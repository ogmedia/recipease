<a href="/recipes/add">Add a recipe (populate)</a>
<br />
<ul id="recipe_list">
<?foreach($recipes as $recipe){?>
	<li id="<?=$recipe['id']?>"> <?=$recipe['id']?>: &nbsp;<a href="/recipes/view/<?=$recipe['id']?>"><?=$recipe['title']?></a> (<?=date( 'M j, Y g:ia',strtotime($recipe['created']) );?>)</li>
<?}?>
</ul>