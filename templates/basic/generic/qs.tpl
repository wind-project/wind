{foreach key=key item=item from=$qs}
<input type="hidden" name="{$key}" value="{$item}" />
{/foreach}