<!DOCTYPE html>
<html>
	<head>
	   @include('admin.partials.head')
	</head>
	<body>
		<div id="st-container" class="st-container container-fluid">
            <div class="st-pusher">
                <nav class="st-menu st-effect-1" id="st-menu-1">
        			@include('admin.partials.sidebar')
				</nav>
				<div class="st-content">
				    <div class="st-content-inner">
						@yield('content')
					</div>
				</div>
            </div>
        </div>
	</body>
</html>