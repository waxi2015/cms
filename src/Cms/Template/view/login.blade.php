<!DOCTYPE html>
<html>
	<head>
	   @include('admin.partials.head')
	</head>
	<body class="login-page">
		@include('admin.partials.svgs')
		<?=$form->render()?>

        <? /* Here for reason */ ?>
		<script type="text/javascript" src="{{ elixir('assets/admin/js/app.js') }}"></script>
	</body>
</html>