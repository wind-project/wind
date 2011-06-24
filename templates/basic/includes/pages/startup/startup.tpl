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
{include file=generic/page-title.tpl title="`$lang.welcome`"}
{if $startup_html != ''}
{$startup_html}
{else}
<div style="padding: 30px; font-size: 12px;">
<h1>{$community_name}</h1>
<p>Welcome at {$community_name}. Here you can find information about <a href="?page=nodes">registered nodes</a>
of {$community_short_name} and <a href="?page=services">services</a> running on the network.
If you want want to participate you can always try to <a href="?page=users&user=add">register</a>. For registered
users, there is support for private messages.
</p>

<h3>Registration</h3>

<p>
To create a new account, visit <a href="?page=users&user=add">registration page</a>. To complete the registration you have
to confirm your email. If, for any reason you didn't get any email, you can request to
<a href="?page=users&action=restore">resend the email</a>. 
</p>

<h3>Add Your Node</h3>
<p>
To create a new node you must be a registered user. After you have logged on on the system you
can request to <a href="?page=mynodes&action=add">add a node</a>.
</p>

<h3>Declare links</h3>
<p>
For each node you can declare its links with other <strong>existing</strong> nodes.
<ul>
<li>If you are a <strong>client</strong> node, declare only one 
	link with the access point that you have been connected at.</li>
<li>If you have created a <strong>backbone link</strong>, declare it with as many information as possible.
	For complete link, the other node must add also link information.</li>
<li>If you own an access point, declare it so that clients can declare their links at you.</li>
</ul>  
</p>

<h3>Managing your Nodes</h3>
<p>
For any node you can update its information by visiting its page. Through your node page you can also interract
with the Hostmaster team, to request IP Ranges, DNS zones and nameservers.
</p>
<br />
<hr/>
<em>Try to update your nodes, with as much as possible <strong>valid</strong> information.
If you see invalid data on foreign nodes don't hesitate to contact them and request to update/change their public information.</em>

</div>
{/if}