{*
 * WiND - Wireless Nodes Database
 *
 * Copyright (C) 2005-2014 	by WiND Contributors (see AUTHORS.txt)
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *}
<div class="language-selection">
<a href="#" id="select-language"><img alt="current" src="{$img_dir}/flags/{$current_language}.gif" /></a>
<ul id="languages" class="languages">
	{foreach key=key item=item from=$languages}
	<li>
	<a href="{$item.link|escape}"><img alt="{$item.name}" src="{$img_dir}/flags/{$key}.gif" /> {$item.name}</a>
	</li> 
	{/foreach}
</ul>
</div>

{literal}
<script>
$(function(){
	$('#select-language').click(function() {
		$('#languages').toggle();
		$('#languages').offset({'left': $('#select-language').offset().left -15});
	});

});
</script>
{/literal}