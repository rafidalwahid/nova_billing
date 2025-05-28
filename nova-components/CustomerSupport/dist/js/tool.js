/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/LoadingSpinner.vue?vue&type=script&lang=js":
/*!********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/LoadingSpinner.vue?vue&type=script&lang=js ***!
  \********************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
// Spinner Icon Component
var SpinnerIcon = {
  template: "\n    <svg class=\"animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500\" fill=\"none\" viewBox=\"0 0 24 24\">\n      <circle class=\"opacity-25\" cx=\"12\" cy=\"12\" r=\"10\" stroke=\"currentColor\" stroke-width=\"4\"></circle>\n      <path class=\"opacity-75\" fill=\"currentColor\" d=\"M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z\"></path>\n    </svg>\n  "
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: 'LoadingSpinner',
  components: {
    SpinnerIcon: SpinnerIcon
  },
  props: {
    message: {
      type: String,
      "default": 'Loading...',
      validator: function validator(value) {
        return typeof value === 'string';
      }
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/TicketDetailsModal.vue?vue&type=script&lang=js":
/*!************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/TicketDetailsModal.vue?vue&type=script&lang=js ***!
  \************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _LoadingSpinner_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./LoadingSpinner.vue */ "./resources/js/components/LoadingSpinner.vue");
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/babel/babel/blob/main/packages/babel-helpers/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return r; }; var t, r = {}, e = Object.prototype, n = e.hasOwnProperty, o = "function" == typeof Symbol ? Symbol : {}, i = o.iterator || "@@iterator", a = o.asyncIterator || "@@asyncIterator", u = o.toStringTag || "@@toStringTag"; function c(t, r, e, n) { Object.defineProperty(t, r, { value: e, enumerable: !n, configurable: !n, writable: !n }); } try { c({}, ""); } catch (t) { c = function c(t, r, e) { return t[r] = e; }; } function h(r, e, n, o) { var i = e && e.prototype instanceof Generator ? e : Generator, a = Object.create(i.prototype); return c(a, "_invoke", function (r, e, n) { var o = 1; return function (i, a) { if (3 === o) throw Error("Generator is already running"); if (4 === o) { if ("throw" === i) throw a; return { value: t, done: !0 }; } for (n.method = i, n.arg = a;;) { var u = n.delegate; if (u) { var c = d(u, n); if (c) { if (c === f) continue; return c; } } if ("next" === n.method) n.sent = n._sent = n.arg;else if ("throw" === n.method) { if (1 === o) throw o = 4, n.arg; n.dispatchException(n.arg); } else "return" === n.method && n.abrupt("return", n.arg); o = 3; var h = s(r, e, n); if ("normal" === h.type) { if (o = n.done ? 4 : 2, h.arg === f) continue; return { value: h.arg, done: n.done }; } "throw" === h.type && (o = 4, n.method = "throw", n.arg = h.arg); } }; }(r, n, new Context(o || [])), !0), a; } function s(t, r, e) { try { return { type: "normal", arg: t.call(r, e) }; } catch (t) { return { type: "throw", arg: t }; } } r.wrap = h; var f = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var l = {}; c(l, i, function () { return this; }); var p = Object.getPrototypeOf, y = p && p(p(x([]))); y && y !== e && n.call(y, i) && (l = y); var v = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(l); function g(t) { ["next", "throw", "return"].forEach(function (r) { c(t, r, function (t) { return this._invoke(r, t); }); }); } function AsyncIterator(t, r) { function e(o, i, a, u) { var c = s(t[o], t, i); if ("throw" !== c.type) { var h = c.arg, f = h.value; return f && "object" == _typeof(f) && n.call(f, "__await") ? r.resolve(f.__await).then(function (t) { e("next", t, a, u); }, function (t) { e("throw", t, a, u); }) : r.resolve(f).then(function (t) { h.value = t, a(h); }, function (t) { return e("throw", t, a, u); }); } u(c.arg); } var o; c(this, "_invoke", function (t, n) { function i() { return new r(function (r, o) { e(t, n, r, o); }); } return o = o ? o.then(i, i) : i(); }, !0); } function d(r, e) { var n = e.method, o = r.i[n]; if (o === t) return e.delegate = null, "throw" === n && r.i["return"] && (e.method = "return", e.arg = t, d(r, e), "throw" === e.method) || "return" !== n && (e.method = "throw", e.arg = new TypeError("The iterator does not provide a '" + n + "' method")), f; var i = s(o, r.i, e.arg); if ("throw" === i.type) return e.method = "throw", e.arg = i.arg, e.delegate = null, f; var a = i.arg; return a ? a.done ? (e[r.r] = a.value, e.next = r.n, "return" !== e.method && (e.method = "next", e.arg = t), e.delegate = null, f) : a : (e.method = "throw", e.arg = new TypeError("iterator result is not an object"), e.delegate = null, f); } function w(t) { this.tryEntries.push(t); } function m(r) { var e = r[4] || {}; e.type = "normal", e.arg = t, r[4] = e; } function Context(t) { this.tryEntries = [[-1]], t.forEach(w, this), this.reset(!0); } function x(r) { if (null != r) { var e = r[i]; if (e) return e.call(r); if ("function" == typeof r.next) return r; if (!isNaN(r.length)) { var o = -1, a = function e() { for (; ++o < r.length;) if (n.call(r, o)) return e.value = r[o], e.done = !1, e; return e.value = t, e.done = !0, e; }; return a.next = a; } } throw new TypeError(_typeof(r) + " is not iterable"); } return GeneratorFunction.prototype = GeneratorFunctionPrototype, c(v, "constructor", GeneratorFunctionPrototype), c(GeneratorFunctionPrototype, "constructor", GeneratorFunction), c(GeneratorFunctionPrototype, u, GeneratorFunction.displayName = "GeneratorFunction"), r.isGeneratorFunction = function (t) { var r = "function" == typeof t && t.constructor; return !!r && (r === GeneratorFunction || "GeneratorFunction" === (r.displayName || r.name)); }, r.mark = function (t) { return Object.setPrototypeOf ? Object.setPrototypeOf(t, GeneratorFunctionPrototype) : (t.__proto__ = GeneratorFunctionPrototype, c(t, u, "GeneratorFunction")), t.prototype = Object.create(v), t; }, r.awrap = function (t) { return { __await: t }; }, g(AsyncIterator.prototype), c(AsyncIterator.prototype, a, function () { return this; }), r.AsyncIterator = AsyncIterator, r.async = function (t, e, n, o, i) { void 0 === i && (i = Promise); var a = new AsyncIterator(h(t, e, n, o), i); return r.isGeneratorFunction(e) ? a : a.next().then(function (t) { return t.done ? t.value : a.next(); }); }, g(v), c(v, u, "Generator"), c(v, i, function () { return this; }), c(v, "toString", function () { return "[object Generator]"; }), r.keys = function (t) { var r = Object(t), e = []; for (var n in r) e.unshift(n); return function t() { for (; e.length;) if ((n = e.pop()) in r) return t.value = n, t.done = !1, t; return t.done = !0, t; }; }, r.values = x, Context.prototype = { constructor: Context, reset: function reset(r) { if (this.prev = this.next = 0, this.sent = this._sent = t, this.done = !1, this.delegate = null, this.method = "next", this.arg = t, this.tryEntries.forEach(m), !r) for (var e in this) "t" === e.charAt(0) && n.call(this, e) && !isNaN(+e.slice(1)) && (this[e] = t); }, stop: function stop() { this.done = !0; var t = this.tryEntries[0][4]; if ("throw" === t.type) throw t.arg; return this.rval; }, dispatchException: function dispatchException(r) { if (this.done) throw r; var e = this; function n(t) { a.type = "throw", a.arg = r, e.next = t; } for (var o = e.tryEntries.length - 1; o >= 0; --o) { var i = this.tryEntries[o], a = i[4], u = this.prev, c = i[1], h = i[2]; if (-1 === i[0]) return n("end"), !1; if (!c && !h) throw Error("try statement without catch or finally"); if (null != i[0] && i[0] <= u) { if (u < c) return this.method = "next", this.arg = t, n(c), !0; if (u < h) return n(h), !1; } } }, abrupt: function abrupt(t, r) { for (var e = this.tryEntries.length - 1; e >= 0; --e) { var n = this.tryEntries[e]; if (n[0] > -1 && n[0] <= this.prev && this.prev < n[2]) { var o = n; break; } } o && ("break" === t || "continue" === t) && o[0] <= r && r <= o[2] && (o = null); var i = o ? o[4] : {}; return i.type = t, i.arg = r, o ? (this.method = "next", this.next = o[2], f) : this.complete(i); }, complete: function complete(t, r) { if ("throw" === t.type) throw t.arg; return "break" === t.type || "continue" === t.type ? this.next = t.arg : "return" === t.type ? (this.rval = this.arg = t.arg, this.method = "return", this.next = "end") : "normal" === t.type && r && (this.next = r), f; }, finish: function finish(t) { for (var r = this.tryEntries.length - 1; r >= 0; --r) { var e = this.tryEntries[r]; if (e[2] === t) return this.complete(e[4], e[3]), m(e), f; } }, "catch": function _catch(t) { for (var r = this.tryEntries.length - 1; r >= 0; --r) { var e = this.tryEntries[r]; if (e[0] === t) { var n = e[4]; if ("throw" === n.type) { var o = n.arg; m(e); } return o; } } throw Error("illegal catch attempt"); }, delegateYield: function delegateYield(r, e, n) { return this.delegate = { i: x(r), r: e, n: n }, "next" === this.method && (this.arg = t), f; } }, r; }
function asyncGeneratorStep(n, t, e, r, o, a, c) { try { var i = n[a](c), u = i.value; } catch (n) { return void e(n); } i.done ? t(u) : Promise.resolve(u).then(r, o); }
function _asyncToGenerator(n) { return function () { var t = this, e = arguments; return new Promise(function (r, o) { var a = n.apply(t, e); function _next(n) { asyncGeneratorStep(a, r, o, _next, _throw, "next", n); } function _throw(n) { asyncGeneratorStep(a, r, o, _next, _throw, "throw", n); } _next(void 0); }); }; }


// Icon Components
var TicketIcon = {
  template: "\n    <svg class=\"w-5 h-5 text-white\" fill=\"none\" viewBox=\"0 0 24 24\" stroke=\"currentColor\">\n      <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z\" />\n    </svg>\n  "
};
var CloseIcon = {
  template: "\n    <svg class=\"w-5 h-5\" fill=\"none\" viewBox=\"0 0 24 24\" stroke=\"currentColor\">\n      <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M6 18L18 6M6 6l12 12\" />\n    </svg>\n  "
};
var SendIcon = {
  template: "\n    <svg class=\"w-4 h-4\" fill=\"none\" viewBox=\"0 0 24 24\" stroke=\"currentColor\">\n      <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M12 19l9 2-9-18-9 18 9-2zm0 0v-8\" />\n    </svg>\n  "
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: 'TicketDetailsModal',
  components: {
    LoadingSpinner: _LoadingSpinner_vue__WEBPACK_IMPORTED_MODULE_0__["default"],
    TicketIcon: TicketIcon,
    CloseIcon: CloseIcon,
    SendIcon: SendIcon
  },
  props: {
    isOpen: {
      type: Boolean,
      "default": false
    },
    ticket: {
      type: Object,
      "default": null
    }
  },
  emits: {
    close: null,
    addResponse: function addResponse(message) {
      return typeof message === 'string' && message.trim().length > 0;
    }
  },
  data: function data() {
    return {
      loading: false,
      responses: [],
      replyMessage: '',
      isSubmitting: false
    };
  },
  computed: {
    canReply: function canReply() {
      return this.ticket && ['open', 'in_progress'].includes(this.ticket.status);
    }
  },
  watch: {
    isOpen: function isOpen(newValue) {
      if (newValue && this.ticket) {
        this.loadResponses();
      }
    }
  },
  methods: {
    loadResponses: function loadResponses() {
      var _this = this;
      return _asyncToGenerator(/*#__PURE__*/_regeneratorRuntime().mark(function _callee() {
        var response;
        return _regeneratorRuntime().wrap(function _callee$(_context) {
          while (1) switch (_context.prev = _context.next) {
            case 0:
              if (_this.ticket) {
                _context.next = 2;
                break;
              }
              return _context.abrupt("return");
            case 2:
              _context.prev = 2;
              _this.loading = true;
              _context.next = 6;
              return Nova.request().get("/nova-vendor/customer-support/tickets/".concat(_this.ticket.id, "/responses"));
            case 6:
              response = _context.sent;
              _this.responses = response.data.data || [];
              _context.next = 14;
              break;
            case 10:
              _context.prev = 10;
              _context.t0 = _context["catch"](2);
              console.error('Failed to load responses:', _context.t0);
              _this.responses = [];
            case 14:
              _context.prev = 14;
              _this.loading = false;
              return _context.finish(14);
            case 17:
            case "end":
              return _context.stop();
          }
        }, _callee, null, [[2, 10, 14, 17]]);
      }))();
    },
    submitReply: function submitReply() {
      var _this2 = this;
      return _asyncToGenerator(/*#__PURE__*/_regeneratorRuntime().mark(function _callee2() {
        var response;
        return _regeneratorRuntime().wrap(function _callee2$(_context2) {
          while (1) switch (_context2.prev = _context2.next) {
            case 0:
              if (!(!_this2.replyMessage.trim() || !_this2.ticket)) {
                _context2.next = 2;
                break;
              }
              return _context2.abrupt("return");
            case 2:
              _context2.prev = 2;
              _this2.isSubmitting = true;
              _context2.next = 6;
              return Nova.request().post("/nova-vendor/customer-support/tickets/".concat(_this2.ticket.id, "/responses"), {
                message: _this2.replyMessage.trim()
              });
            case 6:
              response = _context2.sent;
              _this2.responses.push(response.data.data);
              _this2.replyMessage = '';
              _this2.$emit('addResponse', response.data.data);
              if (_this2.$toasted) {
                _this2.$toasted.success('Reply sent successfully!', {
                  duration: 3000,
                  position: 'top-right'
                });
              }
              _context2.next = 17;
              break;
            case 13:
              _context2.prev = 13;
              _context2.t0 = _context2["catch"](2);
              console.error('Failed to send reply:', _context2.t0);
              if (_this2.$toasted) {
                _this2.$toasted.error('Failed to send reply. Please try again.', {
                  duration: 5000,
                  position: 'top-right'
                });
              }
            case 17:
              _context2.prev = 17;
              _this2.isSubmitting = false;
              return _context2.finish(17);
            case 20:
            case "end":
              return _context2.stop();
          }
        }, _callee2, null, [[2, 13, 17, 20]]);
      }))();
    },
    getStatusBadgeClass: function getStatusBadgeClass(status) {
      var classes = {
        'open': 'bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300 border-blue-200 dark:border-blue-800/30',
        'in_progress': 'bg-yellow-50 dark:bg-yellow-900/20 text-yellow-700 dark:text-yellow-300 border-yellow-200 dark:border-yellow-800/30',
        'resolved': 'bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300 border-green-200 dark:border-green-800/30',
        'closed': 'bg-gray-50 dark:bg-gray-800/50 text-gray-700 dark:text-gray-300 border-gray-200 dark:border-gray-700'
      };
      return classes[status] || classes.closed;
    },
    formatStatus: function formatStatus(status) {
      var statusMap = {
        'open': 'Open',
        'in_progress': 'In Progress',
        'resolved': 'Resolved',
        'closed': 'Closed'
      };
      return statusMap[status] || 'Unknown';
    },
    formatDate: function formatDate(date) {
      if (!date) return '';
      try {
        return new Date(date).toLocaleDateString('en-US', {
          year: 'numeric',
          month: 'short',
          day: 'numeric',
          hour: '2-digit',
          minute: '2-digit'
        });
      } catch (error) {
        return 'Invalid Date';
      }
    },
    getDepartmentName: function getDepartmentName(category) {
      var departmentNames = {
        'billing': 'Billing Support',
        'technical': 'Technical Support',
        'sales': 'Sales Inquiry',
        'general': 'General Support'
      };
      return departmentNames[category] || 'General Support';
    },
    getInitials: function getInitials(name) {
      if (!name) return '?';
      return name.split(' ').map(function (n) {
        return n[0];
      }).join('').toUpperCase().substring(0, 2);
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/TicketFilters.vue?vue&type=script&lang=js":
/*!*******************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/TicketFilters.vue?vue&type=script&lang=js ***!
  \*******************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: 'TicketFilters',
  props: {
    searchQuery: {
      type: String,
      "default": '',
      validator: function validator(value) {
        return typeof value === 'string';
      }
    },
    statusFilter: {
      type: String,
      "default": '',
      validator: function validator(value) {
        return typeof value === 'string';
      }
    },
    departmentFilter: {
      type: String,
      "default": '',
      validator: function validator(value) {
        return typeof value === 'string';
      }
    },
    totalTickets: {
      type: Number,
      "default": 0,
      validator: function validator(value) {
        return typeof value === 'number' && value >= 0;
      }
    }
  },
  emits: {
    'update:searchQuery': function updateSearchQuery(value) {
      return typeof value === 'string';
    },
    'update:statusFilter': function updateStatusFilter(value) {
      return typeof value === 'string';
    },
    'update:departmentFilter': function updateDepartmentFilter(value) {
      return typeof value === 'string';
    },
    'createTicket': null
  },
  setup: function setup() {
    // Filter options
    var statusOptions = [{
      value: '',
      label: 'All Statuses'
    }, {
      value: 'open',
      label: 'Open'
    }, {
      value: 'waiting_customer',
      label: 'Waiting for Your Response'
    }, {
      value: 'resolved',
      label: 'Resolved'
    }, {
      value: 'closed',
      label: 'Closed'
    }];
    var departmentOptions = [{
      value: '',
      label: 'All Departments'
    }, {
      value: 'billing',
      label: 'Billing Support'
    }, {
      value: 'technical',
      label: 'Technical Support'
    }, {
      value: 'sales',
      label: 'Sales Inquiry'
    }, {
      value: 'general',
      label: 'General Support'
    }];
    return {
      statusOptions: statusOptions,
      departmentOptions: departmentOptions
    };
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/TicketList.vue?vue&type=script&lang=js":
/*!****************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/TicketList.vue?vue&type=script&lang=js ***!
  \****************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
// Icon Components
var TicketIcon = {
  template: "\n    <svg class=\"w-4 h-4 text-blue-500\" fill=\"none\" viewBox=\"0 0 24 24\" stroke=\"currentColor\">\n      <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z\" />\n    </svg>\n  "
};
var MessageIcon = {
  template: "\n    <svg class=\"w-4 h-4 text-blue-500\" fill=\"none\" viewBox=\"0 0 24 24\" stroke=\"currentColor\">\n      <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z\" />\n    </svg>\n  "
};
var StatusIcon = {
  template: "\n    <svg class=\"w-4 h-4 text-blue-500\" fill=\"none\" viewBox=\"0 0 24 24\" stroke=\"currentColor\">\n      <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z\" />\n    </svg>\n  "
};
var DepartmentIcon = {
  template: "\n    <svg class=\"w-4 h-4 text-blue-500\" fill=\"none\" viewBox=\"0 0 24 24\" stroke=\"currentColor\">\n      <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4\" />\n    </svg>\n  "
};
var ClockIcon = {
  template: "\n    <svg class=\"w-4 h-4 text-blue-500\" fill=\"none\" viewBox=\"0 0 24 24\" stroke=\"currentColor\">\n      <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z\" />\n    </svg>\n  "
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: 'TicketList',
  components: {
    TicketIcon: TicketIcon,
    MessageIcon: MessageIcon,
    StatusIcon: StatusIcon,
    DepartmentIcon: DepartmentIcon,
    ClockIcon: ClockIcon
  },
  props: {
    tickets: {
      type: Array,
      "default": function _default() {
        return [];
      },
      validator: function validator(tickets) {
        return Array.isArray(tickets);
      }
    },
    loading: {
      type: Boolean,
      "default": false
    },
    pagination: {
      type: Object,
      "default": function _default() {
        return {
          current_page: 1,
          last_page: 1,
          per_page: 10,
          total: 0
        };
      },
      validator: function validator(pagination) {
        return pagination && typeof pagination.current_page === 'number' && typeof pagination.last_page === 'number' && typeof pagination.per_page === 'number' && typeof pagination.total === 'number';
      }
    },
    totalTickets: {
      type: Number,
      "default": 0,
      validator: function validator(value) {
        return value >= 0;
      }
    }
  },
  emits: {
    viewTicket: function viewTicket(ticket) {
      return ticket && _typeof(ticket) === 'object';
    },
    changePage: function changePage(page) {
      return typeof page === 'number' && page > 0;
    },
    createTicket: null
  },
  setup: function setup() {
    // Status badge classes mapping
    var statusClasses = {
      'open': 'bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300 border-blue-200 dark:border-blue-800/30',
      'in_progress': 'bg-yellow-50 dark:bg-yellow-900/20 text-yellow-700 dark:text-yellow-300 border-yellow-200 dark:border-yellow-800/30',
      'resolved': 'bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300 border-green-200 dark:border-green-800/30',
      'closed': 'bg-gray-50 dark:bg-gray-800/50 text-gray-700 dark:text-gray-300 border-gray-200 dark:border-gray-700',
      'waiting_customer': 'bg-yellow-50 dark:bg-yellow-900/20 text-yellow-700 dark:text-yellow-300 border-yellow-200 dark:border-yellow-800/30'
    };

    // Status display names mapping
    var statusNames = {
      'open': 'Open',
      'in_progress': 'In Progress',
      'resolved': 'Resolved',
      'closed': 'Closed',
      'waiting_customer': 'Waiting for Your Response'
    };

    // Department names mapping
    var departmentNames = {
      'billing': 'Billing Support',
      'technical': 'Technical Support',
      'sales': 'Sales Inquiry',
      'general': 'General Support'
    };
    return {
      statusClasses: statusClasses,
      statusNames: statusNames,
      departmentNames: departmentNames
    };
  },
  methods: {
    getStatusBadgeClass: function getStatusBadgeClass(status) {
      return this.statusClasses[status] || this.statusClasses.closed;
    },
    formatStatus: function formatStatus(status) {
      return this.statusNames[status] || 'Unknown';
    },
    formatDate: function formatDate(date) {
      if (!date) return '';
      try {
        return new Date(date).toLocaleDateString('en-US', {
          year: 'numeric',
          month: 'short',
          day: 'numeric',
          hour: '2-digit',
          minute: '2-digit'
        });
      } catch (error) {
        console.warn('Invalid date format:', date);
        return 'Invalid Date';
      }
    },
    getDepartmentName: function getDepartmentName(category) {
      return this.departmentNames[category] || 'General Support';
    },
    truncateText: function truncateText(text) {
      var maxLength = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 80;
      if (!text || text.length <= maxLength) return text;
      return text.substring(0, maxLength) + '...';
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/TicketWizard.vue?vue&type=script&lang=js":
/*!******************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/TicketWizard.vue?vue&type=script&lang=js ***!
  \******************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "vue");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);
function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/babel/babel/blob/main/packages/babel-helpers/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return r; }; var t, r = {}, e = Object.prototype, n = e.hasOwnProperty, o = "function" == typeof Symbol ? Symbol : {}, i = o.iterator || "@@iterator", a = o.asyncIterator || "@@asyncIterator", u = o.toStringTag || "@@toStringTag"; function c(t, r, e, n) { Object.defineProperty(t, r, { value: e, enumerable: !n, configurable: !n, writable: !n }); } try { c({}, ""); } catch (t) { c = function c(t, r, e) { return t[r] = e; }; } function h(r, e, n, o) { var i = e && e.prototype instanceof Generator ? e : Generator, a = Object.create(i.prototype); return c(a, "_invoke", function (r, e, n) { var o = 1; return function (i, a) { if (3 === o) throw Error("Generator is already running"); if (4 === o) { if ("throw" === i) throw a; return { value: t, done: !0 }; } for (n.method = i, n.arg = a;;) { var u = n.delegate; if (u) { var c = d(u, n); if (c) { if (c === f) continue; return c; } } if ("next" === n.method) n.sent = n._sent = n.arg;else if ("throw" === n.method) { if (1 === o) throw o = 4, n.arg; n.dispatchException(n.arg); } else "return" === n.method && n.abrupt("return", n.arg); o = 3; var h = s(r, e, n); if ("normal" === h.type) { if (o = n.done ? 4 : 2, h.arg === f) continue; return { value: h.arg, done: n.done }; } "throw" === h.type && (o = 4, n.method = "throw", n.arg = h.arg); } }; }(r, n, new Context(o || [])), !0), a; } function s(t, r, e) { try { return { type: "normal", arg: t.call(r, e) }; } catch (t) { return { type: "throw", arg: t }; } } r.wrap = h; var f = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var l = {}; c(l, i, function () { return this; }); var p = Object.getPrototypeOf, y = p && p(p(x([]))); y && y !== e && n.call(y, i) && (l = y); var v = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(l); function g(t) { ["next", "throw", "return"].forEach(function (r) { c(t, r, function (t) { return this._invoke(r, t); }); }); } function AsyncIterator(t, r) { function e(o, i, a, u) { var c = s(t[o], t, i); if ("throw" !== c.type) { var h = c.arg, f = h.value; return f && "object" == _typeof(f) && n.call(f, "__await") ? r.resolve(f.__await).then(function (t) { e("next", t, a, u); }, function (t) { e("throw", t, a, u); }) : r.resolve(f).then(function (t) { h.value = t, a(h); }, function (t) { return e("throw", t, a, u); }); } u(c.arg); } var o; c(this, "_invoke", function (t, n) { function i() { return new r(function (r, o) { e(t, n, r, o); }); } return o = o ? o.then(i, i) : i(); }, !0); } function d(r, e) { var n = e.method, o = r.i[n]; if (o === t) return e.delegate = null, "throw" === n && r.i["return"] && (e.method = "return", e.arg = t, d(r, e), "throw" === e.method) || "return" !== n && (e.method = "throw", e.arg = new TypeError("The iterator does not provide a '" + n + "' method")), f; var i = s(o, r.i, e.arg); if ("throw" === i.type) return e.method = "throw", e.arg = i.arg, e.delegate = null, f; var a = i.arg; return a ? a.done ? (e[r.r] = a.value, e.next = r.n, "return" !== e.method && (e.method = "next", e.arg = t), e.delegate = null, f) : a : (e.method = "throw", e.arg = new TypeError("iterator result is not an object"), e.delegate = null, f); } function w(t) { this.tryEntries.push(t); } function m(r) { var e = r[4] || {}; e.type = "normal", e.arg = t, r[4] = e; } function Context(t) { this.tryEntries = [[-1]], t.forEach(w, this), this.reset(!0); } function x(r) { if (null != r) { var e = r[i]; if (e) return e.call(r); if ("function" == typeof r.next) return r; if (!isNaN(r.length)) { var o = -1, a = function e() { for (; ++o < r.length;) if (n.call(r, o)) return e.value = r[o], e.done = !1, e; return e.value = t, e.done = !0, e; }; return a.next = a; } } throw new TypeError(_typeof(r) + " is not iterable"); } return GeneratorFunction.prototype = GeneratorFunctionPrototype, c(v, "constructor", GeneratorFunctionPrototype), c(GeneratorFunctionPrototype, "constructor", GeneratorFunction), c(GeneratorFunctionPrototype, u, GeneratorFunction.displayName = "GeneratorFunction"), r.isGeneratorFunction = function (t) { var r = "function" == typeof t && t.constructor; return !!r && (r === GeneratorFunction || "GeneratorFunction" === (r.displayName || r.name)); }, r.mark = function (t) { return Object.setPrototypeOf ? Object.setPrototypeOf(t, GeneratorFunctionPrototype) : (t.__proto__ = GeneratorFunctionPrototype, c(t, u, "GeneratorFunction")), t.prototype = Object.create(v), t; }, r.awrap = function (t) { return { __await: t }; }, g(AsyncIterator.prototype), c(AsyncIterator.prototype, a, function () { return this; }), r.AsyncIterator = AsyncIterator, r.async = function (t, e, n, o, i) { void 0 === i && (i = Promise); var a = new AsyncIterator(h(t, e, n, o), i); return r.isGeneratorFunction(e) ? a : a.next().then(function (t) { return t.done ? t.value : a.next(); }); }, g(v), c(v, u, "Generator"), c(v, i, function () { return this; }), c(v, "toString", function () { return "[object Generator]"; }), r.keys = function (t) { var r = Object(t), e = []; for (var n in r) e.unshift(n); return function t() { for (; e.length;) if ((n = e.pop()) in r) return t.value = n, t.done = !1, t; return t.done = !0, t; }; }, r.values = x, Context.prototype = { constructor: Context, reset: function reset(r) { if (this.prev = this.next = 0, this.sent = this._sent = t, this.done = !1, this.delegate = null, this.method = "next", this.arg = t, this.tryEntries.forEach(m), !r) for (var e in this) "t" === e.charAt(0) && n.call(this, e) && !isNaN(+e.slice(1)) && (this[e] = t); }, stop: function stop() { this.done = !0; var t = this.tryEntries[0][4]; if ("throw" === t.type) throw t.arg; return this.rval; }, dispatchException: function dispatchException(r) { if (this.done) throw r; var e = this; function n(t) { a.type = "throw", a.arg = r, e.next = t; } for (var o = e.tryEntries.length - 1; o >= 0; --o) { var i = this.tryEntries[o], a = i[4], u = this.prev, c = i[1], h = i[2]; if (-1 === i[0]) return n("end"), !1; if (!c && !h) throw Error("try statement without catch or finally"); if (null != i[0] && i[0] <= u) { if (u < c) return this.method = "next", this.arg = t, n(c), !0; if (u < h) return n(h), !1; } } }, abrupt: function abrupt(t, r) { for (var e = this.tryEntries.length - 1; e >= 0; --e) { var n = this.tryEntries[e]; if (n[0] > -1 && n[0] <= this.prev && this.prev < n[2]) { var o = n; break; } } o && ("break" === t || "continue" === t) && o[0] <= r && r <= o[2] && (o = null); var i = o ? o[4] : {}; return i.type = t, i.arg = r, o ? (this.method = "next", this.next = o[2], f) : this.complete(i); }, complete: function complete(t, r) { if ("throw" === t.type) throw t.arg; return "break" === t.type || "continue" === t.type ? this.next = t.arg : "return" === t.type ? (this.rval = this.arg = t.arg, this.method = "return", this.next = "end") : "normal" === t.type && r && (this.next = r), f; }, finish: function finish(t) { for (var r = this.tryEntries.length - 1; r >= 0; --r) { var e = this.tryEntries[r]; if (e[2] === t) return this.complete(e[4], e[3]), m(e), f; } }, "catch": function _catch(t) { for (var r = this.tryEntries.length - 1; r >= 0; --r) { var e = this.tryEntries[r]; if (e[0] === t) { var n = e[4]; if ("throw" === n.type) { var o = n.arg; m(e); } return o; } } throw Error("illegal catch attempt"); }, delegateYield: function delegateYield(r, e, n) { return this.delegate = { i: x(r), r: e, n: n }, "next" === this.method && (this.arg = t), f; } }, r; }
function asyncGeneratorStep(n, t, e, r, o, a, c) { try { var i = n[a](c), u = i.value; } catch (n) { return void e(n); } i.done ? t(u) : Promise.resolve(u).then(r, o); }
function _asyncToGenerator(n) { return function () { var t = this, e = arguments; return new Promise(function (r, o) { var a = n.apply(t, e); function _next(n) { asyncGeneratorStep(a, r, o, _next, _throw, "next", n); } function _throw(n) { asyncGeneratorStep(a, r, o, _next, _throw, "throw", n); } _next(void 0); }); }; }
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: 'TicketWizard',
  props: {
    isOpen: {
      type: Boolean,
      "default": false,
      required: true
    }
  },
  emits: {
    close: null,
    ticketCreated: function ticketCreated(ticket) {
      return ticket && _typeof(ticket) === 'object';
    }
  },
  setup: function setup(props, _ref) {
    var emit = _ref.emit;
    // Reactive state
    var currentStep = (0,vue__WEBPACK_IMPORTED_MODULE_0__.ref)(0);
    var isSubmitting = (0,vue__WEBPACK_IMPORTED_MODULE_0__.ref)(false);

    // Static configuration
    var steps = [{
      title: 'Department'
    }, {
      title: 'Details'
    }, {
      title: 'Description'
    }, {
      title: 'Review'
    }];
    var departments = [{
      value: 'billing',
      name: 'Billing Support',
      description: 'Questions about invoices, payments, or billing issues',
      icon: '💳'
    }, {
      value: 'technical',
      name: 'Technical Support',
      description: 'Website issues, hosting problems, or technical difficulties',
      icon: '🔧'
    }, {
      value: 'general',
      name: 'General Support',
      description: 'Account questions, general inquiries, or other issues',
      icon: '💬'
    }, {
      value: 'sales',
      name: 'Sales Inquiry',
      description: 'Questions about services, upgrades, or new purchases',
      icon: '🛒'
    }];

    // Form data
    var formData = (0,vue__WEBPACK_IMPORTED_MODULE_0__.reactive)({
      department: '',
      priority: 'medium',
      subject: '',
      description: '',
      email: ''
    });

    // Computed properties
    var canProceed = (0,vue__WEBPACK_IMPORTED_MODULE_0__.computed)(function () {
      switch (currentStep.value) {
        case 0:
          return formData.department !== '';
        case 1:
          return formData.priority !== '' && formData.subject.trim() !== '';
        case 2:
          return formData.description.trim() !== '' && formData.email.trim() !== '';
        case 3:
          return true;
        default:
          return false;
      }
    });

    // Watch for modal close to reset form
    (0,vue__WEBPACK_IMPORTED_MODULE_0__.watch)(function () {
      return props.isOpen;
    }, function (newValue) {
      if (!newValue) {
        resetForm();
      }
    });
    return {
      currentStep: currentStep,
      isSubmitting: isSubmitting,
      steps: steps,
      departments: departments,
      formData: formData,
      canProceed: canProceed,
      emit: emit
    };
  },
  methods: {
    nextStep: function nextStep() {
      if (this.canProceed && this.currentStep < this.steps.length - 1) {
        this.currentStep++;
      }
    },
    previousStep: function previousStep() {
      if (this.currentStep > 0) {
        this.currentStep--;
      }
    },
    closeWizard: function closeWizard() {
      this.resetForm();
      this.emit('close');
    },
    resetForm: function resetForm() {
      this.currentStep = 0;
      this.isSubmitting = false;
      Object.assign(this.formData, {
        department: '',
        priority: 'medium',
        subject: '',
        description: '',
        email: ''
      });
    },
    submitTicket: function submitTicket() {
      var _this = this;
      return _asyncToGenerator(/*#__PURE__*/_regeneratorRuntime().mark(function _callee() {
        var _response$data$data, payload, response, ticketNumber, errorMessage;
        return _regeneratorRuntime().wrap(function _callee$(_context) {
          while (1) switch (_context.prev = _context.next) {
            case 0:
              _this.isSubmitting = true;
              _context.prev = 1;
              payload = {
                department: _this.formData.department,
                priority: _this.formData.priority,
                subject: _this.formData.subject.trim(),
                description: _this.formData.description.trim(),
                email: _this.formData.email.trim()
              };
              _context.next = 5;
              return Nova.request().post('/nova-vendor/customer-support/tickets', payload);
            case 5:
              response = _context.sent;
              ticketNumber = ((_response$data$data = response.data.data) === null || _response$data$data === void 0 ? void 0 : _response$data$data.ticket_number) || 'Unknown';
              _this.showSuccessMessage("Ticket ".concat(ticketNumber, " created successfully! You will receive a confirmation email shortly."));
              _this.emit('ticketCreated', response.data.data);
              _this.closeWizard();
              _context.next = 16;
              break;
            case 12:
              _context.prev = 12;
              _context.t0 = _context["catch"](1);
              errorMessage = _this.getErrorMessage(_context.t0);
              _this.showErrorMessage(errorMessage);
            case 16:
              _context.prev = 16;
              _this.isSubmitting = false;
              return _context.finish(16);
            case 19:
            case "end":
              return _context.stop();
          }
        }, _callee, null, [[1, 12, 16, 19]]);
      }))();
    },
    getDepartmentName: function getDepartmentName(value) {
      var dept = this.departments.find(function (d) {
        return d.value === value;
      });
      return dept ? dept.name : value;
    },
    getPriorityName: function getPriorityName(value) {
      var priorityMap = {
        'low': 'Low Priority',
        'medium': 'Medium Priority',
        'high': 'High Priority'
      };
      return priorityMap[value] || value;
    },
    getErrorMessage: function getErrorMessage(error) {
      var _error$response, _error$response2;
      var status = (_error$response = error.response) === null || _error$response === void 0 ? void 0 : _error$response.status;
      var data = (_error$response2 = error.response) === null || _error$response2 === void 0 ? void 0 : _error$response2.data;
      switch (status) {
        case 401:
          return 'Authentication required. Please log in again.';
        case 403:
          return 'Access denied. You do not have permission to create tickets.';
        case 422:
          if (data !== null && data !== void 0 && data.errors) {
            var errorList = Object.values(data.errors).flat().join('\n');
            return "Validation errors:\n".concat(errorList);
          }
          return 'Please check your input. Some fields may be invalid.';
        case 429:
          return 'Too many requests. Please wait a moment before trying again.';
        case 500:
          return data !== null && data !== void 0 && data.message ? "Server error: ".concat(data.message) : 'Internal server error occurred.';
        default:
          return (data === null || data === void 0 ? void 0 : data.message) || 'Failed to create ticket. Please try again.';
      }
    },
    showSuccessMessage: function showSuccessMessage(message) {
      if (this.$toasted) {
        this.$toasted.success(message, {
          duration: 5000,
          position: 'top-right'
        });
      }
    },
    showErrorMessage: function showErrorMessage(message) {
      if (this.$toasted) {
        this.$toasted.error(message, {
          duration: 8000,
          position: 'top-right'
        });
      }
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/Tool.vue?vue&type=script&lang=js":
/*!*****************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/Tool.vue?vue&type=script&lang=js ***!
  \*****************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "vue");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _components_TicketFilters_vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../components/TicketFilters.vue */ "./resources/js/components/TicketFilters.vue");
/* harmony import */ var _components_TicketList_vue__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../components/TicketList.vue */ "./resources/js/components/TicketList.vue");
/* harmony import */ var _components_LoadingSpinner_vue__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../components/LoadingSpinner.vue */ "./resources/js/components/LoadingSpinner.vue");
/* harmony import */ var _components_TicketWizard_vue__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../components/TicketWizard.vue */ "./resources/js/components/TicketWizard.vue");
/* harmony import */ var _components_TicketDetailsModal_vue__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../components/TicketDetailsModal.vue */ "./resources/js/components/TicketDetailsModal.vue");
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/babel/babel/blob/main/packages/babel-helpers/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return r; }; var t, r = {}, e = Object.prototype, n = e.hasOwnProperty, o = "function" == typeof Symbol ? Symbol : {}, i = o.iterator || "@@iterator", a = o.asyncIterator || "@@asyncIterator", u = o.toStringTag || "@@toStringTag"; function c(t, r, e, n) { Object.defineProperty(t, r, { value: e, enumerable: !n, configurable: !n, writable: !n }); } try { c({}, ""); } catch (t) { c = function c(t, r, e) { return t[r] = e; }; } function h(r, e, n, o) { var i = e && e.prototype instanceof Generator ? e : Generator, a = Object.create(i.prototype); return c(a, "_invoke", function (r, e, n) { var o = 1; return function (i, a) { if (3 === o) throw Error("Generator is already running"); if (4 === o) { if ("throw" === i) throw a; return { value: t, done: !0 }; } for (n.method = i, n.arg = a;;) { var u = n.delegate; if (u) { var c = d(u, n); if (c) { if (c === f) continue; return c; } } if ("next" === n.method) n.sent = n._sent = n.arg;else if ("throw" === n.method) { if (1 === o) throw o = 4, n.arg; n.dispatchException(n.arg); } else "return" === n.method && n.abrupt("return", n.arg); o = 3; var h = s(r, e, n); if ("normal" === h.type) { if (o = n.done ? 4 : 2, h.arg === f) continue; return { value: h.arg, done: n.done }; } "throw" === h.type && (o = 4, n.method = "throw", n.arg = h.arg); } }; }(r, n, new Context(o || [])), !0), a; } function s(t, r, e) { try { return { type: "normal", arg: t.call(r, e) }; } catch (t) { return { type: "throw", arg: t }; } } r.wrap = h; var f = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var l = {}; c(l, i, function () { return this; }); var p = Object.getPrototypeOf, y = p && p(p(x([]))); y && y !== e && n.call(y, i) && (l = y); var v = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(l); function g(t) { ["next", "throw", "return"].forEach(function (r) { c(t, r, function (t) { return this._invoke(r, t); }); }); } function AsyncIterator(t, r) { function e(o, i, a, u) { var c = s(t[o], t, i); if ("throw" !== c.type) { var h = c.arg, f = h.value; return f && "object" == _typeof(f) && n.call(f, "__await") ? r.resolve(f.__await).then(function (t) { e("next", t, a, u); }, function (t) { e("throw", t, a, u); }) : r.resolve(f).then(function (t) { h.value = t, a(h); }, function (t) { return e("throw", t, a, u); }); } u(c.arg); } var o; c(this, "_invoke", function (t, n) { function i() { return new r(function (r, o) { e(t, n, r, o); }); } return o = o ? o.then(i, i) : i(); }, !0); } function d(r, e) { var n = e.method, o = r.i[n]; if (o === t) return e.delegate = null, "throw" === n && r.i["return"] && (e.method = "return", e.arg = t, d(r, e), "throw" === e.method) || "return" !== n && (e.method = "throw", e.arg = new TypeError("The iterator does not provide a '" + n + "' method")), f; var i = s(o, r.i, e.arg); if ("throw" === i.type) return e.method = "throw", e.arg = i.arg, e.delegate = null, f; var a = i.arg; return a ? a.done ? (e[r.r] = a.value, e.next = r.n, "return" !== e.method && (e.method = "next", e.arg = t), e.delegate = null, f) : a : (e.method = "throw", e.arg = new TypeError("iterator result is not an object"), e.delegate = null, f); } function w(t) { this.tryEntries.push(t); } function m(r) { var e = r[4] || {}; e.type = "normal", e.arg = t, r[4] = e; } function Context(t) { this.tryEntries = [[-1]], t.forEach(w, this), this.reset(!0); } function x(r) { if (null != r) { var e = r[i]; if (e) return e.call(r); if ("function" == typeof r.next) return r; if (!isNaN(r.length)) { var o = -1, a = function e() { for (; ++o < r.length;) if (n.call(r, o)) return e.value = r[o], e.done = !1, e; return e.value = t, e.done = !0, e; }; return a.next = a; } } throw new TypeError(_typeof(r) + " is not iterable"); } return GeneratorFunction.prototype = GeneratorFunctionPrototype, c(v, "constructor", GeneratorFunctionPrototype), c(GeneratorFunctionPrototype, "constructor", GeneratorFunction), c(GeneratorFunctionPrototype, u, GeneratorFunction.displayName = "GeneratorFunction"), r.isGeneratorFunction = function (t) { var r = "function" == typeof t && t.constructor; return !!r && (r === GeneratorFunction || "GeneratorFunction" === (r.displayName || r.name)); }, r.mark = function (t) { return Object.setPrototypeOf ? Object.setPrototypeOf(t, GeneratorFunctionPrototype) : (t.__proto__ = GeneratorFunctionPrototype, c(t, u, "GeneratorFunction")), t.prototype = Object.create(v), t; }, r.awrap = function (t) { return { __await: t }; }, g(AsyncIterator.prototype), c(AsyncIterator.prototype, a, function () { return this; }), r.AsyncIterator = AsyncIterator, r.async = function (t, e, n, o, i) { void 0 === i && (i = Promise); var a = new AsyncIterator(h(t, e, n, o), i); return r.isGeneratorFunction(e) ? a : a.next().then(function (t) { return t.done ? t.value : a.next(); }); }, g(v), c(v, u, "Generator"), c(v, i, function () { return this; }), c(v, "toString", function () { return "[object Generator]"; }), r.keys = function (t) { var r = Object(t), e = []; for (var n in r) e.unshift(n); return function t() { for (; e.length;) if ((n = e.pop()) in r) return t.value = n, t.done = !1, t; return t.done = !0, t; }; }, r.values = x, Context.prototype = { constructor: Context, reset: function reset(r) { if (this.prev = this.next = 0, this.sent = this._sent = t, this.done = !1, this.delegate = null, this.method = "next", this.arg = t, this.tryEntries.forEach(m), !r) for (var e in this) "t" === e.charAt(0) && n.call(this, e) && !isNaN(+e.slice(1)) && (this[e] = t); }, stop: function stop() { this.done = !0; var t = this.tryEntries[0][4]; if ("throw" === t.type) throw t.arg; return this.rval; }, dispatchException: function dispatchException(r) { if (this.done) throw r; var e = this; function n(t) { a.type = "throw", a.arg = r, e.next = t; } for (var o = e.tryEntries.length - 1; o >= 0; --o) { var i = this.tryEntries[o], a = i[4], u = this.prev, c = i[1], h = i[2]; if (-1 === i[0]) return n("end"), !1; if (!c && !h) throw Error("try statement without catch or finally"); if (null != i[0] && i[0] <= u) { if (u < c) return this.method = "next", this.arg = t, n(c), !0; if (u < h) return n(h), !1; } } }, abrupt: function abrupt(t, r) { for (var e = this.tryEntries.length - 1; e >= 0; --e) { var n = this.tryEntries[e]; if (n[0] > -1 && n[0] <= this.prev && this.prev < n[2]) { var o = n; break; } } o && ("break" === t || "continue" === t) && o[0] <= r && r <= o[2] && (o = null); var i = o ? o[4] : {}; return i.type = t, i.arg = r, o ? (this.method = "next", this.next = o[2], f) : this.complete(i); }, complete: function complete(t, r) { if ("throw" === t.type) throw t.arg; return "break" === t.type || "continue" === t.type ? this.next = t.arg : "return" === t.type ? (this.rval = this.arg = t.arg, this.method = "return", this.next = "end") : "normal" === t.type && r && (this.next = r), f; }, finish: function finish(t) { for (var r = this.tryEntries.length - 1; r >= 0; --r) { var e = this.tryEntries[r]; if (e[2] === t) return this.complete(e[4], e[3]), m(e), f; } }, "catch": function _catch(t) { for (var r = this.tryEntries.length - 1; r >= 0; --r) { var e = this.tryEntries[r]; if (e[0] === t) { var n = e[4]; if ("throw" === n.type) { var o = n.arg; m(e); } return o; } } throw Error("illegal catch attempt"); }, delegateYield: function delegateYield(r, e, n) { return this.delegate = { i: x(r), r: e, n: n }, "next" === this.method && (this.arg = t), f; } }, r; }
function asyncGeneratorStep(n, t, e, r, o, a, c) { try { var i = n[a](c), u = i.value; } catch (n) { return void e(n); } i.done ? t(u) : Promise.resolve(u).then(r, o); }
function _asyncToGenerator(n) { return function () { var t = this, e = arguments; return new Promise(function (r, o) { var a = n.apply(t, e); function _next(n) { asyncGeneratorStep(a, r, o, _next, _throw, "next", n); } function _throw(n) { asyncGeneratorStep(a, r, o, _next, _throw, "throw", n); } _next(void 0); }); }; }






/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: 'CustomerSupportTool',
  components: {
    TicketFilters: _components_TicketFilters_vue__WEBPACK_IMPORTED_MODULE_1__["default"],
    TicketList: _components_TicketList_vue__WEBPACK_IMPORTED_MODULE_2__["default"],
    LoadingSpinner: _components_LoadingSpinner_vue__WEBPACK_IMPORTED_MODULE_3__["default"],
    TicketWizard: _components_TicketWizard_vue__WEBPACK_IMPORTED_MODULE_4__["default"],
    TicketDetailsModal: _components_TicketDetailsModal_vue__WEBPACK_IMPORTED_MODULE_5__["default"]
  },
  setup: function setup() {
    // Reactive state
    var loading = (0,vue__WEBPACK_IMPORTED_MODULE_0__.ref)(false);
    var tickets = (0,vue__WEBPACK_IMPORTED_MODULE_0__.ref)([]);
    var pagination = (0,vue__WEBPACK_IMPORTED_MODULE_0__.reactive)({
      current_page: 1,
      last_page: 1,
      per_page: 10,
      total: 0
    });
    var totalTickets = (0,vue__WEBPACK_IMPORTED_MODULE_0__.ref)(0);
    var showWizard = (0,vue__WEBPACK_IMPORTED_MODULE_0__.ref)(false);
    var showTicketDetails = (0,vue__WEBPACK_IMPORTED_MODULE_0__.ref)(false);
    var selectedTicket = (0,vue__WEBPACK_IMPORTED_MODULE_0__.ref)(null);
    var searchQuery = (0,vue__WEBPACK_IMPORTED_MODULE_0__.ref)('');
    var statusFilter = (0,vue__WEBPACK_IMPORTED_MODULE_0__.ref)('');
    var departmentFilter = (0,vue__WEBPACK_IMPORTED_MODULE_0__.ref)('');
    var searchTimeout = (0,vue__WEBPACK_IMPORTED_MODULE_0__.ref)(null);
    return {
      loading: loading,
      tickets: tickets,
      pagination: pagination,
      totalTickets: totalTickets,
      showWizard: showWizard,
      showTicketDetails: showTicketDetails,
      selectedTicket: selectedTicket,
      searchQuery: searchQuery,
      statusFilter: statusFilter,
      departmentFilter: departmentFilter,
      searchTimeout: searchTimeout
    };
  },
  mounted: function mounted() {
    this.loadTickets();
  },
  methods: {
    loadTickets: function loadTickets() {
      var _arguments = arguments,
        _this = this;
      return _asyncToGenerator(/*#__PURE__*/_regeneratorRuntime().mark(function _callee() {
        var page, _response$data$meta, params, response, _error$response, _error$response2, _this$$toasted, _this$$toasted2, _this$$toasted3;
        return _regeneratorRuntime().wrap(function _callee$(_context) {
          while (1) switch (_context.prev = _context.next) {
            case 0:
              page = _arguments.length > 0 && _arguments[0] !== undefined ? _arguments[0] : 1;
              _context.prev = 1;
              _this.loading = true;

              // Build query parameters
              params = {
                page: page
              };
              if (_this.searchQuery.trim()) {
                params.search = _this.searchQuery.trim();
              }
              if (_this.statusFilter) {
                params.status = _this.statusFilter;
              }
              if (_this.departmentFilter) {
                params.department = _this.departmentFilter;
              }

              // Make API request using Nova.request
              _context.next = 9;
              return Nova.request().get('/nova-vendor/customer-support/tickets', {
                params: params
              });
            case 9:
              response = _context.sent;
              _this.tickets = response.data.data || [];
              _this.pagination = response.data.meta || {};
              _this.totalTickets = ((_response$data$meta = response.data.meta) === null || _response$data$meta === void 0 ? void 0 : _response$data$meta.total) || 0;
              _context.next = 22;
              break;
            case 15:
              _context.prev = 15;
              _context.t0 = _context["catch"](1);
              console.error('Error loading tickets:', _context.t0);

              // Show user-friendly error message
              if (((_error$response = _context.t0.response) === null || _error$response === void 0 ? void 0 : _error$response.status) === 401) {
                (_this$$toasted = _this.$toasted) === null || _this$$toasted === void 0 || _this$$toasted.error('Authentication required. Please log in again.');
              } else if (((_error$response2 = _context.t0.response) === null || _error$response2 === void 0 ? void 0 : _error$response2.status) === 403) {
                (_this$$toasted2 = _this.$toasted) === null || _this$$toasted2 === void 0 || _this$$toasted2.error('Access denied. You do not have permission to view tickets.');
              } else {
                (_this$$toasted3 = _this.$toasted) === null || _this$$toasted3 === void 0 || _this$$toasted3.error('Failed to load tickets. Please try again.');
              }

              // Reset data on error
              _this.tickets = [];
              _this.pagination = {
                current_page: 1,
                last_page: 1,
                per_page: 10,
                total: 0
              };
              _this.totalTickets = 0;
            case 22:
              _context.prev = 22;
              _this.loading = false;
              return _context.finish(22);
            case 25:
            case "end":
              return _context.stop();
          }
        }, _callee, null, [[1, 15, 22, 25]]);
      }))();
    },
    viewTicketDetails: function viewTicketDetails(ticket) {
      var _this2 = this;
      return _asyncToGenerator(/*#__PURE__*/_regeneratorRuntime().mark(function _callee2() {
        return _regeneratorRuntime().wrap(function _callee2$(_context2) {
          while (1) switch (_context2.prev = _context2.next) {
            case 0:
              _this2.selectedTicket = ticket;
              _this2.showTicketDetails = true;
            case 2:
            case "end":
              return _context2.stop();
          }
        }, _callee2);
      }))();
    },
    closeTicketDetails: function closeTicketDetails() {
      this.showTicketDetails = false;
      this.selectedTicket = null;
    },
    onResponseAdded: function onResponseAdded() {
      // Refresh the ticket list to show updated status
      this.loadTickets(this.pagination.current_page);
      if (this.$toasted) {
        this.$toasted.success('Response added successfully!', {
          duration: 3000,
          position: 'top-right'
        });
      }
    },
    openWizard: function openWizard() {
      this.showWizard = true;
    },
    closeWizard: function closeWizard() {
      this.showWizard = false;
    },
    onTicketCreated: function onTicketCreated() {
      this.loadTickets(1);
      if (this.$toasted) {
        this.$toasted.success('Support ticket created successfully!', {
          duration: 5000,
          position: 'top-right'
        });
      }
    },
    handleSearch: function handleSearch() {
      var _this3 = this;
      if (this.searchTimeout) {
        clearTimeout(this.searchTimeout);
      }
      this.searchTimeout = setTimeout(function () {
        _this3.loadTickets(1);
      }, 500);
    },
    handleFilterChange: function handleFilterChange() {
      this.loadTickets(1);
    },
    clearSearchTimeout: function clearSearchTimeout() {
      if (this.searchTimeout) {
        clearTimeout(this.searchTimeout);
        this.searchTimeout = null;
      }
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/LoadingSpinner.vue?vue&type=template&id=41495c30":
/*!************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/LoadingSpinner.vue?vue&type=template&id=41495c30 ***!
  \************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "vue");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);

var _hoisted_1 = {
  "class": "bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-600 shadow-lg py-12"
};
var _hoisted_2 = {
  "class": "flex justify-center items-center"
};
var _hoisted_3 = {
  "class": "flex items-center"
};
var _hoisted_4 = {
  "class": "ml-3 text-gray-600 dark:text-gray-400"
};
function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_SpinnerIcon = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("SpinnerIcon");
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_3, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_SpinnerIcon), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", _hoisted_4, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($props.message), 1 /* TEXT */)])])]);
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/TicketDetailsModal.vue?vue&type=template&id=175674e2":
/*!****************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/TicketDetailsModal.vue?vue&type=template&id=175674e2 ***!
  \****************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "vue");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);

var _hoisted_1 = {
  "class": "bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-hidden flex flex-col border border-gray-200 dark:border-gray-600"
};
var _hoisted_2 = {
  "class": "flex justify-between items-center p-6 border-b border-gray-200 dark:border-gray-600 bg-gradient-to-r from-blue-50 to-white dark:from-gray-800 dark:to-gray-700"
};
var _hoisted_3 = {
  "class": "flex items-center gap-4"
};
var _hoisted_4 = {
  "class": "flex items-center justify-center w-10 h-10 bg-blue-500 rounded-lg"
};
var _hoisted_5 = {
  "class": "text-lg font-semibold text-gray-900 dark:text-gray-100"
};
var _hoisted_6 = {
  "class": "text-sm text-gray-600 dark:text-gray-400"
};
var _hoisted_7 = {
  "class": "flex-1 overflow-hidden flex flex-col"
};
var _hoisted_8 = {
  "class": "px-6 py-4 bg-gray-50 dark:bg-gray-700/50 border-b border-gray-200 dark:border-gray-600"
};
var _hoisted_9 = {
  "class": "flex flex-wrap items-center gap-4 text-sm"
};
var _hoisted_10 = {
  "class": "flex items-center gap-2"
};
var _hoisted_11 = {
  "class": "flex items-center gap-2"
};
var _hoisted_12 = {
  "class": "text-gray-900 dark:text-gray-100 font-medium"
};
var _hoisted_13 = {
  "class": "flex items-center gap-2"
};
var _hoisted_14 = {
  "class": "text-gray-900 dark:text-gray-100"
};
var _hoisted_15 = {
  "class": "flex-1 overflow-y-auto p-6 space-y-6"
};
var _hoisted_16 = {
  key: 0,
  "class": "flex justify-center py-8"
};
var _hoisted_17 = {
  key: 1,
  "class": "text-center py-8"
};
var _hoisted_18 = {
  key: 2,
  "class": "space-y-4"
};
var _hoisted_19 = {
  "class": "flex-shrink-0"
};
var _hoisted_20 = {
  "class": "text-sm whitespace-pre-wrap"
};
var _hoisted_21 = {
  key: 0,
  "class": "border-t border-gray-200 dark:border-gray-600 p-6 bg-gray-50 dark:bg-gray-700/50"
};
var _hoisted_22 = ["disabled"];
var _hoisted_23 = {
  "class": "text-xs text-gray-500 dark:text-gray-400 mt-1"
};
var _hoisted_24 = {
  "class": "flex justify-end gap-3"
};
var _hoisted_25 = ["disabled"];
var _hoisted_26 = ["disabled"];
var _hoisted_27 = {
  key: 0
};
var _hoisted_28 = {
  key: 1
};
function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _$props$ticket, _$props$ticket2, _$props$ticket3, _$props$ticket4, _$props$ticket5, _$props$ticket6;
  var _component_TicketIcon = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("TicketIcon");
  var _component_CloseIcon = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("CloseIcon");
  var _component_LoadingSpinner = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("LoadingSpinner");
  var _component_SendIcon = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("SendIcon");
  return $props.isOpen ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", {
    key: 0,
    "class": "fixed inset-0 bg-gradient-to-br from-black/40 to-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4",
    onClick: _cache[4] || (_cache[4] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)(function ($event) {
      return _ctx.$emit('close');
    }, ["self"]))
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Header "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_3, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_4, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_TicketIcon)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h2", _hoisted_5, " Ticket #" + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)((_$props$ticket = $props.ticket) === null || _$props$ticket === void 0 ? void 0 : _$props$ticket.ticket_number), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", _hoisted_6, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)((_$props$ticket2 = $props.ticket) === null || _$props$ticket2 === void 0 ? void 0 : _$props$ticket2.subject), 1 /* TEXT */)])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
    onClick: _cache[0] || (_cache[0] = function ($event) {
      return _ctx.$emit('close');
    }),
    "class": "text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors duration-200 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700"
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_CloseIcon)])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Content "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_7, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Ticket Info Bar "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_8, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_9, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_10, [_cache[5] || (_cache[5] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
    "class": "text-gray-500 dark:text-gray-400"
  }, "Status:", -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)([$options.getStatusBadgeClass((_$props$ticket3 = $props.ticket) === null || _$props$ticket3 === void 0 ? void 0 : _$props$ticket3.status), "inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium uppercase tracking-wider border"])
  }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($options.formatStatus((_$props$ticket4 = $props.ticket) === null || _$props$ticket4 === void 0 ? void 0 : _$props$ticket4.status)), 3 /* TEXT, CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_11, [_cache[6] || (_cache[6] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
    "class": "text-gray-500 dark:text-gray-400"
  }, "Department:", -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", _hoisted_12, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($options.getDepartmentName((_$props$ticket5 = $props.ticket) === null || _$props$ticket5 === void 0 ? void 0 : _$props$ticket5.category)), 1 /* TEXT */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_13, [_cache[7] || (_cache[7] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
    "class": "text-gray-500 dark:text-gray-400"
  }, "Created:", -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", _hoisted_14, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($options.formatDate((_$props$ticket6 = $props.ticket) === null || _$props$ticket6 === void 0 ? void 0 : _$props$ticket6.created_at)), 1 /* TEXT */)])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Conversation Thread "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_15, [$data.loading ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_16, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_LoadingSpinner, {
    message: "Loading conversation..."
  })])) : $data.responses.length === 0 ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_17, _cache[8] || (_cache[8] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": "text-gray-500 dark:text-gray-400"
  }, " No responses yet. Be the first to reply! ", -1 /* HOISTED */)]))) : ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_18, [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($data.responses, function (response) {
    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", {
      key: response.id,
      "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["flex gap-4", {
        'flex-row-reverse': response.is_customer
      }])
    }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Avatar "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_19, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
      "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["w-10 h-10 rounded-full flex items-center justify-center text-white text-sm font-medium", response.is_customer ? 'bg-blue-500' : 'bg-gray-500'])
    }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($options.getInitials(response.author_name)), 3 /* TEXT, CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Message "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
      "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["flex-1 max-w-[70%]", {
        'text-right': response.is_customer
      }])
    }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
      "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["rounded-2xl px-4 py-3 shadow-sm border", response.is_customer ? 'bg-blue-500 text-white border-blue-500' : 'bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 border-gray-200 dark:border-gray-600'])
    }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_20, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(response.message), 1 /* TEXT */)], 2 /* CLASS */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
      "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["text-xs mt-1 px-2", response.is_customer ? 'text-blue-100' : 'text-gray-500 dark:text-gray-400'])
    }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(response.author_name) + " • " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($options.formatDate(response.created_at)), 3 /* TEXT, CLASS */)], 2 /* CLASS */)], 2 /* CLASS */);
  }), 128 /* KEYED_FRAGMENT */))]))]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Reply Form "), $options.canReply ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_21, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("form", {
    onSubmit: _cache[3] || (_cache[3] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)(function () {
      return $options.submitReply && $options.submitReply.apply($options, arguments);
    }, ["prevent"])),
    "class": "space-y-4"
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [_cache[9] || (_cache[9] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
    "class": "block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
  }, " Add a reply ", -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("textarea", {
    "onUpdate:modelValue": _cache[1] || (_cache[1] = function ($event) {
      return $data.replyMessage = $event;
    }),
    placeholder: "Type your message here...",
    "class": "w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 resize-vertical",
    rows: "3",
    maxlength: "1000",
    disabled: $data.isSubmitting
  }, null, 8 /* PROPS */, _hoisted_22), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.replyMessage]]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_23, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.replyMessage.length) + "/1000 characters ", 1 /* TEXT */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_24, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
    type: "button",
    onClick: _cache[2] || (_cache[2] = function ($event) {
      return $data.replyMessage = '';
    }),
    "class": "px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200",
    disabled: $data.isSubmitting
  }, " Clear ", 8 /* PROPS */, _hoisted_25), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
    type: "submit",
    disabled: !$data.replyMessage.trim() || $data.isSubmitting,
    "class": "px-6 py-2 text-sm font-medium text-white bg-blue-500 hover:bg-blue-600 rounded-lg transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2"
  }, [$data.isSubmitting ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_27, "Sending...")) : ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_28, "Send Reply")), !$data.isSubmitting ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(_component_SendIcon, {
    key: 2
  })) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 8 /* PROPS */, _hoisted_26)])], 32 /* NEED_HYDRATION */)])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])])])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true);
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/TicketFilters.vue?vue&type=template&id=20c33118":
/*!***********************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/TicketFilters.vue?vue&type=template&id=20c33118 ***!
  \***********************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "vue");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);

var _hoisted_1 = {
  "class": "bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-600 shadow-lg mb-6"
};
var _hoisted_2 = {
  "class": "p-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4"
};
var _hoisted_3 = {
  "class": "flex flex-col sm:flex-row gap-4"
};
var _hoisted_4 = {
  "class": "relative"
};
var _hoisted_5 = ["value"];
var _hoisted_6 = ["value"];
var _hoisted_7 = ["value"];
var _hoisted_8 = ["value"];
var _hoisted_9 = ["value"];
var _hoisted_10 = {
  "class": "flex items-center gap-4"
};
var _hoisted_11 = {
  "class": "text-sm text-gray-600 dark:text-gray-400"
};
function render(_ctx, _cache, $props, $setup, $data, $options) {
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_3, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Search Input "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_4, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    value: $props.searchQuery,
    onInput: _cache[0] || (_cache[0] = function ($event) {
      return _ctx.$emit('update:searchQuery', $event.target.value);
    }),
    type: "text",
    placeholder: "Search tickets...",
    "class": "w-full sm:w-64 px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-sm text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 transition-all duration-200 shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-100 dark:focus:ring-blue-900 focus:outline-none"
  }, null, 40 /* PROPS, NEED_HYDRATION */, _hoisted_5)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Status Filter "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("select", {
    value: $props.statusFilter,
    onChange: _cache[1] || (_cache[1] = function ($event) {
      return _ctx.$emit('update:statusFilter', $event.target.value);
    }),
    "class": "w-full sm:w-48 px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-sm text-gray-700 dark:text-gray-200 transition-all duration-200 shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-100 dark:focus:ring-blue-900 focus:outline-none cursor-pointer"
  }, [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($setup.statusOptions, function (option) {
    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("option", {
      key: option.value,
      value: option.value
    }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(option.label), 9 /* TEXT, PROPS */, _hoisted_7);
  }), 128 /* KEYED_FRAGMENT */))], 40 /* PROPS, NEED_HYDRATION */, _hoisted_6), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Department Filter "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("select", {
    value: $props.departmentFilter,
    onChange: _cache[2] || (_cache[2] = function ($event) {
      return _ctx.$emit('update:departmentFilter', $event.target.value);
    }),
    "class": "w-full sm:w-48 px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-sm text-gray-700 dark:text-gray-200 transition-all duration-200 shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-100 dark:focus:ring-blue-900 focus:outline-none cursor-pointer"
  }, [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($setup.departmentOptions, function (option) {
    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("option", {
      key: option.value,
      value: option.value
    }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(option.label), 9 /* TEXT, PROPS */, _hoisted_9);
  }), 128 /* KEYED_FRAGMENT */))], 40 /* PROPS, NEED_HYDRATION */, _hoisted_8)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_10, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_11, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($props.totalTickets) + " " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($props.totalTickets === 1 ? 'ticket' : 'tickets') + " total ", 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
    onClick: _cache[3] || (_cache[3] = function ($event) {
      return _ctx.$emit('createTicket');
    }),
    "class": "flex items-center gap-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-3 rounded-lg font-semibold text-sm tracking-wide transition-all duration-200 shadow-sm hover:from-blue-600 hover:to-blue-700 hover:shadow-lg hover:-translate-y-0.5 active:translate-y-0 active:shadow-sm whitespace-nowrap"
  }, " Create New Ticket ")])])]);
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/TicketList.vue?vue&type=template&id=5d983d16":
/*!********************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/TicketList.vue?vue&type=template&id=5d983d16 ***!
  \********************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "vue");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);

var _hoisted_1 = {
  key: 0,
  "class": "bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-600 shadow-lg overflow-hidden"
};
var _hoisted_2 = {
  "class": "hidden lg:block overflow-x-auto"
};
var _hoisted_3 = {
  "class": "w-full"
};
var _hoisted_4 = {
  "class": "bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700 border-b border-gray-200 dark:border-gray-600"
};
var _hoisted_5 = {
  "class": "px-6 py-4 text-left text-sm font-semibold text-gray-700 dark:text-gray-200 tracking-wide"
};
var _hoisted_6 = {
  "class": "flex items-center gap-2"
};
var _hoisted_7 = {
  "class": "px-6 py-4 text-left text-sm font-semibold text-gray-700 dark:text-gray-200 tracking-wide"
};
var _hoisted_8 = {
  "class": "flex items-center gap-2"
};
var _hoisted_9 = {
  "class": "px-6 py-4 text-left text-sm font-semibold text-gray-700 dark:text-gray-200 tracking-wide"
};
var _hoisted_10 = {
  "class": "flex items-center gap-2"
};
var _hoisted_11 = {
  "class": "px-6 py-4 text-left text-sm font-semibold text-gray-700 dark:text-gray-200 tracking-wide"
};
var _hoisted_12 = {
  "class": "flex items-center gap-2"
};
var _hoisted_13 = {
  "class": "px-6 py-4 text-right text-sm font-semibold text-gray-700 dark:text-gray-200 tracking-wide"
};
var _hoisted_14 = {
  "class": "flex items-center justify-end gap-2"
};
var _hoisted_15 = {
  key: 0,
  "class": "divide-y divide-gray-100 dark:divide-gray-700"
};
var _hoisted_16 = ["onClick"];
var _hoisted_17 = {
  "class": "px-6 py-4 whitespace-nowrap"
};
var _hoisted_18 = {
  "class": "text-sm font-semibold text-blue-600 group-hover:text-blue-700"
};
var _hoisted_19 = {
  "class": "text-xs text-gray-500 dark:text-gray-400 mt-1"
};
var _hoisted_20 = {
  "class": "px-6 py-4"
};
var _hoisted_21 = {
  "class": "text-sm font-medium text-gray-900 dark:text-gray-100 group-hover:text-gray-700 dark:group-hover:text-gray-200"
};
var _hoisted_22 = {
  "class": "text-xs text-gray-500 dark:text-gray-400 mt-1 line-clamp-1"
};
var _hoisted_23 = {
  "class": "px-6 py-4 whitespace-nowrap"
};
var _hoisted_24 = {
  "class": "px-6 py-4 whitespace-nowrap"
};
var _hoisted_25 = {
  "class": "inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600"
};
var _hoisted_26 = {
  "class": "px-6 py-4 whitespace-nowrap text-right"
};
var _hoisted_27 = {
  "class": "text-sm text-gray-600 dark:text-gray-400"
};
var _hoisted_28 = {
  key: 0,
  "class": "lg:hidden p-4 space-y-4"
};
var _hoisted_29 = ["onClick"];
var _hoisted_30 = {
  "class": "flex justify-between items-start mb-3"
};
var _hoisted_31 = {
  "class": "text-sm font-semibold text-blue-600 group-hover:text-blue-700"
};
var _hoisted_32 = {
  "class": "text-xs text-gray-500 dark:text-gray-400 mt-1"
};
var _hoisted_33 = {
  "class": "mb-3"
};
var _hoisted_34 = {
  "class": "text-sm font-medium text-gray-900 dark:text-gray-100 mb-1 group-hover:text-gray-700 dark:group-hover:text-gray-200"
};
var _hoisted_35 = {
  key: 0,
  "class": "text-xs text-gray-600 dark:text-gray-400 line-clamp-2"
};
var _hoisted_36 = {
  "class": "flex justify-between items-center"
};
var _hoisted_37 = {
  "class": "inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600"
};
var _hoisted_38 = {
  "class": "text-xs text-gray-500 dark:text-gray-400"
};
var _hoisted_39 = {
  key: 1,
  "class": "px-4 sm:px-6 py-4 border-t border-gray-200 dark:border-gray-700"
};
var _hoisted_40 = {
  "class": "flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4"
};
var _hoisted_41 = {
  "class": "text-sm text-gray-700 dark:text-gray-300 text-center sm:text-left"
};
var _hoisted_42 = {
  "class": "flex items-center justify-center gap-2"
};
var _hoisted_43 = ["disabled"];
var _hoisted_44 = {
  "class": "px-3 py-2 text-sm text-gray-700 dark:text-gray-300 whitespace-nowrap"
};
var _hoisted_45 = ["disabled"];
function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_TicketIcon = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("TicketIcon");
  var _component_MessageIcon = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("MessageIcon");
  var _component_StatusIcon = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("StatusIcon");
  var _component_DepartmentIcon = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("DepartmentIcon");
  var _component_ClockIcon = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("ClockIcon");
  return !$props.loading || $props.tickets.length > 0 ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Desktop Table "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("table", _hoisted_3, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Table Header "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("thead", _hoisted_4, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", _hoisted_5, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_6, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_TicketIcon), _cache[2] || (_cache[2] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Ticket "))])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", _hoisted_7, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_8, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_MessageIcon), _cache[3] || (_cache[3] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Subject "))])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", _hoisted_9, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_10, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_StatusIcon), _cache[4] || (_cache[4] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Status "))])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", _hoisted_11, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_12, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_DepartmentIcon), _cache[5] || (_cache[5] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Department "))])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", _hoisted_13, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_14, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_ClockIcon), _cache[6] || (_cache[6] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Last Updated "))])])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Table Body "), $props.tickets.length > 0 ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("tbody", _hoisted_15, [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($props.tickets, function (ticket) {
    var _ticket$department;
    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("tr", {
      key: ticket.id,
      onClick: function onClick($event) {
        return _ctx.$emit('viewTicket', ticket);
      },
      "class": "cursor-pointer transition-all duration-200 hover:bg-gray-50 dark:hover:bg-gray-700/50 group"
    }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Ticket Number "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_17, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_18, " #" + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(ticket.ticket_number), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_19, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($options.formatDate(ticket.created_at)), 1 /* TEXT */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Subject "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_20, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_21, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(ticket.subject), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_22, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($options.truncateText(ticket.description, 80)), 1 /* TEXT */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Status "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_23, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
      "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)([$options.getStatusBadgeClass(ticket.status), "inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium uppercase tracking-wider border"])
    }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($options.formatStatus(ticket.status)), 3 /* TEXT, CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Department "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_24, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_25, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($options.getDepartmentName(ticket.category || ((_ticket$department = ticket.department) === null || _ticket$department === void 0 ? void 0 : _ticket$department.name))), 1 /* TEXT */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Last Updated "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_26, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_27, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($options.formatDate(ticket.updated_at)), 1 /* TEXT */)])], 8 /* PROPS */, _hoisted_16);
  }), 128 /* KEYED_FRAGMENT */))])) : !$props.loading ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, {
    key: 1
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Empty State for Table "), _cache[7] || (_cache[7] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tbody", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", {
    colspan: "5",
    "class": "px-6 py-12 text-center"
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
    "class": "mx-auto h-12 w-12 text-gray-400 mb-4",
    fill: "none",
    viewBox: "0 0 24 24",
    stroke: "currentColor"
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
    "stroke-linecap": "round",
    "stroke-linejoin": "round",
    "stroke-width": "2",
    d: "M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-3.582 8-8 8a8.955 8.955 0 01-2.697-.413l-2.725.725.725-2.725A8.955 8.955 0 013 12c0-4.418 3.582-8 8-8s8 3.582 8 8z"
  })]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h3", {
    "class": "text-sm font-medium text-gray-900 dark:text-gray-100 mb-1"
  }, "No support tickets found"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", {
    "class": "text-sm text-gray-500 dark:text-gray-400"
  }, " You don't have any support tickets yet. Use the \"Create Ticket\" button above to get started. ")])])], -1 /* HOISTED */))], 2112 /* STABLE_FRAGMENT, DEV_ROOT_FRAGMENT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Mobile Card View "), $props.tickets.length > 0 ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_28, [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($props.tickets, function (ticket) {
    var _ticket$department2;
    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", {
      key: ticket.id,
      onClick: function onClick($event) {
        return _ctx.$emit('viewTicket', ticket);
      },
      "class": "bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-xl p-4 cursor-pointer transition-all duration-200 hover:border-blue-300 dark:hover:border-blue-500 hover:shadow-lg group"
    }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Ticket Header "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_30, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_31, " #" + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(ticket.ticket_number), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_32, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($options.formatDate(ticket.created_at)), 1 /* TEXT */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
      "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)([$options.getStatusBadgeClass(ticket.status), "inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium uppercase tracking-wider border"])
    }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($options.formatStatus(ticket.status)), 3 /* TEXT, CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Subject "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_33, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_34, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(ticket.subject), 1 /* TEXT */), ticket.description ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_35, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($options.truncateText(ticket.description, 120)), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Footer "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_36, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_37, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($options.getDepartmentName(ticket.category || ((_ticket$department2 = ticket.department) === null || _ticket$department2 === void 0 ? void 0 : _ticket$department2.name))), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_38, " Updated " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($options.formatDate(ticket.updated_at)), 1 /* TEXT */)])], 8 /* PROPS */, _hoisted_29);
  }), 128 /* KEYED_FRAGMENT */))])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Pagination "), $props.pagination.last_page > 1 ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_39, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_40, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_41, " Showing " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(($props.pagination.current_page - 1) * $props.pagination.per_page + 1) + " to " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(Math.min($props.pagination.current_page * $props.pagination.per_page, $props.pagination.total)) + " of " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($props.pagination.total) + " results ", 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_42, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
    onClick: _cache[0] || (_cache[0] = function ($event) {
      return _ctx.$emit('changePage', $props.pagination.current_page - 1);
    }),
    disabled: $props.pagination.current_page <= 1,
    "class": "px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-50 dark:hover:bg-gray-700 flex-1 sm:flex-none"
  }, " Previous ", 8 /* PROPS */, _hoisted_43), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", _hoisted_44, " Page " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($props.pagination.current_page) + " of " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($props.pagination.last_page), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
    onClick: _cache[1] || (_cache[1] = function ($event) {
      return _ctx.$emit('changePage', $props.pagination.current_page + 1);
    }),
    disabled: $props.pagination.current_page >= $props.pagination.last_page,
    "class": "px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-50 dark:hover:bg-gray-700 flex-1 sm:flex-none"
  }, " Next ", 8 /* PROPS */, _hoisted_45)])])])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true);
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/TicketWizard.vue?vue&type=template&id=2fe6f402":
/*!**********************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/TicketWizard.vue?vue&type=template&id=2fe6f402 ***!
  \**********************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "vue");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);

var _hoisted_1 = {
  key: 0,
  "class": "fixed inset-0 bg-gradient-to-br from-black/40 to-black/60 backdrop-blur-sm flex items-center justify-center z-50"
};
var _hoisted_2 = {
  "class": "bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-[95%] max-w-2xl max-h-[95vh] overflow-hidden flex flex-col m-4 border border-gray-200 dark:border-gray-600"
};
var _hoisted_3 = {
  "class": "flex justify-between items-center p-8 border-b border-gray-200 dark:border-gray-600 bg-gradient-to-r from-blue-50 to-white dark:from-gray-800 dark:to-gray-700"
};
var _hoisted_4 = {
  "class": "px-8 py-6 border-b border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/50"
};
var _hoisted_5 = {
  "class": "flex items-center justify-between"
};
var _hoisted_6 = {
  key: 0,
  "class": "text-white"
};
var _hoisted_7 = {
  key: 1,
  "class": "text-sm font-medium"
};
var _hoisted_8 = {
  "class": "flex justify-between mt-2"
};
var _hoisted_9 = {
  "class": "hidden sm:inline"
};
var _hoisted_10 = {
  "class": "sm:hidden"
};
var _hoisted_11 = {
  "class": "p-8 bg-white dark:bg-gray-800 min-h-[300px] max-h-[60vh] overflow-y-auto"
};
var _hoisted_12 = {
  key: 0,
  "class": "space-y-4"
};
var _hoisted_13 = {
  "class": "grid grid-cols-1 md:grid-cols-2 gap-3"
};
var _hoisted_14 = ["value"];
var _hoisted_15 = {
  "class": "flex items-center"
};
var _hoisted_16 = {
  "class": "mr-3 text-lg sm:text-xl"
};
var _hoisted_17 = {
  "class": "flex-1 min-w-0"
};
var _hoisted_18 = {
  "class": "font-medium text-gray-900 dark:text-gray-100 text-sm sm:text-base"
};
var _hoisted_19 = {
  "class": "text-xs sm:text-sm text-gray-500 dark:text-gray-400 leading-tight"
};
var _hoisted_20 = {
  key: 1,
  "class": "space-y-4"
};
var _hoisted_21 = {
  "class": "mb-4"
};
var _hoisted_22 = {
  "class": "mb-4"
};
var _hoisted_23 = {
  "class": "text-xs text-gray-500 dark:text-gray-400 mt-1"
};
var _hoisted_24 = {
  key: 2,
  "class": "space-y-4"
};
var _hoisted_25 = {
  "class": "mb-4"
};
var _hoisted_26 = {
  "class": "text-xs text-gray-500 dark:text-gray-400 mt-1"
};
var _hoisted_27 = {
  "class": "mb-4"
};
var _hoisted_28 = {
  key: 3,
  "class": "space-y-4"
};
var _hoisted_29 = {
  "class": "bg-gray-50 dark:bg-gray-700/50 rounded-lg p-6 space-y-4"
};
var _hoisted_30 = {
  "class": "flex justify-between items-start py-2 border-b border-gray-200 dark:border-gray-600"
};
var _hoisted_31 = {
  "class": "text-sm text-gray-900 dark:text-gray-100 font-medium"
};
var _hoisted_32 = {
  "class": "flex justify-between items-start py-2 border-b border-gray-200 dark:border-gray-600"
};
var _hoisted_33 = {
  "class": "text-sm text-gray-900 dark:text-gray-100 font-medium"
};
var _hoisted_34 = {
  "class": "flex justify-between items-start py-2 border-b border-gray-200 dark:border-gray-600"
};
var _hoisted_35 = {
  "class": "text-sm text-gray-900 dark:text-gray-100 font-medium"
};
var _hoisted_36 = {
  "class": "flex justify-between items-start py-2 border-b border-gray-200 dark:border-gray-600"
};
var _hoisted_37 = {
  "class": "text-sm text-gray-900 dark:text-gray-100 font-medium"
};
var _hoisted_38 = {
  "class": "py-2"
};
var _hoisted_39 = {
  "class": "text-sm text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 p-3 rounded border border-gray-200 dark:border-gray-600 whitespace-pre-wrap"
};
var _hoisted_40 = {
  "class": "flex justify-between items-center p-8 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600 gap-4"
};
var _hoisted_41 = ["disabled"];
var _hoisted_42 = ["disabled"];
function render(_ctx, _cache, $props, $setup, $data, $options) {
  return $props.isOpen ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Header "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_3, [_cache[10] || (_cache[10] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h2", {
    "class": "text-base sm:text-lg font-medium text-gray-900 dark:text-gray-100"
  }, " Create New Support Ticket ", -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
    onClick: _cache[0] || (_cache[0] = function () {
      return $options.closeWizard && $options.closeWizard.apply($options, arguments);
    }),
    "class": "text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors duration-200"
  }, _cache[9] || (_cache[9] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
    "class": "h-5 w-5 sm:h-6 sm:w-6",
    fill: "none",
    viewBox: "0 0 24 24",
    stroke: "currentColor"
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
    "stroke-linecap": "round",
    "stroke-linejoin": "round",
    "stroke-width": "2",
    d: "M6 18L18 6M6 6l12 12"
  })], -1 /* HOISTED */)]))]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Progress Steps "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_4, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_5, [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($setup.steps, function (_, index) {
    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", {
      key: index,
      "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["flex items-center", {
        'flex-1': index < $setup.steps.length - 1
      }])
    }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
      "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["w-8 h-8 rounded-full flex items-center justify-center text-sm font-medium transition-all duration-200", {
        'bg-blue-500 text-white': index === $setup.currentStep,
        'bg-green-500 text-white': index < $setup.currentStep,
        'bg-gray-200 dark:bg-gray-600 text-gray-500 dark:text-gray-400': index > $setup.currentStep
      }])
    }, [index < $setup.currentStep ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_6, "✓")) : ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_7, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(index + 1), 1 /* TEXT */))], 2 /* CLASS */), index < $setup.steps.length - 1 ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", {
      key: 0,
      "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["flex-1 h-0.5 mx-4 bg-gray-200 dark:bg-gray-600", {
        'bg-green-500': index < $setup.currentStep,
        'bg-blue-500': index === $setup.currentStep
      }])
    }, null, 2 /* CLASS */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */);
  }), 128 /* KEYED_FRAGMENT */))]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_8, [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($setup.steps, function (step, index) {
    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", {
      key: index,
      "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["text-xs font-medium flex-1 text-center px-1", {
        'text-blue-600 dark:text-blue-400': index === $setup.currentStep,
        'text-green-600 dark:text-green-400': index < $setup.currentStep,
        'text-gray-500 dark:text-gray-400': index > $setup.currentStep
      }])
    }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", _hoisted_9, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(step.title), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", _hoisted_10, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(step.title.substring(0, 4)), 1 /* TEXT */)], 2 /* CLASS */);
  }), 128 /* KEYED_FRAGMENT */))])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Step Content "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_11, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Step 1: Department Selection "), $setup.currentStep === 0 ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_12, [_cache[11] || (_cache[11] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h3", {
    "class": "text-sm sm:text-md font-medium text-gray-900 dark:text-gray-100 mb-4"
  }, " Which department can help you? ", -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_13, [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($setup.departments, function (dept) {
    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("label", {
      key: dept.value,
      "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["relative cursor-pointer rounded-lg border p-4 transition-all duration-200 hover:shadow-md", $setup.formData.department === dept.value ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/20 ring-2 ring-blue-500' : 'border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-500'])
    }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
      type: "radio",
      value: dept.value,
      "onUpdate:modelValue": _cache[1] || (_cache[1] = function ($event) {
        return $setup.formData.department = $event;
      }),
      "class": "sr-only"
    }, null, 8 /* PROPS */, _hoisted_14), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelRadio, $setup.formData.department]]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_15, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_16, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dept.icon), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_17, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_18, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dept.name), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_19, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dept.description), 1 /* TEXT */)])])], 2 /* CLASS */);
  }), 128 /* KEYED_FRAGMENT */))])])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Step 2: Priority & Subject "), $setup.currentStep === 1 ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_20, [_cache[15] || (_cache[15] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h3", {
    "class": "text-sm sm:text-md font-medium text-gray-900 dark:text-gray-100 mb-4"
  }, " Tell us about your issue ", -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_21, [_cache[13] || (_cache[13] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
    "class": "block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
  }, "Priority Level", -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("select", {
    "onUpdate:modelValue": _cache[2] || (_cache[2] = function ($event) {
      return $setup.formData.priority = $event;
    }),
    "class": "w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
  }, _cache[12] || (_cache[12] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
    value: "low"
  }, "Low - General question or request", -1 /* HOISTED */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
    value: "medium"
  }, "Medium - Issue affecting my work", -1 /* HOISTED */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
    value: "high"
  }, "High - Urgent issue needs quick resolution", -1 /* HOISTED */)]), 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelSelect, $setup.formData.priority]])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_22, [_cache[14] || (_cache[14] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
    "class": "block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
  }, "Subject", -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[3] || (_cache[3] = function ($event) {
      return $setup.formData.subject = $event;
    }),
    placeholder: "Brief description of your issue",
    "class": "w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200",
    maxlength: "100"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $setup.formData.subject]]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_23, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.formData.subject.length) + "/100 characters ", 1 /* TEXT */)])])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Step 3: Description & Details "), $setup.currentStep === 2 ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_24, [_cache[19] || (_cache[19] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h3", {
    "class": "text-sm sm:text-md font-medium text-gray-900 dark:text-gray-100 mb-4"
  }, " Provide more details ", -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_25, [_cache[16] || (_cache[16] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
    "class": "block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
  }, "Description", -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("textarea", {
    "onUpdate:modelValue": _cache[4] || (_cache[4] = function ($event) {
      return $setup.formData.description = $event;
    }),
    placeholder: "Please describe your issue in detail. Include any error messages, steps to reproduce, or relevant information.",
    "class": "w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 resize-vertical",
    rows: "6",
    maxlength: "1000"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $setup.formData.description]]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_26, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.formData.description.length) + "/1000 characters ", 1 /* TEXT */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_27, [_cache[17] || (_cache[17] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
    "class": "block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
  }, "Contact Email", -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "email",
    "onUpdate:modelValue": _cache[5] || (_cache[5] = function ($event) {
      return $setup.formData.email = $event;
    }),
    placeholder: "your@email.com",
    "class": "w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $setup.formData.email]]), _cache[18] || (_cache[18] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": "text-xs text-gray-500 dark:text-gray-400 mt-1"
  }, " We'll send updates to this email address ", -1 /* HOISTED */))])])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Step 4: Review & Submit "), $setup.currentStep === 3 ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_28, [_cache[25] || (_cache[25] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h3", {
    "class": "text-sm sm:text-md font-medium text-gray-900 dark:text-gray-100 mb-4"
  }, " Review your ticket ", -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_29, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_30, [_cache[20] || (_cache[20] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
    "class": "text-sm font-medium text-gray-600 dark:text-gray-400"
  }, "Department:", -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", _hoisted_31, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($options.getDepartmentName($setup.formData.department)), 1 /* TEXT */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_32, [_cache[21] || (_cache[21] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
    "class": "text-sm font-medium text-gray-600 dark:text-gray-400"
  }, "Priority:", -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", _hoisted_33, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($options.getPriorityName($setup.formData.priority)), 1 /* TEXT */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_34, [_cache[22] || (_cache[22] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
    "class": "text-sm font-medium text-gray-600 dark:text-gray-400"
  }, "Subject:", -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", _hoisted_35, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.formData.subject), 1 /* TEXT */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_36, [_cache[23] || (_cache[23] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
    "class": "text-sm font-medium text-gray-600 dark:text-gray-400"
  }, "Email:", -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", _hoisted_37, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.formData.email), 1 /* TEXT */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_38, [_cache[24] || (_cache[24] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
    "class": "text-sm font-medium text-gray-600 dark:text-gray-400 block mb-2"
  }, "Description:", -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_39, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.formData.description), 1 /* TEXT */)])])])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Footer Actions "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_40, [$setup.currentStep > 0 ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("button", {
    key: 0,
    onClick: _cache[6] || (_cache[6] = function () {
      return $options.previousStep && $options.previousStep.apply($options, arguments);
    }),
    "class": "bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 px-8 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-lg font-semibold text-sm tracking-wide transition-all duration-200 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 hover:border-gray-400 dark:hover:border-gray-500 hover:shadow-lg hover:-translate-y-0.5"
  }, " Previous ")) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), _cache[26] || (_cache[26] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": "flex-1"
  }, null, -1 /* HOISTED */)), $setup.currentStep < $setup.steps.length - 1 ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("button", {
    key: 1,
    onClick: _cache[7] || (_cache[7] = function () {
      return $options.nextStep && $options.nextStep.apply($options, arguments);
    }),
    disabled: !$setup.canProceed,
    "class": "bg-gradient-to-r from-blue-500 to-blue-600 text-white px-8 py-3 rounded-lg font-semibold text-sm tracking-wide transition-all duration-200 shadow-sm hover:from-blue-600 hover:to-blue-700 hover:shadow-lg hover:-translate-y-0.5 active:translate-y-0 active:shadow-sm disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:translate-y-0"
  }, " Next ", 8 /* PROPS */, _hoisted_41)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), $setup.currentStep === $setup.steps.length - 1 ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("button", {
    key: 2,
    onClick: _cache[8] || (_cache[8] = function () {
      return $options.submitTicket && $options.submitTicket.apply($options, arguments);
    }),
    disabled: $setup.isSubmitting,
    "class": "bg-gradient-to-r from-blue-500 to-blue-600 text-white px-8 py-3 rounded-lg font-semibold text-sm tracking-wide transition-all duration-200 shadow-sm hover:from-blue-600 hover:to-blue-700 hover:shadow-lg hover:-translate-y-0.5 active:translate-y-0 active:shadow-sm disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:translate-y-0"
  }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.isSubmitting ? 'Creating...' : 'Create Ticket'), 9 /* TEXT, PROPS */, _hoisted_42)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])])])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true);
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/Tool.vue?vue&type=template&id=ef10eebe":
/*!*********************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/Tool.vue?vue&type=template&id=ef10eebe ***!
  \*********************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "vue");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);

var _hoisted_1 = {
  "class": "min-h-screen bg-gray-50 dark:bg-gray-900"
};
var _hoisted_2 = {
  "class": "max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8"
};
function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_Head = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Head");
  var _component_TicketFilters = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("TicketFilters");
  var _component_TicketList = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("TicketList");
  var _component_LoadingSpinner = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("LoadingSpinner");
  var _component_TicketWizard = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("TicketWizard");
  var _component_TicketDetailsModal = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("TicketDetailsModal");
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Head, {
    title: "My Support"
  }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Main Content Area "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Filters "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_TicketFilters, {
    searchQuery: $setup.searchQuery,
    "onUpdate:searchQuery": [_cache[0] || (_cache[0] = function ($event) {
      return $setup.searchQuery = $event;
    }), $options.handleSearch],
    statusFilter: $setup.statusFilter,
    "onUpdate:statusFilter": [_cache[1] || (_cache[1] = function ($event) {
      return $setup.statusFilter = $event;
    }), $options.handleFilterChange],
    departmentFilter: $setup.departmentFilter,
    "onUpdate:departmentFilter": [_cache[2] || (_cache[2] = function ($event) {
      return $setup.departmentFilter = $event;
    }), $options.handleFilterChange],
    totalTickets: $setup.totalTickets,
    onCreateTicket: $options.openWizard
  }, null, 8 /* PROPS */, ["searchQuery", "statusFilter", "departmentFilter", "totalTickets", "onCreateTicket", "onUpdate:searchQuery", "onUpdate:statusFilter", "onUpdate:departmentFilter"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Ticket List "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_TicketList, {
    tickets: $setup.tickets,
    loading: $setup.loading,
    pagination: $setup.pagination,
    totalTickets: $setup.totalTickets,
    onViewTicket: $options.viewTicketDetails,
    onChangePage: $options.loadTickets,
    onCreateTicket: $options.openWizard
  }, null, 8 /* PROPS */, ["tickets", "loading", "pagination", "totalTickets", "onViewTicket", "onChangePage", "onCreateTicket"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Loading State "), $setup.loading && $setup.tickets.length === 0 ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(_component_LoadingSpinner, {
    key: 0,
    message: "Loading tickets..."
  })) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Ticket Creation Wizard "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_TicketWizard, {
    isOpen: $setup.showWizard,
    onClose: $options.closeWizard,
    onTicketCreated: $options.onTicketCreated
  }, null, 8 /* PROPS */, ["isOpen", "onClose", "onTicketCreated"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Ticket Details Modal "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_TicketDetailsModal, {
    isOpen: $setup.showTicketDetails,
    ticket: $setup.selectedTicket,
    onClose: $options.closeTicketDetails,
    onAddResponse: $options.onResponseAdded
  }, null, 8 /* PROPS */, ["isOpen", "ticket", "onClose", "onAddResponse"])]);
}

/***/ }),

/***/ "./node_modules/vue-loader/dist/exportHelper.js":
/*!******************************************************!*\
  !*** ./node_modules/vue-loader/dist/exportHelper.js ***!
  \******************************************************/
/***/ ((__unused_webpack_module, exports) => {


Object.defineProperty(exports, "__esModule", ({ value: true }));
// runtime helper for setting properties on components
// in a tree-shakable way
exports["default"] = (sfc, props) => {
    const target = sfc.__vccOpts || sfc;
    for (const [key, val] of props) {
        target[key] = val;
    }
    return target;
};


/***/ }),

/***/ "./resources/js/components/LoadingSpinner.vue":
/*!****************************************************!*\
  !*** ./resources/js/components/LoadingSpinner.vue ***!
  \****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _LoadingSpinner_vue_vue_type_template_id_41495c30__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./LoadingSpinner.vue?vue&type=template&id=41495c30 */ "./resources/js/components/LoadingSpinner.vue?vue&type=template&id=41495c30");
/* harmony import */ var _LoadingSpinner_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./LoadingSpinner.vue?vue&type=script&lang=js */ "./resources/js/components/LoadingSpinner.vue?vue&type=script&lang=js");
/* harmony import */ var _node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_LoadingSpinner_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_LoadingSpinner_vue_vue_type_template_id_41495c30__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/components/LoadingSpinner.vue"]])
/* hot reload */
if (false) // removed by dead control flow
{}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/components/LoadingSpinner.vue?vue&type=script&lang=js":
/*!****************************************************************************!*\
  !*** ./resources/js/components/LoadingSpinner.vue?vue&type=script&lang=js ***!
  \****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_LoadingSpinner_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_LoadingSpinner_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./LoadingSpinner.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/LoadingSpinner.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/components/LoadingSpinner.vue?vue&type=template&id=41495c30":
/*!**********************************************************************************!*\
  !*** ./resources/js/components/LoadingSpinner.vue?vue&type=template&id=41495c30 ***!
  \**********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_LoadingSpinner_vue_vue_type_template_id_41495c30__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_LoadingSpinner_vue_vue_type_template_id_41495c30__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./LoadingSpinner.vue?vue&type=template&id=41495c30 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/LoadingSpinner.vue?vue&type=template&id=41495c30");


/***/ }),

/***/ "./resources/js/components/TicketDetailsModal.vue":
/*!********************************************************!*\
  !*** ./resources/js/components/TicketDetailsModal.vue ***!
  \********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _TicketDetailsModal_vue_vue_type_template_id_175674e2__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TicketDetailsModal.vue?vue&type=template&id=175674e2 */ "./resources/js/components/TicketDetailsModal.vue?vue&type=template&id=175674e2");
/* harmony import */ var _TicketDetailsModal_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TicketDetailsModal.vue?vue&type=script&lang=js */ "./resources/js/components/TicketDetailsModal.vue?vue&type=script&lang=js");
/* harmony import */ var _node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_TicketDetailsModal_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_TicketDetailsModal_vue_vue_type_template_id_175674e2__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/components/TicketDetailsModal.vue"]])
/* hot reload */
if (false) // removed by dead control flow
{}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/components/TicketDetailsModal.vue?vue&type=script&lang=js":
/*!********************************************************************************!*\
  !*** ./resources/js/components/TicketDetailsModal.vue?vue&type=script&lang=js ***!
  \********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_TicketDetailsModal_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_TicketDetailsModal_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./TicketDetailsModal.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/TicketDetailsModal.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/components/TicketDetailsModal.vue?vue&type=template&id=175674e2":
/*!**************************************************************************************!*\
  !*** ./resources/js/components/TicketDetailsModal.vue?vue&type=template&id=175674e2 ***!
  \**************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_TicketDetailsModal_vue_vue_type_template_id_175674e2__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_TicketDetailsModal_vue_vue_type_template_id_175674e2__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./TicketDetailsModal.vue?vue&type=template&id=175674e2 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/TicketDetailsModal.vue?vue&type=template&id=175674e2");


/***/ }),

/***/ "./resources/js/components/TicketFilters.vue":
/*!***************************************************!*\
  !*** ./resources/js/components/TicketFilters.vue ***!
  \***************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _TicketFilters_vue_vue_type_template_id_20c33118__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TicketFilters.vue?vue&type=template&id=20c33118 */ "./resources/js/components/TicketFilters.vue?vue&type=template&id=20c33118");
/* harmony import */ var _TicketFilters_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TicketFilters.vue?vue&type=script&lang=js */ "./resources/js/components/TicketFilters.vue?vue&type=script&lang=js");
/* harmony import */ var _node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_TicketFilters_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_TicketFilters_vue_vue_type_template_id_20c33118__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/components/TicketFilters.vue"]])
/* hot reload */
if (false) // removed by dead control flow
{}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/components/TicketFilters.vue?vue&type=script&lang=js":
/*!***************************************************************************!*\
  !*** ./resources/js/components/TicketFilters.vue?vue&type=script&lang=js ***!
  \***************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_TicketFilters_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_TicketFilters_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./TicketFilters.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/TicketFilters.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/components/TicketFilters.vue?vue&type=template&id=20c33118":
/*!*********************************************************************************!*\
  !*** ./resources/js/components/TicketFilters.vue?vue&type=template&id=20c33118 ***!
  \*********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_TicketFilters_vue_vue_type_template_id_20c33118__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_TicketFilters_vue_vue_type_template_id_20c33118__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./TicketFilters.vue?vue&type=template&id=20c33118 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/TicketFilters.vue?vue&type=template&id=20c33118");


/***/ }),

/***/ "./resources/js/components/TicketList.vue":
/*!************************************************!*\
  !*** ./resources/js/components/TicketList.vue ***!
  \************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _TicketList_vue_vue_type_template_id_5d983d16__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TicketList.vue?vue&type=template&id=5d983d16 */ "./resources/js/components/TicketList.vue?vue&type=template&id=5d983d16");
/* harmony import */ var _TicketList_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TicketList.vue?vue&type=script&lang=js */ "./resources/js/components/TicketList.vue?vue&type=script&lang=js");
/* harmony import */ var _node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_TicketList_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_TicketList_vue_vue_type_template_id_5d983d16__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/components/TicketList.vue"]])
/* hot reload */
if (false) // removed by dead control flow
{}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/components/TicketList.vue?vue&type=script&lang=js":
/*!************************************************************************!*\
  !*** ./resources/js/components/TicketList.vue?vue&type=script&lang=js ***!
  \************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_TicketList_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_TicketList_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./TicketList.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/TicketList.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/components/TicketList.vue?vue&type=template&id=5d983d16":
/*!******************************************************************************!*\
  !*** ./resources/js/components/TicketList.vue?vue&type=template&id=5d983d16 ***!
  \******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_TicketList_vue_vue_type_template_id_5d983d16__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_TicketList_vue_vue_type_template_id_5d983d16__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./TicketList.vue?vue&type=template&id=5d983d16 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/TicketList.vue?vue&type=template&id=5d983d16");


/***/ }),

/***/ "./resources/js/components/TicketWizard.vue":
/*!**************************************************!*\
  !*** ./resources/js/components/TicketWizard.vue ***!
  \**************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _TicketWizard_vue_vue_type_template_id_2fe6f402__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TicketWizard.vue?vue&type=template&id=2fe6f402 */ "./resources/js/components/TicketWizard.vue?vue&type=template&id=2fe6f402");
/* harmony import */ var _TicketWizard_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TicketWizard.vue?vue&type=script&lang=js */ "./resources/js/components/TicketWizard.vue?vue&type=script&lang=js");
/* harmony import */ var _node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_TicketWizard_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_TicketWizard_vue_vue_type_template_id_2fe6f402__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/components/TicketWizard.vue"]])
/* hot reload */
if (false) // removed by dead control flow
{}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/components/TicketWizard.vue?vue&type=script&lang=js":
/*!**************************************************************************!*\
  !*** ./resources/js/components/TicketWizard.vue?vue&type=script&lang=js ***!
  \**************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_TicketWizard_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_TicketWizard_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./TicketWizard.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/TicketWizard.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/components/TicketWizard.vue?vue&type=template&id=2fe6f402":
/*!********************************************************************************!*\
  !*** ./resources/js/components/TicketWizard.vue?vue&type=template&id=2fe6f402 ***!
  \********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_TicketWizard_vue_vue_type_template_id_2fe6f402__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_TicketWizard_vue_vue_type_template_id_2fe6f402__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./TicketWizard.vue?vue&type=template&id=2fe6f402 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/TicketWizard.vue?vue&type=template&id=2fe6f402");


/***/ }),

/***/ "./resources/js/pages/Tool.vue":
/*!*************************************!*\
  !*** ./resources/js/pages/Tool.vue ***!
  \*************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Tool_vue_vue_type_template_id_ef10eebe__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Tool.vue?vue&type=template&id=ef10eebe */ "./resources/js/pages/Tool.vue?vue&type=template&id=ef10eebe");
/* harmony import */ var _Tool_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Tool.vue?vue&type=script&lang=js */ "./resources/js/pages/Tool.vue?vue&type=script&lang=js");
/* harmony import */ var _node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_Tool_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Tool_vue_vue_type_template_id_ef10eebe__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/pages/Tool.vue"]])
/* hot reload */
if (false) // removed by dead control flow
{}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/pages/Tool.vue?vue&type=script&lang=js":
/*!*************************************************************!*\
  !*** ./resources/js/pages/Tool.vue?vue&type=script&lang=js ***!
  \*************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Tool_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Tool_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Tool.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/Tool.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/pages/Tool.vue?vue&type=template&id=ef10eebe":
/*!*******************************************************************!*\
  !*** ./resources/js/pages/Tool.vue?vue&type=template&id=ef10eebe ***!
  \*******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Tool_vue_vue_type_template_id_ef10eebe__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Tool_vue_vue_type_template_id_ef10eebe__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Tool.vue?vue&type=template&id=ef10eebe */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/Tool.vue?vue&type=template&id=ef10eebe");


/***/ }),

/***/ "vue":
/*!**********************!*\
  !*** external "Vue" ***!
  \**********************/
/***/ ((module) => {

module.exports = Vue;

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry needs to be wrapped in an IIFE because it needs to be isolated against other modules in the chunk.
(() => {
/*!******************************!*\
  !*** ./resources/js/tool.js ***!
  \******************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _pages_Tool__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./pages/Tool */ "./resources/js/pages/Tool.vue");

Nova.inertia('CustomerSupport', _pages_Tool__WEBPACK_IMPORTED_MODULE_0__["default"]);
Nova.booting(function (app, store) {
  //
});
})();

/******/ })()
;