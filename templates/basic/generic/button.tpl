{*
 * WiND - Wireless Nodes Database
 *
 * Copyright (C) 2005-2013 	by WiND Contributors (see AUTHORS.txt)
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
 
{if $glyph}
	{assign var=extra_left_content value="<span class=\"glyphicon glyphicon-`$glyph`\"></span> "}
{else}
	{assign var=extra_left_content value=''}
{/if}

{if $class}
	{assign var=btn_class value=`$class`}
{else}
	{assign var=btn_class value="btn-default"}
{/if}

{if $href}
	{assign var=onclick value="javascript: window.location='`$href`'"}
{/if}
<button type="button" class="btn {$btn_class}" {if $onclick != ''} onclick="{$onclick}"{/if}>{$extra_left_content}{$content}</button>