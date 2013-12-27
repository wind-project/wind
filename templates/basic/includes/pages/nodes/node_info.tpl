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
<table width="100%"  border="0" cellspacing="0" cellpadding="0" class="table-node">
<tr>
<td class="table-node-key">{$lang.db.nodes__id}</td>
<td class="table-node-value">{$node.id}</td>
</tr>
<tr>
<td class="table-node-key">{$lang.db.nodes__name}</td>
<td class="table-node-value">{$node.name|escape}</td>
</tr>
<tr>
<td class="table-node-key">{$lang.db.areas__name}</td>
<td class="table-node-value">{$node.area_name|escape}</td>
</tr>
<tr>
<td class="table-node-key">{$lang.db.regions__name}</td>
<td class="table-node-value">{$node.region_name|escape}</td>
</tr>
<tr>
<td class="table-node-key">{$lang.db.nodes__date_in}</td>
<td class="table-node-value">{$node.date_in|date_format:"%x"}</td>
</tr>
<tr>
<td class="table-node-key">{$lang.db.nodes__status}</td>
<td class="table-node-value">{$node.status|escape}</td>
</tr>
<tr>
<td class="table-node-key">{$lang.db.user_id_owner}</td>
<td class="table-node-value">{$node.owner_username|escape} {include file="generic/link.tpl" onclick="javascript: t = window.open('$link_contact', 'contact', 'width=700,height=600,toolbar=0,resizable=1,scrollbars=1'); t.focus(); return false;" content=$lang.contact}</td>
</tr>
</table>