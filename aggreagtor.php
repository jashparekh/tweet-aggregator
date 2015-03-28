<?php
	require_once('src/TwitterAPIExchange.php');

	$mysqli = new mysqli("YOUR HOST", "USER", "PASSWORD", "DATABASE NAME");
	$hastag = "CWC";
	
	// Get Tweets

	//Get these details from https://apps.twitter.com/
	$settings = array(
	'oauth_access_token' => "ACCESS TOKEN",
		'oauth_access_token_secret' => "ACCESS TOKEN SECRET",
		'consumer_key' => "CONSUMER KEY",
		'consumer_secret' => "CONSUMER SECRET"
	);
	$url = "https://api.twitter.com/1.1/search/tweets.json";
	$requestMethod = "GET";
	$getfield = '?q=#'.$hastag.'&count=100&include_entities=true&with_twitter_user_id=true&result_type=recent';
	
	$twitter = new TwitterAPIExchange($settings);
	$string = json_decode($twitter->setGetfield($getfield)
	->buildOauth($url, $requestMethod)
	->performRequest(),$assoc = TRUE);
	
	if($string["errors"][0]["message"] != "") {
		echo "<h3>Sorry, there was a problem.</h3><p>Twitter returned the following error message:</p><p><em>".$string[errors][0]["message"]."</em></p>";
		exit();
		}
	
	foreach($string["statuses"] as $status) {
		$selectSQL = 'SELECT * FROM twitter WHERE t_id="'.$status["id"].'" ';
		$queryset = '';
		$queryset = $mysqli->query ($selectSQL);
		if(mysqli_num_rows($queryset)==0)
			{ 
			$text = mysqli_real_escape_string($mysqli, $status["text"]);
			$loc = mysqli_real_escape_string($mysqli, $status["user"]["location"]);
			$user_id = mysqli_real_escape_string($mysqli, $status["user"]["id"]);
			$app = mysqli_real_escape_string($mysqli, $status["source"]);
			$img = mysqli_real_escape_string($mysqli, $status["user"]["profile_image_url"]);
			$retweet = mysqli_real_escape_string($mysqli, $status["retweet_count"]);
			$favorite = mysqli_real_escape_string($mysqli, $status["favorite_count"]);
			
			$mysqli->query('INSERT INTO `twitter` VALUES (NULL,"'.$status['id'].'","'.$text.'","'.$status['created_at'].'","'.$loc.'","'.$user_id.'","'.$app.'","'.$img.'","'.$retweet.'","'.$favorite.'")');
			}	
	}
	
	
	//Display Code
	
	echo "<table><tr><td>Sr.No</td><td>Tweet</td></tr>";	
	
    $selectSQL='SELECT * FROM  `twitter` ORDER BY  `id` DESC';
    $queryset='';
    $queryset= $mysqli->query($selectSQL);
    while($row = mysqli_fetch_array($queryset)) 
       {
         echo('<tr><td>'.$row['id'].'</td><td>'.$row['tweet'].'</td></tr>');
       }
	   
	echo "</table>";

?>