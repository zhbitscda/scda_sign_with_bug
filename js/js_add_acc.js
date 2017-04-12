
function add_sumbit(){
	$.ajax({  
     url : "user.php?action=add",  
     type : "POST",  
     data : $('#add_acc').serialize(),  
     success : function(data) {  
			layer.msg('<span style="color:#000000">添加用户成功!</span>',{icon: 1,time:1500})
			setTimeout(function(){window.location.href="list_account.html";}, 1500);
     },  
     error : function(data) {  
          layer.alert('添加失败,请与技术部门联系');  
     }  
});  
}