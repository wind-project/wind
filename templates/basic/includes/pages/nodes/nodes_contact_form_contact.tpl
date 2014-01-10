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
<form name="{$extra_data.FORM_NAME}" method="post" action="{$action_url}">
<input type="hidden" name="form_name" value="{$extra_data.FORM_NAME}" />
<div class="form-group">
	<label>{$lang.from}:</label>
	<input type="text" class="form-control" disabled=disabled value="{$extra_data.from_username|escape} &lt;{$extra_data.from_email|escape}&gt;"/>
</div>
<div class="form-group">
	<label>{$lang.to}:</label>
	<select class="form-control" name="email_to_type">
		<option value="all">{$lang.mailto_all}</option>
		<option value="owner">{$lang.mailto_owner}</option>
	</select>
</div>
<div class="form-group">
	<label>{$lang.subject}:</label>
	<input class="form-control" type="text" name="email_subject" />
</div>
<div class="form-group">
	<label>{$lang.body}:</label>
	<textarea class="form-control" name ="email_body"></textarea>
</div>
<div class="buttons">
	<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-envelope"></span> {$lang.send}</button>
</div>
</form>
</div>