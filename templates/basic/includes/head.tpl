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
{if $title != ''}
	<title>{$title}</title>
{/if}
{foreach from=$base item=i}
	<base{foreach from=$i key=key item=value}{if $value != ''} {$key}="{$value}"{/if}{/foreach} />
{/foreach}
{foreach from=$link item=i}
	<link{foreach from=$i key=key item=value}{if $value != ''} {$key}="{$value}"{/if}{/foreach} />
{/foreach}
{foreach from=$meta item=i}
	<meta{foreach from=$i key=key item=value}{if $value != ''} {$key}="{$value}"{/if}{/foreach} />
{/foreach}
{foreach from=$script item=i}
	<script{foreach from=$i key=key item=value}{if $value != ''} {$key}="{$value}"{/if}{/foreach}></script>
{/foreach}
{if $extra != ''}
{$extra}
{/if}