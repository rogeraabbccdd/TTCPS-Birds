$("#content").hide();

$(window).on('load', function() {
	setTimeout(OnFinishLoad, 500);
	CanScroll = true;
})

function OnFinishLoad()
{
	$("#load").fadeOut("slow", function(){
		$("#content").fadeIn("fast");
	});	
}