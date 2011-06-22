{*
 * WiND - Wireless Nodes Database
 * Basic HTML Template
 *
 * Copyright (C) 2005 Konstantinos Papadimitriou <vinilios@cube.gr>
 * Copyright (C) 2010 Vasilis Tsiligiannis <b_tsiligiannis@silverton.gr>
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
{include assign=panoramic file="generic/photosview_image.tpl" image=$photosview.PANORAMIC}
<table border="0" cellspacing="0" align="center">
	<tr>
	<td colspan="3"><br/></td>
	</tr>
	<tr>
	<td class="node-view-left-top" >{include file="generic/photosview_image.tpl" image=$photosview.NW}</td>
	<td class="node-view-left-top" >{include file="generic/photosview_image.tpl" image=$photosview.N}</td>
	<td class="node-view-right-top" >{include file="generic/photosview_image.tpl" image=$photosview.NE}</td>
	</tr>
	<tr>
	<td class="node-view-left-mid" >{include file="generic/photosview_image.tpl" image=$photosview.W}</td>
	<td class="node-view-left-mid" ><img src="{$img_dir}compass.png" alt="" /></td>
	<td class="node-view-right-mid" >{include file="generic/photosview_image.tpl" image=$photosview.E}</td>
	</tr>
	<tr>
	<td class="node-view-left-bottom" >{include file="generic/photosview_image.tpl" image=$photosview.SW}</td>
	<td class="node-view-left-bottom" >{include file="generic/photosview_image.tpl" image=$photosview.S}</td>
	<td class="node-view-right-bottom" >{include file="generic/photosview_image.tpl" image=$photosview.SE}</td>
	</tr>
	<tr>
	<td colspan="3" align="center">{assign var=t value="photos__view_point-PANORAMIC"}{include file=generic/title5.tpl title="`$lang.db.$t`" content=$panoramic}</td>
	</tr>
</table>