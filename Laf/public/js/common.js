$.extend({  
  getParams: function(){  
    var vars = [], hash;  
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');  
    for(var i = 0; i < hashes.length; i++)  
    {  
      hash = hashes[i].split('=');  
      //vars.push(hash[0]);  
      vars[hash[0]] = hash[1];  
    }  
    return vars;  
  },  
  getParam: function(name){  
    return $.getParams()[name];  
  },
  delParam: function(name){
	  var url = window.location.href;
	  if(url.indexOf("?")==-1){
		  return;
	  }
	  if($.getParam(name) == undefined){
		  return;
	  }
	  var resUrl=url.slice(0,url.indexOf('?') + 1);
	  var params=$.getParams();
	  var len=params.length;
	  for(var key in params){
		  if(key==name)continue;
		  resUrl += key+"="+params[key]+"&";
	  }
	  return resUrl.slice(0,resUrl.length-1);
  },
  getPageUrl:function(page){
  	var url=window.location.href;
  	
  	if(url.indexOf('?')==-1){
  		return url+"?page="+page;
  	}
  	
  	if($.getParam("page") == undefined){
  		return url+"&page="+page;
  	}else{
  		url=$.delParam("page");
  		if(url.indexOf("?")==-1){
  			url += "?page="+page;
  		}else{
  			url += "&page="+page;
  		}
  		return url;
  	}
  }
});