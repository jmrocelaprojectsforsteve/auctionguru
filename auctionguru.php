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

if(isset($_GET['auctionguru_request'])) {

} else {
	add_action('admin_menu', 'auctionguru_menu');
}

//----------------------------------------------------------------------------
function auctionguru_menu(){
	add_menu_page('AuctionGuru &rsaquo; Main', 'AuctionGuru', 8, __FILE__, 'auctionguru_page_main');
	add_submenu_page(__FILE__, 'AuctionGuru &rsaquo; Post New Auction', 'Post New Auction', 8, 'auctionguru/postnew', 'auctionguru_page_new');
	add_submenu_page(__FILE__, 'AuctionGuru &rsaquo; Manage Auctions', 'Manage Auctions', 8, 'auctionguru/manage', 'auctionguru_page_manage');
	add_submenu_page(__FILE__, 'AuctionGuru &rsaquo; Settings', 'Settings', 8, 'auctionguru/settings', 'auctionguru_page_settings');
}

function auctionguru_page_main(){
	?>
		<div id="wpbody-content">
			<div class="wrap">
				<div id="icon-tools" class="icon32"><br /></div>
				<h2>AuctionGuru</h2>
				<div class="clear"></div>
				<div>
					<p>Some Content to Explain AuctionGuru</p>
				</div>
			</div>
		</div>
	<?php
}

function auctionguru_page_new(){
	?>
		<div id="wpbody-content">
			<div class="wrap">
				<div id="icon-tools" class="icon32"><br /></div>
				<h2>AuctionGuru &rsaquo; Post New Auction</h2>
				<div class="clear"></div>
				
				<script type="text/javascript">
					jQuery(document).ready(function(){
						jQuery('.form-table').hide();
						jQuery('#ag_auctiontable').show();
						jQuery('#ag_newauction').click(function(){
							jQuery('.form-table').hide();
							jQuery('#ag_auctiontable').show();
							jQuery('#ag_newauction').attr('style','display:block;float:left;width:50%;text-align:center;padding:4px 0;color:#000;text-decoration:none;');
							jQuery('#ag_newfixedprice_link').attr('style','display:block;float:left;width:50%;text-align:center;padding:4px 0;border:1px solid #c0c0c0;border-top:0;border-right:0;margin-left:-1px;background:#fefefe;color:#c0c0c0;text-decoration:none;');
						});
						jQuery('#ag_newfixedprice_link').click(function(){
							jQuery('.form-table').hide();
							jQuery('#ag_fixedpricetable').show();
							jQuery('#ag_newfixedprice_link').attr('style','display:block;float:left;width:50%;text-align:center;padding:4px 0;color:#000;text-decoration:none;');
							jQuery('#ag_newauction').attr('style','display:block;float:left;width:50%;text-align:center;padding:4px 0;border:1px solid #c0c0c0;border-top:0;border-left:0;margin-right:-1px;background:#fefefe;color:#c0c0c0;text-decoration:none;');
						});
					});
				</script>
				
				<div style="border:1px solid #c0c0c0;background:#efefef;width:724px;">
				<a href="#ag_newauction_link" class="ag_newauction" id="ag_newauction" style="display:block;float:left;width:50%;text-align:center;padding:4px 0;color:#000;text-decoration:none;">Auction</a>
				<a href="#ag_newfixedprice_link" class="ag_newauction" id="ag_newfixedprice_link" style="display:block;float:left;width:50%;text-align:center;padding:4px 0;border:1px solid #c0c0c0;border-top:0;border-right:0;margin-left:-1px;background:#fefefe;color:#c0c0c0;text-decoration:none;">Fixed Price</a>
				<div class="clear"></div>
				
				<table cellspacing="0" cellpadding="0" border="0" style="margin:8px 0;" class="form-table" id="ag_auctiontable">
					<tr valign="top">
					<td scope="row" colspan="2"><label for="ag_auction_itemtitle">Item Title</label><br/><input name="ag_auction_itemtitle" id="ag_auction_itemtitle" value="" type="text" style="width:700px;"/></td>
					</tr>
					<tr valign="top">
					<td scope="row" colspan="2"><label for="ag_auction_itemdesc">Item Description</label><br/><textarea name="ag_auction_itemdesc" id="ag_auction_itemdesc" style="width:700px;height:120px;"></textarea></td>
					</tr>
					<tr valign="top">
					<td scope="row" style="padding:8px 14px;width:120px;"><label for="ag_auction_startingprice">Starting Price  <?php echo (get_option('ag_currency')) ? '(' . get_option('ag_currency') . ')': ''; ?></label></td>
					<td style="padding:4px;"><input name="ag_auction_startingprice" id="ag_auction_startingprice" type="text" style="width:120px;"/></td>
					</tr>
					<tr valign="top">
					<td scope="row" style="padding:8px 14px;width:120px;"><label for="ag_auction_reserveprice">Reserve Price <?php echo (get_option('ag_currency')) ? '(' . get_option('ag_currency') . ')': ''; ?></label></td>
					<td style="padding:4px;"><input name="ag_auction_reserveprice" id="ag_auction_reserveprice" type="text" style="width:120px;"/></td>
					</tr>
					<tr valign="top">
					<td scope="row" style="padding:8px 14px;width:120px;"><label for="ag_auction_quantity">Quantity</label></td>
					<td style="padding:4px;"><input name="ag_auction_quantity" id="ag_auction_quantity" type="text" style="width:42px;"/></td>
					</tr>
					<tr valign="top">
					<td scope="row" style="padding:8px 14px;width:120px;"><label for="ag_auction_startingtime">Starting Time</label></td>
					<td style="padding:4px;">
						<select id="ag_auction_startingtime" name="ag_auction_startingtime_mm" tabindex="4">
							<option value="01"<?php echo (date('n') == 1) ? ' selected="selected"': ''; ?>>Jan</option>
							<option value="02"<?php echo (date('n') == 2) ? ' selected="selected"': ''; ?>>Feb</option>
							<option value="03"<?php echo (date('n') == 3) ? ' selected="selected"': ''; ?>>Mar</option>
							<option value="04"<?php echo (date('n') == 4) ? ' selected="selected"': ''; ?>>Apr</option>
							<option value="05"<?php echo (date('n') == 5) ? ' selected="selected"': ''; ?>>May</option>
							<option value="06"<?php echo (date('n') == 6) ? ' selected="selected"': ''; ?>>Jun</option>
							<option value="07"<?php echo (date('n') == 7) ? ' selected="selected"': ''; ?>>Jul</option>
							<option value="08"<?php echo (date('n') == 8) ? ' selected="selected"': ''; ?>>Aug</option>
							<option value="09"<?php echo (date('n') == 9) ? ' selected="selected"': ''; ?>>Sep</option>
							<option value="10"<?php echo (date('n') == 10) ? ' selected="selected"': ''; ?>>Oct</option>
							<option value="11"<?php echo (date('n') == 11) ? ' selected="selected"': ''; ?>>Nov</option>
							<option value="12"<?php echo (date('n') == 12) ? ' selected="selected"': ''; ?>>Dec</option>
						</select>
						<input id="jj" name="ag_auction_startingtime_jj" value="<?php echo date('d'); ?>" size="2" maxlength="2" tabindex="4" autocomplete="off" type="text">,
						<input id="aa" name="ag_auction_startingtime_aa" value="<?php echo date('Y'); ?>" size="4" maxlength="5" tabindex="4" autocomplete="off" type="text">
						@ <input id="hh" name="ag_auction_startingtime_hh" value="<?php echo date('H'); ?>" size="2" maxlength="2" tabindex="4" autocomplete="off" type="text">
						: <input id="mn" name="ag_auction_startingtime_mn" value="<?php echo date('i'); ?>" size="2" maxlength="2" tabindex="4" autocomplete="off" type="text">
					</td>
					</tr>
					<tr valign="top">
					<td scope="row" style="padding:8px 14px;width:120px;"><label for="ag_auction_duration">Duration</label></td>
					<td style="padding:4px;">
						<select id="ag_auction_duration" name="ag_auction_duration">
							<?php 
								$option = get_option('ag_duration');
								if($option){
									$options = explode(",", $option);
									foreach($options as $option){
										$option = trim($option);
										if(substr($option,-1) == '0'){
											echo '<option>Run forever, until closed.</option>';
										}elseif(substr($option,-1) == 'h'){
											if(substr($option,-3,2)){
												echo '<option>' . substr($option,-3,2) . ' Hours</option>';
											}else{
												$s = (substr($option,-2,1) == 1) ? '': 's';
												echo '<option>' . substr($option,-2,1) . ' Hour' . $s . '</option>';
											}
										}elseif(substr($option,-1) == 'd'){
											if(substr($option,-3,2)){
												echo '<option>' . substr($option,-3,2) . ' Days</option>';
											}else{
												$s = (substr($option,-2,1) == 1) ? '': 's';
												echo '<option>' . substr($option,-2,1) . ' Day' . $s . '</option>';
											}
										}
									}
								}
								else{
									echo '<option value="0">Run forever, until closed.</option>';
								}
							?>
						</select>
					</td>
					</tr>
					<tr valign="top">
					<td scope="row" style="padding:8px 14px;width:120px;"><label for="ag_auction_antisnipe">Anti-Snipe</label></td>
					<td style="padding:4px;"><input name="ag_auction_antisnipe" id="ag_auction_antisnipe" type="checkbox" value="1"/></td>
					</tr>
					<tr valign="top">
					<td scope="row" style="padding:8px 14px;width:120px;" colspan="2"><input type="submit" value="Add this Auction" class="button"/></td>
					</tr>
				</table>

				<table cellspacing="0" cellpadding="0" border="0" style="margin:8px 0;" class="form-table" id="ag_fixedpricetable">
					<tr valign="top">
					<td scope="row" colspan="2"><label for="ag_fixed_itemtitle">Item Title</label><br/><input name="ag_fixed_itemtitle" id="ag_fixed_itemtitle" value="" type="text" style="width:700px;"/></td>
					</tr>
					<tr valign="top">
					<td scope="row" colspan="2"><label for="ag_fixed_itemdesc">Item Description</label><br/><textarea name="ag_fixed_itemdesc" id="ag_fixed_itemdesc" style="width:700px;height:120px;"></textarea></td>
					</tr>
					<tr valign="top">
					<td scope="row" style="padding:8px 14px;width:120px;"><label for="ag_fixed_startingprice">Starting Price  <?php echo (get_option('ag_currency')) ? '(' . get_option('ag_currency') . ')': ''; ?></label></td>
					<td style="padding:4px;"><input name="ag_fixed_startingprice" id="ag_fixed_startingprice" type="text" style="width:120px;"/></td>
					</tr>
					<tr valign="top">
					<td scope="row" style="padding:8px 14px;width:120px;"><label for="ag_fixed_quantity">Quantity</label></td>
					<td style="padding:4px;"><input name="ag_fixed_quantity" id="ag_fixed_quantity" type="text" style="width:42px;"/></td>
					</tr>
					<tr valign="top">
					<td scope="row" style="padding:8px 14px;width:120px;"><label for="ag_fixed_startingtime">Starting Time</label></td>
					<td style="padding:4px;">
						<select id="ag_fixed_startingtime" name="ag_fixed_startingtime_mm" tabindex="4">
							<option value="01"<?php echo (date('n') == 1) ? ' selected="selected"': ''; ?>>Jan</option>
							<option value="02"<?php echo (date('n') == 2) ? ' selected="selected"': ''; ?>>Feb</option>
							<option value="03"<?php echo (date('n') == 3) ? ' selected="selected"': ''; ?>>Mar</option>
							<option value="04"<?php echo (date('n') == 4) ? ' selected="selected"': ''; ?>>Apr</option>
							<option value="05"<?php echo (date('n') == 5) ? ' selected="selected"': ''; ?>>May</option>
							<option value="06"<?php echo (date('n') == 6) ? ' selected="selected"': ''; ?>>Jun</option>
							<option value="07"<?php echo (date('n') == 7) ? ' selected="selected"': ''; ?>>Jul</option>
							<option value="08"<?php echo (date('n') == 8) ? ' selected="selected"': ''; ?>>Aug</option>
							<option value="09"<?php echo (date('n') == 9) ? ' selected="selected"': ''; ?>>Sep</option>
							<option value="10"<?php echo (date('n') == 10) ? ' selected="selected"': ''; ?>>Oct</option>
							<option value="11"<?php echo (date('n') == 11) ? ' selected="selected"': ''; ?>>Nov</option>
							<option value="12"<?php echo (date('n') == 12) ? ' selected="selected"': ''; ?>>Dec</option>
						</select>
						<input id="jj" name="ag_fixed_startingtime_jj" value="<?php echo date('d'); ?>" size="2" maxlength="2" tabindex="4" autocomplete="off" type="text">,
						<input id="aa" name="ag_fixed_startingtime_aa" value="<?php echo date('Y'); ?>" size="4" maxlength="5" tabindex="4" autocomplete="off" type="text">
						@ <input id="hh" name="ag_fixed_startingtime_hh" value="<?php echo date('H'); ?>" size="2" maxlength="2" tabindex="4" autocomplete="off" type="text">
						: <input id="mn" name="ag_fixed_startingtime_mn" value="<?php echo date('i'); ?>" size="2" maxlength="2" tabindex="4" autocomplete="off" type="text">
					</td>
					</tr>
					<tr valign="top">
					<td scope="row" style="padding:8px 14px;width:120px;"><label for="ag_fixed_duration">Duration</label></td>
					<td style="padding:4px;">
						<select id="ag_fixed_duration" name="ag_fixed_duration">
							<?php 
								$option = get_option('ag_duration');
								if($option){
									$options = explode(",", $option);
									foreach($options as $option){
										$option = trim($option);
										if(substr($option,-1) == '0'){
											echo '<option>Run forever, until closed.</option>';
										}elseif(substr($option,-1) == 'h'){
											if(substr($option,-3,2)){
												echo '<option>' . substr($option,-3,2) . ' Hours</option>';
											}else{
												$s = (substr($option,-2,1) == 1) ? '': 's';
												echo '<option>' . substr($option,-2,1) . ' Hour' . $s . '</option>';
											}
										}elseif(substr($option,-1) == 'd'){
											if(substr($option,-3,2)){
												echo '<option>' . substr($option,-3,2) . ' Days</option>';
											}else{
												$s = (substr($option,-2,1) == 1) ? '': 's';
												echo '<option>' . substr($option,-2,1) . ' Day' . $s . '</option>';
											}
										}
									}
								}
								else{
									echo '<option value="0">Run forever, until closed.</option>';
								}
							?>
						</select>
					</td>
					</tr>
					<tr valign="top">
					<td scope="row" style="padding:8px 14px;width:120px;" colspan="2"><input type="submit" value="Add this Auction" class="button"/></td>
					</tr>
				</table>

				
				</div>
				<center style="font-size:80%;margin-top:8px;">This Plugin is brought to you by: <a href="http://www.gurucs.com/products/auctionguru">Guru Consulting Services</a></center>
			</div>
		</div>
	<?php
}

function auctionguru_page_manage(){
	?>
	asdasd
	<?php
}

function auctionguru_page_settings(){
	?>
		<div id="wpbody-content">
			<div class="wrap">
				<div id="icon-tools" class="icon32"><br /></div>
				<h2>AuctionGuru &rsaquo; Settings</h2>
				<div class="tool-box" style="margin-bottom:0;">
					<p>Define AuctionGuru's configuration below.</p>
				</div>	
				<div class="clear"></div>
				<form method="post" action="options.php">
				<?php
					if(@$_GET['updated'] == "true"){
				?>
					<div id="message" class="updated fade"><p><strong>Settings saved.</strong></p></div>
				<?php
					}
				?>
				<?php wp_nonce_field('update-options'); ?>
				<table cellspacing="0" cellpadding="0" border="0" style="margin:8px 0;width:590px;float:left;" class="form-table">
					<tr valign="top" style="padding:4px;">
					<th scope="row" style="padding:10px;"><label for="ag_duration">Durations</label></th>
					<td style="padding:4px;"><input name="ag_duration" id="ag_duration" onblur="closeTooltip();" onfocus="showTooltip('duration');" value="<?php echo get_option('ag_duration'); ?>" type="text" style="width:300px;"/></td>
					</tr>
					<tr valign="top">
					<th scope="row" style="padding:10px;"><label for="ag_currency">Currency Symbol</label></th>
					<td style="padding:4px;"><input name="ag_currency" onblur="closeTooltip();" onfocus="showTooltip('currency');" id="ag_currency" value="<?php echo get_option('ag_currency'); ?>" type="text" style="width:24px;"/></td>
					</tr>
					<tr valign="top">
					<th scope="row" style="padding:10px;"><label for="ag_antisnipe">Anti-Snipe</label></th>
					<td style="padding:4px;">Extend auction for for <input name="ag_antisnipe" id="ag_antisnipe" onblur="closeTooltip();" onfocus="showTooltip('sniping');" value="<?php echo get_option('ag_antisnipe'); ?>" type="text" style="width:24px;"/> minute(s) if a new bid<br/>Is recieved within <input name="ag_antisnipewithin" id="ag_antisnipewithin" onblur="closeTooltip();" onfocus="showTooltip('sniping');" value="<?php echo get_option('ag_antisnipewithin'); ?>" type="text" style="width:24px;"/> minute(s) of ending time.</td>
					</tr>
					<tr valign="top" style="padding:4px;">
					<th scope="row" style="padding:10px;"><label for="ag_paypal">Paypal Email</label></th>
					<td style="padding:4px;"><input name="ag_paypal" id="ag_paypal" onblur="closeTooltip();" onfocus="showTooltip('paypal');" value="<?php echo get_option('ag_paypal'); ?>" type="text" style="width:180px;"/></td>
					</tr>
				</table>
				<input type="hidden" name="action" value="update" />
				<input type="hidden" name="page_options" value="ag_duration,ag_currency,ag_antisnipe,ag_antisnipewithin,ag_paypal" />
				<div id="tooltip" style="float:left;width:328px;">
					<div style="padding:8px;background:#fffbcc;-moz-border-radius:6px;" id="duration" class="settingsTooltip">
						<p>The plugin shall interpret:</p>
						<p>0 = Forever</p>
						<p>#h = number of hours</p>
						<p>#d = number of days</p>
					</div>
					<div style="padding:8px;margin-top:34px;background:#fffbcc;-moz-border-radius:6px;" id="currency" class="settingsTooltip">
						<p>The Currency Symbol you are going to use.</p>
					</div>
					<div style="padding:8px;background:#fffbcc;-moz-border-radius:6px;" id="sniping" class="settingsTooltip">
						<p>if a new bid is received (for auction type only) within 2 minutes of ending time, 1 minute is added to the ending time.</p>
						<p>For example, let's say ending time is 5:00 PM.</p>
						<p>If a bid is received at 4:48 PM, then new ending time is 5:01 PM.</p>
						<p>If another bid is received at 5:00 PM, then new ending time is 5:02 PM.</p>
						<p>This calculation shall be down to the seconds.</p>
					</div>
					<div style="padding:8px;margin-top:124px;background:#fffbcc;-moz-border-radius:6px;" id="paypal" class="settingsTooltip">
						<p>The Plugin will automatically generate the needed paypal buttons for easy transactions.</p>
					</div>
				</div>
				<div class="clear"></div>
				<input type="submit" value="Save Changes" class="button-primary"/>
				</form>
				<center style="font-size:80%;margin-top:8px;">This Plugin is brought to you by: <a href="http://www.gurucs.com/products/auctionguru">Guru Consulting Services</a></center>
			</div>
			<script type="text/javascript">
				closeTooltip();
				function showTooltip(where){
					jQuery('.settingsTooltip').hide();
					jQuery('#' + where).show();
				}
				function closeTooltip(){
					jQuery('.settingsTooltip').hide();
				}
			</script>
		</div>	
	<?php
}

?>