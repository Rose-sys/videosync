<!DOCTYPE html>
<html>
        <head>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
                <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
                <link href="https://fonts.googleapis.com/css?family=Ubuntu&display=swap" rel="stylesheet">
                <link href="css/index.css" rel="stylesheet">
        </head>
	<script>
	$( document ).ready(function () {
		setTimeout(function() {
		$("#loginbox").animate({
			left: "+=50",
			opacity: 1
			},300);
		},700);
		$("#loginform").submit(function ( event ) {
			$.post('index.php?a=verify', $('form#loginform').serialize(), function (data) {
				if (data == "OK") {
						$("#status").html("Success!");
						$("#status").css("display", "block");
						setTimeout(function () {
							window.location.replace("index.php?a=main");
						}, 1000);
				} else {
						$("#status").html("Incorrect username or password.");
						$("#status").css("display", "block");
						$("#loginbox").effect("shake");
				}

			}).fail(function(data, textStatus, xhr) {
				$("#status").html("Backend not ready. " + data.status);
				$("#status").css("display", "block");
				$("#loginbox").effect("shake");
			});
			event.preventDefault();
		});
	});
	</script>
     
     <body>
     <div class="top"><div class="icon"></div>VideoSync</div>
     <div id="loginbox">
         <div class="login-title-bar">Login</div>
         <div class="login-text">Please Login!</div>
         <div id="status">Something happened</div>
         <form id="loginform">
             <div class="form-block"><div class="left label">Login</div><div><input class="noline" type="text" name="username"></div></div>
             <div class="clear"></div>
             <div class="form-block"><div class="left label">Password</div><div><input class="noline" type="password" name="password"></div></div>
             <input class="login-button" type="submit" id="submit" value="Login">
         </form>
     </div>
     </body>
 </html>

