$( document ).ready(function () {
	$("#time").change(function() {
		var vid = document.getElementById("video");
		vid.currentTime = $("#time").val()
	$.post("index.php?a=pushdata", {
		action: "seek",
		time: $("#time").val(),
		hash: hashid
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
	var vid = document.getElementById("video");
    vid.setAttribute('src', $("#videourl").val()); 
	detectVideoSize()
}
function detectVideoSize() {
	$("#gray").css('visibility', 'visible');
	$(".messagebox").css('visibility', 'visible');
	$(".messagebox").html("Loading video...");
	clearInterval(timer);
	setTimeout(function(){
		var vid = document.getElementById("video");
		
		var Kyaa = Math.ceil(vid.duration); 
		$("#time").attr("max", Kyaa );
		$.post("index.php?a=pushdata", {
			action: "setvideo",
			totaltime: Math.ceil(vid.duration),
			url: $("#videourl").val(),
			hash: hashid,
			height: vid.videoHeight,
			width: vid.videoWidth
			
			}, function(data) {
				if (data == "ok") {
					
				} else {
					alert ("Invalid session");
				}
			})
			if (vidstate == 1) {
					$("#gray").animate({
					opacity: 1
					},300);
					$(".messagebox").animate({
					left: "+=50",
					opacity: 1
					},300);
				}
			$(".messagebox").html("Video paused.");
			vidstate = 0;
		},1000);	
}



function pausevid() {
	if (vidstate == 1) {
	var vid = document.getElementById("video");

	$.post("index.php?a=pushdata", {
		action: "pause",
		hash: hashid
	}, function(data) {
		if (data == "ok") {
			
		} else {
			alert ("Invalid session");
		}
	})
	vid.pause();
	$("#gray").animate({
		opacity: 1
		},300);
	$(".messagebox").animate({
		left: "+=50",
		opacity: 1
		},300);
	
	clearInterval(timer);
	vidstate = 0;
	}
}
function playvid() {
	if (vidstate == 0) { 
	var vid = document.getElementById("video");
	vid.play();
	clearInterval(timer);
	timer = setInterval(function() {
		
		$("#time").val(vid.currentTime)
				$.post("index.php?a=pushdata", {
			action: "updatetime",
			curtime: vid.currentTime,
			hash: hashid
		}, function(data) {
			if (data == "ok") {
				
			} else {
				alert ("Invalid session");
			}
		})
	},1000);
	$.post("index.php?a=pushdata", {
		action: "play",
		hash: hashid
	}, function(data) {
		if (data == "ok") {
			
		} else {
			alert ("Invalid session");
		}
	})
	$("#gray").animate({
		opacity: 0
		},300);
	$(".messagebox").animate({
		left: "-=50",
		opacity: 0
		},300);
	vidstate = 1;
	}
}


