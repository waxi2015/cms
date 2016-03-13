<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<title>{{ Lang::get('cms.page_title') }}</title>

<!-- Core libs -->
<script type="text/javascript" src="/libs/jquery/jquery.min.js"></script>
<script type="text/javascript" src="/libs/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="/libs/bootstrap/bootstrap.min.js"></script>
<script type="text/javascript" src="/js/lang.js"></script>
<link href="/libs/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css">
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>

<!-- CK editor -->
<script type="text/javascript" src="/libs/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="/libs/ckeditor/adapters/jquery.js"></script>

<!-- WX Modules -->
<script type="text/javascript" src="/js/form.js"></script>
<link href="/css/form.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/js/repeater.js"></script>

<!-- Admin -->
<link href="/css/admin/theme.css" rel="stylesheet" type="text/css">

<!-- Favicons -->
<link rel="apple-touch-icon" sizes="57x57" href="/favicon/admin/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="/favicon/admin/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="/favicon/admin/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="/favicon/admin/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="/favicon/admin/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="/favicon/admin/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="/favicon/admin/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="/favicon/admin/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="/favicon/admin/apple-icon-180x180.png">
<link rel="icon" type="image/x-icon" sizes="16x16" href="/favicon/admin/favicon.ico">
<link rel="manifest" href="/favicon/admin/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="/favicon/admin/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">

<script>
	$(function(){
		Lang.setLocale('{{ Lang::getLocale() }}');
	})
</script>