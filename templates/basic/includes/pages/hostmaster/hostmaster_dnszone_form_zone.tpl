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
<script language="JavaScript" type="text/javascript" src="{$js_dir}pickup.js"></script>
<form name="{$extra_data.FORM_NAME}" method="post">
<input type="hidden" name="query_string" value="{$hidden_qs}" />
<input type="hidden" name="form_name" value="{$extra_data.FORM_NAME}" />
<table class="table-form">
	<tr class="table-form-row1"><td class="table-form-title">{$lang.db[$data.0.fullField]}{if $data.0.Null != 'YES'}*{/if}:</td><td class="table-form-field"><input class="fld-form-input" name="{$data.0.fullField}" type="text" value="{$data.0.value|escape}" /></td></tr>

	<tr class="table-form-row2"><td class="table-form-title">{$lang.db[$data.1.fullField]}{if $data.1.Null != 'YES'}*{/if}:</td><td class="table-form-field"><textarea class="fld-form-input" name="{$data.1.fullField}">{$data.1.value|escape}</textarea></td></tr>

	<tr class="table-form-row1">
	<td class="table-form-title">{$lang.db[$data.2.fullField]}{if $data[2].Null != 'YES'}*{/if}:</td>
	<td class="table-form-field" >
		<select class="fld-form-input" name="{$data.2.fullField}[]" size="5" multiple="multiple">
			{section loop=$data.2.Type_Pickup name=e}
			{assign var="value" value=$data.2.Type_Pickup[e].value}
			<option value="{$data.2.Type_Pickup[e].value|escape}" selected="selected">{include file=constructors/form_enum.tpl fullField=$fullField value=$data.2.Type_Pickup[e].output}</option>
			{/section}
		</select>
		{include file=generic/link.tpl content="`$lang.add`" onclick="javascript: t = window.open('`$data.2.Pickup_url`', 'popup_pickup', 'width=700,height=600,toolbar=0,resizable=1,scrollbars=1'); t.focus(); return false;"}
		{include file=generic/link.tpl content="`$lang.remove`" onclick="javascript: remove_selected(window.document.`$extra_data.FORM_NAME`.elements['`$data.2.fullField`[]']); return false;"}
	</td>	
	</tr>
		
	<tr class="table-form-row2"><td class="table-form-title">{$lang.db[$data.3.fullField]}{if $data[d].Null != 'YES'}*{/if}:</td>
	<td class="table-form-field">
		<select class="fld-form-input" name="{$data[3].fullField}" onchange="status_changed()">
			{section loop=$data[3].Type_Enums name=e}
			<option value="{$data[3].Type_Enums[e].value|escape}"{if $data[3].Type_Enums[e].value == $data[3].value} selected="selected"{/if}>{include file=constructors/form_enum.tpl fullField=$data.3.fullField value=$data[3].Type_Enums[e].output}</option>
			{/section}
		</select>
	</td></tr>	
<tr class="table-form-row1"><td class="table-form-field" colspan="2"><input type="checkbox" name="sendmail" value="Y" onclick="sendmail_changed()" />&nbsp;{$lang.send_mail}</td></tr>
<tr class="table-form-row2"><td class="table-form-title">{$lang.to}:</td><td class="table-form-field">
		<select class="fld-form-input" name="email_to_type" onchange="email_to_type_changed()" disabled="disabled">
			<option value="all">{$lang.mailto_all}</option>
			<option value="owner">{$lang.mailto_owner}</option>
			<option value="custom">{$lang.mailto_custom}</option>
		</select><br />
<input class="fld-form-input" type="text" name="email_to" value="{$extra_data.email_all}" disabled="disabled" /></td></tr>
<tr class="table-form-row1"><td class="table-form-title">{$lang.subject}:</td><td  class="table-form-field"><input class="fld-form-input" type="text" name="email_subject" disabled="disabled" /></td></tr>
<tr class="table-form-row2"><td class="table-form-title">{$lang.body}:</td><td  class="table-form-field"><textarea class="fld-form-input" name ="email_body" disabled="disabled"></textarea></td></tr>
<tr><td  class="table-form-submit" colspan="2"><input class="fld-form-submit" type="submit" name="submit" value="{$lang.submit}" /></td></tr>
</table>
</form>