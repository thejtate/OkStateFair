var iScrollers=[];(function($){$.fn.jScroll=function(){var customOptions={},action="scroll";if(typeof arguments[0]==="string"){action=arguments[0];customOptions=arguments[1];}else{customOptions=arguments[0];}
var options=$.extend({},$.fn.jScroll.defaultOptions,customOptions);return this.each(function(){var id=$(this).attr("id");if(id===undefined||id===""){id=guid();$(this).attr("id",id);}
if(is_ios_5()&&!options.forceIscroll){var type="";if(options.hScroll&&!options.vScroll){type="horizontal";}else if(!options.hScroll&&options.vScroll){type="vertical";}else{type="both";}
if(action==="remove"||options.remove===true){remove_native_scroller(id,type);}else{add_native_scroller(id,type);}}else{if(action==="remove"||options.remove===true){remove_scroller(id);}else{var iScrollersCount=iScrollers.length;var found=false;for(var i=0;i<iScrollersCount;i++){if(iScrollers[i].id===id){remove_scroller(id);break;}}
add_scroller(id,options);}}});};$.fn.jScroll.defaultOptions={hScroll:true,vScroll:true,hScrollbar:true,vScrollbar:true,fixedScrollbar:false,fadeScrollbar:true,hideScrollbar:true,bounce:true,momentum:true,lockDirection:false,forceIscroll:false,zoom:false,useTransition:false,onBeforeScrollStart:function(e){var target=e.target;while(target.nodeType!==1){target=target.parentNode;}
if(target.tagName!=='SELECT'&&target.tagName!=='INPUT'&&target.tagName!=='TEXTAREA'){e.preventDefault();}},remove:false};function add_native_scroller(id,type){$el=$("#"+id).children(0);if(type==="horizontal"){$el.css("overflow-x","scroll");}else if(type==="vertical"){$el.css("overflow-y","scroll");}else{$el.css("overflow","scroll");}
$el.css("-webkit-overflow-scrolling","touch");}
function add_scroller(id,options){setTimeout(function(){var scroller={'id':id,instance:new iScroll(id,options)};iScrollers.push(scroller);},100);}
function guid(){var S4=function(){return(((1+Math.random())*0x10000)|0).toString(16).substring(1);};return(S4()+S4()+"-"+S4()+"-"+S4()+"-"+S4()+"-"+S4()+S4()+S4());}
function is_ios_5(){var ios5=navigator.userAgent.match(/OS 5_[0-9_]+ like Mac OS X/i)!=null;if(ios5){return true;}else{return false;}}
function remove_native_scroller(id,type){$el=$("#"+id).children(0);if(type==="horizontal"){$el.css("overflow-x","");}else if(type==="vertical"){$el.css("overflow-y","");}else{$el.css("overflow","");}
$el.css("-webkit-overflow-scrolling","");}
function remove_scroller(id){for(var i=0;i<iScrollers.length;i++){if(iScrollers[i].id===id){if(iScrollers[i].instance!==null){iScrollers[i].instance.destroy();iScrollers[i].instance=null;break;}}}}})(jQuery);