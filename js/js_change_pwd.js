function GetQueryString(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
    var r = window.location.search.substr(1).match(reg);
    if (r != null)
        return unescape(r[2]);
    return "";
}

function change_pwd(){
	var uid=GetQueryString('uid');
	$.ajax({
		type:"post",
		url:"user.php?action=change_pwd&uid="+uid,
		async:true,
		data:$("#change_pwd").serialize(),
		success:function(data){
			layer.msg('<span style="color:#000000">修改密码成功!</span>',{icon: 1,time:1500})
		//	$.delay(2000);
			console.log(data);
			setTimeout(function(){window.location.href="list_account.html";}, 1500);
			
		},
		error:function(data){
			console.log(data);
		}
	});
}
