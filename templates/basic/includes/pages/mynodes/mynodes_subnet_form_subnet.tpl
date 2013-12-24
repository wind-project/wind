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
{literal}
<script type="text/javascript" language="javascript">
function type_changed() {
	t = document.getElementById("{/literal}{$extra_data.FORM_NAME}{literal}_t")
	form = document.{/literal}{$extra_data.FORM_NAME}{literal}
	switch (form.subnets__type.value) {
		case 'local':
		form.subnets__link_id.value = ''
		form.subnets__link_id.disabled = true
		form.subnets__client_node_id.value = ''
		form.subnets__client_node_id.disabled = true
		t.rows[3].style.display = "none"
		t.rows[4].style.display = "none"
		break
		case 'link':
		form.subnets__link_id.disabled = false
		form.subnets__client_node_id.value = ''
		form.subnets__client_node_id.disabled = true
		try {
			t.rows[3].style.display = 'table-row';
		} catch(e) {
			t.rows[3].style.display = 'block';
		}

		t.rows[4].style.display = "none"
		break
		case 'client':
		form.subnets__link_id.value = ''
		form.subnets__link_id.disabled = true
		form.subnets__client_node_id.disabled = false
		t.rows[3].style.display = "none"
		try {
			t.rows[4].style.display = 'table-row';
		} catch(e) {
			t.rows[4].style.display = 'block';
		}
		break
	}
}
</script>
{/literal}
<form name="{$extra_data.FORM_NAME}" method="post" action="?">
<input type="hidden" name="query_string" value="{$hidden_qs}" />
<input type="hidden" name="form_name" value="{$extra_data.FORM_NAME}" />
<table class="table-form" id="{$extra_data.FORM_NAME}_t">
		<tr class="table-form-row1">
			<td class="table-form-title">{$lang.db[$data.0.fullField]}{if $data[0].Null != 'YES'}*{/if}:</td>
			<td class="table-form-field"><input class="fld-form-input" name="{$data[0].fullField}" type="text" value="{$data[0].value|escape}" /></td>
		</tr>
		<tr class="table-form-row2">
			<td class="table-form-title">{$lang.db[$data.1.fullField]}{if $data[1].Null != 'YES'}*{/if}:</td>
			<td class="table-form-field"><input class="fld-form-input" name="{$data[1].fullField}" type="text" value="{$data[1].value|escape}" /></td>
		</tr>

		<tr class="table-form-row1">
			<td class="table-form-title">{$lang.db[$data.2.fullField]}{if $data[2].Null != 'YES'}*{/if}:</td>
			<td class="table-form-field">
				<select class="fld-form-input" name="{$data[2].fullField}" onchange="type_changed()">
					{if $data[2].Null == 'YES'}<option value=""></option>{/if}
					{section loop=$data[2].Type_Enums name=e}
					<option value="{$data[2].Type_Enums[e].value|escape}"{if $data[2].Type_Enums[e].value == $data[2].value} selected="selected"{/if}>{include file=constructors/form_enum.tpl fullField=$data.2.fullField value=$data[2].Type_Enums[e].output}</option>
					{/section}
				</select>
			</td>
		</tr>	

		<tr class="table-form-row2">
			<td class="table-form-title">{$lang.db[$data.3.fullField]}{if $data[3].Null != 'YES'}*{/if}:</td>
			<td class="table-form-field">
				<select class="fld-form-input" name="{$data[3].fullField}">
					{if $data[3].Null == 'YES'}<option value=""></option>{/if}
					{section loop=$data[3].Type_Enums name=e}
					<option value="{$data[3].Type_Enums[e].value|escape}"{if $data[3].Type_Enums[e].value == $data[3].value} selected="selected"{/if}>{$data[3].Type_Enums[e].output|escape}</option>
					{/section}
				</select>
			</td>
		</tr>	

		<tr class="table-form-row2">
			<td class="table-form-title">{$lang.db[$data.4.fullField]}{if $data[4].Null != 'YES'}*{/if}:</td>
			<td class="table-form-field">
				<select class="fld-form-input" name="{$data[4].fullField}">
					{if $data[4].Null == 'YES'}<option value=""></option>{/if}
					{section loop=$data[4].Type_Enums name=e}
					<option value="{$data[4].Type_Enums[e].value|escape}"{if $data[4].Type_Enums[e].value == $data[4].value} selected="selected"{/if}>{$data[4].Type_Enums[e].output|escape}</option>
					{/section}
				</select>
			</td>
		</tr>	

		<tr>
			<td class="table-form-submit" colspan="2"><button type="submit">{$lang.submit}</button></td>
		</tr>
</table>
</form>
<script type="text/javascript" language="javascript">
type_changed()
</script>