(function(e){function t(t){for(var r,u,i=t[0],c=t[1],p=t[2],f=0,s=[];f<i.length;f++)u=i[f],Object.prototype.hasOwnProperty.call(o,u)&&o[u]&&s.push(o[u][0]),o[u]=0;for(r in c)Object.prototype.hasOwnProperty.call(c,r)&&(e[r]=c[r]);l&&l(t);while(s.length)s.shift()();return a.push.apply(a,p||[]),n()}function n(){for(var e,t=0;t<a.length;t++){for(var n=a[t],r=!0,i=1;i<n.length;i++){var c=n[i];0!==o[c]&&(r=!1)}r&&(a.splice(t--,1),e=u(u.s=n[0]))}return e}var r={},o={live:0},a=[];function u(t){if(r[t])return r[t].exports;var n=r[t]={i:t,l:!1,exports:{}};return e[t].call(n.exports,n,n.exports,u),n.l=!0,n.exports}u.m=e,u.c=r,u.d=function(e,t,n){u.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:n})},u.r=function(e){"undefined"!==typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},u.t=function(e,t){if(1&t&&(e=u(e)),8&t)return e;if(4&t&&"object"===typeof e&&e&&e.__esModule)return e;var n=Object.create(null);if(u.r(n),Object.defineProperty(n,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var r in e)u.d(n,r,function(t){return e[t]}.bind(null,r));return n},u.n=function(e){var t=e&&e.__esModule?function(){return e["default"]}:function(){return e};return u.d(t,"a",t),t},u.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},u.p="/";var i=window["webpackJsonp"]=window["webpackJsonp"]||[],c=i.push.bind(i);i.push=t,i=i.slice();for(var p=0;p<i.length;p++)t(i[p]);var l=c;a.push([1,"chunk-vendors","chunk-common"]),n()})({1:function(e,t,n){e.exports=n("b754")},b754:function(e,t,n){"use strict";n.r(t);var r=n("5530"),o=(n("e260"),n("e6cf"),n("cca6"),n("a79d"),n("2b0e")),a=function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("v-app",[e.ready?n("video-player",e._b({},"video-player",e.video,!1)):e._e(),n("dev-raw",{attrs:{value:{video:e.video}}})],1)},u=[],i=(n("96cf"),n("1da1")),c=n("c739"),p={data:function(){return{ready:!1,video:{}}},computed:{endpoint:function(){return"video/".concat(this.$app.config.video)}},beforeMount:function(){var e=this;return Object(i["a"])(regeneratorRuntime.mark((function t(){var n,r,o,a;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return t.next=2,e.$app.get(e.endpoint);case 2:if(n=t.sent,n&&n.data){t.next=5;break}return t.abrupt("return",console.log("NOT AVAILABLE"));case 5:if(r=n.data,n.meta)for(o in n.meta)n.meta[o]&&(a=Object(c["a"])(o),r[a]=n.meta[o]);e.video=r,e.ready=!0;case 9:case"end":return t.stop()}}),t)})))()}},l=p,f=n("2877"),s=n("6544"),d=n.n(s),v=n("7496"),b=Object(f["a"])(l,a,u,!1,null,null,null),y=b.exports;d()(b,{VApp:v["a"]});var h=n("4360"),g=n("a078"),m=n("402c"),O=n("df69"),w=n("8c2b"),j=n("906b"),x=n("96d6"),_=[j["a"]];console.log("dev plugin"),o["a"].use(x["a"]),o["a"].use(w["a"]),o["a"].use(O["a"],Object(r["a"])(Object(r["a"])({store:h["a"]},g["a"]),{},{modules:_,config:g["a"]})),o["a"].config.productionTip=!1,new o["a"]({store:h["a"],vuetify:m["a"],render:function(e){return e(y)}}).$mount("#app")}});