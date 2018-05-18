//分页
function getTableBottom(msg){
	
	var curPage = 0;//当前第几页
	var total = msg.total;//总条数
	var pageSum = msg.pageSum;//总页数


	var from = 0;//当前页从第多少条开始
	var to = 0;//当前页到第多少条结束 

	
	if(pageSum<=1){
		$('#page').val(1);
		if(pageSum==1){
			curPage = 1;
			from = 1;
			to = msg.rows.length;
		}
	}else{
		curPage = parseInt($('#page').val());
		var rowNum = parseInt($('#rows').val());//1页显示多少行
		var endLastPage = rowNum*(curPage-1);//上一页最后一行的序号
		from = endLastPage + 1;
		to = endLastPage + msg.rows.length;
	}
	
	var pageHtml = new Array();
	pageHtml.push('<div class="col-md-5 col-sm-12">');
		pageHtml.push('<div id="sample_editable_1_info" class="dataTables_info">');
			pageHtml.push('第 '+from+' 至 '+to+' 条 共 '+total+' 条');
		pageHtml.push('</div>');
	pageHtml.push('</div>');
	 
	pageHtml.push('<div class="col-md-7 col-sm-12">');  
		pageHtml.push('<div class="sample_editable_1_info">');
			pageHtml.push('<ul style="visibility: visible;" class="pagination">');            
				if(curPage<=1){
					pageHtml.push('<li class="prev disabled">');
					pageHtml.push('<a href="javascript:prevPage('+curPage+');" title="Prev" style="height:36px;">上一页</a>');
				}else{
					pageHtml.push('<li class="prev">');
					pageHtml.push('<a href="javascript:prevPage('+curPage+');" title="Prev" style="height:36px;">上一页</a>');
				}
				pageHtml.push('</li>');
				/*pageHtml.push('<li><a>当前第<select onchange="getData(this.value)">');
				for(var i=1;i<=pageSum;i++){
					if(i==curPage){
						pageHtml.push('<option value="'+i+'" selected>' + i + '</option>');
					}else{
						pageHtml.push('<option value="'+i+'">' + i + '</option>');
					}
				}
				pageHtml.push('</select>页</a></li>');*/ 
				
				if(curPage>=pageSum){
					pageHtml.push('<li class="next disabled">'); 
					pageHtml.push('<a href="javascript:nextPage('+curPage+','+pageSum+');" title="Next" style="height:36px;">下一页</a></li>');
				}else{
					pageHtml.push('<li class="next">');
					pageHtml.push('<a href="javascript:nextPage('+curPage+','+pageSum+');" title="Next" style="height:36px;">下一页</a></li>');
				}
			pageHtml.push('</ul>');
		pageHtml.push('</div>');
	pageHtml.push('</div>');
	$('.paging').html(pageHtml.join(''));
	
}

//上一页 
function prevPage(curPage) {
	if(curPage<=1){
		return;
	}else{
		$('#page').val(curPage - 1);
		loadData();
	}
}

//下一页
function nextPage(curPage, pageSum) {
	if(curPage>=pageSum){
		return;
	}else{
		$('#page').val(curPage + 1);
		loadData();
	}
}

function getData(page){
	$("#page").val(page);
	loadData();
}
