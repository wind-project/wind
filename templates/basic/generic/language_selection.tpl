<ul class="language-selection">
	{foreach key=key item=item from=$languages}
	<li>
	<a href="{$item.link}"><img alt="{$item.name}" src="{$img_dir}flags/{$key}.gif" /></a>
	</li> 
	{/foreach}
</ul>