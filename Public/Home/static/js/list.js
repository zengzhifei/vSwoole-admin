$.listtest = function(params){
		
		var url = params.url;
		this.pagesize = params.pagesize;
		this.curpage = '';
		this.pagenation = function(totalnum, curPage){
				


				var from = 0;//当前页从第多少条开始
				var to = 0;//当前页到第多少条结束 
				
				var barObj = $(params.container).children('.pagebar');

				var pageSum = totalnum / this.pagesize;//总页数
				
				if(pageSum<=1){
					//$('.pagebar').val(1);
					if(pageSum==1){
						curPage = 1;
						from = 1;
						to = totalnum;
					}
				}else{
					//curPage = parseInt($('.pagebar').val());
					var rowNum = parseInt(this.pagesize);//1页显示多少条  4
					var endLastPage = rowNum*(curPage-1);//上一页最后一行的序号 4
					from = endLastPage + 1; //5
					if((endLastPage+parseInt(this.pagesize))>totalnum){
						to = totalnum;
					}else{
						to = endLastPage + parseInt(this.pagesize);
					}
					
				}
				
				var pageHtml = new Array();
				pageHtml.push('<div class="col-md-5 col-sm-12">');
					pageHtml.push('<div id="sample_editable_1_info" class="dataTables_info">');
						pageHtml.push('第 '+from+' 至 '+to+' 条 共 '+totalnum+' 条');
					pageHtml.push('</div>');
				pageHtml.push('</div>');
				 
				pageHtml.push('<div class="col-md-7 col-sm-12">');  
					pageHtml.push('<div class="sample_editable_1_info">');
						pageHtml.push('<ul style="visibility: visible;" class="pagination">');            
							if(curPage<=1){
								pageHtml.push('<li class="prev disabled">');
								pageHtml.push('<a  title="Prev" style="height:36px;">上一页</a>');
							}else{
								pageHtml.push('<li class="prev">');
								pageHtml.push('<a  title="Prev" style="height:36px;">上一页</a>');
							}
							pageHtml.push('</li>');

							
							if(curPage>=pageSum){
								pageHtml.push('<li class="next disabled">'); 
								pageHtml.push('<a  title="Next" style="height:36px;">下一页</a></li>');
							}else{
								pageHtml.push('<li class="next">');
								pageHtml.push('<a  title="Next" style="height:36px;">下一页</a></li>');
							}
						pageHtml.push('</ul>');
					pageHtml.push('</div>');
				pageHtml.push('</div>');
				barObj.html(pageHtml.join(''));

				if(curPage<pageSum){
					barObj.find('.next a').click(
						function(obj){
							return function() {
								obj.loaddata(curPage + 1);
							}
						}(this)
					);
				}
				
				if(curPage>1){
					barObj.find('.prev a').click(
						function(obj){
							return function() {
								obj.loaddata(curPage - 1);
							}
						}(this)
					);
				}
			
			}
		this.loaddata = function(curpage1){
			this.curpage = curpage1;
			$.ajax({
				type: "POST",
				url: url,
				dataType: "json",
				data:{"curpage": curpage1,
					  "pagesize":this.pagesize},
				success:
				function(obj) {	
				 return function (data) {
					var id = [];
					var htmltext = '<div class="row">';
					for(var i = 0;i<data.programmers.length;i++){
						id[i] = data.programmers[i].id;
						if((i+1)%4 == 0 ){
							htmltext+='<div class="col-md-3"><a href="javascript:;" class="thumbnail"><img src="'+data.programmers[i].image+'" alt="" style="height: 353px; width: 170px; display: block;"></a><div class="radio-list"><label class="col-md-offset-5">'+data.programmers[i].title+'</label></div></div></div><div class="row">'
						}else{
							htmltext+='<div class="col-md-3"><a href="javascript:;" class="thumbnail"><img src="'+data.programmers[i].image+'" alt="" style="height: 353px; width: 170px; display: block;"></a><div class="radio-list"><label class="col-md-offset-5">'+data.programmers[i].title+'</label></div></div>'
						}
						
					}
					htmltext+='</div>';
					htmltext+='<div class="row pagebar"></div>';
					$(params.container).html(htmltext);
					$(params.container).find("label").each(function(n, obj){
						var message1 = "<div class='row'><div class='col-md-4' id='"+id[n]+"'>发布</div><div class='col-md-4' id='"+id[n]+"'>编辑</div><div class='col-md-4' id='"+id[n]+"'>删除</div></div>"
						$(obj).click(function(){
							var cont = $(obj).parents('.radio-list'); 
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

						  });
					});
					obj.pagenation(data.totalnum, curpage1);
				};
				}(this)
			});
		}
		this.loaddata(1);


			
			
	};