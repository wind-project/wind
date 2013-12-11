<div class="language-selection">
<a href="#" id="select-language"><img alt="current" src="{$img_dir}flags/{$current_language}.gif" /></a>
<ul id="languages" class="languages">
	{foreach key=key item=item from=$languages}
	<li>
	<a href="{$item.link}"><img alt="{$item.name}" src="{$img_dir}flags/{$key}.gif" /> {$item.name}</a>
	</li> 
	{/foreach}
</ul>
</div>

{literal}
<script>
$(function(){
	$('#select-language').click(function() {
		$('#languages').toggle();
	});

});
</script>
{/literal}