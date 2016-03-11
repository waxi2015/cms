<!DOCTYPE html>
<html>
	<head>
	   @include('admin.partials.head')

	   <style type="text/css">
			.svg-bubbles-dims { width: 72px; height: 64px; }
			.svg-cog-dims { width: 64px; height: 64px; }
			.svg-glasses--martini-dims { width: 64px; height: 64px; }
			.svg-glasses--wine-dims { width: 64px; height: 64px; }
		</style>
	</head>
	<body class="login-page">
		<?=$form->render()?>
	</body>
</html>