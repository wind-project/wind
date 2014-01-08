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
<script type="text/javascript">
function status_changed()
{{/literal}
	var arr_s = new Array()
	{section loop=$data[3].Type_Enums name=e}
		{assign var="lng" value=$data[3].Type_Enums[e].value}
		arr_s[{$smarty.section.e.index}] = '{$lang.email.zone.$lng.subject|replace:"##zone##":"`$data.0.value`"|replace:"\r":"\\r"|replace:"\n":"\\n"|escape:"quotes"}'
	{/section}
	var arr_b = new Array()
	{section loop=$data[3].Type_Enums name=e}
		{assign var="lng" value=$data[3].Type_Enums[e].value}
		arr_b[{$smarty.section.e.index}] = '{$lang.email.zone.$lng.body|replace:"##zone##":"`$data.0.value`"|replace:"##node_name##":"`$extra_data.node_name`"|replace:"##node_id##":"`$extra_data.node_id`"|replace:"##hostmaster_username##":"`$extra_data.hostmaster_username`"|replace:"##hostmaster_name##":"`$extra_data.hostmaster_name`"|replace:"##hostmaster_surname##":"`$extra_data.hostmaster_surname`"|replace:"\r":"\\r"|replace:"\n":"\\n"|escape:"quotes"}'
	{/section}
	document.{$extra_data.FORM_NAME}.email_subject.value = arr_s[document.{$extra_data.FORM_NAME}.{$data[3].fullField}.selectedIndex]
	document.{$extra_data.FORM_NAME}.email_body.value = arr_b[document.{$extra_data.FORM_NAME}.{$data[3].fullField}.selectedIndex]
	document.{$extra_data.FORM_NAME}.sendmail.checked = true
	document.{$extra_data.FORM_NAME}.email_to_type.disabled = false
	document.{$extra_data.FORM_NAME}.email_to.disabled = false
	document.{$extra_data.FORM_NAME}.email_subject.disabled = false
	document.{$extra_data.FORM_NAME}.email_body.disabled = false
{literal}}

function email_to_type_changed()
{
var lst=document.{/literal}{$extra_data.FORM_NAME}{literal}.email_to_type
var txt=document.{/literal}{$extra_data.FORM_NAME}{literal}.email_to
switch (lst.options[lst.selectedIndex].value) {
	case 'all':
		txt.value = '{/literal}{$extra_data.email_all}{literal}'
		break
	case 'owner':
		txt.value = '{/literal}{$extra_data.email_owner}{literal}'
		break
	case 'custom':
		txt.value = ''
		break
}
}

function sendmail_changed() {{/literal}
	document.{$extra_data.FORM_NAME}.email_to_type.disabled = !document.{$extra_data.FORM_NAME}.sendmail.checked
	document.{$extra_data.FORM_NAME}.email_to.disabled = !document.{$extra_data.FORM_NAME}.sendmail.checked
	document.{$extra_data.FORM_NAME}.email_subject.disabled = !document.{$extra_data.FORM_NAME}.sendmail.checked
	document.{$extra_data.FORM_NAME}.email_body.disabled = !document.{$extra_data.FORM_NAME}.sendmail.checked
{literal}}
</script>
{/literal}
<script type="text/javascript" src="{$js_dir}/pickup.js"></script>
<form name="{$extra_data.FORM_NAME}" method="post">
<input type="hidden" name="query_string" value="{$hidden_qs}" />
<input type="hidden" name="form_name" value="{$extra_data.FORM_NAME}" />
<div class="form-bs">
	<div class="form-group">
		<label>{$lang.db[$data.0.fullField]}{if $data.0.Null != 'YES'}*{/if}:</label>
		<input class="form-control" name="{$data.0.fullField}" type="text" value="{$data.0.value|escape}" />
	</div>

	<div class="form-group">
		<label>{$lang.db[$data.1.fullField]}{if $data.1.Null != 'YES'}*{/if}:</label>
		<textarea class="form-control" name="{$data.1.fullField}">{$data.1.value|escape}</textarea>
	</div>

	<div class="form-group">
		<label>{$lang.db[$data.2.fullField]}{if $data[2].Null != 'YES'}*{/if}:</label>
		<select class="form-control" name="{$data.2.fullField}[]" size="5" multiple="multiple">
			{section loop=$data.2.Type_Pickup name=e}
			{assign var="value" value=$data.2.Type_Pickup[e].value}
			<option value="{$data.2.Type_Pickup[e].value|escape}" selected="selected">{include file=constructors/form_enum.tpl fullField=$fullField value=$data.2.Type_Pickup[e].output}</option>
			{/section}
		</select>
		{include file="generic/button.tpl" class="btn-success btn-xs" glyph="plus-sign" content=`$lang.add`
			onclick="javascript: t = window.open('`$data.2.Pickup_url`', 'popup_pickup', 'width=700,height=600,toolbar=0,resizable=1,scrollbars=1'); t.focus();"}
		{include file="generic/button.tpl" class="btn-danger btn-xs" glyph="minus-sign" content=`$lang.remove`
			onclick="javascript: remove_selected(window.document.`$extra_data.FORM_NAME`.elements['`$data.2.fullField`[]']); return false;" }
	</div>
	
	
	<div class="form-group">
		<label>{$lang.db[$data.3.fullField]}{if $data[d].Null != 'YES'}*{/if}:</label>
		
		<select class="form-control" name="{$data[3].fullField}" onchange="status_changed()">
			{section loop=$data[3].Type_Enums name=e}
			<option value="{$data[3].Type_Enums[e].value|escape}"{if $data[3].Type_Enums[e].value == $data[3].value} selected="selected"{/if}>{include file=constructors/form_enum.tpl fullField=$data.3.fullField value=$data[3].Type_Enums[e].output}</option>
			{/section}
		</select>
	</div>
	<div class="form-group">
		<input type="checkbox" name="sendmail" value="Y" onclick="sendmail_changed()" />&nbsp;{$lang.send_mail}
	</div>
	<div class="form-group">
		<label>{$lang.to}:</label>
		<select class="form-control" name="email_to_type" onchange="email_to_type_changed()" disabled="disabled">
			<option value="all">{$lang.mailto_all}</option>
			<option value="owner">{$lang.mailto_owner}</option>
			<option value="custom">{$lang.mailto_custom}</option>
		</select><br />
		<input class="form-control" type="text" name="email_to" value="{$extra_data.email_all}" disabled="disabled" />
	</div>
	
	<div class="form-group">
		<label>{$lang.subject}:</label>
		<input class="form-control" type="text" name="email_subject" disabled="disabled" />
	</div>
	<div class="form-group">
		<label>{$lang.body}:</label>
		<textarea class="form-control" class="email-body" name ="email_body" disabled="disabled"></textarea>
	</div>
<div class="buttons">
<button class="btn btn-primary" type="submit">{$lang.submit}</button>
</div>
</div>
</form>