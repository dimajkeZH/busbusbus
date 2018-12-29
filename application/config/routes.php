<?php

return [

	'admin' => [
		'controller' => 'mainAdmin',
		'action' => 'main',
	],

	'admin/main' => [
		'controller' => 'mainAdmin',
		'action' => 'main',
	],

	'admin/auth' => [
		'controller' => 'mainAdmin',
		'action' => 'auth',
	],

	'admin/login' => [
		'controller' => 'mainAdmin',
		'action' => 'login',
	],

	'admin/logout' => [
		'controller' => 'mainAdmin',
		'action' => 'logout',
	],




	/* ADMIN INNER PAGES */
	//show settings cms
	'admin/config' => [
		'controller' => 'mainAdmin',
		'action' => 'config',
	],
	//show general content
	'admin/site/content' => [
		'controller' => 'mainAdmin',
		'action' => 'siteContent',
	],
	//show general settings
	'admin/site/settings' => [
		'controller' => 'mainAdmin',
		'action' => 'siteSettings',
	],


	//child pages (show add[0]/show change[1+])
	'admin/site/pages' => [
		'controller' => 'mainAdmin',
		'action' => 'sitePages',
	],
	'admin/site/pages/[0-9]{1,}' => [
		'controller' => 'mainAdmin',
		'action' => 'sitePages',
	],

	//reports
	'admin/report/accounts' => [
		'controller' => 'mainAdmin',
		'action' => 'reportAccounts',
	],
	'admin/report/sessions' => [
		'controller' => 'mainAdmin',
		'action' => 'reportSessions',
	],
	'admin/report/actions' => [
		'controller' => 'mainAdmin',
		'action' => 'reportActions',
	],

	// catalogs
	'admin/catalog/buses' => [
		'controller' => 'mainAdmin',
		'action' => 'catalogBuses',
	],
	'admin/catalog/buses/[0-9]{1,}' => [
		'controller' => 'mainAdmin',
		'action' => 'catalogBuses',
	],
	'admin/catalog/minivans' => [
		'controller' => 'mainAdmin',
		'action' => 'catalogMinivans',
	],
	'admin/catalog/minivans/[0-9]{1,}' => [
		'controller' => 'mainAdmin',
		'action' => 'catalogMinivans',
	],
	'admin/catalog/news' => [
		'controller' => 'mainAdmin',
		'action' => 'catalogNews',
	],
	'admin/catalog/news/[0-9]{1,}' => [
		'controller' => 'mainAdmin',
		'action' => 'catalogNews',
	],
	'admin/catalog/vacancies' => [
		'controller' => 'mainAdmin',
		'action' => 'catalogVacancies',
	],
	'admin/catalog/vacancies/[0-9]{1,}' => [
		'controller' => 'mainAdmin',
		'action' => 'catalogVacancies',
	],
	/* ADMIN INNER PAGES END */





	/* ADMIN AJAX */
	//save config cms
	'admin/save/config' => [
		'controller' => 'AjaxAdmin',
		'action' => 'saveConfig',
	],
	//save general content
	'admin/save/content' => [
		'controller' => 'AjaxAdmin',
		'action' => 'saveContent',
	],
	//save general settings
	'admin/save/settings' => [
		'controller' => 'AjaxAdmin',
		'action' => 'saveSettings',
	],


	'admin/site/pages/save/[0-9]{1,}' => [
		'controller' => 'AjaxAdmin',
		'action' => 'savePages',
	],
	'admin/site/pages/remove/[0-9]{1,}' => [
		'controller' => 'AjaxAdmin',
		'action' => 'delPages',
	],
	'admin/site/pages/add' => [
		'controller' => 'AjaxAdmin',
		'action' => 'addPages',
	],


	//
	'admin/ajax/catalog/buses/remove/[0-9]{1,}' => [
		'controller' => 'AjaxAdmin',
		'action' => 'delBuses',
	],
	//
	'admin/ajax/catalog/minivans/remove/[0-9]{1,}' => [
		'controller' => 'AjaxAdmin',
		'action' => 'delMinivans',
	],
	//
	'admin/ajax/catalog/news/remove/[0-9]{1,}' => [
		'controller' => 'AjaxAdmin',
		'action' => 'delNews',
	],
	//
	'admin/ajax/catalog/vacancies/remove/[0-9]{1,}' => [
		'controller' => 'AjaxAdmin',
		'action' => 'delVacancies',
	],

	//
	'admin/ajax/catalog/buses/change' => [
		'controller' => 'AjaxAdmin',
		'action' => 'changeBuses',
	],
	//
	'admin/ajax/catalog/minivans/change' => [
		'controller' => 'AjaxAdmin',
		'action' => 'changeMinivans',
	],
	//
	'admin/ajax/catalog/news/change' => [
		'controller' => 'AjaxAdmin',
		'action' => 'changeNews',
	],
	//
	'admin/ajax/catalog/vacancies/change' => [
		'controller' => 'AjaxAdmin',
		'action' => 'changeVacancies',
	],
	
	
	
	
	/* ADMIN AJAX END */





	/* ADMIN API */
	'admin/api/site_tree' => [
		'controller' => 'ApiAdmin',
		'action' => 'SiteTree',
	],
	'admin/api/uri' => [
		'controller' => 'ApiAdmin',
		'action' => 'CheckURI',
	],

	'admin/api/catalog/buses/show/[0-9A-Za-z_]{1,}' => [
		'controller' => 'ApiAdmin',
		'action' => 'ShowBuses',
	],
	'admin/api/catalog/minivans/show/[0-9A-Za-z_]{1,}' => [
		'controller' => 'ApiAdmin',
		'action' => 'ShowMinivans',
	],
	'admin/api/catalog/news/show/[0-9A-Za-z_]{1,}' => [
		'controller' => 'ApiAdmin',
		'action' => 'ShowNews',
	],
	'admin/api/catalog/vacancies/show/[0-9A-Za-z_]{1,}' => [
		'controller' => 'ApiAdmin',
		'action' => 'ShowVacancies',
	],

	
	
	
	
	/* ADMIN API END */





	/* USER */
	'' => [
		'controller' => 'MainUser',
		'action' => 'main',
	],

	'uslugi' => [
		'controller' => 'MainUser',
		'action' => 'services',
	],

		'uslugi/[0-9A-Za-z_]{1,}' => [
			'controller' => 'SecondUser',
			'action' => 'services',
		],

	'avtobusy' => [
		'controller' => 'MainUser',
		'action' => 'buses',
	],

		'avtobusy/[0-9A-Za-z_]{1,}' => [
			'controller' => 'SecondUser',
			'action' => 'buses',
		],

	'mikroavtobusy' => [
		'controller' => 'MainUser',
		'action' => 'minivans',
	],

		'mikroavtobusy/[0-9A-Za-z_]{1,}' => [
			'controller' => 'SecondUser',
			'action' => 'minivans',
		],

	'avtobusnyie_ekskursii' => [
		'controller' => 'MainUser',
		'action' => 'excursions',
	],

		'avtobusnyie_ekskursii/[0-9A-Za-z_]{1,}' => [
			'controller' => 'SecondUser',
			'action' => 'excursions',
		],

	'contacts' => [
		'controller' => 'MainUser',
		'action' => 'contacts',
	],

	'news/[0-9A-Za-z_]{1,}' => [
		'controller' => 'OtherUser',
		'action' => 'news',
	],

	'[0-9A-Za-z_]{1,}' => [
		'controller' => 'OtherUser',
		'action' => 'bus',
	],
	/* USER END */





	/* USER AJAX */
	'ajax/order' => [
		'controller' => 'AjaxUser',
		'action' => 'order',
	],

	'ajax/feedback' => [
		'controller' => 'AjaxUser',
		'action' => 'feedback',
	],
	/* USER AJAX END */
];