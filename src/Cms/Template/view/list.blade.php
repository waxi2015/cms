@extends('admin.layout')

@section('content')
	<div class="header" id="st-trigger-effects">
	    <button type="button" data-effect="st-effect-1" class="navbar-toggle"><i></i><i></i><i></i></button>
		<h1><?=$cms->getPageTitle()?></h1>
		<div class="actions">
			<?=$cms->renderButtons()?>
			<?=$cms->renderExport()?>
		</div>
		<? if ($cms->getFilters() !== null): ?>
			<div class="filters">
				<label>Filters</label> <?=$cms->renderFilters()?>
			</div>
		<? endif; ?>
	</div>
	<?$cms->renderModule()?>
@endsection