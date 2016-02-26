<div class="left-side">
	<div class="tabs">
		<ul class="first">
			<? foreach ($cms->getTabs() as $key => $one): ?>
				<? if ($one['parent'] !== null) continue; ?>

				<li class="first<?=$one['selected'] ? ' active' : ''?>">
					<a href="<?=$one['url']?>">
						<span class="<?=$one['icon']?>"></span>
						<?=$one['label']?>
						<? if ($cms->getSubTabs($key)): ?>
							<i class="fa fa-chevron-down"></i>
							<i class="fa fa-chevron-right"></i>
						<? endif; ?>
					</a>
					<? if ($cms->getSubTabs($key)): ?>
						<ul>
							<? foreach ($cms->getSubTabs($key) as $skey => $subtab): ?>
								<li class="second<?=$skey == $tab ? ' active' : ''?>">
									<a href="<?=$subtab['url']?>"><?=$subtab['label']?></a>
								</li>
							<? endforeach; ?>
						</ul>
					<? endif; ?>
				</li>
			<? endforeach; ?>
		</ul>
	</div>
</div>