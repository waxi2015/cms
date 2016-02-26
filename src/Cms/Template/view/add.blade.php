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
<h1><?=$cms->getPageTitle()?><?=$cms->renderButtons()?></h1>
<?=$cms->renderModule()?>
@endsection