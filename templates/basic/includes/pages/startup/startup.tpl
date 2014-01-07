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
{include file=generic/page-title.tpl title="`$community_name`"}
{if $startup_html != ''}
{$startup_html}
{else}
<div style="padding: 30px; font-size: 12px;">
<h2>{$lang.welcome}</h2>
<p>Welcome at {$community_name}. Here you can find information about <a href="?page=nodes">registered nodes</a>
of {$community_short_name} and <a href="?page=services">services</a> running on the network.
If you want want to participate you can always try to <a href="?page=users&amp;user=add">register</a>. For registered
users, there is support for private messages.
</p>

<h3>Registration</h3>

<p>
To create a new account, visit <a href="?page=users&amp;user=add">registration page</a>. To complete the registration you have
to confirm your email. If, for any reason you didn't get any email, you can request to
<a href="?page=users&amp;action=restore">resend the email</a>. 
</p>

<h3>Add Your Node</h3>
<p>
To create a new node you must be a registered user. After you have logged on on the system you
can request to <a href="?page=node_editor&amp;action=add">add a node</a>.
</p>

<h3>Declare links</h3>
<p>
For each node you can declare its links with other <strong>existing</strong> nodes.
</p>
<ul>
<li>If you are a <strong>client</strong> node, declare only one 
	link with the access point that you have been connected at.</li>
<li>If you have created a <strong>backbone link</strong>, declare it with as many information as possible.
	For complete link, the other node must add also link information.</li>
<li>If you own an access point, declare it so that clients can declare their links at you.</li>
</ul>

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