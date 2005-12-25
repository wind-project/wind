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
<form name="{$extra_data.FORM_NAME}" method="post" action="?">
<input type="hidden" name="query_string" value="{$hidden_qs}" />
<input type="hidden" name="form_name" value="{$extra_data.FORM_NAME}" />
<table class="table-form">
{section loop=$data name=d}
	{if $smarty.section.d.index is not even}
	<tr class="table-form-row2">
	{else}
	<tr class="table-form-row1">
	{/if}
	{assign var=fullField value=$data[d].fullField}
	{if $data[d].Type == 'caption'}
		<td class="table-form-title" colspan="2">{$data[d].Value|escape}</td>
	{elseif $data[d].Type == 'datetime'}
		<td class="table-form-title" >{$lang.db.$fullField}{if $data[d].Null != 'YES'}*{/if}:</td><td class="table-form-field" >{html_select_date time="`$data[d].value`" prefix="CONDATETIME_`$data[d].fullField`_"} - {html_select_time time="`$data[d].value`" prefix="CONDATETIME_`$data[d].fullField`_"}</td>
	{elseif $data[d].Type == 'text'}
		<td class="table-form-title" >{$lang.db.$fullField}{if $data[d].Null != 'YES'}*{/if}:</td><td class="table-form-field" ><textarea class="fld-form-input" name="{$data[d].fullField}">{$data[d].value|escape}</textarea></td>
	{elseif $data[d].Type == 'enum'}
		<td class="table-form-title" >{$lang.db.$fullField}{if $data[d].Null != 'YES'}*{/if}:</td>
		<td class="table-form-field" >
			<select class="fld-form-input" name="{$data[d].fullField}">
				{if $data[d].Null == 'YES'}<option value=""></option>{/if}
				{section loop=$data[d].Type_Enums name=e}
				<option value="{$data[d].Type_Enums[e].value|escape}"{if $data[d].Type_Enums[e].value == $data[d].value} selected="selected"{/if}>{include file=constructors/form_enum.tpl fullField=$fullField value=$data[d].Type_Enums[e].output}</option>
				{/section}
			</select>
		</td>	
	{elseif $data[d].Type == 'enum_multi'}
		<td class="table-form-title" >{$lang.db.$fullField}{if $data[d].Null != 'YES'}*{/if}:</td>
		<td class="table-form-field" >
			<select class="fld-form-input" name="{$data[d].fullField}[]" size="5" multiple="multiple">
				{section loop=$data[d].Type_Enums name=e}
				{assign var="value" value=$data[d].Type_Enums[e].value}
				<option value="{$data[d].Type_Enums[e].value}"{if $data[d].value.$value == 'YES'} selected="selected"{/if}>{include file=constructors/form_enum.tpl fullField=$fullField value=$data[d].Type_Enums[e].output}</option>
				{/section}
			</select>
		</td>	
	{elseif $data[d].Type == 'enum_radio'}
		<td class="table-form-title" >{$lang.db.$fullField}{if $data[d].Null != 'YES'}*{/if}:</td>
		<td class="table-form-field" >
			{if $data[d].Null == 'YES'}<input type="radio" name="{$data[d].fullField}" value="" /><br />{/if}
			{section loop=$data[d].Type_Enums name=e}
			<input type="radio" name="{$data[d].fullField}" value="{$data[d].Type_Enums[e].value|escape}"{if $data[d].Type_Enums[e].value == $data[d].value} checked="checked"{/if} />{include file=constructors/form_enum.tpl fullField=$fullField value=$data[d].Type_Enums[e].output}<br />
			{/section}
		</td>
	{elseif $data[d].Type == 'pickup'}
		{assign var=use_pickup value=TRUE}
		<td class="table-form-title" >{$lang.db.$fullField}{if $data[d].Null != 'YES'}*{/if}:</td>
		<td class="table-form-field" >
			<input type="hidden" name="{$data[d].fullField}" value="{$data[d].Type_Pickup.value|escape}" />
			<input type="text" disabled="disabled" class="fld-form-input-pickup" name="{$data[d].fullField}_output" value="{$data[d].Type_Pickup.output|escape}" />
			{include file=generic/link.tpl content="`$lang.change`" onclick="javascript: t = window.open('`$data[d].Pickup_url`', 'popup_pickup', 'width=700,height=600,toolbar=0,resizable=1,scrollbars=1'); t.focus(); return false;"}
			{if $data[d].Null == 'YES'}{include file=generic/link.tpl content="`$lang.delete`" onclick="javascript: `$data[d].fullField`.value = ''; `$data[d].fullField`_output.innerText = ''; return false;"}{/if}
		</td>	
	{elseif $data[d].Type == 'pickup_multi'}
		{assign var=use_pickup value=TRUE}
		<td class="table-form-title" >{$lang.db.$fullField}{if $data[d].Null != 'YES'}*{/if}:</td>
		<td class="table-form-field" >
			<select class="fld-form-input" name="{$data[d].fullField}[]" size="5" multiple="multiple">
				{section loop=$data[d].Type_Pickup name=e}
				{assign var="value" value=$data[d].Type_Pickup[e].value}
				<option value="{$data[d].Type_Pickup[e].value|escape}" selected="selected">{include file=constructors/form_enum.tpl fullField=$fullField value=$data[d].Type_Pickup[e].output}</option>
				{/section}
			</select>
			{include file=generic/link.tpl content="`$lang.add`" onclick="javascript: t = window.open('`$data[d].Pickup_url`', 'popup_pickup', 'width=700,height=600,toolbar=0,resizable=1,scrollbars=1'); t.focus(); return false;"}
			{include file=generic/link.tpl content="`$lang.remove`" onclick="javascript: remove_selected(window.document.`$extra_data.FORM_NAME`.elements['`$data[d].fullField`[]']); return false;"}
		</td>	
	{elseif $data[d].Field|truncate:8:"":true == 'password'}
		<td class="table-form-title">{$lang.db.$fullField}{if $data[d].Null != 'YES'}*{/if}:</td><td class="table-form-field" ><input class="fld-form-input" name="{$data[d].fullField}" type="password" value="{$data[d].value|escape}" /></td>
	{else}
		<td class="table-form-title">{$lang.db.$fullField}{if $data[d].Null != 'YES'}*{/if}:</td>
		<td class="table-form-field" >
		{if $data[d].Compare != ''}
			<table class="table-main" cellpadding="0" cellspacing="0"><tr><td>
			<select name="{$data[d].fullField}_compare">
				{if $data[d].Compare == 'full' || $data[d].Compare == 'numeric'}
				<option value="equal"{if $data[d].Compare_value == 'equal'} selected="selected"{/if}>{$lang.compare_equal}</option>
				<option value="greater_equal"{if $data[d].Compare_value == 'greater_equal'} selected="selected"{/if}>{$lang.compare_greater_equal}</option>
				<option value="less_equal"{if $data[d].Compare_value == 'less_equal'} selected="selected"{/if}>{$lang.compare_less_equal}</option>
				<option value="greater"{if $data[d].Compare_value == 'greater'} selected="selected"{/if}>{$lang.compare_greater}</option>
				<option value="less"{if $data[d].Compare_value == 'less'} selected="selected"{/if}>{$lang.compare_less}</option>
				{/if}
				{if $data[d].Compare == 'full' || $data[d].Compare == 'text'}
				<option value="starts_with"{if $data[d].Compare_value == 'starts_with'} selected="selected"{/if}>{$lang.compare_starts_with}</option>
				<option value="ends_with"{if $data[d].Compare_value == 'ends_with'} selected="selected"{/if}>{$lang.compare_ends_with}</option>
				<option value="contains"{if $data[d].Compare_value == 'contains'} selected="selected"{/if}>{$lang.compare_contains}</option>
				{/if}
			</select>
			</td><td width="100%">
		{/if}
		<input class="fld-form-input" name="{$data[d].fullField}" type="text" value="{$data[d].value|escape}" />
		{if $data[d].Compare != ''}</td></tr></table>{/if}
		</td>
	{/if}
	</tr>
{/section}
<tr><td class="table-form-submit" colspan="2"><input class="fld-form-submit" type="submit" name="submit" value="{$lang.submit}" /></td></tr>
</table>
</form>
{if $use_pickup == TRUE}<script language="JavaScript" type="text/javascript" src="{$js_dir}pickup.js"></script>{/if}