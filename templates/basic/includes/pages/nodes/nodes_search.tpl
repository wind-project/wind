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


{include assign=help file=generic/help.tpl help=nodes_search}
{include file=generic/page-title.tpl title="`$lang.all_nodes`" right="$help"}
<table width="100%"  border="0" cellpadding="0" cellspacing="0" class="table-page">
{if $skip_map!='yes'}
	<tr>
		<td class="table-page-split">
		<div id="map" class="map" style="height: 350px;" > </div>
		</td>
	</tr>
{/if}
	<tr>
		<td class="table-page-split">
			{include file=generic/title1.tpl title="`$lang.nodes_search`" content=$form_search_nodes}
		</td>
	</tr>
	<tr>
		<td class="table-page-pad">
			{include file=generic/title2.tpl title="`$lang.nodes_found`" content=$table_nodes}
		</td>
	</tr>
</table>
