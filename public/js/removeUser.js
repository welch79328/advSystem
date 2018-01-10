// JavaScript Document

//會員管理
function removeUser1(id){

				var txt = '是否確定刪除此筆資料?'+name+'<input type="hidden" id="userid" name="userid" value="'+ id +'" />';

				$.prompt(txt,{
					buttons:{刪除:true, 取消:false},
					close: function(e,v,m,f){

						if(v){

							var uid = f.userid;

							// $.ajax({
							// 	url: deletePostUri,
							// 	type:"POST",
                             //    data:"uid",
							// 	dataType:'text',
                            //
							// 	success: function(msg){
                            //
                             //        // $('#ma'+uid).hide('slow', function(){
                             //        //     $(this).remove();
                             //        //     location.reload();
                             //        // });
							// 	}
							// });
                            $.post(deletePostUri,{'_token':token,'ma_id':uid},function (data) {
                                    $('#ma'+uid).hide('slow', function(){
                                        $(this).remove();
                                        location.reload();
                                    });
                            });

						}

					}
				});
			}
			

//廣告類型
function removeUser2(id){
				
				var txt = '是否確定刪除此筆資料?'+name+'<input type="hidden" id="userid" name="userid" value="'+ id +'" />';
				
				$.prompt(txt,{ 
					buttons:{刪除:true, 取消:false},
					close: function(e,v,m,f){
						
						if(v){
							
							var uid = f.userid;
							
							// $.ajax({
							// 	url: "calss_del.php?s_id="+uid,
							// 	type:"GET",
							// 	dataType:'text',
                            //
							// 	success: function(msg){
                            //
							// 		$('#s'+uid).hide('slow', function(){
							// 			$(this).remove();
							// 			location.reload();
							// 		});
							// 	}
							// });

                            $.post(deletePostUri,{'_token':token,'s_id':uid},function (data) {
                                $('#s'+uid).hide('slow', function(){
                                    $(this).remove();
                                    // location.reload();
                                });
                            });
			
						}
						
					}
				});
			}
			
//廣告
function removeUser3(id){
				
				var txt = '是否確定刪除此筆資料?'+name+'<input type="hidden" id="userid" name="userid" value="'+ id +'" />';
				
				$.prompt(txt,{ 
					buttons:{刪除:true, 取消:false},
					close: function(e,v,m,f){
						
						if(v){
							
							var uid = f.userid;
							
							// $.ajax({
							// 	url: "banner_del.php?a_id="+uid,
							// 	type:"GET",
							// 	dataType:'text',
                            //
							// 	success: function(msg){
                            //
							// 		$('#a'+uid).hide('slow', function(){
							// 			$(this).remove();
							// 			location.reload();
							// 		});
							// 	}
							// });

                            $.post(deletebannerUri,{'_token':token,'a_id':uid},function (data) {
                                $('#a'+uid).hide('slow', function(){
                                    $(this).remove();
                                    location.reload();
                                });
                            });
			
						}
						
					}
				});
			}

//廣告
function removeUser4(id){
				
				var txt = '廣告尚有點數無法刪除,請先將點數歸戶!!'+name+'<input type="hidden" id="userid" name="userid" value="'+ id +'" />';
				
				$.prompt(txt,{ 
					buttons:{確定:false},
					close: function(e,v,m,f){
						
					}
				});
			}
			
//點數歸戶
function removeUser5(id){
				
				var txt = '點數是否確定歸戶?'+name+'<input type="hidden" id="userid" name="userid" value="'+ id +'" />';
				
				$.prompt(txt,{ 
					buttons:{確定:true, 取消:false},
					close: function(e,v,m,f){
						
						if(v){
							
							var uid = f.userid;
							
							// $.ajax({
							// 	url: "banner_return.php?a_id="+uid,
							// 	type:"GET",
							// 	dataType:'text',
                            //
							// 	success: function(msg){
                            //
							// 		location.href="banner.php?act=4";
                            //
							// 		/*
							// 		$('#a'+uid).hide('slow', function(){
							// 			$(this).remove();
							// 			location.reload();
							// 		});
							// 		*/
                            //
							// 	}
							// });

                            $.post(deletereturnUri,{'_token':token,'a_id':uid},function (data) {
                                location.href="banner/4";
                                // $('#a'+uid).hide('slow', function(){
                                //     $(this).remove();
                                //     location.reload();
                                // });
                            });
			
						}
						
					}
				});
			}