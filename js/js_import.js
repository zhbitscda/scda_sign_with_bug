function sumbit_list(){  
     var formData = new FormData($( "#add_list" )[0]);  
     $.ajax({  
          url: 'import.php',  
          type: 'POST',  
          data: formData,  
          async: false,  
          cache: false,  
          contentType: false,  
          processData: false,  
          success: function (returndata) {  
			layer.msg('<span style="color:#000000">名单添加成功!</span>',{icon: 1,time:1500})
			setTimeout(function(){window.location.href="list_list.html";}, 1500);
          },  
          error: function (returndata) {  
              alert(returndata);  
          }  
     });  
}