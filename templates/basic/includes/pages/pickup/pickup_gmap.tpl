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
<table class="table-main" cellpadding="0" cellspacing="0"><tr><td>
{include file=generic/page-title.tpl title="`$lang.find_coordinates`"}
</td></tr><tr style="height: 100%"><td>
<table class="table-main" cellpadding="0" cellspacing="0"><tr><td style="font-size:12px; text-align:center; width: 100%; height: 100%">
{if $gmap_key_ok}
<div id="map" style="width: 100%; height: 100%"></div>
{else}
{$lang.message.error.gmap_key_failed.body|wordwrap:40|nl2br}
{/if}
</td></tr>
</table>
</td></tr>
</table>
