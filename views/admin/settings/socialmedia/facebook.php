<?php 
/**
 * Twitter Settings view page.
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     Ushahidi Team <team@ushahidi.com> 
 * @package    Ushahidi - http://source.ushahididev.com
 * @module     Facebook Settings View
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL) 
 */
?>
			<div class="bg">
				<h2>
					<?php admin::settings_subtabs("socialmedia"); ?>
				</h2>
				<?php print form::open(); ?>
				<!-- tabs -->
				<div class="tabs">
					<!-- tabset -->
					<ul class="tabset">
						<?php
						$dispatch = Dispatch::controller("SocialMedia", "admin/settings");
						if ($dispatch instanceof Dispatch) $run = $dispatch->method('subtabs', 'facebook');
						?>
					</ul>
					<!-- /tabset -->

					<!-- tab -->
					<div class="tab">
						<ul>
							<li><input style="margin:0;" type="submit" class="save-rep-btn" value="<?php echo Kohana::lang('ui_admin.save_settings');?>" /></li>
						</ul>
					</div>
					<!-- /tab -->

				</div>
				<!-- /tabs -->

				<div class="report-form">
					<?php
					if ($form_error) {
					?>
						<!-- red-box -->
						<div class="red-box">
							<h3><?php echo Kohana::lang('ui_main.error');?></h3>
							<ul>
							<?php
							foreach ($errors as $error_item => $error_description)
							{
								// print "<li>" . $error_description . "</li>";
								print (!$error_description) ? '' : "<li>" . $error_description . "</li>";
							}
							?>
							</ul>
						</div>
					<?php
					}

					if ($form_saved) {
					?>
						<!-- green-box -->
						<div class="green-box">
							<h3><?php echo Kohana::lang('ui_main.configuration_saved');?></h3>
						</div>
					<?php
					}
					?>				
					<!-- column -->
		
					<div class="sms_holder">
						<?php /*<div class="row">
							<p><?php echo Kohana::lang('settings.twitter.description');?>:<br><a href="https://twitter.com/oauth_clients/" target="_blank">https://twitter.com/oauth_clients/</a></p>
							<p>For instructions see <a
							href="https://wiki.ushahidi.com/display/WIKI/Configuring+Twitter+on+a+deployment/"target="_blank">https://wiki.ushahidi.com/display/WIKI/Configuring+Twitter+on+a+deployment</a></h4>
						</div>*/ ?>
						<div class="row">
							<h4><?php echo Kohana::lang('settings.facebook.app_id');?>:</h4>
							<?php print form::input('facebook_app_id', $form['facebook_app_id'], ' class="text long2"'); ?>
						</div>
						<div class="row">
							<h4><?php echo Kohana::lang('settings.facebook.app_secret');?>:</h4>
							<?php print form::input('facebook_app_secret',$form['facebook_app_secret'],'class="text long2"'); ?>
						</div>
					</div>
				</div>
				<?php print form::close(); ?>
			</div>
		</div>