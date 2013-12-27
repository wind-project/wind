Wind
----

WiND is a Web application targeting at [Wireless Community Networks](http://en.wikipedia.org/wiki/Wireless_community_network).
It was created as a replacement for [NodeDB](http://www.nodedb.com/) by the members of [Athens Wireless Metropolitan Network](http://www.awmn.net/) located in Athens, Greece. It has evolved into much more as you can see below in the feature list.

WiND is distributed under [GNU Affero General Public License v3](http://www.gnu.org/licenses/agpl-3.0.html) where each piece of code remains under the copyright of their respective author. Everyone can see the source code and everyone can contribute to it.

## Caution ##
There have been changes in the Database. Please review the DB Schema before you try to use the current master source with your old installation.


## Features
 * Supports multiple users and multiple nodes per user
 * Supports controling of task authorization.
 * Stores all the node information a Wireless MAN will need: location, height, area, region, backbone & AP interfaces, roof view photos, subnets & hosts in a node etc.
 * Provides an easy (but powerful) way of searching for specific nodes
 * Using [NASA's SRTM data](http://www2.jpl.nasa.gov/srtm/), it graphs the _Line of Sight_, and _Fresnel Zone_ between two nodes and calculates _Free Space Loss_ for the distance between them
 * Uses [OpenLayers](http://openlayers.org/) to show the nodes and their links on map.
 * Can be used to manage the distribution of IP Ranges and forward/reverse DNS assigned to each node (_Hostmaster_)
 * Fully themeable interface (using simple (X)HTML templates)
 * Support for localication; Unicode/UTF-8 support
 * Integrates with BIND Nameserver for serving the DNS zones.
 * A WHOIS server is provided that serves the data using the [WHOIS protocol](http://www.faqs.org/rfcs/rfc3912.html)

## Documentation

You can find latest documentation online on the [wiki of project](https://github.com/wind-project/wind/wiki)
