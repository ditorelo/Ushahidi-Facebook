<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Twitter Settings Controller
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author	   Ushahidi Team <team@ushahidi.com> 
 * @package    Ushahidi - http://source.ushahididev.com
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL) 
*
*/

class Facebook_Controller extends Admin_Controller {

	function __construct()
	{
		parent::__construct();
		$this->template->this_page = 'settings';

		// If user doesn't have access, redirect to dashboard
		if ( ! $this->auth->has_permission("manage"))
		{
			url::redirect(url::site().'admin/dashboard');
		}
	}

	function index()
	{
		$this->template->content = new View('admin/settings/socialmedia/facebook');
		$this->template->content->title = Kohana::lang('ui_admin.settings');

		// setup and initialize form field names
		$form = array
		(
			'facebook_app_secret' => '',
			'facebook_app_id' => '',
		);
		//	Copy the form as errors, so the errors will be stored with keys
		//	corresponding to the form field names
		$errors = $form;
		$form_error = FALSE;
		$form_saved = FALSE;

		// check, has the form been submitted, if so, setup validation
		if ($_POST)
		{
			// Instantiate Validation, use $post, so we don't overwrite $_POST
			// fields with our own things
			$post = new Validation($_POST);

			// Add some filters
			$post->pre_filter('trim', TRUE);

			// Add some rules, the input field, followed by a list of checks, carried out in order

			$post->add_rules('facebook_app_id','required', 'length[1,150]');
			$post->add_rules('facebook_app_secret','required', 'length[1,150]');
			
			// Test to see if things passed the rule checks
			if ($post->validate())
			{
				// Yes! everything is valid
				socialmedia_helper::setSetting('facebook_app_id', $post->facebook_app_id);
				socialmedia_helper::setSetting('facebook_app_secret', $post->facebook_app_secret);

				// Delete Settings Cache
				$this->cache->delete('settings');
				$this->cache->delete_tag('settings');

				// Everything is A-Okay!
				$form_saved = TRUE;

				// repopulate the form fields
				$form = arr::overwrite($form, $post->as_array());

			}

			// No! We have validation errors, we need to show the form again,
			// with the errors
			else
			{
				// repopulate the form fields
				$form = arr::overwrite($form, $post->as_array());

				// populate the error fields, if any
				$errors = arr::overwrite($errors, $post->errors('twitter'));
				$form_error = TRUE;
			}
		}
		else
		{
			$form = array
			(
				'facebook_app_id' => socialmedia_helper::getSetting('facebook_api_id'),
				'facebook_app_secret' => socialmedia_helper::getSetting('facebook_app_secret'),
			);
		}
		
		$this->template->content->form = $form;
		$this->template->content->errors = $errors;
		$this->template->content->form_error = $form_error;
		$this->template->content->form_saved = $form_saved;

		// Javascript Header
		$this->themes->js = new View('admin/settings/socialmedia/facebook_js');

	}




}