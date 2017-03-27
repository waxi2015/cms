@extends('admin.layout')

@section('content')

	<script type="text/javascript" src="/assets/common/libs/stat/js/stat.js"></script>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

	<div class="header with-border" id="st-trigger-effects">
	    <button type="button" data-effect="st-effect-1" class="navbar-toggle"><i></i><i></i><i></i></button>
		<h1>Dashboard</h1>
	</div>

	<div class="dashboard">
		{{$dashboard->render()}}
	</div>
@endsection