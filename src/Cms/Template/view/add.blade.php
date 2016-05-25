@extends('admin.layout')

@section('content')
	<script>
		$(function(){
			$(document).off('click', '#save-form').on('click', '#save-form', {} ,function(e){
				e.preventDefault();
				$('#<?=$cms->getFormId()?>').data('formValidation').validate();
				$('#<?=$cms->getFormId()?>').trigger('submit');
			});
		})

		function sendSuccess () {
			//wx.feedback.init('success', 'Mentés sikeres', '', 1500);
		}
	</script>

	<div class="header with-border" id="st-trigger-effects">
	    <button type="button" data-effect="st-effect-1" class="navbar-toggle"><i></i><i></i><i></i></button>
		<h1><?=$cms->getPageTitle()?></h1>
		<div class="actions">
			<?=$cms->renderButtons()?>
		</div>
	</div>
	<?$cms->renderModule()?>
@endsection