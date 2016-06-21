<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<title>{{ Lang::get('cms.page_title') }}</title>

<!-- Core libs -->
<script type="text/javascript" src="/assets/common/libs/jquery/jquery.min.js"></script>
<script type="text/javascript" src="/assets/common/libs/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="/assets/common/libs/bootstrap/bootstrap.min.js"></script>
<script type="text/javascript" src="/assets/common/js/lang.js"></script>
<link href="/assets/common/libs/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css">
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>

<!-- CK editor -->
<script type="text/javascript" src="/assets/common/libs/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="/assets/common/libs/ckeditor/adapters/jquery.js"></script>

<!-- WX Modules -->
<script type="text/javascript" src="/assets/common/libs/form/js/form.js"></script>
<script type="text/javascript" src="/assets/common/libs/repeater/js/repeater.js"></script>

<!-- Admin -->
<link href="{{ elixir('assets/admin/css/theme.css') }}" rel="stylesheet" type="text/css">

<!-- Favicons -->
<link rel="apple-touch-icon" sizes="57x57" href="/assets/admin/favicon/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="/assets/admin/favicon/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="/assets/admin/favicon/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="/assets/admin/favicon/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="/assets/admin/favicon/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="/assets/admin/favicon/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="/assets/admin/favicon/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="/assets/admin/favicon/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="/assets/admin/favicon/apple-icon-180x180.png">
<link rel="icon" type="image/x-icon" sizes="16x16" href="/assets/admin/favicon/favicon.ico">
<link rel="manifest" href="/assets/admin/favicon/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="/assets/admin/favicon/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">

<script>
	$(function(){
		Lang.setLocale('{{ Lang::getLocale() }}');
	})
</script>