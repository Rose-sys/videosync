var jsn;
var cur;
var clientid;
$( document ).ready(function () {
	showmsg();
	createclient();
	$(".messagebox").html("Retrieving master data");
	$.post("master.php", {
		action: "createviewer",
		hash: $("#hsession").html()
	}, function(data) {
		jsn = $.parseJSON(data);
		cur = jsn;
		if (jsn[0].url == null)  { 
			$(".messagebox").html("Waiting for master to select video");
		} else {
			loadvideo();
			var vid = document.getElementById("master");
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
	
	$.post("master.php", {
		action: "getstatus",
		hash: $("#hsession").html()
	}, function(data) {
		jsn = $.parseJSON(data);
		cur = jsn;
		if (jsn[0].url == null)  { 
			$(".messagebox").html("Waiting for master to select video");
		} else {
			loadvideo();
			var vid = document.getElementById("master");
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
	$.post("master.php", {
		action: "getstatus",
		hash: $("#hsession").html()
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
			var vid = document.getElementById("master");
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
};

function loadvideo() {
	var vid = document.getElementById("master");
	vid.setAttribute('src', jsn[0].url);
	$(".messagebox").html("Syncing...");

};

function showmsg() {
	$(".blackout").css('visibility', 'visible');
	$(".messagebox").css('visibility', 'visible');
}


function hidemsg() {
	$(".blackout").css('visibility', 'hidden');
	$(".messagebox").css('visibility', 'hidden');
}


function sendstatus() {
	
		var vid = document.getElementById("master");
		$.post("master.php", {
			action: "updateclient",
			url: cur[0].url,
			hash: $("#hsession").html(),
			client: clientid, 
			curtime: vid.currentTime
		});
}

function createclient() {
	
			var vid = document.getElementById("master");		
			$.post("master.php", {
				action: "createclient",
				hash: $("#hsession").html(),
			}, function(data) {
				clientid = data;
			});

}
