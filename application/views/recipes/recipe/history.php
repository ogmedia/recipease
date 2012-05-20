<div>
<h2>Recipe History</h2>
<ul>
	<? foreach( $recipe_history as $recipe ){ ?>
	<li id="recipe_<?=$recipe['data']['id']?>" class="recipe_edit">
	<div class="recipe_title"><?=$recipe['data']['title'];?></div>
	<div class="created_on">(<?=date( 'M j, Y g:ia',strtotime($recipe['data']['created']) );?>)</div>
	</li>
	<? } ?>
</ul>
</div>

<style type="text/css">
.recipe_edit{
	float:left;
	clear:left;
}
.recipe_title{
	width:400px;
	float:left;
}
.created_on{
	width:200px;
	float:left;
}
</style>