<?php 
unset($_SESSION['loggedin']);
unset($_SESSION['userid']);
session_destroy();

?>
<html>
        <head>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
                <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
                <link href="https://fonts.googleapis.com/css?family=Ubuntu&display=swap" rel="stylesheet">
                <link href="css/index.css" rel="stylesheet">
        </head>

<script>
	$( document ).ready(function () {

							window.location.replace("index.php?a=main");

	});
	</script>
	<body>
	Session killed...
	</body>
	</html>