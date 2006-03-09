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
	<tr>
		<td class="table-page-split">
		{if $gmap_key_ok!=="nomap"}
			<table align="center" bgcolor="#DBE0D7" cellpadding="0" cellspacing="2">
				<tr>
					<td align="left">{include file=generic/link.tpl link=$link_gearth content="`$lang.google_earth`"}</td><td align="right">{include file=generic/link.tpl link=$link_fullmap content="`$lang.new_window`" target="_blank"}</td>
				</tr>
				<tr>
					<td style="font-size:12px; text-align:center;" colspan="2">
					{if $gmap_key_ok}
						<div id="map" style="width: 500px; height: 500px;"></div>
					{else}
						{$lang.message.error.gmap_key_failed.body|wordwrap:40|nl2br}
					{/if}
					</td>
				</tr>
				<tr>
					<td style="font-size:12px;">
						<input type="checkbox" name="p2p" checked="checked" onclick="gmap_refresh();" />{html_image file="`$img_dir`/gmap/mm_20_orange.png" alt=$lang.backbone}{$lang.backbone}
						<input type="checkbox" name="aps" checked="checked" onclick="gmap_refresh();" />{html_image file="`$img_dir`/gmap/mm_20_green.png" alt=$lang.aps}{$lang.aps}
						<input type="checkbox" name="clients" onclick="gmap_refresh();" />{html_image file="`$img_dir`/gmap/mm_20_blue.png" alt=$lang.clients}{$lang.clients}
						<input type="checkbox" name="unlinked" onclick="gmap_refresh();" />{html_image file="`$img_dir`/gmap/mm_20_red.png" alt=$lang.unlinked}{$lang.unlinked}
					</td>
				</tr>
			</table>
		{/if}
		</td>
	</tr>
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
