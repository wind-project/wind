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
{literal}
<script type="text/javascript" language="javascript">
function type_changed() {
	t = document.getElementById("{/literal}{$extra_data.FORM_NAME}{literal}_t")
	form = document.{/literal}{$extra_data.FORM_NAME}{literal}
	switch (form.links__type.value) {
		case 'p2p':
			form.links__peer_node_id.disabled = false
			form.links__peer_ap_id.value = ''
			form.links__peer_ap_id.disabled = true
			form.links__protocol.disabled = false
			form.links__ssid.disabled = false
			form.links__channel.disabled = false
			try {
				t.rows[1].style.display = 'table-row';
			} catch(e) {
				t.rows[1].style.display = 'block';
			}
			t.rows[2].style.display = "none"
			try {
				t.rows[3].style.display = 'table-row';
				t.rows[4].style.display = 'table-row';
				t.rows[5].style.display = 'table-row';
			} catch(e) {
				t.rows[3].style.display = 'block';
				t.rows[4].style.display = 'block';
				t.rows[5].style.display = 'block';
			}
			break
		case 'ap':
			form.links__peer_node_id.value = ''
			form.links__peer_node_id.disabled = true
			form.links__peer_ap_id.value = ''
			form.links__peer_ap_id.disabled = true
			form.links__protocol.disabled = false
			form.links__ssid.disabled = false
			form.links__channel.disabled = false
			t.rows[1].style.display = "none"
			t.rows[2].style.display = "none"
			try {
				t.rows[3].style.display = 'table-row';
				t.rows[4].style.display = 'table-row';
				t.rows[5].style.display = 'table-row';
			} catch(e) {
				t.rows[3].style.display = 'block';
				t.rows[4].style.display = 'block';
				t.rows[5].style.display = 'block';
			}
			break
		case 'client':
			form.links__peer_node_id.disabled = true
			form.links__peer_ap_id.disabled = false
			form.links__protocol.disabled = true
			form.links__ssid.disabled = true
			form.links__channel.disabled = true
			form.links__protocol.value = ''
			form.links__ssid.value = ''
			form.links__channel.value = ''
			t.rows[1].style.display = "none"
			try {
				t.rows[2].style.display = 'table-row';
			} catch(e) {
				t.rows[2].style.display = "block";
			}
			t.rows[3].style.display = "none"
			t.rows[4].style.display = "none"
			t.rows[5].style.display = "none"
			break
	}
}
</script>
{/literal}
<script language="JavaScript" type="text/javascript" src="{$js_dir}/pickup.js"></script>
<div class="form-bs">
<form name="{$extra_data.FORM_NAME}" method="post" action="{$action_url}" id="{$extra_data.FORM_NAME}_t">
<input type="hidden" name="form_name" value="{$extra_data.FORM_NAME}" />
	<div class="form-group">
		<label>{$lang.db[$data.0.fullField]}{if $data[0].Null != 'YES'}*{/if}:</label>
		<select class="form-control" name="{$data[0].fullField}" onchange="type_changed()">
			{if $data[0].Null == 'YES'}<option value=""></option>{/if}
			{section loop=$data[0].Type_Enums name=e}
			<option value="{$data[0].Type_Enums[e].value|escape}"{if $data[0].Type_Enums[e].value == $data[0].value} selected="selected"{/if}>{include file=constructors/form_enum.tpl fullField=$data.0.fullField value=$data[0].Type_Enums[e].output}</option>
			{/section}
		</select>
	</div>
	<div class="form-group">
		<label>{$lang.db[$data.1.fullField]}{if $data[1].Null != 'YES'}*{/if}:</label>
			<input type="hidden" name="{$data[1].fullField}" value="{$data[1].Type_Pickup.value|escape}" />
			<input class="form-control" type="text" disabled="disabled" name="{$data[1].fullField}_output" value="{$data[1].Type_Pickup.output|escape}" />
			{include file=generic/button.tpl content="`$lang.change`" class="btn-default btn-sm" glyph=edit 
				onclick="javascript: t = window.open('`$data[1].Pickup_url`', 'popup_pickup', 'width=700,height=600,toolbar=0,resizable=1,scrollbars=1'); t.focus(); return false;"}
			{if $data[1].Null == 'YES'}{include file=generic/link.tpl content="`$lang.delete`" onclick="javascript: `$data[1].fullField`.value = ''; `$data[1].fullField`_output.innerText = ''; return false;"}{/if}
	</div>	
	<div class="form-group">
		<label>{$lang.db[$data.2.fullField]}{if $data[2].Null != 'YES'}*{/if}:</label>
			<input type="hidden" name="{$data[2].fullField}" value="{$data[2].Type_Pickup.value|escape}" />
			<input type="text" disabled="disabled" class="form-control" name="{$data[2].fullField}_output" value="{$data[2].Type_Pickup.output|escape}" />
			{include file=generic/button.tpl content="`$lang.change`" class="btn-default btn-sm" glyph=edit
			onclick="javascript: t = window.open('`$data[2].Pickup_url`', 'popup_pickup', 'width=700,height=600,toolbar=0,resizable=1,scrollbars=1'); t.focus(); return false;"}
			
			{if $data[2].Null == 'YES'}
				{include file=generic/link.tpl content="`$lang.delete`" onclick="javascript: `$data[2].fullField`.value = ''; `$data[2].fullField`_output.innerText = ''; return false;"}
			{/if}
	</div>
	<div class="form-group">	
		<label>{$lang.db[$data.3.fullField]}{if $data[3].Null != 'YES'}*{/if}:</label>
		<select class="form-control" name="{$data[3].fullField}">
			{if $data[3].Null == 'YES'}<option value=""></option>{/if}
			{section loop=$data[3].Type_Enums name=e}
			<option value="{$data[3].Type_Enums[e].value|escape}"{if $data[3].Type_Enums[e].value == $data[3].value} selected="selected"{/if}>{include file=constructors/form_enum.tpl fullField=$data.3.fullField value=$data[3].Type_Enums[e].output}</option>
			{/section}
		</select>
	</div>	
	<div class="form-group">
		<label>{$lang.db[$data.4.fullField]}{if $data[4].Null != 'YES'}*{/if}:</label>
		<input class="form-control" name="{$data[4].fullField}" type="text" value="{$data[4].value|escape}" />
	</div>
	<div class="form-group">
		<label>{$lang.db[$data.5.fullField]}{if $data[5].Null != 'YES'}*{/if}:</label>
		<input class="form-control" name="{$data[5].fullField}" type="text" value="{$data[5].value|escape}" />
	</div>
	
	<div class="form-group">
		<label>{$lang.db[$data.6.fullField]}{if $data[6].Null != 'YES'}*{/if}:</label>
			<select class="form-control" name="{$data[6].fullField}">
				{if $data[6].Null == 'YES'}<option value=""></option>{/if}
				{section loop=$data[6].Type_Enums name=e}
					<option value="{$data[6].Type_Enums[e].value|escape}"{if $data[6].Type_Enums[e].value == $data[6].value} selected="selected"{/if}>{include file=constructors/form_enum.tpl fullField=$data.6.fullField value=$data[6].Type_Enums[e].output}</option>
				{/section}
			</select>
	</div>
	<div class="form-group">
		<label>{$lang.db[$data.7.fullField]}{if $data[7].Null != 'YES'}*{/if}:</label>
		<select class="form-control" name="{$data[7].fullField}">
			{if $data[7].Null == 'YES'}<option value=""></option>{/if}
			{section loop=$data[7].Type_Enums name=e}
			<option value="{$data[7].Type_Enums[e].value|escape}"{if $data[7].Type_Enums[e].value == $data[7].value} selected="selected"{/if}>{include file=constructors/form_enum.tpl fullField=$data.7.fullField value=$data[7].Type_Enums[e].output}</option>
			{/section}
		</select>
	</div>
	<div class="form-group">
		<label>{$lang.db[$data.8.fullField]}{if $data[8].Null != 'YES'}*{/if}:
		<textarea class="form-control" name="{$data[8].fullField}">{$data[8].value|escape}</textarea>
	</div>
	<div class="form-group">
		<label>{$lang.db[$data.9.fullField]}{if $data[9].Null != 'YES'}*{/if}:</label>
		<textarea class="form-control" name="{$data[9].fullField}">{$data[9].value|escape}</textarea>
	</div>
<div class="buttons">
<button class="btn btn-primary">{$lang.submit}</button>
</div>
</form>
</div>
<script type="text/javascript" language="javascript">
type_changed()
</script>