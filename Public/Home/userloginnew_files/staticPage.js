	//定义map对象
	function Map() {  
		//构建
		var struct = function(key, value) {  
			this.key = key;  
			this.value = value;  
		}
		//放入方法
		var put = function(key, value){  
			for (var i = 0; i < this.arr.length; i++) {  
				if ( this.arr[i].key === key ) {  
				this.arr[i].value = value;  
				return;  
			}  
		}  
			this.arr[this.arr.length] = new struct(key, value);  
		} 
	
		//取出方法
		var get = function(key) {  
			for (var i = 0; i < this.arr.length; i++) {  
			if ( this.arr[i].key === key ) {  
				return this.arr[i].value;  
			}  
		}  
			return '';  
		}  
		this.arr = new Array();  
		this.get = get;  
		this.put = put;  
	}  
	//声明map对象
	var params = new Map();
	//将域名值放入map
	var prePath = "https://" + window.location.host;
	params.put("prePath",prePath);
	//开始解析参数并放入map对象中
	var url=location.search; //得到参数部分
	var strRight = url.substr(1);
	var strs = strRight.split("&");
	for(var i = 0; i < strs.length; i++){
		var key = strs[i].split("=")[0];
		var value = strs[i].split("=")[1];
		params.put(key,value);
	}