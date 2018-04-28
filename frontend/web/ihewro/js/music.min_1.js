/*! handsome 2017-10-17 */

function runImg(){$("#music-img").addClass("runImg"),$(".runMusic").html('<i onclick="stopMusic();" class="fa fa-pause-circle-o runMusicIcon" ></i>')}function stopImg(){$("#music-img").removeClass("runImg"),$(".runMusic").html('<i onclick="playMusic();" class="fa fa-play-circle-o runMusicIcon" ></i>')}function lastMusic(){player.prev(),runImg(),$(".runMusicIcon").removeClass("fa-play-circle-o"),$(".runMusicIcon").addClass("fa-pause-circle-o")}function nextMusic(){player.next(),runImg(),$(".runMusicIcon").removeClass("fa-play-circle-o"),$(".runMusicIcon").addClass("fa-pause-circle-o")}function stopMusic(){stopImg(),player.pause()}function playMusic(){player.play(),runImg()}function stopMusic(){$(".runMusic").html('<i onclick="playMusic();" class="fa fa-play-circle-o runMusicIcon" ></i>'),stopImg(),player.pause()}!function(a,b){"object"==typeof exports&&"object"==typeof module?module.exports=b():"function"==typeof define&&define.amd?define("skPlayer",[],b):"object"==typeof exports?exports.skPlayer=b():a.skPlayer=b()}(this,function(){return function(a){function b(d){if(c[d])return c[d].exports;var e=c[d]={i:d,l:!1,exports:{}};return a[d].call(e.exports,e,e.exports,b),e.l=!0,e.exports}var c={};return b.m=a,b.c=c,b.d=function(a,c,d){b.o(a,c)||Object.defineProperty(a,c,{configurable:!1,enumerable:!0,get:d})},b.n=function(a){var c=a&&a.__esModule?function(){return a.default}:function(){return a};return b.d(c,"a",c),c},b.o=function(a,b){return Object.prototype.hasOwnProperty.call(a,b)},b.p="",b(b.s=0)}([function(a,b,c){var d=function(){function a(a,b){for(var c=0;c<b.length;c++){var d=b[c];d.enumerable=d.enumerable||!1,d.configurable=!0,"value"in d&&(d.writable=!0),Object.defineProperty(a,d.key,d)}}return function(b,c,d){return c&&a(b.prototype,c),d&&a(b,d),b}}();c(1);var e={leftDistance:function(a){for(var b=a.offsetLeft,c=void 0;a.offsetParent;)a=a.offsetParent,b+=a.offsetLeft;return c=document.body.scrollLeft+document.documentElement.scrollLeft,b-c},timeFormat:function(a){var b=parseInt(a/60);return a=parseInt(a%60),(10>b?"0"+b:b)+":"+(10>a?"0"+a:a)},percentFormat:function(a){return(100*a).toFixed(2)+"%"},ajax:function(a){a.beforeSend&&a.beforeSend();var b=new XMLHttpRequest;b.onreadystatechange=function(){4===b.readyState&&(200<=b.status&&300>b.status?a.success&&a.success(b.responseText):a.fail&&a.fail(b.status))},b.open("GET",a.url),b.send(null)}},f=!1;b=function(){function a(b){var c=this;if(!(this instanceof a))throw new TypeError("Cannot call a class as a function");if(f)return console.error("SKPlayer只能存在一个实例！"),Object.create(null);f=!0;var d,g={element:document.getElementById("skPlayer"),autoplay:!1,mode:"listloop",listshow:!0};for(d in g)b.hasOwnProperty(d)||(b[d]=g[d]);if(this.option=b,!(this.option.music&&this.option.music.type&&this.option.music.source))return console.error("请正确配置对象！"),Object.create(null);this.root=this.option.element,this.type=this.option.music.type,this.music=this.option.music.source,this.media=this.option.music.media,this.isMobile=/mobile/i.test(window.navigator.userAgent),this.toggle=this.toggle.bind(this),this.toggleList=this.toggleList.bind(this),this.toggleMute=this.toggleMute.bind(this),this.switchMode=this.switchMode.bind(this),"file"===this.type?(this.root.innerHTML=this.template(),this.init(),this.bind()):"cloud"===this.type&&(this.root.innerHTML='<p class="skPlayer-tip-loading"><span></span> <span></span> <span></span> <span></span><span></span></p>',e.ajax({url:LocalConst.BASE_SCRIPT_URL+"libs/Get.php?id="+this.music+"&type=collect&media="+this.media,beforeSend:function(){},success:function(a){setTimeout(function(){c.music=JSON.parse(a),c.root.innerHTML=c.template(),c.init(),c.bind()},3e3)},fail:function(a){stopImg(),console.error("错误码："+a)}}))}return d(a,[{key:"template",value:function(){var a,b='\n            <audio class="skPlayer-source" preload="auto"><source src="'+("file"===this.type?this.music[0].src:"")+'" type="audio/mpeg"></audio>\n            <div class="skPlayer-picture">\n                <img class="skPlayer-cover" src="'+this.music[0].cover+'" id="music-img">\n                <a href="javascript:;" class="skPlayer-play-btn">\n                    <span class="skPlayer-left"></span>\n                    <span class="skPlayer-right"></span>\n                </a>\n            </div>\n            <div class="skPlayer-control">\n                <p class="skPlayer-name">'+this.music[0].name+'</p>\n   <div class="playController"><div onclick="lastMusic();" class="lastMusic  music-off "><i class="fa fa-angle-double-left"></i></div> &nbsp;&nbsp;\n <div class="runMusic  music-off "><i onclick="playMusic();" class="fa fa-play-circle-o runMusicIcon" ></i></div>&nbsp;&nbsp; \n <div onclick="nextMusic();" class="nextMusic  music-off "><i class="fa fa-angle-double-right"></i></div></div> \n             <p class="skPlayer-author">'+this.music[0].author+'</p>\n                <div class="skPlayer-percent">\n                    <div class="skPlayer-line-loading"></div>\n                    <div class="skPlayer-line"></div>\n                </div>\n                <p class="skPlayer-time">\n                    <span class="skPlayer-cur">00:00</span>/<span class="skPlayer-total">00:00</span>\n                </p>\n                <div class="skPlayer-volume" style="'+(this.isMobile?"display:none;":"")+'">\n                    <i class="skPlayer-icon"></i>\n                    <div class="skPlayer-percent">\n                        <div class="skPlayer-line"></div>\n                    </div>\n                </div>\n                              </div><div class="skPlayer-list-switch"></div>\n                <i class="'+("singleloop"===this.option.mode?"skPlayer-mode skPlayer-mode-loop":"skPlayer-mode")+'"></i>\n            </div>\n            <ul class="skPlayer-list">\n        ';for(a in this.music)b+='\n                <li data-index="'+a+'">\n                    <i class="skPlayer-list-sign"></i>\n                    <span class="skPlayer-list-index">'+(parseInt(a)+1)+'</span>\n                    <span class="skPlayer-list-name" title="'+this.music[a].name+'">'+this.music[a].name+'</span>\n                    <span class="skPlayer-list-author" title="'+this.music[a].author+'">'+this.music[a].author+"</span>\n                </li>\n            ";return b+"\n            </ul>\n        "}},{key:"init",value:function(){var a=this;this.dom={cover:this.root.querySelector(".skPlayer-cover"),playbutton:this.root.querySelector(".skPlayer-play-btn"),name:this.root.querySelector(".skPlayer-name"),author:this.root.querySelector(".skPlayer-author"),timeline_total:this.root.querySelector(".skPlayer-percent"),timeline_loaded:this.root.querySelector(".skPlayer-line-loading"),timeline_played:this.root.querySelector(".skPlayer-percent .skPlayer-line"),timetext_total:this.root.querySelector(".skPlayer-total"),timetext_played:this.root.querySelector(".skPlayer-cur"),volumebutton:this.root.querySelector(".skPlayer-icon"),volumeline_total:this.root.querySelector(".skPlayer-volume .skPlayer-percent"),volumeline_value:this.root.querySelector(".skPlayer-volume .skPlayer-line"),switchbutton:this.root.querySelector(".skPlayer-list-switch"),modebutton:this.root.querySelector(".skPlayer-mode"),musiclist:this.root.querySelector(".skPlayer-list"),musicitem:this.root.querySelectorAll(".skPlayer-list li")},this.audio=this.root.querySelector(".skPlayer-source"),this.option.listshow&&(this.root.className="skPlayer-list-on"),"singleloop"===this.option.mode&&(this.audio.loop=!0),this.dom.musicitem[0].className="skPlayer-curMusic","cloud"===this.type&&e.ajax({url:LocalConst.BASE_SCRIPT_URL+"libs/Get.php?id="+this.music[0].song_id+"&type=song&media="+this.media,beforeSend:function(){},success:function(b){b=JSON.parse(b).url,a.audio.children[0].src=b,isLoaded=!1,lastRunTime=Date.now()},fail:function(a){stopImg(),console.error("错误码："+a)}})}},{key:"bind",value:function(){var a=this;this.updateLine=function(){var b=a.audio.buffered.length?a.audio.buffered.end(a.audio.buffered.length-1)/a.audio.duration:0;a.dom.timeline_loaded.style.width=e.percentFormat(b)},this.audio.addEventListener("durationchange",function(b){a.dom.timetext_total.innerHTML=e.timeFormat(a.audio.duration),a.updateLine()}),this.audio.addEventListener("progress",function(b){a.updateLine()}),this.audio.addEventListener("canplay",function(b){a.option.autoplay&&!a.isMobile&&a.play()}),this.audio.addEventListener("timeupdate",function(b){a.dom.timeline_played.style.width=e.percentFormat(a.audio.currentTime/a.audio.duration),a.dom.timetext_played.innerHTML=e.timeFormat(a.audio.currentTime)}),this.audio.addEventListener("seeked",function(b){a.play()}),this.audio.addEventListener("ended",function(b){a.next()}),this.dom.playbutton.addEventListener("click",this.toggle),this.dom.switchbutton.addEventListener("click",this.toggleList),this.isMobile||this.dom.volumebutton.addEventListener("click",this.toggleMute),this.dom.modebutton.addEventListener("click",this.switchMode),this.dom.musiclist.addEventListener("click",function(b){var c=void 0,d=c=void 0;if(setTimeout(function(){runImg()},1500),"LI"===b.target.tagName.toUpperCase())c=b.target;else{if("LI"!==b.target.parentElement.tagName.toUpperCase())return;c=b.target.parentElement}c=parseInt(c.getAttribute("data-index")),d=parseInt(a.dom.musiclist.querySelector(".skPlayer-curMusic").getAttribute("data-index")),c===d?a.play():a.switchMusic(c+1)}),this.dom.timeline_total.addEventListener("click",function(b){b=((b||window.event).clientX-e.leftDistance(a.dom.timeline_total))/a.dom.timeline_total.clientWidth,isNaN(a.audio.duration)||(a.dom.timeline_played.style.width=e.percentFormat(b),a.dom.timetext_played.innerHTML=e.timeFormat(b*a.audio.duration),a.audio.currentTime=b*a.audio.duration)}),this.isMobile||this.dom.volumeline_total.addEventListener("click",function(b){b=((b||window.event).clientX-e.leftDistance(a.dom.volumeline_total))/a.dom.volumeline_total.clientWidth,a.dom.volumeline_value.style.width=e.percentFormat(b),a.audio.volume=b,a.audio.muted&&a.toggleMute()})}},{key:"prev",value:function(){var a=parseInt(this.dom.musiclist.querySelector(".skPlayer-curMusic").getAttribute("data-index"));0===a?1===this.music.length?this.play():this.switchMusic(this.music.length-1+1):this.switchMusic(a-1+1)}},{key:"next",value:function(){var a=parseInt(this.dom.musiclist.querySelector(".skPlayer-curMusic").getAttribute("data-index"));a===this.music.length-1?1===this.music.length?this.play():this.switchMusic(1):this.switchMusic(a+1+1)}},{key:"switchMusic",value:function(a){var b=this;return"number"!=typeof a?void console.error("请输入正确的歌曲序号！"):0>--a||a>=this.music.length?void console.error("请输入正确的歌曲序号！"):a==this.dom.musiclist.querySelector(".skPlayer-curMusic").getAttribute("data-index")?void this.play():(this.dom.musiclist.querySelector(".skPlayer-curMusic").classList.remove("skPlayer-curMusic"),this.dom.musicitem[a].classList.add("skPlayer-curMusic"),this.dom.name.innerHTML=this.music[a].name,this.dom.author.innerHTML=this.music[a].author,this.dom.cover.src=this.music[a].cover,void("file"===this.type?(this.audio.children[0].src=this.music[a].src,alert("unkonwn info"),this.play()):"cloud"===this.type&&e.ajax({url:LocalConst.BASE_SCRIPT_URL+"libs/Get.php?id="+this.music[a].song_id+"&type=song&media="+this.media,beforeSend:function(){},success:function(a){a=JSON.parse(a).url,b.audio.children[0].src=a,b.audio.played&&b.audio.pause(),isLoaded=!1,console.log("this is switch music + isloaded = "+isLoaded);var c=Date.now();"undefined"!=typeof lastRunTime&&c-lastRunTime<100||(lastRunTime=Date.now(),b.play())},fail:function(a){stopImg(),console.error("错误码："+a)}})))}},{key:"play",value:function(){this.audio.paused&&(isLoaded||(this.audio.load(),isLoaded=!0),this.audio.play(),this.dom.playbutton.classList.add("skPlayer-pause"),this.dom.cover.classList.add("skPlayer-pause"))}},{key:"pause",value:function(){this.audio.paused||(this.audio.pause(),this.dom.playbutton.classList.remove("skPlayer-pause"),this.dom.cover.classList.remove("skPlayer-pause"))}},{key:"toggle",value:function(){this.audio.paused?this.play():this.pause()}},{key:"toggleList",value:function(){var a=document.getElementsByClassName("skPlayer-list")[0];this.root.classList.contains("skPlayer-list-on")?(this.root.classList.remove("skPlayer-list-on"),void 0!==a&&a.classList.remove("pulse")):(this.root.classList.add("skPlayer-list-on"),void 0!==a&&a.classList.add("pulse","animated"))}},{key:"toggleMute",value:function(){this.audio.muted?(this.audio.muted=!1,this.dom.volumebutton.classList.remove("skPlayer-quiet"),this.dom.volumeline_value.style.width=e.percentFormat(this.audio.volume)):(this.audio.muted=!0,this.dom.volumebutton.classList.add("skPlayer-quiet"),this.dom.volumeline_value.style.width="0%")}},{key:"switchMode",value:function(){this.audio.loop?(this.audio.loop=!1,this.dom.modebutton.classList.remove("skPlayer-mode-loop")):(this.audio.loop=!0,this.dom.modebutton.classList.add("skPlayer-mode-loop"))}},{key:"destroy",value:function(){f=!1,this.audio.pause(),this.root.innerHTML="";for(var a in this)delete this[a];console.log("该实例已销毁，可重新配置 ...")}}]),a}(),a.exports=b},function(a,b,c){b=c(2),"string"==typeof b&&(b=[[a.i,b,""]]),c(4)(b,{transform:void 0}),b.locals&&(a.exports=b.locals)},function(a,b,c){b=a.exports=c(3)(void 0),b.push([a.i,"",""])},function(a,b){function c(a,b){var c=a[1]||"",d=a[3];if(!d)return c;if(b&&"function"==typeof btoa){var e="/*# sourceMappingURL=data:application/json;charset=utf-8;base64,"+btoa(unescape(encodeURIComponent(JSON.stringify(d))))+" */";return[c].concat(d.sources.map(function(a){return"/*# sourceURL="+d.sourceRoot+a+" */"})).concat([e]).join("\n")}return""+c}a.exports=function(a){var b=[];return b.toString=function(){return this.map(function(b){var d=c(b,a);return b[2]?"@media "+b[2]+"{"+d+"}":d}).join("")},b.i=function(a,c){"string"==typeof a&&(a=[[null,a,""]]);for(var d={},e=0;e<this.length;e++){var f=this[e][0];"number"==typeof f&&(d[f]=!0)}for(e=0;e<a.length;e++)f=a[e],"number"==typeof f[0]&&d[f[0]]||(c&&!f[2]?f[2]=c:c&&(f[2]="("+f[2]+") and ("+c+")"),b.push(f))},b}},function(a,b,c){function d(a,b){for(var c=0;c<a.length;c++){var d=a[c],e=o[d.id];if(e){e.refs++;for(var f=0;f<e.parts.length;f++)e.parts[f](d.parts[f]);for(;f<d.parts.length;f++)e.parts.push(k(d.parts[f],b))}else{for(e=[],f=0;f<d.parts.length;f++)e.push(k(d.parts[f],b));o[d.id]={id:d.id,refs:1,parts:e}}}}function e(a,b){for(var c=[],d={},e=0;e<a.length;e++){var f=a[e],g=b.base?f[0]+b.base:f[0];f={css:f[1],media:f[2],sourceMap:f[3]},d[g]?d[g].parts.push(f):c.push(d[g]={id:g,parts:[f]})}return c}function f(a,b){var c=q(a.insertInto);if(!c)throw Error("Couldn't find a style target. This probably means that the value for the 'insertInto' parameter is invalid.");var d=t[t.length-1];if("top"===a.insertAt)d?d.nextSibling?c.insertBefore(b,d.nextSibling):c.appendChild(b):c.insertBefore(b,c.firstChild),t.push(b);else{if("bottom"!==a.insertAt)throw Error("Invalid value for parameter 'insertAt'. Must be 'top' or 'bottom'.");c.appendChild(b)}}function g(a){if(null===a.parentNode)return!1;a.parentNode.removeChild(a),0<=(a=t.indexOf(a))&&t.splice(a,1)}function h(a){var b=document.createElement("style");return a.attrs.type="text/css",j(b,a.attrs),f(a,b),b}function i(a){var b=document.createElement("link");return a.attrs.type="text/css",a.attrs.rel="stylesheet",j(b,a.attrs),f(a,b),b}function j(a,b){Object.keys(b).forEach(function(c){a.setAttribute(c,b[c])})}function k(a,b){var c;if(b.transform&&a.css){if(!(c=b.transform(a.css)))return function(){};a.css=c}if(b.singleton){c=s++;var d=r||(r=h(b)),e=l.bind(null,d,c,!1),f=l.bind(null,d,c,!0)}else a.sourceMap&&"function"==typeof URL&&"function"==typeof URL.createObjectURL&&"function"==typeof URL.revokeObjectURL&&"function"==typeof Blob&&"function"==typeof btoa?(d=i(b),e=n.bind(null,d,b),f=function(){g(d),d.href&&URL.revokeObjectURL(d.href)}):(d=h(b),e=m.bind(null,d),f=function(){g(d)});return e(a),function(b){b?(b.css!==a.css||b.media!==a.media||b.sourceMap!==a.sourceMap)&&e(a=b):f()}}function l(a,b,c,d){c=c?"":d.css,a.styleSheet?a.styleSheet.cssText=v(b,c):(c=document.createTextNode(c),d=a.childNodes,d[b]&&a.removeChild(d[b]),d.length?a.insertBefore(c,d[b]):a.appendChild(c))}function m(a,b){var c=b.css,d=b.media;if(d&&a.setAttribute("media",d),a.styleSheet)a.styleSheet.cssText=c;else{for(;a.firstChild;)a.removeChild(a.firstChild);a.appendChild(document.createTextNode(c))}}function n(a,b,c){var d=c.css;c=c.sourceMap;var e=void 0===b.convertToAbsoluteUrls&&c;(b.convertToAbsoluteUrls||e)&&(d=u(d)),c&&(d+="\n/*# sourceMappingURL=data:application/json;base64,"+btoa(unescape(encodeURIComponent(JSON.stringify(c))))+" */"),b=new Blob([d],{type:"text/css"}),d=a.href,a.href=URL.createObjectURL(b),d&&URL.revokeObjectURL(d)}var o={},p=function(a){var b;return function(){return void 0===b&&(b=a.apply(this,arguments)),b}}(function(){return window&&document&&document.all&&!window.atob}),q=function(a){var b={};return function(c){return void 0===b[c]&&(b[c]=a.call(this,c)),b[c]}}(function(a){return document.querySelector(a)}),r=null,s=0,t=[],u=c(5);a.exports=function(a,b){if("undefined"!=typeof DEBUG&&DEBUG&&"object"!=typeof document)throw Error("The style-loader cannot be used in a non-browser environment");b=b||{},b.attrs="object"==typeof b.attrs?b.attrs:{},b.singleton||(b.singleton=p()),b.insertInto||(b.insertInto="head"),b.insertAt||(b.insertAt="bottom");var c=e(a,b);return d(c,b),function(a){for(var f=[],g=0;g<c.length;g++){var h=o[c[g].id];h.refs--,f.push(h)}for(a&&d(e(a,b),b),g=0;g<f.length;g++)if(h=f[g],0===h.refs){for(a=0;a<h.parts.length;a++)h.parts[a]();delete o[h.id]}}};var v=function(){var a=[];return function(b,c){return a[b]=c,a.filter(Boolean).join("\n")}}()},function(a,b){a.exports=function(a){var b="undefined"!=typeof window&&window.location;if(!b)throw Error("fixUrls requires window.location");if(!a||"string"!=typeof a)return a;var c=b.protocol+"//"+b.host,d=c+b.pathname.replace(/\/[^\/]*$/,"/");return a.replace(/url\s*\(((?:[^)(]|\((?:[^)(]+|\([^)(]*\))*\))*)\)/gi,function(a,b){var e=b.trim().replace(/^"(.*)"$/,function(a,b){return b}).replace(/^'(.*)'$/,function(a,b){return b});if(/^(#|data:|http:\/\/|https:\/\/|file:\/\/\/)/i.test(e))return a;var f;return f=0===e.indexOf("//")?e:0===e.indexOf("/")?c+e:d+e.replace(/^\.\//,""),"url("+JSON.stringify(f)+")"})}}])});