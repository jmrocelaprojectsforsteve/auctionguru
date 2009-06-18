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

// Plugin Procedures
if((@$_POST['ag_auction_itemtitle'] || @$_POST['ag_fixed_itemtitle']) && !@$_GET['editID']){
  $title = (@$_POST['ag_auction_itemtitle'] != "") ? $_POST['ag_auction_itemtitle']: $_POST['ag_fixed_itemtitle'];
  $desc = (@$_POST['ag_auction_itemdesc'] != "") ? $_POST['ag_auction_itemdesc']: $_POST['ag_fixed_itemdesc'];
  $category = (@$_POST['ag_auction_category'] != "") ? $_POST['ag_auction_category']: $_POST['ag_fixed_category'];
  $startprice = (@$_POST['ag_auction_startingprice'] != "") ? $_POST['ag_auction_startingprice']: $_POST['ag_fixed_startingprice'];
  $reserve = (@$_POST['ag_auction_reserveprice'] != "") ? $_POST['ag_auction_reserveprice']: "null";
  $quantity = (@$_POST['ag_auction_quantity'] != "") ? $_POST['ag_auction_quantity']: $_POST['ag_fixed_quantity'];
  $duration = (@$_POST['ag_auction_startingprice'] != "") ? $_POST['ag_auction_duration']: $_POST['ag_fixed_duration'];
  $antisnipe = (@$_POST['ag_auction_antisnipe'] != "") ? $_POST['ag_auction_antisnipe']: "null";
  $type = (@$_POST['ag_auction_startingprice'] != "") ? 'auction': 'fixed';
 
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
  add_post_meta($post_id, 'ag_is', 1);
  add_post_meta($post_id, 'ag_status', 'open');
  add_post_meta($post_id, 'ag_type', $type);
  add_post_meta($post_id, 'ag_startprice', $startprice);
  add_post_meta($post_id, 'ag_starttime', $starttime);
  add_post_meta($post_id, 'ag_quantity', $quantity);
  add_post_meta($post_id, 'ag_duration', $duration);
  if($type == 'auction'){
	add_post_meta($post_id, 'ag_antisnipe', $antisnipe);
	add_post_meta($post_id, 'ag_reserve', $reserve);
	add_post_meta($post_id, 'ag_currentbid', null);
	add_post_meta($post_id, 'ag_bids', array()); //still returns 1
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
function auctionguru_page_manage(){
  if(@$_GET['editID'] && !@$_POST){include 'pages/edit.html';}
  else{
    if(@$_POST['ag_auction_itemtitle']){
      $title = @$_POST['ag_auction_itemtitle'];
      $desc = @$_POST['ag_auction_itemdesc'];
      $startprice = @$_POST['ag_auction_startingprice'];
      $reserve = (@$_POST['ag_auction_reserveprice'] != "") ? $_POST['ag_auction_reserveprice']: "null";
      $quantity = @$_POST['ag_auction_quantity'];
      $duration = @$_POST['ag_auction_duration'];
      $antisnipe = (@$_POST['ag_auction_antisnipe'] != "") ? $_POST['ag_auction_antisnipe']: "null";
      $type = (@$_POST['ag_auction_reserveprice'] != "") ? 'auction': 'fixed';
 
      $starttime = strtotime($_POST['ag_auction_startingtime_mm'] . "/" . $_POST['ag_auction_startingtime_jj'] . "/" . $_POST['ag_auction_startingtime_aa'] . " " . $_POST['ag_auction_startingtime_hh'] . ":" . $_POST['ag_auction_startingtime_mn']);
      
      $id = $_GET['editID'];
	  
	  $post = array(
		'ID' => $_GET['editID'],
	    'post_author' => 1,
	    'post_category' => $category,
	    'post_content' => $desc,
	    'post_title' => $title
	  );

	  $post_id = @wp_update_post($post);
	  update_post_meta($post_id, 'ag_is', 1);
	  update_post_meta($post_id, 'ag_status', 'open');
	  update_post_meta($post_id, 'ag_type', $type);
	  update_post_meta($post_id, 'ag_startprice', $startprice);
	  update_post_meta($post_id, 'ag_starttime', $starttime);
	  update_post_meta($post_id, 'ag_quantity', $quantity);
	  update_post_meta($post_id, 'ag_duration', $duration);
	  if($type == 'auction'){
	    update_post_meta($post_id, 'ag_antisnipe', $antisnipe);
	    update_post_meta($post_id, 'ag_reserve', $reserve);
	  }
	}
    include 'pages/manage.html';
  }
}
function auctionguru_page_settings(){include 'pages/settings.html';}

//Miscellaneous Methods
function timeLeft($theTime){
  $now = strtotime("now");
  $timeLeft = $theTime - $now;
 
  if($timeLeft > 0){
    $days = floor($timeLeft/60/60/24);
    $hours = $timeLeft/60/60%24;
    $mins = $timeLeft/60%60;
    $secs = $timeLeft%60;
 
    if($days){
      $theText = $days . " Day(s)";
      if($hours){
        $theText .= ", " .$hours . " Hour(s) ";
      }
    }
    elseif($hours){
      $theText = $hours . " Hour(s)";
      if($mins){
        $theText .= ", " .$mins . " Minute(s) ";
      }
    }
    elseif($mins){
      $theText = $mins . " Minute(s)";
      if($secs){
        $theText .= ", " .$secs . " Second(s) ";
      }
    }
    elseif($secs){
      $theText = $secs . " Second(s)";
    }
  }
  else{
    $theText = "Expired";
  }
  return $theText;
}

?>