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
<table class="plot-table" cellspacing="0">
<tr><td colspan="3" class="plot-title">{$lang.plot}</td></tr>
<tr><td width="33%" align="left">{$data[rowl].node_name|escape} (#{$data[rowl].node_id})</td><td width="33%" align="center">-- {$data[rowl].distance|round:3}km --</td><td align="right">{$data[rowl].peer_node_name|escape} (#{$data[rowl].links__peer_node_id})</td></tr>
<tr><td colspan="3" align="center"><a href="" onclick="javascript: t = window.open('?page=nodes&amp;subpage=plot_link&amp;a_node={$data[rowl].node_id}&amp;b_node={$data[rowl].links__peer_node_id}', 'popup_plot_link', 'width=600,height=450,toolbar=0,resizable=1,scrollbars=1'); t.focus(); return false;"><img src="?page=nodes&amp;subpage=plot&amp;a_node={$data[rowl].node_id}&amp;b_node={$data[rowl].links__peer_node_id}&amp;width=300&amp;height=150" width="300" height="150" alt="{$lang.plot}" /></a></td></tr>
</table>