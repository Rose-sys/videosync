<!DOCTYPE html>
<html>
        <head>
			<title>VideoSync - Fatal</title>
        </head>
        <script>
			function redir() {
				window.location.replace("/");
			}

        </script>
        <style>
            @font-face {
                font-family: guru;
                src: url('css/GURU0.ttf');
            }
            body, html {
                margin: 0px;
                background: #000;
                font-family: guru;
            }
            #messagebox { 
                Width: calc(100% - 10px);
                border: 5px solid red;
                color: red;
                animation: blink 1s step-end infinite alternate;
                background: #000;
                white-space: pre;
                text-align: center;
                padding-bottom: 20px;
            }
            @keyframes blink {
                50% { border-color:black; }
            }
            .full {
            position: fixed;
            width: 100%;
            height: 100%;
            } 
        </style>
     <body onclick="redir();">
	<div class="full">
     <div id="messagebox">
     		Software failure.    Press left mouse button to continue.
     		
     		<?php echo $data ?>
     </div>
     </div>
     </body>
 </html>

