		<meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1"/>
        <meta name="msapplication-tap-highlight" content="no">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="application-name" content="{{ @$configuration['site_title'] }}">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="apple-mobile-web-app-title" content="{{ @$configuration['site_title'] }}">
        <meta name="theme-color" content="#4C7FF0">
        <meta name="_token" content="{{ csrf_token() }}">
        <meta name="google-site-verification" content="{{ @$configuration['site_verification'] }}">

		<meta name="keywords" content="@yield('meta_keywords',@$configuration['site_keywords'])"/>
		<meta name="description" content="@yield('meta_description',@$configuration['site_description'])"/>

		<meta name="author" content="@yield('author',@$configuration['site_author'])"/>

		<!-- Open Graph Tags -->
		<meta property='og:type' content='website' />
		<meta property='og:url' content='@yield('meta_item_url',url('/'))' />
		<meta property='og:title' content='@yield('meta_item_name',@$configuration['site_title'])' />
		<meta property='og:description' content='@yield('meta_item_desc',@$configuration['site_description'])' />
		<meta property='og:image' content='@yield('meta_item_image','')' />

		<meta name='twitter:card' content='summary_large_image'>
		<meta name='twitter:site' content='@appmarketcmsAnthonyPillos'>
		<meta name='twitter:title' content='@yield('meta_item_name',@$configuration['site_title'])'>
		<meta name='twitter:description' content='@yield('meta_item_desc',@$configuration['site_description'])'>
		<meta name='twitter:creator' content='@appmarketcmsAnthonyPillos'>
		<meta name='twitter:image:src' content='@yield('meta_item_image','')'>
		<meta name='twitter:domain' content='@yield('meta_item_url',url('/'))'>

		<link rel="icon" href="/favicon.ico" type="image/x-icon"/>
		<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>

		<title>@yield('site_title',@$configuration['site_title'])</title>
