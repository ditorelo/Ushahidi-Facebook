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

	// NOT USED FOR FACEBOOK

	/*

	// Function that tests Twitter settings
	function test() 
	{
		$this->template = "";
		$this->auto_render = FALSE;

		// grab the necessary keys consumer key, secret, token, token secret
		$consumer_key = socialmedia_helper::getSetting('twitter_api_key');
		$consumer_secret = socialmedia_helper::getSetting('twitter_api_key_secret');
		$oauth_token = socialmedia_helper::getSetting('twitter_token');
		$oauth_token_secret = socialmedia_helper::getSetting('twitter_token_secret');

		$connection = new Twitter_Oauth($consumer_key, $consumer_secret, $oauth_token, $oauth_token_secret);
		$connection->decode_json = FALSE;
		$connection->get('account/verify_credentials');

		if ($connection->http_code == 200)
		{
			echo json_encode(array("status" => "success", "message" => Kohana::lang('ui_main.success')));
		}
		else
		{
			echo json_encode(array("status" => "error", "message" => Kohana::lang('ui_main.error') . " - " . Kohana::lang('ui_admin.error_twitter')));
		}
	}

	function index()
	{
		$this->template->content = new View('admin/settings/socialmedia/twitter');
		$this->template->content->title = Kohana::lang('ui_admin.settings');

		// setup and initialize form field names
		$form = array
		(
			'twitter_api_key' => '',
			'twitter_api_key_secret' => '',
			'twitter_token' => '',
			'twitter_token_secret' => '',
			'twitter_hashtags' => ''
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

			$post->add_rules('twitter_api_key','required', 'length[1,150]');
			$post->add_rules('twitter_api_key_secret','required', 'length[1,150]');
			$post->add_rules('twitter_token','required', 'length[1,150]');
			$post->add_rules('twitter_token_secret','required', 'length[1,150]');
			
			// Test to see if things passed the rule checks
			if ($post->validate())
			{
				// Yes! everything is valid
				socialmedia_helper::setSetting('twitter_api_key', $post->twitter_api_key);
				socialmedia_helper::setSetting('twitter_api_key_secret', $post->twitter_api_key_secret);
				socialmedia_helper::setSetting('twitter_token', $post->twitter_token);
				socialmedia_helper::setSetting('twitter_token_secret', $post->twitter_token_secret);

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
				'twitter_api_key' => socialmedia_helper::getSetting('twitter_api_key'),
				'twitter_api_key_secret' => socialmedia_helper::getSetting('twitter_api_key_secret'),
				'twitter_token' => socialmedia_helper::getSetting('twitter_token'),
				'twitter_token_secret' => socialmedia_helper::getSetting('twitter_token_secret'),
			);
		}
		
		$this->template->content->form = $form;
		$this->template->content->errors = $errors;
		$this->template->content->form_error = $form_error;
		$this->template->content->form_saved = $form_saved;

		// Javascript Header
		$this->themes->js = new View('admin/settings/socialmedia/twitter_js');

	}
	*/




}