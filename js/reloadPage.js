$(document).ready(function() {
var notReload = false;
var maxTime = 7; // Seconds
var countTime = 0;

// reload page
var objMetaRefresh = $(document).find('meta[refreshpage="true"]').first();
if(objMetaRefresh != null && objMetaRefresh != undefined){
	var time_refresh = parseInt(objMetaRefresh.attr('content'));
	
	setInterval(function(){
		if(!notReload){
			$(".obj-button-up-down-icon").unbind("click");
			location.reload();
		}
	}, time_refresh * 1000);
}

// Check maxtime to reset
setInterval(function(){
	// console.log("notReload: " + notReload);
	// console.log("countTime: " + countTime);

	if(notReload){
		countTime ++;
		if(countTime == maxTime){
			// Update to 0
			$(".obj-button-up-down-icon").trigger("off");

			bPopup.close();
		}

		if(countTime >= maxTime + 2){
			notReload = false;
			countTime = 0;
		}
	} else {
		countTime = 0;
	}

}, 1000);

// -------------------------------------------------

});
