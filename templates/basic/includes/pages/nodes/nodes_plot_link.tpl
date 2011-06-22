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
<table cellpadding="0" cellspacing="0" class="table-main">
	<tr>
		<td>
			{include file=generic/page-title.tpl title="`$lang.nodes_plot_link`"}
		</td>
	</tr>
	<tr>
		<td height="100%">
			<script language="JavaScript" type="text/javascript" src="{$js_dir}pickup.js"></script>
			<form style="height:100%;" name="form_nodes_plot_link" method="post" action="?">
			<input type="hidden" name="query_string" value="{$hidden_qs}" />
			<table cellpadding="4" cellspacing="0" class="plot-link-table">
				<tr>
					<td width="25%" align="left">
						{include file=generic/link.tpl content="`$lang.change`" onclick="javascript: t = window.open('?page=pickup&amp;subpage=nodes&amp;object=form_nodes_plot_link.a_node', 'popup_pickup', 'width=700,height=600,toolbar=0,resizable=1,scrollbars=1'); t.focus(); return false;"}
						<br />
						<input type="hidden" name="a_node" value="{$a_node}" />
						<input class="fld-form-input-pickup" type="text" disabled="disabled" name="a_node_output" value="{$a_node_output|escape}" />
					</td>
					<td width="50%" align="center">
						<input class="fld-form-submit" type="submit" name="submitbutton" value="{$lang.submit}" />
					</td>
					<td width="25%" align="right">
						{include file=generic/link.tpl content="`$lang.change`" onclick="javascript: t = window.open('?page=pickup&amp;subpage=nodes&amp;object=form_nodes_plot_link.b_node', 'popup_pickup', 'width=700,height=600,toolbar=0,resizable=1,scrollbars=1'); t.focus(); return false;"}
						<br />
						<input type="hidden" name="b_node" value="{$b_node}" />
						<input style="text-align:right;" class="fld-form-input-pickup" type="text" disabled="disabled" name="b_node_output" value="{$b_node_output|escape}" />
					</td>
				</tr>
				{if $a_node != '' && $b_node != ''}
				<tr>
					<td align="left">
						{$lang.azimuth}: {$a_node_azimuth|round:2}&#176;<br />
						{$lang.elevation}: {$a_node_geo_elevation|round:0} (+{$a_node_elevation|round:0}) m<br />
						{$lang.tilt}: {$a_node_tilt|round:2}&#176;
					</td>
					<td align="center">
						&lt;--- {$lang.distance}: {$distance|round:3} km ---&gt;<br />
						<span style="color: brown;">
							{$lang.fsl}:<br />
							{$fsl|round:2} dBm @ 
							<select name="frequency" onchange="this.form.submit();" style="font-size: 10px;">
								<option value="2450"{if $frequency == 2450} selected="selected"{/if}>2450</option>
								<option value="5500"{if $frequency == 5500} selected="selected"{/if}>5500</option>
							</select>
	 						MHz
						</span>
					</td>
					<td align="right">
						{$lang.azimuth}: {$b_node_azimuth|round:2}&#176;<br />
						{$lang.elevation}: {$b_node_geo_elevation|round:0} (+{$b_node_elevation|round:0}) m<br />
						{$lang.tilt}: {$b_node_tilt|round:2}&#176;
					</td>
				</tr>
				<tr>
					<td height="100%" colspan="3" align="center"><img src="{$plot_image}&amp;width=570&amp;height=250" width="570" height="250" alt="" /></td>
				</tr>
				<tr>
					<td colspan="3" align="right">{include file=generic/link.tpl content="`$lang.google_earth`" link="$gearth"}</td>
				</tr>
				{else}
				<tr>
					<td height="100%" colspan="3" align="center">{$lang.nodes_plot_link_info|wordwrap:40:"<br />"}</td>
				</tr>
				{/if}
			</table>
			</form>
		</td>
	</tr>
</table>