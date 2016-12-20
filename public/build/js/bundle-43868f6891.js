(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
"use strict";

var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol ? "symbol" : typeof obj; };

/*!
 * ClockPicker v0.0.9 (http://weareoutman.github.io/clockpicker/)
 * Copyright 2014 Wang Shenwei.
 * Licensed under MIT (https://github.com/weareoutman/clockpicker/blob/gh-pages/LICENSE)
 */
!function () {
  function t(t) {
    return document.createElementNS(p, t);
  }function i(t) {
    return (10 > t ? "0" : "") + t;
  }function e(t) {
    var i = ++v + "";return t ? t + i : i;
  }function s(s, r) {
    function p(t, i) {
      var e = u.offset(),
          s = /^touch/.test(t.type),
          o = e.left + b,
          n = e.top + b,
          p = (s ? t.originalEvent.touches[0] : t).pageX - o,
          l = (s ? t.originalEvent.touches[0] : t).pageY - n,
          k = Math.sqrt(p * p + l * l),
          m = !1;if (!i || !(g - y > k || k > g + y)) {
        t.preventDefault();var v = setTimeout(function () {
          c.addClass("clockpicker-moving");
        }, 200);h && u.append(x.canvas), x.setHand(p, l, !i, !0), a.off(d).on(d, function (t) {
          t.preventDefault();var i = /^touch/.test(t.type),
              e = (i ? t.originalEvent.touches[0] : t).pageX - o,
              s = (i ? t.originalEvent.touches[0] : t).pageY - n;(m || e !== p || s !== l) && (m = !0, x.setHand(e, s, !1, !0));
        }), a.off(f).on(f, function (t) {
          a.off(f), t.preventDefault();var e = /^touch/.test(t.type),
              s = (e ? t.originalEvent.changedTouches[0] : t).pageX - o,
              h = (e ? t.originalEvent.changedTouches[0] : t).pageY - n;(i || m) && s === p && h === l && x.setHand(s, h), "hours" === x.currentView ? x.toggleView("minutes", A / 2) : r.autoclose && (x.minutesView.addClass("clockpicker-dial-out"), setTimeout(function () {
            x.done();
          }, A / 2)), u.prepend(U), clearTimeout(v), c.removeClass("clockpicker-moving"), a.off(d);
        });
      }
    }var l = n(V),
        u = l.find(".clockpicker-plate"),
        m = l.find(".clockpicker-hours"),
        v = l.find(".clockpicker-minutes"),
        T = l.find(".clockpicker-am-pm-block"),
        P = "INPUT" === s.prop("tagName"),
        C = P ? s : s.find("input"),
        H = s.find(".input-group-addon"),
        x = this;if (this.id = e("cp"), this.element = s, this.options = r, this.isAppended = !1, this.isShown = !1, this.currentView = "hours", this.isInput = P, this.input = C, this.addon = H, this.popover = l, this.plate = u, this.hoursView = m, this.minutesView = v, this.amPmBlock = T, this.spanHours = l.find(".clockpicker-span-hours"), this.spanMinutes = l.find(".clockpicker-span-minutes"), this.spanAmPm = l.find(".clockpicker-span-am-pm"), this.amOrPm = "PM", r.twelvehour) {
      {
        var S = ['<div class="clockpicker-am-pm-block">', '<button type="button" class="btn btn-sm btn-default clockpicker-button clockpicker-am-button">', "AM</button>", '<button type="button" class="btn btn-sm btn-default clockpicker-button clockpicker-pm-button">', "PM</button>", "</div>"].join("");n(S);
      }n('<button type="button" class="btn btn-sm btn-default clockpicker-button am-button">AM</button>').on("click", function () {
        x.amOrPm = "AM", n(".clockpicker-span-am-pm").empty().append("AM");
      }).appendTo(this.amPmBlock), n('<button type="button" class="btn btn-sm btn-default clockpicker-button pm-button">PM</button>').on("click", function () {
        x.amOrPm = "PM", n(".clockpicker-span-am-pm").empty().append("PM");
      }).appendTo(this.amPmBlock);
    }r.autoclose || n('<button type="button" class="btn btn-sm btn-default btn-block clockpicker-button">' + r.donetext + "</button>").click(n.proxy(this.done, this)).appendTo(l), "top" !== r.placement && "bottom" !== r.placement || "top" !== r.align && "bottom" !== r.align || (r.align = "left"), "left" !== r.placement && "right" !== r.placement || "left" !== r.align && "right" !== r.align || (r.align = "top"), l.addClass(r.placement), l.addClass("clockpicker-align-" + r.align), this.spanHours.click(n.proxy(this.toggleView, this, "hours")), this.spanMinutes.click(n.proxy(this.toggleView, this, "minutes")), C.on("focus.clockpicker click.clockpicker", n.proxy(this.show, this)), H.on("click.clockpicker", n.proxy(this.toggle, this));var E,
        D,
        I,
        B,
        O = n('<div class="clockpicker-tick"></div>');if (r.twelvehour) for (E = 1; 13 > E; E += 1) {
      D = O.clone(), I = E / 6 * Math.PI, B = g, D.css("font-size", "120%"), D.css({ left: b + Math.sin(I) * B - y, top: b - Math.cos(I) * B - y }), D.html(0 === E ? "00" : E), m.append(D), D.on(k, p);
    } else for (E = 0; 24 > E; E += 1) {
      D = O.clone(), I = E / 6 * Math.PI;var z = E > 0 && 13 > E;B = z ? w : g, D.css({ left: b + Math.sin(I) * B - y, top: b - Math.cos(I) * B - y }), z && D.css("font-size", "120%"), D.html(0 === E ? "00" : E), m.append(D), D.on(k, p);
    }for (E = 0; 60 > E; E += 5) {
      D = O.clone(), I = E / 30 * Math.PI, D.css({ left: b + Math.sin(I) * g - y, top: b - Math.cos(I) * g - y }), D.css("font-size", "120%"), D.html(i(E)), v.append(D), D.on(k, p);
    }if (u.on(k, function (t) {
      0 === n(t.target).closest(".clockpicker-tick").length && p(t, !0);
    }), h) {
      var U = l.find(".clockpicker-canvas"),
          j = t("svg");j.setAttribute("class", "clockpicker-svg"), j.setAttribute("width", M), j.setAttribute("height", M);var L = t("g");L.setAttribute("transform", "translate(" + b + "," + b + ")");var W = t("circle");W.setAttribute("class", "clockpicker-canvas-bearing"), W.setAttribute("cx", 0), W.setAttribute("cy", 0), W.setAttribute("r", 2);var N = t("line");N.setAttribute("x1", 0), N.setAttribute("y1", 0);var X = t("circle");X.setAttribute("class", "clockpicker-canvas-bg"), X.setAttribute("r", y);var Y = t("circle");Y.setAttribute("class", "clockpicker-canvas-fg"), Y.setAttribute("r", 3.5), L.appendChild(N), L.appendChild(X), L.appendChild(Y), L.appendChild(W), j.appendChild(L), U.append(j), this.hand = N, this.bg = X, this.fg = Y, this.bearing = W, this.g = L, this.canvas = U;
    }o(this.options.init);
  }function o(t) {
    t && "function" == typeof t && t();
  }var c,
      n = window.jQuery,
      r = n(window),
      a = n(document),
      p = "http://www.w3.org/2000/svg",
      h = "SVGAngle" in window && function () {
    var t,
        i = document.createElement("div");return i.innerHTML = "<svg/>", t = (i.firstChild && i.firstChild.namespaceURI) == p, i.innerHTML = "", t;
  }(),
      l = function () {
    var t = document.createElement("div").style;return "transition" in t || "WebkitTransition" in t || "MozTransition" in t || "msTransition" in t || "OTransition" in t;
  }(),
      u = "ontouchstart" in window,
      k = "mousedown" + (u ? " touchstart" : ""),
      d = "mousemove.clockpicker" + (u ? " touchmove.clockpicker" : ""),
      f = "mouseup.clockpicker" + (u ? " touchend.clockpicker" : ""),
      m = navigator.vibrate ? "vibrate" : navigator.webkitVibrate ? "webkitVibrate" : null,
      v = 0,
      b = 100,
      g = 80,
      w = 54,
      y = 13,
      M = 2 * b,
      A = l ? 350 : 1,
      V = ['<div class="popover clockpicker-popover">', '<div class="arrow"></div>', '<div class="popover-title">', '<span class="clockpicker-span-hours text-primary"></span>', " : ", '<span class="clockpicker-span-minutes"></span>', '<span class="clockpicker-span-am-pm"></span>', "</div>", '<div class="popover-content">', '<div class="clockpicker-plate">', '<div class="clockpicker-canvas"></div>', '<div class="clockpicker-dial clockpicker-hours"></div>', '<div class="clockpicker-dial clockpicker-minutes clockpicker-dial-out"></div>', "</div>", '<span class="clockpicker-am-pm-block">', "</span>", "</div>", "</div>"].join("");s.DEFAULTS = { "default": "", fromnow: 0, placement: "bottom", align: "left", donetext: "å®Œæˆ", autoclose: !1, twelvehour: !1, vibrate: !0 }, s.prototype.toggle = function () {
    this[this.isShown ? "hide" : "show"]();
  }, s.prototype.locate = function () {
    var t = this.element,
        i = this.popover,
        e = t.position(),
        s = t.outerWidth(),
        o = t.outerHeight(),
        c = this.options.placement,
        n = this.options.align,
        r = {};switch (i.show(), c) {case "bottom":
        r.top = e.top + o;break;case "right":
        r.left = e.left + s;break;case "top":
        r.top = e.top - i.outerHeight();break;case "left":
        r.left = e.left - i.outerWidth();}switch (n) {case "left":
        r.left = e.left;break;case "right":
        r.left = e.left + s - i.outerWidth();break;case "top":
        r.top = e.top;break;case "bottom":
        r.top = e.top + o - i.outerHeight();}i.css(r);
  }, s.prototype.show = function () {
    if (!this.isShown) {
      o(this.options.beforeShow);var t = this;this.isAppended || (c = t.element.offsetParent().append(this.popover), r.on("resize.clockpicker" + this.id, function () {
        t.isShown && t.locate();
      }), this.isAppended = !0);var e = ((this.input.prop("value") || this.options["default"] || "") + "").replace(/^\s\s*/, "").replace(/\s\s*$/, "");if ("now" === e) {
        var s = new Date(+new Date() + this.options.fromnow);this.hours = s.getHours(), this.minutes = s.getMinutes();
      } else {
        var p = e.toUpperCase().match(/^(\d{1,2}):(\d{1,2})\s*(AM|PM)?$/);p ? (this.hours = +p[1], this.minutes = +p[2], this.amOrPm = p[3]) : (this.hours = 0, this.minutes = 0);
      }this.spanHours.html(i(this.hours)), this.spanMinutes.html(i(this.minutes)), this.spanAmPm.html(this.amOrPm), this.toggleView("hours"), this.locate(), this.isShown = !0, a.on("click.clockpicker." + this.id + " focusin.clockpicker." + this.id, function (i) {
        var e = n(i.target);0 === e.closest(t.popover).length && 0 === e.closest(t.addon).length && 0 === e.closest(t.input).length && t.hide();
      }), a.on("keyup.clockpicker." + this.id, function (i) {
        27 === i.keyCode && t.hide();
      }), o(this.options.afterShow);
    }
  }, s.prototype.hide = function () {
    o(this.options.beforeHide), this.isShown = !1, a.off("click.clockpicker." + this.id + " focusin.clockpicker." + this.id), a.off("keyup.clockpicker." + this.id), this.popover.hide(), o(this.options.afterHide);
  }, s.prototype.toggleView = function (t, i) {
    var e = !1;"minutes" === t && "visible" === n(this.hoursView).css("visibility") && (o(this.options.beforeHourSelect), e = !0);var s = "hours" === t,
        c = s ? this.hoursView : this.minutesView,
        r = s ? this.minutesView : this.hoursView;this.currentView = t, this.spanHours.toggleClass("text-primary", s), this.spanMinutes.toggleClass("text-primary", !s), r.addClass("clockpicker-dial-out"), c.css("visibility", "visible").removeClass("clockpicker-dial-out"), this.resetClock(i), clearTimeout(this.toggleViewTimer), this.toggleViewTimer = setTimeout(function () {
      r.css("visibility", "hidden");
    }, A), e && o(this.options.afterHourSelect);
  }, s.prototype.resetClock = function (t) {
    var i = this.currentView,
        e = this[i],
        s = "hours" === i,
        o = Math.PI / (s ? 6 : 30),
        c = e * o,
        n = s && e > 0 && 13 > e ? w : g,
        r = Math.sin(c) * n,
        a = -Math.cos(c) * n,
        p = this;h && t ? (p.canvas.addClass("clockpicker-canvas-out"), setTimeout(function () {
      p.canvas.removeClass("clockpicker-canvas-out"), p.setHand(r, a);
    }, t)) : this.setHand(r, a);
  }, s.prototype.setHand = function (t, e, s, o) {
    var c,
        r = Math.atan2(t, -e),
        a = "hours" === this.currentView,
        p = Math.PI / (a || s ? 6 : 30),
        l = Math.sqrt(t * t + e * e),
        u = this.options,
        k = a && (g + w) / 2 > l,
        d = k ? w : g;if (u.twelvehour && (d = g), 0 > r && (r = 2 * Math.PI + r), c = Math.round(r / p), r = c * p, u.twelvehour ? a ? 0 === c && (c = 12) : (s && (c *= 5), 60 === c && (c = 0)) : a ? (12 === c && (c = 0), c = k ? 0 === c ? 12 : c : 0 === c ? 0 : c + 12) : (s && (c *= 5), 60 === c && (c = 0)), this[this.currentView] !== c && m && this.options.vibrate && (this.vibrateTimer || (navigator[m](10), this.vibrateTimer = setTimeout(n.proxy(function () {
      this.vibrateTimer = null;
    }, this), 100))), this[this.currentView] = c, this[a ? "spanHours" : "spanMinutes"].html(i(c)), !h) return this[a ? "hoursView" : "minutesView"].find(".clockpicker-tick").each(function () {
      var t = n(this);t.toggleClass("active", c === +t.html());
    }), void 0;o || !a && c % 5 ? (this.g.insertBefore(this.hand, this.bearing), this.g.insertBefore(this.bg, this.fg), this.bg.setAttribute("class", "clockpicker-canvas-bg clockpicker-canvas-bg-trans")) : (this.g.insertBefore(this.hand, this.bg), this.g.insertBefore(this.fg, this.bg), this.bg.setAttribute("class", "clockpicker-canvas-bg"));var f = Math.sin(r) * d,
        v = -Math.cos(r) * d;this.hand.setAttribute("x2", f), this.hand.setAttribute("y2", v), this.bg.setAttribute("cx", f), this.bg.setAttribute("cy", v), this.fg.setAttribute("cx", f), this.fg.setAttribute("cy", v);
  }, s.prototype.done = function () {
    o(this.options.beforeDone), this.hide();var t = this.input.prop("value"),
        e = i(this.hours) + ":" + i(this.minutes);this.options.twelvehour && (e += this.amOrPm), this.input.prop("value", e), e !== t && (this.input.triggerHandler("change"), this.isInput || this.element.trigger("change")), this.options.autoclose && this.input.trigger("blur"), o(this.options.afterDone);
  }, s.prototype.remove = function () {
    this.element.removeData("clockpicker"), this.input.off("focus.clockpicker click.clockpicker"), this.addon.off("click.clockpicker"), this.isShown && this.hide(), this.isAppended && (r.off("resize.clockpicker" + this.id), this.popover.remove());
  }, n.fn.clockpicker = function (t) {
    var i = Array.prototype.slice.call(arguments, 1);return this.each(function () {
      var e = n(this),
          o = e.data("clockpicker");if (o) "function" == typeof o[t] && o[t].apply(o, i);else {
        var c = n.extend({}, s.DEFAULTS, e.data(), "object" == (typeof t === "undefined" ? "undefined" : _typeof(t)) && t);e.data("clockpicker", new s(e, c));
      }
    });
  };
}();

},{}],2:[function(require,module,exports){
'use strict';

/* ===========================================================
 * bootstrap-fileupload.js j2
 * http://jasny.github.com/bootstrap/javascript.html#fileupload
 * ===========================================================
 * Copyright 2012 Jasny BV, Netherlands.
 *
 * Licensed under the Apache License, Version 2.0 (the "License")
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ========================================================== */

!function ($) {

  "use strict"; // jshint ;_

  /* FILEUPLOAD PUBLIC CLASS DEFINITION
   * ================================= */

  var Fileupload = function Fileupload(element, options) {
    this.$element = $(element);
    this.type = this.$element.data('uploadtype') || (this.$element.find('.thumbnail').length > 0 ? "image" : "file");

    this.$input = this.$element.find(':file');
    if (this.$input.length === 0) return;

    this.name = this.$input.attr('name') || options.name;

    this.$hidden = this.$element.find('input[type=hidden][name="' + this.name + '"]');
    if (this.$hidden.length === 0) {
      this.$hidden = $('<input type="hidden" />');
      this.$element.prepend(this.$hidden);
    }

    this.$preview = this.$element.find('.fileupload-preview');
    var height = this.$preview.css('height');
    if (this.$preview.css('display') != 'inline' && height != '0px' && height != 'none') this.$preview.css('line-height', height);

    this.original = {
      'exists': this.$element.hasClass('fileupload-exists'),
      'preview': this.$preview.html(),
      'hiddenVal': this.$hidden.val()
    };

    this.$remove = this.$element.find('[data-dismiss="fileupload"]');

    this.$element.find('[data-trigger="fileupload"]').on('click.fileupload', $.proxy(this.trigger, this));

    this.listen();
  };

  Fileupload.prototype = {

    listen: function listen() {
      this.$input.on('change.fileupload', $.proxy(this.change, this));
      $(this.$input[0].form).on('reset.fileupload', $.proxy(this.reset, this));
      if (this.$remove) this.$remove.on('click.fileupload', $.proxy(this.clear, this));
    },

    change: function change(e, invoked) {
      if (invoked === 'clear') return;

      var file = e.target.files !== undefined ? e.target.files[0] : e.target.value ? { name: e.target.value.replace(/^.+\\/, '') } : null;

      if (!file) {
        this.clear();
        return;
      }

      this.$hidden.val('');
      this.$hidden.attr('name', '');
      this.$input.attr('name', this.name);

      if (this.type === "image" && this.$preview.length > 0 && (typeof file.type !== "undefined" ? file.type.match('image.*') : file.name.match(/\.(gif|png|jpe?g)$/i)) && typeof FileReader !== "undefined") {
        var reader = new FileReader();
        var preview = this.$preview;
        var element = this.$element;

        reader.onload = function (e) {
          preview.html('<img src="' + e.target.result + '" ' + (preview.css('max-height') != 'none' ? 'style="max-height: ' + preview.css('max-height') + ';"' : '') + ' />');
          element.addClass('fileupload-exists').removeClass('fileupload-new');
        };

        reader.readAsDataURL(file);
      } else {
        this.$preview.text(file.name);
        this.$element.addClass('fileupload-exists').removeClass('fileupload-new');
      }
    },

    clear: function clear(e) {
      this.$hidden.val('');
      this.$hidden.attr('name', this.name);
      this.$input.attr('name', '');

      //ie8+ doesn't support changing the value of input with type=file so clone instead
      if (navigator.userAgent.match(/msie/i)) {
        var inputClone = this.$input.clone(true);
        this.$input.after(inputClone);
        this.$input.remove();
        this.$input = inputClone;
      } else {
        this.$input.val('');
      }

      this.$preview.html('');
      this.$element.addClass('fileupload-new').removeClass('fileupload-exists');

      if (e) {
        this.$input.trigger('change', ['clear']);
        e.preventDefault();
      }
    },

    reset: function reset(e) {
      this.clear();

      this.$hidden.val(this.original.hiddenVal);
      this.$preview.html(this.original.preview);

      if (this.original.exists) this.$element.addClass('fileupload-exists').removeClass('fileupload-new');else this.$element.addClass('fileupload-new').removeClass('fileupload-exists');
    },

    trigger: function trigger(e) {
      this.$input.trigger('click');
      e.preventDefault();
    }
  };

  /* FILEUPLOAD PLUGIN DEFINITION
   * =========================== */

  $.fn.fileupload = function (options) {
    return this.each(function () {
      var $this = $(this),
          data = $this.data('fileupload');
      if (!data) $this.data('fileupload', data = new Fileupload(this, options));
      if (typeof options == 'string') data[options]();
    });
  };

  $.fn.fileupload.Constructor = Fileupload;

  /* FILEUPLOAD DATA-API
   * ================== */

  $(document).on('click.fileupload.data-api', '[data-provides="fileupload"]', function (e) {
    var $this = $(this);
    if ($this.data('fileupload')) return;
    $this.fileupload($this.data());

    var $target = $(e.target).closest('[data-dismiss="fileupload"],[data-trigger="fileupload"]');
    if ($target.length > 0) {
      $target.trigger('click.fileupload');
      e.preventDefault();
    }
  });
}(window.jQuery);

},{}],3:[function(require,module,exports){
'use strict';

var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol ? "symbol" : typeof obj; };

(function ($) {
  'use strict';
  /**
   * We need an event when the elements are destroyed
   * because if an input is removed, we have to remove the
   * maxlength object associated (if any).
   * From:
   * http://stackoverflow.com/questions/2200494/jquery-trigger-event-when-an-element-is-removed-from-the-dom
   */

  if (!$.event.special.destroyed) {
    $.event.special.destroyed = {
      remove: function remove(o) {
        if (o.handler) {
          o.handler();
        }
      }
    };
  }

  $.fn.extend({
    maxlength: function maxlength(options, callback) {
      var documentBody = $('body'),
          defaults = {
        showOnReady: false, // true to always show when indicator is ready
        alwaysShow: false, // if true the indicator it's always shown.
        threshold: 10, // Represents how many chars left are needed to show up the counter
        warningClass: 'label label-success',
        limitReachedClass: 'label label-important label-danger',
        separator: ' / ',
        preText: '',
        postText: '',
        showMaxLength: true,
        placement: 'bottom',
        message: null, // an alternative way to provide the message text
        showCharsTyped: true, // show the number of characters typed and not the number of characters remaining
        validate: false, // if the browser doesn't support the maxlength attribute, attempt to type more than
        // the indicated chars, will be prevented.
        utf8: false, // counts using bytesize rather than length. eg: 'Â£' is counted as 2 characters.
        appendToParent: false, // append the indicator to the input field's parent instead of body
        twoCharLinebreak: true, // count linebreak as 2 characters to match IE/Chrome textarea validation. As well as DB storage.
        customMaxAttribute: null, // null = use maxlength attribute and browser functionality, string = use specified attribute instead.
        allowOverMax: false
        // Form submit validation is handled on your own.  when maxlength has been exceeded 'overmax' class added to element
      };

      if ($.isFunction(options) && !callback) {
        callback = options;
        options = {};
      }
      options = $.extend(defaults, options);

      /**
      * Return the length of the specified input.
      *
      * @param input
      * @return {number}
      */
      function inputLength(input) {
        var text = input.val();

        if (options.twoCharLinebreak) {
          // Count all line breaks as 2 characters
          text = text.replace(/\r(?!\n)|\n(?!\r)/g, '\r\n');
        } else {
          // Remove all double-character (\r\n) linebreaks, so they're counted only once.
          text = text.replace(new RegExp('\r?\n', 'g'), '\n');
        }

        var currentLength = 0;

        if (options.utf8) {
          currentLength = utf8Length(text);
        } else {
          currentLength = text.length;
        }
        return currentLength;
      }

      /**
      * Truncate the text of the specified input.
      *
      * @param input
      * @param limit
      */
      function truncateChars(input, maxlength) {
        var text = input.val();
        var newlines = 0;

        if (options.twoCharLinebreak) {
          text = text.replace(/\r(?!\n)|\n(?!\r)/g, '\r\n');

          if (text.substr(text.length - 1) === '\n' && text.length % 2 === 1) {
            newlines = 1;
          }
        }

        input.val(text.substr(0, maxlength - newlines));
      }

      /**
      * Return the length of the specified input in UTF8 encoding.
      *
      * @param input
      * @return {number}
      */
      function utf8Length(string) {
        var utf8length = 0;
        for (var n = 0; n < string.length; n++) {
          var c = string.charCodeAt(n);
          if (c < 128) {
            utf8length++;
          } else if (c > 127 && c < 2048) {
            utf8length = utf8length + 2;
          } else {
            utf8length = utf8length + 3;
          }
        }
        return utf8length;
      }

      /**
       * Return true if the indicator should be showing up.
       *
       * @param input
       * @param thereshold
       * @param maxlength
       * @return {number}
       */
      function charsLeftThreshold(input, thereshold, maxlength) {
        var output = true;
        if (!options.alwaysShow && maxlength - inputLength(input) > thereshold) {
          output = false;
        }
        return output;
      }

      /**
       * Returns how many chars are left to complete the fill up of the form.
       *
       * @param input
       * @param maxlength
       * @return {number}
       */
      function remainingChars(input, maxlength) {
        var length = maxlength - inputLength(input);
        return length;
      }

      /**
       * When called displays the indicator.
       *
       * @param indicator
       */
      function showRemaining(currentInput, indicator) {
        indicator.css({
          display: 'block'
        });
        currentInput.trigger('maxlength.shown');
      }

      /**
       * When called shows the indicator.
       *
       * @param indicator
       */
      function hideRemaining(currentInput, indicator) {

        if (options.alwaysShow) {
          return;
        }

        indicator.css({
          display: 'none'
        });
        currentInput.trigger('maxlength.hidden');
      }

      /**
      * This function updates the value in the indicator
      *
      * @param maxLengthThisInput
      * @param typedChars
      * @return String
      */
      function updateMaxLengthHTML(currentInputText, maxLengthThisInput, typedChars) {
        var output = '';
        if (options.message) {
          if (typeof options.message === 'function') {
            output = options.message(currentInputText, maxLengthThisInput);
          } else {
            output = options.message.replace('%charsTyped%', typedChars).replace('%charsRemaining%', maxLengthThisInput - typedChars).replace('%charsTotal%', maxLengthThisInput);
          }
        } else {
          if (options.preText) {
            output += options.preText;
          }
          if (!options.showCharsTyped) {
            output += maxLengthThisInput - typedChars;
          } else {
            output += typedChars;
          }
          if (options.showMaxLength) {
            output += options.separator + maxLengthThisInput;
          }
          if (options.postText) {
            output += options.postText;
          }
        }
        return output;
      }

      /**
       * This function updates the value of the counter in the indicator.
       * Wants as parameters: the number of remaining chars, the element currently managed,
       * the maxLength for the current input and the indicator generated for it.
       *
       * @param remaining
       * @param currentInput
       * @param maxLengthCurrentInput
       * @param maxLengthIndicator
       */
      function manageRemainingVisibility(remaining, currentInput, maxLengthCurrentInput, maxLengthIndicator) {
        if (maxLengthIndicator) {
          maxLengthIndicator.html(updateMaxLengthHTML(currentInput.val(), maxLengthCurrentInput, maxLengthCurrentInput - remaining));

          if (remaining > 0) {
            if (charsLeftThreshold(currentInput, options.threshold, maxLengthCurrentInput)) {
              showRemaining(currentInput, maxLengthIndicator.removeClass(options.limitReachedClass).addClass(options.warningClass));
            } else {
              hideRemaining(currentInput, maxLengthIndicator);
            }
          } else {
            showRemaining(currentInput, maxLengthIndicator.removeClass(options.warningClass).addClass(options.limitReachedClass));
          }
        }

        if (options.customMaxAttribute) {
          // class to use for form validation on custom maxlength attribute
          if (remaining < 0) {
            currentInput.addClass('overmax');
          } else {
            currentInput.removeClass('overmax');
          }
        }
      }

      /**
       * This function returns an object containing all the
       * informations about the position of the current input
       *
       * @param currentInput
       * @return object {bottom height left right top width}
       *
       */
      function getPosition(currentInput) {
        var el = currentInput[0];
        return $.extend({}, typeof el.getBoundingClientRect === 'function' ? el.getBoundingClientRect() : {
          width: el.offsetWidth,
          height: el.offsetHeight
        }, currentInput.offset());
      }

      /**
       * This function places the maxLengthIndicator at the
       * top / bottom / left / right of the currentInput
       *
       * @param currentInput
       * @param maxLengthIndicator
       * @return null
       *
       */
      function place(currentInput, maxLengthIndicator) {
        var pos = getPosition(currentInput);

        // Supports custom placement handler
        if ($.type(options.placement) === 'function') {
          options.placement(currentInput, maxLengthIndicator, pos);
          return;
        }

        // Supports custom placement via css positional properties
        if ($.isPlainObject(options.placement)) {
          placeWithCSS(options.placement, maxLengthIndicator);
          return;
        }

        var inputOuter = currentInput.outerWidth(),
            outerWidth = maxLengthIndicator.outerWidth(),
            actualWidth = maxLengthIndicator.width(),
            actualHeight = maxLengthIndicator.height();

        // get the right position if the indicator is appended to the input's parent
        if (options.appendToParent) {
          pos.top -= currentInput.parent().offset().top;
          pos.left -= currentInput.parent().offset().left;
        }

        switch (options.placement) {
          case 'bottom':
            maxLengthIndicator.css({ top: pos.top + pos.height, left: pos.left + pos.width / 2 - actualWidth / 2 });
            break;
          case 'top':
            maxLengthIndicator.css({ top: pos.top - actualHeight, left: pos.left + pos.width / 2 - actualWidth / 2 });
            break;
          case 'left':
            maxLengthIndicator.css({ top: pos.top + pos.height / 2 - actualHeight / 2, left: pos.left - actualWidth });
            break;
          case 'right':
            maxLengthIndicator.css({ top: pos.top + pos.height / 2 - actualHeight / 2, left: pos.left + pos.width });
            break;
          case 'bottom-right':
            maxLengthIndicator.css({ top: pos.top + pos.height, left: pos.left + pos.width });
            break;
          case 'top-right':
            maxLengthIndicator.css({ top: pos.top - actualHeight, left: pos.left + inputOuter });
            break;
          case 'top-left':
            maxLengthIndicator.css({ top: pos.top - actualHeight, left: pos.left - outerWidth });
            break;
          case 'bottom-left':
            maxLengthIndicator.css({ top: pos.top + currentInput.outerHeight(), left: pos.left - outerWidth });
            break;
          case 'centered-right':
            maxLengthIndicator.css({ top: pos.top + actualHeight / 2, left: pos.left + inputOuter - outerWidth - 3 });
            break;

          // Some more options for placements
          case 'bottom-right-inside':
            maxLengthIndicator.css({ top: pos.top + pos.height, left: pos.left + pos.width - outerWidth });
            break;
          case 'top-right-inside':
            maxLengthIndicator.css({ top: pos.top - actualHeight, left: pos.left + inputOuter - outerWidth });
            break;
          case 'top-left-inside':
            maxLengthIndicator.css({ top: pos.top - actualHeight, left: pos.left });
            break;
          case 'bottom-left-inside':
            maxLengthIndicator.css({ top: pos.top + currentInput.outerHeight(), left: pos.left });
            break;
        }
      }

      /**
       * This function places the maxLengthIndicator based on placement config object.
       *
       * @param {object} placement
       * @param {$} maxLengthIndicator
       * @return null
       *
       */
      function placeWithCSS(placement, maxLengthIndicator) {
        if (!placement || !maxLengthIndicator) {
          return;
        }

        var POSITION_KEYS = ['top', 'bottom', 'left', 'right', 'position'];

        var cssPos = {};

        // filter css properties to position
        $.each(POSITION_KEYS, function (i, key) {
          var val = options.placement[key];
          if (typeof val !== 'undefined') {
            cssPos[key] = val;
          }
        });

        maxLengthIndicator.css(cssPos);

        return;
      }

      /**
       * This function returns true if the indicator position needs to
       * be recalculated when the currentInput changes
       *
       * @return {boolean}
       *
       */
      function isPlacementMutable() {
        return options.placement === 'bottom-right-inside' || options.placement === 'top-right-inside' || typeof options.placement === 'function' || options.message && typeof options.message === 'function';
      }

      /**
       * This function retrieves the maximum length of currentInput
       *
       * @param currentInput
       * @return {number}
       *
       */
      function getMaxLength(currentInput) {
        var max = currentInput.attr('maxlength') || options.customMaxAttribute;

        if (options.customMaxAttribute && !options.allowOverMax) {
          var custom = currentInput.attr(options.customMaxAttribute);
          if (!max || custom < max) {
            max = custom;
          }
        }

        if (!max) {
          max = currentInput.attr('size');
        }
        return max;
      }

      return this.each(function () {

        var currentInput = $(this),
            maxLengthCurrentInput,
            maxLengthIndicator;

        $(window).resize(function () {
          if (maxLengthIndicator) {
            place(currentInput, maxLengthIndicator);
          }
        });

        function firstInit() {
          var maxlengthContent = updateMaxLengthHTML(currentInput.val(), maxLengthCurrentInput, '0');
          maxLengthCurrentInput = getMaxLength(currentInput);

          if (!maxLengthIndicator) {
            maxLengthIndicator = $('<span class="bootstrap-maxlength"></span>').css({
              display: 'none',
              position: 'absolute',
              whiteSpace: 'nowrap',
              zIndex: 1099
            }).html(maxlengthContent);
          }

          // We need to detect resizes if we are dealing with a textarea:
          if (currentInput.is('textarea')) {
            currentInput.data('maxlenghtsizex', currentInput.outerWidth());
            currentInput.data('maxlenghtsizey', currentInput.outerHeight());

            currentInput.mouseup(function () {
              if (currentInput.outerWidth() !== currentInput.data('maxlenghtsizex') || currentInput.outerHeight() !== currentInput.data('maxlenghtsizey')) {
                place(currentInput, maxLengthIndicator);
              }

              currentInput.data('maxlenghtsizex', currentInput.outerWidth());
              currentInput.data('maxlenghtsizey', currentInput.outerHeight());
            });
          }

          if (options.appendToParent) {
            currentInput.parent().append(maxLengthIndicator);
            currentInput.parent().css('position', 'relative');
          } else {
            documentBody.append(maxLengthIndicator);
          }

          var remaining = remainingChars(currentInput, getMaxLength(currentInput));
          manageRemainingVisibility(remaining, currentInput, maxLengthCurrentInput, maxLengthIndicator);
          place(currentInput, maxLengthIndicator);
        }

        if (options.showOnReady) {
          currentInput.ready(function () {
            firstInit();
          });
        } else {
          currentInput.focus(function () {
            firstInit();
          });
        }

        currentInput.on('maxlength.reposition', function () {
          place(currentInput, maxLengthIndicator);
        });

        currentInput.on('destroyed', function () {
          if (maxLengthIndicator) {
            maxLengthIndicator.remove();
          }
        });

        currentInput.on('blur', function () {
          if (maxLengthIndicator && !options.showOnReady && !options.alwaysShow) {
            maxLengthIndicator.remove();
          }
        });

        currentInput.on('input', function () {
          var maxlength = getMaxLength(currentInput),
              remaining = remainingChars(currentInput, maxlength),
              output = true;

          if (options.validate && remaining < 0) {
            truncateChars(currentInput, maxlength);
            output = false;
          } else {
            manageRemainingVisibility(remaining, currentInput, maxLengthCurrentInput, maxLengthIndicator);
          }

          if (isPlacementMutable()) {
            place(currentInput, maxLengthIndicator);
          }

          return output;
        });
      });
    }
  });
})(jQuery);

/**
 * @author zhixin wen <wenzhixin2010@gmail.com>
 * https://github.com/wenzhixin/bootstrap-show-password
 * version: 1.0.2
 */
!function (t) {
  "use strict";
  var e = function e(t) {
    var e = arguments,
        s = !0,
        i = 1;return t = t.replace(/%s/g, function () {
      var t = e[i++];return "undefined" == typeof t ? (s = !1, "") : t;
    }), s ? t : "";
  },
      s = function s(e, _s) {
    this.options = _s, this.$element = t(e), this.isShown = !1, this.init();
  };s.DEFAULTS = { placement: "after", white: !1, message: "Click here to show/hide password" }, s.prototype.init = function () {
    var s, i;"before" === this.options.placement ? (s = "insertBefore", i = "input-prepend") : (this.options.placement = "after", s = "insertAfter", i = "input-append"), this.$element.wrap(e('<div class="%s input-group" />', i)), this.$text = t('<input type="text" />')[s](this.$element).attr("class", this.$element.attr("class")).attr("placeholder", this.$element.attr("placeholder")).css("display", this.$element.css("display")).val(this.$element.val()).hide(), this.$icon = t(['<span tabindex="100" title="' + this.options.message + '" class="add-on input-group-addon">', '<i class="icon-eye-open' + (this.options.white ? " icon-white" : "") + ' glyphicon glyphicon-eye-open"></i>', "</span>"].join(""))[s](this.$text).css("cursor", "pointer"), this.$text.off("keyup").on("keyup", t.proxy(function () {
      this.$element.val(this.$text.val());
    }, this)), this.$icon.off("click").on("click", t.proxy(function () {
      this.$text.val(this.$element.val()), this.toggle();
    }, this));
  }, s.prototype.toggle = function (t) {
    this[this.isShown ? "hide" : "show"](t);
  }, s.prototype.show = function (e) {
    var s = t.Event("show.bs.password", { relatedTarget: e });this.$element.trigger(s), this.isShown = !0, this.$element.hide(), this.$text.show(), this.$icon.find("i").removeClass("icon-eye-open glyphicon-eye-open").addClass("icon-eye-close glyphicon-eye-close"), this.$text[this.options.placement](this.$element);
  }, s.prototype.hide = function (e) {
    var s = t.Event("hide.bs.password", { relatedTarget: e });this.$element.trigger(s), this.isShown = !1, this.$element.show(), this.$text.hide(), this.$icon.find("i").removeClass("icon-eye-close glyphicon-eye-close").addClass("icon-eye-open glyphicon-eye-open"), this.$element[this.options.placement](this.$text);
  }, s.prototype.val = function (t) {
    return "undefined" == typeof t ? this.$element.val() : (this.$element.val(t), void this.$text.val(t));
  };var i = t.fn.password;t.fn.password = function () {
    var e,
        i = arguments[0],
        n = arguments,
        o = ["show", "hide", "toggle", "val"];return this.each(function () {
      var a = t(this),
          h = a.data("bs.password"),
          r = t.extend({}, s.DEFAULTS, a.data(), "object" == (typeof i === 'undefined' ? 'undefined' : _typeof(i)) && i);if ("string" == typeof i) {
        if (t.inArray(i, o) < 0) throw "Unknown method: " + i;e = h[i](n[1]);
      } else h ? h.init(r) : (h = new s(a, r), a.data("bs.password", h));
    }), e ? e : this;
  }, t.fn.password.Constructor = s, t.fn.password.noConflict = function () {
    return t.fn.password = i, this;
  }, t(function () {
    t('[data-toggle="password"]').password();
  });
}(window.jQuery);

},{}],4:[function(require,module,exports){
'use strict';var _typeof=typeof Symbol==="function"&&typeof Symbol.iterator==="symbol"?function(obj){return typeof obj;}:function(obj){return obj&&typeof Symbol==="function"&&obj.constructor===Symbol?"symbol":typeof obj;};/**
 * @author zhixin wen <wenzhixin2010@gmail.com>
 * version: 1.10.0
 * https://github.com/wenzhixin/bootstrap-table/
 */!function($){'use strict';// TOOLS DEFINITION
// ======================
var cachedWidth=null;// it only does '%s', and return '' when arguments are undefined
var sprintf=function sprintf(str){var args=arguments,flag=true,i=1;str=str.replace(/%s/g,function(){var arg=args[i++];if(typeof arg==='undefined'){flag=false;return'';}return arg;});return flag?str:'';};var getPropertyFromOther=function getPropertyFromOther(list,from,to,value){var result='';$.each(list,function(i,item){if(item[from]===value){result=item[to];return false;}return true;});return result;};var getFieldIndex=function getFieldIndex(columns,field){var index=-1;$.each(columns,function(i,column){if(column.field===field){index=i;return false;}return true;});return index;};// http://jsfiddle.net/wenyi/47nz7ez9/3/
var setFieldIndex=function setFieldIndex(columns){var i,j,k,totalCol=0,flag=[];for(i=0;i<columns[0].length;i++){totalCol+=columns[0][i].colspan||1;}for(i=0;i<columns.length;i++){flag[i]=[];for(j=0;j<totalCol;j++){flag[i][j]=false;}}for(i=0;i<columns.length;i++){for(j=0;j<columns[i].length;j++){var r=columns[i][j],rowspan=r.rowspan||1,colspan=r.colspan||1,index=$.inArray(false,flag[i]);if(colspan===1){r.fieldIndex=index;// when field is undefined, use index instead
if(typeof r.field==='undefined'){r.field=index;}}for(k=0;k<rowspan;k++){flag[i+k][index]=true;}for(k=0;k<colspan;k++){flag[i][index+k]=true;}}}};var getScrollBarWidth=function getScrollBarWidth(){if(cachedWidth===null){var inner=$('<p/>').addClass('fixed-table-scroll-inner'),outer=$('<div/>').addClass('fixed-table-scroll-outer'),w1,w2;outer.append(inner);$('body').append(outer);w1=inner[0].offsetWidth;outer.css('overflow','scroll');w2=inner[0].offsetWidth;if(w1===w2){w2=outer[0].clientWidth;}outer.remove();cachedWidth=w1-w2;}return cachedWidth;};var calculateObjectValue=function calculateObjectValue(self,name,args,defaultValue){var func=name;if(typeof name==='string'){// support obj.func1.func2
var names=name.split('.');if(names.length>1){func=window;$.each(names,function(i,f){func=func[f];});}else{func=window[name];}}if((typeof func==='undefined'?'undefined':_typeof(func))==='object'){return func;}if(typeof func==='function'){return func.apply(self,args);}if(!func&&typeof name==='string'&&sprintf.apply(this,[name].concat(args))){return sprintf.apply(this,[name].concat(args));}return defaultValue;};var compareObjects=function compareObjects(objectA,objectB,compareLength){// Create arrays of property names
var objectAProperties=Object.getOwnPropertyNames(objectA),objectBProperties=Object.getOwnPropertyNames(objectB),propName='';if(compareLength){// If number of properties is different, objects are not equivalent
if(objectAProperties.length!==objectBProperties.length){return false;}}for(var i=0;i<objectAProperties.length;i++){propName=objectAProperties[i];// If the property is not in the object B properties, continue with the next property
if($.inArray(propName,objectBProperties)>-1){// If values of same property are not equal, objects are not equivalent
if(objectA[propName]!==objectB[propName]){return false;}}}// If we made it this far, objects are considered equivalent
return true;};var escapeHTML=function escapeHTML(text){if(typeof text==='string'){return text.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;').replace(/'/g,'&#039;').replace(/`/g,'&#x60;');}return text;};var getRealHeight=function getRealHeight($el){var height=0;$el.children().each(function(){if(height<$(this).outerHeight(true)){height=$(this).outerHeight(true);}});return height;};var getRealDataAttr=function getRealDataAttr(dataAttr){for(var attr in dataAttr){var auxAttr=attr.split(/(?=[A-Z])/).join('-').toLowerCase();if(auxAttr!==attr){dataAttr[auxAttr]=dataAttr[attr];delete dataAttr[attr];}}return dataAttr;};var getItemField=function getItemField(item,field,escape){var value=item;if(typeof field!=='string'||item.hasOwnProperty(field)){return escape?escapeHTML(item[field]):item[field];}var props=field.split('.');for(var p in props){value=value&&value[props[p]];}return escape?escapeHTML(value):value;};var isIEBrowser=function isIEBrowser(){return!!(navigator.userAgent.indexOf("MSIE ")>0||!!navigator.userAgent.match(/Trident.*rv\:11\./));};// BOOTSTRAP TABLE CLASS DEFINITION
// ======================
var BootstrapTable=function BootstrapTable(el,options){this.options=options;this.$el=$(el);this.$el_=this.$el.clone();this.timeoutId_=0;this.timeoutFooter_=0;this.init();};BootstrapTable.DEFAULTS={classes:'table',locale:undefined,height:undefined,undefinedText:'-',sortName:undefined,sortOrder:'asc',striped:false,columns:[[]],data:[],dataField:'rows',method:'get',url:undefined,ajax:undefined,cache:true,contentType:'application/json',dataType:'json',ajaxOptions:{},queryParams:function queryParams(params){return params;},queryParamsType:'limit',// undefined
responseHandler:function responseHandler(res){return res;},pagination:false,onlyInfoPagination:false,sidePagination:'client',// client or server
totalRows:0,// server side need to set
pageNumber:1,pageSize:10,pageList:[10,25,50,100],paginationHAlign:'right',//right, left
paginationVAlign:'bottom',//bottom, top, both
paginationDetailHAlign:'left',//right, left
paginationPreText:'&lsaquo;',paginationNextText:'&rsaquo;',search:false,searchOnEnterKey:false,strictSearch:false,searchAlign:'right',selectItemName:'btSelectItem',showHeader:true,showFooter:false,showColumns:false,showPaginationSwitch:false,showRefresh:false,showToggle:false,buttonsAlign:'right',smartDisplay:true,escape:false,minimumCountColumns:1,idField:undefined,uniqueId:undefined,cardView:false,detailView:false,detailFormatter:function detailFormatter(index,row){return'';},trimOnSearch:true,clickToSelect:false,singleSelect:false,toolbar:undefined,toolbarAlign:'left',checkboxHeader:true,sortable:true,silentSort:true,maintainSelected:false,searchTimeOut:500,searchText:'',iconSize:undefined,iconsPrefix:'glyphicon',// glyphicon of fa (font awesome)
icons:{paginationSwitchDown:'glyphicon-collapse-down icon-chevron-down',paginationSwitchUp:'glyphicon-collapse-up icon-chevron-up',refresh:'glyphicon-refresh icon-refresh',toggle:'glyphicon-list-alt icon-list-alt',columns:'glyphicon-th icon-th',detailOpen:'glyphicon-plus icon-plus',detailClose:'glyphicon-minus icon-minus'},rowStyle:function rowStyle(row,index){return{};},rowAttributes:function rowAttributes(row,index){return{};},onAll:function onAll(name,args){return false;},onClickCell:function onClickCell(field,value,row,$element){return false;},onDblClickCell:function onDblClickCell(field,value,row,$element){return false;},onClickRow:function onClickRow(item,$element){return false;},onDblClickRow:function onDblClickRow(item,$element){return false;},onSort:function onSort(name,order){return false;},onCheck:function onCheck(row){return false;},onUncheck:function onUncheck(row){return false;},onCheckAll:function onCheckAll(rows){return false;},onUncheckAll:function onUncheckAll(rows){return false;},onCheckSome:function onCheckSome(rows){return false;},onUncheckSome:function onUncheckSome(rows){return false;},onLoadSuccess:function onLoadSuccess(data){return false;},onLoadError:function onLoadError(status){return false;},onColumnSwitch:function onColumnSwitch(field,checked){return false;},onPageChange:function onPageChange(number,size){return false;},onSearch:function onSearch(text){return false;},onToggle:function onToggle(cardView){return false;},onPreBody:function onPreBody(data){return false;},onPostBody:function onPostBody(){return false;},onPostHeader:function onPostHeader(){return false;},onExpandRow:function onExpandRow(index,row,$detail){return false;},onCollapseRow:function onCollapseRow(index,row){return false;},onRefreshOptions:function onRefreshOptions(options){return false;},onResetView:function onResetView(){return false;}};BootstrapTable.LOCALES=[];BootstrapTable.LOCALES['en-US']=BootstrapTable.LOCALES['en']={formatLoadingMessage:function formatLoadingMessage(){return'Loading, please wait...';},formatRecordsPerPage:function formatRecordsPerPage(pageNumber){return sprintf('%s records per page',pageNumber);},formatShowingRows:function formatShowingRows(pageFrom,pageTo,totalRows){return sprintf('Showing %s to %s of %s rows',pageFrom,pageTo,totalRows);},formatDetailPagination:function formatDetailPagination(totalRows){return sprintf('Showing %s rows',totalRows);},formatSearch:function formatSearch(){return'Search';},formatNoMatches:function formatNoMatches(){return'No matching records found';},formatPaginationSwitch:function formatPaginationSwitch(){return'Hide/Show pagination';},formatRefresh:function formatRefresh(){return'Refresh';},formatToggle:function formatToggle(){return'Toggle';},formatColumns:function formatColumns(){return'Columns';},formatAllRows:function formatAllRows(){return'All';}};$.extend(BootstrapTable.DEFAULTS,BootstrapTable.LOCALES['en-US']);BootstrapTable.COLUMN_DEFAULTS={radio:false,checkbox:false,checkboxEnabled:true,field:undefined,title:undefined,titleTooltip:undefined,'class':undefined,align:undefined,// left, right, center
halign:undefined,// left, right, center
falign:undefined,// left, right, center
valign:undefined,// top, middle, bottom
width:undefined,sortable:false,order:'asc',// asc, desc
visible:true,switchable:true,clickToSelect:true,formatter:undefined,footerFormatter:undefined,events:undefined,sorter:undefined,sortName:undefined,cellStyle:undefined,searchable:true,searchFormatter:true,cardVisible:true};BootstrapTable.EVENTS={'all.bs.table':'onAll','click-cell.bs.table':'onClickCell','dbl-click-cell.bs.table':'onDblClickCell','click-row.bs.table':'onClickRow','dbl-click-row.bs.table':'onDblClickRow','sort.bs.table':'onSort','check.bs.table':'onCheck','uncheck.bs.table':'onUncheck','check-all.bs.table':'onCheckAll','uncheck-all.bs.table':'onUncheckAll','check-some.bs.table':'onCheckSome','uncheck-some.bs.table':'onUncheckSome','load-success.bs.table':'onLoadSuccess','load-error.bs.table':'onLoadError','column-switch.bs.table':'onColumnSwitch','page-change.bs.table':'onPageChange','search.bs.table':'onSearch','toggle.bs.table':'onToggle','pre-body.bs.table':'onPreBody','post-body.bs.table':'onPostBody','post-header.bs.table':'onPostHeader','expand-row.bs.table':'onExpandRow','collapse-row.bs.table':'onCollapseRow','refresh-options.bs.table':'onRefreshOptions','reset-view.bs.table':'onResetView'};BootstrapTable.prototype.init=function(){this.initLocale();this.initContainer();this.initTable();this.initHeader();this.initData();this.initFooter();this.initToolbar();this.initPagination();this.initBody();this.initSearchText();this.initServer();};BootstrapTable.prototype.initLocale=function(){if(this.options.locale){var parts=this.options.locale.split(/-|_/);parts[0].toLowerCase();parts[1]&&parts[1].toUpperCase();if($.fn.bootstrapTable.locales[this.options.locale]){// locale as requested
$.extend(this.options,$.fn.bootstrapTable.locales[this.options.locale]);}else if($.fn.bootstrapTable.locales[parts.join('-')]){// locale with sep set to - (in case original was specified with _)
$.extend(this.options,$.fn.bootstrapTable.locales[parts.join('-')]);}else if($.fn.bootstrapTable.locales[parts[0]]){// short locale language code (i.e. 'en')
$.extend(this.options,$.fn.bootstrapTable.locales[parts[0]]);}}};BootstrapTable.prototype.initContainer=function(){this.$container=$(['<div class="bootstrap-table">','<div class="fixed-table-toolbar"></div>',this.options.paginationVAlign==='top'||this.options.paginationVAlign==='both'?'<div class="fixed-table-pagination" style="clear: both;"></div>':'','<div class="fixed-table-container">','<div class="fixed-table-header"><table></table></div>','<div class="fixed-table-body">','<div class="fixed-table-loading">',this.options.formatLoadingMessage(),'</div>','</div>','<div class="fixed-table-footer"><table><tr></tr></table></div>',this.options.paginationVAlign==='bottom'||this.options.paginationVAlign==='both'?'<div class="fixed-table-pagination"></div>':'','</div>','</div>'].join(''));this.$container.insertAfter(this.$el);this.$tableContainer=this.$container.find('.fixed-table-container');this.$tableHeader=this.$container.find('.fixed-table-header');this.$tableBody=this.$container.find('.fixed-table-body');this.$tableLoading=this.$container.find('.fixed-table-loading');this.$tableFooter=this.$container.find('.fixed-table-footer');this.$toolbar=this.$container.find('.fixed-table-toolbar');this.$pagination=this.$container.find('.fixed-table-pagination');this.$tableBody.append(this.$el);this.$container.after('<div class="clearfix"></div>');this.$el.addClass(this.options.classes);if(this.options.striped){this.$el.addClass('table-striped');}if($.inArray('table-no-bordered',this.options.classes.split(' '))!==-1){this.$tableContainer.addClass('table-no-bordered');}};BootstrapTable.prototype.initTable=function(){var that=this,columns=[],data=[];this.$header=this.$el.find('>thead');if(!this.$header.length){this.$header=$('<thead></thead>').appendTo(this.$el);}this.$header.find('tr').each(function(){var column=[];$(this).find('th').each(function(){column.push($.extend({},{title:$(this).html(),'class':$(this).attr('class'),titleTooltip:$(this).attr('title'),rowspan:$(this).attr('rowspan')?+$(this).attr('rowspan'):undefined,colspan:$(this).attr('colspan')?+$(this).attr('colspan'):undefined},$(this).data()));});columns.push(column);});if(!$.isArray(this.options.columns[0])){this.options.columns=[this.options.columns];}this.options.columns=$.extend(true,[],columns,this.options.columns);this.columns=[];setFieldIndex(this.options.columns);$.each(this.options.columns,function(i,columns){$.each(columns,function(j,column){column=$.extend({},BootstrapTable.COLUMN_DEFAULTS,column);if(typeof column.fieldIndex!=='undefined'){that.columns[column.fieldIndex]=column;}that.options.columns[i][j]=column;});});// if options.data is setting, do not process tbody data
if(this.options.data.length){return;}this.$el.find('>tbody>tr').each(function(){var row={};// save tr's id, class and data-* attributes
row._id=$(this).attr('id');row._class=$(this).attr('class');row._data=getRealDataAttr($(this).data());$(this).find('td').each(function(i){var field=that.columns[i].field;row[field]=$(this).html();// save td's id, class and data-* attributes
row['_'+field+'_id']=$(this).attr('id');row['_'+field+'_class']=$(this).attr('class');row['_'+field+'_rowspan']=$(this).attr('rowspan');row['_'+field+'_title']=$(this).attr('title');row['_'+field+'_data']=getRealDataAttr($(this).data());});data.push(row);});this.options.data=data;};BootstrapTable.prototype.initHeader=function(){var that=this,visibleColumns={},html=[];this.header={fields:[],styles:[],classes:[],formatters:[],events:[],sorters:[],sortNames:[],cellStyles:[],searchables:[]};$.each(this.options.columns,function(i,columns){html.push('<tr>');if(i==0&&!that.options.cardView&&that.options.detailView){html.push(sprintf('<th class="detail" rowspan="%s"><div class="fht-cell"></div></th>',that.options.columns.length));}$.each(columns,function(j,column){var text='',halign='',// header align style
align='',// body align style
style='',class_=sprintf(' class="%s"',column['class']),order=that.options.sortOrder||column.order,unitWidth='px',width=column.width;if(column.width!==undefined&&!that.options.cardView){if(typeof column.width==='string'){if(column.width.indexOf('%')!==-1){unitWidth='%';}}}if(column.width&&typeof column.width==='string'){width=column.width.replace('%','').replace('px','');}halign=sprintf('text-align: %s; ',column.halign?column.halign:column.align);align=sprintf('text-align: %s; ',column.align);style=sprintf('vertical-align: %s; ',column.valign);style+=sprintf('width: %s; ',(column.checkbox||column.radio)&&!width?'36px':width?width+unitWidth:undefined);if(typeof column.fieldIndex!=='undefined'){that.header.fields[column.fieldIndex]=column.field;that.header.styles[column.fieldIndex]=align+style;that.header.classes[column.fieldIndex]=class_;that.header.formatters[column.fieldIndex]=column.formatter;that.header.events[column.fieldIndex]=column.events;that.header.sorters[column.fieldIndex]=column.sorter;that.header.sortNames[column.fieldIndex]=column.sortName;that.header.cellStyles[column.fieldIndex]=column.cellStyle;that.header.searchables[column.fieldIndex]=column.searchable;if(!column.visible){return;}if(that.options.cardView&&!column.cardVisible){return;}visibleColumns[column.field]=column;}html.push('<th'+sprintf(' title="%s"',column.titleTooltip),column.checkbox||column.radio?sprintf(' class="bs-checkbox %s"',column['class']||''):class_,sprintf(' style="%s"',halign+style),sprintf(' rowspan="%s"',column.rowspan),sprintf(' colspan="%s"',column.colspan),sprintf(' data-field="%s"',column.field),"tabindex='0'",'>');html.push(sprintf('<div class="th-inner %s">',that.options.sortable&&column.sortable?'sortable both':''));text=column.title;if(column.checkbox){if(!that.options.singleSelect&&that.options.checkboxHeader){text='<div class="checkbox checkbox-only"><input id="datatable-chekbox-select-all" name="btSelectAll" type="checkbox" /><label for="datatable-chekbox-select-all"></label></div>';}that.header.stateField=column.field;}if(column.radio){text='';that.header.stateField=column.field;that.options.singleSelect=true;}html.push(text);html.push('</div>');html.push('<div class="fht-cell"></div>');html.push('</div>');html.push('</th>');});html.push('</tr>');});this.$header.html(html.join(''));this.$header.find('th[data-field]').each(function(i){$(this).data(visibleColumns[$(this).data('field')]);});this.$container.off('click','.th-inner').on('click','.th-inner',function(event){var target=$(this);if(target.closest('.bootstrap-table')[0]!==that.$container[0])return false;if(that.options.sortable&&target.parent().data().sortable){that.onSort(event);}});this.$header.children().children().off('keypress').on('keypress',function(event){if(that.options.sortable&&$(this).data().sortable){var code=event.keyCode||event.which;if(code==13){//Enter keycode
that.onSort(event);}}});if(!this.options.showHeader||this.options.cardView){this.$header.hide();this.$tableHeader.hide();this.$tableLoading.css('top',0);}else{this.$header.show();this.$tableHeader.show();this.$tableLoading.css('top',this.$header.outerHeight()+1);// Assign the correct sortable arrow
this.getCaret();}this.$selectAll=this.$header.find('[name="btSelectAll"]');this.$selectAll.off('click').on('click',function(){var checked=$(this).prop('checked');that[checked?'checkAll':'uncheckAll']();that.updateSelected();});};BootstrapTable.prototype.initFooter=function(){if(!this.options.showFooter||this.options.cardView){this.$tableFooter.hide();}else{this.$tableFooter.show();}};/**
     * @param data
     * @param type: append / prepend
     */BootstrapTable.prototype.initData=function(data,type){if(type==='append'){this.data=this.data.concat(data);}else if(type==='prepend'){this.data=[].concat(data).concat(this.data);}else{this.data=data||this.options.data;}// Fix #839 Records deleted when adding new row on filtered table
if(type==='append'){this.options.data=this.options.data.concat(data);}else if(type==='prepend'){this.options.data=[].concat(data).concat(this.options.data);}else{this.options.data=this.data;}if(this.options.sidePagination==='server'){return;}this.initSort();};BootstrapTable.prototype.initSort=function(){var that=this,name=this.options.sortName,order=this.options.sortOrder==='desc'?-1:1,index=$.inArray(this.options.sortName,this.header.fields);if(index!==-1){this.data.sort(function(a,b){if(that.header.sortNames[index]){name=that.header.sortNames[index];}var aa=getItemField(a,name,that.options.escape),bb=getItemField(b,name,that.options.escape),value=calculateObjectValue(that.header,that.header.sorters[index],[aa,bb]);if(value!==undefined){return order*value;}// Fix #161: undefined or null string sort bug.
if(aa===undefined||aa===null){aa='';}if(bb===undefined||bb===null){bb='';}// IF both values are numeric, do a numeric comparison
if($.isNumeric(aa)&&$.isNumeric(bb)){// Convert numerical values form string to float.
aa=parseFloat(aa);bb=parseFloat(bb);if(aa<bb){return order*-1;}return order;}if(aa===bb){return 0;}// If value is not a string, convert to string
if(typeof aa!=='string'){aa=aa.toString();}if(aa.localeCompare(bb)===-1){return order*-1;}return order;});}};BootstrapTable.prototype.onSort=function(event){var $this=event.type==="keypress"?$(event.currentTarget):$(event.currentTarget).parent(),$this_=this.$header.find('th').eq($this.index());this.$header.add(this.$header_).find('span.order').remove();if(this.options.sortName===$this.data('field')){this.options.sortOrder=this.options.sortOrder==='asc'?'desc':'asc';}else{this.options.sortName=$this.data('field');this.options.sortOrder=$this.data('order')==='asc'?'desc':'asc';}this.trigger('sort',this.options.sortName,this.options.sortOrder);$this.add($this_).data('order',this.options.sortOrder);// Assign the correct sortable arrow
this.getCaret();if(this.options.sidePagination==='server'){this.initServer(this.options.silentSort);return;}this.initSort();this.initBody();};BootstrapTable.prototype.initToolbar=function(){var that=this,html=[],timeoutId=0,$keepOpen,$search,switchableCount=0;if(this.$toolbar.find('.bars').children().length){$('body').append($(this.options.toolbar));}this.$toolbar.html('');if(typeof this.options.toolbar==='string'||_typeof(this.options.toolbar)==='object'){$(sprintf('<div class="bars pull-%s"></div>',this.options.toolbarAlign)).appendTo(this.$toolbar).append($(this.options.toolbar));}// showColumns, showToggle, showRefresh
html=[sprintf('<div class="columns columns-%s btn-group pull-%s">',this.options.buttonsAlign,this.options.buttonsAlign)];if(typeof this.options.icons==='string'){this.options.icons=calculateObjectValue(null,this.options.icons);}if(this.options.showPaginationSwitch){html.push(sprintf('<button class="btn btn-default" type="button" name="paginationSwitch" title="%s">',this.options.formatPaginationSwitch()),sprintf('<i class="%s %s"></i>',this.options.iconsPrefix,this.options.icons.paginationSwitchDown),'</button>');}if(this.options.showRefresh){html.push(sprintf('<button class="btn btn-default'+sprintf(' btn-%s',this.options.iconSize)+'" type="button" name="refresh" title="%s">',this.options.formatRefresh()),sprintf('<i class="%s %s"></i>',this.options.iconsPrefix,this.options.icons.refresh),'</button>');}if(this.options.showToggle){html.push(sprintf('<button class="btn btn-default'+sprintf(' btn-%s',this.options.iconSize)+'" type="button" name="toggle" title="%s">',this.options.formatToggle()),sprintf('<i class="%s %s"></i>',this.options.iconsPrefix,this.options.icons.toggle),'</button>');}if(this.options.showColumns){html.push(sprintf('<div class="keep-open btn-group" title="%s">',this.options.formatColumns()),'<button type="button" class="btn btn-default'+sprintf(' btn-%s',this.options.iconSize)+' dropdown-toggle" data-toggle="dropdown">',sprintf('<i class="%s %s"></i>',this.options.iconsPrefix,this.options.icons.columns),' <span class="caret"></span>','</button>','<ul class="dropdown-menu" role="menu">');$.each(this.columns,function(i,column){if(column.radio||column.checkbox){return;}if(that.options.cardView&&!column.cardVisible){return;}var checked=column.visible?' checked="checked"':'';if(column.switchable){html.push(sprintf('<li>'+'<span class="checkbox"><input id="datatable-columns-checkbox-'+i+'" type="checkbox" data-field="%s" value="%s"%s> <label for="datatable-columns-checkbox-'+i+'">%s</label></span>'+'</li>',column.field,i,checked,column.title));switchableCount++;}});html.push('</ul>','</div>');}html.push('</div>');// Fix #188: this.showToolbar is for extensions
if(this.showToolbar||html.length>2){this.$toolbar.append(html.join(''));}if(this.options.showPaginationSwitch){this.$toolbar.find('button[name="paginationSwitch"]').off('click').on('click',$.proxy(this.togglePagination,this));}if(this.options.showRefresh){this.$toolbar.find('button[name="refresh"]').off('click').on('click',$.proxy(this.refresh,this));}if(this.options.showToggle){this.$toolbar.find('button[name="toggle"]').off('click').on('click',function(){that.toggleView();});}if(this.options.showColumns){$keepOpen=this.$toolbar.find('.keep-open');if(switchableCount<=this.options.minimumCountColumns){$keepOpen.find('input').prop('disabled',true);}$keepOpen.find('li').off('click').on('click',function(event){event.stopImmediatePropagation();});$keepOpen.find('input').off('click').on('click',function(){var $this=$(this);that.toggleColumn(getFieldIndex(that.columns,$(this).data('field')),$this.prop('checked'),false);that.trigger('column-switch',$(this).data('field'),$this.prop('checked'));});}if(this.options.search){html=[];html.push('<div class="pull-'+this.options.searchAlign+' search">',sprintf('<input class="form-control'+sprintf(' input-%s',this.options.iconSize)+'" type="text" placeholder="%s">',this.options.formatSearch()),'</div>');this.$toolbar.append(html.join(''));$search=this.$toolbar.find('.search input');$search.off('keyup drop').on('keyup drop',function(event){if(that.options.searchOnEnterKey){if(event.keyCode!==13){return;}}clearTimeout(timeoutId);// doesn't matter if it's 0
timeoutId=setTimeout(function(){that.onSearch(event);},that.options.searchTimeOut);});if(isIEBrowser()){$search.off('mouseup').on('mouseup',function(event){clearTimeout(timeoutId);// doesn't matter if it's 0
timeoutId=setTimeout(function(){that.onSearch(event);},that.options.searchTimeOut);});}}};BootstrapTable.prototype.onSearch=function(event){var text=$.trim($(event.currentTarget).val());// trim search input
if(this.options.trimOnSearch&&$(event.currentTarget).val()!==text){$(event.currentTarget).val(text);}if(text===this.searchText){return;}this.searchText=text;this.options.searchText=text;this.options.pageNumber=1;this.initSearch();this.updatePagination();this.trigger('search',text);};BootstrapTable.prototype.initSearch=function(){var that=this;if(this.options.sidePagination!=='server'){var s=this.searchText&&this.searchText.toLowerCase();var f=$.isEmptyObject(this.filterColumns)?null:this.filterColumns;// Check filter
this.data=f?$.grep(this.options.data,function(item,i){for(var key in f){if($.isArray(f[key])){if($.inArray(item[key],f[key])===-1){return false;}}else if(item[key]!==f[key]){return false;}}return true;}):this.options.data;this.data=s?$.grep(this.data,function(item,i){for(var key in item){key=$.isNumeric(key)?parseInt(key,10):key;var value=item[key],column=that.columns[getFieldIndex(that.columns,key)],j=$.inArray(key,that.header.fields);// Fix #142: search use formatted data
if(column&&column.searchFormatter){value=calculateObjectValue(column,that.header.formatters[j],[value,item,i],value);}var index=$.inArray(key,that.header.fields);if(index!==-1&&that.header.searchables[index]&&(typeof value==='string'||typeof value==='number')){if(that.options.strictSearch){if((value+'').toLowerCase()===s){return true;}}else{if((value+'').toLowerCase().indexOf(s)!==-1){return true;}}}}return false;}):this.data;}};BootstrapTable.prototype.initPagination=function(){if(!this.options.pagination){this.$pagination.hide();return;}else{this.$pagination.show();}var that=this,html=[],$allSelected=false,i,from,to,$pageList,$first,$pre,$next,$last,$number,data=this.getData();if(this.options.sidePagination!=='server'){this.options.totalRows=data.length;}this.totalPages=0;if(this.options.totalRows){if(this.options.pageSize===this.options.formatAllRows()){this.options.pageSize=this.options.totalRows;$allSelected=true;}else if(this.options.pageSize===this.options.totalRows){// Fix #667 Table with pagination,
// multiple pages and a search that matches to one page throws exception
var pageLst=typeof this.options.pageList==='string'?this.options.pageList.replace('[','').replace(']','').replace(/ /g,'').toLowerCase().split(','):this.options.pageList;if($.inArray(this.options.formatAllRows().toLowerCase(),pageLst)>-1){$allSelected=true;}}this.totalPages=~~((this.options.totalRows-1)/this.options.pageSize)+1;this.options.totalPages=this.totalPages;}if(this.totalPages>0&&this.options.pageNumber>this.totalPages){this.options.pageNumber=this.totalPages;}this.pageFrom=(this.options.pageNumber-1)*this.options.pageSize+1;this.pageTo=this.options.pageNumber*this.options.pageSize;if(this.pageTo>this.options.totalRows){this.pageTo=this.options.totalRows;}html.push('<div class="pull-'+this.options.paginationDetailHAlign+' pagination-detail">','<span class="pagination-info">',this.options.onlyInfoPagination?this.options.formatDetailPagination(this.options.totalRows):this.options.formatShowingRows(this.pageFrom,this.pageTo,this.options.totalRows),'</span>');if(!this.options.onlyInfoPagination){html.push('<span class="page-list">');var pageNumber=[sprintf('<span class="btn-group %s">',this.options.paginationVAlign==='top'||this.options.paginationVAlign==='both'?'dropdown':'dropup'),'<button type="button" class="btn btn-default '+sprintf(' btn-%s',this.options.iconSize)+' dropdown-toggle" data-toggle="dropdown">','<span class="page-size">',$allSelected?this.options.formatAllRows():this.options.pageSize,'</span>',' <span class="caret"></span>','</button>','<ul class="dropdown-menu" role="menu">'],pageList=this.options.pageList;if(typeof this.options.pageList==='string'){var list=this.options.pageList.replace('[','').replace(']','').replace(/ /g,'').split(',');pageList=[];$.each(list,function(i,value){pageList.push(value.toUpperCase()===that.options.formatAllRows().toUpperCase()?that.options.formatAllRows():+value);});}$.each(pageList,function(i,page){if(!that.options.smartDisplay||i===0||pageList[i-1]<=that.options.totalRows){var active;if($allSelected){active=page===that.options.formatAllRows()?' class="active"':'';}else{active=page===that.options.pageSize?' class="active"':'';}pageNumber.push(sprintf('<li%s><a href="javascript:void(0)">%s</a></li>',active,page));}});pageNumber.push('</ul></span>');html.push(this.options.formatRecordsPerPage(pageNumber.join('')));html.push('</span>');html.push('</div>','<div class="pull-'+this.options.paginationHAlign+' pagination">','<ul class="pagination'+sprintf(' pagination-%s',this.options.iconSize)+'">','<li class="page-pre"><a href="javascript:void(0)">'+this.options.paginationPreText+'</a></li>');if(this.totalPages<5){from=1;to=this.totalPages;}else{from=this.options.pageNumber-2;to=from+4;if(from<1){from=1;to=5;}if(to>this.totalPages){to=this.totalPages;from=to-4;}}if(this.totalPages>=6){if(this.options.pageNumber>=3){html.push('<li class="page-first'+(1===this.options.pageNumber?' active':'')+'">','<a href="javascript:void(0)">',1,'</a>','</li>');from++;}if(this.options.pageNumber>=4){if(this.options.pageNumber==4||this.totalPages==6||this.totalPages==7){from--;}else{html.push('<li class="page-first-separator disabled">','<a href="javascript:void(0)">...</a>','</li>');}to--;}}if(this.totalPages>=7){if(this.options.pageNumber>=this.totalPages-2){from--;}}if(this.totalPages==6){if(this.options.pageNumber>=this.totalPages-2){to++;}}else if(this.totalPages>=7){if(this.totalPages==7||this.options.pageNumber>=this.totalPages-3){to++;}}for(i=from;i<=to;i++){html.push('<li class="page-number'+(i===this.options.pageNumber?' active':'')+'">','<a href="javascript:void(0)">',i,'</a>','</li>');}if(this.totalPages>=8){if(this.options.pageNumber<=this.totalPages-4){html.push('<li class="page-last-separator disabled">','<a href="javascript:void(0)">...</a>','</li>');}}if(this.totalPages>=6){if(this.options.pageNumber<=this.totalPages-3){html.push('<li class="page-last'+(this.totalPages===this.options.pageNumber?' active':'')+'">','<a href="javascript:void(0)">',this.totalPages,'</a>','</li>');}}html.push('<li class="page-next"><a href="javascript:void(0)">'+this.options.paginationNextText+'</a></li>','</ul>','</div>');}this.$pagination.html(html.join(''));if(!this.options.onlyInfoPagination){$pageList=this.$pagination.find('.page-list a');$first=this.$pagination.find('.page-first');$pre=this.$pagination.find('.page-pre');$next=this.$pagination.find('.page-next');$last=this.$pagination.find('.page-last');$number=this.$pagination.find('.page-number');if(this.options.smartDisplay){if(this.totalPages<=1){this.$pagination.find('div.pagination').hide();}if(pageList.length<2||this.options.totalRows<=pageList[0]){this.$pagination.find('span.page-list').hide();}// when data is empty, hide the pagination
this.$pagination[this.getData().length?'show':'hide']();}if($allSelected){this.options.pageSize=this.options.formatAllRows();}$pageList.off('click').on('click',$.proxy(this.onPageListChange,this));$first.off('click').on('click',$.proxy(this.onPageFirst,this));$pre.off('click').on('click',$.proxy(this.onPagePre,this));$next.off('click').on('click',$.proxy(this.onPageNext,this));$last.off('click').on('click',$.proxy(this.onPageLast,this));$number.off('click').on('click',$.proxy(this.onPageNumber,this));}};BootstrapTable.prototype.updatePagination=function(event){// Fix #171: IE disabled button can be clicked bug.
if(event&&$(event.currentTarget).hasClass('disabled')){return;}if(!this.options.maintainSelected){this.resetRows();}this.initPagination();if(this.options.sidePagination==='server'){this.initServer();}else{this.initBody();}this.trigger('page-change',this.options.pageNumber,this.options.pageSize);};BootstrapTable.prototype.onPageListChange=function(event){var $this=$(event.currentTarget);$this.parent().addClass('active').siblings().removeClass('active');this.options.pageSize=$this.text().toUpperCase()===this.options.formatAllRows().toUpperCase()?this.options.formatAllRows():+$this.text();this.$toolbar.find('.page-size').text(this.options.pageSize);this.updatePagination(event);};BootstrapTable.prototype.onPageFirst=function(event){this.options.pageNumber=1;this.updatePagination(event);};BootstrapTable.prototype.onPagePre=function(event){if(this.options.pageNumber-1==0){this.options.pageNumber=this.options.totalPages;}else{this.options.pageNumber--;}this.updatePagination(event);};BootstrapTable.prototype.onPageNext=function(event){if(this.options.pageNumber+1>this.options.totalPages){this.options.pageNumber=1;}else{this.options.pageNumber++;}this.updatePagination(event);};BootstrapTable.prototype.onPageLast=function(event){this.options.pageNumber=this.totalPages;this.updatePagination(event);};BootstrapTable.prototype.onPageNumber=function(event){if(this.options.pageNumber===+$(event.currentTarget).text()){return;}this.options.pageNumber=+$(event.currentTarget).text();this.updatePagination(event);};BootstrapTable.prototype.initBody=function(fixedScroll){var that=this,html=[],data=this.getData();this.trigger('pre-body',data);this.$body=this.$el.find('>tbody');if(!this.$body.length){this.$body=$('<tbody></tbody>').appendTo(this.$el);}//Fix #389 Bootstrap-table-flatJSON is not working
if(!this.options.pagination||this.options.sidePagination==='server'){this.pageFrom=1;this.pageTo=data.length;}for(var i=this.pageFrom-1;i<this.pageTo;i++){var key,item=data[i],style={},csses=[],data_='',attributes={},htmlAttributes=[];style=calculateObjectValue(this.options,this.options.rowStyle,[item,i],style);if(style&&style.css){for(key in style.css){csses.push(key+': '+style.css[key]);}}attributes=calculateObjectValue(this.options,this.options.rowAttributes,[item,i],attributes);if(attributes){for(key in attributes){htmlAttributes.push(sprintf('%s="%s"',key,escapeHTML(attributes[key])));}}if(item._data&&!$.isEmptyObject(item._data)){$.each(item._data,function(k,v){// ignore data-index
if(k==='index'){return;}data_+=sprintf(' data-%s="%s"',k,v);});}html.push('<tr',sprintf(' %s',htmlAttributes.join(' ')),sprintf(' id="%s"',$.isArray(item)?undefined:item._id),sprintf(' class="%s"',style.classes||($.isArray(item)?undefined:item._class)),sprintf(' data-index="%s"',i),sprintf(' data-uniqueid="%s"',item[this.options.uniqueId]),sprintf('%s',data_),'>');if(this.options.cardView){html.push(sprintf('<td colspan="%s">',this.header.fields.length));}if(!this.options.cardView&&this.options.detailView){html.push('<td>','<a class="detail-icon" href="javascript:">',sprintf('<i class="%s %s"></i>',this.options.iconsPrefix,this.options.icons.detailOpen),'</a>','</td>');}$.each(this.header.fields,function(j,field){var text='',value=getItemField(item,field,that.options.escape),type='',cellStyle={},id_='',class_=that.header.classes[j],data_='',rowspan_='',title_='',column=that.columns[getFieldIndex(that.columns,field)];if(!column.visible){return;}style=sprintf('style="%s"',csses.concat(that.header.styles[j]).join('; '));value=calculateObjectValue(column,that.header.formatters[j],[value,item,i],value);// handle td's id and class
if(item['_'+field+'_id']){id_=sprintf(' id="%s"',item['_'+field+'_id']);}if(item['_'+field+'_class']){class_=sprintf(' class="%s"',item['_'+field+'_class']);}if(item['_'+field+'_rowspan']){rowspan_=sprintf(' rowspan="%s"',item['_'+field+'_rowspan']);}if(item['_'+field+'_title']){title_=sprintf(' title="%s"',item['_'+field+'_title']);}cellStyle=calculateObjectValue(that.header,that.header.cellStyles[j],[value,item,i],cellStyle);if(cellStyle.classes){class_=sprintf(' class="%s"',cellStyle.classes);}if(cellStyle.css){var csses_=[];for(var key in cellStyle.css){csses_.push(key+': '+cellStyle.css[key]);}style=sprintf('style="%s"',csses_.concat(that.header.styles[j]).join('; '));}if(item['_'+field+'_data']&&!$.isEmptyObject(item['_'+field+'_data'])){$.each(item['_'+field+'_data'],function(k,v){// ignore data-index
if(k==='index'){return;}data_+=sprintf(' data-%s="%s"',k,v);});}if(column.checkbox||column.radio){type=column.checkbox?'checkbox':type;type=column.radio?'radio':type;text=[sprintf(that.options.cardView?'<div class="card-view %s">':'<td class="bs-checkbox %s">',column['class']||''),'<div class="checkbox checkbox-only">'+'<input'+sprintf(' id="datatable-checkbox-%s"',i)+sprintf(' data-index="%s"',i)+sprintf(' name="%s"',that.options.selectItemName)+sprintf(' type="%s"',type)+sprintf(' value="%s"',item[that.options.idField])+sprintf(' checked="%s"',value===true||value&&value.checked?'checked':undefined)+sprintf(' disabled="%s"',!column.checkboxEnabled||value&&value.disabled?'disabled':undefined)+' />'+sprintf('<label for="datatable-checkbox-%s"></label>',i)+'</div>',that.header.formatters[j]&&typeof value==='string'?value:'',that.options.cardView?'</div>':'</td>'].join('');item[that.header.stateField]=value===true||value&&value.checked;}else{value=typeof value==='undefined'||value===null?that.options.undefinedText:value;text=that.options.cardView?['<div class="card-view">',that.options.showHeader?sprintf('<span class="title" %s>%s</span>',style,getPropertyFromOther(that.columns,'field','title',field)):'',sprintf('<span class="value">%s</span>',value),'</div>'].join(''):[sprintf('<td%s %s %s %s %s %s>',id_,class_,style,data_,rowspan_,title_),value,'</td>'].join('');// Hide empty data on Card view when smartDisplay is set to true.
if(that.options.cardView&&that.options.smartDisplay&&value===''){// Should set a placeholder for event binding correct fieldIndex
text='<div class="card-view"></div>';}}html.push(text);});if(this.options.cardView){html.push('</td>');}html.push('</tr>');}// show no records
if(!html.length){html.push('<tr class="no-records-found">',sprintf('<td colspan="%s">%s</td>',this.$header.find('th').length,this.options.formatNoMatches()),'</tr>');}this.$body.html(html.join(''));if(!fixedScroll){this.scrollTo(0);}// click to select by column
this.$body.find('> tr[data-index] > td').off('click dblclick').on('click dblclick',function(e){var $td=$(this),$tr=$td.parent(),item=that.data[$tr.data('index')],index=$td[0].cellIndex,field=that.header.fields[that.options.detailView&&!that.options.cardView?index-1:index],column=that.columns[getFieldIndex(that.columns,field)],value=getItemField(item,field,that.options.escape);if($td.find('.detail-icon').length){return;}that.trigger(e.type==='click'?'click-cell':'dbl-click-cell',field,value,item,$td);that.trigger(e.type==='click'?'click-row':'dbl-click-row',item,$tr);// if click to select - then trigger the checkbox/radio click
if(e.type==='click'&&that.options.clickToSelect&&column.clickToSelect){var $selectItem=$tr.find(sprintf('[name="%s"]',that.options.selectItemName));if($selectItem.length){$selectItem[0].click();// #144: .trigger('click') bug
}}});this.$body.find('> tr[data-index] > td > .detail-icon').off('click').on('click',function(){var $this=$(this),$tr=$this.parent().parent(),index=$tr.data('index'),row=data[index];// Fix #980 Detail view, when searching, returns wrong row
// remove and update
if($tr.next().is('tr.detail-view')){$this.find('i').attr('class',sprintf('%s %s',that.options.iconsPrefix,that.options.icons.detailOpen));$tr.next().remove();that.trigger('collapse-row',index,row);}else{$this.find('i').attr('class',sprintf('%s %s',that.options.iconsPrefix,that.options.icons.detailClose));$tr.after(sprintf('<tr class="detail-view"><td colspan="%s"></td></tr>',$tr.find('td').length));var $element=$tr.next().find('td');var content=calculateObjectValue(that.options,that.options.detailFormatter,[index,row,$element],'');if($element.length===1){$element.append(content);}that.trigger('expand-row',index,row,$element);}that.resetView();});this.$selectItem=this.$body.find(sprintf('[name="%s"]',this.options.selectItemName));this.$selectItem.off('click').on('click',function(event){event.stopImmediatePropagation();var $this=$(this),checked=$this.prop('checked'),row=that.data[$this.data('index')];if(that.options.maintainSelected&&$(this).is(':radio')){$.each(that.options.data,function(i,row){row[that.header.stateField]=false;});}row[that.header.stateField]=checked;if(that.options.singleSelect){that.$selectItem.not(this).each(function(){that.data[$(this).data('index')][that.header.stateField]=false;});that.$selectItem.filter(':checked').not(this).prop('checked',false);}that.updateSelected();that.trigger(checked?'check':'uncheck',row,$this);});$.each(this.header.events,function(i,events){if(!events){return;}// fix bug, if events is defined with namespace
if(typeof events==='string'){events=calculateObjectValue(null,events);}var field=that.header.fields[i],fieldIndex=$.inArray(field,that.getVisibleFields());if(that.options.detailView&&!that.options.cardView){fieldIndex+=1;}for(var key in events){that.$body.find('>tr:not(.no-records-found)').each(function(){var $tr=$(this),$td=$tr.find(that.options.cardView?'.card-view':'td').eq(fieldIndex),index=key.indexOf(' '),name=key.substring(0,index),el=key.substring(index+1),func=events[key];$td.find(el).off(name).on(name,function(e){var index=$tr.data('index'),row=that.data[index],value=row[field];func.apply(this,[e,value,row,index]);});});}});this.updateSelected();this.resetView();this.trigger('post-body');};BootstrapTable.prototype.initServer=function(silent,query){var that=this,data={},params={searchText:this.searchText,sortName:this.options.sortName,sortOrder:this.options.sortOrder},request;if(this.options.pagination){params.pageSize=this.options.pageSize===this.options.formatAllRows()?this.options.totalRows:this.options.pageSize;params.pageNumber=this.options.pageNumber;}if(!this.options.url&&!this.options.ajax){return;}if(this.options.queryParamsType==='limit'){params={search:params.searchText,sort:params.sortName,order:params.sortOrder};if(this.options.pagination){params.limit=this.options.pageSize===this.options.formatAllRows()?this.options.totalRows:this.options.pageSize;params.offset=this.options.pageSize===this.options.formatAllRows()?0:this.options.pageSize*(this.options.pageNumber-1);}}if(!$.isEmptyObject(this.filterColumnsPartial)){params['filter']=JSON.stringify(this.filterColumnsPartial,null);}data=calculateObjectValue(this.options,this.options.queryParams,[params],data);$.extend(data,query||{});// false to stop request
if(data===false){return;}if(!silent){this.$tableLoading.show();}request=$.extend({},calculateObjectValue(null,this.options.ajaxOptions),{type:this.options.method,url:this.options.url,data:this.options.contentType==='application/json'&&this.options.method==='post'?JSON.stringify(data):data,cache:this.options.cache,contentType:this.options.contentType,dataType:this.options.dataType,success:function success(res){res=calculateObjectValue(that.options,that.options.responseHandler,[res],res);that.load(res);that.trigger('load-success',res);if(!silent)that.$tableLoading.hide();},error:function error(res){that.trigger('load-error',res.status,res);if(!silent)that.$tableLoading.hide();}});if(this.options.ajax){calculateObjectValue(this,this.options.ajax,[request],null);}else{$.ajax(request);}};BootstrapTable.prototype.initSearchText=function(){if(this.options.search){if(this.options.searchText!==''){var $search=this.$toolbar.find('.search input');$search.val(this.options.searchText);this.onSearch({currentTarget:$search});}}};BootstrapTable.prototype.getCaret=function(){var that=this;$.each(this.$header.find('th'),function(i,th){$(th).find('.sortable').removeClass('desc asc').addClass($(th).data('field')===that.options.sortName?that.options.sortOrder:'both');});};BootstrapTable.prototype.updateSelected=function(){var checkAll=this.$selectItem.filter(':enabled').length&&this.$selectItem.filter(':enabled').length===this.$selectItem.filter(':enabled').filter(':checked').length;this.$selectAll.add(this.$selectAll_).prop('checked',checkAll);this.$selectItem.each(function(){$(this).closest('tr')[$(this).prop('checked')?'addClass':'removeClass']('selected');});};BootstrapTable.prototype.updateRows=function(){var that=this;this.$selectItem.each(function(){that.data[$(this).data('index')][that.header.stateField]=$(this).prop('checked');});};BootstrapTable.prototype.resetRows=function(){var that=this;$.each(this.data,function(i,row){that.$selectAll.prop('checked',false);that.$selectItem.prop('checked',false);if(that.header.stateField){row[that.header.stateField]=false;}});};BootstrapTable.prototype.trigger=function(name){var args=Array.prototype.slice.call(arguments,1);name+='.bs.table';this.options[BootstrapTable.EVENTS[name]].apply(this.options,args);this.$el.trigger($.Event(name),args);this.options.onAll(name,args);this.$el.trigger($.Event('all.bs.table'),[name,args]);};BootstrapTable.prototype.resetHeader=function(){// fix #61: the hidden table reset header bug.
// fix bug: get $el.css('width') error sometime (height = 500)
clearTimeout(this.timeoutId_);this.timeoutId_=setTimeout($.proxy(this.fitHeader,this),this.$el.is(':hidden')?100:0);};BootstrapTable.prototype.fitHeader=function(){var that=this,fixedBody,scrollWidth,focused,focusedTemp;if(that.$el.is(':hidden')){that.timeoutId_=setTimeout($.proxy(that.fitHeader,that),100);return;}fixedBody=this.$tableBody.get(0);scrollWidth=fixedBody.scrollWidth>fixedBody.clientWidth&&fixedBody.scrollHeight>fixedBody.clientHeight+this.$header.outerHeight()?getScrollBarWidth():0;this.$el.css('margin-top',-this.$header.outerHeight());focused=$(':focus');if(focused.length>0){var $th=focused.parents('th');if($th.length>0){var dataField=$th.attr('data-field');if(dataField!==undefined){var $headerTh=this.$header.find("[data-field='"+dataField+"']");if($headerTh.length>0){$headerTh.find(":input").addClass("focus-temp");}}}}this.$header_=this.$header.clone(true,true);this.$selectAll_=this.$header_.find('[name="btSelectAll"]');this.$tableHeader.css({'margin-right':scrollWidth}).find('table').css('width',this.$el.outerWidth()).html('').attr('class',this.$el.attr('class')).append(this.$header_);focusedTemp=$('.focus-temp:visible:eq(0)');if(focusedTemp.length>0){focusedTemp.focus();this.$header.find('.focus-temp').removeClass('focus-temp');}// fix bug: $.data() is not working as expected after $.append()
this.$header.find('th[data-field]').each(function(i){that.$header_.find(sprintf('th[data-field="%s"]',$(this).data('field'))).data($(this).data());});var visibleFields=this.getVisibleFields();this.$body.find('>tr:first-child:not(.no-records-found) > *').each(function(i){var $this=$(this),index=i;if(that.options.detailView&&!that.options.cardView){if(i===0){that.$header_.find('th.detail').find('.fht-cell').width($this.innerWidth());}index=i-1;}that.$header_.find(sprintf('th[data-field="%s"]',visibleFields[index])).find('.fht-cell').width($this.innerWidth());});// horizontal scroll event
// TODO: it's probably better improving the layout than binding to scroll event
this.$tableBody.off('scroll').on('scroll',function(){that.$tableHeader.scrollLeft($(this).scrollLeft());if(that.options.showFooter&&!that.options.cardView){that.$tableFooter.scrollLeft($(this).scrollLeft());}});that.trigger('post-header');};BootstrapTable.prototype.resetFooter=function(){var that=this,data=that.getData(),html=[];if(!this.options.showFooter||this.options.cardView){//do nothing
return;}if(!this.options.cardView&&this.options.detailView){html.push('<td><div class="th-inner">&nbsp;</div><div class="fht-cell"></div></td>');}$.each(this.columns,function(i,column){var falign='',// footer align style
style='',class_=sprintf(' class="%s"',column['class']);if(!column.visible){return;}if(that.options.cardView&&!column.cardVisible){return;}falign=sprintf('text-align: %s; ',column.falign?column.falign:column.align);style=sprintf('vertical-align: %s; ',column.valign);html.push('<td',class_,sprintf(' style="%s"',falign+style),'>');html.push('<div class="th-inner">');html.push(calculateObjectValue(column,column.footerFormatter,[data],'&nbsp;')||'&nbsp;');html.push('</div>');html.push('<div class="fht-cell"></div>');html.push('</div>');html.push('</td>');});this.$tableFooter.find('tr').html(html.join(''));clearTimeout(this.timeoutFooter_);this.timeoutFooter_=setTimeout($.proxy(this.fitFooter,this),this.$el.is(':hidden')?100:0);};BootstrapTable.prototype.fitFooter=function(){var that=this,$footerTd,elWidth,scrollWidth;clearTimeout(this.timeoutFooter_);if(this.$el.is(':hidden')){this.timeoutFooter_=setTimeout($.proxy(this.fitFooter,this),100);return;}elWidth=this.$el.css('width');scrollWidth=elWidth>this.$tableBody.width()?getScrollBarWidth():0;this.$tableFooter.css({'margin-right':scrollWidth}).find('table').css('width',elWidth).attr('class',this.$el.attr('class'));$footerTd=this.$tableFooter.find('td');this.$body.find('>tr:first-child:not(.no-records-found) > *').each(function(i){var $this=$(this);$footerTd.eq(i).find('.fht-cell').width($this.innerWidth());});};BootstrapTable.prototype.toggleColumn=function(index,checked,needUpdate){if(index===-1){return;}this.columns[index].visible=checked;this.initHeader();this.initSearch();this.initPagination();this.initBody();if(this.options.showColumns){var $items=this.$toolbar.find('.keep-open input').prop('disabled',false);if(needUpdate){$items.filter(sprintf('[value="%s"]',index)).prop('checked',checked);}if($items.filter(':checked').length<=this.options.minimumCountColumns){$items.filter(':checked').prop('disabled',true);}}};BootstrapTable.prototype.toggleRow=function(index,uniqueId,visible){if(index===-1){return;}this.$body.find(typeof index!=='undefined'?sprintf('tr[data-index="%s"]',index):sprintf('tr[data-uniqueid="%s"]',uniqueId))[visible?'show':'hide']();};BootstrapTable.prototype.getVisibleFields=function(){var that=this,visibleFields=[];$.each(this.header.fields,function(j,field){var column=that.columns[getFieldIndex(that.columns,field)];if(!column.visible){return;}visibleFields.push(field);});return visibleFields;};// PUBLIC FUNCTION DEFINITION
// =======================
BootstrapTable.prototype.resetView=function(params){var padding=0;if(params&&params.height){this.options.height=params.height;}this.$selectAll.prop('checked',this.$selectItem.length>0&&this.$selectItem.length===this.$selectItem.filter(':checked').length);if(this.options.height){var toolbarHeight=getRealHeight(this.$toolbar),paginationHeight=getRealHeight(this.$pagination),height=this.options.height-toolbarHeight-paginationHeight;this.$tableContainer.css('height',height+'px');}if(this.options.cardView){// remove the element css
this.$el.css('margin-top','0');this.$tableContainer.css('padding-bottom','0');return;}if(this.options.showHeader&&this.options.height){this.$tableHeader.show();this.resetHeader();padding+=this.$header.outerHeight();}else{this.$tableHeader.hide();this.trigger('post-header');}if(this.options.showFooter){this.resetFooter();if(this.options.height){padding+=this.$tableFooter.outerHeight()+1;}}// Assign the correct sortable arrow
this.getCaret();this.$tableContainer.css('padding-bottom',padding+'px');this.trigger('reset-view');};BootstrapTable.prototype.getData=function(useCurrentPage){return this.searchText||!$.isEmptyObject(this.filterColumns)||!$.isEmptyObject(this.filterColumnsPartial)?useCurrentPage?this.data.slice(this.pageFrom-1,this.pageTo):this.data:useCurrentPage?this.options.data.slice(this.pageFrom-1,this.pageTo):this.options.data;};BootstrapTable.prototype.load=function(data){var fixedScroll=false;// #431: support pagination
if(this.options.sidePagination==='server'){this.options.totalRows=data.total;fixedScroll=data.fixedScroll;data=data[this.options.dataField];}else if(!$.isArray(data)){// support fixedScroll
fixedScroll=data.fixedScroll;data=data.data;}this.initData(data);this.initSearch();this.initPagination();this.initBody(fixedScroll);};BootstrapTable.prototype.append=function(data){this.initData(data,'append');this.initSearch();this.initPagination();this.initSort();this.initBody(true);};BootstrapTable.prototype.prepend=function(data){this.initData(data,'prepend');this.initSearch();this.initPagination();this.initSort();this.initBody(true);};BootstrapTable.prototype.remove=function(params){var len=this.options.data.length,i,row;if(!params.hasOwnProperty('field')||!params.hasOwnProperty('values')){return;}for(i=len-1;i>=0;i--){row=this.options.data[i];if(!row.hasOwnProperty(params.field)){continue;}if($.inArray(row[params.field],params.values)!==-1){this.options.data.splice(i,1);}}if(len===this.options.data.length){return;}this.initSearch();this.initPagination();this.initSort();this.initBody(true);};BootstrapTable.prototype.removeAll=function(){if(this.options.data.length>0){this.options.data.splice(0,this.options.data.length);this.initSearch();this.initPagination();this.initBody(true);}};BootstrapTable.prototype.getRowByUniqueId=function(id){var uniqueId=this.options.uniqueId,len=this.options.data.length,dataRow=null,i,row,rowUniqueId;for(i=len-1;i>=0;i--){row=this.options.data[i];if(row.hasOwnProperty(uniqueId)){// uniqueId is a column
rowUniqueId=row[uniqueId];}else if(row._data.hasOwnProperty(uniqueId)){// uniqueId is a row data property
rowUniqueId=row._data[uniqueId];}else{continue;}if(typeof rowUniqueId==='string'){id=id.toString();}else if(typeof rowUniqueId==='number'){if(Number(rowUniqueId)===rowUniqueId&&rowUniqueId%1===0){id=parseInt(id);}else if(rowUniqueId===Number(rowUniqueId)&&rowUniqueId!==0){id=parseFloat(id);}}if(rowUniqueId===id){dataRow=row;break;}}return dataRow;};BootstrapTable.prototype.removeByUniqueId=function(id){var len=this.options.data.length,row=this.getRowByUniqueId(id);if(row){this.options.data.splice(this.options.data.indexOf(row),1);}if(len===this.options.data.length){return;}this.initSearch();this.initPagination();this.initBody(true);};BootstrapTable.prototype.updateByUniqueId=function(params){var rowId;if(!params.hasOwnProperty('id')||!params.hasOwnProperty('row')){return;}rowId=$.inArray(this.getRowByUniqueId(params.id),this.options.data);if(rowId===-1){return;}$.extend(this.data[rowId],params.row);this.initSort();this.initBody(true);};BootstrapTable.prototype.insertRow=function(params){if(!params.hasOwnProperty('index')||!params.hasOwnProperty('row')){return;}this.data.splice(params.index,0,params.row);this.initSearch();this.initPagination();this.initSort();this.initBody(true);};BootstrapTable.prototype.updateRow=function(params){if(!params.hasOwnProperty('index')||!params.hasOwnProperty('row')){return;}$.extend(this.data[params.index],params.row);this.initSort();this.initBody(true);};BootstrapTable.prototype.showRow=function(params){if(!params.hasOwnProperty('index')&&!params.hasOwnProperty('uniqueId')){return;}this.toggleRow(params.index,params.uniqueId,true);};BootstrapTable.prototype.hideRow=function(params){if(!params.hasOwnProperty('index')&&!params.hasOwnProperty('uniqueId')){return;}this.toggleRow(params.index,params.uniqueId,false);};BootstrapTable.prototype.getRowsHidden=function(show){var rows=$(this.$body[0]).children().filter(':hidden'),i=0;if(show){for(;i<rows.length;i++){$(rows[i]).show();}}return rows;};BootstrapTable.prototype.mergeCells=function(options){var row=options.index,col=$.inArray(options.field,this.getVisibleFields()),rowspan=options.rowspan||1,colspan=options.colspan||1,i,j,$tr=this.$body.find('>tr'),$td;if(this.options.detailView&&!this.options.cardView){col+=1;}$td=$tr.eq(row).find('>td').eq(col);if(row<0||col<0||row>=this.data.length){return;}for(i=row;i<row+rowspan;i++){for(j=col;j<col+colspan;j++){$tr.eq(i).find('>td').eq(j).hide();}}$td.attr('rowspan',rowspan).attr('colspan',colspan).show();};BootstrapTable.prototype.updateCell=function(params){if(!params.hasOwnProperty('index')||!params.hasOwnProperty('field')||!params.hasOwnProperty('value')){return;}this.data[params.index][params.field]=params.value;if(params.reinit===false){return;}this.initSort();this.initBody(true);};BootstrapTable.prototype.getOptions=function(){return this.options;};BootstrapTable.prototype.getSelections=function(){var that=this;return $.grep(this.data,function(row){return row[that.header.stateField];});};BootstrapTable.prototype.getAllSelections=function(){var that=this;return $.grep(this.options.data,function(row){return row[that.header.stateField];});};BootstrapTable.prototype.checkAll=function(){this.checkAll_(true);};BootstrapTable.prototype.uncheckAll=function(){this.checkAll_(false);};BootstrapTable.prototype.checkAll_=function(checked){var rows;if(!checked){rows=this.getSelections();}this.$selectAll.add(this.$selectAll_).prop('checked',checked);this.$selectItem.filter(':enabled').prop('checked',checked);this.updateRows();if(checked){rows=this.getSelections();}this.trigger(checked?'check-all':'uncheck-all',rows);};BootstrapTable.prototype.check=function(index){this.check_(true,index);};BootstrapTable.prototype.uncheck=function(index){this.check_(false,index);};BootstrapTable.prototype.check_=function(checked,index){var $el=this.$selectItem.filter(sprintf('[data-index="%s"]',index)).prop('checked',checked);this.data[index][this.header.stateField]=checked;this.updateSelected();this.trigger(checked?'check':'uncheck',this.data[index],$el);};BootstrapTable.prototype.checkBy=function(obj){this.checkBy_(true,obj);};BootstrapTable.prototype.uncheckBy=function(obj){this.checkBy_(false,obj);};BootstrapTable.prototype.checkBy_=function(checked,obj){if(!obj.hasOwnProperty('field')||!obj.hasOwnProperty('values')){return;}var that=this,rows=[];$.each(this.options.data,function(index,row){if(!row.hasOwnProperty(obj.field)){return false;}if($.inArray(row[obj.field],obj.values)!==-1){var $el=that.$selectItem.filter(':enabled').filter(sprintf('[data-index="%s"]',index)).prop('checked',checked);row[that.header.stateField]=checked;rows.push(row);that.trigger(checked?'check':'uncheck',row,$el);}});this.updateSelected();this.trigger(checked?'check-some':'uncheck-some',rows);};BootstrapTable.prototype.destroy=function(){this.$el.insertBefore(this.$container);$(this.options.toolbar).insertBefore(this.$el);this.$container.next().remove();this.$container.remove();this.$el.html(this.$el_.html()).css('margin-top','0').attr('class',this.$el_.attr('class')||'');// reset the class
};BootstrapTable.prototype.showLoading=function(){this.$tableLoading.show();};BootstrapTable.prototype.hideLoading=function(){this.$tableLoading.hide();};BootstrapTable.prototype.togglePagination=function(){this.options.pagination=!this.options.pagination;var button=this.$toolbar.find('button[name="paginationSwitch"] i');if(this.options.pagination){button.attr("class",this.options.iconsPrefix+" "+this.options.icons.paginationSwitchDown);}else{button.attr("class",this.options.iconsPrefix+" "+this.options.icons.paginationSwitchUp);}this.updatePagination();};BootstrapTable.prototype.refresh=function(params){if(params&&params.url){this.options.url=params.url;this.options.pageNumber=1;}this.initServer(params&&params.silent,params&&params.query);};BootstrapTable.prototype.resetWidth=function(){if(this.options.showHeader&&this.options.height){this.fitHeader();}if(this.options.showFooter){this.fitFooter();}};BootstrapTable.prototype.showColumn=function(field){this.toggleColumn(getFieldIndex(this.columns,field),true,true);};BootstrapTable.prototype.hideColumn=function(field){this.toggleColumn(getFieldIndex(this.columns,field),false,true);};BootstrapTable.prototype.getHiddenColumns=function(){return $.grep(this.columns,function(column){return!column.visible;});};BootstrapTable.prototype.filterBy=function(columns){this.filterColumns=$.isEmptyObject(columns)?{}:columns;this.options.pageNumber=1;this.initSearch();this.updatePagination();};BootstrapTable.prototype.scrollTo=function(value){if(typeof value==='string'){value=value==='bottom'?this.$tableBody[0].scrollHeight:0;}if(typeof value==='number'){this.$tableBody.scrollTop(value);}if(typeof value==='undefined'){return this.$tableBody.scrollTop();}};BootstrapTable.prototype.getScrollPosition=function(){return this.scrollTo();};BootstrapTable.prototype.selectPage=function(page){if(page>0&&page<=this.options.totalPages){this.options.pageNumber=page;this.updatePagination();}};BootstrapTable.prototype.prevPage=function(){if(this.options.pageNumber>1){this.options.pageNumber--;this.updatePagination();}};BootstrapTable.prototype.nextPage=function(){if(this.options.pageNumber<this.options.totalPages){this.options.pageNumber++;this.updatePagination();}};BootstrapTable.prototype.toggleView=function(){this.options.cardView=!this.options.cardView;this.initHeader();// Fixed remove toolbar when click cardView button.
//that.initToolbar();
this.initBody();this.trigger('toggle',this.options.cardView);};BootstrapTable.prototype.refreshOptions=function(options){//If the objects are equivalent then avoid the call of destroy / init methods
if(compareObjects(this.options,options,true)){return;}this.options=$.extend(this.options,options);this.trigger('refresh-options',this.options);this.destroy();this.init();};BootstrapTable.prototype.resetSearch=function(text){var $search=this.$toolbar.find('.search input');$search.val(text||'');this.onSearch({currentTarget:$search});};BootstrapTable.prototype.expandRow_=function(expand,index){var $tr=this.$body.find(sprintf('> tr[data-index="%s"]',index));if($tr.next().is('tr.detail-view')===(expand?false:true)){$tr.find('> td > .detail-icon').click();}};BootstrapTable.prototype.expandRow=function(index){this.expandRow_(true,index);};BootstrapTable.prototype.collapseRow=function(index){this.expandRow_(false,index);};BootstrapTable.prototype.expandAllRows=function(isSubTable){if(isSubTable){var $tr=this.$body.find(sprintf('> tr[data-index="%s"]',0)),that=this,detailIcon=null,executeInterval=false,idInterval=-1;if(!$tr.next().is('tr.detail-view')){$tr.find('> td > .detail-icon').click();executeInterval=true;}else if(!$tr.next().next().is('tr.detail-view')){$tr.next().find(".detail-icon").click();executeInterval=true;}if(executeInterval){try{idInterval=setInterval(function(){detailIcon=that.$body.find("tr.detail-view").last().find(".detail-icon");if(detailIcon.length>0){detailIcon.click();}else{clearInterval(idInterval);}},1);}catch(ex){clearInterval(idInterval);}}}else{var trs=this.$body.children();for(var i=0;i<trs.length;i++){this.expandRow_(true,$(trs[i]).data("index"));}}};BootstrapTable.prototype.collapseAllRows=function(isSubTable){if(isSubTable){this.expandRow_(false,0);}else{var trs=this.$body.children();for(var i=0;i<trs.length;i++){this.expandRow_(false,$(trs[i]).data("index"));}}};BootstrapTable.prototype.updateFormatText=function(name,text){if(this.options[sprintf('format%s',name)]){if(typeof text==='string'){this.options[sprintf('format%s',name)]=function(){return text;};}else if(typeof text==='function'){this.options[sprintf('format%s',name)]=text;}}this.initToolbar();this.initPagination();this.initBody();};// BOOTSTRAP TABLE PLUGIN DEFINITION
// =======================
var allowedMethods=['getOptions','getSelections','getAllSelections','getData','load','append','prepend','remove','removeAll','insertRow','updateRow','updateCell','updateByUniqueId','removeByUniqueId','getRowByUniqueId','showRow','hideRow','getRowsHidden','mergeCells','checkAll','uncheckAll','check','uncheck','checkBy','uncheckBy','refresh','resetView','resetWidth','destroy','showLoading','hideLoading','showColumn','hideColumn','getHiddenColumns','filterBy','scrollTo','getScrollPosition','selectPage','prevPage','nextPage','togglePagination','toggleView','refreshOptions','resetSearch','expandRow','collapseRow','expandAllRows','collapseAllRows','updateFormatText'];$.fn.bootstrapTable=function(option){var value,args=Array.prototype.slice.call(arguments,1);this.each(function(){var $this=$(this),data=$this.data('bootstrap.table'),options=$.extend({},BootstrapTable.DEFAULTS,$this.data(),(typeof option==='undefined'?'undefined':_typeof(option))==='object'&&option);if(typeof option==='string'){if($.inArray(option,allowedMethods)<0){throw new Error("Unknown method: "+option);}if(!data){return;}value=data[option].apply(data,args);if(option==='destroy'){$this.removeData('bootstrap.table');}}if(!data){$this.data('bootstrap.table',data=new BootstrapTable(this,options));}});return typeof value==='undefined'?this:value;};$.fn.bootstrapTable.Constructor=BootstrapTable;$.fn.bootstrapTable.defaults=BootstrapTable.DEFAULTS;$.fn.bootstrapTable.columnDefaults=BootstrapTable.COLUMN_DEFAULTS;$.fn.bootstrapTable.locales=BootstrapTable.LOCALES;$.fn.bootstrapTable.methods=allowedMethods;$.fn.bootstrapTable.utils={sprintf:sprintf,getFieldIndex:getFieldIndex,compareObjects:compareObjects,calculateObjectValue:calculateObjectValue};// BOOTSTRAP TABLE INIT
// =======================
$(function(){$('[data-toggle="table"]').bootstrapTable();});}(jQuery);/*
* bootstrap-table - v1.10.0 - 2016-01-18
* https://github.com/wenzhixin/bootstrap-table
* Copyright (c) 2016 zhixin wen
* Licensed MIT License
*/!function(a){"use strict";var b=a.fn.bootstrapTable.utils.sprintf,c={json:"JSON",xml:"XML",png:"PNG",csv:"CSV",txt:"TXT",sql:"SQL",doc:"MS-Word",excel:"MS-Excel",powerpoint:"MS-Powerpoint",pdf:"PDF"};a.extend(a.fn.bootstrapTable.defaults,{showExport:!1,exportDataType:"basic",exportTypes:["json","xml","csv","txt","sql","excel"],exportOptions:{}}),a.extend(a.fn.bootstrapTable.defaults.icons,{"export":"glyphicon-export icon-share"});var d=a.fn.bootstrapTable.Constructor,e=d.prototype.initToolbar;d.prototype.initToolbar=function(){if(this.showToolbar=this.options.showExport,e.apply(this,Array.prototype.slice.apply(arguments)),this.options.showExport){var d=this,f=this.$toolbar.find(">.btn-group"),g=f.find("div.export");if(!g.length){g=a(['<div class="export btn-group">','<button class="btn btn-default'+b(" btn-%s",this.options.iconSize)+' dropdown-toggle" data-toggle="dropdown" type="button">',b('<i class="%s %s"></i> ',this.options.iconsPrefix,this.options.icons["export"]),'<span class="caret"></span>',"</button>",'<ul class="dropdown-menu" role="menu">',"</ul>","</div>"].join("")).appendTo(f);var h=g.find(".dropdown-menu"),i=this.options.exportTypes;if("string"==typeof this.options.exportTypes){var j=this.options.exportTypes.slice(1,-1).replace(/ /g,"").split(",");i=[],a.each(j,function(a,b){i.push(b.slice(1,-1));});}a.each(i,function(a,b){c.hasOwnProperty(b)&&h.append(['<li data-type="'+b+'">','<a href="javascript:void(0)">',c[b],"</a>","</li>"].join(""));}),h.find("li").click(function(){var b=a(this).data("type"),c=function c(){d.$el.tableExport(a.extend({},d.options.exportOptions,{type:b,escape:!1}));};if("all"===d.options.exportDataType&&d.options.pagination)d.$el.one("load-success.bs.table page-change.bs.table",function(){c(),d.togglePagination();}),d.togglePagination();else if("selected"===d.options.exportDataType){var e=d.getData(),f=d.getAllSelections();d.load(f),c(),d.load(e);}else c();});}}};}(jQuery);/**
 * Table export
 */(function(c){c.fn.extend({tableExport:function tableExport(p){function y(b,u,d,e,k){if(-1==c.inArray(d,a.ignoreRow)&&-1==c.inArray(d-e,a.ignoreRow)){var L=c(b).filter(function(){return"none"!=c(this).data("tableexport-display")&&(c(this).is(":visible")||"always"==c(this).data("tableexport-display")||"always"==c(this).closest("table").data("tableexport-display"));}).find(u),f=0;L.each(function(b){if(("always"==c(this).data("tableexport-display")||"none"!=c(this).css("display")&&"hidden"!=c(this).css("visibility")&&"none"!=c(this).data("tableexport-display"))&&-1==c.inArray(b,a.ignoreColumn)&&-1==c.inArray(b-L.length,a.ignoreColumn)&&"function"===typeof k){var e,u=0,g,h=0;if("undefined"!=typeof B[d]&&0<B[d].length)for(e=0;e<=b;e++){"undefined"!=typeof B[d][e]&&(k(null,d,e),delete B[d][e],b++);}c(this).is("[colspan]")&&(u=parseInt(c(this).attr("colspan")),f+=0<u?u-1:0);c(this).is("[rowspan]")&&(h=parseInt(c(this).attr("rowspan")));k(this,d,b);for(e=0;e<u-1;e++){k(null,d,b+e);}if(h)for(g=1;g<h;g++){for("undefined"==typeof B[d+g]&&(B[d+g]=[]),B[d+g][b+f]="",e=1;e<u;e++){B[d+g][b+f-e]="";}}}});}}function M(b){!0===a.consoleLog&&console.log(b.output());if("string"===a.outputMode)return b.output();if("base64"===a.outputMode)return C(b.output());try{var u=b.output("blob");saveAs(u,a.fileName+".pdf");}catch(d){D(a.fileName+".pdf","data:application/pdf;base64,",b.output());}}function N(b,a,d){var e=0;"undefined"!=typeof d&&(e=d.colspan);if(0<=e){for(var k=b.width,c=b.textPos.x,f=a.table.columns.indexOf(a.column),g=1;g<e;g++){k+=a.table.columns[f+g].width;}1<e&&("right"===b.styles.halign?c=b.textPos.x+k-b.width:"center"===b.styles.halign&&(c=b.textPos.x+(k-b.width)/2));b.width=k;b.textPos.x=c;"undefined"!=typeof d&&1<d.rowspan&&("middle"===b.styles.valign?b.textPos.y+=b.height*(d.rowspan-1)/2:"bottom"===b.styles.valign&&(b.textPos.y+=(d.rowspan-1)*b.height),b.height*=d.rowspan);if("middle"===b.styles.valign||"bottom"===b.styles.valign)d=("string"===typeof b.text?b.text.split(/\r\n|\r|\n/g):b.text).length||1,2<d&&(b.textPos.y-=(2-1.15)/2*a.row.styles.fontSize*(d-2)/3);return!0;}return!1;}function J(b,a,d){return b.replace(new RegExp(a.replace(/([.*+?^=!:${}()|\[\]\/\\])/g,"\\$1"),"g"),d);}function V(b){b=J(b||"0",a.numbers.html.decimalMark,".");b=J(b,a.numbers.html.thousandsSeparator,"");return"number"===typeof b||!1!==jQuery.isNumeric(b)?b:!1;}function v(b,u,d){var e="";if(null!=b){b=c(b);var k=b.html();"function"===typeof a.onCellHtmlData&&(k=a.onCellHtmlData(b,u,d,k));if(!0===a.htmlContent)e=c.trim(k);else{var f=k.replace(/\n/g,'\u2028').replace(/<br\s*[\/]?>/gi,'⁠'),k=c("<div/>").html(f).contents(),f="";c.each(k.text().split('\u2028'),function(b,a){0<b&&(f+=" ");f+=c.trim(a);});c.each(f.split('⁠'),function(b,a){0<b&&(e+="\n");e+=c.trim(a).replace(/\u00AD/g,"");});if(a.numbers.html.decimalMark!=a.numbers.output.decimalMark||a.numbers.html.thousandsSeparator!=a.numbers.output.thousandsSeparator)if(k=V(e),!1!==k){var g=(""+k).split(".");1==g.length&&(g[1]="");var h=3<g[0].length?g[0].length%3:0,e=(0>k?"-":"")+(a.numbers.output.thousandsSeparator?(h?g[0].substr(0,h)+a.numbers.output.thousandsSeparator:"")+g[0].substr(h).replace(/(\d{3})(?=\d)/g,"$1"+a.numbers.output.thousandsSeparator):g[0])+(g[1].length?a.numbers.output.decimalMark+g[1]:"");}}!0===a.escape&&(e=escape(e));"function"===typeof a.onCellData&&(e=a.onCellData(b,u,d,e));}return e;}function W(b,a,d){return a+"-"+d.toLowerCase();}function O(b,a){var d=/^rgb\((\d{1,3}),\s*(\d{1,3}),\s*(\d{1,3})\)$/.exec(b),e=a;d&&(e=[parseInt(d[1]),parseInt(d[2]),parseInt(d[3])]);return e;}function P(b){var a=E(b,"text-align"),d=E(b,"font-weight"),e=E(b,"font-style"),k="";"start"==a&&(a="rtl"==E(b,"direction")?"right":"left");700<=d&&(k="bold");"italic"==e&&(k+=e);""==k&&(k="normal");return{style:{align:a,bcolor:O(E(b,"background-color"),[255,255,255]),color:O(E(b,"color"),[0,0,0]),fstyle:k},colspan:parseInt(c(b).attr("colspan"))||0,rowspan:parseInt(c(b).attr("rowspan"))||0};}function E(b,a){try{return window.getComputedStyle?(a=a.replace(/([a-z])([A-Z])/,W),window.getComputedStyle(b,null).getPropertyValue(a)):b.currentStyle?b.currentStyle[a]:b.style[a];}catch(d){}return"";}function K(b,a,d){a=E(b,a).match(/\d+/);if(null!==a){a=a[0];var e=document.createElement("div");e.style.overflow="hidden";e.style.visibility="hidden";b.parentElement.appendChild(e);e.style.width=100+d;d=100/e.offsetWidth;b.parentElement.removeChild(e);return a*d;}return 0;}function D(a,c,d){var e=window.navigator.userAgent;if(0<e.indexOf("MSIE ")||e.match(/Trident.*rv\:11\./)){if(c=document.createElement("iframe"))document.body.appendChild(c),c.setAttribute("style","display:none"),c.contentDocument.open("txt/html","replace"),c.contentDocument.write(d),c.contentDocument.close(),c.focus(),c.contentDocument.execCommand("SaveAs",!0,a),document.body.removeChild(c);}else if(e=document.createElement("a")){e.style.display="none";e.download=a;0<=c.toLowerCase().indexOf("base64,")?e.href=c+C(d):e.href=c+encodeURIComponent(d);document.body.appendChild(e);if(document.createEvent)null==H&&(H=document.createEvent("MouseEvents")),H.initEvent("click",!0,!1),e.dispatchEvent(H);else if(document.createEventObject)e.fireEvent("onclick");else if("function"==typeof e.onclick)e.onclick();document.body.removeChild(e);}}function C(a){var c="",d,e,k,g,f,h,l=0;a=a.replace(/\x0d\x0a/g,"\n");e="";for(k=0;k<a.length;k++){g=a.charCodeAt(k),128>g?e+=String.fromCharCode(g):(127<g&&2048>g?e+=String.fromCharCode(g>>6|192):(e+=String.fromCharCode(g>>12|224),e+=String.fromCharCode(g>>6&63|128)),e+=String.fromCharCode(g&63|128));}for(a=e;l<a.length;){d=a.charCodeAt(l++),e=a.charCodeAt(l++),k=a.charCodeAt(l++),g=d>>2,d=(d&3)<<4|e>>4,f=(e&15)<<2|k>>6,h=k&63,isNaN(e)?f=h=64:isNaN(k)&&(h=64),c=c+"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=".charAt(g)+"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=".charAt(d)+"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=".charAt(f)+"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=".charAt(h);}return c;}var a={consoleLog:!1,csvEnclosure:'"',csvSeparator:",",csvUseBOM:!0,displayTableName:!1,escape:!1,excelstyles:["border-bottom","border-top","border-left","border-right"],fileName:"tableExport",htmlContent:!1,ignoreColumn:[],ignoreRow:[],jspdf:{orientation:"p",unit:"pt",format:"a4",margins:{left:20,right:10,top:10,bottom:10},autotable:{styles:{cellPadding:2,rowHeight:12,fontSize:8,fillColor:255,textColor:50,fontStyle:"normal",overflow:"ellipsize",halign:"left",valign:"middle"},headerStyles:{fillColor:[52,73,94],textColor:255,fontStyle:"bold",halign:"center"},alternateRowStyles:{fillColor:245},tableExport:{onAfterAutotable:null,onBeforeAutotable:null,onTable:null}}},numbers:{html:{decimalMark:".",thousandsSeparator:","},output:{decimalMark:".",thousandsSeparator:","}},onCellData:null,onCellHtmlData:null,outputMode:"file",tbodySelector:"tr",theadSelector:"tr",tableName:"myTableName",type:"csv",worksheetName:"xlsWorksheetName"},r=this,H=null,q=[],n=[],m=0,B=[],g="";c.extend(!0,a,p);if("csv"==a.type||"txt"==a.type){p=function p(b,f,d,e){n=c(r).find(b).first().find(f);n.each(function(){g="";y(this,d,m,e+n.length,function(b,e,d){var c=g,f="";if(null!=b)if(b=v(b,e,d),e=null===b||""==b?"":b.toString(),b instanceof Date)f=a.csvEnclosure+b.toLocaleString()+a.csvEnclosure;else if(f=J(e,a.csvEnclosure,a.csvEnclosure+a.csvEnclosure),0<=f.indexOf(a.csvSeparator)||/[\r\n ]/g.test(f))f=a.csvEnclosure+f+a.csvEnclosure;g=c+(f+a.csvSeparator);});g=c.trim(g).substring(0,g.length-1);0<g.length&&(0<w.length&&(w+="\n"),w+=g);m++;});return n.length;};var w="",z=0,m=0,z=z+p("thead",a.theadSelector,"th,td",z),z=z+p("tbody",a.tbodySelector,"td",z);p("tfoot",a.tbodySelector,"td",z);w+="\n";!0===a.consoleLog&&console.log(w);if("string"===a.outputMode)return w;if("base64"===a.outputMode)return C(w);try{var A=new Blob([w],{type:"text/"+("csv"==a.type?"csv":"plain")+";charset=utf-8"});saveAs(A,a.fileName+"."+a.type,"csv"!=a.type||!1===a.csvUseBOM);}catch(b){D(a.fileName+"."+a.type,"data:text/"+("csv"==a.type?"csv":"plain")+";charset=utf-8,"+("csv"==a.type&&a.csvUseBOM?'﻿':""),w);}}else if("sql"==a.type){var m=0,l="INSERT INTO `"+a.tableName+"` (",q=c(r).find("thead").first().find(a.theadSelector);q.each(function(){y(this,"th,td",m,q.length,function(a,c,d){l+="'"+v(a,c,d)+"',";});m++;l=c.trim(l);l=c.trim(l).substring(0,l.length-1);});l+=") VALUES ";n=c(r).find("tbody").first().find(a.tbodySelector);n.each(function(){g="";y(this,"td",m,q.length+n.length,function(a,c,d){g+="'"+v(a,c,d)+"',";});3<g.length&&(l+="("+g,l=c.trim(l).substring(0,l.length-1),l+="),");m++;});l=c.trim(l).substring(0,l.length-1);l+=";";!0===a.consoleLog&&console.log(l);if("string"===a.outputMode)return l;if("base64"===a.outputMode)return C(l);try{A=new Blob([l],{type:"text/plain;charset=utf-8"}),saveAs(A,a.fileName+".sql");}catch(b){D(a.fileName+".sql","data:application/sql;charset=utf-8,",l);}}else if("json"==a.type){var Q=[],q=c(r).find("thead").first().find(a.theadSelector);q.each(function(){var a=[];y(this,"th,td",m,q.length,function(c,d,e){a.push(v(c,d,e));});Q.push(a);});var R=[],n=c(r).find("tbody").first().find(a.tbodySelector);n.each(function(){var a=[];y(this,"td",m,q.length+n.length,function(c,d,e){a.push(v(c,d,e));});0<a.length&&(1!=a.length||""!=a[0])&&R.push(a);m++;});p=[];p.push({header:Q,data:R});p=JSON.stringify(p);!0===a.consoleLog&&console.log(p);if("string"===a.outputMode)return p;if("base64"===a.outputMode)return C(p);try{A=new Blob([p],{type:"application/json;charset=utf-8"}),saveAs(A,a.fileName+".json");}catch(b){D(a.fileName+".json","data:application/json;charset=utf-8;base64,",p);}}else if("xml"===a.type){var m=0,t='<?xml version="1.0" encoding="utf-8"?>',t=t+"<tabledata><fields>",q=c(r).find("thead").first().find(a.theadSelector);q.each(function(){y(this,"th,td",m,n.length,function(a,c,d){t+="<field>"+v(a,c,d)+"</field>";});m++;});var t=t+"</fields><data>",S=1,n=c(r).find("tbody").first().find(a.tbodySelector);n.each(function(){var a=1;g="";y(this,"td",m,q.length+n.length,function(c,d,e){g+="<column-"+a+">"+v(c,d,e)+"</column-"+a+">";a++;});0<g.length&&"<column-1></column-1>"!=g&&(t+='<row id="'+S+'">'+g+"</row>",S++);m++;});t+="</data></tabledata>";!0===a.consoleLog&&console.log(t);if("string"===a.outputMode)return t;if("base64"===a.outputMode)return C(t);try{A=new Blob([t],{type:"application/xml;charset=utf-8"}),saveAs(A,a.fileName+".xml");}catch(b){D(a.fileName+".xml","data:application/xml;charset=utf-8;base64,",t);}}else if("excel"==a.type||"xls"==a.type||"word"==a.type||"doc"==a.type){p="excel"==a.type||"xls"==a.type?"excel":"word";var z="excel"==p?"xls":"doc",f="xls"==z?'xmlns:x="urn:schemas-microsoft-com:office:excel"':'xmlns:w="urn:schemas-microsoft-com:office:word"',m=0,x="<table><thead>",q=c(r).find("thead").first().find(a.theadSelector);q.each(function(){g="";y(this,"th,td",m,q.length,function(b,f,d){if(null!=b){g+='<th style="';for(var e in a.excelstyles){a.excelstyles.hasOwnProperty(e)&&(g+=a.excelstyles[e]+": "+c(b).css(a.excelstyles[e])+";");}c(b).is("[colspan]")&&(g+='" colspan="'+c(b).attr("colspan"));c(b).is("[rowspan]")&&(g+='" rowspan="'+c(b).attr("rowspan"));g+='">'+v(b,f,d)+"</th>";}});0<g.length&&(x+="<tr>"+g+"</tr>");m++;});x+="</thead><tbody>";n=c(r).find("tbody").first().find(a.tbodySelector);n.each(function(){g="";y(this,"td",m,q.length+n.length,function(b,f,d){if(null!=b){g+='<td style="';for(var e in a.excelstyles){a.excelstyles.hasOwnProperty(e)&&(g+=a.excelstyles[e]+": "+c(b).css(a.excelstyles[e])+";");}c(b).is("[colspan]")&&(g+='" colspan="'+c(b).attr("colspan"));c(b).is("[rowspan]")&&(g+='" rowspan="'+c(b).attr("rowspan"));g+='">'+v(b,f,d)+"</td>";}});0<g.length&&(x+="<tr>"+g+"</tr>");m++;});a.displayTableName&&(x+="<tr><td></td></tr><tr><td></td></tr><tr><td>"+v(c("<p>"+a.tableName+"</p>"))+"</td></tr>");x+="</tbody></table>";!0===a.consoleLog&&console.log(x);f='<html xmlns:o="urn:schemas-microsoft-com:office:office" '+f+' xmlns="http://www.w3.org/TR/REC-html40">'+('<meta http-equiv="content-type" content="application/vnd.ms-'+p+'; charset=UTF-8">');f+="<head>";"excel"===p&&(f+="\x3c!--[if gte mso 9]>",f+="<xml>",f+="<x:ExcelWorkbook>",f+="<x:ExcelWorksheets>",f+="<x:ExcelWorksheet>",f+="<x:Name>",f+=a.worksheetName,f+="</x:Name>",f+="<x:WorksheetOptions>",f+="<x:DisplayGridlines/>",f+="</x:WorksheetOptions>",f+="</x:ExcelWorksheet>",f+="</x:ExcelWorksheets>",f+="</x:ExcelWorkbook>",f+="</xml>",f+="<![endif]--\x3e");f+="</head>";f+="<body>";f+=x;f+="</body>";f+="</html>";!0===a.consoleLog&&console.log(f);if("string"===a.outputMode)return f;if("base64"===a.outputMode)return C(f);try{A=new Blob([f],{type:"application/vnd.ms-"+a.type}),saveAs(A,a.fileName+"."+z);}catch(b){D(a.fileName+"."+z,"data:application/vnd.ms-"+p+";base64,",f);}}else if("png"==a.type)html2canvas(c(r)[0],{allowTaint:!0,background:"#fff",onrendered:function onrendered(b){b=b.toDataURL();b=b.substring(22);for(var c=atob(b),d=new ArrayBuffer(c.length),e=new Uint8Array(d),f=0;f<c.length;f++){e[f]=c.charCodeAt(f);}!0===a.consoleLog&&console.log(c);if("string"===a.outputMode)return c;if("base64"===a.outputMode)return C(b);try{var g=new Blob([d],{type:"image/png"});saveAs(g,a.fileName+".png");}catch(h){D(a.fileName+".png","data:image/png;base64,",b);}}});else if("pdf"==a.type)if(!1===a.jspdf.autotable){var A={dim:{w:K(c(r).first().get(0),"width","mm"),h:K(c(r).first().get(0),"height","mm")},pagesplit:!1},T=new jsPDF(a.jspdf.orientation,a.jspdf.unit,a.jspdf.format);T.addHTML(c(r).first(),a.jspdf.margins.left,a.jspdf.margins.top,A,function(){M(T);});}else{var h=a.jspdf.autotable.tableExport;if("string"===typeof a.jspdf.format&&"bestfit"===a.jspdf.format.toLowerCase()){var F={a0:[2383.94,3370.39],a1:[1683.78,2383.94],a2:[1190.55,1683.78],a3:[841.89,1190.55],a4:[595.28,841.89]},I="",G="",U=0;c(r).filter(":visible").each(function(){if("none"!=c(this).css("display")){var a=K(c(this).get(0),"width","pt");if(a>U){a>F.a0[0]&&(I="a0",G="l");for(var f in F){F.hasOwnProperty(f)&&F[f][1]>a&&(I=f,G="l",F[f][0]>a&&(G="p"));}U=a;}}});a.jspdf.format=""==I?"a4":I;a.jspdf.orientation=""==G?"w":G;}h.doc=new jsPDF(a.jspdf.orientation,a.jspdf.unit,a.jspdf.format);c(r).filter(function(){return"none"!=c(this).data("tableexport-display")&&(c(this).is(":visible")||"always"==c(this).data("tableexport-display"));}).each(function(){var b,f=0;h.columns=[];h.rows=[];h.rowoptions={};if("function"===typeof h.onTable&&!1===h.onTable(c(this),a))return!0;a.jspdf.autotable.tableExport=null;var d=c.extend(!0,{},a.jspdf.autotable);a.jspdf.autotable.tableExport=h;d.margin={};c.extend(!0,d.margin,a.jspdf.margins);d.tableExport=h;"function"!==typeof d.beforePageContent&&(d.beforePageContent=function(a){1==a.pageCount&&a.table.rows.concat(a.table.headerRow).forEach(function(b){0<b.height&&(b.height+=(2-1.15)/2*b.styles.fontSize,a.table.height+=(2-1.15)/2*b.styles.fontSize);});});"function"!==typeof d.createdHeaderCell&&(d.createdHeaderCell=function(a,b){if("undefined"!=typeof h.columns[b.column.dataKey]){var c=h.columns[b.column.dataKey];a.styles.halign=c.style.align;"inherit"===d.styles.fillColor&&(a.styles.fillColor=c.style.bcolor);"inherit"===d.styles.textColor&&(a.styles.textColor=c.style.color);"inherit"===d.styles.fontStyle&&(a.styles.fontStyle=c.style.fstyle);}});"function"!==typeof d.createdCell&&(d.createdCell=function(a,b){var c=h.rowoptions[b.row.index+":"+b.column.dataKey];"undefined"!=typeof c&&"undefined"!=typeof c.style&&(a.styles.halign=c.style.align,"inherit"===d.styles.fillColor&&(a.styles.fillColor=c.style.bcolor),"inherit"===d.styles.textColor&&(a.styles.textColor=c.style.color),"inherit"===d.styles.fontStyle&&(a.styles.fontStyle=c.style.fstyle));});"function"!==typeof d.drawHeaderCell&&(d.drawHeaderCell=function(a,b){var c=h.columns[b.column.dataKey];return 1!=c.style.hasOwnProperty("hidden")||!0!==c.style.hidden?N(a,b,c):!1;});"function"!==typeof d.drawCell&&(d.drawCell=function(a,b){return N(a,b,h.rowoptions[b.row.index+":"+b.column.dataKey]);});q=c(this).find("thead").find(a.theadSelector);q.each(function(){b=0;y(this,"th,td",f,q.length,function(a,c,e){var d=P(a);d.title=v(a,c,e);d.key=b++;h.columns.push(d);});f++;});var e=0;n=c(this).find("tbody").find(a.tbodySelector);n.each(function(){var a=[];b=0;y(this,"td",f,q.length+n.length,function(d,f,g){if("undefined"===typeof h.columns[b]){var l={title:"",key:b,style:{hidden:!0}};h.columns.push(l);}null!==d?h.rowoptions[e+":"+b++]=P(d):(l=c.extend(!0,{},h.rowoptions[e+":"+(b-1)]),l.colspan=-1,h.rowoptions[e+":"+b++]=l);a.push(v(d,f,g));});a.length&&(h.rows.push(a),e++);f++;});if("function"===typeof h.onBeforeAutotable)h.onBeforeAutotable(c(this),h.columns,h.rows,d);h.doc.autoTable(h.columns,h.rows,d);if("function"===typeof h.onAfterAutotable)h.onAfterAutotable(c(this),d);a.jspdf.autotable.startY=h.doc.autoTableEndPosY()+d.margin.top;});M(h.doc);h.columns.length=0;h.rows.length=0;delete h.doc;h.doc=null;}return this;}});})(jQuery);

},{}],5:[function(require,module,exports){
//= lib/responsive-bootstrap-toolkit/bootstrap-toolkit.min.js
//= lib/clickout/jquery.clickout.js
//= lib/jScrollPane/jquery.mousewheel.js
//= lib/jScrollPane/jquery.jscrollpane.min.js
"use strict";

},{}]},{},[4,2,1,3,5]);

//# sourceMappingURL=bundle.js.map
