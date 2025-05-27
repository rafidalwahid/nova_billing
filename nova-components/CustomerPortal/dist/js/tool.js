/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Dashboard.vue?vue&type=script&lang=js":
/*!***************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Dashboard.vue?vue&type=script&lang=js ***!
  \***************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _utils_helpers_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../utils/helpers.js */ "./resources/js/utils/helpers.js");

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: 'Dashboard',
  props: {
    dashboardData: {
      type: Object,
      required: true
    }
  },
  computed: {
    statusBadgeType: function statusBadgeType() {
      var _this$dashboardData$c;
      var status = (_this$dashboardData$c = this.dashboardData.customer) === null || _this$dashboardData$c === void 0 ? void 0 : _this$dashboardData$c.status;
      switch (status) {
        case 'Active':
          return 'success';
        case 'Inactive':
          return 'danger';
        case 'Suspended':
          return 'warning';
        default:
          return 'info';
      }
    }
  },
  methods: {
    formatMoney: _utils_helpers_js__WEBPACK_IMPORTED_MODULE_0__.formatMoney,
    formatDate: _utils_helpers_js__WEBPACK_IMPORTED_MODULE_0__.formatDate,
    getOrderStatusClass: _utils_helpers_js__WEBPACK_IMPORTED_MODULE_0__.getOrderStatusClass,
    getInvoiceStatusClass: _utils_helpers_js__WEBPACK_IMPORTED_MODULE_0__.getInvoiceStatusClass,
    getOrderBadgeType: function getOrderBadgeType(status) {
      var badgeTypes = {
        'pending': 'warning',
        'processing': 'info',
        'completed': 'success',
        'active': 'success',
        'cancelled': 'danger',
        'shipped': 'info'
      };
      return badgeTypes[status] || 'info';
    },
    getInvoiceBadgeType: function getInvoiceBadgeType(status) {
      var badgeTypes = {
        'draft': 'info',
        'sent': 'info',
        'paid': 'success',
        'overdue': 'danger',
        'cancelled': 'danger',
        'partial': 'warning'
      };
      return badgeTypes[status] || 'info';
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Invoices.vue?vue&type=script&lang=js":
/*!**************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Invoices.vue?vue&type=script&lang=js ***!
  \**************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _utils_helpers_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../utils/helpers.js */ "./resources/js/utils/helpers.js");
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/babel/babel/blob/main/packages/babel-helpers/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return r; }; var t, r = {}, e = Object.prototype, n = e.hasOwnProperty, o = "function" == typeof Symbol ? Symbol : {}, i = o.iterator || "@@iterator", a = o.asyncIterator || "@@asyncIterator", u = o.toStringTag || "@@toStringTag"; function c(t, r, e, n) { return Object.defineProperty(t, r, { value: e, enumerable: !n, configurable: !n, writable: !n }); } try { c({}, ""); } catch (t) { c = function c(t, r, e) { return t[r] = e; }; } function h(r, e, n, o) { var i = e && e.prototype instanceof Generator ? e : Generator, a = Object.create(i.prototype); return c(a, "_invoke", function (r, e, n) { var o = 1; return function (i, a) { if (3 === o) throw Error("Generator is already running"); if (4 === o) { if ("throw" === i) throw a; return { value: t, done: !0 }; } for (n.method = i, n.arg = a;;) { var u = n.delegate; if (u) { var c = d(u, n); if (c) { if (c === f) continue; return c; } } if ("next" === n.method) n.sent = n._sent = n.arg;else if ("throw" === n.method) { if (1 === o) throw o = 4, n.arg; n.dispatchException(n.arg); } else "return" === n.method && n.abrupt("return", n.arg); o = 3; var h = s(r, e, n); if ("normal" === h.type) { if (o = n.done ? 4 : 2, h.arg === f) continue; return { value: h.arg, done: n.done }; } "throw" === h.type && (o = 4, n.method = "throw", n.arg = h.arg); } }; }(r, n, new Context(o || [])), !0), a; } function s(t, r, e) { try { return { type: "normal", arg: t.call(r, e) }; } catch (t) { return { type: "throw", arg: t }; } } r.wrap = h; var f = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var l = {}; c(l, i, function () { return this; }); var p = Object.getPrototypeOf, y = p && p(p(x([]))); y && y !== e && n.call(y, i) && (l = y); var v = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(l); function g(t) { ["next", "throw", "return"].forEach(function (r) { c(t, r, function (t) { return this._invoke(r, t); }); }); } function AsyncIterator(t, r) { function e(o, i, a, u) { var c = s(t[o], t, i); if ("throw" !== c.type) { var h = c.arg, f = h.value; return f && "object" == _typeof(f) && n.call(f, "__await") ? r.resolve(f.__await).then(function (t) { e("next", t, a, u); }, function (t) { e("throw", t, a, u); }) : r.resolve(f).then(function (t) { h.value = t, a(h); }, function (t) { return e("throw", t, a, u); }); } u(c.arg); } var o; c(this, "_invoke", function (t, n) { function i() { return new r(function (r, o) { e(t, n, r, o); }); } return o = o ? o.then(i, i) : i(); }, !0); } function d(r, e) { var n = e.method, o = r.i[n]; if (o === t) return e.delegate = null, "throw" === n && r.i["return"] && (e.method = "return", e.arg = t, d(r, e), "throw" === e.method) || "return" !== n && (e.method = "throw", e.arg = new TypeError("The iterator does not provide a '" + n + "' method")), f; var i = s(o, r.i, e.arg); if ("throw" === i.type) return e.method = "throw", e.arg = i.arg, e.delegate = null, f; var a = i.arg; return a ? a.done ? (e[r.r] = a.value, e.next = r.n, "return" !== e.method && (e.method = "next", e.arg = t), e.delegate = null, f) : a : (e.method = "throw", e.arg = new TypeError("iterator result is not an object"), e.delegate = null, f); } function w(t) { this.tryEntries.push(t); } function m(r) { var e = r[4] || {}; e.type = "normal", e.arg = t, r[4] = e; } function Context(t) { this.tryEntries = [[-1]], t.forEach(w, this), this.reset(!0); } function x(r) { if (null != r) { var e = r[i]; if (e) return e.call(r); if ("function" == typeof r.next) return r; if (!isNaN(r.length)) { var o = -1, a = function e() { for (; ++o < r.length;) if (n.call(r, o)) return e.value = r[o], e.done = !1, e; return e.value = t, e.done = !0, e; }; return a.next = a; } } throw new TypeError(_typeof(r) + " is not iterable"); } return GeneratorFunction.prototype = GeneratorFunctionPrototype, c(v, "constructor", GeneratorFunctionPrototype), c(GeneratorFunctionPrototype, "constructor", GeneratorFunction), GeneratorFunction.displayName = c(GeneratorFunctionPrototype, u, "GeneratorFunction"), r.isGeneratorFunction = function (t) { var r = "function" == typeof t && t.constructor; return !!r && (r === GeneratorFunction || "GeneratorFunction" === (r.displayName || r.name)); }, r.mark = function (t) { return Object.setPrototypeOf ? Object.setPrototypeOf(t, GeneratorFunctionPrototype) : (t.__proto__ = GeneratorFunctionPrototype, c(t, u, "GeneratorFunction")), t.prototype = Object.create(v), t; }, r.awrap = function (t) { return { __await: t }; }, g(AsyncIterator.prototype), c(AsyncIterator.prototype, a, function () { return this; }), r.AsyncIterator = AsyncIterator, r.async = function (t, e, n, o, i) { void 0 === i && (i = Promise); var a = new AsyncIterator(h(t, e, n, o), i); return r.isGeneratorFunction(e) ? a : a.next().then(function (t) { return t.done ? t.value : a.next(); }); }, g(v), c(v, u, "Generator"), c(v, i, function () { return this; }), c(v, "toString", function () { return "[object Generator]"; }), r.keys = function (t) { var r = Object(t), e = []; for (var n in r) e.unshift(n); return function t() { for (; e.length;) if ((n = e.pop()) in r) return t.value = n, t.done = !1, t; return t.done = !0, t; }; }, r.values = x, Context.prototype = { constructor: Context, reset: function reset(r) { if (this.prev = this.next = 0, this.sent = this._sent = t, this.done = !1, this.delegate = null, this.method = "next", this.arg = t, this.tryEntries.forEach(m), !r) for (var e in this) "t" === e.charAt(0) && n.call(this, e) && !isNaN(+e.slice(1)) && (this[e] = t); }, stop: function stop() { this.done = !0; var t = this.tryEntries[0][4]; if ("throw" === t.type) throw t.arg; return this.rval; }, dispatchException: function dispatchException(r) { if (this.done) throw r; var e = this; function n(t) { a.type = "throw", a.arg = r, e.next = t; } for (var o = e.tryEntries.length - 1; o >= 0; --o) { var i = this.tryEntries[o], a = i[4], u = this.prev, c = i[1], h = i[2]; if (-1 === i[0]) return n("end"), !1; if (!c && !h) throw Error("try statement without catch or finally"); if (null != i[0] && i[0] <= u) { if (u < c) return this.method = "next", this.arg = t, n(c), !0; if (u < h) return n(h), !1; } } }, abrupt: function abrupt(t, r) { for (var e = this.tryEntries.length - 1; e >= 0; --e) { var n = this.tryEntries[e]; if (n[0] > -1 && n[0] <= this.prev && this.prev < n[2]) { var o = n; break; } } o && ("break" === t || "continue" === t) && o[0] <= r && r <= o[2] && (o = null); var i = o ? o[4] : {}; return i.type = t, i.arg = r, o ? (this.method = "next", this.next = o[2], f) : this.complete(i); }, complete: function complete(t, r) { if ("throw" === t.type) throw t.arg; return "break" === t.type || "continue" === t.type ? this.next = t.arg : "return" === t.type ? (this.rval = this.arg = t.arg, this.method = "return", this.next = "end") : "normal" === t.type && r && (this.next = r), f; }, finish: function finish(t) { for (var r = this.tryEntries.length - 1; r >= 0; --r) { var e = this.tryEntries[r]; if (e[2] === t) return this.complete(e[4], e[3]), m(e), f; } }, "catch": function _catch(t) { for (var r = this.tryEntries.length - 1; r >= 0; --r) { var e = this.tryEntries[r]; if (e[0] === t) { var n = e[4]; if ("throw" === n.type) { var o = n.arg; m(e); } return o; } } throw Error("illegal catch attempt"); }, delegateYield: function delegateYield(r, e, n) { return this.delegate = { i: x(r), r: e, n: n }, "next" === this.method && (this.arg = t), f; } }, r; }
function asyncGeneratorStep(n, t, e, r, o, a, c) { try { var i = n[a](c), u = i.value; } catch (n) { return void e(n); } i.done ? t(u) : Promise.resolve(u).then(r, o); }
function _asyncToGenerator(n) { return function () { var t = this, e = arguments; return new Promise(function (r, o) { var a = n.apply(t, e); function _next(n) { asyncGeneratorStep(a, r, o, _next, _throw, "next", n); } function _throw(n) { asyncGeneratorStep(a, r, o, _next, _throw, "throw", n); } _next(void 0); }); }; }


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: 'Invoices',
  data: function data() {
    return {
      invoices: [],
      loading: false,
      searchQuery: '',
      statusFilter: '',
      pagination: {
        current_page: 1,
        last_page: 1,
        per_page: 10,
        total: 0
      },
      totalInvoices: 0,
      searchTimeout: null,
      // Modal state
      showInvoiceModal: false,
      selectedInvoice: null
    };
  },
  computed: {
    debouncedSearch: function debouncedSearch() {
      var _this = this;
      return function () {
        clearTimeout(_this.searchTimeout);
        _this.searchTimeout = setTimeout(function () {
          _this.loadInvoices(1);
        }, 500);
      };
    }
  },
  mounted: function mounted() {
    this.loadInvoices();
  },
  methods: {
    formatMoney: _utils_helpers_js__WEBPACK_IMPORTED_MODULE_0__.formatMoney,
    formatDate: _utils_helpers_js__WEBPACK_IMPORTED_MODULE_0__.formatDate,
    formatTime: _utils_helpers_js__WEBPACK_IMPORTED_MODULE_0__.formatTime,
    loadInvoices: function loadInvoices() {
      var _arguments = arguments,
        _this2 = this;
      return _asyncToGenerator(/*#__PURE__*/_regeneratorRuntime().mark(function _callee() {
        var page, _response$meta, filters, response, _error$response, _error$response2, _error$response3, _this2$$toasted, _this2$$toasted2, _this2$$toasted3;
        return _regeneratorRuntime().wrap(function _callee$(_context) {
          while (1) switch (_context.prev = _context.next) {
            case 0:
              page = _arguments.length > 0 && _arguments[0] !== undefined ? _arguments[0] : 1;
              _context.prev = 1;
              _this2.loading = true;

              // Build filters object
              filters = {};
              if (_this2.searchQuery.trim()) {
                filters.search = _this2.searchQuery.trim();
              }
              if (_this2.statusFilter) {
                filters.status = _this2.statusFilter;
              }
              _context.next = 8;
              return _utils_helpers_js__WEBPACK_IMPORTED_MODULE_0__.CustomerPortalAPI.getInvoices(page, filters);
            case 8:
              response = _context.sent;
              _this2.invoices = response.data || [];
              _this2.pagination = response.meta || {};
              _this2.totalInvoices = ((_response$meta = response.meta) === null || _response$meta === void 0 ? void 0 : _response$meta.total) || 0;
              _context.next = 22;
              break;
            case 14:
              _context.prev = 14;
              _context.t0 = _context["catch"](1);
              console.error('Error loading invoices:', _context.t0);
              console.error('Error details:', ((_error$response = _context.t0.response) === null || _error$response === void 0 ? void 0 : _error$response.data) || _context.t0.message);

              // Show user-friendly error message
              if (((_error$response2 = _context.t0.response) === null || _error$response2 === void 0 ? void 0 : _error$response2.status) === 401) {
                (_this2$$toasted = _this2.$toasted) === null || _this2$$toasted === void 0 || _this2$$toasted.error('Authentication required. Please log in again.');
              } else if (((_error$response3 = _context.t0.response) === null || _error$response3 === void 0 ? void 0 : _error$response3.status) === 403) {
                (_this2$$toasted2 = _this2.$toasted) === null || _this2$$toasted2 === void 0 || _this2$$toasted2.error('Access denied. You do not have permission to view invoices.');
              } else {
                (_this2$$toasted3 = _this2.$toasted) === null || _this2$$toasted3 === void 0 || _this2$$toasted3.error('Failed to load invoices. Please try again.');
              }

              // Reset data on error
              _this2.invoices = [];
              _this2.pagination = {
                current_page: 1,
                last_page: 1,
                per_page: 10,
                total: 0
              };
              _this2.totalInvoices = 0;
            case 22:
              _context.prev = 22;
              _this2.loading = false;
              return _context.finish(22);
            case 25:
            case "end":
              return _context.stop();
          }
        }, _callee, null, [[1, 14, 22, 25]]);
      }))();
    },
    viewInvoiceDetails: function viewInvoiceDetails(invoice) {
      var _this3 = this;
      return _asyncToGenerator(/*#__PURE__*/_regeneratorRuntime().mark(function _callee2() {
        var response, _this3$$toasted;
        return _regeneratorRuntime().wrap(function _callee2$(_context2) {
          while (1) switch (_context2.prev = _context2.next) {
            case 0:
              _this3.selectedInvoice = invoice;
              _this3.showInvoiceModal = true;

              // Load full invoice details if needed
              _context2.prev = 2;
              _context2.next = 5;
              return _utils_helpers_js__WEBPACK_IMPORTED_MODULE_0__.CustomerPortalAPI.getInvoice(invoice.id);
            case 5:
              response = _context2.sent;
              _this3.selectedInvoice = response.data || invoice;
              _context2.next = 13;
              break;
            case 9:
              _context2.prev = 9;
              _context2.t0 = _context2["catch"](2);
              console.error('Error loading invoice details:', _context2.t0);
              (_this3$$toasted = _this3.$toasted) === null || _this3$$toasted === void 0 || _this3$$toasted.error('Failed to load invoice details');
            case 13:
            case "end":
              return _context2.stop();
          }
        }, _callee2, null, [[2, 9]]);
      }))();
    },
    closeInvoiceModal: function closeInvoiceModal() {
      this.showInvoiceModal = false;
      this.selectedInvoice = null;
    },
    downloadInvoice: function downloadInvoice(invoiceId) {
      var _this4 = this;
      return _asyncToGenerator(/*#__PURE__*/_regeneratorRuntime().mark(function _callee3() {
        var _this4$$toasted, response, _this4$$toasted2, url, link, _this4$$toasted3;
        return _regeneratorRuntime().wrap(function _callee3$(_context3) {
          while (1) switch (_context3.prev = _context3.next) {
            case 0:
              _context3.prev = 0;
              (_this4$$toasted = _this4.$toasted) === null || _this4$$toasted === void 0 || _this4$$toasted.info('Preparing invoice download...');
              _context3.next = 4;
              return _utils_helpers_js__WEBPACK_IMPORTED_MODULE_0__.CustomerPortalAPI.downloadInvoicePdf(invoiceId);
            case 4:
              response = _context3.sent;
              // Handle PDF download
              if (response.data) {
                // Create download link
                url = window.URL.createObjectURL(new Blob([response.data]));
                link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', "invoice-".concat(invoiceId, ".pdf"));
                document.body.appendChild(link);
                link.click();
                link.remove();
                window.URL.revokeObjectURL(url);
                (_this4$$toasted2 = _this4.$toasted) === null || _this4$$toasted2 === void 0 || _this4$$toasted2.success('Invoice downloaded successfully');
              }
              _context3.next = 12;
              break;
            case 8:
              _context3.prev = 8;
              _context3.t0 = _context3["catch"](0);
              console.error('Error downloading invoice:', _context3.t0);
              (_this4$$toasted3 = _this4.$toasted) === null || _this4$$toasted3 === void 0 || _this4$$toasted3.error('Failed to download invoice. Please try again.');
            case 12:
            case "end":
              return _context3.stop();
          }
        }, _callee3, null, [[0, 8]]);
      }))();
    },
    payInvoice: function payInvoice(invoiceId) {
      var _this5 = this;
      return _asyncToGenerator(/*#__PURE__*/_regeneratorRuntime().mark(function _callee4() {
        var _this5$$toasted;
        return _regeneratorRuntime().wrap(function _callee4$(_context4) {
          while (1) switch (_context4.prev = _context4.next) {
            case 0:
              // Placeholder for payment functionality
              (_this5$$toasted = _this5.$toasted) === null || _this5$$toasted === void 0 || _this5$$toasted.info("Payment processing for invoice #".concat(invoiceId, " - This feature will be implemented in a future update"));
            case 1:
            case "end":
              return _context4.stop();
          }
        }, _callee4);
      }))();
    },
    clearFilters: function clearFilters() {
      this.searchQuery = '';
      this.statusFilter = '';
      this.loadInvoices(1);
    },
    getInvoiceBadgeType: function getInvoiceBadgeType(status) {
      var badgeTypes = {
        'draft': 'info',
        'sent': 'info',
        'paid': 'success',
        'overdue': 'danger',
        'cancelled': 'danger',
        'partial': 'warning'
      };
      return badgeTypes[status] || 'info';
    },
    formatStatus: function formatStatus(status) {
      if (!status) return 'Unknown';
      return status.charAt(0).toUpperCase() + status.slice(1).replace('_', ' ');
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Profile.vue?vue&type=script&lang=js":
/*!*************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Profile.vue?vue&type=script&lang=js ***!
  \*************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/babel/babel/blob/main/packages/babel-helpers/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return r; }; var t, r = {}, e = Object.prototype, n = e.hasOwnProperty, o = "function" == typeof Symbol ? Symbol : {}, i = o.iterator || "@@iterator", a = o.asyncIterator || "@@asyncIterator", u = o.toStringTag || "@@toStringTag"; function c(t, r, e, n) { return Object.defineProperty(t, r, { value: e, enumerable: !n, configurable: !n, writable: !n }); } try { c({}, ""); } catch (t) { c = function c(t, r, e) { return t[r] = e; }; } function h(r, e, n, o) { var i = e && e.prototype instanceof Generator ? e : Generator, a = Object.create(i.prototype); return c(a, "_invoke", function (r, e, n) { var o = 1; return function (i, a) { if (3 === o) throw Error("Generator is already running"); if (4 === o) { if ("throw" === i) throw a; return { value: t, done: !0 }; } for (n.method = i, n.arg = a;;) { var u = n.delegate; if (u) { var c = d(u, n); if (c) { if (c === f) continue; return c; } } if ("next" === n.method) n.sent = n._sent = n.arg;else if ("throw" === n.method) { if (1 === o) throw o = 4, n.arg; n.dispatchException(n.arg); } else "return" === n.method && n.abrupt("return", n.arg); o = 3; var h = s(r, e, n); if ("normal" === h.type) { if (o = n.done ? 4 : 2, h.arg === f) continue; return { value: h.arg, done: n.done }; } "throw" === h.type && (o = 4, n.method = "throw", n.arg = h.arg); } }; }(r, n, new Context(o || [])), !0), a; } function s(t, r, e) { try { return { type: "normal", arg: t.call(r, e) }; } catch (t) { return { type: "throw", arg: t }; } } r.wrap = h; var f = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var l = {}; c(l, i, function () { return this; }); var p = Object.getPrototypeOf, y = p && p(p(x([]))); y && y !== e && n.call(y, i) && (l = y); var v = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(l); function g(t) { ["next", "throw", "return"].forEach(function (r) { c(t, r, function (t) { return this._invoke(r, t); }); }); } function AsyncIterator(t, r) { function e(o, i, a, u) { var c = s(t[o], t, i); if ("throw" !== c.type) { var h = c.arg, f = h.value; return f && "object" == _typeof(f) && n.call(f, "__await") ? r.resolve(f.__await).then(function (t) { e("next", t, a, u); }, function (t) { e("throw", t, a, u); }) : r.resolve(f).then(function (t) { h.value = t, a(h); }, function (t) { return e("throw", t, a, u); }); } u(c.arg); } var o; c(this, "_invoke", function (t, n) { function i() { return new r(function (r, o) { e(t, n, r, o); }); } return o = o ? o.then(i, i) : i(); }, !0); } function d(r, e) { var n = e.method, o = r.i[n]; if (o === t) return e.delegate = null, "throw" === n && r.i["return"] && (e.method = "return", e.arg = t, d(r, e), "throw" === e.method) || "return" !== n && (e.method = "throw", e.arg = new TypeError("The iterator does not provide a '" + n + "' method")), f; var i = s(o, r.i, e.arg); if ("throw" === i.type) return e.method = "throw", e.arg = i.arg, e.delegate = null, f; var a = i.arg; return a ? a.done ? (e[r.r] = a.value, e.next = r.n, "return" !== e.method && (e.method = "next", e.arg = t), e.delegate = null, f) : a : (e.method = "throw", e.arg = new TypeError("iterator result is not an object"), e.delegate = null, f); } function w(t) { this.tryEntries.push(t); } function m(r) { var e = r[4] || {}; e.type = "normal", e.arg = t, r[4] = e; } function Context(t) { this.tryEntries = [[-1]], t.forEach(w, this), this.reset(!0); } function x(r) { if (null != r) { var e = r[i]; if (e) return e.call(r); if ("function" == typeof r.next) return r; if (!isNaN(r.length)) { var o = -1, a = function e() { for (; ++o < r.length;) if (n.call(r, o)) return e.value = r[o], e.done = !1, e; return e.value = t, e.done = !0, e; }; return a.next = a; } } throw new TypeError(_typeof(r) + " is not iterable"); } return GeneratorFunction.prototype = GeneratorFunctionPrototype, c(v, "constructor", GeneratorFunctionPrototype), c(GeneratorFunctionPrototype, "constructor", GeneratorFunction), GeneratorFunction.displayName = c(GeneratorFunctionPrototype, u, "GeneratorFunction"), r.isGeneratorFunction = function (t) { var r = "function" == typeof t && t.constructor; return !!r && (r === GeneratorFunction || "GeneratorFunction" === (r.displayName || r.name)); }, r.mark = function (t) { return Object.setPrototypeOf ? Object.setPrototypeOf(t, GeneratorFunctionPrototype) : (t.__proto__ = GeneratorFunctionPrototype, c(t, u, "GeneratorFunction")), t.prototype = Object.create(v), t; }, r.awrap = function (t) { return { __await: t }; }, g(AsyncIterator.prototype), c(AsyncIterator.prototype, a, function () { return this; }), r.AsyncIterator = AsyncIterator, r.async = function (t, e, n, o, i) { void 0 === i && (i = Promise); var a = new AsyncIterator(h(t, e, n, o), i); return r.isGeneratorFunction(e) ? a : a.next().then(function (t) { return t.done ? t.value : a.next(); }); }, g(v), c(v, u, "Generator"), c(v, i, function () { return this; }), c(v, "toString", function () { return "[object Generator]"; }), r.keys = function (t) { var r = Object(t), e = []; for (var n in r) e.unshift(n); return function t() { for (; e.length;) if ((n = e.pop()) in r) return t.value = n, t.done = !1, t; return t.done = !0, t; }; }, r.values = x, Context.prototype = { constructor: Context, reset: function reset(r) { if (this.prev = this.next = 0, this.sent = this._sent = t, this.done = !1, this.delegate = null, this.method = "next", this.arg = t, this.tryEntries.forEach(m), !r) for (var e in this) "t" === e.charAt(0) && n.call(this, e) && !isNaN(+e.slice(1)) && (this[e] = t); }, stop: function stop() { this.done = !0; var t = this.tryEntries[0][4]; if ("throw" === t.type) throw t.arg; return this.rval; }, dispatchException: function dispatchException(r) { if (this.done) throw r; var e = this; function n(t) { a.type = "throw", a.arg = r, e.next = t; } for (var o = e.tryEntries.length - 1; o >= 0; --o) { var i = this.tryEntries[o], a = i[4], u = this.prev, c = i[1], h = i[2]; if (-1 === i[0]) return n("end"), !1; if (!c && !h) throw Error("try statement without catch or finally"); if (null != i[0] && i[0] <= u) { if (u < c) return this.method = "next", this.arg = t, n(c), !0; if (u < h) return n(h), !1; } } }, abrupt: function abrupt(t, r) { for (var e = this.tryEntries.length - 1; e >= 0; --e) { var n = this.tryEntries[e]; if (n[0] > -1 && n[0] <= this.prev && this.prev < n[2]) { var o = n; break; } } o && ("break" === t || "continue" === t) && o[0] <= r && r <= o[2] && (o = null); var i = o ? o[4] : {}; return i.type = t, i.arg = r, o ? (this.method = "next", this.next = o[2], f) : this.complete(i); }, complete: function complete(t, r) { if ("throw" === t.type) throw t.arg; return "break" === t.type || "continue" === t.type ? this.next = t.arg : "return" === t.type ? (this.rval = this.arg = t.arg, this.method = "return", this.next = "end") : "normal" === t.type && r && (this.next = r), f; }, finish: function finish(t) { for (var r = this.tryEntries.length - 1; r >= 0; --r) { var e = this.tryEntries[r]; if (e[2] === t) return this.complete(e[4], e[3]), m(e), f; } }, "catch": function _catch(t) { for (var r = this.tryEntries.length - 1; r >= 0; --r) { var e = this.tryEntries[r]; if (e[0] === t) { var n = e[4]; if ("throw" === n.type) { var o = n.arg; m(e); } return o; } } throw Error("illegal catch attempt"); }, delegateYield: function delegateYield(r, e, n) { return this.delegate = { i: x(r), r: e, n: n }, "next" === this.method && (this.arg = t), f; } }, r; }
function asyncGeneratorStep(n, t, e, r, o, a, c) { try { var i = n[a](c), u = i.value; } catch (n) { return void e(n); } i.done ? t(u) : Promise.resolve(u).then(r, o); }
function _asyncToGenerator(n) { return function () { var t = this, e = arguments; return new Promise(function (r, o) { var a = n.apply(t, e); function _next(n) { asyncGeneratorStep(a, r, o, _next, _throw, "next", n); } function _throw(n) { asyncGeneratorStep(a, r, o, _next, _throw, "throw", n); } _next(void 0); }); }; }
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: 'Profile',
  data: function data() {
    return {
      profile: {},
      loading: false
    };
  },
  mounted: function mounted() {
    this.loadProfile();
  },
  methods: {
    loadProfile: function loadProfile() {
      var _this = this;
      return _asyncToGenerator(/*#__PURE__*/_regeneratorRuntime().mark(function _callee() {
        return _regeneratorRuntime().wrap(function _callee$(_context) {
          while (1) switch (_context.prev = _context.next) {
            case 0:
              try {
                _this.loading = true;
                // TODO: Add API endpoint for profile
                // const response = await Nova.request().get('/nova-vendor/customer-portal/profile')
                // this.profile = response.data.profile
              } catch (error) {
                console.error('Error loading profile:', error);
                _this.$toasted.error('Failed to load profile');
              } finally {
                _this.loading = false;
              }
            case 1:
            case "end":
              return _context.stop();
          }
        }, _callee);
      }))();
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Services.vue?vue&type=script&lang=js":
/*!**************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Services.vue?vue&type=script&lang=js ***!
  \**************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _utils_helpers_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../utils/helpers.js */ "./resources/js/utils/helpers.js");
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/babel/babel/blob/main/packages/babel-helpers/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return r; }; var t, r = {}, e = Object.prototype, n = e.hasOwnProperty, o = "function" == typeof Symbol ? Symbol : {}, i = o.iterator || "@@iterator", a = o.asyncIterator || "@@asyncIterator", u = o.toStringTag || "@@toStringTag"; function c(t, r, e, n) { return Object.defineProperty(t, r, { value: e, enumerable: !n, configurable: !n, writable: !n }); } try { c({}, ""); } catch (t) { c = function c(t, r, e) { return t[r] = e; }; } function h(r, e, n, o) { var i = e && e.prototype instanceof Generator ? e : Generator, a = Object.create(i.prototype); return c(a, "_invoke", function (r, e, n) { var o = 1; return function (i, a) { if (3 === o) throw Error("Generator is already running"); if (4 === o) { if ("throw" === i) throw a; return { value: t, done: !0 }; } for (n.method = i, n.arg = a;;) { var u = n.delegate; if (u) { var c = d(u, n); if (c) { if (c === f) continue; return c; } } if ("next" === n.method) n.sent = n._sent = n.arg;else if ("throw" === n.method) { if (1 === o) throw o = 4, n.arg; n.dispatchException(n.arg); } else "return" === n.method && n.abrupt("return", n.arg); o = 3; var h = s(r, e, n); if ("normal" === h.type) { if (o = n.done ? 4 : 2, h.arg === f) continue; return { value: h.arg, done: n.done }; } "throw" === h.type && (o = 4, n.method = "throw", n.arg = h.arg); } }; }(r, n, new Context(o || [])), !0), a; } function s(t, r, e) { try { return { type: "normal", arg: t.call(r, e) }; } catch (t) { return { type: "throw", arg: t }; } } r.wrap = h; var f = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var l = {}; c(l, i, function () { return this; }); var p = Object.getPrototypeOf, y = p && p(p(x([]))); y && y !== e && n.call(y, i) && (l = y); var v = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(l); function g(t) { ["next", "throw", "return"].forEach(function (r) { c(t, r, function (t) { return this._invoke(r, t); }); }); } function AsyncIterator(t, r) { function e(o, i, a, u) { var c = s(t[o], t, i); if ("throw" !== c.type) { var h = c.arg, f = h.value; return f && "object" == _typeof(f) && n.call(f, "__await") ? r.resolve(f.__await).then(function (t) { e("next", t, a, u); }, function (t) { e("throw", t, a, u); }) : r.resolve(f).then(function (t) { h.value = t, a(h); }, function (t) { return e("throw", t, a, u); }); } u(c.arg); } var o; c(this, "_invoke", function (t, n) { function i() { return new r(function (r, o) { e(t, n, r, o); }); } return o = o ? o.then(i, i) : i(); }, !0); } function d(r, e) { var n = e.method, o = r.i[n]; if (o === t) return e.delegate = null, "throw" === n && r.i["return"] && (e.method = "return", e.arg = t, d(r, e), "throw" === e.method) || "return" !== n && (e.method = "throw", e.arg = new TypeError("The iterator does not provide a '" + n + "' method")), f; var i = s(o, r.i, e.arg); if ("throw" === i.type) return e.method = "throw", e.arg = i.arg, e.delegate = null, f; var a = i.arg; return a ? a.done ? (e[r.r] = a.value, e.next = r.n, "return" !== e.method && (e.method = "next", e.arg = t), e.delegate = null, f) : a : (e.method = "throw", e.arg = new TypeError("iterator result is not an object"), e.delegate = null, f); } function w(t) { this.tryEntries.push(t); } function m(r) { var e = r[4] || {}; e.type = "normal", e.arg = t, r[4] = e; } function Context(t) { this.tryEntries = [[-1]], t.forEach(w, this), this.reset(!0); } function x(r) { if (null != r) { var e = r[i]; if (e) return e.call(r); if ("function" == typeof r.next) return r; if (!isNaN(r.length)) { var o = -1, a = function e() { for (; ++o < r.length;) if (n.call(r, o)) return e.value = r[o], e.done = !1, e; return e.value = t, e.done = !0, e; }; return a.next = a; } } throw new TypeError(_typeof(r) + " is not iterable"); } return GeneratorFunction.prototype = GeneratorFunctionPrototype, c(v, "constructor", GeneratorFunctionPrototype), c(GeneratorFunctionPrototype, "constructor", GeneratorFunction), GeneratorFunction.displayName = c(GeneratorFunctionPrototype, u, "GeneratorFunction"), r.isGeneratorFunction = function (t) { var r = "function" == typeof t && t.constructor; return !!r && (r === GeneratorFunction || "GeneratorFunction" === (r.displayName || r.name)); }, r.mark = function (t) { return Object.setPrototypeOf ? Object.setPrototypeOf(t, GeneratorFunctionPrototype) : (t.__proto__ = GeneratorFunctionPrototype, c(t, u, "GeneratorFunction")), t.prototype = Object.create(v), t; }, r.awrap = function (t) { return { __await: t }; }, g(AsyncIterator.prototype), c(AsyncIterator.prototype, a, function () { return this; }), r.AsyncIterator = AsyncIterator, r.async = function (t, e, n, o, i) { void 0 === i && (i = Promise); var a = new AsyncIterator(h(t, e, n, o), i); return r.isGeneratorFunction(e) ? a : a.next().then(function (t) { return t.done ? t.value : a.next(); }); }, g(v), c(v, u, "Generator"), c(v, i, function () { return this; }), c(v, "toString", function () { return "[object Generator]"; }), r.keys = function (t) { var r = Object(t), e = []; for (var n in r) e.unshift(n); return function t() { for (; e.length;) if ((n = e.pop()) in r) return t.value = n, t.done = !1, t; return t.done = !0, t; }; }, r.values = x, Context.prototype = { constructor: Context, reset: function reset(r) { if (this.prev = this.next = 0, this.sent = this._sent = t, this.done = !1, this.delegate = null, this.method = "next", this.arg = t, this.tryEntries.forEach(m), !r) for (var e in this) "t" === e.charAt(0) && n.call(this, e) && !isNaN(+e.slice(1)) && (this[e] = t); }, stop: function stop() { this.done = !0; var t = this.tryEntries[0][4]; if ("throw" === t.type) throw t.arg; return this.rval; }, dispatchException: function dispatchException(r) { if (this.done) throw r; var e = this; function n(t) { a.type = "throw", a.arg = r, e.next = t; } for (var o = e.tryEntries.length - 1; o >= 0; --o) { var i = this.tryEntries[o], a = i[4], u = this.prev, c = i[1], h = i[2]; if (-1 === i[0]) return n("end"), !1; if (!c && !h) throw Error("try statement without catch or finally"); if (null != i[0] && i[0] <= u) { if (u < c) return this.method = "next", this.arg = t, n(c), !0; if (u < h) return n(h), !1; } } }, abrupt: function abrupt(t, r) { for (var e = this.tryEntries.length - 1; e >= 0; --e) { var n = this.tryEntries[e]; if (n[0] > -1 && n[0] <= this.prev && this.prev < n[2]) { var o = n; break; } } o && ("break" === t || "continue" === t) && o[0] <= r && r <= o[2] && (o = null); var i = o ? o[4] : {}; return i.type = t, i.arg = r, o ? (this.method = "next", this.next = o[2], f) : this.complete(i); }, complete: function complete(t, r) { if ("throw" === t.type) throw t.arg; return "break" === t.type || "continue" === t.type ? this.next = t.arg : "return" === t.type ? (this.rval = this.arg = t.arg, this.method = "return", this.next = "end") : "normal" === t.type && r && (this.next = r), f; }, finish: function finish(t) { for (var r = this.tryEntries.length - 1; r >= 0; --r) { var e = this.tryEntries[r]; if (e[2] === t) return this.complete(e[4], e[3]), m(e), f; } }, "catch": function _catch(t) { for (var r = this.tryEntries.length - 1; r >= 0; --r) { var e = this.tryEntries[r]; if (e[0] === t) { var n = e[4]; if ("throw" === n.type) { var o = n.arg; m(e); } return o; } } throw Error("illegal catch attempt"); }, delegateYield: function delegateYield(r, e, n) { return this.delegate = { i: x(r), r: e, n: n }, "next" === this.method && (this.arg = t), f; } }, r; }
function asyncGeneratorStep(n, t, e, r, o, a, c) { try { var i = n[a](c), u = i.value; } catch (n) { return void e(n); } i.done ? t(u) : Promise.resolve(u).then(r, o); }
function _asyncToGenerator(n) { return function () { var t = this, e = arguments; return new Promise(function (r, o) { var a = n.apply(t, e); function _next(n) { asyncGeneratorStep(a, r, o, _next, _throw, "next", n); } function _throw(n) { asyncGeneratorStep(a, r, o, _next, _throw, "throw", n); } _next(void 0); }); }; }


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: 'Services',
  data: function data() {
    return {
      services: {
        subscriptions: [],
        hosting_accounts: [],
        domain_registrations: []
      },
      loading: false
    };
  },
  computed: {
    hasAnyServices: function hasAnyServices() {
      var _this$services$subscr, _this$services$hostin, _this$services$domain;
      return ((_this$services$subscr = this.services.subscriptions) === null || _this$services$subscr === void 0 ? void 0 : _this$services$subscr.length) > 0 || ((_this$services$hostin = this.services.hosting_accounts) === null || _this$services$hostin === void 0 ? void 0 : _this$services$hostin.length) > 0 || ((_this$services$domain = this.services.domain_registrations) === null || _this$services$domain === void 0 ? void 0 : _this$services$domain.length) > 0;
    }
  },
  mounted: function mounted() {
    this.loadServices();
  },
  methods: {
    formatMoney: _utils_helpers_js__WEBPACK_IMPORTED_MODULE_0__.formatMoney,
    formatDate: _utils_helpers_js__WEBPACK_IMPORTED_MODULE_0__.formatDate,
    formatTime: _utils_helpers_js__WEBPACK_IMPORTED_MODULE_0__.formatTime,
    loadServices: function loadServices() {
      var _this = this;
      return _asyncToGenerator(/*#__PURE__*/_regeneratorRuntime().mark(function _callee() {
        var response, _error$response, _error$response2, _error$response3, _this$$toasted, _this$$toasted2, _this$$toasted3;
        return _regeneratorRuntime().wrap(function _callee$(_context) {
          while (1) switch (_context.prev = _context.next) {
            case 0:
              _context.prev = 0;
              _this.loading = true;
              _context.next = 4;
              return _utils_helpers_js__WEBPACK_IMPORTED_MODULE_0__.CustomerPortalAPI.getServices();
            case 4:
              response = _context.sent;
              _this.services = response.data || {
                subscriptions: [],
                hosting_accounts: [],
                domain_registrations: []
              };
              _context.next = 14;
              break;
            case 8:
              _context.prev = 8;
              _context.t0 = _context["catch"](0);
              console.error('Error loading services:', _context.t0);
              console.error('Error details:', ((_error$response = _context.t0.response) === null || _error$response === void 0 ? void 0 : _error$response.data) || _context.t0.message);

              // Show user-friendly error message
              if (((_error$response2 = _context.t0.response) === null || _error$response2 === void 0 ? void 0 : _error$response2.status) === 401) {
                (_this$$toasted = _this.$toasted) === null || _this$$toasted === void 0 || _this$$toasted.error('Authentication required. Please log in again.');
              } else if (((_error$response3 = _context.t0.response) === null || _error$response3 === void 0 ? void 0 : _error$response3.status) === 403) {
                (_this$$toasted2 = _this.$toasted) === null || _this$$toasted2 === void 0 || _this$$toasted2.error('Access denied. You do not have permission to view services.');
              } else {
                (_this$$toasted3 = _this.$toasted) === null || _this$$toasted3 === void 0 || _this$$toasted3.error('Failed to load services. Please try again.');
              }

              // Reset data on error
              _this.services = {
                subscriptions: [],
                hosting_accounts: [],
                domain_registrations: []
              };
            case 14:
              _context.prev = 14;
              _this.loading = false;
              return _context.finish(14);
            case 17:
            case "end":
              return _context.stop();
          }
        }, _callee, null, [[0, 8, 14, 17]]);
      }))();
    },
    getSubscriptionBadgeType: function getSubscriptionBadgeType(status) {
      var badgeTypes = {
        'active': 'success',
        'pending': 'warning',
        'suspended': 'danger',
        'cancelled': 'danger',
        'expired': 'danger'
      };
      return badgeTypes[status] || 'info';
    },
    getHostingBadgeType: function getHostingBadgeType(status) {
      var badgeTypes = {
        'active': 'success',
        'pending': 'warning',
        'suspended': 'danger',
        'terminated': 'danger'
      };
      return badgeTypes[status] || 'info';
    },
    getDomainBadgeType: function getDomainBadgeType(status) {
      var badgeTypes = {
        'active': 'success',
        'pending': 'warning',
        'expired': 'danger',
        'cancelled': 'danger',
        'transferred': 'info'
      };
      return badgeTypes[status] || 'info';
    },
    formatStatus: function formatStatus(status) {
      if (!status) return 'Unknown';
      return status.charAt(0).toUpperCase() + status.slice(1).replace('_', ' ');
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Support.vue?vue&type=script&lang=js":
/*!*************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Support.vue?vue&type=script&lang=js ***!
  \*************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _utils_helpers_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../utils/helpers.js */ "./resources/js/utils/helpers.js");
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/babel/babel/blob/main/packages/babel-helpers/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return r; }; var t, r = {}, e = Object.prototype, n = e.hasOwnProperty, o = "function" == typeof Symbol ? Symbol : {}, i = o.iterator || "@@iterator", a = o.asyncIterator || "@@asyncIterator", u = o.toStringTag || "@@toStringTag"; function c(t, r, e, n) { return Object.defineProperty(t, r, { value: e, enumerable: !n, configurable: !n, writable: !n }); } try { c({}, ""); } catch (t) { c = function c(t, r, e) { return t[r] = e; }; } function h(r, e, n, o) { var i = e && e.prototype instanceof Generator ? e : Generator, a = Object.create(i.prototype); return c(a, "_invoke", function (r, e, n) { var o = 1; return function (i, a) { if (3 === o) throw Error("Generator is already running"); if (4 === o) { if ("throw" === i) throw a; return { value: t, done: !0 }; } for (n.method = i, n.arg = a;;) { var u = n.delegate; if (u) { var c = d(u, n); if (c) { if (c === f) continue; return c; } } if ("next" === n.method) n.sent = n._sent = n.arg;else if ("throw" === n.method) { if (1 === o) throw o = 4, n.arg; n.dispatchException(n.arg); } else "return" === n.method && n.abrupt("return", n.arg); o = 3; var h = s(r, e, n); if ("normal" === h.type) { if (o = n.done ? 4 : 2, h.arg === f) continue; return { value: h.arg, done: n.done }; } "throw" === h.type && (o = 4, n.method = "throw", n.arg = h.arg); } }; }(r, n, new Context(o || [])), !0), a; } function s(t, r, e) { try { return { type: "normal", arg: t.call(r, e) }; } catch (t) { return { type: "throw", arg: t }; } } r.wrap = h; var f = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var l = {}; c(l, i, function () { return this; }); var p = Object.getPrototypeOf, y = p && p(p(x([]))); y && y !== e && n.call(y, i) && (l = y); var v = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(l); function g(t) { ["next", "throw", "return"].forEach(function (r) { c(t, r, function (t) { return this._invoke(r, t); }); }); } function AsyncIterator(t, r) { function e(o, i, a, u) { var c = s(t[o], t, i); if ("throw" !== c.type) { var h = c.arg, f = h.value; return f && "object" == _typeof(f) && n.call(f, "__await") ? r.resolve(f.__await).then(function (t) { e("next", t, a, u); }, function (t) { e("throw", t, a, u); }) : r.resolve(f).then(function (t) { h.value = t, a(h); }, function (t) { return e("throw", t, a, u); }); } u(c.arg); } var o; c(this, "_invoke", function (t, n) { function i() { return new r(function (r, o) { e(t, n, r, o); }); } return o = o ? o.then(i, i) : i(); }, !0); } function d(r, e) { var n = e.method, o = r.i[n]; if (o === t) return e.delegate = null, "throw" === n && r.i["return"] && (e.method = "return", e.arg = t, d(r, e), "throw" === e.method) || "return" !== n && (e.method = "throw", e.arg = new TypeError("The iterator does not provide a '" + n + "' method")), f; var i = s(o, r.i, e.arg); if ("throw" === i.type) return e.method = "throw", e.arg = i.arg, e.delegate = null, f; var a = i.arg; return a ? a.done ? (e[r.r] = a.value, e.next = r.n, "return" !== e.method && (e.method = "next", e.arg = t), e.delegate = null, f) : a : (e.method = "throw", e.arg = new TypeError("iterator result is not an object"), e.delegate = null, f); } function w(t) { this.tryEntries.push(t); } function m(r) { var e = r[4] || {}; e.type = "normal", e.arg = t, r[4] = e; } function Context(t) { this.tryEntries = [[-1]], t.forEach(w, this), this.reset(!0); } function x(r) { if (null != r) { var e = r[i]; if (e) return e.call(r); if ("function" == typeof r.next) return r; if (!isNaN(r.length)) { var o = -1, a = function e() { for (; ++o < r.length;) if (n.call(r, o)) return e.value = r[o], e.done = !1, e; return e.value = t, e.done = !0, e; }; return a.next = a; } } throw new TypeError(_typeof(r) + " is not iterable"); } return GeneratorFunction.prototype = GeneratorFunctionPrototype, c(v, "constructor", GeneratorFunctionPrototype), c(GeneratorFunctionPrototype, "constructor", GeneratorFunction), GeneratorFunction.displayName = c(GeneratorFunctionPrototype, u, "GeneratorFunction"), r.isGeneratorFunction = function (t) { var r = "function" == typeof t && t.constructor; return !!r && (r === GeneratorFunction || "GeneratorFunction" === (r.displayName || r.name)); }, r.mark = function (t) { return Object.setPrototypeOf ? Object.setPrototypeOf(t, GeneratorFunctionPrototype) : (t.__proto__ = GeneratorFunctionPrototype, c(t, u, "GeneratorFunction")), t.prototype = Object.create(v), t; }, r.awrap = function (t) { return { __await: t }; }, g(AsyncIterator.prototype), c(AsyncIterator.prototype, a, function () { return this; }), r.AsyncIterator = AsyncIterator, r.async = function (t, e, n, o, i) { void 0 === i && (i = Promise); var a = new AsyncIterator(h(t, e, n, o), i); return r.isGeneratorFunction(e) ? a : a.next().then(function (t) { return t.done ? t.value : a.next(); }); }, g(v), c(v, u, "Generator"), c(v, i, function () { return this; }), c(v, "toString", function () { return "[object Generator]"; }), r.keys = function (t) { var r = Object(t), e = []; for (var n in r) e.unshift(n); return function t() { for (; e.length;) if ((n = e.pop()) in r) return t.value = n, t.done = !1, t; return t.done = !0, t; }; }, r.values = x, Context.prototype = { constructor: Context, reset: function reset(r) { if (this.prev = this.next = 0, this.sent = this._sent = t, this.done = !1, this.delegate = null, this.method = "next", this.arg = t, this.tryEntries.forEach(m), !r) for (var e in this) "t" === e.charAt(0) && n.call(this, e) && !isNaN(+e.slice(1)) && (this[e] = t); }, stop: function stop() { this.done = !0; var t = this.tryEntries[0][4]; if ("throw" === t.type) throw t.arg; return this.rval; }, dispatchException: function dispatchException(r) { if (this.done) throw r; var e = this; function n(t) { a.type = "throw", a.arg = r, e.next = t; } for (var o = e.tryEntries.length - 1; o >= 0; --o) { var i = this.tryEntries[o], a = i[4], u = this.prev, c = i[1], h = i[2]; if (-1 === i[0]) return n("end"), !1; if (!c && !h) throw Error("try statement without catch or finally"); if (null != i[0] && i[0] <= u) { if (u < c) return this.method = "next", this.arg = t, n(c), !0; if (u < h) return n(h), !1; } } }, abrupt: function abrupt(t, r) { for (var e = this.tryEntries.length - 1; e >= 0; --e) { var n = this.tryEntries[e]; if (n[0] > -1 && n[0] <= this.prev && this.prev < n[2]) { var o = n; break; } } o && ("break" === t || "continue" === t) && o[0] <= r && r <= o[2] && (o = null); var i = o ? o[4] : {}; return i.type = t, i.arg = r, o ? (this.method = "next", this.next = o[2], f) : this.complete(i); }, complete: function complete(t, r) { if ("throw" === t.type) throw t.arg; return "break" === t.type || "continue" === t.type ? this.next = t.arg : "return" === t.type ? (this.rval = this.arg = t.arg, this.method = "return", this.next = "end") : "normal" === t.type && r && (this.next = r), f; }, finish: function finish(t) { for (var r = this.tryEntries.length - 1; r >= 0; --r) { var e = this.tryEntries[r]; if (e[2] === t) return this.complete(e[4], e[3]), m(e), f; } }, "catch": function _catch(t) { for (var r = this.tryEntries.length - 1; r >= 0; --r) { var e = this.tryEntries[r]; if (e[0] === t) { var n = e[4]; if ("throw" === n.type) { var o = n.arg; m(e); } return o; } } throw Error("illegal catch attempt"); }, delegateYield: function delegateYield(r, e, n) { return this.delegate = { i: x(r), r: e, n: n }, "next" === this.method && (this.arg = t), f; } }, r; }
function asyncGeneratorStep(n, t, e, r, o, a, c) { try { var i = n[a](c), u = i.value; } catch (n) { return void e(n); } i.done ? t(u) : Promise.resolve(u).then(r, o); }
function _asyncToGenerator(n) { return function () { var t = this, e = arguments; return new Promise(function (r, o) { var a = n.apply(t, e); function _next(n) { asyncGeneratorStep(a, r, o, _next, _throw, "next", n); } function _throw(n) { asyncGeneratorStep(a, r, o, _next, _throw, "throw", n); } _next(void 0); }); }; }

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: 'Support',
  data: function data() {
    return {
      tickets: [],
      loading: false
    };
  },
  mounted: function mounted() {
    this.loadTickets();
  },
  methods: {
    loadTickets: function loadTickets() {
      var _this = this;
      return _asyncToGenerator(/*#__PURE__*/_regeneratorRuntime().mark(function _callee() {
        var data;
        return _regeneratorRuntime().wrap(function _callee$(_context) {
          while (1) switch (_context.prev = _context.next) {
            case 0:
              _context.prev = 0;
              _this.loading = true;
              _context.next = 4;
              return _utils_helpers_js__WEBPACK_IMPORTED_MODULE_0__.CustomerPortalAPI.getTickets();
            case 4:
              data = _context.sent;
              _this.tickets = data.tickets;
              _context.next = 12;
              break;
            case 8:
              _context.prev = 8;
              _context.t0 = _context["catch"](0);
              console.error('Error loading tickets:', _context.t0);
              _this.$toasted.error('Failed to load tickets');
            case 12:
              _context.prev = 12;
              _this.loading = false;
              return _context.finish(12);
            case 15:
            case "end":
              return _context.stop();
          }
        }, _callee, null, [[0, 8, 12, 15]]);
      }))();
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
/* harmony import */ var _components_Dashboard_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../components/Dashboard.vue */ "./resources/js/components/Dashboard.vue");
/* harmony import */ var _components_Invoices_vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../components/Invoices.vue */ "./resources/js/components/Invoices.vue");
/* harmony import */ var _components_Services_vue__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../components/Services.vue */ "./resources/js/components/Services.vue");
/* harmony import */ var _components_Support_vue__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../components/Support.vue */ "./resources/js/components/Support.vue");
/* harmony import */ var _components_Profile_vue__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../components/Profile.vue */ "./resources/js/components/Profile.vue");
/* harmony import */ var _utils_helpers_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../utils/helpers.js */ "./resources/js/utils/helpers.js");
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/babel/babel/blob/main/packages/babel-helpers/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return r; }; var t, r = {}, e = Object.prototype, n = e.hasOwnProperty, o = "function" == typeof Symbol ? Symbol : {}, i = o.iterator || "@@iterator", a = o.asyncIterator || "@@asyncIterator", u = o.toStringTag || "@@toStringTag"; function c(t, r, e, n) { return Object.defineProperty(t, r, { value: e, enumerable: !n, configurable: !n, writable: !n }); } try { c({}, ""); } catch (t) { c = function c(t, r, e) { return t[r] = e; }; } function h(r, e, n, o) { var i = e && e.prototype instanceof Generator ? e : Generator, a = Object.create(i.prototype); return c(a, "_invoke", function (r, e, n) { var o = 1; return function (i, a) { if (3 === o) throw Error("Generator is already running"); if (4 === o) { if ("throw" === i) throw a; return { value: t, done: !0 }; } for (n.method = i, n.arg = a;;) { var u = n.delegate; if (u) { var c = d(u, n); if (c) { if (c === f) continue; return c; } } if ("next" === n.method) n.sent = n._sent = n.arg;else if ("throw" === n.method) { if (1 === o) throw o = 4, n.arg; n.dispatchException(n.arg); } else "return" === n.method && n.abrupt("return", n.arg); o = 3; var h = s(r, e, n); if ("normal" === h.type) { if (o = n.done ? 4 : 2, h.arg === f) continue; return { value: h.arg, done: n.done }; } "throw" === h.type && (o = 4, n.method = "throw", n.arg = h.arg); } }; }(r, n, new Context(o || [])), !0), a; } function s(t, r, e) { try { return { type: "normal", arg: t.call(r, e) }; } catch (t) { return { type: "throw", arg: t }; } } r.wrap = h; var f = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var l = {}; c(l, i, function () { return this; }); var p = Object.getPrototypeOf, y = p && p(p(x([]))); y && y !== e && n.call(y, i) && (l = y); var v = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(l); function g(t) { ["next", "throw", "return"].forEach(function (r) { c(t, r, function (t) { return this._invoke(r, t); }); }); } function AsyncIterator(t, r) { function e(o, i, a, u) { var c = s(t[o], t, i); if ("throw" !== c.type) { var h = c.arg, f = h.value; return f && "object" == _typeof(f) && n.call(f, "__await") ? r.resolve(f.__await).then(function (t) { e("next", t, a, u); }, function (t) { e("throw", t, a, u); }) : r.resolve(f).then(function (t) { h.value = t, a(h); }, function (t) { return e("throw", t, a, u); }); } u(c.arg); } var o; c(this, "_invoke", function (t, n) { function i() { return new r(function (r, o) { e(t, n, r, o); }); } return o = o ? o.then(i, i) : i(); }, !0); } function d(r, e) { var n = e.method, o = r.i[n]; if (o === t) return e.delegate = null, "throw" === n && r.i["return"] && (e.method = "return", e.arg = t, d(r, e), "throw" === e.method) || "return" !== n && (e.method = "throw", e.arg = new TypeError("The iterator does not provide a '" + n + "' method")), f; var i = s(o, r.i, e.arg); if ("throw" === i.type) return e.method = "throw", e.arg = i.arg, e.delegate = null, f; var a = i.arg; return a ? a.done ? (e[r.r] = a.value, e.next = r.n, "return" !== e.method && (e.method = "next", e.arg = t), e.delegate = null, f) : a : (e.method = "throw", e.arg = new TypeError("iterator result is not an object"), e.delegate = null, f); } function w(t) { this.tryEntries.push(t); } function m(r) { var e = r[4] || {}; e.type = "normal", e.arg = t, r[4] = e; } function Context(t) { this.tryEntries = [[-1]], t.forEach(w, this), this.reset(!0); } function x(r) { if (null != r) { var e = r[i]; if (e) return e.call(r); if ("function" == typeof r.next) return r; if (!isNaN(r.length)) { var o = -1, a = function e() { for (; ++o < r.length;) if (n.call(r, o)) return e.value = r[o], e.done = !1, e; return e.value = t, e.done = !0, e; }; return a.next = a; } } throw new TypeError(_typeof(r) + " is not iterable"); } return GeneratorFunction.prototype = GeneratorFunctionPrototype, c(v, "constructor", GeneratorFunctionPrototype), c(GeneratorFunctionPrototype, "constructor", GeneratorFunction), GeneratorFunction.displayName = c(GeneratorFunctionPrototype, u, "GeneratorFunction"), r.isGeneratorFunction = function (t) { var r = "function" == typeof t && t.constructor; return !!r && (r === GeneratorFunction || "GeneratorFunction" === (r.displayName || r.name)); }, r.mark = function (t) { return Object.setPrototypeOf ? Object.setPrototypeOf(t, GeneratorFunctionPrototype) : (t.__proto__ = GeneratorFunctionPrototype, c(t, u, "GeneratorFunction")), t.prototype = Object.create(v), t; }, r.awrap = function (t) { return { __await: t }; }, g(AsyncIterator.prototype), c(AsyncIterator.prototype, a, function () { return this; }), r.AsyncIterator = AsyncIterator, r.async = function (t, e, n, o, i) { void 0 === i && (i = Promise); var a = new AsyncIterator(h(t, e, n, o), i); return r.isGeneratorFunction(e) ? a : a.next().then(function (t) { return t.done ? t.value : a.next(); }); }, g(v), c(v, u, "Generator"), c(v, i, function () { return this; }), c(v, "toString", function () { return "[object Generator]"; }), r.keys = function (t) { var r = Object(t), e = []; for (var n in r) e.unshift(n); return function t() { for (; e.length;) if ((n = e.pop()) in r) return t.value = n, t.done = !1, t; return t.done = !0, t; }; }, r.values = x, Context.prototype = { constructor: Context, reset: function reset(r) { if (this.prev = this.next = 0, this.sent = this._sent = t, this.done = !1, this.delegate = null, this.method = "next", this.arg = t, this.tryEntries.forEach(m), !r) for (var e in this) "t" === e.charAt(0) && n.call(this, e) && !isNaN(+e.slice(1)) && (this[e] = t); }, stop: function stop() { this.done = !0; var t = this.tryEntries[0][4]; if ("throw" === t.type) throw t.arg; return this.rval; }, dispatchException: function dispatchException(r) { if (this.done) throw r; var e = this; function n(t) { a.type = "throw", a.arg = r, e.next = t; } for (var o = e.tryEntries.length - 1; o >= 0; --o) { var i = this.tryEntries[o], a = i[4], u = this.prev, c = i[1], h = i[2]; if (-1 === i[0]) return n("end"), !1; if (!c && !h) throw Error("try statement without catch or finally"); if (null != i[0] && i[0] <= u) { if (u < c) return this.method = "next", this.arg = t, n(c), !0; if (u < h) return n(h), !1; } } }, abrupt: function abrupt(t, r) { for (var e = this.tryEntries.length - 1; e >= 0; --e) { var n = this.tryEntries[e]; if (n[0] > -1 && n[0] <= this.prev && this.prev < n[2]) { var o = n; break; } } o && ("break" === t || "continue" === t) && o[0] <= r && r <= o[2] && (o = null); var i = o ? o[4] : {}; return i.type = t, i.arg = r, o ? (this.method = "next", this.next = o[2], f) : this.complete(i); }, complete: function complete(t, r) { if ("throw" === t.type) throw t.arg; return "break" === t.type || "continue" === t.type ? this.next = t.arg : "return" === t.type ? (this.rval = this.arg = t.arg, this.method = "return", this.next = "end") : "normal" === t.type && r && (this.next = r), f; }, finish: function finish(t) { for (var r = this.tryEntries.length - 1; r >= 0; --r) { var e = this.tryEntries[r]; if (e[2] === t) return this.complete(e[4], e[3]), m(e), f; } }, "catch": function _catch(t) { for (var r = this.tryEntries.length - 1; r >= 0; --r) { var e = this.tryEntries[r]; if (e[0] === t) { var n = e[4]; if ("throw" === n.type) { var o = n.arg; m(e); } return o; } } throw Error("illegal catch attempt"); }, delegateYield: function delegateYield(r, e, n) { return this.delegate = { i: x(r), r: e, n: n }, "next" === this.method && (this.arg = t), f; } }, r; }
function asyncGeneratorStep(n, t, e, r, o, a, c) { try { var i = n[a](c), u = i.value; } catch (n) { return void e(n); } i.done ? t(u) : Promise.resolve(u).then(r, o); }
function _asyncToGenerator(n) { return function () { var t = this, e = arguments; return new Promise(function (r, o) { var a = n.apply(t, e); function _next(n) { asyncGeneratorStep(a, r, o, _next, _throw, "next", n); } function _throw(n) { asyncGeneratorStep(a, r, o, _next, _throw, "throw", n); } _next(void 0); }); }; }
// Import components

// Orders component removed - now handled by Nova CustomerOrder resource





// Import utilities

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: 'CustomerPortalTool',
  components: {
    Dashboard: _components_Dashboard_vue__WEBPACK_IMPORTED_MODULE_0__["default"],
    // Orders removed - now handled by Nova CustomerOrder resource
    Invoices: _components_Invoices_vue__WEBPACK_IMPORTED_MODULE_1__["default"],
    Services: _components_Services_vue__WEBPACK_IMPORTED_MODULE_2__["default"],
    Support: _components_Support_vue__WEBPACK_IMPORTED_MODULE_3__["default"],
    Profile: _components_Profile_vue__WEBPACK_IMPORTED_MODULE_4__["default"]
  },
  data: function data() {
    return {
      loading: true,
      currentView: 'dashboard',
      dashboardData: {
        customer: null,
        stats: null,
        recent_orders: [],
        recent_invoices: [],
        open_tickets: 0
      }
    };
  },
  mounted: function mounted() {
    var _this = this;
    this.loadDashboardData();
    this.setupRouteWatcher();

    // Also listen for popstate events (browser back/forward)
    window.addEventListener('popstate', this.setupRouteWatcher);

    // Listen for Nova navigation events
    this.$nextTick(function () {
      // Check route again after component is fully mounted
      setTimeout(function () {
        _this.setupRouteWatcher();
      }, 100);
    });
  },
  beforeDestroy: function beforeDestroy() {
    window.removeEventListener('popstate', this.setupRouteWatcher);
  },
  methods: {
    loadDashboardData: function loadDashboardData() {
      var _this2 = this;
      return _asyncToGenerator(/*#__PURE__*/_regeneratorRuntime().mark(function _callee() {
        return _regeneratorRuntime().wrap(function _callee$(_context) {
          while (1) switch (_context.prev = _context.next) {
            case 0:
              _context.prev = 0;
              _this2.loading = true;
              _context.next = 4;
              return _utils_helpers_js__WEBPACK_IMPORTED_MODULE_5__.CustomerPortalAPI.getDashboardData();
            case 4:
              _this2.dashboardData = _context.sent;
              _context.next = 11;
              break;
            case 7:
              _context.prev = 7;
              _context.t0 = _context["catch"](0);
              console.error('Error loading dashboard data:', _context.t0);
              _this2.$toasted.error('Failed to load dashboard data');
            case 11:
              _context.prev = 11;
              _this2.loading = false;
              return _context.finish(11);
            case 14:
            case "end":
              return _context.stop();
          }
        }, _callee, null, [[0, 7, 11, 14]]);
      }))();
    },
    setupRouteWatcher: function setupRouteWatcher() {
      var _this$$route;
      // Watch for route changes to switch views
      var path = window.location.pathname || ((_this$$route = this.$route) === null || _this$$route === void 0 ? void 0 : _this$$route.path) || '';

      // Orders route removed - now handled by Nova CustomerOrder resource
      if (path.includes('/customer-portal/invoices')) {
        this.currentView = 'invoices';
      } else if (path.includes('/customer-portal/services')) {
        this.currentView = 'services';
      } else if (path.includes('/customer-portal/tickets')) {
        this.currentView = 'tickets';
      } else if (path.includes('/customer-portal/profile')) {
        this.currentView = 'profile';
      } else {
        this.currentView = 'dashboard';
      }
    }
  },
  watch: {
    '$route': function $route() {
      this.setupRouteWatcher();
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Dashboard.vue?vue&type=template&id=040e2ab9":
/*!*******************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Dashboard.vue?vue&type=template&id=040e2ab9 ***!
  \*******************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "vue");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);

var _hoisted_1 = {
  "class": "p-6"
};
var _hoisted_2 = {
  "class": "flex items-center justify-between"
};
var _hoisted_3 = {
  "class": "text-lg font-medium"
};
var _hoisted_4 = {
  "class": "text-sm text-80 mt-1"
};
var _hoisted_5 = {
  "class": "flex items-center space-x-6"
};
var _hoisted_6 = {
  "class": "text-right"
};
var _hoisted_7 = {
  "class": "mt-1"
};
var _hoisted_8 = {
  "class": "text-right"
};
var _hoisted_9 = {
  "class": "text-sm font-medium mt-1"
};
var _hoisted_10 = {
  "class": "grid grid-cols-1 md:grid-cols-3 gap-6 mb-6"
};
var _hoisted_11 = {
  "class": "p-6"
};
var _hoisted_12 = {
  "class": "flex items-center"
};
var _hoisted_13 = {
  "class": "ml-4"
};
var _hoisted_14 = {
  "class": "text-3xl font-bold"
};
var _hoisted_15 = {
  "class": "p-6"
};
var _hoisted_16 = {
  "class": "flex items-center"
};
var _hoisted_17 = {
  "class": "ml-4"
};
var _hoisted_18 = {
  "class": "text-3xl font-bold"
};
var _hoisted_19 = {
  "class": "p-6"
};
var _hoisted_20 = {
  "class": "flex items-center"
};
var _hoisted_21 = {
  "class": "ml-4"
};
var _hoisted_22 = {
  "class": "text-3xl font-bold"
};
var _hoisted_23 = {
  "class": "grid grid-cols-1 lg:grid-cols-2 gap-6"
};
var _hoisted_24 = {
  "class": "p-6"
};
var _hoisted_25 = {
  key: 0,
  "class": "space-y-3"
};
var _hoisted_26 = {
  "class": "flex items-center space-x-3"
};
var _hoisted_27 = {
  "class": "text-sm font-medium"
};
var _hoisted_28 = {
  "class": "text-xs text-80"
};
var _hoisted_29 = {
  "class": "text-right"
};
var _hoisted_30 = {
  "class": "text-sm font-semibold"
};
var _hoisted_31 = {
  "class": "mt-1"
};
var _hoisted_32 = {
  key: 1,
  "class": "text-center py-8"
};
var _hoisted_33 = {
  "class": "p-6"
};
var _hoisted_34 = {
  key: 0,
  "class": "space-y-3"
};
var _hoisted_35 = {
  "class": "flex items-center space-x-3"
};
var _hoisted_36 = {
  "class": "text-sm font-medium"
};
var _hoisted_37 = {
  "class": "text-xs text-80"
};
var _hoisted_38 = {
  "class": "text-right"
};
var _hoisted_39 = {
  "class": "text-sm font-semibold"
};
var _hoisted_40 = {
  "class": "mt-1"
};
var _hoisted_41 = {
  key: 1,
  "class": "text-center py-8"
};
function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_Heading = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Heading");
  var _component_Badge = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Badge");
  var _component_Card = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Card");
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Heading, {
    "class": "mb-6"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return _cache[0] || (_cache[0] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("Dashboard")]);
    }),
    _: 1 /* STABLE */,
    __: [0]
  }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Account Overview "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Card, {
    "class": "mb-6"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      var _$props$dashboardData, _$props$dashboardData2, _$props$dashboardData4;
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h3", _hoisted_3, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)((_$props$dashboardData = $props.dashboardData.customer) === null || _$props$dashboardData === void 0 ? void 0 : _$props$dashboardData.name), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", _hoisted_4, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(((_$props$dashboardData2 = $props.dashboardData.customer) === null || _$props$dashboardData2 === void 0 ? void 0 : _$props$dashboardData2.company) || 'Individual Customer'), 1 /* TEXT */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_5, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_6, [_cache[1] || (_cache[1] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", {
        "class": "text-xs text-80 uppercase tracking-wide"
      }, "Status", -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_7, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Badge, {
        type: $options.statusBadgeType
      }, {
        "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
          var _$props$dashboardData3;
          return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)((0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)((_$props$dashboardData3 = $props.dashboardData.customer) === null || _$props$dashboardData3 === void 0 ? void 0 : _$props$dashboardData3.status), 1 /* TEXT */)];
        }),
        _: 1 /* STABLE */
      }, 8 /* PROPS */, ["type"])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_8, [_cache[2] || (_cache[2] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", {
        "class": "text-xs text-80 uppercase tracking-wide"
      }, "Member Since", -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", _hoisted_9, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)((_$props$dashboardData4 = $props.dashboardData.customer) === null || _$props$dashboardData4 === void 0 ? void 0 : _$props$dashboardData4.member_since), 1 /* TEXT */)])])])])];
    }),
    _: 1 /* STABLE */
  }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Stats Grid "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_10, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Active Services Card "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Card, null, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      var _$props$dashboardData5;
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_11, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_12, [_cache[4] || (_cache[4] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
        "class": "flex-shrink-0"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
        "class": "w-12 h-12 bg-success-light rounded-lg flex items-center justify-center"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
        "class": "w-6 h-6 text-success",
        fill: "none",
        stroke: "currentColor",
        viewBox: "0 0 24 24"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
        "stroke-linecap": "round",
        "stroke-linejoin": "round",
        "stroke-width": "2",
        d: "M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
      })])])], -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_13, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", _hoisted_14, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(((_$props$dashboardData5 = $props.dashboardData.stats) === null || _$props$dashboardData5 === void 0 ? void 0 : _$props$dashboardData5.active_subscriptions) || 0), 1 /* TEXT */), _cache[3] || (_cache[3] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", {
        "class": "text-sm text-80"
      }, "Active Services", -1 /* HOISTED */))])])])];
    }),
    _: 1 /* STABLE */
  }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Total Orders Card "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Card, null, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      var _$props$dashboardData6;
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_15, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_16, [_cache[6] || (_cache[6] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
        "class": "flex-shrink-0"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
        "class": "w-12 h-12 bg-primary-light rounded-lg flex items-center justify-center"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
        "class": "w-6 h-6 text-primary",
        fill: "none",
        stroke: "currentColor",
        viewBox: "0 0 24 24"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
        "stroke-linecap": "round",
        "stroke-linejoin": "round",
        "stroke-width": "2",
        d: "M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"
      })])])], -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_17, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", _hoisted_18, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(((_$props$dashboardData6 = $props.dashboardData.stats) === null || _$props$dashboardData6 === void 0 ? void 0 : _$props$dashboardData6.total_orders) || 0), 1 /* TEXT */), _cache[5] || (_cache[5] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", {
        "class": "text-sm text-80"
      }, "Total Orders", -1 /* HOISTED */))])])])];
    }),
    _: 1 /* STABLE */
  }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Support Tickets Card "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Card, null, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_19, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_20, [_cache[8] || (_cache[8] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
        "class": "flex-shrink-0"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
        "class": "w-12 h-12 bg-warning-light rounded-lg flex items-center justify-center"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
        "class": "w-6 h-6 text-warning",
        fill: "none",
        stroke: "currentColor",
        viewBox: "0 0 24 24"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
        "stroke-linecap": "round",
        "stroke-linejoin": "round",
        "stroke-width": "2",
        d: "M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"
      })])])], -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_21, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", _hoisted_22, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($props.dashboardData.open_tickets || 0), 1 /* TEXT */), _cache[7] || (_cache[7] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", {
        "class": "text-sm text-80"
      }, "Open Tickets", -1 /* HOISTED */))])])])];
    }),
    _: 1 /* STABLE */
  })]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Recent Activity "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_23, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Recent Orders "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Card, null, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      var _$props$dashboardData7;
      return [_cache[11] || (_cache[11] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
        "class": "px-6 py-4 border-b border-20"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
        "class": "flex items-center justify-between"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h3", {
        "class": "text-lg font-medium"
      }, "Recent Orders"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
        "class": "text-sm text-80"
      }, "Last 3 orders")])], -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_24, [(_$props$dashboardData7 = $props.dashboardData.recent_orders) !== null && _$props$dashboardData7 !== void 0 && _$props$dashboardData7.length ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_25, [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($props.dashboardData.recent_orders.slice(0, 3), function (order) {
        return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", {
          key: order.id,
          "class": "flex items-center justify-between p-4 bg-20 rounded-lg hover:bg-30 transition-colors duration-150"
        }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_26, [_cache[9] || (_cache[9] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
          "class": "flex-shrink-0"
        }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
          "class": "w-10 h-10 bg-primary-light rounded-lg flex items-center justify-center"
        }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
          "class": "w-5 h-5 text-primary",
          fill: "none",
          stroke: "currentColor",
          viewBox: "0 0 24 24"
        }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
          "stroke-linecap": "round",
          "stroke-linejoin": "round",
          "stroke-width": "2",
          d: "M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"
        })])])], -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", _hoisted_27, " Order #" + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(order.order_number), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", _hoisted_28, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($options.formatDate(order.created_at)), 1 /* TEXT */)])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_29, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", _hoisted_30, " $" + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($options.formatMoney(order.total)), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_31, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Badge, {
          type: $options.getOrderBadgeType(order.status)
        }, {
          "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
            return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)((0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(order.status), 1 /* TEXT */)];
          }),
          _: 2 /* DYNAMIC */
        }, 1032 /* PROPS, DYNAMIC_SLOTS */, ["type"])])])]);
      }), 128 /* KEYED_FRAGMENT */))])) : ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_32, _cache[10] || (_cache[10] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
        "class": "w-12 h-12 bg-20 rounded-lg flex items-center justify-center mx-auto mb-3"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
        "class": "w-6 h-6 text-80",
        fill: "none",
        stroke: "currentColor",
        viewBox: "0 0 24 24"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
        "stroke-linecap": "round",
        "stroke-linejoin": "round",
        "stroke-width": "2",
        d: "M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"
      })])], -1 /* HOISTED */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", {
        "class": "text-sm text-80"
      }, "No recent orders", -1 /* HOISTED */)])))])];
    }),
    _: 1 /* STABLE */,
    __: [11]
  }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Recent Invoices "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Card, null, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      var _$props$dashboardData8;
      return [_cache[14] || (_cache[14] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
        "class": "px-6 py-4 border-b border-20"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
        "class": "flex items-center justify-between"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h3", {
        "class": "text-lg font-medium"
      }, "Recent Invoices"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
        "class": "text-sm text-80"
      }, "Last 3 invoices")])], -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_33, [(_$props$dashboardData8 = $props.dashboardData.recent_invoices) !== null && _$props$dashboardData8 !== void 0 && _$props$dashboardData8.length ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_34, [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($props.dashboardData.recent_invoices.slice(0, 3), function (invoice) {
        return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", {
          key: invoice.id,
          "class": "flex items-center justify-between p-4 bg-20 rounded-lg hover:bg-30 transition-colors duration-150"
        }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_35, [_cache[12] || (_cache[12] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
          "class": "flex-shrink-0"
        }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
          "class": "w-10 h-10 bg-success-light rounded-lg flex items-center justify-center"
        }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
          "class": "w-5 h-5 text-success",
          fill: "none",
          stroke: "currentColor",
          viewBox: "0 0 24 24"
        }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
          "stroke-linecap": "round",
          "stroke-linejoin": "round",
          "stroke-width": "2",
          d: "M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
        })])])], -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", _hoisted_36, " Invoice #" + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(invoice.invoice_number), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", _hoisted_37, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($options.formatDate(invoice.created_at)), 1 /* TEXT */)])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_38, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", _hoisted_39, " $" + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($options.formatMoney(invoice.total)), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_40, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Badge, {
          type: $options.getInvoiceBadgeType(invoice.status)
        }, {
          "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
            return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)((0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(invoice.status), 1 /* TEXT */)];
          }),
          _: 2 /* DYNAMIC */
        }, 1032 /* PROPS, DYNAMIC_SLOTS */, ["type"])])])]);
      }), 128 /* KEYED_FRAGMENT */))])) : ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_41, _cache[13] || (_cache[13] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
        "class": "w-12 h-12 bg-20 rounded-lg flex items-center justify-center mx-auto mb-3"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
        "class": "w-6 h-6 text-80",
        fill: "none",
        stroke: "currentColor",
        viewBox: "0 0 24 24"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
        "stroke-linecap": "round",
        "stroke-linejoin": "round",
        "stroke-width": "2",
        d: "M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
      })])], -1 /* HOISTED */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", {
        "class": "text-sm text-80"
      }, "No recent invoices", -1 /* HOISTED */)])))])];
    }),
    _: 1 /* STABLE */,
    __: [14]
  })])]);
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Invoices.vue?vue&type=template&id=39dd555e":
/*!******************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Invoices.vue?vue&type=template&id=39dd555e ***!
  \******************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "vue");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);
function _toConsumableArray(r) { return _arrayWithoutHoles(r) || _iterableToArray(r) || _unsupportedIterableToArray(r) || _nonIterableSpread(); }
function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }
function _unsupportedIterableToArray(r, a) { if (r) { if ("string" == typeof r) return _arrayLikeToArray(r, a); var t = {}.toString.call(r).slice(8, -1); return "Object" === t && r.constructor && (t = r.constructor.name), "Map" === t || "Set" === t ? Array.from(r) : "Arguments" === t || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(t) ? _arrayLikeToArray(r, a) : void 0; } }
function _iterableToArray(r) { if ("undefined" != typeof Symbol && null != r[Symbol.iterator] || null != r["@@iterator"]) return Array.from(r); }
function _arrayWithoutHoles(r) { if (Array.isArray(r)) return _arrayLikeToArray(r); }
function _arrayLikeToArray(r, a) { (null == a || a > r.length) && (a = r.length); for (var e = 0, n = Array(a); e < a; e++) n[e] = r[e]; return n; }

var _hoisted_1 = {
  "class": "flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 p-6"
};
var _hoisted_2 = {
  "class": "flex flex-col sm:flex-row gap-4"
};
var _hoisted_3 = {
  "class": "relative"
};
var _hoisted_4 = {
  "class": "text-sm text-80"
};
var _hoisted_5 = {
  "class": "flex justify-center items-center"
};
var _hoisted_6 = {
  "class": "flex flex-col items-center justify-center py-16 px-6"
};
var _hoisted_7 = {
  "class": "text-80 text-center mb-6 max-w-md"
};
var _hoisted_8 = {
  "class": "divide-y divide-20"
};
var _hoisted_9 = {
  "class": "grid grid-cols-6 gap-4 items-center"
};
var _hoisted_10 = {
  "class": "col-span-2"
};
var _hoisted_11 = {
  "class": "text-sm font-medium"
};
var _hoisted_12 = {
  "class": "text-sm text-80"
};
var _hoisted_13 = {
  "class": "text-sm text-80"
};
var _hoisted_14 = {
  "class": "text-right"
};
var _hoisted_15 = {
  "class": "text-sm font-medium"
};
var _hoisted_16 = {
  "class": "text-right"
};
var _hoisted_17 = {
  "class": "flex justify-end space-x-2"
};
var _hoisted_18 = {
  key: 0,
  "class": "px-6 py-4 border-t border-20"
};
var _hoisted_19 = {
  "class": "flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4"
};
var _hoisted_20 = {
  "class": "text-sm text-80"
};
var _hoisted_21 = {
  "class": "flex items-center space-x-2"
};
var _hoisted_22 = {
  "class": "px-3 py-1 text-sm text-80"
};
var _hoisted_23 = {
  key: 1,
  "class": "absolute inset-0 bg-white dark:bg-gray-800 bg-opacity-75 flex items-center justify-center"
};
var _hoisted_24 = {
  "class": "flex items-center"
};
var _hoisted_25 = {
  "class": "flex items-center justify-between px-6 py-4 border-b border-20"
};
var _hoisted_26 = {
  "class": "p-6"
};
var _hoisted_27 = {
  "class": "grid grid-cols-1 md:grid-cols-2 gap-6 mb-6"
};
var _hoisted_28 = {
  "class": "space-y-2"
};
var _hoisted_29 = {
  "class": "flex justify-between"
};
var _hoisted_30 = {
  "class": "text-sm font-medium"
};
var _hoisted_31 = {
  "class": "flex justify-between"
};
var _hoisted_32 = {
  "class": "text-sm"
};
var _hoisted_33 = {
  "class": "flex justify-between"
};
var _hoisted_34 = {
  "class": "text-sm"
};
var _hoisted_35 = {
  "class": "flex justify-between"
};
var _hoisted_36 = {
  "class": "flex justify-between"
};
var _hoisted_37 = {
  "class": "text-sm font-semibold"
};
var _hoisted_38 = {
  "class": "space-y-2"
};
var _hoisted_39 = {
  "class": "flex justify-between"
};
var _hoisted_40 = {
  "class": "text-sm font-medium"
};
var _hoisted_41 = {
  "class": "flex justify-between"
};
var _hoisted_42 = {
  "class": "text-sm font-medium"
};
var _hoisted_43 = {
  key: 0,
  "class": "flex justify-between"
};
var _hoisted_44 = {
  "class": "text-sm"
};
var _hoisted_45 = {
  "class": "mt-3 space-y-2"
};
var _hoisted_46 = {
  key: 0
};
var _hoisted_47 = {
  "class": "bg-20 rounded-lg p-4"
};
var _hoisted_48 = {
  "class": "space-y-3"
};
var _hoisted_49 = {
  "class": "flex justify-between items-start"
};
var _hoisted_50 = {
  "class": "flex-1"
};
var _hoisted_51 = {
  "class": "text-sm font-medium"
};
var _hoisted_52 = {
  "class": "flex items-center space-x-4 mt-2 text-xs text-80"
};
var _hoisted_53 = {
  "class": "text-right ml-4"
};
var _hoisted_54 = {
  "class": "text-sm font-semibold"
};
var _hoisted_55 = {
  key: 1,
  "class": "mt-6"
};
var _hoisted_56 = {
  "class": "bg-20 rounded-lg p-4"
};
var _hoisted_57 = {
  "class": "text-sm text-80"
};
var _hoisted_58 = {
  "class": "flex justify-end px-6 py-4 border-t border-20"
};
function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_Heading = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Heading");
  var _component_Card = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Card");
  var _component_Loader = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Loader");
  var _component_DefaultButton = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("DefaultButton");
  var _component_Badge = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Badge");
  var _component_Modal = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Modal");
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Heading, {
    "class": "mb-6"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return _cache[9] || (_cache[9] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("My Invoices")]);
    }),
    _: 1 /* STABLE */,
    __: [9]
  }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Action Bar "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Card, {
    "class": "mb-6"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Search Input "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_3, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
        "onUpdate:modelValue": _cache[0] || (_cache[0] = function ($event) {
          return $data.searchQuery = $event;
        }),
        type: "text",
        placeholder: "Search invoices...",
        "class": "form-control form-input form-input-bordered w-full sm:w-64",
        onInput: _cache[1] || (_cache[1] = function () {
          return $options.debouncedSearch && $options.debouncedSearch.apply($options, arguments);
        })
      }, null, 544 /* NEED_HYDRATION, NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.searchQuery]])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Status Filter "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("select", {
        "onUpdate:modelValue": _cache[2] || (_cache[2] = function ($event) {
          return $data.statusFilter = $event;
        }),
        onChange: _cache[3] || (_cache[3] = function ($event) {
          return $options.loadInvoices(1);
        }),
        "class": "form-control form-select form-select-bordered w-full sm:w-48"
      }, _cache[10] || (_cache[10] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
        value: ""
      }, "All Statuses", -1 /* HOISTED */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
        value: "draft"
      }, "Draft", -1 /* HOISTED */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
        value: "sent"
      }, "Sent", -1 /* HOISTED */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
        value: "paid"
      }, "Paid", -1 /* HOISTED */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
        value: "overdue"
      }, "Overdue", -1 /* HOISTED */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
        value: "cancelled"
      }, "Cancelled", -1 /* HOISTED */)]), 544 /* NEED_HYDRATION, NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelSelect, $data.statusFilter]])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_4, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.totalInvoices) + " " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.totalInvoices === 1 ? 'invoice' : 'invoices') + " total ", 1 /* TEXT */)])];
    }),
    _: 1 /* STABLE */
  }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Loading State "), $data.loading && $data.invoices.length === 0 ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(_component_Card, {
    key: 0,
    "class": "py-12"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_5, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Loader, {
        "class": "text-60"
      }), _cache[11] || (_cache[11] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
        "class": "ml-3 text-80"
      }, "Loading invoices...", -1 /* HOISTED */))])];
    }),
    _: 1 /* STABLE */
  })) : !$data.loading && $data.invoices.length === 0 ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, {
    key: 1
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Empty State "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Card, null, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_6, [_cache[13] || (_cache[13] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
        "class": "w-16 h-16 text-60 mb-4",
        fill: "none",
        stroke: "currentColor",
        viewBox: "0 0 24 24"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
        "stroke-linecap": "round",
        "stroke-linejoin": "round",
        "stroke-width": "2",
        d: "M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
      })], -1 /* HOISTED */)), _cache[14] || (_cache[14] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h3", {
        "class": "text-xl font-semibold mb-2"
      }, "No Invoices Found", -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", _hoisted_7, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.searchQuery || $data.statusFilter ? 'No invoices match your current filters.' : 'You don\'t have any invoices yet.'), 1 /* TEXT */), $data.searchQuery || $data.statusFilter ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(_component_DefaultButton, {
        key: 0,
        onClick: $options.clearFilters,
        type: "button"
      }, {
        "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
          return _cache[12] || (_cache[12] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Clear Filters ")]);
        }),
        _: 1 /* STABLE */,
        __: [12]
      }, 8 /* PROPS */, ["onClick"])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])];
    }),
    _: 1 /* STABLE */
  })], 2112 /* STABLE_FRAGMENT, DEV_ROOT_FRAGMENT */)) : ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, {
    key: 2
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Invoices Table "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Card, {
    "class": "overflow-hidden"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Table Header "), _cache[20] || (_cache[20] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
        "class": "bg-gray-50 dark:bg-gray-800 px-6 py-3 border-b border-20"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
        "class": "grid grid-cols-6 gap-4 text-sm font-medium text-80"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
        "class": "col-span-2"
      }, "Invoice Number"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, "Date"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, "Due Date"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, "Status"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
        "class": "text-right"
      }, "Total"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
        "class": "text-right"
      }, "Actions")])], -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Table Body "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_8, [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($data.invoices, function (invoice) {
        return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", {
          key: invoice.id,
          "class": "px-6 py-4 hover:bg-20 transition-colors duration-150"
        }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_9, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_10, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_11, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(invoice.invoice_number), 1 /* TEXT */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_12, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($options.formatDate(invoice.created_at)), 1 /* TEXT */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_13, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($options.formatDate(invoice.due_date)), 1 /* TEXT */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Badge, {
          type: $options.getInvoiceBadgeType(invoice.status)
        }, {
          "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
            return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)((0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($options.formatStatus(invoice.status)), 1 /* TEXT */)];
          }),
          _: 2 /* DYNAMIC */
        }, 1032 /* PROPS, DYNAMIC_SLOTS */, ["type"])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_14, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_15, " $" + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($options.formatMoney(invoice.total)), 1 /* TEXT */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_16, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_17, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_DefaultButton, {
          onClick: function onClick($event) {
            return $options.viewInvoiceDetails(invoice);
          },
          size: "sm",
          variant: "ghost"
        }, {
          "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
            return _toConsumableArray(_cache[15] || (_cache[15] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" View ")]));
          }),
          _: 2 /* DYNAMIC */,
          __: [15]
        }, 1032 /* PROPS, DYNAMIC_SLOTS */, ["onClick"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_DefaultButton, {
          onClick: function onClick($event) {
            return $options.downloadInvoice(invoice.id);
          },
          size: "sm",
          variant: "ghost"
        }, {
          "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
            return _toConsumableArray(_cache[16] || (_cache[16] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Download ")]));
          }),
          _: 2 /* DYNAMIC */,
          __: [16]
        }, 1032 /* PROPS, DYNAMIC_SLOTS */, ["onClick"])])])])]);
      }), 128 /* KEYED_FRAGMENT */))]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Pagination "), $data.pagination.last_page > 1 ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_18, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_19, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_20, " Showing " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(($data.pagination.current_page - 1) * $data.pagination.per_page + 1) + " to " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(Math.min($data.pagination.current_page * $data.pagination.per_page, $data.pagination.total)) + " of " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.pagination.total) + " results ", 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_21, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_DefaultButton, {
        onClick: _cache[4] || (_cache[4] = function ($event) {
          return $options.loadInvoices($data.pagination.current_page - 1);
        }),
        disabled: $data.pagination.current_page <= 1,
        size: "sm",
        variant: "ghost"
      }, {
        "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
          return _cache[17] || (_cache[17] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Previous ")]);
        }),
        _: 1 /* STABLE */,
        __: [17]
      }, 8 /* PROPS */, ["disabled"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", _hoisted_22, " Page " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.pagination.current_page) + " of " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.pagination.last_page), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_DefaultButton, {
        onClick: _cache[5] || (_cache[5] = function ($event) {
          return $options.loadInvoices($data.pagination.current_page + 1);
        }),
        disabled: $data.pagination.current_page >= $data.pagination.last_page,
        size: "sm",
        variant: "ghost"
      }, {
        "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
          return _cache[18] || (_cache[18] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Next ")]);
        }),
        _: 1 /* STABLE */,
        __: [18]
      }, 8 /* PROPS */, ["disabled"])])])])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Loading overlay for pagination "), $data.loading && $data.invoices.length > 0 ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_23, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_24, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Loader, {
        "class": "text-60"
      }), _cache[19] || (_cache[19] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
        "class": "ml-3 text-80"
      }, "Loading...", -1 /* HOISTED */))])])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)];
    }),
    _: 1 /* STABLE */,
    __: [20]
  })], 2112 /* STABLE_FRAGMENT, DEV_ROOT_FRAGMENT */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Invoice Details Modal "), $data.showInvoiceModal ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(_component_Modal, {
    key: 3,
    onModalClose: $options.closeInvoiceModal,
    show: $data.showInvoiceModal,
    "max-width": "4xl"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Card, {
        "class": "overflow-hidden"
      }, {
        "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
          var _$data$selectedInvoic2, _$data$selectedInvoic3, _$data$selectedInvoic4, _$data$selectedInvoic5, _$data$selectedInvoic7, _$data$selectedInvoic8, _$data$selectedInvoic9, _$data$selectedInvoic0, _$data$selectedInvoic1, _$data$selectedInvoic10, _$data$selectedInvoic11, _$data$selectedInvoic12;
          return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Modal Header "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_25, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Heading, {
            level: 3
          }, {
            "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
              var _$data$selectedInvoic;
              return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Invoice Details - #" + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)((_$data$selectedInvoic = $data.selectedInvoice) === null || _$data$selectedInvoic === void 0 ? void 0 : _$data$selectedInvoic.invoice_number), 1 /* TEXT */)];
            }),
            _: 1 /* STABLE */
          }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
            onClick: _cache[6] || (_cache[6] = function () {
              return $options.closeInvoiceModal && $options.closeInvoiceModal.apply($options, arguments);
            }),
            "class": "text-60 hover:text-80 transition-colors duration-200"
          }, _cache[21] || (_cache[21] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
            "class": "w-6 h-6",
            fill: "none",
            stroke: "currentColor",
            viewBox: "0 0 24 24"
          }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
            "stroke-linecap": "round",
            "stroke-linejoin": "round",
            "stroke-width": "2",
            d: "M6 18L18 6M6 6l12 12"
          })], -1 /* HOISTED */)]))]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Modal Content "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_26, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Invoice Summary "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_27, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [_cache[27] || (_cache[27] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h4", {
            "class": "text-sm font-medium mb-3"
          }, "Invoice Information", -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("dl", _hoisted_28, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_29, [_cache[22] || (_cache[22] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("dt", {
            "class": "text-sm text-80"
          }, "Invoice Number:", -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("dd", _hoisted_30, "#" + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)((_$data$selectedInvoic2 = $data.selectedInvoice) === null || _$data$selectedInvoic2 === void 0 ? void 0 : _$data$selectedInvoic2.invoice_number), 1 /* TEXT */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_31, [_cache[23] || (_cache[23] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("dt", {
            "class": "text-sm text-80"
          }, "Date:", -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("dd", _hoisted_32, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($options.formatDate((_$data$selectedInvoic3 = $data.selectedInvoice) === null || _$data$selectedInvoic3 === void 0 ? void 0 : _$data$selectedInvoic3.created_at)), 1 /* TEXT */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_33, [_cache[24] || (_cache[24] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("dt", {
            "class": "text-sm text-80"
          }, "Due Date:", -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("dd", _hoisted_34, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($options.formatDate((_$data$selectedInvoic4 = $data.selectedInvoice) === null || _$data$selectedInvoic4 === void 0 ? void 0 : _$data$selectedInvoic4.due_date)), 1 /* TEXT */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_35, [_cache[25] || (_cache[25] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("dt", {
            "class": "text-sm text-80"
          }, "Status:", -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("dd", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Badge, {
            type: $options.getInvoiceBadgeType((_$data$selectedInvoic5 = $data.selectedInvoice) === null || _$data$selectedInvoic5 === void 0 ? void 0 : _$data$selectedInvoic5.status)
          }, {
            "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
              var _$data$selectedInvoic6;
              return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)((0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($options.formatStatus((_$data$selectedInvoic6 = $data.selectedInvoice) === null || _$data$selectedInvoic6 === void 0 ? void 0 : _$data$selectedInvoic6.status)), 1 /* TEXT */)];
            }),
            _: 1 /* STABLE */
          }, 8 /* PROPS */, ["type"])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_36, [_cache[26] || (_cache[26] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("dt", {
            "class": "text-sm text-80"
          }, "Total:", -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("dd", _hoisted_37, "$" + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($options.formatMoney((_$data$selectedInvoic7 = $data.selectedInvoice) === null || _$data$selectedInvoic7 === void 0 ? void 0 : _$data$selectedInvoic7.total)), 1 /* TEXT */)])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [_cache[33] || (_cache[33] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h4", {
            "class": "text-sm font-medium mb-3"
          }, "Payment Information", -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("dl", _hoisted_38, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_39, [_cache[28] || (_cache[28] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("dt", {
            "class": "text-sm text-80"
          }, "Amount Paid:", -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("dd", _hoisted_40, "$" + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($options.formatMoney(((_$data$selectedInvoic8 = $data.selectedInvoice) === null || _$data$selectedInvoic8 === void 0 ? void 0 : _$data$selectedInvoic8.amount_paid) || 0)), 1 /* TEXT */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_41, [_cache[29] || (_cache[29] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("dt", {
            "class": "text-sm text-80"
          }, "Balance Due:", -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("dd", _hoisted_42, "$" + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($options.formatMoney((((_$data$selectedInvoic9 = $data.selectedInvoice) === null || _$data$selectedInvoic9 === void 0 ? void 0 : _$data$selectedInvoic9.total) || 0) - (((_$data$selectedInvoic0 = $data.selectedInvoice) === null || _$data$selectedInvoic0 === void 0 ? void 0 : _$data$selectedInvoic0.amount_paid) || 0))), 1 /* TEXT */)]), (_$data$selectedInvoic1 = $data.selectedInvoice) !== null && _$data$selectedInvoic1 !== void 0 && _$data$selectedInvoic1.last_payment_date ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_43, [_cache[30] || (_cache[30] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("dt", {
            "class": "text-sm text-80"
          }, "Last Payment:", -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("dd", _hoisted_44, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($options.formatDate($data.selectedInvoice.last_payment_date)), 1 /* TEXT */)])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_45, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_DefaultButton, {
            onClick: _cache[7] || (_cache[7] = function ($event) {
              return $options.downloadInvoice($data.selectedInvoice.id);
            }),
            size: "sm",
            "class": "w-full"
          }, {
            "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
              return _cache[31] || (_cache[31] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Download PDF ")]);
            }),
            _: 1 /* STABLE */,
            __: [31]
          }), ((_$data$selectedInvoic10 = $data.selectedInvoice) === null || _$data$selectedInvoic10 === void 0 ? void 0 : _$data$selectedInvoic10.status) !== 'paid' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(_component_DefaultButton, {
            key: 0,
            onClick: _cache[8] || (_cache[8] = function ($event) {
              return $options.payInvoice($data.selectedInvoice.id);
            }),
            size: "sm",
            variant: "primary",
            "class": "w-full"
          }, {
            "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
              return _cache[32] || (_cache[32] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Pay Now ")]);
            }),
            _: 1 /* STABLE */,
            __: [32]
          })) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Invoice Items "), (_$data$selectedInvoic11 = $data.selectedInvoice) !== null && _$data$selectedInvoic11 !== void 0 && (_$data$selectedInvoic11 = _$data$selectedInvoic11.items) !== null && _$data$selectedInvoic11 !== void 0 && _$data$selectedInvoic11.length ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_46, [_cache[34] || (_cache[34] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h4", {
            "class": "text-sm font-medium mb-3"
          }, "Invoice Items", -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_47, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_48, [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($data.selectedInvoice.items, function (item) {
            return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", {
              key: item.id,
              "class": "bg-white dark:bg-gray-800 rounded-lg p-4 border-20"
            }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_49, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_50, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h5", _hoisted_51, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(item.description), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_52, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, "Qty: " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(item.quantity), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, "Rate: $" + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($options.formatMoney(item.unit_price)), 1 /* TEXT */)])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_53, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_54, " $" + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($options.formatMoney(item.total)), 1 /* TEXT */)])])]);
          }), 128 /* KEYED_FRAGMENT */))])])])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Invoice Notes "), (_$data$selectedInvoic12 = $data.selectedInvoice) !== null && _$data$selectedInvoic12 !== void 0 && _$data$selectedInvoic12.notes ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_55, [_cache[35] || (_cache[35] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h4", {
            "class": "text-sm font-medium mb-3"
          }, "Notes", -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_56, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", _hoisted_57, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.selectedInvoice.notes), 1 /* TEXT */)])])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Modal Footer "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_58, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_DefaultButton, {
            onClick: $options.closeInvoiceModal,
            variant: "ghost"
          }, {
            "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
              return _cache[36] || (_cache[36] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Close ")]);
            }),
            _: 1 /* STABLE */,
            __: [36]
          }, 8 /* PROPS */, ["onClick"])])];
        }),
        _: 1 /* STABLE */
      })];
    }),
    _: 1 /* STABLE */
  }, 8 /* PROPS */, ["onModalClose", "show"])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)]);
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Profile.vue?vue&type=template&id=3bd692e4":
/*!*****************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Profile.vue?vue&type=template&id=3bd692e4 ***!
  \*****************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "vue");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);

function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_Heading = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Heading");
  var _component_Card = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Card");
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Heading, {
    "class": "mb-6"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return _cache[0] || (_cache[0] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("My Profile")]);
    }),
    _: 1 /* STABLE */,
    __: [0]
  }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Card, null, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return _cache[1] || (_cache[1] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
        "class": "p-6"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
        "class": "text-center py-12"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
        "class": "w-16 h-16 text-gray-300 mx-auto mb-4",
        fill: "none",
        stroke: "currentColor",
        viewBox: "0 0 24 24"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
        "stroke-linecap": "round",
        "stroke-linejoin": "round",
        "stroke-width": "2",
        d: "M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
      })]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h3", {
        "class": "text-xl font-semibold text-gray-900 mb-2"
      }, "Profile Management"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", {
        "class": "text-gray-600 mb-6"
      }, "Complete profile management system coming soon..."), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
        "class": "bg-indigo-50 border border-indigo-200 rounded-lg p-4 max-w-md mx-auto"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", {
        "class": "text-indigo-800 text-sm"
      }, "This feature will include profile editing, password changes, and notification preferences.")])])], -1 /* HOISTED */)]);
    }),
    _: 1 /* STABLE */,
    __: [1]
  })]);
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Services.vue?vue&type=template&id=30b0c6c9":
/*!******************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Services.vue?vue&type=template&id=30b0c6c9 ***!
  \******************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "vue");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);

var _hoisted_1 = {
  "class": "flex justify-center items-center"
};
var _hoisted_2 = {
  "class": "space-y-6"
};
var _hoisted_3 = {
  "class": "grid grid-cols-1 md:grid-cols-3 gap-6"
};
var _hoisted_4 = {
  "class": "p-6"
};
var _hoisted_5 = {
  "class": "flex items-center"
};
var _hoisted_6 = {
  "class": "ml-4"
};
var _hoisted_7 = {
  "class": "text-3xl font-bold"
};
var _hoisted_8 = {
  "class": "p-6"
};
var _hoisted_9 = {
  "class": "flex items-center"
};
var _hoisted_10 = {
  "class": "ml-4"
};
var _hoisted_11 = {
  "class": "text-3xl font-bold"
};
var _hoisted_12 = {
  "class": "p-6"
};
var _hoisted_13 = {
  "class": "flex items-center"
};
var _hoisted_14 = {
  "class": "ml-4"
};
var _hoisted_15 = {
  "class": "text-3xl font-bold"
};
var _hoisted_16 = {
  "class": "px-6 py-4 border-b border-20"
};
var _hoisted_17 = {
  "class": "flex items-center justify-between"
};
var _hoisted_18 = {
  "class": "text-sm text-80"
};
var _hoisted_19 = {
  "class": "p-6"
};
var _hoisted_20 = {
  "class": "space-y-4"
};
var _hoisted_21 = {
  "class": "flex items-center justify-between"
};
var _hoisted_22 = {
  "class": "flex items-center space-x-4"
};
var _hoisted_23 = {
  "class": "text-sm font-medium"
};
var _hoisted_24 = {
  "class": "text-xs text-80"
};
var _hoisted_25 = {
  "class": "text-right"
};
var _hoisted_26 = {
  "class": "text-sm font-semibold"
};
var _hoisted_27 = {
  "class": "mt-1"
};
var _hoisted_28 = {
  "class": "px-6 py-4 border-b border-20"
};
var _hoisted_29 = {
  "class": "flex items-center justify-between"
};
var _hoisted_30 = {
  "class": "text-sm text-80"
};
var _hoisted_31 = {
  "class": "p-6"
};
var _hoisted_32 = {
  "class": "space-y-4"
};
var _hoisted_33 = {
  "class": "flex items-center justify-between"
};
var _hoisted_34 = {
  "class": "flex items-center space-x-4"
};
var _hoisted_35 = {
  "class": "text-sm font-medium"
};
var _hoisted_36 = {
  "class": "text-xs text-80"
};
var _hoisted_37 = {
  "class": "text-right"
};
var _hoisted_38 = {
  "class": "mt-1"
};
var _hoisted_39 = {
  "class": "px-6 py-4 border-b border-20"
};
var _hoisted_40 = {
  "class": "flex items-center justify-between"
};
var _hoisted_41 = {
  "class": "text-sm text-80"
};
var _hoisted_42 = {
  "class": "p-6"
};
var _hoisted_43 = {
  "class": "space-y-4"
};
var _hoisted_44 = {
  "class": "flex items-center justify-between"
};
var _hoisted_45 = {
  "class": "flex items-center space-x-4"
};
var _hoisted_46 = {
  "class": "text-sm font-medium"
};
var _hoisted_47 = {
  "class": "text-xs text-80"
};
var _hoisted_48 = {
  "class": "text-right"
};
var _hoisted_49 = {
  "class": "mt-1"
};
function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _$data$services$subsc2, _$data$services$hosti2, _$data$services$domai2;
  var _component_Heading = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Heading");
  var _component_Loader = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Loader");
  var _component_Card = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Card");
  var _component_Badge = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Badge");
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Heading, {
    "class": "mb-6"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return _cache[0] || (_cache[0] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("My Services")]);
    }),
    _: 1 /* STABLE */,
    __: [0]
  }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Loading State "), $data.loading ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(_component_Card, {
    key: 0,
    "class": "py-12"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Loader, {
        "class": "text-60"
      }), _cache[1] || (_cache[1] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
        "class": "ml-3 text-80"
      }, "Loading services...", -1 /* HOISTED */))])];
    }),
    _: 1 /* STABLE */
  })) : !$data.loading && !$options.hasAnyServices ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, {
    key: 1
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Empty State "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Card, null, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return _cache[2] || (_cache[2] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
        "class": "flex flex-col items-center justify-center py-16 px-6"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
        "class": "w-16 h-16 text-60 mb-4",
        fill: "none",
        stroke: "currentColor",
        viewBox: "0 0 24 24"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
        "stroke-linecap": "round",
        "stroke-linejoin": "round",
        "stroke-width": "2",
        d: "M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"
      })]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h3", {
        "class": "text-xl font-semibold mb-2"
      }, "No Services Found"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", {
        "class": "text-80 text-center mb-6 max-w-md"
      }, " You don't have any active services yet. ")], -1 /* HOISTED */)]);
    }),
    _: 1 /* STABLE */,
    __: [2]
  })], 2112 /* STABLE_FRAGMENT, DEV_ROOT_FRAGMENT */)) : ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, {
    key: 2
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Services Overview "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Service Stats "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_3, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Active Subscriptions "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Card, null, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      var _$data$services$subsc;
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_4, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_5, [_cache[4] || (_cache[4] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
        "class": "flex-shrink-0"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
        "class": "w-12 h-12 bg-success-light rounded-lg flex items-center justify-center"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
        "class": "w-6 h-6 text-success",
        fill: "none",
        stroke: "currentColor",
        viewBox: "0 0 24 24"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
        "stroke-linecap": "round",
        "stroke-linejoin": "round",
        "stroke-width": "2",
        d: "M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
      })])])], -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_6, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", _hoisted_7, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(((_$data$services$subsc = $data.services.subscriptions) === null || _$data$services$subsc === void 0 ? void 0 : _$data$services$subsc.length) || 0), 1 /* TEXT */), _cache[3] || (_cache[3] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", {
        "class": "text-sm text-80"
      }, "Active Subscriptions", -1 /* HOISTED */))])])])];
    }),
    _: 1 /* STABLE */
  }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Hosting Accounts "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Card, null, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      var _$data$services$hosti;
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_8, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_9, [_cache[6] || (_cache[6] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
        "class": "flex-shrink-0"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
        "class": "w-12 h-12 bg-primary-light rounded-lg flex items-center justify-center"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
        "class": "w-6 h-6 text-primary",
        fill: "none",
        stroke: "currentColor",
        viewBox: "0 0 24 24"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
        "stroke-linecap": "round",
        "stroke-linejoin": "round",
        "stroke-width": "2",
        d: "M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"
      })])])], -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_10, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", _hoisted_11, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(((_$data$services$hosti = $data.services.hosting_accounts) === null || _$data$services$hosti === void 0 ? void 0 : _$data$services$hosti.length) || 0), 1 /* TEXT */), _cache[5] || (_cache[5] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", {
        "class": "text-sm text-80"
      }, "Hosting Accounts", -1 /* HOISTED */))])])])];
    }),
    _: 1 /* STABLE */
  }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Domain Registrations "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Card, null, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      var _$data$services$domai;
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_12, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_13, [_cache[8] || (_cache[8] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
        "class": "flex-shrink-0"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
        "class": "w-12 h-12 bg-warning-light rounded-lg flex items-center justify-center"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
        "class": "w-6 h-6 text-warning",
        fill: "none",
        stroke: "currentColor",
        viewBox: "0 0 24 24"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
        "stroke-linecap": "round",
        "stroke-linejoin": "round",
        "stroke-width": "2",
        d: "M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9"
      })])])], -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_14, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", _hoisted_15, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(((_$data$services$domai = $data.services.domain_registrations) === null || _$data$services$domai === void 0 ? void 0 : _$data$services$domai.length) || 0), 1 /* TEXT */), _cache[7] || (_cache[7] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", {
        "class": "text-sm text-80"
      }, "Domain Names", -1 /* HOISTED */))])])])];
    }),
    _: 1 /* STABLE */
  })]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Active Subscriptions "), (_$data$services$subsc2 = $data.services.subscriptions) !== null && _$data$services$subsc2 !== void 0 && _$data$services$subsc2.length ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(_component_Card, {
    key: 0
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_16, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_17, [_cache[9] || (_cache[9] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h3", {
        "class": "text-lg font-medium"
      }, "Active Subscriptions", -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", _hoisted_18, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.services.subscriptions.length) + " active", 1 /* TEXT */)])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_19, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_20, [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($data.services.subscriptions, function (subscription) {
        var _subscription$product;
        return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", {
          key: subscription.id,
          "class": "bg-20 rounded-lg p-4 hover:bg-30 transition-colors duration-150"
        }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_21, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_22, [_cache[10] || (_cache[10] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
          "class": "flex-shrink-0"
        }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
          "class": "w-10 h-10 bg-success-light rounded-lg flex items-center justify-center"
        }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
          "class": "w-5 h-5 text-success",
          fill: "none",
          stroke: "currentColor",
          viewBox: "0 0 24 24"
        }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
          "stroke-linecap": "round",
          "stroke-linejoin": "round",
          "stroke-width": "2",
          d: "M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
        })])])], -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", _hoisted_23, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(((_subscription$product = subscription.product) === null || _subscription$product === void 0 ? void 0 : _subscription$product.name) || 'Unknown Product'), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", _hoisted_24, " Next billing: " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($options.formatDate(subscription.next_billing_date)), 1 /* TEXT */)])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_25, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", _hoisted_26, " $" + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($options.formatMoney(subscription.amount)), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_27, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Badge, {
          type: $options.getSubscriptionBadgeType(subscription.status)
        }, {
          "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
            return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)((0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($options.formatStatus(subscription.status)), 1 /* TEXT */)];
          }),
          _: 2 /* DYNAMIC */
        }, 1032 /* PROPS, DYNAMIC_SLOTS */, ["type"])])])])]);
      }), 128 /* KEYED_FRAGMENT */))])])];
    }),
    _: 1 /* STABLE */
  })) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Hosting Accounts "), (_$data$services$hosti2 = $data.services.hosting_accounts) !== null && _$data$services$hosti2 !== void 0 && _$data$services$hosti2.length ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(_component_Card, {
    key: 1
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_28, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_29, [_cache[11] || (_cache[11] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h3", {
        "class": "text-lg font-medium"
      }, "Hosting Accounts", -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", _hoisted_30, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.services.hosting_accounts.length) + " accounts", 1 /* TEXT */)])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_31, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_32, [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($data.services.hosting_accounts, function (account) {
        var _account$server;
        return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", {
          key: account.id,
          "class": "bg-20 rounded-lg p-4 hover:bg-30 transition-colors duration-150"
        }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_33, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_34, [_cache[12] || (_cache[12] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
          "class": "flex-shrink-0"
        }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
          "class": "w-10 h-10 bg-primary-light rounded-lg flex items-center justify-center"
        }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
          "class": "w-5 h-5 text-primary",
          fill: "none",
          stroke: "currentColor",
          viewBox: "0 0 24 24"
        }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
          "stroke-linecap": "round",
          "stroke-linejoin": "round",
          "stroke-width": "2",
          d: "M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"
        })])])], -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", _hoisted_35, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(account.domain || account.username), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", _hoisted_36, " Server: " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(((_account$server = account.server) === null || _account$server === void 0 ? void 0 : _account$server.name) || 'Unknown'), 1 /* TEXT */)])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_37, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_38, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Badge, {
          type: $options.getHostingBadgeType(account.status)
        }, {
          "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
            return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)((0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($options.formatStatus(account.status)), 1 /* TEXT */)];
          }),
          _: 2 /* DYNAMIC */
        }, 1032 /* PROPS, DYNAMIC_SLOTS */, ["type"])])])])]);
      }), 128 /* KEYED_FRAGMENT */))])])];
    }),
    _: 1 /* STABLE */
  })) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Domain Registrations "), (_$data$services$domai2 = $data.services.domain_registrations) !== null && _$data$services$domai2 !== void 0 && _$data$services$domai2.length ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(_component_Card, {
    key: 2
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_39, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_40, [_cache[13] || (_cache[13] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h3", {
        "class": "text-lg font-medium"
      }, "Domain Names", -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", _hoisted_41, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.services.domain_registrations.length) + " domains", 1 /* TEXT */)])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_42, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_43, [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($data.services.domain_registrations, function (domain) {
        return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", {
          key: domain.id,
          "class": "bg-20 rounded-lg p-4 hover:bg-30 transition-colors duration-150"
        }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_44, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_45, [_cache[14] || (_cache[14] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
          "class": "flex-shrink-0"
        }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
          "class": "w-10 h-10 bg-warning-light rounded-lg flex items-center justify-center"
        }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
          "class": "w-5 h-5 text-warning",
          fill: "none",
          stroke: "currentColor",
          viewBox: "0 0 24 24"
        }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
          "stroke-linecap": "round",
          "stroke-linejoin": "round",
          "stroke-width": "2",
          d: "M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9"
        })])])], -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", _hoisted_46, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(domain.domain_name), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", _hoisted_47, " Expires: " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($options.formatDate(domain.expiry_date)), 1 /* TEXT */)])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_48, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_49, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Badge, {
          type: $options.getDomainBadgeType(domain.status)
        }, {
          "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
            return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)((0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($options.formatStatus(domain.status)), 1 /* TEXT */)];
          }),
          _: 2 /* DYNAMIC */
        }, 1032 /* PROPS, DYNAMIC_SLOTS */, ["type"])])])])]);
      }), 128 /* KEYED_FRAGMENT */))])])];
    }),
    _: 1 /* STABLE */
  })) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])], 2112 /* STABLE_FRAGMENT, DEV_ROOT_FRAGMENT */))]);
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Support.vue?vue&type=template&id=692529b4":
/*!*****************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Support.vue?vue&type=template&id=692529b4 ***!
  \*****************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "vue");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);

function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_Heading = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Heading");
  var _component_Card = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Card");
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Heading, {
    "class": "mb-6"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return _cache[0] || (_cache[0] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("Support Tickets")]);
    }),
    _: 1 /* STABLE */,
    __: [0]
  }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Card, null, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return _cache[1] || (_cache[1] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
        "class": "p-6"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
        "class": "text-center py-12"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
        "class": "w-16 h-16 text-gray-300 mx-auto mb-4",
        fill: "none",
        stroke: "currentColor",
        viewBox: "0 0 24 24"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
        "stroke-linecap": "round",
        "stroke-linejoin": "round",
        "stroke-width": "2",
        d: "M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"
      })]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h3", {
        "class": "text-xl font-semibold text-gray-900 mb-2"
      }, "Support System"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", {
        "class": "text-gray-600 mb-6"
      }, "Complete support ticket system coming soon..."), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
        "class": "bg-orange-50 border border-orange-200 rounded-lg p-4 max-w-md mx-auto"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", {
        "class": "text-orange-800 text-sm"
      }, "This feature will include ticket creation, tracking, and communication with support staff.")])])], -1 /* HOISTED */)]);
    }),
    _: 1 /* STABLE */,
    __: [1]
  })]);
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/Tool.vue?vue&type=template&id=ef10eebe&scoped=true":
/*!*********************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/Tool.vue?vue&type=template&id=ef10eebe&scoped=true ***!
  \*********************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "vue");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);

var _hoisted_1 = {
  "class": "customer-portal"
};
var _hoisted_2 = {
  key: 5,
  "class": "flex justify-center items-center py-12"
};
function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_Head = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Head");
  var _component_Dashboard = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Dashboard");
  var _component_Invoices = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Invoices");
  var _component_Services = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Services");
  var _component_Support = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Support");
  var _component_Profile = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Profile");
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Head, {
    title: "Customer Portal"
  }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Dashboard View "), $data.currentView === 'dashboard' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(_component_Dashboard, {
    key: 0,
    "dashboard-data": $data.dashboardData
  }, null, 8 /* PROPS */, ["dashboard-data"])) : $data.currentView === 'invoices' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, {
    key: 1
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Orders View - Now handled by Nova Resource "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Orders functionality moved to Nova CustomerOrder resource "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Invoices View "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Invoices)], 2112 /* STABLE_FRAGMENT, DEV_ROOT_FRAGMENT */)) : $data.currentView === 'services' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, {
    key: 2
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Services View "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Services)], 2112 /* STABLE_FRAGMENT, DEV_ROOT_FRAGMENT */)) : $data.currentView === 'tickets' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, {
    key: 3
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Support Tickets View "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Support)], 2112 /* STABLE_FRAGMENT, DEV_ROOT_FRAGMENT */)) : $data.currentView === 'profile' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, {
    key: 4
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Profile View "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Profile)], 2112 /* STABLE_FRAGMENT, DEV_ROOT_FRAGMENT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Loading State "), $data.loading ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_2, _cache[0] || (_cache[0] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
    "class": "animate-spin h-8 w-8 text-gray-600",
    fill: "none",
    viewBox: "0 0 24 24"
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("circle", {
    "class": "opacity-25",
    cx: "12",
    cy: "12",
    r: "10",
    stroke: "currentColor",
    "stroke-width": "4"
  }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
    "class": "opacity-75",
    fill: "currentColor",
    d: "M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
  })], -1 /* HOISTED */)]))) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)]);
}

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/Tool.vue?vue&type=style&index=0&id=ef10eebe&scoped=true&lang=css":
/*!******************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/Tool.vue?vue&type=style&index=0&id=ef10eebe&scoped=true&lang=css ***!
  \******************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../node_modules/css-loader/dist/runtime/api.js */ "./node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
// Imports

var ___CSS_LOADER_EXPORT___ = _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
// Module
___CSS_LOADER_EXPORT___.push([module.id, "\n/* Minimal custom styles for the customer portal */\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/css-loader/dist/runtime/api.js":
/*!*****************************************************!*\
  !*** ./node_modules/css-loader/dist/runtime/api.js ***!
  \*****************************************************/
/***/ ((module) => {



/*
  MIT License http://www.opensource.org/licenses/mit-license.php
  Author Tobias Koppers @sokra
*/
// css base code, injected by the css-loader
// eslint-disable-next-line func-names
module.exports = function (cssWithMappingToString) {
  var list = []; // return the list of modules as css string

  list.toString = function toString() {
    return this.map(function (item) {
      var content = cssWithMappingToString(item);

      if (item[2]) {
        return "@media ".concat(item[2], " {").concat(content, "}");
      }

      return content;
    }).join("");
  }; // import a list of modules into the list
  // eslint-disable-next-line func-names


  list.i = function (modules, mediaQuery, dedupe) {
    if (typeof modules === "string") {
      // eslint-disable-next-line no-param-reassign
      modules = [[null, modules, ""]];
    }

    var alreadyImportedModules = {};

    if (dedupe) {
      for (var i = 0; i < this.length; i++) {
        // eslint-disable-next-line prefer-destructuring
        var id = this[i][0];

        if (id != null) {
          alreadyImportedModules[id] = true;
        }
      }
    }

    for (var _i = 0; _i < modules.length; _i++) {
      var item = [].concat(modules[_i]);

      if (dedupe && alreadyImportedModules[item[0]]) {
        // eslint-disable-next-line no-continue
        continue;
      }

      if (mediaQuery) {
        if (!item[2]) {
          item[2] = mediaQuery;
        } else {
          item[2] = "".concat(mediaQuery, " and ").concat(item[2]);
        }
      }

      list.push(item);
    }
  };

  return list;
};

/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/Tool.vue?vue&type=style&index=0&id=ef10eebe&scoped=true&lang=css":
/*!**********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/Tool.vue?vue&type=style&index=0&id=ef10eebe&scoped=true&lang=css ***!
  \**********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Tool_vue_vue_type_style_index_0_id_ef10eebe_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../../../node_modules/vue-loader/dist/stylePostLoader.js!../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Tool.vue?vue&type=style&index=0&id=ef10eebe&scoped=true&lang=css */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/Tool.vue?vue&type=style&index=0&id=ef10eebe&scoped=true&lang=css");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Tool_vue_vue_type_style_index_0_id_ef10eebe_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Tool_vue_vue_type_style_index_0_id_ef10eebe_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js":
/*!****************************************************************************!*\
  !*** ./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js ***!
  \****************************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {



var isOldIE = function isOldIE() {
  var memo;
  return function memorize() {
    if (typeof memo === 'undefined') {
      // Test for IE <= 9 as proposed by Browserhacks
      // @see http://browserhacks.com/#hack-e71d8692f65334173fee715c222cb805
      // Tests for existence of standard globals is to allow style-loader
      // to operate correctly into non-standard environments
      // @see https://github.com/webpack-contrib/style-loader/issues/177
      memo = Boolean(window && document && document.all && !window.atob);
    }

    return memo;
  };
}();

var getTarget = function getTarget() {
  var memo = {};
  return function memorize(target) {
    if (typeof memo[target] === 'undefined') {
      var styleTarget = document.querySelector(target); // Special case to return head of iframe instead of iframe itself

      if (window.HTMLIFrameElement && styleTarget instanceof window.HTMLIFrameElement) {
        try {
          // This will throw an exception if access to iframe is blocked
          // due to cross-origin restrictions
          styleTarget = styleTarget.contentDocument.head;
        } catch (e) {
          // istanbul ignore next
          styleTarget = null;
        }
      }

      memo[target] = styleTarget;
    }

    return memo[target];
  };
}();

var stylesInDom = [];

function getIndexByIdentifier(identifier) {
  var result = -1;

  for (var i = 0; i < stylesInDom.length; i++) {
    if (stylesInDom[i].identifier === identifier) {
      result = i;
      break;
    }
  }

  return result;
}

function modulesToDom(list, options) {
  var idCountMap = {};
  var identifiers = [];

  for (var i = 0; i < list.length; i++) {
    var item = list[i];
    var id = options.base ? item[0] + options.base : item[0];
    var count = idCountMap[id] || 0;
    var identifier = "".concat(id, " ").concat(count);
    idCountMap[id] = count + 1;
    var index = getIndexByIdentifier(identifier);
    var obj = {
      css: item[1],
      media: item[2],
      sourceMap: item[3]
    };

    if (index !== -1) {
      stylesInDom[index].references++;
      stylesInDom[index].updater(obj);
    } else {
      stylesInDom.push({
        identifier: identifier,
        updater: addStyle(obj, options),
        references: 1
      });
    }

    identifiers.push(identifier);
  }

  return identifiers;
}

function insertStyleElement(options) {
  var style = document.createElement('style');
  var attributes = options.attributes || {};

  if (typeof attributes.nonce === 'undefined') {
    var nonce =  true ? __webpack_require__.nc : 0;

    if (nonce) {
      attributes.nonce = nonce;
    }
  }

  Object.keys(attributes).forEach(function (key) {
    style.setAttribute(key, attributes[key]);
  });

  if (typeof options.insert === 'function') {
    options.insert(style);
  } else {
    var target = getTarget(options.insert || 'head');

    if (!target) {
      throw new Error("Couldn't find a style target. This probably means that the value for the 'insert' parameter is invalid.");
    }

    target.appendChild(style);
  }

  return style;
}

function removeStyleElement(style) {
  // istanbul ignore if
  if (style.parentNode === null) {
    return false;
  }

  style.parentNode.removeChild(style);
}
/* istanbul ignore next  */


var replaceText = function replaceText() {
  var textStore = [];
  return function replace(index, replacement) {
    textStore[index] = replacement;
    return textStore.filter(Boolean).join('\n');
  };
}();

function applyToSingletonTag(style, index, remove, obj) {
  var css = remove ? '' : obj.media ? "@media ".concat(obj.media, " {").concat(obj.css, "}") : obj.css; // For old IE

  /* istanbul ignore if  */

  if (style.styleSheet) {
    style.styleSheet.cssText = replaceText(index, css);
  } else {
    var cssNode = document.createTextNode(css);
    var childNodes = style.childNodes;

    if (childNodes[index]) {
      style.removeChild(childNodes[index]);
    }

    if (childNodes.length) {
      style.insertBefore(cssNode, childNodes[index]);
    } else {
      style.appendChild(cssNode);
    }
  }
}

function applyToTag(style, options, obj) {
  var css = obj.css;
  var media = obj.media;
  var sourceMap = obj.sourceMap;

  if (media) {
    style.setAttribute('media', media);
  } else {
    style.removeAttribute('media');
  }

  if (sourceMap && typeof btoa !== 'undefined') {
    css += "\n/*# sourceMappingURL=data:application/json;base64,".concat(btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap)))), " */");
  } // For old IE

  /* istanbul ignore if  */


  if (style.styleSheet) {
    style.styleSheet.cssText = css;
  } else {
    while (style.firstChild) {
      style.removeChild(style.firstChild);
    }

    style.appendChild(document.createTextNode(css));
  }
}

var singleton = null;
var singletonCounter = 0;

function addStyle(obj, options) {
  var style;
  var update;
  var remove;

  if (options.singleton) {
    var styleIndex = singletonCounter++;
    style = singleton || (singleton = insertStyleElement(options));
    update = applyToSingletonTag.bind(null, style, styleIndex, false);
    remove = applyToSingletonTag.bind(null, style, styleIndex, true);
  } else {
    style = insertStyleElement(options);
    update = applyToTag.bind(null, style, options);

    remove = function remove() {
      removeStyleElement(style);
    };
  }

  update(obj);
  return function updateStyle(newObj) {
    if (newObj) {
      if (newObj.css === obj.css && newObj.media === obj.media && newObj.sourceMap === obj.sourceMap) {
        return;
      }

      update(obj = newObj);
    } else {
      remove();
    }
  };
}

module.exports = function (list, options) {
  options = options || {}; // Force single-tag solution on IE6-9, which has a hard limit on the # of <style>
  // tags it will allow on a page

  if (!options.singleton && typeof options.singleton !== 'boolean') {
    options.singleton = isOldIE();
  }

  list = list || [];
  var lastIdentifiers = modulesToDom(list, options);
  return function update(newList) {
    newList = newList || [];

    if (Object.prototype.toString.call(newList) !== '[object Array]') {
      return;
    }

    for (var i = 0; i < lastIdentifiers.length; i++) {
      var identifier = lastIdentifiers[i];
      var index = getIndexByIdentifier(identifier);
      stylesInDom[index].references--;
    }

    var newLastIdentifiers = modulesToDom(newList, options);

    for (var _i = 0; _i < lastIdentifiers.length; _i++) {
      var _identifier = lastIdentifiers[_i];

      var _index = getIndexByIdentifier(_identifier);

      if (stylesInDom[_index].references === 0) {
        stylesInDom[_index].updater();

        stylesInDom.splice(_index, 1);
      }
    }

    lastIdentifiers = newLastIdentifiers;
  };
};

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

/***/ "./resources/css/tool.css":
/*!********************************!*\
  !*** ./resources/css/tool.css ***!
  \********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./resources/js/components/Dashboard.vue":
/*!***********************************************!*\
  !*** ./resources/js/components/Dashboard.vue ***!
  \***********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Dashboard_vue_vue_type_template_id_040e2ab9__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Dashboard.vue?vue&type=template&id=040e2ab9 */ "./resources/js/components/Dashboard.vue?vue&type=template&id=040e2ab9");
/* harmony import */ var _Dashboard_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Dashboard.vue?vue&type=script&lang=js */ "./resources/js/components/Dashboard.vue?vue&type=script&lang=js");
/* harmony import */ var _node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_Dashboard_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Dashboard_vue_vue_type_template_id_040e2ab9__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/components/Dashboard.vue"]])
/* hot reload */
if (false) // removed by dead control flow
{}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/components/Dashboard.vue?vue&type=script&lang=js":
/*!***********************************************************************!*\
  !*** ./resources/js/components/Dashboard.vue?vue&type=script&lang=js ***!
  \***********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Dashboard_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Dashboard_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Dashboard.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Dashboard.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/components/Dashboard.vue?vue&type=template&id=040e2ab9":
/*!*****************************************************************************!*\
  !*** ./resources/js/components/Dashboard.vue?vue&type=template&id=040e2ab9 ***!
  \*****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Dashboard_vue_vue_type_template_id_040e2ab9__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Dashboard_vue_vue_type_template_id_040e2ab9__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Dashboard.vue?vue&type=template&id=040e2ab9 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Dashboard.vue?vue&type=template&id=040e2ab9");


/***/ }),

/***/ "./resources/js/components/Invoices.vue":
/*!**********************************************!*\
  !*** ./resources/js/components/Invoices.vue ***!
  \**********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Invoices_vue_vue_type_template_id_39dd555e__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Invoices.vue?vue&type=template&id=39dd555e */ "./resources/js/components/Invoices.vue?vue&type=template&id=39dd555e");
/* harmony import */ var _Invoices_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Invoices.vue?vue&type=script&lang=js */ "./resources/js/components/Invoices.vue?vue&type=script&lang=js");
/* harmony import */ var _node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_Invoices_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Invoices_vue_vue_type_template_id_39dd555e__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/components/Invoices.vue"]])
/* hot reload */
if (false) // removed by dead control flow
{}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/components/Invoices.vue?vue&type=script&lang=js":
/*!**********************************************************************!*\
  !*** ./resources/js/components/Invoices.vue?vue&type=script&lang=js ***!
  \**********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Invoices_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Invoices_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Invoices.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Invoices.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/components/Invoices.vue?vue&type=template&id=39dd555e":
/*!****************************************************************************!*\
  !*** ./resources/js/components/Invoices.vue?vue&type=template&id=39dd555e ***!
  \****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Invoices_vue_vue_type_template_id_39dd555e__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Invoices_vue_vue_type_template_id_39dd555e__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Invoices.vue?vue&type=template&id=39dd555e */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Invoices.vue?vue&type=template&id=39dd555e");


/***/ }),

/***/ "./resources/js/components/Profile.vue":
/*!*********************************************!*\
  !*** ./resources/js/components/Profile.vue ***!
  \*********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Profile_vue_vue_type_template_id_3bd692e4__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Profile.vue?vue&type=template&id=3bd692e4 */ "./resources/js/components/Profile.vue?vue&type=template&id=3bd692e4");
/* harmony import */ var _Profile_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Profile.vue?vue&type=script&lang=js */ "./resources/js/components/Profile.vue?vue&type=script&lang=js");
/* harmony import */ var _node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_Profile_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Profile_vue_vue_type_template_id_3bd692e4__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/components/Profile.vue"]])
/* hot reload */
if (false) // removed by dead control flow
{}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/components/Profile.vue?vue&type=script&lang=js":
/*!*********************************************************************!*\
  !*** ./resources/js/components/Profile.vue?vue&type=script&lang=js ***!
  \*********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Profile_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Profile_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Profile.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Profile.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/components/Profile.vue?vue&type=template&id=3bd692e4":
/*!***************************************************************************!*\
  !*** ./resources/js/components/Profile.vue?vue&type=template&id=3bd692e4 ***!
  \***************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Profile_vue_vue_type_template_id_3bd692e4__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Profile_vue_vue_type_template_id_3bd692e4__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Profile.vue?vue&type=template&id=3bd692e4 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Profile.vue?vue&type=template&id=3bd692e4");


/***/ }),

/***/ "./resources/js/components/Services.vue":
/*!**********************************************!*\
  !*** ./resources/js/components/Services.vue ***!
  \**********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Services_vue_vue_type_template_id_30b0c6c9__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Services.vue?vue&type=template&id=30b0c6c9 */ "./resources/js/components/Services.vue?vue&type=template&id=30b0c6c9");
/* harmony import */ var _Services_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Services.vue?vue&type=script&lang=js */ "./resources/js/components/Services.vue?vue&type=script&lang=js");
/* harmony import */ var _node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_Services_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Services_vue_vue_type_template_id_30b0c6c9__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/components/Services.vue"]])
/* hot reload */
if (false) // removed by dead control flow
{}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/components/Services.vue?vue&type=script&lang=js":
/*!**********************************************************************!*\
  !*** ./resources/js/components/Services.vue?vue&type=script&lang=js ***!
  \**********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Services_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Services_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Services.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Services.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/components/Services.vue?vue&type=template&id=30b0c6c9":
/*!****************************************************************************!*\
  !*** ./resources/js/components/Services.vue?vue&type=template&id=30b0c6c9 ***!
  \****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Services_vue_vue_type_template_id_30b0c6c9__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Services_vue_vue_type_template_id_30b0c6c9__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Services.vue?vue&type=template&id=30b0c6c9 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Services.vue?vue&type=template&id=30b0c6c9");


/***/ }),

/***/ "./resources/js/components/Support.vue":
/*!*********************************************!*\
  !*** ./resources/js/components/Support.vue ***!
  \*********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Support_vue_vue_type_template_id_692529b4__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Support.vue?vue&type=template&id=692529b4 */ "./resources/js/components/Support.vue?vue&type=template&id=692529b4");
/* harmony import */ var _Support_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Support.vue?vue&type=script&lang=js */ "./resources/js/components/Support.vue?vue&type=script&lang=js");
/* harmony import */ var _node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_Support_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Support_vue_vue_type_template_id_692529b4__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/components/Support.vue"]])
/* hot reload */
if (false) // removed by dead control flow
{}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/components/Support.vue?vue&type=script&lang=js":
/*!*********************************************************************!*\
  !*** ./resources/js/components/Support.vue?vue&type=script&lang=js ***!
  \*********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Support_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Support_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Support.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Support.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/components/Support.vue?vue&type=template&id=692529b4":
/*!***************************************************************************!*\
  !*** ./resources/js/components/Support.vue?vue&type=template&id=692529b4 ***!
  \***************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Support_vue_vue_type_template_id_692529b4__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Support_vue_vue_type_template_id_692529b4__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Support.vue?vue&type=template&id=692529b4 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Support.vue?vue&type=template&id=692529b4");


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
/* harmony import */ var _Tool_vue_vue_type_template_id_ef10eebe_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Tool.vue?vue&type=template&id=ef10eebe&scoped=true */ "./resources/js/pages/Tool.vue?vue&type=template&id=ef10eebe&scoped=true");
/* harmony import */ var _Tool_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Tool.vue?vue&type=script&lang=js */ "./resources/js/pages/Tool.vue?vue&type=script&lang=js");
/* harmony import */ var _Tool_vue_vue_type_style_index_0_id_ef10eebe_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Tool.vue?vue&type=style&index=0&id=ef10eebe&scoped=true&lang=css */ "./resources/js/pages/Tool.vue?vue&type=style&index=0&id=ef10eebe&scoped=true&lang=css");
/* harmony import */ var _node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;


const __exports__ = /*#__PURE__*/(0,_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_3__["default"])(_Tool_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Tool_vue_vue_type_template_id_ef10eebe_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render],['__scopeId',"data-v-ef10eebe"],['__file',"resources/js/pages/Tool.vue"]])
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

/***/ "./resources/js/pages/Tool.vue?vue&type=style&index=0&id=ef10eebe&scoped=true&lang=css":
/*!*********************************************************************************************!*\
  !*** ./resources/js/pages/Tool.vue?vue&type=style&index=0&id=ef10eebe&scoped=true&lang=css ***!
  \*********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Tool_vue_vue_type_style_index_0_id_ef10eebe_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/style-loader/dist/cjs.js!../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../../../node_modules/vue-loader/dist/stylePostLoader.js!../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Tool.vue?vue&type=style&index=0&id=ef10eebe&scoped=true&lang=css */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/Tool.vue?vue&type=style&index=0&id=ef10eebe&scoped=true&lang=css");


/***/ }),

/***/ "./resources/js/pages/Tool.vue?vue&type=template&id=ef10eebe&scoped=true":
/*!*******************************************************************************!*\
  !*** ./resources/js/pages/Tool.vue?vue&type=template&id=ef10eebe&scoped=true ***!
  \*******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Tool_vue_vue_type_template_id_ef10eebe_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Tool_vue_vue_type_template_id_ef10eebe_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Tool.vue?vue&type=template&id=ef10eebe&scoped=true */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/Tool.vue?vue&type=template&id=ef10eebe&scoped=true");


/***/ }),

/***/ "./resources/js/tool.js":
/*!******************************!*\
  !*** ./resources/js/tool.js ***!
  \******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _pages_Tool__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./pages/Tool */ "./resources/js/pages/Tool.vue");

Nova.inertia('CustomerPortal', _pages_Tool__WEBPACK_IMPORTED_MODULE_0__["default"]);
Nova.booting(function (app, store) {
  //
});

/***/ }),

/***/ "./resources/js/utils/helpers.js":
/*!***************************************!*\
  !*** ./resources/js/utils/helpers.js ***!
  \***************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   CustomerPortalAPI: () => (/* binding */ CustomerPortalAPI),
/* harmony export */   formatDate: () => (/* binding */ formatDate),
/* harmony export */   formatMoney: () => (/* binding */ formatMoney),
/* harmony export */   formatTime: () => (/* binding */ formatTime),
/* harmony export */   getCustomerStatusClass: () => (/* binding */ getCustomerStatusClass),
/* harmony export */   getInitials: () => (/* binding */ getInitials),
/* harmony export */   getInvoiceStatusClass: () => (/* binding */ getInvoiceStatusClass),
/* harmony export */   getOrderStatusClass: () => (/* binding */ getOrderStatusClass)
/* harmony export */ });
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/babel/babel/blob/main/packages/babel-helpers/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return r; }; var t, r = {}, e = Object.prototype, n = e.hasOwnProperty, o = "function" == typeof Symbol ? Symbol : {}, i = o.iterator || "@@iterator", a = o.asyncIterator || "@@asyncIterator", u = o.toStringTag || "@@toStringTag"; function c(t, r, e, n) { return Object.defineProperty(t, r, { value: e, enumerable: !n, configurable: !n, writable: !n }); } try { c({}, ""); } catch (t) { c = function c(t, r, e) { return t[r] = e; }; } function h(r, e, n, o) { var i = e && e.prototype instanceof Generator ? e : Generator, a = Object.create(i.prototype); return c(a, "_invoke", function (r, e, n) { var o = 1; return function (i, a) { if (3 === o) throw Error("Generator is already running"); if (4 === o) { if ("throw" === i) throw a; return { value: t, done: !0 }; } for (n.method = i, n.arg = a;;) { var u = n.delegate; if (u) { var c = d(u, n); if (c) { if (c === f) continue; return c; } } if ("next" === n.method) n.sent = n._sent = n.arg;else if ("throw" === n.method) { if (1 === o) throw o = 4, n.arg; n.dispatchException(n.arg); } else "return" === n.method && n.abrupt("return", n.arg); o = 3; var h = s(r, e, n); if ("normal" === h.type) { if (o = n.done ? 4 : 2, h.arg === f) continue; return { value: h.arg, done: n.done }; } "throw" === h.type && (o = 4, n.method = "throw", n.arg = h.arg); } }; }(r, n, new Context(o || [])), !0), a; } function s(t, r, e) { try { return { type: "normal", arg: t.call(r, e) }; } catch (t) { return { type: "throw", arg: t }; } } r.wrap = h; var f = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var l = {}; c(l, i, function () { return this; }); var p = Object.getPrototypeOf, y = p && p(p(x([]))); y && y !== e && n.call(y, i) && (l = y); var v = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(l); function g(t) { ["next", "throw", "return"].forEach(function (r) { c(t, r, function (t) { return this._invoke(r, t); }); }); } function AsyncIterator(t, r) { function e(o, i, a, u) { var c = s(t[o], t, i); if ("throw" !== c.type) { var h = c.arg, f = h.value; return f && "object" == _typeof(f) && n.call(f, "__await") ? r.resolve(f.__await).then(function (t) { e("next", t, a, u); }, function (t) { e("throw", t, a, u); }) : r.resolve(f).then(function (t) { h.value = t, a(h); }, function (t) { return e("throw", t, a, u); }); } u(c.arg); } var o; c(this, "_invoke", function (t, n) { function i() { return new r(function (r, o) { e(t, n, r, o); }); } return o = o ? o.then(i, i) : i(); }, !0); } function d(r, e) { var n = e.method, o = r.i[n]; if (o === t) return e.delegate = null, "throw" === n && r.i["return"] && (e.method = "return", e.arg = t, d(r, e), "throw" === e.method) || "return" !== n && (e.method = "throw", e.arg = new TypeError("The iterator does not provide a '" + n + "' method")), f; var i = s(o, r.i, e.arg); if ("throw" === i.type) return e.method = "throw", e.arg = i.arg, e.delegate = null, f; var a = i.arg; return a ? a.done ? (e[r.r] = a.value, e.next = r.n, "return" !== e.method && (e.method = "next", e.arg = t), e.delegate = null, f) : a : (e.method = "throw", e.arg = new TypeError("iterator result is not an object"), e.delegate = null, f); } function w(t) { this.tryEntries.push(t); } function m(r) { var e = r[4] || {}; e.type = "normal", e.arg = t, r[4] = e; } function Context(t) { this.tryEntries = [[-1]], t.forEach(w, this), this.reset(!0); } function x(r) { if (null != r) { var e = r[i]; if (e) return e.call(r); if ("function" == typeof r.next) return r; if (!isNaN(r.length)) { var o = -1, a = function e() { for (; ++o < r.length;) if (n.call(r, o)) return e.value = r[o], e.done = !1, e; return e.value = t, e.done = !0, e; }; return a.next = a; } } throw new TypeError(_typeof(r) + " is not iterable"); } return GeneratorFunction.prototype = GeneratorFunctionPrototype, c(v, "constructor", GeneratorFunctionPrototype), c(GeneratorFunctionPrototype, "constructor", GeneratorFunction), GeneratorFunction.displayName = c(GeneratorFunctionPrototype, u, "GeneratorFunction"), r.isGeneratorFunction = function (t) { var r = "function" == typeof t && t.constructor; return !!r && (r === GeneratorFunction || "GeneratorFunction" === (r.displayName || r.name)); }, r.mark = function (t) { return Object.setPrototypeOf ? Object.setPrototypeOf(t, GeneratorFunctionPrototype) : (t.__proto__ = GeneratorFunctionPrototype, c(t, u, "GeneratorFunction")), t.prototype = Object.create(v), t; }, r.awrap = function (t) { return { __await: t }; }, g(AsyncIterator.prototype), c(AsyncIterator.prototype, a, function () { return this; }), r.AsyncIterator = AsyncIterator, r.async = function (t, e, n, o, i) { void 0 === i && (i = Promise); var a = new AsyncIterator(h(t, e, n, o), i); return r.isGeneratorFunction(e) ? a : a.next().then(function (t) { return t.done ? t.value : a.next(); }); }, g(v), c(v, u, "Generator"), c(v, i, function () { return this; }), c(v, "toString", function () { return "[object Generator]"; }), r.keys = function (t) { var r = Object(t), e = []; for (var n in r) e.unshift(n); return function t() { for (; e.length;) if ((n = e.pop()) in r) return t.value = n, t.done = !1, t; return t.done = !0, t; }; }, r.values = x, Context.prototype = { constructor: Context, reset: function reset(r) { if (this.prev = this.next = 0, this.sent = this._sent = t, this.done = !1, this.delegate = null, this.method = "next", this.arg = t, this.tryEntries.forEach(m), !r) for (var e in this) "t" === e.charAt(0) && n.call(this, e) && !isNaN(+e.slice(1)) && (this[e] = t); }, stop: function stop() { this.done = !0; var t = this.tryEntries[0][4]; if ("throw" === t.type) throw t.arg; return this.rval; }, dispatchException: function dispatchException(r) { if (this.done) throw r; var e = this; function n(t) { a.type = "throw", a.arg = r, e.next = t; } for (var o = e.tryEntries.length - 1; o >= 0; --o) { var i = this.tryEntries[o], a = i[4], u = this.prev, c = i[1], h = i[2]; if (-1 === i[0]) return n("end"), !1; if (!c && !h) throw Error("try statement without catch or finally"); if (null != i[0] && i[0] <= u) { if (u < c) return this.method = "next", this.arg = t, n(c), !0; if (u < h) return n(h), !1; } } }, abrupt: function abrupt(t, r) { for (var e = this.tryEntries.length - 1; e >= 0; --e) { var n = this.tryEntries[e]; if (n[0] > -1 && n[0] <= this.prev && this.prev < n[2]) { var o = n; break; } } o && ("break" === t || "continue" === t) && o[0] <= r && r <= o[2] && (o = null); var i = o ? o[4] : {}; return i.type = t, i.arg = r, o ? (this.method = "next", this.next = o[2], f) : this.complete(i); }, complete: function complete(t, r) { if ("throw" === t.type) throw t.arg; return "break" === t.type || "continue" === t.type ? this.next = t.arg : "return" === t.type ? (this.rval = this.arg = t.arg, this.method = "return", this.next = "end") : "normal" === t.type && r && (this.next = r), f; }, finish: function finish(t) { for (var r = this.tryEntries.length - 1; r >= 0; --r) { var e = this.tryEntries[r]; if (e[2] === t) return this.complete(e[4], e[3]), m(e), f; } }, "catch": function _catch(t) { for (var r = this.tryEntries.length - 1; r >= 0; --r) { var e = this.tryEntries[r]; if (e[0] === t) { var n = e[4]; if ("throw" === n.type) { var o = n.arg; m(e); } return o; } } throw Error("illegal catch attempt"); }, delegateYield: function delegateYield(r, e, n) { return this.delegate = { i: x(r), r: e, n: n }, "next" === this.method && (this.arg = t), f; } }, r; }
function asyncGeneratorStep(n, t, e, r, o, a, c) { try { var i = n[a](c), u = i.value; } catch (n) { return void e(n); } i.done ? t(u) : Promise.resolve(u).then(r, o); }
function _asyncToGenerator(n) { return function () { var t = this, e = arguments; return new Promise(function (r, o) { var a = n.apply(t, e); function _next(n) { asyncGeneratorStep(a, r, o, _next, _throw, "next", n); } function _throw(n) { asyncGeneratorStep(a, r, o, _next, _throw, "throw", n); } _next(void 0); }); }; }
function _classCallCheck(a, n) { if (!(a instanceof n)) throw new TypeError("Cannot call a class as a function"); }
function _defineProperties(e, r) { for (var t = 0; t < r.length; t++) { var o = r[t]; o.enumerable = o.enumerable || !1, o.configurable = !0, "value" in o && (o.writable = !0), Object.defineProperty(e, _toPropertyKey(o.key), o); } }
function _createClass(e, r, t) { return r && _defineProperties(e.prototype, r), t && _defineProperties(e, t), Object.defineProperty(e, "prototype", { writable: !1 }), e; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
/**
 * Customer Portal Helper Functions
 */

/**
 * Format money amount with commas and decimal places
 * @param {number|string} amount
 * @returns {string}
 */
function formatMoney(amount) {
  if (!amount) return '0.00';
  return parseFloat(amount).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
}

/**
 * Format date to readable format
 * @param {string} date
 * @returns {string}
 */
function formatDate(date) {
  if (!date) return '';
  return new Date(date).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  });
}

/**
 * Format time to readable format
 * @param {string} date
 * @returns {string}
 */
function formatTime(date) {
  if (!date) return '';
  return new Date(date).toLocaleTimeString('en-US', {
    hour: '2-digit',
    minute: '2-digit'
  });
}

/**
 * Get initials from a name
 * @param {string} name
 * @returns {string}
 */
function getInitials(name) {
  if (!name) return 'U';
  return name.split(' ').map(function (word) {
    return word.charAt(0);
  }).join('').toUpperCase().substring(0, 2);
}

/**
 * Get CSS classes for order status
 * @param {string} status
 * @returns {string}
 */
function getOrderStatusClass(status) {
  var classes = {
    'pending': 'bg-yellow-100 text-yellow-800 border border-yellow-200',
    'processing': 'bg-blue-100 text-blue-800 border border-blue-200',
    'completed': 'bg-green-100 text-green-800 border border-green-200',
    'cancelled': 'bg-red-100 text-red-800 border border-red-200',
    'shipped': 'bg-purple-100 text-purple-800 border border-purple-200'
  };
  return classes[status] || 'bg-gray-100 text-gray-800 border border-gray-200';
}

/**
 * Get CSS classes for invoice status
 * @param {string} status
 * @returns {string}
 */
function getInvoiceStatusClass(status) {
  var classes = {
    'draft': 'bg-gray-100 text-gray-800 border border-gray-200',
    'sent': 'bg-blue-100 text-blue-800 border border-blue-200',
    'paid': 'bg-green-100 text-green-800 border border-green-200',
    'overdue': 'bg-red-100 text-red-800 border border-red-200',
    'cancelled': 'bg-red-100 text-red-800 border border-red-200',
    'partial': 'bg-orange-100 text-orange-800 border border-orange-200'
  };
  return classes[status] || 'bg-gray-100 text-gray-800 border border-gray-200';
}

/**
 * Get CSS classes for customer status
 * @param {string} status
 * @returns {string}
 */
function getCustomerStatusClass(status) {
  switch (status) {
    case 'Active':
      return 'bg-green-100 text-green-800 border border-green-200';
    case 'Inactive':
      return 'bg-red-100 text-red-800 border border-red-200';
    case 'Suspended':
      return 'bg-yellow-100 text-yellow-800 border border-yellow-200';
    default:
      return 'bg-gray-100 text-gray-800 border border-gray-200';
  }
}

/**
 * API helper for customer portal requests
 */
var CustomerPortalAPI = /*#__PURE__*/function () {
  function CustomerPortalAPI() {
    _classCallCheck(this, CustomerPortalAPI);
  }
  return _createClass(CustomerPortalAPI, null, [{
    key: "getDashboardData",
    value: function () {
      var _getDashboardData = _asyncToGenerator(/*#__PURE__*/_regeneratorRuntime().mark(function _callee() {
        var response;
        return _regeneratorRuntime().wrap(function _callee$(_context) {
          while (1) switch (_context.prev = _context.next) {
            case 0:
              _context.prev = 0;
              _context.next = 3;
              return Nova.request().get('/nova-vendor/customer-portal/dashboard');
            case 3:
              response = _context.sent;
              return _context.abrupt("return", response.data);
            case 7:
              _context.prev = 7;
              _context.t0 = _context["catch"](0);
              console.error('Error loading dashboard data:', _context.t0);
              throw _context.t0;
            case 11:
            case "end":
              return _context.stop();
          }
        }, _callee, null, [[0, 7]]);
      }));
      function getDashboardData() {
        return _getDashboardData.apply(this, arguments);
      }
      return getDashboardData;
    }() // Orders API - DEPRECATED: Now handled by Nova CustomerOrder resource
    // These methods are kept for reference but are no longer used
    // Orders are now managed through Nova's CustomerOrder resource
    /*
    static async getOrders(page = 1, filters = {}) {
      try {
        const params = new URLSearchParams()
        params.append('page', page)
         // Add filter parameters
        if (filters.search) {
          params.append('search', filters.search)
        }
        if (filters.status) {
          params.append('status', filters.status)
        }
        if (filters.sort_by) {
          params.append('sort_by', filters.sort_by)
        }
        if (filters.sort_direction) {
          params.append('sort_direction', filters.sort_direction)
        }
        if (filters.per_page) {
          params.append('per_page', filters.per_page)
        }
         const response = await Nova.request().get(`/nova-vendor/customer-portal/orders?${params.toString()}`)
        return response.data
      } catch (error) {
        console.error('Error loading orders:', error)
        throw error
      }
    }
     static async getOrder(orderId) {
      try {
        const response = await Nova.request().get(`/nova-vendor/customer-portal/orders/${orderId}`)
        return response.data
      } catch (error) {
        console.error('Error loading order:', error)
        throw error
      }
    }
     static async getOrderItems(orderId) {
      try {
        const response = await Nova.request().get(`/nova-vendor/customer-portal/orders/${orderId}/items`)
        return response.data
      } catch (error) {
        console.error('Error loading order items:', error)
        throw error
      }
    }
    */
    // Invoices API
  }, {
    key: "getInvoices",
    value: function () {
      var _getInvoices = _asyncToGenerator(/*#__PURE__*/_regeneratorRuntime().mark(function _callee2() {
        var page,
          filters,
          params,
          response,
          _args2 = arguments;
        return _regeneratorRuntime().wrap(function _callee2$(_context2) {
          while (1) switch (_context2.prev = _context2.next) {
            case 0:
              page = _args2.length > 0 && _args2[0] !== undefined ? _args2[0] : 1;
              filters = _args2.length > 1 && _args2[1] !== undefined ? _args2[1] : {};
              _context2.prev = 2;
              params = new URLSearchParams();
              params.append('page', page);

              // Add filter parameters
              if (filters.search) {
                params.append('search', filters.search);
              }
              if (filters.status) {
                params.append('status', filters.status);
              }
              if (filters.sort_by) {
                params.append('sort_by', filters.sort_by);
              }
              if (filters.sort_direction) {
                params.append('sort_direction', filters.sort_direction);
              }
              if (filters.per_page) {
                params.append('per_page', filters.per_page);
              }
              _context2.next = 12;
              return Nova.request().get("/nova-vendor/customer-portal/invoices?".concat(params.toString()));
            case 12:
              response = _context2.sent;
              return _context2.abrupt("return", response.data);
            case 16:
              _context2.prev = 16;
              _context2.t0 = _context2["catch"](2);
              console.error('Error loading invoices:', _context2.t0);
              throw _context2.t0;
            case 20:
            case "end":
              return _context2.stop();
          }
        }, _callee2, null, [[2, 16]]);
      }));
      function getInvoices() {
        return _getInvoices.apply(this, arguments);
      }
      return getInvoices;
    }()
  }, {
    key: "getInvoice",
    value: function () {
      var _getInvoice = _asyncToGenerator(/*#__PURE__*/_regeneratorRuntime().mark(function _callee3(invoiceId) {
        var response;
        return _regeneratorRuntime().wrap(function _callee3$(_context3) {
          while (1) switch (_context3.prev = _context3.next) {
            case 0:
              _context3.prev = 0;
              _context3.next = 3;
              return Nova.request().get("/nova-vendor/customer-portal/invoices/".concat(invoiceId));
            case 3:
              response = _context3.sent;
              return _context3.abrupt("return", response.data);
            case 7:
              _context3.prev = 7;
              _context3.t0 = _context3["catch"](0);
              console.error('Error loading invoice:', _context3.t0);
              throw _context3.t0;
            case 11:
            case "end":
              return _context3.stop();
          }
        }, _callee3, null, [[0, 7]]);
      }));
      function getInvoice(_x) {
        return _getInvoice.apply(this, arguments);
      }
      return getInvoice;
    }()
  }, {
    key: "getInvoicePayments",
    value: function () {
      var _getInvoicePayments = _asyncToGenerator(/*#__PURE__*/_regeneratorRuntime().mark(function _callee4(invoiceId) {
        var response;
        return _regeneratorRuntime().wrap(function _callee4$(_context4) {
          while (1) switch (_context4.prev = _context4.next) {
            case 0:
              _context4.prev = 0;
              _context4.next = 3;
              return Nova.request().get("/nova-vendor/customer-portal/invoices/".concat(invoiceId, "/payments"));
            case 3:
              response = _context4.sent;
              return _context4.abrupt("return", response.data);
            case 7:
              _context4.prev = 7;
              _context4.t0 = _context4["catch"](0);
              console.error('Error loading invoice payments:', _context4.t0);
              throw _context4.t0;
            case 11:
            case "end":
              return _context4.stop();
          }
        }, _callee4, null, [[0, 7]]);
      }));
      function getInvoicePayments(_x2) {
        return _getInvoicePayments.apply(this, arguments);
      }
      return getInvoicePayments;
    }()
  }, {
    key: "downloadInvoicePdf",
    value: function () {
      var _downloadInvoicePdf = _asyncToGenerator(/*#__PURE__*/_regeneratorRuntime().mark(function _callee5(invoiceId) {
        var response;
        return _regeneratorRuntime().wrap(function _callee5$(_context5) {
          while (1) switch (_context5.prev = _context5.next) {
            case 0:
              _context5.prev = 0;
              _context5.next = 3;
              return Nova.request().get("/nova-vendor/customer-portal/invoices/".concat(invoiceId, "/pdf"));
            case 3:
              response = _context5.sent;
              return _context5.abrupt("return", response.data);
            case 7:
              _context5.prev = 7;
              _context5.t0 = _context5["catch"](0);
              console.error('Error downloading invoice PDF:', _context5.t0);
              throw _context5.t0;
            case 11:
            case "end":
              return _context5.stop();
          }
        }, _callee5, null, [[0, 7]]);
      }));
      function downloadInvoicePdf(_x3) {
        return _downloadInvoicePdf.apply(this, arguments);
      }
      return downloadInvoicePdf;
    }() // Services API
  }, {
    key: "getServices",
    value: function () {
      var _getServices = _asyncToGenerator(/*#__PURE__*/_regeneratorRuntime().mark(function _callee6() {
        var response;
        return _regeneratorRuntime().wrap(function _callee6$(_context6) {
          while (1) switch (_context6.prev = _context6.next) {
            case 0:
              _context6.prev = 0;
              _context6.next = 3;
              return Nova.request().get('/nova-vendor/customer-portal/services');
            case 3:
              response = _context6.sent;
              return _context6.abrupt("return", response.data);
            case 7:
              _context6.prev = 7;
              _context6.t0 = _context6["catch"](0);
              console.error('Error loading services:', _context6.t0);
              throw _context6.t0;
            case 11:
            case "end":
              return _context6.stop();
          }
        }, _callee6, null, [[0, 7]]);
      }));
      function getServices() {
        return _getServices.apply(this, arguments);
      }
      return getServices;
    }()
  }, {
    key: "getHostingAccounts",
    value: function () {
      var _getHostingAccounts = _asyncToGenerator(/*#__PURE__*/_regeneratorRuntime().mark(function _callee7() {
        var page,
          response,
          _args7 = arguments;
        return _regeneratorRuntime().wrap(function _callee7$(_context7) {
          while (1) switch (_context7.prev = _context7.next) {
            case 0:
              page = _args7.length > 0 && _args7[0] !== undefined ? _args7[0] : 1;
              _context7.prev = 1;
              _context7.next = 4;
              return Nova.request().get("/nova-vendor/customer-portal/hosting-accounts?page=".concat(page));
            case 4:
              response = _context7.sent;
              return _context7.abrupt("return", response.data);
            case 8:
              _context7.prev = 8;
              _context7.t0 = _context7["catch"](1);
              console.error('Error loading hosting accounts:', _context7.t0);
              throw _context7.t0;
            case 12:
            case "end":
              return _context7.stop();
          }
        }, _callee7, null, [[1, 8]]);
      }));
      function getHostingAccounts() {
        return _getHostingAccounts.apply(this, arguments);
      }
      return getHostingAccounts;
    }()
  }, {
    key: "getDomains",
    value: function () {
      var _getDomains = _asyncToGenerator(/*#__PURE__*/_regeneratorRuntime().mark(function _callee8() {
        var page,
          response,
          _args8 = arguments;
        return _regeneratorRuntime().wrap(function _callee8$(_context8) {
          while (1) switch (_context8.prev = _context8.next) {
            case 0:
              page = _args8.length > 0 && _args8[0] !== undefined ? _args8[0] : 1;
              _context8.prev = 1;
              _context8.next = 4;
              return Nova.request().get("/nova-vendor/customer-portal/domains?page=".concat(page));
            case 4:
              response = _context8.sent;
              return _context8.abrupt("return", response.data);
            case 8:
              _context8.prev = 8;
              _context8.t0 = _context8["catch"](1);
              console.error('Error loading domains:', _context8.t0);
              throw _context8.t0;
            case 12:
            case "end":
              return _context8.stop();
          }
        }, _callee8, null, [[1, 8]]);
      }));
      function getDomains() {
        return _getDomains.apply(this, arguments);
      }
      return getDomains;
    }()
  }, {
    key: "getSubscriptions",
    value: function () {
      var _getSubscriptions = _asyncToGenerator(/*#__PURE__*/_regeneratorRuntime().mark(function _callee9() {
        var page,
          response,
          _args9 = arguments;
        return _regeneratorRuntime().wrap(function _callee9$(_context9) {
          while (1) switch (_context9.prev = _context9.next) {
            case 0:
              page = _args9.length > 0 && _args9[0] !== undefined ? _args9[0] : 1;
              _context9.prev = 1;
              _context9.next = 4;
              return Nova.request().get("/nova-vendor/customer-portal/subscriptions?page=".concat(page));
            case 4:
              response = _context9.sent;
              return _context9.abrupt("return", response.data);
            case 8:
              _context9.prev = 8;
              _context9.t0 = _context9["catch"](1);
              console.error('Error loading subscriptions:', _context9.t0);
              throw _context9.t0;
            case 12:
            case "end":
              return _context9.stop();
          }
        }, _callee9, null, [[1, 8]]);
      }));
      function getSubscriptions() {
        return _getSubscriptions.apply(this, arguments);
      }
      return getSubscriptions;
    }() // Support Tickets API
  }, {
    key: "getTickets",
    value: function () {
      var _getTickets = _asyncToGenerator(/*#__PURE__*/_regeneratorRuntime().mark(function _callee0() {
        var page,
          response,
          _args0 = arguments;
        return _regeneratorRuntime().wrap(function _callee0$(_context0) {
          while (1) switch (_context0.prev = _context0.next) {
            case 0:
              page = _args0.length > 0 && _args0[0] !== undefined ? _args0[0] : 1;
              _context0.prev = 1;
              _context0.next = 4;
              return Nova.request().get("/nova-vendor/customer-portal/tickets?page=".concat(page));
            case 4:
              response = _context0.sent;
              return _context0.abrupt("return", response.data);
            case 8:
              _context0.prev = 8;
              _context0.t0 = _context0["catch"](1);
              console.error('Error loading tickets:', _context0.t0);
              throw _context0.t0;
            case 12:
            case "end":
              return _context0.stop();
          }
        }, _callee0, null, [[1, 8]]);
      }));
      function getTickets() {
        return _getTickets.apply(this, arguments);
      }
      return getTickets;
    }()
  }, {
    key: "getTicket",
    value: function () {
      var _getTicket = _asyncToGenerator(/*#__PURE__*/_regeneratorRuntime().mark(function _callee1(ticketId) {
        var response;
        return _regeneratorRuntime().wrap(function _callee1$(_context1) {
          while (1) switch (_context1.prev = _context1.next) {
            case 0:
              _context1.prev = 0;
              _context1.next = 3;
              return Nova.request().get("/nova-vendor/customer-portal/tickets/".concat(ticketId));
            case 3:
              response = _context1.sent;
              return _context1.abrupt("return", response.data);
            case 7:
              _context1.prev = 7;
              _context1.t0 = _context1["catch"](0);
              console.error('Error loading ticket:', _context1.t0);
              throw _context1.t0;
            case 11:
            case "end":
              return _context1.stop();
          }
        }, _callee1, null, [[0, 7]]);
      }));
      function getTicket(_x4) {
        return _getTicket.apply(this, arguments);
      }
      return getTicket;
    }()
  }, {
    key: "createTicket",
    value: function () {
      var _createTicket = _asyncToGenerator(/*#__PURE__*/_regeneratorRuntime().mark(function _callee10(ticketData) {
        var response;
        return _regeneratorRuntime().wrap(function _callee10$(_context10) {
          while (1) switch (_context10.prev = _context10.next) {
            case 0:
              _context10.prev = 0;
              _context10.next = 3;
              return Nova.request().post('/nova-vendor/customer-portal/tickets', ticketData);
            case 3:
              response = _context10.sent;
              return _context10.abrupt("return", response.data);
            case 7:
              _context10.prev = 7;
              _context10.t0 = _context10["catch"](0);
              console.error('Error creating ticket:', _context10.t0);
              throw _context10.t0;
            case 11:
            case "end":
              return _context10.stop();
          }
        }, _callee10, null, [[0, 7]]);
      }));
      function createTicket(_x5) {
        return _createTicket.apply(this, arguments);
      }
      return createTicket;
    }()
  }, {
    key: "addTicketResponse",
    value: function () {
      var _addTicketResponse = _asyncToGenerator(/*#__PURE__*/_regeneratorRuntime().mark(function _callee11(ticketId, responseData) {
        var response;
        return _regeneratorRuntime().wrap(function _callee11$(_context11) {
          while (1) switch (_context11.prev = _context11.next) {
            case 0:
              _context11.prev = 0;
              _context11.next = 3;
              return Nova.request().post("/nova-vendor/customer-portal/tickets/".concat(ticketId, "/responses"), responseData);
            case 3:
              response = _context11.sent;
              return _context11.abrupt("return", response.data);
            case 7:
              _context11.prev = 7;
              _context11.t0 = _context11["catch"](0);
              console.error('Error adding ticket response:', _context11.t0);
              throw _context11.t0;
            case 11:
            case "end":
              return _context11.stop();
          }
        }, _callee11, null, [[0, 7]]);
      }));
      function addTicketResponse(_x6, _x7) {
        return _addTicketResponse.apply(this, arguments);
      }
      return addTicketResponse;
    }()
  }, {
    key: "uploadTicketAttachment",
    value: function () {
      var _uploadTicketAttachment = _asyncToGenerator(/*#__PURE__*/_regeneratorRuntime().mark(function _callee12(ticketId, formData) {
        var response;
        return _regeneratorRuntime().wrap(function _callee12$(_context12) {
          while (1) switch (_context12.prev = _context12.next) {
            case 0:
              _context12.prev = 0;
              _context12.next = 3;
              return Nova.request().post("/nova-vendor/customer-portal/tickets/".concat(ticketId, "/attachments"), formData, {
                headers: {
                  'Content-Type': 'multipart/form-data'
                }
              });
            case 3:
              response = _context12.sent;
              return _context12.abrupt("return", response.data);
            case 7:
              _context12.prev = 7;
              _context12.t0 = _context12["catch"](0);
              console.error('Error uploading ticket attachment:', _context12.t0);
              throw _context12.t0;
            case 11:
            case "end":
              return _context12.stop();
          }
        }, _callee12, null, [[0, 7]]);
      }));
      function uploadTicketAttachment(_x8, _x9) {
        return _uploadTicketAttachment.apply(this, arguments);
      }
      return uploadTicketAttachment;
    }() // Profile API
  }, {
    key: "getProfile",
    value: function () {
      var _getProfile = _asyncToGenerator(/*#__PURE__*/_regeneratorRuntime().mark(function _callee13() {
        var response;
        return _regeneratorRuntime().wrap(function _callee13$(_context13) {
          while (1) switch (_context13.prev = _context13.next) {
            case 0:
              _context13.prev = 0;
              _context13.next = 3;
              return Nova.request().get('/nova-vendor/customer-portal/profile');
            case 3:
              response = _context13.sent;
              return _context13.abrupt("return", response.data);
            case 7:
              _context13.prev = 7;
              _context13.t0 = _context13["catch"](0);
              console.error('Error loading profile:', _context13.t0);
              throw _context13.t0;
            case 11:
            case "end":
              return _context13.stop();
          }
        }, _callee13, null, [[0, 7]]);
      }));
      function getProfile() {
        return _getProfile.apply(this, arguments);
      }
      return getProfile;
    }()
  }, {
    key: "updateProfile",
    value: function () {
      var _updateProfile = _asyncToGenerator(/*#__PURE__*/_regeneratorRuntime().mark(function _callee14(profileData) {
        var response;
        return _regeneratorRuntime().wrap(function _callee14$(_context14) {
          while (1) switch (_context14.prev = _context14.next) {
            case 0:
              _context14.prev = 0;
              _context14.next = 3;
              return Nova.request().put('/nova-vendor/customer-portal/profile', profileData);
            case 3:
              response = _context14.sent;
              return _context14.abrupt("return", response.data);
            case 7:
              _context14.prev = 7;
              _context14.t0 = _context14["catch"](0);
              console.error('Error updating profile:', _context14.t0);
              throw _context14.t0;
            case 11:
            case "end":
              return _context14.stop();
          }
        }, _callee14, null, [[0, 7]]);
      }));
      function updateProfile(_x0) {
        return _updateProfile.apply(this, arguments);
      }
      return updateProfile;
    }()
  }, {
    key: "changePassword",
    value: function () {
      var _changePassword = _asyncToGenerator(/*#__PURE__*/_regeneratorRuntime().mark(function _callee15(passwordData) {
        var response;
        return _regeneratorRuntime().wrap(function _callee15$(_context15) {
          while (1) switch (_context15.prev = _context15.next) {
            case 0:
              _context15.prev = 0;
              _context15.next = 3;
              return Nova.request().put('/nova-vendor/customer-portal/profile/password', passwordData);
            case 3:
              response = _context15.sent;
              return _context15.abrupt("return", response.data);
            case 7:
              _context15.prev = 7;
              _context15.t0 = _context15["catch"](0);
              console.error('Error changing password:', _context15.t0);
              throw _context15.t0;
            case 11:
            case "end":
              return _context15.stop();
          }
        }, _callee15, null, [[0, 7]]);
      }));
      function changePassword(_x1) {
        return _changePassword.apply(this, arguments);
      }
      return changePassword;
    }()
  }]);
}();

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
/******/ 			id: moduleId,
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
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
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
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/js/tool": 0,
/******/ 			"css/tool": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunkbilling_customer_portal"] = self["webpackChunkbilling_customer_portal"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/nonce */
/******/ 	(() => {
/******/ 		__webpack_require__.nc = undefined;
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["css/tool"], () => (__webpack_require__("./resources/js/tool.js")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["css/tool"], () => (__webpack_require__("./resources/css/tool.css")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;