<?php
	require '../vendor/autoload.php';
	use Parse\ParseClient;
	use Parse\ParseObject;
	use Parse\ParseQuery;

	ParseClient::initialize('pYVHYPd6vO4f3cVY7qv5xgu3z1Ov9sKa5CJ0W2QR', 'z1NxzK18fRMxjpdXnj4Cx493v4LnteJewhEQr9PL', 'nSvembfd30ZafKOHCzWd1T7aFBHazTfbdvajPgN4');
	$client = new Freebird\Services\freebird\Client();
	$client->init_bearer_token('r0WFx0QS4w2NUCCELvG2KENUW', 'UwnC01gDUCTcRVk2nweJaWk6aE50yvQfKUbyFqFP6ax6Lwkt4G');
	
	$response = $client->api_request('statuses/user_timeline.json', array('screen_name' => 'appreviewtimes', 'count' => 1, 'trim_user' => true, 'exclude_replies' => true, 'include_rts' => false));
	$json = json_decode($response);

	$query = new ParseQuery("reviewtimes");
	$query->equalTo("status_id",$json[0]->id_str);
	$statusObj = $query->first();
	
	if (!$statusObj) {
		$pos = strpos($json[0]->text, "iOS");
		$days = substr($json[0]->text, $pos, 10);
		$array = explode(" ", $days);
		$ios_days = $array[1];
		
		$pos = strpos($json[0]->text, "Mac");
		$days = substr($json[0]->text, $pos, 10);
		$array = explode(" ", $days);
		$mac_days = $array[1];
		
		$newStatus = new ParseObject('reviewtimes');
		$newStatus->set('ios_days',intval($ios_days,10));
		$newStatus->set('mac_days',intval($mac_days,10));
		$newStatus->set('status_id',$json[0]->id_str);
		
		try {
			$newStatus->save();
			echo 'New object: ' . $newStatus->getObjectId();
		} catch (ParseException $ex) {  
		  	echo 'Error: ' + $ex->getMessage();
		}
	} else {
		echo 'Object Skipped';
	}
?>