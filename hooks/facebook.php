<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Socialmedia Twitter Hooks
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author	   Ushahidi Team <team@ushahidi.com> 
 * @package	   Ushahidi - http://source.ushahididev.com
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license	   http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL) 
 */

class socialmediafacebook {
	
	/**
	 * Registers the main event add method
	 */
	public function __construct()
	{
		// Hook into routing
		Event::add('system.pre_controller', array($this, 'add'));
	}

	/**
	 * Adds all the events to the main Social Media bits
	 */
	public function add()
	{
		// Only add the events if we are on parent controller
		if (in_array("socialmedia", Router::$segments) !== false && in_array("settings", Router::$segments) !== false)
		{
			Event::add('socialmedia.settings_subtabs', array($this, '_socialmedia'));
		}
	}

	public function _socialmedia()
	{
		$this_sub_page = Event::$data;
		echo "<li><a href='" . url::site() . "admin/settings/socialmedia/facebook'" . ($this_sub_page != "facebook" ? null : " class='active'") . ">Facebook</a></li>";
	}
}
new socialmediafacebook;