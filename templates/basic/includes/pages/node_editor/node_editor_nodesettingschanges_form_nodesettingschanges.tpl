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
<table class="table-form" id="{$extra_data.FORM_NAME}_t">
		<tr class="table-form-row1" style="display:none">
			<td class="table-form-title">{$lang.db[$data.0.fullField]}{if $data[0].Null != 'YES'}*{/if}:</td>
			<td class="table-form-field"><input class="fld-form-input" name="{$data[0].fullField}" type="text" value="{$data[0].value|escape}" /></td>
		</tr>
		<tr class="table-form-row2" style="display:none">
			<td class="table-form-title">{$lang.db[$data.1.fullField]}{if $data[1].Null != 'YES'}*{/if}:</td>
			<td class="table-form-field"><input class="fld-form-input" name="{$data[1].fullField}" type="text" value="{$data[1].value|escape}" /></td>
		</tr>

		<tr class="table-form-row1" style="display:none">
			<td class="table-form-title">{$lang.db[$data.2.fullField]}{if $data[2].Null != 'YES'}*{/if}:</td>
			<td class="table-form-field"><input class="fld-form-input" name="{$data[2].fullField}" type="text" value="{$data[2].value|escape}" /></td>
		</tr>
		<tr class="table-form-row2">
			<td class="table-form-title">{$lang.db[$data.3.fullField]}{if $data[3].Null != 'YES'}*{/if}:</td>
		<td class="table-form-field"><textarea class="fld-form-input" name="{$data[3].fullField}">{$data[3].value|escape}</textarea></td>
		</tr>
 
       	<tr class="table-form-row1">
			<td class="table-form-title">{$lang.db[$data.4.fullField]}{if $data[4].Null != 'YES'}*{/if}:</td>
			<td class="table-form-field">
            <select class="fld-form-input" name="{$data[4].fullField}">
				{if $data[4].Null == 'YES'}<option value=""></option>{/if}
				{section loop=$data[4].Type_Enums name=e}
				<option value="{$data[4].Type_Enums[e].value|escape}"{if $data[4].Type_Enums[e].value == $data[4].value} selected="selected"{/if}>{include file=constructors/form_enum.tpl fullField=$data.4.fullField value=$data[4].Type_Enums[e].output}</option>
				{/section}
			</select>
            </td>
		</tr>
        
   	<tr class="table-form-row2">
			<td class="table-form-title">{$lang.db[$data.5.fullField]}{if $data[5].Null != 'YES'}*{/if}:</td>
			<td class="table-form-field">
            <select class="fld-form-input" name="{$data[5].fullField}">
				{if $data[5].Null == 'YES'}<option value=""></option>{/if}
				{section loop=$data[5].Type_Enums name=e}
				<option value="{$data[5].Type_Enums[e].value|escape}"{if $data[5].Type_Enums[e].value == $data[5].value} selected="selected"{/if}>{include file=constructors/form_enum.tpl fullField=$data.5.fullField value=$data[5].Type_Enums[e].output}</option>
				{/section}
			</select>
            </td>
		</tr>
 
 
   	<tr class="table-form-row1">
			<td class="table-form-title">{$lang.db[$data.6.fullField]}{if $data[6].Null != 'YES'}*{/if}:</td>
			<td class="table-form-field"><textarea class="fld-form-input" name="{$data[6].fullField}">{$data[6].value|escape}</textarea></td>
		</tr>


		
		<tr>
			<td class="table-form-submit" colspan="2"><input class="fld-form-submit" type="submit" name="submit" value="{$lang.submit}" /></td>
		</tr>
</table>
</form>