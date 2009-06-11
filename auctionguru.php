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

//Plugin Tables
define("AG_AUCTIONTABLE", $wpdb->prefix . 'auctionguru_auctions');
define("AG_BIDTABLE", $wpdb->prefix . 'auctionguru_bids');

//Plugin Activation
register_activation_hook(__FILE__, 'auctionguru_activate');
function auctionguru_activate(){
	global $wpdb;
	
	$installSQL_auctiontable = "CREATE TABLE IF NOT EXISTS `" . AG_AUCTIONTABLE . "` (`id` bigint(20) NOT NULL auto_increment,`title` varchar(255) NOT NULL,`description` mediumtext NOT NULL,`starting_price` decimal(10,2) NOT NULL,`reserve_price` decimal(10,2) default NULL,`quantity` int(11) NOT NULL,`starting_time` char(10) NOT NULL,`duration` char(5) NOT NULL,`anti_snipe` int(11) default NULL,`type` tinyint(1) NOT NULL default '1' COMMENT '1 for auction, 0 for fixed price',`status` tinyint(1) NOT NULL default '1',PRIMARY KEY  (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=1 ;";
	$wpdb->query($installSQL_auctiontable);
	$installSQL_bidtable = "CREATE TABLE IF NOT EXISTS `" . AG_BIDTABLE . "` (`id` bigint(20) NOT NULL auto_increment,`auction_id` bigint(20) NOT NULL,`timestamp` char(10) NOT NULL,`name` varchar(60) NOT NULL,`email` varchar(255) NOT NULL,`bid` decimal(10,2) NOT NULL,PRIMARY KEY  (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
	$wpdb->query($installSQL_bidtable);
}

//Plugin Hooks
add_action('admin_menu', 'auctionguru_menu');

//Plugin Methods
function auctionguru_menu(){
	add_menu_page('AuctionGuru', 'AuctionGuru', 8, __FILE__, 'auctionguru_page_main');
	add_submenu_page(__FILE__, 'AuctionGuru &rsaquo; Post New Auction', 'Post New Auction', 8, 'auctionguru/postnew', 'auctionguru_page_postnew');
	add_submenu_page(__FILE__, 'AuctionGuru &rsaquo; Manage Auctions', 'Manage Auctions', 8, 'auctionguru/manage', 'auctionguru_page_manage');
	add_submenu_page(__FILE__, 'AuctionGuru &rsaquo; Settings', 'Settings', 8, 'auctionguru/settings', 'auctionguru_page_settings');
}

//Plugin Pages
function auctionguru_page_main(){include 'pages/main.html';}
function auctionguru_page_postnew(){include 'pages/postnew.html';}
function auctionguru_page_manage(){global $wpdb;include 'pages/manage.html';}
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
		$theText = "The time is already in the past!";
	}
	return $theText;
}


?>