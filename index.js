(function () {function c(e,t){var r=Object.keys(e);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(e);t&&(n=n.filter(function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable})),r.push.apply(r,n)}return r}function d(e){for(var t=1;t<arguments.length;t++){var r=null!=arguments[t]?arguments[t]:{};t%2?c(Object(r),!0).forEach(function(t){f(e,t,r[t])}):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(r)):c(Object(r)).forEach(function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(r,t))})}return e}function f(e,t,r){return t in e?Object.defineProperty(e,t,{value:r,enumerable:!0,configurable:!0,writable:!0}):e[t]=r,e}var a={data:function(){return{ratings:[],settings:[],ratingState:{up:0,down:0}}},created:function(){this.load()},methods:{load:function(){var e=this,t=window.localStorage.getItem("k3-rate-page");this.savedRatings=t?JSON.parse(t):[],this.$api.get("ratepage/all").then(function(t){t.ratings.forEach(function(t){var r,n=e.savedRatings.filter(function(e){return e.uid===t.uid})[0];n?(n.state.up=n.up,n.state.down=n.down,r=d({},n,{},t),console.log(r)):r=t,e.ratings.push(r)}),e.settings=t.settings,window.localStorage.setItem("k3-rate-page",JSON.stringify(e.ratings))})}}};if(typeof a==="function"){a=a.options}Object.assign(a,function(){var render=function(){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c("div",{staticClass:"k-ratings"},[_c("k-list",{attrs:{"data-size":"medium"}},_vm._l(_vm.ratings,function(rating){return _c("k-list-item",{key:rating.title,attrs:{"link":rating.url,"info":"\uD83D\uDE42 "+rating.up+" (+"+(rating.up-rating.state.up)+") &nbsp;&nbsp;&nbsp; \uD83D\uDE41 "+rating.down+" (+"+(rating.down-rating.state.down)+")","text":""+rating.title,"target":"_self"}})}),1)],1)};var staticRenderFns=[];return{render:render,staticRenderFns:staticRenderFns,_compiled:true,_scopeId:null,functional:undefined}}());var b={components:{PageRatings:a}};if(typeof b==="function"){b=b.options}Object.assign(b,function(){var render=function(){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c("k-view",{staticClass:"k-ratingviews-view"},[_c("k-header",[_vm._v("Page Ratings")]),_vm._v(" "),_c("k-column",{attrs:{"width":"1/2"}},[_c("PageRatings")],1)],1)};var staticRenderFns=[];return{render:render,staticRenderFns:staticRenderFns,_compiled:true,_scopeId:null,functional:undefined}}());panel.plugin("mauricerenck/ratePage",{views:{ratePage:{component:b,icon:"star",label:"Ratings"}}});})();