@extends('admin.layout')

@section('content')
	<h1>
		<?=$cms->getPageTitle()?>
		<?=$cms->renderButtons()?>
		<?=$cms->renderExport()?>
		<?=$cms->renderFilters()?>
	</h1>

	<?$cms->renderModule()?>
@endsection