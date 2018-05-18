
			$(function(){
				$(".weitingr ul li").hover(function(){
					$(this).addClass("hover");
				},function(){
					$(this).removeClass("hover");
				});
				$(".weitingr ul li").click(function(){
					$(".weitingr ul li").removeClass("cur");
					$(this).addClass("cur");
				});
				
			})
	/*头部弹出*/
	
		$(function(){
		$('.tan_1 ').hover(function(){
			$('.ninhao_box').show();
			
		},function(){
			$('.ninhao_box').hide();	
		});

	$('.ninhao_box').hover(function(){
	$(this).show();
	
},function(){

	$(this).hide()
});
			});
			
				$(function(){
		$('.tan_2 ').hover(function(){
			$('.shezhi_box').show();
			
		},function(){
			$('.shezhi_box').hide();	
		});

	$('.shezhi_box').hover(function(){
	$(this).show();
	
},function(){

	$(this).hide()
});
			});
			
		/*点赞变红*/	
		/*	$(function(){
											$('.imgzan').toggle(function(){
												$(this).attr('src','../images/shouye_zanhong.png')
		
												},function(){
													$(this).attr('src','../images/zan_zan.png')
													})
											})*/
											
											
	 $(function(){
					$('.yijingguangz').hover(function(){
						
						$(this).text('取消关注').addClass('anniuhong')
						},function(){
							$(this).text('已关注').removeClass('anniuhong')
							
							})
					
					})	;	
					 $(function(){
					$('.huxiangguanzhu').hover(function(){
						
						$(this).text('取消关注').addClass('anniuhong')
						},function(){
							$(this).text('互相关注').removeClass('anniuhong')
							
							})
					
					})		