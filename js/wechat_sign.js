function refresh_qrcode(aid){
	while(1){
		$.ajax({
			type:"get",
			url:"wechat_qrcode.php",
			async:true,
			data:{aid:aid},
			success:function(data){
				$("#qrcode_box").attr('src',data); 
				alert('SUCCESS');
			}
		});
		$.delay(5000);
	}
}