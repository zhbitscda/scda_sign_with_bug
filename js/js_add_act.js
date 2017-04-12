function get_list(){
	$('#list_gp').ready(function(){
		$.ajax({
	   	type:"get",
	   	url:"active.php",
	   	data:{action:'add'},
	   	async:true,
        success:function(data){
        	var json=eval(data);
        	if(!(json[0].error==1)){
        		for(var i=0;i<json.length;i++){//把活动塞进去
        			var str='<option value="'+json[i].listid+'">'+json[i].listname+'</option>';
                   $('#list_select').append(str);
        		}
        	}
        	else{
               window.location.href='login.php';
        	}
        }
	  });
	});
}

function add_sumbit(){
	$.ajax({  
     url : "active.php?action=add_sumbit",  
     type : "POST",  
     data : $('#add_act').serialize(),  
     success : function(data) {  
         layer.alert('添加活动成功');
        window.location.href='list_act.html';
     },  
     error : function(data) {  
          layer.alert('添加失败,请与技术部门联系');  
     }  
});  
}

$("#list_select").ready(function(){
	get_list();
});
