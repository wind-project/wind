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
		<a href="{$link_user_profile}" class="user">{$logged_username}</a> | <a href="{$link_logout}" class="logout">{$lang.logout}</a>
	{else}
		<a id="login" href="#">{$lang.login}</a> / <a href="{$link_register}">{$lang.register}</a> 
		<div id="login-dialog">
			{$form_login}
		</div>
	{/if}
		{include file="generic/language_selection.tpl" languages=$languages current_language=$current_language}
	</div>

	{literal}
	<script>
	$(function(){
		$('#login').click(function() {
			$('#login-dialog').dialog( {
				modal: true,
				dialogClass: 'login-dialog'
			});
		});
	});
	</script>
	{/literal}
</div>