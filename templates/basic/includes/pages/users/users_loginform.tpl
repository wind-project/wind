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
<div class="login">
<div class="close button"></div>
<form name="login-form" action="{$form_submit_url}" method="POST">
	<input type="hidden" name="form_name" value="login"/> 
  <fieldset>
    <label><input type="text" name="username" placeholder="{$lang.username}"></label>
    <label><input type="password" name="password" placeholder="{$lang.password}"></label>
	<label>{$lang.rememberme}: <input type="checkbox" name="rememberme"></label>
  </fieldset>
  	<div class="notification"></div>
    <button type="submit">{$lang.login}</button> <a href="{$link_restore_password}">{$lang.password_recover}</a>
</form>
</div>
