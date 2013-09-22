<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Facebook Controller
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

class Socialmedia_Facebook_Controller extends Controller
{
	const API_URL = "https://graph.facebook.com/search?";

	var $service = null;

	public function __construct() {
		$this->service = ORM::factory("Service")
								->where("service_name", "SocialMedia Facebook")
								->find();
	}

	/**
	* Search function for Facebook
	* @param array $keywords Keyworkds for search
	* @param array[lat,lon,radius] $location Array with Geo point and radius to constrain search results
	* @param string $since yyyy-mm-dd Date to be used as since date on search
	*/
	public function search($keywords, $location, $since)
	{
		require dirname(__DIR__) . '/libraries/facebook-php-sdk-master/src/facebook.php';

		$facebook = new Facebook(array(
				"appId"		=> "126280780764167",
				"secret"	=> "d86997a6a2f697702e5ac1111002e250"
			));

		foreach ($keywords as $keyword)
		{
			$settings = ORM::factory('socialmedia_settings')->where('setting', 'facebook_last_id_' . $keyword)->find();

			$data = array(
					"type"		=> "post",
					"q"			=> $keyword,
					"limit"		=> 25,
				);

			if (empty($settings->value)) {
				if (! empty($since)) {
					$data["since"] = strtotime($since);
				}
			} else {
				$data["since"] = $settings->value;
			}

			$result = $facebook->api("/search?" . http_build_query($data));

			// parse our lovely results
			$result = $this->parse($result, (is_null($settings->value) ? 0 : $settings->value));

			// Save new highest id
			$settings->setting =  'facebook_last_id_' . $keyword;
			$settings->value = $result["highest_date"];
			$settings->save();
		}
	}

	/**
	* Parses API results and inserts them on the database
	* @param array $array_result json arrayed result
	* @param int $highest_id Current highest message ID on the database
	* @return int highest_date New highest data after parsing results
	*/
	public function parse($array_result, $highest_date = 0) {
		$statuses = $array_result["data"];

		foreach ($statuses as $s) {
			$entry = Socialmedia_Message_Model::getMessage($s["id"], $this->service->id);

			// don't resave messages we already have
			if (! $entry->loaded) 
			{
				// set message data
				$entry->setServiceId($this->service->id);
				$entry->setMessageFrom($this->service->service_name);				
				$entry->setMessageLevel($entry::STATUS_TOREVIEW);
				$entry->setMessageId($s["id"]);
				$entry->setMessageDetail($s["message"]);
				$date = strtotime($s["created_time"]);
				$entry->setMessageDate(date("Y-m-d H:i:s", $date));

				$entry->setAuthor(
					$s["from"]["id"], 
					$s["from"]["name"],
					null,
					null
				);


				// saves entities in array for later
				$media = array();
				if (isset($s["link"])) 
				{
					$media["url"][] = $s["link"];
				}

				$media = array();
				if (isset($s["picture"])) 
				{
					$media["url"][] = $s["picture"];
				}				

				// geo data
				if (isset($s["location"]))
				{
					var_dump($s["place"]);
					die();

					//twitter uses long,lat
					$entry->setCoordinates($s["place"]["latitude"], $s["coordinates"]["coordinates"][0]);
				}

				// save message and assign data to it
				$entry->save();

				//$entry->addData("url", "http://twitter.com/" . $s["user"]["screen_name"] . "/status/" . $s["id_str"]);
				$entry->addAssets($media);

				if ($date > $highest_date) {
					$highest_date = $date;
				}				
			}
		}

		return array(
				"highest_date"		=> $highest_date
			);
	}
}
