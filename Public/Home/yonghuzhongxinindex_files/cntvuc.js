(function() {


/**
 * 全局名字空间:cntvuc
 */
cntvuc = {
  VERSION: "1.0.0",
  COPYRIGHT: "www.cntv.cn",
  AUTHOR: "wudi",
  fnEmpty: function() {},
  fnTrue: function() { return true; },
  fnFalse: function() { return false; },
  fnEventStop: function(e) { cntvuc.Event.stop(e||window.event); return false; }
};

cntvuc.Class = {
  create: function() {
    return function() {
      this.initialize.apply(this, arguments);
    }
  }
};

cntvuc.$ = function(elem) {
  if (arguments.length > 1) {
    for (var i = 0, elems = [], length = arguments.length; i < length; i++)
      elems.push($(arguments[i]));
    return elems;
  }
  if (typeof elem == 'string') {
    return document.getElementById(elem);
  } else {
    return elem;
  }
};

/*
 * 将类数组对象转换成Array对象
 */
cntvuc.$A = function(a) {
  var results = [];
  for (var i = 0, length = a.length; i < length; i++) {
    results.push(a[i]);
  }
  return results;
};

/**
 * 从倒数第一个参数开始逐步将属性复制到前一个参数，参数数目必须大于1
 */
cntvuc.extend = function(dist) {
  for (var i = 1; i < arguments.length; i++) {
    var src = arguments[i];
    for (var p in src) {
      dist[p] = src[p];
    }
  }
  return dist;
}

/*
 * 给String添加trim、startsWith、endsWith方法
 */
cntvuc.extend(
  String.prototype,
  {
  	trim: function(s) {
  	  return s ? this.replace(new RegExp("^" + s + "+|" + s + "+$", "g"), "") : this.replace(/^\s+|\s+$/g, "");
    },
    ltrim: function(s) {
      return s ? this.replace(new RegExp("^" + s + "+", "g"), "") : this.replace(/^\s+|\s+$/g, "");
    },
    rtrim: function(s) {
      return s ? this.replace(new RegExp(s + "+$", "g"), "") : this.replace(/^\s+|\s+$/g, "");
    },
    startsWith: function(pf) {
      return (pf == "") ? true : (this.indexOf(pf) == 0);
    },
    endsWith: function (sf) {
      return (sf == "") ? true : (this.lastIndexOf(sf) == this.length - String(sf).length);
    }
  }
);

/**
 * package cntvuc.util
 */
cntvuc.util = {};
/*
 * class cntvuc.util.List
 */
cntvuc.util.List = cntvuc.Class.create();
cntvuc.extend(cntvuc.util.List.prototype, {
  initialize: function() {
    this._l = [];
  },
  add: function(o) { this._l.push(o); },
  addAll: function(l) {
  	var a = (l instanceof cntvuc.util.List || l instanceof cntvuc.util.Set) ? l._l : l;
  	for (var i = 0; i < a.length; i++) {
  	  this._l.push(a[i]);
  	}
  },
  clear: function() { this._l.length = 0; },
  contains: function(o) { return this.indexOf(o) != -1; },
  get: function(i) { return this._l[i]; },
  indexOf: function(o) {
    for(var i = 0; i < this._l.length; i++){
      if(this._l[i] === o) {
        return i;
      }
    }
    return -1;
  },
  isEmpty: function() { return this._l.length == 0; },
  remove: function(i) { return this._l.splice(i, 1); },
  removeObject: function(o) { 
    var i = this.indexOf(o);
    return i != -1 ? this._l.splice(i, 1)[0] : null;
  },
  size: function() { return this._l.length; },
  toArray: function() { return [].concat(this._l); },
  dump: function() { return "[" + this._l.join(",") + "]"; },
  sort: function(fn) {
    this._l.sort(fn);
    return this;
  },
  filter: function(fnExp, fnCond) {
    return cntvuc.util.Arrays.asList(cntvuc.util.Arrays.filter(fnExp, this._l, fnCond));
  },
  each: function(fn) {
  	var l = this._l;
  	for (var i = 0, len = l.length; i < len; i++) {
  	  if (fn(l[i]) === false) break;
  	}
  }
});
cntvuc.util.Set = cntvuc.Class.create();
cntvuc.extend(cntvuc.util.Set.prototype, cntvuc.util.List.prototype, {
  initialize: function() {
    this._l = [];
  },
  add: function(o) {
    if (this.indexOf(o) == -1) {
      this._l.push(o);
    }
  },
  addAll: function(s) {
  	var a = (s instanceof cntvuc.util.List || s instanceof cntvuc.util.Set) ? s._l : s;
    for (var i = 0; i < a.length; i++) {
      this.add(a[i]);
    }
  },
  filter: function(fnExp, fnCond) {
    return cntvuc.util.Arrays.asSet(cntvuc.util.Arrays.filter(fnExp, this._l, fnCond));
  }
});
cntvuc.util.Map = cntvuc.Class.create();
cntvuc.extend(cntvuc.util.Map.prototype, {
  initialize: function() {
    this._m = {};
  },
  clear: function() { this._m = {}; },
  containsKey: function(k) { return this._m.hasOwnProperty("_" + k); },
  containsValue: function(v) {
    for (var k in this._m) {
      if (this._m["_" + k] === v) {
        return true;
      }
    }
    return false;
  },
  get: function(k) { return this._m["_" + k]; },
  isEmpty: function() {
    for (var k in this._m) {
      return false;
    }
    return true;
  },
  keySet: function() {
  	var set = new cntvuc.util.Set();
    var m = this._m;
    for (var i in m) {
      set.add(i.substring(1));
    }
    return set;
  },
  values: function() {
  	var a = [], m = this._m;
    for (var i in m) {
      a.push(m[i]);
    }
    return cntvuc.util.Arrays.asList(a);
  },
  put: function(k, v) { return this._m["_" + k] = v; },
  remove: function(k) {
    var v = this._m["_" + k];
    delete(this._m["_" + k]);
    return v;
  },
  size: function() {
    var c = 0;
    for (var i in this._m) {
      c++;
    }
    return c;
  },
  filter: function(fnExp, fnCond) {
    fnExp = fnExp ? (typeof(fnExp) == "string" ? new Function("k", "v", "return " + fnExp + ";") : fnExp) : function(k, v) { return {k: k, v: v} };
    fnCond = fnCond ? (typeof(fnCond) == "string" ? new Function("k", "v", "return (" + fnCond + ");") : fnCond) : cntvuc.fnTrue;
    
	var rst = new cntvuc.util.Map();
	var m = this._m, v = null, t = null;
    for (var k in m) {
      v = m[k];
      k = k.substring(1);
      if (fnCond(k, v)) {
      	t = fnExp(k, v);
        rst.put(t.k, t.v);
      }
    }
    return rst;
  },
  each: function(fn) {
	var m = this._m, v = null;
    for (var k in m) {
      v = m[k];
      k = k.substring(1);
      if (fn(k, v) === false) break;
    }
  }
});
cntvuc.extend(cntvuc.util.Map, {
  fromObject: function(o) {
    var m = new cntvuc.util.Map();
    for (var i in o) {
      m.put(i, o[i]);
    }
    return m;
  }
});

cntvuc.util.Queue = cntvuc.Class.create();
cntvuc.extend(cntvuc.util.Queue.prototype, {
  initialize: function() { this._q = []; },
  enqueue: function(o) { this._q.push(o); },
  dequeue: function() { return this._q.shift(); },
  peek: function() { return this._q[0]; },
  size: function() { return this._q.length; }
});

cntvuc.util.Arrays = {
  asList: function(a) {
    var l = new cntvuc.util.List();
    l._l = [].concat(a);
    return l;
  },
  asSet: function(a) {
    var s = new cntvuc.util.Set();
    for (var i = 0, len = a.length; i < len; i++) {
      s.add(a[i]);
    }
    return s;
  },
  asMap: function(a, asType) {
  	asType = asType ? asType : 0;
  	var m = new cntvuc.util.Map();
  	var tmp = null;
  	for (var i = 0, len = a.length, v = null; i < len; i++) {
  	  v = a[i];
      switch (asType) {
        case 0:
          m.put(v[0], v[1]);
          break;
        case 1:
          m.put(v, a[++i]);
          break;
        case 2:
          m.put(v.k, v.v);
          break;
        default:
          v = asType(v);
          m.put(v.k, v.v);
          break;
      }
  	}
  	return m;
  },
  filter: function(fnExp, arr, fnCond) {
    fnExp = fnExp ? (typeof(fnExp) == "string" ? new Function("o", "return " + fnExp + ";") : fnExp) : function(o) { return o; };
    fnCond = fnCond ? (typeof(fnCond) == "string" ? new Function("o", "return (" + fnCond + ");") : fnCond) : cntvuc.fnTrue;
    var rst = [], o = null;
    for (var i = 0, l = arr.length; i < l; i++) {
      o = arr[i];
      if (fnCond(o)) {
        rst.push(fnExp(o));
      }
    }
    return rst;
  },
  contains: function(a, o) {
    for (var i = 0, len = a.length; i < len; i++) {
      if (a[i] === o) {
      	return true;
      }
    }
    return false;
  },
  each: function(a, fn) {
    for (var i = 0, c = a.length; i < c; i++) {
      if (fn(a[i]) === false) break;
    }
  }
};

//

cntvuc.Event = {
  addEvent: function(elem, name, fn, useCapture) {
    if (elem.addEventListener) {
      elem.addEventListener(name, fn, useCapture);
    } else if (elem.attachEvent) {
      elem.attachEvent('on' + name, fn);
    }
  },
  removeEvent: function(elem, name, fn, useCapture) {
    if (elem.removeEventListener) {
      elem.removeEventListener(name, fn, useCapture);
    } else if (elem.detachEvent) {
      elem.detachEvent('on' + name, fn);
    }
  },
  pointer: function(e) {
    return {x: this.pointerX(e), y: this.pointerY(e)};
  },
  pointerX: function(e) {
    return e.pageX || (e.clientX + (document.documentElement.scrollLeft || document.body.scrollLeft));
  },
  pointerY: function(e) {
    return e.pageY || (e.clientY + (document.documentElement.scrollTop || document.body.scrollTop));
  },
  stop: function(e) {
    if (e.preventDefault) {
      e.preventDefault();
      e.stopPropagation();
    } else {
      e.returnValue = false;
      e.cancelBubble = true;
    }
  },
  isLeftClick: function(e) {
    return (((e.which) && (e.which == 1)) || ((e.button) && (e.button == 1)));
  }
};

//bool setcookie ( string name [, string value [, int expire [, string path [, string domain [, bool secure]]]]] )

cntvuc.Cookie = {
  write: function(name, value, hours, path, domain, secure) {
    var expire = "";
    if(hours != null) {
      expire = new Date((new Date()).getTime() + hours * 3600000);
      expire = "; expires=" + expire.toGMTString();
    }
    path = path ? ("; path=" + path) : "";
    domain = domain ? ("; domain=" + domain) : "";
    document.cookie = name + "=" + encodeURIComponent(value) + expire + path + domain;
  },  
  read: function(name) {
    var cookieValue = "";
    var search = name + "=";
    if(document.cookie.length > 0) { 
      offset = document.cookie.indexOf(search);
      if (offset != -1) { 
        offset += search.length;
        end = document.cookie.indexOf(";", offset);
        if (end == -1) end = document.cookie.length;
        cookieValue = decodeURIComponent(document.cookie.substring(offset, end))
      }
    }
    return cookieValue;
  },
  remove: function(name, domain) {
    var exp = new Date();    
    exp.setTime (exp.getTime() - 65535);
    domain = domain ? ("; domain=" + domain) : "";
//    var cval = this.read(name);
    document.cookie = name + "=0; expires=" + exp.toGMTString() + "; path=/" + domain; 
  }
};

cntvuc.Element = {
  getStyle: function(element, style) {
   var elem = typeof element == "string" ? document.getElementById(element) : element;
    if (cntvuc.util.Arrays.contains(['float','cssFloat'], style.toLowerCase())) {
      style = (typeof elem.style.styleFloat != 'undefined' ? 'styleFloat' : 'cssFloat');
    }
    var value = elem.style[style];
    if (!value) {
      if (document.defaultView && document.defaultView.getComputedStyle) {
        var css = document.defaultView.getComputedStyle(elem, null);
        value = css ? css[style] : null;
      } else if (elem.currentStyle) {
        value = elem.currentStyle[style];
      }
    }
    if((value == 'auto') && (cntvuc.util.Arrays.contains(['width','height'], style.toLowerCase())) && (this.getStyle(elem, 'display') != 'none')) {
      value = elem['offset'+style.charAt(0).toUpperCase()+style.substring(1, style.length)] + 'px';
    }
    if (window.opera && (cntvuc.util.Arrays.contains(['left', 'top', 'right', 'botcntvuc'], style.toLowerCase()))) {
      if (this.getStyle(elem, 'position') == 'static') value = 'auto';
    }
    if(style == 'opacity') {
      if(value) return parseFloat(value);
      if(value = (elem.getStyle('filter') || '').match(/alpha\(opacity=(.*)\)/))
        if(value[1]) return parseFloat(value[1]) / 100;
      return 1.0;
    }
    return value == 'auto' ? null : value;
  },

  setStyle: function(element, style, value) {
    var elem = typeof element == "string" ? document.getElementById(element) : element;
    if(style == 'opacity') {
      if (value == 1) {
        value = (/Gecko/.test(navigator.userAgent) &&
          !/Konqueror|Safari|KHTML/.test(navigator.userAgent)) ? 0.999999 : 1.0;
        if(/MSIE/.test(navigator.userAgent) && !window.opera)
          elem.style.filter = elem.getStyle('filter').replace(/alpha\([^\)]*\)/gi,'');
      } else if(value === '') {
        if(/MSIE/.test(navigator.userAgent) && !window.opera)
          elem.style.filter = elem.getStyle('filter').replace(/alpha\([^\)]*\)/gi,'');
      } else {
        if(value < 0.00001) value = 0;
        if(/MSIE/.test(navigator.userAgent) && !window.opera)
          elem.style.filter = elem.getStyle('filter').replace(/alpha\([^\)]*\)/gi,'') +
            'alpha(opacity='+value*100+')';
      }
    } else if(cntvuc.util.Arrays.contains(name, ['float','cssFloat'])) {
    	name = (typeof elem.style.styleFloat != 'undefined') ? 'styleFloat' : 'cssFloat';
    }
    elem.style[style] = value;
    return elem;
  }
};

cntvuc.Position = {
  pointer: function(e) {
    return {x: (e.pageX || e.clientX), y: (e.pageY || e.clientY)};
  },
  pointerX: function(e) {
    return e.clientX || (e.pageX - cntvuc.Position.getWindowScrollLeft());
  },
  pointerY: function(e) {
    return e.clientY || (e.pageY - cntvuc.Position.getWindowScrollTop());
  },
  prepare: function() {
    this.deltaX = window.pageXOffset || document.documentElement.scrollLeft || document.body.scrollLeft || 0;
    this.deltaY =  window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
  },
  cumulativeOffset: function(elem, o) {
    var x = 0, y = 0;
    do {
      y += elem.offsetTop  || 0;
      x += elem.offsetLeft || 0;
      elem = elem.offsetParent;
    } while (elem);
    o = o || {};
    o.left = x;
    o.top = y;
    return o;
  },
  within: function(elem, x, y) {
    if (this.includeScrollOffsets)
      return this.withinIncludingScrolloffsets(elem, x, y);
    this.xcomp = x;
    this.ycomp = y;
    this.offset = this.cumulativeOffset(elem);
    return (y >= this.offset.top &&
            y <  this.offset.top + elem.offsetHeight &&
            x >= this.offset.left &&
            x <  this.offset.left + elem.offsetWidth);
  },
  withinVertical: function(elem, x) {
    this.offset = this.cumulativeOffset(elem);
    return (x >= this.offset.left && x < this.offset.left + elem.offsetWidth);
  },
  withinHorizontal: function(elem, y) {
    this.offset = this.cumulativeOffset(elem);
    return (y >= this.offset.top && y < this.offset.top + elem.offsetHeight);
  },
  withinIncludingScrolloffsets: function(elem, x, y) {
    var offsetcache = this.realOffset(elem);
    this.xcomp = x + offsetcache.left - this.deltaX;
    this.ycomp = y + offsetcache.top - this.deltaY;
    this.offset = this.cumulativeOffset(elem);
    return (this.ycomp >= this.offset.top &&
            this.ycomp <  this.offset.top + elem.offsetHeight &&
            this.xcomp >= this.offset.left &&
            this.xcomp <  this.offset.left + elem.offsetWidth);
  },
  bound: function(elem) {
  	var pos = this.cumulativeOffset(elem);
    return { x: pos.left, y: pos.top, w: elem.offsetWidth, h: elem.offsetHeight };
  },
  makeBound: function(el, bd) {
    this.cumulativeOffset(el, bd);
    bd.x = bd.left;
    bd.y = bd.top;
    bd.w = el.offsetWidth;
    bd.h = el.offsetHeight;
    return bd;
  },
  getWindowClientWidth: function() {
    return window.innerWidth 
        || document.documentElement.clientWidth
        || document.body.clientWidth
        || 0;
  },
  getWindowClientHeight: function() {
    return window.innerHeight 
        || document.documentElement.clientHeight
        || document.body.clientHeight
        || 0;
  },
  getWindowScrollWidth: function() {
    return window.scrollWidth 
        || document.documentElement.scrollWidth
        || document.body.scrollWidth;
  },
  getWindowScrollHeight: function() {
    return window.scrollHeight
        || document.documentElement.scrollHeight
        || document.body.scrollHeight;
  },
  getWindowScrollLeft: function() {
    if (window.scrollWidth) {
      return window.scrollLeft;
    } else if (document.documentElement.scrollWidth) {
      return document.documentElement.scrollLeft;
    } else if (document.body.scrollWidth) {
      return document.body.scrollLeft
    } else {
      return 0;
    }
  },
  getWindowScrollTop: function() {
    if (window.scrollWidth) {
      return window.scrollTop;
    } else if (document.documentElement.scrollWidth) {
      return document.documentElement.scrollTop;
    } else if (document.body.scrollWidth) {
      return document.body.scrollTop;
    } else {
      return 0;
    }
  },
  getPageSize:function(){
		var xScroll, yScroll;
		if (window.innerHeight && window.scrollMaxY) {   
			xScroll = document.body.scrollWidth;
			yScroll = window.innerHeight + window.scrollMaxY;
		} else if (document.body.scrollHeight > document.body.offsetHeight){ // all but Explorer Mac
			xScroll = document.body.scrollWidth;
			yScroll = document.body.scrollHeight;
		} else { // Explorer Mac...would also work in Explorer 6 Strict, Mozilla and Safari
			xScroll = document.body.offsetWidth;
			yScroll = document.body.offsetHeight;
		}
		var windowWidth, windowHeight;
		if (self.innerHeight) {    // all except Explorer
			windowWidth = self.innerWidth;
			windowHeight = self.innerHeight;
		} else if (document.documentElement && document.documentElement.clientHeight) { // Explorer 6 Strict Mode
			windowWidth = document.documentElement.clientWidth;
			windowHeight = document.documentElement.clientHeight;
		} else if (document.body) { // other Explorers
			windowWidth = document.body.clientWidth;
			windowHeight = document.body.clientHeight;
		}   
		// for small pages with total height less then height of the viewport
		if(yScroll < windowHeight){
			pageHeight = windowHeight;
		} else {
			pageHeight = yScroll;
		}
		// for small pages with total width less then width of the viewport
		if(xScroll < windowWidth){   
			pageWidth = windowWidth;
		} else {
			pageWidth = xScroll;
		}
		arrayPageSize = new Array(pageWidth,pageHeight,windowWidth,windowHeight)
		return arrayPageSize;
	}

};

cntvuc.Effect = {
  setOpacity: function(elem, val) {
    if (document.all) {
      elem.style.filter = "alpha(opacity=" + val * 100 + ")";
    } else {
      elem.style.opacity = val;
    }
  }
};

cntvuc.Image = {
  resizeImage: function(img, mw, mh) {
    var w = img.offsetWidth;
    var h = img.offsetHeight;
    if (w / h >= mw / mh) {
      if (w >= mw) {
	    img.style.width = mw + "px";
	  }
    } else {
      if (h >= mh) {
        img.style.height = mh + "px";
	  }
    }
  }
};

/*
 * 提示框（类似alert）
 * msg: 提示信息
 * ico：图标，OK/ERROR/INFO
 * fn: 关闭提示框后执行的回调函数。（可选）
 * extData: {autoHide: 0, etc...} 其他附加数据(可选)
 *		autoHide: 自动关闭的时间，如不添则不自动隐藏。（可选）
 */
cntvuc.alert = function(msg, fn, extData) {
  cntvuc.config.alert.getCallBack()(msg, fn, extData);
}

cntvuc.closeDlg = function(){
  if(document.getElementById('cntvucmask'))document.body.removeChild(document.getElementById('cntvucmask'));
  if(document.getElementById('cntvucalert'))document.body.removeChild(document.getElementById('cntvucalert'));
}
/*
 * 确认框（类似alert）
 * msg: 提示信息
 * fnOk: 点击ok按钮的回调函数。
 * fnCancel: 点击cancel的回调函数。
 * extData: {title: 0, etc...} 其他附加数据(可选)
 * 			title: 标题栏文字（可选）
 */
cntvuc.confirm = function(msg, fnOk, fnCancel, extData) {
  cntvuc.config.confirm.getCallBack()(msg, fnOk, fnCancel, extData);
}

/*
 * 提示框（只是一个div）
 * msg: 提示信息
 * autoHide: 自动关闭的时间，如不添则不自动隐藏。
 * fn: 关闭提示框后执行的回调函数。（可选）
 */
cntvuc.information = function(msg, autoHide, fn) {
  cntvuc.config.information.getCallBack()(msg, autoHide, fn);
}

cntvuc.title = function(string) {
  document.title=string+" - 央视网社区";
}

////////////////// Default Config /////////////////////////////
cntvuc.config = {
  alert: {
  	_fnCallBack: function(msg, fn, extData) {
	  extData = extData?extData:{};
	  var digwidth = extData.width?extData.width:260;
  	  var cb = fn ?  fn : function(){cntvuc.closeDlg()};
	  var pagesize = cntvuc.Position.getPageSize();
	  var pageWidth=pagesize[0];
	  var pageHeight=pagesize[1];
	  var windowWidth=pagesize[2];
	  var windowHeight=pagesize[3];
	  var mask = document.createElement("div");
      mask.setAttribute("id","cntvucmask");
      mask.style.width = pageWidth+'px';
      mask.style.height = pageHeight+'px';
      mask.style.zIndex = "9999999998";
      mask.style.position = "absolute";
	  mask.style.top = 0;
	  mask.style.left= 0;
      mask.style.filter = "alpha(opacity=50)";
      mask.style.opacity = 0.5;
      mask.style.background = "#000";
      document.body.appendChild(mask);
	
	  var alertDlg = document.createElement("div");
      alertDlg.setAttribute("id","cntvucalert");
	  alertDlg.style.position = "absolute";
	  alertDlg.style.padding = "5px";
	  alertDlg.style.background = "#ccc";

	  alertDlg.style.width = ''+digwidth+"px";
	  alertDlg.style.zIndex = "9999999999";
	  alertDlg.innerHTML='<div class="poptit"><span class="windowtit">操作提示</span><span class="windowclose"><img src="/theme/default/include/images/popclose.gif" id="cntvucDlgCloseIco" ></span></div><div class="popcon pop-p-30"><div class="popcon-con">'+msg+'</div><div class="popcon-btn pop-t-c"><a href="#" onclick="cntvuc.closeDlg();return false" id="cntvucDlgCloseBtn" class="modbtn"><b>确定</b></a></div></div>';
	  
	  document.body.appendChild(alertDlg);
	  var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
      alertDlg.style.top = scrollTop+(windowHeight-alertDlg.offsetHeight)/3+'px';
	  alertDlg.style.left = (windowWidth-digwidth)/2+'px';
	  document.getElementById('cntvucDlgCloseIco').onclick=function(){cb();cntvuc.closeDlg()};
	  document.getElementById('cntvucDlgCloseBtn').onclick=function(){cb();cntvuc.closeDlg()}
  	},
  	getCallBack: function() {
  	  return this._fnCallBack;
  	}
  },
  information: {
  	_fnCallBack: function(msg, autoHide, fn) {
      var cb = fn ? ((fn instanceof Function) ? fn : ((typeof(fn) == "string") ? new Function("e", fn) : cntvuc.fnTrue)) : cntvuc.fnTrue;
      alert(msg);
      cb();
  	},
  	getCallBack: function() {
  	  return this._fnCallBack;
  	}
  },
  confirm: {
  	_fnCallBack: function(msg, fnOk, fnCancel, extData) {
      var cbOk = fnOk ? ((fnOk instanceof Function) ? fnOk : ((typeof(fnOk) == "string") ? new Function("e", fnOk) : cntvuc.fnTrue)) : cntvuc.fnTrue;
      var cbCancel = fnCancel ? ((fnCancel instanceof Function) ? fnCancel : ((typeof(fnCancel) == "string") ? new Function("e", fnCancel) : cntvuc.fnTrue)) : cntvuc.fnTrue;
      confirm(msg) ? cbOk() : cbCancel();
  	},
  	getCallBack: function() {
  	  return this._fnCallBack;
  	}
  },
  login: {
  	_fnCallBack: function(backUrl) {
      alert("TODO. back to " + backUrl);
  	},
  	getCallBack: function() {
  	  return this._fnCallBack;
  	}
  }
};

})();
