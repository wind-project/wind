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
<div class="header">

	<a href="{$link_home}"><img
{if $mylogo}
	src="{$mylogo_dir}mylogo.png"
{else}	
	src="{$img_dir}main_logo.png"
{/if}
	alt="Logo" class="{$lang.site_title}"/></a>

	<div class="user-panel">
	{if $logged==TRUE}
		<a href="{$link_user_profile}" class="user">{$logged_title}</a> | <a id="logout" href="{$link_logout}" class="logout">{$lang.logout}</a>
	{else}
		<a id="login" href="{$link_login_form}">{$lang.login}</a> / <a href="{$link_register}">{$lang.register}</a> 
	{/if}
		{include file="generic/language_selection.tpl" languages=$languages current_language=$current_language}
	</div>

	{literal}
	<script>
	$(function(){
		var login_form = new LoginForm({/literal} '{$link_login_form}' {literal});
		$('#login').click(function() {
			login_form.show();
			return false;
		});
		
		$('#logout').click(function() {
			$.get({/literal} '{$link_logout}' {literal}, function(){
				reload();
			});
			return false;
		});
	});
	</script>
	{/literal}
</div>