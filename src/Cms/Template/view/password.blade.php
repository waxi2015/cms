@extends('admin.layout')

@section('content')
	<script>
		$(function(){
			$(document).off('click', '#save-form').on('click', '#save-form', {} ,function(e){
				e.preventDefault();
				$('#change-password').data('formValidation').validate();
				$('#change-password').trigger('submit');
			});
		})
	</script>

	<div class="header with-border" id="st-trigger-effects">
	    <button type="button" data-effect="st-effect-1" class="navbar-toggle"><i></i><i></i><i></i></button>
		<h1>{{ trans('cms.change_password.title') }}</h1>
		<div class="actions">
			<a href="" id="save-form" class="btn btn-primary">{{ trans('cms.change_password.button_save') }}</a>
			<a href="/admin/admins" class="btn btn-plain">{{ trans('cms.change_password.button_back') }}</a>
		</div>
	</div>
	<?=$form->render()?>
@endsection