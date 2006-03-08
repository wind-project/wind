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
{if $extra_data.MULTICHOICE[1] != ''}
<form name="{$extra_data.FORM_NAME}" method="post">
<input type="hidden" name="query_string" value="{$hidden_qs}" />
<input type="hidden" name="form_name" value="{$extra_data.FORM_NAME}" />
{/if}
<table width="100%"  border="0" cellspacing="0" cellpadding="2">
{section name=row loop=$data}

	{if $smarty.section.row.index == 0 }
	<tr>
	{else}
	{if $smarty.section.row.index is not even}
	<tr class="table-list-list1">
	{else}
	<tr class="table-list-list2">
	{/if}
	{/if}
		
	{foreach key=key item=itm from=$data[row]}
	{assign var="fullkey" value=$data.0.$key}
	{if $extra_data.HIDE.$fullkey != 'YES'}
	{if $smarty.section.row.index == 0 && $lang.db.$itm != ''}
		{assign var="cell" value=$lang.db.$itm}
		{assign var="cellclass" value="table-list-top-cell"}
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
	<td class="{$cellclass}">
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
	<td width="1%" class="table-list-top-cell">{$lang[$extra_data.MULTICHOICE_LABEL]}</td>
	{/if}
</tr>
{/section}
{if $extra_data.MULTICHOICE[1] != '' || $extra_data.TOTAL_PAGES != ''}
<tr class="table-list-footer">
	{if $extra_data.TOTAL_PAGES == ''}
		{foreach key=key item=cell from=$data[0]}
		<td></td>
		{/foreach}
	{else}
		{section name=cell loop=$data[0]}
		{/section}
		<td class="table-list-footer" colspan="{$smarty.section.cell.total}">Pages: 
		{foreach key=key item=page from=$extra_data.PAGES}
			{if $key == $extra_data.CURRENT_PAGE}
				{$key}
			{else}
				<a href="{$page}">{$key}</a>
			{/if}
		{/foreach}</td>
	{/if}
	{if $extra_data.MULTICHOICE[1] != ''}<td class="table-form-submit"><input class="fld-form-submit" type="submit" name="submit" value="{$lang[$extra_data.MULTICHOICE_LABEL]|escape}" /></td>{/if}
</tr>
{/if}
</table>
{if $extra_data.MULTICHOICE[1] != ''}</form>{/if}