<?php
/**
 * Plugin Name: 	AuctionGuru
 * Plugin URI:	http://www.gurucs.com/products/auctionguru
 * Description:	Enables the user to have auctions on their blog dynamically.
 * @version:	1.0.0
 * Author: 		J. Rocela (me@iamjamoy.com)
 * Author URI:	http://www.gurucs.com
 *
 * copyright (c) 2009  J. Rocela(me@iamjamoy.com)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
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
 */

//Plugin Core
define("AG_VERSION", "1.0.0");
define("AG_DEBUG", true);

//Plugin Hooks
add_action('admin_menu', 'auctionguru_menu');

// Plugin Methods
if((@$_POST['ag_auction_itemtitle'] || @$_POST['ag_fixed_itemtitle']) && !@$_GET['editID']){
  $title = (@$_POST['ag_auction_itemtitle'] != "") ? $_POST['ag_auction_itemtitle']: $_POST['ag_fixed_itemtitle'];
  $desc = (@$_POST['ag_auction_itemdesc'] != "") ? $_POST['ag_auction_itemdesc']: $_POST['ag_fixed_itemdesc'];
  $category = (@$_POST['ag_auction_category'] != "") ? $_POST['ag_auction_category']: $_POST['ag_fixed_category'];
  $startprice = (@$_POST['ag_auction_startingprice'] != "") ? $_POST['ag_auction_startingprice']: $_POST['ag_fixed_startingprice'];
  $reserve = (@$_POST['ag_auction_reserveprice'] != "") ? $_POST['ag_auction_reserveprice']: "null";
  $quantity = (@$_POST['ag_auction_quantity'] != "") ? $_POST['ag_auction_quantity']: $_POST['ag_fixed_quantity'];
  $duration = (@$_POST['ag_auction_duration'] != "") ? $_POST['ag_auction_duration']: $_POST['ag_fixed_duration'];
  $antisnipe = (@$_POST['ag_auction_antisnipe'] != "") ? $_POST['ag_auction_antisnipe']: "null";
  $type = (@$_POST['ag_auction_startingprice'] != "") ? 1: 0;
 
  if($type == 1){$starttime = strtotime($_POST['ag_auction_startingtime_mm'] . "/" . $_POST['ag_auction_startingtime_jj'] . "/" . $_POST['ag_auction_startingtime_aa'] . " " . $_POST['ag_auction_startingtime_hh'] . ":" . $_POST['ag_auction_startingtime_mn']);}
  else{$starttime = strtotime($_POST['ag_fixed_startingtime_mm'] . "/" . $_POST['ag_fixed_startingtime_jj'] . "/" . $_POST['ag_fixed_startingtime_aa'] . " " . $_POST['ag_fixed_startingtime_hh'] . ":" . $_POST['ag_fixed_startingtime_mn']);}
 
 $post = array(
	  'post_author' => 1,
	  'post_category' => category,
	  'post_content' => $desc,
	  'post_status' => 'publish',
	  'post_title' => $title
  );
  
  $post_id = @wp_insert_post($post);
  add_post_meta($post_id, 'type', $type);
  add_post_meta($post_id, 'startprice', $startprice);
  add_post_meta($post_id, 'quantity', $quantity);
  add_post_meta($post_id, 'duration', $duration);
  if($type == 1){
	add_post_meta($post_id, 'antisnipe', $antisnipe);
	add_post_meta($post_id, 'reserve', $reserve);
  }
}

//Plugin Methods
function auctionguru_menu(){
	add_menu_page('AuctionGuru', 'AuctionGuru', 8, __FILE__, 'auctionguru_page_main');
	add_submenu_page(__FILE__, 'AuctionGuru &rsaquo; Post New Auction', 'Post New Auction', 8, 'auctionguru/postnew', 'auctionguru_page_postnew');
	add_submenu_page(__FILE__, 'AuctionGuru &rsaquo; Mass Upload Auctions', 'Mass Upload Auctions', 8, 'auctionguru/mass', 'auctionguru_page_mass');
	add_submenu_page(__FILE__, 'AuctionGuru &rsaquo; Manage Auctions', 'Manage Auctions', 8, 'auctionguru/manage', 'auctionguru_page_manage');
	add_submenu_page(__FILE__, 'AuctionGuru &rsaquo; Settings', 'Settings', 8, 'auctionguru/settings', 'auctionguru_page_settings');
}

//Plugin Pages
function auctionguru_page_main(){include 'pages/main.html';}
function auctionguru_page_postnew(){include 'pages/postnew.html';}
function auctionguru_page_mass(){}
function auctionguru_page_manage(){}
function auctionguru_page_settings(){include 'pages/settings.html';}

?>