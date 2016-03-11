<div class="menu-header">
	@if (Auth::guard('admin')->user()->image)
		<span class="image"><img src="/image/admin/thumbnail/{{ Auth::guard('admin')->user()->image }}"></span>
	@else
		<span class="image"><i class="fa fa-user"></i></span>
	@endif
	<span class="name">{{ Auth::guard('admin')->user()->name }}</span>
	<a href="{{ route('logout') }}"><i class="fa fa-power-off"></i> Logout</a>
</div>

<ul class="metismenu" id="menu">
	<? foreach ($cms->getTabs() as $key => $one): ?>
		<? if ($one['parent'] !== null) continue; ?>

		<li<?=$one['selected'] || $tab == $key ? ' class="active"' : ''?>>
			<a href="<?=$one['url']?>"<?=$one['selected'] || $tab == $key ? ' aria-expanded="true"' : ''?>>
				<i class="<?=$one['icon']?>"></i>
				<span><?=$one['label']?></span>
				<? if ($cms->getSubTabs($key)): ?>
					<span class="fa arrow"></span>
				<? endif; ?>
			</a>
			<? if ($cms->getSubTabs($key)): ?>
				<ul<?=$one['selected'] ? ' aria-expanded="true"' : ''?>>
					<? foreach ($cms->getSubTabs($key) as $skey => $subtab): ?>
						<li<?=$skey == $tab ? ' class="active"' : ''?>>
							<a href="<?=$subtab['url']?>"><?=$subtab['label']?></a>
						</li>
					<? endforeach; ?>
				</ul>
			<? endif; ?>
		</li>
	<? endforeach; ?>
</ul>
<div class="menu-footer"></div>