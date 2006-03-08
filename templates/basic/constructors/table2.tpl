{*
 * WiND - Wireless Nodes Database
 * Basic HTML Template
 *
 * Copyright (C) 2005 Konstantinos Papadimitriou <vinilios@cube.gr>
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; version 2 dated June, 1991.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 *
 *}
<table class="table-form">
{section name=row loop=$data}
<tr>
	{foreach key=key item=itm from=$data[row]}
	{assign var="fullkey" value=$data.0.$key}
	{if $extra_data.HIDE.$fullkey != 'YES'}
	{if $smarty.section.row.index == 0 && $lang.db.$itm != ''}
		{assign var="cell" value="`$lang.db.$itm`"}
		{assign var="cellclass" value="table-node-key2"}
	{elseif $smarty.section.row.index != 0 && $key|truncate:5:"":true == 'date_'}
		{assign var="cell" value=$itm|date_format:"%x"}
		{assign var="cellclass" value="table-node-value2"}
	{elseif $extra_data.TRANSLATE.$fullkey == 'YES'}
		{assign var="cellclass" value="table-node-value2"}
		{assign var="lang_cell" value=$fullkey|cat:"-"|cat:$itm}
		{assign var="cell" value=$lang.db.$lang_cell}
		{assign var="cellclass" value="table-node-value2"}
	{else}
		{assign var="cellclass" value="table-node-value2"}
		{assign var="cell" value=$itm}
	{/if}
	
	<td class="{$cellclass}">
		{if $extra_data.LINK.$fullkey[row] != ''}
		<a href="{$extra_data.LINK.$fullkey[row]}">
		{/if}
		{$cell|escape}
		{if $extra_data.LINK.$fullkey[row] != ''}
		</a>
		{/if}
	</td>
	{/if}
	{/foreach}
</tr>
{/section}
</table>