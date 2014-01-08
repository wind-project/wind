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
	<a href="{$link_home}"><img
{if $mylogo}
	src="{$mylogo_dir}/mylogo.png"
{else}	
	src="{$img_dir}/main_logo.png"
{/if}
	alt="Logo" class="{$lang.site_title}"/></a>

	<div class="user-panel">
		{include file="generic/language_selection.tpl" languages=$languages current_language=$current_language}
	{if $logged==TRUE}
		<a href="{$link_user_profile|escape}" class="user">{$logged_title}</a> | <a id="logout" href="{$link_logout|escape}" class="logout">{$lang.logout}</a>
	{else}
		<a id="login" href="{$link_login_form|escape}">{$lang.login}</a> / <a href="{$link_register|escape}">{$lang.register}</a> 
	{/if}
		<div class="quicksearch">
			<form name="search" method="get" action="{$search_url}">
				<input placeholder="{$lang.search}" type="text" id="q" name="q" autocomplete="off" onkeydown="" onfocus="hover('',this.value);" onkeyup="hover(event.keyCode,this.value);"  onblur="setTimeout('hideSearch()',500); hov=0;" />
				<div id="searchResult" ></div>
			</form>
		</div>
		
	</div>

	{literal}
	<script>
	$(function(){
		var login_form = new LoginForm({/literal} '{$link_login_form|escape}' {literal});
		$('#login').click(function() {
			login_form.show();
			return false;
		});
		
		$('#logout').click(function() {
			$.get($(this).attr('href'), function(){
				reload();
			});
			return false;
		});
	});
	</script>
	{/literal}