<?php 
if (!isset($GLOBALS['x'])) {
    die("direct access not allowed");
}
?>
<!DOCTYPE html>
<html>
        <head>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
                <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
                <link href="https://fonts.googleapis.com/css?family=Ubuntu&display=swap" rel="stylesheet">
                <link href="css/index.css" rel="stylesheet">
                <link href="css/main.css" rel="stylesheet">
        </head>
	<script>

	function createroom() {
		$("body").append('<div id="create" class="dialog"> </div>');
		$("#create").html('<div class="login-title-bar">Create new room</div><div class="login-text">Please enter your title</div><div class="form-block"><div class="left label">Title</div><div><input id="ctitle" class="noline" type="text" name="title" value="enter title"></div></div><div class="clear"></div><input class="login-button" type="button" onclick="docreate()" id="submit" value="Create"></div>');
		$("#create").animate({
			left: "+=50",
			opacity: 1
			},300);
	}
	function docreate() {
		$("#create").animate({
			left: "+=50",
			opacity:0
			},300);
		var txt = $("#ctitle").val();
		$.post("index.php?a=roomfunc",{ action: "create", title: txt });
		setTimeout(function() {
			$("#create").remove();
			window.location.href = "index.php?a=main";
		},300);
	}
	function xdelete(hash) {
		$("body").append('<div id="xdelete" class="dialog"> </div>');
		$("#xdelete").html('<div class="login-title-bar">Delete room</div><div class="login-text">Are you sure you want to delete the room?</div><div class="buttonsmall right" id="yes" onclick="dodelete(\'' + hash + '\')">Yes</div><div class="buttonsmall right" id="no" onclick="canceldel()">No</div>');
 		$("#xdelete").animate({
    			left: "+=50",
    			opacity: 1
			},300);
	}
	function canceldel() {
		$("#xdelete").animate({
			left: "+=50",
			opacity:0
			},300);
		var txt = $("#xdelete").val();
		setTimeout(function() {
			$("#xdelete").remove();
		},300);

	}
	function dodelete(hashx) {
		$("#xdelete").animate({
			left: "+=50",
			opacity:0
			},300);
		var txt = $("#xdelete").val();
		$.post("index.php?a=roomfunc",{ action: "delete", hash: hashx });
		setTimeout(function() {
			$("#xdelete").remove();
			window.location.href = "index.php?a=main";
		},300);
	}

	function xpublic(hashx) {
		$.post("index.php?a=roomfunc",{ action: "pub", hash: hashx }, function () {
			window.location.href = "index.php?a=main";
			});
		

	}
	function xprivate(hashx) {
		$.post("index.php?a=roomfunc",{ action: "priv", hash: hashx }, function () {
			window.location.href = "index.php?a=main";
		});
	}
	function copylink(data,elem) {
		var baseurl = window.location.origin+window.location.pathname + '?a=room&hash=' + data;

		  $("body").append('<input id="copyme" style="">');
		  $("#copyme").val(baseurl);
		  var copyText = document.getElementById("copyme");;

		  copyText.select();
		  copyText.setSelectionRange(0, 99999); /*For mobile devices*/

		  document.execCommand("copy");
		  $("#copyme").remove();
		  $(elem).css("background-color", "#ffffff");
		  $(elem).html("Copied!");
			$(elem).animate({
				backgroundColor: "#751c1c"
				},300, function() {
					$(elem).html("Copy Link");
				});
		} 
	function openlink(data) {
		var baseurl = window.location.origin+window.location.pathname + '?a=room&hash=' + data;
		  var win = window.open(baseurl, '_blank');
		  win.focus();
	}
	function kill() {
		window.location.href = "index.php?a=kill";
	}
	</script>
     
     <body>
     <div class="top"><div class="icon" ></div>VideoSync</div>
     <div id="Control">
     <div id="addroom" class="button right" onclick="createroom()">Create Room</div>
     <div id="logout" class="button right" onclick="kill()">Logout</div>
     </div>
     
     <div id="Rooms">
     
     <?php
        $getrooms = $this->dbaccess->getrooms($_SESSION['userid']);
        
        if ($getrooms) {
            foreach ($getrooms as $item) {
        
     ?>
     
         <div class="Room" id="<?php echo $item['sessionid']?>">
         
         	<div id="type" class="<?php if ($item['display']  == 0) { echo "public"; } else { echo "private"; }?> left"><?php if ($item['display'] == 0) { echo "Public"; } else { echo "Private"; }?></div>

         	<div class="title left"> <?php echo $item['title']?></div>
         	<div class="button right" id="delete" onclick="xdelete('<?php echo $item['sessionid']?>')">Delete</div>
         	<div class="button right" id="make<?php if ($item['display'] == 0) { echo "private"; } else { echo "public"; }?>" onclick="x<?php if ($item['display'] == 0) { echo "private"; } else { echo "public"; }?>('<?php echo $item['sessionid']?>')">Make <?php if ($item['display'] == 0) { echo "private"; } else { echo "public"; }?></div>
         	<div class="button right" id="copy" onclick="copylink('<?php echo $item['sessionid']?>',this)">Copy Link</div>
         	<div class="buttonsmall right" id="go" onclick="openlink('<?php echo $item['sessionid']?>')">Go</div>
         	<div class="clear"></div>
         </div>
         
     <?php 
            }
        } else {
                echo "You have not created any rooms yet!";
        }
     ?>
     </div>
    
     </body>
 </html>

