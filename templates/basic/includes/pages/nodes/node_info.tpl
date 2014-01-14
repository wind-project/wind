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
<div class="node-info">
<span class="node-status node-status-{$node.status|escape}">{$node.status|escape}</span>
<dl class="node-details dl-horizontal">
<dt>{$lang.db.user_id_owner}</dt>
	<dd>{$node.owner_username|escape}
		{include file="generic/button.tpl" glyph=envelope class="btn-info btn-xs" onclick="javascript: t = window.open('$link_contact', 'contact', 'width=700,height=600,toolbar=0,resizable=1,scrollbars=1'); t.focus(); return false;" content=$lang.contact}
	</dd>
<dt>{$lang.location}</dt>
	<dd>{if $node.area_name}{$node.area_name|escape}{else}n/a{/if}<br/>
		{if $node.region_name}{$node.region_name|escape}{else}n/a{/if}<br />
		<code> {$node.latitude}, {$node.longitude} </code>
	</dd>
<dt>{$lang.db.nodes__date_in}</dt>
	<dd>{$node.date_in|date_format:"%x"}</dd>
<dt>{$lang.db.nodes__due_date}</dt>
	<dd>{$node.due_date|escape}</dd>
</dl>
{if $node.info }
<pre class="node-comments">
{$node.info}
</pre>
{/if}
</div>