<?php 
	if(isset($_POST['token'])) {
		require 'DbConnect.php';
		$db = new DbConnect;
		$conn = $db->connect();
		$cdate = date('Y-m-d');
		$stmt = $conn->prepare('INSERT INTO tokens VALUES(null, :token, :cdate)');
		$stmt->bindParam(':token', $_POST['token']);
		$stmt->bindParam(':cdate', $cdate);
		if($stmt->execute()) {
			print json_encode(["Mess"=>"Done","Code"=>"404"]);
		} else {
			
			print json_encode(["Mess"=>"Failed to saved token..","Code"=>"404"]);
		}
	}

 ?>