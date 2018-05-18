$(document).ready(function(){
$("#niming").click(function(){

if($("#nc").attr("id")=="nc")
{
	$("#nc").attr("id","ncc")
	$("#pdcw").show();
	$(this).hide();
}
else
{
	$("#ncc").attr("id","nc")
	$("#pdcw").hide();
}

})
$("#xgtx").click(function(){
$(".xiuzp").show();
})
$("#liulan").click(function(){
$(".xiuzp2").show();	
})		
$("#queding").click(function(){
$(".xiuzp2").hide();	 
 })
$("#quxiao").click(function(){
$(".xiuzp2").hide();	 
 })
$("#close3").click(function(){
$(".xiuzp2").hide();	 
 })
$("#close").click(function(){
$(".xiuzp").hide();
})
$("#tjxg").click(function(){
$("#xgcg").show();
})
$("#close2").click(function(){
$("#xgcg").hide();
})
$("#tjxg2").click(function(){
$("#xgcg2").show();
})
$("#close4").click(function(){
$("#xgcg2").hide();
})
$("#tjxg3").click(function(){
$("#xgcg3").show();
})
$("#close5").click(function(){
$("#xgcg3").hide();
})
});



$("#xxclose").click(function(){
                           $(".ts").hide();
                           })


//绑定信息
$(document).ready(function(){
//绑定信息导航
$("#bangd0").click(function(){
$(".allbd").hide();
$(".bdxx_1").show();
$("#bdxx").find("tr td").attr("class","")
$("#bangd0").attr("class","cur")
			})
$("#bangd1").click(function(){
$(".allbd").hide();
$(".youxiang_bd1").show();
$(".youxiang_bd7").show();
$("#bdxx").find("tr td").attr("class","")
$("#bangd1").attr("class","cur")
			})
$("#bangd2").click(function(){
$(".allbd").hide();
$(".shouji_bd0").show();
$("#bdxx").find("tr td").attr("class","")
$("#bangd2").attr("class","cur")
			})
$("#bangd3").click(function(){
$(".allbd").hide();
$(".wangzhan").show();
$("#bdxx").find("tr td").attr("class","")
$("#bangd3").attr("class","cur")
			})

//邮箱
$("#youxiang").click(function(){
				$(".bdxx_1").hide();
				$(".youxiang_bd1").show();
				$(".youxiang_bd7").show();
				$("#bdxx").find("tr td").attr("class","")
				$("#bangd1").attr("class","cur")
				})			
$("#queding2").click(function(){
				$(".youxiang_bd1").hide();
				$(".youxiang_bd7").hide();
				$(".youxiang_bd4").show();
				$(".youxiang_bd6").show();
				$(".youxiang_bd5").show();
				})
$("#quxiao2").click(function(){
			 $(".youxiang_bd2").hide();
			 $(".bdxx_1").show();
			 $("#bdxx").find("tr td").attr("class","")
				$("#bangd0").attr("class","cur")
			 })
$("#xyouxiang").click(function(){
					$(".youxiang_bd2").show();
					$(".youxiang_bd4").hide();
				 })
$("#cxfs").click(function(){
			 $(".youxiang_bd6").hide();
			 $(".youxiang_bd5").hide();
			 $(".youxiang_bd4").hide();
			 $(".youxiang_bd3").show();
			 })
$("#cxfs2").click(function(){
			 $(".youxiang_bd6").hide();
			 $(".youxiang_bd5").hide();
			 $(".youxiang_bd4").hide();
			 $(".youxiang_bd3").show();
			 })
$("#ljfw").click(function(){
		$(".youxiang_bd3").hide();
		$(".youxiang_bd").show();
		})
$("#xgbmyx").click(function(){
			$(".youxiang_bd").hide();
			$(".youxiang_bd2").show();
			})
$("#yxclose").click(function(){
			 $("#jihuosb").hide();
			 })
$("#yxclose2").click(function(){
			 $("#jihuocg").hide();
			 })
//手机
$("#shouji").click(function(){
				$(".bdxx_1").hide();
				$(".shouji_bd0").show();
				$("#bdxx").find("tr td").attr("class","")
				$("#bangd2").attr("class","cur")
			})
$("#next").click(function(){
		$(".shouji_bd0").hide();
		$(".shouji_bd1").show();
		})
$("#yzm").click(function(){
		$(".shouji_bd1").hide();
		$(".shouji_bd2").show();
	 })
$("#xiugai5").click(function(){
		$(".shouji_bd1").show();
		$(".shouji_bd2").hide();
	 })
$("#wc").click(function(){
		$(".shouji_bd2").hide();
		$(".shouji_bd3").show();
	})
$("#ghsjh").click(function(){
		 $(".shouji_bd1").show();
		$(".shouji_bd3").hide();
		$(".shouji_bd3").find(".kj").show();
		 })
$("#close6").click(function(){
			$(".shouji_bd3").find(".kj").hide();
			})
$("#fanhui").click(function(){
			$(".shouji_bd3").hide();
			$(".bdxx_1").show();
			})
//网站
$("#wangzhan").click(function(){
				$(".bdxx_1").hide();
				$(".wangzhan").show();
				$("#bdxx").find("tr td").attr("class","")
				$("#bangd3").attr("class","cur")
				})
$("#bangding").click(function(){
				$("#bangding").click(function(){
											$(".wangzhan").hide();
											$(".wangzhan2").show();
																			})	
				})
$("#bangding2").click(function(){
				$("#bangding").click(function(){
											$("#bdxx").hide();							
											$(".wangzhan").hide();
											$(".wangzhan2").show();
																			})	
				})

});



$("#xiugai").click(function(){
$(".bd").hide();
$(".bd2").show();
})
$(".qx").click(function(){
$(".bd").show();
$(".bd2").hide();
})




$(document).ready(function(){
var len=$("#dell li").size();
len=len-1;
$("#dell li").each(function(i)
	{
		$(this).click(function()
		{
			$(this).siblings("li").removeClass("cur").end().addClass("cur");
			$("#jibenxinxi_"+i).siblings(".xinxi").css({"display":"none"}).end().css({"display":"block"});
			if(i==len)
			{
				$("#bdxx").show();
			}
			else
			{
				$("#bdxx").hide();
			}
		});
	});
});




