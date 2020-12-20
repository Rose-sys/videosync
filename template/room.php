<!DOCTYPE html>

<?php 
$info = $this->dbaccess->getinfo($_GET['hash']);
if  ($info['userid'] == $_SESSION['userid']) {
    $master = "yes";
    $this->curlmaster($info);
}
?>
<html>
        <head>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
                <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
                <?php 
                if ($master == "yes") {
                    //load master player
                   ?><script src="js/master.js"></script><?php
                } else {
                    //load client player
                    ?><script src="js/client.js"></script><?php
                    
                }
                
                ?>
                <link href="https://fonts.googleapis.com/css?family=Ubuntu&display=swap" rel="stylesheet">
                <link href="css/index.css" rel="stylesheet">
                <link href="css/room.css" rel="stylesheet">
                <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        </head>
        <script type="text/javascript">
        $.urlParam = function(name){
        	var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
        	return results[1] || 0;
        }
        var hashid = $.urlParam('hash');
        var idleTime = 0;
        var hidden = 0;
        var vidstate = 0;
        $(document).ready(function () {
            //Increment the idle time counter every minute.
            var idleInterval = setInterval(timerIncrement, 1000); // 1 minute
            var sz = document.getElementById("controls").offsetWidth;
            sz = sz / 2;
            $("#controls").css("margin-left", '-' + sz + 'px');
            //Zero the idle timer on mouse movement.
            $("html").mousemove(function (e) {
                unidle();
            });
            $("html").keypress(function (e) {
                unidle();
            });
<?php if (!empty($info['url'])) { ?>
        	var vid = document.getElementById("video");
            vid.setAttribute('src', '<?php echo $info['url']?>'); 
            vid.currentTime = '<?php echo $info['time']?>'; 
			$(".messagebox").html("Video paused");
			var Kyaa = Math.ceil(vid.duration); 
			$("#time").attr("max", Kyaa );
            <?php }?>
        });

        function unidle() {
        	idleTime = 0;
        	if (hidden == 1) {
        		hidden = 0;
           		$("#controls").animate({
           			top: "+=50px",
        			opacity: 1
        			},700);
    			}
        }
        function timerIncrement() {
            idleTime = idleTime + 1;
            if (idleTime > 4) {
                if (hidden == 0) {
                	hidden = 1;
            		$("#controls").animate({
                		top: "-=50px",
            			opacity: 0
            			},1000);
            		
                }
            }
        }
        </script>   
		<body> 
		<video id="video">
	<source src="" type="video/webm">
	Maybe you should upgrade your browser.
</video>
		<div id="gray"></div>
	<?php 
	if (($info['display'] == 1) && (!isset($_SESSION['userid']))) {
	    ?><div class="messagebox">You need to be logged in for this room</div><?php 
	} else {
	
	?>

		<div id="controls">
    		<div id="title" class="left roomname"><?php echo $info['title']?></div>
    		<?php if ($master == "yes") { ?>
    		<div id="url" class="left roomname"><input class="input" id="videourl" name="videourl" type="text" value="<?php if ($info['url'] == "") { echo "Enter url to video here"; } else { echo $info['url']; }?>"></div>
    		<div id="seturl" class="buttonx left" onclick="openvid();">Go</div>
    		<?php } ?>
    		<div id="slider" class="slidy left" ><input type="range" min="0" max="100" value="1" class="slider" id="time"></div>
    		
    		<?php if ($master == "yes") { ?>
    		<div id="pause" class="button right" onclick="pausevid();"><i class="material-icons">pause</i></div>
    		<div id="play" class="button right" onclick="playvid();"><i class="material-icons">play_arrow</i></div>
    		<?php } ?>
    	</div>
		<div class="messagebox">No video loaded.</div>

	<?php 
	}
	
	?>
		</body>
</html>