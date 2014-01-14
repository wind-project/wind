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
<div class="plot-table">
	<div class="plot-peers">
	<span class="plot-left-peer">{$data[rowl].node_name|escape} <small>#{$data[rowl].node_id}</small></span>
	<span class="plot-right-peer"><small>#{$data[rowl].links__peer_node_id}</small> {$data[rowl].peer_node_name|escape}</span>
	</div>
	<span class="plot-distance">-- {$data[rowl].distance|round:3}km --</span>
	<div class="plot-image-cell">
		<a href="" onclick="javascript: t = window.open('?page=nodes&amp;subpage=plot_link&amp;a_node={$data[rowl].node_id}&amp;b_node={$data[rowl].links__peer_node_id}', 'popup_plot_link', 'width=600,height=450,toolbar=0,resizable=1,scrollbars=1'); t.focus(); return false;"><img src="?page=nodes&amp;subpage=plot&amp;a_node={$data[rowl].node_id}&amp;b_node={$data[rowl].links__peer_node_id}&amp;width=300&amp;height=150" width="300" height="150" alt="{$lang.plot}" /></a>
	</div>
</div>