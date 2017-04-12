function get_act_list(){
		$.ajax({
	   	type:"get",
	   	url:"export.php",
	   	async:true,
        success:function(data){
        	var json=eval(data);
        	if(!(json[0]['error']==1)){
        		$('#act_list').empty();
        		for(var i=0;i<json.length;i++){//把活动塞进去
        			var str='<div class="media"><div class="media-body">'+json[i].name+'<div class="clearfix"></div>'+'<div class="attrs">活动时间：'+json[i].actime+'</div>'+
      '<div class="list-options"><button class="btn btn-sm" data-actid="'+json[i].aid+'" onclick="export_action(this)">导出</button>'+'</div></div>';
                   $('#act_list').append(str);
        		}
        	}
        	else{
               window.location.href='login.php';
        	}
        }
	   });
}
function export_action(obj){
	var actid=$(obj).data("actid");
	var jump='export_action.php?active='+actid;
	window.location.href=jump;
}
$('#act_list').ready(function(){
	get_act_list();
});