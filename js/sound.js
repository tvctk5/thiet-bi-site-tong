$(document).ready(function() {
setRingSound();

$(".fa-volume").on("click", function(){
	var OBJECT = $(this);
	var hostid = OBJECT.attr("hostid");
	var userid = OBJECT.attr("userid");
	var check_volumn_on = $(this).hasClass("app-sound-on");
	
	if(OBJECT.hasClass("fa-volume-up")){
		OBJECT.removeClass("fa-volume-up").addClass("fa-volume-off");
		// Stop
		if(check_volumn_on){
			ion.sound.stop(hostid);
		}
		// Update DB
		pushMute(0, hostid, userid);
	}else{
		OBJECT.removeClass("fa-volume-off").addClass("fa-volume-up");
		// Play
		if(check_volumn_on){
			ion.sound.play(hostid);
		}
		// Update DB
		pushMute(1, hostid, userid);
	}
});

// -------------------------------------------------

});

function pushMute(value, hostid, userid){
	$.post(
		"function/data.php",
		{
			type : "mute",
			value : value,
			hostid : hostid,
			userid : userid
		}	
	).fail(function(){
		console.log("Set mute failed");
	}).always(function(){
		console.log("Set mute always");
	});
}


function setRingSound(){
	var sounds = [];
	$(document).find(".app-sound").each(function(index){
		// console.log($(this).attr("id"));
		
		var hostid = $(this).attr("hostid");
		var userid = $(this).attr("userid");
		var mute = $(this).attr("mute");
		var check_on = $(this).hasClass("app-sound-on");
		var cssClass = "fa-volume-off";
		var cssClass_on_off = "app-sound-off";

		sounds.push({
			alias: hostid,
			name: "bell_ring"
		});
		if(mute == '0'){
			cssClass = "fa-volume-up";
		}

		if(check_on){
			cssClass_on_off = "app-sound-on";
		}

		$(this).append('<i class="fa fa-volume ' + cssClass + " " + cssClass_on_off + '" id="volum-' + hostid + '" hostid="' + hostid + '" userid="' + userid + '"></i>');
	});

	ion.sound({
		sounds: sounds,
		volume: 1,
		path: "js/ion.sound-3.0.7/sounds/",
		preload: true,
		loop: true,
		multiplay: true
	});

	// Simple
	$(document).find(".app-sound").each(function(index){
		var hostid = $(this).attr("hostid");
		var mute = $(this).attr("mute");
		var check_on = $(this).hasClass("app-sound-on");

		if(mute == '0' && check_on){
			// console.log("hostid: " + hostid);
			ion.sound.play(hostid);

		}

	});

}