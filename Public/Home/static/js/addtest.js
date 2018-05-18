$.addtest = function(params){
	var html = "";
	if(params.listnum.length > 0){
		for(var i = 0; i<params.listnum.length;i++){
			html+='<div class="alert  '+params.bgcolor+' alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button><input type="text" value="'+params.listnum[i].cont+'" name="'+params.inputname+'" class="form-control" placeholder="'+params.defaultname+'"></div>';
		}
		$(params.container).find(params.addcontainer).html(html);
	}
	$(params.addbutton).click(function(){
			$(params.container).find(params.addcontainer).append('<div class="alert  '+params.bgcolor+' alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button><input type="text" name="'+params.inputname+'" class="form-control" placeholder="'+params.defaultname+'"></div>'); 	
	});	
}

