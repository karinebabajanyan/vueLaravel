(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[3],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Posts/edit.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Posts/edit.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
/* harmony default export */ __webpack_exports__["default"] = ({
  mounted: function mounted() {//
  },
  data: function data() {
    return {
      id: '',
      post: [],
      // title: '',
      // description: '',
      form: new FormData(),
      files: [],
      isClicked: false,
      index: [],
      images: [],
      $refs: '',
      checked: 0,
      seen: true
    };
  },
  methods: {
    showData: function showData() {
      var _this = this;

      axios.get('/api/posts/' + this.$route.query.id).then(function (response) {
        if (response.status === 200) {
          console.log(response);
          _this.post = response.data.post;
        }
      })["catch"](function (error) {
        _this.errors = error.response.data;
      });
    },

    /*
     Handles the uploading of files
    */
    handleFilesUpload: function handleFilesUpload(e) {
      var _this2 = this;

      var vm = this;
      this.index = [];
      var files = e.target.files;
      this.images = [];

      for (var j = 0; j < this.files.length; j++) {
        this.images.push(this.files[j]);
        this.index.push(j);
      }

      var length = this.index.length;

      for (var i = 0; i < files.length; i++) {
        this.files.push(files[i]);
        this.images.push(files[i]);
        this.index.push(length + i);
      }

      if (!this.files.length || this.post.files.length + this.files.length > 10) {
        this.seen = false;
        location.reload();
      } else {
        var _loop = function _loop(_i) {
          var reader = new FileReader();

          reader.onload = function (e) {
            _this2.$refs.image[_i].parentElement.parentElement.style.display = 'block';
            _this2.$refs.image[_i].src = reader.result;
          };

          reader.readAsDataURL(_this2.images[_i]);
        };

        for (var _i = 0; _i < this.images.length; _i++) {
          _loop(_i);
        }
      }

      console.log(this.$refs);
    },

    /*
      Handles the deleting of files
    */
    handleFilesRemove: function handleFilesRemove(key) {
      console.log(this.checked);
    },
    handleFilesDelete: function handleFilesDelete(key) {
      var _this3 = this;

      // console.log(this.post.files[key].id);
      axios["delete"]('/api/posts/' + this.post.files[key].id + '/files').then(function (response) {
        if (response.status === 200) {
          // this.fetchData()  // to refresh table..
          console.log(response);
        }
      })["catch"](function (error) {
        _this3.errors = error.response.data;
      });
    },
    formSubmit: function formSubmit() {}
  },
  created: function created() {
    this.checked = 'old' + parseInt(this.$route.query.cover);
    this.showData();
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Posts/edit.vue?vue&type=template&id=08f38871&scoped=true&":
/*!*************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Posts/edit.vue?vue&type=template&id=08f38871&scoped=true& ***!
  \*************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "container" }, [
    _c("div", { staticClass: "row justify-content-center" }, [
      _c("div", { staticStyle: { width: "80%", margin: "0 auto" } }, [
        _c("div", { staticClass: "form-group" }, [
          _c("div", { staticClass: "large-12 medium-12 small-12 cell" }, [
            _c("label", { staticClass: "btn btn-outline-secondary" }, [
              _vm._v("Files\n                        "),
              _c("input", {
                attrs: {
                  type: "file",
                  id: "files",
                  accept: "image/*",
                  multiple: ""
                },
                on: { change: _vm.handleFilesUpload }
              })
            ])
          ]),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "img-upload-preview" },
            [
              _vm._l(_vm.post.files, function(image, k) {
                return _c(
                  "div",
                  {
                    directives: [
                      {
                        name: "show",
                        rawName: "v-show",
                        value: _vm.seen,
                        expression: "seen"
                      }
                    ],
                    staticClass: "cc-selector-2 previewImage"
                  },
                  [
                    _c("div", [
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.checked,
                            expression: "checked"
                          }
                        ],
                        attrs: { type: "radio", name: "check", id: "old" + k },
                        domProps: {
                          value: "old" + k,
                          checked: _vm._q(_vm.checked, "old" + k)
                        },
                        on: {
                          change: function($event) {
                            _vm.checked = "old" + k
                          }
                        }
                      }),
                      _vm._v(" "),
                      _c(
                        "label",
                        {
                          staticClass: "preview drinkcard-cc",
                          attrs: { for: "old" + k }
                        },
                        [_c("img", { attrs: { src: image.path } })]
                      ),
                      _vm._v(" "),
                      _c(
                        "i",
                        {
                          on: {
                            click: function($event) {
                              return _vm.handleFilesDelete(k)
                            }
                          }
                        },
                        [_vm._v("x")]
                      )
                    ])
                  ]
                )
              }),
              _vm._v(" "),
              _vm._l(_vm.images, function(image, key) {
                return _c(
                  "div",
                  {
                    directives: [
                      {
                        name: "show",
                        rawName: "v-show",
                        value: _vm.seen,
                        expression: "seen"
                      }
                    ],
                    staticClass: "cc-selector-2 previewImage"
                  },
                  [
                    _c("div", [
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.checked,
                            expression: "checked"
                          }
                        ],
                        attrs: {
                          type: "radio",
                          name: "check",
                          id: "new" + key
                        },
                        domProps: {
                          value: "new" + key,
                          checked: _vm._q(_vm.checked, "new" + key)
                        },
                        on: {
                          change: function($event) {
                            _vm.checked = "new" + key
                          }
                        }
                      }),
                      _vm._v(" "),
                      _c(
                        "label",
                        {
                          staticClass: "preview drinkcard-cc",
                          attrs: { for: "new" + key }
                        },
                        [_c("img", { ref: "image", refInFor: true })]
                      ),
                      _vm._v(" "),
                      _c(
                        "i",
                        {
                          on: {
                            click: function($event) {
                              return _vm.handleFilesRemove(key)
                            }
                          }
                        },
                        [_vm._v("x")]
                      )
                    ])
                  ]
                )
              })
            ],
            2
          ),
          _vm._v(" "),
          _c("label", { staticStyle: { width: "100%" } }, [_vm._v("Title:")]),
          _vm._v(" "),
          _c("input", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.post.title,
                expression: "post.title"
              }
            ],
            staticClass: "form-control",
            attrs: { type: "text" },
            domProps: { value: _vm.post.title },
            on: {
              input: function($event) {
                if ($event.target.composing) {
                  return
                }
                _vm.$set(_vm.post, "title", $event.target.value)
              }
            }
          }),
          _vm._v(" "),
          _c("label", [_vm._v("Description:")]),
          _vm._v(" "),
          _c("textarea", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.post.description,
                expression: "post.description"
              }
            ],
            staticClass: "form-control",
            domProps: { value: _vm.post.description },
            on: {
              input: function($event) {
                if ($event.target.composing) {
                  return
                }
                _vm.$set(_vm.post, "description", $event.target.value)
              }
            }
          }),
          _vm._v(" "),
          _c(
            "button",
            {
              staticClass: "btn btn-primary",
              staticStyle: { "margin-top": "10px" },
              on: { click: _vm.formSubmit }
            },
            [_vm._v("Submit")]
          )
        ])
      ])
    ])
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/Posts/edit.vue":
/*!************************************************!*\
  !*** ./resources/js/components/Posts/edit.vue ***!
  \************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _edit_vue_vue_type_template_id_08f38871_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./edit.vue?vue&type=template&id=08f38871&scoped=true& */ "./resources/js/components/Posts/edit.vue?vue&type=template&id=08f38871&scoped=true&");
/* harmony import */ var _edit_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./edit.vue?vue&type=script&lang=js& */ "./resources/js/components/Posts/edit.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _edit_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _edit_vue_vue_type_template_id_08f38871_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _edit_vue_vue_type_template_id_08f38871_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "08f38871",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Posts/edit.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/Posts/edit.vue?vue&type=script&lang=js&":
/*!*************************************************************************!*\
  !*** ./resources/js/components/Posts/edit.vue?vue&type=script&lang=js& ***!
  \*************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_edit_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./edit.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Posts/edit.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_edit_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Posts/edit.vue?vue&type=template&id=08f38871&scoped=true&":
/*!*******************************************************************************************!*\
  !*** ./resources/js/components/Posts/edit.vue?vue&type=template&id=08f38871&scoped=true& ***!
  \*******************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_edit_vue_vue_type_template_id_08f38871_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./edit.vue?vue&type=template&id=08f38871&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Posts/edit.vue?vue&type=template&id=08f38871&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_edit_vue_vue_type_template_id_08f38871_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_edit_vue_vue_type_template_id_08f38871_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);