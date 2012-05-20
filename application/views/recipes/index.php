<div data-role="page">

	<div data-role="header">
		<h1>Recipease!</h1>
	</div><!-- /header -->

	<div data-role="content">	
		<div class="ui-body ui-body-b">
			<h1>Your receipes</h1>
			<a href="/recipes/add" data-role="button" data-inline="true" data-rel="dialog" data-transition="pop" data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" data-theme="b" class="ui-btn ui-btn-inline ui-shadow ui-btn-corner-all ui-btn-up-b"><span class="ui-btn-inner ui-btn-corner-all"><span class="ui-btn-text">Add a new recipe.</span></span></a>
			<br><br>
			<ol id="recipe_list" data-role="listview" data-inset="true" data-filter="true">
				<?foreach($recipes as $recipe){?>
					<li id="<?=$recipe['id']?>" class="ui-btn ui-btn-icon-right ui-li-has-arrow ui-li ui-btn-up-c">
						<a href="/recipes/view/<?=$recipe['id']?>"><?=$recipe['title']?>
							<p class="ui-li-aside ui-li-desc"><strong><?=date( 'M j, Y g:ia',strtotime($recipe['created']) );?></strong></p>
						</a>
					</li>
				<?}?>
			</ol>
		</div>
	</div><!-- /content -->

	<div data-role="footer" data-theme="a" data-position="fixed" class="ui-footer ui-bar-a ui-footer-fixed slideup" role="contentinfo">
		<h1 class="ui-title" role="heading" aria-level="1">Footer Stuffs</h1>
	</div>

</div><!-- /page -->