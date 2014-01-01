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
{if $extra_data.MULTICHOICE[1] != ''}
<form name="{$extra_data.FORM_NAME}" method="post" action={$action_url}>
<input type="hidden" name="form_name" value="{$extra_data.FORM_NAME}" />
{/if}
<table class="table-data">
{section name=row loop=$data}

	{if $smarty.section.row.index == 0 }
		<tr class="header">
	{else}
		<tr>
	{/if}
		
	{foreach key=key item=itm from=$data[row]}
		{assign var="fullkey" value=$data.0.$key}
		{assign var="cellType" value="td"}
		{if $extra_data.HIDE.$fullkey != 'YES'}
		{if $smarty.section.row.index == 0 && $lang.db.$itm != ''}
			{assign var="cell" value=$lang.db.$itm}
			{assign var="cellType" value="th"}
		{elseif $smarty.section.row.index != 0 && $key|truncate:5:"":true == 'date_'}
			{assign var="cell" value=$itm|date_format:"%x"}
			{assign var="cellclass" value="table-list-cell"}
		{elseif $extra_data.TRANSLATE.$fullkey == 'YES'}
			{assign var="cellclass" value="table-list-cell"}
			{assign var="lang_cell" value=$fullkey|cat:"-"|cat:$itm}
			{assign var="cell" value=$lang.db.$lang_cell}
			{assign var="cellclass" value="table-list-cell"}
		{else}
			{assign var="cellclass" value="table-list-cell"}
			{assign var="cell" value=$itm}
		{/if}
		
		{if $rowclass != ""}
	
		{/if}
		{assign var=edit_column value=""}
		{assign var=edit value=""}
		{assign var=onclick value=""}
		{if $extra_data.EDIT_COLUMN != ''}
			{assign var=edit_column value="`$extra_data.EDIT_COLUMN`"}
			{assign var=edit value="`$extra_data.EDIT[row]`"}
		{/if}
		{if $extra_data.PICKUP_COLUMN != ''}
			{assign var=edit_column value="`$extra_data.PICKUP_COLUMN`"}
			{assign var=edit value=""}
			{assign var=onclick value="javascript: window.opener.pickup(window.opener.document.`$extra_data.PICKUP_OBJECT`,'`$extra_data.PICKUP_OUTPUT[row]`','`$extra_data.PICKUP_VALUE[row]`', window); return false;"|stripslashes}
		{/if}
		<{$cellType} class="{$cellclass}">
			{if $key==$edit_column && $smarty.section.row.index != 0}
			<a href="{$edit}"{if $extra_data.PICKUP_COLUMN != ''} onclick="{$onclick}"{/if}>
			{/if}
			{if $extra_data.LINK.$fullkey[row] != ''}
			<a href="{$extra_data.LINK.$fullkey[row]}">
			{/if}
			{$cell|escape}
			{if $key==$edit_column && $smarty.section.row.index != 0}</a>{/if}
			{if $extra_data.LINK.$fullkey[row] != ''}
			</a>
			{/if}
		</td>
		{/if}
	{/foreach}
	{if $extra_data.MULTICHOICE[row] != ''}
	<td class="table-list-cell-extra"><input class="fld-form-check" type="checkbox" name="id[]" value="{$extra_data.MULTICHOICE[row]|escape}" {if $extra_data.MULTICHOICE_CHECKED[row] == 'YES'}checked="checked" {/if}/></td>
	{elseif $extra_data.MULTICHOICE_LABEL != ''}
	<td width="1%">{$lang[$extra_data.MULTICHOICE_LABEL]}</td>
	{/if}
</tr>
{/section}
{if $extra_data.MULTICHOICE[1] != '' || $extra_data.TOTAL_PAGES != ''}
<tr class="paginator">
	{if $extra_data.TOTAL_PAGES == ''}
		{foreach key=key item=cell from=$data[0]}
		<td></td>
		{/foreach}
	{else}
		{section name=cell loop=$data[0]}
		{/section}
		<td colspan="{$smarty.section.cell.total}">Pages: 
		{foreach key=key item=page from=$extra_data.PAGES}
			{if $key == $extra_data.CURRENT_PAGE}
				{$key}
			{else}
				<a href="{$page}">{$key}</a>
			{/if}
		{/foreach}</td>
	{/if}
	{if $extra_data.MULTICHOICE[1] != ''}<td class="table-form-submit"><button type="submit">{$lang[$extra_data.MULTICHOICE_LABEL]|escape}</button></td>{/if}
</tr>
{/if}
</table>
{if $extra_data.MULTICHOICE[1] != ''}</form>{/if}