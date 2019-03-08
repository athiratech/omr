

<!DOCTYPE html>
<html>
<head>
<title>Web Push Notification in PHP/MySQL using FCM</title>

<script src="https://www.gstatic.com/firebasejs/5.7.0/firebase-app.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!-- Add additional services that you want to use -->
<script src="https://www.gstatic.com/firebasejs/5.7.0/firebase-auth.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.7.0/firebase-database.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.7.0/firebase-firestore.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.7.0/firebase-messaging.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.7.0/firebase-functions.js"></script>
<link rel="manifest" href="manifest.json">


<script>
  // Initialize Firebase
  /*Update this config*/
  // Initialize Firebase
  var config = {
    apiKey: "AIzaSyCDgGUCUxJSHoPJu2bnjzPeRwcdJzG_1Gg",
    authDomain: "realtimecrud-15317.firebaseapp.com",
    databaseURL: "https://realtimecrud-15317.firebaseio.com",
    projectId: "realtimecrud-15317",
    storageBucket: "realtimecrud-15317.appspot.com",
    messagingSenderId: "872121004465"
  };
  
  firebase.initializeApp(config);

	// Retrieve Firebase Messaging object.
	const messaging = firebase.messaging();
	messaging.requestPermission()
	.then(function() {
	  console.log('Notification permission granted.');
	  // TODO(developer): Retrieve an Instance ID token for use with FCM.
	  if(isTokenSentToServer()) {
	  	console.log('Token already saved.');
	  } else {
	  	getRegToken();
	  }

	})
	.catch(function(err) {
	  console.log('Unable to get permission to notify.', err);
	});

	function getRegToken(argument) {
		messaging.getToken()
		  .then(function(currentToken) {
		    if (currentToken) {
		      saveToken(currentToken);
		      setTokenSentToServer(true);
		    } else {

		      console.log('No Instance ID token available. Request permission to generate one.');
		      setTokenSentToServer(false);
		    }
		  })
		  .catch(function(err) {
		    console.log('An error occurred while retrieving token. ', err);
		    setTokenSentToServer(false);
		  });
	}

	function setTokenSentToServer(sent) {
	    window.localStorage.setItem('sentToServer', sent ? 1 : 0);
	}

	function isTokenSentToServer() {
	    return window.localStorage.getItem('sentToServer') == 1;
	}

	function saveToken(currentToken) {


		$.ajax({
			url: 'action.php',
			method: 'post',
			data: 'token=' + currentToken
		}).done(function(data){
			console.log("Results="+data);
		})
	
	}

	messaging.onMessage(function(payload) {

	  console.log("Message received. ", payload);
	  notificationTitle = payload.data.title;
	  notificationOptions = {
	  	body: payload.data.body,
	  	icon: payload.data.icon,
	  	image:  payload.data.image
	  };
	  var notification = new Notification(notificationTitle,notificationOptions);
	});
</script>
</head>
<body>
<center>
  <h1>FCM Web Push Notification in PHP/MySQL from localhost</h1>
  <h2>Part 5: Send and Receive Push Notifications in background</h2>
</center>
</body>
