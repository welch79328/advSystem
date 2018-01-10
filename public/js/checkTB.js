// JavaScript Document
jQuery.validator.addMethod("checkTB", function(sid) {
	
   var tbNum = new Array(1,2,1,2,1,2,4,1);
   var temp = 0;
   var total = 0;
   var alerts = "" ;
   
   if(sid==""){
       return false;
   }else if(!sid.match(/^\d{8}$/)) {
       return false;
   }else{
   
   for(var i = 0; i < tbNum.length ;i ++){
        temp = sid.charAt(i) * tbNum[i];
        total += Math.floor(temp/10)+temp%10;
   }
   
   if(total%10==0 || (total%10==9 && sid.charAt(6)==7)){
        return true;
   }else{ 
   		return false;
   }
 }
	
}, "請輸入有效的統一編號!");