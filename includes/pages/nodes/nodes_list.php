<?php
/*
 * WiND - Wireless Nodes Database
 *
 * Copyright (C) 2005 Nikolaos Nikalexis <winner@cube.gr>
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
 * ***********************************************************
 * Edit History
 * ***********************************************************
 * File created : 04 April 2009
 * By : Morne Oosthuizen (moroos@mweb.co.za)
 * Location : Bellville, Cape Town, South Africa
 * Purpose : Added functionality to view a complete list of nodes,
 *                       and compare it with all avaiable nodes in table format.
 * ***********************************************************
 */

include_once(ROOT_PATH.'globals/classes/geocalc.php');
include_once(ROOT_PATH.'globals/classes/srtm.php');
include_once(ROOT_PATH.'globals/classes/geoimage.php');
$srtm = new srtm($vars['srtm']['path']);
$geocalc = new GeoCalc();
$geoimage = new geoimage();


class nodes_list {

  var $template;
  var $result;
  var $aDistance;
  var $aCounter;
  var $classCounter = 1;
  var $image;

  function nodes_list() {
    global $db;
    global $geocalc;
    global $srtm;
    global $vars;

    $this->aCounter = 0;

    $a_node = get('a_node');
    $this->template['a_node'] = $a_node;
    if ($this->template['a_node'] != '') {
      $a_node_data = $db->get('id, name, latitude, longitude, elevation',
        'nodes',
        "id = '".$this->template['a_node']."'",
        '','name');
      $a_node_data = $a_node_data[0];
        $this->template['a_node_output'] = $a_node_data['name'].' (#'.$a_node_data['id'].')';
    }
    $this->result = "<table width=\"100%\"  border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"table-list\">
    <tr>
    <td width=\"100%\" class=\"table-list-title\">LOS from ".$this->template['a_node_output']."</td>
    <td width=\"200\"></td>         </tr>
    <tr>
    <td width=\"100%\" colspan=\"2\">
    <table width=\"100%\"  border=\"0\" cellspacing=\"0\" cellpadding=\"2\">
    <tr>
    <td class=\"table-list-top-cell\">
    Node name
    </td>
    <td class=\"table-list-top-cell\">
    Lat
    </td><td class=\"table-list-top-cell\">
    Long
    </td>" .
    "<td class=\"table-list-top-cell\">
    Elevation
    </td>" .
    "<td class=\"table-list-top-cell\">
    Distance
    </td>" .
    "<td class=\"table-list-top-cell\" colspan=\"2\">
    LOS
    </td>
    </tr>";
    $a_node = $db->get('latitude, longitude, elevation', 'nodes', "id = '".$_GET["a_node"]."'");
    $SQL_select  = "SELECT distinct(a.id), a.*, (1000 * acos(
      cos( radians(".$a_node[0]['latitude'].") )
      * cos( radians( latitude ) )
      * cos( radians( longitude )
      - radians(".$a_node[0]['longitude'].") )
      + sin( radians(".$a_node[0]['latitude'].") )
      * sin( radians( latitude ) )
      )
      ) AS distance
    ";
    $SQL = " FROM nodes a LEFT JOIN links b ON a.id = b.node_id and b.type in ('ap','p2p'".
      ((get('showall') == '')?"":",'client'").") and b.status='active' 
      WHERE a.id != ".$_GET["a_node"]." AND not b.node_id is null ".
      sprintf("and a.latitude between %.2f and %.2f ",
        min($vars['map']['bounds']['min_latitude'],$vars['map']['bounds']['max_latitude']),
        max($vars['map']['bounds']['min_latitude'],$vars['map']['bounds']['max_latitude'])).
      sprintf("and a.longitude between %.2f and %.2f ",
        min($vars['map']['bounds']['min_longitude'],$vars['map']['bounds']['max_longitude']),
        max($vars['map']['bounds']['min_longitude'],$vars['map']['bounds']['max_longitude']));
    //echo $SQL_select.$SQL;
    $limitRows = (isset($vars['constructor']['max_rows'])?$vars['constructor']['max_rows']:20);
    $r = mysql_query("SELECT COUNT( DISTINCT (a.id) ) AS number ".$SQL);
    //echo "SELECT COUNT( DISTINCT (a.id) ) AS number ".$SQL;
    while ($ROW = mysql_fetch_array($r)) {
      $nodesNum = $ROW['number'];
    }
    $sqldo = $SQL_select.$SQL.
      " order by distance asc
      limit ".(isset($_REQUEST['pg'])?($_REQUEST['pg']*$limitRows-$limitRows).
      ",$limitRows":$limitRows);
    //echo $sqldo;
    $RES = mysql_query($sqldo);
    $a_node = $db->get('latitude, longitude, elevation', 'nodes', "id = '".$_GET["a_node"]."'");
    $width = 570;
    $height = 250;

    while ($ROW = mysql_fetch_array($RES)) {
      $this->image = imagecreate($width, $height);
      $b_node = $ROW[0];
      $this->template['b_node'] = $b_node;
      if ($this->template['b_node'] != '') {
        $b_node_data = $db->get('id, name, latitude, longitude, elevation', 'nodes', "id = '".$this->template['b_node']."'");
        $b_node_data = $b_node_data[0];
        $this->template['b_node_output'] = $b_node_data['name'].' (#'.$b_node_data['id'].')';
      }
      $b_node = $db->get('latitude, longitude, elevation', 'nodes', "id = '".$ROW[0]."'");
      $antenna_a = $a_node[0]["elevation"];
      $antenna_b = $b_node[0]["elevation"];
      $point_a = new coordinate($a_node[0]['latitude'], $a_node[0]['longitude']);
      $point_b = new coordinate($b_node[0]['latitude'], $b_node[0]['longitude']);

      $distance = $geocalc->GCDistance($point_a->lat, $point_a->lon, $point_b->lat, $point_b->lon) * 1000;

      $ground_pad = $height * (1 / 20);
      $sky_pad = $height * (1 / 20);
      $left_pad = 0;
      $right_pad = 0;

      $width = $width - $left_pad - $right_pad;

      $color_sky = ImageColorAllocate($this->image, 99, 200, 248);
      $color_ground = ImageColorAllocate($this->image, 177, 125, 86);
      $color_antenna = ImageColorAllocate($this->image, 0, 0, 0);
      $color_sea = ImageColorAllocate($this->image, 0, 0, 200);
      $black = ImageColorAllocate($this->image, 0, 0, 0);
      $color_link_on = ImageColorAllocate($this->image, 57, 187, 77); //THIS IS THE PASS COLOUR
      $color_link_off = ImageColorAllocate($this->image, 211, 97, 97);  //THIS IS THE FAIL COLOUR

      $step_lat = ($point_b->lat - $point_a->lat) / ($width - 1);
      $step_log = ($point_b->lon - $point_a->lon) / ($width - 1);
      for ($i=0;$i<$width;$i++) {
        $elevations[$i] = $srtm->get_elevation($point_a->lat + $step_lat * $i, $point_a->lon + $step_log * $i, FALSE);
				if ($point_a->lat == '' || $point_a->lon == '' || $point_b->lat == '' || $point_b->lon == '' || $elevations[$i] === FALSE) {
          imagestring ($this->image, 5, 10, 10, "Data error!", $black);
          return $this->image;
        }
        if ($elevations[$i] < -32000) {
          $elevations[$i] = $elevations[$i-1];
        }
      }
      $max_el = max($elevations) + max($antenna_a, $antenna_b);
      $min_el = min($elevations);

      $step_elevation = ($max_el - $min_el) / ($height - $ground_pad - $sky_pad);

      $antenna_a_se = $antenna_a / $step_elevation;
      $antenna_b_se = $antenna_b / $step_elevation;

      for ($i=0;$i<$width;$i++) {
        //GROUND
        $pixels_el = ($elevations[$i] - $min_el) / $step_elevation;
        $y1 = $height - 1 - $ground_pad - $pixels_el;
        $y2 = $height - 1;
        imagelinethick($this->image, $left_pad + $i, $y1, $left_pad + $i, $y2, $color_ground);

        //SEA
        if ($elevations[$i] < 0) {
          $pixels_el = (0 - $min_el) / $step_elevation;
          $y2 = $y1;
          $y1 = $height - 1 - $ground_pad - $pixels_el;
          imagelinethick($this->image, $left_pad + $i, $y1, $left_pad + $i, $y2, $color_sea);
        }

        //ANTENNA A
        if ($i ==0) {
          $ant_a = $y1 - $antenna_a_se;
        }

        //ANTENNA B
        if ($i == $width-2) {
          $ant_b = $y1 - $antenna_b_se;
        }
      } // End for

      $color_link = $color_link_on;

      $start = $color_link;
      $pf = "<div style='color:green;font-weight:bold'>PASS</div>";
      for ($i=0;$i<$width;$i++) {
        if (imagecolorat($this->image, $left_pad + $i, $ant_a + $i * ($ant_b - $ant_a) / ($width - 1)) == $color_ground) {
          $color_link = $color_link_off;
          if ($start != $color_link) {
            $pf = "<div style='color:red;font-weight:bold'>FAIL</div>";
          }
          break;
        }
      }
      //echo $start." = ".$color_link."<br>";
      $this->aDistance[$this->aCounter] = number_format(($distance/1000),2);
      $this->aResult[$this->aCounter] = $pf;
      $this->aNodeName[$this->aCounter] = $this->template["b_node_output"];
      $this->aLat[$this->aCounter] = $point_b->lat;
      $this->aLong[$this->aCounter] = $point_b->lon;
      $this->aElev[$this->aCounter] = $antenna_b;
      $this->aID[$this->aCounter] = $this->template['a_node'];
      $this->bID[$this->aCounter] = $this->template['b_node'];
      $this->aCounter++;
      imagedestroy($this->image);
    }
    
    foreach ($this->aDistance as $key => $val) {
      $this->result .= "<tr class=\"table-list-list1\">
        <td class=\"table-list-cell\">
        <a href=\"\" onclick=\"javascript: t = window.open('?page=nodes&amp;subpage=plot_link&amp;a_node=".$this->aID[$key]."&amp;b_node=".$this->bID[$key]."', 'popup_plot_link', 'width=600,height=420,toolbar=0,resizable=1,scrollbars=1'); t.focus(); return false;\">".$this->aNodeName[$key]."</a>
        </td><td class=\"table-list-cell\">
        ".$this->aLat[$key]."
        </td><td class=\"table-list-cell\">
        ".$this->aLong[$key]."
        </td><td class=\"table-list-cell\">
        ".$this->aElev[$key]."
        </td><td class=\"table-list-cell\">
        ".$this->aDistance[$key]." km
        </td><td class=\"table-list-cell\">".$this->aResult[$key].
        "</td><td class=\"table-list-cell\">
        <img src=\"".
        make_ref(get_path(),array(
        "page" => "nodes",
        "subpage" => "plot",
        "a_node" => $this->aID[$key],
        "b_node" => $this->bID[$key],
        "width" => 400,
        "height" => 150
        ))."\"/>
        </td>
        </tr>";
    }
    $this->result .= "</table></td></tr>
    <tr><td><br />
    <div style='text-align:center;font-weight:bold;'>Page ";

    $pgs = $nodesNum / $limitRows;
    $pg = (!isset($_REQUEST['pg']) || $_REQUEST['pg'] < 1?"1":$_REQUEST['pg']);
    for ($x=1; $x<=$pgs; $x++) {
      $this->result .= ($x == $pg?"$x ":"<a href='".
        make_ref(get_path(),array(
          "page" => "nodes",
          "subpage" => "list",
          "a_node" => $this->aID[$key],
          "pg" => ($x)))
        ."'>$x </a>");
    }

    $this->result .= "</div><br /><br /></td><td></td></tr></table>";
  } // End nodes_list

  function output() {
    return $this->result;
  }

  function imagelinethick($image, $x1, $y1, $x2, $y2, $color, $thick = 1) {
  
    /* this way it works well only for orthogonal lines
    imagesetthickness($image, $thick);
    return imageline($image, $x1, $y1, $x2, $y2, $color);
    */
    if ($thick == 1) {
      return imageline($image, round($x1), round($y1), round($x2), round($y2), $color);
    }
    $t = $thick / 2 - 0.5;
    if ($x1 == $x2 || $y1 == $y2) {
      return imagefilledrectangle($image, round(min($x1, $x2) - $t), round(min($y1, $y2) - $t), round(max($x1, $x2) + $t), round(max($y1, $y2) + $t), $color);
    }
    $k = ($y2 - $y1) / ($x2 - $x1); //y = kx + q
    $a = $t / sqrt(1 + pow($k, 2));
    $points = array(
      round($x1 - (1+$k)*$a), round($y1 + (1-$k)*$a),
      round($x1 - (1-$k)*$a), round($y1 - (1+$k)*$a),
      round($x2 + (1+$k)*$a), round($y2 - (1-$k)*$a),
      round($x2 + (1-$k)*$a), round($y2 + (1+$k)*$a),
    );
    imagefilledpolygon($image, $points, 4, $color);
    return imagepolygon($image, $points, 4, $color);
  
}
?>
