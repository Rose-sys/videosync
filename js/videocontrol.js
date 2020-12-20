$( document ).ready(function () {
	$.post("master.php", {
		action: "createsession"
	}, function(data) {
		$("#session").html(data);
	})
	$("#time").change(function() {
		var vid = document.getElementById("master");
		vid.currentTime = $("#time").val()
	$.post("master.php", {
		action: "seek",
		time: $("#time").val(),
		hash: $("#session").html()
	}, function(data) {
		if (data == "ok") {
			
		} else {
			alert ("Invalid session");
		}
	})
	});
});
var timer;

function openvid() {
	clearInterval(timer);
	$("#time").val(0)
	var vid = document.getElementById("master");
    vid.setAttribute('src', $("#url").val()); 
	detectVideoSize()
}
function pausevid() {
	var vid = document.getElementById("master");

	$.post("master.php", {
		action: "pause",
		hash: $("#session").html()
	}, function(data) {
		if (data == "ok") {
			
		} else {
			alert ("Invalid session");
		}
	})
	vid.pause();
	clearInterval(timer);
}
function playvid() {
	var vid = document.getElementById("master");
	vid.play();
	clearInterval(timer);
	timer = setInterval(function() {
		
		$("#time").val(vid.currentTime)
		$.post("master.php", {
			action: "updatetime",
			curtime: vid.currentTime,
			hash: $("#session").html()

			
		}, function(data) {
			if (data == "ok") {
				
			} else {
				alert ("Invalid session");
			}
		})
	},1000);
	$.post("master.php", {
		action: "play",
		hash: $("#session").html()
	}, function(data) {
		if (data == "ok") {
			
		} else {
			alert ("Invalid session");
		}
	})
	
}

function detectVideoSize() {
	$(".blackout").css('visibility', 'visible');
	$(".messagebox").css('visibility', 'visible');
	clearInterval(timer);
	setTimeout(function(){
		var vid = document.getElementById("master");
		var Kyaa = Math.ceil(vid.duration); 
		$("#time").attr("max", Kyaa );
		$.post("master.php", {
			action: "setvideo",
			totaltime: Math.ceil(vid.duration),
			url: $("#url").val(),
			hash: $("#session").html(),
			height: vid.videoHeight,
			width: vid.videoWidth
			
		}, function(data) {
			if (data == "ok") {
				
			} else {
				alert ("Invalid session");
			}
		})
		$(".blackout").css('visibility', 'hidden');
		$(".messagebox").css('visibility', 'hidden');

		},1000);	
}

