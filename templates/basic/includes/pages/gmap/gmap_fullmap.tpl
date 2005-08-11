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
<table class="table-main" cellpadding="0" cellspacing="0"><tr><td height="100%">
<div id="map" style="width: 100%; height: 100%"></div>
</td></tr><tr><td style="font-size:12px;" align="center">
<input type="checkbox" name="p2p" checked="checked" onClick="gmap_refresh();" />{$lang.backbone}
<input type="checkbox" name="aps" checked="checked" onClick="gmap_refresh();" />{$lang.aps}
<input type="checkbox" name="clients" checked="checked" onClick="gmap_refresh();" />{$lang.clients}
<input type="checkbox" name="unlinked" onClick="gmap_refresh();" />{$lang.unlinked}
</td>
</table>