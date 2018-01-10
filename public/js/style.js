// JavaScript Document
$(function(){

	var s_id = $("#s_id").val();
	
	if(s_id == 3) {
		
		$("#at1, #tw_im").hide();
		$("#at2, #tw_yu").show();
		$("#a_type2").attr("checked", true);
		$("#a_type1").attr("checked", false);
		
	}else {
		
		$("#at2, #tw_yu").hide();
		$("#at1, #tw_im").show();
		$("#a_type1").attr("checked", true);
		$("#a_type2").attr("checked", false);
		
	}
	
	$("#s_id").change(function(){
		
		var s_id = $("#s_id").val();
	
		if(s_id == 3) {
			
			$("#at1, #tw_im").hide();
			$("#at2, #tw_yu").show();
			$("#a_type2").attr("checked", true);
			$("#a_type1").attr("checked", false);
			
		}else {
			
			$("#at2, #tw_yu").hide();
			$("#at1, #tw_im").show();
			$("#a_type1").attr("checked", true);
			$("#a_type2").attr("checked", false);
			
		}
		
	});
	
	
});