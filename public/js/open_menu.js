// JavaScript Document
$(function(){
	
	$(".open_menu").hover(function(){
		
		si = $(this).attr("id");

		$(".rn").not($("#rn"+si)).hide();

		$("#rn"+si).show();
		
	});
	
	
	$("#gadd").mouseleave(function(){
		
			$(".rn").hide();
		
	});
	
	
	$(".pc").click(function(){
	
		var name = $(this).attr("name");
		
		$("#rn"+name).hide('slow');
		
	});
	
	
	/* 全選與全不選 */
	$("input[name='a_add[]']").click(function() {

		var ci  = $(this).attr('id');
		var ha  = $("#ha").html();
		var hah = $("#hah").val();
		
		if($(this).prop("checked")) {


			$(".rid"+ci).prop("checked", true);

			$(".rid"+ci).each(function() {

				if(($(this).prop('checked'))) {
					
					var title = '<span class="hck" name="'+$(this).val()+'" id="rd'+$(this).val()+'">'+$(this).attr('title')+'</span>';

					if(ha.match(title)==null) {
					
						ha += title;
						/*hah += $(this).val()+',';*/
					
					}

                    var key = $(this).val()

                    $("#rid"+key).hide();
				}


			});
			
			
	   	} else {

	   		$(".rid"+ci).prop("checked", false);
			
			$(".rid"+ci).each(function() {
			
				if(($(this).prop("checked", false))) {
					
					$("#rd"+$(this).val()).remove();

                    var key = $(this).val()

                    $("#rid"+key).show();
				}


     	
			});
			
			ha  = $("#ha").html();
			    
	   	}
		
		$("#ha").html(ha);
		$("#hah").val(hah);
		   
	});
	
	
	/* 單選部分 */
	$(".ridc").click(function(){
		
		var ha = $("#ha").html();
		
		if($(this).prop("checked")) {
			
			if(($(this).prop('checked'))) {
					
				var title = '<span class="hck" name="'+$(this).val()+'" id="rd'+$(this).val()+'">'+$(this).attr('title')+'</span>';			
					
				if(ha.match(title)==null) {
					
					ha += title;
					
				}
					
			}
	
			
		}else {
			
			$("#rd"+$(this).val()).remove();
			ha  = $("#ha").html();
			
			if( $("input[name='rid["+si+"]']:checked").length == 0 ) {
				
				$("#"+si).prop("checked", false);
			}
			
		}
		
		$("#ha").html(ha);
	
	});
	
	
	
	/* 單區單選部分 */
	$(".ridc2").click(function(){
		
		var ha = $("#ha").html();
		
		if($(this).prop("checked")) {
			
			if(($(this).prop('checked'))) {
					
				var title = '<span class="hck" name="'+$(this).val()+'" id="rd'+$(this).val()+'">'+$(this).attr('title')+'</span>';			
					
				if(ha.match(title)==null) {
					
					ha += title;
					
				}
					
			}
	
			
		}else {
			
			$("#rd"+$(this).val()).remove();
			ha  = $("#ha").html();
			
			if( $("input[name='rid2["+si+"]']:checked").length == 0 ) {
				
				$("#"+si).prop("checked", false);
			}
			
		}
		
		$("#ha").html(ha);
	
	});
	
	/*
	$("input[name='a_add[]']").click(function() {
		
		var ci = $(this).attr('id');
		
		if($(this).prop("checked")) {
			
			$(".rid"+ci).prop("checked", true);
			
			
	   	} else {
			
	   		$(".rid"+ci).prop("checked", false);  
			        
	   	}
			   
	});
	*/
	
	
	/* 送出相關值 */
	/*
	$(".pop_but").click(function(){
		
		var pb  = $(this).attr('name');
		var ha  = $("#ha").html();
		var hah = $("#hah").val();
		
		$(".rid"+pb).each(function() {
			
			if(($(this).prop('checked'))) {
				
				var title = $(this).attr('title');
				
				if(ha.match(title)==null) {
				
					ha += title+",";
					hah += $(this).val()+',';
				
				}
				
			}
			
     	
		});

		
		$("#ha").html(ha);
		$("#hah").val(hah);
				
	});
	*/
	
});