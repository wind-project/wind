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

<div class="form-bs"> 
<form class="form-horizontal" name="{$extra_data.FORM_NAME}" method="post" action="{$action_url}">
<input type="hidden" name="form_name" value="{$extra_data.FORM_NAME}" />
{section loop=$data name=d}
	<div class="form-entry form-group">
	{assign var=fullField value=$data[d].fullField}
	<label class="control-label col-sm-3">{$lang.db.$fullField}{if $data[d].Null != 'YES'}*{/if}:</label>
	<div class="col-sm-9">
	{if $data[d].Type == 'caption'}
		{$data[d].Value|escape}
	{elseif $data[d].Type == 'datetime'}
		{html_select_date time="`$data[d].value`" prefix="CONDATETIME_`$data[d].fullField`_"} - {html_select_time time="`$data[d].value`" prefix="CONDATETIME_`$data[d].fullField`_"}
	{elseif $data[d].Type == 'text'}
		<textarea class="form-control" name="{$data[d].fullField}">{$data[d].value|escape}</textarea>
	{elseif $data[d].Type == 'enum'}
			<select class="form-control" name="{$data[d].fullField}">
				{if $data[d].Null == 'YES'}<option value="">---</option>{/if}
				{section loop=$data[d].Type_Enums name=e}
				<option value="{$data[d].Type_Enums[e].value|escape}"{if $data[d].Type_Enums[e].value == $data[d].value} selected="selected"{/if}>{include file=constructors/form_enum.tpl fullField=$fullField value=$data[d].Type_Enums[e].output}</option>
				{/section}
			</select>
	{elseif $data[d].Type == 'enum_multi'}
			<div class="multi-select">
				{section loop=$data[d].Type_Enums name=e}
				{assign var="value" value=$data[d].Type_Enums[e].value}
				<span class="multi-select-entry">
					<input type="checkbox" name="{$data[d].fullField}[]" value="{$data[d].Type_Enums[e].value}" {if $data[d].value.$value == 'YES'} checked="checked"{/if}>
					{include file=constructors/form_enum.tpl fullField=$fullField value=$data[d].Type_Enums[e].output}
				</span>
				{/section}
			</div>
	{elseif $data[d].Type == 'enum_radio'}
			{if $data[d].Null == 'YES'}<input type="radio" name="{$data[d].fullField}" value="" /><br />{/if}
			{section loop=$data[d].Type_Enums name=e}
				<input type="radio" name="{$data[d].fullField}" value="{$data[d].Type_Enums[e].value|escape}"{if $data[d].Type_Enums[e].value == $data[d].value} checked="checked"{/if} />{include file=constructors/form_enum.tpl fullField=$fullField value=$data[d].Type_Enums[e].output}<br />
			{/section}
	{elseif $data[d].Type == 'pickup'}
		{assign var=use_pickup value=TRUE}
		<div class="pickup">
			<input type="hidden" name="{$data[d].fullField}" value="{$data[d].Type_Pickup.value|escape}" />
			<input class="form-control" type="text" disabled="disabled" name="{$data[d].fullField}_output" value="{$data[d].Type_Pickup.output|escape}" />
			{include file=generic/button.tpl class="btn-default btn-xs" glyph=edit content=`$lang.change`
				onclick="javascript: t = window.open('`$data[d].Pickup_url`', 'popup_pickup', 'width=700,height=600,toolbar=0,resizable=1,scrollbars=1'); t.focus(); return false;" }
			{if $data[d].Null == 'YES'}
				{include file=generic/button.tpl class="btn-danger btn-xs" glyph=remove content=`$lang.delete`
					onclick="javascript: `$data[d].fullField`.value = ''; `$data[d].fullField`_output.innerText = ''; return false;"}
			{/if}
		</div>
	{elseif $data[d].Type == 'pickup_multi'}
		{assign var=use_pickup value=TRUE}
			<select class="form-control" name="{$data[d].fullField}[]" size="5" multiple="multiple">
				{section loop=$data[d].Type_Pickup name=e}
				{assign var="value" value=$data[d].Type_Pickup[e].value}
				<option value="{$data[d].Type_Pickup[e].value|escape}" selected="selected">{include file=constructors/form_enum.tpl fullField=$fullField value=$data[d].Type_Pickup[e].output}</option>
				{/section}
			</select>
			{include file=generic/button.tpl class="btn-success btn-xs" glyph=plus-sign content=`$lang.add`
					onclick="javascript: t = window.open('`$data[d].Pickup_url`', 'popup_pickup', 'width=700,height=600,toolbar=0,resizable=1,scrollbars=1'); t.focus();" }
			{include file=generic/button.tpl class="btn-danger btn-xs" glyph=minus-sign content=`$lang.delete`
					onclick="javascript: remove_selected(window.document.`$extra_data.FORM_NAME`.elements['`$data[d].fullField`[]']); return false;" }
		{*<ul class="pickup-list menu">
		{section loop=$data[d].Type_Pickup name=e}
		{assign var="value" value=$data[d].Type_Pickup[e].value}
			<li>
				<span class="text">
					{include file=constructors/form_enum.tpl fullField=$fullField value=$data[d].Type_Pickup[e].output}
				</span>
				<button type="button" class="delete">{$lang.delete}</button>
			</li>
		{/section}
		</ul>
		<div class="pickup-node">
		<input type="text"> <button type="button" class="add">{$lang.add}</button>
		</div>
		*}
	{elseif $data[d].Field|truncate:8:"":true == 'password'}
		<input class="form-control" name="{$data[d].fullField}" type="password" value="{$data[d].value|escape}" />
	{else}
		{if $data[d].Compare != ''}
			<div class="comparison">
			<select class="form-control" name="{$data[d].fullField}_compare">
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
		{/if}
		<input class="form-control" name="{$data[d].fullField}" type="text" value="{$data[d].value|escape}" />
		{if $data[d].Compare != ''}
			</div>
		{/if}
	{/if}
	</div>
	</div>
{/section}
<div class="buttons">
<button class="btn-primary btn submit" type="submit">{$lang.submit}</button>
{foreach from=$buttons item=button}
	<button type="button" class="btn {$button.classes}" onclick="javascript: window.location='{$button.href}';">{$button.title}</button>
{/foreach}
</div>
</form>
</div>

{if $use_pickup == TRUE}<script type="text/javascript" src="{$js_dir}/pickup.js"></script>{/if}