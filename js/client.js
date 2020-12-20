var jsn;
var cur;
var clientid;
var msg = 0;
$( document ).ready(function () {
	showmsg();
	createclient();
	$(".messagebox").html("Retrieving master data");
	$.post("index.php?a=getdata", {
		action: "createviewer",
		hash: hashid
	}, function(data) {
		jsn = $.parseJSON(data);
		cur = jsn;
		if (jsn[0].url == null)  { 
			$(".messagebox").html("Waiting for master to select video");
		} else {
			loadvideo();
			var vid = document.getElementById("video");
			if (jsn[0].action == 0) {
				showmsg();
				vid.currentTime = jsn[0].time;
				vid.pause();
				$(".messagebox").html("Master paused.");
			} else if (jsn[0].action == 1) {
				hidemsg();
				vid.currentTime = jsn[0].time;
				vid.play();
			}
		}
	});
	
	$.post("index.php?a=getdata", {
		action: "getstatus",
		hash: hashid
	}, function(data) {
		jsn = $.parseJSON(data);
		cur = jsn;
		if (jsn[0].url == null)  { 
			$(".messagebox").html("Waiting for master to select video");
		} else {
			loadvideo();
			var vid = document.getElementById("video");
			if (jsn[0].action == 0) {
				showmsg();
				vid.currentTime = jsn[0].time;
				vid.pause();
				$(".messagebox").html("Master paused.");
			} else if (jsn[0].action == 1) {
				hidemsg();
				vid.currentTime = jsn[0].time;
				vid.play();
			}
		}
	});
	setInterval(function() {
		runcheck();
		sendstatus();

	},1000);
});

function runcheck() {
	var vid = document.getElementById("video");
	$.post("index.php?a=getdata", {
		action: "getstatus",
		hash: hashid
	}, function(data) {
		jsn = $.parseJSON(data);
		if (jsn[0].url == null)  { 
			showmsg();
			$(".messagebox").html("Waiting for master to select video");
		} else if (jsn[0].url !== cur[0].url) {
			loadvideo();
			cur[0].url = jsn[0].url;
		}
		if (jsn[0].actionid !== cur[0].actionid ) {
			
			if (jsn[0].action == 0) {
				showmsg();
				vid.currentTime = jsn[0].time;
				vid.pause();
				$(".messagebox").html("Master paused.");
			} else if (jsn[0].action == 1) {
				hidemsg();
				vid.currentTime = jsn[0].time;
				vid.play();
			}
			cur = jsn;
		}
	});
	var Kyaa = Math.ceil(vid.duration); 
	$("#time").attr("max", Kyaa );
};

function loadvideo() {
	var vid = document.getElementById("video");
	vid.setAttribute('src', jsn[0].url);
	$(".messagebox").html("Syncing...");

};

function showmsg() {
	if (msg == 1) {
	$("#gray").animate({
		opacity: 1
		},300);
	$(".messagebox").animate({
		left: "+=50",
		opacity: 1
		},300);
	msg = 0; 
	}
}


function hidemsg() {
	if (msg == 0) {
		$("#gray").animate({
			opacity: 0
			},300);
		$(".messagebox").animate({
			left: "-=50",
			opacity: 0
			},300);
			msg = 1; 
	}
}


function sendstatus() {
	
		var vid = document.getElementById("video");
		$.post("index.php?a=getdata", {
			action: "updateclient",
			url: cur[0].url,
			hash: hashid,
			client: clientid, 
			curtime: vid.currentTime
		});
}

function createclient() {
			var vid = document.getElementById("video");		
			$.post("index.php?a=getdata", {
				action: "createclient",
				hash: hashid,
			}, function(data) {
				clientid = data;
			});
}
