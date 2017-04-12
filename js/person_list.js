
var $_GET = (function(){
    var url = window.document.location.href.toString();
    var u = url.split("?");
    if(typeof(u[1]) == "string"){
        u = u[1].split("&");
        var get = {};
        for(var i in u){
            var j = u[i].split("=");
            get[j[0]] = j[1];
        }
        return get;
    } else {
        return {};
    }
})();

function GetRequest() { 
var url = location.search; //获取url中"?"符后的字串 
var theRequest = new Object(); 
if (url.indexOf("?") != -1) { 
var str = url.substr(1); 
strs = str.split("&"); 
for(var i = 0; i < strs.length; i ++) { 
theRequest[strs[i].split("=")[0]]=unescape(strs[i].split("=")[1]); 
} 
} 
return theRequest; 
} 

function GetQueryString(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
    var r = window.location.search.substr(1).match(reg);
    if (r != null)
        return unescape(r[2]);
    return "";
}

function EnterPress(e){ //传入 event 
    var e = e || window.event; 
    if(e.keyCode == 13){ 
    document.getElementById("txtAdd").focus(); 
    } 
} 

function output_signlist(data){  //清空元素先
	$('#list_list').empty();
	data=eval(data);
	if(!(data[0].error==1)){
	for(var i=0;i<data.length;i++){//依次输出返回数据到表格中
		var appenstr='<div class="media"><div class="media-body">'+data[i].listname+'<div class="clearfix"></div><div class="list-options"><button class="btn btn-sm" data-listid='+data[i].listid+' onclick="del_list(this)">删除</button></div></div>';
		$('#list_list').append(appenstr);
	}
	}
	else{
		window.location.href='login.php';
	}
}

function Get_sign_list(){
	    $.ajax({
	   	type:"get",
	   	url:"person_list.php",
	   	async:true,
        success:function(data){
        	output_signlist(data);
        }
	   });
}

 function del_list(obj){
	layer.confirm('<span style="color:#000000">确认要删除列表吗？</span>',function(index){
		listid=$(obj).data('listid');
		$.get('person_list.php',{action:"del",listid:listid});
		$(obj).parents("div.media").remove();
		layer.msg('<span style="color:#000000">已删除!</span>',{icon: 1,time:1000});
	});
}


$("#list_list").ready(function(){
	Get_sign_list();//主界面初始化完毕之后开始拉数据并生成需要的东西
});



