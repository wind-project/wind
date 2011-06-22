{*
 * WiND - Wireless Nodes Database
 * Basic HTML Template
 *
 * Copyright (C) 2005 Konstantinos Papadimitriou <vinilios@cube.gr>
 * Copyright (C) 2010 Vasilis Tsiligiannis <b_tsiligiannis@silverton.gr>
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
{section name=row loop=$data start=1}
{if $data[row].ip_start != $cur}
	{$close2}{$close1}
	{assign var=close1 value=""}
	{assign var=close2 value=""}
	{assign var=close1 value="</table></td></tr>"}
	{assign var=cur value=$data[row].ip_start}
	<tr><td>
	<table class="table-form">
	<tr><td class="table-search-menu-text">
		<img src="{$img_dir}admin.gif" alt="{$lang.db.subnet}" />
		{assign var=t1 value="subnets__type-"|cat:$data[row].type}
		{assign var=t2 value="links__type-"|cat:$data[row].links__type}
		{$lang.db.$t1}
		{$lang.db.$t2}
		{if $data[row].nodes__name != ''}[{$data[row].nodes__name|escape} (#{$data[row].nodes__id})] {/if}
		({$data[row].ip_start} - {$data[row].ip_end})
	</td></tr>
	{if $data[row].date_in != ''}
	{assign var=close2 value="</table></td></tr>"}
	<tr><td>
	<table class="table-form">
	<tr>
	{foreach key=key item=itm from=$data.0}
	{assign var="fullkey" value=$data.0.$key}
	{if $extra_data.HIDE.$fullkey != 'YES'}
	{if $lang.db.$itm != ''}
		{assign var="cell" value="`$lang.db.$itm`"}
		{assign var="cellclass" value="table-node-key2"}
	{elseif $extra_data.TRANSLATE.$fullkey == 'YES'}
		{assign var="cellclass" value="table-node-value2"}
		{assign var="lang_cell" value=$fullkey|cat:"-"|cat:$itm}
		{assign var="cell" value=$lang.db.$lang_cell}
		{assign var="cellclass" value="table-node-value2"}
	{else}
		{assign var="cellclass" value="table-node-value2"}
		{assign var="cell" value=$itm}
	{/if}
	
	<td class="{$cellclass}">{$cell|escape}</td>
	{/if}
	{/foreach}
	</tr>
	{/if}
{/if}
	{if $data[row].date_in != ''}
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
		
		<td class="{$cellclass}">{$cell|escape}</td>
		{/if}
		{/foreach}
	</tr>
	{/if}
{/section}
{$close2}{$close1}
{assign var=close1 value=""}
{assign var=close2 value=""}
</table>