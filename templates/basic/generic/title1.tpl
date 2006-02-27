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
<table width="100%"  border="0" cellspacing="0" cellpadding="0" class="table-d1">
	<tr>
		<td width="6" class="table-d1-side">&nbsp;</td>
		<td nowrap="nowrap" class="table-d1-title-text" >
			{$title}
		</td>
		{if $right != ''}<td nowrap="nowrap">{$right}</td>{/if}
		<td width="10" class="table-d1-title-space"></td>
		<td width="299" class="table-d1-title-border">&nbsp;</td>
		<td width="6" class="table-d1-side2">&nbsp;</td>
	</tr>
	<tr>
		<td rowspan="2" class="table-d1-side">&nbsp;</td>
		<td colspan="{if $right !=''}4{else}3{/if}" class="table-d1-title-down"></td>
		<td rowspan="2" class="table-d1-side2">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="{if $right !=''}4{else}3{/if}" class="table-d1-text1">
			{$content}
		</td>
	</tr>
</table>