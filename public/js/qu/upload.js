



function uploadifive_build(timestamp,csrf_token,upload_url,upload_js,upload_css,name,number) {
    var main = "<div><img src='' alt='' id='button_img"+number+"' style='height: 200px; width: 200px;'></div>" +
        "<input type='hidden' size='50' name='"+name+"' value=''>" +
        "<input id='file_upload"+number+"' name='file_upload' type='file'>" +
        "<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js' type='text/javascript'></script>" +
        "<script src='"+upload_js+"' type='text/javascript'></script>" +
        "<link rel='stylesheet' type='text/css' href='"+upload_css+"'>" +
        "<script type='text/javascript'>" +
        "$(function() {" +
        "$('#file_upload"+number+"').uploadifive({" +
        "'buttonText'   : '上傳'," +
        "'formData'     : {" +
        "'timestamp' : "+timestamp+"," +
        "'_token'     : '"+csrf_token+"'" +
        "}," +
        "'uploadScript' : '"+upload_url+"'," +
        "'onUploadComplete' : function(file, data) {" +
        "$('input[name ="+name+"]').val(data);" +
        "$('#button_img"+number+"').attr('src','/ads_qu_merge/public/'+data);" +
        "}" +
        "});" +
        "});" +
        "</script>";

    return main;
}