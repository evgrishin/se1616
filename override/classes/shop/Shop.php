<?php



class Shop extends ShopCore
{

public $id_shop_url;

	public function setUrl()
	{
		$cache_id = 'Shop::setUrl_'.(int)$this->id;
		if (!Cache::isStored($cache_id))
		{
			$host = Tools::getHttpHost();
			$row = Db::getInstance()->getRow('
			SELECT su.physical_uri, su.virtual_uri, su.domain, su.domain_ssl, t.id_theme, t.name, t.directory, su.id_shop_url
			FROM '._DB_PREFIX_.'shop s
			LEFT JOIN '._DB_PREFIX_.'shop_url su ON (s.id_shop = su.id_shop)
			LEFT JOIN '._DB_PREFIX_.'theme t ON (t.id_theme = s.id_theme)
			WHERE s.id_shop = '.(int)$this->id.'
			AND s.active = 1 AND s.deleted = 0 AND su.domain = "'.$host.'"');// AND su.main = 1 GrishinEV
			Cache::store($cache_id, $row);
		}
		$row = Cache::retrieve($cache_id);
		if (!$row)
			return false;

		$this->theme_id = $row['id_theme'];
		$this->theme_name = $row['name'];
		$this->theme_directory = $row['directory'];
		$this->physical_uri = $row['physical_uri'];
		$this->virtual_uri = $row['virtual_uri'];
		$this->domain = $row['domain'];
		$this->domain_ssl = $row['domain_ssl'];
		$this->id_shop_url = $row['id_shop_url'];

		return true;
	}
	
	/**
	 * Find the shop from current domain / uri and get an instance of this shop
	 * if INSTALL_VERSION is defined, will return an empty shop object
	 *
	 * @return Shop
	 */
	public static function initialize()
	{
		// Find current shop from URL
		if (!($id_shop = Tools::getValue('id_shop')) || defined('_PS_ADMIN_DIR_'))
		{
			$found_uri = '';
			$is_main_uri = false;
			$host = Tools::getHttpHost();
			$request_uri = rawurldecode($_SERVER['REQUEST_URI']);

			$sql = 'SELECT s.id_shop, CONCAT(su.physical_uri, su.virtual_uri) AS uri, su.domain, su.main
					FROM '._DB_PREFIX_.'shop_url su
					LEFT JOIN '._DB_PREFIX_.'shop s ON (s.id_shop = su.id_shop)
					WHERE (su.domain = \''. pSQL($host).'\' OR su.domain_ssl = \''. pSQL($host).'\')
						AND s.active = 1
						AND s.deleted = 0
					ORDER BY LENGTH(CONCAT(su.physical_uri, su.virtual_uri)) DESC';

			$result = Db::getInstance()->executeS($sql);

			$through = false;
			foreach ($result as $row)
			{
				// An URL matching current shop was found
				if (preg_match('#^'.preg_quote($row['uri'], '#').'#i', $request_uri))
				{
					$through = true;
					$id_shop = $row['id_shop'];
					$found_uri = $row['uri'];
					if ($row['main'])
						$is_main_uri = true;
					break;
				}
			}

			// If an URL was found but is not the main URL, redirect to main URL
			if ($through && $id_shop && !$is_main_uri)
			{

				foreach ($result as $row)
				{
					if ($row['id_shop'] == $id_shop && $row['main'])
					{
						$request_uri = substr($request_uri, strlen($found_uri));
						$url = str_replace('//', '/', $row['domain'].$row['uri'].$request_uri);
						$redirect_type = Configuration::get('PS_CANONICAL_REDIRECT') == 2 ? '301' : '302';
						header('HTTP/1.0 '.$redirect_type.' Moved');
						header('Cache-Control: no-cache');
						header('location: http://'.$url);
						exit;
					}
				}
			}
		}

		$http_host = Tools::getHttpHost();
		$all_media = array_merge(Configuration::getMultiShopValues('PS_MEDIA_SERVER_1'), Configuration::getMultiShopValues('PS_MEDIA_SERVER_2'), Configuration::getMultiShopValues('PS_MEDIA_SERVER_3'));

		if ((!$id_shop && defined('_PS_ADMIN_DIR_')) || Tools::isPHPCLI() || in_array($http_host, $all_media))
		{
			// If in admin, we can access to the shop without right URL
			if ((!$id_shop && Tools::isPHPCLI()) || defined('_PS_ADMIN_DIR_'))
				$id_shop = (int)Configuration::get('PS_SHOP_DEFAULT');

			$shop = new Shop((int)$id_shop);
			if (!Validate::isLoadedObject($shop))
				$shop = new Shop((int)Configuration::get('PS_SHOP_DEFAULT'));

			$shop->virtual_uri = '';

			// Define some $_SERVER variables like HTTP_HOST if PHP is launched with php-cli
			if (Tools::isPHPCLI())
			{
				if (!isset($_SERVER['HTTP_HOST']) || empty($_SERVER['HTTP_HOST']))
					$_SERVER['HTTP_HOST'] = $shop->domain;
				if (!isset($_SERVER['SERVER_NAME']) || empty($_SERVER['SERVER_NAME']))
					$_SERVER['SERVER_NAME'] = $shop->domain;
				if (!isset($_SERVER['REMOTE_ADDR']) || empty($_SERVER['REMOTE_ADDR']))
					$_SERVER['REMOTE_ADDR'] = '127.0.0.1';
			}
		}
		else
		{
			$shop = new Shop($id_shop);
			if (!Validate::isLoadedObject($shop) || !$shop->active)
			{
				// No shop found ... too bad, let's redirect to default shop
				$default_shop = new Shop(Configuration::get('PS_SHOP_DEFAULT'));

				// Hmm there is something really bad in your Prestashop !
				if (!Validate::isLoadedObject($default_shop))
					throw new PrestaShopException('Shop not found');

				$params = $_GET;
				unset($params['id_shop']);
				$url = $default_shop->domain;
				if (!Configuration::get('PS_REWRITING_SETTINGS'))
					$url .= $default_shop->getBaseURI().'index.php?'.http_build_query($params);
				else
				{
					// Catch url with subdomain "www"
					if (strpos($url, 'www.') === 0 && 'www.'.$_SERVER['HTTP_HOST'] === $url || $_SERVER['HTTP_HOST'] === 'www.'.$url)
						$url .= $_SERVER['REQUEST_URI'];
					else
						$url .= $default_shop->getBaseURI();

					if (count($params))
						$url .= '?'.http_build_query($params);
				}
				$redirect_type = Configuration::get('PS_CANONICAL_REDIRECT') == 2 ? '301' : '302';
				header('HTTP/1.0 '.$redirect_type.' Moved');
				header('location: http://'.$url);
				exit;
			}
			elseif (defined('_PS_ADMIN_DIR_') && empty($shop->physical_uri))
			{
				$shop_default = new Shop((int)Configuration::get('PS_SHOP_DEFAULT'));
				$shop->physical_uri = $shop_default->physical_uri;
				$shop->virtual_uri = $shop_default->virtual_uri;
			}
		}

		self::$context_id_shop = $shop->id;
		self::$context_id_shop_group = $shop->id_shop_group;
		self::$context = self::CONTEXT_SHOP;

		return $shop;
	}	

	/**
	 * Get list of shop's urls
	 *
	 * @return array
	 */
	public function getUrls()
	{
	
		$host = Tools::getHttpHost();
		
		$sql = 'SELECT *
				FROM '._DB_PREFIX_.'shop_url
				WHERE domain = "'.$host.'"
					AND id_shop = '.(int)$this->id;
		return Db::getInstance()->executeS($sql);
	}	
	
	public function getUrlsSharedCart()
	{
		if (!$this->getGroup()->share_order)
			return false;

		$query = new DbQuery();
		$query->select('domain');
		$query->from('shop_url');
		//$query->where('main = 1');
		$query->where('active = 1');
		$query .= $this->addSqlRestriction(Shop::SHARE_ORDER);
		$domains = array();
		foreach (Db::getInstance()->executeS($query) as $row)
			$domains[] = $row['domain'];

		return $domains;
	}	
	
	/**
	 * @return bool Return true if multishop feature is active and at last 2 shops have been created
	 */
	public static function isFeatureActive()
	{
		static $feature_active = null;

		/*if ($feature_active === null)
			$feature_active = (bool)Db::getInstance()->getValue('SELECT value FROM `'._DB_PREFIX_.'configuration` WHERE `name` LIKE "PS_MULTISHOP_FEATURE_ACTIVE"')
				&& (Db::getInstance()->getValue('SELECT COUNT(*) FROM '._DB_PREFIX_.'shop') > 1);
		*/
		$feature_active = true;
		return $feature_active;
	}	

}

