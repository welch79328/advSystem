// JavaScript Document
$(function(){
		
	/* 不以var宣告的變數為全域變數 */
	$("input, textarea").focus(function(){	
		ph = $(this).attr("placeholder");
		$(this).attr("placeholder","");	
	}).blur(function(){
		$(this).attr("placeholder",ph);
	});
		
});