var jq=jQuery;

var bodyBack=jq("#bodyBack");

var popbox=null;

var Message=function(div){

        return jq("#"+div);

    }

function popHide(Message_){

    var popMessage=Message(Message_);   

    bodyBack.css("display","none");

    popMessage.css("display","none");

    popbox=null;

}

function popShow(Message_){

    var popMessage=Message(Message_);

    bodyBack.css("display","block");

    popMessage.css("display","block");

    popbox=popMessage;

}

function messageShow(Message_){

    popShow(Message_);

    var popMessage=Message(Message_);

    var bodyW=document.documentElement.clientWidth,

        bodyH=document.documentElement.clientHeight,

        bodyLeft=document.documentElement.scrollLeft,

        bodyTop=document.documentElement.scrollTop+document.body.scrollTop;

    bodyBack.css({"width":bodyW+"px","height":bodyH+"px",left:bodyLeft+"px",top:bodyTop+"px"});

    popMessage.css({"left":(bodyW-popMessage.width())/2+"px","top":((bodyH-popMessage.height())/2+bodyTop)+"px"});  

}

function popRoll(popMessage){

    var bodyW=document.documentElement.clientWidth,

        bodyH=document.documentElement.clientHeight,

        bodyLeft=document.documentElement.scrollLeft+document.body.scrollLeft,

        bodyTop=document.documentElement.scrollTop+document.body.scrollTop; 

        //alert(bodyTop);

        bodyBack.css({"width":bodyW+"px","height":bodyH+"px",left:bodyLeft+"px",top:bodyTop+"px"});

        popMessage.css({"left":(bodyW-popMessage.width())/2+"px","top":((bodyH-popMessage.height())/2+bodyTop)+"px"});  

}

window.onscroll=window.onresize=function(){

    

    if(popbox){

        //alert("ddd");

        popRoll(popbox);

    }

}



