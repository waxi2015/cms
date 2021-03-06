<div class="menu-header">
	@if (Auth::guard('admin')->user()->photo)
		<span class="image"><img src="/image/admin/thumbnail/{{ Auth::guard('admin')->user()->photo }}"></span>
	@else
		<span class="image"><i class="fa fa-user"></i></span>
	@endif
	<span class="name">{{ Auth::guard('admin')->user()->firstname }} {{ Auth::guard('admin')->user()->lastname }}</span>
	<a href="{{ route('logout') }}"><i class="fa fa-power-off"></i> {{ Lang::get('cms.logout') }}</a>
</div>

<ul class="metismenu" id="menu">
	<? foreach ($cms->getTabs() as $key => $one): ?>
		<? if ($one['parent'] !== null) continue; ?>

		<li<?=$one['selected'] || $tab == $key ? ' class="active"' : ''?>>
			<a href="<?=$one['url']?>"<?=$one['selected'] || $tab == $key ? ' aria-expanded="true"' : ''?>>
				<i class="<?=$one['icon']?>"><?=$one['iconHtml']!==null?$one['iconHtml']:''?></i>
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