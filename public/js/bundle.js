(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
/*! ========================================================================
 * Bootstrap Toggle: bootstrap-toggle.js v2.2.0
 * http://www.bootstraptoggle.com
 * ========================================================================
 * Copyright 2014 Min Hur, The New York Times Company
 * Licensed under MIT
 * ======================================================================== */


 +function ($) {
 	'use strict';

	// TOGGLE PUBLIC CLASS DEFINITION
	// ==============================

	var Toggle = function (element, options) {
		this.$element  = $(element)
		this.options   = $.extend({}, this.defaults(), options)
		this.render()
	}

	Toggle.VERSION  = '2.2.0'

	Toggle.DEFAULTS = {
		on: 'On',
		off: 'Off',
		onstyle: 'primary',
		offstyle: 'default',
		size: 'normal',
		style: '',
		width: null,
		height: null
	}

	Toggle.prototype.defaults = function() {
		return {
			on: this.$element.attr('data-on') || Toggle.DEFAULTS.on,
			off: this.$element.attr('data-off') || Toggle.DEFAULTS.off,
			onstyle: this.$element.attr('data-onstyle') || Toggle.DEFAULTS.onstyle,
			offstyle: this.$element.attr('data-offstyle') || Toggle.DEFAULTS.offstyle,
			size: this.$element.attr('data-size') || Toggle.DEFAULTS.size,
			style: this.$element.attr('data-style') || Toggle.DEFAULTS.style,
			width: this.$element.attr('data-width') || Toggle.DEFAULTS.width,
			height: this.$element.attr('data-height') || Toggle.DEFAULTS.height
		}
	}

	Toggle.prototype.render = function () {
		this._onstyle = 'btn-' + this.options.onstyle
		this._offstyle = 'btn-' + this.options.offstyle
		var size = this.options.size === 'large' ? 'btn-lg'
			: this.options.size === 'small' ? 'btn-sm'
			: this.options.size === 'mini' ? 'btn-xs'
			: ''
		var $toggleOn = $('<label class="btn">').html(this.options.on)
			.addClass(this._onstyle + ' ' + size)
		var $toggleOff = $('<label class="btn">').html(this.options.off)
			.addClass(this._offstyle + ' ' + size + ' active')
		var $toggleHandle = $('<span class="toggle-handle btn btn-default">')
			.addClass(size)
		var $toggleGroup = $('<div class="toggle-group">')
			.append($toggleOn, $toggleOff, $toggleHandle)
		var $toggle = $('<div class="toggle btn" data-toggle="toggle">')
			.addClass( this.$element.prop('checked') ? this._onstyle : this._offstyle+' off' )
			.addClass(size).addClass(this.options.style)

		this.$element.wrap($toggle)
		$.extend(this, {
			$toggle: this.$element.parent(),
			$toggleOn: $toggleOn,
			$toggleOff: $toggleOff,
			$toggleGroup: $toggleGroup
		})
		this.$toggle.append($toggleGroup)

		var width = this.options.width || Math.max($toggleOn.outerWidth(), $toggleOff.outerWidth())+($toggleHandle.outerWidth()/2)
		var height = this.options.height || Math.max($toggleOn.outerHeight(), $toggleOff.outerHeight())
		$toggleOn.addClass('toggle-on')
		$toggleOff.addClass('toggle-off')
		this.$toggle.css({ width: width, height: height })
		if (this.options.height) {
			$toggleOn.css('line-height', $toggleOn.height() + 'px')
			$toggleOff.css('line-height', $toggleOff.height() + 'px')
		}
		this.update(true)
		this.trigger(true)
	}

	Toggle.prototype.toggle = function () {
		if (this.$element.prop('checked')) this.off()
		else this.on()
	}

	Toggle.prototype.on = function (silent) {
		if (this.$element.prop('disabled')) return false
		this.$toggle.removeClass(this._offstyle + ' off').addClass(this._onstyle)
		this.$element.prop('checked', true)
		if (!silent) this.trigger()
	}

	Toggle.prototype.off = function (silent) {
		if (this.$element.prop('disabled')) return false
		this.$toggle.removeClass(this._onstyle).addClass(this._offstyle + ' off')
		this.$element.prop('checked', false)
		if (!silent) this.trigger()
	}

	Toggle.prototype.enable = function () {
		this.$toggle.removeAttr('disabled')
		this.$element.prop('disabled', false)
	}

	Toggle.prototype.disable = function () {
		this.$toggle.attr('disabled', 'disabled')
		this.$element.prop('disabled', true)
	}

	Toggle.prototype.update = function (silent) {
		if (this.$element.prop('disabled')) this.disable()
		else this.enable()
		if (this.$element.prop('checked')) this.on(silent)
		else this.off(silent)
	}

	Toggle.prototype.trigger = function (silent) {
		this.$element.off('change.bs.toggle')
		if (!silent) this.$element.change()
		this.$element.on('change.bs.toggle', $.proxy(function() {
			this.update()
		}, this))
	}

	Toggle.prototype.destroy = function() {
		this.$element.off('change.bs.toggle')
		this.$toggleGroup.remove()
		this.$element.removeData('bs.toggle')
		this.$element.unwrap()
	}

	// TOGGLE PLUGIN DEFINITION
	// ========================

	function Plugin(option) {
		return this.each(function () {
			var $this   = $(this)
			var data    = $this.data('bs.toggle')
			var options = typeof option == 'object' && option

			if (!data) $this.data('bs.toggle', (data = new Toggle(this, options)))
			if (typeof option == 'string' && data[option]) data[option]()
		})
	}

	var old = $.fn.bootstrapToggle

	$.fn.bootstrapToggle             = Plugin
	$.fn.bootstrapToggle.Constructor = Toggle

	// TOGGLE NO CONFLICT
	// ==================

	$.fn.toggle.noConflict = function () {
		$.fn.bootstrapToggle = old
		return this
	}

	// TOGGLE DATA-API
	// ===============

	$(function() {
		$('input[type=checkbox][data-toggle^=toggle]').bootstrapToggle()
	})

	$(document).on('click.bs.toggle', 'div[data-toggle^=toggle]', function(e) {
		var $checkbox = $(this).find('input[type=checkbox]')
		$checkbox.bootstrapToggle('toggle')
		e.preventDefault()
	})

}(jQuery);

},{}],2:[function(require,module,exports){
/*
 * Date Format 1.2.3
 * (c) 2007-2009 Steven Levithan <stevenlevithan.com>
 * MIT license
 *
 * Includes enhancements by Scott Trenda <scott.trenda.net>
 * and Kris Kowal <cixar.com/~kris.kowal/>
 *
 * Accepts a date, a mask, or a date and a mask.
 * Returns a formatted version of the given date.
 * The date defaults to the current date/time.
 * The mask defaults to dateFormat.masks.default.
 */

(function(global) {
  'use strict';

  var dateFormat = (function() {
      var token = /d{1,4}|m{1,4}|yy(?:yy)?|([HhMsTt])\1?|[LloSZWN]|'[^']*'|'[^']*'/g;
      var timezone = /\b(?:[PMCEA][SDP]T|(?:Pacific|Mountain|Central|Eastern|Atlantic) (?:Standard|Daylight|Prevailing) Time|(?:GMT|UTC)(?:[-+]\d{4})?)\b/g;
      var timezoneClip = /[^-+\dA-Z]/g;
  
      // Regexes and supporting functions are cached through closure
      return function (date, mask, utc, gmt) {
  
        // You can't provide utc if you skip other args (use the 'UTC:' mask prefix)
        if (arguments.length === 1 && kindOf(date) === 'string' && !/\d/.test(date)) {
          mask = date;
          date = undefined;
        }
  
        date = date || new Date;
  
        if(!(date instanceof Date)) {
          date = new Date(date);
        }
  
        if (isNaN(date)) {
          throw TypeError('Invalid date');
        }
  
        mask = String(dateFormat.masks[mask] || mask || dateFormat.masks['default']);
  
        // Allow setting the utc/gmt argument via the mask
        var maskSlice = mask.slice(0, 4);
        if (maskSlice === 'UTC:' || maskSlice === 'GMT:') {
          mask = mask.slice(4);
          utc = true;
          if (maskSlice === 'GMT:') {
            gmt = true;
          }
        }
  
        var _ = utc ? 'getUTC' : 'get';
        var d = date[_ + 'Date']();
        var D = date[_ + 'Day']();
        var m = date[_ + 'Month']();
        var y = date[_ + 'FullYear']();
        var H = date[_ + 'Hours']();
        var M = date[_ + 'Minutes']();
        var s = date[_ + 'Seconds']();
        var L = date[_ + 'Milliseconds']();
        var o = utc ? 0 : date.getTimezoneOffset();
        var W = getWeek(date);
        var N = getDayOfWeek(date);
        var flags = {
          d:    d,
          dd:   pad(d),
          ddd:  dateFormat.i18n.dayNames[D],
          dddd: dateFormat.i18n.dayNames[D + 7],
          m:    m + 1,
          mm:   pad(m + 1),
          mmm:  dateFormat.i18n.monthNames[m],
          mmmm: dateFormat.i18n.monthNames[m + 12],
          yy:   String(y).slice(2),
          yyyy: y,
          h:    H % 12 || 12,
          hh:   pad(H % 12 || 12),
          H:    H,
          HH:   pad(H),
          M:    M,
          MM:   pad(M),
          s:    s,
          ss:   pad(s),
          l:    pad(L, 3),
          L:    pad(Math.round(L / 10)),
          t:    H < 12 ? 'a'  : 'p',
          tt:   H < 12 ? 'am' : 'pm',
          T:    H < 12 ? 'A'  : 'P',
          TT:   H < 12 ? 'AM' : 'PM',
          Z:    gmt ? 'GMT' : utc ? 'UTC' : (String(date).match(timezone) || ['']).pop().replace(timezoneClip, ''),
          o:    (o > 0 ? '-' : '+') + pad(Math.floor(Math.abs(o) / 60) * 100 + Math.abs(o) % 60, 4),
          S:    ['th', 'st', 'nd', 'rd'][d % 10 > 3 ? 0 : (d % 100 - d % 10 != 10) * d % 10],
          W:    W,
          N:    N
        };
  
        return mask.replace(token, function (match) {
          if (match in flags) {
            return flags[match];
          }
          return match.slice(1, match.length - 1);
        });
      };
    })();

  dateFormat.masks = {
    'default':               'ddd mmm dd yyyy HH:MM:ss',
    'shortDate':             'm/d/yy',
    'mediumDate':            'mmm d, yyyy',
    'longDate':              'mmmm d, yyyy',
    'fullDate':              'dddd, mmmm d, yyyy',
    'shortTime':             'h:MM TT',
    'mediumTime':            'h:MM:ss TT',
    'longTime':              'h:MM:ss TT Z',
    'isoDate':               'yyyy-mm-dd',
    'isoTime':               'HH:MM:ss',
    'isoDateTime':           'yyyy-mm-dd\'T\'HH:MM:sso',
    'isoUtcDateTime':        'UTC:yyyy-mm-dd\'T\'HH:MM:ss\'Z\'',
    'expiresHeaderFormat':   'ddd, dd mmm yyyy HH:MM:ss Z'
  };

  // Internationalization strings
  dateFormat.i18n = {
    dayNames: [
      'Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat',
      'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'
    ],
    monthNames: [
      'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec',
      'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'
    ]
  };

function pad(val, len) {
  val = String(val);
  len = len || 2;
  while (val.length < len) {
    val = '0' + val;
  }
  return val;
}

/**
 * Get the ISO 8601 week number
 * Based on comments from
 * http://techblog.procurios.nl/k/n618/news/view/33796/14863/Calculate-ISO-8601-week-and-year-in-javascript.html
 *
 * @param  {Object} `date`
 * @return {Number}
 */
function getWeek(date) {
  // Remove time components of date
  var targetThursday = new Date(date.getFullYear(), date.getMonth(), date.getDate());

  // Change date to Thursday same week
  targetThursday.setDate(targetThursday.getDate() - ((targetThursday.getDay() + 6) % 7) + 3);

  // Take January 4th as it is always in week 1 (see ISO 8601)
  var firstThursday = new Date(targetThursday.getFullYear(), 0, 4);

  // Change date to Thursday same week
  firstThursday.setDate(firstThursday.getDate() - ((firstThursday.getDay() + 6) % 7) + 3);

  // Check if daylight-saving-time-switch occured and correct for it
  var ds = targetThursday.getTimezoneOffset() - firstThursday.getTimezoneOffset();
  targetThursday.setHours(targetThursday.getHours() - ds);

  // Number of weeks between target Thursday and first Thursday
  var weekDiff = (targetThursday - firstThursday) / (86400000*7);
  return 1 + Math.floor(weekDiff);
}

/**
 * Get ISO-8601 numeric representation of the day of the week
 * 1 (for Monday) through 7 (for Sunday)
 * 
 * @param  {Object} `date`
 * @return {Number}
 */
function getDayOfWeek(date) {
  var dow = date.getDay();
  if(dow === 0) {
    dow = 7;
  }
  return dow;
}

/**
 * kind-of shortcut
 * @param  {*} val
 * @return {String}
 */
function kindOf(val) {
  if (val === null) {
    return 'null';
  }

  if (val === undefined) {
    return 'undefined';
  }

  if (typeof val !== 'object') {
    return typeof val;
  }

  if (Array.isArray(val)) {
    return 'array';
  }

  return {}.toString.call(val)
    .slice(8, -1).toLowerCase();
};



  if (typeof define === 'function' && define.amd) {
    define(function () {
      return dateFormat;
    });
  } else if (typeof exports === 'object') {
    module.exports = dateFormat;
  } else {
    global.dateFormat = dateFormat;
  }
})(this);

},{}],3:[function(require,module,exports){

/*
 *
 * More info at [www.dropzonejs.com](http://www.dropzonejs.com)
 *
 * Copyright (c) 2012, Matias Meno
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 */

(function() {
  var Dropzone, Emitter, camelize, contentLoaded, detectVerticalSquash, drawImageIOSFix, noop, without,
    __slice = [].slice,
    __hasProp = {}.hasOwnProperty,
    __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

  noop = function() {};

  Emitter = (function() {
    function Emitter() {}

    Emitter.prototype.addEventListener = Emitter.prototype.on;

    Emitter.prototype.on = function(event, fn) {
      this._callbacks = this._callbacks || {};
      if (!this._callbacks[event]) {
        this._callbacks[event] = [];
      }
      this._callbacks[event].push(fn);
      return this;
    };

    Emitter.prototype.emit = function() {
      var args, callback, callbacks, event, _i, _len;
      event = arguments[0], args = 2 <= arguments.length ? __slice.call(arguments, 1) : [];
      this._callbacks = this._callbacks || {};
      callbacks = this._callbacks[event];
      if (callbacks) {
        for (_i = 0, _len = callbacks.length; _i < _len; _i++) {
          callback = callbacks[_i];
          callback.apply(this, args);
        }
      }
      return this;
    };

    Emitter.prototype.removeListener = Emitter.prototype.off;

    Emitter.prototype.removeAllListeners = Emitter.prototype.off;

    Emitter.prototype.removeEventListener = Emitter.prototype.off;

    Emitter.prototype.off = function(event, fn) {
      var callback, callbacks, i, _i, _len;
      if (!this._callbacks || arguments.length === 0) {
        this._callbacks = {};
        return this;
      }
      callbacks = this._callbacks[event];
      if (!callbacks) {
        return this;
      }
      if (arguments.length === 1) {
        delete this._callbacks[event];
        return this;
      }
      for (i = _i = 0, _len = callbacks.length; _i < _len; i = ++_i) {
        callback = callbacks[i];
        if (callback === fn) {
          callbacks.splice(i, 1);
          break;
        }
      }
      return this;
    };

    return Emitter;

  })();

  Dropzone = (function(_super) {
    var extend, resolveOption;

    __extends(Dropzone, _super);

    Dropzone.prototype.Emitter = Emitter;


    /*
    This is a list of all available events you can register on a dropzone object.
    
    You can register an event handler like this:
    
        dropzone.on("dragEnter", function() { });
     */

    Dropzone.prototype.events = ["drop", "dragstart", "dragend", "dragenter", "dragover", "dragleave", "addedfile", "addedfiles", "removedfile", "thumbnail", "error", "errormultiple", "processing", "processingmultiple", "uploadprogress", "totaluploadprogress", "sending", "sendingmultiple", "success", "successmultiple", "canceled", "canceledmultiple", "complete", "completemultiple", "reset", "maxfilesexceeded", "maxfilesreached", "queuecomplete"];

    Dropzone.prototype.defaultOptions = {
      url: null,
      method: "post",
      withCredentials: false,
      parallelUploads: 2,
      uploadMultiple: false,
      maxFilesize: 256,
      paramName: "file",
      createImageThumbnails: true,
      maxThumbnailFilesize: 10,
      thumbnailWidth: 120,
      thumbnailHeight: 120,
      filesizeBase: 1000,
      maxFiles: null,
      params: {},
      clickable: true,
      ignoreHiddenFiles: true,
      acceptedFiles: null,
      acceptedMimeTypes: null,
      autoProcessQueue: true,
      autoQueue: true,
      addRemoveLinks: false,
      previewsContainer: null,
      hiddenInputContainer: "body",
      capture: null,
      renameFilename: null,
      dictDefaultMessage: "Drop files here to upload",
      dictFallbackMessage: "Your browser does not support drag'n'drop file uploads.",
      dictFallbackText: "Please use the fallback form below to upload your files like in the olden days.",
      dictFileTooBig: "File is too big ({{filesize}}MiB). Max filesize: {{maxFilesize}}MiB.",
      dictInvalidFileType: "You can't upload files of this type.",
      dictResponseError: "Server responded with {{statusCode}} code.",
      dictCancelUpload: "Cancel upload",
      dictCancelUploadConfirmation: "Are you sure you want to cancel this upload?",
      dictRemoveFile: "Remove file",
      dictRemoveFileConfirmation: null,
      dictMaxFilesExceeded: "You can not upload any more files.",
      accept: function(file, done) {
        return done();
      },
      init: function() {
        return noop;
      },
      forceFallback: false,
      fallback: function() {
        var child, messageElement, span, _i, _len, _ref;
        this.element.className = "" + this.element.className + " dz-browser-not-supported";
        _ref = this.element.getElementsByTagName("div");
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
          child = _ref[_i];
          if (/(^| )dz-message($| )/.test(child.className)) {
            messageElement = child;
            child.className = "dz-message";
            continue;
          }
        }
        if (!messageElement) {
          messageElement = Dropzone.createElement("<div class=\"dz-message\"><span></span></div>");
          this.element.appendChild(messageElement);
        }
        span = messageElement.getElementsByTagName("span")[0];
        if (span) {
          if (span.textContent != null) {
            span.textContent = this.options.dictFallbackMessage;
          } else if (span.innerText != null) {
            span.innerText = this.options.dictFallbackMessage;
          }
        }
        return this.element.appendChild(this.getFallbackForm());
      },
      resize: function(file) {
        var info, srcRatio, trgRatio;
        info = {
          srcX: 0,
          srcY: 0,
          srcWidth: file.width,
          srcHeight: file.height
        };
        srcRatio = file.width / file.height;
        info.optWidth = this.options.thumbnailWidth;
        info.optHeight = this.options.thumbnailHeight;
        if ((info.optWidth == null) && (info.optHeight == null)) {
          info.optWidth = info.srcWidth;
          info.optHeight = info.srcHeight;
        } else if (info.optWidth == null) {
          info.optWidth = srcRatio * info.optHeight;
        } else if (info.optHeight == null) {
          info.optHeight = (1 / srcRatio) * info.optWidth;
        }
        trgRatio = info.optWidth / info.optHeight;
        if (file.height < info.optHeight || file.width < info.optWidth) {
          info.trgHeight = info.srcHeight;
          info.trgWidth = info.srcWidth;
        } else {
          if (srcRatio > trgRatio) {
            info.srcHeight = file.height;
            info.srcWidth = info.srcHeight * trgRatio;
          } else {
            info.srcWidth = file.width;
            info.srcHeight = info.srcWidth / trgRatio;
          }
        }
        info.srcX = (file.width - info.srcWidth) / 2;
        info.srcY = (file.height - info.srcHeight) / 2;
        return info;
      },

      /*
      Those functions register themselves to the events on init and handle all
      the user interface specific stuff. Overwriting them won't break the upload
      but can break the way it's displayed.
      You can overwrite them if you don't like the default behavior. If you just
      want to add an additional event handler, register it on the dropzone object
      and don't overwrite those options.
       */
      drop: function(e) {
        return this.element.classList.remove("dz-drag-hover");
      },
      dragstart: noop,
      dragend: function(e) {
        return this.element.classList.remove("dz-drag-hover");
      },
      dragenter: function(e) {
        return this.element.classList.add("dz-drag-hover");
      },
      dragover: function(e) {
        return this.element.classList.add("dz-drag-hover");
      },
      dragleave: function(e) {
        return this.element.classList.remove("dz-drag-hover");
      },
      paste: noop,
      reset: function() {
        return this.element.classList.remove("dz-started");
      },
      addedfile: function(file) {
        var node, removeFileEvent, removeLink, _i, _j, _k, _len, _len1, _len2, _ref, _ref1, _ref2, _results;
        if (this.element === this.previewsContainer) {
          this.element.classList.add("dz-started");
        }
        if (this.previewsContainer) {
          file.previewElement = Dropzone.createElement(this.options.previewTemplate.trim());
          file.previewTemplate = file.previewElement;
          this.previewsContainer.appendChild(file.previewElement);
          _ref = file.previewElement.querySelectorAll("[data-dz-name]");
          for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            node = _ref[_i];
            node.textContent = this._renameFilename(file.name);
          }
          _ref1 = file.previewElement.querySelectorAll("[data-dz-size]");
          for (_j = 0, _len1 = _ref1.length; _j < _len1; _j++) {
            node = _ref1[_j];
            node.innerHTML = this.filesize(file.size);
          }
          if (this.options.addRemoveLinks) {
            file._removeLink = Dropzone.createElement("<a class=\"dz-remove\" href=\"javascript:undefined;\" data-dz-remove>" + this.options.dictRemoveFile + "</a>");
            file.previewElement.appendChild(file._removeLink);
          }
          removeFileEvent = (function(_this) {
            return function(e) {
              e.preventDefault();
              e.stopPropagation();
              if (file.status === Dropzone.UPLOADING) {
                return Dropzone.confirm(_this.options.dictCancelUploadConfirmation, function() {
                  return _this.removeFile(file);
                });
              } else {
                if (_this.options.dictRemoveFileConfirmation) {
                  return Dropzone.confirm(_this.options.dictRemoveFileConfirmation, function() {
                    return _this.removeFile(file);
                  });
                } else {
                  return _this.removeFile(file);
                }
              }
            };
          })(this);
          _ref2 = file.previewElement.querySelectorAll("[data-dz-remove]");
          _results = [];
          for (_k = 0, _len2 = _ref2.length; _k < _len2; _k++) {
            removeLink = _ref2[_k];
            _results.push(removeLink.addEventListener("click", removeFileEvent));
          }
          return _results;
        }
      },
      removedfile: function(file) {
        var _ref;
        if (file.previewElement) {
          if ((_ref = file.previewElement) != null) {
            _ref.parentNode.removeChild(file.previewElement);
          }
        }
        return this._updateMaxFilesReachedClass();
      },
      thumbnail: function(file, dataUrl) {
        var thumbnailElement, _i, _len, _ref;
        if (file.previewElement) {
          file.previewElement.classList.remove("dz-file-preview");
          _ref = file.previewElement.querySelectorAll("[data-dz-thumbnail]");
          for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            thumbnailElement = _ref[_i];
            thumbnailElement.alt = file.name;
            thumbnailElement.src = dataUrl;
          }
          return setTimeout(((function(_this) {
            return function() {
              return file.previewElement.classList.add("dz-image-preview");
            };
          })(this)), 1);
        }
      },
      error: function(file, message) {
        var node, _i, _len, _ref, _results;
        if (file.previewElement) {
          file.previewElement.classList.add("dz-error");
          if (typeof message !== "String" && message.error) {
            message = message.error;
          }
          _ref = file.previewElement.querySelectorAll("[data-dz-errormessage]");
          _results = [];
          for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            node = _ref[_i];
            _results.push(node.textContent = message);
          }
          return _results;
        }
      },
      errormultiple: noop,
      processing: function(file) {
        if (file.previewElement) {
          file.previewElement.classList.add("dz-processing");
          if (file._removeLink) {
            return file._removeLink.textContent = this.options.dictCancelUpload;
          }
        }
      },
      processingmultiple: noop,
      uploadprogress: function(file, progress, bytesSent) {
        var node, _i, _len, _ref, _results;
        if (file.previewElement) {
          _ref = file.previewElement.querySelectorAll("[data-dz-uploadprogress]");
          _results = [];
          for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            node = _ref[_i];
            if (node.nodeName === 'PROGRESS') {
              _results.push(node.value = progress);
            } else {
              _results.push(node.style.width = "" + progress + "%");
            }
          }
          return _results;
        }
      },
      totaluploadprogress: noop,
      sending: noop,
      sendingmultiple: noop,
      success: function(file) {
        if (file.previewElement) {
          return file.previewElement.classList.add("dz-success");
        }
      },
      successmultiple: noop,
      canceled: function(file) {
        return this.emit("error", file, "Upload canceled.");
      },
      canceledmultiple: noop,
      complete: function(file) {
        if (file._removeLink) {
          file._removeLink.textContent = this.options.dictRemoveFile;
        }
        if (file.previewElement) {
          return file.previewElement.classList.add("dz-complete");
        }
      },
      completemultiple: noop,
      maxfilesexceeded: noop,
      maxfilesreached: noop,
      queuecomplete: noop,
      addedfiles: noop,
      previewTemplate: "<div class=\"dz-preview dz-file-preview\">\n  <div class=\"dz-image\"><img data-dz-thumbnail /></div>\n  <div class=\"dz-details\">\n    <div class=\"dz-size\"><span data-dz-size></span></div>\n    <div class=\"dz-filename\"><span data-dz-name></span></div>\n  </div>\n  <div class=\"dz-progress\"><span class=\"dz-upload\" data-dz-uploadprogress></span></div>\n  <div class=\"dz-error-message\"><span data-dz-errormessage></span></div>\n  <div class=\"dz-success-mark\">\n    <svg width=\"54px\" height=\"54px\" viewBox=\"0 0 54 54\" version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" xmlns:sketch=\"http://www.bohemiancoding.com/sketch/ns\">\n      <title>Check</title>\n      <defs></defs>\n      <g id=\"Page-1\" stroke=\"none\" stroke-width=\"1\" fill=\"none\" fill-rule=\"evenodd\" sketch:type=\"MSPage\">\n        <path d=\"M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z\" id=\"Oval-2\" stroke-opacity=\"0.198794158\" stroke=\"#747474\" fill-opacity=\"0.816519475\" fill=\"#FFFFFF\" sketch:type=\"MSShapeGroup\"></path>\n      </g>\n    </svg>\n  </div>\n  <div class=\"dz-error-mark\">\n    <svg width=\"54px\" height=\"54px\" viewBox=\"0 0 54 54\" version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" xmlns:sketch=\"http://www.bohemiancoding.com/sketch/ns\">\n      <title>Error</title>\n      <defs></defs>\n      <g id=\"Page-1\" stroke=\"none\" stroke-width=\"1\" fill=\"none\" fill-rule=\"evenodd\" sketch:type=\"MSPage\">\n        <g id=\"Check-+-Oval-2\" sketch:type=\"MSLayerGroup\" stroke=\"#747474\" stroke-opacity=\"0.198794158\" fill=\"#FFFFFF\" fill-opacity=\"0.816519475\">\n          <path d=\"M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z\" id=\"Oval-2\" sketch:type=\"MSShapeGroup\"></path>\n        </g>\n      </g>\n    </svg>\n  </div>\n</div>"
    };

    extend = function() {
      var key, object, objects, target, val, _i, _len;
      target = arguments[0], objects = 2 <= arguments.length ? __slice.call(arguments, 1) : [];
      for (_i = 0, _len = objects.length; _i < _len; _i++) {
        object = objects[_i];
        for (key in object) {
          val = object[key];
          target[key] = val;
        }
      }
      return target;
    };

    function Dropzone(element, options) {
      var elementOptions, fallback, _ref;
      this.element = element;
      this.version = Dropzone.version;
      this.defaultOptions.previewTemplate = this.defaultOptions.previewTemplate.replace(/\n*/g, "");
      this.clickableElements = [];
      this.listeners = [];
      this.files = [];
      if (typeof this.element === "string") {
        this.element = document.querySelector(this.element);
      }
      if (!(this.element && (this.element.nodeType != null))) {
        throw new Error("Invalid dropzone element.");
      }
      if (this.element.dropzone) {
        throw new Error("Dropzone already attached.");
      }
      Dropzone.instances.push(this);
      this.element.dropzone = this;
      elementOptions = (_ref = Dropzone.optionsForElement(this.element)) != null ? _ref : {};
      this.options = extend({}, this.defaultOptions, elementOptions, options != null ? options : {});
      if (this.options.forceFallback || !Dropzone.isBrowserSupported()) {
        return this.options.fallback.call(this);
      }
      if (this.options.url == null) {
        this.options.url = this.element.getAttribute("action");
      }
      if (!this.options.url) {
        throw new Error("No URL provided.");
      }
      if (this.options.acceptedFiles && this.options.acceptedMimeTypes) {
        throw new Error("You can't provide both 'acceptedFiles' and 'acceptedMimeTypes'. 'acceptedMimeTypes' is deprecated.");
      }
      if (this.options.acceptedMimeTypes) {
        this.options.acceptedFiles = this.options.acceptedMimeTypes;
        delete this.options.acceptedMimeTypes;
      }
      this.options.method = this.options.method.toUpperCase();
      if ((fallback = this.getExistingFallback()) && fallback.parentNode) {
        fallback.parentNode.removeChild(fallback);
      }
      if (this.options.previewsContainer !== false) {
        if (this.options.previewsContainer) {
          this.previewsContainer = Dropzone.getElement(this.options.previewsContainer, "previewsContainer");
        } else {
          this.previewsContainer = this.element;
        }
      }
      if (this.options.clickable) {
        if (this.options.clickable === true) {
          this.clickableElements = [this.element];
        } else {
          this.clickableElements = Dropzone.getElements(this.options.clickable, "clickable");
        }
      }
      this.init();
    }

    Dropzone.prototype.getAcceptedFiles = function() {
      var file, _i, _len, _ref, _results;
      _ref = this.files;
      _results = [];
      for (_i = 0, _len = _ref.length; _i < _len; _i++) {
        file = _ref[_i];
        if (file.accepted) {
          _results.push(file);
        }
      }
      return _results;
    };

    Dropzone.prototype.getRejectedFiles = function() {
      var file, _i, _len, _ref, _results;
      _ref = this.files;
      _results = [];
      for (_i = 0, _len = _ref.length; _i < _len; _i++) {
        file = _ref[_i];
        if (!file.accepted) {
          _results.push(file);
        }
      }
      return _results;
    };

    Dropzone.prototype.getFilesWithStatus = function(status) {
      var file, _i, _len, _ref, _results;
      _ref = this.files;
      _results = [];
      for (_i = 0, _len = _ref.length; _i < _len; _i++) {
        file = _ref[_i];
        if (file.status === status) {
          _results.push(file);
        }
      }
      return _results;
    };

    Dropzone.prototype.getQueuedFiles = function() {
      return this.getFilesWithStatus(Dropzone.QUEUED);
    };

    Dropzone.prototype.getUploadingFiles = function() {
      return this.getFilesWithStatus(Dropzone.UPLOADING);
    };

    Dropzone.prototype.getAddedFiles = function() {
      return this.getFilesWithStatus(Dropzone.ADDED);
    };

    Dropzone.prototype.getActiveFiles = function() {
      var file, _i, _len, _ref, _results;
      _ref = this.files;
      _results = [];
      for (_i = 0, _len = _ref.length; _i < _len; _i++) {
        file = _ref[_i];
        if (file.status === Dropzone.UPLOADING || file.status === Dropzone.QUEUED) {
          _results.push(file);
        }
      }
      return _results;
    };

    Dropzone.prototype.init = function() {
      var eventName, noPropagation, setupHiddenFileInput, _i, _len, _ref, _ref1;
      if (this.element.tagName === "form") {
        this.element.setAttribute("enctype", "multipart/form-data");
      }
      if (this.element.classList.contains("dropzone") && !this.element.querySelector(".dz-message")) {
        this.element.appendChild(Dropzone.createElement("<div class=\"dz-default dz-message\"><span>" + this.options.dictDefaultMessage + "</span></div>"));
      }
      if (this.clickableElements.length) {
        setupHiddenFileInput = (function(_this) {
          return function() {
            if (_this.hiddenFileInput) {
              _this.hiddenFileInput.parentNode.removeChild(_this.hiddenFileInput);
            }
            _this.hiddenFileInput = document.createElement("input");
            _this.hiddenFileInput.setAttribute("type", "file");
            if ((_this.options.maxFiles == null) || _this.options.maxFiles > 1) {
              _this.hiddenFileInput.setAttribute("multiple", "multiple");
            }
            _this.hiddenFileInput.className = "dz-hidden-input";
            if (_this.options.acceptedFiles != null) {
              _this.hiddenFileInput.setAttribute("accept", _this.options.acceptedFiles);
            }
            if (_this.options.capture != null) {
              _this.hiddenFileInput.setAttribute("capture", _this.options.capture);
            }
            _this.hiddenFileInput.style.visibility = "hidden";
            _this.hiddenFileInput.style.position = "absolute";
            _this.hiddenFileInput.style.top = "0";
            _this.hiddenFileInput.style.left = "0";
            _this.hiddenFileInput.style.height = "0";
            _this.hiddenFileInput.style.width = "0";
            document.querySelector(_this.options.hiddenInputContainer).appendChild(_this.hiddenFileInput);
            return _this.hiddenFileInput.addEventListener("change", function() {
              var file, files, _i, _len;
              files = _this.hiddenFileInput.files;
              if (files.length) {
                for (_i = 0, _len = files.length; _i < _len; _i++) {
                  file = files[_i];
                  _this.addFile(file);
                }
              }
              _this.emit("addedfiles", files);
              return setupHiddenFileInput();
            });
          };
        })(this);
        setupHiddenFileInput();
      }
      this.URL = (_ref = window.URL) != null ? _ref : window.webkitURL;
      _ref1 = this.events;
      for (_i = 0, _len = _ref1.length; _i < _len; _i++) {
        eventName = _ref1[_i];
        this.on(eventName, this.options[eventName]);
      }
      this.on("uploadprogress", (function(_this) {
        return function() {
          return _this.updateTotalUploadProgress();
        };
      })(this));
      this.on("removedfile", (function(_this) {
        return function() {
          return _this.updateTotalUploadProgress();
        };
      })(this));
      this.on("canceled", (function(_this) {
        return function(file) {
          return _this.emit("complete", file);
        };
      })(this));
      this.on("complete", (function(_this) {
        return function(file) {
          if (_this.getAddedFiles().length === 0 && _this.getUploadingFiles().length === 0 && _this.getQueuedFiles().length === 0) {
            return setTimeout((function() {
              return _this.emit("queuecomplete");
            }), 0);
          }
        };
      })(this));
      noPropagation = function(e) {
        e.stopPropagation();
        if (e.preventDefault) {
          return e.preventDefault();
        } else {
          return e.returnValue = false;
        }
      };
      this.listeners = [
        {
          element: this.element,
          events: {
            "dragstart": (function(_this) {
              return function(e) {
                return _this.emit("dragstart", e);
              };
            })(this),
            "dragenter": (function(_this) {
              return function(e) {
                noPropagation(e);
                return _this.emit("dragenter", e);
              };
            })(this),
            "dragover": (function(_this) {
              return function(e) {
                var efct;
                try {
                  efct = e.dataTransfer.effectAllowed;
                } catch (_error) {}
                e.dataTransfer.dropEffect = 'move' === efct || 'linkMove' === efct ? 'move' : 'copy';
                noPropagation(e);
                return _this.emit("dragover", e);
              };
            })(this),
            "dragleave": (function(_this) {
              return function(e) {
                return _this.emit("dragleave", e);
              };
            })(this),
            "drop": (function(_this) {
              return function(e) {
                noPropagation(e);
                return _this.drop(e);
              };
            })(this),
            "dragend": (function(_this) {
              return function(e) {
                return _this.emit("dragend", e);
              };
            })(this)
          }
        }
      ];
      this.clickableElements.forEach((function(_this) {
        return function(clickableElement) {
          return _this.listeners.push({
            element: clickableElement,
            events: {
              "click": function(evt) {
                if ((clickableElement !== _this.element) || (evt.target === _this.element || Dropzone.elementInside(evt.target, _this.element.querySelector(".dz-message")))) {
                  _this.hiddenFileInput.click();
                }
                return true;
              }
            }
          });
        };
      })(this));
      this.enable();
      return this.options.init.call(this);
    };

    Dropzone.prototype.destroy = function() {
      var _ref;
      this.disable();
      this.removeAllFiles(true);
      if ((_ref = this.hiddenFileInput) != null ? _ref.parentNode : void 0) {
        this.hiddenFileInput.parentNode.removeChild(this.hiddenFileInput);
        this.hiddenFileInput = null;
      }
      delete this.element.dropzone;
      return Dropzone.instances.splice(Dropzone.instances.indexOf(this), 1);
    };

    Dropzone.prototype.updateTotalUploadProgress = function() {
      var activeFiles, file, totalBytes, totalBytesSent, totalUploadProgress, _i, _len, _ref;
      totalBytesSent = 0;
      totalBytes = 0;
      activeFiles = this.getActiveFiles();
      if (activeFiles.length) {
        _ref = this.getActiveFiles();
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
          file = _ref[_i];
          totalBytesSent += file.upload.bytesSent;
          totalBytes += file.upload.total;
        }
        totalUploadProgress = 100 * totalBytesSent / totalBytes;
      } else {
        totalUploadProgress = 100;
      }
      return this.emit("totaluploadprogress", totalUploadProgress, totalBytes, totalBytesSent);
    };

    Dropzone.prototype._getParamName = function(n) {
      if (typeof this.options.paramName === "function") {
        return this.options.paramName(n);
      } else {
        return "" + this.options.paramName + (this.options.uploadMultiple ? "[" + n + "]" : "");
      }
    };

    Dropzone.prototype._renameFilename = function(name) {
      if (typeof this.options.renameFilename !== "function") {
        return name;
      }
      return this.options.renameFilename(name);
    };

    Dropzone.prototype.getFallbackForm = function() {
      var existingFallback, fields, fieldsString, form;
      if (existingFallback = this.getExistingFallback()) {
        return existingFallback;
      }
      fieldsString = "<div class=\"dz-fallback\">";
      if (this.options.dictFallbackText) {
        fieldsString += "<p>" + this.options.dictFallbackText + "</p>";
      }
      fieldsString += "<input type=\"file\" name=\"" + (this._getParamName(0)) + "\" " + (this.options.uploadMultiple ? 'multiple="multiple"' : void 0) + " /><input type=\"submit\" value=\"Upload!\"></div>";
      fields = Dropzone.createElement(fieldsString);
      if (this.element.tagName !== "FORM") {
        form = Dropzone.createElement("<form action=\"" + this.options.url + "\" enctype=\"multipart/form-data\" method=\"" + this.options.method + "\"></form>");
        form.appendChild(fields);
      } else {
        this.element.setAttribute("enctype", "multipart/form-data");
        this.element.setAttribute("method", this.options.method);
      }
      return form != null ? form : fields;
    };

    Dropzone.prototype.getExistingFallback = function() {
      var fallback, getFallback, tagName, _i, _len, _ref;
      getFallback = function(elements) {
        var el, _i, _len;
        for (_i = 0, _len = elements.length; _i < _len; _i++) {
          el = elements[_i];
          if (/(^| )fallback($| )/.test(el.className)) {
            return el;
          }
        }
      };
      _ref = ["div", "form"];
      for (_i = 0, _len = _ref.length; _i < _len; _i++) {
        tagName = _ref[_i];
        if (fallback = getFallback(this.element.getElementsByTagName(tagName))) {
          return fallback;
        }
      }
    };

    Dropzone.prototype.setupEventListeners = function() {
      var elementListeners, event, listener, _i, _len, _ref, _results;
      _ref = this.listeners;
      _results = [];
      for (_i = 0, _len = _ref.length; _i < _len; _i++) {
        elementListeners = _ref[_i];
        _results.push((function() {
          var _ref1, _results1;
          _ref1 = elementListeners.events;
          _results1 = [];
          for (event in _ref1) {
            listener = _ref1[event];
            _results1.push(elementListeners.element.addEventListener(event, listener, false));
          }
          return _results1;
        })());
      }
      return _results;
    };

    Dropzone.prototype.removeEventListeners = function() {
      var elementListeners, event, listener, _i, _len, _ref, _results;
      _ref = this.listeners;
      _results = [];
      for (_i = 0, _len = _ref.length; _i < _len; _i++) {
        elementListeners = _ref[_i];
        _results.push((function() {
          var _ref1, _results1;
          _ref1 = elementListeners.events;
          _results1 = [];
          for (event in _ref1) {
            listener = _ref1[event];
            _results1.push(elementListeners.element.removeEventListener(event, listener, false));
          }
          return _results1;
        })());
      }
      return _results;
    };

    Dropzone.prototype.disable = function() {
      var file, _i, _len, _ref, _results;
      this.clickableElements.forEach(function(element) {
        return element.classList.remove("dz-clickable");
      });
      this.removeEventListeners();
      _ref = this.files;
      _results = [];
      for (_i = 0, _len = _ref.length; _i < _len; _i++) {
        file = _ref[_i];
        _results.push(this.cancelUpload(file));
      }
      return _results;
    };

    Dropzone.prototype.enable = function() {
      this.clickableElements.forEach(function(element) {
        return element.classList.add("dz-clickable");
      });
      return this.setupEventListeners();
    };

    Dropzone.prototype.filesize = function(size) {
      var cutoff, i, selectedSize, selectedUnit, unit, units, _i, _len;
      selectedSize = 0;
      selectedUnit = "b";
      if (size > 0) {
        units = ['TB', 'GB', 'MB', 'KB', 'b'];
        for (i = _i = 0, _len = units.length; _i < _len; i = ++_i) {
          unit = units[i];
          cutoff = Math.pow(this.options.filesizeBase, 4 - i) / 10;
          if (size >= cutoff) {
            selectedSize = size / Math.pow(this.options.filesizeBase, 4 - i);
            selectedUnit = unit;
            break;
          }
        }
        selectedSize = Math.round(10 * selectedSize) / 10;
      }
      return "<strong>" + selectedSize + "</strong> " + selectedUnit;
    };

    Dropzone.prototype._updateMaxFilesReachedClass = function() {
      if ((this.options.maxFiles != null) && this.getAcceptedFiles().length >= this.options.maxFiles) {
        if (this.getAcceptedFiles().length === this.options.maxFiles) {
          this.emit('maxfilesreached', this.files);
        }
        return this.element.classList.add("dz-max-files-reached");
      } else {
        return this.element.classList.remove("dz-max-files-reached");
      }
    };

    Dropzone.prototype.drop = function(e) {
      var files, items;
      if (!e.dataTransfer) {
        return;
      }
      this.emit("drop", e);
      files = e.dataTransfer.files;
      this.emit("addedfiles", files);
      if (files.length) {
        items = e.dataTransfer.items;
        if (items && items.length && (items[0].webkitGetAsEntry != null)) {
          this._addFilesFromItems(items);
        } else {
          this.handleFiles(files);
        }
      }
    };

    Dropzone.prototype.paste = function(e) {
      var items, _ref;
      if ((e != null ? (_ref = e.clipboardData) != null ? _ref.items : void 0 : void 0) == null) {
        return;
      }
      this.emit("paste", e);
      items = e.clipboardData.items;
      if (items.length) {
        return this._addFilesFromItems(items);
      }
    };

    Dropzone.prototype.handleFiles = function(files) {
      var file, _i, _len, _results;
      _results = [];
      for (_i = 0, _len = files.length; _i < _len; _i++) {
        file = files[_i];
        _results.push(this.addFile(file));
      }
      return _results;
    };

    Dropzone.prototype._addFilesFromItems = function(items) {
      var entry, item, _i, _len, _results;
      _results = [];
      for (_i = 0, _len = items.length; _i < _len; _i++) {
        item = items[_i];
        if ((item.webkitGetAsEntry != null) && (entry = item.webkitGetAsEntry())) {
          if (entry.isFile) {
            _results.push(this.addFile(item.getAsFile()));
          } else if (entry.isDirectory) {
            _results.push(this._addFilesFromDirectory(entry, entry.name));
          } else {
            _results.push(void 0);
          }
        } else if (item.getAsFile != null) {
          if ((item.kind == null) || item.kind === "file") {
            _results.push(this.addFile(item.getAsFile()));
          } else {
            _results.push(void 0);
          }
        } else {
          _results.push(void 0);
        }
      }
      return _results;
    };

    Dropzone.prototype._addFilesFromDirectory = function(directory, path) {
      var dirReader, errorHandler, readEntries;
      dirReader = directory.createReader();
      errorHandler = function(error) {
        return typeof console !== "undefined" && console !== null ? typeof console.log === "function" ? console.log(error) : void 0 : void 0;
      };
      readEntries = (function(_this) {
        return function() {
          return dirReader.readEntries(function(entries) {
            var entry, _i, _len;
            if (entries.length > 0) {
              for (_i = 0, _len = entries.length; _i < _len; _i++) {
                entry = entries[_i];
                if (entry.isFile) {
                  entry.file(function(file) {
                    if (_this.options.ignoreHiddenFiles && file.name.substring(0, 1) === '.') {
                      return;
                    }
                    file.fullPath = "" + path + "/" + file.name;
                    return _this.addFile(file);
                  });
                } else if (entry.isDirectory) {
                  _this._addFilesFromDirectory(entry, "" + path + "/" + entry.name);
                }
              }
              readEntries();
            }
            return null;
          }, errorHandler);
        };
      })(this);
      return readEntries();
    };

    Dropzone.prototype.accept = function(file, done) {
      if (file.size > this.options.maxFilesize * 1024 * 1024) {
        return done(this.options.dictFileTooBig.replace("{{filesize}}", Math.round(file.size / 1024 / 10.24) / 100).replace("{{maxFilesize}}", this.options.maxFilesize));
      } else if (!Dropzone.isValidFile(file, this.options.acceptedFiles)) {
        return done(this.options.dictInvalidFileType);
      } else if ((this.options.maxFiles != null) && this.getAcceptedFiles().length >= this.options.maxFiles) {
        done(this.options.dictMaxFilesExceeded.replace("{{maxFiles}}", this.options.maxFiles));
        return this.emit("maxfilesexceeded", file);
      } else {
        return this.options.accept.call(this, file, done);
      }
    };

    Dropzone.prototype.addFile = function(file) {
      file.upload = {
        progress: 0,
        total: file.size,
        bytesSent: 0
      };
      this.files.push(file);
      file.status = Dropzone.ADDED;
      this.emit("addedfile", file);
      this._enqueueThumbnail(file);
      return this.accept(file, (function(_this) {
        return function(error) {
          if (error) {
            file.accepted = false;
            _this._errorProcessing([file], error);
          } else {
            file.accepted = true;
            if (_this.options.autoQueue) {
              _this.enqueueFile(file);
            }
          }
          return _this._updateMaxFilesReachedClass();
        };
      })(this));
    };

    Dropzone.prototype.enqueueFiles = function(files) {
      var file, _i, _len;
      for (_i = 0, _len = files.length; _i < _len; _i++) {
        file = files[_i];
        this.enqueueFile(file);
      }
      return null;
    };

    Dropzone.prototype.enqueueFile = function(file) {
      if (file.status === Dropzone.ADDED && file.accepted === true) {
        file.status = Dropzone.QUEUED;
        if (this.options.autoProcessQueue) {
          return setTimeout(((function(_this) {
            return function() {
              return _this.processQueue();
            };
          })(this)), 0);
        }
      } else {
        throw new Error("This file can't be queued because it has already been processed or was rejected.");
      }
    };

    Dropzone.prototype._thumbnailQueue = [];

    Dropzone.prototype._processingThumbnail = false;

    Dropzone.prototype._enqueueThumbnail = function(file) {
      if (this.options.createImageThumbnails && file.type.match(/image.*/) && file.size <= this.options.maxThumbnailFilesize * 1024 * 1024) {
        this._thumbnailQueue.push(file);
        return setTimeout(((function(_this) {
          return function() {
            return _this._processThumbnailQueue();
          };
        })(this)), 0);
      }
    };

    Dropzone.prototype._processThumbnailQueue = function() {
      if (this._processingThumbnail || this._thumbnailQueue.length === 0) {
        return;
      }
      this._processingThumbnail = true;
      return this.createThumbnail(this._thumbnailQueue.shift(), (function(_this) {
        return function() {
          _this._processingThumbnail = false;
          return _this._processThumbnailQueue();
        };
      })(this));
    };

    Dropzone.prototype.removeFile = function(file) {
      if (file.status === Dropzone.UPLOADING) {
        this.cancelUpload(file);
      }
      this.files = without(this.files, file);
      this.emit("removedfile", file);
      if (this.files.length === 0) {
        return this.emit("reset");
      }
    };

    Dropzone.prototype.removeAllFiles = function(cancelIfNecessary) {
      var file, _i, _len, _ref;
      if (cancelIfNecessary == null) {
        cancelIfNecessary = false;
      }
      _ref = this.files.slice();
      for (_i = 0, _len = _ref.length; _i < _len; _i++) {
        file = _ref[_i];
        if (file.status !== Dropzone.UPLOADING || cancelIfNecessary) {
          this.removeFile(file);
        }
      }
      return null;
    };

    Dropzone.prototype.createThumbnail = function(file, callback) {
      var fileReader;
      fileReader = new FileReader;
      fileReader.onload = (function(_this) {
        return function() {
          if (file.type === "image/svg+xml") {
            _this.emit("thumbnail", file, fileReader.result);
            if (callback != null) {
              callback();
            }
            return;
          }
          return _this.createThumbnailFromUrl(file, fileReader.result, callback);
        };
      })(this);
      return fileReader.readAsDataURL(file);
    };

    Dropzone.prototype.createThumbnailFromUrl = function(file, imageUrl, callback, crossOrigin) {
      var img;
      img = document.createElement("img");
      if (crossOrigin) {
        img.crossOrigin = crossOrigin;
      }
      img.onload = (function(_this) {
        return function() {
          var canvas, ctx, resizeInfo, thumbnail, _ref, _ref1, _ref2, _ref3;
          file.width = img.width;
          file.height = img.height;
          resizeInfo = _this.options.resize.call(_this, file);
          if (resizeInfo.trgWidth == null) {
            resizeInfo.trgWidth = resizeInfo.optWidth;
          }
          if (resizeInfo.trgHeight == null) {
            resizeInfo.trgHeight = resizeInfo.optHeight;
          }
          canvas = document.createElement("canvas");
          ctx = canvas.getContext("2d");
          canvas.width = resizeInfo.trgWidth;
          canvas.height = resizeInfo.trgHeight;
          drawImageIOSFix(ctx, img, (_ref = resizeInfo.srcX) != null ? _ref : 0, (_ref1 = resizeInfo.srcY) != null ? _ref1 : 0, resizeInfo.srcWidth, resizeInfo.srcHeight, (_ref2 = resizeInfo.trgX) != null ? _ref2 : 0, (_ref3 = resizeInfo.trgY) != null ? _ref3 : 0, resizeInfo.trgWidth, resizeInfo.trgHeight);
          thumbnail = canvas.toDataURL("image/png");
          _this.emit("thumbnail", file, thumbnail);
          if (callback != null) {
            return callback();
          }
        };
      })(this);
      if (callback != null) {
        img.onerror = callback;
      }
      return img.src = imageUrl;
    };

    Dropzone.prototype.processQueue = function() {
      var i, parallelUploads, processingLength, queuedFiles;
      parallelUploads = this.options.parallelUploads;
      processingLength = this.getUploadingFiles().length;
      i = processingLength;
      if (processingLength >= parallelUploads) {
        return;
      }
      queuedFiles = this.getQueuedFiles();
      if (!(queuedFiles.length > 0)) {
        return;
      }
      if (this.options.uploadMultiple) {
        return this.processFiles(queuedFiles.slice(0, parallelUploads - processingLength));
      } else {
        while (i < parallelUploads) {
          if (!queuedFiles.length) {
            return;
          }
          this.processFile(queuedFiles.shift());
          i++;
        }
      }
    };

    Dropzone.prototype.processFile = function(file) {
      return this.processFiles([file]);
    };

    Dropzone.prototype.processFiles = function(files) {
      var file, _i, _len;
      for (_i = 0, _len = files.length; _i < _len; _i++) {
        file = files[_i];
        file.processing = true;
        file.status = Dropzone.UPLOADING;
        this.emit("processing", file);
      }
      if (this.options.uploadMultiple) {
        this.emit("processingmultiple", files);
      }
      return this.uploadFiles(files);
    };

    Dropzone.prototype._getFilesWithXhr = function(xhr) {
      var file, files;
      return files = (function() {
        var _i, _len, _ref, _results;
        _ref = this.files;
        _results = [];
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
          file = _ref[_i];
          if (file.xhr === xhr) {
            _results.push(file);
          }
        }
        return _results;
      }).call(this);
    };

    Dropzone.prototype.cancelUpload = function(file) {
      var groupedFile, groupedFiles, _i, _j, _len, _len1, _ref;
      if (file.status === Dropzone.UPLOADING) {
        groupedFiles = this._getFilesWithXhr(file.xhr);
        for (_i = 0, _len = groupedFiles.length; _i < _len; _i++) {
          groupedFile = groupedFiles[_i];
          groupedFile.status = Dropzone.CANCELED;
        }
        file.xhr.abort();
        for (_j = 0, _len1 = groupedFiles.length; _j < _len1; _j++) {
          groupedFile = groupedFiles[_j];
          this.emit("canceled", groupedFile);
        }
        if (this.options.uploadMultiple) {
          this.emit("canceledmultiple", groupedFiles);
        }
      } else if ((_ref = file.status) === Dropzone.ADDED || _ref === Dropzone.QUEUED) {
        file.status = Dropzone.CANCELED;
        this.emit("canceled", file);
        if (this.options.uploadMultiple) {
          this.emit("canceledmultiple", [file]);
        }
      }
      if (this.options.autoProcessQueue) {
        return this.processQueue();
      }
    };

    resolveOption = function() {
      var args, option;
      option = arguments[0], args = 2 <= arguments.length ? __slice.call(arguments, 1) : [];
      if (typeof option === 'function') {
        return option.apply(this, args);
      }
      return option;
    };

    Dropzone.prototype.uploadFile = function(file) {
      return this.uploadFiles([file]);
    };

    Dropzone.prototype.uploadFiles = function(files) {
      var file, formData, handleError, headerName, headerValue, headers, i, input, inputName, inputType, key, method, option, progressObj, response, updateProgress, url, value, xhr, _i, _j, _k, _l, _len, _len1, _len2, _len3, _m, _ref, _ref1, _ref2, _ref3, _ref4, _ref5;
      xhr = new XMLHttpRequest();
      for (_i = 0, _len = files.length; _i < _len; _i++) {
        file = files[_i];
        file.xhr = xhr;
      }
      method = resolveOption(this.options.method, files);
      url = resolveOption(this.options.url, files);
      xhr.open(method, url, true);
      xhr.withCredentials = !!this.options.withCredentials;
      response = null;
      handleError = (function(_this) {
        return function() {
          var _j, _len1, _results;
          _results = [];
          for (_j = 0, _len1 = files.length; _j < _len1; _j++) {
            file = files[_j];
            _results.push(_this._errorProcessing(files, response || _this.options.dictResponseError.replace("{{statusCode}}", xhr.status), xhr));
          }
          return _results;
        };
      })(this);
      updateProgress = (function(_this) {
        return function(e) {
          var allFilesFinished, progress, _j, _k, _l, _len1, _len2, _len3, _results;
          if (e != null) {
            progress = 100 * e.loaded / e.total;
            for (_j = 0, _len1 = files.length; _j < _len1; _j++) {
              file = files[_j];
              file.upload = {
                progress: progress,
                total: e.total,
                bytesSent: e.loaded
              };
            }
          } else {
            allFilesFinished = true;
            progress = 100;
            for (_k = 0, _len2 = files.length; _k < _len2; _k++) {
              file = files[_k];
              if (!(file.upload.progress === 100 && file.upload.bytesSent === file.upload.total)) {
                allFilesFinished = false;
              }
              file.upload.progress = progress;
              file.upload.bytesSent = file.upload.total;
            }
            if (allFilesFinished) {
              return;
            }
          }
          _results = [];
          for (_l = 0, _len3 = files.length; _l < _len3; _l++) {
            file = files[_l];
            _results.push(_this.emit("uploadprogress", file, progress, file.upload.bytesSent));
          }
          return _results;
        };
      })(this);
      xhr.onload = (function(_this) {
        return function(e) {
          var _ref;
          if (files[0].status === Dropzone.CANCELED) {
            return;
          }
          if (xhr.readyState !== 4) {
            return;
          }
          response = xhr.responseText;
          if (xhr.getResponseHeader("content-type") && ~xhr.getResponseHeader("content-type").indexOf("application/json")) {
            try {
              response = JSON.parse(response);
            } catch (_error) {
              e = _error;
              response = "Invalid JSON response from server.";
            }
          }
          updateProgress();
          if (!((200 <= (_ref = xhr.status) && _ref < 300))) {
            return handleError();
          } else {
            return _this._finished(files, response, e);
          }
        };
      })(this);
      xhr.onerror = (function(_this) {
        return function() {
          if (files[0].status === Dropzone.CANCELED) {
            return;
          }
          return handleError();
        };
      })(this);
      progressObj = (_ref = xhr.upload) != null ? _ref : xhr;
      progressObj.onprogress = updateProgress;
      headers = {
        "Accept": "application/json",
        "Cache-Control": "no-cache",
        "X-Requested-With": "XMLHttpRequest"
      };
      if (this.options.headers) {
        extend(headers, this.options.headers);
      }
      for (headerName in headers) {
        headerValue = headers[headerName];
        if (headerValue) {
          xhr.setRequestHeader(headerName, headerValue);
        }
      }
      formData = new FormData();
      if (this.options.params) {
        _ref1 = this.options.params;
        for (key in _ref1) {
          value = _ref1[key];
          formData.append(key, value);
        }
      }
      for (_j = 0, _len1 = files.length; _j < _len1; _j++) {
        file = files[_j];
        this.emit("sending", file, xhr, formData);
      }
      if (this.options.uploadMultiple) {
        this.emit("sendingmultiple", files, xhr, formData);
      }
      if (this.element.tagName === "FORM") {
        _ref2 = this.element.querySelectorAll("input, textarea, select, button");
        for (_k = 0, _len2 = _ref2.length; _k < _len2; _k++) {
          input = _ref2[_k];
          inputName = input.getAttribute("name");
          inputType = input.getAttribute("type");
          if (input.tagName === "SELECT" && input.hasAttribute("multiple")) {
            _ref3 = input.options;
            for (_l = 0, _len3 = _ref3.length; _l < _len3; _l++) {
              option = _ref3[_l];
              if (option.selected) {
                formData.append(inputName, option.value);
              }
            }
          } else if (!inputType || ((_ref4 = inputType.toLowerCase()) !== "checkbox" && _ref4 !== "radio") || input.checked) {
            formData.append(inputName, input.value);
          }
        }
      }
      for (i = _m = 0, _ref5 = files.length - 1; 0 <= _ref5 ? _m <= _ref5 : _m >= _ref5; i = 0 <= _ref5 ? ++_m : --_m) {
        formData.append(this._getParamName(i), files[i], this._renameFilename(files[i].name));
      }
      return this.submitRequest(xhr, formData, files);
    };

    Dropzone.prototype.submitRequest = function(xhr, formData, files) {
      return xhr.send(formData);
    };

    Dropzone.prototype._finished = function(files, responseText, e) {
      var file, _i, _len;
      for (_i = 0, _len = files.length; _i < _len; _i++) {
        file = files[_i];
        file.status = Dropzone.SUCCESS;
        this.emit("success", file, responseText, e);
        this.emit("complete", file);
      }
      if (this.options.uploadMultiple) {
        this.emit("successmultiple", files, responseText, e);
        this.emit("completemultiple", files);
      }
      if (this.options.autoProcessQueue) {
        return this.processQueue();
      }
    };

    Dropzone.prototype._errorProcessing = function(files, message, xhr) {
      var file, _i, _len;
      for (_i = 0, _len = files.length; _i < _len; _i++) {
        file = files[_i];
        file.status = Dropzone.ERROR;
        this.emit("error", file, message, xhr);
        this.emit("complete", file);
      }
      if (this.options.uploadMultiple) {
        this.emit("errormultiple", files, message, xhr);
        this.emit("completemultiple", files);
      }
      if (this.options.autoProcessQueue) {
        return this.processQueue();
      }
    };

    return Dropzone;

  })(Emitter);

  Dropzone.version = "4.3.0";

  Dropzone.options = {};

  Dropzone.optionsForElement = function(element) {
    if (element.getAttribute("id")) {
      return Dropzone.options[camelize(element.getAttribute("id"))];
    } else {
      return void 0;
    }
  };

  Dropzone.instances = [];

  Dropzone.forElement = function(element) {
    if (typeof element === "string") {
      element = document.querySelector(element);
    }
    if ((element != null ? element.dropzone : void 0) == null) {
      throw new Error("No Dropzone found for given element. This is probably because you're trying to access it before Dropzone had the time to initialize. Use the `init` option to setup any additional observers on your Dropzone.");
    }
    return element.dropzone;
  };

  Dropzone.autoDiscover = true;

  Dropzone.discover = function() {
    var checkElements, dropzone, dropzones, _i, _len, _results;
    if (document.querySelectorAll) {
      dropzones = document.querySelectorAll(".dropzone");
    } else {
      dropzones = [];
      checkElements = function(elements) {
        var el, _i, _len, _results;
        _results = [];
        for (_i = 0, _len = elements.length; _i < _len; _i++) {
          el = elements[_i];
          if (/(^| )dropzone($| )/.test(el.className)) {
            _results.push(dropzones.push(el));
          } else {
            _results.push(void 0);
          }
        }
        return _results;
      };
      checkElements(document.getElementsByTagName("div"));
      checkElements(document.getElementsByTagName("form"));
    }
    _results = [];
    for (_i = 0, _len = dropzones.length; _i < _len; _i++) {
      dropzone = dropzones[_i];
      if (Dropzone.optionsForElement(dropzone) !== false) {
        _results.push(new Dropzone(dropzone));
      } else {
        _results.push(void 0);
      }
    }
    return _results;
  };

  Dropzone.blacklistedBrowsers = [/opera.*Macintosh.*version\/12/i];

  Dropzone.isBrowserSupported = function() {
    var capableBrowser, regex, _i, _len, _ref;
    capableBrowser = true;
    if (window.File && window.FileReader && window.FileList && window.Blob && window.FormData && document.querySelector) {
      if (!("classList" in document.createElement("a"))) {
        capableBrowser = false;
      } else {
        _ref = Dropzone.blacklistedBrowsers;
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
          regex = _ref[_i];
          if (regex.test(navigator.userAgent)) {
            capableBrowser = false;
            continue;
          }
        }
      }
    } else {
      capableBrowser = false;
    }
    return capableBrowser;
  };

  without = function(list, rejectedItem) {
    var item, _i, _len, _results;
    _results = [];
    for (_i = 0, _len = list.length; _i < _len; _i++) {
      item = list[_i];
      if (item !== rejectedItem) {
        _results.push(item);
      }
    }
    return _results;
  };

  camelize = function(str) {
    return str.replace(/[\-_](\w)/g, function(match) {
      return match.charAt(1).toUpperCase();
    });
  };

  Dropzone.createElement = function(string) {
    var div;
    div = document.createElement("div");
    div.innerHTML = string;
    return div.childNodes[0];
  };

  Dropzone.elementInside = function(element, container) {
    if (element === container) {
      return true;
    }
    while (element = element.parentNode) {
      if (element === container) {
        return true;
      }
    }
    return false;
  };

  Dropzone.getElement = function(el, name) {
    var element;
    if (typeof el === "string") {
      element = document.querySelector(el);
    } else if (el.nodeType != null) {
      element = el;
    }
    if (element == null) {
      throw new Error("Invalid `" + name + "` option provided. Please provide a CSS selector or a plain HTML element.");
    }
    return element;
  };

  Dropzone.getElements = function(els, name) {
    var e, el, elements, _i, _j, _len, _len1, _ref;
    if (els instanceof Array) {
      elements = [];
      try {
        for (_i = 0, _len = els.length; _i < _len; _i++) {
          el = els[_i];
          elements.push(this.getElement(el, name));
        }
      } catch (_error) {
        e = _error;
        elements = null;
      }
    } else if (typeof els === "string") {
      elements = [];
      _ref = document.querySelectorAll(els);
      for (_j = 0, _len1 = _ref.length; _j < _len1; _j++) {
        el = _ref[_j];
        elements.push(el);
      }
    } else if (els.nodeType != null) {
      elements = [els];
    }
    if (!((elements != null) && elements.length)) {
      throw new Error("Invalid `" + name + "` option provided. Please provide a CSS selector, a plain HTML element or a list of those.");
    }
    return elements;
  };

  Dropzone.confirm = function(question, accepted, rejected) {
    if (window.confirm(question)) {
      return accepted();
    } else if (rejected != null) {
      return rejected();
    }
  };

  Dropzone.isValidFile = function(file, acceptedFiles) {
    var baseMimeType, mimeType, validType, _i, _len;
    if (!acceptedFiles) {
      return true;
    }
    acceptedFiles = acceptedFiles.split(",");
    mimeType = file.type;
    baseMimeType = mimeType.replace(/\/.*$/, "");
    for (_i = 0, _len = acceptedFiles.length; _i < _len; _i++) {
      validType = acceptedFiles[_i];
      validType = validType.trim();
      if (validType.charAt(0) === ".") {
        if (file.name.toLowerCase().indexOf(validType.toLowerCase(), file.name.length - validType.length) !== -1) {
          return true;
        }
      } else if (/\/\*$/.test(validType)) {
        if (baseMimeType === validType.replace(/\/.*$/, "")) {
          return true;
        }
      } else {
        if (mimeType === validType) {
          return true;
        }
      }
    }
    return false;
  };

  if (typeof jQuery !== "undefined" && jQuery !== null) {
    jQuery.fn.dropzone = function(options) {
      return this.each(function() {
        return new Dropzone(this, options);
      });
    };
  }

  if (typeof module !== "undefined" && module !== null) {
    module.exports = Dropzone;
  } else {
    window.Dropzone = Dropzone;
  }

  Dropzone.ADDED = "added";

  Dropzone.QUEUED = "queued";

  Dropzone.ACCEPTED = Dropzone.QUEUED;

  Dropzone.UPLOADING = "uploading";

  Dropzone.PROCESSING = Dropzone.UPLOADING;

  Dropzone.CANCELED = "canceled";

  Dropzone.ERROR = "error";

  Dropzone.SUCCESS = "success";


  /*
  
  Bugfix for iOS 6 and 7
  Source: http://stackoverflow.com/questions/11929099/html5-canvas-drawimage-ratio-bug-ios
  based on the work of https://github.com/stomita/ios-imagefile-megapixel
   */

  detectVerticalSquash = function(img) {
    var alpha, canvas, ctx, data, ey, ih, iw, py, ratio, sy;
    iw = img.naturalWidth;
    ih = img.naturalHeight;
    canvas = document.createElement("canvas");
    canvas.width = 1;
    canvas.height = ih;
    ctx = canvas.getContext("2d");
    ctx.drawImage(img, 0, 0);
    data = ctx.getImageData(0, 0, 1, ih).data;
    sy = 0;
    ey = ih;
    py = ih;
    while (py > sy) {
      alpha = data[(py - 1) * 4 + 3];
      if (alpha === 0) {
        ey = py;
      } else {
        sy = py;
      }
      py = (ey + sy) >> 1;
    }
    ratio = py / ih;
    if (ratio === 0) {
      return 1;
    } else {
      return ratio;
    }
  };

  drawImageIOSFix = function(ctx, img, sx, sy, sw, sh, dx, dy, dw, dh) {
    var vertSquashRatio;
    vertSquashRatio = detectVerticalSquash(img);
    return ctx.drawImage(img, sx, sy, sw, sh, dx, dy, dw, dh / vertSquashRatio);
  };


  /*
   * contentloaded.js
   *
   * Author: Diego Perini (diego.perini at gmail.com)
   * Summary: cross-browser wrapper for DOMContentLoaded
   * Updated: 20101020
   * License: MIT
   * Version: 1.2
   *
   * URL:
   * http://javascript.nwbox.com/ContentLoaded/
   * http://javascript.nwbox.com/ContentLoaded/MIT-LICENSE
   */

  contentLoaded = function(win, fn) {
    var add, doc, done, init, poll, pre, rem, root, top;
    done = false;
    top = true;
    doc = win.document;
    root = doc.documentElement;
    add = (doc.addEventListener ? "addEventListener" : "attachEvent");
    rem = (doc.addEventListener ? "removeEventListener" : "detachEvent");
    pre = (doc.addEventListener ? "" : "on");
    init = function(e) {
      if (e.type === "readystatechange" && doc.readyState !== "complete") {
        return;
      }
      (e.type === "load" ? win : doc)[rem](pre + e.type, init, false);
      if (!done && (done = true)) {
        return fn.call(win, e.type || e);
      }
    };
    poll = function() {
      var e;
      try {
        root.doScroll("left");
      } catch (_error) {
        e = _error;
        setTimeout(poll, 50);
        return;
      }
      return init("poll");
    };
    if (doc.readyState !== "complete") {
      if (doc.createEventObject && root.doScroll) {
        try {
          top = !win.frameElement;
        } catch (_error) {}
        if (top) {
          poll();
        }
      }
      doc[add](pre + "DOMContentLoaded", init, false);
      doc[add](pre + "readystatechange", init, false);
      return win[add](pre + "load", init, false);
    }
  };

  Dropzone._autoDiscoverFunction = function() {
    if (Dropzone.autoDiscover) {
      return Dropzone.discover();
    }
  };

  contentLoaded(window, Dropzone._autoDiscoverFunction);

}).call(this);

},{}],4:[function(require,module,exports){
(function (global){
'use strict';

var _forEach = require('lodash-compat/collection/forEach'),
    _map = require('lodash-compat/collection/map'),
    _forIn = require('lodash-compat/object/forIn'),
    _extend = require('lodash-compat/object/extend'),
    _omit = require('lodash-compat/object/omit'),
    isGoogleMapsRegistered = (typeof google === 'object' && google.maps),
    nativeMethods = [
      'setCenter', 'streetView_changed', 'getDiv', 'panBy', 'panTo',
      'panToBounds', 'fitBounds', 'getBounds', 'getStreetView', 'setStreetView',
      'getCenter', 'getZoom', 'setZoom', 'getMapTypeId', 'setMapTypeId', 'getProjection',
      'getHeading', 'setHeading', 'getTilt', 'setTilt', 'get', 'set', 'notify', 'setValues',
      'setOptions', 'changed', 'bindTo', 'unbind', 'unbindAll', 'addListener'
    ];

function querySelector(selector, context) {
  var element;

  if (!context) {
    context = document;
  }

  if (context.querySelector) {
    element = context.querySelector(selector);
  }
  else if (selector[0] === '#') {
    element = document.getElementById(selector.replace(/^#/, ''));
  }
  else if (selector[0] === '.') {
    element = context.getElementsByClassName(selector.replace(/^\./, ''))[0];
  }

  return element;
}

function coordsToLatLngs(coords, useGeoJSON) {
  var firstCoordinate = coords[0],
      secondCoordinate = coords[1];

  if (useGeoJSON) {
    firstCoordinate = coords[1];
    secondCoordinate = coords[0];
  }

  return new google.maps.LatLng(firstCoordinate, secondCoordinate);
}

function arrayToLatLng(coords, useGeoJSON) {
  var coordinates = _map(coords, function(coordinate) {
    var isGoogleLatLng = (coordinate instanceof google.maps.LatLng),
        looksLikeMultiDimensionalArray = (coordinate.length > 0 && typeof coordinate[0] === 'object');

    if (!isGoogleLatLng) {
      if (looksLikeMultiDimensionalArray) {
        coordinate = arrayToLatLng(coordinate, useGeoJSON);
      }
      else {
        coordinate = coordsToLatLngs(coordinate, useGeoJSON);
      }
    }

    return coordinate;
  });

  return coordinates;
}

function findAbsolutePosition(element)  {
  var left = 0,
      top = 0,
      absolutePosition = {};

  if (element.offsetParent) {
    do {
      left += element.offsetLeft;
      top += element.offsetTop;
    } while ((element = element.offsetParent));
  }

  absolutePosition.left = left;
  absolutePosition.top = top;

  return absolutePosition;
}

function buildContextMenuContent(gmaps, control, rightClickEvent) {
  var html = '',
      controlOptions = gmaps.contextMenu[control],
      contextMenuElement = querySelector('#gmaps_context_menu_' + gmaps._id),
      contextMenuItems;

  if (!contextMenuElement) {
    return;
  }

  _forIn(controlOptions, function(option, key) {
    if (controlOptions.hasOwnProperty(key)) {
      html += '<li><a id="' + control + '_' + key + '" href="#">' + option.title + '</a></li>';
    }
  });

  contextMenuElement.innerHTML = html;
  contextMenuItems = contextMenuElement.getElementsByTagName('a');

  function assignMenuItemAction(clickEvent) {
    clickEvent.preventDefault();

    var controlKey = this.id.replace(control + '_', '');

    controlOptions[controlKey].action.call(gmaps, rightClickEvent);

    gmaps.hideContextMenu();
  }

  _forEach(contextMenuItems, function(contextMenuItem) {
    google.maps.event.clearListeners(contextMenuItem, 'click');
    google.maps.event.addDomListenerOnce(contextMenuItem, 'click', assignMenuItemAction, false);
  });

  var position = findAbsolutePosition(gmaps.element),
      left = position.left + rightClickEvent.pixel.x - 15,
      top = position.top + rightClickEvent.pixel.y - 15;

  contextMenuElement.style.left = left + 'px';
  contextMenuElement.style.top = top + 'px';
  contextMenuElement.style.display = 'block';
}

function setupListener(gmaps, object, eventName, listener) {
  google.maps.event.addListener(object, eventName, function(mapEvent) {
    if (!mapEvent) {
      mapEvent = gmaps;
    }

    listener.call(gmaps, mapEvent);

    gmaps.hideContextMenu();
  });
}

function GMaps(options) {
  if (!isGoogleMapsRegistered) {
    throw 'Google Maps API is required. Please register the following JavaScript library in your site: http://maps.google.com/maps/api/js?sensor=true';
  }

  if (!this) {
    return new GMaps(options);
  }

  var self = this,
      optionsToDelete = [
        'el', 'div', 'lat', 'lng', 'mapType', 'width',
        'height', 'markerClusterer', 'enableNewStyle'
      ],
      hidingContextMenuEvents = [
        'bounds_changed', 'center_changed', 'click', 'dblclick', 'drag',
        'dragend', 'dragstart', 'idle', 'maptypeid_changed', 'projection_changed',
        'resize', 'tilesloaded', 'zoom_changed'
      ],
      notHidingContextMenuEvents = ['mousemove', 'mouseout', 'mouseover'],
      containerIdentifier = options.el || options.div,
      zoom = options.zoom || 15,
      mapType = google.maps.MapTypeId[(options.mapType || 'roadmap').toUpperCase()],
      mapCenter = new google.maps.LatLng(options.lat, options.lng),
      markerClustererFunction = options.markerClusterer,
      zoomControl = options.zoomControl || true,
      zoomControlOptions = options.zoomControlOptions || {
        style: 'default',
        position: 'top_left'
      },
      panControl = options.panControl || true,
      mapTypeControl = options.mapTypeControl || true,
      scaleControl = options.scaleControl || true,
      streetViewControl = options.streetViewControl || true,
      overviewMapControl = options.overviewMapControl || true,
      mapBaseOptions = {
        zoom: zoom,
        mapTypeId: mapType,
        center: mapCenter
      },
      mapControlsOptions = {
        panControl: panControl,
        zoomControl: zoomControl,
        zoomControlOptions: {
          style: google.maps.ZoomControlStyle[(zoomControlOptions.style || 'default').toUpperCase()],
          position: google.maps.ControlPosition[(zoomControlOptions.position || 'top_left').toUpperCase()]
        },
        mapTypeControl: mapTypeControl,
        scaleControl: scaleControl,
        streetViewControl: streetViewControl,
        overviewMapControl: overviewMapControl
      },
      mapOptions;

  if (typeof options.el === 'string' || typeof options.div === 'string') {
    this.element = querySelector(containerIdentifier, options.context);
  } else {
    this.element = containerIdentifier;
  }

  if (!this.element) {
    throw 'No element defined.';
  }

  this.contextMenu = {};
  this.controls = [];
  this.overlays = [];
  this.layers = []; // array with kml/georss and fusiontables layers, can be as many
  this.singleLayers = {}; // object with the other layers, only one per layer
  this.markers = [];
  this.polylines = [];
  this.routes = [];
  this.polygons = [];
  this.infoWindow = null;
  this.overlayElement = this.overlayEl = null;
  this.zoom = zoom;
  this.registeredEvents = {};
  this.element.style.width = options.width || this.element.scrollWidth || this.element.offsetWidth;
  this.element.style.height = options.height || this.element.scrollHeight || this.element.offsetHeight;
  this._id = Date.now() + '_' + Math.ceil(Math.random() * Date.now());

  google.maps.visualRefresh = options.enableNewStyle;

  if (options.disableDefaultUI !== true) {
    mapBaseOptions = _extend(mapBaseOptions, mapControlsOptions);
  }

  mapOptions = _extend(mapBaseOptions, options);
  mapOptions = _omit(mapOptions, optionsToDelete);
  mapOptions = _omit(mapOptions, hidingContextMenuEvents);
  mapOptions = _omit(mapOptions, notHidingContextMenuEvents);

  this.map = new google.maps.Map(this.element, mapOptions);

  _forEach(hidingContextMenuEvents, function(eventName) {
    if (eventName in options) {
      setupListener(self, self.map, eventName, options[eventName]);
    }
  });

  _forEach(notHidingContextMenuEvents, function(eventName) {
    if (eventName in options) {
      setupListener(self, self.map, eventName, options[eventName]);
    }
  });

  google.maps.event.addListener(this.map, 'zoom_changed', this.hideContextMenu);
  google.maps.event.addListener(this.map, 'rightclick', function(rightClickEvent) {
    if (typeof options.rightclick === 'function') {
      options.rightclick.call(this, rightClickEvent);
    }

    if (self.contextMenu.map) {
      self.buildContextMenu('map', rightClickEvent);
    }
  });

  if (typeof markerClustererFunction === 'function') {
    this.markerClusterer = markerClustererFunction.apply(this, [this.map]);
  }
}

for (var counter = 0; counter < nativeMethods.length; counter++) {
  (function(gmapsPrototype, methodName) {
    gmapsPrototype[methodName] = function() {
      return this.map[methodName].apply(this.map, arguments);
    };
  })(GMaps.prototype, nativeMethods[counter]);
}

GMaps.prototype.refresh = function() {
  google.maps.event.trigger(this.map, 'resize');
};

GMaps.prototype.fitZoom = function() {
  var latLngs = [];

  _forEach(this.markers, function(marker) {
    if (marker.visible === true) {
      latLngs.push(marker.getPosition());
    }
  });

  if (latLngs.length > 0) {
    this.fitLatLngBounds(latLngs);
  }
};

GMaps.prototype.fitLatLngBounds = function(latLngs) {
  var bounds = new google.maps.LatLngBounds();

  _forEach(latLngs, function(latLng) {
    bounds.extend(latLng);
  });

  if (!bounds.isEmpty()) {
    this.map.fitBounds(bounds);
  }
};

GMaps.prototype.setCenter = function(lat, lng, callback) {
  this.map.panTo(new google.maps.LatLng(lat, lng));

  if (typeof callback === 'function') {
    callback.call(this, lat, lng);
  }
};

GMaps.prototype.getElement = function() {
  return this.element;
};

GMaps.prototype.zoomIn = function(value) {
  value = value || 1;

  this.zoom = this.map.getZoom() + value;
  this.map.setZoom(this.zoom);
};

GMaps.prototype.zoomOut = function(value) {
  value = value || 1;

  this.zoom = this.map.getZoom() - value;
  this.map.setZoom(this.zoom);
};

GMaps.prototype.buildContextMenu = function(control, rightClickEvent) {
  var self = this;

  if (control === 'marker') {
    var overlay = new google.maps.OverlayView();

    overlay.setMap(self.map);

    overlay.draw = function() {
      var projection = overlay.getProjection(),
          position = rightClickEvent.marker.getPosition();

      rightClickEvent.pixel = projection.fromLatLngToContainerPixel(position);

      buildContextMenuContent(self, control, rightClickEvent);
    };
  }
  else {
    buildContextMenuContent(self, control, rightClickEvent);
  }
};

GMaps.prototype.getContextMenu = function() {
  return querySelector('#gmaps_context_menu_' + this._id);
};

GMaps.prototype.setContextMenu = function(options) {
  var contextMenuElement = document.createElement('ul'),
      contextMenuControlType = options.control,
      contextMenuOptions = options.options,
      contextMenu = {};

  _forIn(contextMenuOptions, function(option, key) {
    if (contextMenuOptions.hasOwnProperty(key)) {
      contextMenu[option.name] = {
        title: option.title,
        action: option.action
      };
    }
  });

  this.contextMenu[contextMenuControlType] = contextMenu;

  contextMenuElement.id = 'gmaps_context_menu_' + this._id;
  contextMenuElement.style.display = 'none';
  contextMenuElement.style.position = 'absolute';
  contextMenuElement.style.minWidth = '100px';
  contextMenuElement.style.background = 'white';
  contextMenuElement.style.listStyle = 'none';
  contextMenuElement.style.padding = '8px';
  contextMenuElement.style.boxShadow = '2px 2px 6px #ccc';

  document.body.appendChild(contextMenuElement);

  google.maps.event.addDomListener(contextMenuElement, 'mouseout', function(mouseOutEvent) {
    if (!mouseOutEvent.relatedTarget || !this.contains(mouseOutEvent.relatedTarget)) {
      setTimeout(function() {
        contextMenuElement.style.display = 'none';
      }, 400);
    }
  }, false);
};

GMaps.prototype.hideContextMenu = function() {
  var contextMenuElement = querySelector('#gmaps_context_menu_' + this._id);

  if (contextMenuElement) {
    contextMenuElement.style.display = 'none';
  }
};

GMaps.arrayToLatLng = arrayToLatLng;
GMaps.coordsToLatLngs = coordsToLatLngs;

global.GMaps = GMaps;
module.exports = GMaps;
}).call(this,typeof global !== "undefined" ? global : typeof self !== "undefined" ? self : typeof window !== "undefined" ? window : {})
},{"lodash-compat/collection/forEach":8,"lodash-compat/collection/map":9,"lodash-compat/object/extend":75,"lodash-compat/object/forIn":76,"lodash-compat/object/omit":79}],5:[function(require,module,exports){
'use strict';

var _forEach = require('lodash-compat/collection/forEach'),
    _map = require('lodash-compat/collection/map'),
    _extend = require('lodash-compat/object/extend'),
    _omit = require('lodash-compat/object/omit'),
    markersModule = {};

markersModule.createMarker = function(options) {
  if (options.lat === undefined && options.lng === undefined && options.position === undefined) {
    throw 'No latitude or longitude defined.';
  }

  var self = this,
      details = options.details,
      fences = options.fences,
      inside = options.inside,
      outside = options.outside,
      baseOptions = {
        position: new google.maps.LatLng(options.lat, options.lng),
        map: null
      },
      markerOptions = _extend(baseOptions, options),
      optionsToDelete = ['lat', 'lng', 'fences', 'infoWindow', 'outside', 'inside'],
      infoWindowOptions = markerOptions.infoWindow,
      infoWindowEvents = [
        'closeclick', 'content_changed',
        'domready', 'position_changed', 'zindex_changed'
      ],
      markerEvents = [
        'animation_changed', 'clickable_changed', 'cursor_changed', 'draggable_changed',
        'flat_changed', 'icon_changed', 'position_changed', 'shadow_changed',
        'shape_changed', 'title_changed', 'visible_changed', 'zindex_changed'
      ],
      markerMouseEvents = [
        'dblclick', 'drag', 'dragend', 'dragstart',
        'mousedown', 'mouseout', 'mouseover', 'mouseup'
      ],
      marker;

  markerOptions = _omit(markerOptions, optionsToDelete);

  marker = new google.maps.Marker(markerOptions);

  marker.fences = fences;

  if (infoWindowOptions) {
    marker.infoWindow = new google.maps.InfoWindow(infoWindowOptions);

    _forEach(infoWindowEvents, function(infoWindowEventName) {
      var listener = infoWindowOptions[infoWindowEventName];

      if (typeof listener === 'function') {
        google.maps.event.addListener(marker, infoWindowEventName, listener);
      }
    });
  }

  _forEach(markerEvents, function(markerEventName) {
    var listener = markerOptions[markerEventName];

    if (typeof listener === 'function') {
      google.maps.event.addListener(marker, markerEventName, listener);
    }
  });

  _forEach(markerMouseEvents, function(markerMouseEventName) {
    var listener = markerOptions[markerMouseEventName];

    if (typeof listener === 'function') {
      google.maps.event.addListener(marker, markerMouseEventName, function(eventObject) {
        if (eventObject && !eventObject.pixel) {
          eventObject.pixel = self.map.getProjection().fromLatLngToPoint(eventObject.latLng);
        }

        listener.call(marker, eventObject);
      });
    }
  });

  google.maps.event.addListener(marker, 'click', function(eventObject) {
    this.details = details;

    if (eventObject && !eventObject.pixel) {
      eventObject.pixel = self.map.getProjection().fromLatLngToPoint(eventObject.latLng);
    }

    if (typeof markerOptions.click === 'function') {
      markerOptions.click.call(this, eventObject);
    }

    if (marker.infoWindow) {
      self.hideInfoWindows();

      marker.infoWindow.open(self.map, marker);
    }
  });

  google.maps.event.addListener(marker, 'rightclick', function(eventObject) {
    eventObject.marker = this;

    if (eventObject && !eventObject.pixel) {
      eventObject.pixel = self.map.getProjection().fromLatLngToPoint(eventObject.latLng);
    }

    if (options.rightclick) {
      options.rightclick.call(this, eventObject);
    }

    if (self.contextMenu.marker !== undefined) {
      self.buildContextMenu('marker', eventObject);
    }
  });

  if (marker.fences && self.checkMarkerGeofence) {
    google.maps.event.addListener(marker, 'dragend', function() {
      self.checkMarkerGeofence(marker, outside, inside);
    });
  }

  return marker;
};

markersModule.addMarker = function(options) {
  var marker;

  if (options.hasOwnProperty('gm_accessors_')) {
    // Native google.maps.Marker object
    marker = options;
  }
  else {
    if ((options.hasOwnProperty('lat') && options.hasOwnProperty('lng')) || options.position) {
      marker = this.createMarker(options);
    }
    else {
      throw 'No latitude or longitude defined.';
    }
  }

  marker.setMap(this.map);

  if (this.markerClusterer) {
    this.markerClusterer.addMarker(marker);
  }

  this.markers.push(marker);

  if (GMaps.trigger) {
    GMaps.trigger('marker_added', this, marker);
  }

  return marker;
};

markersModule.addMarkers = function(arrayOfMarkerOptions) {
  var self = this,
      addedMarkers = _map(arrayOfMarkerOptions, function(markerOption) {
        return self.addMarker(markerOption);
      });

  return addedMarkers;
};

markersModule.hideInfoWindows = function() {
  _forEach(this.markers, function(marker) {
    if (marker.infoWindow) {
      marker.infoWindow.close();
    }
  });
};

markersModule.removeMarker = function(marker) {
  for (var i = 0; i < this.markers.length; i++) {
    var markerInMap = this.markers[i];

    if (markerInMap === marker) {
      markerInMap.setMap(null);

      this.markers.splice(i, 1);

      if (this.markerClusterer) {
        this.markerClusterer.removeMarker(marker);
      }

      if (GMaps.trigger) {
        GMaps.trigger('marker_removed', this, marker);
      }

      break;
    }
  }

  return marker;
};

markersModule.removeMarkers = function(collection) {
  var newMarkersCollection = [],
      self = this;

  if (collection === undefined) {
    _forEach(this.markers, function(marker) {
      marker.setMap(null);

      if (self.markerClusterer) {
        self.markerClusterer.removeMarker(marker);
      }

      if (GMaps.trigger) {
        GMaps.trigger('marker_removed', self, marker);
      }
    });
  }
  else {
    _forEach(collection, function(markerInCollection) {
      var index = self.markers.indexOf(markerInCollection),
          marker = self.markers[index];

      if (index > -1 && marker) {
        marker.setMap(null);

        if (self.markerClusterer) {
          self.markerClusterer.removeMarker(marker);
        }

        if (GMaps.trigger) {
          GMaps.trigger('marker_removed', self, marker);
        }
      }
    });

    _forEach(this.markers, function(marker) {
      if (marker.getMap() !== null) {
        newMarkersCollection.push(marker);
      }
    });
  }

  this.markers = newMarkersCollection;

  return newMarkersCollection.slice(0);
};

if (window.GMaps) {
  GMaps.customEvents = GMaps.customEvents || [];
  GMaps.customEvents = GMaps.customEvents.concat(['marker_added', 'marker_removed']);

  _extend(GMaps.prototype, markersModule);
}

module.exports = markersModule;
},{"lodash-compat/collection/forEach":8,"lodash-compat/collection/map":9,"lodash-compat/object/extend":75,"lodash-compat/object/omit":79}],6:[function(require,module,exports){
/*! jquery-locationpicker - v0.1.12 - 2015-01-05 */

!function(a){function b(a,b){var c=new google.maps.Map(a,b),d=new google.maps.Marker({position:new google.maps.LatLng(54.19335,-3.92695),map:c,title:"Drag Me",draggable:b.draggable});return{map:c,marker:d,circle:null,location:d.position,radius:b.radius,locationName:b.locationName,addressComponents:{formatted_address:null,addressLine1:null,addressLine2:null,streetName:null,streetNumber:null,city:null,district:null,state:null,stateOrProvince:null},settings:b.settings,domContainer:a,geodecoder:new google.maps.Geocoder}}function c(a){return void 0!=d(a)}function d(b){return a(b).data("locationpicker")}function e(a,b){if(a){var c=h.locationFromLatLng(b.location);a.latitudeInput&&a.latitudeInput.val(c.latitude).change(),a.longitudeInput&&a.longitudeInput.val(c.longitude).change(),a.radiusInput&&a.radiusInput.val(b.radius).change(),a.locationNameInput&&a.locationNameInput.val(b.locationName).change()}}function f(b,c){b&&(b.radiusInput&&b.radiusInput.on("change",function(b){b.originalEvent&&(c.radius=a(this).val(),h.setPosition(c,c.location,function(a){a.settings.onchanged.apply(c.domContainer,[h.locationFromLatLng(a.location),a.radius,!1])}))}),b.locationNameInput&&c.settings.enableAutocomplete&&(c.autocomplete=new google.maps.places.Autocomplete(b.locationNameInput.get(0)),google.maps.event.addListener(c.autocomplete,"place_changed",function(){var a=c.autocomplete.getPlace();return a.geometry?void h.setPosition(c,a.geometry.location,function(a){e(b,a),a.settings.onchanged.apply(c.domContainer,[h.locationFromLatLng(a.location),a.radius,!1])}):void c.settings.onlocationnotfound(a.name)})),b.latitudeInput&&b.latitudeInput.on("change",function(b){b.originalEvent&&h.setPosition(c,new google.maps.LatLng(a(this).val(),c.location.lng()),function(a){a.settings.onchanged.apply(c.domContainer,[h.locationFromLatLng(a.location),a.radius,!1])})}),b.longitudeInput&&b.longitudeInput.on("change",function(b){b.originalEvent&&h.setPosition(c,new google.maps.LatLng(c.location.lat(),a(this).val()),function(a){a.settings.onchanged.apply(c.domContainer,[h.locationFromLatLng(a.location),a.radius,!1])})}))}function g(a){google.maps.event.trigger(a.map,"resize"),setTimeout(function(){a.map.setCenter(a.marker.position)},300)}var h={drawCircle:function(b,c,d,e){return null!=b.circle&&b.circle.setMap(null),d>0?(d*=1,e=a.extend({strokeColor:"#0000FF",strokeOpacity:.35,strokeWeight:2,fillColor:"#0000FF",fillOpacity:.2},e),e.map=b.map,e.radius=d,e.center=c,b.circle=new google.maps.Circle(e),b.circle):null},setPosition:function(a,b,c){a.location=b,a.marker.setPosition(b),a.map.panTo(b),this.drawCircle(a,b,a.radius,{}),a.settings.enableReverseGeocode?a.geodecoder.geocode({latLng:a.location},function(b,d){d==google.maps.GeocoderStatus.OK&&b.length>0&&(a.locationName=b[0].formatted_address,a.addressComponents=h.address_component_from_google_geocode(b[0].address_components)),c&&c.call(this,a)}):c&&c.call(this,a)},locationFromLatLng:function(a){return{latitude:a.lat(),longitude:a.lng()}},address_component_from_google_geocode:function(a){for(var b={},c=a.length-1;c>=0;c--){var d=a[c];d.types.indexOf("postal_code")>=0?b.postalCode=d.short_name:d.types.indexOf("street_number")>=0?b.streetNumber=d.short_name:d.types.indexOf("route")>=0?b.streetName=d.short_name:d.types.indexOf("locality")>=0?b.city=d.short_name:d.types.indexOf("sublocality")>=0?b.district=d.short_name:d.types.indexOf("administrative_area_level_1")>=0?b.stateOrProvince=d.short_name:d.types.indexOf("country")>=0&&(b.country=d.short_name)}return b.addressLine1=[b.streetNumber,b.streetName].join(" ").trim(),b.addressLine2="",b}};a.fn.locationpicker=function(i,j){if("string"==typeof i){var k=this.get(0);if(!c(k))return;var l=d(k);switch(i){case"location":if(void 0==j){var m=h.locationFromLatLng(l.location);return m.radius=l.radius,m.name=l.locationName,m}j.radius&&(l.radius=j.radius),h.setPosition(l,new google.maps.LatLng(j.latitude,j.longitude),function(a){e(a.settings.inputBinding,a)});break;case"subscribe":if(void 0==j)return null;var n=j.event,o=j.callback;if(!n||!o)return console.error('LocationPicker: Invalid arguments for method "subscribe"'),null;google.maps.event.addListener(l.map,n,o);break;case"map":if(void 0==j){var p=h.locationFromLatLng(l.location);return p.formattedAddress=l.locationName,p.addressComponents=l.addressComponents,{map:l.map,marker:l.marker,location:p}}return null;case"autosize":return g(l),this}return null}return this.each(function(){var d=a(this);if(!c(this)){var g=a.extend({},a.fn.locationpicker.defaults,i),j=new b(this,{zoom:g.zoom,center:new google.maps.LatLng(g.location.latitude,g.location.longitude),mapTypeId:google.maps.MapTypeId.ROADMAP,mapTypeControl:!1,disableDoubleClickZoom:!1,scrollwheel:g.scrollwheel,streetViewControl:!1,radius:g.radius,locationName:g.locationName,settings:g,draggable:g.draggable});d.data("locationpicker",j),google.maps.event.addListener(j.marker,"dragend",function(){h.setPosition(j,j.marker.position,function(a){var b=h.locationFromLatLng(j.location);a.settings.onchanged.apply(j.domContainer,[b,a.radius,!0]),e(j.settings.inputBinding,j)})}),h.setPosition(j,new google.maps.LatLng(g.location.latitude,g.location.longitude),function(a){e(g.inputBinding,j),f(g.inputBinding,j),a.settings.oninitialized(d)})}})},a.fn.locationpicker.defaults={location:{latitude:40.7324319,longitude:-73.82480799999996},locationName:"",radius:500,zoom:15,scrollwheel:!0,inputBinding:{latitudeInput:null,longitudeInput:null,radiusInput:null,locationNameInput:null},enableAutocomplete:!1,enableReverseGeocode:!0,draggable:!0,onchanged:function(){},onlocationnotfound:function(){},oninitialized:function(){}}}(jQuery);

},{}],7:[function(require,module,exports){
/**
 * Gets the last element of `array`.
 *
 * @static
 * @memberOf _
 * @category Array
 * @param {Array} array The array to query.
 * @returns {*} Returns the last element of `array`.
 * @example
 *
 * _.last([1, 2, 3]);
 * // => 3
 */
function last(array) {
  var length = array ? array.length : 0;
  return length ? array[length - 1] : undefined;
}

module.exports = last;

},{}],8:[function(require,module,exports){
var arrayEach = require('../internal/arrayEach'),
    baseEach = require('../internal/baseEach'),
    createForEach = require('../internal/createForEach');

/**
 * Iterates over elements of `collection` invoking `iteratee` for each element.
 * The `iteratee` is bound to `thisArg` and invoked with three arguments:
 * (value, index|key, collection). Iteratee functions may exit iteration early
 * by explicitly returning `false`.
 *
 * **Note:** As with other "Collections" methods, objects with a "length" property
 * are iterated like arrays. To avoid this behavior `_.forIn` or `_.forOwn`
 * may be used for object iteration.
 *
 * @static
 * @memberOf _
 * @alias each
 * @category Collection
 * @param {Array|Object|string} collection The collection to iterate over.
 * @param {Function} [iteratee=_.identity] The function invoked per iteration.
 * @param {*} [thisArg] The `this` binding of `iteratee`.
 * @returns {Array|Object|string} Returns `collection`.
 * @example
 *
 * _([1, 2]).forEach(function(n) {
 *   console.log(n);
 * }).value();
 * // => logs each value from left to right and returns the array
 *
 * _.forEach({ 'a': 1, 'b': 2 }, function(n, key) {
 *   console.log(n, key);
 * });
 * // => logs each value-key pair and returns the object (iteration order is not guaranteed)
 */
var forEach = createForEach(arrayEach, baseEach);

module.exports = forEach;

},{"../internal/arrayEach":12,"../internal/baseEach":21,"../internal/createForEach":45}],9:[function(require,module,exports){
var arrayMap = require('../internal/arrayMap'),
    baseCallback = require('../internal/baseCallback'),
    baseMap = require('../internal/baseMap'),
    isArray = require('../lang/isArray');

/**
 * Creates an array of values by running each element in `collection` through
 * `iteratee`. The `iteratee` is bound to `thisArg` and invoked with three
 * arguments: (value, index|key, collection).
 *
 * If a property name is provided for `iteratee` the created `_.property`
 * style callback returns the property value of the given element.
 *
 * If a value is also provided for `thisArg` the created `_.matchesProperty`
 * style callback returns `true` for elements that have a matching property
 * value, else `false`.
 *
 * If an object is provided for `iteratee` the created `_.matches` style
 * callback returns `true` for elements that have the properties of the given
 * object, else `false`.
 *
 * Many lodash methods are guarded to work as iteratees for methods like
 * `_.every`, `_.filter`, `_.map`, `_.mapValues`, `_.reject`, and `_.some`.
 *
 * The guarded methods are:
 * `ary`, `callback`, `chunk`, `clone`, `create`, `curry`, `curryRight`,
 * `drop`, `dropRight`, `every`, `fill`, `flatten`, `invert`, `max`, `min`,
 * `parseInt`, `slice`, `sortBy`, `take`, `takeRight`, `template`, `trim`,
 * `trimLeft`, `trimRight`, `trunc`, `random`, `range`, `sample`, `some`,
 * `sum`, `uniq`, and `words`
 *
 * @static
 * @memberOf _
 * @alias collect
 * @category Collection
 * @param {Array|Object|string} collection The collection to iterate over.
 * @param {Function|Object|string} [iteratee=_.identity] The function invoked
 *  per iteration.
 * @param {*} [thisArg] The `this` binding of `iteratee`.
 * @returns {Array} Returns the new mapped array.
 * @example
 *
 * function timesThree(n) {
 *   return n * 3;
 * }
 *
 * _.map([1, 2], timesThree);
 * // => [3, 6]
 *
 * _.map({ 'a': 1, 'b': 2 }, timesThree);
 * // => [3, 6] (iteration order is not guaranteed)
 *
 * var users = [
 *   { 'user': 'barney' },
 *   { 'user': 'fred' }
 * ];
 *
 * // using the `_.property` callback shorthand
 * _.map(users, 'user');
 * // => ['barney', 'fred']
 */
function map(collection, iteratee, thisArg) {
  var func = isArray(collection) ? arrayMap : baseMap;
  iteratee = baseCallback(iteratee, thisArg, 3);
  return func(collection, iteratee);
}

module.exports = map;

},{"../internal/arrayMap":13,"../internal/baseCallback":18,"../internal/baseMap":31,"../lang/isArray":68}],10:[function(require,module,exports){
/** Used as the `TypeError` message for "Functions" methods. */
var FUNC_ERROR_TEXT = 'Expected a function';

/* Native method references for those with the same name as other `lodash` methods. */
var nativeMax = Math.max;

/**
 * Creates a function that invokes `func` with the `this` binding of the
 * created function and arguments from `start` and beyond provided as an array.
 *
 * **Note:** This method is based on the [rest parameter](https://developer.mozilla.org/Web/JavaScript/Reference/Functions/rest_parameters).
 *
 * @static
 * @memberOf _
 * @category Function
 * @param {Function} func The function to apply a rest parameter to.
 * @param {number} [start=func.length-1] The start position of the rest parameter.
 * @returns {Function} Returns the new function.
 * @example
 *
 * var say = _.restParam(function(what, names) {
 *   return what + ' ' + _.initial(names).join(', ') +
 *     (_.size(names) > 1 ? ', & ' : '') + _.last(names);
 * });
 *
 * say('hello', 'fred', 'barney', 'pebbles');
 * // => 'hello fred, barney, & pebbles'
 */
function restParam(func, start) {
  if (typeof func != 'function') {
    throw new TypeError(FUNC_ERROR_TEXT);
  }
  start = nativeMax(start === undefined ? (func.length - 1) : (+start || 0), 0);
  return function() {
    var args = arguments,
        index = -1,
        length = nativeMax(args.length - start, 0),
        rest = Array(length);

    while (++index < length) {
      rest[index] = args[start + index];
    }
    switch (start) {
      case 0: return func.call(this, rest);
      case 1: return func.call(this, args[0], rest);
      case 2: return func.call(this, args[0], args[1], rest);
    }
    var otherArgs = Array(start + 1);
    index = -1;
    while (++index < start) {
      otherArgs[index] = args[index];
    }
    otherArgs[start] = rest;
    return func.apply(this, otherArgs);
  };
}

module.exports = restParam;

},{}],11:[function(require,module,exports){
(function (global){
var cachePush = require('./cachePush'),
    getNative = require('./getNative');

/** Native method references. */
var Set = getNative(global, 'Set');

/* Native method references for those with the same name as other `lodash` methods. */
var nativeCreate = getNative(Object, 'create');

/**
 *
 * Creates a cache object to store unique values.
 *
 * @private
 * @param {Array} [values] The values to cache.
 */
function SetCache(values) {
  var length = values ? values.length : 0;

  this.data = { 'hash': nativeCreate(null), 'set': new Set };
  while (length--) {
    this.push(values[length]);
  }
}

// Add functions to the `Set` cache.
SetCache.prototype.push = cachePush;

module.exports = SetCache;

}).call(this,typeof global !== "undefined" ? global : typeof self !== "undefined" ? self : typeof window !== "undefined" ? window : {})
},{"./cachePush":40,"./getNative":52}],12:[function(require,module,exports){
/**
 * A specialized version of `_.forEach` for arrays without support for callback
 * shorthands and `this` binding.
 *
 * @private
 * @param {Array} array The array to iterate over.
 * @param {Function} iteratee The function invoked per iteration.
 * @returns {Array} Returns `array`.
 */
function arrayEach(array, iteratee) {
  var index = -1,
      length = array.length;

  while (++index < length) {
    if (iteratee(array[index], index, array) === false) {
      break;
    }
  }
  return array;
}

module.exports = arrayEach;

},{}],13:[function(require,module,exports){
/**
 * A specialized version of `_.map` for arrays without support for callback
 * shorthands and `this` binding.
 *
 * @private
 * @param {Array} array The array to iterate over.
 * @param {Function} iteratee The function invoked per iteration.
 * @returns {Array} Returns the new mapped array.
 */
function arrayMap(array, iteratee) {
  var index = -1,
      length = array.length,
      result = Array(length);

  while (++index < length) {
    result[index] = iteratee(array[index], index, array);
  }
  return result;
}

module.exports = arrayMap;

},{}],14:[function(require,module,exports){
/**
 * Appends the elements of `values` to `array`.
 *
 * @private
 * @param {Array} array The array to modify.
 * @param {Array} values The values to append.
 * @returns {Array} Returns `array`.
 */
function arrayPush(array, values) {
  var index = -1,
      length = values.length,
      offset = array.length;

  while (++index < length) {
    array[offset + index] = values[index];
  }
  return array;
}

module.exports = arrayPush;

},{}],15:[function(require,module,exports){
/**
 * A specialized version of `_.some` for arrays without support for callback
 * shorthands and `this` binding.
 *
 * @private
 * @param {Array} array The array to iterate over.
 * @param {Function} predicate The function invoked per iteration.
 * @returns {boolean} Returns `true` if any element passes the predicate check,
 *  else `false`.
 */
function arraySome(array, predicate) {
  var index = -1,
      length = array.length;

  while (++index < length) {
    if (predicate(array[index], index, array)) {
      return true;
    }
  }
  return false;
}

module.exports = arraySome;

},{}],16:[function(require,module,exports){
var keys = require('../object/keys');

/**
 * A specialized version of `_.assign` for customizing assigned values without
 * support for argument juggling, multiple sources, and `this` binding `customizer`
 * functions.
 *
 * @private
 * @param {Object} object The destination object.
 * @param {Object} source The source object.
 * @param {Function} customizer The function to customize assigned values.
 * @returns {Object} Returns `object`.
 */
function assignWith(object, source, customizer) {
  var index = -1,
      props = keys(source),
      length = props.length;

  while (++index < length) {
    var key = props[index],
        value = object[key],
        result = customizer(value, source[key], key, object, source);

    if ((result === result ? (result !== value) : (value === value)) ||
        (value === undefined && !(key in object))) {
      object[key] = result;
    }
  }
  return object;
}

module.exports = assignWith;

},{"../object/keys":77}],17:[function(require,module,exports){
var baseCopy = require('./baseCopy'),
    keys = require('../object/keys');

/**
 * The base implementation of `_.assign` without support for argument juggling,
 * multiple sources, and `customizer` functions.
 *
 * @private
 * @param {Object} object The destination object.
 * @param {Object} source The source object.
 * @returns {Object} Returns `object`.
 */
function baseAssign(object, source) {
  return source == null
    ? object
    : baseCopy(source, keys(source), object);
}

module.exports = baseAssign;

},{"../object/keys":77,"./baseCopy":19}],18:[function(require,module,exports){
var baseMatches = require('./baseMatches'),
    baseMatchesProperty = require('./baseMatchesProperty'),
    bindCallback = require('./bindCallback'),
    identity = require('../utility/identity'),
    property = require('../utility/property');

/**
 * The base implementation of `_.callback` which supports specifying the
 * number of arguments to provide to `func`.
 *
 * @private
 * @param {*} [func=_.identity] The value to convert to a callback.
 * @param {*} [thisArg] The `this` binding of `func`.
 * @param {number} [argCount] The number of arguments to provide to `func`.
 * @returns {Function} Returns the callback.
 */
function baseCallback(func, thisArg, argCount) {
  var type = typeof func;
  if (type == 'function') {
    return thisArg === undefined
      ? func
      : bindCallback(func, thisArg, argCount);
  }
  if (func == null) {
    return identity;
  }
  if (type == 'object') {
    return baseMatches(func);
  }
  return thisArg === undefined
    ? property(func)
    : baseMatchesProperty(func, thisArg);
}

module.exports = baseCallback;

},{"../utility/identity":82,"../utility/property":83,"./baseMatches":32,"./baseMatchesProperty":33,"./bindCallback":38}],19:[function(require,module,exports){
/**
 * Copies properties of `source` to `object`.
 *
 * @private
 * @param {Object} source The object to copy properties from.
 * @param {Array} props The property names to copy.
 * @param {Object} [object={}] The object to copy properties to.
 * @returns {Object} Returns `object`.
 */
function baseCopy(source, props, object) {
  object || (object = {});

  var index = -1,
      length = props.length;

  while (++index < length) {
    var key = props[index];
    object[key] = source[key];
  }
  return object;
}

module.exports = baseCopy;

},{}],20:[function(require,module,exports){
var baseIndexOf = require('./baseIndexOf'),
    cacheIndexOf = require('./cacheIndexOf'),
    createCache = require('./createCache');

/** Used as the size to enable large array optimizations. */
var LARGE_ARRAY_SIZE = 200;

/**
 * The base implementation of `_.difference` which accepts a single array
 * of values to exclude.
 *
 * @private
 * @param {Array} array The array to inspect.
 * @param {Array} values The values to exclude.
 * @returns {Array} Returns the new array of filtered values.
 */
function baseDifference(array, values) {
  var length = array ? array.length : 0,
      result = [];

  if (!length) {
    return result;
  }
  var index = -1,
      indexOf = baseIndexOf,
      isCommon = true,
      cache = (isCommon && values.length >= LARGE_ARRAY_SIZE) ? createCache(values) : null,
      valuesLength = values.length;

  if (cache) {
    indexOf = cacheIndexOf;
    isCommon = false;
    values = cache;
  }
  outer:
  while (++index < length) {
    var value = array[index];

    if (isCommon && value === value) {
      var valuesIndex = valuesLength;
      while (valuesIndex--) {
        if (values[valuesIndex] === value) {
          continue outer;
        }
      }
      result.push(value);
    }
    else if (indexOf(values, value, 0) < 0) {
      result.push(value);
    }
  }
  return result;
}

module.exports = baseDifference;

},{"./baseIndexOf":27,"./cacheIndexOf":39,"./createCache":44}],21:[function(require,module,exports){
var baseForOwn = require('./baseForOwn'),
    createBaseEach = require('./createBaseEach');

/**
 * The base implementation of `_.forEach` without support for callback
 * shorthands and `this` binding.
 *
 * @private
 * @param {Array|Object|string} collection The collection to iterate over.
 * @param {Function} iteratee The function invoked per iteration.
 * @returns {Array|Object|string} Returns `collection`.
 */
var baseEach = createBaseEach(baseForOwn);

module.exports = baseEach;

},{"./baseForOwn":25,"./createBaseEach":42}],22:[function(require,module,exports){
var arrayPush = require('./arrayPush'),
    isArguments = require('../lang/isArguments'),
    isArray = require('../lang/isArray'),
    isArrayLike = require('./isArrayLike'),
    isObjectLike = require('./isObjectLike');

/**
 * The base implementation of `_.flatten` with added support for restricting
 * flattening and specifying the start index.
 *
 * @private
 * @param {Array} array The array to flatten.
 * @param {boolean} [isDeep] Specify a deep flatten.
 * @param {boolean} [isStrict] Restrict flattening to arrays-like objects.
 * @param {Array} [result=[]] The initial result value.
 * @returns {Array} Returns the new flattened array.
 */
function baseFlatten(array, isDeep, isStrict, result) {
  result || (result = []);

  var index = -1,
      length = array.length;

  while (++index < length) {
    var value = array[index];
    if (isObjectLike(value) && isArrayLike(value) &&
        (isStrict || isArray(value) || isArguments(value))) {
      if (isDeep) {
        // Recursively flatten arrays (susceptible to call stack limits).
        baseFlatten(value, isDeep, isStrict, result);
      } else {
        arrayPush(result, value);
      }
    } else if (!isStrict) {
      result[result.length] = value;
    }
  }
  return result;
}

module.exports = baseFlatten;

},{"../lang/isArguments":67,"../lang/isArray":68,"./arrayPush":14,"./isArrayLike":54,"./isObjectLike":60}],23:[function(require,module,exports){
var createBaseFor = require('./createBaseFor');

/**
 * The base implementation of `baseForIn` and `baseForOwn` which iterates
 * over `object` properties returned by `keysFunc` invoking `iteratee` for
 * each property. Iteratee functions may exit iteration early by explicitly
 * returning `false`.
 *
 * @private
 * @param {Object} object The object to iterate over.
 * @param {Function} iteratee The function invoked per iteration.
 * @param {Function} keysFunc The function to get the keys of `object`.
 * @returns {Object} Returns `object`.
 */
var baseFor = createBaseFor();

module.exports = baseFor;

},{"./createBaseFor":43}],24:[function(require,module,exports){
var baseFor = require('./baseFor'),
    keysIn = require('../object/keysIn');

/**
 * The base implementation of `_.forIn` without support for callback
 * shorthands and `this` binding.
 *
 * @private
 * @param {Object} object The object to iterate over.
 * @param {Function} iteratee The function invoked per iteration.
 * @returns {Object} Returns `object`.
 */
function baseForIn(object, iteratee) {
  return baseFor(object, iteratee, keysIn);
}

module.exports = baseForIn;

},{"../object/keysIn":78,"./baseFor":23}],25:[function(require,module,exports){
var baseFor = require('./baseFor'),
    keys = require('../object/keys');

/**
 * The base implementation of `_.forOwn` without support for callback
 * shorthands and `this` binding.
 *
 * @private
 * @param {Object} object The object to iterate over.
 * @param {Function} iteratee The function invoked per iteration.
 * @returns {Object} Returns `object`.
 */
function baseForOwn(object, iteratee) {
  return baseFor(object, iteratee, keys);
}

module.exports = baseForOwn;

},{"../object/keys":77,"./baseFor":23}],26:[function(require,module,exports){
var toObject = require('./toObject');

/**
 * The base implementation of `get` without support for string paths
 * and default values.
 *
 * @private
 * @param {Object} object The object to query.
 * @param {Array} path The path of the property to get.
 * @param {string} [pathKey] The key representation of path.
 * @returns {*} Returns the resolved value.
 */
function baseGet(object, path, pathKey) {
  if (object == null) {
    return;
  }
  object = toObject(object);
  if (pathKey !== undefined && pathKey in object) {
    path = [pathKey];
  }
  var index = 0,
      length = path.length;

  while (object != null && index < length) {
    object = toObject(object)[path[index++]];
  }
  return (index && index == length) ? object : undefined;
}

module.exports = baseGet;

},{"./toObject":65}],27:[function(require,module,exports){
var indexOfNaN = require('./indexOfNaN');

/**
 * The base implementation of `_.indexOf` without support for binary searches.
 *
 * @private
 * @param {Array} array The array to search.
 * @param {*} value The value to search for.
 * @param {number} fromIndex The index to search from.
 * @returns {number} Returns the index of the matched value, else `-1`.
 */
function baseIndexOf(array, value, fromIndex) {
  if (value !== value) {
    return indexOfNaN(array, fromIndex);
  }
  var index = fromIndex - 1,
      length = array.length;

  while (++index < length) {
    if (array[index] === value) {
      return index;
    }
  }
  return -1;
}

module.exports = baseIndexOf;

},{"./indexOfNaN":53}],28:[function(require,module,exports){
var baseIsEqualDeep = require('./baseIsEqualDeep'),
    isObject = require('../lang/isObject'),
    isObjectLike = require('./isObjectLike');

/**
 * The base implementation of `_.isEqual` without support for `this` binding
 * `customizer` functions.
 *
 * @private
 * @param {*} value The value to compare.
 * @param {*} other The other value to compare.
 * @param {Function} [customizer] The function to customize comparing values.
 * @param {boolean} [isLoose] Specify performing partial comparisons.
 * @param {Array} [stackA] Tracks traversed `value` objects.
 * @param {Array} [stackB] Tracks traversed `other` objects.
 * @returns {boolean} Returns `true` if the values are equivalent, else `false`.
 */
function baseIsEqual(value, other, customizer, isLoose, stackA, stackB) {
  if (value === other) {
    return true;
  }
  if (value == null || other == null || (!isObject(value) && !isObjectLike(other))) {
    return value !== value && other !== other;
  }
  return baseIsEqualDeep(value, other, baseIsEqual, customizer, isLoose, stackA, stackB);
}

module.exports = baseIsEqual;

},{"../lang/isObject":71,"./baseIsEqualDeep":29,"./isObjectLike":60}],29:[function(require,module,exports){
var equalArrays = require('./equalArrays'),
    equalByTag = require('./equalByTag'),
    equalObjects = require('./equalObjects'),
    isArray = require('../lang/isArray'),
    isHostObject = require('./isHostObject'),
    isTypedArray = require('../lang/isTypedArray');

/** `Object#toString` result references. */
var argsTag = '[object Arguments]',
    arrayTag = '[object Array]',
    objectTag = '[object Object]';

/** Used for native method references. */
var objectProto = Object.prototype;

/** Used to check objects for own properties. */
var hasOwnProperty = objectProto.hasOwnProperty;

/**
 * Used to resolve the [`toStringTag`](http://ecma-international.org/ecma-262/6.0/#sec-object.prototype.tostring)
 * of values.
 */
var objToString = objectProto.toString;

/**
 * A specialized version of `baseIsEqual` for arrays and objects which performs
 * deep comparisons and tracks traversed objects enabling objects with circular
 * references to be compared.
 *
 * @private
 * @param {Object} object The object to compare.
 * @param {Object} other The other object to compare.
 * @param {Function} equalFunc The function to determine equivalents of values.
 * @param {Function} [customizer] The function to customize comparing objects.
 * @param {boolean} [isLoose] Specify performing partial comparisons.
 * @param {Array} [stackA=[]] Tracks traversed `value` objects.
 * @param {Array} [stackB=[]] Tracks traversed `other` objects.
 * @returns {boolean} Returns `true` if the objects are equivalent, else `false`.
 */
function baseIsEqualDeep(object, other, equalFunc, customizer, isLoose, stackA, stackB) {
  var objIsArr = isArray(object),
      othIsArr = isArray(other),
      objTag = arrayTag,
      othTag = arrayTag;

  if (!objIsArr) {
    objTag = objToString.call(object);
    if (objTag == argsTag) {
      objTag = objectTag;
    } else if (objTag != objectTag) {
      objIsArr = isTypedArray(object);
    }
  }
  if (!othIsArr) {
    othTag = objToString.call(other);
    if (othTag == argsTag) {
      othTag = objectTag;
    } else if (othTag != objectTag) {
      othIsArr = isTypedArray(other);
    }
  }
  var objIsObj = objTag == objectTag && !isHostObject(object),
      othIsObj = othTag == objectTag && !isHostObject(other),
      isSameTag = objTag == othTag;

  if (isSameTag && !(objIsArr || objIsObj)) {
    return equalByTag(object, other, objTag);
  }
  if (!isLoose) {
    var objIsWrapped = objIsObj && hasOwnProperty.call(object, '__wrapped__'),
        othIsWrapped = othIsObj && hasOwnProperty.call(other, '__wrapped__');

    if (objIsWrapped || othIsWrapped) {
      return equalFunc(objIsWrapped ? object.value() : object, othIsWrapped ? other.value() : other, customizer, isLoose, stackA, stackB);
    }
  }
  if (!isSameTag) {
    return false;
  }
  // Assume cyclic values are equal.
  // For more information on detecting circular references see https://es5.github.io/#JO.
  stackA || (stackA = []);
  stackB || (stackB = []);

  var length = stackA.length;
  while (length--) {
    if (stackA[length] == object) {
      return stackB[length] == other;
    }
  }
  // Add `object` and `other` to the stack of traversed objects.
  stackA.push(object);
  stackB.push(other);

  var result = (objIsArr ? equalArrays : equalObjects)(object, other, equalFunc, customizer, isLoose, stackA, stackB);

  stackA.pop();
  stackB.pop();

  return result;
}

module.exports = baseIsEqualDeep;

},{"../lang/isArray":68,"../lang/isTypedArray":73,"./equalArrays":47,"./equalByTag":48,"./equalObjects":49,"./isHostObject":55}],30:[function(require,module,exports){
var baseIsEqual = require('./baseIsEqual'),
    toObject = require('./toObject');

/**
 * The base implementation of `_.isMatch` without support for callback
 * shorthands and `this` binding.
 *
 * @private
 * @param {Object} object The object to inspect.
 * @param {Array} matchData The propery names, values, and compare flags to match.
 * @param {Function} [customizer] The function to customize comparing objects.
 * @returns {boolean} Returns `true` if `object` is a match, else `false`.
 */
function baseIsMatch(object, matchData, customizer) {
  var index = matchData.length,
      length = index,
      noCustomizer = !customizer;

  if (object == null) {
    return !length;
  }
  object = toObject(object);
  while (index--) {
    var data = matchData[index];
    if ((noCustomizer && data[2])
          ? data[1] !== object[data[0]]
          : !(data[0] in object)
        ) {
      return false;
    }
  }
  while (++index < length) {
    data = matchData[index];
    var key = data[0],
        objValue = object[key],
        srcValue = data[1];

    if (noCustomizer && data[2]) {
      if (objValue === undefined && !(key in object)) {
        return false;
      }
    } else {
      var result = customizer ? customizer(objValue, srcValue, key) : undefined;
      if (!(result === undefined ? baseIsEqual(srcValue, objValue, customizer, true) : result)) {
        return false;
      }
    }
  }
  return true;
}

module.exports = baseIsMatch;

},{"./baseIsEqual":28,"./toObject":65}],31:[function(require,module,exports){
var baseEach = require('./baseEach'),
    isArrayLike = require('./isArrayLike');

/**
 * The base implementation of `_.map` without support for callback shorthands
 * and `this` binding.
 *
 * @private
 * @param {Array|Object|string} collection The collection to iterate over.
 * @param {Function} iteratee The function invoked per iteration.
 * @returns {Array} Returns the new mapped array.
 */
function baseMap(collection, iteratee) {
  var index = -1,
      result = isArrayLike(collection) ? Array(collection.length) : [];

  baseEach(collection, function(value, key, collection) {
    result[++index] = iteratee(value, key, collection);
  });
  return result;
}

module.exports = baseMap;

},{"./baseEach":21,"./isArrayLike":54}],32:[function(require,module,exports){
var baseIsMatch = require('./baseIsMatch'),
    getMatchData = require('./getMatchData'),
    toObject = require('./toObject');

/**
 * The base implementation of `_.matches` which does not clone `source`.
 *
 * @private
 * @param {Object} source The object of property values to match.
 * @returns {Function} Returns the new function.
 */
function baseMatches(source) {
  var matchData = getMatchData(source);
  if (matchData.length == 1 && matchData[0][2]) {
    var key = matchData[0][0],
        value = matchData[0][1];

    return function(object) {
      if (object == null) {
        return false;
      }
      object = toObject(object);
      return object[key] === value && (value !== undefined || (key in object));
    };
  }
  return function(object) {
    return baseIsMatch(object, matchData);
  };
}

module.exports = baseMatches;

},{"./baseIsMatch":30,"./getMatchData":51,"./toObject":65}],33:[function(require,module,exports){
var baseGet = require('./baseGet'),
    baseIsEqual = require('./baseIsEqual'),
    baseSlice = require('./baseSlice'),
    isArray = require('../lang/isArray'),
    isKey = require('./isKey'),
    isStrictComparable = require('./isStrictComparable'),
    last = require('../array/last'),
    toObject = require('./toObject'),
    toPath = require('./toPath');

/**
 * The base implementation of `_.matchesProperty` which does not clone `srcValue`.
 *
 * @private
 * @param {string} path The path of the property to get.
 * @param {*} srcValue The value to compare.
 * @returns {Function} Returns the new function.
 */
function baseMatchesProperty(path, srcValue) {
  var isArr = isArray(path),
      isCommon = isKey(path) && isStrictComparable(srcValue),
      pathKey = (path + '');

  path = toPath(path);
  return function(object) {
    if (object == null) {
      return false;
    }
    var key = pathKey;
    object = toObject(object);
    if ((isArr || !isCommon) && !(key in object)) {
      object = path.length == 1 ? object : baseGet(object, baseSlice(path, 0, -1));
      if (object == null) {
        return false;
      }
      key = last(path);
      object = toObject(object);
    }
    return object[key] === srcValue
      ? (srcValue !== undefined || (key in object))
      : baseIsEqual(srcValue, object[key], undefined, true);
  };
}

module.exports = baseMatchesProperty;

},{"../array/last":7,"../lang/isArray":68,"./baseGet":26,"./baseIsEqual":28,"./baseSlice":36,"./isKey":58,"./isStrictComparable":61,"./toObject":65,"./toPath":66}],34:[function(require,module,exports){
var toObject = require('./toObject');

/**
 * The base implementation of `_.property` without support for deep paths.
 *
 * @private
 * @param {string} key The key of the property to get.
 * @returns {Function} Returns the new function.
 */
function baseProperty(key) {
  return function(object) {
    return object == null ? undefined : toObject(object)[key];
  };
}

module.exports = baseProperty;

},{"./toObject":65}],35:[function(require,module,exports){
var baseGet = require('./baseGet'),
    toPath = require('./toPath');

/**
 * A specialized version of `baseProperty` which supports deep paths.
 *
 * @private
 * @param {Array|string} path The path of the property to get.
 * @returns {Function} Returns the new function.
 */
function basePropertyDeep(path) {
  var pathKey = (path + '');
  path = toPath(path);
  return function(object) {
    return baseGet(object, path, pathKey);
  };
}

module.exports = basePropertyDeep;

},{"./baseGet":26,"./toPath":66}],36:[function(require,module,exports){
/**
 * The base implementation of `_.slice` without an iteratee call guard.
 *
 * @private
 * @param {Array} array The array to slice.
 * @param {number} [start=0] The start position.
 * @param {number} [end=array.length] The end position.
 * @returns {Array} Returns the slice of `array`.
 */
function baseSlice(array, start, end) {
  var index = -1,
      length = array.length;

  start = start == null ? 0 : (+start || 0);
  if (start < 0) {
    start = -start > length ? 0 : (length + start);
  }
  end = (end === undefined || end > length) ? length : (+end || 0);
  if (end < 0) {
    end += length;
  }
  length = start > end ? 0 : ((end - start) >>> 0);
  start >>>= 0;

  var result = Array(length);
  while (++index < length) {
    result[index] = array[index + start];
  }
  return result;
}

module.exports = baseSlice;

},{}],37:[function(require,module,exports){
/**
 * Converts `value` to a string if it's not one. An empty string is returned
 * for `null` or `undefined` values.
 *
 * @private
 * @param {*} value The value to process.
 * @returns {string} Returns the string.
 */
function baseToString(value) {
  return value == null ? '' : (value + '');
}

module.exports = baseToString;

},{}],38:[function(require,module,exports){
var identity = require('../utility/identity');

/**
 * A specialized version of `baseCallback` which only supports `this` binding
 * and specifying the number of arguments to provide to `func`.
 *
 * @private
 * @param {Function} func The function to bind.
 * @param {*} thisArg The `this` binding of `func`.
 * @param {number} [argCount] The number of arguments to provide to `func`.
 * @returns {Function} Returns the callback.
 */
function bindCallback(func, thisArg, argCount) {
  if (typeof func != 'function') {
    return identity;
  }
  if (thisArg === undefined) {
    return func;
  }
  switch (argCount) {
    case 1: return function(value) {
      return func.call(thisArg, value);
    };
    case 3: return function(value, index, collection) {
      return func.call(thisArg, value, index, collection);
    };
    case 4: return function(accumulator, value, index, collection) {
      return func.call(thisArg, accumulator, value, index, collection);
    };
    case 5: return function(value, other, key, object, source) {
      return func.call(thisArg, value, other, key, object, source);
    };
  }
  return function() {
    return func.apply(thisArg, arguments);
  };
}

module.exports = bindCallback;

},{"../utility/identity":82}],39:[function(require,module,exports){
var isObject = require('../lang/isObject');

/**
 * Checks if `value` is in `cache` mimicking the return signature of
 * `_.indexOf` by returning `0` if the value is found, else `-1`.
 *
 * @private
 * @param {Object} cache The cache to search.
 * @param {*} value The value to search for.
 * @returns {number} Returns `0` if `value` is found, else `-1`.
 */
function cacheIndexOf(cache, value) {
  var data = cache.data,
      result = (typeof value == 'string' || isObject(value)) ? data.set.has(value) : data.hash[value];

  return result ? 0 : -1;
}

module.exports = cacheIndexOf;

},{"../lang/isObject":71}],40:[function(require,module,exports){
var isObject = require('../lang/isObject');

/**
 * Adds `value` to the cache.
 *
 * @private
 * @name push
 * @memberOf SetCache
 * @param {*} value The value to cache.
 */
function cachePush(value) {
  var data = this.data;
  if (typeof value == 'string' || isObject(value)) {
    data.set.add(value);
  } else {
    data.hash[value] = true;
  }
}

module.exports = cachePush;

},{"../lang/isObject":71}],41:[function(require,module,exports){
var bindCallback = require('./bindCallback'),
    isIterateeCall = require('./isIterateeCall'),
    restParam = require('../function/restParam');

/**
 * Creates a `_.assign`, `_.defaults`, or `_.merge` function.
 *
 * @private
 * @param {Function} assigner The function to assign values.
 * @returns {Function} Returns the new assigner function.
 */
function createAssigner(assigner) {
  return restParam(function(object, sources) {
    var index = -1,
        length = object == null ? 0 : sources.length,
        customizer = length > 2 ? sources[length - 2] : undefined,
        guard = length > 2 ? sources[2] : undefined,
        thisArg = length > 1 ? sources[length - 1] : undefined;

    if (typeof customizer == 'function') {
      customizer = bindCallback(customizer, thisArg, 5);
      length -= 2;
    } else {
      customizer = typeof thisArg == 'function' ? thisArg : undefined;
      length -= (customizer ? 1 : 0);
    }
    if (guard && isIterateeCall(sources[0], sources[1], guard)) {
      customizer = length < 3 ? undefined : customizer;
      length = 1;
    }
    while (++index < length) {
      var source = sources[index];
      if (source) {
        assigner(object, source, customizer);
      }
    }
    return object;
  });
}

module.exports = createAssigner;

},{"../function/restParam":10,"./bindCallback":38,"./isIterateeCall":57}],42:[function(require,module,exports){
var getLength = require('./getLength'),
    isLength = require('./isLength'),
    toObject = require('./toObject');

/**
 * Creates a `baseEach` or `baseEachRight` function.
 *
 * @private
 * @param {Function} eachFunc The function to iterate over a collection.
 * @param {boolean} [fromRight] Specify iterating from right to left.
 * @returns {Function} Returns the new base function.
 */
function createBaseEach(eachFunc, fromRight) {
  return function(collection, iteratee) {
    var length = collection ? getLength(collection) : 0;
    if (!isLength(length)) {
      return eachFunc(collection, iteratee);
    }
    var index = fromRight ? length : -1,
        iterable = toObject(collection);

    while ((fromRight ? index-- : ++index < length)) {
      if (iteratee(iterable[index], index, iterable) === false) {
        break;
      }
    }
    return collection;
  };
}

module.exports = createBaseEach;

},{"./getLength":50,"./isLength":59,"./toObject":65}],43:[function(require,module,exports){
var toObject = require('./toObject');

/**
 * Creates a base function for `_.forIn` or `_.forInRight`.
 *
 * @private
 * @param {boolean} [fromRight] Specify iterating from right to left.
 * @returns {Function} Returns the new base function.
 */
function createBaseFor(fromRight) {
  return function(object, iteratee, keysFunc) {
    var iterable = toObject(object),
        props = keysFunc(object),
        length = props.length,
        index = fromRight ? length : -1;

    while ((fromRight ? index-- : ++index < length)) {
      var key = props[index];
      if (iteratee(iterable[key], key, iterable) === false) {
        break;
      }
    }
    return object;
  };
}

module.exports = createBaseFor;

},{"./toObject":65}],44:[function(require,module,exports){
(function (global){
var SetCache = require('./SetCache'),
    getNative = require('./getNative');

/** Native method references. */
var Set = getNative(global, 'Set');

/* Native method references for those with the same name as other `lodash` methods. */
var nativeCreate = getNative(Object, 'create');

/**
 * Creates a `Set` cache object to optimize linear searches of large arrays.
 *
 * @private
 * @param {Array} [values] The values to cache.
 * @returns {null|Object} Returns the new cache object if `Set` is supported, else `null`.
 */
function createCache(values) {
  return (nativeCreate && Set) ? new SetCache(values) : null;
}

module.exports = createCache;

}).call(this,typeof global !== "undefined" ? global : typeof self !== "undefined" ? self : typeof window !== "undefined" ? window : {})
},{"./SetCache":11,"./getNative":52}],45:[function(require,module,exports){
var bindCallback = require('./bindCallback'),
    isArray = require('../lang/isArray');

/**
 * Creates a function for `_.forEach` or `_.forEachRight`.
 *
 * @private
 * @param {Function} arrayFunc The function to iterate over an array.
 * @param {Function} eachFunc The function to iterate over a collection.
 * @returns {Function} Returns the new each function.
 */
function createForEach(arrayFunc, eachFunc) {
  return function(collection, iteratee, thisArg) {
    return (typeof iteratee == 'function' && thisArg === undefined && isArray(collection))
      ? arrayFunc(collection, iteratee)
      : eachFunc(collection, bindCallback(iteratee, thisArg, 3));
  };
}

module.exports = createForEach;

},{"../lang/isArray":68,"./bindCallback":38}],46:[function(require,module,exports){
var bindCallback = require('./bindCallback'),
    keysIn = require('../object/keysIn');

/**
 * Creates a function for `_.forIn` or `_.forInRight`.
 *
 * @private
 * @param {Function} objectFunc The function to iterate over an object.
 * @returns {Function} Returns the new each function.
 */
function createForIn(objectFunc) {
  return function(object, iteratee, thisArg) {
    if (typeof iteratee != 'function' || thisArg !== undefined) {
      iteratee = bindCallback(iteratee, thisArg, 3);
    }
    return objectFunc(object, iteratee, keysIn);
  };
}

module.exports = createForIn;

},{"../object/keysIn":78,"./bindCallback":38}],47:[function(require,module,exports){
var arraySome = require('./arraySome');

/**
 * A specialized version of `baseIsEqualDeep` for arrays with support for
 * partial deep comparisons.
 *
 * @private
 * @param {Array} array The array to compare.
 * @param {Array} other The other array to compare.
 * @param {Function} equalFunc The function to determine equivalents of values.
 * @param {Function} [customizer] The function to customize comparing arrays.
 * @param {boolean} [isLoose] Specify performing partial comparisons.
 * @param {Array} [stackA] Tracks traversed `value` objects.
 * @param {Array} [stackB] Tracks traversed `other` objects.
 * @returns {boolean} Returns `true` if the arrays are equivalent, else `false`.
 */
function equalArrays(array, other, equalFunc, customizer, isLoose, stackA, stackB) {
  var index = -1,
      arrLength = array.length,
      othLength = other.length;

  if (arrLength != othLength && !(isLoose && othLength > arrLength)) {
    return false;
  }
  // Ignore non-index properties.
  while (++index < arrLength) {
    var arrValue = array[index],
        othValue = other[index],
        result = customizer ? customizer(isLoose ? othValue : arrValue, isLoose ? arrValue : othValue, index) : undefined;

    if (result !== undefined) {
      if (result) {
        continue;
      }
      return false;
    }
    // Recursively compare arrays (susceptible to call stack limits).
    if (isLoose) {
      if (!arraySome(other, function(othValue) {
            return arrValue === othValue || equalFunc(arrValue, othValue, customizer, isLoose, stackA, stackB);
          })) {
        return false;
      }
    } else if (!(arrValue === othValue || equalFunc(arrValue, othValue, customizer, isLoose, stackA, stackB))) {
      return false;
    }
  }
  return true;
}

module.exports = equalArrays;

},{"./arraySome":15}],48:[function(require,module,exports){
/** `Object#toString` result references. */
var boolTag = '[object Boolean]',
    dateTag = '[object Date]',
    errorTag = '[object Error]',
    numberTag = '[object Number]',
    regexpTag = '[object RegExp]',
    stringTag = '[object String]';

/**
 * A specialized version of `baseIsEqualDeep` for comparing objects of
 * the same `toStringTag`.
 *
 * **Note:** This function only supports comparing values with tags of
 * `Boolean`, `Date`, `Error`, `Number`, `RegExp`, or `String`.
 *
 * @private
 * @param {Object} object The object to compare.
 * @param {Object} other The other object to compare.
 * @param {string} tag The `toStringTag` of the objects to compare.
 * @returns {boolean} Returns `true` if the objects are equivalent, else `false`.
 */
function equalByTag(object, other, tag) {
  switch (tag) {
    case boolTag:
    case dateTag:
      // Coerce dates and booleans to numbers, dates to milliseconds and booleans
      // to `1` or `0` treating invalid dates coerced to `NaN` as not equal.
      return +object == +other;

    case errorTag:
      return object.name == other.name && object.message == other.message;

    case numberTag:
      // Treat `NaN` vs. `NaN` as equal.
      return (object != +object)
        ? other != +other
        : object == +other;

    case regexpTag:
    case stringTag:
      // Coerce regexes to strings and treat strings primitives and string
      // objects as equal. See https://es5.github.io/#x15.10.6.4 for more details.
      return object == (other + '');
  }
  return false;
}

module.exports = equalByTag;

},{}],49:[function(require,module,exports){
var keys = require('../object/keys');

/** Used for native method references. */
var objectProto = Object.prototype;

/** Used to check objects for own properties. */
var hasOwnProperty = objectProto.hasOwnProperty;

/**
 * A specialized version of `baseIsEqualDeep` for objects with support for
 * partial deep comparisons.
 *
 * @private
 * @param {Object} object The object to compare.
 * @param {Object} other The other object to compare.
 * @param {Function} equalFunc The function to determine equivalents of values.
 * @param {Function} [customizer] The function to customize comparing values.
 * @param {boolean} [isLoose] Specify performing partial comparisons.
 * @param {Array} [stackA] Tracks traversed `value` objects.
 * @param {Array} [stackB] Tracks traversed `other` objects.
 * @returns {boolean} Returns `true` if the objects are equivalent, else `false`.
 */
function equalObjects(object, other, equalFunc, customizer, isLoose, stackA, stackB) {
  var objProps = keys(object),
      objLength = objProps.length,
      othProps = keys(other),
      othLength = othProps.length;

  if (objLength != othLength && !isLoose) {
    return false;
  }
  var index = objLength;
  while (index--) {
    var key = objProps[index];
    if (!(isLoose ? key in other : hasOwnProperty.call(other, key))) {
      return false;
    }
  }
  var skipCtor = isLoose;
  while (++index < objLength) {
    key = objProps[index];
    var objValue = object[key],
        othValue = other[key],
        result = customizer ? customizer(isLoose ? othValue : objValue, isLoose? objValue : othValue, key) : undefined;

    // Recursively compare objects (susceptible to call stack limits).
    if (!(result === undefined ? equalFunc(objValue, othValue, customizer, isLoose, stackA, stackB) : result)) {
      return false;
    }
    skipCtor || (skipCtor = key == 'constructor');
  }
  if (!skipCtor) {
    var objCtor = object.constructor,
        othCtor = other.constructor;

    // Non `Object` object instances with different constructors are not equal.
    if (objCtor != othCtor &&
        ('constructor' in object && 'constructor' in other) &&
        !(typeof objCtor == 'function' && objCtor instanceof objCtor &&
          typeof othCtor == 'function' && othCtor instanceof othCtor)) {
      return false;
    }
  }
  return true;
}

module.exports = equalObjects;

},{"../object/keys":77}],50:[function(require,module,exports){
var baseProperty = require('./baseProperty');

/**
 * Gets the "length" property value of `object`.
 *
 * **Note:** This function is used to avoid a [JIT bug](https://bugs.webkit.org/show_bug.cgi?id=142792)
 * that affects Safari on at least iOS 8.1-8.3 ARM64.
 *
 * @private
 * @param {Object} object The object to query.
 * @returns {*} Returns the "length" value.
 */
var getLength = baseProperty('length');

module.exports = getLength;

},{"./baseProperty":34}],51:[function(require,module,exports){
var isStrictComparable = require('./isStrictComparable'),
    pairs = require('../object/pairs');

/**
 * Gets the propery names, values, and compare flags of `object`.
 *
 * @private
 * @param {Object} object The object to query.
 * @returns {Array} Returns the match data of `object`.
 */
function getMatchData(object) {
  var result = pairs(object),
      length = result.length;

  while (length--) {
    result[length][2] = isStrictComparable(result[length][1]);
  }
  return result;
}

module.exports = getMatchData;

},{"../object/pairs":80,"./isStrictComparable":61}],52:[function(require,module,exports){
var isNative = require('../lang/isNative');

/**
 * Gets the native function at `key` of `object`.
 *
 * @private
 * @param {Object} object The object to query.
 * @param {string} key The key of the method to get.
 * @returns {*} Returns the function if it's native, else `undefined`.
 */
function getNative(object, key) {
  var value = object == null ? undefined : object[key];
  return isNative(value) ? value : undefined;
}

module.exports = getNative;

},{"../lang/isNative":70}],53:[function(require,module,exports){
/**
 * Gets the index at which the first occurrence of `NaN` is found in `array`.
 *
 * @private
 * @param {Array} array The array to search.
 * @param {number} fromIndex The index to search from.
 * @param {boolean} [fromRight] Specify iterating from right to left.
 * @returns {number} Returns the index of the matched `NaN`, else `-1`.
 */
function indexOfNaN(array, fromIndex, fromRight) {
  var length = array.length,
      index = fromIndex + (fromRight ? 0 : -1);

  while ((fromRight ? index-- : ++index < length)) {
    var other = array[index];
    if (other !== other) {
      return index;
    }
  }
  return -1;
}

module.exports = indexOfNaN;

},{}],54:[function(require,module,exports){
var getLength = require('./getLength'),
    isLength = require('./isLength');

/**
 * Checks if `value` is array-like.
 *
 * @private
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is array-like, else `false`.
 */
function isArrayLike(value) {
  return value != null && isLength(getLength(value));
}

module.exports = isArrayLike;

},{"./getLength":50,"./isLength":59}],55:[function(require,module,exports){
/**
 * Checks if `value` is a host object in IE < 9.
 *
 * @private
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is a host object, else `false`.
 */
var isHostObject = (function() {
  try {
    Object({ 'toString': 0 } + '');
  } catch(e) {
    return function() { return false; };
  }
  return function(value) {
    // IE < 9 presents many host objects as `Object` objects that can coerce
    // to strings despite having improperly defined `toString` methods.
    return typeof value.toString != 'function' && typeof (value + '') == 'string';
  };
}());

module.exports = isHostObject;

},{}],56:[function(require,module,exports){
/** Used to detect unsigned integer values. */
var reIsUint = /^\d+$/;

/**
 * Used as the [maximum length](http://ecma-international.org/ecma-262/6.0/#sec-number.max_safe_integer)
 * of an array-like value.
 */
var MAX_SAFE_INTEGER = 9007199254740991;

/**
 * Checks if `value` is a valid array-like index.
 *
 * @private
 * @param {*} value The value to check.
 * @param {number} [length=MAX_SAFE_INTEGER] The upper bounds of a valid index.
 * @returns {boolean} Returns `true` if `value` is a valid index, else `false`.
 */
function isIndex(value, length) {
  value = (typeof value == 'number' || reIsUint.test(value)) ? +value : -1;
  length = length == null ? MAX_SAFE_INTEGER : length;
  return value > -1 && value % 1 == 0 && value < length;
}

module.exports = isIndex;

},{}],57:[function(require,module,exports){
var isArrayLike = require('./isArrayLike'),
    isIndex = require('./isIndex'),
    isObject = require('../lang/isObject');

/**
 * Checks if the provided arguments are from an iteratee call.
 *
 * @private
 * @param {*} value The potential iteratee value argument.
 * @param {*} index The potential iteratee index or key argument.
 * @param {*} object The potential iteratee object argument.
 * @returns {boolean} Returns `true` if the arguments are from an iteratee call, else `false`.
 */
function isIterateeCall(value, index, object) {
  if (!isObject(object)) {
    return false;
  }
  var type = typeof index;
  if (type == 'number'
      ? (isArrayLike(object) && isIndex(index, object.length))
      : (type == 'string' && index in object)) {
    var other = object[index];
    return value === value ? (value === other) : (other !== other);
  }
  return false;
}

module.exports = isIterateeCall;

},{"../lang/isObject":71,"./isArrayLike":54,"./isIndex":56}],58:[function(require,module,exports){
var isArray = require('../lang/isArray'),
    toObject = require('./toObject');

/** Used to match property names within property paths. */
var reIsDeepProp = /\.|\[(?:[^[\]]*|(["'])(?:(?!\1)[^\n\\]|\\.)*?\1)\]/,
    reIsPlainProp = /^\w*$/;

/**
 * Checks if `value` is a property name and not a property path.
 *
 * @private
 * @param {*} value The value to check.
 * @param {Object} [object] The object to query keys on.
 * @returns {boolean} Returns `true` if `value` is a property name, else `false`.
 */
function isKey(value, object) {
  var type = typeof value;
  if ((type == 'string' && reIsPlainProp.test(value)) || type == 'number') {
    return true;
  }
  if (isArray(value)) {
    return false;
  }
  var result = !reIsDeepProp.test(value);
  return result || (object != null && value in toObject(object));
}

module.exports = isKey;

},{"../lang/isArray":68,"./toObject":65}],59:[function(require,module,exports){
/**
 * Used as the [maximum length](http://ecma-international.org/ecma-262/6.0/#sec-number.max_safe_integer)
 * of an array-like value.
 */
var MAX_SAFE_INTEGER = 9007199254740991;

/**
 * Checks if `value` is a valid array-like length.
 *
 * **Note:** This function is based on [`ToLength`](http://ecma-international.org/ecma-262/6.0/#sec-tolength).
 *
 * @private
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is a valid length, else `false`.
 */
function isLength(value) {
  return typeof value == 'number' && value > -1 && value % 1 == 0 && value <= MAX_SAFE_INTEGER;
}

module.exports = isLength;

},{}],60:[function(require,module,exports){
/**
 * Checks if `value` is object-like.
 *
 * @private
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is object-like, else `false`.
 */
function isObjectLike(value) {
  return !!value && typeof value == 'object';
}

module.exports = isObjectLike;

},{}],61:[function(require,module,exports){
var isObject = require('../lang/isObject');

/**
 * Checks if `value` is suitable for strict equality comparisons, i.e. `===`.
 *
 * @private
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` if suitable for strict
 *  equality comparisons, else `false`.
 */
function isStrictComparable(value) {
  return value === value && !isObject(value);
}

module.exports = isStrictComparable;

},{"../lang/isObject":71}],62:[function(require,module,exports){
var toObject = require('./toObject');

/**
 * A specialized version of `_.pick` which picks `object` properties specified
 * by `props`.
 *
 * @private
 * @param {Object} object The source object.
 * @param {string[]} props The property names to pick.
 * @returns {Object} Returns the new object.
 */
function pickByArray(object, props) {
  object = toObject(object);

  var index = -1,
      length = props.length,
      result = {};

  while (++index < length) {
    var key = props[index];
    if (key in object) {
      result[key] = object[key];
    }
  }
  return result;
}

module.exports = pickByArray;

},{"./toObject":65}],63:[function(require,module,exports){
var baseForIn = require('./baseForIn');

/**
 * A specialized version of `_.pick` which picks `object` properties `predicate`
 * returns truthy for.
 *
 * @private
 * @param {Object} object The source object.
 * @param {Function} predicate The function invoked per iteration.
 * @returns {Object} Returns the new object.
 */
function pickByCallback(object, predicate) {
  var result = {};
  baseForIn(object, function(value, key, object) {
    if (predicate(value, key, object)) {
      result[key] = value;
    }
  });
  return result;
}

module.exports = pickByCallback;

},{"./baseForIn":24}],64:[function(require,module,exports){
var isArguments = require('../lang/isArguments'),
    isArray = require('../lang/isArray'),
    isIndex = require('./isIndex'),
    isLength = require('./isLength'),
    isString = require('../lang/isString'),
    keysIn = require('../object/keysIn');

/** Used for native method references. */
var objectProto = Object.prototype;

/** Used to check objects for own properties. */
var hasOwnProperty = objectProto.hasOwnProperty;

/**
 * A fallback implementation of `Object.keys` which creates an array of the
 * own enumerable property names of `object`.
 *
 * @private
 * @param {Object} object The object to query.
 * @returns {Array} Returns the array of property names.
 */
function shimKeys(object) {
  var props = keysIn(object),
      propsLength = props.length,
      length = propsLength && object.length;

  var allowIndexes = !!length && isLength(length) &&
    (isArray(object) || isArguments(object) || isString(object));

  var index = -1,
      result = [];

  while (++index < propsLength) {
    var key = props[index];
    if ((allowIndexes && isIndex(key, length)) || hasOwnProperty.call(object, key)) {
      result.push(key);
    }
  }
  return result;
}

module.exports = shimKeys;

},{"../lang/isArguments":67,"../lang/isArray":68,"../lang/isString":72,"../object/keysIn":78,"./isIndex":56,"./isLength":59}],65:[function(require,module,exports){
var isObject = require('../lang/isObject'),
    isString = require('../lang/isString'),
    support = require('../support');

/**
 * Converts `value` to an object if it's not one.
 *
 * @private
 * @param {*} value The value to process.
 * @returns {Object} Returns the object.
 */
function toObject(value) {
  if (support.unindexedChars && isString(value)) {
    var index = -1,
        length = value.length,
        result = Object(value);

    while (++index < length) {
      result[index] = value.charAt(index);
    }
    return result;
  }
  return isObject(value) ? value : Object(value);
}

module.exports = toObject;

},{"../lang/isObject":71,"../lang/isString":72,"../support":81}],66:[function(require,module,exports){
var baseToString = require('./baseToString'),
    isArray = require('../lang/isArray');

/** Used to match property names within property paths. */
var rePropName = /[^.[\]]+|\[(?:(-?\d+(?:\.\d+)?)|(["'])((?:(?!\2)[^\n\\]|\\.)*?)\2)\]/g;

/** Used to match backslashes in property paths. */
var reEscapeChar = /\\(\\)?/g;

/**
 * Converts `value` to property path array if it's not one.
 *
 * @private
 * @param {*} value The value to process.
 * @returns {Array} Returns the property path array.
 */
function toPath(value) {
  if (isArray(value)) {
    return value;
  }
  var result = [];
  baseToString(value).replace(rePropName, function(match, number, quote, string) {
    result.push(quote ? string.replace(reEscapeChar, '$1') : (number || match));
  });
  return result;
}

module.exports = toPath;

},{"../lang/isArray":68,"./baseToString":37}],67:[function(require,module,exports){
var isArrayLike = require('../internal/isArrayLike'),
    isObjectLike = require('../internal/isObjectLike');

/** Used for native method references. */
var objectProto = Object.prototype;

/** Used to check objects for own properties. */
var hasOwnProperty = objectProto.hasOwnProperty;

/** Native method references. */
var propertyIsEnumerable = objectProto.propertyIsEnumerable;

/**
 * Checks if `value` is classified as an `arguments` object.
 *
 * @static
 * @memberOf _
 * @category Lang
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is correctly classified, else `false`.
 * @example
 *
 * _.isArguments(function() { return arguments; }());
 * // => true
 *
 * _.isArguments([1, 2, 3]);
 * // => false
 */
function isArguments(value) {
  return isObjectLike(value) && isArrayLike(value) &&
    hasOwnProperty.call(value, 'callee') && !propertyIsEnumerable.call(value, 'callee');
}

module.exports = isArguments;

},{"../internal/isArrayLike":54,"../internal/isObjectLike":60}],68:[function(require,module,exports){
var getNative = require('../internal/getNative'),
    isLength = require('../internal/isLength'),
    isObjectLike = require('../internal/isObjectLike');

/** `Object#toString` result references. */
var arrayTag = '[object Array]';

/** Used for native method references. */
var objectProto = Object.prototype;

/**
 * Used to resolve the [`toStringTag`](http://ecma-international.org/ecma-262/6.0/#sec-object.prototype.tostring)
 * of values.
 */
var objToString = objectProto.toString;

/* Native method references for those with the same name as other `lodash` methods. */
var nativeIsArray = getNative(Array, 'isArray');

/**
 * Checks if `value` is classified as an `Array` object.
 *
 * @static
 * @memberOf _
 * @category Lang
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is correctly classified, else `false`.
 * @example
 *
 * _.isArray([1, 2, 3]);
 * // => true
 *
 * _.isArray(function() { return arguments; }());
 * // => false
 */
var isArray = nativeIsArray || function(value) {
  return isObjectLike(value) && isLength(value.length) && objToString.call(value) == arrayTag;
};

module.exports = isArray;

},{"../internal/getNative":52,"../internal/isLength":59,"../internal/isObjectLike":60}],69:[function(require,module,exports){
var isObject = require('./isObject');

/** `Object#toString` result references. */
var funcTag = '[object Function]';

/** Used for native method references. */
var objectProto = Object.prototype;

/**
 * Used to resolve the [`toStringTag`](http://ecma-international.org/ecma-262/6.0/#sec-object.prototype.tostring)
 * of values.
 */
var objToString = objectProto.toString;

/**
 * Checks if `value` is classified as a `Function` object.
 *
 * @static
 * @memberOf _
 * @category Lang
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is correctly classified, else `false`.
 * @example
 *
 * _.isFunction(_);
 * // => true
 *
 * _.isFunction(/abc/);
 * // => false
 */
function isFunction(value) {
  // The use of `Object#toString` avoids issues with the `typeof` operator
  // in older versions of Chrome and Safari which return 'function' for regexes
  // and Safari 8 which returns 'object' for typed array constructors.
  return isObject(value) && objToString.call(value) == funcTag;
}

module.exports = isFunction;

},{"./isObject":71}],70:[function(require,module,exports){
var isFunction = require('./isFunction'),
    isHostObject = require('../internal/isHostObject'),
    isObjectLike = require('../internal/isObjectLike');

/** Used to detect host constructors (Safari > 5). */
var reIsHostCtor = /^\[object .+?Constructor\]$/;

/** Used for native method references. */
var objectProto = Object.prototype;

/** Used to resolve the decompiled source of functions. */
var fnToString = Function.prototype.toString;

/** Used to check objects for own properties. */
var hasOwnProperty = objectProto.hasOwnProperty;

/** Used to detect if a method is native. */
var reIsNative = RegExp('^' +
  fnToString.call(hasOwnProperty).replace(/[\\^$.*+?()[\]{}|]/g, '\\$&')
  .replace(/hasOwnProperty|(function).*?(?=\\\()| for .+?(?=\\\])/g, '$1.*?') + '$'
);

/**
 * Checks if `value` is a native function.
 *
 * @static
 * @memberOf _
 * @category Lang
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is a native function, else `false`.
 * @example
 *
 * _.isNative(Array.prototype.push);
 * // => true
 *
 * _.isNative(_);
 * // => false
 */
function isNative(value) {
  if (value == null) {
    return false;
  }
  if (isFunction(value)) {
    return reIsNative.test(fnToString.call(value));
  }
  return isObjectLike(value) && (isHostObject(value) ? reIsNative : reIsHostCtor).test(value);
}

module.exports = isNative;

},{"../internal/isHostObject":55,"../internal/isObjectLike":60,"./isFunction":69}],71:[function(require,module,exports){
/**
 * Checks if `value` is the [language type](https://es5.github.io/#x8) of `Object`.
 * (e.g. arrays, functions, objects, regexes, `new Number(0)`, and `new String('')`)
 *
 * @static
 * @memberOf _
 * @category Lang
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is an object, else `false`.
 * @example
 *
 * _.isObject({});
 * // => true
 *
 * _.isObject([1, 2, 3]);
 * // => true
 *
 * _.isObject(1);
 * // => false
 */
function isObject(value) {
  // Avoid a V8 JIT bug in Chrome 19-20.
  // See https://code.google.com/p/v8/issues/detail?id=2291 for more details.
  var type = typeof value;
  return !!value && (type == 'object' || type == 'function');
}

module.exports = isObject;

},{}],72:[function(require,module,exports){
var isObjectLike = require('../internal/isObjectLike');

/** `Object#toString` result references. */
var stringTag = '[object String]';

/** Used for native method references. */
var objectProto = Object.prototype;

/**
 * Used to resolve the [`toStringTag`](http://ecma-international.org/ecma-262/6.0/#sec-object.prototype.tostring)
 * of values.
 */
var objToString = objectProto.toString;

/**
 * Checks if `value` is classified as a `String` primitive or object.
 *
 * @static
 * @memberOf _
 * @category Lang
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is correctly classified, else `false`.
 * @example
 *
 * _.isString('abc');
 * // => true
 *
 * _.isString(1);
 * // => false
 */
function isString(value) {
  return typeof value == 'string' || (isObjectLike(value) && objToString.call(value) == stringTag);
}

module.exports = isString;

},{"../internal/isObjectLike":60}],73:[function(require,module,exports){
var isLength = require('../internal/isLength'),
    isObjectLike = require('../internal/isObjectLike');

/** `Object#toString` result references. */
var argsTag = '[object Arguments]',
    arrayTag = '[object Array]',
    boolTag = '[object Boolean]',
    dateTag = '[object Date]',
    errorTag = '[object Error]',
    funcTag = '[object Function]',
    mapTag = '[object Map]',
    numberTag = '[object Number]',
    objectTag = '[object Object]',
    regexpTag = '[object RegExp]',
    setTag = '[object Set]',
    stringTag = '[object String]',
    weakMapTag = '[object WeakMap]';

var arrayBufferTag = '[object ArrayBuffer]',
    float32Tag = '[object Float32Array]',
    float64Tag = '[object Float64Array]',
    int8Tag = '[object Int8Array]',
    int16Tag = '[object Int16Array]',
    int32Tag = '[object Int32Array]',
    uint8Tag = '[object Uint8Array]',
    uint8ClampedTag = '[object Uint8ClampedArray]',
    uint16Tag = '[object Uint16Array]',
    uint32Tag = '[object Uint32Array]';

/** Used to identify `toStringTag` values of typed arrays. */
var typedArrayTags = {};
typedArrayTags[float32Tag] = typedArrayTags[float64Tag] =
typedArrayTags[int8Tag] = typedArrayTags[int16Tag] =
typedArrayTags[int32Tag] = typedArrayTags[uint8Tag] =
typedArrayTags[uint8ClampedTag] = typedArrayTags[uint16Tag] =
typedArrayTags[uint32Tag] = true;
typedArrayTags[argsTag] = typedArrayTags[arrayTag] =
typedArrayTags[arrayBufferTag] = typedArrayTags[boolTag] =
typedArrayTags[dateTag] = typedArrayTags[errorTag] =
typedArrayTags[funcTag] = typedArrayTags[mapTag] =
typedArrayTags[numberTag] = typedArrayTags[objectTag] =
typedArrayTags[regexpTag] = typedArrayTags[setTag] =
typedArrayTags[stringTag] = typedArrayTags[weakMapTag] = false;

/** Used for native method references. */
var objectProto = Object.prototype;

/**
 * Used to resolve the [`toStringTag`](http://ecma-international.org/ecma-262/6.0/#sec-object.prototype.tostring)
 * of values.
 */
var objToString = objectProto.toString;

/**
 * Checks if `value` is classified as a typed array.
 *
 * @static
 * @memberOf _
 * @category Lang
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is correctly classified, else `false`.
 * @example
 *
 * _.isTypedArray(new Uint8Array);
 * // => true
 *
 * _.isTypedArray([]);
 * // => false
 */
function isTypedArray(value) {
  return isObjectLike(value) && isLength(value.length) && !!typedArrayTags[objToString.call(value)];
}

module.exports = isTypedArray;

},{"../internal/isLength":59,"../internal/isObjectLike":60}],74:[function(require,module,exports){
var assignWith = require('../internal/assignWith'),
    baseAssign = require('../internal/baseAssign'),
    createAssigner = require('../internal/createAssigner');

/**
 * Assigns own enumerable properties of source object(s) to the destination
 * object. Subsequent sources overwrite property assignments of previous sources.
 * If `customizer` is provided it's invoked to produce the assigned values.
 * The `customizer` is bound to `thisArg` and invoked with five arguments:
 * (objectValue, sourceValue, key, object, source).
 *
 * **Note:** This method mutates `object` and is based on
 * [`Object.assign`](http://ecma-international.org/ecma-262/6.0/#sec-object.assign).
 *
 * @static
 * @memberOf _
 * @alias extend
 * @category Object
 * @param {Object} object The destination object.
 * @param {...Object} [sources] The source objects.
 * @param {Function} [customizer] The function to customize assigned values.
 * @param {*} [thisArg] The `this` binding of `customizer`.
 * @returns {Object} Returns `object`.
 * @example
 *
 * _.assign({ 'user': 'barney' }, { 'age': 40 }, { 'user': 'fred' });
 * // => { 'user': 'fred', 'age': 40 }
 *
 * // using a customizer callback
 * var defaults = _.partialRight(_.assign, function(value, other) {
 *   return _.isUndefined(value) ? other : value;
 * });
 *
 * defaults({ 'user': 'barney' }, { 'age': 36 }, { 'user': 'fred' });
 * // => { 'user': 'barney', 'age': 36 }
 */
var assign = createAssigner(function(object, source, customizer) {
  return customizer
    ? assignWith(object, source, customizer)
    : baseAssign(object, source);
});

module.exports = assign;

},{"../internal/assignWith":16,"../internal/baseAssign":17,"../internal/createAssigner":41}],75:[function(require,module,exports){
module.exports = require('./assign');

},{"./assign":74}],76:[function(require,module,exports){
var baseFor = require('../internal/baseFor'),
    createForIn = require('../internal/createForIn');

/**
 * Iterates over own and inherited enumerable properties of an object invoking
 * `iteratee` for each property. The `iteratee` is bound to `thisArg` and invoked
 * with three arguments: (value, key, object). Iteratee functions may exit
 * iteration early by explicitly returning `false`.
 *
 * @static
 * @memberOf _
 * @category Object
 * @param {Object} object The object to iterate over.
 * @param {Function} [iteratee=_.identity] The function invoked per iteration.
 * @param {*} [thisArg] The `this` binding of `iteratee`.
 * @returns {Object} Returns `object`.
 * @example
 *
 * function Foo() {
 *   this.a = 1;
 *   this.b = 2;
 * }
 *
 * Foo.prototype.c = 3;
 *
 * _.forIn(new Foo, function(value, key) {
 *   console.log(key);
 * });
 * // => logs 'a', 'b', and 'c' (iteration order is not guaranteed)
 */
var forIn = createForIn(baseFor);

module.exports = forIn;

},{"../internal/baseFor":23,"../internal/createForIn":46}],77:[function(require,module,exports){
var getNative = require('../internal/getNative'),
    isArrayLike = require('../internal/isArrayLike'),
    isObject = require('../lang/isObject'),
    shimKeys = require('../internal/shimKeys'),
    support = require('../support');

/* Native method references for those with the same name as other `lodash` methods. */
var nativeKeys = getNative(Object, 'keys');

/**
 * Creates an array of the own enumerable property names of `object`.
 *
 * **Note:** Non-object values are coerced to objects. See the
 * [ES spec](http://ecma-international.org/ecma-262/6.0/#sec-object.keys)
 * for more details.
 *
 * @static
 * @memberOf _
 * @category Object
 * @param {Object} object The object to query.
 * @returns {Array} Returns the array of property names.
 * @example
 *
 * function Foo() {
 *   this.a = 1;
 *   this.b = 2;
 * }
 *
 * Foo.prototype.c = 3;
 *
 * _.keys(new Foo);
 * // => ['a', 'b'] (iteration order is not guaranteed)
 *
 * _.keys('hi');
 * // => ['0', '1']
 */
var keys = !nativeKeys ? shimKeys : function(object) {
  var Ctor = object == null ? undefined : object.constructor;
  if ((typeof Ctor == 'function' && Ctor.prototype === object) ||
      (typeof object == 'function' ? support.enumPrototypes : isArrayLike(object))) {
    return shimKeys(object);
  }
  return isObject(object) ? nativeKeys(object) : [];
};

module.exports = keys;

},{"../internal/getNative":52,"../internal/isArrayLike":54,"../internal/shimKeys":64,"../lang/isObject":71,"../support":81}],78:[function(require,module,exports){
var arrayEach = require('../internal/arrayEach'),
    isArguments = require('../lang/isArguments'),
    isArray = require('../lang/isArray'),
    isFunction = require('../lang/isFunction'),
    isIndex = require('../internal/isIndex'),
    isLength = require('../internal/isLength'),
    isObject = require('../lang/isObject'),
    isString = require('../lang/isString'),
    support = require('../support');

/** `Object#toString` result references. */
var arrayTag = '[object Array]',
    boolTag = '[object Boolean]',
    dateTag = '[object Date]',
    errorTag = '[object Error]',
    funcTag = '[object Function]',
    numberTag = '[object Number]',
    objectTag = '[object Object]',
    regexpTag = '[object RegExp]',
    stringTag = '[object String]';

/** Used to fix the JScript `[[DontEnum]]` bug. */
var shadowProps = [
  'constructor', 'hasOwnProperty', 'isPrototypeOf', 'propertyIsEnumerable',
  'toLocaleString', 'toString', 'valueOf'
];

/** Used for native method references. */
var errorProto = Error.prototype,
    objectProto = Object.prototype,
    stringProto = String.prototype;

/** Used to check objects for own properties. */
var hasOwnProperty = objectProto.hasOwnProperty;

/**
 * Used to resolve the [`toStringTag`](http://ecma-international.org/ecma-262/6.0/#sec-object.prototype.tostring)
 * of values.
 */
var objToString = objectProto.toString;

/** Used to avoid iterating over non-enumerable properties in IE < 9. */
var nonEnumProps = {};
nonEnumProps[arrayTag] = nonEnumProps[dateTag] = nonEnumProps[numberTag] = { 'constructor': true, 'toLocaleString': true, 'toString': true, 'valueOf': true };
nonEnumProps[boolTag] = nonEnumProps[stringTag] = { 'constructor': true, 'toString': true, 'valueOf': true };
nonEnumProps[errorTag] = nonEnumProps[funcTag] = nonEnumProps[regexpTag] = { 'constructor': true, 'toString': true };
nonEnumProps[objectTag] = { 'constructor': true };

arrayEach(shadowProps, function(key) {
  for (var tag in nonEnumProps) {
    if (hasOwnProperty.call(nonEnumProps, tag)) {
      var props = nonEnumProps[tag];
      props[key] = hasOwnProperty.call(props, key);
    }
  }
});

/**
 * Creates an array of the own and inherited enumerable property names of `object`.
 *
 * **Note:** Non-object values are coerced to objects.
 *
 * @static
 * @memberOf _
 * @category Object
 * @param {Object} object The object to query.
 * @returns {Array} Returns the array of property names.
 * @example
 *
 * function Foo() {
 *   this.a = 1;
 *   this.b = 2;
 * }
 *
 * Foo.prototype.c = 3;
 *
 * _.keysIn(new Foo);
 * // => ['a', 'b', 'c'] (iteration order is not guaranteed)
 */
function keysIn(object) {
  if (object == null) {
    return [];
  }
  if (!isObject(object)) {
    object = Object(object);
  }
  var length = object.length;

  length = (length && isLength(length) &&
    (isArray(object) || isArguments(object) || isString(object)) && length) || 0;

  var Ctor = object.constructor,
      index = -1,
      proto = (isFunction(Ctor) && Ctor.prototype) || objectProto,
      isProto = proto === object,
      result = Array(length),
      skipIndexes = length > 0,
      skipErrorProps = support.enumErrorProps && (object === errorProto || object instanceof Error),
      skipProto = support.enumPrototypes && isFunction(object);

  while (++index < length) {
    result[index] = (index + '');
  }
  // lodash skips the `constructor` property when it infers it's iterating
  // over a `prototype` object because IE < 9 can't set the `[[Enumerable]]`
  // attribute of an existing property and the `constructor` property of a
  // prototype defaults to non-enumerable.
  for (var key in object) {
    if (!(skipProto && key == 'prototype') &&
        !(skipErrorProps && (key == 'message' || key == 'name')) &&
        !(skipIndexes && isIndex(key, length)) &&
        !(key == 'constructor' && (isProto || !hasOwnProperty.call(object, key)))) {
      result.push(key);
    }
  }
  if (support.nonEnumShadows && object !== objectProto) {
    var tag = object === stringProto ? stringTag : (object === errorProto ? errorTag : objToString.call(object)),
        nonEnums = nonEnumProps[tag] || nonEnumProps[objectTag];

    if (tag == objectTag) {
      proto = objectProto;
    }
    length = shadowProps.length;
    while (length--) {
      key = shadowProps[length];
      var nonEnum = nonEnums[key];
      if (!(isProto && nonEnum) &&
          (nonEnum ? hasOwnProperty.call(object, key) : object[key] !== proto[key])) {
        result.push(key);
      }
    }
  }
  return result;
}

module.exports = keysIn;

},{"../internal/arrayEach":12,"../internal/isIndex":56,"../internal/isLength":59,"../lang/isArguments":67,"../lang/isArray":68,"../lang/isFunction":69,"../lang/isObject":71,"../lang/isString":72,"../support":81}],79:[function(require,module,exports){
var arrayMap = require('../internal/arrayMap'),
    baseDifference = require('../internal/baseDifference'),
    baseFlatten = require('../internal/baseFlatten'),
    bindCallback = require('../internal/bindCallback'),
    keysIn = require('./keysIn'),
    pickByArray = require('../internal/pickByArray'),
    pickByCallback = require('../internal/pickByCallback'),
    restParam = require('../function/restParam');

/**
 * The opposite of `_.pick`; this method creates an object composed of the
 * own and inherited enumerable properties of `object` that are not omitted.
 *
 * @static
 * @memberOf _
 * @category Object
 * @param {Object} object The source object.
 * @param {Function|...(string|string[])} [predicate] The function invoked per
 *  iteration or property names to omit, specified as individual property
 *  names or arrays of property names.
 * @param {*} [thisArg] The `this` binding of `predicate`.
 * @returns {Object} Returns the new object.
 * @example
 *
 * var object = { 'user': 'fred', 'age': 40 };
 *
 * _.omit(object, 'age');
 * // => { 'user': 'fred' }
 *
 * _.omit(object, _.isNumber);
 * // => { 'user': 'fred' }
 */
var omit = restParam(function(object, props) {
  if (object == null) {
    return {};
  }
  if (typeof props[0] != 'function') {
    var props = arrayMap(baseFlatten(props), String);
    return pickByArray(object, baseDifference(keysIn(object), props));
  }
  var predicate = bindCallback(props[0], props[1], 3);
  return pickByCallback(object, function(value, key, object) {
    return !predicate(value, key, object);
  });
});

module.exports = omit;

},{"../function/restParam":10,"../internal/arrayMap":13,"../internal/baseDifference":20,"../internal/baseFlatten":22,"../internal/bindCallback":38,"../internal/pickByArray":62,"../internal/pickByCallback":63,"./keysIn":78}],80:[function(require,module,exports){
var keys = require('./keys'),
    toObject = require('../internal/toObject');

/**
 * Creates a two dimensional array of the key-value pairs for `object`,
 * e.g. `[[key1, value1], [key2, value2]]`.
 *
 * @static
 * @memberOf _
 * @category Object
 * @param {Object} object The object to query.
 * @returns {Array} Returns the new array of key-value pairs.
 * @example
 *
 * _.pairs({ 'barney': 36, 'fred': 40 });
 * // => [['barney', 36], ['fred', 40]] (iteration order is not guaranteed)
 */
function pairs(object) {
  object = toObject(object);

  var index = -1,
      props = keys(object),
      length = props.length,
      result = Array(length);

  while (++index < length) {
    var key = props[index];
    result[index] = [key, object[key]];
  }
  return result;
}

module.exports = pairs;

},{"../internal/toObject":65,"./keys":77}],81:[function(require,module,exports){
/** Used for native method references. */
var arrayProto = Array.prototype,
    errorProto = Error.prototype,
    objectProto = Object.prototype;

/** Native method references. */
var propertyIsEnumerable = objectProto.propertyIsEnumerable,
    splice = arrayProto.splice;

/**
 * An object environment feature flags.
 *
 * @static
 * @memberOf _
 * @type Object
 */
var support = {};

(function(x) {
  var Ctor = function() { this.x = x; },
      object = { '0': x, 'length': x },
      props = [];

  Ctor.prototype = { 'valueOf': x, 'y': x };
  for (var key in new Ctor) { props.push(key); }

  /**
   * Detect if `name` or `message` properties of `Error.prototype` are
   * enumerable by default (IE < 9, Safari < 5.1).
   *
   * @memberOf _.support
   * @type boolean
   */
  support.enumErrorProps = propertyIsEnumerable.call(errorProto, 'message') ||
    propertyIsEnumerable.call(errorProto, 'name');

  /**
   * Detect if `prototype` properties are enumerable by default.
   *
   * Firefox < 3.6, Opera > 9.50 - Opera < 11.60, and Safari < 5.1
   * (if the prototype or a property on the prototype has been set)
   * incorrectly set the `[[Enumerable]]` value of a function's `prototype`
   * property to `true`.
   *
   * @memberOf _.support
   * @type boolean
   */
  support.enumPrototypes = propertyIsEnumerable.call(Ctor, 'prototype');

  /**
   * Detect if properties shadowing those on `Object.prototype` are non-enumerable.
   *
   * In IE < 9 an object's own properties, shadowing non-enumerable ones,
   * are made non-enumerable as well (a.k.a the JScript `[[DontEnum]]` bug).
   *
   * @memberOf _.support
   * @type boolean
   */
  support.nonEnumShadows = !/valueOf/.test(props);

  /**
   * Detect if own properties are iterated after inherited properties (IE < 9).
   *
   * @memberOf _.support
   * @type boolean
   */
  support.ownLast = props[0] != 'x';

  /**
   * Detect if `Array#shift` and `Array#splice` augment array-like objects
   * correctly.
   *
   * Firefox < 10, compatibility modes of IE 8, and IE < 9 have buggy Array
   * `shift()` and `splice()` functions that fail to remove the last element,
   * `value[0]`, of array-like objects even though the "length" property is
   * set to `0`. The `shift()` method is buggy in compatibility modes of IE 8,
   * while `splice()` is buggy regardless of mode in IE < 9.
   *
   * @memberOf _.support
   * @type boolean
   */
  support.spliceObjects = (splice.call(object, 0, 1), !object[0]);

  /**
   * Detect lack of support for accessing string characters by index.
   *
   * IE < 8 can't access characters by index. IE 8 can only access characters
   * by index on string literals, not string objects.
   *
   * @memberOf _.support
   * @type boolean
   */
  support.unindexedChars = ('x'[0] + Object('x')[0]) != 'xx';
}(1, 0));

module.exports = support;

},{}],82:[function(require,module,exports){
/**
 * This method returns the first argument provided to it.
 *
 * @static
 * @memberOf _
 * @category Utility
 * @param {*} value Any value.
 * @returns {*} Returns `value`.
 * @example
 *
 * var object = { 'user': 'fred' };
 *
 * _.identity(object) === object;
 * // => true
 */
function identity(value) {
  return value;
}

module.exports = identity;

},{}],83:[function(require,module,exports){
var baseProperty = require('../internal/baseProperty'),
    basePropertyDeep = require('../internal/basePropertyDeep'),
    isKey = require('../internal/isKey');

/**
 * Creates a function that returns the property value at `path` on a
 * given object.
 *
 * @static
 * @memberOf _
 * @category Utility
 * @param {Array|string} path The path of the property to get.
 * @returns {Function} Returns the new function.
 * @example
 *
 * var objects = [
 *   { 'a': { 'b': { 'c': 2 } } },
 *   { 'a': { 'b': { 'c': 1 } } }
 * ];
 *
 * _.map(objects, _.property('a.b.c'));
 * // => [2, 1]
 *
 * _.pluck(_.sortBy(objects, _.property(['a', 'b', 'c'])), 'a.b.c');
 * // => [1, 2]
 */
function property(path) {
  return isKey(path) ? baseProperty(path) : basePropertyDeep(path);
}

module.exports = property;

},{"../internal/baseProperty":34,"../internal/basePropertyDeep":35,"../internal/isKey":58}],84:[function(require,module,exports){
// shim for using process in browser
var process = module.exports = {};

// cached from whatever global is present so that test runners that stub it
// don't break things.  But we need to wrap it in a try catch in case it is
// wrapped in strict mode code which doesn't define any globals.  It's inside a
// function because try/catches deoptimize in certain engines.

var cachedSetTimeout;
var cachedClearTimeout;

function defaultSetTimout() {
    throw new Error('setTimeout has not been defined');
}
function defaultClearTimeout () {
    throw new Error('clearTimeout has not been defined');
}
(function () {
    try {
        if (typeof setTimeout === 'function') {
            cachedSetTimeout = setTimeout;
        } else {
            cachedSetTimeout = defaultSetTimout;
        }
    } catch (e) {
        cachedSetTimeout = defaultSetTimout;
    }
    try {
        if (typeof clearTimeout === 'function') {
            cachedClearTimeout = clearTimeout;
        } else {
            cachedClearTimeout = defaultClearTimeout;
        }
    } catch (e) {
        cachedClearTimeout = defaultClearTimeout;
    }
} ())
function runTimeout(fun) {
    if (cachedSetTimeout === setTimeout) {
        //normal enviroments in sane situations
        return setTimeout(fun, 0);
    }
    // if setTimeout wasn't available but was latter defined
    if ((cachedSetTimeout === defaultSetTimout || !cachedSetTimeout) && setTimeout) {
        cachedSetTimeout = setTimeout;
        return setTimeout(fun, 0);
    }
    try {
        // when when somebody has screwed with setTimeout but no I.E. maddness
        return cachedSetTimeout(fun, 0);
    } catch(e){
        try {
            // When we are in I.E. but the script has been evaled so I.E. doesn't trust the global object when called normally
            return cachedSetTimeout.call(null, fun, 0);
        } catch(e){
            // same as above but when it's a version of I.E. that must have the global object for 'this', hopfully our context correct otherwise it will throw a global error
            return cachedSetTimeout.call(this, fun, 0);
        }
    }


}
function runClearTimeout(marker) {
    if (cachedClearTimeout === clearTimeout) {
        //normal enviroments in sane situations
        return clearTimeout(marker);
    }
    // if clearTimeout wasn't available but was latter defined
    if ((cachedClearTimeout === defaultClearTimeout || !cachedClearTimeout) && clearTimeout) {
        cachedClearTimeout = clearTimeout;
        return clearTimeout(marker);
    }
    try {
        // when when somebody has screwed with setTimeout but no I.E. maddness
        return cachedClearTimeout(marker);
    } catch (e){
        try {
            // When we are in I.E. but the script has been evaled so I.E. doesn't  trust the global object when called normally
            return cachedClearTimeout.call(null, marker);
        } catch (e){
            // same as above but when it's a version of I.E. that must have the global object for 'this', hopfully our context correct otherwise it will throw a global error.
            // Some versions of I.E. have different rules for clearTimeout vs setTimeout
            return cachedClearTimeout.call(this, marker);
        }
    }



}
var queue = [];
var draining = false;
var currentQueue;
var queueIndex = -1;

function cleanUpNextTick() {
    if (!draining || !currentQueue) {
        return;
    }
    draining = false;
    if (currentQueue.length) {
        queue = currentQueue.concat(queue);
    } else {
        queueIndex = -1;
    }
    if (queue.length) {
        drainQueue();
    }
}

function drainQueue() {
    if (draining) {
        return;
    }
    var timeout = runTimeout(cleanUpNextTick);
    draining = true;

    var len = queue.length;
    while(len) {
        currentQueue = queue;
        queue = [];
        while (++queueIndex < len) {
            if (currentQueue) {
                currentQueue[queueIndex].run();
            }
        }
        queueIndex = -1;
        len = queue.length;
    }
    currentQueue = null;
    draining = false;
    runClearTimeout(timeout);
}

process.nextTick = function (fun) {
    var args = new Array(arguments.length - 1);
    if (arguments.length > 1) {
        for (var i = 1; i < arguments.length; i++) {
            args[i - 1] = arguments[i];
        }
    }
    queue.push(new Item(fun, args));
    if (queue.length === 1 && !draining) {
        runTimeout(drainQueue);
    }
};

// v8 likes predictible objects
function Item(fun, array) {
    this.fun = fun;
    this.array = array;
}
Item.prototype.run = function () {
    this.fun.apply(null, this.array);
};
process.title = 'browser';
process.browser = true;
process.env = {};
process.argv = [];
process.version = ''; // empty string to avoid regexp issues
process.versions = {};

function noop() {}

process.on = noop;
process.addListener = noop;
process.once = noop;
process.off = noop;
process.removeListener = noop;
process.removeAllListeners = noop;
process.emit = noop;

process.binding = function (name) {
    throw new Error('process.binding is not supported');
};

process.cwd = function () { return '/' };
process.chdir = function (dir) {
    throw new Error('process.chdir is not supported');
};
process.umask = function() { return 0; };

},{}],85:[function(require,module,exports){
//fgnass.github.com/spin.js#v1.2.5
/**
 * Copyright (c) 2011 Felix Gnass [fgnass at neteye dot de]
 * Licensed under the MIT license
 */

var prefixes = ['webkit', 'Moz', 'ms', 'O']; /* Vendor prefixes */
var animations = {}; /* Animation rules keyed by their name */
var useCssAnimations;

/**
 * Utility function to create elements. If no tag name is given,
 * a DIV is created. Optionally properties can be passed.
 */
function createEl(tag, prop) {
  var el = document.createElement(tag || 'div');
  var n;

  for(n in prop) {
    el[n] = prop[n];
  }
  return el;
}

/**
 * Appends children and returns the parent.
 */
function ins(parent /* child1, child2, ...*/) {
  for (var i=1, n=arguments.length; i<n; i++) {
    parent.appendChild(arguments[i]);
  }
  return parent;
}

/**
 * Insert a new stylesheet to hold the @keyframe or VML rules.
 */
var sheet = function() {
  var el = createEl('style');
  ins(document.getElementsByTagName('head')[0], el);
  return el.sheet || el.styleSheet;
}();

/**
 * Creates an opacity keyframe animation rule and returns its name.
 * Since most mobile Webkits have timing issues with animation-delay,
 * we create separate rules for each line/segment.
 */
function addAnimation(alpha, trail, i, lines) {
  var name = ['opacity', trail, ~~(alpha*100), i, lines].join('-');
  var start = 0.01 + i/lines*100;
  var z = Math.max(1-(1-alpha)/trail*(100-start) , alpha);
  var prefix = useCssAnimations.substring(0, useCssAnimations.indexOf('Animation')).toLowerCase();
  var pre = prefix && '-'+prefix+'-' || '';

  if (!animations[name]) {
    sheet.insertRule(
      '@' + pre + 'keyframes ' + name + '{' +
      '0%{opacity:'+z+'}' +
      start + '%{opacity:'+ alpha + '}' +
      (start+0.01) + '%{opacity:1}' +
      (start+trail)%100 + '%{opacity:'+ alpha + '}' +
      '100%{opacity:'+ z + '}' +
      '}', 0);
    animations[name] = 1;
  }
  return name;
}

/**
 * Tries various vendor prefixes and returns the first supported property.
 **/
function vendor(el, prop) {
  var s = el.style;
  var pp;
  var i;

  if(s[prop] !== undefined) return prop;
  prop = prop.charAt(0).toUpperCase() + prop.slice(1);
  for(i=0; i<prefixes.length; i++) {
    pp = prefixes[i]+prop;
    if(s[pp] !== undefined) return pp;
  }
}

/**
 * Sets multiple style properties at once.
 */
function css(el, prop) {
  for (var n in prop) {
    el.style[vendor(el, n)||n] = prop[n];
  }
  return el;
}

/**
 * Fills in default values.
 */
function merge(obj) {
  for (var i=1; i < arguments.length; i++) {
    var def = arguments[i];
    for (var n in def) {
      if (obj[n] === undefined) obj[n] = def[n];
    }
  }
  return obj;
}

/**
 * Returns the absolute page-offset of the given element.
 */
function pos(el) {
  var o = {x:el.offsetLeft, y:el.offsetTop};
  while((el = el.offsetParent)) {
    o.x+=el.offsetLeft;
    o.y+=el.offsetTop;
  }
  return o;
}

var defaults = {
  lines: 12,            // The number of lines to draw
  length: 7,            // The length of each line
  width: 5,             // The line thickness
  radius: 10,           // The radius of the inner circle
  rotate: 0,            // rotation offset
  color: '#000',        // #rgb or #rrggbb
  speed: 1,             // Rounds per second
  trail: 100,           // Afterglow percentage
  opacity: 1/4,         // Opacity of the lines
  fps: 20,              // Frames per second when using setTimeout()
  zIndex: 2e9,          // Use a high z-index by default
  className: 'spinner', // CSS class to assign to the element
  top: 'auto',          // center vertically
  left: 'auto'          // center horizontally
};

/** The constructor */
var Spinner = function Spinner(o) {
  if (!this.spin) return new Spinner(o);
  this.opts = merge(o || {}, Spinner.defaults, defaults);
};

Spinner.defaults = {};
merge(Spinner.prototype, {
  spin: function(target) {
    this.stop();
    var self = this;
    var o = self.opts;
    var el = self.el = css(createEl(0, {className: o.className}), {position: 'relative', zIndex: o.zIndex});
    var mid = o.radius+o.length+o.width;
    var ep; // element position
    var tp; // target position

    if (target) {
      target.insertBefore(el, target.firstChild||null);
      tp = pos(target);
      ep = pos(el);
      css(el, {
        left: (o.left == 'auto' ? tp.x-ep.x + (target.offsetWidth >> 1) : o.left+mid) + 'px',
        top: (o.top == 'auto' ? tp.y-ep.y + (target.offsetHeight >> 1) : o.top+mid)  + 'px'
      });
    }

    el.setAttribute('aria-role', 'progressbar');
    self.lines(el, self.opts);

    if (!useCssAnimations) {
      // No CSS animation support, use setTimeout() instead
      var i = 0;
      var fps = o.fps;
      var f = fps/o.speed;
      var ostep = (1-o.opacity)/(f*o.trail / 100);
      var astep = f/o.lines;

      !function anim() {
        i++;
        for (var s=o.lines; s; s--) {
          var alpha = Math.max(1-(i+s*astep)%f * ostep, o.opacity);
          self.opacity(el, o.lines-s, alpha, o);
        }
        self.timeout = self.el && setTimeout(anim, ~~(1000/fps));
      }();
    }
    return self;
  },
  stop: function() {
    var el = this.el;
    if (el) {
      clearTimeout(this.timeout);
      if (el.parentNode) el.parentNode.removeChild(el);
      this.el = undefined;
    }
    return this;
  },
  lines: function(el, o) {
    var i = 0;
    var seg;

    function fill(color, shadow) {
      return css(createEl(), {
        position: 'absolute',
        width: (o.length+o.width) + 'px',
        height: o.width + 'px',
        background: color,
        boxShadow: shadow,
        transformOrigin: 'left',
        transform: 'rotate(' + ~~(360/o.lines*i+o.rotate) + 'deg) translate(' + o.radius+'px' +',0)',
        borderRadius: (o.width>>1) + 'px'
      });
    }
    for (; i < o.lines; i++) {
      seg = css(createEl(), {
        position: 'absolute',
        top: 1+~(o.width/2) + 'px',
        transform: o.hwaccel ? 'translate3d(0,0,0)' : '',
        opacity: o.opacity,
        animation: useCssAnimations && addAnimation(o.opacity, o.trail, i, o.lines) + ' ' + 1/o.speed + 's linear infinite'
      });
      if (o.shadow) ins(seg, css(fill('#000', '0 0 4px ' + '#000'), {top: 2+'px'}));
      ins(el, ins(seg, fill(o.color, '0 0 1px rgba(0,0,0,.1)')));
    }
    return el;
  },
  opacity: function(el, i, val) {
    if (i < el.childNodes.length) el.childNodes[i].style.opacity = val;
  }
});

/////////////////////////////////////////////////////////////////////////
// VML rendering for IE
/////////////////////////////////////////////////////////////////////////

/**
 * Check and init VML support
 */
!function() {

  function vml(tag, attr) {
    return createEl('<' + tag + ' xmlns="urn:schemas-microsoft.com:vml" class="spin-vml">', attr);
  }

  var s = css(createEl('group'), {behavior: 'url(#default#VML)'});

  if (!vendor(s, 'transform') && s.adj) {

    // VML support detected. Insert CSS rule ...
    sheet.addRule('.spin-vml', 'behavior:url(#default#VML)');

    Spinner.prototype.lines = function(el, o) {
      var r = o.length+o.width;
      var s = 2*r;

      function grp() {
        return css(vml('group', {coordsize: s +' '+s, coordorigin: -r +' '+-r}), {width: s, height: s});
      }

      var margin = -(o.width+o.length)*2+'px';
      var g = css(grp(), {position: 'absolute', top: margin, left: margin});

      var i;

      function seg(i, dx, filter) {
        ins(g,
          ins(css(grp(), {rotation: 360 / o.lines * i + 'deg', left: ~~dx}),
            ins(css(vml('roundrect', {arcsize: 1}), {
                width: r,
                height: o.width,
                left: o.radius,
                top: -o.width>>1,
                filter: filter
              }),
              vml('fill', {color: o.color, opacity: o.opacity}),
              vml('stroke', {opacity: 0}) // transparent stroke to fix color bleeding upon opacity change
            )
          )
        );
      }

      if (o.shadow) {
        for (i = 1; i <= o.lines; i++) {
          seg(i, -2, 'progid:DXImageTransform.Microsoft.Blur(pixelradius=2,makeshadow=1,shadowopacity=.3)');
        }
      }
      for (i = 1; i <= o.lines; i++) seg(i);
      return ins(el, g);
    };
    Spinner.prototype.opacity = function(el, i, val, o) {
      var c = el.firstChild;
      o = o.shadow && o.lines || 0;
      if (c && i+o < c.childNodes.length) {
        c = c.childNodes[i+o]; c = c && c.firstChild; c = c && c.firstChild;
        if (c) c.opacity = val;
      }
    };
  }
  else {
    useCssAnimations = vendor(s, 'animation');
  }
}();

module.exports = Spinner;

},{}],86:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, '__esModule', {
  value: true
});
var defaultParams = {
  title: '',
  text: '',
  type: null,
  allowOutsideClick: false,
  showConfirmButton: true,
  showCancelButton: false,
  closeOnConfirm: true,
  closeOnCancel: true,
  confirmButtonText: 'OK',
  confirmButtonColor: '#8CD4F5',
  cancelButtonText: 'Cancel',
  imageUrl: null,
  imageSize: null,
  timer: null,
  customClass: '',
  html: false,
  animation: true,
  allowEscapeKey: true,
  inputType: 'text',
  inputPlaceholder: '',
  inputValue: '',
  showLoaderOnConfirm: false
};

exports['default'] = defaultParams;
module.exports = exports['default'];
},{}],87:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, '__esModule', {
  value: true
});

var _colorLuminance = require('./utils');

var _getModal = require('./handle-swal-dom');

var _hasClass$isDescendant = require('./handle-dom');

/*
 * User clicked on "Confirm"/"OK" or "Cancel"
 */
var handleButton = function handleButton(event, params, modal) {
  var e = event || window.event;
  var target = e.target || e.srcElement;

  var targetedConfirm = target.className.indexOf('confirm') !== -1;
  var targetedOverlay = target.className.indexOf('sweet-overlay') !== -1;
  var modalIsVisible = _hasClass$isDescendant.hasClass(modal, 'visible');
  var doneFunctionExists = params.doneFunction && modal.getAttribute('data-has-done-function') === 'true';

  // Since the user can change the background-color of the confirm button programmatically,
  // we must calculate what the color should be on hover/active
  var normalColor, hoverColor, activeColor;
  if (targetedConfirm && params.confirmButtonColor) {
    normalColor = params.confirmButtonColor;
    hoverColor = _colorLuminance.colorLuminance(normalColor, -0.04);
    activeColor = _colorLuminance.colorLuminance(normalColor, -0.14);
  }

  function shouldSetConfirmButtonColor(color) {
    if (targetedConfirm && params.confirmButtonColor) {
      target.style.backgroundColor = color;
    }
  }

  switch (e.type) {
    case 'mouseover':
      shouldSetConfirmButtonColor(hoverColor);
      break;

    case 'mouseout':
      shouldSetConfirmButtonColor(normalColor);
      break;

    case 'mousedown':
      shouldSetConfirmButtonColor(activeColor);
      break;

    case 'mouseup':
      shouldSetConfirmButtonColor(hoverColor);
      break;

    case 'focus':
      var $confirmButton = modal.querySelector('button.confirm');
      var $cancelButton = modal.querySelector('button.cancel');

      if (targetedConfirm) {
        $cancelButton.style.boxShadow = 'none';
      } else {
        $confirmButton.style.boxShadow = 'none';
      }
      break;

    case 'click':
      var clickedOnModal = modal === target;
      var clickedOnModalChild = _hasClass$isDescendant.isDescendant(modal, target);

      // Ignore click outside if allowOutsideClick is false
      if (!clickedOnModal && !clickedOnModalChild && modalIsVisible && !params.allowOutsideClick) {
        break;
      }

      if (targetedConfirm && doneFunctionExists && modalIsVisible) {
        handleConfirm(modal, params);
      } else if (doneFunctionExists && modalIsVisible || targetedOverlay) {
        handleCancel(modal, params);
      } else if (_hasClass$isDescendant.isDescendant(modal, target) && target.tagName === 'BUTTON') {
        sweetAlert.close();
      }
      break;
  }
};

/*
 *  User clicked on "Confirm"/"OK"
 */
var handleConfirm = function handleConfirm(modal, params) {
  var callbackValue = true;

  if (_hasClass$isDescendant.hasClass(modal, 'show-input')) {
    callbackValue = modal.querySelector('input').value;

    if (!callbackValue) {
      callbackValue = '';
    }
  }

  params.doneFunction(callbackValue);

  if (params.closeOnConfirm) {
    sweetAlert.close();
  }
  // Disable cancel and confirm button if the parameter is true
  if (params.showLoaderOnConfirm) {
    sweetAlert.disableButtons();
  }
};

/*
 *  User clicked on "Cancel"
 */
var handleCancel = function handleCancel(modal, params) {
  // Check if callback function expects a parameter (to track cancel actions)
  var functionAsStr = String(params.doneFunction).replace(/\s/g, '');
  var functionHandlesCancel = functionAsStr.substring(0, 9) === 'function(' && functionAsStr.substring(9, 10) !== ')';

  if (functionHandlesCancel) {
    params.doneFunction(false);
  }

  if (params.closeOnCancel) {
    sweetAlert.close();
  }
};

exports['default'] = {
  handleButton: handleButton,
  handleConfirm: handleConfirm,
  handleCancel: handleCancel
};
module.exports = exports['default'];
},{"./handle-dom":88,"./handle-swal-dom":90,"./utils":93}],88:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, '__esModule', {
  value: true
});
var hasClass = function hasClass(elem, className) {
  return new RegExp(' ' + className + ' ').test(' ' + elem.className + ' ');
};

var addClass = function addClass(elem, className) {
  if (!hasClass(elem, className)) {
    elem.className += ' ' + className;
  }
};

var removeClass = function removeClass(elem, className) {
  var newClass = ' ' + elem.className.replace(/[\t\r\n]/g, ' ') + ' ';
  if (hasClass(elem, className)) {
    while (newClass.indexOf(' ' + className + ' ') >= 0) {
      newClass = newClass.replace(' ' + className + ' ', ' ');
    }
    elem.className = newClass.replace(/^\s+|\s+$/g, '');
  }
};

var escapeHtml = function escapeHtml(str) {
  var div = document.createElement('div');
  div.appendChild(document.createTextNode(str));
  return div.innerHTML;
};

var _show = function _show(elem) {
  elem.style.opacity = '';
  elem.style.display = 'block';
};

var show = function show(elems) {
  if (elems && !elems.length) {
    return _show(elems);
  }
  for (var i = 0; i < elems.length; ++i) {
    _show(elems[i]);
  }
};

var _hide = function _hide(elem) {
  elem.style.opacity = '';
  elem.style.display = 'none';
};

var hide = function hide(elems) {
  if (elems && !elems.length) {
    return _hide(elems);
  }
  for (var i = 0; i < elems.length; ++i) {
    _hide(elems[i]);
  }
};

var isDescendant = function isDescendant(parent, child) {
  var node = child.parentNode;
  while (node !== null) {
    if (node === parent) {
      return true;
    }
    node = node.parentNode;
  }
  return false;
};

var getTopMargin = function getTopMargin(elem) {
  elem.style.left = '-9999px';
  elem.style.display = 'block';

  var height = elem.clientHeight,
      padding;
  if (typeof getComputedStyle !== 'undefined') {
    // IE 8
    padding = parseInt(getComputedStyle(elem).getPropertyValue('padding-top'), 10);
  } else {
    padding = parseInt(elem.currentStyle.padding);
  }

  elem.style.left = '';
  elem.style.display = 'none';
  return '-' + parseInt((height + padding) / 2) + 'px';
};

var fadeIn = function fadeIn(elem, interval) {
  if (+elem.style.opacity < 1) {
    interval = interval || 16;
    elem.style.opacity = 0;
    elem.style.display = 'block';
    var last = +new Date();
    var tick = (function (_tick) {
      function tick() {
        return _tick.apply(this, arguments);
      }

      tick.toString = function () {
        return _tick.toString();
      };

      return tick;
    })(function () {
      elem.style.opacity = +elem.style.opacity + (new Date() - last) / 100;
      last = +new Date();

      if (+elem.style.opacity < 1) {
        setTimeout(tick, interval);
      }
    });
    tick();
  }
  elem.style.display = 'block'; //fallback IE8
};

var fadeOut = function fadeOut(elem, interval) {
  interval = interval || 16;
  elem.style.opacity = 1;
  var last = +new Date();
  var tick = (function (_tick2) {
    function tick() {
      return _tick2.apply(this, arguments);
    }

    tick.toString = function () {
      return _tick2.toString();
    };

    return tick;
  })(function () {
    elem.style.opacity = +elem.style.opacity - (new Date() - last) / 100;
    last = +new Date();

    if (+elem.style.opacity > 0) {
      setTimeout(tick, interval);
    } else {
      elem.style.display = 'none';
    }
  });
  tick();
};

var fireClick = function fireClick(node) {
  // Taken from http://www.nonobtrusive.com/2011/11/29/programatically-fire-crossbrowser-click-event-with-javascript/
  // Then fixed for today's Chrome browser.
  if (typeof MouseEvent === 'function') {
    // Up-to-date approach
    var mevt = new MouseEvent('click', {
      view: window,
      bubbles: false,
      cancelable: true
    });
    node.dispatchEvent(mevt);
  } else if (document.createEvent) {
    // Fallback
    var evt = document.createEvent('MouseEvents');
    evt.initEvent('click', false, false);
    node.dispatchEvent(evt);
  } else if (document.createEventObject) {
    node.fireEvent('onclick');
  } else if (typeof node.onclick === 'function') {
    node.onclick();
  }
};

var stopEventPropagation = function stopEventPropagation(e) {
  // In particular, make sure the space bar doesn't scroll the main window.
  if (typeof e.stopPropagation === 'function') {
    e.stopPropagation();
    e.preventDefault();
  } else if (window.event && window.event.hasOwnProperty('cancelBubble')) {
    window.event.cancelBubble = true;
  }
};

exports.hasClass = hasClass;
exports.addClass = addClass;
exports.removeClass = removeClass;
exports.escapeHtml = escapeHtml;
exports._show = _show;
exports.show = show;
exports._hide = _hide;
exports.hide = hide;
exports.isDescendant = isDescendant;
exports.getTopMargin = getTopMargin;
exports.fadeIn = fadeIn;
exports.fadeOut = fadeOut;
exports.fireClick = fireClick;
exports.stopEventPropagation = stopEventPropagation;
},{}],89:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, '__esModule', {
  value: true
});

var _stopEventPropagation$fireClick = require('./handle-dom');

var _setFocusStyle = require('./handle-swal-dom');

var handleKeyDown = function handleKeyDown(event, params, modal) {
  var e = event || window.event;
  var keyCode = e.keyCode || e.which;

  var $okButton = modal.querySelector('button.confirm');
  var $cancelButton = modal.querySelector('button.cancel');
  var $modalButtons = modal.querySelectorAll('button[tabindex]');

  if ([9, 13, 32, 27].indexOf(keyCode) === -1) {
    // Don't do work on keys we don't care about.
    return;
  }

  var $targetElement = e.target || e.srcElement;

  var btnIndex = -1; // Find the button - note, this is a nodelist, not an array.
  for (var i = 0; i < $modalButtons.length; i++) {
    if ($targetElement === $modalButtons[i]) {
      btnIndex = i;
      break;
    }
  }

  if (keyCode === 9) {
    // TAB
    if (btnIndex === -1) {
      // No button focused. Jump to the confirm button.
      $targetElement = $okButton;
    } else {
      // Cycle to the next button
      if (btnIndex === $modalButtons.length - 1) {
        $targetElement = $modalButtons[0];
      } else {
        $targetElement = $modalButtons[btnIndex + 1];
      }
    }

    _stopEventPropagation$fireClick.stopEventPropagation(e);
    $targetElement.focus();

    if (params.confirmButtonColor) {
      _setFocusStyle.setFocusStyle($targetElement, params.confirmButtonColor);
    }
  } else {
    if (keyCode === 13) {
      if ($targetElement.tagName === 'INPUT') {
        $targetElement = $okButton;
        $okButton.focus();
      }

      if (btnIndex === -1) {
        // ENTER/SPACE clicked outside of a button.
        $targetElement = $okButton;
      } else {
        // Do nothing - let the browser handle it.
        $targetElement = undefined;
      }
    } else if (keyCode === 27 && params.allowEscapeKey === true) {
      $targetElement = $cancelButton;
      _stopEventPropagation$fireClick.fireClick($targetElement, e);
    } else {
      // Fallback - let the browser handle it.
      $targetElement = undefined;
    }
  }
};

exports['default'] = handleKeyDown;
module.exports = exports['default'];
},{"./handle-dom":88,"./handle-swal-dom":90}],90:[function(require,module,exports){
'use strict';

var _interopRequireWildcard = function (obj) { return obj && obj.__esModule ? obj : { 'default': obj }; };

Object.defineProperty(exports, '__esModule', {
  value: true
});

var _hexToRgb = require('./utils');

var _removeClass$getTopMargin$fadeIn$show$addClass = require('./handle-dom');

var _defaultParams = require('./default-params');

var _defaultParams2 = _interopRequireWildcard(_defaultParams);

/*
 * Add modal + overlay to DOM
 */

var _injectedHTML = require('./injected-html');

var _injectedHTML2 = _interopRequireWildcard(_injectedHTML);

var modalClass = '.sweet-alert';
var overlayClass = '.sweet-overlay';

var sweetAlertInitialize = function sweetAlertInitialize() {
  var sweetWrap = document.createElement('div');
  sweetWrap.innerHTML = _injectedHTML2['default'];

  // Append elements to body
  while (sweetWrap.firstChild) {
    document.body.appendChild(sweetWrap.firstChild);
  }
};

/*
 * Get DOM element of modal
 */
var getModal = (function (_getModal) {
  function getModal() {
    return _getModal.apply(this, arguments);
  }

  getModal.toString = function () {
    return _getModal.toString();
  };

  return getModal;
})(function () {
  var $modal = document.querySelector(modalClass);

  if (!$modal) {
    sweetAlertInitialize();
    $modal = getModal();
  }

  return $modal;
});

/*
 * Get DOM element of input (in modal)
 */
var getInput = function getInput() {
  var $modal = getModal();
  if ($modal) {
    return $modal.querySelector('input');
  }
};

/*
 * Get DOM element of overlay
 */
var getOverlay = function getOverlay() {
  return document.querySelector(overlayClass);
};

/*
 * Add box-shadow style to button (depending on its chosen bg-color)
 */
var setFocusStyle = function setFocusStyle($button, bgColor) {
  var rgbColor = _hexToRgb.hexToRgb(bgColor);
  $button.style.boxShadow = '0 0 2px rgba(' + rgbColor + ', 0.8), inset 0 0 0 1px rgba(0, 0, 0, 0.05)';
};

/*
 * Animation when opening modal
 */
var openModal = function openModal(callback) {
  var $modal = getModal();
  _removeClass$getTopMargin$fadeIn$show$addClass.fadeIn(getOverlay(), 10);
  _removeClass$getTopMargin$fadeIn$show$addClass.show($modal);
  _removeClass$getTopMargin$fadeIn$show$addClass.addClass($modal, 'showSweetAlert');
  _removeClass$getTopMargin$fadeIn$show$addClass.removeClass($modal, 'hideSweetAlert');

  window.previousActiveElement = document.activeElement;
  var $okButton = $modal.querySelector('button.confirm');
  $okButton.focus();

  setTimeout(function () {
    _removeClass$getTopMargin$fadeIn$show$addClass.addClass($modal, 'visible');
  }, 500);

  var timer = $modal.getAttribute('data-timer');

  if (timer !== 'null' && timer !== '') {
    var timerCallback = callback;
    $modal.timeout = setTimeout(function () {
      var doneFunctionExists = (timerCallback || null) && $modal.getAttribute('data-has-done-function') === 'true';
      if (doneFunctionExists) {
        timerCallback(null);
      } else {
        sweetAlert.close();
      }
    }, timer);
  }
};

/*
 * Reset the styling of the input
 * (for example if errors have been shown)
 */
var resetInput = function resetInput() {
  var $modal = getModal();
  var $input = getInput();

  _removeClass$getTopMargin$fadeIn$show$addClass.removeClass($modal, 'show-input');
  $input.value = _defaultParams2['default'].inputValue;
  $input.setAttribute('type', _defaultParams2['default'].inputType);
  $input.setAttribute('placeholder', _defaultParams2['default'].inputPlaceholder);

  resetInputError();
};

var resetInputError = function resetInputError(event) {
  // If press enter => ignore
  if (event && event.keyCode === 13) {
    return false;
  }

  var $modal = getModal();

  var $errorIcon = $modal.querySelector('.sa-input-error');
  _removeClass$getTopMargin$fadeIn$show$addClass.removeClass($errorIcon, 'show');

  var $errorContainer = $modal.querySelector('.sa-error-container');
  _removeClass$getTopMargin$fadeIn$show$addClass.removeClass($errorContainer, 'show');
};

/*
 * Set "margin-top"-property on modal based on its computed height
 */
var fixVerticalPosition = function fixVerticalPosition() {
  var $modal = getModal();
  $modal.style.marginTop = _removeClass$getTopMargin$fadeIn$show$addClass.getTopMargin(getModal());
};

exports.sweetAlertInitialize = sweetAlertInitialize;
exports.getModal = getModal;
exports.getOverlay = getOverlay;
exports.getInput = getInput;
exports.setFocusStyle = setFocusStyle;
exports.openModal = openModal;
exports.resetInput = resetInput;
exports.resetInputError = resetInputError;
exports.fixVerticalPosition = fixVerticalPosition;
},{"./default-params":86,"./handle-dom":88,"./injected-html":91,"./utils":93}],91:[function(require,module,exports){
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
var injectedHTML =

// Dark overlay
"<div class=\"sweet-overlay\" tabIndex=\"-1\"></div>" +

// Modal
"<div class=\"sweet-alert\">" +

// Error icon
"<div class=\"sa-icon sa-error\">\n      <span class=\"sa-x-mark\">\n        <span class=\"sa-line sa-left\"></span>\n        <span class=\"sa-line sa-right\"></span>\n      </span>\n    </div>" +

// Warning icon
"<div class=\"sa-icon sa-warning\">\n      <span class=\"sa-body\"></span>\n      <span class=\"sa-dot\"></span>\n    </div>" +

// Info icon
"<div class=\"sa-icon sa-info\"></div>" +

// Success icon
"<div class=\"sa-icon sa-success\">\n      <span class=\"sa-line sa-tip\"></span>\n      <span class=\"sa-line sa-long\"></span>\n\n      <div class=\"sa-placeholder\"></div>\n      <div class=\"sa-fix\"></div>\n    </div>" + "<div class=\"sa-icon sa-custom\"></div>" +

// Title, text and input
"<h2>Title</h2>\n    <p>Text</p>\n    <fieldset>\n      <input type=\"text\" tabIndex=\"3\" />\n      <div class=\"sa-input-error\"></div>\n    </fieldset>" +

// Input errors
"<div class=\"sa-error-container\">\n      <div class=\"icon\">!</div>\n      <p>Not valid!</p>\n    </div>" +

// Cancel and confirm buttons
"<div class=\"sa-button-container\">\n      <button class=\"cancel\" tabIndex=\"2\">Cancel</button>\n      <div class=\"sa-confirm-button-container\">\n        <button class=\"confirm\" tabIndex=\"1\">OK</button>" +

// Loading animation
"<div class=\"la-ball-fall\">\n          <div></div>\n          <div></div>\n          <div></div>\n        </div>\n      </div>\n    </div>" +

// End of modal
"</div>";

exports["default"] = injectedHTML;
module.exports = exports["default"];
},{}],92:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, '__esModule', {
  value: true
});

var _isIE8 = require('./utils');

var _getModal$getInput$setFocusStyle = require('./handle-swal-dom');

var _hasClass$addClass$removeClass$escapeHtml$_show$show$_hide$hide = require('./handle-dom');

var alertTypes = ['error', 'warning', 'info', 'success', 'input', 'prompt'];

/*
 * Set type, text and actions on modal
 */
var setParameters = function setParameters(params) {
  var modal = _getModal$getInput$setFocusStyle.getModal();

  var $title = modal.querySelector('h2');
  var $text = modal.querySelector('p');
  var $cancelBtn = modal.querySelector('button.cancel');
  var $confirmBtn = modal.querySelector('button.confirm');

  /*
   * Title
   */
  $title.innerHTML = params.html ? params.title : _hasClass$addClass$removeClass$escapeHtml$_show$show$_hide$hide.escapeHtml(params.title).split('\n').join('<br>');

  /*
   * Text
   */
  $text.innerHTML = params.html ? params.text : _hasClass$addClass$removeClass$escapeHtml$_show$show$_hide$hide.escapeHtml(params.text || '').split('\n').join('<br>');
  if (params.text) _hasClass$addClass$removeClass$escapeHtml$_show$show$_hide$hide.show($text);

  /*
   * Custom class
   */
  if (params.customClass) {
    _hasClass$addClass$removeClass$escapeHtml$_show$show$_hide$hide.addClass(modal, params.customClass);
    modal.setAttribute('data-custom-class', params.customClass);
  } else {
    // Find previously set classes and remove them
    var customClass = modal.getAttribute('data-custom-class');
    _hasClass$addClass$removeClass$escapeHtml$_show$show$_hide$hide.removeClass(modal, customClass);
    modal.setAttribute('data-custom-class', '');
  }

  /*
   * Icon
   */
  _hasClass$addClass$removeClass$escapeHtml$_show$show$_hide$hide.hide(modal.querySelectorAll('.sa-icon'));

  if (params.type && !_isIE8.isIE8()) {
    var _ret = (function () {

      var validType = false;

      for (var i = 0; i < alertTypes.length; i++) {
        if (params.type === alertTypes[i]) {
          validType = true;
          break;
        }
      }

      if (!validType) {
        logStr('Unknown alert type: ' + params.type);
        return {
          v: false
        };
      }

      var typesWithIcons = ['success', 'error', 'warning', 'info'];
      var $icon = undefined;

      if (typesWithIcons.indexOf(params.type) !== -1) {
        $icon = modal.querySelector('.sa-icon.' + 'sa-' + params.type);
        _hasClass$addClass$removeClass$escapeHtml$_show$show$_hide$hide.show($icon);
      }

      var $input = _getModal$getInput$setFocusStyle.getInput();

      // Animate icon
      switch (params.type) {

        case 'success':
          _hasClass$addClass$removeClass$escapeHtml$_show$show$_hide$hide.addClass($icon, 'animate');
          _hasClass$addClass$removeClass$escapeHtml$_show$show$_hide$hide.addClass($icon.querySelector('.sa-tip'), 'animateSuccessTip');
          _hasClass$addClass$removeClass$escapeHtml$_show$show$_hide$hide.addClass($icon.querySelector('.sa-long'), 'animateSuccessLong');
          break;

        case 'error':
          _hasClass$addClass$removeClass$escapeHtml$_show$show$_hide$hide.addClass($icon, 'animateErrorIcon');
          _hasClass$addClass$removeClass$escapeHtml$_show$show$_hide$hide.addClass($icon.querySelector('.sa-x-mark'), 'animateXMark');
          break;

        case 'warning':
          _hasClass$addClass$removeClass$escapeHtml$_show$show$_hide$hide.addClass($icon, 'pulseWarning');
          _hasClass$addClass$removeClass$escapeHtml$_show$show$_hide$hide.addClass($icon.querySelector('.sa-body'), 'pulseWarningIns');
          _hasClass$addClass$removeClass$escapeHtml$_show$show$_hide$hide.addClass($icon.querySelector('.sa-dot'), 'pulseWarningIns');
          break;

        case 'input':
        case 'prompt':
          $input.setAttribute('type', params.inputType);
          $input.value = params.inputValue;
          $input.setAttribute('placeholder', params.inputPlaceholder);
          _hasClass$addClass$removeClass$escapeHtml$_show$show$_hide$hide.addClass(modal, 'show-input');
          setTimeout(function () {
            $input.focus();
            $input.addEventListener('keyup', swal.resetInputError);
          }, 400);
          break;
      }
    })();

    if (typeof _ret === 'object') {
      return _ret.v;
    }
  }

  /*
   * Custom image
   */
  if (params.imageUrl) {
    var $customIcon = modal.querySelector('.sa-icon.sa-custom');

    $customIcon.style.backgroundImage = 'url(' + params.imageUrl + ')';
    _hasClass$addClass$removeClass$escapeHtml$_show$show$_hide$hide.show($customIcon);

    var _imgWidth = 80;
    var _imgHeight = 80;

    if (params.imageSize) {
      var dimensions = params.imageSize.toString().split('x');
      var imgWidth = dimensions[0];
      var imgHeight = dimensions[1];

      if (!imgWidth || !imgHeight) {
        logStr('Parameter imageSize expects value with format WIDTHxHEIGHT, got ' + params.imageSize);
      } else {
        _imgWidth = imgWidth;
        _imgHeight = imgHeight;
      }
    }

    $customIcon.setAttribute('style', $customIcon.getAttribute('style') + 'width:' + _imgWidth + 'px; height:' + _imgHeight + 'px');
  }

  /*
   * Show cancel button?
   */
  modal.setAttribute('data-has-cancel-button', params.showCancelButton);
  if (params.showCancelButton) {
    $cancelBtn.style.display = 'inline-block';
  } else {
    _hasClass$addClass$removeClass$escapeHtml$_show$show$_hide$hide.hide($cancelBtn);
  }

  /*
   * Show confirm button?
   */
  modal.setAttribute('data-has-confirm-button', params.showConfirmButton);
  if (params.showConfirmButton) {
    $confirmBtn.style.display = 'inline-block';
  } else {
    _hasClass$addClass$removeClass$escapeHtml$_show$show$_hide$hide.hide($confirmBtn);
  }

  /*
   * Custom text on cancel/confirm buttons
   */
  if (params.cancelButtonText) {
    $cancelBtn.innerHTML = _hasClass$addClass$removeClass$escapeHtml$_show$show$_hide$hide.escapeHtml(params.cancelButtonText);
  }
  if (params.confirmButtonText) {
    $confirmBtn.innerHTML = _hasClass$addClass$removeClass$escapeHtml$_show$show$_hide$hide.escapeHtml(params.confirmButtonText);
  }

  /*
   * Custom color on confirm button
   */
  if (params.confirmButtonColor) {
    // Set confirm button to selected background color
    $confirmBtn.style.backgroundColor = params.confirmButtonColor;

    // Set the confirm button color to the loading ring
    $confirmBtn.style.borderLeftColor = params.confirmLoadingButtonColor;
    $confirmBtn.style.borderRightColor = params.confirmLoadingButtonColor;

    // Set box-shadow to default focused button
    _getModal$getInput$setFocusStyle.setFocusStyle($confirmBtn, params.confirmButtonColor);
  }

  /*
   * Allow outside click
   */
  modal.setAttribute('data-allow-outside-click', params.allowOutsideClick);

  /*
   * Callback function
   */
  var hasDoneFunction = params.doneFunction ? true : false;
  modal.setAttribute('data-has-done-function', hasDoneFunction);

  /*
   * Animation
   */
  if (!params.animation) {
    modal.setAttribute('data-animation', 'none');
  } else if (typeof params.animation === 'string') {
    modal.setAttribute('data-animation', params.animation); // Custom animation
  } else {
    modal.setAttribute('data-animation', 'pop');
  }

  /*
   * Timer
   */
  modal.setAttribute('data-timer', params.timer);
};

exports['default'] = setParameters;
module.exports = exports['default'];
},{"./handle-dom":88,"./handle-swal-dom":90,"./utils":93}],93:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, '__esModule', {
  value: true
});
/*
 * Allow user to pass their own params
 */
var extend = function extend(a, b) {
  for (var key in b) {
    if (b.hasOwnProperty(key)) {
      a[key] = b[key];
    }
  }
  return a;
};

/*
 * Convert HEX codes to RGB values (#000000 -> rgb(0,0,0))
 */
var hexToRgb = function hexToRgb(hex) {
  var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
  return result ? parseInt(result[1], 16) + ', ' + parseInt(result[2], 16) + ', ' + parseInt(result[3], 16) : null;
};

/*
 * Check if the user is using Internet Explorer 8 (for fallbacks)
 */
var isIE8 = function isIE8() {
  return window.attachEvent && !window.addEventListener;
};

/*
 * IE compatible logging for developers
 */
var logStr = function logStr(string) {
  if (window.console) {
    // IE...
    window.console.log('SweetAlert: ' + string);
  }
};

/*
 * Set hover, active and focus-states for buttons 
 * (source: http://www.sitepoint.com/javascript-generate-lighter-darker-color)
 */
var colorLuminance = function colorLuminance(hex, lum) {
  // Validate hex string
  hex = String(hex).replace(/[^0-9a-f]/gi, '');
  if (hex.length < 6) {
    hex = hex[0] + hex[0] + hex[1] + hex[1] + hex[2] + hex[2];
  }
  lum = lum || 0;

  // Convert to decimal and change luminosity
  var rgb = '#';
  var c;
  var i;

  for (i = 0; i < 3; i++) {
    c = parseInt(hex.substr(i * 2, 2), 16);
    c = Math.round(Math.min(Math.max(0, c + c * lum), 255)).toString(16);
    rgb += ('00' + c).substr(c.length);
  }

  return rgb;
};

exports.extend = extend;
exports.hexToRgb = hexToRgb;
exports.isIE8 = isIE8;
exports.logStr = logStr;
exports.colorLuminance = colorLuminance;
},{}],94:[function(require,module,exports){
'use strict';

var _interopRequireWildcard = function (obj) { return obj && obj.__esModule ? obj : { 'default': obj }; };

Object.defineProperty(exports, '__esModule', {
  value: true
});
// SweetAlert
// 2014-2015 (c) - Tristan Edwards
// github.com/t4t5/sweetalert

/*
 * jQuery-like functions for manipulating the DOM
 */

var _hasClass$addClass$removeClass$escapeHtml$_show$show$_hide$hide$isDescendant$getTopMargin$fadeIn$fadeOut$fireClick$stopEventPropagation = require('./modules/handle-dom');

/*
 * Handy utilities
 */

var _extend$hexToRgb$isIE8$logStr$colorLuminance = require('./modules/utils');

/*
 *  Handle sweetAlert's DOM elements
 */

var _sweetAlertInitialize$getModal$getOverlay$getInput$setFocusStyle$openModal$resetInput$fixVerticalPosition = require('./modules/handle-swal-dom');

// Handle button events and keyboard events

var _handleButton$handleConfirm$handleCancel = require('./modules/handle-click');

var _handleKeyDown = require('./modules/handle-key');

var _handleKeyDown2 = _interopRequireWildcard(_handleKeyDown);

// Default values

var _defaultParams = require('./modules/default-params');

var _defaultParams2 = _interopRequireWildcard(_defaultParams);

var _setParameters = require('./modules/set-params');

var _setParameters2 = _interopRequireWildcard(_setParameters);

/*
 * Remember state in cases where opening and handling a modal will fiddle with it.
 * (We also use window.previousActiveElement as a global variable)
 */
var previousWindowKeyDown;
var lastFocusedButton;

/*
 * Global sweetAlert function
 * (this is what the user calls)
 */
var sweetAlert, swal;

exports['default'] = sweetAlert = swal = function () {
  var customizations = arguments[0];

  _hasClass$addClass$removeClass$escapeHtml$_show$show$_hide$hide$isDescendant$getTopMargin$fadeIn$fadeOut$fireClick$stopEventPropagation.addClass(document.body, 'stop-scrolling');
  _sweetAlertInitialize$getModal$getOverlay$getInput$setFocusStyle$openModal$resetInput$fixVerticalPosition.resetInput();

  /*
   * Use argument if defined or default value from params object otherwise.
   * Supports the case where a default value is boolean true and should be
   * overridden by a corresponding explicit argument which is boolean false.
   */
  function argumentOrDefault(key) {
    var args = customizations;
    return args[key] === undefined ? _defaultParams2['default'][key] : args[key];
  }

  if (customizations === undefined) {
    _extend$hexToRgb$isIE8$logStr$colorLuminance.logStr('SweetAlert expects at least 1 attribute!');
    return false;
  }

  var params = _extend$hexToRgb$isIE8$logStr$colorLuminance.extend({}, _defaultParams2['default']);

  switch (typeof customizations) {

    // Ex: swal("Hello", "Just testing", "info");
    case 'string':
      params.title = customizations;
      params.text = arguments[1] || '';
      params.type = arguments[2] || '';
      break;

    // Ex: swal({ title:"Hello", text: "Just testing", type: "info" });
    case 'object':
      if (customizations.title === undefined) {
        _extend$hexToRgb$isIE8$logStr$colorLuminance.logStr('Missing "title" argument!');
        return false;
      }

      params.title = customizations.title;

      for (var customName in _defaultParams2['default']) {
        params[customName] = argumentOrDefault(customName);
      }

      // Show "Confirm" instead of "OK" if cancel button is visible
      params.confirmButtonText = params.showCancelButton ? 'Confirm' : _defaultParams2['default'].confirmButtonText;
      params.confirmButtonText = argumentOrDefault('confirmButtonText');

      // Callback function when clicking on "OK"/"Cancel"
      params.doneFunction = arguments[1] || null;

      break;

    default:
      _extend$hexToRgb$isIE8$logStr$colorLuminance.logStr('Unexpected type of argument! Expected "string" or "object", got ' + typeof customizations);
      return false;

  }

  _setParameters2['default'](params);
  _sweetAlertInitialize$getModal$getOverlay$getInput$setFocusStyle$openModal$resetInput$fixVerticalPosition.fixVerticalPosition();
  _sweetAlertInitialize$getModal$getOverlay$getInput$setFocusStyle$openModal$resetInput$fixVerticalPosition.openModal(arguments[1]);

  // Modal interactions
  var modal = _sweetAlertInitialize$getModal$getOverlay$getInput$setFocusStyle$openModal$resetInput$fixVerticalPosition.getModal();

  /*
   * Make sure all modal buttons respond to all events
   */
  var $buttons = modal.querySelectorAll('button');
  var buttonEvents = ['onclick', 'onmouseover', 'onmouseout', 'onmousedown', 'onmouseup', 'onfocus'];
  var onButtonEvent = function onButtonEvent(e) {
    return _handleButton$handleConfirm$handleCancel.handleButton(e, params, modal);
  };

  for (var btnIndex = 0; btnIndex < $buttons.length; btnIndex++) {
    for (var evtIndex = 0; evtIndex < buttonEvents.length; evtIndex++) {
      var btnEvt = buttonEvents[evtIndex];
      $buttons[btnIndex][btnEvt] = onButtonEvent;
    }
  }

  // Clicking outside the modal dismisses it (if allowed by user)
  _sweetAlertInitialize$getModal$getOverlay$getInput$setFocusStyle$openModal$resetInput$fixVerticalPosition.getOverlay().onclick = onButtonEvent;

  previousWindowKeyDown = window.onkeydown;

  var onKeyEvent = function onKeyEvent(e) {
    return _handleKeyDown2['default'](e, params, modal);
  };
  window.onkeydown = onKeyEvent;

  window.onfocus = function () {
    // When the user has focused away and focused back from the whole window.
    setTimeout(function () {
      // Put in a timeout to jump out of the event sequence.
      // Calling focus() in the event sequence confuses things.
      if (lastFocusedButton !== undefined) {
        lastFocusedButton.focus();
        lastFocusedButton = undefined;
      }
    }, 0);
  };

  // Show alert with enabled buttons always
  swal.enableButtons();
};

/*
 * Set default params for each popup
 * @param {Object} userParams
 */
sweetAlert.setDefaults = swal.setDefaults = function (userParams) {
  if (!userParams) {
    throw new Error('userParams is required');
  }
  if (typeof userParams !== 'object') {
    throw new Error('userParams has to be a object');
  }

  _extend$hexToRgb$isIE8$logStr$colorLuminance.extend(_defaultParams2['default'], userParams);
};

/*
 * Animation when closing modal
 */
sweetAlert.close = swal.close = function () {
  var modal = _sweetAlertInitialize$getModal$getOverlay$getInput$setFocusStyle$openModal$resetInput$fixVerticalPosition.getModal();

  _hasClass$addClass$removeClass$escapeHtml$_show$show$_hide$hide$isDescendant$getTopMargin$fadeIn$fadeOut$fireClick$stopEventPropagation.fadeOut(_sweetAlertInitialize$getModal$getOverlay$getInput$setFocusStyle$openModal$resetInput$fixVerticalPosition.getOverlay(), 5);
  _hasClass$addClass$removeClass$escapeHtml$_show$show$_hide$hide$isDescendant$getTopMargin$fadeIn$fadeOut$fireClick$stopEventPropagation.fadeOut(modal, 5);
  _hasClass$addClass$removeClass$escapeHtml$_show$show$_hide$hide$isDescendant$getTopMargin$fadeIn$fadeOut$fireClick$stopEventPropagation.removeClass(modal, 'showSweetAlert');
  _hasClass$addClass$removeClass$escapeHtml$_show$show$_hide$hide$isDescendant$getTopMargin$fadeIn$fadeOut$fireClick$stopEventPropagation.addClass(modal, 'hideSweetAlert');
  _hasClass$addClass$removeClass$escapeHtml$_show$show$_hide$hide$isDescendant$getTopMargin$fadeIn$fadeOut$fireClick$stopEventPropagation.removeClass(modal, 'visible');

  /*
   * Reset icon animations
   */
  var $successIcon = modal.querySelector('.sa-icon.sa-success');
  _hasClass$addClass$removeClass$escapeHtml$_show$show$_hide$hide$isDescendant$getTopMargin$fadeIn$fadeOut$fireClick$stopEventPropagation.removeClass($successIcon, 'animate');
  _hasClass$addClass$removeClass$escapeHtml$_show$show$_hide$hide$isDescendant$getTopMargin$fadeIn$fadeOut$fireClick$stopEventPropagation.removeClass($successIcon.querySelector('.sa-tip'), 'animateSuccessTip');
  _hasClass$addClass$removeClass$escapeHtml$_show$show$_hide$hide$isDescendant$getTopMargin$fadeIn$fadeOut$fireClick$stopEventPropagation.removeClass($successIcon.querySelector('.sa-long'), 'animateSuccessLong');

  var $errorIcon = modal.querySelector('.sa-icon.sa-error');
  _hasClass$addClass$removeClass$escapeHtml$_show$show$_hide$hide$isDescendant$getTopMargin$fadeIn$fadeOut$fireClick$stopEventPropagation.removeClass($errorIcon, 'animateErrorIcon');
  _hasClass$addClass$removeClass$escapeHtml$_show$show$_hide$hide$isDescendant$getTopMargin$fadeIn$fadeOut$fireClick$stopEventPropagation.removeClass($errorIcon.querySelector('.sa-x-mark'), 'animateXMark');

  var $warningIcon = modal.querySelector('.sa-icon.sa-warning');
  _hasClass$addClass$removeClass$escapeHtml$_show$show$_hide$hide$isDescendant$getTopMargin$fadeIn$fadeOut$fireClick$stopEventPropagation.removeClass($warningIcon, 'pulseWarning');
  _hasClass$addClass$removeClass$escapeHtml$_show$show$_hide$hide$isDescendant$getTopMargin$fadeIn$fadeOut$fireClick$stopEventPropagation.removeClass($warningIcon.querySelector('.sa-body'), 'pulseWarningIns');
  _hasClass$addClass$removeClass$escapeHtml$_show$show$_hide$hide$isDescendant$getTopMargin$fadeIn$fadeOut$fireClick$stopEventPropagation.removeClass($warningIcon.querySelector('.sa-dot'), 'pulseWarningIns');

  // Reset custom class (delay so that UI changes aren't visible)
  setTimeout(function () {
    var customClass = modal.getAttribute('data-custom-class');
    _hasClass$addClass$removeClass$escapeHtml$_show$show$_hide$hide$isDescendant$getTopMargin$fadeIn$fadeOut$fireClick$stopEventPropagation.removeClass(modal, customClass);
  }, 300);

  // Make page scrollable again
  _hasClass$addClass$removeClass$escapeHtml$_show$show$_hide$hide$isDescendant$getTopMargin$fadeIn$fadeOut$fireClick$stopEventPropagation.removeClass(document.body, 'stop-scrolling');

  // Reset the page to its previous state
  window.onkeydown = previousWindowKeyDown;
  if (window.previousActiveElement) {
    window.previousActiveElement.focus();
  }
  lastFocusedButton = undefined;
  clearTimeout(modal.timeout);

  return true;
};

/*
 * Validation of the input field is done by user
 * If something is wrong => call showInputError with errorMessage
 */
sweetAlert.showInputError = swal.showInputError = function (errorMessage) {
  var modal = _sweetAlertInitialize$getModal$getOverlay$getInput$setFocusStyle$openModal$resetInput$fixVerticalPosition.getModal();

  var $errorIcon = modal.querySelector('.sa-input-error');
  _hasClass$addClass$removeClass$escapeHtml$_show$show$_hide$hide$isDescendant$getTopMargin$fadeIn$fadeOut$fireClick$stopEventPropagation.addClass($errorIcon, 'show');

  var $errorContainer = modal.querySelector('.sa-error-container');
  _hasClass$addClass$removeClass$escapeHtml$_show$show$_hide$hide$isDescendant$getTopMargin$fadeIn$fadeOut$fireClick$stopEventPropagation.addClass($errorContainer, 'show');

  $errorContainer.querySelector('p').innerHTML = errorMessage;

  setTimeout(function () {
    sweetAlert.enableButtons();
  }, 1);

  modal.querySelector('input').focus();
};

/*
 * Reset input error DOM elements
 */
sweetAlert.resetInputError = swal.resetInputError = function (event) {
  // If press enter => ignore
  if (event && event.keyCode === 13) {
    return false;
  }

  var $modal = _sweetAlertInitialize$getModal$getOverlay$getInput$setFocusStyle$openModal$resetInput$fixVerticalPosition.getModal();

  var $errorIcon = $modal.querySelector('.sa-input-error');
  _hasClass$addClass$removeClass$escapeHtml$_show$show$_hide$hide$isDescendant$getTopMargin$fadeIn$fadeOut$fireClick$stopEventPropagation.removeClass($errorIcon, 'show');

  var $errorContainer = $modal.querySelector('.sa-error-container');
  _hasClass$addClass$removeClass$escapeHtml$_show$show$_hide$hide$isDescendant$getTopMargin$fadeIn$fadeOut$fireClick$stopEventPropagation.removeClass($errorContainer, 'show');
};

/*
 * Disable confirm and cancel buttons
 */
sweetAlert.disableButtons = swal.disableButtons = function (event) {
  var modal = _sweetAlertInitialize$getModal$getOverlay$getInput$setFocusStyle$openModal$resetInput$fixVerticalPosition.getModal();
  var $confirmButton = modal.querySelector('button.confirm');
  var $cancelButton = modal.querySelector('button.cancel');
  $confirmButton.disabled = true;
  $cancelButton.disabled = true;
};

/*
 * Enable confirm and cancel buttons
 */
sweetAlert.enableButtons = swal.enableButtons = function (event) {
  var modal = _sweetAlertInitialize$getModal$getOverlay$getInput$setFocusStyle$openModal$resetInput$fixVerticalPosition.getModal();
  var $confirmButton = modal.querySelector('button.confirm');
  var $cancelButton = modal.querySelector('button.cancel');
  $confirmButton.disabled = false;
  $cancelButton.disabled = false;
};

if (typeof window !== 'undefined') {
  // The 'handle-click' module requires
  // that 'sweetAlert' was set as global.
  window.sweetAlert = window.swal = sweetAlert;
} else {
  _extend$hexToRgb$isIE8$logStr$colorLuminance.logStr('SweetAlert is a frontend module!');
}
module.exports = exports['default'];
},{"./modules/default-params":86,"./modules/handle-click":87,"./modules/handle-dom":88,"./modules/handle-key":89,"./modules/handle-swal-dom":90,"./modules/set-params":92,"./modules/utils":93}],95:[function(require,module,exports){
var Vue // late bind
var map = Object.create(null)
var shimmed = false
var isBrowserify = false

/**
 * Determine compatibility and apply patch.
 *
 * @param {Function} vue
 * @param {Boolean} browserify
 */

exports.install = function (vue, browserify) {
  if (shimmed) return
  shimmed = true

  Vue = vue
  isBrowserify = browserify

  exports.compatible = !!Vue.internalDirectives
  if (!exports.compatible) {
    console.warn(
      '[HMR] vue-loader hot reload is only compatible with ' +
      'Vue.js 1.0.0+.'
    )
    return
  }

  // patch view directive
  patchView(Vue.internalDirectives.component)
  console.log('[HMR] Vue component hot reload shim applied.')
  // shim router-view if present
  var routerView = Vue.elementDirective('router-view')
  if (routerView) {
    patchView(routerView)
    console.log('[HMR] vue-router <router-view> hot reload shim applied.')
  }
}

/**
 * Shim the view directive (component or router-view).
 *
 * @param {Object} View
 */

function patchView (View) {
  var unbuild = View.unbuild
  View.unbuild = function (defer) {
    if (!this.hotUpdating) {
      var prevComponent = this.childVM && this.childVM.constructor
      removeView(prevComponent, this)
      // defer = true means we are transitioning to a new
      // Component. Register this new component to the list.
      if (defer) {
        addView(this.Component, this)
      }
    }
    // call original
    return unbuild.call(this, defer)
  }
}

/**
 * Add a component view to a Component's hot list
 *
 * @param {Function} Component
 * @param {Directive} view - view directive instance
 */

function addView (Component, view) {
  var id = Component && Component.options.hotID
  if (id) {
    if (!map[id]) {
      map[id] = {
        Component: Component,
        views: [],
        instances: []
      }
    }
    map[id].views.push(view)
  }
}

/**
 * Remove a component view from a Component's hot list
 *
 * @param {Function} Component
 * @param {Directive} view - view directive instance
 */

function removeView (Component, view) {
  var id = Component && Component.options.hotID
  if (id) {
    map[id].views.$remove(view)
  }
}

/**
 * Create a record for a hot module, which keeps track of its construcotr,
 * instnaces and views (component directives or router-views).
 *
 * @param {String} id
 * @param {Object} options
 */

exports.createRecord = function (id, options) {
  if (typeof options === 'function') {
    options = options.options
  }
  if (typeof options.el !== 'string' && typeof options.data !== 'object') {
    makeOptionsHot(id, options)
    map[id] = {
      Component: null,
      views: [],
      instances: []
    }
  }
}

/**
 * Make a Component options object hot.
 *
 * @param {String} id
 * @param {Object} options
 */

function makeOptionsHot (id, options) {
  options.hotID = id
  injectHook(options, 'created', function () {
    var record = map[id]
    if (!record.Component) {
      record.Component = this.constructor
    }
    record.instances.push(this)
  })
  injectHook(options, 'beforeDestroy', function () {
    map[id].instances.$remove(this)
  })
}

/**
 * Inject a hook to a hot reloadable component so that
 * we can keep track of it.
 *
 * @param {Object} options
 * @param {String} name
 * @param {Function} hook
 */

function injectHook (options, name, hook) {
  var existing = options[name]
  options[name] = existing
    ? Array.isArray(existing)
      ? existing.concat(hook)
      : [existing, hook]
    : [hook]
}

/**
 * Update a hot component.
 *
 * @param {String} id
 * @param {Object|null} newOptions
 * @param {String|null} newTemplate
 */

exports.update = function (id, newOptions, newTemplate) {
  var record = map[id]
  // force full-reload if an instance of the component is active but is not
  // managed by a view
  if (!record || (record.instances.length && !record.views.length)) {
    console.log('[HMR] Root or manually-mounted instance modified. Full reload may be required.')
    if (!isBrowserify) {
      window.location.reload()
    } else {
      // browserify-hmr somehow sends incomplete bundle if we reload here
      return
    }
  }
  if (!isBrowserify) {
    // browserify-hmr already logs this
    console.log('[HMR] Updating component: ' + format(id))
  }
  var Component = record.Component
  // update constructor
  if (newOptions) {
    // in case the user exports a constructor
    Component = record.Component = typeof newOptions === 'function'
      ? newOptions
      : Vue.extend(newOptions)
    makeOptionsHot(id, Component.options)
  }
  if (newTemplate) {
    Component.options.template = newTemplate
  }
  // handle recursive lookup
  if (Component.options.name) {
    Component.options.components[Component.options.name] = Component
  }
  // reset constructor cached linker
  Component.linker = null
  // reload all views
  record.views.forEach(function (view) {
    updateView(view, Component)
  })
  // flush devtools
  if (window.__VUE_DEVTOOLS_GLOBAL_HOOK__) {
    window.__VUE_DEVTOOLS_GLOBAL_HOOK__.emit('flush')
  }
}

/**
 * Update a component view instance
 *
 * @param {Directive} view
 * @param {Function} Component
 */

function updateView (view, Component) {
  if (!view._bound) {
    return
  }
  view.Component = Component
  view.hotUpdating = true
  // disable transitions
  view.vm._isCompiled = false
  // save state
  var state = extractState(view.childVM)
  // remount, make sure to disable keep-alive
  var keepAlive = view.keepAlive
  view.keepAlive = false
  view.mountComponent()
  view.keepAlive = keepAlive
  // restore state
  restoreState(view.childVM, state, true)
  // re-eanble transitions
  view.vm._isCompiled = true
  view.hotUpdating = false
}

/**
 * Extract state from a Vue instance.
 *
 * @param {Vue} vm
 * @return {Object}
 */

function extractState (vm) {
  return {
    cid: vm.constructor.cid,
    data: vm.$data,
    children: vm.$children.map(extractState)
  }
}

/**
 * Restore state to a reloaded Vue instance.
 *
 * @param {Vue} vm
 * @param {Object} state
 */

function restoreState (vm, state, isRoot) {
  var oldAsyncConfig
  if (isRoot) {
    // set Vue into sync mode during state rehydration
    oldAsyncConfig = Vue.config.async
    Vue.config.async = false
  }
  // actual restore
  if (isRoot || !vm._props) {
    vm.$data = state.data
  } else {
    Object.keys(state.data).forEach(function (key) {
      if (!vm._props[key]) {
        // for non-root, only restore non-props fields
        vm.$data[key] = state.data[key]
      }
    })
  }
  // verify child consistency
  var hasSameChildren = vm.$children.every(function (c, i) {
    return state.children[i] && state.children[i].cid === c.constructor.cid
  })
  if (hasSameChildren) {
    // rehydrate children
    vm.$children.forEach(function (c, i) {
      restoreState(c, state.children[i])
    })
  }
  if (isRoot) {
    Vue.config.async = oldAsyncConfig
  }
}

function format (id) {
  var match = id.match(/[^\/]+\.vue$/)
  return match ? match[0] : id
}

},{}],96:[function(require,module,exports){
"use strict";

var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol ? "symbol" : typeof obj; };

!function (t, e) {
  "object" == (typeof exports === "undefined" ? "undefined" : _typeof(exports)) && "object" == (typeof module === "undefined" ? "undefined" : _typeof(module)) ? module.exports = e() : "function" == typeof define && define.amd ? define([], e) : "object" == (typeof exports === "undefined" ? "undefined" : _typeof(exports)) ? exports.VueMultiselect = e() : t.VueMultiselect = e();
}(undefined, function () {
  return function (t) {
    function e(i) {
      if (n[i]) return n[i].exports;var o = n[i] = { exports: {}, id: i, loaded: !1 };return t[i].call(o.exports, o, o.exports, e), o.loaded = !0, o.exports;
    }var n = {};return e.m = t, e.c = n, e.p = "/", e(0);
  }([function (t, e, n) {
    "use strict";
    function i(t) {
      return t && t.__esModule ? t : { "default": t };
    }Object.defineProperty(e, "__esModule", { value: !0 }), e.deepClone = e.pointerMixin = e.multiselectMixin = e.Multiselect = void 0;var o = n(80),
        r = i(o),
        s = n(28),
        l = i(s),
        a = n(29),
        u = i(a),
        c = n(30),
        f = i(c);e["default"] = r["default"], e.Multiselect = r["default"], e.multiselectMixin = l["default"], e.pointerMixin = u["default"], e.deepClone = f["default"];
  }, function (t, e) {
    var n = t.exports = "undefined" != typeof window && window.Math == Math ? window : "undefined" != typeof self && self.Math == Math ? self : Function("return this")();"number" == typeof __g && (__g = n);
  }, function (t, e) {
    var n = {}.hasOwnProperty;t.exports = function (t, e) {
      return n.call(t, e);
    };
  }, function (t, e, n) {
    var i = n(55),
        o = n(15);t.exports = function (t) {
      return i(o(t));
    };
  }, function (t, e, n) {
    t.exports = !n(9)(function () {
      return 7 != Object.defineProperty({}, "a", { get: function get() {
          return 7;
        } }).a;
    });
  }, function (t, e, n) {
    var i = n(6),
        o = n(13);t.exports = n(4) ? function (t, e, n) {
      return i.f(t, e, o(1, n));
    } : function (t, e, n) {
      return t[e] = n, t;
    };
  }, function (t, e, n) {
    var i = n(11),
        o = n(34),
        r = n(25),
        s = Object.defineProperty;e.f = n(4) ? Object.defineProperty : function (t, e, n) {
      if (i(t), e = r(e, !0), i(n), o) try {
        return s(t, e, n);
      } catch (l) {}if ("get" in n || "set" in n) throw TypeError("Accessors not supported!");return "value" in n && (t[e] = n.value), t;
    };
  }, function (t, e, n) {
    var i = n(23)("wks"),
        o = n(14),
        r = n(1).Symbol,
        s = "function" == typeof r,
        l = t.exports = function (t) {
      return i[t] || (i[t] = s && r[t] || (s ? r : o)("Symbol." + t));
    };l.store = i;
  }, function (t, e) {
    var n = t.exports = { version: "2.4.0" };"number" == typeof __e && (__e = n);
  }, function (t, e) {
    t.exports = function (t) {
      try {
        return !!t();
      } catch (e) {
        return !0;
      }
    };
  }, function (t, e, n) {
    var i = n(39),
        o = n(16);t.exports = Object.keys || function (t) {
      return i(t, o);
    };
  }, function (t, e, n) {
    var i = n(12);t.exports = function (t) {
      if (!i(t)) throw TypeError(t + " is not an object!");return t;
    };
  }, function (t, e) {
    t.exports = function (t) {
      return "object" == (typeof t === "undefined" ? "undefined" : _typeof(t)) ? null !== t : "function" == typeof t;
    };
  }, function (t, e) {
    t.exports = function (t, e) {
      return { enumerable: !(1 & t), configurable: !(2 & t), writable: !(4 & t), value: e };
    };
  }, function (t, e) {
    var n = 0,
        i = Math.random();t.exports = function (t) {
      return "Symbol(".concat(void 0 === t ? "" : t, ")_", (++n + i).toString(36));
    };
  }, function (t, e) {
    t.exports = function (t) {
      if (void 0 == t) throw TypeError("Can't call method on  " + t);return t;
    };
  }, function (t, e) {
    t.exports = "constructor,hasOwnProperty,isPrototypeOf,propertyIsEnumerable,toLocaleString,toString,valueOf".split(",");
  }, function (t, e, n) {
    var i = n(1),
        o = n(8),
        r = n(52),
        s = n(5),
        l = "prototype",
        a = function a(t, e, n) {
      var u,
          c,
          f,
          p = t & a.F,
          d = t & a.G,
          h = t & a.S,
          m = t & a.P,
          v = t & a.B,
          b = t & a.W,
          g = d ? o : o[e] || (o[e] = {}),
          y = g[l],
          x = d ? i : h ? i[e] : (i[e] || {})[l];d && (n = e);for (u in n) {
        c = !p && x && void 0 !== x[u], c && u in g || (f = c ? x[u] : n[u], g[u] = d && "function" != typeof x[u] ? n[u] : v && c ? r(f, i) : b && x[u] == f ? function (t) {
          var e = function e(_e, n, i) {
            if (this instanceof t) {
              switch (arguments.length) {case 0:
                  return new t();case 1:
                  return new t(_e);case 2:
                  return new t(_e, n);}return new t(_e, n, i);
            }return t.apply(this, arguments);
          };return e[l] = t[l], e;
        }(f) : m && "function" == typeof f ? r(Function.call, f) : f, m && ((g.virtual || (g.virtual = {}))[u] = f, t & a.R && y && !y[u] && s(y, u, f)));
      }
    };a.F = 1, a.G = 2, a.S = 4, a.P = 8, a.B = 16, a.W = 32, a.U = 64, a.R = 128, t.exports = a;
  }, function (t, e) {
    t.exports = {};
  }, function (t, e) {
    t.exports = !0;
  }, function (t, e) {
    e.f = {}.propertyIsEnumerable;
  }, function (t, e, n) {
    var i = n(6).f,
        o = n(2),
        r = n(7)("toStringTag");t.exports = function (t, e, n) {
      t && !o(t = n ? t : t.prototype, r) && i(t, r, { configurable: !0, value: e });
    };
  }, function (t, e, n) {
    var i = n(23)("keys"),
        o = n(14);t.exports = function (t) {
      return i[t] || (i[t] = o(t));
    };
  }, function (t, e, n) {
    var i = n(1),
        o = "__core-js_shared__",
        r = i[o] || (i[o] = {});t.exports = function (t) {
      return r[t] || (r[t] = {});
    };
  }, function (t, e) {
    var n = Math.ceil,
        i = Math.floor;t.exports = function (t) {
      return isNaN(t = +t) ? 0 : (t > 0 ? i : n)(t);
    };
  }, function (t, e, n) {
    var i = n(12);t.exports = function (t, e) {
      if (!i(t)) return t;var n, o;if (e && "function" == typeof (n = t.toString) && !i(o = n.call(t))) return o;if ("function" == typeof (n = t.valueOf) && !i(o = n.call(t))) return o;if (!e && "function" == typeof (n = t.toString) && !i(o = n.call(t))) return o;throw TypeError("Can't convert object to primitive value");
    };
  }, function (t, e, n) {
    var i = n(1),
        o = n(8),
        r = n(19),
        s = n(27),
        l = n(6).f;t.exports = function (t) {
      var e = o.Symbol || (o.Symbol = r ? {} : i.Symbol || {});"_" == t.charAt(0) || t in e || l(e, t, { value: s.f(t) });
    };
  }, function (t, e, n) {
    e.f = n(7);
  }, function (t, e, n) {
    "use strict";
    function i(t) {
      return t && t.__esModule ? t : { "default": t };
    }var o = n(31),
        r = i(o),
        s = n(30),
        l = i(s);t.exports = { data: function data() {
        return { search: "", isOpen: !1, value: this.selected ? (0, l["default"])(this.selected) : this.multiple ? [] : null };
      }, props: { localSearch: { type: Boolean, "default": !0 }, options: { type: Array, required: !0 }, multiple: { type: Boolean, "default": !1 }, selected: {}, key: { type: String, "default": !1 }, label: { type: String, "default": !1 }, searchable: { type: Boolean, "default": !0 }, clearOnSelect: { type: Boolean, "default": !0 }, hideSelected: { type: Boolean, "default": !1 }, placeholder: { type: String, "default": "Select option" }, maxHeight: { type: Number, "default": 300 }, allowEmpty: { type: Boolean, "default": !0 }, resetAfter: { type: Boolean, "default": !1 }, closeOnSelect: { type: Boolean, "default": !0 }, customLabel: { type: Function, "default": !1 }, taggable: { type: Boolean, "default": !1 }, tagPlaceholder: { type: String, "default": "Press enter to create a tag" }, max: { type: Number, "default": !1 }, id: { "default": null } }, created: function created() {
        this.searchable && this.adjustSearch();
      }, computed: { filteredOptions: function filteredOptions() {
          var t = this.search || "",
              e = this.hideSelected ? this.options.filter(this.isNotSelected) : this.options;return this.localSearch && (e = this.$options.filters.filterBy(e, this.search)), this.taggable && t.length && !this.isExistingOption(t) && e.unshift({ isTag: !0, label: t }), e;
        }, valueKeys: function valueKeys() {
          var t = this;return this.key ? this.multiple ? this.value.map(function (e) {
            return e[t.key];
          }) : this.value[this.key] : this.value;
        }, optionKeys: function optionKeys() {
          var t = this;return this.label ? this.options.map(function (e) {
            return e[t.label];
          }) : this.options;
        }, currentOptionLabel: function currentOptionLabel() {
          return this.getOptionLabel(this.value);
        } }, watch: { value: function value() {
          this.resetAfter && (this.$set("value", null), this.$set("search", null), this.$set("selected", null)), this.adjustSearch();
        }, search: function search() {
          this.search !== this.currentOptionLabel && this.$emit("search-change", this.search, this.id);
        }, selected: function selected(t, e) {
          this.value = (0, l["default"])(this.selected);
        } }, methods: { isExistingOption: function isExistingOption(t) {
          return this.options ? this.optionKeys.indexOf(t) > -1 : !1;
        }, isSelected: function isSelected(t) {
          if (!this.value) return !1;var e = this.key ? t[this.key] : t;return this.multiple ? this.valueKeys.indexOf(e) > -1 : this.valueKeys === e;
        }, isNotSelected: function isNotSelected(t) {
          return !this.isSelected(t);
        }, getOptionLabel: function getOptionLabel(t) {
          return "object" !== ("undefined" == typeof t ? "undefined" : (0, r["default"])(t)) || null === t ? t : this.customLabel ? this.customLabel(t) : this.label && t[this.label] ? t[this.label] : t.label ? t.label : void 0;
        }, select: function select(t) {
          if (!this.max || !this.multiple || this.value.length !== this.max) if (t.isTag) this.$emit("tag", t.label, this.id), this.search = "";else {
            if (this.multiple) this.isNotSelected(t) ? (this.value.push(t), this.$emit("select", (0, l["default"])(t), this.id), this.$emit("update", (0, l["default"])(this.value), this.id)) : this.removeElement(t);else {
              var e = this.isSelected(t);if (e && !this.allowEmpty) return;this.value = e ? null : t, this.$emit("select", (0, l["default"])(t), this.id), this.$emit("update", (0, l["default"])(this.value), this.id);
            }this.closeOnSelect && this.deactivate();
          }
        }, removeElement: function removeElement(t) {
          if (this.allowEmpty || !(this.value.length <= 1)) {
            if (this.multiple && "object" === ("undefined" == typeof t ? "undefined" : (0, r["default"])(t))) {
              var e = this.valueKeys.indexOf(t[this.key]);this.value.splice(e, 1);
            } else this.value.$remove(t);this.$emit("remove", (0, l["default"])(t), this.id), this.$emit("update", (0, l["default"])(this.value), this.id);
          }
        }, removeLastElement: function removeLastElement() {
          0 === this.search.length && Array.isArray(this.value) && this.removeElement(this.value[this.value.length - 1]);
        }, activate: function activate() {
          this.isOpen || (this.isOpen = !0, this.searchable ? (this.search = "", this.$els.search.focus()) : this.$el.focus(), this.$emit("open", this.id));
        }, deactivate: function deactivate() {
          this.isOpen && (this.isOpen = !1, this.searchable ? (this.$els.search.blur(), this.adjustSearch()) : this.$el.blur(), this.$emit("close", (0, l["default"])(this.value), this.id));
        }, adjustSearch: function adjustSearch() {
          this.searchable && this.clearOnSelect && (this.search = this.multiple ? "" : this.currentOptionLabel);
        }, toggle: function toggle() {
          this.isOpen ? this.deactivate() : this.activate();
        } } };
  }, function (t, e) {
    "use strict";
    t.exports = { data: function data() {
        return { pointer: 0, visibleElements: this.maxHeight / this.optionHeight };
      }, props: { showPointer: { type: Boolean, "default": !0 }, optionHeight: { type: Number, "default": 40 } }, computed: { pointerPosition: function pointerPosition() {
          return this.pointer * this.optionHeight;
        } }, watch: { filteredOptions: function filteredOptions() {
          this.pointerAdjust();
        } }, methods: { addPointerElement: function addPointerElement() {
          this.filteredOptions.length > 0 && this.select(this.filteredOptions[this.pointer]), this.pointerReset();
        }, pointerForward: function pointerForward() {
          this.pointer < this.filteredOptions.length - 1 && (this.pointer++, this.$els.list.scrollTop <= this.pointerPosition - this.visibleElements * this.optionHeight && (this.$els.list.scrollTop = this.pointerPosition - (this.visibleElements - 1) * this.optionHeight));
        }, pointerBackward: function pointerBackward() {
          this.pointer > 0 && (this.pointer--, this.$els.list.scrollTop >= this.pointerPosition && (this.$els.list.scrollTop = this.pointerPosition));
        }, pointerReset: function pointerReset() {
          this.closeOnSelect && (this.pointer = 0, this.$els.list && (this.$els.list.scrollTop = 0));
        }, pointerAdjust: function pointerAdjust() {
          this.pointer >= this.filteredOptions.length - 1 && (this.pointer = this.filteredOptions.length ? this.filteredOptions.length - 1 : 0);
        }, pointerSet: function pointerSet(t) {
          this.pointer = t;
        } } };
  }, function (t, e, n) {
    "use strict";
    function i(t) {
      return t && t.__esModule ? t : { "default": t };
    }var o = n(43),
        r = i(o),
        s = n(31),
        l = i(s),
        a = function u(t) {
      if (Array.isArray(t)) return t.map(u);if (t && "object" === ("undefined" == typeof t ? "undefined" : (0, l["default"])(t))) {
        for (var e = {}, n = (0, r["default"])(t), i = 0, o = n.length; o > i; i++) {
          var s = n[i];e[s] = u(t[s]);
        }return e;
      }return t;
    };t.exports = a;
  }, function (t, e, n) {
    "use strict";
    function i(t) {
      return t && t.__esModule ? t : { "default": t };
    }e.__esModule = !0;var o = n(45),
        r = i(o),
        s = n(44),
        l = i(s),
        a = "function" == typeof l["default"] && "symbol" == _typeof(r["default"]) ? function (t) {
      return typeof t === "undefined" ? "undefined" : _typeof(t);
    } : function (t) {
      return t && "function" == typeof l["default"] && t.constructor === l["default"] ? "symbol" : typeof t === "undefined" ? "undefined" : _typeof(t);
    };e["default"] = "function" == typeof l["default"] && "symbol" === a(r["default"]) ? function (t) {
      return "undefined" == typeof t ? "undefined" : a(t);
    } : function (t) {
      return t && "function" == typeof l["default"] && t.constructor === l["default"] ? "symbol" : "undefined" == typeof t ? "undefined" : a(t);
    };
  }, function (t, e) {
    var n = {}.toString;t.exports = function (t) {
      return n.call(t).slice(8, -1);
    };
  }, function (t, e, n) {
    var i = n(12),
        o = n(1).document,
        r = i(o) && i(o.createElement);t.exports = function (t) {
      return r ? o.createElement(t) : {};
    };
  }, function (t, e, n) {
    t.exports = !n(4) && !n(9)(function () {
      return 7 != Object.defineProperty(n(33)("div"), "a", { get: function get() {
          return 7;
        } }).a;
    });
  }, function (t, e, n) {
    "use strict";
    var i = n(19),
        o = n(17),
        r = n(40),
        s = n(5),
        l = n(2),
        a = n(18),
        u = n(57),
        c = n(21),
        f = n(64),
        p = n(7)("iterator"),
        d = !([].keys && "next" in [].keys()),
        h = "@@iterator",
        m = "keys",
        v = "values",
        b = function b() {
      return this;
    };t.exports = function (t, e, n, g, y, x, _) {
      u(n, e, g);var w,
          O,
          S,
          k = function k(t) {
        if (!d && t in M) return M[t];switch (t) {case m:
            return function () {
              return new n(this, t);
            };case v:
            return function () {
              return new n(this, t);
            };}return function () {
          return new n(this, t);
        };
      },
          j = e + " Iterator",
          E = y == v,
          P = !1,
          M = t.prototype,
          L = M[p] || M[h] || y && M[y],
          A = L || k(y),
          T = y ? E ? k("entries") : A : void 0,
          $ = "Array" == e ? M.entries || L : L;if ($ && (S = f($.call(new t())), S !== Object.prototype && (c(S, j, !0), i || l(S, p) || s(S, p, b))), E && L && L.name !== v && (P = !0, A = function A() {
        return L.call(this);
      }), i && !_ || !d && !P && M[p] || s(M, p, A), a[e] = A, a[j] = b, y) if (w = { values: E ? A : k(v), keys: x ? A : k(m), entries: T }, _) for (O in w) {
        O in M || r(M, O, w[O]);
      } else o(o.P + o.F * (d || P), e, w);return w;
    };
  }, function (t, e, n) {
    var i = n(11),
        o = n(61),
        r = n(16),
        s = n(22)("IE_PROTO"),
        l = function l() {},
        a = "prototype",
        _u = function u() {
      var t,
          e = n(33)("iframe"),
          i = r.length,
          o = ">";for (e.style.display = "none", n(54).appendChild(e), e.src = "javascript:", t = e.contentWindow.document, t.open(), t.write("<script>document.F=Object</script" + o), t.close(), _u = t.F; i--;) {
        delete _u[a][r[i]];
      }return _u();
    };t.exports = Object.create || function (t, e) {
      var n;return null !== t ? (l[a] = i(t), n = new l(), l[a] = null, n[s] = t) : n = _u(), void 0 === e ? n : o(n, e);
    };
  }, function (t, e, n) {
    var i = n(39),
        o = n(16).concat("length", "prototype");e.f = Object.getOwnPropertyNames || function (t) {
      return i(t, o);
    };
  }, function (t, e) {
    e.f = Object.getOwnPropertySymbols;
  }, function (t, e, n) {
    var i = n(2),
        o = n(3),
        r = n(51)(!1),
        s = n(22)("IE_PROTO");t.exports = function (t, e) {
      var n,
          l = o(t),
          a = 0,
          u = [];for (n in l) {
        n != s && i(l, n) && u.push(n);
      }for (; e.length > a;) {
        i(l, n = e[a++]) && (~r(u, n) || u.push(n));
      }return u;
    };
  }, function (t, e, n) {
    t.exports = n(5);
  }, function (t, e, n) {
    var i = n(15);t.exports = function (t) {
      return Object(i(t));
    };
  }, function (t, e, n) {
    "use strict";
    function i(t) {
      return t && t.__esModule ? t : { "default": t };
    }Object.defineProperty(e, "__esModule", { value: !0 });var o = n(28),
        r = i(o),
        s = n(29),
        l = i(s);e["default"] = { mixins: [r["default"], l["default"]], props: { optionPartial: { type: String, "default": "" }, selectLabel: { type: String, "default": "Press enter to select" }, selectedLabel: { type: String, "default": "Selected" }, deselectLabel: { type: String, "default": "Press enter to remove" }, showLabels: { type: Boolean, "default": !0 }, limit: { type: Number, "default": 99999 }, limitText: { type: Function, "default": function _default(t) {
            return "and " + t + " more";
          } }, loading: { type: Boolean, "default": !1 }, disabled: { type: Boolean, "default": !1 } }, computed: { visibleValue: function visibleValue() {
          return this.multiple ? this.value.slice(0, this.limit) : this.value;
        } }, ready: function ready() {
        this.showLabels || (this.deselectLabel = this.selectedLabel = this.selectLabel = "");
      } };
  }, function (t, e, n) {
    t.exports = { "default": n(46), __esModule: !0 };
  }, function (t, e, n) {
    t.exports = { "default": n(47), __esModule: !0 };
  }, function (t, e, n) {
    t.exports = { "default": n(48), __esModule: !0 };
  }, function (t, e, n) {
    n(70), t.exports = n(8).Object.keys;
  }, function (t, e, n) {
    n(73), n(71), n(74), n(75), t.exports = n(8).Symbol;
  }, function (t, e, n) {
    n(72), n(76), t.exports = n(27).f("iterator");
  }, function (t, e) {
    t.exports = function (t) {
      if ("function" != typeof t) throw TypeError(t + " is not a function!");return t;
    };
  }, function (t, e) {
    t.exports = function () {};
  }, function (t, e, n) {
    var i = n(3),
        o = n(68),
        r = n(67);t.exports = function (t) {
      return function (e, n, s) {
        var l,
            a = i(e),
            u = o(a.length),
            c = r(s, u);if (t && n != n) {
          for (; u > c;) {
            if (l = a[c++], l != l) return !0;
          }
        } else for (; u > c; c++) {
          if ((t || c in a) && a[c] === n) return t || c || 0;
        }return !t && -1;
      };
    };
  }, function (t, e, n) {
    var i = n(49);t.exports = function (t, e, n) {
      if (i(t), void 0 === e) return t;switch (n) {case 1:
          return function (n) {
            return t.call(e, n);
          };case 2:
          return function (n, i) {
            return t.call(e, n, i);
          };case 3:
          return function (n, i, o) {
            return t.call(e, n, i, o);
          };}return function () {
        return t.apply(e, arguments);
      };
    };
  }, function (t, e, n) {
    var i = n(10),
        o = n(38),
        r = n(20);t.exports = function (t) {
      var e = i(t),
          n = o.f;if (n) for (var s, l = n(t), a = r.f, u = 0; l.length > u;) {
        a.call(t, s = l[u++]) && e.push(s);
      }return e;
    };
  }, function (t, e, n) {
    t.exports = n(1).document && document.documentElement;
  }, function (t, e, n) {
    var i = n(32);t.exports = Object("z").propertyIsEnumerable(0) ? Object : function (t) {
      return "String" == i(t) ? t.split("") : Object(t);
    };
  }, function (t, e, n) {
    var i = n(32);t.exports = Array.isArray || function (t) {
      return "Array" == i(t);
    };
  }, function (t, e, n) {
    "use strict";
    var i = n(36),
        o = n(13),
        r = n(21),
        s = {};n(5)(s, n(7)("iterator"), function () {
      return this;
    }), t.exports = function (t, e, n) {
      t.prototype = i(s, { next: o(1, n) }), r(t, e + " Iterator");
    };
  }, function (t, e) {
    t.exports = function (t, e) {
      return { value: e, done: !!t };
    };
  }, function (t, e, n) {
    var i = n(10),
        o = n(3);t.exports = function (t, e) {
      for (var n, r = o(t), s = i(r), l = s.length, a = 0; l > a;) {
        if (r[n = s[a++]] === e) return n;
      }
    };
  }, function (t, e, n) {
    var i = n(14)("meta"),
        o = n(12),
        r = n(2),
        s = n(6).f,
        l = 0,
        a = Object.isExtensible || function () {
      return !0;
    },
        u = !n(9)(function () {
      return a(Object.preventExtensions({}));
    }),
        c = function c(t) {
      s(t, i, { value: { i: "O" + ++l, w: {} } });
    },
        f = function f(t, e) {
      if (!o(t)) return "symbol" == (typeof t === "undefined" ? "undefined" : _typeof(t)) ? t : ("string" == typeof t ? "S" : "P") + t;if (!r(t, i)) {
        if (!a(t)) return "F";if (!e) return "E";c(t);
      }return t[i].i;
    },
        p = function p(t, e) {
      if (!r(t, i)) {
        if (!a(t)) return !0;if (!e) return !1;c(t);
      }return t[i].w;
    },
        d = function d(t) {
      return u && h.NEED && a(t) && !r(t, i) && c(t), t;
    },
        h = t.exports = { KEY: i, NEED: !1, fastKey: f, getWeak: p, onFreeze: d };
  }, function (t, e, n) {
    var i = n(6),
        o = n(11),
        r = n(10);t.exports = n(4) ? Object.defineProperties : function (t, e) {
      o(t);for (var n, s = r(e), l = s.length, a = 0; l > a;) {
        i.f(t, n = s[a++], e[n]);
      }return t;
    };
  }, function (t, e, n) {
    var i = n(20),
        o = n(13),
        r = n(3),
        s = n(25),
        l = n(2),
        a = n(34),
        u = Object.getOwnPropertyDescriptor;e.f = n(4) ? u : function (t, e) {
      if (t = r(t), e = s(e, !0), a) try {
        return u(t, e);
      } catch (n) {}return l(t, e) ? o(!i.f.call(t, e), t[e]) : void 0;
    };
  }, function (t, e, n) {
    var i = n(3),
        o = n(37).f,
        r = {}.toString,
        s = "object" == (typeof window === "undefined" ? "undefined" : _typeof(window)) && window && Object.getOwnPropertyNames ? Object.getOwnPropertyNames(window) : [],
        l = function l(t) {
      try {
        return o(t);
      } catch (e) {
        return s.slice();
      }
    };t.exports.f = function (t) {
      return s && "[object Window]" == r.call(t) ? l(t) : o(i(t));
    };
  }, function (t, e, n) {
    var i = n(2),
        o = n(41),
        r = n(22)("IE_PROTO"),
        s = Object.prototype;t.exports = Object.getPrototypeOf || function (t) {
      return t = o(t), i(t, r) ? t[r] : "function" == typeof t.constructor && t instanceof t.constructor ? t.constructor.prototype : t instanceof Object ? s : null;
    };
  }, function (t, e, n) {
    var i = n(17),
        o = n(8),
        r = n(9);t.exports = function (t, e) {
      var n = (o.Object || {})[t] || Object[t],
          s = {};s[t] = e(n), i(i.S + i.F * r(function () {
        n(1);
      }), "Object", s);
    };
  }, function (t, e, n) {
    var i = n(24),
        o = n(15);t.exports = function (t) {
      return function (e, n) {
        var r,
            s,
            l = String(o(e)),
            a = i(n),
            u = l.length;return 0 > a || a >= u ? t ? "" : void 0 : (r = l.charCodeAt(a), 55296 > r || r > 56319 || a + 1 === u || (s = l.charCodeAt(a + 1)) < 56320 || s > 57343 ? t ? l.charAt(a) : r : t ? l.slice(a, a + 2) : (r - 55296 << 10) + (s - 56320) + 65536);
      };
    };
  }, function (t, e, n) {
    var i = n(24),
        o = Math.max,
        r = Math.min;t.exports = function (t, e) {
      return t = i(t), 0 > t ? o(t + e, 0) : r(t, e);
    };
  }, function (t, e, n) {
    var i = n(24),
        o = Math.min;t.exports = function (t) {
      return t > 0 ? o(i(t), 9007199254740991) : 0;
    };
  }, function (t, e, n) {
    "use strict";
    var i = n(50),
        o = n(58),
        r = n(18),
        s = n(3);t.exports = n(35)(Array, "Array", function (t, e) {
      this._t = s(t), this._i = 0, this._k = e;
    }, function () {
      var t = this._t,
          e = this._k,
          n = this._i++;return !t || n >= t.length ? (this._t = void 0, o(1)) : "keys" == e ? o(0, n) : "values" == e ? o(0, t[n]) : o(0, [n, t[n]]);
    }, "values"), r.Arguments = r.Array, i("keys"), i("values"), i("entries");
  }, function (t, e, n) {
    var i = n(41),
        o = n(10);n(65)("keys", function () {
      return function (t) {
        return o(i(t));
      };
    });
  }, function (t, e) {}, function (t, e, n) {
    "use strict";
    var i = n(66)(!0);n(35)(String, "String", function (t) {
      this._t = String(t), this._i = 0;
    }, function () {
      var t,
          e = this._t,
          n = this._i;return n >= e.length ? { value: void 0, done: !0 } : (t = i(e, n), this._i += t.length, { value: t, done: !1 });
    });
  }, function (t, e, n) {
    "use strict";
    var i = n(1),
        o = n(2),
        r = n(4),
        s = n(17),
        l = n(40),
        a = n(60).KEY,
        u = n(9),
        c = n(23),
        f = n(21),
        p = n(14),
        d = n(7),
        h = n(27),
        m = n(26),
        v = n(59),
        b = n(53),
        g = n(56),
        y = n(11),
        x = n(3),
        _ = n(25),
        w = n(13),
        O = n(36),
        S = n(63),
        k = n(62),
        j = n(6),
        E = n(10),
        P = k.f,
        M = j.f,
        L = S.f,
        _A = i.Symbol,
        T = i.JSON,
        $ = T && T.stringify,
        N = "prototype",
        B = d("_hidden"),
        C = d("toPrimitive"),
        F = {}.propertyIsEnumerable,
        z = c("symbol-registry"),
        I = c("symbols"),
        R = c("op-symbols"),
        H = Object[N],
        K = "function" == typeof _A,
        D = i.QObject,
        W = !D || !D[N] || !D[N].findChild,
        J = r && u(function () {
      return 7 != O(M({}, "a", { get: function get() {
          return M(this, "a", { value: 7 }).a;
        } })).a;
    }) ? function (t, e, n) {
      var i = P(H, e);i && delete H[e], M(t, e, n), i && t !== H && M(H, e, i);
    } : M,
        U = function U(t) {
      var e = I[t] = O(_A[N]);return e._k = t, e;
    },
        V = K && "symbol" == _typeof(_A.iterator) ? function (t) {
      return "symbol" == (typeof t === "undefined" ? "undefined" : _typeof(t));
    } : function (t) {
      return t instanceof _A;
    },
        G = function G(t, e, n) {
      return t === H && G(R, e, n), y(t), e = _(e, !0), y(n), o(I, e) ? (n.enumerable ? (o(t, B) && t[B][e] && (t[B][e] = !1), n = O(n, { enumerable: w(0, !1) })) : (o(t, B) || M(t, B, w(1, {})), t[B][e] = !0), J(t, e, n)) : M(t, e, n);
    },
        q = function q(t, e) {
      y(t);for (var n, i = b(e = x(e)), o = 0, r = i.length; r > o;) {
        G(t, n = i[o++], e[n]);
      }return t;
    },
        Y = function Y(t, e) {
      return void 0 === e ? O(t) : q(O(t), e);
    },
        Q = function Q(t) {
      var e = F.call(this, t = _(t, !0));return this === H && o(I, t) && !o(R, t) ? !1 : e || !o(this, t) || !o(I, t) || o(this, B) && this[B][t] ? e : !0;
    },
        X = function X(t, e) {
      if (t = x(t), e = _(e, !0), t !== H || !o(I, e) || o(R, e)) {
        var n = P(t, e);return !n || !o(I, e) || o(t, B) && t[B][e] || (n.enumerable = !0), n;
      }
    },
        Z = function Z(t) {
      for (var e, n = L(x(t)), i = [], r = 0; n.length > r;) {
        o(I, e = n[r++]) || e == B || e == a || i.push(e);
      }return i;
    },
        tt = function tt(t) {
      for (var e, n = t === H, i = L(n ? R : x(t)), r = [], s = 0; i.length > s;) {
        o(I, e = i[s++]) && (n ? o(H, e) : !0) && r.push(I[e]);
      }return r;
    };K || (_A = function A() {
      if (this instanceof _A) throw TypeError("Symbol is not a constructor!");var t = p(arguments.length > 0 ? arguments[0] : void 0),
          e = function e(n) {
        this === H && e.call(R, n), o(this, B) && o(this[B], t) && (this[B][t] = !1), J(this, t, w(1, n));
      };return r && W && J(H, t, { configurable: !0, set: e }), U(t);
    }, l(_A[N], "toString", function () {
      return this._k;
    }), k.f = X, j.f = G, n(37).f = S.f = Z, n(20).f = Q, n(38).f = tt, r && !n(19) && l(H, "propertyIsEnumerable", Q, !0), h.f = function (t) {
      return U(d(t));
    }), s(s.G + s.W + s.F * !K, { Symbol: _A });for (var et = "hasInstance,isConcatSpreadable,iterator,match,replace,search,species,split,toPrimitive,toStringTag,unscopables".split(","), nt = 0; et.length > nt;) {
      d(et[nt++]);
    }for (var et = E(d.store), nt = 0; et.length > nt;) {
      m(et[nt++]);
    }s(s.S + s.F * !K, "Symbol", { "for": function _for(t) {
        return o(z, t += "") ? z[t] : z[t] = _A(t);
      }, keyFor: function keyFor(t) {
        if (V(t)) return v(z, t);throw TypeError(t + " is not a symbol!");
      }, useSetter: function useSetter() {
        W = !0;
      }, useSimple: function useSimple() {
        W = !1;
      } }), s(s.S + s.F * !K, "Object", { create: Y, defineProperty: G, defineProperties: q, getOwnPropertyDescriptor: X, getOwnPropertyNames: Z, getOwnPropertySymbols: tt }), T && s(s.S + s.F * (!K || u(function () {
      var t = _A();return "[null]" != $([t]) || "{}" != $({ a: t }) || "{}" != $(Object(t));
    })), "JSON", { stringify: function stringify(t) {
        if (void 0 !== t && !V(t)) {
          for (var e, n, i = [t], o = 1; arguments.length > o;) {
            i.push(arguments[o++]);
          }return e = i[1], "function" == typeof e && (n = e), !n && g(e) || (e = function e(t, _e2) {
            return n && (_e2 = n.call(this, t, _e2)), V(_e2) ? void 0 : _e2;
          }), i[1] = e, $.apply(T, i);
        }
      } }), _A[N][C] || n(5)(_A[N], C, _A[N].valueOf), f(_A, "Symbol"), f(Math, "Math", !0), f(i.JSON, "JSON", !0);
  }, function (t, e, n) {
    n(26)("asyncIterator");
  }, function (t, e, n) {
    n(26)("observable");
  }, function (t, e, n) {
    n(69);for (var i = n(1), o = n(5), r = n(18), s = n(7)("toStringTag"), l = ["NodeList", "DOMTokenList", "MediaList", "StyleSheetList", "CSSRuleList"], a = 0; 5 > a; a++) {
      var u = l[a],
          c = i[u],
          f = c && c.prototype;f && !f[s] && o(f, s, u), r[u] = r.Array;
    }
  }, function (t, e, n) {
    e = t.exports = n(78)(), e.push([t.id, 'fieldset[disabled] .multiselect{pointer-events:none}.multiselect__spinner{position:absolute;right:1px;top:1px;width:48px;height:35px;background:#fff;display:block}.multiselect__spinner:after,.multiselect__spinner:before{position:absolute;content:"";top:50%;left:50%;margin:-8px 0 0 -8px;width:16px;height:16px;border-radius:100%;border-color:#41b883 transparent transparent;border-style:solid;border-width:2px;box-shadow:0 0 0 1px transparent}.multiselect__spinner:before{-webkit-animation:spinning 2.4s cubic-bezier(.41,.26,.2,.62);animation:spinning 2.4s cubic-bezier(.41,.26,.2,.62);-webkit-animation-iteration-count:infinite;animation-iteration-count:infinite}.multiselect__spinner:after{-webkit-animation:spinning 2.4s cubic-bezier(.51,.09,.21,.8);animation:spinning 2.4s cubic-bezier(.51,.09,.21,.8);-webkit-animation-iteration-count:infinite;animation-iteration-count:infinite}.multiselect__loading-transition{-webkit-transition:opacity .4s ease-in-out;transition:opacity .4s ease-in-out;opacity:1}.multiselect__loading-enter,.multiselect__loading-leave{opacity:0}.multiselect,.multiselect__input,.multiselect__single{font-family:inherit;font-size:14px}.multiselect{box-sizing:content-box;display:block;position:relative;width:100%;min-height:40px;text-align:left;color:#35495e}.multiselect *{box-sizing:border-box}.multiselect:focus{outline:none}.multiselect--disabled{pointer-events:none;opacity:.6}.multiselect--active{z-index:50}.multiselect--active .multiselect__current,.multiselect--active .multiselect__input,.multiselect--active .multiselect__tags{border-bottom-left-radius:0;border-bottom-right-radius:0}.multiselect--active .multiselect__select{-webkit-transform:rotate(180deg);transform:rotate(180deg)}.multiselect__input,.multiselect__single{position:relative;display:inline-block;min-height:20px;line-height:20px;border:none;border-radius:5px;background:#fff;padding:1px 0 0 5px;width:100%;-webkit-transition:border .1s ease;transition:border .1s ease;box-sizing:border-box;margin-bottom:8px}.multiselect__tag~.multiselect__input{width:auto}.multiselect__input:hover,.multiselect__single:hover{border-color:#cfcfcf}.multiselect__input:focus,.multiselect__single:focus{border-color:#a8a8a8;outline:none}.multiselect__single{padding-left:6px;margin-bottom:8px}.multiselect__tags{min-height:40px;display:block;padding:8px 40px 0 8px;border-radius:5px;border:1px solid #e8e8e8;background:#fff}.multiselect__tag{position:relative;display:inline-block;padding:4px 26px 4px 10px;border-radius:5px;margin-right:10px;color:#fff;line-height:1;background:#41b883;margin-bottom:8px;white-space:nowrap}.multiselect__tag-icon{cursor:pointer;margin-left:7px;position:absolute;right:0;top:0;bottom:0;font-weight:700;font-style:initial;width:22px;text-align:center;line-height:22px;-webkit-transition:all .2s ease;transition:all .2s ease;border-radius:5px}.multiselect__tag-icon:after{content:"\\D7";color:#266d4d;font-size:14px}.multiselect__tag-icon:focus,.multiselect__tag-icon:hover{background:#369a6e}.multiselect__tag-icon:focus:after,.multiselect__tag-icon:hover:after{color:#fff}.multiselect__current{min-height:40px;overflow:hidden;padding:8px 12px 0;padding-right:30px;white-space:nowrap;border-radius:5px;border:1px solid #e8e8e8}.multiselect__current,.multiselect__select{line-height:16px;box-sizing:border-box;display:block;margin:0;text-decoration:none;cursor:pointer}.multiselect__select{position:absolute;width:40px;height:38px;right:1px;top:1px;padding:4px 8px;text-align:center;-webkit-transition:-webkit-transform .2s ease;transition:-webkit-transform .2s ease;transition:transform .2s ease;transition:transform .2s ease,-webkit-transform .2s ease}.multiselect__select:before{position:relative;right:0;top:65%;color:#999;margin-top:4px;border-style:solid;border-width:5px 5px 0;border-color:#999 transparent transparent;content:""}.multiselect__placeholder{color:#adadad;display:inline-block;margin-bottom:10px;padding-top:2px}.multiselect--active .multiselect__placeholder{display:none}.multiselect__content{position:absolute;list-style:none;display:block;background:#fff;width:100%;max-height:240px;overflow:auto;padding:0;margin:0;border:1px solid #e8e8e8;border-top:none;border-bottom-left-radius:5px;border-bottom-right-radius:5px;z-index:50}.multiselect__content::webkit-scrollbar{display:none}.multiselect__option{display:block;padding:12px;min-height:40px;line-height:16px;text-decoration:none;text-transform:none;vertical-align:middle;position:relative;cursor:pointer;white-space:nowrap}.multiselect__option:after{top:0;right:0;position:absolute;line-height:40px;padding-right:12px;padding-left:20px}.multiselect__option--highlight{background:#41b883;outline:none;color:#fff}.multiselect__option--highlight:after{content:attr(data-select);background:#41b883;color:#fff}.multiselect__option--selected{background:#f3f3f3;color:#35495e;font-weight:700}.multiselect__option--selected:after{content:attr(data-selected);color:silver}.multiselect__option--selected.multiselect__option--highlight{background:#ff6a6a;color:#fff}.multiselect__option--selected.multiselect__option--highlight:after{background:#ff6a6a;content:attr(data-deselect);color:#fff}.multiselect--disabled{background:#ededed;pointer-events:none}.multiselect--disabled .multiselect__current,.multiselect--disabled .multiselect__select,.multiselect__option--disabled{background:#ededed;color:#a6a6a6}.multiselect__option--disabled{cursor:text;pointer-events:none}.multiselect__option--disabled:visited{color:#a6a6a6}.multiselect__option--disabled:focus,.multiselect__option--disabled:hover{background:#3dad7b}.multiselect-transition{-webkit-transition:all .3s ease;transition:all .3s ease}.multiselect-enter,.multiselect-leave{opacity:0;max-height:0!important}@-webkit-keyframes spinning{0%{-webkit-transform:rotate(0);transform:rotate(0)}to{-webkit-transform:rotate(2turn);transform:rotate(2turn)}}@keyframes spinning{0%{-webkit-transform:rotate(0);transform:rotate(0)}to{-webkit-transform:rotate(2turn);transform:rotate(2turn)}}', ""]);
  }, function (t, e) {
    t.exports = function () {
      var t = [];return t.toString = function () {
        for (var t = [], e = 0; e < this.length; e++) {
          var n = this[e];n[2] ? t.push("@media " + n[2] + "{" + n[1] + "}") : t.push(n[1]);
        }return t.join("");
      }, t.i = function (e, n) {
        "string" == typeof e && (e = [[null, e, ""]]);for (var i = {}, o = 0; o < this.length; o++) {
          var r = this[o][0];"number" == typeof r && (i[r] = !0);
        }for (o = 0; o < e.length; o++) {
          var s = e[o];"number" == typeof s[0] && i[s[0]] || (n && !s[2] ? s[2] = n : n && (s[2] = "(" + s[2] + ") and (" + n + ")"), t.push(s));
        }
      }, t;
    };
  }, function (t, e) {
    t.exports = '<div tabindex=0 :class="{ \'multiselect--active\': isOpen, \'multiselect--disabled\': disabled }" @focus=activate() @blur="searchable ? false : deactivate()" @keydown.self.down.prevent=pointerForward() @keydown.self.up.prevent=pointerBackward() @keydown.enter.stop.prevent.self=addPointerElement() @keyup.esc=deactivate() class=multiselect> <div @mousedown.prevent=toggle() class=multiselect__select></div> <div v-el:tags class=multiselect__tags> <span v-if=multiple v-for="option in visibleValue" track-by=$index onmousedown=event.preventDefault() class=multiselect__tag> <span v-text=getOptionLabel(option)></span> <i aria-hidden=true tabindex=1 @keydown.enter.prevent=removeElement(option) @mousedown.prevent=removeElement(option) class=multiselect__tag-icon> </i> </span> <template v-if="value && value.length > limit"> <strong v-text="limitText(value.length - limit)"></strong> </template> <div v-show=loading transition=multiselect__loading class=multiselect__spinner></div> <input name=search type=text autocomplete=off :placeholder=placeholder v-el:search v-if=searchable v-model=search :disabled=disabled @focus.prevent=activate() @blur.prevent=deactivate() @keyup.esc=deactivate() @keyup.down=pointerForward() @keyup.up=pointerBackward() @keydown.enter.stop.prevent.self=addPointerElement() @keydown.delete=removeLastElement() class=multiselect__input /> <span v-if="!searchable && !multiple" class=multiselect__single v-text="currentOptionLabel || placeholder"> </span> </div> <ul transition=multiselect :style="{ maxHeight: maxHeight + \'px\' }" v-el:list v-show=isOpen class=multiselect__content> <slot name=beforeList></slot> <li v-if="multiple && max === value.length"> <span class=multiselect__option> <slot name=maxElements>Maximum of {{ max }} options selected. First remove a selected option to select another.</slot> </span> </li> <template v-if="!max || value.length < max"> <li v-for="option in filteredOptions" track-by=$index tabindex=0 :class="{ \'multiselect__option--highlight\': $index === pointer && this.showPointer, \'multiselect__option--selected\': !isNotSelected(option) }" class=multiselect__option @mousedown.prevent=select(option) @mouseenter=pointerSet($index) :data-select="option.isTag ? tagPlaceholder : selectLabel" :data-selected=selectedLabel :data-deselect=deselectLabel> <partial :name=optionPartial v-if=optionPartial.length></partial> <span v-else v-text=getOptionLabel(option)></span> </li> </template> <li v-show="filteredOptions.length === 0 && search"> <span class=multiselect__option> <slot name=noResult>No elements found. Consider changing the search query.</slot> </span> </li> <slot name=afterList></slot> </ul> </div>';
  }, function (t, e, n) {
    var i, o;n(82), i = n(42), o = n(79), t.exports = i || {}, t.exports.__esModule && (t.exports = t.exports["default"]), o && (("function" == typeof t.exports ? t.exports.options || (t.exports.options = {}) : t.exports).template = o);
  }, function (t, e, n) {
    function i(t, e) {
      for (var n = 0; n < t.length; n++) {
        var i = t[n],
            o = f[i.id];if (o) {
          o.refs++;for (var r = 0; r < o.parts.length; r++) {
            o.parts[r](i.parts[r]);
          }for (; r < i.parts.length; r++) {
            o.parts.push(a(i.parts[r], e));
          }
        } else {
          for (var s = [], r = 0; r < i.parts.length; r++) {
            s.push(a(i.parts[r], e));
          }f[i.id] = { id: i.id, refs: 1, parts: s };
        }
      }
    }function o(t) {
      for (var e = [], n = {}, i = 0; i < t.length; i++) {
        var o = t[i],
            r = o[0],
            s = o[1],
            l = o[2],
            a = o[3],
            u = { css: s, media: l, sourceMap: a };n[r] ? n[r].parts.push(u) : e.push(n[r] = { id: r, parts: [u] });
      }return e;
    }function r(t, e) {
      var n = h(),
          i = b[b.length - 1];if ("top" === t.insertAt) i ? i.nextSibling ? n.insertBefore(e, i.nextSibling) : n.appendChild(e) : n.insertBefore(e, n.firstChild), b.push(e);else {
        if ("bottom" !== t.insertAt) throw new Error("Invalid value for parameter 'insertAt'. Must be 'top' or 'bottom'.");n.appendChild(e);
      }
    }function s(t) {
      t.parentNode.removeChild(t);var e = b.indexOf(t);e >= 0 && b.splice(e, 1);
    }function l(t) {
      var e = document.createElement("style");return e.type = "text/css", r(t, e), e;
    }function a(t, e) {
      var n, i, o;if (e.singleton) {
        var r = v++;n = m || (m = l(e)), i = u.bind(null, n, r, !1), o = u.bind(null, n, r, !0);
      } else n = l(e), i = c.bind(null, n), o = function o() {
        s(n);
      };return i(t), function (e) {
        if (e) {
          if (e.css === t.css && e.media === t.media && e.sourceMap === t.sourceMap) return;i(t = e);
        } else o();
      };
    }function u(t, e, n, i) {
      var o = n ? "" : i.css;if (t.styleSheet) t.styleSheet.cssText = g(e, o);else {
        var r = document.createTextNode(o),
            s = t.childNodes;s[e] && t.removeChild(s[e]), s.length ? t.insertBefore(r, s[e]) : t.appendChild(r);
      }
    }function c(t, e) {
      var n = e.css,
          i = e.media,
          o = e.sourceMap;if (i && t.setAttribute("media", i), o && (n += "\n/*# sourceURL=" + o.sources[0] + " */", n += "\n/*# sourceMappingURL=data:application/json;base64," + btoa(unescape(encodeURIComponent(JSON.stringify(o)))) + " */"), t.styleSheet) t.styleSheet.cssText = n;else {
        for (; t.firstChild;) {
          t.removeChild(t.firstChild);
        }t.appendChild(document.createTextNode(n));
      }
    }var f = {},
        p = function p(t) {
      var e;return function () {
        return "undefined" == typeof e && (e = t.apply(this, arguments)), e;
      };
    },
        d = p(function () {
      return (/msie [6-9]\b/.test(window.navigator.userAgent.toLowerCase())
      );
    }),
        h = p(function () {
      return document.head || document.getElementsByTagName("head")[0];
    }),
        m = null,
        v = 0,
        b = [];t.exports = function (t, e) {
      e = e || {}, "undefined" == typeof e.singleton && (e.singleton = d()), "undefined" == typeof e.insertAt && (e.insertAt = "bottom");var n = o(t);return i(n, e), function (t) {
        for (var r = [], s = 0; s < n.length; s++) {
          var l = n[s],
              a = f[l.id];a.refs--, r.push(a);
        }if (t) {
          var u = o(t);i(u, e);
        }for (var s = 0; s < r.length; s++) {
          var a = r[s];if (0 === a.refs) {
            for (var c = 0; c < a.parts.length; c++) {
              a.parts[c]();
            }delete f[a.id];
          }
        }
      };
    };var g = function () {
      var t = [];return function (e, n) {
        return t[e] = n, t.filter(Boolean).join("\n");
      };
    }();
  }, function (t, e, n) {
    var i = n(77);"string" == typeof i && (i = [[t.id, i, ""]]);n(81)(i, {});i.locals && (t.exports = i.locals);
  }]);
});


},{}],97:[function(require,module,exports){
/*!
 * vue-resource v0.7.4
 * https://github.com/vuejs/vue-resource
 * Released under the MIT License.
 */

'use strict';

var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) {
  return typeof obj;
} : function (obj) {
  return obj && typeof Symbol === "function" && obj.constructor === Symbol ? "symbol" : typeof obj;
};

/**
 * Utility functions.
 */

var util = {};
var config = {};
var array = [];
var console = window.console;
function Util (Vue) {
    util = Vue.util;
    config = Vue.config;
}

var isArray = Array.isArray;

function warn(msg) {
    if (console && util.warn && (!config.silent || config.debug)) {
        console.warn('[VueResource warn]: ' + msg);
    }
}

function error(msg) {
    if (console) {
        console.error(msg);
    }
}

function nextTick(cb, ctx) {
    return util.nextTick(cb, ctx);
}

function trim(str) {
    return str.replace(/^\s*|\s*$/g, '');
}

function toLower(str) {
    return str ? str.toLowerCase() : '';
}

function isString(val) {
    return typeof val === 'string';
}

function isFunction(val) {
    return typeof val === 'function';
}

function isObject(obj) {
    return obj !== null && (typeof obj === 'undefined' ? 'undefined' : _typeof(obj)) === 'object';
}

function isPlainObject(obj) {
    return isObject(obj) && Object.getPrototypeOf(obj) == Object.prototype;
}

function options(fn, obj, opts) {

    opts = opts || {};

    if (isFunction(opts)) {
        opts = opts.call(obj);
    }

    return merge(fn.bind({ $vm: obj, $options: opts }), fn, { $options: opts });
}

function each(obj, iterator) {

    var i, key;

    if (typeof obj.length == 'number') {
        for (i = 0; i < obj.length; i++) {
            iterator.call(obj[i], obj[i], i);
        }
    } else if (isObject(obj)) {
        for (key in obj) {
            if (obj.hasOwnProperty(key)) {
                iterator.call(obj[key], obj[key], key);
            }
        }
    }

    return obj;
}

function extend(target) {

    var args = array.slice.call(arguments, 1);

    args.forEach(function (arg) {
        _merge(target, arg);
    });

    return target;
}

function merge(target) {

    var args = array.slice.call(arguments, 1);

    args.forEach(function (arg) {
        _merge(target, arg, true);
    });

    return target;
}

function _merge(target, source, deep) {
    for (var key in source) {
        if (deep && (isPlainObject(source[key]) || isArray(source[key]))) {
            if (isPlainObject(source[key]) && !isPlainObject(target[key])) {
                target[key] = {};
            }
            if (isArray(source[key]) && !isArray(target[key])) {
                target[key] = [];
            }
            _merge(target[key], source[key], deep);
        } else if (source[key] !== undefined) {
            target[key] = source[key];
        }
    }
}

function root (options, next) {

    var url = next(options);

    if (isString(options.root) && !url.match(/^(https?:)?\//)) {
        url = options.root + '/' + url;
    }

    return url;
}

function query (options, next) {

    var urlParams = Object.keys(Url.options.params),
        query = {},
        url = next(options);

    each(options.params, function (value, key) {
        if (urlParams.indexOf(key) === -1) {
            query[key] = value;
        }
    });

    query = Url.params(query);

    if (query) {
        url += (url.indexOf('?') == -1 ? '?' : '&') + query;
    }

    return url;
}

function legacy (options, next) {

    var variables = [],
        url = next(options);

    url = url.replace(/(\/?):([a-z]\w*)/gi, function (match, slash, name) {

        warn('The `:' + name + '` parameter syntax has been deprecated. Use the `{' + name + '}` syntax instead.');

        if (options.params[name]) {
            variables.push(name);
            return slash + encodeUriSegment(options.params[name]);
        }

        return '';
    });

    variables.forEach(function (key) {
        delete options.params[key];
    });

    return url;
}

function encodeUriSegment(value) {

    return encodeUriQuery(value, true).replace(/%26/gi, '&').replace(/%3D/gi, '=').replace(/%2B/gi, '+');
}

function encodeUriQuery(value, spaces) {

    return encodeURIComponent(value).replace(/%40/gi, '@').replace(/%3A/gi, ':').replace(/%24/g, '$').replace(/%2C/gi, ',').replace(/%20/g, spaces ? '%20' : '+');
}

/**
 * URL Template v2.0.6 (https://github.com/bramstein/url-template)
 */

function expand(url, params, variables) {

    var tmpl = parse(url),
        expanded = tmpl.expand(params);

    if (variables) {
        variables.push.apply(variables, tmpl.vars);
    }

    return expanded;
}

function parse(template) {

    var operators = ['+', '#', '.', '/', ';', '?', '&'],
        variables = [];

    return {
        vars: variables,
        expand: function expand(context) {
            return template.replace(/\{([^\{\}]+)\}|([^\{\}]+)/g, function (_, expression, literal) {
                if (expression) {

                    var operator = null,
                        values = [];

                    if (operators.indexOf(expression.charAt(0)) !== -1) {
                        operator = expression.charAt(0);
                        expression = expression.substr(1);
                    }

                    expression.split(/,/g).forEach(function (variable) {
                        var tmp = /([^:\*]*)(?::(\d+)|(\*))?/.exec(variable);
                        values.push.apply(values, getValues(context, operator, tmp[1], tmp[2] || tmp[3]));
                        variables.push(tmp[1]);
                    });

                    if (operator && operator !== '+') {

                        var separator = ',';

                        if (operator === '?') {
                            separator = '&';
                        } else if (operator !== '#') {
                            separator = operator;
                        }

                        return (values.length !== 0 ? operator : '') + values.join(separator);
                    } else {
                        return values.join(',');
                    }
                } else {
                    return encodeReserved(literal);
                }
            });
        }
    };
}

function getValues(context, operator, key, modifier) {

    var value = context[key],
        result = [];

    if (isDefined(value) && value !== '') {
        if (typeof value === 'string' || typeof value === 'number' || typeof value === 'boolean') {
            value = value.toString();

            if (modifier && modifier !== '*') {
                value = value.substring(0, parseInt(modifier, 10));
            }

            result.push(encodeValue(operator, value, isKeyOperator(operator) ? key : null));
        } else {
            if (modifier === '*') {
                if (Array.isArray(value)) {
                    value.filter(isDefined).forEach(function (value) {
                        result.push(encodeValue(operator, value, isKeyOperator(operator) ? key : null));
                    });
                } else {
                    Object.keys(value).forEach(function (k) {
                        if (isDefined(value[k])) {
                            result.push(encodeValue(operator, value[k], k));
                        }
                    });
                }
            } else {
                var tmp = [];

                if (Array.isArray(value)) {
                    value.filter(isDefined).forEach(function (value) {
                        tmp.push(encodeValue(operator, value));
                    });
                } else {
                    Object.keys(value).forEach(function (k) {
                        if (isDefined(value[k])) {
                            tmp.push(encodeURIComponent(k));
                            tmp.push(encodeValue(operator, value[k].toString()));
                        }
                    });
                }

                if (isKeyOperator(operator)) {
                    result.push(encodeURIComponent(key) + '=' + tmp.join(','));
                } else if (tmp.length !== 0) {
                    result.push(tmp.join(','));
                }
            }
        }
    } else {
        if (operator === ';') {
            result.push(encodeURIComponent(key));
        } else if (value === '' && (operator === '&' || operator === '?')) {
            result.push(encodeURIComponent(key) + '=');
        } else if (value === '') {
            result.push('');
        }
    }

    return result;
}

function isDefined(value) {
    return value !== undefined && value !== null;
}

function isKeyOperator(operator) {
    return operator === ';' || operator === '&' || operator === '?';
}

function encodeValue(operator, value, key) {

    value = operator === '+' || operator === '#' ? encodeReserved(value) : encodeURIComponent(value);

    if (key) {
        return encodeURIComponent(key) + '=' + value;
    } else {
        return value;
    }
}

function encodeReserved(str) {
    return str.split(/(%[0-9A-Fa-f]{2})/g).map(function (part) {
        if (!/%[0-9A-Fa-f]/.test(part)) {
            part = encodeURI(part);
        }
        return part;
    }).join('');
}

function template (options) {

    var variables = [],
        url = expand(options.url, options.params, variables);

    variables.forEach(function (key) {
        delete options.params[key];
    });

    return url;
}

/**
 * Service for URL templating.
 */

var ie = document.documentMode;
var el = document.createElement('a');

function Url(url, params) {

    var self = this || {},
        options = url,
        transform;

    if (isString(url)) {
        options = { url: url, params: params };
    }

    options = merge({}, Url.options, self.$options, options);

    Url.transforms.forEach(function (handler) {
        transform = factory(handler, transform, self.$vm);
    });

    return transform(options);
}

/**
 * Url options.
 */

Url.options = {
    url: '',
    root: null,
    params: {}
};

/**
 * Url transforms.
 */

Url.transforms = [template, legacy, query, root];

/**
 * Encodes a Url parameter string.
 *
 * @param {Object} obj
 */

Url.params = function (obj) {

    var params = [],
        escape = encodeURIComponent;

    params.add = function (key, value) {

        if (isFunction(value)) {
            value = value();
        }

        if (value === null) {
            value = '';
        }

        this.push(escape(key) + '=' + escape(value));
    };

    serialize(params, obj);

    return params.join('&').replace(/%20/g, '+');
};

/**
 * Parse a URL and return its components.
 *
 * @param {String} url
 */

Url.parse = function (url) {

    if (ie) {
        el.href = url;
        url = el.href;
    }

    el.href = url;

    return {
        href: el.href,
        protocol: el.protocol ? el.protocol.replace(/:$/, '') : '',
        port: el.port,
        host: el.host,
        hostname: el.hostname,
        pathname: el.pathname.charAt(0) === '/' ? el.pathname : '/' + el.pathname,
        search: el.search ? el.search.replace(/^\?/, '') : '',
        hash: el.hash ? el.hash.replace(/^#/, '') : ''
    };
};

function factory(handler, next, vm) {
    return function (options) {
        return handler.call(vm, options, next);
    };
}

function serialize(params, obj, scope) {

    var array = isArray(obj),
        plain = isPlainObject(obj),
        hash;

    each(obj, function (value, key) {

        hash = isObject(value) || isArray(value);

        if (scope) {
            key = scope + '[' + (plain || hash ? key : '') + ']';
        }

        if (!scope && array) {
            params.add(value.name, value.value);
        } else if (hash) {
            serialize(params, value, key);
        } else {
            params.add(key, value);
        }
    });
}

/**
 * Promises/A+ polyfill v1.1.4 (https://github.com/bramstein/promis)
 */

var RESOLVED = 0;
var REJECTED = 1;
var PENDING = 2;

function Promise$2(executor) {

    this.state = PENDING;
    this.value = undefined;
    this.deferred = [];

    var promise = this;

    try {
        executor(function (x) {
            promise.resolve(x);
        }, function (r) {
            promise.reject(r);
        });
    } catch (e) {
        promise.reject(e);
    }
}

Promise$2.reject = function (r) {
    return new Promise$2(function (resolve, reject) {
        reject(r);
    });
};

Promise$2.resolve = function (x) {
    return new Promise$2(function (resolve, reject) {
        resolve(x);
    });
};

Promise$2.all = function all(iterable) {
    return new Promise$2(function (resolve, reject) {
        var count = 0,
            result = [];

        if (iterable.length === 0) {
            resolve(result);
        }

        function resolver(i) {
            return function (x) {
                result[i] = x;
                count += 1;

                if (count === iterable.length) {
                    resolve(result);
                }
            };
        }

        for (var i = 0; i < iterable.length; i += 1) {
            Promise$2.resolve(iterable[i]).then(resolver(i), reject);
        }
    });
};

Promise$2.race = function race(iterable) {
    return new Promise$2(function (resolve, reject) {
        for (var i = 0; i < iterable.length; i += 1) {
            Promise$2.resolve(iterable[i]).then(resolve, reject);
        }
    });
};

var p$1 = Promise$2.prototype;

p$1.resolve = function resolve(x) {
    var promise = this;

    if (promise.state === PENDING) {
        if (x === promise) {
            throw new TypeError('Promise settled with itself.');
        }

        var called = false;

        try {
            var then = x && x['then'];

            if (x !== null && (typeof x === 'undefined' ? 'undefined' : _typeof(x)) === 'object' && typeof then === 'function') {
                then.call(x, function (x) {
                    if (!called) {
                        promise.resolve(x);
                    }
                    called = true;
                }, function (r) {
                    if (!called) {
                        promise.reject(r);
                    }
                    called = true;
                });
                return;
            }
        } catch (e) {
            if (!called) {
                promise.reject(e);
            }
            return;
        }

        promise.state = RESOLVED;
        promise.value = x;
        promise.notify();
    }
};

p$1.reject = function reject(reason) {
    var promise = this;

    if (promise.state === PENDING) {
        if (reason === promise) {
            throw new TypeError('Promise settled with itself.');
        }

        promise.state = REJECTED;
        promise.value = reason;
        promise.notify();
    }
};

p$1.notify = function notify() {
    var promise = this;

    nextTick(function () {
        if (promise.state !== PENDING) {
            while (promise.deferred.length) {
                var deferred = promise.deferred.shift(),
                    onResolved = deferred[0],
                    onRejected = deferred[1],
                    resolve = deferred[2],
                    reject = deferred[3];

                try {
                    if (promise.state === RESOLVED) {
                        if (typeof onResolved === 'function') {
                            resolve(onResolved.call(undefined, promise.value));
                        } else {
                            resolve(promise.value);
                        }
                    } else if (promise.state === REJECTED) {
                        if (typeof onRejected === 'function') {
                            resolve(onRejected.call(undefined, promise.value));
                        } else {
                            reject(promise.value);
                        }
                    }
                } catch (e) {
                    reject(e);
                }
            }
        }
    });
};

p$1.then = function then(onResolved, onRejected) {
    var promise = this;

    return new Promise$2(function (resolve, reject) {
        promise.deferred.push([onResolved, onRejected, resolve, reject]);
        promise.notify();
    });
};

p$1.catch = function (onRejected) {
    return this.then(undefined, onRejected);
};

var PromiseObj = window.Promise || Promise$2;

function Promise$1(executor, context) {

    if (executor instanceof PromiseObj) {
        this.promise = executor;
    } else {
        this.promise = new PromiseObj(executor.bind(context));
    }

    this.context = context;
}

Promise$1.all = function (iterable, context) {
    return new Promise$1(PromiseObj.all(iterable), context);
};

Promise$1.resolve = function (value, context) {
    return new Promise$1(PromiseObj.resolve(value), context);
};

Promise$1.reject = function (reason, context) {
    return new Promise$1(PromiseObj.reject(reason), context);
};

Promise$1.race = function (iterable, context) {
    return new Promise$1(PromiseObj.race(iterable), context);
};

var p = Promise$1.prototype;

p.bind = function (context) {
    this.context = context;
    return this;
};

p.then = function (fulfilled, rejected) {

    if (fulfilled && fulfilled.bind && this.context) {
        fulfilled = fulfilled.bind(this.context);
    }

    if (rejected && rejected.bind && this.context) {
        rejected = rejected.bind(this.context);
    }

    this.promise = this.promise.then(fulfilled, rejected);

    return this;
};

p.catch = function (rejected) {

    if (rejected && rejected.bind && this.context) {
        rejected = rejected.bind(this.context);
    }

    this.promise = this.promise.catch(rejected);

    return this;
};

p.finally = function (callback) {

    return this.then(function (value) {
        callback.call(this);
        return value;
    }, function (reason) {
        callback.call(this);
        return PromiseObj.reject(reason);
    });
};

p.success = function (callback) {

    warn('The `success` method has been deprecated. Use the `then` method instead.');

    return this.then(function (response) {
        return callback.call(this, response.data, response.status, response) || response;
    });
};

p.error = function (callback) {

    warn('The `error` method has been deprecated. Use the `catch` method instead.');

    return this.catch(function (response) {
        return callback.call(this, response.data, response.status, response) || response;
    });
};

p.always = function (callback) {

    warn('The `always` method has been deprecated. Use the `finally` method instead.');

    var cb = function cb(response) {
        return callback.call(this, response.data, response.status, response) || response;
    };

    return this.then(cb, cb);
};

function xdrClient (request) {
    return new Promise$1(function (resolve) {

        var xdr = new XDomainRequest(),
            response = { request: request },
            handler;

        request.cancel = function () {
            xdr.abort();
        };

        xdr.open(request.method, Url(request), true);

        handler = function handler(event) {

            response.data = xdr.responseText;
            response.status = xdr.status;
            response.statusText = xdr.statusText || '';

            resolve(response);
        };

        xdr.timeout = 0;
        xdr.onload = handler;
        xdr.onabort = handler;
        xdr.onerror = handler;
        xdr.ontimeout = function () {};
        xdr.onprogress = function () {};

        xdr.send(request.data);
    });
}

var originUrl = Url.parse(location.href);
var supportCors = 'withCredentials' in new XMLHttpRequest();

var exports$1 = {
    request: function request(_request) {

        if (_request.crossOrigin === null) {
            _request.crossOrigin = crossOrigin(_request);
        }

        if (_request.crossOrigin) {

            if (!supportCors) {
                _request.client = xdrClient;
            }

            _request.emulateHTTP = false;
        }

        return _request;
    }
};

function crossOrigin(request) {

    var requestUrl = Url.parse(Url(request));

    return requestUrl.protocol !== originUrl.protocol || requestUrl.host !== originUrl.host;
}

var exports$2 = {
    request: function request(_request) {

        if (_request.emulateJSON && isPlainObject(_request.data)) {
            _request.headers['Content-Type'] = 'application/x-www-form-urlencoded';
            _request.data = Url.params(_request.data);
        }

        if (isObject(_request.data) && /FormData/i.test(_request.data.toString())) {
            delete _request.headers['Content-Type'];
        }

        if (isPlainObject(_request.data)) {
            _request.data = JSON.stringify(_request.data);
        }

        return _request;
    },
    response: function response(_response) {

        try {
            _response.data = JSON.parse(_response.data);
        } catch (e) {}

        return _response;
    }
};

function jsonpClient (request) {
    return new Promise$1(function (resolve) {

        var callback = '_jsonp' + Math.random().toString(36).substr(2),
            response = { request: request, data: null },
            handler,
            script;

        request.params[request.jsonp] = callback;
        request.cancel = function () {
            handler({ type: 'cancel' });
        };

        script = document.createElement('script');
        script.src = Url(request);
        script.type = 'text/javascript';
        script.async = true;

        window[callback] = function (data) {
            response.data = data;
        };

        handler = function handler(event) {

            if (event.type === 'load' && response.data !== null) {
                response.status = 200;
            } else if (event.type === 'error') {
                response.status = 404;
            } else {
                response.status = 0;
            }

            resolve(response);

            delete window[callback];
            document.body.removeChild(script);
        };

        script.onload = handler;
        script.onerror = handler;

        document.body.appendChild(script);
    });
}

var exports$3 = {
    request: function request(_request) {

        if (_request.method == 'JSONP') {
            _request.client = jsonpClient;
        }

        return _request;
    }
};

var exports$4 = {
    request: function request(_request) {

        if (isFunction(_request.beforeSend)) {
            _request.beforeSend.call(this, _request);
        }

        return _request;
    }
};

/**
 * HTTP method override Interceptor.
 */

var exports$5 = {
    request: function request(_request) {

        if (_request.emulateHTTP && /^(PUT|PATCH|DELETE)$/i.test(_request.method)) {
            _request.headers['X-HTTP-Method-Override'] = _request.method;
            _request.method = 'POST';
        }

        return _request;
    }
};

var exports$6 = {
    request: function request(_request) {

        _request.method = _request.method.toUpperCase();
        _request.headers = extend({}, Http.headers.common, !_request.crossOrigin ? Http.headers.custom : {}, Http.headers[_request.method.toLowerCase()], _request.headers);

        if (isPlainObject(_request.data) && /^(GET|JSONP)$/i.test(_request.method)) {
            extend(_request.params, _request.data);
            delete _request.data;
        }

        return _request;
    }
};

/**
 * Timeout Interceptor.
 */

var exports$7 = function exports() {

    var timeout;

    return {
        request: function request(_request) {

            if (_request.timeout) {
                timeout = setTimeout(function () {
                    _request.cancel();
                }, _request.timeout);
            }

            return _request;
        },
        response: function response(_response) {

            clearTimeout(timeout);

            return _response;
        }
    };
};

function interceptor (handler, vm) {

    return function (client) {

        if (isFunction(handler)) {
            handler = handler.call(vm, Promise$1);
        }

        return function (request) {

            if (isFunction(handler.request)) {
                request = handler.request.call(vm, request);
            }

            return when(request, function (request) {
                return when(client(request), function (response) {

                    if (isFunction(handler.response)) {
                        response = handler.response.call(vm, response);
                    }

                    return response;
                });
            });
        };
    };
}

function when(value, fulfilled, rejected) {

    var promise = Promise$1.resolve(value);

    if (arguments.length < 2) {
        return promise;
    }

    return promise.then(fulfilled, rejected);
}

function xhrClient (request) {
    return new Promise$1(function (resolve) {

        var xhr = new XMLHttpRequest(),
            response = { request: request },
            handler;

        request.cancel = function () {
            xhr.abort();
        };

        xhr.open(request.method, Url(request), true);

        handler = function handler(event) {

            response.data = 'response' in xhr ? xhr.response : xhr.responseText;
            response.status = xhr.status === 1223 ? 204 : xhr.status; // IE9 status bug
            response.statusText = trim(xhr.statusText || '');
            response.headers = xhr.getAllResponseHeaders();

            resolve(response);
        };

        xhr.timeout = 0;
        xhr.onload = handler;
        xhr.onabort = handler;
        xhr.onerror = handler;
        xhr.ontimeout = function () {};
        xhr.onprogress = function () {};

        if (isPlainObject(request.xhr)) {
            extend(xhr, request.xhr);
        }

        if (isPlainObject(request.upload)) {
            extend(xhr.upload, request.upload);
        }

        each(request.headers || {}, function (value, header) {
            xhr.setRequestHeader(header, value);
        });

        xhr.send(request.data);
    });
}

function Client (request) {

    var response = (request.client || xhrClient)(request);

    return Promise$1.resolve(response).then(function (response) {

        if (response.headers) {

            var headers = parseHeaders(response.headers);

            response.headers = function (name) {

                if (name) {
                    return headers[toLower(name)];
                }

                return headers;
            };
        }

        response.ok = response.status >= 200 && response.status < 300;

        return response;
    });
}

function parseHeaders(str) {

    var headers = {},
        value,
        name,
        i;

    if (isString(str)) {
        each(str.split('\n'), function (row) {

            i = row.indexOf(':');
            name = trim(toLower(row.slice(0, i)));
            value = trim(row.slice(i + 1));

            if (headers[name]) {

                if (isArray(headers[name])) {
                    headers[name].push(value);
                } else {
                    headers[name] = [headers[name], value];
                }
            } else {

                headers[name] = value;
            }
        });
    }

    return headers;
}

/**
 * Service for sending network requests.
 */

var jsonType = { 'Content-Type': 'application/json' };

function Http(url, options) {

    var self = this || {},
        client = Client,
        request,
        promise;

    Http.interceptors.forEach(function (handler) {
        client = interceptor(handler, self.$vm)(client);
    });

    options = isObject(url) ? url : extend({ url: url }, options);
    request = merge({}, Http.options, self.$options, options);
    promise = client(request).bind(self.$vm).then(function (response) {

        return response.ok ? response : Promise$1.reject(response);
    }, function (response) {

        if (response instanceof Error) {
            error(response);
        }

        return Promise$1.reject(response);
    });

    if (request.success) {
        promise.success(request.success);
    }

    if (request.error) {
        promise.error(request.error);
    }

    return promise;
}

Http.options = {
    method: 'get',
    data: '',
    params: {},
    headers: {},
    xhr: null,
    upload: null,
    jsonp: 'callback',
    beforeSend: null,
    crossOrigin: null,
    emulateHTTP: false,
    emulateJSON: false,
    timeout: 0
};

Http.headers = {
    put: jsonType,
    post: jsonType,
    patch: jsonType,
    delete: jsonType,
    common: { 'Accept': 'application/json, text/plain, */*' },
    custom: { 'X-Requested-With': 'XMLHttpRequest' }
};

Http.interceptors = [exports$4, exports$7, exports$3, exports$5, exports$2, exports$6, exports$1];

['get', 'put', 'post', 'patch', 'delete', 'jsonp'].forEach(function (method) {

    Http[method] = function (url, data, success, options) {

        if (isFunction(data)) {
            options = success;
            success = data;
            data = undefined;
        }

        if (isObject(success)) {
            options = success;
            success = undefined;
        }

        return this(url, extend({ method: method, data: data, success: success }, options));
    };
});

function Resource(url, params, actions, options) {

    var self = this || {},
        resource = {};

    actions = extend({}, Resource.actions, actions);

    each(actions, function (action, name) {

        action = merge({ url: url, params: params || {} }, options, action);

        resource[name] = function () {
            return (self.$http || Http)(opts(action, arguments));
        };
    });

    return resource;
}

function opts(action, args) {

    var options = extend({}, action),
        params = {},
        data,
        success,
        error;

    switch (args.length) {

        case 4:

            error = args[3];
            success = args[2];

        case 3:
        case 2:

            if (isFunction(args[1])) {

                if (isFunction(args[0])) {

                    success = args[0];
                    error = args[1];

                    break;
                }

                success = args[1];
                error = args[2];
            } else {

                params = args[0];
                data = args[1];
                success = args[2];

                break;
            }

        case 1:

            if (isFunction(args[0])) {
                success = args[0];
            } else if (/^(POST|PUT|PATCH)$/i.test(options.method)) {
                data = args[0];
            } else {
                params = args[0];
            }

            break;

        case 0:

            break;

        default:

            throw 'Expected up to 4 arguments [params, data, success, error], got ' + args.length + ' arguments';
    }

    options.data = data;
    options.params = extend({}, options.params, params);

    if (success) {
        options.success = success;
    }

    if (error) {
        options.error = error;
    }

    return options;
}

Resource.actions = {

    get: { method: 'GET' },
    save: { method: 'POST' },
    query: { method: 'GET' },
    update: { method: 'PUT' },
    remove: { method: 'DELETE' },
    delete: { method: 'DELETE' }

};

function plugin(Vue) {

    if (plugin.installed) {
        return;
    }

    Util(Vue);

    Vue.url = Url;
    Vue.http = Http;
    Vue.resource = Resource;
    Vue.Promise = Promise$1;

    Object.defineProperties(Vue.prototype, {

        $url: {
            get: function get() {
                return options(Vue.url, this, this.$options.url);
            }
        },

        $http: {
            get: function get() {
                return options(Vue.http, this, this.$options.http);
            }
        },

        $resource: {
            get: function get() {
                return Vue.resource.bind(this);
            }
        },

        $promise: {
            get: function get() {
                var _this = this;

                return function (executor) {
                    return new Vue.Promise(executor, _this);
                };
            }
        }

    });
}

if (typeof window !== 'undefined' && window.Vue) {
    window.Vue.use(plugin);
}

module.exports = plugin;
},{}],98:[function(require,module,exports){
(function (process,global){
/*!
 * Vue.js v1.0.26
 * (c) 2016 Evan You
 * Released under the MIT License.
 */
'use strict';

function set(obj, key, val) {
  if (hasOwn(obj, key)) {
    obj[key] = val;
    return;
  }
  if (obj._isVue) {
    set(obj._data, key, val);
    return;
  }
  var ob = obj.__ob__;
  if (!ob) {
    obj[key] = val;
    return;
  }
  ob.convert(key, val);
  ob.dep.notify();
  if (ob.vms) {
    var i = ob.vms.length;
    while (i--) {
      var vm = ob.vms[i];
      vm._proxy(key);
      vm._digest();
    }
  }
  return val;
}

/**
 * Delete a property and trigger change if necessary.
 *
 * @param {Object} obj
 * @param {String} key
 */

function del(obj, key) {
  if (!hasOwn(obj, key)) {
    return;
  }
  delete obj[key];
  var ob = obj.__ob__;
  if (!ob) {
    if (obj._isVue) {
      delete obj._data[key];
      obj._digest();
    }
    return;
  }
  ob.dep.notify();
  if (ob.vms) {
    var i = ob.vms.length;
    while (i--) {
      var vm = ob.vms[i];
      vm._unproxy(key);
      vm._digest();
    }
  }
}

var hasOwnProperty = Object.prototype.hasOwnProperty;
/**
 * Check whether the object has the property.
 *
 * @param {Object} obj
 * @param {String} key
 * @return {Boolean}
 */

function hasOwn(obj, key) {
  return hasOwnProperty.call(obj, key);
}

/**
 * Check if an expression is a literal value.
 *
 * @param {String} exp
 * @return {Boolean}
 */

var literalValueRE = /^\s?(true|false|-?[\d\.]+|'[^']*'|"[^"]*")\s?$/;

function isLiteral(exp) {
  return literalValueRE.test(exp);
}

/**
 * Check if a string starts with $ or _
 *
 * @param {String} str
 * @return {Boolean}
 */

function isReserved(str) {
  var c = (str + '').charCodeAt(0);
  return c === 0x24 || c === 0x5F;
}

/**
 * Guard text output, make sure undefined outputs
 * empty string
 *
 * @param {*} value
 * @return {String}
 */

function _toString(value) {
  return value == null ? '' : value.toString();
}

/**
 * Check and convert possible numeric strings to numbers
 * before setting back to data
 *
 * @param {*} value
 * @return {*|Number}
 */

function toNumber(value) {
  if (typeof value !== 'string') {
    return value;
  } else {
    var parsed = Number(value);
    return isNaN(parsed) ? value : parsed;
  }
}

/**
 * Convert string boolean literals into real booleans.
 *
 * @param {*} value
 * @return {*|Boolean}
 */

function toBoolean(value) {
  return value === 'true' ? true : value === 'false' ? false : value;
}

/**
 * Strip quotes from a string
 *
 * @param {String} str
 * @return {String | false}
 */

function stripQuotes(str) {
  var a = str.charCodeAt(0);
  var b = str.charCodeAt(str.length - 1);
  return a === b && (a === 0x22 || a === 0x27) ? str.slice(1, -1) : str;
}

/**
 * Camelize a hyphen-delmited string.
 *
 * @param {String} str
 * @return {String}
 */

var camelizeRE = /-(\w)/g;

function camelize(str) {
  return str.replace(camelizeRE, toUpper);
}

function toUpper(_, c) {
  return c ? c.toUpperCase() : '';
}

/**
 * Hyphenate a camelCase string.
 *
 * @param {String} str
 * @return {String}
 */

var hyphenateRE = /([a-z\d])([A-Z])/g;

function hyphenate(str) {
  return str.replace(hyphenateRE, '$1-$2').toLowerCase();
}

/**
 * Converts hyphen/underscore/slash delimitered names into
 * camelized classNames.
 *
 * e.g. my-component => MyComponent
 *      some_else    => SomeElse
 *      some/comp    => SomeComp
 *
 * @param {String} str
 * @return {String}
 */

var classifyRE = /(?:^|[-_\/])(\w)/g;

function classify(str) {
  return str.replace(classifyRE, toUpper);
}

/**
 * Simple bind, faster than native
 *
 * @param {Function} fn
 * @param {Object} ctx
 * @return {Function}
 */

function bind(fn, ctx) {
  return function (a) {
    var l = arguments.length;
    return l ? l > 1 ? fn.apply(ctx, arguments) : fn.call(ctx, a) : fn.call(ctx);
  };
}

/**
 * Convert an Array-like object to a real Array.
 *
 * @param {Array-like} list
 * @param {Number} [start] - start index
 * @return {Array}
 */

function toArray(list, start) {
  start = start || 0;
  var i = list.length - start;
  var ret = new Array(i);
  while (i--) {
    ret[i] = list[i + start];
  }
  return ret;
}

/**
 * Mix properties into target object.
 *
 * @param {Object} to
 * @param {Object} from
 */

function extend(to, from) {
  var keys = Object.keys(from);
  var i = keys.length;
  while (i--) {
    to[keys[i]] = from[keys[i]];
  }
  return to;
}

/**
 * Quick object check - this is primarily used to tell
 * Objects from primitive values when we know the value
 * is a JSON-compliant type.
 *
 * @param {*} obj
 * @return {Boolean}
 */

function isObject(obj) {
  return obj !== null && typeof obj === 'object';
}

/**
 * Strict object type check. Only returns true
 * for plain JavaScript objects.
 *
 * @param {*} obj
 * @return {Boolean}
 */

var toString = Object.prototype.toString;
var OBJECT_STRING = '[object Object]';

function isPlainObject(obj) {
  return toString.call(obj) === OBJECT_STRING;
}

/**
 * Array type check.
 *
 * @param {*} obj
 * @return {Boolean}
 */

var isArray = Array.isArray;

/**
 * Define a property.
 *
 * @param {Object} obj
 * @param {String} key
 * @param {*} val
 * @param {Boolean} [enumerable]
 */

function def(obj, key, val, enumerable) {
  Object.defineProperty(obj, key, {
    value: val,
    enumerable: !!enumerable,
    writable: true,
    configurable: true
  });
}

/**
 * Debounce a function so it only gets called after the
 * input stops arriving after the given wait period.
 *
 * @param {Function} func
 * @param {Number} wait
 * @return {Function} - the debounced function
 */

function _debounce(func, wait) {
  var timeout, args, context, timestamp, result;
  var later = function later() {
    var last = Date.now() - timestamp;
    if (last < wait && last >= 0) {
      timeout = setTimeout(later, wait - last);
    } else {
      timeout = null;
      result = func.apply(context, args);
      if (!timeout) context = args = null;
    }
  };
  return function () {
    context = this;
    args = arguments;
    timestamp = Date.now();
    if (!timeout) {
      timeout = setTimeout(later, wait);
    }
    return result;
  };
}

/**
 * Manual indexOf because it's slightly faster than
 * native.
 *
 * @param {Array} arr
 * @param {*} obj
 */

function indexOf(arr, obj) {
  var i = arr.length;
  while (i--) {
    if (arr[i] === obj) return i;
  }
  return -1;
}

/**
 * Make a cancellable version of an async callback.
 *
 * @param {Function} fn
 * @return {Function}
 */

function cancellable(fn) {
  var cb = function cb() {
    if (!cb.cancelled) {
      return fn.apply(this, arguments);
    }
  };
  cb.cancel = function () {
    cb.cancelled = true;
  };
  return cb;
}

/**
 * Check if two values are loosely equal - that is,
 * if they are plain objects, do they have the same shape?
 *
 * @param {*} a
 * @param {*} b
 * @return {Boolean}
 */

function looseEqual(a, b) {
  /* eslint-disable eqeqeq */
  return a == b || (isObject(a) && isObject(b) ? JSON.stringify(a) === JSON.stringify(b) : false);
  /* eslint-enable eqeqeq */
}

var hasProto = ('__proto__' in {});

// Browser environment sniffing
var inBrowser = typeof window !== 'undefined' && Object.prototype.toString.call(window) !== '[object Object]';

// detect devtools
var devtools = inBrowser && window.__VUE_DEVTOOLS_GLOBAL_HOOK__;

// UA sniffing for working around browser-specific quirks
var UA = inBrowser && window.navigator.userAgent.toLowerCase();
var isIE = UA && UA.indexOf('trident') > 0;
var isIE9 = UA && UA.indexOf('msie 9.0') > 0;
var isAndroid = UA && UA.indexOf('android') > 0;
var isIos = UA && /(iphone|ipad|ipod|ios)/i.test(UA);
var iosVersionMatch = isIos && UA.match(/os ([\d_]+)/);
var iosVersion = iosVersionMatch && iosVersionMatch[1].split('_');

// detecting iOS UIWebView by indexedDB
var hasMutationObserverBug = iosVersion && Number(iosVersion[0]) >= 9 && Number(iosVersion[1]) >= 3 && !window.indexedDB;

var transitionProp = undefined;
var transitionEndEvent = undefined;
var animationProp = undefined;
var animationEndEvent = undefined;

// Transition property/event sniffing
if (inBrowser && !isIE9) {
  var isWebkitTrans = window.ontransitionend === undefined && window.onwebkittransitionend !== undefined;
  var isWebkitAnim = window.onanimationend === undefined && window.onwebkitanimationend !== undefined;
  transitionProp = isWebkitTrans ? 'WebkitTransition' : 'transition';
  transitionEndEvent = isWebkitTrans ? 'webkitTransitionEnd' : 'transitionend';
  animationProp = isWebkitAnim ? 'WebkitAnimation' : 'animation';
  animationEndEvent = isWebkitAnim ? 'webkitAnimationEnd' : 'animationend';
}

/**
 * Defer a task to execute it asynchronously. Ideally this
 * should be executed as a microtask, so we leverage
 * MutationObserver if it's available, and fallback to
 * setTimeout(0).
 *
 * @param {Function} cb
 * @param {Object} ctx
 */

var nextTick = (function () {
  var callbacks = [];
  var pending = false;
  var timerFunc;
  function nextTickHandler() {
    pending = false;
    var copies = callbacks.slice(0);
    callbacks = [];
    for (var i = 0; i < copies.length; i++) {
      copies[i]();
    }
  }

  /* istanbul ignore if */
  if (typeof MutationObserver !== 'undefined' && !hasMutationObserverBug) {
    var counter = 1;
    var observer = new MutationObserver(nextTickHandler);
    var textNode = document.createTextNode(counter);
    observer.observe(textNode, {
      characterData: true
    });
    timerFunc = function () {
      counter = (counter + 1) % 2;
      textNode.data = counter;
    };
  } else {
    // webpack attempts to inject a shim for setImmediate
    // if it is used as a global, so we have to work around that to
    // avoid bundling unnecessary code.
    var context = inBrowser ? window : typeof global !== 'undefined' ? global : {};
    timerFunc = context.setImmediate || setTimeout;
  }
  return function (cb, ctx) {
    var func = ctx ? function () {
      cb.call(ctx);
    } : cb;
    callbacks.push(func);
    if (pending) return;
    pending = true;
    timerFunc(nextTickHandler, 0);
  };
})();

var _Set = undefined;
/* istanbul ignore if */
if (typeof Set !== 'undefined' && Set.toString().match(/native code/)) {
  // use native Set when available.
  _Set = Set;
} else {
  // a non-standard Set polyfill that only works with primitive keys.
  _Set = function () {
    this.set = Object.create(null);
  };
  _Set.prototype.has = function (key) {
    return this.set[key] !== undefined;
  };
  _Set.prototype.add = function (key) {
    this.set[key] = 1;
  };
  _Set.prototype.clear = function () {
    this.set = Object.create(null);
  };
}

function Cache(limit) {
  this.size = 0;
  this.limit = limit;
  this.head = this.tail = undefined;
  this._keymap = Object.create(null);
}

var p = Cache.prototype;

/**
 * Put <value> into the cache associated with <key>.
 * Returns the entry which was removed to make room for
 * the new entry. Otherwise undefined is returned.
 * (i.e. if there was enough room already).
 *
 * @param {String} key
 * @param {*} value
 * @return {Entry|undefined}
 */

p.put = function (key, value) {
  var removed;

  var entry = this.get(key, true);
  if (!entry) {
    if (this.size === this.limit) {
      removed = this.shift();
    }
    entry = {
      key: key
    };
    this._keymap[key] = entry;
    if (this.tail) {
      this.tail.newer = entry;
      entry.older = this.tail;
    } else {
      this.head = entry;
    }
    this.tail = entry;
    this.size++;
  }
  entry.value = value;

  return removed;
};

/**
 * Purge the least recently used (oldest) entry from the
 * cache. Returns the removed entry or undefined if the
 * cache was empty.
 */

p.shift = function () {
  var entry = this.head;
  if (entry) {
    this.head = this.head.newer;
    this.head.older = undefined;
    entry.newer = entry.older = undefined;
    this._keymap[entry.key] = undefined;
    this.size--;
  }
  return entry;
};

/**
 * Get and register recent use of <key>. Returns the value
 * associated with <key> or undefined if not in cache.
 *
 * @param {String} key
 * @param {Boolean} returnEntry
 * @return {Entry|*}
 */

p.get = function (key, returnEntry) {
  var entry = this._keymap[key];
  if (entry === undefined) return;
  if (entry === this.tail) {
    return returnEntry ? entry : entry.value;
  }
  // HEAD--------------TAIL
  //   <.older   .newer>
  //  <--- add direction --
  //   A  B  C  <D>  E
  if (entry.newer) {
    if (entry === this.head) {
      this.head = entry.newer;
    }
    entry.newer.older = entry.older; // C <-- E.
  }
  if (entry.older) {
    entry.older.newer = entry.newer; // C. --> E
  }
  entry.newer = undefined; // D --x
  entry.older = this.tail; // D. --> E
  if (this.tail) {
    this.tail.newer = entry; // E. <-- D
  }
  this.tail = entry;
  return returnEntry ? entry : entry.value;
};

var cache$1 = new Cache(1000);
var filterTokenRE = /[^\s'"]+|'[^']*'|"[^"]*"/g;
var reservedArgRE = /^in$|^-?\d+/;

/**
 * Parser state
 */

var str;
var dir;
var c;
var prev;
var i;
var l;
var lastFilterIndex;
var inSingle;
var inDouble;
var curly;
var square;
var paren;
/**
 * Push a filter to the current directive object
 */

function pushFilter() {
  var exp = str.slice(lastFilterIndex, i).trim();
  var filter;
  if (exp) {
    filter = {};
    var tokens = exp.match(filterTokenRE);
    filter.name = tokens[0];
    if (tokens.length > 1) {
      filter.args = tokens.slice(1).map(processFilterArg);
    }
  }
  if (filter) {
    (dir.filters = dir.filters || []).push(filter);
  }
  lastFilterIndex = i + 1;
}

/**
 * Check if an argument is dynamic and strip quotes.
 *
 * @param {String} arg
 * @return {Object}
 */

function processFilterArg(arg) {
  if (reservedArgRE.test(arg)) {
    return {
      value: toNumber(arg),
      dynamic: false
    };
  } else {
    var stripped = stripQuotes(arg);
    var dynamic = stripped === arg;
    return {
      value: dynamic ? arg : stripped,
      dynamic: dynamic
    };
  }
}

/**
 * Parse a directive value and extract the expression
 * and its filters into a descriptor.
 *
 * Example:
 *
 * "a + 1 | uppercase" will yield:
 * {
 *   expression: 'a + 1',
 *   filters: [
 *     { name: 'uppercase', args: null }
 *   ]
 * }
 *
 * @param {String} s
 * @return {Object}
 */

function parseDirective(s) {
  var hit = cache$1.get(s);
  if (hit) {
    return hit;
  }

  // reset parser state
  str = s;
  inSingle = inDouble = false;
  curly = square = paren = 0;
  lastFilterIndex = 0;
  dir = {};

  for (i = 0, l = str.length; i < l; i++) {
    prev = c;
    c = str.charCodeAt(i);
    if (inSingle) {
      // check single quote
      if (c === 0x27 && prev !== 0x5C) inSingle = !inSingle;
    } else if (inDouble) {
      // check double quote
      if (c === 0x22 && prev !== 0x5C) inDouble = !inDouble;
    } else if (c === 0x7C && // pipe
    str.charCodeAt(i + 1) !== 0x7C && str.charCodeAt(i - 1) !== 0x7C) {
      if (dir.expression == null) {
        // first filter, end of expression
        lastFilterIndex = i + 1;
        dir.expression = str.slice(0, i).trim();
      } else {
        // already has filter
        pushFilter();
      }
    } else {
      switch (c) {
        case 0x22:
          inDouble = true;break; // "
        case 0x27:
          inSingle = true;break; // '
        case 0x28:
          paren++;break; // (
        case 0x29:
          paren--;break; // )
        case 0x5B:
          square++;break; // [
        case 0x5D:
          square--;break; // ]
        case 0x7B:
          curly++;break; // {
        case 0x7D:
          curly--;break; // }
      }
    }
  }

  if (dir.expression == null) {
    dir.expression = str.slice(0, i).trim();
  } else if (lastFilterIndex !== 0) {
    pushFilter();
  }

  cache$1.put(s, dir);
  return dir;
}

var directive = Object.freeze({
  parseDirective: parseDirective
});

var regexEscapeRE = /[-.*+?^${}()|[\]\/\\]/g;
var cache = undefined;
var tagRE = undefined;
var htmlRE = undefined;
/**
 * Escape a string so it can be used in a RegExp
 * constructor.
 *
 * @param {String} str
 */

function escapeRegex(str) {
  return str.replace(regexEscapeRE, '\\$&');
}

function compileRegex() {
  var open = escapeRegex(config.delimiters[0]);
  var close = escapeRegex(config.delimiters[1]);
  var unsafeOpen = escapeRegex(config.unsafeDelimiters[0]);
  var unsafeClose = escapeRegex(config.unsafeDelimiters[1]);
  tagRE = new RegExp(unsafeOpen + '((?:.|\\n)+?)' + unsafeClose + '|' + open + '((?:.|\\n)+?)' + close, 'g');
  htmlRE = new RegExp('^' + unsafeOpen + '((?:.|\\n)+?)' + unsafeClose + '$');
  // reset cache
  cache = new Cache(1000);
}

/**
 * Parse a template text string into an array of tokens.
 *
 * @param {String} text
 * @return {Array<Object> | null}
 *               - {String} type
 *               - {String} value
 *               - {Boolean} [html]
 *               - {Boolean} [oneTime]
 */

function parseText(text) {
  if (!cache) {
    compileRegex();
  }
  var hit = cache.get(text);
  if (hit) {
    return hit;
  }
  if (!tagRE.test(text)) {
    return null;
  }
  var tokens = [];
  var lastIndex = tagRE.lastIndex = 0;
  var match, index, html, value, first, oneTime;
  /* eslint-disable no-cond-assign */
  while (match = tagRE.exec(text)) {
    /* eslint-enable no-cond-assign */
    index = match.index;
    // push text token
    if (index > lastIndex) {
      tokens.push({
        value: text.slice(lastIndex, index)
      });
    }
    // tag token
    html = htmlRE.test(match[0]);
    value = html ? match[1] : match[2];
    first = value.charCodeAt(0);
    oneTime = first === 42; // *
    value = oneTime ? value.slice(1) : value;
    tokens.push({
      tag: true,
      value: value.trim(),
      html: html,
      oneTime: oneTime
    });
    lastIndex = index + match[0].length;
  }
  if (lastIndex < text.length) {
    tokens.push({
      value: text.slice(lastIndex)
    });
  }
  cache.put(text, tokens);
  return tokens;
}

/**
 * Format a list of tokens into an expression.
 * e.g. tokens parsed from 'a {{b}} c' can be serialized
 * into one single expression as '"a " + b + " c"'.
 *
 * @param {Array} tokens
 * @param {Vue} [vm]
 * @return {String}
 */

function tokensToExp(tokens, vm) {
  if (tokens.length > 1) {
    return tokens.map(function (token) {
      return formatToken(token, vm);
    }).join('+');
  } else {
    return formatToken(tokens[0], vm, true);
  }
}

/**
 * Format a single token.
 *
 * @param {Object} token
 * @param {Vue} [vm]
 * @param {Boolean} [single]
 * @return {String}
 */

function formatToken(token, vm, single) {
  return token.tag ? token.oneTime && vm ? '"' + vm.$eval(token.value) + '"' : inlineFilters(token.value, single) : '"' + token.value + '"';
}

/**
 * For an attribute with multiple interpolation tags,
 * e.g. attr="some-{{thing | filter}}", in order to combine
 * the whole thing into a single watchable expression, we
 * have to inline those filters. This function does exactly
 * that. This is a bit hacky but it avoids heavy changes
 * to directive parser and watcher mechanism.
 *
 * @param {String} exp
 * @param {Boolean} single
 * @return {String}
 */

var filterRE = /[^|]\|[^|]/;
function inlineFilters(exp, single) {
  if (!filterRE.test(exp)) {
    return single ? exp : '(' + exp + ')';
  } else {
    var dir = parseDirective(exp);
    if (!dir.filters) {
      return '(' + exp + ')';
    } else {
      return 'this._applyFilters(' + dir.expression + // value
      ',null,' + // oldValue (null for read)
      JSON.stringify(dir.filters) + // filter descriptors
      ',false)'; // write?
    }
  }
}

var text = Object.freeze({
  compileRegex: compileRegex,
  parseText: parseText,
  tokensToExp: tokensToExp
});

var delimiters = ['{{', '}}'];
var unsafeDelimiters = ['{{{', '}}}'];

var config = Object.defineProperties({

  /**
   * Whether to print debug messages.
   * Also enables stack trace for warnings.
   *
   * @type {Boolean}
   */

  debug: false,

  /**
   * Whether to suppress warnings.
   *
   * @type {Boolean}
   */

  silent: false,

  /**
   * Whether to use async rendering.
   */

  async: true,

  /**
   * Whether to warn against errors caught when evaluating
   * expressions.
   */

  warnExpressionErrors: true,

  /**
   * Whether to allow devtools inspection.
   * Disabled by default in production builds.
   */

  devtools: process.env.NODE_ENV !== 'production',

  /**
   * Internal flag to indicate the delimiters have been
   * changed.
   *
   * @type {Boolean}
   */

  _delimitersChanged: true,

  /**
   * List of asset types that a component can own.
   *
   * @type {Array}
   */

  _assetTypes: ['component', 'directive', 'elementDirective', 'filter', 'transition', 'partial'],

  /**
   * prop binding modes
   */

  _propBindingModes: {
    ONE_WAY: 0,
    TWO_WAY: 1,
    ONE_TIME: 2
  },

  /**
   * Max circular updates allowed in a batcher flush cycle.
   */

  _maxUpdateCount: 100

}, {
  delimiters: { /**
                 * Interpolation delimiters. Changing these would trigger
                 * the text parser to re-compile the regular expressions.
                 *
                 * @type {Array<String>}
                 */

    get: function get() {
      return delimiters;
    },
    set: function set(val) {
      delimiters = val;
      compileRegex();
    },
    configurable: true,
    enumerable: true
  },
  unsafeDelimiters: {
    get: function get() {
      return unsafeDelimiters;
    },
    set: function set(val) {
      unsafeDelimiters = val;
      compileRegex();
    },
    configurable: true,
    enumerable: true
  }
});

var warn = undefined;
var formatComponentName = undefined;

if (process.env.NODE_ENV !== 'production') {
  (function () {
    var hasConsole = typeof console !== 'undefined';

    warn = function (msg, vm) {
      if (hasConsole && !config.silent) {
        console.error('[Vue warn]: ' + msg + (vm ? formatComponentName(vm) : ''));
      }
    };

    formatComponentName = function (vm) {
      var name = vm._isVue ? vm.$options.name : vm.name;
      return name ? ' (found in component: <' + hyphenate(name) + '>)' : '';
    };
  })();
}

/**
 * Append with transition.
 *
 * @param {Element} el
 * @param {Element} target
 * @param {Vue} vm
 * @param {Function} [cb]
 */

function appendWithTransition(el, target, vm, cb) {
  applyTransition(el, 1, function () {
    target.appendChild(el);
  }, vm, cb);
}

/**
 * InsertBefore with transition.
 *
 * @param {Element} el
 * @param {Element} target
 * @param {Vue} vm
 * @param {Function} [cb]
 */

function beforeWithTransition(el, target, vm, cb) {
  applyTransition(el, 1, function () {
    before(el, target);
  }, vm, cb);
}

/**
 * Remove with transition.
 *
 * @param {Element} el
 * @param {Vue} vm
 * @param {Function} [cb]
 */

function removeWithTransition(el, vm, cb) {
  applyTransition(el, -1, function () {
    remove(el);
  }, vm, cb);
}

/**
 * Apply transitions with an operation callback.
 *
 * @param {Element} el
 * @param {Number} direction
 *                  1: enter
 *                 -1: leave
 * @param {Function} op - the actual DOM operation
 * @param {Vue} vm
 * @param {Function} [cb]
 */

function applyTransition(el, direction, op, vm, cb) {
  var transition = el.__v_trans;
  if (!transition ||
  // skip if there are no js hooks and CSS transition is
  // not supported
  !transition.hooks && !transitionEndEvent ||
  // skip transitions for initial compile
  !vm._isCompiled ||
  // if the vm is being manipulated by a parent directive
  // during the parent's compilation phase, skip the
  // animation.
  vm.$parent && !vm.$parent._isCompiled) {
    op();
    if (cb) cb();
    return;
  }
  var action = direction > 0 ? 'enter' : 'leave';
  transition[action](op, cb);
}

var transition = Object.freeze({
  appendWithTransition: appendWithTransition,
  beforeWithTransition: beforeWithTransition,
  removeWithTransition: removeWithTransition,
  applyTransition: applyTransition
});

/**
 * Query an element selector if it's not an element already.
 *
 * @param {String|Element} el
 * @return {Element}
 */

function query(el) {
  if (typeof el === 'string') {
    var selector = el;
    el = document.querySelector(el);
    if (!el) {
      process.env.NODE_ENV !== 'production' && warn('Cannot find element: ' + selector);
    }
  }
  return el;
}

/**
 * Check if a node is in the document.
 * Note: document.documentElement.contains should work here
 * but always returns false for comment nodes in phantomjs,
 * making unit tests difficult. This is fixed by doing the
 * contains() check on the node's parentNode instead of
 * the node itself.
 *
 * @param {Node} node
 * @return {Boolean}
 */

function inDoc(node) {
  if (!node) return false;
  var doc = node.ownerDocument.documentElement;
  var parent = node.parentNode;
  return doc === node || doc === parent || !!(parent && parent.nodeType === 1 && doc.contains(parent));
}

/**
 * Get and remove an attribute from a node.
 *
 * @param {Node} node
 * @param {String} _attr
 */

function getAttr(node, _attr) {
  var val = node.getAttribute(_attr);
  if (val !== null) {
    node.removeAttribute(_attr);
  }
  return val;
}

/**
 * Get an attribute with colon or v-bind: prefix.
 *
 * @param {Node} node
 * @param {String} name
 * @return {String|null}
 */

function getBindAttr(node, name) {
  var val = getAttr(node, ':' + name);
  if (val === null) {
    val = getAttr(node, 'v-bind:' + name);
  }
  return val;
}

/**
 * Check the presence of a bind attribute.
 *
 * @param {Node} node
 * @param {String} name
 * @return {Boolean}
 */

function hasBindAttr(node, name) {
  return node.hasAttribute(name) || node.hasAttribute(':' + name) || node.hasAttribute('v-bind:' + name);
}

/**
 * Insert el before target
 *
 * @param {Element} el
 * @param {Element} target
 */

function before(el, target) {
  target.parentNode.insertBefore(el, target);
}

/**
 * Insert el after target
 *
 * @param {Element} el
 * @param {Element} target
 */

function after(el, target) {
  if (target.nextSibling) {
    before(el, target.nextSibling);
  } else {
    target.parentNode.appendChild(el);
  }
}

/**
 * Remove el from DOM
 *
 * @param {Element} el
 */

function remove(el) {
  el.parentNode.removeChild(el);
}

/**
 * Prepend el to target
 *
 * @param {Element} el
 * @param {Element} target
 */

function prepend(el, target) {
  if (target.firstChild) {
    before(el, target.firstChild);
  } else {
    target.appendChild(el);
  }
}

/**
 * Replace target with el
 *
 * @param {Element} target
 * @param {Element} el
 */

function replace(target, el) {
  var parent = target.parentNode;
  if (parent) {
    parent.replaceChild(el, target);
  }
}

/**
 * Add event listener shorthand.
 *
 * @param {Element} el
 * @param {String} event
 * @param {Function} cb
 * @param {Boolean} [useCapture]
 */

function on(el, event, cb, useCapture) {
  el.addEventListener(event, cb, useCapture);
}

/**
 * Remove event listener shorthand.
 *
 * @param {Element} el
 * @param {String} event
 * @param {Function} cb
 */

function off(el, event, cb) {
  el.removeEventListener(event, cb);
}

/**
 * For IE9 compat: when both class and :class are present
 * getAttribute('class') returns wrong value...
 *
 * @param {Element} el
 * @return {String}
 */

function getClass(el) {
  var classname = el.className;
  if (typeof classname === 'object') {
    classname = classname.baseVal || '';
  }
  return classname;
}

/**
 * In IE9, setAttribute('class') will result in empty class
 * if the element also has the :class attribute; However in
 * PhantomJS, setting `className` does not work on SVG elements...
 * So we have to do a conditional check here.
 *
 * @param {Element} el
 * @param {String} cls
 */

function setClass(el, cls) {
  /* istanbul ignore if */
  if (isIE9 && !/svg$/.test(el.namespaceURI)) {
    el.className = cls;
  } else {
    el.setAttribute('class', cls);
  }
}

/**
 * Add class with compatibility for IE & SVG
 *
 * @param {Element} el
 * @param {String} cls
 */

function addClass(el, cls) {
  if (el.classList) {
    el.classList.add(cls);
  } else {
    var cur = ' ' + getClass(el) + ' ';
    if (cur.indexOf(' ' + cls + ' ') < 0) {
      setClass(el, (cur + cls).trim());
    }
  }
}

/**
 * Remove class with compatibility for IE & SVG
 *
 * @param {Element} el
 * @param {String} cls
 */

function removeClass(el, cls) {
  if (el.classList) {
    el.classList.remove(cls);
  } else {
    var cur = ' ' + getClass(el) + ' ';
    var tar = ' ' + cls + ' ';
    while (cur.indexOf(tar) >= 0) {
      cur = cur.replace(tar, ' ');
    }
    setClass(el, cur.trim());
  }
  if (!el.className) {
    el.removeAttribute('class');
  }
}

/**
 * Extract raw content inside an element into a temporary
 * container div
 *
 * @param {Element} el
 * @param {Boolean} asFragment
 * @return {Element|DocumentFragment}
 */

function extractContent(el, asFragment) {
  var child;
  var rawContent;
  /* istanbul ignore if */
  if (isTemplate(el) && isFragment(el.content)) {
    el = el.content;
  }
  if (el.hasChildNodes()) {
    trimNode(el);
    rawContent = asFragment ? document.createDocumentFragment() : document.createElement('div');
    /* eslint-disable no-cond-assign */
    while (child = el.firstChild) {
      /* eslint-enable no-cond-assign */
      rawContent.appendChild(child);
    }
  }
  return rawContent;
}

/**
 * Trim possible empty head/tail text and comment
 * nodes inside a parent.
 *
 * @param {Node} node
 */

function trimNode(node) {
  var child;
  /* eslint-disable no-sequences */
  while ((child = node.firstChild, isTrimmable(child))) {
    node.removeChild(child);
  }
  while ((child = node.lastChild, isTrimmable(child))) {
    node.removeChild(child);
  }
  /* eslint-enable no-sequences */
}

function isTrimmable(node) {
  return node && (node.nodeType === 3 && !node.data.trim() || node.nodeType === 8);
}

/**
 * Check if an element is a template tag.
 * Note if the template appears inside an SVG its tagName
 * will be in lowercase.
 *
 * @param {Element} el
 */

function isTemplate(el) {
  return el.tagName && el.tagName.toLowerCase() === 'template';
}

/**
 * Create an "anchor" for performing dom insertion/removals.
 * This is used in a number of scenarios:
 * - fragment instance
 * - v-html
 * - v-if
 * - v-for
 * - component
 *
 * @param {String} content
 * @param {Boolean} persist - IE trashes empty textNodes on
 *                            cloneNode(true), so in certain
 *                            cases the anchor needs to be
 *                            non-empty to be persisted in
 *                            templates.
 * @return {Comment|Text}
 */

function createAnchor(content, persist) {
  var anchor = config.debug ? document.createComment(content) : document.createTextNode(persist ? ' ' : '');
  anchor.__v_anchor = true;
  return anchor;
}

/**
 * Find a component ref attribute that starts with $.
 *
 * @param {Element} node
 * @return {String|undefined}
 */

var refRE = /^v-ref:/;

function findRef(node) {
  if (node.hasAttributes()) {
    var attrs = node.attributes;
    for (var i = 0, l = attrs.length; i < l; i++) {
      var name = attrs[i].name;
      if (refRE.test(name)) {
        return camelize(name.replace(refRE, ''));
      }
    }
  }
}

/**
 * Map a function to a range of nodes .
 *
 * @param {Node} node
 * @param {Node} end
 * @param {Function} op
 */

function mapNodeRange(node, end, op) {
  var next;
  while (node !== end) {
    next = node.nextSibling;
    op(node);
    node = next;
  }
  op(end);
}

/**
 * Remove a range of nodes with transition, store
 * the nodes in a fragment with correct ordering,
 * and call callback when done.
 *
 * @param {Node} start
 * @param {Node} end
 * @param {Vue} vm
 * @param {DocumentFragment} frag
 * @param {Function} cb
 */

function removeNodeRange(start, end, vm, frag, cb) {
  var done = false;
  var removed = 0;
  var nodes = [];
  mapNodeRange(start, end, function (node) {
    if (node === end) done = true;
    nodes.push(node);
    removeWithTransition(node, vm, onRemoved);
  });
  function onRemoved() {
    removed++;
    if (done && removed >= nodes.length) {
      for (var i = 0; i < nodes.length; i++) {
        frag.appendChild(nodes[i]);
      }
      cb && cb();
    }
  }
}

/**
 * Check if a node is a DocumentFragment.
 *
 * @param {Node} node
 * @return {Boolean}
 */

function isFragment(node) {
  return node && node.nodeType === 11;
}

/**
 * Get outerHTML of elements, taking care
 * of SVG elements in IE as well.
 *
 * @param {Element} el
 * @return {String}
 */

function getOuterHTML(el) {
  if (el.outerHTML) {
    return el.outerHTML;
  } else {
    var container = document.createElement('div');
    container.appendChild(el.cloneNode(true));
    return container.innerHTML;
  }
}

var commonTagRE = /^(div|p|span|img|a|b|i|br|ul|ol|li|h1|h2|h3|h4|h5|h6|code|pre|table|th|td|tr|form|label|input|select|option|nav|article|section|header|footer)$/i;
var reservedTagRE = /^(slot|partial|component)$/i;

var isUnknownElement = undefined;
if (process.env.NODE_ENV !== 'production') {
  isUnknownElement = function (el, tag) {
    if (tag.indexOf('-') > -1) {
      // http://stackoverflow.com/a/28210364/1070244
      return el.constructor === window.HTMLUnknownElement || el.constructor === window.HTMLElement;
    } else {
      return (/HTMLUnknownElement/.test(el.toString()) &&
        // Chrome returns unknown for several HTML5 elements.
        // https://code.google.com/p/chromium/issues/detail?id=540526
        // Firefox returns unknown for some "Interactive elements."
        !/^(data|time|rtc|rb|details|dialog|summary)$/.test(tag)
      );
    }
  };
}

/**
 * Check if an element is a component, if yes return its
 * component id.
 *
 * @param {Element} el
 * @param {Object} options
 * @return {Object|undefined}
 */

function checkComponentAttr(el, options) {
  var tag = el.tagName.toLowerCase();
  var hasAttrs = el.hasAttributes();
  if (!commonTagRE.test(tag) && !reservedTagRE.test(tag)) {
    if (resolveAsset(options, 'components', tag)) {
      return { id: tag };
    } else {
      var is = hasAttrs && getIsBinding(el, options);
      if (is) {
        return is;
      } else if (process.env.NODE_ENV !== 'production') {
        var expectedTag = options._componentNameMap && options._componentNameMap[tag];
        if (expectedTag) {
          warn('Unknown custom element: <' + tag + '> - ' + 'did you mean <' + expectedTag + '>? ' + 'HTML is case-insensitive, remember to use kebab-case in templates.');
        } else if (isUnknownElement(el, tag)) {
          warn('Unknown custom element: <' + tag + '> - did you ' + 'register the component correctly? For recursive components, ' + 'make sure to provide the "name" option.');
        }
      }
    }
  } else if (hasAttrs) {
    return getIsBinding(el, options);
  }
}

/**
 * Get "is" binding from an element.
 *
 * @param {Element} el
 * @param {Object} options
 * @return {Object|undefined}
 */

function getIsBinding(el, options) {
  // dynamic syntax
  var exp = el.getAttribute('is');
  if (exp != null) {
    if (resolveAsset(options, 'components', exp)) {
      el.removeAttribute('is');
      return { id: exp };
    }
  } else {
    exp = getBindAttr(el, 'is');
    if (exp != null) {
      return { id: exp, dynamic: true };
    }
  }
}

/**
 * Option overwriting strategies are functions that handle
 * how to merge a parent option value and a child option
 * value into the final value.
 *
 * All strategy functions follow the same signature:
 *
 * @param {*} parentVal
 * @param {*} childVal
 * @param {Vue} [vm]
 */

var strats = config.optionMergeStrategies = Object.create(null);

/**
 * Helper that recursively merges two data objects together.
 */

function mergeData(to, from) {
  var key, toVal, fromVal;
  for (key in from) {
    toVal = to[key];
    fromVal = from[key];
    if (!hasOwn(to, key)) {
      set(to, key, fromVal);
    } else if (isObject(toVal) && isObject(fromVal)) {
      mergeData(toVal, fromVal);
    }
  }
  return to;
}

/**
 * Data
 */

strats.data = function (parentVal, childVal, vm) {
  if (!vm) {
    // in a Vue.extend merge, both should be functions
    if (!childVal) {
      return parentVal;
    }
    if (typeof childVal !== 'function') {
      process.env.NODE_ENV !== 'production' && warn('The "data" option should be a function ' + 'that returns a per-instance value in component ' + 'definitions.', vm);
      return parentVal;
    }
    if (!parentVal) {
      return childVal;
    }
    // when parentVal & childVal are both present,
    // we need to return a function that returns the
    // merged result of both functions... no need to
    // check if parentVal is a function here because
    // it has to be a function to pass previous merges.
    return function mergedDataFn() {
      return mergeData(childVal.call(this), parentVal.call(this));
    };
  } else if (parentVal || childVal) {
    return function mergedInstanceDataFn() {
      // instance merge
      var instanceData = typeof childVal === 'function' ? childVal.call(vm) : childVal;
      var defaultData = typeof parentVal === 'function' ? parentVal.call(vm) : undefined;
      if (instanceData) {
        return mergeData(instanceData, defaultData);
      } else {
        return defaultData;
      }
    };
  }
};

/**
 * El
 */

strats.el = function (parentVal, childVal, vm) {
  if (!vm && childVal && typeof childVal !== 'function') {
    process.env.NODE_ENV !== 'production' && warn('The "el" option should be a function ' + 'that returns a per-instance value in component ' + 'definitions.', vm);
    return;
  }
  var ret = childVal || parentVal;
  // invoke the element factory if this is instance merge
  return vm && typeof ret === 'function' ? ret.call(vm) : ret;
};

/**
 * Hooks and param attributes are merged as arrays.
 */

strats.init = strats.created = strats.ready = strats.attached = strats.detached = strats.beforeCompile = strats.compiled = strats.beforeDestroy = strats.destroyed = strats.activate = function (parentVal, childVal) {
  return childVal ? parentVal ? parentVal.concat(childVal) : isArray(childVal) ? childVal : [childVal] : parentVal;
};

/**
 * Assets
 *
 * When a vm is present (instance creation), we need to do
 * a three-way merge between constructor options, instance
 * options and parent options.
 */

function mergeAssets(parentVal, childVal) {
  var res = Object.create(parentVal || null);
  return childVal ? extend(res, guardArrayAssets(childVal)) : res;
}

config._assetTypes.forEach(function (type) {
  strats[type + 's'] = mergeAssets;
});

/**
 * Events & Watchers.
 *
 * Events & watchers hashes should not overwrite one
 * another, so we merge them as arrays.
 */

strats.watch = strats.events = function (parentVal, childVal) {
  if (!childVal) return parentVal;
  if (!parentVal) return childVal;
  var ret = {};
  extend(ret, parentVal);
  for (var key in childVal) {
    var parent = ret[key];
    var child = childVal[key];
    if (parent && !isArray(parent)) {
      parent = [parent];
    }
    ret[key] = parent ? parent.concat(child) : [child];
  }
  return ret;
};

/**
 * Other object hashes.
 */

strats.props = strats.methods = strats.computed = function (parentVal, childVal) {
  if (!childVal) return parentVal;
  if (!parentVal) return childVal;
  var ret = Object.create(null);
  extend(ret, parentVal);
  extend(ret, childVal);
  return ret;
};

/**
 * Default strategy.
 */

var defaultStrat = function defaultStrat(parentVal, childVal) {
  return childVal === undefined ? parentVal : childVal;
};

/**
 * Make sure component options get converted to actual
 * constructors.
 *
 * @param {Object} options
 */

function guardComponents(options) {
  if (options.components) {
    var components = options.components = guardArrayAssets(options.components);
    var ids = Object.keys(components);
    var def;
    if (process.env.NODE_ENV !== 'production') {
      var map = options._componentNameMap = {};
    }
    for (var i = 0, l = ids.length; i < l; i++) {
      var key = ids[i];
      if (commonTagRE.test(key) || reservedTagRE.test(key)) {
        process.env.NODE_ENV !== 'production' && warn('Do not use built-in or reserved HTML elements as component ' + 'id: ' + key);
        continue;
      }
      // record a all lowercase <-> kebab-case mapping for
      // possible custom element case error warning
      if (process.env.NODE_ENV !== 'production') {
        map[key.replace(/-/g, '').toLowerCase()] = hyphenate(key);
      }
      def = components[key];
      if (isPlainObject(def)) {
        components[key] = Vue.extend(def);
      }
    }
  }
}

/**
 * Ensure all props option syntax are normalized into the
 * Object-based format.
 *
 * @param {Object} options
 */

function guardProps(options) {
  var props = options.props;
  var i, val;
  if (isArray(props)) {
    options.props = {};
    i = props.length;
    while (i--) {
      val = props[i];
      if (typeof val === 'string') {
        options.props[val] = null;
      } else if (val.name) {
        options.props[val.name] = val;
      }
    }
  } else if (isPlainObject(props)) {
    var keys = Object.keys(props);
    i = keys.length;
    while (i--) {
      val = props[keys[i]];
      if (typeof val === 'function') {
        props[keys[i]] = { type: val };
      }
    }
  }
}

/**
 * Guard an Array-format assets option and converted it
 * into the key-value Object format.
 *
 * @param {Object|Array} assets
 * @return {Object}
 */

function guardArrayAssets(assets) {
  if (isArray(assets)) {
    var res = {};
    var i = assets.length;
    var asset;
    while (i--) {
      asset = assets[i];
      var id = typeof asset === 'function' ? asset.options && asset.options.name || asset.id : asset.name || asset.id;
      if (!id) {
        process.env.NODE_ENV !== 'production' && warn('Array-syntax assets must provide a "name" or "id" field.');
      } else {
        res[id] = asset;
      }
    }
    return res;
  }
  return assets;
}

/**
 * Merge two option objects into a new one.
 * Core utility used in both instantiation and inheritance.
 *
 * @param {Object} parent
 * @param {Object} child
 * @param {Vue} [vm] - if vm is present, indicates this is
 *                     an instantiation merge.
 */

function mergeOptions(parent, child, vm) {
  guardComponents(child);
  guardProps(child);
  if (process.env.NODE_ENV !== 'production') {
    if (child.propsData && !vm) {
      warn('propsData can only be used as an instantiation option.');
    }
  }
  var options = {};
  var key;
  if (child['extends']) {
    parent = typeof child['extends'] === 'function' ? mergeOptions(parent, child['extends'].options, vm) : mergeOptions(parent, child['extends'], vm);
  }
  if (child.mixins) {
    for (var i = 0, l = child.mixins.length; i < l; i++) {
      var mixin = child.mixins[i];
      var mixinOptions = mixin.prototype instanceof Vue ? mixin.options : mixin;
      parent = mergeOptions(parent, mixinOptions, vm);
    }
  }
  for (key in parent) {
    mergeField(key);
  }
  for (key in child) {
    if (!hasOwn(parent, key)) {
      mergeField(key);
    }
  }
  function mergeField(key) {
    var strat = strats[key] || defaultStrat;
    options[key] = strat(parent[key], child[key], vm, key);
  }
  return options;
}

/**
 * Resolve an asset.
 * This function is used because child instances need access
 * to assets defined in its ancestor chain.
 *
 * @param {Object} options
 * @param {String} type
 * @param {String} id
 * @param {Boolean} warnMissing
 * @return {Object|Function}
 */

function resolveAsset(options, type, id, warnMissing) {
  /* istanbul ignore if */
  if (typeof id !== 'string') {
    return;
  }
  var assets = options[type];
  var camelizedId;
  var res = assets[id] ||
  // camelCase ID
  assets[camelizedId = camelize(id)] ||
  // Pascal Case ID
  assets[camelizedId.charAt(0).toUpperCase() + camelizedId.slice(1)];
  if (process.env.NODE_ENV !== 'production' && warnMissing && !res) {
    warn('Failed to resolve ' + type.slice(0, -1) + ': ' + id, options);
  }
  return res;
}

var uid$1 = 0;

/**
 * A dep is an observable that can have multiple
 * directives subscribing to it.
 *
 * @constructor
 */
function Dep() {
  this.id = uid$1++;
  this.subs = [];
}

// the current target watcher being evaluated.
// this is globally unique because there could be only one
// watcher being evaluated at any time.
Dep.target = null;

/**
 * Add a directive subscriber.
 *
 * @param {Directive} sub
 */

Dep.prototype.addSub = function (sub) {
  this.subs.push(sub);
};

/**
 * Remove a directive subscriber.
 *
 * @param {Directive} sub
 */

Dep.prototype.removeSub = function (sub) {
  this.subs.$remove(sub);
};

/**
 * Add self as a dependency to the target watcher.
 */

Dep.prototype.depend = function () {
  Dep.target.addDep(this);
};

/**
 * Notify all subscribers of a new value.
 */

Dep.prototype.notify = function () {
  // stablize the subscriber list first
  var subs = toArray(this.subs);
  for (var i = 0, l = subs.length; i < l; i++) {
    subs[i].update();
  }
};

var arrayProto = Array.prototype;
var arrayMethods = Object.create(arrayProto)

/**
 * Intercept mutating methods and emit events
 */

;['push', 'pop', 'shift', 'unshift', 'splice', 'sort', 'reverse'].forEach(function (method) {
  // cache original method
  var original = arrayProto[method];
  def(arrayMethods, method, function mutator() {
    // avoid leaking arguments:
    // http://jsperf.com/closure-with-arguments
    var i = arguments.length;
    var args = new Array(i);
    while (i--) {
      args[i] = arguments[i];
    }
    var result = original.apply(this, args);
    var ob = this.__ob__;
    var inserted;
    switch (method) {
      case 'push':
        inserted = args;
        break;
      case 'unshift':
        inserted = args;
        break;
      case 'splice':
        inserted = args.slice(2);
        break;
    }
    if (inserted) ob.observeArray(inserted);
    // notify change
    ob.dep.notify();
    return result;
  });
});

/**
 * Swap the element at the given index with a new value
 * and emits corresponding event.
 *
 * @param {Number} index
 * @param {*} val
 * @return {*} - replaced element
 */

def(arrayProto, '$set', function $set(index, val) {
  if (index >= this.length) {
    this.length = Number(index) + 1;
  }
  return this.splice(index, 1, val)[0];
});

/**
 * Convenience method to remove the element at given index or target element reference.
 *
 * @param {*} item
 */

def(arrayProto, '$remove', function $remove(item) {
  /* istanbul ignore if */
  if (!this.length) return;
  var index = indexOf(this, item);
  if (index > -1) {
    return this.splice(index, 1);
  }
});

var arrayKeys = Object.getOwnPropertyNames(arrayMethods);

/**
 * By default, when a reactive property is set, the new value is
 * also converted to become reactive. However in certain cases, e.g.
 * v-for scope alias and props, we don't want to force conversion
 * because the value may be a nested value under a frozen data structure.
 *
 * So whenever we want to set a reactive property without forcing
 * conversion on the new value, we wrap that call inside this function.
 */

var shouldConvert = true;

function withoutConversion(fn) {
  shouldConvert = false;
  fn();
  shouldConvert = true;
}

/**
 * Observer class that are attached to each observed
 * object. Once attached, the observer converts target
 * object's property keys into getter/setters that
 * collect dependencies and dispatches updates.
 *
 * @param {Array|Object} value
 * @constructor
 */

function Observer(value) {
  this.value = value;
  this.dep = new Dep();
  def(value, '__ob__', this);
  if (isArray(value)) {
    var augment = hasProto ? protoAugment : copyAugment;
    augment(value, arrayMethods, arrayKeys);
    this.observeArray(value);
  } else {
    this.walk(value);
  }
}

// Instance methods

/**
 * Walk through each property and convert them into
 * getter/setters. This method should only be called when
 * value type is Object.
 *
 * @param {Object} obj
 */

Observer.prototype.walk = function (obj) {
  var keys = Object.keys(obj);
  for (var i = 0, l = keys.length; i < l; i++) {
    this.convert(keys[i], obj[keys[i]]);
  }
};

/**
 * Observe a list of Array items.
 *
 * @param {Array} items
 */

Observer.prototype.observeArray = function (items) {
  for (var i = 0, l = items.length; i < l; i++) {
    observe(items[i]);
  }
};

/**
 * Convert a property into getter/setter so we can emit
 * the events when the property is accessed/changed.
 *
 * @param {String} key
 * @param {*} val
 */

Observer.prototype.convert = function (key, val) {
  defineReactive(this.value, key, val);
};

/**
 * Add an owner vm, so that when $set/$delete mutations
 * happen we can notify owner vms to proxy the keys and
 * digest the watchers. This is only called when the object
 * is observed as an instance's root $data.
 *
 * @param {Vue} vm
 */

Observer.prototype.addVm = function (vm) {
  (this.vms || (this.vms = [])).push(vm);
};

/**
 * Remove an owner vm. This is called when the object is
 * swapped out as an instance's $data object.
 *
 * @param {Vue} vm
 */

Observer.prototype.removeVm = function (vm) {
  this.vms.$remove(vm);
};

// helpers

/**
 * Augment an target Object or Array by intercepting
 * the prototype chain using __proto__
 *
 * @param {Object|Array} target
 * @param {Object} src
 */

function protoAugment(target, src) {
  /* eslint-disable no-proto */
  target.__proto__ = src;
  /* eslint-enable no-proto */
}

/**
 * Augment an target Object or Array by defining
 * hidden properties.
 *
 * @param {Object|Array} target
 * @param {Object} proto
 */

function copyAugment(target, src, keys) {
  for (var i = 0, l = keys.length; i < l; i++) {
    var key = keys[i];
    def(target, key, src[key]);
  }
}

/**
 * Attempt to create an observer instance for a value,
 * returns the new observer if successfully observed,
 * or the existing observer if the value already has one.
 *
 * @param {*} value
 * @param {Vue} [vm]
 * @return {Observer|undefined}
 * @static
 */

function observe(value, vm) {
  if (!value || typeof value !== 'object') {
    return;
  }
  var ob;
  if (hasOwn(value, '__ob__') && value.__ob__ instanceof Observer) {
    ob = value.__ob__;
  } else if (shouldConvert && (isArray(value) || isPlainObject(value)) && Object.isExtensible(value) && !value._isVue) {
    ob = new Observer(value);
  }
  if (ob && vm) {
    ob.addVm(vm);
  }
  return ob;
}

/**
 * Define a reactive property on an Object.
 *
 * @param {Object} obj
 * @param {String} key
 * @param {*} val
 */

function defineReactive(obj, key, val) {
  var dep = new Dep();

  var property = Object.getOwnPropertyDescriptor(obj, key);
  if (property && property.configurable === false) {
    return;
  }

  // cater for pre-defined getter/setters
  var getter = property && property.get;
  var setter = property && property.set;

  var childOb = observe(val);
  Object.defineProperty(obj, key, {
    enumerable: true,
    configurable: true,
    get: function reactiveGetter() {
      var value = getter ? getter.call(obj) : val;
      if (Dep.target) {
        dep.depend();
        if (childOb) {
          childOb.dep.depend();
        }
        if (isArray(value)) {
          for (var e, i = 0, l = value.length; i < l; i++) {
            e = value[i];
            e && e.__ob__ && e.__ob__.dep.depend();
          }
        }
      }
      return value;
    },
    set: function reactiveSetter(newVal) {
      var value = getter ? getter.call(obj) : val;
      if (newVal === value) {
        return;
      }
      if (setter) {
        setter.call(obj, newVal);
      } else {
        val = newVal;
      }
      childOb = observe(newVal);
      dep.notify();
    }
  });
}



var util = Object.freeze({
	defineReactive: defineReactive,
	set: set,
	del: del,
	hasOwn: hasOwn,
	isLiteral: isLiteral,
	isReserved: isReserved,
	_toString: _toString,
	toNumber: toNumber,
	toBoolean: toBoolean,
	stripQuotes: stripQuotes,
	camelize: camelize,
	hyphenate: hyphenate,
	classify: classify,
	bind: bind,
	toArray: toArray,
	extend: extend,
	isObject: isObject,
	isPlainObject: isPlainObject,
	def: def,
	debounce: _debounce,
	indexOf: indexOf,
	cancellable: cancellable,
	looseEqual: looseEqual,
	isArray: isArray,
	hasProto: hasProto,
	inBrowser: inBrowser,
	devtools: devtools,
	isIE: isIE,
	isIE9: isIE9,
	isAndroid: isAndroid,
	isIos: isIos,
	iosVersionMatch: iosVersionMatch,
	iosVersion: iosVersion,
	hasMutationObserverBug: hasMutationObserverBug,
	get transitionProp () { return transitionProp; },
	get transitionEndEvent () { return transitionEndEvent; },
	get animationProp () { return animationProp; },
	get animationEndEvent () { return animationEndEvent; },
	nextTick: nextTick,
	get _Set () { return _Set; },
	query: query,
	inDoc: inDoc,
	getAttr: getAttr,
	getBindAttr: getBindAttr,
	hasBindAttr: hasBindAttr,
	before: before,
	after: after,
	remove: remove,
	prepend: prepend,
	replace: replace,
	on: on,
	off: off,
	setClass: setClass,
	addClass: addClass,
	removeClass: removeClass,
	extractContent: extractContent,
	trimNode: trimNode,
	isTemplate: isTemplate,
	createAnchor: createAnchor,
	findRef: findRef,
	mapNodeRange: mapNodeRange,
	removeNodeRange: removeNodeRange,
	isFragment: isFragment,
	getOuterHTML: getOuterHTML,
	mergeOptions: mergeOptions,
	resolveAsset: resolveAsset,
	checkComponentAttr: checkComponentAttr,
	commonTagRE: commonTagRE,
	reservedTagRE: reservedTagRE,
	get warn () { return warn; }
});

var uid = 0;

function initMixin (Vue) {
  /**
   * The main init sequence. This is called for every
   * instance, including ones that are created from extended
   * constructors.
   *
   * @param {Object} options - this options object should be
   *                           the result of merging class
   *                           options and the options passed
   *                           in to the constructor.
   */

  Vue.prototype._init = function (options) {
    options = options || {};

    this.$el = null;
    this.$parent = options.parent;
    this.$root = this.$parent ? this.$parent.$root : this;
    this.$children = [];
    this.$refs = {}; // child vm references
    this.$els = {}; // element references
    this._watchers = []; // all watchers as an array
    this._directives = []; // all directives

    // a uid
    this._uid = uid++;

    // a flag to avoid this being observed
    this._isVue = true;

    // events bookkeeping
    this._events = {}; // registered callbacks
    this._eventsCount = {}; // for $broadcast optimization

    // fragment instance properties
    this._isFragment = false;
    this._fragment = // @type {DocumentFragment}
    this._fragmentStart = // @type {Text|Comment}
    this._fragmentEnd = null; // @type {Text|Comment}

    // lifecycle state
    this._isCompiled = this._isDestroyed = this._isReady = this._isAttached = this._isBeingDestroyed = this._vForRemoving = false;
    this._unlinkFn = null;

    // context:
    // if this is a transcluded component, context
    // will be the common parent vm of this instance
    // and its host.
    this._context = options._context || this.$parent;

    // scope:
    // if this is inside an inline v-for, the scope
    // will be the intermediate scope created for this
    // repeat fragment. this is used for linking props
    // and container directives.
    this._scope = options._scope;

    // fragment:
    // if this instance is compiled inside a Fragment, it
    // needs to reigster itself as a child of that fragment
    // for attach/detach to work properly.
    this._frag = options._frag;
    if (this._frag) {
      this._frag.children.push(this);
    }

    // push self into parent / transclusion host
    if (this.$parent) {
      this.$parent.$children.push(this);
    }

    // merge options.
    options = this.$options = mergeOptions(this.constructor.options, options, this);

    // set ref
    this._updateRef();

    // initialize data as empty object.
    // it will be filled up in _initData().
    this._data = {};

    // call init hook
    this._callHook('init');

    // initialize data observation and scope inheritance.
    this._initState();

    // setup event system and option events.
    this._initEvents();

    // call created hook
    this._callHook('created');

    // if `el` option is passed, start compilation.
    if (options.el) {
      this.$mount(options.el);
    }
  };
}

var pathCache = new Cache(1000);

// actions
var APPEND = 0;
var PUSH = 1;
var INC_SUB_PATH_DEPTH = 2;
var PUSH_SUB_PATH = 3;

// states
var BEFORE_PATH = 0;
var IN_PATH = 1;
var BEFORE_IDENT = 2;
var IN_IDENT = 3;
var IN_SUB_PATH = 4;
var IN_SINGLE_QUOTE = 5;
var IN_DOUBLE_QUOTE = 6;
var AFTER_PATH = 7;
var ERROR = 8;

var pathStateMachine = [];

pathStateMachine[BEFORE_PATH] = {
  'ws': [BEFORE_PATH],
  'ident': [IN_IDENT, APPEND],
  '[': [IN_SUB_PATH],
  'eof': [AFTER_PATH]
};

pathStateMachine[IN_PATH] = {
  'ws': [IN_PATH],
  '.': [BEFORE_IDENT],
  '[': [IN_SUB_PATH],
  'eof': [AFTER_PATH]
};

pathStateMachine[BEFORE_IDENT] = {
  'ws': [BEFORE_IDENT],
  'ident': [IN_IDENT, APPEND]
};

pathStateMachine[IN_IDENT] = {
  'ident': [IN_IDENT, APPEND],
  '0': [IN_IDENT, APPEND],
  'number': [IN_IDENT, APPEND],
  'ws': [IN_PATH, PUSH],
  '.': [BEFORE_IDENT, PUSH],
  '[': [IN_SUB_PATH, PUSH],
  'eof': [AFTER_PATH, PUSH]
};

pathStateMachine[IN_SUB_PATH] = {
  "'": [IN_SINGLE_QUOTE, APPEND],
  '"': [IN_DOUBLE_QUOTE, APPEND],
  '[': [IN_SUB_PATH, INC_SUB_PATH_DEPTH],
  ']': [IN_PATH, PUSH_SUB_PATH],
  'eof': ERROR,
  'else': [IN_SUB_PATH, APPEND]
};

pathStateMachine[IN_SINGLE_QUOTE] = {
  "'": [IN_SUB_PATH, APPEND],
  'eof': ERROR,
  'else': [IN_SINGLE_QUOTE, APPEND]
};

pathStateMachine[IN_DOUBLE_QUOTE] = {
  '"': [IN_SUB_PATH, APPEND],
  'eof': ERROR,
  'else': [IN_DOUBLE_QUOTE, APPEND]
};

/**
 * Determine the type of a character in a keypath.
 *
 * @param {Char} ch
 * @return {String} type
 */

function getPathCharType(ch) {
  if (ch === undefined) {
    return 'eof';
  }

  var code = ch.charCodeAt(0);

  switch (code) {
    case 0x5B: // [
    case 0x5D: // ]
    case 0x2E: // .
    case 0x22: // "
    case 0x27: // '
    case 0x30:
      // 0
      return ch;

    case 0x5F: // _
    case 0x24:
      // $
      return 'ident';

    case 0x20: // Space
    case 0x09: // Tab
    case 0x0A: // Newline
    case 0x0D: // Return
    case 0xA0: // No-break space
    case 0xFEFF: // Byte Order Mark
    case 0x2028: // Line Separator
    case 0x2029:
      // Paragraph Separator
      return 'ws';
  }

  // a-z, A-Z
  if (code >= 0x61 && code <= 0x7A || code >= 0x41 && code <= 0x5A) {
    return 'ident';
  }

  // 1-9
  if (code >= 0x31 && code <= 0x39) {
    return 'number';
  }

  return 'else';
}

/**
 * Format a subPath, return its plain form if it is
 * a literal string or number. Otherwise prepend the
 * dynamic indicator (*).
 *
 * @param {String} path
 * @return {String}
 */

function formatSubPath(path) {
  var trimmed = path.trim();
  // invalid leading 0
  if (path.charAt(0) === '0' && isNaN(path)) {
    return false;
  }
  return isLiteral(trimmed) ? stripQuotes(trimmed) : '*' + trimmed;
}

/**
 * Parse a string path into an array of segments
 *
 * @param {String} path
 * @return {Array|undefined}
 */

function parse(path) {
  var keys = [];
  var index = -1;
  var mode = BEFORE_PATH;
  var subPathDepth = 0;
  var c, newChar, key, type, transition, action, typeMap;

  var actions = [];

  actions[PUSH] = function () {
    if (key !== undefined) {
      keys.push(key);
      key = undefined;
    }
  };

  actions[APPEND] = function () {
    if (key === undefined) {
      key = newChar;
    } else {
      key += newChar;
    }
  };

  actions[INC_SUB_PATH_DEPTH] = function () {
    actions[APPEND]();
    subPathDepth++;
  };

  actions[PUSH_SUB_PATH] = function () {
    if (subPathDepth > 0) {
      subPathDepth--;
      mode = IN_SUB_PATH;
      actions[APPEND]();
    } else {
      subPathDepth = 0;
      key = formatSubPath(key);
      if (key === false) {
        return false;
      } else {
        actions[PUSH]();
      }
    }
  };

  function maybeUnescapeQuote() {
    var nextChar = path[index + 1];
    if (mode === IN_SINGLE_QUOTE && nextChar === "'" || mode === IN_DOUBLE_QUOTE && nextChar === '"') {
      index++;
      newChar = '\\' + nextChar;
      actions[APPEND]();
      return true;
    }
  }

  while (mode != null) {
    index++;
    c = path[index];

    if (c === '\\' && maybeUnescapeQuote()) {
      continue;
    }

    type = getPathCharType(c);
    typeMap = pathStateMachine[mode];
    transition = typeMap[type] || typeMap['else'] || ERROR;

    if (transition === ERROR) {
      return; // parse error
    }

    mode = transition[0];
    action = actions[transition[1]];
    if (action) {
      newChar = transition[2];
      newChar = newChar === undefined ? c : newChar;
      if (action() === false) {
        return;
      }
    }

    if (mode === AFTER_PATH) {
      keys.raw = path;
      return keys;
    }
  }
}

/**
 * External parse that check for a cache hit first
 *
 * @param {String} path
 * @return {Array|undefined}
 */

function parsePath(path) {
  var hit = pathCache.get(path);
  if (!hit) {
    hit = parse(path);
    if (hit) {
      pathCache.put(path, hit);
    }
  }
  return hit;
}

/**
 * Get from an object from a path string
 *
 * @param {Object} obj
 * @param {String} path
 */

function getPath(obj, path) {
  return parseExpression(path).get(obj);
}

/**
 * Warn against setting non-existent root path on a vm.
 */

var warnNonExistent;
if (process.env.NODE_ENV !== 'production') {
  warnNonExistent = function (path, vm) {
    warn('You are setting a non-existent path "' + path.raw + '" ' + 'on a vm instance. Consider pre-initializing the property ' + 'with the "data" option for more reliable reactivity ' + 'and better performance.', vm);
  };
}

/**
 * Set on an object from a path
 *
 * @param {Object} obj
 * @param {String | Array} path
 * @param {*} val
 */

function setPath(obj, path, val) {
  var original = obj;
  if (typeof path === 'string') {
    path = parse(path);
  }
  if (!path || !isObject(obj)) {
    return false;
  }
  var last, key;
  for (var i = 0, l = path.length; i < l; i++) {
    last = obj;
    key = path[i];
    if (key.charAt(0) === '*') {
      key = parseExpression(key.slice(1)).get.call(original, original);
    }
    if (i < l - 1) {
      obj = obj[key];
      if (!isObject(obj)) {
        obj = {};
        if (process.env.NODE_ENV !== 'production' && last._isVue) {
          warnNonExistent(path, last);
        }
        set(last, key, obj);
      }
    } else {
      if (isArray(obj)) {
        obj.$set(key, val);
      } else if (key in obj) {
        obj[key] = val;
      } else {
        if (process.env.NODE_ENV !== 'production' && obj._isVue) {
          warnNonExistent(path, obj);
        }
        set(obj, key, val);
      }
    }
  }
  return true;
}

var path = Object.freeze({
  parsePath: parsePath,
  getPath: getPath,
  setPath: setPath
});

var expressionCache = new Cache(1000);

var allowedKeywords = 'Math,Date,this,true,false,null,undefined,Infinity,NaN,' + 'isNaN,isFinite,decodeURI,decodeURIComponent,encodeURI,' + 'encodeURIComponent,parseInt,parseFloat';
var allowedKeywordsRE = new RegExp('^(' + allowedKeywords.replace(/,/g, '\\b|') + '\\b)');

// keywords that don't make sense inside expressions
var improperKeywords = 'break,case,class,catch,const,continue,debugger,default,' + 'delete,do,else,export,extends,finally,for,function,if,' + 'import,in,instanceof,let,return,super,switch,throw,try,' + 'var,while,with,yield,enum,await,implements,package,' + 'protected,static,interface,private,public';
var improperKeywordsRE = new RegExp('^(' + improperKeywords.replace(/,/g, '\\b|') + '\\b)');

var wsRE = /\s/g;
var newlineRE = /\n/g;
var saveRE = /[\{,]\s*[\w\$_]+\s*:|('(?:[^'\\]|\\.)*'|"(?:[^"\\]|\\.)*"|`(?:[^`\\]|\\.)*\$\{|\}(?:[^`\\]|\\.)*`|`(?:[^`\\]|\\.)*`)|new |typeof |void /g;
var restoreRE = /"(\d+)"/g;
var pathTestRE = /^[A-Za-z_$][\w$]*(?:\.[A-Za-z_$][\w$]*|\['.*?'\]|\[".*?"\]|\[\d+\]|\[[A-Za-z_$][\w$]*\])*$/;
var identRE = /[^\w$\.](?:[A-Za-z_$][\w$]*)/g;
var literalValueRE$1 = /^(?:true|false|null|undefined|Infinity|NaN)$/;

function noop() {}

/**
 * Save / Rewrite / Restore
 *
 * When rewriting paths found in an expression, it is
 * possible for the same letter sequences to be found in
 * strings and Object literal property keys. Therefore we
 * remove and store these parts in a temporary array, and
 * restore them after the path rewrite.
 */

var saved = [];

/**
 * Save replacer
 *
 * The save regex can match two possible cases:
 * 1. An opening object literal
 * 2. A string
 * If matched as a plain string, we need to escape its
 * newlines, since the string needs to be preserved when
 * generating the function body.
 *
 * @param {String} str
 * @param {String} isString - str if matched as a string
 * @return {String} - placeholder with index
 */

function save(str, isString) {
  var i = saved.length;
  saved[i] = isString ? str.replace(newlineRE, '\\n') : str;
  return '"' + i + '"';
}

/**
 * Path rewrite replacer
 *
 * @param {String} raw
 * @return {String}
 */

function rewrite(raw) {
  var c = raw.charAt(0);
  var path = raw.slice(1);
  if (allowedKeywordsRE.test(path)) {
    return raw;
  } else {
    path = path.indexOf('"') > -1 ? path.replace(restoreRE, restore) : path;
    return c + 'scope.' + path;
  }
}

/**
 * Restore replacer
 *
 * @param {String} str
 * @param {String} i - matched save index
 * @return {String}
 */

function restore(str, i) {
  return saved[i];
}

/**
 * Rewrite an expression, prefixing all path accessors with
 * `scope.` and generate getter/setter functions.
 *
 * @param {String} exp
 * @return {Function}
 */

function compileGetter(exp) {
  if (improperKeywordsRE.test(exp)) {
    process.env.NODE_ENV !== 'production' && warn('Avoid using reserved keywords in expression: ' + exp);
  }
  // reset state
  saved.length = 0;
  // save strings and object literal keys
  var body = exp.replace(saveRE, save).replace(wsRE, '');
  // rewrite all paths
  // pad 1 space here because the regex matches 1 extra char
  body = (' ' + body).replace(identRE, rewrite).replace(restoreRE, restore);
  return makeGetterFn(body);
}

/**
 * Build a getter function. Requires eval.
 *
 * We isolate the try/catch so it doesn't affect the
 * optimization of the parse function when it is not called.
 *
 * @param {String} body
 * @return {Function|undefined}
 */

function makeGetterFn(body) {
  try {
    /* eslint-disable no-new-func */
    return new Function('scope', 'return ' + body + ';');
    /* eslint-enable no-new-func */
  } catch (e) {
    if (process.env.NODE_ENV !== 'production') {
      /* istanbul ignore if */
      if (e.toString().match(/unsafe-eval|CSP/)) {
        warn('It seems you are using the default build of Vue.js in an environment ' + 'with Content Security Policy that prohibits unsafe-eval. ' + 'Use the CSP-compliant build instead: ' + 'http://vuejs.org/guide/installation.html#CSP-compliant-build');
      } else {
        warn('Invalid expression. ' + 'Generated function body: ' + body);
      }
    }
    return noop;
  }
}

/**
 * Compile a setter function for the expression.
 *
 * @param {String} exp
 * @return {Function|undefined}
 */

function compileSetter(exp) {
  var path = parsePath(exp);
  if (path) {
    return function (scope, val) {
      setPath(scope, path, val);
    };
  } else {
    process.env.NODE_ENV !== 'production' && warn('Invalid setter expression: ' + exp);
  }
}

/**
 * Parse an expression into re-written getter/setters.
 *
 * @param {String} exp
 * @param {Boolean} needSet
 * @return {Function}
 */

function parseExpression(exp, needSet) {
  exp = exp.trim();
  // try cache
  var hit = expressionCache.get(exp);
  if (hit) {
    if (needSet && !hit.set) {
      hit.set = compileSetter(hit.exp);
    }
    return hit;
  }
  var res = { exp: exp };
  res.get = isSimplePath(exp) && exp.indexOf('[') < 0
  // optimized super simple getter
  ? makeGetterFn('scope.' + exp)
  // dynamic getter
  : compileGetter(exp);
  if (needSet) {
    res.set = compileSetter(exp);
  }
  expressionCache.put(exp, res);
  return res;
}

/**
 * Check if an expression is a simple path.
 *
 * @param {String} exp
 * @return {Boolean}
 */

function isSimplePath(exp) {
  return pathTestRE.test(exp) &&
  // don't treat literal values as paths
  !literalValueRE$1.test(exp) &&
  // Math constants e.g. Math.PI, Math.E etc.
  exp.slice(0, 5) !== 'Math.';
}

var expression = Object.freeze({
  parseExpression: parseExpression,
  isSimplePath: isSimplePath
});

// we have two separate queues: one for directive updates
// and one for user watcher registered via $watch().
// we want to guarantee directive updates to be called
// before user watchers so that when user watchers are
// triggered, the DOM would have already been in updated
// state.

var queue = [];
var userQueue = [];
var has = {};
var circular = {};
var waiting = false;

/**
 * Reset the batcher's state.
 */

function resetBatcherState() {
  queue.length = 0;
  userQueue.length = 0;
  has = {};
  circular = {};
  waiting = false;
}

/**
 * Flush both queues and run the watchers.
 */

function flushBatcherQueue() {
  var _again = true;

  _function: while (_again) {
    _again = false;

    runBatcherQueue(queue);
    runBatcherQueue(userQueue);
    // user watchers triggered more watchers,
    // keep flushing until it depletes
    if (queue.length) {
      _again = true;
      continue _function;
    }
    // dev tool hook
    /* istanbul ignore if */
    if (devtools && config.devtools) {
      devtools.emit('flush');
    }
    resetBatcherState();
  }
}

/**
 * Run the watchers in a single queue.
 *
 * @param {Array} queue
 */

function runBatcherQueue(queue) {
  // do not cache length because more watchers might be pushed
  // as we run existing watchers
  for (var i = 0; i < queue.length; i++) {
    var watcher = queue[i];
    var id = watcher.id;
    has[id] = null;
    watcher.run();
    // in dev build, check and stop circular updates.
    if (process.env.NODE_ENV !== 'production' && has[id] != null) {
      circular[id] = (circular[id] || 0) + 1;
      if (circular[id] > config._maxUpdateCount) {
        warn('You may have an infinite update loop for watcher ' + 'with expression "' + watcher.expression + '"', watcher.vm);
        break;
      }
    }
  }
  queue.length = 0;
}

/**
 * Push a watcher into the watcher queue.
 * Jobs with duplicate IDs will be skipped unless it's
 * pushed when the queue is being flushed.
 *
 * @param {Watcher} watcher
 *   properties:
 *   - {Number} id
 *   - {Function} run
 */

function pushWatcher(watcher) {
  var id = watcher.id;
  if (has[id] == null) {
    // push watcher into appropriate queue
    var q = watcher.user ? userQueue : queue;
    has[id] = q.length;
    q.push(watcher);
    // queue the flush
    if (!waiting) {
      waiting = true;
      nextTick(flushBatcherQueue);
    }
  }
}

var uid$2 = 0;

/**
 * A watcher parses an expression, collects dependencies,
 * and fires callback when the expression value changes.
 * This is used for both the $watch() api and directives.
 *
 * @param {Vue} vm
 * @param {String|Function} expOrFn
 * @param {Function} cb
 * @param {Object} options
 *                 - {Array} filters
 *                 - {Boolean} twoWay
 *                 - {Boolean} deep
 *                 - {Boolean} user
 *                 - {Boolean} sync
 *                 - {Boolean} lazy
 *                 - {Function} [preProcess]
 *                 - {Function} [postProcess]
 * @constructor
 */
function Watcher(vm, expOrFn, cb, options) {
  // mix in options
  if (options) {
    extend(this, options);
  }
  var isFn = typeof expOrFn === 'function';
  this.vm = vm;
  vm._watchers.push(this);
  this.expression = expOrFn;
  this.cb = cb;
  this.id = ++uid$2; // uid for batching
  this.active = true;
  this.dirty = this.lazy; // for lazy watchers
  this.deps = [];
  this.newDeps = [];
  this.depIds = new _Set();
  this.newDepIds = new _Set();
  this.prevError = null; // for async error stacks
  // parse expression for getter/setter
  if (isFn) {
    this.getter = expOrFn;
    this.setter = undefined;
  } else {
    var res = parseExpression(expOrFn, this.twoWay);
    this.getter = res.get;
    this.setter = res.set;
  }
  this.value = this.lazy ? undefined : this.get();
  // state for avoiding false triggers for deep and Array
  // watchers during vm._digest()
  this.queued = this.shallow = false;
}

/**
 * Evaluate the getter, and re-collect dependencies.
 */

Watcher.prototype.get = function () {
  this.beforeGet();
  var scope = this.scope || this.vm;
  var value;
  try {
    value = this.getter.call(scope, scope);
  } catch (e) {
    if (process.env.NODE_ENV !== 'production' && config.warnExpressionErrors) {
      warn('Error when evaluating expression ' + '"' + this.expression + '": ' + e.toString(), this.vm);
    }
  }
  // "touch" every property so they are all tracked as
  // dependencies for deep watching
  if (this.deep) {
    traverse(value);
  }
  if (this.preProcess) {
    value = this.preProcess(value);
  }
  if (this.filters) {
    value = scope._applyFilters(value, null, this.filters, false);
  }
  if (this.postProcess) {
    value = this.postProcess(value);
  }
  this.afterGet();
  return value;
};

/**
 * Set the corresponding value with the setter.
 *
 * @param {*} value
 */

Watcher.prototype.set = function (value) {
  var scope = this.scope || this.vm;
  if (this.filters) {
    value = scope._applyFilters(value, this.value, this.filters, true);
  }
  try {
    this.setter.call(scope, scope, value);
  } catch (e) {
    if (process.env.NODE_ENV !== 'production' && config.warnExpressionErrors) {
      warn('Error when evaluating setter ' + '"' + this.expression + '": ' + e.toString(), this.vm);
    }
  }
  // two-way sync for v-for alias
  var forContext = scope.$forContext;
  if (forContext && forContext.alias === this.expression) {
    if (forContext.filters) {
      process.env.NODE_ENV !== 'production' && warn('It seems you are using two-way binding on ' + 'a v-for alias (' + this.expression + '), and the ' + 'v-for has filters. This will not work properly. ' + 'Either remove the filters or use an array of ' + 'objects and bind to object properties instead.', this.vm);
      return;
    }
    forContext._withLock(function () {
      if (scope.$key) {
        // original is an object
        forContext.rawValue[scope.$key] = value;
      } else {
        forContext.rawValue.$set(scope.$index, value);
      }
    });
  }
};

/**
 * Prepare for dependency collection.
 */

Watcher.prototype.beforeGet = function () {
  Dep.target = this;
};

/**
 * Add a dependency to this directive.
 *
 * @param {Dep} dep
 */

Watcher.prototype.addDep = function (dep) {
  var id = dep.id;
  if (!this.newDepIds.has(id)) {
    this.newDepIds.add(id);
    this.newDeps.push(dep);
    if (!this.depIds.has(id)) {
      dep.addSub(this);
    }
  }
};

/**
 * Clean up for dependency collection.
 */

Watcher.prototype.afterGet = function () {
  Dep.target = null;
  var i = this.deps.length;
  while (i--) {
    var dep = this.deps[i];
    if (!this.newDepIds.has(dep.id)) {
      dep.removeSub(this);
    }
  }
  var tmp = this.depIds;
  this.depIds = this.newDepIds;
  this.newDepIds = tmp;
  this.newDepIds.clear();
  tmp = this.deps;
  this.deps = this.newDeps;
  this.newDeps = tmp;
  this.newDeps.length = 0;
};

/**
 * Subscriber interface.
 * Will be called when a dependency changes.
 *
 * @param {Boolean} shallow
 */

Watcher.prototype.update = function (shallow) {
  if (this.lazy) {
    this.dirty = true;
  } else if (this.sync || !config.async) {
    this.run();
  } else {
    // if queued, only overwrite shallow with non-shallow,
    // but not the other way around.
    this.shallow = this.queued ? shallow ? this.shallow : false : !!shallow;
    this.queued = true;
    // record before-push error stack in debug mode
    /* istanbul ignore if */
    if (process.env.NODE_ENV !== 'production' && config.debug) {
      this.prevError = new Error('[vue] async stack trace');
    }
    pushWatcher(this);
  }
};

/**
 * Batcher job interface.
 * Will be called by the batcher.
 */

Watcher.prototype.run = function () {
  if (this.active) {
    var value = this.get();
    if (value !== this.value ||
    // Deep watchers and watchers on Object/Arrays should fire even
    // when the value is the same, because the value may
    // have mutated; but only do so if this is a
    // non-shallow update (caused by a vm digest).
    (isObject(value) || this.deep) && !this.shallow) {
      // set new value
      var oldValue = this.value;
      this.value = value;
      // in debug + async mode, when a watcher callbacks
      // throws, we also throw the saved before-push error
      // so the full cross-tick stack trace is available.
      var prevError = this.prevError;
      /* istanbul ignore if */
      if (process.env.NODE_ENV !== 'production' && config.debug && prevError) {
        this.prevError = null;
        try {
          this.cb.call(this.vm, value, oldValue);
        } catch (e) {
          nextTick(function () {
            throw prevError;
          }, 0);
          throw e;
        }
      } else {
        this.cb.call(this.vm, value, oldValue);
      }
    }
    this.queued = this.shallow = false;
  }
};

/**
 * Evaluate the value of the watcher.
 * This only gets called for lazy watchers.
 */

Watcher.prototype.evaluate = function () {
  // avoid overwriting another watcher that is being
  // collected.
  var current = Dep.target;
  this.value = this.get();
  this.dirty = false;
  Dep.target = current;
};

/**
 * Depend on all deps collected by this watcher.
 */

Watcher.prototype.depend = function () {
  var i = this.deps.length;
  while (i--) {
    this.deps[i].depend();
  }
};

/**
 * Remove self from all dependencies' subcriber list.
 */

Watcher.prototype.teardown = function () {
  if (this.active) {
    // remove self from vm's watcher list
    // this is a somewhat expensive operation so we skip it
    // if the vm is being destroyed or is performing a v-for
    // re-render (the watcher list is then filtered by v-for).
    if (!this.vm._isBeingDestroyed && !this.vm._vForRemoving) {
      this.vm._watchers.$remove(this);
    }
    var i = this.deps.length;
    while (i--) {
      this.deps[i].removeSub(this);
    }
    this.active = false;
    this.vm = this.cb = this.value = null;
  }
};

/**
 * Recrusively traverse an object to evoke all converted
 * getters, so that every nested property inside the object
 * is collected as a "deep" dependency.
 *
 * @param {*} val
 */

var seenObjects = new _Set();
function traverse(val, seen) {
  var i = undefined,
      keys = undefined;
  if (!seen) {
    seen = seenObjects;
    seen.clear();
  }
  var isA = isArray(val);
  var isO = isObject(val);
  if ((isA || isO) && Object.isExtensible(val)) {
    if (val.__ob__) {
      var depId = val.__ob__.dep.id;
      if (seen.has(depId)) {
        return;
      } else {
        seen.add(depId);
      }
    }
    if (isA) {
      i = val.length;
      while (i--) traverse(val[i], seen);
    } else if (isO) {
      keys = Object.keys(val);
      i = keys.length;
      while (i--) traverse(val[keys[i]], seen);
    }
  }
}

var text$1 = {

  bind: function bind() {
    this.attr = this.el.nodeType === 3 ? 'data' : 'textContent';
  },

  update: function update(value) {
    this.el[this.attr] = _toString(value);
  }
};

var templateCache = new Cache(1000);
var idSelectorCache = new Cache(1000);

var map = {
  efault: [0, '', ''],
  legend: [1, '<fieldset>', '</fieldset>'],
  tr: [2, '<table><tbody>', '</tbody></table>'],
  col: [2, '<table><tbody></tbody><colgroup>', '</colgroup></table>']
};

map.td = map.th = [3, '<table><tbody><tr>', '</tr></tbody></table>'];

map.option = map.optgroup = [1, '<select multiple="multiple">', '</select>'];

map.thead = map.tbody = map.colgroup = map.caption = map.tfoot = [1, '<table>', '</table>'];

map.g = map.defs = map.symbol = map.use = map.image = map.text = map.circle = map.ellipse = map.line = map.path = map.polygon = map.polyline = map.rect = [1, '<svg ' + 'xmlns="http://www.w3.org/2000/svg" ' + 'xmlns:xlink="http://www.w3.org/1999/xlink" ' + 'xmlns:ev="http://www.w3.org/2001/xml-events"' + 'version="1.1">', '</svg>'];

/**
 * Check if a node is a supported template node with a
 * DocumentFragment content.
 *
 * @param {Node} node
 * @return {Boolean}
 */

function isRealTemplate(node) {
  return isTemplate(node) && isFragment(node.content);
}

var tagRE$1 = /<([\w:-]+)/;
var entityRE = /&#?\w+?;/;
var commentRE = /<!--/;

/**
 * Convert a string template to a DocumentFragment.
 * Determines correct wrapping by tag types. Wrapping
 * strategy found in jQuery & component/domify.
 *
 * @param {String} templateString
 * @param {Boolean} raw
 * @return {DocumentFragment}
 */

function stringToFragment(templateString, raw) {
  // try a cache hit first
  var cacheKey = raw ? templateString : templateString.trim();
  var hit = templateCache.get(cacheKey);
  if (hit) {
    return hit;
  }

  var frag = document.createDocumentFragment();
  var tagMatch = templateString.match(tagRE$1);
  var entityMatch = entityRE.test(templateString);
  var commentMatch = commentRE.test(templateString);

  if (!tagMatch && !entityMatch && !commentMatch) {
    // text only, return a single text node.
    frag.appendChild(document.createTextNode(templateString));
  } else {
    var tag = tagMatch && tagMatch[1];
    var wrap = map[tag] || map.efault;
    var depth = wrap[0];
    var prefix = wrap[1];
    var suffix = wrap[2];
    var node = document.createElement('div');

    node.innerHTML = prefix + templateString + suffix;
    while (depth--) {
      node = node.lastChild;
    }

    var child;
    /* eslint-disable no-cond-assign */
    while (child = node.firstChild) {
      /* eslint-enable no-cond-assign */
      frag.appendChild(child);
    }
  }
  if (!raw) {
    trimNode(frag);
  }
  templateCache.put(cacheKey, frag);
  return frag;
}

/**
 * Convert a template node to a DocumentFragment.
 *
 * @param {Node} node
 * @return {DocumentFragment}
 */

function nodeToFragment(node) {
  // if its a template tag and the browser supports it,
  // its content is already a document fragment. However, iOS Safari has
  // bug when using directly cloned template content with touch
  // events and can cause crashes when the nodes are removed from DOM, so we
  // have to treat template elements as string templates. (#2805)
  /* istanbul ignore if */
  if (isRealTemplate(node)) {
    return stringToFragment(node.innerHTML);
  }
  // script template
  if (node.tagName === 'SCRIPT') {
    return stringToFragment(node.textContent);
  }
  // normal node, clone it to avoid mutating the original
  var clonedNode = cloneNode(node);
  var frag = document.createDocumentFragment();
  var child;
  /* eslint-disable no-cond-assign */
  while (child = clonedNode.firstChild) {
    /* eslint-enable no-cond-assign */
    frag.appendChild(child);
  }
  trimNode(frag);
  return frag;
}

// Test for the presence of the Safari template cloning bug
// https://bugs.webkit.org/showug.cgi?id=137755
var hasBrokenTemplate = (function () {
  /* istanbul ignore else */
  if (inBrowser) {
    var a = document.createElement('div');
    a.innerHTML = '<template>1</template>';
    return !a.cloneNode(true).firstChild.innerHTML;
  } else {
    return false;
  }
})();

// Test for IE10/11 textarea placeholder clone bug
var hasTextareaCloneBug = (function () {
  /* istanbul ignore else */
  if (inBrowser) {
    var t = document.createElement('textarea');
    t.placeholder = 't';
    return t.cloneNode(true).value === 't';
  } else {
    return false;
  }
})();

/**
 * 1. Deal with Safari cloning nested <template> bug by
 *    manually cloning all template instances.
 * 2. Deal with IE10/11 textarea placeholder bug by setting
 *    the correct value after cloning.
 *
 * @param {Element|DocumentFragment} node
 * @return {Element|DocumentFragment}
 */

function cloneNode(node) {
  /* istanbul ignore if */
  if (!node.querySelectorAll) {
    return node.cloneNode();
  }
  var res = node.cloneNode(true);
  var i, original, cloned;
  /* istanbul ignore if */
  if (hasBrokenTemplate) {
    var tempClone = res;
    if (isRealTemplate(node)) {
      node = node.content;
      tempClone = res.content;
    }
    original = node.querySelectorAll('template');
    if (original.length) {
      cloned = tempClone.querySelectorAll('template');
      i = cloned.length;
      while (i--) {
        cloned[i].parentNode.replaceChild(cloneNode(original[i]), cloned[i]);
      }
    }
  }
  /* istanbul ignore if */
  if (hasTextareaCloneBug) {
    if (node.tagName === 'TEXTAREA') {
      res.value = node.value;
    } else {
      original = node.querySelectorAll('textarea');
      if (original.length) {
        cloned = res.querySelectorAll('textarea');
        i = cloned.length;
        while (i--) {
          cloned[i].value = original[i].value;
        }
      }
    }
  }
  return res;
}

/**
 * Process the template option and normalizes it into a
 * a DocumentFragment that can be used as a partial or a
 * instance template.
 *
 * @param {*} template
 *        Possible values include:
 *        - DocumentFragment object
 *        - Node object of type Template
 *        - id selector: '#some-template-id'
 *        - template string: '<div><span>{{msg}}</span></div>'
 * @param {Boolean} shouldClone
 * @param {Boolean} raw
 *        inline HTML interpolation. Do not check for id
 *        selector and keep whitespace in the string.
 * @return {DocumentFragment|undefined}
 */

function parseTemplate(template, shouldClone, raw) {
  var node, frag;

  // if the template is already a document fragment,
  // do nothing
  if (isFragment(template)) {
    trimNode(template);
    return shouldClone ? cloneNode(template) : template;
  }

  if (typeof template === 'string') {
    // id selector
    if (!raw && template.charAt(0) === '#') {
      // id selector can be cached too
      frag = idSelectorCache.get(template);
      if (!frag) {
        node = document.getElementById(template.slice(1));
        if (node) {
          frag = nodeToFragment(node);
          // save selector to cache
          idSelectorCache.put(template, frag);
        }
      }
    } else {
      // normal string template
      frag = stringToFragment(template, raw);
    }
  } else if (template.nodeType) {
    // a direct node
    frag = nodeToFragment(template);
  }

  return frag && shouldClone ? cloneNode(frag) : frag;
}

var template = Object.freeze({
  cloneNode: cloneNode,
  parseTemplate: parseTemplate
});

var html = {

  bind: function bind() {
    // a comment node means this is a binding for
    // {{{ inline unescaped html }}}
    if (this.el.nodeType === 8) {
      // hold nodes
      this.nodes = [];
      // replace the placeholder with proper anchor
      this.anchor = createAnchor('v-html');
      replace(this.el, this.anchor);
    }
  },

  update: function update(value) {
    value = _toString(value);
    if (this.nodes) {
      this.swap(value);
    } else {
      this.el.innerHTML = value;
    }
  },

  swap: function swap(value) {
    // remove old nodes
    var i = this.nodes.length;
    while (i--) {
      remove(this.nodes[i]);
    }
    // convert new value to a fragment
    // do not attempt to retrieve from id selector
    var frag = parseTemplate(value, true, true);
    // save a reference to these nodes so we can remove later
    this.nodes = toArray(frag.childNodes);
    before(frag, this.anchor);
  }
};

/**
 * Abstraction for a partially-compiled fragment.
 * Can optionally compile content with a child scope.
 *
 * @param {Function} linker
 * @param {Vue} vm
 * @param {DocumentFragment} frag
 * @param {Vue} [host]
 * @param {Object} [scope]
 * @param {Fragment} [parentFrag]
 */
function Fragment(linker, vm, frag, host, scope, parentFrag) {
  this.children = [];
  this.childFrags = [];
  this.vm = vm;
  this.scope = scope;
  this.inserted = false;
  this.parentFrag = parentFrag;
  if (parentFrag) {
    parentFrag.childFrags.push(this);
  }
  this.unlink = linker(vm, frag, host, scope, this);
  var single = this.single = frag.childNodes.length === 1 &&
  // do not go single mode if the only node is an anchor
  !frag.childNodes[0].__v_anchor;
  if (single) {
    this.node = frag.childNodes[0];
    this.before = singleBefore;
    this.remove = singleRemove;
  } else {
    this.node = createAnchor('fragment-start');
    this.end = createAnchor('fragment-end');
    this.frag = frag;
    prepend(this.node, frag);
    frag.appendChild(this.end);
    this.before = multiBefore;
    this.remove = multiRemove;
  }
  this.node.__v_frag = this;
}

/**
 * Call attach/detach for all components contained within
 * this fragment. Also do so recursively for all child
 * fragments.
 *
 * @param {Function} hook
 */

Fragment.prototype.callHook = function (hook) {
  var i, l;
  for (i = 0, l = this.childFrags.length; i < l; i++) {
    this.childFrags[i].callHook(hook);
  }
  for (i = 0, l = this.children.length; i < l; i++) {
    hook(this.children[i]);
  }
};

/**
 * Insert fragment before target, single node version
 *
 * @param {Node} target
 * @param {Boolean} withTransition
 */

function singleBefore(target, withTransition) {
  this.inserted = true;
  var method = withTransition !== false ? beforeWithTransition : before;
  method(this.node, target, this.vm);
  if (inDoc(this.node)) {
    this.callHook(attach);
  }
}

/**
 * Remove fragment, single node version
 */

function singleRemove() {
  this.inserted = false;
  var shouldCallRemove = inDoc(this.node);
  var self = this;
  this.beforeRemove();
  removeWithTransition(this.node, this.vm, function () {
    if (shouldCallRemove) {
      self.callHook(detach);
    }
    self.destroy();
  });
}

/**
 * Insert fragment before target, multi-nodes version
 *
 * @param {Node} target
 * @param {Boolean} withTransition
 */

function multiBefore(target, withTransition) {
  this.inserted = true;
  var vm = this.vm;
  var method = withTransition !== false ? beforeWithTransition : before;
  mapNodeRange(this.node, this.end, function (node) {
    method(node, target, vm);
  });
  if (inDoc(this.node)) {
    this.callHook(attach);
  }
}

/**
 * Remove fragment, multi-nodes version
 */

function multiRemove() {
  this.inserted = false;
  var self = this;
  var shouldCallRemove = inDoc(this.node);
  this.beforeRemove();
  removeNodeRange(this.node, this.end, this.vm, this.frag, function () {
    if (shouldCallRemove) {
      self.callHook(detach);
    }
    self.destroy();
  });
}

/**
 * Prepare the fragment for removal.
 */

Fragment.prototype.beforeRemove = function () {
  var i, l;
  for (i = 0, l = this.childFrags.length; i < l; i++) {
    // call the same method recursively on child
    // fragments, depth-first
    this.childFrags[i].beforeRemove(false);
  }
  for (i = 0, l = this.children.length; i < l; i++) {
    // Call destroy for all contained instances,
    // with remove:false and defer:true.
    // Defer is necessary because we need to
    // keep the children to call detach hooks
    // on them.
    this.children[i].$destroy(false, true);
  }
  var dirs = this.unlink.dirs;
  for (i = 0, l = dirs.length; i < l; i++) {
    // disable the watchers on all the directives
    // so that the rendered content stays the same
    // during removal.
    dirs[i]._watcher && dirs[i]._watcher.teardown();
  }
};

/**
 * Destroy the fragment.
 */

Fragment.prototype.destroy = function () {
  if (this.parentFrag) {
    this.parentFrag.childFrags.$remove(this);
  }
  this.node.__v_frag = null;
  this.unlink();
};

/**
 * Call attach hook for a Vue instance.
 *
 * @param {Vue} child
 */

function attach(child) {
  if (!child._isAttached && inDoc(child.$el)) {
    child._callHook('attached');
  }
}

/**
 * Call detach hook for a Vue instance.
 *
 * @param {Vue} child
 */

function detach(child) {
  if (child._isAttached && !inDoc(child.$el)) {
    child._callHook('detached');
  }
}

var linkerCache = new Cache(5000);

/**
 * A factory that can be used to create instances of a
 * fragment. Caches the compiled linker if possible.
 *
 * @param {Vue} vm
 * @param {Element|String} el
 */
function FragmentFactory(vm, el) {
  this.vm = vm;
  var template;
  var isString = typeof el === 'string';
  if (isString || isTemplate(el) && !el.hasAttribute('v-if')) {
    template = parseTemplate(el, true);
  } else {
    template = document.createDocumentFragment();
    template.appendChild(el);
  }
  this.template = template;
  // linker can be cached, but only for components
  var linker;
  var cid = vm.constructor.cid;
  if (cid > 0) {
    var cacheId = cid + (isString ? el : getOuterHTML(el));
    linker = linkerCache.get(cacheId);
    if (!linker) {
      linker = compile(template, vm.$options, true);
      linkerCache.put(cacheId, linker);
    }
  } else {
    linker = compile(template, vm.$options, true);
  }
  this.linker = linker;
}

/**
 * Create a fragment instance with given host and scope.
 *
 * @param {Vue} host
 * @param {Object} scope
 * @param {Fragment} parentFrag
 */

FragmentFactory.prototype.create = function (host, scope, parentFrag) {
  var frag = cloneNode(this.template);
  return new Fragment(this.linker, this.vm, frag, host, scope, parentFrag);
};

var ON = 700;
var MODEL = 800;
var BIND = 850;
var TRANSITION = 1100;
var EL = 1500;
var COMPONENT = 1500;
var PARTIAL = 1750;
var IF = 2100;
var FOR = 2200;
var SLOT = 2300;

var uid$3 = 0;

var vFor = {

  priority: FOR,
  terminal: true,

  params: ['track-by', 'stagger', 'enter-stagger', 'leave-stagger'],

  bind: function bind() {
    // support "item in/of items" syntax
    var inMatch = this.expression.match(/(.*) (?:in|of) (.*)/);
    if (inMatch) {
      var itMatch = inMatch[1].match(/\((.*),(.*)\)/);
      if (itMatch) {
        this.iterator = itMatch[1].trim();
        this.alias = itMatch[2].trim();
      } else {
        this.alias = inMatch[1].trim();
      }
      this.expression = inMatch[2];
    }

    if (!this.alias) {
      process.env.NODE_ENV !== 'production' && warn('Invalid v-for expression "' + this.descriptor.raw + '": ' + 'alias is required.', this.vm);
      return;
    }

    // uid as a cache identifier
    this.id = '__v-for__' + ++uid$3;

    // check if this is an option list,
    // so that we know if we need to update the <select>'s
    // v-model when the option list has changed.
    // because v-model has a lower priority than v-for,
    // the v-model is not bound here yet, so we have to
    // retrive it in the actual updateModel() function.
    var tag = this.el.tagName;
    this.isOption = (tag === 'OPTION' || tag === 'OPTGROUP') && this.el.parentNode.tagName === 'SELECT';

    // setup anchor nodes
    this.start = createAnchor('v-for-start');
    this.end = createAnchor('v-for-end');
    replace(this.el, this.end);
    before(this.start, this.end);

    // cache
    this.cache = Object.create(null);

    // fragment factory
    this.factory = new FragmentFactory(this.vm, this.el);
  },

  update: function update(data) {
    this.diff(data);
    this.updateRef();
    this.updateModel();
  },

  /**
   * Diff, based on new data and old data, determine the
   * minimum amount of DOM manipulations needed to make the
   * DOM reflect the new data Array.
   *
   * The algorithm diffs the new data Array by storing a
   * hidden reference to an owner vm instance on previously
   * seen data. This allows us to achieve O(n) which is
   * better than a levenshtein distance based algorithm,
   * which is O(m * n).
   *
   * @param {Array} data
   */

  diff: function diff(data) {
    // check if the Array was converted from an Object
    var item = data[0];
    var convertedFromObject = this.fromObject = isObject(item) && hasOwn(item, '$key') && hasOwn(item, '$value');

    var trackByKey = this.params.trackBy;
    var oldFrags = this.frags;
    var frags = this.frags = new Array(data.length);
    var alias = this.alias;
    var iterator = this.iterator;
    var start = this.start;
    var end = this.end;
    var inDocument = inDoc(start);
    var init = !oldFrags;
    var i, l, frag, key, value, primitive;

    // First pass, go through the new Array and fill up
    // the new frags array. If a piece of data has a cached
    // instance for it, we reuse it. Otherwise build a new
    // instance.
    for (i = 0, l = data.length; i < l; i++) {
      item = data[i];
      key = convertedFromObject ? item.$key : null;
      value = convertedFromObject ? item.$value : item;
      primitive = !isObject(value);
      frag = !init && this.getCachedFrag(value, i, key);
      if (frag) {
        // reusable fragment
        frag.reused = true;
        // update $index
        frag.scope.$index = i;
        // update $key
        if (key) {
          frag.scope.$key = key;
        }
        // update iterator
        if (iterator) {
          frag.scope[iterator] = key !== null ? key : i;
        }
        // update data for track-by, object repeat &
        // primitive values.
        if (trackByKey || convertedFromObject || primitive) {
          withoutConversion(function () {
            frag.scope[alias] = value;
          });
        }
      } else {
        // new isntance
        frag = this.create(value, alias, i, key);
        frag.fresh = !init;
      }
      frags[i] = frag;
      if (init) {
        frag.before(end);
      }
    }

    // we're done for the initial render.
    if (init) {
      return;
    }

    // Second pass, go through the old fragments and
    // destroy those who are not reused (and remove them
    // from cache)
    var removalIndex = 0;
    var totalRemoved = oldFrags.length - frags.length;
    // when removing a large number of fragments, watcher removal
    // turns out to be a perf bottleneck, so we batch the watcher
    // removals into a single filter call!
    this.vm._vForRemoving = true;
    for (i = 0, l = oldFrags.length; i < l; i++) {
      frag = oldFrags[i];
      if (!frag.reused) {
        this.deleteCachedFrag(frag);
        this.remove(frag, removalIndex++, totalRemoved, inDocument);
      }
    }
    this.vm._vForRemoving = false;
    if (removalIndex) {
      this.vm._watchers = this.vm._watchers.filter(function (w) {
        return w.active;
      });
    }

    // Final pass, move/insert new fragments into the
    // right place.
    var targetPrev, prevEl, currentPrev;
    var insertionIndex = 0;
    for (i = 0, l = frags.length; i < l; i++) {
      frag = frags[i];
      // this is the frag that we should be after
      targetPrev = frags[i - 1];
      prevEl = targetPrev ? targetPrev.staggerCb ? targetPrev.staggerAnchor : targetPrev.end || targetPrev.node : start;
      if (frag.reused && !frag.staggerCb) {
        currentPrev = findPrevFrag(frag, start, this.id);
        if (currentPrev !== targetPrev && (!currentPrev ||
        // optimization for moving a single item.
        // thanks to suggestions by @livoras in #1807
        findPrevFrag(currentPrev, start, this.id) !== targetPrev)) {
          this.move(frag, prevEl);
        }
      } else {
        // new instance, or still in stagger.
        // insert with updated stagger index.
        this.insert(frag, insertionIndex++, prevEl, inDocument);
      }
      frag.reused = frag.fresh = false;
    }
  },

  /**
   * Create a new fragment instance.
   *
   * @param {*} value
   * @param {String} alias
   * @param {Number} index
   * @param {String} [key]
   * @return {Fragment}
   */

  create: function create(value, alias, index, key) {
    var host = this._host;
    // create iteration scope
    var parentScope = this._scope || this.vm;
    var scope = Object.create(parentScope);
    // ref holder for the scope
    scope.$refs = Object.create(parentScope.$refs);
    scope.$els = Object.create(parentScope.$els);
    // make sure point $parent to parent scope
    scope.$parent = parentScope;
    // for two-way binding on alias
    scope.$forContext = this;
    // define scope properties
    // important: define the scope alias without forced conversion
    // so that frozen data structures remain non-reactive.
    withoutConversion(function () {
      defineReactive(scope, alias, value);
    });
    defineReactive(scope, '$index', index);
    if (key) {
      defineReactive(scope, '$key', key);
    } else if (scope.$key) {
      // avoid accidental fallback
      def(scope, '$key', null);
    }
    if (this.iterator) {
      defineReactive(scope, this.iterator, key !== null ? key : index);
    }
    var frag = this.factory.create(host, scope, this._frag);
    frag.forId = this.id;
    this.cacheFrag(value, frag, index, key);
    return frag;
  },

  /**
   * Update the v-ref on owner vm.
   */

  updateRef: function updateRef() {
    var ref = this.descriptor.ref;
    if (!ref) return;
    var hash = (this._scope || this.vm).$refs;
    var refs;
    if (!this.fromObject) {
      refs = this.frags.map(findVmFromFrag);
    } else {
      refs = {};
      this.frags.forEach(function (frag) {
        refs[frag.scope.$key] = findVmFromFrag(frag);
      });
    }
    hash[ref] = refs;
  },

  /**
   * For option lists, update the containing v-model on
   * parent <select>.
   */

  updateModel: function updateModel() {
    if (this.isOption) {
      var parent = this.start.parentNode;
      var model = parent && parent.__v_model;
      if (model) {
        model.forceUpdate();
      }
    }
  },

  /**
   * Insert a fragment. Handles staggering.
   *
   * @param {Fragment} frag
   * @param {Number} index
   * @param {Node} prevEl
   * @param {Boolean} inDocument
   */

  insert: function insert(frag, index, prevEl, inDocument) {
    if (frag.staggerCb) {
      frag.staggerCb.cancel();
      frag.staggerCb = null;
    }
    var staggerAmount = this.getStagger(frag, index, null, 'enter');
    if (inDocument && staggerAmount) {
      // create an anchor and insert it synchronously,
      // so that we can resolve the correct order without
      // worrying about some elements not inserted yet
      var anchor = frag.staggerAnchor;
      if (!anchor) {
        anchor = frag.staggerAnchor = createAnchor('stagger-anchor');
        anchor.__v_frag = frag;
      }
      after(anchor, prevEl);
      var op = frag.staggerCb = cancellable(function () {
        frag.staggerCb = null;
        frag.before(anchor);
        remove(anchor);
      });
      setTimeout(op, staggerAmount);
    } else {
      var target = prevEl.nextSibling;
      /* istanbul ignore if */
      if (!target) {
        // reset end anchor position in case the position was messed up
        // by an external drag-n-drop library.
        after(this.end, prevEl);
        target = this.end;
      }
      frag.before(target);
    }
  },

  /**
   * Remove a fragment. Handles staggering.
   *
   * @param {Fragment} frag
   * @param {Number} index
   * @param {Number} total
   * @param {Boolean} inDocument
   */

  remove: function remove(frag, index, total, inDocument) {
    if (frag.staggerCb) {
      frag.staggerCb.cancel();
      frag.staggerCb = null;
      // it's not possible for the same frag to be removed
      // twice, so if we have a pending stagger callback,
      // it means this frag is queued for enter but removed
      // before its transition started. Since it is already
      // destroyed, we can just leave it in detached state.
      return;
    }
    var staggerAmount = this.getStagger(frag, index, total, 'leave');
    if (inDocument && staggerAmount) {
      var op = frag.staggerCb = cancellable(function () {
        frag.staggerCb = null;
        frag.remove();
      });
      setTimeout(op, staggerAmount);
    } else {
      frag.remove();
    }
  },

  /**
   * Move a fragment to a new position.
   * Force no transition.
   *
   * @param {Fragment} frag
   * @param {Node} prevEl
   */

  move: function move(frag, prevEl) {
    // fix a common issue with Sortable:
    // if prevEl doesn't have nextSibling, this means it's
    // been dragged after the end anchor. Just re-position
    // the end anchor to the end of the container.
    /* istanbul ignore if */
    if (!prevEl.nextSibling) {
      this.end.parentNode.appendChild(this.end);
    }
    frag.before(prevEl.nextSibling, false);
  },

  /**
   * Cache a fragment using track-by or the object key.
   *
   * @param {*} value
   * @param {Fragment} frag
   * @param {Number} index
   * @param {String} [key]
   */

  cacheFrag: function cacheFrag(value, frag, index, key) {
    var trackByKey = this.params.trackBy;
    var cache = this.cache;
    var primitive = !isObject(value);
    var id;
    if (key || trackByKey || primitive) {
      id = getTrackByKey(index, key, value, trackByKey);
      if (!cache[id]) {
        cache[id] = frag;
      } else if (trackByKey !== '$index') {
        process.env.NODE_ENV !== 'production' && this.warnDuplicate(value);
      }
    } else {
      id = this.id;
      if (hasOwn(value, id)) {
        if (value[id] === null) {
          value[id] = frag;
        } else {
          process.env.NODE_ENV !== 'production' && this.warnDuplicate(value);
        }
      } else if (Object.isExtensible(value)) {
        def(value, id, frag);
      } else if (process.env.NODE_ENV !== 'production') {
        warn('Frozen v-for objects cannot be automatically tracked, make sure to ' + 'provide a track-by key.');
      }
    }
    frag.raw = value;
  },

  /**
   * Get a cached fragment from the value/index/key
   *
   * @param {*} value
   * @param {Number} index
   * @param {String} key
   * @return {Fragment}
   */

  getCachedFrag: function getCachedFrag(value, index, key) {
    var trackByKey = this.params.trackBy;
    var primitive = !isObject(value);
    var frag;
    if (key || trackByKey || primitive) {
      var id = getTrackByKey(index, key, value, trackByKey);
      frag = this.cache[id];
    } else {
      frag = value[this.id];
    }
    if (frag && (frag.reused || frag.fresh)) {
      process.env.NODE_ENV !== 'production' && this.warnDuplicate(value);
    }
    return frag;
  },

  /**
   * Delete a fragment from cache.
   *
   * @param {Fragment} frag
   */

  deleteCachedFrag: function deleteCachedFrag(frag) {
    var value = frag.raw;
    var trackByKey = this.params.trackBy;
    var scope = frag.scope;
    var index = scope.$index;
    // fix #948: avoid accidentally fall through to
    // a parent repeater which happens to have $key.
    var key = hasOwn(scope, '$key') && scope.$key;
    var primitive = !isObject(value);
    if (trackByKey || key || primitive) {
      var id = getTrackByKey(index, key, value, trackByKey);
      this.cache[id] = null;
    } else {
      value[this.id] = null;
      frag.raw = null;
    }
  },

  /**
   * Get the stagger amount for an insertion/removal.
   *
   * @param {Fragment} frag
   * @param {Number} index
   * @param {Number} total
   * @param {String} type
   */

  getStagger: function getStagger(frag, index, total, type) {
    type = type + 'Stagger';
    var trans = frag.node.__v_trans;
    var hooks = trans && trans.hooks;
    var hook = hooks && (hooks[type] || hooks.stagger);
    return hook ? hook.call(frag, index, total) : index * parseInt(this.params[type] || this.params.stagger, 10);
  },

  /**
   * Pre-process the value before piping it through the
   * filters. This is passed to and called by the watcher.
   */

  _preProcess: function _preProcess(value) {
    // regardless of type, store the un-filtered raw value.
    this.rawValue = value;
    return value;
  },

  /**
   * Post-process the value after it has been piped through
   * the filters. This is passed to and called by the watcher.
   *
   * It is necessary for this to be called during the
   * watcher's dependency collection phase because we want
   * the v-for to update when the source Object is mutated.
   */

  _postProcess: function _postProcess(value) {
    if (isArray(value)) {
      return value;
    } else if (isPlainObject(value)) {
      // convert plain object to array.
      var keys = Object.keys(value);
      var i = keys.length;
      var res = new Array(i);
      var key;
      while (i--) {
        key = keys[i];
        res[i] = {
          $key: key,
          $value: value[key]
        };
      }
      return res;
    } else {
      if (typeof value === 'number' && !isNaN(value)) {
        value = range(value);
      }
      return value || [];
    }
  },

  unbind: function unbind() {
    if (this.descriptor.ref) {
      (this._scope || this.vm).$refs[this.descriptor.ref] = null;
    }
    if (this.frags) {
      var i = this.frags.length;
      var frag;
      while (i--) {
        frag = this.frags[i];
        this.deleteCachedFrag(frag);
        frag.destroy();
      }
    }
  }
};

/**
 * Helper to find the previous element that is a fragment
 * anchor. This is necessary because a destroyed frag's
 * element could still be lingering in the DOM before its
 * leaving transition finishes, but its inserted flag
 * should have been set to false so we can skip them.
 *
 * If this is a block repeat, we want to make sure we only
 * return frag that is bound to this v-for. (see #929)
 *
 * @param {Fragment} frag
 * @param {Comment|Text} anchor
 * @param {String} id
 * @return {Fragment}
 */

function findPrevFrag(frag, anchor, id) {
  var el = frag.node.previousSibling;
  /* istanbul ignore if */
  if (!el) return;
  frag = el.__v_frag;
  while ((!frag || frag.forId !== id || !frag.inserted) && el !== anchor) {
    el = el.previousSibling;
    /* istanbul ignore if */
    if (!el) return;
    frag = el.__v_frag;
  }
  return frag;
}

/**
 * Find a vm from a fragment.
 *
 * @param {Fragment} frag
 * @return {Vue|undefined}
 */

function findVmFromFrag(frag) {
  var node = frag.node;
  // handle multi-node frag
  if (frag.end) {
    while (!node.__vue__ && node !== frag.end && node.nextSibling) {
      node = node.nextSibling;
    }
  }
  return node.__vue__;
}

/**
 * Create a range array from given number.
 *
 * @param {Number} n
 * @return {Array}
 */

function range(n) {
  var i = -1;
  var ret = new Array(Math.floor(n));
  while (++i < n) {
    ret[i] = i;
  }
  return ret;
}

/**
 * Get the track by key for an item.
 *
 * @param {Number} index
 * @param {String} key
 * @param {*} value
 * @param {String} [trackByKey]
 */

function getTrackByKey(index, key, value, trackByKey) {
  return trackByKey ? trackByKey === '$index' ? index : trackByKey.charAt(0).match(/\w/) ? getPath(value, trackByKey) : value[trackByKey] : key || value;
}

if (process.env.NODE_ENV !== 'production') {
  vFor.warnDuplicate = function (value) {
    warn('Duplicate value found in v-for="' + this.descriptor.raw + '": ' + JSON.stringify(value) + '. Use track-by="$index" if ' + 'you are expecting duplicate values.', this.vm);
  };
}

var vIf = {

  priority: IF,
  terminal: true,

  bind: function bind() {
    var el = this.el;
    if (!el.__vue__) {
      // check else block
      var next = el.nextElementSibling;
      if (next && getAttr(next, 'v-else') !== null) {
        remove(next);
        this.elseEl = next;
      }
      // check main block
      this.anchor = createAnchor('v-if');
      replace(el, this.anchor);
    } else {
      process.env.NODE_ENV !== 'production' && warn('v-if="' + this.expression + '" cannot be ' + 'used on an instance root element.', this.vm);
      this.invalid = true;
    }
  },

  update: function update(value) {
    if (this.invalid) return;
    if (value) {
      if (!this.frag) {
        this.insert();
      }
    } else {
      this.remove();
    }
  },

  insert: function insert() {
    if (this.elseFrag) {
      this.elseFrag.remove();
      this.elseFrag = null;
    }
    // lazy init factory
    if (!this.factory) {
      this.factory = new FragmentFactory(this.vm, this.el);
    }
    this.frag = this.factory.create(this._host, this._scope, this._frag);
    this.frag.before(this.anchor);
  },

  remove: function remove() {
    if (this.frag) {
      this.frag.remove();
      this.frag = null;
    }
    if (this.elseEl && !this.elseFrag) {
      if (!this.elseFactory) {
        this.elseFactory = new FragmentFactory(this.elseEl._context || this.vm, this.elseEl);
      }
      this.elseFrag = this.elseFactory.create(this._host, this._scope, this._frag);
      this.elseFrag.before(this.anchor);
    }
  },

  unbind: function unbind() {
    if (this.frag) {
      this.frag.destroy();
    }
    if (this.elseFrag) {
      this.elseFrag.destroy();
    }
  }
};

var show = {

  bind: function bind() {
    // check else block
    var next = this.el.nextElementSibling;
    if (next && getAttr(next, 'v-else') !== null) {
      this.elseEl = next;
    }
  },

  update: function update(value) {
    this.apply(this.el, value);
    if (this.elseEl) {
      this.apply(this.elseEl, !value);
    }
  },

  apply: function apply(el, value) {
    if (inDoc(el)) {
      applyTransition(el, value ? 1 : -1, toggle, this.vm);
    } else {
      toggle();
    }
    function toggle() {
      el.style.display = value ? '' : 'none';
    }
  }
};

var text$2 = {

  bind: function bind() {
    var self = this;
    var el = this.el;
    var isRange = el.type === 'range';
    var lazy = this.params.lazy;
    var number = this.params.number;
    var debounce = this.params.debounce;

    // handle composition events.
    //   http://blog.evanyou.me/2014/01/03/composition-event/
    // skip this for Android because it handles composition
    // events quite differently. Android doesn't trigger
    // composition events for language input methods e.g.
    // Chinese, but instead triggers them for spelling
    // suggestions... (see Discussion/#162)
    var composing = false;
    if (!isAndroid && !isRange) {
      this.on('compositionstart', function () {
        composing = true;
      });
      this.on('compositionend', function () {
        composing = false;
        // in IE11 the "compositionend" event fires AFTER
        // the "input" event, so the input handler is blocked
        // at the end... have to call it here.
        //
        // #1327: in lazy mode this is unecessary.
        if (!lazy) {
          self.listener();
        }
      });
    }

    // prevent messing with the input when user is typing,
    // and force update on blur.
    this.focused = false;
    if (!isRange && !lazy) {
      this.on('focus', function () {
        self.focused = true;
      });
      this.on('blur', function () {
        self.focused = false;
        // do not sync value after fragment removal (#2017)
        if (!self._frag || self._frag.inserted) {
          self.rawListener();
        }
      });
    }

    // Now attach the main listener
    this.listener = this.rawListener = function () {
      if (composing || !self._bound) {
        return;
      }
      var val = number || isRange ? toNumber(el.value) : el.value;
      self.set(val);
      // force update on next tick to avoid lock & same value
      // also only update when user is not typing
      nextTick(function () {
        if (self._bound && !self.focused) {
          self.update(self._watcher.value);
        }
      });
    };

    // apply debounce
    if (debounce) {
      this.listener = _debounce(this.listener, debounce);
    }

    // Support jQuery events, since jQuery.trigger() doesn't
    // trigger native events in some cases and some plugins
    // rely on $.trigger()
    //
    // We want to make sure if a listener is attached using
    // jQuery, it is also removed with jQuery, that's why
    // we do the check for each directive instance and
    // store that check result on itself. This also allows
    // easier test coverage control by unsetting the global
    // jQuery variable in tests.
    this.hasjQuery = typeof jQuery === 'function';
    if (this.hasjQuery) {
      var method = jQuery.fn.on ? 'on' : 'bind';
      jQuery(el)[method]('change', this.rawListener);
      if (!lazy) {
        jQuery(el)[method]('input', this.listener);
      }
    } else {
      this.on('change', this.rawListener);
      if (!lazy) {
        this.on('input', this.listener);
      }
    }

    // IE9 doesn't fire input event on backspace/del/cut
    if (!lazy && isIE9) {
      this.on('cut', function () {
        nextTick(self.listener);
      });
      this.on('keyup', function (e) {
        if (e.keyCode === 46 || e.keyCode === 8) {
          self.listener();
        }
      });
    }

    // set initial value if present
    if (el.hasAttribute('value') || el.tagName === 'TEXTAREA' && el.value.trim()) {
      this.afterBind = this.listener;
    }
  },

  update: function update(value) {
    // #3029 only update when the value changes. This prevent
    // browsers from overwriting values like selectionStart
    value = _toString(value);
    if (value !== this.el.value) this.el.value = value;
  },

  unbind: function unbind() {
    var el = this.el;
    if (this.hasjQuery) {
      var method = jQuery.fn.off ? 'off' : 'unbind';
      jQuery(el)[method]('change', this.listener);
      jQuery(el)[method]('input', this.listener);
    }
  }
};

var radio = {

  bind: function bind() {
    var self = this;
    var el = this.el;

    this.getValue = function () {
      // value overwrite via v-bind:value
      if (el.hasOwnProperty('_value')) {
        return el._value;
      }
      var val = el.value;
      if (self.params.number) {
        val = toNumber(val);
      }
      return val;
    };

    this.listener = function () {
      self.set(self.getValue());
    };
    this.on('change', this.listener);

    if (el.hasAttribute('checked')) {
      this.afterBind = this.listener;
    }
  },

  update: function update(value) {
    this.el.checked = looseEqual(value, this.getValue());
  }
};

var select = {

  bind: function bind() {
    var _this = this;

    var self = this;
    var el = this.el;

    // method to force update DOM using latest value.
    this.forceUpdate = function () {
      if (self._watcher) {
        self.update(self._watcher.get());
      }
    };

    // check if this is a multiple select
    var multiple = this.multiple = el.hasAttribute('multiple');

    // attach listener
    this.listener = function () {
      var value = getValue(el, multiple);
      value = self.params.number ? isArray(value) ? value.map(toNumber) : toNumber(value) : value;
      self.set(value);
    };
    this.on('change', this.listener);

    // if has initial value, set afterBind
    var initValue = getValue(el, multiple, true);
    if (multiple && initValue.length || !multiple && initValue !== null) {
      this.afterBind = this.listener;
    }

    // All major browsers except Firefox resets
    // selectedIndex with value -1 to 0 when the element
    // is appended to a new parent, therefore we have to
    // force a DOM update whenever that happens...
    this.vm.$on('hook:attached', function () {
      nextTick(_this.forceUpdate);
    });
    if (!inDoc(el)) {
      nextTick(this.forceUpdate);
    }
  },

  update: function update(value) {
    var el = this.el;
    el.selectedIndex = -1;
    var multi = this.multiple && isArray(value);
    var options = el.options;
    var i = options.length;
    var op, val;
    while (i--) {
      op = options[i];
      val = op.hasOwnProperty('_value') ? op._value : op.value;
      /* eslint-disable eqeqeq */
      op.selected = multi ? indexOf$1(value, val) > -1 : looseEqual(value, val);
      /* eslint-enable eqeqeq */
    }
  },

  unbind: function unbind() {
    /* istanbul ignore next */
    this.vm.$off('hook:attached', this.forceUpdate);
  }
};

/**
 * Get select value
 *
 * @param {SelectElement} el
 * @param {Boolean} multi
 * @param {Boolean} init
 * @return {Array|*}
 */

function getValue(el, multi, init) {
  var res = multi ? [] : null;
  var op, val, selected;
  for (var i = 0, l = el.options.length; i < l; i++) {
    op = el.options[i];
    selected = init ? op.hasAttribute('selected') : op.selected;
    if (selected) {
      val = op.hasOwnProperty('_value') ? op._value : op.value;
      if (multi) {
        res.push(val);
      } else {
        return val;
      }
    }
  }
  return res;
}

/**
 * Native Array.indexOf uses strict equal, but in this
 * case we need to match string/numbers with custom equal.
 *
 * @param {Array} arr
 * @param {*} val
 */

function indexOf$1(arr, val) {
  var i = arr.length;
  while (i--) {
    if (looseEqual(arr[i], val)) {
      return i;
    }
  }
  return -1;
}

var checkbox = {

  bind: function bind() {
    var self = this;
    var el = this.el;

    this.getValue = function () {
      return el.hasOwnProperty('_value') ? el._value : self.params.number ? toNumber(el.value) : el.value;
    };

    function getBooleanValue() {
      var val = el.checked;
      if (val && el.hasOwnProperty('_trueValue')) {
        return el._trueValue;
      }
      if (!val && el.hasOwnProperty('_falseValue')) {
        return el._falseValue;
      }
      return val;
    }

    this.listener = function () {
      var model = self._watcher.value;
      if (isArray(model)) {
        var val = self.getValue();
        if (el.checked) {
          if (indexOf(model, val) < 0) {
            model.push(val);
          }
        } else {
          model.$remove(val);
        }
      } else {
        self.set(getBooleanValue());
      }
    };

    this.on('change', this.listener);
    if (el.hasAttribute('checked')) {
      this.afterBind = this.listener;
    }
  },

  update: function update(value) {
    var el = this.el;
    if (isArray(value)) {
      el.checked = indexOf(value, this.getValue()) > -1;
    } else {
      if (el.hasOwnProperty('_trueValue')) {
        el.checked = looseEqual(value, el._trueValue);
      } else {
        el.checked = !!value;
      }
    }
  }
};

var handlers = {
  text: text$2,
  radio: radio,
  select: select,
  checkbox: checkbox
};

var model = {

  priority: MODEL,
  twoWay: true,
  handlers: handlers,
  params: ['lazy', 'number', 'debounce'],

  /**
   * Possible elements:
   *   <select>
   *   <textarea>
   *   <input type="*">
   *     - text
   *     - checkbox
   *     - radio
   *     - number
   */

  bind: function bind() {
    // friendly warning...
    this.checkFilters();
    if (this.hasRead && !this.hasWrite) {
      process.env.NODE_ENV !== 'production' && warn('It seems you are using a read-only filter with ' + 'v-model="' + this.descriptor.raw + '". ' + 'You might want to use a two-way filter to ensure correct behavior.', this.vm);
    }
    var el = this.el;
    var tag = el.tagName;
    var handler;
    if (tag === 'INPUT') {
      handler = handlers[el.type] || handlers.text;
    } else if (tag === 'SELECT') {
      handler = handlers.select;
    } else if (tag === 'TEXTAREA') {
      handler = handlers.text;
    } else {
      process.env.NODE_ENV !== 'production' && warn('v-model does not support element type: ' + tag, this.vm);
      return;
    }
    el.__v_model = this;
    handler.bind.call(this);
    this.update = handler.update;
    this._unbind = handler.unbind;
  },

  /**
   * Check read/write filter stats.
   */

  checkFilters: function checkFilters() {
    var filters = this.filters;
    if (!filters) return;
    var i = filters.length;
    while (i--) {
      var filter = resolveAsset(this.vm.$options, 'filters', filters[i].name);
      if (typeof filter === 'function' || filter.read) {
        this.hasRead = true;
      }
      if (filter.write) {
        this.hasWrite = true;
      }
    }
  },

  unbind: function unbind() {
    this.el.__v_model = null;
    this._unbind && this._unbind();
  }
};

// keyCode aliases
var keyCodes = {
  esc: 27,
  tab: 9,
  enter: 13,
  space: 32,
  'delete': [8, 46],
  up: 38,
  left: 37,
  right: 39,
  down: 40
};

function keyFilter(handler, keys) {
  var codes = keys.map(function (key) {
    var charCode = key.charCodeAt(0);
    if (charCode > 47 && charCode < 58) {
      return parseInt(key, 10);
    }
    if (key.length === 1) {
      charCode = key.toUpperCase().charCodeAt(0);
      if (charCode > 64 && charCode < 91) {
        return charCode;
      }
    }
    return keyCodes[key];
  });
  codes = [].concat.apply([], codes);
  return function keyHandler(e) {
    if (codes.indexOf(e.keyCode) > -1) {
      return handler.call(this, e);
    }
  };
}

function stopFilter(handler) {
  return function stopHandler(e) {
    e.stopPropagation();
    return handler.call(this, e);
  };
}

function preventFilter(handler) {
  return function preventHandler(e) {
    e.preventDefault();
    return handler.call(this, e);
  };
}

function selfFilter(handler) {
  return function selfHandler(e) {
    if (e.target === e.currentTarget) {
      return handler.call(this, e);
    }
  };
}

var on$1 = {

  priority: ON,
  acceptStatement: true,
  keyCodes: keyCodes,

  bind: function bind() {
    // deal with iframes
    if (this.el.tagName === 'IFRAME' && this.arg !== 'load') {
      var self = this;
      this.iframeBind = function () {
        on(self.el.contentWindow, self.arg, self.handler, self.modifiers.capture);
      };
      this.on('load', this.iframeBind);
    }
  },

  update: function update(handler) {
    // stub a noop for v-on with no value,
    // e.g. @mousedown.prevent
    if (!this.descriptor.raw) {
      handler = function () {};
    }

    if (typeof handler !== 'function') {
      process.env.NODE_ENV !== 'production' && warn('v-on:' + this.arg + '="' + this.expression + '" expects a function value, ' + 'got ' + handler, this.vm);
      return;
    }

    // apply modifiers
    if (this.modifiers.stop) {
      handler = stopFilter(handler);
    }
    if (this.modifiers.prevent) {
      handler = preventFilter(handler);
    }
    if (this.modifiers.self) {
      handler = selfFilter(handler);
    }
    // key filter
    var keys = Object.keys(this.modifiers).filter(function (key) {
      return key !== 'stop' && key !== 'prevent' && key !== 'self' && key !== 'capture';
    });
    if (keys.length) {
      handler = keyFilter(handler, keys);
    }

    this.reset();
    this.handler = handler;

    if (this.iframeBind) {
      this.iframeBind();
    } else {
      on(this.el, this.arg, this.handler, this.modifiers.capture);
    }
  },

  reset: function reset() {
    var el = this.iframeBind ? this.el.contentWindow : this.el;
    if (this.handler) {
      off(el, this.arg, this.handler);
    }
  },

  unbind: function unbind() {
    this.reset();
  }
};

var prefixes = ['-webkit-', '-moz-', '-ms-'];
var camelPrefixes = ['Webkit', 'Moz', 'ms'];
var importantRE = /!important;?$/;
var propCache = Object.create(null);

var testEl = null;

var style = {

  deep: true,

  update: function update(value) {
    if (typeof value === 'string') {
      this.el.style.cssText = value;
    } else if (isArray(value)) {
      this.handleObject(value.reduce(extend, {}));
    } else {
      this.handleObject(value || {});
    }
  },

  handleObject: function handleObject(value) {
    // cache object styles so that only changed props
    // are actually updated.
    var cache = this.cache || (this.cache = {});
    var name, val;
    for (name in cache) {
      if (!(name in value)) {
        this.handleSingle(name, null);
        delete cache[name];
      }
    }
    for (name in value) {
      val = value[name];
      if (val !== cache[name]) {
        cache[name] = val;
        this.handleSingle(name, val);
      }
    }
  },

  handleSingle: function handleSingle(prop, value) {
    prop = normalize(prop);
    if (!prop) return; // unsupported prop
    // cast possible numbers/booleans into strings
    if (value != null) value += '';
    if (value) {
      var isImportant = importantRE.test(value) ? 'important' : '';
      if (isImportant) {
        /* istanbul ignore if */
        if (process.env.NODE_ENV !== 'production') {
          warn('It\'s probably a bad idea to use !important with inline rules. ' + 'This feature will be deprecated in a future version of Vue.');
        }
        value = value.replace(importantRE, '').trim();
        this.el.style.setProperty(prop.kebab, value, isImportant);
      } else {
        this.el.style[prop.camel] = value;
      }
    } else {
      this.el.style[prop.camel] = '';
    }
  }

};

/**
 * Normalize a CSS property name.
 * - cache result
 * - auto prefix
 * - camelCase -> dash-case
 *
 * @param {String} prop
 * @return {String}
 */

function normalize(prop) {
  if (propCache[prop]) {
    return propCache[prop];
  }
  var res = prefix(prop);
  propCache[prop] = propCache[res] = res;
  return res;
}

/**
 * Auto detect the appropriate prefix for a CSS property.
 * https://gist.github.com/paulirish/523692
 *
 * @param {String} prop
 * @return {String}
 */

function prefix(prop) {
  prop = hyphenate(prop);
  var camel = camelize(prop);
  var upper = camel.charAt(0).toUpperCase() + camel.slice(1);
  if (!testEl) {
    testEl = document.createElement('div');
  }
  var i = prefixes.length;
  var prefixed;
  if (camel !== 'filter' && camel in testEl.style) {
    return {
      kebab: prop,
      camel: camel
    };
  }
  while (i--) {
    prefixed = camelPrefixes[i] + upper;
    if (prefixed in testEl.style) {
      return {
        kebab: prefixes[i] + prop,
        camel: prefixed
      };
    }
  }
}

// xlink
var xlinkNS = 'http://www.w3.org/1999/xlink';
var xlinkRE = /^xlink:/;

// check for attributes that prohibit interpolations
var disallowedInterpAttrRE = /^v-|^:|^@|^(?:is|transition|transition-mode|debounce|track-by|stagger|enter-stagger|leave-stagger)$/;
// these attributes should also set their corresponding properties
// because they only affect the initial state of the element
var attrWithPropsRE = /^(?:value|checked|selected|muted)$/;
// these attributes expect enumrated values of "true" or "false"
// but are not boolean attributes
var enumeratedAttrRE = /^(?:draggable|contenteditable|spellcheck)$/;

// these attributes should set a hidden property for
// binding v-model to object values
var modelProps = {
  value: '_value',
  'true-value': '_trueValue',
  'false-value': '_falseValue'
};

var bind$1 = {

  priority: BIND,

  bind: function bind() {
    var attr = this.arg;
    var tag = this.el.tagName;
    // should be deep watch on object mode
    if (!attr) {
      this.deep = true;
    }
    // handle interpolation bindings
    var descriptor = this.descriptor;
    var tokens = descriptor.interp;
    if (tokens) {
      // handle interpolations with one-time tokens
      if (descriptor.hasOneTime) {
        this.expression = tokensToExp(tokens, this._scope || this.vm);
      }

      // only allow binding on native attributes
      if (disallowedInterpAttrRE.test(attr) || attr === 'name' && (tag === 'PARTIAL' || tag === 'SLOT')) {
        process.env.NODE_ENV !== 'production' && warn(attr + '="' + descriptor.raw + '": ' + 'attribute interpolation is not allowed in Vue.js ' + 'directives and special attributes.', this.vm);
        this.el.removeAttribute(attr);
        this.invalid = true;
      }

      /* istanbul ignore if */
      if (process.env.NODE_ENV !== 'production') {
        var raw = attr + '="' + descriptor.raw + '": ';
        // warn src
        if (attr === 'src') {
          warn(raw + 'interpolation in "src" attribute will cause ' + 'a 404 request. Use v-bind:src instead.', this.vm);
        }

        // warn style
        if (attr === 'style') {
          warn(raw + 'interpolation in "style" attribute will cause ' + 'the attribute to be discarded in Internet Explorer. ' + 'Use v-bind:style instead.', this.vm);
        }
      }
    }
  },

  update: function update(value) {
    if (this.invalid) {
      return;
    }
    var attr = this.arg;
    if (this.arg) {
      this.handleSingle(attr, value);
    } else {
      this.handleObject(value || {});
    }
  },

  // share object handler with v-bind:class
  handleObject: style.handleObject,

  handleSingle: function handleSingle(attr, value) {
    var el = this.el;
    var interp = this.descriptor.interp;
    if (this.modifiers.camel) {
      attr = camelize(attr);
    }
    if (!interp && attrWithPropsRE.test(attr) && attr in el) {
      var attrValue = attr === 'value' ? value == null // IE9 will set input.value to "null" for null...
      ? '' : value : value;

      if (el[attr] !== attrValue) {
        el[attr] = attrValue;
      }
    }
    // set model props
    var modelProp = modelProps[attr];
    if (!interp && modelProp) {
      el[modelProp] = value;
      // update v-model if present
      var model = el.__v_model;
      if (model) {
        model.listener();
      }
    }
    // do not set value attribute for textarea
    if (attr === 'value' && el.tagName === 'TEXTAREA') {
      el.removeAttribute(attr);
      return;
    }
    // update attribute
    if (enumeratedAttrRE.test(attr)) {
      el.setAttribute(attr, value ? 'true' : 'false');
    } else if (value != null && value !== false) {
      if (attr === 'class') {
        // handle edge case #1960:
        // class interpolation should not overwrite Vue transition class
        if (el.__v_trans) {
          value += ' ' + el.__v_trans.id + '-transition';
        }
        setClass(el, value);
      } else if (xlinkRE.test(attr)) {
        el.setAttributeNS(xlinkNS, attr, value === true ? '' : value);
      } else {
        el.setAttribute(attr, value === true ? '' : value);
      }
    } else {
      el.removeAttribute(attr);
    }
  }
};

var el = {

  priority: EL,

  bind: function bind() {
    /* istanbul ignore if */
    if (!this.arg) {
      return;
    }
    var id = this.id = camelize(this.arg);
    var refs = (this._scope || this.vm).$els;
    if (hasOwn(refs, id)) {
      refs[id] = this.el;
    } else {
      defineReactive(refs, id, this.el);
    }
  },

  unbind: function unbind() {
    var refs = (this._scope || this.vm).$els;
    if (refs[this.id] === this.el) {
      refs[this.id] = null;
    }
  }
};

var ref = {
  bind: function bind() {
    process.env.NODE_ENV !== 'production' && warn('v-ref:' + this.arg + ' must be used on a child ' + 'component. Found on <' + this.el.tagName.toLowerCase() + '>.', this.vm);
  }
};

var cloak = {
  bind: function bind() {
    var el = this.el;
    this.vm.$once('pre-hook:compiled', function () {
      el.removeAttribute('v-cloak');
    });
  }
};

// must export plain object
var directives = {
  text: text$1,
  html: html,
  'for': vFor,
  'if': vIf,
  show: show,
  model: model,
  on: on$1,
  bind: bind$1,
  el: el,
  ref: ref,
  cloak: cloak
};

var vClass = {

  deep: true,

  update: function update(value) {
    if (!value) {
      this.cleanup();
    } else if (typeof value === 'string') {
      this.setClass(value.trim().split(/\s+/));
    } else {
      this.setClass(normalize$1(value));
    }
  },

  setClass: function setClass(value) {
    this.cleanup(value);
    for (var i = 0, l = value.length; i < l; i++) {
      var val = value[i];
      if (val) {
        apply(this.el, val, addClass);
      }
    }
    this.prevKeys = value;
  },

  cleanup: function cleanup(value) {
    var prevKeys = this.prevKeys;
    if (!prevKeys) return;
    var i = prevKeys.length;
    while (i--) {
      var key = prevKeys[i];
      if (!value || value.indexOf(key) < 0) {
        apply(this.el, key, removeClass);
      }
    }
  }
};

/**
 * Normalize objects and arrays (potentially containing objects)
 * into array of strings.
 *
 * @param {Object|Array<String|Object>} value
 * @return {Array<String>}
 */

function normalize$1(value) {
  var res = [];
  if (isArray(value)) {
    for (var i = 0, l = value.length; i < l; i++) {
      var _key = value[i];
      if (_key) {
        if (typeof _key === 'string') {
          res.push(_key);
        } else {
          for (var k in _key) {
            if (_key[k]) res.push(k);
          }
        }
      }
    }
  } else if (isObject(value)) {
    for (var key in value) {
      if (value[key]) res.push(key);
    }
  }
  return res;
}

/**
 * Add or remove a class/classes on an element
 *
 * @param {Element} el
 * @param {String} key The class name. This may or may not
 *                     contain a space character, in such a
 *                     case we'll deal with multiple class
 *                     names at once.
 * @param {Function} fn
 */

function apply(el, key, fn) {
  key = key.trim();
  if (key.indexOf(' ') === -1) {
    fn(el, key);
    return;
  }
  // The key contains one or more space characters.
  // Since a class name doesn't accept such characters, we
  // treat it as multiple classes.
  var keys = key.split(/\s+/);
  for (var i = 0, l = keys.length; i < l; i++) {
    fn(el, keys[i]);
  }
}

var component = {

  priority: COMPONENT,

  params: ['keep-alive', 'transition-mode', 'inline-template'],

  /**
   * Setup. Two possible usages:
   *
   * - static:
   *   <comp> or <div v-component="comp">
   *
   * - dynamic:
   *   <component :is="view">
   */

  bind: function bind() {
    if (!this.el.__vue__) {
      // keep-alive cache
      this.keepAlive = this.params.keepAlive;
      if (this.keepAlive) {
        this.cache = {};
      }
      // check inline-template
      if (this.params.inlineTemplate) {
        // extract inline template as a DocumentFragment
        this.inlineTemplate = extractContent(this.el, true);
      }
      // component resolution related state
      this.pendingComponentCb = this.Component = null;
      // transition related state
      this.pendingRemovals = 0;
      this.pendingRemovalCb = null;
      // create a ref anchor
      this.anchor = createAnchor('v-component');
      replace(this.el, this.anchor);
      // remove is attribute.
      // this is removed during compilation, but because compilation is
      // cached, when the component is used elsewhere this attribute
      // will remain at link time.
      this.el.removeAttribute('is');
      this.el.removeAttribute(':is');
      // remove ref, same as above
      if (this.descriptor.ref) {
        this.el.removeAttribute('v-ref:' + hyphenate(this.descriptor.ref));
      }
      // if static, build right now.
      if (this.literal) {
        this.setComponent(this.expression);
      }
    } else {
      process.env.NODE_ENV !== 'production' && warn('cannot mount component "' + this.expression + '" ' + 'on already mounted element: ' + this.el);
    }
  },

  /**
   * Public update, called by the watcher in the dynamic
   * literal scenario, e.g. <component :is="view">
   */

  update: function update(value) {
    if (!this.literal) {
      this.setComponent(value);
    }
  },

  /**
   * Switch dynamic components. May resolve the component
   * asynchronously, and perform transition based on
   * specified transition mode. Accepts a few additional
   * arguments specifically for vue-router.
   *
   * The callback is called when the full transition is
   * finished.
   *
   * @param {String} value
   * @param {Function} [cb]
   */

  setComponent: function setComponent(value, cb) {
    this.invalidatePending();
    if (!value) {
      // just remove current
      this.unbuild(true);
      this.remove(this.childVM, cb);
      this.childVM = null;
    } else {
      var self = this;
      this.resolveComponent(value, function () {
        self.mountComponent(cb);
      });
    }
  },

  /**
   * Resolve the component constructor to use when creating
   * the child vm.
   *
   * @param {String|Function} value
   * @param {Function} cb
   */

  resolveComponent: function resolveComponent(value, cb) {
    var self = this;
    this.pendingComponentCb = cancellable(function (Component) {
      self.ComponentName = Component.options.name || (typeof value === 'string' ? value : null);
      self.Component = Component;
      cb();
    });
    this.vm._resolveComponent(value, this.pendingComponentCb);
  },

  /**
   * Create a new instance using the current constructor and
   * replace the existing instance. This method doesn't care
   * whether the new component and the old one are actually
   * the same.
   *
   * @param {Function} [cb]
   */

  mountComponent: function mountComponent(cb) {
    // actual mount
    this.unbuild(true);
    var self = this;
    var activateHooks = this.Component.options.activate;
    var cached = this.getCached();
    var newComponent = this.build();
    if (activateHooks && !cached) {
      this.waitingFor = newComponent;
      callActivateHooks(activateHooks, newComponent, function () {
        if (self.waitingFor !== newComponent) {
          return;
        }
        self.waitingFor = null;
        self.transition(newComponent, cb);
      });
    } else {
      // update ref for kept-alive component
      if (cached) {
        newComponent._updateRef();
      }
      this.transition(newComponent, cb);
    }
  },

  /**
   * When the component changes or unbinds before an async
   * constructor is resolved, we need to invalidate its
   * pending callback.
   */

  invalidatePending: function invalidatePending() {
    if (this.pendingComponentCb) {
      this.pendingComponentCb.cancel();
      this.pendingComponentCb = null;
    }
  },

  /**
   * Instantiate/insert a new child vm.
   * If keep alive and has cached instance, insert that
   * instance; otherwise build a new one and cache it.
   *
   * @param {Object} [extraOptions]
   * @return {Vue} - the created instance
   */

  build: function build(extraOptions) {
    var cached = this.getCached();
    if (cached) {
      return cached;
    }
    if (this.Component) {
      // default options
      var options = {
        name: this.ComponentName,
        el: cloneNode(this.el),
        template: this.inlineTemplate,
        // make sure to add the child with correct parent
        // if this is a transcluded component, its parent
        // should be the transclusion host.
        parent: this._host || this.vm,
        // if no inline-template, then the compiled
        // linker can be cached for better performance.
        _linkerCachable: !this.inlineTemplate,
        _ref: this.descriptor.ref,
        _asComponent: true,
        _isRouterView: this._isRouterView,
        // if this is a transcluded component, context
        // will be the common parent vm of this instance
        // and its host.
        _context: this.vm,
        // if this is inside an inline v-for, the scope
        // will be the intermediate scope created for this
        // repeat fragment. this is used for linking props
        // and container directives.
        _scope: this._scope,
        // pass in the owner fragment of this component.
        // this is necessary so that the fragment can keep
        // track of its contained components in order to
        // call attach/detach hooks for them.
        _frag: this._frag
      };
      // extra options
      // in 1.0.0 this is used by vue-router only
      /* istanbul ignore if */
      if (extraOptions) {
        extend(options, extraOptions);
      }
      var child = new this.Component(options);
      if (this.keepAlive) {
        this.cache[this.Component.cid] = child;
      }
      /* istanbul ignore if */
      if (process.env.NODE_ENV !== 'production' && this.el.hasAttribute('transition') && child._isFragment) {
        warn('Transitions will not work on a fragment instance. ' + 'Template: ' + child.$options.template, child);
      }
      return child;
    }
  },

  /**
   * Try to get a cached instance of the current component.
   *
   * @return {Vue|undefined}
   */

  getCached: function getCached() {
    return this.keepAlive && this.cache[this.Component.cid];
  },

  /**
   * Teardown the current child, but defers cleanup so
   * that we can separate the destroy and removal steps.
   *
   * @param {Boolean} defer
   */

  unbuild: function unbuild(defer) {
    if (this.waitingFor) {
      if (!this.keepAlive) {
        this.waitingFor.$destroy();
      }
      this.waitingFor = null;
    }
    var child = this.childVM;
    if (!child || this.keepAlive) {
      if (child) {
        // remove ref
        child._inactive = true;
        child._updateRef(true);
      }
      return;
    }
    // the sole purpose of `deferCleanup` is so that we can
    // "deactivate" the vm right now and perform DOM removal
    // later.
    child.$destroy(false, defer);
  },

  /**
   * Remove current destroyed child and manually do
   * the cleanup after removal.
   *
   * @param {Function} cb
   */

  remove: function remove(child, cb) {
    var keepAlive = this.keepAlive;
    if (child) {
      // we may have a component switch when a previous
      // component is still being transitioned out.
      // we want to trigger only one lastest insertion cb
      // when the existing transition finishes. (#1119)
      this.pendingRemovals++;
      this.pendingRemovalCb = cb;
      var self = this;
      child.$remove(function () {
        self.pendingRemovals--;
        if (!keepAlive) child._cleanup();
        if (!self.pendingRemovals && self.pendingRemovalCb) {
          self.pendingRemovalCb();
          self.pendingRemovalCb = null;
        }
      });
    } else if (cb) {
      cb();
    }
  },

  /**
   * Actually swap the components, depending on the
   * transition mode. Defaults to simultaneous.
   *
   * @param {Vue} target
   * @param {Function} [cb]
   */

  transition: function transition(target, cb) {
    var self = this;
    var current = this.childVM;
    // for devtool inspection
    if (current) current._inactive = true;
    target._inactive = false;
    this.childVM = target;
    switch (self.params.transitionMode) {
      case 'in-out':
        target.$before(self.anchor, function () {
          self.remove(current, cb);
        });
        break;
      case 'out-in':
        self.remove(current, function () {
          target.$before(self.anchor, cb);
        });
        break;
      default:
        self.remove(current);
        target.$before(self.anchor, cb);
    }
  },

  /**
   * Unbind.
   */

  unbind: function unbind() {
    this.invalidatePending();
    // Do not defer cleanup when unbinding
    this.unbuild();
    // destroy all keep-alive cached instances
    if (this.cache) {
      for (var key in this.cache) {
        this.cache[key].$destroy();
      }
      this.cache = null;
    }
  }
};

/**
 * Call activate hooks in order (asynchronous)
 *
 * @param {Array} hooks
 * @param {Vue} vm
 * @param {Function} cb
 */

function callActivateHooks(hooks, vm, cb) {
  var total = hooks.length;
  var called = 0;
  hooks[0].call(vm, next);
  function next() {
    if (++called >= total) {
      cb();
    } else {
      hooks[called].call(vm, next);
    }
  }
}

var propBindingModes = config._propBindingModes;
var empty = {};

// regexes
var identRE$1 = /^[$_a-zA-Z]+[\w$]*$/;
var settablePathRE = /^[A-Za-z_$][\w$]*(\.[A-Za-z_$][\w$]*|\[[^\[\]]+\])*$/;

/**
 * Compile props on a root element and return
 * a props link function.
 *
 * @param {Element|DocumentFragment} el
 * @param {Array} propOptions
 * @param {Vue} vm
 * @return {Function} propsLinkFn
 */

function compileProps(el, propOptions, vm) {
  var props = [];
  var names = Object.keys(propOptions);
  var i = names.length;
  var options, name, attr, value, path, parsed, prop;
  while (i--) {
    name = names[i];
    options = propOptions[name] || empty;

    if (process.env.NODE_ENV !== 'production' && name === '$data') {
      warn('Do not use $data as prop.', vm);
      continue;
    }

    // props could contain dashes, which will be
    // interpreted as minus calculations by the parser
    // so we need to camelize the path here
    path = camelize(name);
    if (!identRE$1.test(path)) {
      process.env.NODE_ENV !== 'production' && warn('Invalid prop key: "' + name + '". Prop keys ' + 'must be valid identifiers.', vm);
      continue;
    }

    prop = {
      name: name,
      path: path,
      options: options,
      mode: propBindingModes.ONE_WAY,
      raw: null
    };

    attr = hyphenate(name);
    // first check dynamic version
    if ((value = getBindAttr(el, attr)) === null) {
      if ((value = getBindAttr(el, attr + '.sync')) !== null) {
        prop.mode = propBindingModes.TWO_WAY;
      } else if ((value = getBindAttr(el, attr + '.once')) !== null) {
        prop.mode = propBindingModes.ONE_TIME;
      }
    }
    if (value !== null) {
      // has dynamic binding!
      prop.raw = value;
      parsed = parseDirective(value);
      value = parsed.expression;
      prop.filters = parsed.filters;
      // check binding type
      if (isLiteral(value) && !parsed.filters) {
        // for expressions containing literal numbers and
        // booleans, there's no need to setup a prop binding,
        // so we can optimize them as a one-time set.
        prop.optimizedLiteral = true;
      } else {
        prop.dynamic = true;
        // check non-settable path for two-way bindings
        if (process.env.NODE_ENV !== 'production' && prop.mode === propBindingModes.TWO_WAY && !settablePathRE.test(value)) {
          prop.mode = propBindingModes.ONE_WAY;
          warn('Cannot bind two-way prop with non-settable ' + 'parent path: ' + value, vm);
        }
      }
      prop.parentPath = value;

      // warn required two-way
      if (process.env.NODE_ENV !== 'production' && options.twoWay && prop.mode !== propBindingModes.TWO_WAY) {
        warn('Prop "' + name + '" expects a two-way binding type.', vm);
      }
    } else if ((value = getAttr(el, attr)) !== null) {
      // has literal binding!
      prop.raw = value;
    } else if (process.env.NODE_ENV !== 'production') {
      // check possible camelCase prop usage
      var lowerCaseName = path.toLowerCase();
      value = /[A-Z\-]/.test(name) && (el.getAttribute(lowerCaseName) || el.getAttribute(':' + lowerCaseName) || el.getAttribute('v-bind:' + lowerCaseName) || el.getAttribute(':' + lowerCaseName + '.once') || el.getAttribute('v-bind:' + lowerCaseName + '.once') || el.getAttribute(':' + lowerCaseName + '.sync') || el.getAttribute('v-bind:' + lowerCaseName + '.sync'));
      if (value) {
        warn('Possible usage error for prop `' + lowerCaseName + '` - ' + 'did you mean `' + attr + '`? HTML is case-insensitive, remember to use ' + 'kebab-case for props in templates.', vm);
      } else if (options.required) {
        // warn missing required
        warn('Missing required prop: ' + name, vm);
      }
    }
    // push prop
    props.push(prop);
  }
  return makePropsLinkFn(props);
}

/**
 * Build a function that applies props to a vm.
 *
 * @param {Array} props
 * @return {Function} propsLinkFn
 */

function makePropsLinkFn(props) {
  return function propsLinkFn(vm, scope) {
    // store resolved props info
    vm._props = {};
    var inlineProps = vm.$options.propsData;
    var i = props.length;
    var prop, path, options, value, raw;
    while (i--) {
      prop = props[i];
      raw = prop.raw;
      path = prop.path;
      options = prop.options;
      vm._props[path] = prop;
      if (inlineProps && hasOwn(inlineProps, path)) {
        initProp(vm, prop, inlineProps[path]);
      }if (raw === null) {
        // initialize absent prop
        initProp(vm, prop, undefined);
      } else if (prop.dynamic) {
        // dynamic prop
        if (prop.mode === propBindingModes.ONE_TIME) {
          // one time binding
          value = (scope || vm._context || vm).$get(prop.parentPath);
          initProp(vm, prop, value);
        } else {
          if (vm._context) {
            // dynamic binding
            vm._bindDir({
              name: 'prop',
              def: propDef,
              prop: prop
            }, null, null, scope); // el, host, scope
          } else {
              // root instance
              initProp(vm, prop, vm.$get(prop.parentPath));
            }
        }
      } else if (prop.optimizedLiteral) {
        // optimized literal, cast it and just set once
        var stripped = stripQuotes(raw);
        value = stripped === raw ? toBoolean(toNumber(raw)) : stripped;
        initProp(vm, prop, value);
      } else {
        // string literal, but we need to cater for
        // Boolean props with no value, or with same
        // literal value (e.g. disabled="disabled")
        // see https://github.com/vuejs/vue-loader/issues/182
        value = options.type === Boolean && (raw === '' || raw === hyphenate(prop.name)) ? true : raw;
        initProp(vm, prop, value);
      }
    }
  };
}

/**
 * Process a prop with a rawValue, applying necessary coersions,
 * default values & assertions and call the given callback with
 * processed value.
 *
 * @param {Vue} vm
 * @param {Object} prop
 * @param {*} rawValue
 * @param {Function} fn
 */

function processPropValue(vm, prop, rawValue, fn) {
  var isSimple = prop.dynamic && isSimplePath(prop.parentPath);
  var value = rawValue;
  if (value === undefined) {
    value = getPropDefaultValue(vm, prop);
  }
  value = coerceProp(prop, value, vm);
  var coerced = value !== rawValue;
  if (!assertProp(prop, value, vm)) {
    value = undefined;
  }
  if (isSimple && !coerced) {
    withoutConversion(function () {
      fn(value);
    });
  } else {
    fn(value);
  }
}

/**
 * Set a prop's initial value on a vm and its data object.
 *
 * @param {Vue} vm
 * @param {Object} prop
 * @param {*} value
 */

function initProp(vm, prop, value) {
  processPropValue(vm, prop, value, function (value) {
    defineReactive(vm, prop.path, value);
  });
}

/**
 * Update a prop's value on a vm.
 *
 * @param {Vue} vm
 * @param {Object} prop
 * @param {*} value
 */

function updateProp(vm, prop, value) {
  processPropValue(vm, prop, value, function (value) {
    vm[prop.path] = value;
  });
}

/**
 * Get the default value of a prop.
 *
 * @param {Vue} vm
 * @param {Object} prop
 * @return {*}
 */

function getPropDefaultValue(vm, prop) {
  // no default, return undefined
  var options = prop.options;
  if (!hasOwn(options, 'default')) {
    // absent boolean value defaults to false
    return options.type === Boolean ? false : undefined;
  }
  var def = options['default'];
  // warn against non-factory defaults for Object & Array
  if (isObject(def)) {
    process.env.NODE_ENV !== 'production' && warn('Invalid default value for prop "' + prop.name + '": ' + 'Props with type Object/Array must use a factory function ' + 'to return the default value.', vm);
  }
  // call factory function for non-Function types
  return typeof def === 'function' && options.type !== Function ? def.call(vm) : def;
}

/**
 * Assert whether a prop is valid.
 *
 * @param {Object} prop
 * @param {*} value
 * @param {Vue} vm
 */

function assertProp(prop, value, vm) {
  if (!prop.options.required && ( // non-required
  prop.raw === null || // abscent
  value == null) // null or undefined
  ) {
      return true;
    }
  var options = prop.options;
  var type = options.type;
  var valid = !type;
  var expectedTypes = [];
  if (type) {
    if (!isArray(type)) {
      type = [type];
    }
    for (var i = 0; i < type.length && !valid; i++) {
      var assertedType = assertType(value, type[i]);
      expectedTypes.push(assertedType.expectedType);
      valid = assertedType.valid;
    }
  }
  if (!valid) {
    if (process.env.NODE_ENV !== 'production') {
      warn('Invalid prop: type check failed for prop "' + prop.name + '".' + ' Expected ' + expectedTypes.map(formatType).join(', ') + ', got ' + formatValue(value) + '.', vm);
    }
    return false;
  }
  var validator = options.validator;
  if (validator) {
    if (!validator(value)) {
      process.env.NODE_ENV !== 'production' && warn('Invalid prop: custom validator check failed for prop "' + prop.name + '".', vm);
      return false;
    }
  }
  return true;
}

/**
 * Force parsing value with coerce option.
 *
 * @param {*} value
 * @param {Object} options
 * @return {*}
 */

function coerceProp(prop, value, vm) {
  var coerce = prop.options.coerce;
  if (!coerce) {
    return value;
  }
  if (typeof coerce === 'function') {
    return coerce(value);
  } else {
    process.env.NODE_ENV !== 'production' && warn('Invalid coerce for prop "' + prop.name + '": expected function, got ' + typeof coerce + '.', vm);
    return value;
  }
}

/**
 * Assert the type of a value
 *
 * @param {*} value
 * @param {Function} type
 * @return {Object}
 */

function assertType(value, type) {
  var valid;
  var expectedType;
  if (type === String) {
    expectedType = 'string';
    valid = typeof value === expectedType;
  } else if (type === Number) {
    expectedType = 'number';
    valid = typeof value === expectedType;
  } else if (type === Boolean) {
    expectedType = 'boolean';
    valid = typeof value === expectedType;
  } else if (type === Function) {
    expectedType = 'function';
    valid = typeof value === expectedType;
  } else if (type === Object) {
    expectedType = 'object';
    valid = isPlainObject(value);
  } else if (type === Array) {
    expectedType = 'array';
    valid = isArray(value);
  } else {
    valid = value instanceof type;
  }
  return {
    valid: valid,
    expectedType: expectedType
  };
}

/**
 * Format type for output
 *
 * @param {String} type
 * @return {String}
 */

function formatType(type) {
  return type ? type.charAt(0).toUpperCase() + type.slice(1) : 'custom type';
}

/**
 * Format value
 *
 * @param {*} value
 * @return {String}
 */

function formatValue(val) {
  return Object.prototype.toString.call(val).slice(8, -1);
}

var bindingModes = config._propBindingModes;

var propDef = {

  bind: function bind() {
    var child = this.vm;
    var parent = child._context;
    // passed in from compiler directly
    var prop = this.descriptor.prop;
    var childKey = prop.path;
    var parentKey = prop.parentPath;
    var twoWay = prop.mode === bindingModes.TWO_WAY;

    var parentWatcher = this.parentWatcher = new Watcher(parent, parentKey, function (val) {
      updateProp(child, prop, val);
    }, {
      twoWay: twoWay,
      filters: prop.filters,
      // important: props need to be observed on the
      // v-for scope if present
      scope: this._scope
    });

    // set the child initial value.
    initProp(child, prop, parentWatcher.value);

    // setup two-way binding
    if (twoWay) {
      // important: defer the child watcher creation until
      // the created hook (after data observation)
      var self = this;
      child.$once('pre-hook:created', function () {
        self.childWatcher = new Watcher(child, childKey, function (val) {
          parentWatcher.set(val);
        }, {
          // ensure sync upward before parent sync down.
          // this is necessary in cases e.g. the child
          // mutates a prop array, then replaces it. (#1683)
          sync: true
        });
      });
    }
  },

  unbind: function unbind() {
    this.parentWatcher.teardown();
    if (this.childWatcher) {
      this.childWatcher.teardown();
    }
  }
};

var queue$1 = [];
var queued = false;

/**
 * Push a job into the queue.
 *
 * @param {Function} job
 */

function pushJob(job) {
  queue$1.push(job);
  if (!queued) {
    queued = true;
    nextTick(flush);
  }
}

/**
 * Flush the queue, and do one forced reflow before
 * triggering transitions.
 */

function flush() {
  // Force layout
  var f = document.documentElement.offsetHeight;
  for (var i = 0; i < queue$1.length; i++) {
    queue$1[i]();
  }
  queue$1 = [];
  queued = false;
  // dummy return, so js linters don't complain about
  // unused variable f
  return f;
}

var TYPE_TRANSITION = 'transition';
var TYPE_ANIMATION = 'animation';
var transDurationProp = transitionProp + 'Duration';
var animDurationProp = animationProp + 'Duration';

/**
 * If a just-entered element is applied the
 * leave class while its enter transition hasn't started yet,
 * and the transitioned property has the same value for both
 * enter/leave, then the leave transition will be skipped and
 * the transitionend event never fires. This function ensures
 * its callback to be called after a transition has started
 * by waiting for double raf.
 *
 * It falls back to setTimeout on devices that support CSS
 * transitions but not raf (e.g. Android 4.2 browser) - since
 * these environments are usually slow, we are giving it a
 * relatively large timeout.
 */

var raf = inBrowser && window.requestAnimationFrame;
var waitForTransitionStart = raf
/* istanbul ignore next */
? function (fn) {
  raf(function () {
    raf(fn);
  });
} : function (fn) {
  setTimeout(fn, 50);
};

/**
 * A Transition object that encapsulates the state and logic
 * of the transition.
 *
 * @param {Element} el
 * @param {String} id
 * @param {Object} hooks
 * @param {Vue} vm
 */
function Transition(el, id, hooks, vm) {
  this.id = id;
  this.el = el;
  this.enterClass = hooks && hooks.enterClass || id + '-enter';
  this.leaveClass = hooks && hooks.leaveClass || id + '-leave';
  this.hooks = hooks;
  this.vm = vm;
  // async state
  this.pendingCssEvent = this.pendingCssCb = this.cancel = this.pendingJsCb = this.op = this.cb = null;
  this.justEntered = false;
  this.entered = this.left = false;
  this.typeCache = {};
  // check css transition type
  this.type = hooks && hooks.type;
  /* istanbul ignore if */
  if (process.env.NODE_ENV !== 'production') {
    if (this.type && this.type !== TYPE_TRANSITION && this.type !== TYPE_ANIMATION) {
      warn('invalid CSS transition type for transition="' + this.id + '": ' + this.type, vm);
    }
  }
  // bind
  var self = this;['enterNextTick', 'enterDone', 'leaveNextTick', 'leaveDone'].forEach(function (m) {
    self[m] = bind(self[m], self);
  });
}

var p$1 = Transition.prototype;

/**
 * Start an entering transition.
 *
 * 1. enter transition triggered
 * 2. call beforeEnter hook
 * 3. add enter class
 * 4. insert/show element
 * 5. call enter hook (with possible explicit js callback)
 * 6. reflow
 * 7. based on transition type:
 *    - transition:
 *        remove class now, wait for transitionend,
 *        then done if there's no explicit js callback.
 *    - animation:
 *        wait for animationend, remove class,
 *        then done if there's no explicit js callback.
 *    - no css transition:
 *        done now if there's no explicit js callback.
 * 8. wait for either done or js callback, then call
 *    afterEnter hook.
 *
 * @param {Function} op - insert/show the element
 * @param {Function} [cb]
 */

p$1.enter = function (op, cb) {
  this.cancelPending();
  this.callHook('beforeEnter');
  this.cb = cb;
  addClass(this.el, this.enterClass);
  op();
  this.entered = false;
  this.callHookWithCb('enter');
  if (this.entered) {
    return; // user called done synchronously.
  }
  this.cancel = this.hooks && this.hooks.enterCancelled;
  pushJob(this.enterNextTick);
};

/**
 * The "nextTick" phase of an entering transition, which is
 * to be pushed into a queue and executed after a reflow so
 * that removing the class can trigger a CSS transition.
 */

p$1.enterNextTick = function () {
  var _this = this;

  // prevent transition skipping
  this.justEntered = true;
  waitForTransitionStart(function () {
    _this.justEntered = false;
  });
  var enterDone = this.enterDone;
  var type = this.getCssTransitionType(this.enterClass);
  if (!this.pendingJsCb) {
    if (type === TYPE_TRANSITION) {
      // trigger transition by removing enter class now
      removeClass(this.el, this.enterClass);
      this.setupCssCb(transitionEndEvent, enterDone);
    } else if (type === TYPE_ANIMATION) {
      this.setupCssCb(animationEndEvent, enterDone);
    } else {
      enterDone();
    }
  } else if (type === TYPE_TRANSITION) {
    removeClass(this.el, this.enterClass);
  }
};

/**
 * The "cleanup" phase of an entering transition.
 */

p$1.enterDone = function () {
  this.entered = true;
  this.cancel = this.pendingJsCb = null;
  removeClass(this.el, this.enterClass);
  this.callHook('afterEnter');
  if (this.cb) this.cb();
};

/**
 * Start a leaving transition.
 *
 * 1. leave transition triggered.
 * 2. call beforeLeave hook
 * 3. add leave class (trigger css transition)
 * 4. call leave hook (with possible explicit js callback)
 * 5. reflow if no explicit js callback is provided
 * 6. based on transition type:
 *    - transition or animation:
 *        wait for end event, remove class, then done if
 *        there's no explicit js callback.
 *    - no css transition:
 *        done if there's no explicit js callback.
 * 7. wait for either done or js callback, then call
 *    afterLeave hook.
 *
 * @param {Function} op - remove/hide the element
 * @param {Function} [cb]
 */

p$1.leave = function (op, cb) {
  this.cancelPending();
  this.callHook('beforeLeave');
  this.op = op;
  this.cb = cb;
  addClass(this.el, this.leaveClass);
  this.left = false;
  this.callHookWithCb('leave');
  if (this.left) {
    return; // user called done synchronously.
  }
  this.cancel = this.hooks && this.hooks.leaveCancelled;
  // only need to handle leaveDone if
  // 1. the transition is already done (synchronously called
  //    by the user, which causes this.op set to null)
  // 2. there's no explicit js callback
  if (this.op && !this.pendingJsCb) {
    // if a CSS transition leaves immediately after enter,
    // the transitionend event never fires. therefore we
    // detect such cases and end the leave immediately.
    if (this.justEntered) {
      this.leaveDone();
    } else {
      pushJob(this.leaveNextTick);
    }
  }
};

/**
 * The "nextTick" phase of a leaving transition.
 */

p$1.leaveNextTick = function () {
  var type = this.getCssTransitionType(this.leaveClass);
  if (type) {
    var event = type === TYPE_TRANSITION ? transitionEndEvent : animationEndEvent;
    this.setupCssCb(event, this.leaveDone);
  } else {
    this.leaveDone();
  }
};

/**
 * The "cleanup" phase of a leaving transition.
 */

p$1.leaveDone = function () {
  this.left = true;
  this.cancel = this.pendingJsCb = null;
  this.op();
  removeClass(this.el, this.leaveClass);
  this.callHook('afterLeave');
  if (this.cb) this.cb();
  this.op = null;
};

/**
 * Cancel any pending callbacks from a previously running
 * but not finished transition.
 */

p$1.cancelPending = function () {
  this.op = this.cb = null;
  var hasPending = false;
  if (this.pendingCssCb) {
    hasPending = true;
    off(this.el, this.pendingCssEvent, this.pendingCssCb);
    this.pendingCssEvent = this.pendingCssCb = null;
  }
  if (this.pendingJsCb) {
    hasPending = true;
    this.pendingJsCb.cancel();
    this.pendingJsCb = null;
  }
  if (hasPending) {
    removeClass(this.el, this.enterClass);
    removeClass(this.el, this.leaveClass);
  }
  if (this.cancel) {
    this.cancel.call(this.vm, this.el);
    this.cancel = null;
  }
};

/**
 * Call a user-provided synchronous hook function.
 *
 * @param {String} type
 */

p$1.callHook = function (type) {
  if (this.hooks && this.hooks[type]) {
    this.hooks[type].call(this.vm, this.el);
  }
};

/**
 * Call a user-provided, potentially-async hook function.
 * We check for the length of arguments to see if the hook
 * expects a `done` callback. If true, the transition's end
 * will be determined by when the user calls that callback;
 * otherwise, the end is determined by the CSS transition or
 * animation.
 *
 * @param {String} type
 */

p$1.callHookWithCb = function (type) {
  var hook = this.hooks && this.hooks[type];
  if (hook) {
    if (hook.length > 1) {
      this.pendingJsCb = cancellable(this[type + 'Done']);
    }
    hook.call(this.vm, this.el, this.pendingJsCb);
  }
};

/**
 * Get an element's transition type based on the
 * calculated styles.
 *
 * @param {String} className
 * @return {Number}
 */

p$1.getCssTransitionType = function (className) {
  /* istanbul ignore if */
  if (!transitionEndEvent ||
  // skip CSS transitions if page is not visible -
  // this solves the issue of transitionend events not
  // firing until the page is visible again.
  // pageVisibility API is supported in IE10+, same as
  // CSS transitions.
  document.hidden ||
  // explicit js-only transition
  this.hooks && this.hooks.css === false ||
  // element is hidden
  isHidden(this.el)) {
    return;
  }
  var type = this.type || this.typeCache[className];
  if (type) return type;
  var inlineStyles = this.el.style;
  var computedStyles = window.getComputedStyle(this.el);
  var transDuration = inlineStyles[transDurationProp] || computedStyles[transDurationProp];
  if (transDuration && transDuration !== '0s') {
    type = TYPE_TRANSITION;
  } else {
    var animDuration = inlineStyles[animDurationProp] || computedStyles[animDurationProp];
    if (animDuration && animDuration !== '0s') {
      type = TYPE_ANIMATION;
    }
  }
  if (type) {
    this.typeCache[className] = type;
  }
  return type;
};

/**
 * Setup a CSS transitionend/animationend callback.
 *
 * @param {String} event
 * @param {Function} cb
 */

p$1.setupCssCb = function (event, cb) {
  this.pendingCssEvent = event;
  var self = this;
  var el = this.el;
  var onEnd = this.pendingCssCb = function (e) {
    if (e.target === el) {
      off(el, event, onEnd);
      self.pendingCssEvent = self.pendingCssCb = null;
      if (!self.pendingJsCb && cb) {
        cb();
      }
    }
  };
  on(el, event, onEnd);
};

/**
 * Check if an element is hidden - in that case we can just
 * skip the transition alltogether.
 *
 * @param {Element} el
 * @return {Boolean}
 */

function isHidden(el) {
  if (/svg$/.test(el.namespaceURI)) {
    // SVG elements do not have offset(Width|Height)
    // so we need to check the client rect
    var rect = el.getBoundingClientRect();
    return !(rect.width || rect.height);
  } else {
    return !(el.offsetWidth || el.offsetHeight || el.getClientRects().length);
  }
}

var transition$1 = {

  priority: TRANSITION,

  update: function update(id, oldId) {
    var el = this.el;
    // resolve on owner vm
    var hooks = resolveAsset(this.vm.$options, 'transitions', id);
    id = id || 'v';
    oldId = oldId || 'v';
    el.__v_trans = new Transition(el, id, hooks, this.vm);
    removeClass(el, oldId + '-transition');
    addClass(el, id + '-transition');
  }
};

var internalDirectives = {
  style: style,
  'class': vClass,
  component: component,
  prop: propDef,
  transition: transition$1
};

// special binding prefixes
var bindRE = /^v-bind:|^:/;
var onRE = /^v-on:|^@/;
var dirAttrRE = /^v-([^:]+)(?:$|:(.*)$)/;
var modifierRE = /\.[^\.]+/g;
var transitionRE = /^(v-bind:|:)?transition$/;

// default directive priority
var DEFAULT_PRIORITY = 1000;
var DEFAULT_TERMINAL_PRIORITY = 2000;

/**
 * Compile a template and return a reusable composite link
 * function, which recursively contains more link functions
 * inside. This top level compile function would normally
 * be called on instance root nodes, but can also be used
 * for partial compilation if the partial argument is true.
 *
 * The returned composite link function, when called, will
 * return an unlink function that tearsdown all directives
 * created during the linking phase.
 *
 * @param {Element|DocumentFragment} el
 * @param {Object} options
 * @param {Boolean} partial
 * @return {Function}
 */

function compile(el, options, partial) {
  // link function for the node itself.
  var nodeLinkFn = partial || !options._asComponent ? compileNode(el, options) : null;
  // link function for the childNodes
  var childLinkFn = !(nodeLinkFn && nodeLinkFn.terminal) && !isScript(el) && el.hasChildNodes() ? compileNodeList(el.childNodes, options) : null;

  /**
   * A composite linker function to be called on a already
   * compiled piece of DOM, which instantiates all directive
   * instances.
   *
   * @param {Vue} vm
   * @param {Element|DocumentFragment} el
   * @param {Vue} [host] - host vm of transcluded content
   * @param {Object} [scope] - v-for scope
   * @param {Fragment} [frag] - link context fragment
   * @return {Function|undefined}
   */

  return function compositeLinkFn(vm, el, host, scope, frag) {
    // cache childNodes before linking parent, fix #657
    var childNodes = toArray(el.childNodes);
    // link
    var dirs = linkAndCapture(function compositeLinkCapturer() {
      if (nodeLinkFn) nodeLinkFn(vm, el, host, scope, frag);
      if (childLinkFn) childLinkFn(vm, childNodes, host, scope, frag);
    }, vm);
    return makeUnlinkFn(vm, dirs);
  };
}

/**
 * Apply a linker to a vm/element pair and capture the
 * directives created during the process.
 *
 * @param {Function} linker
 * @param {Vue} vm
 */

function linkAndCapture(linker, vm) {
  /* istanbul ignore if */
  if (process.env.NODE_ENV === 'production') {
    // reset directives before every capture in production
    // mode, so that when unlinking we don't need to splice
    // them out (which turns out to be a perf hit).
    // they are kept in development mode because they are
    // useful for Vue's own tests.
    vm._directives = [];
  }
  var originalDirCount = vm._directives.length;
  linker();
  var dirs = vm._directives.slice(originalDirCount);
  dirs.sort(directiveComparator);
  for (var i = 0, l = dirs.length; i < l; i++) {
    dirs[i]._bind();
  }
  return dirs;
}

/**
 * Directive priority sort comparator
 *
 * @param {Object} a
 * @param {Object} b
 */

function directiveComparator(a, b) {
  a = a.descriptor.def.priority || DEFAULT_PRIORITY;
  b = b.descriptor.def.priority || DEFAULT_PRIORITY;
  return a > b ? -1 : a === b ? 0 : 1;
}

/**
 * Linker functions return an unlink function that
 * tearsdown all directives instances generated during
 * the process.
 *
 * We create unlink functions with only the necessary
 * information to avoid retaining additional closures.
 *
 * @param {Vue} vm
 * @param {Array} dirs
 * @param {Vue} [context]
 * @param {Array} [contextDirs]
 * @return {Function}
 */

function makeUnlinkFn(vm, dirs, context, contextDirs) {
  function unlink(destroying) {
    teardownDirs(vm, dirs, destroying);
    if (context && contextDirs) {
      teardownDirs(context, contextDirs);
    }
  }
  // expose linked directives
  unlink.dirs = dirs;
  return unlink;
}

/**
 * Teardown partial linked directives.
 *
 * @param {Vue} vm
 * @param {Array} dirs
 * @param {Boolean} destroying
 */

function teardownDirs(vm, dirs, destroying) {
  var i = dirs.length;
  while (i--) {
    dirs[i]._teardown();
    if (process.env.NODE_ENV !== 'production' && !destroying) {
      vm._directives.$remove(dirs[i]);
    }
  }
}

/**
 * Compile link props on an instance.
 *
 * @param {Vue} vm
 * @param {Element} el
 * @param {Object} props
 * @param {Object} [scope]
 * @return {Function}
 */

function compileAndLinkProps(vm, el, props, scope) {
  var propsLinkFn = compileProps(el, props, vm);
  var propDirs = linkAndCapture(function () {
    propsLinkFn(vm, scope);
  }, vm);
  return makeUnlinkFn(vm, propDirs);
}

/**
 * Compile the root element of an instance.
 *
 * 1. attrs on context container (context scope)
 * 2. attrs on the component template root node, if
 *    replace:true (child scope)
 *
 * If this is a fragment instance, we only need to compile 1.
 *
 * @param {Element} el
 * @param {Object} options
 * @param {Object} contextOptions
 * @return {Function}
 */

function compileRoot(el, options, contextOptions) {
  var containerAttrs = options._containerAttrs;
  var replacerAttrs = options._replacerAttrs;
  var contextLinkFn, replacerLinkFn;

  // only need to compile other attributes for
  // non-fragment instances
  if (el.nodeType !== 11) {
    // for components, container and replacer need to be
    // compiled separately and linked in different scopes.
    if (options._asComponent) {
      // 2. container attributes
      if (containerAttrs && contextOptions) {
        contextLinkFn = compileDirectives(containerAttrs, contextOptions);
      }
      if (replacerAttrs) {
        // 3. replacer attributes
        replacerLinkFn = compileDirectives(replacerAttrs, options);
      }
    } else {
      // non-component, just compile as a normal element.
      replacerLinkFn = compileDirectives(el.attributes, options);
    }
  } else if (process.env.NODE_ENV !== 'production' && containerAttrs) {
    // warn container directives for fragment instances
    var names = containerAttrs.filter(function (attr) {
      // allow vue-loader/vueify scoped css attributes
      return attr.name.indexOf('_v-') < 0 &&
      // allow event listeners
      !onRE.test(attr.name) &&
      // allow slots
      attr.name !== 'slot';
    }).map(function (attr) {
      return '"' + attr.name + '"';
    });
    if (names.length) {
      var plural = names.length > 1;
      warn('Attribute' + (plural ? 's ' : ' ') + names.join(', ') + (plural ? ' are' : ' is') + ' ignored on component ' + '<' + options.el.tagName.toLowerCase() + '> because ' + 'the component is a fragment instance: ' + 'http://vuejs.org/guide/components.html#Fragment-Instance');
    }
  }

  options._containerAttrs = options._replacerAttrs = null;
  return function rootLinkFn(vm, el, scope) {
    // link context scope dirs
    var context = vm._context;
    var contextDirs;
    if (context && contextLinkFn) {
      contextDirs = linkAndCapture(function () {
        contextLinkFn(context, el, null, scope);
      }, context);
    }

    // link self
    var selfDirs = linkAndCapture(function () {
      if (replacerLinkFn) replacerLinkFn(vm, el);
    }, vm);

    // return the unlink function that tearsdown context
    // container directives.
    return makeUnlinkFn(vm, selfDirs, context, contextDirs);
  };
}

/**
 * Compile a node and return a nodeLinkFn based on the
 * node type.
 *
 * @param {Node} node
 * @param {Object} options
 * @return {Function|null}
 */

function compileNode(node, options) {
  var type = node.nodeType;
  if (type === 1 && !isScript(node)) {
    return compileElement(node, options);
  } else if (type === 3 && node.data.trim()) {
    return compileTextNode(node, options);
  } else {
    return null;
  }
}

/**
 * Compile an element and return a nodeLinkFn.
 *
 * @param {Element} el
 * @param {Object} options
 * @return {Function|null}
 */

function compileElement(el, options) {
  // preprocess textareas.
  // textarea treats its text content as the initial value.
  // just bind it as an attr directive for value.
  if (el.tagName === 'TEXTAREA') {
    var tokens = parseText(el.value);
    if (tokens) {
      el.setAttribute(':value', tokensToExp(tokens));
      el.value = '';
    }
  }
  var linkFn;
  var hasAttrs = el.hasAttributes();
  var attrs = hasAttrs && toArray(el.attributes);
  // check terminal directives (for & if)
  if (hasAttrs) {
    linkFn = checkTerminalDirectives(el, attrs, options);
  }
  // check element directives
  if (!linkFn) {
    linkFn = checkElementDirectives(el, options);
  }
  // check component
  if (!linkFn) {
    linkFn = checkComponent(el, options);
  }
  // normal directives
  if (!linkFn && hasAttrs) {
    linkFn = compileDirectives(attrs, options);
  }
  return linkFn;
}

/**
 * Compile a textNode and return a nodeLinkFn.
 *
 * @param {TextNode} node
 * @param {Object} options
 * @return {Function|null} textNodeLinkFn
 */

function compileTextNode(node, options) {
  // skip marked text nodes
  if (node._skip) {
    return removeText;
  }

  var tokens = parseText(node.wholeText);
  if (!tokens) {
    return null;
  }

  // mark adjacent text nodes as skipped,
  // because we are using node.wholeText to compile
  // all adjacent text nodes together. This fixes
  // issues in IE where sometimes it splits up a single
  // text node into multiple ones.
  var next = node.nextSibling;
  while (next && next.nodeType === 3) {
    next._skip = true;
    next = next.nextSibling;
  }

  var frag = document.createDocumentFragment();
  var el, token;
  for (var i = 0, l = tokens.length; i < l; i++) {
    token = tokens[i];
    el = token.tag ? processTextToken(token, options) : document.createTextNode(token.value);
    frag.appendChild(el);
  }
  return makeTextNodeLinkFn(tokens, frag, options);
}

/**
 * Linker for an skipped text node.
 *
 * @param {Vue} vm
 * @param {Text} node
 */

function removeText(vm, node) {
  remove(node);
}

/**
 * Process a single text token.
 *
 * @param {Object} token
 * @param {Object} options
 * @return {Node}
 */

function processTextToken(token, options) {
  var el;
  if (token.oneTime) {
    el = document.createTextNode(token.value);
  } else {
    if (token.html) {
      el = document.createComment('v-html');
      setTokenType('html');
    } else {
      // IE will clean up empty textNodes during
      // frag.cloneNode(true), so we have to give it
      // something here...
      el = document.createTextNode(' ');
      setTokenType('text');
    }
  }
  function setTokenType(type) {
    if (token.descriptor) return;
    var parsed = parseDirective(token.value);
    token.descriptor = {
      name: type,
      def: directives[type],
      expression: parsed.expression,
      filters: parsed.filters
    };
  }
  return el;
}

/**
 * Build a function that processes a textNode.
 *
 * @param {Array<Object>} tokens
 * @param {DocumentFragment} frag
 */

function makeTextNodeLinkFn(tokens, frag) {
  return function textNodeLinkFn(vm, el, host, scope) {
    var fragClone = frag.cloneNode(true);
    var childNodes = toArray(fragClone.childNodes);
    var token, value, node;
    for (var i = 0, l = tokens.length; i < l; i++) {
      token = tokens[i];
      value = token.value;
      if (token.tag) {
        node = childNodes[i];
        if (token.oneTime) {
          value = (scope || vm).$eval(value);
          if (token.html) {
            replace(node, parseTemplate(value, true));
          } else {
            node.data = _toString(value);
          }
        } else {
          vm._bindDir(token.descriptor, node, host, scope);
        }
      }
    }
    replace(el, fragClone);
  };
}

/**
 * Compile a node list and return a childLinkFn.
 *
 * @param {NodeList} nodeList
 * @param {Object} options
 * @return {Function|undefined}
 */

function compileNodeList(nodeList, options) {
  var linkFns = [];
  var nodeLinkFn, childLinkFn, node;
  for (var i = 0, l = nodeList.length; i < l; i++) {
    node = nodeList[i];
    nodeLinkFn = compileNode(node, options);
    childLinkFn = !(nodeLinkFn && nodeLinkFn.terminal) && node.tagName !== 'SCRIPT' && node.hasChildNodes() ? compileNodeList(node.childNodes, options) : null;
    linkFns.push(nodeLinkFn, childLinkFn);
  }
  return linkFns.length ? makeChildLinkFn(linkFns) : null;
}

/**
 * Make a child link function for a node's childNodes.
 *
 * @param {Array<Function>} linkFns
 * @return {Function} childLinkFn
 */

function makeChildLinkFn(linkFns) {
  return function childLinkFn(vm, nodes, host, scope, frag) {
    var node, nodeLinkFn, childrenLinkFn;
    for (var i = 0, n = 0, l = linkFns.length; i < l; n++) {
      node = nodes[n];
      nodeLinkFn = linkFns[i++];
      childrenLinkFn = linkFns[i++];
      // cache childNodes before linking parent, fix #657
      var childNodes = toArray(node.childNodes);
      if (nodeLinkFn) {
        nodeLinkFn(vm, node, host, scope, frag);
      }
      if (childrenLinkFn) {
        childrenLinkFn(vm, childNodes, host, scope, frag);
      }
    }
  };
}

/**
 * Check for element directives (custom elements that should
 * be resovled as terminal directives).
 *
 * @param {Element} el
 * @param {Object} options
 */

function checkElementDirectives(el, options) {
  var tag = el.tagName.toLowerCase();
  if (commonTagRE.test(tag)) {
    return;
  }
  var def = resolveAsset(options, 'elementDirectives', tag);
  if (def) {
    return makeTerminalNodeLinkFn(el, tag, '', options, def);
  }
}

/**
 * Check if an element is a component. If yes, return
 * a component link function.
 *
 * @param {Element} el
 * @param {Object} options
 * @return {Function|undefined}
 */

function checkComponent(el, options) {
  var component = checkComponentAttr(el, options);
  if (component) {
    var ref = findRef(el);
    var descriptor = {
      name: 'component',
      ref: ref,
      expression: component.id,
      def: internalDirectives.component,
      modifiers: {
        literal: !component.dynamic
      }
    };
    var componentLinkFn = function componentLinkFn(vm, el, host, scope, frag) {
      if (ref) {
        defineReactive((scope || vm).$refs, ref, null);
      }
      vm._bindDir(descriptor, el, host, scope, frag);
    };
    componentLinkFn.terminal = true;
    return componentLinkFn;
  }
}

/**
 * Check an element for terminal directives in fixed order.
 * If it finds one, return a terminal link function.
 *
 * @param {Element} el
 * @param {Array} attrs
 * @param {Object} options
 * @return {Function} terminalLinkFn
 */

function checkTerminalDirectives(el, attrs, options) {
  // skip v-pre
  if (getAttr(el, 'v-pre') !== null) {
    return skip;
  }
  // skip v-else block, but only if following v-if
  if (el.hasAttribute('v-else')) {
    var prev = el.previousElementSibling;
    if (prev && prev.hasAttribute('v-if')) {
      return skip;
    }
  }

  var attr, name, value, modifiers, matched, dirName, rawName, arg, def, termDef;
  for (var i = 0, j = attrs.length; i < j; i++) {
    attr = attrs[i];
    name = attr.name.replace(modifierRE, '');
    if (matched = name.match(dirAttrRE)) {
      def = resolveAsset(options, 'directives', matched[1]);
      if (def && def.terminal) {
        if (!termDef || (def.priority || DEFAULT_TERMINAL_PRIORITY) > termDef.priority) {
          termDef = def;
          rawName = attr.name;
          modifiers = parseModifiers(attr.name);
          value = attr.value;
          dirName = matched[1];
          arg = matched[2];
        }
      }
    }
  }

  if (termDef) {
    return makeTerminalNodeLinkFn(el, dirName, value, options, termDef, rawName, arg, modifiers);
  }
}

function skip() {}
skip.terminal = true;

/**
 * Build a node link function for a terminal directive.
 * A terminal link function terminates the current
 * compilation recursion and handles compilation of the
 * subtree in the directive.
 *
 * @param {Element} el
 * @param {String} dirName
 * @param {String} value
 * @param {Object} options
 * @param {Object} def
 * @param {String} [rawName]
 * @param {String} [arg]
 * @param {Object} [modifiers]
 * @return {Function} terminalLinkFn
 */

function makeTerminalNodeLinkFn(el, dirName, value, options, def, rawName, arg, modifiers) {
  var parsed = parseDirective(value);
  var descriptor = {
    name: dirName,
    arg: arg,
    expression: parsed.expression,
    filters: parsed.filters,
    raw: value,
    attr: rawName,
    modifiers: modifiers,
    def: def
  };
  // check ref for v-for and router-view
  if (dirName === 'for' || dirName === 'router-view') {
    descriptor.ref = findRef(el);
  }
  var fn = function terminalNodeLinkFn(vm, el, host, scope, frag) {
    if (descriptor.ref) {
      defineReactive((scope || vm).$refs, descriptor.ref, null);
    }
    vm._bindDir(descriptor, el, host, scope, frag);
  };
  fn.terminal = true;
  return fn;
}

/**
 * Compile the directives on an element and return a linker.
 *
 * @param {Array|NamedNodeMap} attrs
 * @param {Object} options
 * @return {Function}
 */

function compileDirectives(attrs, options) {
  var i = attrs.length;
  var dirs = [];
  var attr, name, value, rawName, rawValue, dirName, arg, modifiers, dirDef, tokens, matched;
  while (i--) {
    attr = attrs[i];
    name = rawName = attr.name;
    value = rawValue = attr.value;
    tokens = parseText(value);
    // reset arg
    arg = null;
    // check modifiers
    modifiers = parseModifiers(name);
    name = name.replace(modifierRE, '');

    // attribute interpolations
    if (tokens) {
      value = tokensToExp(tokens);
      arg = name;
      pushDir('bind', directives.bind, tokens);
      // warn against mixing mustaches with v-bind
      if (process.env.NODE_ENV !== 'production') {
        if (name === 'class' && Array.prototype.some.call(attrs, function (attr) {
          return attr.name === ':class' || attr.name === 'v-bind:class';
        })) {
          warn('class="' + rawValue + '": Do not mix mustache interpolation ' + 'and v-bind for "class" on the same element. Use one or the other.', options);
        }
      }
    } else

      // special attribute: transition
      if (transitionRE.test(name)) {
        modifiers.literal = !bindRE.test(name);
        pushDir('transition', internalDirectives.transition);
      } else

        // event handlers
        if (onRE.test(name)) {
          arg = name.replace(onRE, '');
          pushDir('on', directives.on);
        } else

          // attribute bindings
          if (bindRE.test(name)) {
            dirName = name.replace(bindRE, '');
            if (dirName === 'style' || dirName === 'class') {
              pushDir(dirName, internalDirectives[dirName]);
            } else {
              arg = dirName;
              pushDir('bind', directives.bind);
            }
          } else

            // normal directives
            if (matched = name.match(dirAttrRE)) {
              dirName = matched[1];
              arg = matched[2];

              // skip v-else (when used with v-show)
              if (dirName === 'else') {
                continue;
              }

              dirDef = resolveAsset(options, 'directives', dirName, true);
              if (dirDef) {
                pushDir(dirName, dirDef);
              }
            }
  }

  /**
   * Push a directive.
   *
   * @param {String} dirName
   * @param {Object|Function} def
   * @param {Array} [interpTokens]
   */

  function pushDir(dirName, def, interpTokens) {
    var hasOneTimeToken = interpTokens && hasOneTime(interpTokens);
    var parsed = !hasOneTimeToken && parseDirective(value);
    dirs.push({
      name: dirName,
      attr: rawName,
      raw: rawValue,
      def: def,
      arg: arg,
      modifiers: modifiers,
      // conversion from interpolation strings with one-time token
      // to expression is differed until directive bind time so that we
      // have access to the actual vm context for one-time bindings.
      expression: parsed && parsed.expression,
      filters: parsed && parsed.filters,
      interp: interpTokens,
      hasOneTime: hasOneTimeToken
    });
  }

  if (dirs.length) {
    return makeNodeLinkFn(dirs);
  }
}

/**
 * Parse modifiers from directive attribute name.
 *
 * @param {String} name
 * @return {Object}
 */

function parseModifiers(name) {
  var res = Object.create(null);
  var match = name.match(modifierRE);
  if (match) {
    var i = match.length;
    while (i--) {
      res[match[i].slice(1)] = true;
    }
  }
  return res;
}

/**
 * Build a link function for all directives on a single node.
 *
 * @param {Array} directives
 * @return {Function} directivesLinkFn
 */

function makeNodeLinkFn(directives) {
  return function nodeLinkFn(vm, el, host, scope, frag) {
    // reverse apply because it's sorted low to high
    var i = directives.length;
    while (i--) {
      vm._bindDir(directives[i], el, host, scope, frag);
    }
  };
}

/**
 * Check if an interpolation string contains one-time tokens.
 *
 * @param {Array} tokens
 * @return {Boolean}
 */

function hasOneTime(tokens) {
  var i = tokens.length;
  while (i--) {
    if (tokens[i].oneTime) return true;
  }
}

function isScript(el) {
  return el.tagName === 'SCRIPT' && (!el.hasAttribute('type') || el.getAttribute('type') === 'text/javascript');
}

var specialCharRE = /[^\w\-:\.]/;

/**
 * Process an element or a DocumentFragment based on a
 * instance option object. This allows us to transclude
 * a template node/fragment before the instance is created,
 * so the processed fragment can then be cloned and reused
 * in v-for.
 *
 * @param {Element} el
 * @param {Object} options
 * @return {Element|DocumentFragment}
 */

function transclude(el, options) {
  // extract container attributes to pass them down
  // to compiler, because they need to be compiled in
  // parent scope. we are mutating the options object here
  // assuming the same object will be used for compile
  // right after this.
  if (options) {
    options._containerAttrs = extractAttrs(el);
  }
  // for template tags, what we want is its content as
  // a documentFragment (for fragment instances)
  if (isTemplate(el)) {
    el = parseTemplate(el);
  }
  if (options) {
    if (options._asComponent && !options.template) {
      options.template = '<slot></slot>';
    }
    if (options.template) {
      options._content = extractContent(el);
      el = transcludeTemplate(el, options);
    }
  }
  if (isFragment(el)) {
    // anchors for fragment instance
    // passing in `persist: true` to avoid them being
    // discarded by IE during template cloning
    prepend(createAnchor('v-start', true), el);
    el.appendChild(createAnchor('v-end', true));
  }
  return el;
}

/**
 * Process the template option.
 * If the replace option is true this will swap the $el.
 *
 * @param {Element} el
 * @param {Object} options
 * @return {Element|DocumentFragment}
 */

function transcludeTemplate(el, options) {
  var template = options.template;
  var frag = parseTemplate(template, true);
  if (frag) {
    var replacer = frag.firstChild;
    var tag = replacer.tagName && replacer.tagName.toLowerCase();
    if (options.replace) {
      /* istanbul ignore if */
      if (el === document.body) {
        process.env.NODE_ENV !== 'production' && warn('You are mounting an instance with a template to ' + '<body>. This will replace <body> entirely. You ' + 'should probably use `replace: false` here.');
      }
      // there are many cases where the instance must
      // become a fragment instance: basically anything that
      // can create more than 1 root nodes.
      if (
      // multi-children template
      frag.childNodes.length > 1 ||
      // non-element template
      replacer.nodeType !== 1 ||
      // single nested component
      tag === 'component' || resolveAsset(options, 'components', tag) || hasBindAttr(replacer, 'is') ||
      // element directive
      resolveAsset(options, 'elementDirectives', tag) ||
      // for block
      replacer.hasAttribute('v-for') ||
      // if block
      replacer.hasAttribute('v-if')) {
        return frag;
      } else {
        options._replacerAttrs = extractAttrs(replacer);
        mergeAttrs(el, replacer);
        return replacer;
      }
    } else {
      el.appendChild(frag);
      return el;
    }
  } else {
    process.env.NODE_ENV !== 'production' && warn('Invalid template option: ' + template);
  }
}

/**
 * Helper to extract a component container's attributes
 * into a plain object array.
 *
 * @param {Element} el
 * @return {Array}
 */

function extractAttrs(el) {
  if (el.nodeType === 1 && el.hasAttributes()) {
    return toArray(el.attributes);
  }
}

/**
 * Merge the attributes of two elements, and make sure
 * the class names are merged properly.
 *
 * @param {Element} from
 * @param {Element} to
 */

function mergeAttrs(from, to) {
  var attrs = from.attributes;
  var i = attrs.length;
  var name, value;
  while (i--) {
    name = attrs[i].name;
    value = attrs[i].value;
    if (!to.hasAttribute(name) && !specialCharRE.test(name)) {
      to.setAttribute(name, value);
    } else if (name === 'class' && !parseText(value) && (value = value.trim())) {
      value.split(/\s+/).forEach(function (cls) {
        addClass(to, cls);
      });
    }
  }
}

/**
 * Scan and determine slot content distribution.
 * We do this during transclusion instead at compile time so that
 * the distribution is decoupled from the compilation order of
 * the slots.
 *
 * @param {Element|DocumentFragment} template
 * @param {Element} content
 * @param {Vue} vm
 */

function resolveSlots(vm, content) {
  if (!content) {
    return;
  }
  var contents = vm._slotContents = Object.create(null);
  var el, name;
  for (var i = 0, l = content.children.length; i < l; i++) {
    el = content.children[i];
    /* eslint-disable no-cond-assign */
    if (name = el.getAttribute('slot')) {
      (contents[name] || (contents[name] = [])).push(el);
    }
    /* eslint-enable no-cond-assign */
    if (process.env.NODE_ENV !== 'production' && getBindAttr(el, 'slot')) {
      warn('The "slot" attribute must be static.', vm.$parent);
    }
  }
  for (name in contents) {
    contents[name] = extractFragment(contents[name], content);
  }
  if (content.hasChildNodes()) {
    var nodes = content.childNodes;
    if (nodes.length === 1 && nodes[0].nodeType === 3 && !nodes[0].data.trim()) {
      return;
    }
    contents['default'] = extractFragment(content.childNodes, content);
  }
}

/**
 * Extract qualified content nodes from a node list.
 *
 * @param {NodeList} nodes
 * @return {DocumentFragment}
 */

function extractFragment(nodes, parent) {
  var frag = document.createDocumentFragment();
  nodes = toArray(nodes);
  for (var i = 0, l = nodes.length; i < l; i++) {
    var node = nodes[i];
    if (isTemplate(node) && !node.hasAttribute('v-if') && !node.hasAttribute('v-for')) {
      parent.removeChild(node);
      node = parseTemplate(node, true);
    }
    frag.appendChild(node);
  }
  return frag;
}



var compiler = Object.freeze({
	compile: compile,
	compileAndLinkProps: compileAndLinkProps,
	compileRoot: compileRoot,
	transclude: transclude,
	resolveSlots: resolveSlots
});

function stateMixin (Vue) {
  /**
   * Accessor for `$data` property, since setting $data
   * requires observing the new object and updating
   * proxied properties.
   */

  Object.defineProperty(Vue.prototype, '$data', {
    get: function get() {
      return this._data;
    },
    set: function set(newData) {
      if (newData !== this._data) {
        this._setData(newData);
      }
    }
  });

  /**
   * Setup the scope of an instance, which contains:
   * - observed data
   * - computed properties
   * - user methods
   * - meta properties
   */

  Vue.prototype._initState = function () {
    this._initProps();
    this._initMeta();
    this._initMethods();
    this._initData();
    this._initComputed();
  };

  /**
   * Initialize props.
   */

  Vue.prototype._initProps = function () {
    var options = this.$options;
    var el = options.el;
    var props = options.props;
    if (props && !el) {
      process.env.NODE_ENV !== 'production' && warn('Props will not be compiled if no `el` option is ' + 'provided at instantiation.', this);
    }
    // make sure to convert string selectors into element now
    el = options.el = query(el);
    this._propsUnlinkFn = el && el.nodeType === 1 && props
    // props must be linked in proper scope if inside v-for
    ? compileAndLinkProps(this, el, props, this._scope) : null;
  };

  /**
   * Initialize the data.
   */

  Vue.prototype._initData = function () {
    var dataFn = this.$options.data;
    var data = this._data = dataFn ? dataFn() : {};
    if (!isPlainObject(data)) {
      data = {};
      process.env.NODE_ENV !== 'production' && warn('data functions should return an object.', this);
    }
    var props = this._props;
    // proxy data on instance
    var keys = Object.keys(data);
    var i, key;
    i = keys.length;
    while (i--) {
      key = keys[i];
      // there are two scenarios where we can proxy a data key:
      // 1. it's not already defined as a prop
      // 2. it's provided via a instantiation option AND there are no
      //    template prop present
      if (!props || !hasOwn(props, key)) {
        this._proxy(key);
      } else if (process.env.NODE_ENV !== 'production') {
        warn('Data field "' + key + '" is already defined ' + 'as a prop. To provide default value for a prop, use the "default" ' + 'prop option; if you want to pass prop values to an instantiation ' + 'call, use the "propsData" option.', this);
      }
    }
    // observe data
    observe(data, this);
  };

  /**
   * Swap the instance's $data. Called in $data's setter.
   *
   * @param {Object} newData
   */

  Vue.prototype._setData = function (newData) {
    newData = newData || {};
    var oldData = this._data;
    this._data = newData;
    var keys, key, i;
    // unproxy keys not present in new data
    keys = Object.keys(oldData);
    i = keys.length;
    while (i--) {
      key = keys[i];
      if (!(key in newData)) {
        this._unproxy(key);
      }
    }
    // proxy keys not already proxied,
    // and trigger change for changed values
    keys = Object.keys(newData);
    i = keys.length;
    while (i--) {
      key = keys[i];
      if (!hasOwn(this, key)) {
        // new property
        this._proxy(key);
      }
    }
    oldData.__ob__.removeVm(this);
    observe(newData, this);
    this._digest();
  };

  /**
   * Proxy a property, so that
   * vm.prop === vm._data.prop
   *
   * @param {String} key
   */

  Vue.prototype._proxy = function (key) {
    if (!isReserved(key)) {
      // need to store ref to self here
      // because these getter/setters might
      // be called by child scopes via
      // prototype inheritance.
      var self = this;
      Object.defineProperty(self, key, {
        configurable: true,
        enumerable: true,
        get: function proxyGetter() {
          return self._data[key];
        },
        set: function proxySetter(val) {
          self._data[key] = val;
        }
      });
    }
  };

  /**
   * Unproxy a property.
   *
   * @param {String} key
   */

  Vue.prototype._unproxy = function (key) {
    if (!isReserved(key)) {
      delete this[key];
    }
  };

  /**
   * Force update on every watcher in scope.
   */

  Vue.prototype._digest = function () {
    for (var i = 0, l = this._watchers.length; i < l; i++) {
      this._watchers[i].update(true); // shallow updates
    }
  };

  /**
   * Setup computed properties. They are essentially
   * special getter/setters
   */

  function noop() {}
  Vue.prototype._initComputed = function () {
    var computed = this.$options.computed;
    if (computed) {
      for (var key in computed) {
        var userDef = computed[key];
        var def = {
          enumerable: true,
          configurable: true
        };
        if (typeof userDef === 'function') {
          def.get = makeComputedGetter(userDef, this);
          def.set = noop;
        } else {
          def.get = userDef.get ? userDef.cache !== false ? makeComputedGetter(userDef.get, this) : bind(userDef.get, this) : noop;
          def.set = userDef.set ? bind(userDef.set, this) : noop;
        }
        Object.defineProperty(this, key, def);
      }
    }
  };

  function makeComputedGetter(getter, owner) {
    var watcher = new Watcher(owner, getter, null, {
      lazy: true
    });
    return function computedGetter() {
      if (watcher.dirty) {
        watcher.evaluate();
      }
      if (Dep.target) {
        watcher.depend();
      }
      return watcher.value;
    };
  }

  /**
   * Setup instance methods. Methods must be bound to the
   * instance since they might be passed down as a prop to
   * child components.
   */

  Vue.prototype._initMethods = function () {
    var methods = this.$options.methods;
    if (methods) {
      for (var key in methods) {
        this[key] = bind(methods[key], this);
      }
    }
  };

  /**
   * Initialize meta information like $index, $key & $value.
   */

  Vue.prototype._initMeta = function () {
    var metas = this.$options._meta;
    if (metas) {
      for (var key in metas) {
        defineReactive(this, key, metas[key]);
      }
    }
  };
}

var eventRE = /^v-on:|^@/;

function eventsMixin (Vue) {
  /**
   * Setup the instance's option events & watchers.
   * If the value is a string, we pull it from the
   * instance's methods by name.
   */

  Vue.prototype._initEvents = function () {
    var options = this.$options;
    if (options._asComponent) {
      registerComponentEvents(this, options.el);
    }
    registerCallbacks(this, '$on', options.events);
    registerCallbacks(this, '$watch', options.watch);
  };

  /**
   * Register v-on events on a child component
   *
   * @param {Vue} vm
   * @param {Element} el
   */

  function registerComponentEvents(vm, el) {
    var attrs = el.attributes;
    var name, value, handler;
    for (var i = 0, l = attrs.length; i < l; i++) {
      name = attrs[i].name;
      if (eventRE.test(name)) {
        name = name.replace(eventRE, '');
        // force the expression into a statement so that
        // it always dynamically resolves the method to call (#2670)
        // kinda ugly hack, but does the job.
        value = attrs[i].value;
        if (isSimplePath(value)) {
          value += '.apply(this, $arguments)';
        }
        handler = (vm._scope || vm._context).$eval(value, true);
        handler._fromParent = true;
        vm.$on(name.replace(eventRE), handler);
      }
    }
  }

  /**
   * Register callbacks for option events and watchers.
   *
   * @param {Vue} vm
   * @param {String} action
   * @param {Object} hash
   */

  function registerCallbacks(vm, action, hash) {
    if (!hash) return;
    var handlers, key, i, j;
    for (key in hash) {
      handlers = hash[key];
      if (isArray(handlers)) {
        for (i = 0, j = handlers.length; i < j; i++) {
          register(vm, action, key, handlers[i]);
        }
      } else {
        register(vm, action, key, handlers);
      }
    }
  }

  /**
   * Helper to register an event/watch callback.
   *
   * @param {Vue} vm
   * @param {String} action
   * @param {String} key
   * @param {Function|String|Object} handler
   * @param {Object} [options]
   */

  function register(vm, action, key, handler, options) {
    var type = typeof handler;
    if (type === 'function') {
      vm[action](key, handler, options);
    } else if (type === 'string') {
      var methods = vm.$options.methods;
      var method = methods && methods[handler];
      if (method) {
        vm[action](key, method, options);
      } else {
        process.env.NODE_ENV !== 'production' && warn('Unknown method: "' + handler + '" when ' + 'registering callback for ' + action + ': "' + key + '".', vm);
      }
    } else if (handler && type === 'object') {
      register(vm, action, key, handler.handler, handler);
    }
  }

  /**
   * Setup recursive attached/detached calls
   */

  Vue.prototype._initDOMHooks = function () {
    this.$on('hook:attached', onAttached);
    this.$on('hook:detached', onDetached);
  };

  /**
   * Callback to recursively call attached hook on children
   */

  function onAttached() {
    if (!this._isAttached) {
      this._isAttached = true;
      this.$children.forEach(callAttach);
    }
  }

  /**
   * Iterator to call attached hook
   *
   * @param {Vue} child
   */

  function callAttach(child) {
    if (!child._isAttached && inDoc(child.$el)) {
      child._callHook('attached');
    }
  }

  /**
   * Callback to recursively call detached hook on children
   */

  function onDetached() {
    if (this._isAttached) {
      this._isAttached = false;
      this.$children.forEach(callDetach);
    }
  }

  /**
   * Iterator to call detached hook
   *
   * @param {Vue} child
   */

  function callDetach(child) {
    if (child._isAttached && !inDoc(child.$el)) {
      child._callHook('detached');
    }
  }

  /**
   * Trigger all handlers for a hook
   *
   * @param {String} hook
   */

  Vue.prototype._callHook = function (hook) {
    this.$emit('pre-hook:' + hook);
    var handlers = this.$options[hook];
    if (handlers) {
      for (var i = 0, j = handlers.length; i < j; i++) {
        handlers[i].call(this);
      }
    }
    this.$emit('hook:' + hook);
  };
}

function noop$1() {}

/**
 * A directive links a DOM element with a piece of data,
 * which is the result of evaluating an expression.
 * It registers a watcher with the expression and calls
 * the DOM update function when a change is triggered.
 *
 * @param {Object} descriptor
 *                 - {String} name
 *                 - {Object} def
 *                 - {String} expression
 *                 - {Array<Object>} [filters]
 *                 - {Object} [modifiers]
 *                 - {Boolean} literal
 *                 - {String} attr
 *                 - {String} arg
 *                 - {String} raw
 *                 - {String} [ref]
 *                 - {Array<Object>} [interp]
 *                 - {Boolean} [hasOneTime]
 * @param {Vue} vm
 * @param {Node} el
 * @param {Vue} [host] - transclusion host component
 * @param {Object} [scope] - v-for scope
 * @param {Fragment} [frag] - owner fragment
 * @constructor
 */
function Directive(descriptor, vm, el, host, scope, frag) {
  this.vm = vm;
  this.el = el;
  // copy descriptor properties
  this.descriptor = descriptor;
  this.name = descriptor.name;
  this.expression = descriptor.expression;
  this.arg = descriptor.arg;
  this.modifiers = descriptor.modifiers;
  this.filters = descriptor.filters;
  this.literal = this.modifiers && this.modifiers.literal;
  // private
  this._locked = false;
  this._bound = false;
  this._listeners = null;
  // link context
  this._host = host;
  this._scope = scope;
  this._frag = frag;
  // store directives on node in dev mode
  if (process.env.NODE_ENV !== 'production' && this.el) {
    this.el._vue_directives = this.el._vue_directives || [];
    this.el._vue_directives.push(this);
  }
}

/**
 * Initialize the directive, mixin definition properties,
 * setup the watcher, call definition bind() and update()
 * if present.
 */

Directive.prototype._bind = function () {
  var name = this.name;
  var descriptor = this.descriptor;

  // remove attribute
  if ((name !== 'cloak' || this.vm._isCompiled) && this.el && this.el.removeAttribute) {
    var attr = descriptor.attr || 'v-' + name;
    this.el.removeAttribute(attr);
  }

  // copy def properties
  var def = descriptor.def;
  if (typeof def === 'function') {
    this.update = def;
  } else {
    extend(this, def);
  }

  // setup directive params
  this._setupParams();

  // initial bind
  if (this.bind) {
    this.bind();
  }
  this._bound = true;

  if (this.literal) {
    this.update && this.update(descriptor.raw);
  } else if ((this.expression || this.modifiers) && (this.update || this.twoWay) && !this._checkStatement()) {
    // wrapped updater for context
    var dir = this;
    if (this.update) {
      this._update = function (val, oldVal) {
        if (!dir._locked) {
          dir.update(val, oldVal);
        }
      };
    } else {
      this._update = noop$1;
    }
    var preProcess = this._preProcess ? bind(this._preProcess, this) : null;
    var postProcess = this._postProcess ? bind(this._postProcess, this) : null;
    var watcher = this._watcher = new Watcher(this.vm, this.expression, this._update, // callback
    {
      filters: this.filters,
      twoWay: this.twoWay,
      deep: this.deep,
      preProcess: preProcess,
      postProcess: postProcess,
      scope: this._scope
    });
    // v-model with inital inline value need to sync back to
    // model instead of update to DOM on init. They would
    // set the afterBind hook to indicate that.
    if (this.afterBind) {
      this.afterBind();
    } else if (this.update) {
      this.update(watcher.value);
    }
  }
};

/**
 * Setup all param attributes, e.g. track-by,
 * transition-mode, etc...
 */

Directive.prototype._setupParams = function () {
  if (!this.params) {
    return;
  }
  var params = this.params;
  // swap the params array with a fresh object.
  this.params = Object.create(null);
  var i = params.length;
  var key, val, mappedKey;
  while (i--) {
    key = hyphenate(params[i]);
    mappedKey = camelize(key);
    val = getBindAttr(this.el, key);
    if (val != null) {
      // dynamic
      this._setupParamWatcher(mappedKey, val);
    } else {
      // static
      val = getAttr(this.el, key);
      if (val != null) {
        this.params[mappedKey] = val === '' ? true : val;
      }
    }
  }
};

/**
 * Setup a watcher for a dynamic param.
 *
 * @param {String} key
 * @param {String} expression
 */

Directive.prototype._setupParamWatcher = function (key, expression) {
  var self = this;
  var called = false;
  var unwatch = (this._scope || this.vm).$watch(expression, function (val, oldVal) {
    self.params[key] = val;
    // since we are in immediate mode,
    // only call the param change callbacks if this is not the first update.
    if (called) {
      var cb = self.paramWatchers && self.paramWatchers[key];
      if (cb) {
        cb.call(self, val, oldVal);
      }
    } else {
      called = true;
    }
  }, {
    immediate: true,
    user: false
  });(this._paramUnwatchFns || (this._paramUnwatchFns = [])).push(unwatch);
};

/**
 * Check if the directive is a function caller
 * and if the expression is a callable one. If both true,
 * we wrap up the expression and use it as the event
 * handler.
 *
 * e.g. on-click="a++"
 *
 * @return {Boolean}
 */

Directive.prototype._checkStatement = function () {
  var expression = this.expression;
  if (expression && this.acceptStatement && !isSimplePath(expression)) {
    var fn = parseExpression(expression).get;
    var scope = this._scope || this.vm;
    var handler = function handler(e) {
      scope.$event = e;
      fn.call(scope, scope);
      scope.$event = null;
    };
    if (this.filters) {
      handler = scope._applyFilters(handler, null, this.filters);
    }
    this.update(handler);
    return true;
  }
};

/**
 * Set the corresponding value with the setter.
 * This should only be used in two-way directives
 * e.g. v-model.
 *
 * @param {*} value
 * @public
 */

Directive.prototype.set = function (value) {
  /* istanbul ignore else */
  if (this.twoWay) {
    this._withLock(function () {
      this._watcher.set(value);
    });
  } else if (process.env.NODE_ENV !== 'production') {
    warn('Directive.set() can only be used inside twoWay' + 'directives.');
  }
};

/**
 * Execute a function while preventing that function from
 * triggering updates on this directive instance.
 *
 * @param {Function} fn
 */

Directive.prototype._withLock = function (fn) {
  var self = this;
  self._locked = true;
  fn.call(self);
  nextTick(function () {
    self._locked = false;
  });
};

/**
 * Convenience method that attaches a DOM event listener
 * to the directive element and autometically tears it down
 * during unbind.
 *
 * @param {String} event
 * @param {Function} handler
 * @param {Boolean} [useCapture]
 */

Directive.prototype.on = function (event, handler, useCapture) {
  on(this.el, event, handler, useCapture);(this._listeners || (this._listeners = [])).push([event, handler]);
};

/**
 * Teardown the watcher and call unbind.
 */

Directive.prototype._teardown = function () {
  if (this._bound) {
    this._bound = false;
    if (this.unbind) {
      this.unbind();
    }
    if (this._watcher) {
      this._watcher.teardown();
    }
    var listeners = this._listeners;
    var i;
    if (listeners) {
      i = listeners.length;
      while (i--) {
        off(this.el, listeners[i][0], listeners[i][1]);
      }
    }
    var unwatchFns = this._paramUnwatchFns;
    if (unwatchFns) {
      i = unwatchFns.length;
      while (i--) {
        unwatchFns[i]();
      }
    }
    if (process.env.NODE_ENV !== 'production' && this.el) {
      this.el._vue_directives.$remove(this);
    }
    this.vm = this.el = this._watcher = this._listeners = null;
  }
};

function lifecycleMixin (Vue) {
  /**
   * Update v-ref for component.
   *
   * @param {Boolean} remove
   */

  Vue.prototype._updateRef = function (remove) {
    var ref = this.$options._ref;
    if (ref) {
      var refs = (this._scope || this._context).$refs;
      if (remove) {
        if (refs[ref] === this) {
          refs[ref] = null;
        }
      } else {
        refs[ref] = this;
      }
    }
  };

  /**
   * Transclude, compile and link element.
   *
   * If a pre-compiled linker is available, that means the
   * passed in element will be pre-transcluded and compiled
   * as well - all we need to do is to call the linker.
   *
   * Otherwise we need to call transclude/compile/link here.
   *
   * @param {Element} el
   */

  Vue.prototype._compile = function (el) {
    var options = this.$options;

    // transclude and init element
    // transclude can potentially replace original
    // so we need to keep reference; this step also injects
    // the template and caches the original attributes
    // on the container node and replacer node.
    var original = el;
    el = transclude(el, options);
    this._initElement(el);

    // handle v-pre on root node (#2026)
    if (el.nodeType === 1 && getAttr(el, 'v-pre') !== null) {
      return;
    }

    // root is always compiled per-instance, because
    // container attrs and props can be different every time.
    var contextOptions = this._context && this._context.$options;
    var rootLinker = compileRoot(el, options, contextOptions);

    // resolve slot distribution
    resolveSlots(this, options._content);

    // compile and link the rest
    var contentLinkFn;
    var ctor = this.constructor;
    // component compilation can be cached
    // as long as it's not using inline-template
    if (options._linkerCachable) {
      contentLinkFn = ctor.linker;
      if (!contentLinkFn) {
        contentLinkFn = ctor.linker = compile(el, options);
      }
    }

    // link phase
    // make sure to link root with prop scope!
    var rootUnlinkFn = rootLinker(this, el, this._scope);
    var contentUnlinkFn = contentLinkFn ? contentLinkFn(this, el) : compile(el, options)(this, el);

    // register composite unlink function
    // to be called during instance destruction
    this._unlinkFn = function () {
      rootUnlinkFn();
      // passing destroying: true to avoid searching and
      // splicing the directives
      contentUnlinkFn(true);
    };

    // finally replace original
    if (options.replace) {
      replace(original, el);
    }

    this._isCompiled = true;
    this._callHook('compiled');
  };

  /**
   * Initialize instance element. Called in the public
   * $mount() method.
   *
   * @param {Element} el
   */

  Vue.prototype._initElement = function (el) {
    if (isFragment(el)) {
      this._isFragment = true;
      this.$el = this._fragmentStart = el.firstChild;
      this._fragmentEnd = el.lastChild;
      // set persisted text anchors to empty
      if (this._fragmentStart.nodeType === 3) {
        this._fragmentStart.data = this._fragmentEnd.data = '';
      }
      this._fragment = el;
    } else {
      this.$el = el;
    }
    this.$el.__vue__ = this;
    this._callHook('beforeCompile');
  };

  /**
   * Create and bind a directive to an element.
   *
   * @param {Object} descriptor - parsed directive descriptor
   * @param {Node} node   - target node
   * @param {Vue} [host] - transclusion host component
   * @param {Object} [scope] - v-for scope
   * @param {Fragment} [frag] - owner fragment
   */

  Vue.prototype._bindDir = function (descriptor, node, host, scope, frag) {
    this._directives.push(new Directive(descriptor, this, node, host, scope, frag));
  };

  /**
   * Teardown an instance, unobserves the data, unbind all the
   * directives, turn off all the event listeners, etc.
   *
   * @param {Boolean} remove - whether to remove the DOM node.
   * @param {Boolean} deferCleanup - if true, defer cleanup to
   *                                 be called later
   */

  Vue.prototype._destroy = function (remove, deferCleanup) {
    if (this._isBeingDestroyed) {
      if (!deferCleanup) {
        this._cleanup();
      }
      return;
    }

    var destroyReady;
    var pendingRemoval;

    var self = this;
    // Cleanup should be called either synchronously or asynchronoysly as
    // callback of this.$remove(), or if remove and deferCleanup are false.
    // In any case it should be called after all other removing, unbinding and
    // turning of is done
    var cleanupIfPossible = function cleanupIfPossible() {
      if (destroyReady && !pendingRemoval && !deferCleanup) {
        self._cleanup();
      }
    };

    // remove DOM element
    if (remove && this.$el) {
      pendingRemoval = true;
      this.$remove(function () {
        pendingRemoval = false;
        cleanupIfPossible();
      });
    }

    this._callHook('beforeDestroy');
    this._isBeingDestroyed = true;
    var i;
    // remove self from parent. only necessary
    // if parent is not being destroyed as well.
    var parent = this.$parent;
    if (parent && !parent._isBeingDestroyed) {
      parent.$children.$remove(this);
      // unregister ref (remove: true)
      this._updateRef(true);
    }
    // destroy all children.
    i = this.$children.length;
    while (i--) {
      this.$children[i].$destroy();
    }
    // teardown props
    if (this._propsUnlinkFn) {
      this._propsUnlinkFn();
    }
    // teardown all directives. this also tearsdown all
    // directive-owned watchers.
    if (this._unlinkFn) {
      this._unlinkFn();
    }
    i = this._watchers.length;
    while (i--) {
      this._watchers[i].teardown();
    }
    // remove reference to self on $el
    if (this.$el) {
      this.$el.__vue__ = null;
    }

    destroyReady = true;
    cleanupIfPossible();
  };

  /**
   * Clean up to ensure garbage collection.
   * This is called after the leave transition if there
   * is any.
   */

  Vue.prototype._cleanup = function () {
    if (this._isDestroyed) {
      return;
    }
    // remove self from owner fragment
    // do it in cleanup so that we can call $destroy with
    // defer right when a fragment is about to be removed.
    if (this._frag) {
      this._frag.children.$remove(this);
    }
    // remove reference from data ob
    // frozen object may not have observer.
    if (this._data && this._data.__ob__) {
      this._data.__ob__.removeVm(this);
    }
    // Clean up references to private properties and other
    // instances. preserve reference to _data so that proxy
    // accessors still work. The only potential side effect
    // here is that mutating the instance after it's destroyed
    // may affect the state of other components that are still
    // observing the same object, but that seems to be a
    // reasonable responsibility for the user rather than
    // always throwing an error on them.
    this.$el = this.$parent = this.$root = this.$children = this._watchers = this._context = this._scope = this._directives = null;
    // call the last hook...
    this._isDestroyed = true;
    this._callHook('destroyed');
    // turn off all instance listeners.
    this.$off();
  };
}

function miscMixin (Vue) {
  /**
   * Apply a list of filter (descriptors) to a value.
   * Using plain for loops here because this will be called in
   * the getter of any watcher with filters so it is very
   * performance sensitive.
   *
   * @param {*} value
   * @param {*} [oldValue]
   * @param {Array} filters
   * @param {Boolean} write
   * @return {*}
   */

  Vue.prototype._applyFilters = function (value, oldValue, filters, write) {
    var filter, fn, args, arg, offset, i, l, j, k;
    for (i = 0, l = filters.length; i < l; i++) {
      filter = filters[write ? l - i - 1 : i];
      fn = resolveAsset(this.$options, 'filters', filter.name, true);
      if (!fn) continue;
      fn = write ? fn.write : fn.read || fn;
      if (typeof fn !== 'function') continue;
      args = write ? [value, oldValue] : [value];
      offset = write ? 2 : 1;
      if (filter.args) {
        for (j = 0, k = filter.args.length; j < k; j++) {
          arg = filter.args[j];
          args[j + offset] = arg.dynamic ? this.$get(arg.value) : arg.value;
        }
      }
      value = fn.apply(this, args);
    }
    return value;
  };

  /**
   * Resolve a component, depending on whether the component
   * is defined normally or using an async factory function.
   * Resolves synchronously if already resolved, otherwise
   * resolves asynchronously and caches the resolved
   * constructor on the factory.
   *
   * @param {String|Function} value
   * @param {Function} cb
   */

  Vue.prototype._resolveComponent = function (value, cb) {
    var factory;
    if (typeof value === 'function') {
      factory = value;
    } else {
      factory = resolveAsset(this.$options, 'components', value, true);
    }
    /* istanbul ignore if */
    if (!factory) {
      return;
    }
    // async component factory
    if (!factory.options) {
      if (factory.resolved) {
        // cached
        cb(factory.resolved);
      } else if (factory.requested) {
        // pool callbacks
        factory.pendingCallbacks.push(cb);
      } else {
        factory.requested = true;
        var cbs = factory.pendingCallbacks = [cb];
        factory.call(this, function resolve(res) {
          if (isPlainObject(res)) {
            res = Vue.extend(res);
          }
          // cache resolved
          factory.resolved = res;
          // invoke callbacks
          for (var i = 0, l = cbs.length; i < l; i++) {
            cbs[i](res);
          }
        }, function reject(reason) {
          process.env.NODE_ENV !== 'production' && warn('Failed to resolve async component' + (typeof value === 'string' ? ': ' + value : '') + '. ' + (reason ? '\nReason: ' + reason : ''));
        });
      }
    } else {
      // normal component
      cb(factory);
    }
  };
}

var filterRE$1 = /[^|]\|[^|]/;

function dataAPI (Vue) {
  /**
   * Get the value from an expression on this vm.
   *
   * @param {String} exp
   * @param {Boolean} [asStatement]
   * @return {*}
   */

  Vue.prototype.$get = function (exp, asStatement) {
    var res = parseExpression(exp);
    if (res) {
      if (asStatement) {
        var self = this;
        return function statementHandler() {
          self.$arguments = toArray(arguments);
          var result = res.get.call(self, self);
          self.$arguments = null;
          return result;
        };
      } else {
        try {
          return res.get.call(this, this);
        } catch (e) {}
      }
    }
  };

  /**
   * Set the value from an expression on this vm.
   * The expression must be a valid left-hand
   * expression in an assignment.
   *
   * @param {String} exp
   * @param {*} val
   */

  Vue.prototype.$set = function (exp, val) {
    var res = parseExpression(exp, true);
    if (res && res.set) {
      res.set.call(this, this, val);
    }
  };

  /**
   * Delete a property on the VM
   *
   * @param {String} key
   */

  Vue.prototype.$delete = function (key) {
    del(this._data, key);
  };

  /**
   * Watch an expression, trigger callback when its
   * value changes.
   *
   * @param {String|Function} expOrFn
   * @param {Function} cb
   * @param {Object} [options]
   *                 - {Boolean} deep
   *                 - {Boolean} immediate
   * @return {Function} - unwatchFn
   */

  Vue.prototype.$watch = function (expOrFn, cb, options) {
    var vm = this;
    var parsed;
    if (typeof expOrFn === 'string') {
      parsed = parseDirective(expOrFn);
      expOrFn = parsed.expression;
    }
    var watcher = new Watcher(vm, expOrFn, cb, {
      deep: options && options.deep,
      sync: options && options.sync,
      filters: parsed && parsed.filters,
      user: !options || options.user !== false
    });
    if (options && options.immediate) {
      cb.call(vm, watcher.value);
    }
    return function unwatchFn() {
      watcher.teardown();
    };
  };

  /**
   * Evaluate a text directive, including filters.
   *
   * @param {String} text
   * @param {Boolean} [asStatement]
   * @return {String}
   */

  Vue.prototype.$eval = function (text, asStatement) {
    // check for filters.
    if (filterRE$1.test(text)) {
      var dir = parseDirective(text);
      // the filter regex check might give false positive
      // for pipes inside strings, so it's possible that
      // we don't get any filters here
      var val = this.$get(dir.expression, asStatement);
      return dir.filters ? this._applyFilters(val, null, dir.filters) : val;
    } else {
      // no filter
      return this.$get(text, asStatement);
    }
  };

  /**
   * Interpolate a piece of template text.
   *
   * @param {String} text
   * @return {String}
   */

  Vue.prototype.$interpolate = function (text) {
    var tokens = parseText(text);
    var vm = this;
    if (tokens) {
      if (tokens.length === 1) {
        return vm.$eval(tokens[0].value) + '';
      } else {
        return tokens.map(function (token) {
          return token.tag ? vm.$eval(token.value) : token.value;
        }).join('');
      }
    } else {
      return text;
    }
  };

  /**
   * Log instance data as a plain JS object
   * so that it is easier to inspect in console.
   * This method assumes console is available.
   *
   * @param {String} [path]
   */

  Vue.prototype.$log = function (path) {
    var data = path ? getPath(this._data, path) : this._data;
    if (data) {
      data = clean(data);
    }
    // include computed fields
    if (!path) {
      var key;
      for (key in this.$options.computed) {
        data[key] = clean(this[key]);
      }
      if (this._props) {
        for (key in this._props) {
          data[key] = clean(this[key]);
        }
      }
    }
    console.log(data);
  };

  /**
   * "clean" a getter/setter converted object into a plain
   * object copy.
   *
   * @param {Object} - obj
   * @return {Object}
   */

  function clean(obj) {
    return JSON.parse(JSON.stringify(obj));
  }
}

function domAPI (Vue) {
  /**
   * Convenience on-instance nextTick. The callback is
   * auto-bound to the instance, and this avoids component
   * modules having to rely on the global Vue.
   *
   * @param {Function} fn
   */

  Vue.prototype.$nextTick = function (fn) {
    nextTick(fn, this);
  };

  /**
   * Append instance to target
   *
   * @param {Node} target
   * @param {Function} [cb]
   * @param {Boolean} [withTransition] - defaults to true
   */

  Vue.prototype.$appendTo = function (target, cb, withTransition) {
    return insert(this, target, cb, withTransition, append, appendWithTransition);
  };

  /**
   * Prepend instance to target
   *
   * @param {Node} target
   * @param {Function} [cb]
   * @param {Boolean} [withTransition] - defaults to true
   */

  Vue.prototype.$prependTo = function (target, cb, withTransition) {
    target = query(target);
    if (target.hasChildNodes()) {
      this.$before(target.firstChild, cb, withTransition);
    } else {
      this.$appendTo(target, cb, withTransition);
    }
    return this;
  };

  /**
   * Insert instance before target
   *
   * @param {Node} target
   * @param {Function} [cb]
   * @param {Boolean} [withTransition] - defaults to true
   */

  Vue.prototype.$before = function (target, cb, withTransition) {
    return insert(this, target, cb, withTransition, beforeWithCb, beforeWithTransition);
  };

  /**
   * Insert instance after target
   *
   * @param {Node} target
   * @param {Function} [cb]
   * @param {Boolean} [withTransition] - defaults to true
   */

  Vue.prototype.$after = function (target, cb, withTransition) {
    target = query(target);
    if (target.nextSibling) {
      this.$before(target.nextSibling, cb, withTransition);
    } else {
      this.$appendTo(target.parentNode, cb, withTransition);
    }
    return this;
  };

  /**
   * Remove instance from DOM
   *
   * @param {Function} [cb]
   * @param {Boolean} [withTransition] - defaults to true
   */

  Vue.prototype.$remove = function (cb, withTransition) {
    if (!this.$el.parentNode) {
      return cb && cb();
    }
    var inDocument = this._isAttached && inDoc(this.$el);
    // if we are not in document, no need to check
    // for transitions
    if (!inDocument) withTransition = false;
    var self = this;
    var realCb = function realCb() {
      if (inDocument) self._callHook('detached');
      if (cb) cb();
    };
    if (this._isFragment) {
      removeNodeRange(this._fragmentStart, this._fragmentEnd, this, this._fragment, realCb);
    } else {
      var op = withTransition === false ? removeWithCb : removeWithTransition;
      op(this.$el, this, realCb);
    }
    return this;
  };

  /**
   * Shared DOM insertion function.
   *
   * @param {Vue} vm
   * @param {Element} target
   * @param {Function} [cb]
   * @param {Boolean} [withTransition]
   * @param {Function} op1 - op for non-transition insert
   * @param {Function} op2 - op for transition insert
   * @return vm
   */

  function insert(vm, target, cb, withTransition, op1, op2) {
    target = query(target);
    var targetIsDetached = !inDoc(target);
    var op = withTransition === false || targetIsDetached ? op1 : op2;
    var shouldCallHook = !targetIsDetached && !vm._isAttached && !inDoc(vm.$el);
    if (vm._isFragment) {
      mapNodeRange(vm._fragmentStart, vm._fragmentEnd, function (node) {
        op(node, target, vm);
      });
      cb && cb();
    } else {
      op(vm.$el, target, vm, cb);
    }
    if (shouldCallHook) {
      vm._callHook('attached');
    }
    return vm;
  }

  /**
   * Check for selectors
   *
   * @param {String|Element} el
   */

  function query(el) {
    return typeof el === 'string' ? document.querySelector(el) : el;
  }

  /**
   * Append operation that takes a callback.
   *
   * @param {Node} el
   * @param {Node} target
   * @param {Vue} vm - unused
   * @param {Function} [cb]
   */

  function append(el, target, vm, cb) {
    target.appendChild(el);
    if (cb) cb();
  }

  /**
   * InsertBefore operation that takes a callback.
   *
   * @param {Node} el
   * @param {Node} target
   * @param {Vue} vm - unused
   * @param {Function} [cb]
   */

  function beforeWithCb(el, target, vm, cb) {
    before(el, target);
    if (cb) cb();
  }

  /**
   * Remove operation that takes a callback.
   *
   * @param {Node} el
   * @param {Vue} vm - unused
   * @param {Function} [cb]
   */

  function removeWithCb(el, vm, cb) {
    remove(el);
    if (cb) cb();
  }
}

function eventsAPI (Vue) {
  /**
   * Listen on the given `event` with `fn`.
   *
   * @param {String} event
   * @param {Function} fn
   */

  Vue.prototype.$on = function (event, fn) {
    (this._events[event] || (this._events[event] = [])).push(fn);
    modifyListenerCount(this, event, 1);
    return this;
  };

  /**
   * Adds an `event` listener that will be invoked a single
   * time then automatically removed.
   *
   * @param {String} event
   * @param {Function} fn
   */

  Vue.prototype.$once = function (event, fn) {
    var self = this;
    function on() {
      self.$off(event, on);
      fn.apply(this, arguments);
    }
    on.fn = fn;
    this.$on(event, on);
    return this;
  };

  /**
   * Remove the given callback for `event` or all
   * registered callbacks.
   *
   * @param {String} event
   * @param {Function} fn
   */

  Vue.prototype.$off = function (event, fn) {
    var cbs;
    // all
    if (!arguments.length) {
      if (this.$parent) {
        for (event in this._events) {
          cbs = this._events[event];
          if (cbs) {
            modifyListenerCount(this, event, -cbs.length);
          }
        }
      }
      this._events = {};
      return this;
    }
    // specific event
    cbs = this._events[event];
    if (!cbs) {
      return this;
    }
    if (arguments.length === 1) {
      modifyListenerCount(this, event, -cbs.length);
      this._events[event] = null;
      return this;
    }
    // specific handler
    var cb;
    var i = cbs.length;
    while (i--) {
      cb = cbs[i];
      if (cb === fn || cb.fn === fn) {
        modifyListenerCount(this, event, -1);
        cbs.splice(i, 1);
        break;
      }
    }
    return this;
  };

  /**
   * Trigger an event on self.
   *
   * @param {String|Object} event
   * @return {Boolean} shouldPropagate
   */

  Vue.prototype.$emit = function (event) {
    var isSource = typeof event === 'string';
    event = isSource ? event : event.name;
    var cbs = this._events[event];
    var shouldPropagate = isSource || !cbs;
    if (cbs) {
      cbs = cbs.length > 1 ? toArray(cbs) : cbs;
      // this is a somewhat hacky solution to the question raised
      // in #2102: for an inline component listener like <comp @test="doThis">,
      // the propagation handling is somewhat broken. Therefore we
      // need to treat these inline callbacks differently.
      var hasParentCbs = isSource && cbs.some(function (cb) {
        return cb._fromParent;
      });
      if (hasParentCbs) {
        shouldPropagate = false;
      }
      var args = toArray(arguments, 1);
      for (var i = 0, l = cbs.length; i < l; i++) {
        var cb = cbs[i];
        var res = cb.apply(this, args);
        if (res === true && (!hasParentCbs || cb._fromParent)) {
          shouldPropagate = true;
        }
      }
    }
    return shouldPropagate;
  };

  /**
   * Recursively broadcast an event to all children instances.
   *
   * @param {String|Object} event
   * @param {...*} additional arguments
   */

  Vue.prototype.$broadcast = function (event) {
    var isSource = typeof event === 'string';
    event = isSource ? event : event.name;
    // if no child has registered for this event,
    // then there's no need to broadcast.
    if (!this._eventsCount[event]) return;
    var children = this.$children;
    var args = toArray(arguments);
    if (isSource) {
      // use object event to indicate non-source emit
      // on children
      args[0] = { name: event, source: this };
    }
    for (var i = 0, l = children.length; i < l; i++) {
      var child = children[i];
      var shouldPropagate = child.$emit.apply(child, args);
      if (shouldPropagate) {
        child.$broadcast.apply(child, args);
      }
    }
    return this;
  };

  /**
   * Recursively propagate an event up the parent chain.
   *
   * @param {String} event
   * @param {...*} additional arguments
   */

  Vue.prototype.$dispatch = function (event) {
    var shouldPropagate = this.$emit.apply(this, arguments);
    if (!shouldPropagate) return;
    var parent = this.$parent;
    var args = toArray(arguments);
    // use object event to indicate non-source emit
    // on parents
    args[0] = { name: event, source: this };
    while (parent) {
      shouldPropagate = parent.$emit.apply(parent, args);
      parent = shouldPropagate ? parent.$parent : null;
    }
    return this;
  };

  /**
   * Modify the listener counts on all parents.
   * This bookkeeping allows $broadcast to return early when
   * no child has listened to a certain event.
   *
   * @param {Vue} vm
   * @param {String} event
   * @param {Number} count
   */

  var hookRE = /^hook:/;
  function modifyListenerCount(vm, event, count) {
    var parent = vm.$parent;
    // hooks do not get broadcasted so no need
    // to do bookkeeping for them
    if (!parent || !count || hookRE.test(event)) return;
    while (parent) {
      parent._eventsCount[event] = (parent._eventsCount[event] || 0) + count;
      parent = parent.$parent;
    }
  }
}

function lifecycleAPI (Vue) {
  /**
   * Set instance target element and kick off the compilation
   * process. The passed in `el` can be a selector string, an
   * existing Element, or a DocumentFragment (for block
   * instances).
   *
   * @param {Element|DocumentFragment|string} el
   * @public
   */

  Vue.prototype.$mount = function (el) {
    if (this._isCompiled) {
      process.env.NODE_ENV !== 'production' && warn('$mount() should be called only once.', this);
      return;
    }
    el = query(el);
    if (!el) {
      el = document.createElement('div');
    }
    this._compile(el);
    this._initDOMHooks();
    if (inDoc(this.$el)) {
      this._callHook('attached');
      ready.call(this);
    } else {
      this.$once('hook:attached', ready);
    }
    return this;
  };

  /**
   * Mark an instance as ready.
   */

  function ready() {
    this._isAttached = true;
    this._isReady = true;
    this._callHook('ready');
  }

  /**
   * Teardown the instance, simply delegate to the internal
   * _destroy.
   *
   * @param {Boolean} remove
   * @param {Boolean} deferCleanup
   */

  Vue.prototype.$destroy = function (remove, deferCleanup) {
    this._destroy(remove, deferCleanup);
  };

  /**
   * Partially compile a piece of DOM and return a
   * decompile function.
   *
   * @param {Element|DocumentFragment} el
   * @param {Vue} [host]
   * @param {Object} [scope]
   * @param {Fragment} [frag]
   * @return {Function}
   */

  Vue.prototype.$compile = function (el, host, scope, frag) {
    return compile(el, this.$options, true)(this, el, host, scope, frag);
  };
}

/**
 * The exposed Vue constructor.
 *
 * API conventions:
 * - public API methods/properties are prefixed with `$`
 * - internal methods/properties are prefixed with `_`
 * - non-prefixed properties are assumed to be proxied user
 *   data.
 *
 * @constructor
 * @param {Object} [options]
 * @public
 */

function Vue(options) {
  this._init(options);
}

// install internals
initMixin(Vue);
stateMixin(Vue);
eventsMixin(Vue);
lifecycleMixin(Vue);
miscMixin(Vue);

// install instance APIs
dataAPI(Vue);
domAPI(Vue);
eventsAPI(Vue);
lifecycleAPI(Vue);

var slot = {

  priority: SLOT,
  params: ['name'],

  bind: function bind() {
    // this was resolved during component transclusion
    var name = this.params.name || 'default';
    var content = this.vm._slotContents && this.vm._slotContents[name];
    if (!content || !content.hasChildNodes()) {
      this.fallback();
    } else {
      this.compile(content.cloneNode(true), this.vm._context, this.vm);
    }
  },

  compile: function compile(content, context, host) {
    if (content && context) {
      if (this.el.hasChildNodes() && content.childNodes.length === 1 && content.childNodes[0].nodeType === 1 && content.childNodes[0].hasAttribute('v-if')) {
        // if the inserted slot has v-if
        // inject fallback content as the v-else
        var elseBlock = document.createElement('template');
        elseBlock.setAttribute('v-else', '');
        elseBlock.innerHTML = this.el.innerHTML;
        // the else block should be compiled in child scope
        elseBlock._context = this.vm;
        content.appendChild(elseBlock);
      }
      var scope = host ? host._scope : this._scope;
      this.unlink = context.$compile(content, host, scope, this._frag);
    }
    if (content) {
      replace(this.el, content);
    } else {
      remove(this.el);
    }
  },

  fallback: function fallback() {
    this.compile(extractContent(this.el, true), this.vm);
  },

  unbind: function unbind() {
    if (this.unlink) {
      this.unlink();
    }
  }
};

var partial = {

  priority: PARTIAL,

  params: ['name'],

  // watch changes to name for dynamic partials
  paramWatchers: {
    name: function name(value) {
      vIf.remove.call(this);
      if (value) {
        this.insert(value);
      }
    }
  },

  bind: function bind() {
    this.anchor = createAnchor('v-partial');
    replace(this.el, this.anchor);
    this.insert(this.params.name);
  },

  insert: function insert(id) {
    var partial = resolveAsset(this.vm.$options, 'partials', id, true);
    if (partial) {
      this.factory = new FragmentFactory(this.vm, partial);
      vIf.insert.call(this);
    }
  },

  unbind: function unbind() {
    if (this.frag) {
      this.frag.destroy();
    }
  }
};

var elementDirectives = {
  slot: slot,
  partial: partial
};

var convertArray = vFor._postProcess;

/**
 * Limit filter for arrays
 *
 * @param {Number} n
 * @param {Number} offset (Decimal expected)
 */

function limitBy(arr, n, offset) {
  offset = offset ? parseInt(offset, 10) : 0;
  n = toNumber(n);
  return typeof n === 'number' ? arr.slice(offset, offset + n) : arr;
}

/**
 * Filter filter for arrays
 *
 * @param {String} search
 * @param {String} [delimiter]
 * @param {String} ...dataKeys
 */

function filterBy(arr, search, delimiter) {
  arr = convertArray(arr);
  if (search == null) {
    return arr;
  }
  if (typeof search === 'function') {
    return arr.filter(search);
  }
  // cast to lowercase string
  search = ('' + search).toLowerCase();
  // allow optional `in` delimiter
  // because why not
  var n = delimiter === 'in' ? 3 : 2;
  // extract and flatten keys
  var keys = Array.prototype.concat.apply([], toArray(arguments, n));
  var res = [];
  var item, key, val, j;
  for (var i = 0, l = arr.length; i < l; i++) {
    item = arr[i];
    val = item && item.$value || item;
    j = keys.length;
    if (j) {
      while (j--) {
        key = keys[j];
        if (key === '$key' && contains(item.$key, search) || contains(getPath(val, key), search)) {
          res.push(item);
          break;
        }
      }
    } else if (contains(item, search)) {
      res.push(item);
    }
  }
  return res;
}

/**
 * Filter filter for arrays
 *
 * @param {String|Array<String>|Function} ...sortKeys
 * @param {Number} [order]
 */

function orderBy(arr) {
  var comparator = null;
  var sortKeys = undefined;
  arr = convertArray(arr);

  // determine order (last argument)
  var args = toArray(arguments, 1);
  var order = args[args.length - 1];
  if (typeof order === 'number') {
    order = order < 0 ? -1 : 1;
    args = args.length > 1 ? args.slice(0, -1) : args;
  } else {
    order = 1;
  }

  // determine sortKeys & comparator
  var firstArg = args[0];
  if (!firstArg) {
    return arr;
  } else if (typeof firstArg === 'function') {
    // custom comparator
    comparator = function (a, b) {
      return firstArg(a, b) * order;
    };
  } else {
    // string keys. flatten first
    sortKeys = Array.prototype.concat.apply([], args);
    comparator = function (a, b, i) {
      i = i || 0;
      return i >= sortKeys.length - 1 ? baseCompare(a, b, i) : baseCompare(a, b, i) || comparator(a, b, i + 1);
    };
  }

  function baseCompare(a, b, sortKeyIndex) {
    var sortKey = sortKeys[sortKeyIndex];
    if (sortKey) {
      if (sortKey !== '$key') {
        if (isObject(a) && '$value' in a) a = a.$value;
        if (isObject(b) && '$value' in b) b = b.$value;
      }
      a = isObject(a) ? getPath(a, sortKey) : a;
      b = isObject(b) ? getPath(b, sortKey) : b;
    }
    return a === b ? 0 : a > b ? order : -order;
  }

  // sort on a copy to avoid mutating original array
  return arr.slice().sort(comparator);
}

/**
 * String contain helper
 *
 * @param {*} val
 * @param {String} search
 */

function contains(val, search) {
  var i;
  if (isPlainObject(val)) {
    var keys = Object.keys(val);
    i = keys.length;
    while (i--) {
      if (contains(val[keys[i]], search)) {
        return true;
      }
    }
  } else if (isArray(val)) {
    i = val.length;
    while (i--) {
      if (contains(val[i], search)) {
        return true;
      }
    }
  } else if (val != null) {
    return val.toString().toLowerCase().indexOf(search) > -1;
  }
}

var digitsRE = /(\d{3})(?=\d)/g;

// asset collections must be a plain object.
var filters = {

  orderBy: orderBy,
  filterBy: filterBy,
  limitBy: limitBy,

  /**
   * Stringify value.
   *
   * @param {Number} indent
   */

  json: {
    read: function read(value, indent) {
      return typeof value === 'string' ? value : JSON.stringify(value, null, arguments.length > 1 ? indent : 2);
    },
    write: function write(value) {
      try {
        return JSON.parse(value);
      } catch (e) {
        return value;
      }
    }
  },

  /**
   * 'abc' => 'Abc'
   */

  capitalize: function capitalize(value) {
    if (!value && value !== 0) return '';
    value = value.toString();
    return value.charAt(0).toUpperCase() + value.slice(1);
  },

  /**
   * 'abc' => 'ABC'
   */

  uppercase: function uppercase(value) {
    return value || value === 0 ? value.toString().toUpperCase() : '';
  },

  /**
   * 'AbC' => 'abc'
   */

  lowercase: function lowercase(value) {
    return value || value === 0 ? value.toString().toLowerCase() : '';
  },

  /**
   * 12345 => $12,345.00
   *
   * @param {String} sign
   * @param {Number} decimals Decimal places
   */

  currency: function currency(value, _currency, decimals) {
    value = parseFloat(value);
    if (!isFinite(value) || !value && value !== 0) return '';
    _currency = _currency != null ? _currency : '$';
    decimals = decimals != null ? decimals : 2;
    var stringified = Math.abs(value).toFixed(decimals);
    var _int = decimals ? stringified.slice(0, -1 - decimals) : stringified;
    var i = _int.length % 3;
    var head = i > 0 ? _int.slice(0, i) + (_int.length > 3 ? ',' : '') : '';
    var _float = decimals ? stringified.slice(-1 - decimals) : '';
    var sign = value < 0 ? '-' : '';
    return sign + _currency + head + _int.slice(i).replace(digitsRE, '$1,') + _float;
  },

  /**
   * 'item' => 'items'
   *
   * @params
   *  an array of strings corresponding to
   *  the single, double, triple ... forms of the word to
   *  be pluralized. When the number to be pluralized
   *  exceeds the length of the args, it will use the last
   *  entry in the array.
   *
   *  e.g. ['single', 'double', 'triple', 'multiple']
   */

  pluralize: function pluralize(value) {
    var args = toArray(arguments, 1);
    var length = args.length;
    if (length > 1) {
      var index = value % 10 - 1;
      return index in args ? args[index] : args[length - 1];
    } else {
      return args[0] + (value === 1 ? '' : 's');
    }
  },

  /**
   * Debounce a handler function.
   *
   * @param {Function} handler
   * @param {Number} delay = 300
   * @return {Function}
   */

  debounce: function debounce(handler, delay) {
    if (!handler) return;
    if (!delay) {
      delay = 300;
    }
    return _debounce(handler, delay);
  }
};

function installGlobalAPI (Vue) {
  /**
   * Vue and every constructor that extends Vue has an
   * associated options object, which can be accessed during
   * compilation steps as `this.constructor.options`.
   *
   * These can be seen as the default options of every
   * Vue instance.
   */

  Vue.options = {
    directives: directives,
    elementDirectives: elementDirectives,
    filters: filters,
    transitions: {},
    components: {},
    partials: {},
    replace: true
  };

  /**
   * Expose useful internals
   */

  Vue.util = util;
  Vue.config = config;
  Vue.set = set;
  Vue['delete'] = del;
  Vue.nextTick = nextTick;

  /**
   * The following are exposed for advanced usage / plugins
   */

  Vue.compiler = compiler;
  Vue.FragmentFactory = FragmentFactory;
  Vue.internalDirectives = internalDirectives;
  Vue.parsers = {
    path: path,
    text: text,
    template: template,
    directive: directive,
    expression: expression
  };

  /**
   * Each instance constructor, including Vue, has a unique
   * cid. This enables us to create wrapped "child
   * constructors" for prototypal inheritance and cache them.
   */

  Vue.cid = 0;
  var cid = 1;

  /**
   * Class inheritance
   *
   * @param {Object} extendOptions
   */

  Vue.extend = function (extendOptions) {
    extendOptions = extendOptions || {};
    var Super = this;
    var isFirstExtend = Super.cid === 0;
    if (isFirstExtend && extendOptions._Ctor) {
      return extendOptions._Ctor;
    }
    var name = extendOptions.name || Super.options.name;
    if (process.env.NODE_ENV !== 'production') {
      if (!/^[a-zA-Z][\w-]*$/.test(name)) {
        warn('Invalid component name: "' + name + '". Component names ' + 'can only contain alphanumeric characaters and the hyphen.');
        name = null;
      }
    }
    var Sub = createClass(name || 'VueComponent');
    Sub.prototype = Object.create(Super.prototype);
    Sub.prototype.constructor = Sub;
    Sub.cid = cid++;
    Sub.options = mergeOptions(Super.options, extendOptions);
    Sub['super'] = Super;
    // allow further extension
    Sub.extend = Super.extend;
    // create asset registers, so extended classes
    // can have their private assets too.
    config._assetTypes.forEach(function (type) {
      Sub[type] = Super[type];
    });
    // enable recursive self-lookup
    if (name) {
      Sub.options.components[name] = Sub;
    }
    // cache constructor
    if (isFirstExtend) {
      extendOptions._Ctor = Sub;
    }
    return Sub;
  };

  /**
   * A function that returns a sub-class constructor with the
   * given name. This gives us much nicer output when
   * logging instances in the console.
   *
   * @param {String} name
   * @return {Function}
   */

  function createClass(name) {
    /* eslint-disable no-new-func */
    return new Function('return function ' + classify(name) + ' (options) { this._init(options) }')();
    /* eslint-enable no-new-func */
  }

  /**
   * Plugin system
   *
   * @param {Object} plugin
   */

  Vue.use = function (plugin) {
    /* istanbul ignore if */
    if (plugin.installed) {
      return;
    }
    // additional parameters
    var args = toArray(arguments, 1);
    args.unshift(this);
    if (typeof plugin.install === 'function') {
      plugin.install.apply(plugin, args);
    } else {
      plugin.apply(null, args);
    }
    plugin.installed = true;
    return this;
  };

  /**
   * Apply a global mixin by merging it into the default
   * options.
   */

  Vue.mixin = function (mixin) {
    Vue.options = mergeOptions(Vue.options, mixin);
  };

  /**
   * Create asset registration methods with the following
   * signature:
   *
   * @param {String} id
   * @param {*} definition
   */

  config._assetTypes.forEach(function (type) {
    Vue[type] = function (id, definition) {
      if (!definition) {
        return this.options[type + 's'][id];
      } else {
        /* istanbul ignore if */
        if (process.env.NODE_ENV !== 'production') {
          if (type === 'component' && (commonTagRE.test(id) || reservedTagRE.test(id))) {
            warn('Do not use built-in or reserved HTML elements as component ' + 'id: ' + id);
          }
        }
        if (type === 'component' && isPlainObject(definition)) {
          if (!definition.name) {
            definition.name = id;
          }
          definition = Vue.extend(definition);
        }
        this.options[type + 's'][id] = definition;
        return definition;
      }
    };
  });

  // expose internal transition API
  extend(Vue.transition, transition);
}

installGlobalAPI(Vue);

Vue.version = '1.0.26';

// devtools global hook
/* istanbul ignore next */
setTimeout(function () {
  if (config.devtools) {
    if (devtools) {
      devtools.emit('init', Vue);
    } else if (process.env.NODE_ENV !== 'production' && inBrowser && /Chrome\/\d+/.test(window.navigator.userAgent)) {
      console.log('Download the Vue Devtools for a better development experience:\n' + 'https://github.com/vuejs/vue-devtools');
    }
  }
}, 0);

module.exports = Vue;
}).call(this,require('_process'),typeof global !== "undefined" ? global : typeof self !== "undefined" ? self : typeof window !== "undefined" ? window : {})
},{"_process":84}],99:[function(require,module,exports){
var inserted = exports.cache = {}

exports.insert = function (css) {
  if (inserted[css]) return
  inserted[css] = true

  var elem = document.createElement('style')
  elem.setAttribute('type', 'text/css')

  if ('textContent' in elem) {
    elem.textContent = css
  } else {
    elem.styleSheet.cssText = css
  }

  document.getElementsByTagName('head')[0].appendChild(elem)
  return elem
}

},{}],100:[function(require,module,exports){
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

},{}],101:[function(require,module,exports){
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

},{}],102:[function(require,module,exports){
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

},{}],103:[function(require,module,exports){
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

},{}],104:[function(require,module,exports){
var __vueify_insert__ = require("vueify/lib/insert-css")
var __vueify_style__ = __vueify_insert__.insert("\nh1[_v-22ce5c3f] {\n  color: red;\n}\n")
'use strict';

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.default = {
  props: ['admin', 'permissionType', 'url'],
  data: function data() {
    return {
      permission_reports: [{ id: this.permissionType + "_report_index", name: "View List Reports", checked: this.admin[this.permissionType + '_report_index'] }, { id: this.permissionType + "_report_create", name: "Create New Report", checked: this.admin[this.permissionType + '_report_create'] }, { id: this.permissionType + "_report_show", name: "Show Report Details", checked: this.admin[this.permissionType + '_report_show'] }, { id: this.permissionType + "_report_edit", name: "Edit Reports", checked: this.admin[this.permissionType + '_report_edit'] }, { id: this.permissionType + "_report_addPhoto", name: "Add Photos from Reports", checked: this.admin[this.permissionType + '_report_addPhoto'] }, { id: this.permissionType + "_report_removePhoto", name: "Remove Photos from Reports", checked: this.admin[this.permissionType + '_report_removePhoto'] }, { id: this.permissionType + "_report_destroy", name: "Delete Report", checked: this.admin[this.permissionType + '_report_destroy'] }], permission_services: [{ id: this.permissionType + "_service_index", name: "View List Services", checked: this.admin[this.permissionType + '_service_index'] }, { id: this.permissionType + "_service_create", name: "Create New Service", checked: this.admin[this.permissionType + '_service_create'] }, { id: this.permissionType + "_service_show", name: "Show Service Details", checked: this.admin[this.permissionType + '_service_show'] }, { id: this.permissionType + "_service_edit", name: "Edit Services", checked: this.admin[this.permissionType + '_service_edit'] }, { id: this.permissionType + "_service_destroy", name: "Delete Service", checked: this.admin[this.permissionType + '_service_destroy'] }], permission_clients: [{ id: this.permissionType + "_client_index", name: "View List Clients", checked: this.admin[this.permissionType + '_client_index'] }, { id: this.permissionType + "_client_create", name: "Create New Client", checked: this.admin[this.permissionType + '_client_create'] }, { id: this.permissionType + "_client_show", name: "Show Client Details", checked: this.admin[this.permissionType + '_client_show'] }, { id: this.permissionType + "_client_edit", name: "Edit Clients", checked: this.admin[this.permissionType + '_client_edit'] }, { id: this.permissionType + "_client_destroy", name: "Delete Client", checked: this.admin[this.permissionType + '_client_destroy'] }], permission_supervisors: [{ id: this.permissionType + "_supervisor_index", name: "View List Supervisors", checked: this.admin[this.permissionType + '_supervisor_index'] }, { id: this.permissionType + "_supervisor_create", name: "Create New Supervisor", checked: this.admin[this.permissionType + '_supervisor_create'] }, { id: this.permissionType + "_supervisor_show", name: "Show Supervisor Details", checked: this.admin[this.permissionType + '_supervisor_show'] }, { id: this.permissionType + "_supervisor_edit", name: "Edit Supervisors", checked: this.admin[this.permissionType + '_supervisor_edit'] }, { id: this.permissionType + "_supervisor_destroy", name: "Delete Supervisor", checked: this.admin[this.permissionType + '_supervisor_destroy'] }], permission_technicians: [{ id: this.permissionType + "_technician_index", name: "View List Technicians", checked: this.admin[this.permissionType + '_technician_index'] }, { id: this.permissionType + "_technician_create", name: "Create New Technician", checked: this.admin[this.permissionType + '_technician_create'] }, { id: this.permissionType + "_technician_show", name: "Show Technician Details", checked: this.admin[this.permissionType + '_technician_show'] }, { id: this.permissionType + "_technician_edit", name: "Edit Technicians", checked: this.admin[this.permissionType + '_technician_edit'] }, { id: this.permissionType + "_technician_destroy", name: "Delete Technician", checked: this.admin[this.permissionType + '_technician_destroy'] }]
    };
  }
};
if (module.exports.__esModule) module.exports = module.exports.default
;(typeof module.exports === "function"? module.exports.options: module.exports).template = "\n\n<checkbox-list :header=\"'Reports'\" :data=\"permission_reports\" :url=\"url\" _v-22ce5c3f=\"\"></checkbox-list>\n<checkbox-list :header=\"'Services'\" :data=\"permission_services\" :url=\"url\" _v-22ce5c3f=\"\"></checkbox-list>\n<checkbox-list :header=\"'Clients'\" :data=\"permission_clients\" :url=\"url\" _v-22ce5c3f=\"\"></checkbox-list>\n<checkbox-list :header=\"'Supervisors'\" :data=\"permission_supervisors\" :url=\"url\" _v-22ce5c3f=\"\"></checkbox-list>\n<checkbox-list :header=\"'Technicians'\" :data=\"permission_technicians\" :url=\"url\" _v-22ce5c3f=\"\"></checkbox-list>\n\n"
if (module.hot) {(function () {  module.hot.accept()
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), true)
  if (!hotAPI.compatible) return
  module.hot.dispose(function () {
    __vueify_insert__.cache["\nh1[_v-22ce5c3f] {\n  color: red;\n}\n"] = false
    document.head.removeChild(__vueify_style__)
  })
  if (!module.hot.data) {
    hotAPI.createRecord("_v-22ce5c3f", module.exports)
  } else {
    hotAPI.update("_v-22ce5c3f", module.exports, (typeof module.exports === "function" ? module.exports.options : module.exports).template)
  }
})()}
},{"vue":98,"vue-hot-reload-api":95,"vueify/lib/insert-css":99}],105:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
    value: true
});


var Vue = require('vue');

exports.default = Vue.component('checkbox-list', {
    props: ['header', 'data', 'url'],

    data: function data() {
        return {
            debug: {}
        };
    },


    methods: {
        sendRequest: function sendRequest(permission) {
            // HTTP Request or what ever to update the permission
            $.ajax({
                url: this.url,
                type: 'PATCH',
                dataType: 'json',
                data: {
                    'id': permission.id,
                    'checked': !permission.checked ? true : false,
                    'name': permission.name
                },
                complete: function complete(xhr, textStatus) {
                    //called when complete
                    // console.log('complete');
                },
                success: function success(data, textStatus, xhr) {
                    //called when successful
                    // console.log('success');
                },
                error: function error(xhr, textStatus, errorThrown) {
                    //called when there is an error
                    // console.log('error');
                }
            });
        }
    }
});
if (module.exports.__esModule) module.exports = module.exports.default
;(typeof module.exports === "function"? module.exports.options: module.exports).template = "\n\n<header class=\"box-typical-header-sm\" v-if=\"header\">\n    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ header }}:\n</header>\n\n<div class=\"form-group row\" v-for=\"permission in data\">\n    <div class=\"col-sm-1\">\n    </div>\n    <div class=\"col-sm-11\">\n        <div class=\"checkbox-toggle\">\n\t\t\t<input type=\"checkbox\" id=\"{{&nbsp;permission.id }}\" v-model=\"permission.checked\" @click=\"sendRequest(permission)\">\n\t\t\t<label for=\"{{&nbsp;permission.id }}\">{{&nbsp;permission.name }}</label>\n\t\t</div>\n    </div>\n</div>\n\n\n"
if (module.hot) {(function () {  module.hot.accept()
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), true)
  if (!hotAPI.compatible) return
  if (!module.hot.data) {
    hotAPI.createRecord("_v-0b82fa36", module.exports)
  } else {
    hotAPI.update("_v-0b82fa36", module.exports, (typeof module.exports === "function" ? module.exports.options : module.exports).template)
  }
})()}
},{"vue":98,"vue-hot-reload-api":95}],106:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
    value: true
});

var _vueMultiselect = require('vue-multiselect');

var _vueMultiselect2 = _interopRequireDefault(_vueMultiselect);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
    components: { Multiselect: _vueMultiselect2.default },
    props: ['code'],
    data: function data() {
        var _this = this;

        return {
            selected: typeof this.code != 'undefined' ? countries.find(function (selected) {
                return selected.key === _this.code;
            }) : null,
            options: countries
        };
    },

    methods: {
        updateSelected: function updateSelected(newSelected) {
            this.selected = newSelected;
            this.code = newSelected.key;
        }
    },
    watch: {
        // if the key is changed change the selected
        code: function code(val) {
            this.selected = this.options.find(function (options) {
                return options.key === val;
            });
        }
    }
};


var countries = [{ 'key': 'AF', 'label': 'Afghanistan' }, { 'key': 'AX', 'label': 'Aland Islands' }, { 'key': 'AL', 'label': 'Albania' }, { 'key': 'DZ', 'label': 'Algeria' }, { 'key': 'AS', 'label': 'American Samoa' }, { 'key': 'AD', 'label': 'Andorra' }, { 'key': 'AO', 'label': 'Angola' }, { 'key': 'AI', 'label': 'Anguilla' }, { 'key': 'AQ', 'label': 'Antarctica' }, { 'key': 'AG', 'label': 'Antigua And Barbuda' }, { 'key': 'AR', 'label': 'Argentina' }, { 'key': 'AM', 'label': 'Armenia' }, { 'key': 'AW', 'label': 'Aruba' }, { 'key': 'AU', 'label': 'Australia' }, { 'key': 'AT', 'label': 'Austria' }, { 'key': 'AZ', 'label': 'Azerbaijan' }, { 'key': 'BS', 'label': 'Bahamas' }, { 'key': 'BH', 'label': 'Bahrain' }, { 'key': 'BD', 'label': 'Bangladesh' }, { 'key': 'BB', 'label': 'Barbados' }, { 'key': 'BY', 'label': 'Belarus' }, { 'key': 'BE', 'label': 'Belgium' }, { 'key': 'BZ', 'label': 'Belize' }, { 'key': 'BJ', 'label': 'Benin' }, { 'key': 'BM', 'label': 'Bermuda' }, { 'key': 'BT', 'label': 'Bhutan' }, { 'key': 'BO', 'label': 'Bolivia' }, { 'key': 'BA', 'label': 'Bosnia And Herzegovina' }, { 'key': 'BW', 'label': 'Botswana' }, { 'key': 'BV', 'label': 'Bouvet Island' }, { 'key': 'BR', 'label': 'Brazil' }, { 'key': 'IO', 'label': 'British Indian Ocean Territory' }, { 'key': 'BN', 'label': 'Brunei Darussalam' }, { 'key': 'BG', 'label': 'Bulgaria' }, { 'key': 'BF', 'label': 'Burkina Faso' }, { 'key': 'BI', 'label': 'Burundi' }, { 'key': 'KH', 'label': 'Cambodia' }, { 'key': 'CM', 'label': 'Cameroon' }, { 'key': 'CA', 'label': 'Canada' }, { 'key': 'CV', 'label': 'Cape Verde' }, { 'key': 'KY', 'label': 'Cayman Islands' }, { 'key': 'CF', 'label': 'Central African Republic' }, { 'key': 'TD', 'label': 'Chad' }, { 'key': 'CL', 'label': 'Chile' }, { 'key': 'CN', 'label': 'China' }, { 'key': 'CX', 'label': 'Christmas Island' }, { 'key': 'CC', 'label': 'Cocos (Keeling) Islands' }, { 'key': 'CO', 'label': 'Colombia' }, { 'key': 'KM', 'label': 'Comoros' }, { 'key': 'CG', 'label': 'Congo' }, { 'key': 'CD', 'label': 'Congo, Democratic Republic' }, { 'key': 'CK', 'label': 'Cook Islands' }, { 'key': 'CR', 'label': 'Costa Rica' }, { 'key': 'CI', 'label': 'Cote D\'Ivoire' }, { 'key': 'HR', 'label': 'Croatia' }, { 'key': 'CU', 'label': 'Cuba' }, { 'key': 'CY', 'label': 'Cyprus' }, { 'key': 'CZ', 'label': 'Czech Republic' }, { 'key': 'DK', 'label': 'Denmark' }, { 'key': 'DJ', 'label': 'Djibouti' }, { 'key': 'DM', 'label': 'Dominica' }, { 'key': 'DO', 'label': 'Dominican Republic' }, { 'key': 'EC', 'label': 'Ecuador' }, { 'key': 'EG', 'label': 'Egypt' }, { 'key': 'SV', 'label': 'El Salvador' }, { 'key': 'GQ', 'label': 'Equatorial Guinea' }, { 'key': 'ER', 'label': 'Eritrea' }, { 'key': 'EE', 'label': 'Estonia' }, { 'key': 'ET', 'label': 'Ethiopia' }, { 'key': 'FK', 'label': 'Falkland Islands (Malvinas)' }, { 'key': 'FO', 'label': 'Faroe Islands' }, { 'key': 'FJ', 'label': 'Fiji' }, { 'key': 'FI', 'label': 'Finland' }, { 'key': 'FR', 'label': 'France' }, { 'key': 'GF', 'label': 'French Guiana' }, { 'key': 'PF', 'label': 'French Polynesia' }, { 'key': 'TF', 'label': 'French Southern Territories' }, { 'key': 'GA', 'label': 'Gabon' }, { 'key': 'GM', 'label': 'Gambia' }, { 'key': 'GE', 'label': 'Georgia' }, { 'key': 'DE', 'label': 'Germany' }, { 'key': 'GH', 'label': 'Ghana' }, { 'key': 'GI', 'label': 'Gibraltar' }, { 'key': 'GR', 'label': 'Greece' }, { 'key': 'GL', 'label': 'Greenland' }, { 'key': 'GD', 'label': 'Grenada' }, { 'key': 'GP', 'label': 'Guadeloupe' }, { 'key': 'GU', 'label': 'Guam' }, { 'key': 'GT', 'label': 'Guatemala' }, { 'key': 'GG', 'label': 'Guernsey' }, { 'key': 'GN', 'label': 'Guinea' }, { 'key': 'GW', 'label': 'Guinea-Bissau' }, { 'key': 'GY', 'label': 'Guyana' }, { 'key': 'HT', 'label': 'Haiti' }, { 'key': 'HM', 'label': 'Heard Island & Mcdonald Islands' }, { 'key': 'VA', 'label': 'Holy See (Vatican City State)' }, { 'key': 'HN', 'label': 'Honduras' }, { 'key': 'HK', 'label': 'Hong Kong' }, { 'key': 'HU', 'label': 'Hungary' }, { 'key': 'IS', 'label': 'Iceland' }, { 'key': 'IN', 'label': 'India' }, { 'key': 'ID', 'label': 'Indonesia' }, { 'key': 'IR', 'label': 'Iran, Islamic Republic Of' }, { 'key': 'IQ', 'label': 'Iraq' }, { 'key': 'IE', 'label': 'Ireland' }, { 'key': 'IM', 'label': 'Isle Of Man' }, { 'key': 'IL', 'label': 'Israel' }, { 'key': 'IT', 'label': 'Italy' }, { 'key': 'JM', 'label': 'Jamaica' }, { 'key': 'JP', 'label': 'Japan' }, { 'key': 'JE', 'label': 'Jersey' }, { 'key': 'JO', 'label': 'Jordan' }, { 'key': 'KZ', 'label': 'Kazakhstan' }, { 'key': 'KE', 'label': 'Kenya' }, { 'key': 'KI', 'label': 'Kiribati' }, { 'key': 'KR', 'label': 'Korea' }, { 'key': 'KW', 'label': 'Kuwait' }, { 'key': 'KG', 'label': 'Kyrgyzstan' }, { 'key': 'LA', 'label': 'Lao People\'s Democratic Republic' }, { 'key': 'LV', 'label': 'Latvia' }, { 'key': 'LB', 'label': 'Lebanon' }, { 'key': 'LS', 'label': 'Lesotho' }, { 'key': 'LR', 'label': 'Liberia' }, { 'key': 'LY', 'label': 'Libyan Arab Jamahiriya' }, { 'key': 'LI', 'label': 'Liechtenstein' }, { 'key': 'LT', 'label': 'Lithuania' }, { 'key': 'LU', 'label': 'Luxembourg' }, { 'key': 'MO', 'label': 'Macao' }, { 'key': 'MK', 'label': 'Macedonia' }, { 'key': 'MG', 'label': 'Madagascar' }, { 'key': 'MW', 'label': 'Malawi' }, { 'key': 'MY', 'label': 'Malaysia' }, { 'key': 'MV', 'label': 'Maldives' }, { 'key': 'ML', 'label': 'Mali' }, { 'key': 'MT', 'label': 'Malta' }, { 'key': 'MH', 'label': 'Marshall Islands' }, { 'key': 'MQ', 'label': 'Martinique' }, { 'key': 'MR', 'label': 'Mauritania' }, { 'key': 'MU', 'label': 'Mauritius' }, { 'key': 'YT', 'label': 'Mayotte' }, { 'key': 'MX', 'label': 'Mexico' }, { 'key': 'FM', 'label': 'Micronesia, Federated States Of' }, { 'key': 'MD', 'label': 'Moldova' }, { 'key': 'MC', 'label': 'Monaco' }, { 'key': 'MN', 'label': 'Mongolia' }, { 'key': 'ME', 'label': 'Montenegro' }, { 'key': 'MS', 'label': 'Montserrat' }, { 'key': 'MA', 'label': 'Morocco' }, { 'key': 'MZ', 'label': 'Mozambique' }, { 'key': 'MM', 'label': 'Myanmar' }, { 'key': 'NA', 'label': 'Namibia' }, { 'key': 'NR', 'label': 'Nauru' }, { 'key': 'NP', 'label': 'Nepal' }, { 'key': 'NL', 'label': 'Netherlands' }, { 'key': 'AN', 'label': 'Netherlands Antilles' }, { 'key': 'NC', 'label': 'New Caledonia' }, { 'key': 'NZ', 'label': 'New Zealand' }, { 'key': 'NI', 'label': 'Nicaragua' }, { 'key': 'NE', 'label': 'Niger' }, { 'key': 'NG', 'label': 'Nigeria' }, { 'key': 'NU', 'label': 'Niue' }, { 'key': 'NF', 'label': 'Norfolk Island' }, { 'key': 'MP', 'label': 'Northern Mariana Islands' }, { 'key': 'NO', 'label': 'Norway' }, { 'key': 'OM', 'label': 'Oman' }, { 'key': 'PK', 'label': 'Pakistan' }, { 'key': 'PW', 'label': 'Palau' }, { 'key': 'PS', 'label': 'Palestinian Territory, Occupied' }, { 'key': 'PA', 'label': 'Panama' }, { 'key': 'PG', 'label': 'Papua New Guinea' }, { 'key': 'PY', 'label': 'Paraguay' }, { 'key': 'PE', 'label': 'Peru' }, { 'key': 'PH', 'label': 'Philippines' }, { 'key': 'PN', 'label': 'Pitcairn' }, { 'key': 'PL', 'label': 'Poland' }, { 'key': 'PT', 'label': 'Portugal' }, { 'key': 'PR', 'label': 'Puerto Rico' }, { 'key': 'QA', 'label': 'Qatar' }, { 'key': 'RE', 'label': 'Reunion' }, { 'key': 'RO', 'label': 'Romania' }, { 'key': 'RU', 'label': 'Russian Federation' }, { 'key': 'RW', 'label': 'Rwanda' }, { 'key': 'BL', 'label': 'Saint Barthelemy' }, { 'key': 'SH', 'label': 'Saint Helena' }, { 'key': 'KN', 'label': 'Saint Kitts And Nevis' }, { 'key': 'LC', 'label': 'Saint Lucia' }, { 'key': 'MF', 'label': 'Saint Martin' }, { 'key': 'PM', 'label': 'Saint Pierre And Miquelon' }, { 'key': 'VC', 'label': 'Saint Vincent And Grenadines' }, { 'key': 'WS', 'label': 'Samoa' }, { 'key': 'SM', 'label': 'San Marino' }, { 'key': 'ST', 'label': 'Sao Tome And Principe' }, { 'key': 'SA', 'label': 'Saudi Arabia' }, { 'key': 'SN', 'label': 'Senegal' }, { 'key': 'RS', 'label': 'Serbia' }, { 'key': 'SC', 'label': 'Seychelles' }, { 'key': 'SL', 'label': 'Sierra Leone' }, { 'key': 'SG', 'label': 'Singapore' }, { 'key': 'SK', 'label': 'Slovakia' }, { 'key': 'SI', 'label': 'Slovenia' }, { 'key': 'SB', 'label': 'Solomon Islands' }, { 'key': 'SO', 'label': 'Somalia' }, { 'key': 'ZA', 'label': 'South Africa' }, { 'key': 'GS', 'label': 'South Georgia And Sandwich Isl.' }, { 'key': 'ES', 'label': 'Spain' }, { 'key': 'LK', 'label': 'Sri Lanka' }, { 'key': 'SD', 'label': 'Sudan' }, { 'key': 'SR', 'label': 'Suriname' }, { 'key': 'SJ', 'label': 'Svalbard And Jan Mayen' }, { 'key': 'SZ', 'label': 'Swaziland' }, { 'key': 'SE', 'label': 'Sweden' }, { 'key': 'CH', 'label': 'Switzerland' }, { 'key': 'SY', 'label': 'Syrian Arab Republic' }, { 'key': 'TW', 'label': 'Taiwan' }, { 'key': 'TJ', 'label': 'Tajikistan' }, { 'key': 'TZ', 'label': 'Tanzania' }, { 'key': 'TH', 'label': 'Thailand' }, { 'key': 'TL', 'label': 'Timor-Leste' }, { 'key': 'TG', 'label': 'Togo' }, { 'key': 'TK', 'label': 'Tokelau' }, { 'key': 'TO', 'label': 'Tonga' }, { 'key': 'TT', 'label': 'Trinidad And Tobago' }, { 'key': 'TN', 'label': 'Tunisia' }, { 'key': 'TR', 'label': 'Turkey' }, { 'key': 'TM', 'label': 'Turkmenistan' }, { 'key': 'TC', 'label': 'Turks And Caicos Islands' }, { 'key': 'TV', 'label': 'Tuvalu' }, { 'key': 'UG', 'label': 'Uganda' }, { 'key': 'UA', 'label': 'Ukraine' }, { 'key': 'AE', 'label': 'United Arab Emirates' }, { 'key': 'GB', 'label': 'United Kingdom' }, { 'key': 'US', 'label': 'United States' }, { 'key': 'UM', 'label': 'United States Outlying Islands' }, { 'key': 'UY', 'label': 'Uruguay' }, { 'key': 'UZ', 'label': 'Uzbekistan' }, { 'key': 'VU', 'label': 'Vanuatu' }, { 'key': 'VE', 'label': 'Venezuela' }, { 'key': 'VN', 'label': 'Viet Nam' }, { 'key': 'VG', 'label': 'Virgin Islands, British' }, { 'key': 'VI', 'label': 'Virgin Islands, U.S.' }, { 'key': 'WF', 'label': 'Wallis And Futuna' }, { 'key': 'EH', 'label': 'Western Sahara' }, { 'key': 'YE', 'label': 'Yemen' }, { 'key': 'ZM', 'label': 'Zambia' }, { 'key': 'ZW', 'label': 'Zimbabwe' }];
if (module.exports.__esModule) module.exports = module.exports.default
;(typeof module.exports === "function"? module.exports.options: module.exports).template = "\n    <div>\n        <multiselect :selected=\"selected\" :options=\"options\" @update=\"updateSelected\" :searchable=\"true\" ,=\"\" :close-on-select=\"true\" :allow-empty=\"false\" deselect-label=\"Can't remove this value\" key=\"key\" label=\"label\" placeholder=\"Select Country\">\n        </multiselect>\n    </div>\n\t<input type=\"hidden\" name=\"country\" value=\"{{code}}\">\n"
if (module.hot) {(function () {  module.hot.accept()
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), true)
  if (!hotAPI.compatible) return
  if (!module.hot.data) {
    hotAPI.createRecord("_v-6b0ea74f", module.exports)
  } else {
    hotAPI.update("_v-6b0ea74f", module.exports, (typeof module.exports === "function" ? module.exports.options : module.exports).template)
  }
})()}
},{"vue":98,"vue-hot-reload-api":95,"vue-multiselect":96}],107:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
    value: true
});

var _vueMultiselect = require('vue-multiselect');

var _vueMultiselect2 = _interopRequireDefault(_vueMultiselect);

var _basicNameIconOptionPartial = require('./partials/basicNameIconOptionPartial.html');

var _basicNameIconOptionPartial2 = _interopRequireDefault(_basicNameIconOptionPartial);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var Vue = require('vue');

Vue.partial('basicNameIconOptionPartial', _basicNameIconOptionPartial2.default);

exports.default = {
    components: { Multiselect: _vueMultiselect2.default },
    props: ['key', 'options', 'name'],
    data: function data() {
        var _this = this;

        return {
            selected: this.options.find(function (options) {
                return options.key === _this.key;
            })
        };
    },

    methods: {
        styleLabel: function styleLabel(_ref) {
            var key = _ref.key;
            var label = _ref.label;

            return key + ' ' + label;
        },
        updateSelected: function updateSelected(newSelected) {
            this.selected = newSelected;
            this.key = newSelected.key;
        }
    },
    watch: {
        // if the key is changed change the selected
        key: function key(val) {
            this.selected = this.options.find(function (options) {
                return options.key === val;
            });
        }
    }
};
if (module.exports.__esModule) module.exports = module.exports.default
;(typeof module.exports === "function"? module.exports.options: module.exports).template = "\n<div>\n    <multiselect :selected=\"selected\" :options=\"options\" @update=\"updateSelected\" :searchable=\"true\" :close-on-select=\"true\" :allow-empty=\"false\" :custom-label=\"styleLabel\" option-partial=\"basicNameIconOptionPartial\" deselect-label=\"Can't remove this value\" key=\"key\" label=\"label\">\n    </multiselect>\n</div>\n<input type=\"hidden\" name=\"{{name}}\" value=\"{{key}}\">\n"
if (module.hot) {(function () {  module.hot.accept()
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), true)
  if (!hotAPI.compatible) return
  if (!module.hot.data) {
    hotAPI.createRecord("_v-131aa5c6", module.exports)
  } else {
    hotAPI.update("_v-131aa5c6", module.exports, (typeof module.exports === "function" ? module.exports.options : module.exports).template)
  }
})()}
},{"./partials/basicNameIconOptionPartial.html":109,"vue":98,"vue-hot-reload-api":95,"vue-multiselect":96}],108:[function(require,module,exports){
var __vueify_insert__ = require("vueify/lib/insert-css")
var __vueify_style__ = __vueify_insert__.insert("\nh1[_v-7b51c492] {\n  color: red;\n}\n")
'use strict';

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.default = {
  props: ['person', 'url'],
  data: function data() {
    return {
      permission_reports: [{ id: "get_reports_emails", name: "Send email when new report is created", checked: this.person['get_reports_emails'] }]
    };
  }
};
if (module.exports.__esModule) module.exports = module.exports.default
;(typeof module.exports === "function"? module.exports.options: module.exports).template = "\n\n<checkbox-list :data=\"permission_reports\" :url=\"url\" _v-7b51c492=\"\"></checkbox-list>\n\n"
if (module.hot) {(function () {  module.hot.accept()
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), true)
  if (!hotAPI.compatible) return
  module.hot.dispose(function () {
    __vueify_insert__.cache["\nh1[_v-7b51c492] {\n  color: red;\n}\n"] = false
    document.head.removeChild(__vueify_style__)
  })
  if (!module.hot.data) {
    hotAPI.createRecord("_v-7b51c492", module.exports)
  } else {
    hotAPI.update("_v-7b51c492", module.exports, (typeof module.exports === "function" ? module.exports.options : module.exports).template)
  }
})()}
},{"vue":98,"vue-hot-reload-api":95,"vueify/lib/insert-css":99}],109:[function(require,module,exports){
module.exports = '<span>\n    <img class="iconOptionDropdown" :src="option.icon">\n    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\n    {{option.key}} {{option.label}}\n</span>\n\n<style>\n.iconOptionDropdown {\n    display: block;\n    width: 20px;\n    height: 20px;\n    position: absolute;\n    left: 10px;\n    top: 10px;\n    border-radius: 50%;\n}\n</style>\n';
},{}],110:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
    value: true
});
exports.default = {
    props: ['data', 'objectId', 'canDelete', 'photosUrl'],
    data: function data() {
        return {
            debug: {}
        };
    },

    computed: {
        deleteUrl: function deleteUrl() {
            return this.photosUrl + '/' + this.objectId + '/';
        }
    },
    methods: {
        deletePhoto: function deletePhoto(order) {
            $.ajax({
                vue: this,
                url: this.deleteUrl + order,
                type: 'DELETE',
                success: function success(data, textStatus, xhr) {
                    // remove the just deleted photo from options
                    var index = this.vue.data.findIndex(function (data) {
                        return data.order === order;
                    });
                    this.vue.data = this.vue.data.splice(index, 1);
                },
                error: function error(xhr, textStatus, errorThrown) {
                    console.log('image was not deleted');
                }
            });
        }
    }
};
if (module.exports.__esModule) module.exports = module.exports.default
;(typeof module.exports === "function"? module.exports.options: module.exports).template = "\n\n    <div class=\"col-md-4 m-b-md\" v-for=\"image in data\">\n        <div class=\"gallery-col\">\n        \t<article class=\"gallery-item\">\n        \t\t<img class=\"gallery-picture\" :src=\"image.thumbnail\" alt=\"\" height=\"127\">\n        \t\t<div class=\"gallery-hover-layout\">\n        \t\t\t<div class=\"gallery-hover-layout-in\">\n        \t\t\t\t<p class=\"gallery-item-title\">{{ image.title }}</p>\n        \t\t\t\t<div class=\"btn-group\">\n        \t\t\t\t\t<a class=\"fancybox btn\" href=\"{{ image.full_size }}\" title=\"{{ image.title }}\">\n        \t\t\t\t\t\t<i class=\"font-icon font-icon-eye\"></i>\n        \t\t\t\t\t</a>\n                            <a v-if=\"canDelete\" @click=\"deletePhoto(image.order)\" class=\"btn\">\n\t\t\t\t\t\t\t\t<i class=\"font-icon font-icon-trash\"></i>\n\t\t\t\t\t\t\t</a>\n        \t\t\t\t</div>\n        \t\t\t\t<p>Photo number {{ image.order }}</p>\n        \t\t\t</div>\n        \t\t</div>\n        \t</article>\n        </div><!--.gallery-col-->\n    </div><!--.col-->\n"
if (module.hot) {(function () {  module.hot.accept()
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), true)
  if (!hotAPI.compatible) return
  if (!module.hot.data) {
    hotAPI.createRecord("_v-5566088b", module.exports)
  } else {
    hotAPI.update("_v-5566088b", module.exports, (typeof module.exports === "function" ? module.exports.options : module.exports).template)
  }
})()}
},{"vue":98,"vue-hot-reload-api":95}],111:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
    value: true
});

var Vue = require('vue');

exports.default = Vue.directive('ajax', {
    params: ['title', 'message'],
    http: {
        headers: {
            // You could also store your token in a global object,
            // and reference it here. APP.token
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]') ? document.querySelector('input[name="_token"]').value : ''
        }
    },

    bind: function bind() {
        this.el.addEventListener('submit', this.onSubmit.bind(this));
    },

    onSubmit: function onSubmit(e) {
        e.preventDefault();
        var requestType = this.getRequestType();

        this.vm.$http[requestType](this.el.action, this.getFormData()).then(this.onComplete.bind(this)).catch(this.onError.bind(this));
    },

    onComplete: function onComplete() {
        if (this.params.title && this.params.message) {
            swal({
                title: this.params.title,
                text: this.params.message,
                type: 'success',
                timer: 2000,
                showConfirmButton: false
            });
        }
    },

    onError: function onError(response) {
        // first show validation errors
        var errors = '';
        $.each(response.data, function (key, value) {
            errors += value + '\n';
        });
        swal("Oops, there was an error", errors, "error");
    },

    getRequestType: function getRequestType() {
        var method = this.el.querySelector('input[name="_method"]');

        return (method ? method.value : this.el.method).toLowerCase();
    },
    getFormData: function getFormData() {
        // You can use $(this.el) in jQuery and you will get the same thing.
        var serializedData = $(this.el).serializeArray();
        var objectData = {};
        $.each(serializedData, function () {
            if (objectData[this.name] !== undefined) {
                if (!objectData[this.name].push) {
                    objectData[this.name] = [objectData[this.name]];
                }
                objectData[this.name].push(this.value || '');
            } else {
                objectData[this.name] = this.value || '';
            }
        });
        return objectData;
    }
});
if (module.exports.__esModule) module.exports = module.exports.default
if (module.hot) {(function () {  module.hot.accept()
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), true)
  if (!hotAPI.compatible) return
  if (!module.hot.data) {
    hotAPI.createRecord("_v-3eff3ff4", module.exports)
  } else {
    hotAPI.update("_v-3eff3ff4", module.exports, (typeof module.exports === "function" ? module.exports.options : module.exports).template)
  }
})()}
},{"vue":98,"vue-hot-reload-api":95}],112:[function(require,module,exports){
'use strict';

var dateFormat = require('dateformat');

// Vue imports
var Vue = require('vue');
var Permissions = require('./components/Permissions.vue');
var PhotoList = require('./components/photoList.vue');
var emailPreference = require('./components/email.vue');
var FormToAjax = require('./directives/FormToAjax.vue');
var countries = require('./components/countries.vue');
var dropdown = require('./components/dropdown.vue');
require('./components/checkboxList.vue');

var Spinner = require("spin");
var Gmaps = require("gmaps.core");
require("gmaps.markers");
var Dropzone = require("dropzone");
var swal = require("sweetalert");
var bootstrapToggle = require("bootstrap-toggle");
var locationPicker = require("jquery-locationpicker");
Vue.use(require('vue-resource'));

$(document).ready(function () {
    // var dateFormat = require('dateformat');

    // set th CSRF_TOKEN for ajax requests
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    /* ==========================================================================
       Custom functions
       ========================================================================== */

    /**
     * Check if variable is instanciated
     * @param  {string} strVariableName name of the variable to pass
     * @return {boolean}
     */
    function isset(strVariableName) {
        if (typeof back !== 'undefined') {
            return typeof back[strVariableName] !== 'undefined';
        }
        return false;
    }

    /* ==========================================================================
    	Scroll
    	========================================================================== */

    if (!("ontouchstart" in document.documentElement)) {

        document.documentElement.className += " no-touch";

        var jScrollOptions = {
            autoReinitialise: true,
            autoReinitialiseDelay: 100
        };

        $('.box-typical-body').jScrollPane(jScrollOptions);
        $('.side-menu').jScrollPane(jScrollOptions);
        //$('.side-menu-addl').jScrollPane(jScrollOptions);
        $('.scrollable-block').jScrollPane(jScrollOptions);
    }

    /* ==========================================================================
        Header search
        ========================================================================== */

    $('.site-header .site-header-search').each(function () {
        var parent = $(this),
            overlay = parent.find('.overlay');

        overlay.click(function () {
            parent.removeClass('closed');
        });

        parent.clickoutside(function () {
            if (!parent.hasClass('closed')) {
                parent.addClass('closed');
            }
        });
    });

    /* ==========================================================================
        Header mobile menu
        ========================================================================== */

    // Dropdowns
    $('.site-header-collapsed .dropdown').each(function () {
        var parent = $(this),
            btn = parent.find('.dropdown-toggle');

        btn.click(function () {
            if (parent.hasClass('mobile-opened')) {
                parent.removeClass('mobile-opened');
            } else {
                parent.addClass('mobile-opened');
            }
        });
    });

    $('.dropdown-more').each(function () {
        var parent = $(this),
            more = parent.find('.dropdown-more-caption'),
            classOpen = 'opened';

        more.click(function () {
            if (parent.hasClass(classOpen)) {
                parent.removeClass(classOpen);
            } else {
                parent.addClass(classOpen);
            }
        });
    });

    // Left mobile menu
    $('.hamburger').click(function () {
        if ($('body').hasClass('menu-left-opened')) {
            $(this).removeClass('is-active');
            $('body').removeClass('menu-left-opened');
            $('html').css('overflow', 'auto');
        } else {
            $(this).addClass('is-active');
            $('body').addClass('menu-left-opened');
            $('html').css('overflow', 'hidden');
        }
    });

    $('.mobile-menu-left-overlay').click(function () {
        $('.hamburger').removeClass('is-active');
        $('body').removeClass('menu-left-opened');
        $('html').css('overflow', 'auto');
    });

    // Right mobile menu
    $('.site-header .burger-right').click(function () {
        if ($('body').hasClass('menu-right-opened')) {
            $('body').removeClass('menu-right-opened');
            $('html').css('overflow', 'auto');
        } else {
            $('.hamburger').removeClass('is-active');
            $('body').removeClass('menu-left-opened');
            $('body').addClass('menu-right-opened');
            $('html').css('overflow', 'hidden');
        }
    });

    $('.mobile-menu-right-overlay').click(function () {
        $('body').removeClass('menu-right-opened');
        $('html').css('overflow', 'auto');
    });

    /* ==========================================================================
        Header help
        ========================================================================== */

    $('.help-dropdown').each(function () {
        var parent = $(this),
            btn = parent.find('>button'),
            popup = parent.find('.help-dropdown-popup'),
            jscroll;

        btn.click(function () {
            if (parent.hasClass('opened')) {
                parent.removeClass('opened');
                jscroll.destroy();
            } else {
                parent.addClass('opened');

                $('.help-dropdown-popup-cont, .help-dropdown-popup-side').matchHeight();

                if (!("ontouchstart" in document.documentElement)) {
                    setTimeout(function () {
                        jscroll = parent.find('.jscroll').jScrollPane(jScrollOptions).data().jsp;
                        //jscroll.reinitialise();
                    }, 0);
                }
            }
        });

        $('html').click(function (event) {
            if (!$(event.target).closest('.help-dropdown-popup').length && !$(event.target).closest('.help-dropdown>button').length && !$(event.target).is('.help-dropdown-popup') && !$(event.target).is('.help-dropdown>button')) {
                if (parent.hasClass('opened')) {
                    parent.removeClass('opened');
                    jscroll.destroy();
                }
            }
        });
    });

    /* ==========================================================================
        Side menu list
        ========================================================================== */

    $('.side-menu-list li.with-sub').each(function () {
        var parent = $(this),
            clickLink = parent.find('>span'),
            subMenu = parent.find('ul');

        clickLink.click(function () {
            if (parent.hasClass('opened')) {
                parent.removeClass('opened');
                subMenu.slideUp();
            } else {
                $('.side-menu-list li.with-sub').not(this).removeClass('opened').find('ul').slideUp();
                parent.addClass('opened');
                subMenu.slideDown();
            }
        });
    });

    /* ==========================================================================
        Dashboard
        ========================================================================== */

    // Calculate height
    function dashboardBoxHeight() {
        $('.box-typical-dashboard').each(function () {
            var parent = $(this),
                header = parent.find('.box-typical-header'),
                body = parent.find('.box-typical-body');
            body.height(parent.outerHeight() - header.outerHeight());
        });
    }

    dashboardBoxHeight();

    $(window).resize(function () {
        dashboardBoxHeight();
    });

    // Collapse box
    $('.box-typical-dashboard').each(function () {
        var parent = $(this),
            btnCollapse = parent.find('.action-btn-collapse');

        btnCollapse.click(function () {
            if (parent.hasClass('box-typical-collapsed')) {
                parent.removeClass('box-typical-collapsed');
            } else {
                parent.addClass('box-typical-collapsed');
            }
        });
    });

    // Full screen box
    $('.box-typical-dashboard').each(function () {
        var parent = $(this),
            btnExpand = parent.find('.action-btn-expand'),
            classExpand = 'box-typical-full-screen';

        btnExpand.click(function () {
            if (parent.hasClass(classExpand)) {
                parent.removeClass(classExpand);
                $('html').css('overflow', 'auto');
            } else {
                parent.addClass(classExpand);
                $('html').css('overflow', 'hidden');
            }
            dashboardBoxHeight();
        });
    });

    /* ==========================================================================
    	Select
    	========================================================================== */

    // Bootstrap-select
    $('.bootstrap-select').selectpicker({
        style: '',
        width: '100%',
        size: 8
    });

    // Select2
    $.fn.select2.defaults.set("minimumResultsForSearch", "Infinity");

    $('.select2').select2();

    function select2Icons(state) {
        if (!state.id) {
            return state.text;
        }
        var $state = $('<span class="font-icon ' + state.element.getAttribute('data-icon') + '"></span><span>' + state.text + '</span>');
        return $state;
    }

    $(".select2-icon").select2({
        templateSelection: select2Icons,
        templateResult: select2Icons
    });

    $(".select2-arrow").select2({
        theme: "arrow"
    });

    $(".select2-white").select2({
        theme: "white"
    });

    function select2Photos(state) {
        if (!state.id) {
            return state.text;
        }
        var $state = $('<span class="user-item"><img src="' + state.element.getAttribute('data-photo') + '"/>' + state.text + '</span>');
        return $state;
    }

    $(".select2-photo").select2({
        templateSelection: select2Photos,
        templateResult: select2Photos
    });

    /* ==========================================================================
    	Datepicker
    	========================================================================== */

    $('.datetimepicker-1').datetimepicker({
        widgetPositioning: {
            horizontal: 'right'
        },
        debug: false
    });

    $('.datetimepicker-2').datetimepicker({
        widgetPositioning: {
            horizontal: 'right'
        },
        format: 'LT',
        debug: false
    });

    /* ==========================================================================
    	Tooltips
    	========================================================================== */

    // Tooltip
    $('[data-toggle="tooltip"]').tooltip({
        html: true
    });

    // Popovers
    $('[data-toggle="popover"]').popover({
        trigger: 'focus'
    });

    /* ==========================================================================
    	Validation
    	========================================================================== */

    $('#form-signin_v1').validate({
        submit: {
            settings: {
                inputContainer: '.form-group'
            }
        }
    });

    $('#form-signin_v2').validate({
        submit: {
            settings: {
                inputContainer: '.form-group',
                errorListClass: 'form-error-text-block',
                display: 'block',
                insertion: 'prepend'
            }
        }
    });

    $('#form-signup_v1').validate({
        submit: {
            settings: {
                inputContainer: '.form-group',
                errorListClass: 'form-tooltip-error'
            }
        }
    });

    $('#form-signup_v2').validate({
        submit: {
            settings: {
                inputContainer: '.form-group',
                errorListClass: 'form-tooltip-error'
            }
        }
    });

    /* ==========================================================================
    	Sweet alerts
    	========================================================================== */

    $('.swal-btn-basic').click(function (e) {
        // e.preventDefault();
        swal("Here's a message!");
    });

    $('.swal-btn-text').click(function (e) {
        e.preventDefault();
        swal({
            title: "Here's a message!",
            text: "It's pretty, isn't it?"
        });
    });

    $('.swal-btn-success').click(function (e) {
        e.preventDefault();
        swal({
            title: "Good job!",
            text: "You clicked the button!",
            type: "success",
            confirmButtonClass: "btn-success",
            confirmButtonText: "Success"
        });
    });

    $('.swal-btn-warning').click(function (e) {
        e.preventDefault();
        swal({
            title: "Are you sure?",
            text: "Your will not be able to recover this imaginary file!",
            type: "warning",
            showCancelButton: true,
            cancelButtonClass: "btn-default",
            confirmButtonClass: "btn-warning",
            confirmButtonText: "Warning",
            closeOnConfirm: false
        }, function () {
            swal({
                title: "Deleted!",
                text: "Your imaginary file has been deleted.",
                type: "success",
                confirmButtonClass: "btn-success"
            });
        });
    });

    $('.swal-btn-cancel').click(function (e) {
        e.preventDefault();
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this imaginary file!",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel plx!",
            closeOnConfirm: false,
            closeOnCancel: false
        }, function (isConfirm) {
            if (isConfirm) {
                swal({
                    title: "Deleted!",
                    text: "Your imaginary file has been deleted.",
                    type: "success",
                    confirmButtonClass: "btn-success"
                });
            } else {
                swal({
                    title: "Cancelled",
                    text: "Your imaginary file is safe :)",
                    type: "error",
                    confirmButtonClass: "btn-danger"
                });
            }
        });
    });

    $('.swal-btn-custom-img').click(function (e) {
        e.preventDefault();
        swal({
            title: "Sweet!",
            text: "Here's a custom image.",
            confirmButtonClass: "btn-success",
            imageUrl: 'img/smile.png'
        });
    });

    $('.swal-btn-info').click(function (e) {
        e.preventDefault();
        swal({
            title: "Are you sure?",
            text: "Your will not be able to recover this imaginary file!",
            type: "info",
            showCancelButton: true,
            cancelButtonClass: "btn-default",
            confirmButtonText: "Info",
            confirmButtonClass: "btn-primary"
        });
    });

    /* ==========================================================================
    	Bar chart
    	========================================================================== */

    $(".bar-chart").peity("bar", {
        delimiter: ",",
        fill: ["#919fa9"],
        height: 16,
        max: null,
        min: 0,
        padding: 0.1,
        width: 384
    });

    /* ==========================================================================
    	Full height box
    	========================================================================== */

    function boxFullHeight() {
        var sectionHeader = $('.section-header');
        var sectionHeaderHeight = 0;

        if (sectionHeader.size()) {
            sectionHeaderHeight = parseInt(sectionHeader.height()) + parseInt(sectionHeader.css('padding-bottom'));
        }

        $('.box-typical-full-height').css('min-height', $(window).height() - parseInt($('.page-content').css('padding-top')) - parseInt($('.page-content').css('padding-bottom')) - sectionHeaderHeight - parseInt($('.box-typical-full-height').css('margin-bottom')) - 2);
        $('.box-typical-full-height>.tbl, .box-typical-full-height>.box-typical-center').height(parseInt($('.box-typical-full-height').css('min-height')));
    }

    boxFullHeight();

    $(window).resize(function () {
        boxFullHeight();
    });

    /* ==========================================================================
    	Chat
    	========================================================================== */

    function chatHeights() {
        $('.chat-dialog-area').height($(window).height() - parseInt($('.page-content').css('padding-top')) - parseInt($('.page-content').css('padding-bottom')) - parseInt($('.chat-container').css('margin-bottom')) - 2 - $('.chat-area-header').outerHeight() - $('.chat-area-bottom').outerHeight());
        $('.chat-list-in').height($(window).height() - parseInt($('.page-content').css('padding-top')) - parseInt($('.page-content').css('padding-bottom')) - parseInt($('.chat-container').css('margin-bottom')) - 2 - $('.chat-area-header').outerHeight()).css('min-height', parseInt($('.chat-dialog-area').css('min-height')) + $('.chat-area-bottom').outerHeight());
    }

    chatHeights();

    $(window).resize(function () {
        chatHeights();
    });

    /* ==========================================================================
    	Auto size for textarea
    	========================================================================== */

    autosize($('textarea[data-autosize]'));

    /* ==========================================================================
    	Pages center
    	========================================================================== */

    $('.page-center').matchHeight({
        target: $('html')
    });

    $(window).resize(function () {
        setTimeout(function () {
            $('.page-center').matchHeight({ remove: true });
            $('.page-center').matchHeight({
                target: $('html')
            });
        }, 100);
    });

    /* ==========================================================================
    	Cards user
    	========================================================================== */

    $('.card-user').matchHeight();

    /* ==========================================================================
    	Fancybox
    	========================================================================== */

    $(".fancybox").fancybox({
        padding: 0,
        openEffect: 'none',
        closeEffect: 'none'
    });

    /* ==========================================================================
    	Box typical full height with header
    	========================================================================== */

    function boxWithHeaderFullHeight() {
        $('.box-typical-full-height-with-header').each(function () {
            var box = $(this),
                boxHeader = box.find('.box-typical-header'),
                boxBody = box.find('.box-typical-body');

            boxBody.height($(window).height() - parseInt($('.page-content').css('padding-top')) - parseInt($('.page-content').css('padding-bottom')) - parseInt(box.css('margin-bottom')) - 2 - boxHeader.outerHeight());
        });
    }

    boxWithHeaderFullHeight();

    $(window).resize(function () {
        boxWithHeaderFullHeight();
    });

    /* ==========================================================================
    	Gallery
    	========================================================================== */

    $('.gallery-item').matchHeight({
        target: $('.gallery-item .gallery-picture')
    });

    /* ==========================================================================
    	Addl side menu
    	========================================================================== */

    setTimeout(function () {
        if (!("ontouchstart" in document.documentElement)) {
            $('.side-menu-addl').jScrollPane(jScrollOptions);
        }
    }, 1000);

    /* ==========================================================================
    	Tables
    	========================================================================== */

    var generic_table = $('.generic_table');
    var equipmentTable = $('#equipmentTable');
    var worksTable = $('#worksTable');
    var missingServices = $('#missingServices');

    var tableOptions = {
        iconsPrefix: 'font-icon',
        toggle: 'table',
        sidePagination: 'client',
        pagination: 'true',
        icons: {
            paginationSwitchDown: 'font-icon-arrow-square-down',
            paginationSwitchUp: 'font-icon-arrow-square-down up',
            refresh: 'font-icon-refresh',
            toggle: 'font-icon-list-square',
            columns: 'font-icon-list-rotate',
            export: 'font-icon-download'
        },
        paginationPreText: '<i class="font-icon font-icon-arrow-left"></i>',
        paginationNextText: '<i class="font-icon font-icon-arrow-right"></i>'
    };

    generic_table.bootstrapTable(tableOptions);
    equipmentTable.bootstrapTable(tableOptions);
    worksTable.bootstrapTable(tableOptions);
    missingServices.bootstrapTable(tableOptions);

    $('.generic_table').on('click-row.bs.table', function (e, row, $element) {
        if ($element.hasClass('table_active')) {
            $element.removeClass('table_active');
        } else {
            generic_table.find('tr.table_active').removeClass('table_active');
            $element.addClass('table_active');
        }
        window.location.href = back.click_url + row.id;
    });

    $('#worksTable').on('click-row.bs.table', function (e, row, $element) {
        if ($element.hasClass('table_active')) {
            $element.removeClass('table_active');
        } else {
            worksTable.find('tr.table_active').removeClass('table_active');
            $element.addClass('table_active');
        }
        if (isset('worksUrl')) {
            $.ajax({
                vue: workOrderVue,
                worksTable: worksTable,
                url: back.worksUrl + row.id,
                type: 'GET',
                success: function success(data, textStatus, xhr) {
                    //called when successful
                    this.vue.workId = data.id;
                    this.vue.workTitle = data.title;
                    this.vue.workDescription = data.description;
                    this.vue.workQuantity = data.quantity;
                    this.vue.workUnits = data.units;
                    this.vue.workCost = data.cost;
                    this.vue.workTechnician = data.technican;
                    this.vue.workPhotos = data.photos;

                    this.vue.openWorkModal(2);
                    // remove dropzone instance
                    Dropzone.forElement("#worksDropzone").destroy();

                    if (isset('worksAddPhotoUrl')) {
                        // generating the dropzone dinamicly
                        // in order to change the url
                        $("#worksDropzone").dropzone({
                            vue: this.vue,
                            url: back.worksAddPhotoUrl + data.id,
                            method: 'post',
                            paramName: 'photo',
                            maxFilesize: 50,
                            acceptedFiles: '.jpg, .jpeg, .png',
                            init: function init() {
                                this.on("success", function (file) {
                                    this.options.vue.$emit('workChanged');
                                });
                            }
                        });
                    }
                    // remove the selected color from the row
                    this.worksTable.find('tr.table_active').removeClass('table_active');
                },
                error: function error(xhr, textStatus, errorThrown) {
                    //called when there is an error
                    console.log('error');
                }
            });
        }
    });

    $('#equipmentTable').on('click-row.bs.table', function (e, row, $element) {
        if ($element.hasClass('table_active')) {
            $element.removeClass('table_active');
        } else {
            equipmentTable.find('tr.table_active').removeClass('table_active');
            $element.addClass('table_active');
        }
        if (isset('equipmentUrl')) {
            $.ajax({
                vue: serviceVue,
                equipmentTable: equipmentTable,
                url: back.equipmentUrl + row.id,
                type: 'GET',
                success: function success(data, textStatus, xhr) {
                    //called when successful
                    this.vue.equipmentId = data.id;
                    this.vue.equipmentKind = data.kind;
                    this.vue.equipmentType = data.type;
                    this.vue.equipmentBrand = data.brand;
                    this.vue.equipmentModel = data.model;
                    this.vue.equipmentCapacity = data.capacity;
                    this.vue.equipmentUnits = data.units;
                    this.vue.equipmentPhotos = data.photos;
                    // remove dropzone instance
                    Dropzone.forElement("#equipmentDropzone").destroy();

                    if (isset('equipmentAddPhotoUrl')) {
                        // generating the dropzone dinamicly
                        // in order to change the url
                        $("#equipmentDropzone").dropzone({
                            vue: this.vue,
                            url: back.equipmentAddPhotoUrl + data.id,
                            method: 'post',
                            paramName: 'photo',
                            maxFilesize: 50,
                            acceptedFiles: '.jpg, .jpeg, .png',
                            init: function init() {
                                this.on("success", function (file) {
                                    this.options.vue.$emit('equipmentChanged');
                                });
                            }
                        });
                        // set the dropzone class for styling
                        $("#equipmentDropzone").addClass("dropzone");
                    }
                    // remove the selected color from the row
                    this.equipmentTable.find('tr.table_active').removeClass('table_active');
                    this.vue.equipmentTableFocus = false;
                    this.vue.equipmentFocus = 4;
                },
                error: function error(xhr, textStatus, errorThrown) {
                    //called when there is an error
                    console.log('error');
                }
            });
        }
    });

    $('#missingServices').on('click-row.bs.table', function (e, row, $element) {
        if ($element.hasClass('table_active')) {
            $element.removeClass('table_active');
        } else {
            missingServices.find('tr.table_active').removeClass('table_active');
            $element.addClass('table_active');
        }
        window.location.href = back.click_missingServices_url + row.id;
    });

    /* ==========================================================================
        Side datepicker
        ========================================================================== */
    if (isset('enabledDates')) {
        $('#side-datetimepicker').datetimepicker({
            inline: true,
            enabledDates: back.enabledDates,
            format: 'YYYY-MM-DD',
            defaultDate: back.todayDate
        });
    }

    if (isset('date_url')) {
        $("#side-datetimepicker").on("dp.change", function (e) {
            var date = new Date(e.date._d);
            var date_selected = dateFormat(date, "yyyy-mm-dd");
            var new_url = back.datatable_url + date_selected;
            var new_missingServices_url = back.missingServices_url + date_selected;

            generic_table.bootstrapTable('refresh', { url: new_url });
            missingServices.bootstrapTable('refresh', { url: new_missingServices_url });
            if (isset('missingServicesInfo_url')) {
                $.ajax({
                    vue: reportVue,
                    url: back.missingServicesInfo_url,
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        'date': date_selected
                    },
                    success: function success(data, textStatus, xhr) {
                        //called when successful
                        this.vue.numServicesDone = data.numServicesDone;
                        this.vue.numServicesMissing = data.numServicesMissing;
                        this.vue.numServicesToDo = data.numServicesToDo;
                    },
                    error: function error(xhr, textStatus, errorThrown) {
                        //called when there is an error
                        // console.log('error');
                    }
                });
            }
        });
    }
    if (isset('defaultDate')) {
        $('#editGenericDatepicker').datetimepicker({
            widgetPositioning: {
                horizontal: 'right'
            },
            debug: false,
            defaultDate: back.defaultDate
        });
    }

    $('#genericDatepicker').datetimepicker({
        widgetPositioning: {
            horizontal: 'right'
        },
        debug: false,
        useCurrent: true
    });

    /* ==========================================================================
        Custom Slick Carousel
        ========================================================================== */

    $(".reports_slider").slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        dots: true,
        centerMode: true,
        focusOnSelect: true
    });

    /* ==========================================================================
        Clockpicker
        ========================================================================== */

    $(document).ready(function () {
        $('.clockpicker').clockpicker({
            autoclose: true,
            donetext: 'Done',
            'default': 'now'
        });
    });

    /* ==========================================================================
       VueJs code
       ========================================================================== */

    // workOrders Vue instance
    var workOrderVue = new Vue({
        el: '.workOrderVue',
        components: {
            PhotoList: PhotoList,
            dropdown: dropdown
        },
        data: {
            validationErrors: {},
            // index
            finishedSwitch: false,
            // create edit
            supervisorId: isset('supervisorId') ? back.supervisorId : 0,
            serviceId: isset('serviceId') ? back.serviceId : 0,
            // Show
            finished: isset('workOrderFinished') ? back.workOrderFinished : 0,
            // Finish
            workOrderFinishedAt: '',
            // Photos
            photoFocus: 1, // 1=before work  2=after work 3=editing before work photo
            // Work
            // show and edit
            workFocus: 1, // 1=new, 2=show, 3=edit
            workOrderId: isset('workOrderId') ? back.workOrderId : 0,
            workId: 0,
            workTitle: '',
            workDescription: '',
            workQuantity: '',
            workUnits: '',
            workCost: '',
            workOrderBeforePhotos: isset('workOrderBeforePhotos') ? back.workOrderBeforePhotos : 0,
            workOrderAfterPhotos: isset('workOrderAfterPhotos') ? back.workOrderAfterPhotos : 0,
            workTechnician: {
                'id': 0
            },
            workPhotos: []
        },
        computed: {
            workModalTitle: function workModalTitle() {
                switch (this.workFocus) {
                    case 1:
                        return 'Add Work';
                        break;
                    case 2:
                        return 'View Work';
                        break;
                    case 3:
                        return 'Edit Work';
                        break;
                    default:
                        return 'Work';
                }
            },
            photoModalTitle: function photoModalTitle() {
                switch (this.photoFocus) {
                    case 1:
                        return 'Photos before work started';
                        break;
                    case 2:
                        return 'Photos after the work was finished';
                        break;
                    default:
                        return 'Photos';
                }
            }
        },
        events: {
            workChanged: function workChanged() {
                this.getWork();
            },
            workOrderChangePhotos: function workOrderChangePhotos() {
                this.refreshWorkOrderPhotos('after');
                this.refreshWorkOrderPhotos('before');
            }
        },
        methods: {
            refreshWorkOrderPhotos: function refreshWorkOrderPhotos(type) {
                var url = '';
                if (type == 'before' && isset('workOrderPhotoBeforeUrl')) {
                    url = back.workOrderPhotoBeforeUrl;
                } else if (type == 'after' && isset('workOrderPhotoAfterUrl')) {
                    url = back.workOrderPhotoAfterUrl;
                }

                if (url != '') {
                    $.ajax({
                        vue: this,
                        url: url,
                        type: 'GET',
                        success: function success(data, textStatus, xhr) {
                            if (type == 'before') {
                                this.vue.workOrderBeforePhotos = data;
                            } else if (type == 'after') {
                                this.vue.workOrderAfterPhotos = data;
                            }
                        },
                        error: function error(xhr, textStatus, errorThrown) {}
                    });
                }
            },
            checkValidationError: function checkValidationError($fildName) {
                return $fildName in this.validationErrors;
            },
            finishWorkOrder: function finishWorkOrder() {
                if (isset('finishWorkOrderUrl') && isset('workOrderUrl')) {
                    $.ajax({
                        vue: this,
                        swal: swal,
                        url: back.finishWorkOrderUrl,
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            'end': this.workOrderFinishedAt
                        },
                        success: function success(data, textStatus, xhr) {
                            window.location = back.workOrderUrl;
                            // send success alert
                            this.swal({
                                title: data.title,
                                text: data.message,
                                type: "success",
                                timer: 2000,
                                showConfirmButton: false
                            });
                        },
                        error: function error(xhr, textStatus, errorThrown) {
                            this.vue.validationErrors = xhr.responseJSON;
                        }
                    });
                }
            },
            openPhotosModal: function openPhotosModal($focus) {
                this.photoFocus = $focus;
                $('#photosWorkOrderModal').modal('show');
            },
            checkPhotoFocus: function checkPhotoFocus($num) {
                return this.photoFocus == $num;
            },
            openFinishModal: function openFinishModal() {
                $('#finishWorkOrderModal').modal('show');
            },
            destroyWork: function destroyWork() {
                var _this = this;

                if (isset('worksUrl')) {
                    (function () {
                        var vue = _this;
                        swal({
                            title: "Are you sure?",
                            text: "You will not be able to recover this!",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "Yes, delete it!",
                            cancelButtonText: "No, cancel!",
                            closeOnConfirm: true,
                            closeOnCancel: true
                        }, function (isConfirm) {
                            if (isConfirm) {
                                $.ajax({
                                    vue: vue,
                                    swal: swal,
                                    url: back.worksUrl + vue.workId,
                                    type: 'DELETE',
                                    success: function success(data, textStatus, xhr) {
                                        // refresh equipment list
                                        worksTable.bootstrapTable('refresh');

                                        this.vue.closeWorkModal();
                                        // send success alert
                                        this.swal({
                                            title: data.title,
                                            text: data.message,
                                            type: "success",
                                            timer: 2000,
                                            showConfirmButton: false
                                        });
                                    },
                                    error: function error(xhr, textStatus, errorThrown) {
                                        // this.swal({
                                        //     title: data.title,
                                        //     text: data.message,
                                        //     type: "error",
                                        //     showConfirmButton: true
                                        // });
                                    }
                                });
                            }
                        });
                    })();
                }
            },
            sendWork: function sendWork(type) {
                var url = isset('worksUrl') ? back.worksUrl : '';
                var requestType = 'POST';
                if (type == 'edit') {
                    url += this.workId;
                    requestType = 'PATCH';
                }

                if (url != '') {
                    $.ajax({
                        vue: this,
                        swal: swal,
                        url: url,
                        type: requestType,
                        dataType: 'json',
                        data: {
                            title: this.workTitle,
                            description: this.workDescription,
                            quantity: this.workQuantity,
                            units: this.workUnits,
                            cost: this.workCost,
                            work_order_id: this.workOrderId,
                            technician_id: this.workTechnician.id
                        },
                        success: function success(data, textStatus, xhr) {
                            // refresh equipment list
                            worksTable.bootstrapTable('refresh');

                            this.vue.closeWorkModal();

                            // send success alert
                            this.swal({
                                title: data.title,
                                text: data.message,
                                type: "success",
                                timer: 2000,
                                showConfirmButton: false
                            });
                        },
                        error: function error(xhr, textStatus, errorThrown) {
                            this.vue.validationErrors = xhr.responseJSON;
                        }
                    });
                }
            },
            getWork: function getWork() {
                if (isset('worksUrl')) {
                    $.ajax({
                        vue: this,
                        url: back.worksUrl + this.workId,
                        type: 'GET',
                        success: function success(data, textStatus, xhr) {
                            this.vue.workId = data.id;
                            this.vue.workTitle = data.title;
                            this.vue.workDescription = data.description;
                            this.vue.workQuantity = data.quantity;
                            this.vue.workUnits = data.units;
                            this.vue.workCost = data.cost;
                            this.vue.workTechnician = data.technican;
                            this.vue.workPhotos = data.photos;
                        },
                        error: function error(xhr, textStatus, errorThrown) {
                            //called when there is an error
                            console.log('error');
                        }
                    });
                }
            },
            clearWork: function clearWork() {
                this.workId = 0;
                this.workTitle = '';
                this.workDescription = '';
                this.workQuantity = '';
                this.workUnits = '';
                this.workCost = '';
                this.workTechnician = '';
                this.workPhotos = '';
            },
            setWorkFocus: function setWorkFocus($num) {
                if ($num == 1) {
                    this.clearWork();
                }
                this.workFocus = $num;
            },
            checkWorkFocusIs: function checkWorkFocusIs($num) {
                return this.workFocus == $num;
            },
            openWorkModal: function openWorkModal($focus) {
                this.setWorkFocus($focus);
                $('#workModal').modal('show');
            },
            closeWorkModal: function closeWorkModal() {
                $('#workModal').modal('hide');
                this.clearWork();
            },
            changeWorkOrderListFinished: function changeWorkOrderListFinished(finished) {
                var intFinished = !finished ? 1 : 0;
                if (isset('workOrderTableUrl')) {
                    var new_url = back.workOrderTableUrl + intFinished;
                    generic_table.bootstrapTable('refresh', { url: new_url });
                }
            }
        }
    });

    // report Vue instance
    var reportVue = new Vue({
        el: '.reportVue',
        components: { dropdown: dropdown },
        directives: { FormToAjax: FormToAjax },
        data: {
            numServicesMissing: isset('numServicesMissing') ? back.numServicesMissing : '',
            numServicesToDo: isset('numServicesToDo') ? back.numServicesToDo : '',
            numServicesDone: isset('numServicesDone') ? back.numServicesDone : '',
            reportEmailPreview: isset('emailPreviewNoImage') ? back.emailPreviewNoImage : '',
            serviceKey: isset('serviceKey') ? Number(back.serviceKey) : 0,
            technicianKey: isset('technicianKey') ? Number(back.technicianKey) : 0
        },
        computed: {
            missingServicesTag: function missingServicesTag() {
                if (this.numServicesMissing < 1) {
                    return 'All Services Done';
                }
                return 'Missing Services: ' + this.numServicesMissing;
            }
        },
        methods: {
            previewEmailReport: function previewEmailReport(id) {
                // prevent the user from clicking more than once
                event.target.disabled = true;
                event.target.innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Generating email";
                new Spinner({
                    left: "90%",
                    radius: 5,
                    length: 4,
                    width: 1
                }).spin(event.target);
                // HTTP Request or what ever to update the permission
                $.ajax({
                    vue: this,
                    target: event.target,
                    url: isset('emailPreview') ? back.emailPreview : '',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        'id': id
                    },
                    complete: function complete(xhr, textStatus) {
                        this.target.disabled = false;
                        this.target.innerHTML = "<i class=\"font-icon font-icon-mail\"></i>&nbsp;&nbsp;Preview email";
                    },
                    success: function success(data, textStatus, xhr) {
                        $('#emailPreview').modal('show');
                        this.vue.reportEmailPreview = data.data.url;
                    },
                    error: function error(xhr, textStatus, errorThrown) {
                        console.log('error');
                    }
                });
            }
        }
    });

    var settingsVue = new Vue({
        el: '.settingsVue',
        components: {
            Permissions: Permissions,
            emailPreference: emailPreference
        },
        directives: { FormToAjax: FormToAjax },
        data: {
            companyName: "",
            website: "",
            facebook: "",
            twitter: "",
            objectName: "",
            objectLastName: ""
        }
    });

    var serviceVue = new Vue({
        el: '.serviceVue',
        components: {
            PhotoList: PhotoList,
            countries: countries
        },
        directives: { FormToAjax: FormToAjax },
        data: {
            statusSwitch: true,
            // Location picker values
            pickerServiceAddressLine1: '',
            pickerServiceCity: '',
            pickerServiceState: '',
            pickerServicePostalCode: '',
            pickerServiceCountry: '',
            pickerServiceLatitude: '',
            pickerServiceLongitude: '',
            // form values
            serviceAddressLine1: isset('addressLine') ? back.addressLine : '',
            serviceCity: isset('city') ? back.city : '',
            serviceState: isset('state') ? back.state : '',
            servicePostalCode: isset('postalCode') ? back.postalCode : '',
            serviceCountry: isset('country') ? back.country : '',
            serviceLatitude: isset('latitude') ? back.latitude : null,
            serviceLongitude: isset('longitude') ? back.longitude : null,
            // Equipment
            equipmentTableFocus: true,
            equipmentFocus: 1, // 1=table, 2=new, 3=show, 4=edit
            equipmentId: 0,
            equipmentServiceId: isset('serviceId') ? Number(back.serviceId) : 0,
            equipmentPhotos: [],
            equipmentPhoto: '',
            equipmentKind: '',
            equipmentType: '',
            equipmentBrand: '',
            equipmentModel: '',
            equipmentCapacity: '',
            equipmentUnits: ''
        },
        computed: {
            equipmentModalTitle: function equipmentModalTitle() {
                switch (this.equipmentFocus) {
                    case 1:
                        return 'Equipment List';
                        break;
                    case 2:
                        return 'Add Equipment';
                        break;
                    case 3:
                        return this.equipmentKind;
                        break;
                    case 4:
                        return 'Edit Equipment';
                        break;
                    default:
                        return 'Equipment';
                }
            },
            locationPickerTag: function locationPickerTag() {
                var attributes = {
                    'icon': 'font-icon font-icon-ok',
                    'text': 'Location Selected',
                    'class': 'btn-success'
                };
                if (this.serviceLatitude == null) {
                    attributes = {
                        'icon': 'font-icon font-icon-pin-2',
                        'text': 'Choose Location',
                        'class': 'btn-primary'
                    };
                }
                return attributes;
            }
        },
        events: {
            // when a photo is deleted from the equipment photo edit
            equipmentChanged: function equipmentChanged() {
                this.getEquipment();
            }
        },
        methods: {
            // Equipment
            destroyEquipment: function destroyEquipment() {
                var _this2 = this;

                if (isset('equipmentUrl')) {
                    (function () {
                        var vue = _this2;
                        swal({
                            title: "Are you sure?",
                            text: "You will not be able to recover this!",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "Yes, delete it!",
                            cancelButtonText: "No, cancel!",
                            closeOnConfirm: true,
                            closeOnCancel: true
                        }, function (isConfirm) {
                            if (isConfirm) {
                                $.ajax({
                                    vue: vue,
                                    swal: swal,
                                    url: back.equipmentUrl + vue.equipmentId,
                                    type: 'DELETE',
                                    success: function success(data, textStatus, xhr) {
                                        // refresh equipment list
                                        equipmentTable.bootstrapTable('refresh');

                                        this.vue.openEquimentList();
                                        // send success alert
                                        this.swal({
                                            title: data.title,
                                            text: data.message,
                                            type: "success",
                                            timer: 2000,
                                            showConfirmButton: false
                                        });
                                    },
                                    error: function error(xhr, textStatus, errorThrown) {
                                        // this.swal({
                                        //     title: data.title,
                                        //     text: data.message,
                                        //     type: "error",
                                        //     showConfirmButton: true
                                        // });
                                    }
                                });
                            }
                        });
                    })();
                }
            },
            getEquipment: function getEquipment() {
                if (isset('equipmentUrl')) {
                    $.ajax({
                        vue: this,
                        url: back.equipmentUrl + this.equipmentId,
                        type: 'GET',
                        success: function success(data, textStatus, xhr) {
                            //called when successful
                            this.vue.equipmentId = data.id;
                            this.vue.equipmentKind = data.kind;
                            this.vue.equipmentType = data.type;
                            this.vue.equipmentBrand = data.brand;
                            this.vue.equipmentModel = data.model;
                            this.vue.equipmentCapacity = data.capacity;
                            this.vue.equipmentUnits = data.units;
                            this.vue.equipmentPhotos = data.photos;
                        },
                        error: function error(xhr, textStatus, errorThrown) {
                            //called when there is an error
                            console.log('error');
                        }
                    });
                }
            },
            sendEquipment: function sendEquipment(type) {
                var url = isset('equipmentUrl') ? back.equipmentUrl : '';
                var requestType = 'POST';

                if (type == 'edit') {
                    url += this.equipmentId;
                    requestType = 'PATCH';
                }

                if (url != '') {
                    $.ajax({
                        vue: this,
                        url: url,
                        type: requestType,
                        dataType: 'json',
                        data: {
                            'photo': this.equipmentPhoto,
                            'kind': this.equipmentKind,
                            'type': this.equipmentType,
                            'brand': this.equipmentBrand,
                            'model': this.equipmentModel,
                            'capacity': this.equipmentCapacity,
                            'units': this.equipmentUnits,
                            'service_id': this.equipmentServiceId
                        },
                        success: function success(data, textStatus, xhr) {
                            // refresh equipment list
                            equipmentTable.bootstrapTable('refresh');
                            // send back to list
                            this.vue.openEquimentList();
                        },
                        error: function error(xhr, textStatus, errorThrown) {
                            console.log('error creating equipment');
                        }
                    });
                }
            },
            clearEquipment: function clearEquipment() {
                this.equipmentKind = '';
                this.equipmentType = '';
                this.equipmentBrand = '';
                this.equipmentModel = '';
                this.equipmentCapacity = '';
                this.equipmentUnits = '';
            },
            setEquipmentFocus: function setEquipmentFocus($num) {
                this.equipmentFocus = $num;
            },
            checkEquipmentFocusIs: function checkEquipmentFocusIs($num) {
                return this.equipmentFocus == $num;
            },
            openEquimentList: function openEquimentList() {
                var clearEquipment = arguments.length <= 0 || arguments[0] === undefined ? true : arguments[0];

                this.equipmentTableFocus = true;
                this.equipmentFocus = 1;
                if (clearEquipment) {
                    this.clearEquipment();
                }
                $('#equipmentModal').modal('show');
            },
            populateAddressFields: function populateAddressFields(page) {
                this.setLocation(page);
                if (page == 'create') {
                    this.serviceAddressLine1 = this.pickerServiceAddressLine1;
                    this.serviceCity = this.pickerServiceCity;
                    this.servicePostalCode = this.pickerServicePostalCode;
                    this.serviceState = this.pickerServiceState;
                    this.serviceCountry = this.pickerServiceCountry;
                }
            },
            setLocation: function setLocation(page) {
                if (page == 'create') {
                    this.serviceLongitude = this.pickerServiceLongitude;
                    this.serviceLatitude = this.pickerServiceLatitude;
                }
            },
            changeServiceListStatus: function changeServiceListStatus(status) {
                var intStatus = !status ? 1 : 0;
                if (isset('serviceTableUrl')) {
                    var new_url = back.serviceTableUrl + intStatus;
                    generic_table.bootstrapTable('refresh', { url: new_url });
                }
            }
        }

    });

    /* ==========================================================================
        GMaps
        ========================================================================== */
    $('#mapModal').on('shown.bs.modal', function (e) {
        if (isset('showLatitude') && isset('showLongitude')) {
            var map = new Gmaps({
                el: '#serviceMap',
                lat: back.showLatitude,
                lng: back.showLongitude
            });

            map.addMarker({
                lat: back.showLatitude,
                lng: back.showLongitude
            });
        }
    });

    /* ==========================================================================
        Dropzone
        ========================================================================== */

    // Dropzone.autoDiscover = false;
    Dropzone.options.genericDropzone = {
        paramName: 'photo',
        maxFilesize: 50,
        acceptedFiles: '.jpg, .jpeg, .png'
    };

    Dropzone.options.workOrderDropzone = {
        vue: workOrderVue,
        paramName: 'photo',
        maxFilesize: 50,
        acceptedFiles: '.jpg, .jpeg, .png',
        init: function init() {
            this.on("success", function (file) {
                this.options.vue.$emit('workOrderChangePhotos');
            });
        }
    };

    // Dropzone.options.equipmentDropzone = {
    //     paramName: 'photo',
    // 	maxFilesize: 50,
    // 	acceptedFiles: '.jpg, .jpeg, .png',
    // }


    /* ==========================================================================
        Location Picker
        ========================================================================== */

    var locPicker = $('#locationPicker').locationpicker({
        vue: serviceVue,
        location: { latitude: 23.04457265331633, longitude: -109.70587883663177 },
        radius: 0,
        inputBinding: {
            latitudeInput: $('#serviceLatitude'),
            longitudeInput: $('#serviceLongitude'),
            locationNameInput: $('#serviceAddress')
        },
        enableAutocomplete: true,
        onchanged: function onchanged(currentLocation, radius, isMarkerDropped) {
            var addressComponents = $(this).locationpicker('map').location.addressComponents;
            var vue = $(this).data("locationpicker").settings.vue;

            vue.pickerServiceAddressLine1 = addressComponents.addressLine1;
            vue.pickerServiceCity = addressComponents.city;
            vue.pickerServiceState = addressComponents.stateOrProvince;
            vue.pickerServicePostalCode = addressComponents.postalCode;
            vue.pickerServiceCountry = addressComponents.country;
            vue.pickerServiceLongitude = currentLocation.longitude;
            vue.pickerServiceLatitude = currentLocation.latitude;
        },
        oninitialized: function oninitialized(component) {
            var addressComponents = $(component).locationpicker('map').location.addressComponents;
            var startLocation = $(component).data("locationpicker").settings.location;
            var vue = $(component).data("locationpicker").settings.vue;

            vue.pickerServiceAddressLine1 = addressComponents.addressLine1;
            vue.pickerServiceCity = addressComponents.city;
            vue.pickerServiceState = addressComponents.stateOrProvince;
            vue.pickerServicePostalCode = addressComponents.postalCode;
            vue.pickerServiceCountry = addressComponents.country;
            vue.pickerServiceLongitude = startLocation.longitude;
            vue.pickerServiceLatitude = startLocation.latitude;
        }
    });

    $('#locationPickerModal').on('shown.bs.modal', function () {
        $('#locationPicker').locationpicker('autosize');
    });

    /* ==========================================================================
        Maxlenght and Hide Show Password
        ========================================================================== */

    $('input.maxlength-simple').maxlength();

    $('input.maxlength-custom-message').maxlength({
        threshold: 10,
        warningClass: "label label-success",
        limitReachedClass: "label label-danger",
        separator: ' of ',
        preText: 'You have ',
        postText: ' chars remaining.',
        validate: true
    });

    $('input.maxlength-always-show').maxlength({
        alwaysShow: true
    });

    $('textarea.maxlength-simple').maxlength({
        alwaysShow: true
    });

    $('.hide-show-password').password();

    /* ========================================================================== */
});

/*
Taken from: https://gist.github.com/soufianeEL/3f8483f0f3dc9e3ec5d9
Modified by Ferri Sutanto
- use promise for verifyConfirm
Examples :
<a href="posts/2" data-method="delete" data-token="{{csrf_token()}}">
- Or, request confirmation in the process -
<a href="posts/2" data-method="delete" data-token="{{csrf_token()}}" data-confirm="Are you sure?">
*/

(function (window, $, undefined) {

    var Laravel = {
        initialize: function initialize() {
            this.methodLinks = $('a[data-method]');
            this.token = $('a[data-token]');
            this.registerEvents();
        },

        registerEvents: function registerEvents() {
            this.methodLinks.on('click', this.handleMethod);
        },

        handleMethod: function handleMethod(e) {
            e.preventDefault();

            var link = $(this);
            var httpMethod = link.data('method').toUpperCase();
            var form;

            // If the data-method attribute is not PUT or DELETE,
            // then we don't know what to do. Just ignore.
            if ($.inArray(httpMethod, ['PUT', 'DELETE']) === -1) {
                return false;
            }

            Laravel.verifyConfirm(link).done(function () {
                form = Laravel.createForm(link);
                form.submit();
            });
        },

        verifyConfirm: function verifyConfirm(link) {
            var confirm = new $.Deferred();
            swal({
                title: "Are you sure?",
                text: "You will not be able to recover this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                closeOnConfirm: false
            }, function () {
                confirm.resolve(link);
            });

            return confirm.promise();
        },

        createForm: function createForm(link) {
            var form = $('<form>', {
                'method': 'POST',
                'action': link.attr('href')
            });

            var token = $('<input>', {
                'type': 'hidden',
                'name': '_token',
                'value': link.data('token')
            });

            var hiddenInput = $('<input>', {
                'name': '_method',
                'type': 'hidden',
                'value': link.data('method')
            });

            return form.append(token, hiddenInput).appendTo('body');
        }
    };

    Laravel.initialize();
})(window, jQuery);

},{"./components/Permissions.vue":104,"./components/checkboxList.vue":105,"./components/countries.vue":106,"./components/dropdown.vue":107,"./components/email.vue":108,"./components/photoList.vue":110,"./directives/FormToAjax.vue":111,"bootstrap-toggle":1,"dateformat":2,"dropzone":3,"gmaps.core":4,"gmaps.markers":5,"jquery-locationpicker":6,"spin":85,"sweetalert":94,"vue":98,"vue-resource":97}]},{},[103,101,100,102,112]);

//# sourceMappingURL=bundle.js.map
