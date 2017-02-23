    //获取父级模板内容
        $(document).ready(function(){
            var strUrl=window.location.href; 
            var arrUrl=strUrl.split("/"); 
            var strPage=arrUrl[arrUrl.length-1]; 
            $.get('module/controller/index.php?temp='+strPage, function (data, status) {
                var str = $("html").html();
                console.log(str.replace($("html").html(), data));
                $("html").html(str.replace($("html").html(), data));        
            });
        });