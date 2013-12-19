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