<html>
	<head>
		<link href="/css/app.css" rel="stylesheet" type="text/css">
		<link href="/css/all.css" rel="stylesheet" type="text/css">
		<script type="text/javascript" src="/js/all.js"></script>
		<script type="text/javascript" src="/libs/ckeditor/ckeditor.js"></script>
		<script type="text/javascript" src="/libs/ckeditor/adapters/jquery.js"></script>

		<script>
			$(function() {
				$('.tabs > ul > li > a').click(function(e){
					if ($(this).parent().find('ul').length == 0)
						return;

					e.preventDefault();

					var hasClass = $(this).parent().hasClass('active');

					$('.tabs > ul > li').removeClass('active');

					if (!hasClass) {
						$(this).parent().addClass('active');
					}
				})
			});
		</script>
	</head>
	<body>
		<div id="container">
			@include('admin.left')

			<div id="content">
				@yield('content')
			</div>
		</div>
		<div id="wx-feedback"></div>
	</body>
</html>