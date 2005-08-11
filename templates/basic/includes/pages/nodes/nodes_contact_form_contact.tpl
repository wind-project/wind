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
<form name="{$extra_data.FORM_NAME}" method="post">
<input type="hidden" name="query_string" value="{$hidden_qs}" />
<input type="hidden" name="form_name" value="{$extra_data.FORM_NAME}" />
<table class="table-form">
	<tr class="table-form-row1"><td class="table-form-title">{$lang.from}:</td><td class="table-form-field">{$extra_data.from_username|escape} &lt;{$extra_data.from_email|escape}&gt;</td></tr>
<tr class="table-form-row2"><td class="table-form-title">{$lang.to}:</td><td class="table-form-field">
		<select class="fld-form-input" name="email_to_type">
			<option value="all">{$lang.mailto_all}</option>
			<option value="owner">{$lang.mailto_owner}</option>
		</select>
</td></tr>
<tr class="table-form-row1"><td class="table-form-title">{$lang.subject}:</td><td  class="table-form-field"><input class="fld-form-input" type="text" name="email_subject" /></td></tr>
<tr class="table-form-row2"><td class="table-form-title">{$lang.body}:</td><td  class="table-form-field"><textarea class="fld-form-input" name ="email_body"></textarea></td></tr>
<tr><td  class="table-form-submit" colspan="2"><input class="fld-form-submit" type="submit" name="submit" value="{$lang.send}" /></td></tr>
</table>
</form>