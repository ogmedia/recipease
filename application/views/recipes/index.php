<a href="/recipes/add">Add a recipe (populate)</a>
<br />
<ul id="recipe_list">
<?foreach($recipes as $recipe){?>
	<li id="<?=$recipe['id']?>"><a href="/recipes/view/<?=$recipe['id']?>"><?=$recipe['title']?></a> (<?=date( 'Y-m-d',strtotime($recipe['created']) );?>)<?=$recipe['id']?></li>
<?}?>
</ul>