(function() {
  "use strict";
  var render$3 = function() {
    var _vm = this;
    var _h = _vm.$createElement;
    var _c = _vm._self._c || _h;
    return _c("k-inside", [_c("k-view", { staticClass: "k-page-ratings-view" }, [_c("k-header", [_vm._v("Page Ratings")]), _c("Version", { attrs: { "version": _vm.version } }), _c("RatingList", { attrs: { "ratingData": _vm.sortedRatingData, "onChangeSorting": _vm.sortRatings, "currentSorting": _vm.currentSorting } }), _c("StarRatingList", { attrs: { "ratingData": _vm.startRatingData } })], 1)], 1);
  };
  var staticRenderFns$3 = [];
  render$3._withStripped = true;
  var View_vue_vue_type_style_index_0_lang = "";
  function normalizeComponent(scriptExports, render2, staticRenderFns2, functionalTemplate, injectStyles, scopeId, moduleIdentifier, shadowMode) {
    var options = typeof scriptExports === "function" ? scriptExports.options : scriptExports;
    if (render2) {
      options.render = render2;
      options.staticRenderFns = staticRenderFns2;
      options._compiled = true;
    }
    if (functionalTemplate) {
      options.functional = true;
    }
    if (scopeId) {
      options._scopeId = "data-v-" + scopeId;
    }
    var hook;
    if (moduleIdentifier) {
      hook = function(context) {
        context = context || this.$vnode && this.$vnode.ssrContext || this.parent && this.parent.$vnode && this.parent.$vnode.ssrContext;
        if (!context && typeof __VUE_SSR_CONTEXT__ !== "undefined") {
          context = __VUE_SSR_CONTEXT__;
        }
        if (injectStyles) {
          injectStyles.call(this, context);
        }
        if (context && context._registeredComponents) {
          context._registeredComponents.add(moduleIdentifier);
        }
      };
      options._ssrRegister = hook;
    } else if (injectStyles) {
      hook = shadowMode ? function() {
        injectStyles.call(this, (options.functional ? this.parent : this).$root.$options.shadowRoot);
      } : injectStyles;
    }
    if (hook) {
      if (options.functional) {
        options._injectStyles = hook;
        var originalRender = options.render;
        options.render = function renderWithStyleInjection(h, context) {
          hook.call(context);
          return originalRender(h, context);
        };
      } else {
        var existing = options.beforeCreate;
        options.beforeCreate = existing ? [].concat(existing, hook) : [hook];
      }
    }
    return {
      exports: scriptExports,
      options
    };
  }
  const __vue2_script$3 = {
    props: {
      ratingData: Array,
      startRatingData: Array,
      version: Object
    },
    data() {
      return {
        sortedRatingData: this.ratingData.top,
        sortedRatingTop: this.ratingData.top,
        sortedRatingWorst: this.ratingData.worst,
        currentSorting: "DESC"
      };
    },
    methods: {
      sortRatings(direction) {
        if (direction === "ASC") {
          this.sortedRatingData = this.sortedRatingWorst;
          this.currentSorting = "ASC";
        } else {
          this.sortedRatingData = this.sortedRatingTop;
          this.currentSorting = "DESC";
        }
      }
    }
  };
  const __cssModules$3 = {};
  var __component__$3 = /* @__PURE__ */ normalizeComponent(__vue2_script$3, render$3, staticRenderFns$3, false, __vue2_injectStyles$3, null, null, null);
  function __vue2_injectStyles$3(context) {
    for (let o in __cssModules$3) {
      this[o] = __cssModules$3[o];
    }
  }
  __component__$3.options.__file = "src/components/View.vue";
  var RatingsView = /* @__PURE__ */ function() {
    return __component__$3.exports;
  }();
  var render$2 = function() {
    var _vm = this;
    var _h = _vm.$createElement;
    var _c = _vm._self._c || _h;
    return _c("div", [_c("k-headline", [_vm._v("Thumb Ratings")]), _c("table", [_c("thead", [_c("tr", [_c("th", [_vm._v("Page")]), _c("th", { staticClass: "clickable", class: {
      active: _vm.currentSorting === "DESC"
    }, on: { "click": function($event) {
      return _vm.onChangeSorting("DESC");
    } } }, [_vm._v(" Upvotes ")]), _c("th", { staticClass: "clickable", class: {
      active: _vm.currentSorting === "ASC"
    }, on: { "click": function($event) {
      return _vm.onChangeSorting("ASC");
    } } }, [_vm._v(" Downvotes ")])])]), _c("tbody", _vm._l(_vm.ratingData, function(rating) {
      return _c("tr", { key: rating.title }, [_c("td", [_vm._v(_vm._s(rating.title))]), _c("td", [_vm._v("\u{1F642} " + _vm._s(rating.up))]), _c("td", [_vm._v("\u{1F641} " + _vm._s(rating.down))])]);
    }), 0)])], 1);
  };
  var staticRenderFns$2 = [];
  render$2._withStripped = true;
  const __vue2_script$2 = {
    props: {
      ratingData: Array,
      onChangeSorting: Function,
      currentSorting: String
    }
  };
  const __cssModules$2 = {};
  var __component__$2 = /* @__PURE__ */ normalizeComponent(__vue2_script$2, render$2, staticRenderFns$2, false, __vue2_injectStyles$2, null, null, null);
  function __vue2_injectStyles$2(context) {
    for (let o in __cssModules$2) {
      this[o] = __cssModules$2[o];
    }
  }
  __component__$2.options.__file = "src/components/RatingList.vue";
  var RatingList = /* @__PURE__ */ function() {
    return __component__$2.exports;
  }();
  var render$1 = function() {
    var _vm = this;
    var _h = _vm.$createElement;
    var _c = _vm._self._c || _h;
    return _c("div", { staticClass: "starrating" }, [_c("k-headline", [_vm._v("Star Ratings")]), _c("table", [_vm._m(0), _c("tbody", _vm._l(_vm.ratingData, function(rating) {
      return _c("tr", { key: rating.title }, [_c("td", [_vm._v(_vm._s(rating.title))]), _c("td", [_vm._v(_vm._s(rating.avg))])]);
    }), 0)])], 1);
  };
  var staticRenderFns$1 = [function() {
    var _vm = this;
    var _h = _vm.$createElement;
    var _c = _vm._self._c || _h;
    return _c("thead", [_c("tr", [_c("th", [_vm._v("Page")]), _c("th", [_vm._v("Avg Rating")])])]);
  }];
  render$1._withStripped = true;
  const __vue2_script$1 = {
    props: {
      ratingData: Array
    }
  };
  const __cssModules$1 = {};
  var __component__$1 = /* @__PURE__ */ normalizeComponent(__vue2_script$1, render$1, staticRenderFns$1, false, __vue2_injectStyles$1, null, null, null);
  function __vue2_injectStyles$1(context) {
    for (let o in __cssModules$1) {
      this[o] = __cssModules$1[o];
    }
  }
  __component__$1.options.__file = "src/components/StarRatingList.vue";
  var StarRatingList = /* @__PURE__ */ function() {
    return __component__$1.exports;
  }();
  var render = function() {
    var _vm = this;
    var _h = _vm.$createElement;
    var _c = _vm._self._c || _h;
    return _c("div", { staticClass: "version-box" }, [_vm.version.error ? _c("span", { staticClass: "error" }, [_c("k-info-field", { attrs: { "theme": "negative", "label": "Sorry", "text": "The current version could not be fetched." } })], 1) : _vm.version.updateAvailable ? _c("span", { staticClass: "version" }, [_c("span", { staticClass: "update-available" }, [_vm._v("Update to " + _vm._s(_vm.version.latest) + " available")]), _vm._v(" / "), _c("span", [_vm._v("Your installed version is " + _vm._s(_vm.version.local) + " ")])]) : _vm._e()]);
  };
  var staticRenderFns = [];
  render._withStripped = true;
  var Version_vue_vue_type_style_index_0_lang = "";
  const __vue2_script = {
    props: {
      version: Object
    }
  };
  const __cssModules = {};
  var __component__ = /* @__PURE__ */ normalizeComponent(__vue2_script, render, staticRenderFns, false, __vue2_injectStyles, null, null, null);
  function __vue2_injectStyles(context) {
    for (let o in __cssModules) {
      this[o] = __cssModules[o];
    }
  }
  __component__.options.__file = "src/components/Version.vue";
  var Version = /* @__PURE__ */ function() {
    return __component__.exports;
  }();
  panel.plugin("mauricerenck/ratePage", {
    components: {
      "k-page-ratings-view": RatingsView,
      "RatingList": RatingList,
      "StarRatingList": StarRatingList,
      "Version": Version
    }
  });
})();
