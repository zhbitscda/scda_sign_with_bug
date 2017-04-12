function start_sign(obj){
	var x=$(obj).data('actid');
	var j='sign_list.html?aid='+x;
    window.location.href=j;
}

function start_sign_exit(obj){
	var x=$(obj).data('actid');
	var j='sign_list_exit.html?aid='+x;
    window.location.href=j;
}

function act_del(obj){
	layer.confirm('<span style="color:#000000">确认要删除活动吗？</span>',function(index){
		actid=$(obj).data('actid');
		$.get('active.php',{action:"del",aid:actid});
		$(obj).parents("div.media").remove();
		layer.msg('<span style="color:#000000">已删除!</span>',{icon: 1,time:1000});
	});
}

function act_view(obj){
    var x=$(obj).data('actid');
	var j='view.html?aid='+x;
    window.location.href=j;
}

function act_view_exit(obj){
    var x=$(obj).data('actid');
	var j='view_exit.html?aid='+x;
    window.location.href=j;
}

function get_act_list(){
		$.ajax({
	   	type:"get",
	   	url:"active.php",
	   	async:true,
        success:function(data){
        	var json=eval(data);
        	if(!json.hasOwnProperty("error")){
        		$('#act_list').empty();
        		for(var i=0;i<json.length;i++){//把活动塞进去
        			var str='<div class="media"><div class="media-body">'+json[i].name+'<div class="clearfix"></div>'+'<div class="attrs">活动时间：'+json[i].actime+'</div>'+'<div class="list-options"><button class="btn btn-sm" data-actid="'+json[i].aid+'" onclick="start_sign(this)">开始签到</button>'+'<button class="btn btn-sm" data-actid="'+json[i].aid+'" onclick="start_sign_exit(this)">开始签退</button>'+'<button class="btn btn-sm" data-actid="'+json[i].aid+'" onclick="act_view(this)">查看签到</button>'+'<button class="btn btn-sm" data-actid="'+json[i].aid+'" onclick="act_view_exit(this)">查看签退</button>'+'<button class="btn btn-sm" data-actid="'+json[i].aid+'" onclick="act_del(this)">删除</button>'+'</div></div>';
                   $('#act_list').append(str);
        		}
        	}
        	else{
            window.location.href='login.php';
        	}
        }
	   });
}

$('#act_list').ready(function(){
	get_act_list();
});
