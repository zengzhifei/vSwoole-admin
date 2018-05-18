
	
	var TestUIAlertDialogApi = function () {
	
	//var message = "<div class='form-group'><label class='col-md-3 control-label'>文本框</label><div class='col-md-9'><input type='text' placeholder='Enter text' class='form-control'><span class='help-block'>帮助</span></div></div><div class='form-group'><label class='col-md-3 control-label'>文本框</label><div class='col-md-9'><input type='text' placeholder='Enter text' class='form-control input-inline input-medium'><span class='help-inline'>帮助</span></div></div>"
	
	var message = "保存成功！"
    var testHandleAlerts = function() {

		 /*$('.delete').click(function(){
			bootbox.confirm({
				 buttons: {  
					confirm: {  
						label: '我是确认按钮',  
						className: 'btn-myStyle'  
					},  
					cancel: {  
						label: '我是取消按钮',  
						className: 'btn-default'  
					}  
				},  
				message: '提示信息',  
				callback: function(result) {  
					if(result) {  
						alert('点击确认按钮了');  
					} else {  
						alert('点击取消按钮了');  
					}  
				}
			});
		 });*/
        
        $('.tanceng').click(function(){

            Metronic.alert({
                container: "", // alerts parent container(by default placed after the page breadcrumbs)
                place: "append", // append or prepent in container 
                type: "info",  // alert's type
                message: message,  // alert's message
                close: false, // make alert closable
                reset: true, // close all previouse alerts first
                focus: false, // auto scroll to the alert after shown
                closeInSeconds: 2, // auto close after defined seconds
				width:"col-md-offset-3 col-md-3",
				fixed:"fixed",
                icon: "" // put icon before the message
            });

        });
		

		
		/*var radios = $(".radio-list");
		 for ( var i = 0; i < radios.length; i++) {
			 alert(radios[i])
			if (radios[i].find("span class")== "checked") {
				i++;
				 Metronic.alert({
					container: ".radio-list", // alerts parent container(by default placed after the page breadcrumbs)
					place: "append", // append or prepent in container 
					type: "info",  // alert's type
					message: message,  // alert's message
					close: true, // make alert closable
					reset: true, // close all previouse alerts first
					focus: false, // auto scroll to the alert after shown
					closeInSeconds: 0, // auto close after defined seconds
					width:"",
					fixed:"",
					icon: "" // put icon before the message
				});
			}
		}*/

var message1 = "<div class='row'><div class='col-md-4'>发布</div><div class='col-md-4'>编辑</div><div class='col-md-4'>删除</div></div>"
	$('.radio-list span').click(function(){
		var cont = $(this).parents('.radio-list'); 
		if($(this).attr('class') == "checked"){
			Metronic.alert({
                container: cont, // alerts parent container(by default placed after the page breadcrumbs)
                place: "append", // append or prepent in container 
                type: "info",  // alert's type
                message: message1,  // alert's message
                close: false, // make alert closable
                reset: true, // close all previouse alerts first
                focus: false, // auto scroll to the alert after shown
                closeInSeconds: 0, // auto close after defined seconds
				width:"",
				fixed:"",
                icon: "" // put icon before the message
            });

		}
  
      });




    }

    return {

        //main function to initiate the module
        init: function () {
            testHandleAlerts();
        }
    };

}();

