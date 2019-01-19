<?php 

	define('SERVER_API_KEY', 'AAAAyw52cbE:APA91bG46TVk2hDgBc6sJdWWGQu7f4cnqqp5mVvIdPhy6TYfLjbq9tKin53O-ictzlGnJMt49cu3wirCjMdds5HgjeO5CHAyghLXcZSXg8irWmGk65LeWGLA7uXAo1hErIIGkEhEOGOj');

	require 'DbConnect.php';
	$db = new DbConnect;
	$conn = $db->connect();
	$stmt = $conn->prepare('SELECT * FROM tokens');
	$stmt->execute();
	$tokens = $stmt->fetchAll(PDO::FETCH_ASSOC);

	foreach ($tokens as $token) {
		$registrationIds[] = $token['token'];
	}

	
	$header = [
		'Authorization: Key=' . SERVER_API_KEY,
		'Content-Type: Application/json'
	];

	$msg = [
		'title' => 'Sri Chaitanya Institutions',
		'body' => 'Results for 1_ICON_IPL_IC generated',
		'icon' => 'img/big-logo.png',
		'image' => 'img/big-logo.png',

	];

	$payload = [
		'registration_ids' 	=> $registrationIds,
		'data'				=> $msg
	];

	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_POSTFIELDS => json_encode( $payload ),
	  CURLOPT_HTTPHEADER => $header
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
	  echo "cURL Error #:" . $err;
	} else {
	  echo $response;
	}
 ?>