(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
module.exports = { "default": require("core-js/library/fn/get-iterator"), __esModule: true };
},{"core-js/library/fn/get-iterator":7}],2:[function(require,module,exports){
module.exports = { "default": require("core-js/library/fn/json/stringify"), __esModule: true };
},{"core-js/library/fn/json/stringify":8}],3:[function(require,module,exports){
module.exports = { "default": require("core-js/library/fn/object/keys"), __esModule: true };
},{"core-js/library/fn/object/keys":9}],4:[function(require,module,exports){
module.exports = { "default": require("core-js/library/fn/symbol"), __esModule: true };
},{"core-js/library/fn/symbol":10}],5:[function(require,module,exports){
module.exports = { "default": require("core-js/library/fn/symbol/iterator"), __esModule: true };
},{"core-js/library/fn/symbol/iterator":11}],6:[function(require,module,exports){
"use strict";

exports.__esModule = true;

var _iterator = require("../core-js/symbol/iterator");

var _iterator2 = _interopRequireDefault(_iterator);

var _symbol = require("../core-js/symbol");

var _symbol2 = _interopRequireDefault(_symbol);

var _typeof = typeof _symbol2.default === "function" && typeof _iterator2.default === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof _symbol2.default === "function" && obj.constructor === _symbol2.default ? "symbol" : typeof obj; };

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = typeof _symbol2.default === "function" && _typeof(_iterator2.default) === "symbol" ? function (obj) {
  return typeof obj === "undefined" ? "undefined" : _typeof(obj);
} : function (obj) {
  return obj && typeof _symbol2.default === "function" && obj.constructor === _symbol2.default ? "symbol" : typeof obj === "undefined" ? "undefined" : _typeof(obj);
};
},{"../core-js/symbol":4,"../core-js/symbol/iterator":5}],7:[function(require,module,exports){
require('../modules/web.dom.iterable');
require('../modules/es6.string.iterator');
module.exports = require('../modules/core.get-iterator');
},{"../modules/core.get-iterator":71,"../modules/es6.string.iterator":75,"../modules/web.dom.iterable":79}],8:[function(require,module,exports){
var core  = require('../../modules/_core')
  , $JSON = core.JSON || (core.JSON = {stringify: JSON.stringify});
module.exports = function stringify(it){ // eslint-disable-line no-unused-vars
  return $JSON.stringify.apply($JSON, arguments);
};
},{"../../modules/_core":18}],9:[function(require,module,exports){
require('../../modules/es6.object.keys');
module.exports = require('../../modules/_core').Object.keys;
},{"../../modules/_core":18,"../../modules/es6.object.keys":73}],10:[function(require,module,exports){
require('../../modules/es6.symbol');
require('../../modules/es6.object.to-string');
require('../../modules/es7.symbol.async-iterator');
require('../../modules/es7.symbol.observable');
module.exports = require('../../modules/_core').Symbol;
},{"../../modules/_core":18,"../../modules/es6.object.to-string":74,"../../modules/es6.symbol":76,"../../modules/es7.symbol.async-iterator":77,"../../modules/es7.symbol.observable":78}],11:[function(require,module,exports){
require('../../modules/es6.string.iterator');
require('../../modules/web.dom.iterable');
module.exports = require('../../modules/_wks-ext').f('iterator');
},{"../../modules/_wks-ext":68,"../../modules/es6.string.iterator":75,"../../modules/web.dom.iterable":79}],12:[function(require,module,exports){
module.exports = function(it){
  if(typeof it != 'function')throw TypeError(it + ' is not a function!');
  return it;
};
},{}],13:[function(require,module,exports){
module.exports = function(){ /* empty */ };
},{}],14:[function(require,module,exports){
var isObject = require('./_is-object');
module.exports = function(it){
  if(!isObject(it))throw TypeError(it + ' is not an object!');
  return it;
};
},{"./_is-object":34}],15:[function(require,module,exports){
// false -> Array#indexOf
// true  -> Array#includes
var toIObject = require('./_to-iobject')
  , toLength  = require('./_to-length')
  , toIndex   = require('./_to-index');
module.exports = function(IS_INCLUDES){
  return function($this, el, fromIndex){
    var O      = toIObject($this)
      , length = toLength(O.length)
      , index  = toIndex(fromIndex, length)
      , value;
    // Array#includes uses SameValueZero equality algorithm
    if(IS_INCLUDES && el != el)while(length > index){
      value = O[index++];
      if(value != value)return true;
    // Array#toIndex ignores holes, Array#includes - not
    } else for(;length > index; index++)if(IS_INCLUDES || index in O){
      if(O[index] === el)return IS_INCLUDES || index || 0;
    } return !IS_INCLUDES && -1;
  };
};
},{"./_to-index":60,"./_to-iobject":62,"./_to-length":63}],16:[function(require,module,exports){
// getting tag from 19.1.3.6 Object.prototype.toString()
var cof = require('./_cof')
  , TAG = require('./_wks')('toStringTag')
  // ES3 wrong here
  , ARG = cof(function(){ return arguments; }()) == 'Arguments';

// fallback for IE11 Script Access Denied error
var tryGet = function(it, key){
  try {
    return it[key];
  } catch(e){ /* empty */ }
};

module.exports = function(it){
  var O, T, B;
  return it === undefined ? 'Undefined' : it === null ? 'Null'
    // @@toStringTag case
    : typeof (T = tryGet(O = Object(it), TAG)) == 'string' ? T
    // builtinTag case
    : ARG ? cof(O)
    // ES3 arguments fallback
    : (B = cof(O)) == 'Object' && typeof O.callee == 'function' ? 'Arguments' : B;
};
},{"./_cof":17,"./_wks":69}],17:[function(require,module,exports){
var toString = {}.toString;

module.exports = function(it){
  return toString.call(it).slice(8, -1);
};
},{}],18:[function(require,module,exports){
var core = module.exports = {version: '2.4.0'};
if(typeof __e == 'number')__e = core; // eslint-disable-line no-undef
},{}],19:[function(require,module,exports){
// optional / simple context binding
var aFunction = require('./_a-function');
module.exports = function(fn, that, length){
  aFunction(fn);
  if(that === undefined)return fn;
  switch(length){
    case 1: return function(a){
      return fn.call(that, a);
    };
    case 2: return function(a, b){
      return fn.call(that, a, b);
    };
    case 3: return function(a, b, c){
      return fn.call(that, a, b, c);
    };
  }
  return function(/* ...args */){
    return fn.apply(that, arguments);
  };
};
},{"./_a-function":12}],20:[function(require,module,exports){
// 7.2.1 RequireObjectCoercible(argument)
module.exports = function(it){
  if(it == undefined)throw TypeError("Can't call method on  " + it);
  return it;
};
},{}],21:[function(require,module,exports){
// Thank's IE8 for his funny defineProperty
module.exports = !require('./_fails')(function(){
  return Object.defineProperty({}, 'a', {get: function(){ return 7; }}).a != 7;
});
},{"./_fails":26}],22:[function(require,module,exports){
var isObject = require('./_is-object')
  , document = require('./_global').document
  // in old IE typeof document.createElement is 'object'
  , is = isObject(document) && isObject(document.createElement);
module.exports = function(it){
  return is ? document.createElement(it) : {};
};
},{"./_global":27,"./_is-object":34}],23:[function(require,module,exports){
// IE 8- don't enum bug keys
module.exports = (
  'constructor,hasOwnProperty,isPrototypeOf,propertyIsEnumerable,toLocaleString,toString,valueOf'
).split(',');
},{}],24:[function(require,module,exports){
// all enumerable object keys, includes symbols
var getKeys = require('./_object-keys')
  , gOPS    = require('./_object-gops')
  , pIE     = require('./_object-pie');
module.exports = function(it){
  var result     = getKeys(it)
    , getSymbols = gOPS.f;
  if(getSymbols){
    var symbols = getSymbols(it)
      , isEnum  = pIE.f
      , i       = 0
      , key;
    while(symbols.length > i)if(isEnum.call(it, key = symbols[i++]))result.push(key);
  } return result;
};
},{"./_object-gops":48,"./_object-keys":51,"./_object-pie":52}],25:[function(require,module,exports){
var global    = require('./_global')
  , core      = require('./_core')
  , ctx       = require('./_ctx')
  , hide      = require('./_hide')
  , PROTOTYPE = 'prototype';

var $export = function(type, name, source){
  var IS_FORCED = type & $export.F
    , IS_GLOBAL = type & $export.G
    , IS_STATIC = type & $export.S
    , IS_PROTO  = type & $export.P
    , IS_BIND   = type & $export.B
    , IS_WRAP   = type & $export.W
    , exports   = IS_GLOBAL ? core : core[name] || (core[name] = {})
    , expProto  = exports[PROTOTYPE]
    , target    = IS_GLOBAL ? global : IS_STATIC ? global[name] : (global[name] || {})[PROTOTYPE]
    , key, own, out;
  if(IS_GLOBAL)source = name;
  for(key in source){
    // contains in native
    own = !IS_FORCED && target && target[key] !== undefined;
    if(own && key in exports)continue;
    // export native or passed
    out = own ? target[key] : source[key];
    // prevent global pollution for namespaces
    exports[key] = IS_GLOBAL && typeof target[key] != 'function' ? source[key]
    // bind timers to global for call from export context
    : IS_BIND && own ? ctx(out, global)
    // wrap global constructors for prevent change them in library
    : IS_WRAP && target[key] == out ? (function(C){
      var F = function(a, b, c){
        if(this instanceof C){
          switch(arguments.length){
            case 0: return new C;
            case 1: return new C(a);
            case 2: return new C(a, b);
          } return new C(a, b, c);
        } return C.apply(this, arguments);
      };
      F[PROTOTYPE] = C[PROTOTYPE];
      return F;
    // make static versions for prototype methods
    })(out) : IS_PROTO && typeof out == 'function' ? ctx(Function.call, out) : out;
    // export proto methods to core.%CONSTRUCTOR%.methods.%NAME%
    if(IS_PROTO){
      (exports.virtual || (exports.virtual = {}))[key] = out;
      // export proto methods to core.%CONSTRUCTOR%.prototype.%NAME%
      if(type & $export.R && expProto && !expProto[key])hide(expProto, key, out);
    }
  }
};
// type bitmap
$export.F = 1;   // forced
$export.G = 2;   // global
$export.S = 4;   // static
$export.P = 8;   // proto
$export.B = 16;  // bind
$export.W = 32;  // wrap
$export.U = 64;  // safe
$export.R = 128; // real proto method for `library` 
module.exports = $export;
},{"./_core":18,"./_ctx":19,"./_global":27,"./_hide":29}],26:[function(require,module,exports){
module.exports = function(exec){
  try {
    return !!exec();
  } catch(e){
    return true;
  }
};
},{}],27:[function(require,module,exports){
// https://github.com/zloirock/core-js/issues/86#issuecomment-115759028
var global = module.exports = typeof window != 'undefined' && window.Math == Math
  ? window : typeof self != 'undefined' && self.Math == Math ? self : Function('return this')();
if(typeof __g == 'number')__g = global; // eslint-disable-line no-undef
},{}],28:[function(require,module,exports){
var hasOwnProperty = {}.hasOwnProperty;
module.exports = function(it, key){
  return hasOwnProperty.call(it, key);
};
},{}],29:[function(require,module,exports){
var dP         = require('./_object-dp')
  , createDesc = require('./_property-desc');
module.exports = require('./_descriptors') ? function(object, key, value){
  return dP.f(object, key, createDesc(1, value));
} : function(object, key, value){
  object[key] = value;
  return object;
};
},{"./_descriptors":21,"./_object-dp":43,"./_property-desc":54}],30:[function(require,module,exports){
module.exports = require('./_global').document && document.documentElement;
},{"./_global":27}],31:[function(require,module,exports){
module.exports = !require('./_descriptors') && !require('./_fails')(function(){
  return Object.defineProperty(require('./_dom-create')('div'), 'a', {get: function(){ return 7; }}).a != 7;
});
},{"./_descriptors":21,"./_dom-create":22,"./_fails":26}],32:[function(require,module,exports){
// fallback for non-array-like ES3 and non-enumerable old V8 strings
var cof = require('./_cof');
module.exports = Object('z').propertyIsEnumerable(0) ? Object : function(it){
  return cof(it) == 'String' ? it.split('') : Object(it);
};
},{"./_cof":17}],33:[function(require,module,exports){
// 7.2.2 IsArray(argument)
var cof = require('./_cof');
module.exports = Array.isArray || function isArray(arg){
  return cof(arg) == 'Array';
};
},{"./_cof":17}],34:[function(require,module,exports){
module.exports = function(it){
  return typeof it === 'object' ? it !== null : typeof it === 'function';
};
},{}],35:[function(require,module,exports){
'use strict';
var create         = require('./_object-create')
  , descriptor     = require('./_property-desc')
  , setToStringTag = require('./_set-to-string-tag')
  , IteratorPrototype = {};

// 25.1.2.1.1 %IteratorPrototype%[@@iterator]()
require('./_hide')(IteratorPrototype, require('./_wks')('iterator'), function(){ return this; });

module.exports = function(Constructor, NAME, next){
  Constructor.prototype = create(IteratorPrototype, {next: descriptor(1, next)});
  setToStringTag(Constructor, NAME + ' Iterator');
};
},{"./_hide":29,"./_object-create":42,"./_property-desc":54,"./_set-to-string-tag":56,"./_wks":69}],36:[function(require,module,exports){
'use strict';
var LIBRARY        = require('./_library')
  , $export        = require('./_export')
  , redefine       = require('./_redefine')
  , hide           = require('./_hide')
  , has            = require('./_has')
  , Iterators      = require('./_iterators')
  , $iterCreate    = require('./_iter-create')
  , setToStringTag = require('./_set-to-string-tag')
  , getPrototypeOf = require('./_object-gpo')
  , ITERATOR       = require('./_wks')('iterator')
  , BUGGY          = !([].keys && 'next' in [].keys()) // Safari has buggy iterators w/o `next`
  , FF_ITERATOR    = '@@iterator'
  , KEYS           = 'keys'
  , VALUES         = 'values';

var returnThis = function(){ return this; };

module.exports = function(Base, NAME, Constructor, next, DEFAULT, IS_SET, FORCED){
  $iterCreate(Constructor, NAME, next);
  var getMethod = function(kind){
    if(!BUGGY && kind in proto)return proto[kind];
    switch(kind){
      case KEYS: return function keys(){ return new Constructor(this, kind); };
      case VALUES: return function values(){ return new Constructor(this, kind); };
    } return function entries(){ return new Constructor(this, kind); };
  };
  var TAG        = NAME + ' Iterator'
    , DEF_VALUES = DEFAULT == VALUES
    , VALUES_BUG = false
    , proto      = Base.prototype
    , $native    = proto[ITERATOR] || proto[FF_ITERATOR] || DEFAULT && proto[DEFAULT]
    , $default   = $native || getMethod(DEFAULT)
    , $entries   = DEFAULT ? !DEF_VALUES ? $default : getMethod('entries') : undefined
    , $anyNative = NAME == 'Array' ? proto.entries || $native : $native
    , methods, key, IteratorPrototype;
  // Fix native
  if($anyNative){
    IteratorPrototype = getPrototypeOf($anyNative.call(new Base));
    if(IteratorPrototype !== Object.prototype){
      // Set @@toStringTag to native iterators
      setToStringTag(IteratorPrototype, TAG, true);
      // fix for some old engines
      if(!LIBRARY && !has(IteratorPrototype, ITERATOR))hide(IteratorPrototype, ITERATOR, returnThis);
    }
  }
  // fix Array#{values, @@iterator}.name in V8 / FF
  if(DEF_VALUES && $native && $native.name !== VALUES){
    VALUES_BUG = true;
    $default = function values(){ return $native.call(this); };
  }
  // Define iterator
  if((!LIBRARY || FORCED) && (BUGGY || VALUES_BUG || !proto[ITERATOR])){
    hide(proto, ITERATOR, $default);
  }
  // Plug for library
  Iterators[NAME] = $default;
  Iterators[TAG]  = returnThis;
  if(DEFAULT){
    methods = {
      values:  DEF_VALUES ? $default : getMethod(VALUES),
      keys:    IS_SET     ? $default : getMethod(KEYS),
      entries: $entries
    };
    if(FORCED)for(key in methods){
      if(!(key in proto))redefine(proto, key, methods[key]);
    } else $export($export.P + $export.F * (BUGGY || VALUES_BUG), NAME, methods);
  }
  return methods;
};
},{"./_export":25,"./_has":28,"./_hide":29,"./_iter-create":35,"./_iterators":38,"./_library":40,"./_object-gpo":49,"./_redefine":55,"./_set-to-string-tag":56,"./_wks":69}],37:[function(require,module,exports){
module.exports = function(done, value){
  return {value: value, done: !!done};
};
},{}],38:[function(require,module,exports){
module.exports = {};
},{}],39:[function(require,module,exports){
var getKeys   = require('./_object-keys')
  , toIObject = require('./_to-iobject');
module.exports = function(object, el){
  var O      = toIObject(object)
    , keys   = getKeys(O)
    , length = keys.length
    , index  = 0
    , key;
  while(length > index)if(O[key = keys[index++]] === el)return key;
};
},{"./_object-keys":51,"./_to-iobject":62}],40:[function(require,module,exports){
module.exports = true;
},{}],41:[function(require,module,exports){
var META     = require('./_uid')('meta')
  , isObject = require('./_is-object')
  , has      = require('./_has')
  , setDesc  = require('./_object-dp').f
  , id       = 0;
var isExtensible = Object.isExtensible || function(){
  return true;
};
var FREEZE = !require('./_fails')(function(){
  return isExtensible(Object.preventExtensions({}));
});
var setMeta = function(it){
  setDesc(it, META, {value: {
    i: 'O' + ++id, // object ID
    w: {}          // weak collections IDs
  }});
};
var fastKey = function(it, create){
  // return primitive with prefix
  if(!isObject(it))return typeof it == 'symbol' ? it : (typeof it == 'string' ? 'S' : 'P') + it;
  if(!has(it, META)){
    // can't set metadata to uncaught frozen object
    if(!isExtensible(it))return 'F';
    // not necessary to add metadata
    if(!create)return 'E';
    // add missing metadata
    setMeta(it);
  // return object ID
  } return it[META].i;
};
var getWeak = function(it, create){
  if(!has(it, META)){
    // can't set metadata to uncaught frozen object
    if(!isExtensible(it))return true;
    // not necessary to add metadata
    if(!create)return false;
    // add missing metadata
    setMeta(it);
  // return hash weak collections IDs
  } return it[META].w;
};
// add metadata on freeze-family methods calling
var onFreeze = function(it){
  if(FREEZE && meta.NEED && isExtensible(it) && !has(it, META))setMeta(it);
  return it;
};
var meta = module.exports = {
  KEY:      META,
  NEED:     false,
  fastKey:  fastKey,
  getWeak:  getWeak,
  onFreeze: onFreeze
};
},{"./_fails":26,"./_has":28,"./_is-object":34,"./_object-dp":43,"./_uid":66}],42:[function(require,module,exports){
// 19.1.2.2 / 15.2.3.5 Object.create(O [, Properties])
var anObject    = require('./_an-object')
  , dPs         = require('./_object-dps')
  , enumBugKeys = require('./_enum-bug-keys')
  , IE_PROTO    = require('./_shared-key')('IE_PROTO')
  , Empty       = function(){ /* empty */ }
  , PROTOTYPE   = 'prototype';

// Create object with fake `null` prototype: use iframe Object with cleared prototype
var createDict = function(){
  // Thrash, waste and sodomy: IE GC bug
  var iframe = require('./_dom-create')('iframe')
    , i      = enumBugKeys.length
    , lt     = '<'
    , gt     = '>'
    , iframeDocument;
  iframe.style.display = 'none';
  require('./_html').appendChild(iframe);
  iframe.src = 'javascript:'; // eslint-disable-line no-script-url
  // createDict = iframe.contentWindow.Object;
  // html.removeChild(iframe);
  iframeDocument = iframe.contentWindow.document;
  iframeDocument.open();
  iframeDocument.write(lt + 'script' + gt + 'document.F=Object' + lt + '/script' + gt);
  iframeDocument.close();
  createDict = iframeDocument.F;
  while(i--)delete createDict[PROTOTYPE][enumBugKeys[i]];
  return createDict();
};

module.exports = Object.create || function create(O, Properties){
  var result;
  if(O !== null){
    Empty[PROTOTYPE] = anObject(O);
    result = new Empty;
    Empty[PROTOTYPE] = null;
    // add "__proto__" for Object.getPrototypeOf polyfill
    result[IE_PROTO] = O;
  } else result = createDict();
  return Properties === undefined ? result : dPs(result, Properties);
};

},{"./_an-object":14,"./_dom-create":22,"./_enum-bug-keys":23,"./_html":30,"./_object-dps":44,"./_shared-key":57}],43:[function(require,module,exports){
var anObject       = require('./_an-object')
  , IE8_DOM_DEFINE = require('./_ie8-dom-define')
  , toPrimitive    = require('./_to-primitive')
  , dP             = Object.defineProperty;

exports.f = require('./_descriptors') ? Object.defineProperty : function defineProperty(O, P, Attributes){
  anObject(O);
  P = toPrimitive(P, true);
  anObject(Attributes);
  if(IE8_DOM_DEFINE)try {
    return dP(O, P, Attributes);
  } catch(e){ /* empty */ }
  if('get' in Attributes || 'set' in Attributes)throw TypeError('Accessors not supported!');
  if('value' in Attributes)O[P] = Attributes.value;
  return O;
};
},{"./_an-object":14,"./_descriptors":21,"./_ie8-dom-define":31,"./_to-primitive":65}],44:[function(require,module,exports){
var dP       = require('./_object-dp')
  , anObject = require('./_an-object')
  , getKeys  = require('./_object-keys');

module.exports = require('./_descriptors') ? Object.defineProperties : function defineProperties(O, Properties){
  anObject(O);
  var keys   = getKeys(Properties)
    , length = keys.length
    , i = 0
    , P;
  while(length > i)dP.f(O, P = keys[i++], Properties[P]);
  return O;
};
},{"./_an-object":14,"./_descriptors":21,"./_object-dp":43,"./_object-keys":51}],45:[function(require,module,exports){
var pIE            = require('./_object-pie')
  , createDesc     = require('./_property-desc')
  , toIObject      = require('./_to-iobject')
  , toPrimitive    = require('./_to-primitive')
  , has            = require('./_has')
  , IE8_DOM_DEFINE = require('./_ie8-dom-define')
  , gOPD           = Object.getOwnPropertyDescriptor;

exports.f = require('./_descriptors') ? gOPD : function getOwnPropertyDescriptor(O, P){
  O = toIObject(O);
  P = toPrimitive(P, true);
  if(IE8_DOM_DEFINE)try {
    return gOPD(O, P);
  } catch(e){ /* empty */ }
  if(has(O, P))return createDesc(!pIE.f.call(O, P), O[P]);
};
},{"./_descriptors":21,"./_has":28,"./_ie8-dom-define":31,"./_object-pie":52,"./_property-desc":54,"./_to-iobject":62,"./_to-primitive":65}],46:[function(require,module,exports){
// fallback for IE11 buggy Object.getOwnPropertyNames with iframe and window
var toIObject = require('./_to-iobject')
  , gOPN      = require('./_object-gopn').f
  , toString  = {}.toString;

var windowNames = typeof window == 'object' && window && Object.getOwnPropertyNames
  ? Object.getOwnPropertyNames(window) : [];

var getWindowNames = function(it){
  try {
    return gOPN(it);
  } catch(e){
    return windowNames.slice();
  }
};

module.exports.f = function getOwnPropertyNames(it){
  return windowNames && toString.call(it) == '[object Window]' ? getWindowNames(it) : gOPN(toIObject(it));
};

},{"./_object-gopn":47,"./_to-iobject":62}],47:[function(require,module,exports){
// 19.1.2.7 / 15.2.3.4 Object.getOwnPropertyNames(O)
var $keys      = require('./_object-keys-internal')
  , hiddenKeys = require('./_enum-bug-keys').concat('length', 'prototype');

exports.f = Object.getOwnPropertyNames || function getOwnPropertyNames(O){
  return $keys(O, hiddenKeys);
};
},{"./_enum-bug-keys":23,"./_object-keys-internal":50}],48:[function(require,module,exports){
exports.f = Object.getOwnPropertySymbols;
},{}],49:[function(require,module,exports){
// 19.1.2.9 / 15.2.3.2 Object.getPrototypeOf(O)
var has         = require('./_has')
  , toObject    = require('./_to-object')
  , IE_PROTO    = require('./_shared-key')('IE_PROTO')
  , ObjectProto = Object.prototype;

module.exports = Object.getPrototypeOf || function(O){
  O = toObject(O);
  if(has(O, IE_PROTO))return O[IE_PROTO];
  if(typeof O.constructor == 'function' && O instanceof O.constructor){
    return O.constructor.prototype;
  } return O instanceof Object ? ObjectProto : null;
};
},{"./_has":28,"./_shared-key":57,"./_to-object":64}],50:[function(require,module,exports){
var has          = require('./_has')
  , toIObject    = require('./_to-iobject')
  , arrayIndexOf = require('./_array-includes')(false)
  , IE_PROTO     = require('./_shared-key')('IE_PROTO');

module.exports = function(object, names){
  var O      = toIObject(object)
    , i      = 0
    , result = []
    , key;
  for(key in O)if(key != IE_PROTO)has(O, key) && result.push(key);
  // Don't enum bug & hidden keys
  while(names.length > i)if(has(O, key = names[i++])){
    ~arrayIndexOf(result, key) || result.push(key);
  }
  return result;
};
},{"./_array-includes":15,"./_has":28,"./_shared-key":57,"./_to-iobject":62}],51:[function(require,module,exports){
// 19.1.2.14 / 15.2.3.14 Object.keys(O)
var $keys       = require('./_object-keys-internal')
  , enumBugKeys = require('./_enum-bug-keys');

module.exports = Object.keys || function keys(O){
  return $keys(O, enumBugKeys);
};
},{"./_enum-bug-keys":23,"./_object-keys-internal":50}],52:[function(require,module,exports){
exports.f = {}.propertyIsEnumerable;
},{}],53:[function(require,module,exports){
// most Object methods by ES6 should accept primitives
var $export = require('./_export')
  , core    = require('./_core')
  , fails   = require('./_fails');
module.exports = function(KEY, exec){
  var fn  = (core.Object || {})[KEY] || Object[KEY]
    , exp = {};
  exp[KEY] = exec(fn);
  $export($export.S + $export.F * fails(function(){ fn(1); }), 'Object', exp);
};
},{"./_core":18,"./_export":25,"./_fails":26}],54:[function(require,module,exports){
module.exports = function(bitmap, value){
  return {
    enumerable  : !(bitmap & 1),
    configurable: !(bitmap & 2),
    writable    : !(bitmap & 4),
    value       : value
  };
};
},{}],55:[function(require,module,exports){
module.exports = require('./_hide');
},{"./_hide":29}],56:[function(require,module,exports){
var def = require('./_object-dp').f
  , has = require('./_has')
  , TAG = require('./_wks')('toStringTag');

module.exports = function(it, tag, stat){
  if(it && !has(it = stat ? it : it.prototype, TAG))def(it, TAG, {configurable: true, value: tag});
};
},{"./_has":28,"./_object-dp":43,"./_wks":69}],57:[function(require,module,exports){
var shared = require('./_shared')('keys')
  , uid    = require('./_uid');
module.exports = function(key){
  return shared[key] || (shared[key] = uid(key));
};
},{"./_shared":58,"./_uid":66}],58:[function(require,module,exports){
var global = require('./_global')
  , SHARED = '__core-js_shared__'
  , store  = global[SHARED] || (global[SHARED] = {});
module.exports = function(key){
  return store[key] || (store[key] = {});
};
},{"./_global":27}],59:[function(require,module,exports){
var toInteger = require('./_to-integer')
  , defined   = require('./_defined');
// true  -> String#at
// false -> String#codePointAt
module.exports = function(TO_STRING){
  return function(that, pos){
    var s = String(defined(that))
      , i = toInteger(pos)
      , l = s.length
      , a, b;
    if(i < 0 || i >= l)return TO_STRING ? '' : undefined;
    a = s.charCodeAt(i);
    return a < 0xd800 || a > 0xdbff || i + 1 === l || (b = s.charCodeAt(i + 1)) < 0xdc00 || b > 0xdfff
      ? TO_STRING ? s.charAt(i) : a
      : TO_STRING ? s.slice(i, i + 2) : (a - 0xd800 << 10) + (b - 0xdc00) + 0x10000;
  };
};
},{"./_defined":20,"./_to-integer":61}],60:[function(require,module,exports){
var toInteger = require('./_to-integer')
  , max       = Math.max
  , min       = Math.min;
module.exports = function(index, length){
  index = toInteger(index);
  return index < 0 ? max(index + length, 0) : min(index, length);
};
},{"./_to-integer":61}],61:[function(require,module,exports){
// 7.1.4 ToInteger
var ceil  = Math.ceil
  , floor = Math.floor;
module.exports = function(it){
  return isNaN(it = +it) ? 0 : (it > 0 ? floor : ceil)(it);
};
},{}],62:[function(require,module,exports){
// to indexed object, toObject with fallback for non-array-like ES3 strings
var IObject = require('./_iobject')
  , defined = require('./_defined');
module.exports = function(it){
  return IObject(defined(it));
};
},{"./_defined":20,"./_iobject":32}],63:[function(require,module,exports){
// 7.1.15 ToLength
var toInteger = require('./_to-integer')
  , min       = Math.min;
module.exports = function(it){
  return it > 0 ? min(toInteger(it), 0x1fffffffffffff) : 0; // pow(2, 53) - 1 == 9007199254740991
};
},{"./_to-integer":61}],64:[function(require,module,exports){
// 7.1.13 ToObject(argument)
var defined = require('./_defined');
module.exports = function(it){
  return Object(defined(it));
};
},{"./_defined":20}],65:[function(require,module,exports){
// 7.1.1 ToPrimitive(input [, PreferredType])
var isObject = require('./_is-object');
// instead of the ES6 spec version, we didn't implement @@toPrimitive case
// and the second argument - flag - preferred type is a string
module.exports = function(it, S){
  if(!isObject(it))return it;
  var fn, val;
  if(S && typeof (fn = it.toString) == 'function' && !isObject(val = fn.call(it)))return val;
  if(typeof (fn = it.valueOf) == 'function' && !isObject(val = fn.call(it)))return val;
  if(!S && typeof (fn = it.toString) == 'function' && !isObject(val = fn.call(it)))return val;
  throw TypeError("Can't convert object to primitive value");
};
},{"./_is-object":34}],66:[function(require,module,exports){
var id = 0
  , px = Math.random();
module.exports = function(key){
  return 'Symbol('.concat(key === undefined ? '' : key, ')_', (++id + px).toString(36));
};
},{}],67:[function(require,module,exports){
var global         = require('./_global')
  , core           = require('./_core')
  , LIBRARY        = require('./_library')
  , wksExt         = require('./_wks-ext')
  , defineProperty = require('./_object-dp').f;
module.exports = function(name){
  var $Symbol = core.Symbol || (core.Symbol = LIBRARY ? {} : global.Symbol || {});
  if(name.charAt(0) != '_' && !(name in $Symbol))defineProperty($Symbol, name, {value: wksExt.f(name)});
};
},{"./_core":18,"./_global":27,"./_library":40,"./_object-dp":43,"./_wks-ext":68}],68:[function(require,module,exports){
exports.f = require('./_wks');
},{"./_wks":69}],69:[function(require,module,exports){
var store      = require('./_shared')('wks')
  , uid        = require('./_uid')
  , Symbol     = require('./_global').Symbol
  , USE_SYMBOL = typeof Symbol == 'function';

var $exports = module.exports = function(name){
  return store[name] || (store[name] =
    USE_SYMBOL && Symbol[name] || (USE_SYMBOL ? Symbol : uid)('Symbol.' + name));
};

$exports.store = store;
},{"./_global":27,"./_shared":58,"./_uid":66}],70:[function(require,module,exports){
var classof   = require('./_classof')
  , ITERATOR  = require('./_wks')('iterator')
  , Iterators = require('./_iterators');
module.exports = require('./_core').getIteratorMethod = function(it){
  if(it != undefined)return it[ITERATOR]
    || it['@@iterator']
    || Iterators[classof(it)];
};
},{"./_classof":16,"./_core":18,"./_iterators":38,"./_wks":69}],71:[function(require,module,exports){
var anObject = require('./_an-object')
  , get      = require('./core.get-iterator-method');
module.exports = require('./_core').getIterator = function(it){
  var iterFn = get(it);
  if(typeof iterFn != 'function')throw TypeError(it + ' is not iterable!');
  return anObject(iterFn.call(it));
};
},{"./_an-object":14,"./_core":18,"./core.get-iterator-method":70}],72:[function(require,module,exports){
'use strict';
var addToUnscopables = require('./_add-to-unscopables')
  , step             = require('./_iter-step')
  , Iterators        = require('./_iterators')
  , toIObject        = require('./_to-iobject');

// 22.1.3.4 Array.prototype.entries()
// 22.1.3.13 Array.prototype.keys()
// 22.1.3.29 Array.prototype.values()
// 22.1.3.30 Array.prototype[@@iterator]()
module.exports = require('./_iter-define')(Array, 'Array', function(iterated, kind){
  this._t = toIObject(iterated); // target
  this._i = 0;                   // next index
  this._k = kind;                // kind
// 22.1.5.2.1 %ArrayIteratorPrototype%.next()
}, function(){
  var O     = this._t
    , kind  = this._k
    , index = this._i++;
  if(!O || index >= O.length){
    this._t = undefined;
    return step(1);
  }
  if(kind == 'keys'  )return step(0, index);
  if(kind == 'values')return step(0, O[index]);
  return step(0, [index, O[index]]);
}, 'values');

// argumentsList[@@iterator] is %ArrayProto_values% (9.4.4.6, 9.4.4.7)
Iterators.Arguments = Iterators.Array;

addToUnscopables('keys');
addToUnscopables('values');
addToUnscopables('entries');
},{"./_add-to-unscopables":13,"./_iter-define":36,"./_iter-step":37,"./_iterators":38,"./_to-iobject":62}],73:[function(require,module,exports){
// 19.1.2.14 Object.keys(O)
var toObject = require('./_to-object')
  , $keys    = require('./_object-keys');

require('./_object-sap')('keys', function(){
  return function keys(it){
    return $keys(toObject(it));
  };
});
},{"./_object-keys":51,"./_object-sap":53,"./_to-object":64}],74:[function(require,module,exports){

},{}],75:[function(require,module,exports){
'use strict';
var $at  = require('./_string-at')(true);

// 21.1.3.27 String.prototype[@@iterator]()
require('./_iter-define')(String, 'String', function(iterated){
  this._t = String(iterated); // target
  this._i = 0;                // next index
// 21.1.5.2.1 %StringIteratorPrototype%.next()
}, function(){
  var O     = this._t
    , index = this._i
    , point;
  if(index >= O.length)return {value: undefined, done: true};
  point = $at(O, index);
  this._i += point.length;
  return {value: point, done: false};
});
},{"./_iter-define":36,"./_string-at":59}],76:[function(require,module,exports){
'use strict';
// ECMAScript 6 symbols shim
var global         = require('./_global')
  , has            = require('./_has')
  , DESCRIPTORS    = require('./_descriptors')
  , $export        = require('./_export')
  , redefine       = require('./_redefine')
  , META           = require('./_meta').KEY
  , $fails         = require('./_fails')
  , shared         = require('./_shared')
  , setToStringTag = require('./_set-to-string-tag')
  , uid            = require('./_uid')
  , wks            = require('./_wks')
  , wksExt         = require('./_wks-ext')
  , wksDefine      = require('./_wks-define')
  , keyOf          = require('./_keyof')
  , enumKeys       = require('./_enum-keys')
  , isArray        = require('./_is-array')
  , anObject       = require('./_an-object')
  , toIObject      = require('./_to-iobject')
  , toPrimitive    = require('./_to-primitive')
  , createDesc     = require('./_property-desc')
  , _create        = require('./_object-create')
  , gOPNExt        = require('./_object-gopn-ext')
  , $GOPD          = require('./_object-gopd')
  , $DP            = require('./_object-dp')
  , $keys          = require('./_object-keys')
  , gOPD           = $GOPD.f
  , dP             = $DP.f
  , gOPN           = gOPNExt.f
  , $Symbol        = global.Symbol
  , $JSON          = global.JSON
  , _stringify     = $JSON && $JSON.stringify
  , PROTOTYPE      = 'prototype'
  , HIDDEN         = wks('_hidden')
  , TO_PRIMITIVE   = wks('toPrimitive')
  , isEnum         = {}.propertyIsEnumerable
  , SymbolRegistry = shared('symbol-registry')
  , AllSymbols     = shared('symbols')
  , OPSymbols      = shared('op-symbols')
  , ObjectProto    = Object[PROTOTYPE]
  , USE_NATIVE     = typeof $Symbol == 'function'
  , QObject        = global.QObject;
// Don't use setters in Qt Script, https://github.com/zloirock/core-js/issues/173
var setter = !QObject || !QObject[PROTOTYPE] || !QObject[PROTOTYPE].findChild;

// fallback for old Android, https://code.google.com/p/v8/issues/detail?id=687
var setSymbolDesc = DESCRIPTORS && $fails(function(){
  return _create(dP({}, 'a', {
    get: function(){ return dP(this, 'a', {value: 7}).a; }
  })).a != 7;
}) ? function(it, key, D){
  var protoDesc = gOPD(ObjectProto, key);
  if(protoDesc)delete ObjectProto[key];
  dP(it, key, D);
  if(protoDesc && it !== ObjectProto)dP(ObjectProto, key, protoDesc);
} : dP;

var wrap = function(tag){
  var sym = AllSymbols[tag] = _create($Symbol[PROTOTYPE]);
  sym._k = tag;
  return sym;
};

var isSymbol = USE_NATIVE && typeof $Symbol.iterator == 'symbol' ? function(it){
  return typeof it == 'symbol';
} : function(it){
  return it instanceof $Symbol;
};

var $defineProperty = function defineProperty(it, key, D){
  if(it === ObjectProto)$defineProperty(OPSymbols, key, D);
  anObject(it);
  key = toPrimitive(key, true);
  anObject(D);
  if(has(AllSymbols, key)){
    if(!D.enumerable){
      if(!has(it, HIDDEN))dP(it, HIDDEN, createDesc(1, {}));
      it[HIDDEN][key] = true;
    } else {
      if(has(it, HIDDEN) && it[HIDDEN][key])it[HIDDEN][key] = false;
      D = _create(D, {enumerable: createDesc(0, false)});
    } return setSymbolDesc(it, key, D);
  } return dP(it, key, D);
};
var $defineProperties = function defineProperties(it, P){
  anObject(it);
  var keys = enumKeys(P = toIObject(P))
    , i    = 0
    , l = keys.length
    , key;
  while(l > i)$defineProperty(it, key = keys[i++], P[key]);
  return it;
};
var $create = function create(it, P){
  return P === undefined ? _create(it) : $defineProperties(_create(it), P);
};
var $propertyIsEnumerable = function propertyIsEnumerable(key){
  var E = isEnum.call(this, key = toPrimitive(key, true));
  if(this === ObjectProto && has(AllSymbols, key) && !has(OPSymbols, key))return false;
  return E || !has(this, key) || !has(AllSymbols, key) || has(this, HIDDEN) && this[HIDDEN][key] ? E : true;
};
var $getOwnPropertyDescriptor = function getOwnPropertyDescriptor(it, key){
  it  = toIObject(it);
  key = toPrimitive(key, true);
  if(it === ObjectProto && has(AllSymbols, key) && !has(OPSymbols, key))return;
  var D = gOPD(it, key);
  if(D && has(AllSymbols, key) && !(has(it, HIDDEN) && it[HIDDEN][key]))D.enumerable = true;
  return D;
};
var $getOwnPropertyNames = function getOwnPropertyNames(it){
  var names  = gOPN(toIObject(it))
    , result = []
    , i      = 0
    , key;
  while(names.length > i){
    if(!has(AllSymbols, key = names[i++]) && key != HIDDEN && key != META)result.push(key);
  } return result;
};
var $getOwnPropertySymbols = function getOwnPropertySymbols(it){
  var IS_OP  = it === ObjectProto
    , names  = gOPN(IS_OP ? OPSymbols : toIObject(it))
    , result = []
    , i      = 0
    , key;
  while(names.length > i){
    if(has(AllSymbols, key = names[i++]) && (IS_OP ? has(ObjectProto, key) : true))result.push(AllSymbols[key]);
  } return result;
};

// 19.4.1.1 Symbol([description])
if(!USE_NATIVE){
  $Symbol = function Symbol(){
    if(this instanceof $Symbol)throw TypeError('Symbol is not a constructor!');
    var tag = uid(arguments.length > 0 ? arguments[0] : undefined);
    var $set = function(value){
      if(this === ObjectProto)$set.call(OPSymbols, value);
      if(has(this, HIDDEN) && has(this[HIDDEN], tag))this[HIDDEN][tag] = false;
      setSymbolDesc(this, tag, createDesc(1, value));
    };
    if(DESCRIPTORS && setter)setSymbolDesc(ObjectProto, tag, {configurable: true, set: $set});
    return wrap(tag);
  };
  redefine($Symbol[PROTOTYPE], 'toString', function toString(){
    return this._k;
  });

  $GOPD.f = $getOwnPropertyDescriptor;
  $DP.f   = $defineProperty;
  require('./_object-gopn').f = gOPNExt.f = $getOwnPropertyNames;
  require('./_object-pie').f  = $propertyIsEnumerable;
  require('./_object-gops').f = $getOwnPropertySymbols;

  if(DESCRIPTORS && !require('./_library')){
    redefine(ObjectProto, 'propertyIsEnumerable', $propertyIsEnumerable, true);
  }

  wksExt.f = function(name){
    return wrap(wks(name));
  }
}

$export($export.G + $export.W + $export.F * !USE_NATIVE, {Symbol: $Symbol});

for(var symbols = (
  // 19.4.2.2, 19.4.2.3, 19.4.2.4, 19.4.2.6, 19.4.2.8, 19.4.2.9, 19.4.2.10, 19.4.2.11, 19.4.2.12, 19.4.2.13, 19.4.2.14
  'hasInstance,isConcatSpreadable,iterator,match,replace,search,species,split,toPrimitive,toStringTag,unscopables'
).split(','), i = 0; symbols.length > i; )wks(symbols[i++]);

for(var symbols = $keys(wks.store), i = 0; symbols.length > i; )wksDefine(symbols[i++]);

$export($export.S + $export.F * !USE_NATIVE, 'Symbol', {
  // 19.4.2.1 Symbol.for(key)
  'for': function(key){
    return has(SymbolRegistry, key += '')
      ? SymbolRegistry[key]
      : SymbolRegistry[key] = $Symbol(key);
  },
  // 19.4.2.5 Symbol.keyFor(sym)
  keyFor: function keyFor(key){
    if(isSymbol(key))return keyOf(SymbolRegistry, key);
    throw TypeError(key + ' is not a symbol!');
  },
  useSetter: function(){ setter = true; },
  useSimple: function(){ setter = false; }
});

$export($export.S + $export.F * !USE_NATIVE, 'Object', {
  // 19.1.2.2 Object.create(O [, Properties])
  create: $create,
  // 19.1.2.4 Object.defineProperty(O, P, Attributes)
  defineProperty: $defineProperty,
  // 19.1.2.3 Object.defineProperties(O, Properties)
  defineProperties: $defineProperties,
  // 19.1.2.6 Object.getOwnPropertyDescriptor(O, P)
  getOwnPropertyDescriptor: $getOwnPropertyDescriptor,
  // 19.1.2.7 Object.getOwnPropertyNames(O)
  getOwnPropertyNames: $getOwnPropertyNames,
  // 19.1.2.8 Object.getOwnPropertySymbols(O)
  getOwnPropertySymbols: $getOwnPropertySymbols
});

// 24.3.2 JSON.stringify(value [, replacer [, space]])
$JSON && $export($export.S + $export.F * (!USE_NATIVE || $fails(function(){
  var S = $Symbol();
  // MS Edge converts symbol values to JSON as {}
  // WebKit converts symbol values to JSON as null
  // V8 throws on boxed symbols
  return _stringify([S]) != '[null]' || _stringify({a: S}) != '{}' || _stringify(Object(S)) != '{}';
})), 'JSON', {
  stringify: function stringify(it){
    if(it === undefined || isSymbol(it))return; // IE8 returns string on undefined
    var args = [it]
      , i    = 1
      , replacer, $replacer;
    while(arguments.length > i)args.push(arguments[i++]);
    replacer = args[1];
    if(typeof replacer == 'function')$replacer = replacer;
    if($replacer || !isArray(replacer))replacer = function(key, value){
      if($replacer)value = $replacer.call(this, key, value);
      if(!isSymbol(value))return value;
    };
    args[1] = replacer;
    return _stringify.apply($JSON, args);
  }
});

// 19.4.3.4 Symbol.prototype[@@toPrimitive](hint)
$Symbol[PROTOTYPE][TO_PRIMITIVE] || require('./_hide')($Symbol[PROTOTYPE], TO_PRIMITIVE, $Symbol[PROTOTYPE].valueOf);
// 19.4.3.5 Symbol.prototype[@@toStringTag]
setToStringTag($Symbol, 'Symbol');
// 20.2.1.9 Math[@@toStringTag]
setToStringTag(Math, 'Math', true);
// 24.3.3 JSON[@@toStringTag]
setToStringTag(global.JSON, 'JSON', true);
},{"./_an-object":14,"./_descriptors":21,"./_enum-keys":24,"./_export":25,"./_fails":26,"./_global":27,"./_has":28,"./_hide":29,"./_is-array":33,"./_keyof":39,"./_library":40,"./_meta":41,"./_object-create":42,"./_object-dp":43,"./_object-gopd":45,"./_object-gopn":47,"./_object-gopn-ext":46,"./_object-gops":48,"./_object-keys":51,"./_object-pie":52,"./_property-desc":54,"./_redefine":55,"./_set-to-string-tag":56,"./_shared":58,"./_to-iobject":62,"./_to-primitive":65,"./_uid":66,"./_wks":69,"./_wks-define":67,"./_wks-ext":68}],77:[function(require,module,exports){
require('./_wks-define')('asyncIterator');
},{"./_wks-define":67}],78:[function(require,module,exports){
require('./_wks-define')('observable');
},{"./_wks-define":67}],79:[function(require,module,exports){
require('./es6.array.iterator');
var global        = require('./_global')
  , hide          = require('./_hide')
  , Iterators     = require('./_iterators')
  , TO_STRING_TAG = require('./_wks')('toStringTag');

for(var collections = ['NodeList', 'DOMTokenList', 'MediaList', 'StyleSheetList', 'CSSRuleList'], i = 0; i < 5; i++){
  var NAME       = collections[i]
    , Collection = global[NAME]
    , proto      = Collection && Collection.prototype;
  if(proto && !proto[TO_STRING_TAG])hide(proto, TO_STRING_TAG, NAME);
  Iterators[NAME] = Iterators.Array;
}
},{"./_global":27,"./_hide":29,"./_iterators":38,"./_wks":69,"./es6.array.iterator":72}],80:[function(require,module,exports){
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

},{}],81:[function(require,module,exports){
var asyncGenerator = function () {
  function AwaitValue(value) {
    this.value = value;
  }

  function AsyncGenerator(gen) {
    var front, back;

    function send(key, arg) {
      return new Promise(function (resolve, reject) {
        var request = {
          key: key,
          arg: arg,
          resolve: resolve,
          reject: reject,
          next: null
        };

        if (back) {
          back = back.next = request;
        } else {
          front = back = request;
          resume(key, arg);
        }
      });
    }

    function resume(key, arg) {
      try {
        var result = gen[key](arg);
        var value = result.value;

        if (value instanceof AwaitValue) {
          Promise.resolve(value.value).then(function (arg) {
            resume("next", arg);
          }, function (arg) {
            resume("throw", arg);
          });
        } else {
          settle(result.done ? "return" : "normal", result.value);
        }
      } catch (err) {
        settle("throw", err);
      }
    }

    function settle(type, value) {
      switch (type) {
        case "return":
          front.resolve({
            value: value,
            done: true
          });
          break;

        case "throw":
          front.reject(value);
          break;

        default:
          front.resolve({
            value: value,
            done: false
          });
          break;
      }

      front = front.next;

      if (front) {
        resume(front.key, front.arg);
      } else {
        back = null;
      }
    }

    this._invoke = send;

    if (typeof gen.return !== "function") {
      this.return = undefined;
    }
  }

  if (typeof Symbol === "function" && Symbol.asyncIterator) {
    AsyncGenerator.prototype[Symbol.asyncIterator] = function () {
      return this;
    };
  }

  AsyncGenerator.prototype.next = function (arg) {
    return this._invoke("next", arg);
  };

  AsyncGenerator.prototype.throw = function (arg) {
    return this._invoke("throw", arg);
  };

  AsyncGenerator.prototype.return = function (arg) {
    return this._invoke("return", arg);
  };

  return {
    wrap: function (fn) {
      return function () {
        return new AsyncGenerator(fn.apply(this, arguments));
      };
    },
    await: function (value) {
      return new AwaitValue(value);
    }
  };
}();

var classCallCheck = function (instance, Constructor) {
  if (!(instance instanceof Constructor)) {
    throw new TypeError("Cannot call a class as a function");
  }
};

var createClass = function () {
  function defineProperties(target, props) {
    for (var i = 0; i < props.length; i++) {
      var descriptor = props[i];
      descriptor.enumerable = descriptor.enumerable || false;
      descriptor.configurable = true;
      if ("value" in descriptor) descriptor.writable = true;
      Object.defineProperty(target, descriptor.key, descriptor);
    }
  }

  return function (Constructor, protoProps, staticProps) {
    if (protoProps) defineProperties(Constructor.prototype, protoProps);
    if (staticProps) defineProperties(Constructor, staticProps);
    return Constructor;
  };
}();

var _extends = Object.assign || function (target) {
  for (var i = 1; i < arguments.length; i++) {
    var source = arguments[i];

    for (var key in source) {
      if (Object.prototype.hasOwnProperty.call(source, key)) {
        target[key] = source[key];
      }
    }
  }

  return target;
};

var inherits = function (subClass, superClass) {
  if (typeof superClass !== "function" && superClass !== null) {
    throw new TypeError("Super expression must either be null or a function, not " + typeof superClass);
  }

  subClass.prototype = Object.create(superClass && superClass.prototype, {
    constructor: {
      value: subClass,
      enumerable: false,
      writable: true,
      configurable: true
    }
  });
  if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass;
};

var possibleConstructorReturn = function (self, call) {
  if (!self) {
    throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
  }

  return call && (typeof call === "object" || typeof call === "function") ? call : self;
};

var Connector = function () {
    function Connector(options) {
        classCallCheck(this, Connector);

        this._defaultOptions = {
            auth: {
                headers: {}
            },
            authEndpoint: '/broadcasting/auth',
            broadcaster: 'pusher',
            csrfToken: null,
            host: null,
            key: null,
            namespace: 'App.Events'
        };
        this.setOptions(options);
        this.connect();
    }

    createClass(Connector, [{
        key: 'setOptions',
        value: function setOptions(options) {
            this.options = _extends(this._defaultOptions, options);
            if (this.csrfToken()) {
                this.options.auth.headers['X-CSRF-TOKEN'] = this.csrfToken();
            }
            return options;
        }
    }, {
        key: 'csrfToken',
        value: function csrfToken() {
            var selector = void 0;
            if (window && window['Laravel'] && window['Laravel'].csrfToken) {
                return window['Laravel'].csrfToken;
            } else if (this.options.csrfToken) {
                return this.options.csrfToken;
            } else if (document && (selector = document.querySelector('meta[name="csrf-token"]'))) {
                return selector.getAttribute('content');
            }
            return null;
        }
    }]);
    return Connector;
}();

var Channel = function () {
    function Channel() {
        classCallCheck(this, Channel);
    }

    createClass(Channel, [{
        key: 'notification',
        value: function notification(callback) {
            return this.listen('.Illuminate.Notifications.Events.BroadcastNotificationCreated', callback);
        }
    }, {
        key: 'listenForWhisper',
        value: function listenForWhisper(event, callback) {
            return this.listen('.client-' + event, callback);
        }
    }]);
    return Channel;
}();

var EventFormatter = function () {
    function EventFormatter(namespace) {
        classCallCheck(this, EventFormatter);

        this.setNamespace(namespace);
    }

    createClass(EventFormatter, [{
        key: 'format',
        value: function format(event) {
            if (this.namespace) {
                if (event.charAt(0) != '\\' && event.charAt(0) != '.') {
                    event = this.namespace + '.' + event;
                } else {
                    event = event.substr(1);
                }
            }
            return event.replace(/\./g, '\\');
        }
    }, {
        key: 'setNamespace',
        value: function setNamespace(value) {
            this.namespace = value;
        }
    }]);
    return EventFormatter;
}();

var PusherChannel = function (_Channel) {
    inherits(PusherChannel, _Channel);

    function PusherChannel(pusher, name, options) {
        classCallCheck(this, PusherChannel);

        var _this = possibleConstructorReturn(this, (PusherChannel.__proto__ || Object.getPrototypeOf(PusherChannel)).call(this));

        _this.name = name;
        _this.pusher = pusher;
        _this.options = options;
        _this.eventFormatter = new EventFormatter(_this.options.namespace);
        _this.subscribe();
        return _this;
    }

    createClass(PusherChannel, [{
        key: 'subscribe',
        value: function subscribe() {
            this.subscription = this.pusher.subscribe(this.name);
        }
    }, {
        key: 'unsubscribe',
        value: function unsubscribe() {
            this.pusher.unsubscribe(this.name);
        }
    }, {
        key: 'listen',
        value: function listen(event, callback) {
            this.on(this.eventFormatter.format(event), callback);
            return this;
        }
    }, {
        key: 'stopListening',
        value: function stopListening(event) {
            this.subscription.unbind(this.eventFormatter.format(event));
            return this;
        }
    }, {
        key: 'on',
        value: function on(event, callback) {
            this.subscription.bind(event, callback);
            return this;
        }
    }]);
    return PusherChannel;
}(Channel);

var PusherPrivateChannel = function (_PusherChannel) {
    inherits(PusherPrivateChannel, _PusherChannel);

    function PusherPrivateChannel() {
        classCallCheck(this, PusherPrivateChannel);
        return possibleConstructorReturn(this, (PusherPrivateChannel.__proto__ || Object.getPrototypeOf(PusherPrivateChannel)).apply(this, arguments));
    }

    createClass(PusherPrivateChannel, [{
        key: 'whisper',
        value: function whisper(eventName, data) {
            this.pusher.channels.channels[this.name].trigger('client-' + eventName, data);
            return this;
        }
    }]);
    return PusherPrivateChannel;
}(PusherChannel);

var PusherPresenceChannel = function (_PusherChannel) {
    inherits(PusherPresenceChannel, _PusherChannel);

    function PusherPresenceChannel() {
        classCallCheck(this, PusherPresenceChannel);
        return possibleConstructorReturn(this, (PusherPresenceChannel.__proto__ || Object.getPrototypeOf(PusherPresenceChannel)).apply(this, arguments));
    }

    createClass(PusherPresenceChannel, [{
        key: 'here',
        value: function here(callback) {
            this.on('pusher:subscription_succeeded', function (data) {
                callback(Object.keys(data.members).map(function (k) {
                    return data.members[k];
                }));
            });
            return this;
        }
    }, {
        key: 'joining',
        value: function joining(callback) {
            this.on('pusher:member_added', function (member) {
                callback(member.info);
            });
            return this;
        }
    }, {
        key: 'leaving',
        value: function leaving(callback) {
            this.on('pusher:member_removed', function (member) {
                callback(member.info);
            });
            return this;
        }
    }, {
        key: 'whisper',
        value: function whisper(eventName, data) {
            this.pusher.channels.channels[this.name].trigger('client-' + eventName, data);
            return this;
        }
    }]);
    return PusherPresenceChannel;
}(PusherChannel);

var SocketIoChannel = function (_Channel) {
    inherits(SocketIoChannel, _Channel);

    function SocketIoChannel(socket, name, options) {
        classCallCheck(this, SocketIoChannel);

        var _this = possibleConstructorReturn(this, (SocketIoChannel.__proto__ || Object.getPrototypeOf(SocketIoChannel)).call(this));

        _this.events = {};
        _this.name = name;
        _this.socket = socket;
        _this.options = options;
        _this.eventFormatter = new EventFormatter(_this.options.namespace);
        _this.subscribe();
        _this.configureReconnector();
        return _this;
    }

    createClass(SocketIoChannel, [{
        key: 'subscribe',
        value: function subscribe() {
            this.socket.emit('subscribe', {
                channel: this.name,
                auth: this.options.auth || {}
            });
        }
    }, {
        key: 'unsubscribe',
        value: function unsubscribe() {
            this.unbind();
            this.socket.emit('unsubscribe', {
                channel: this.name,
                auth: this.options.auth || {}
            });
        }
    }, {
        key: 'listen',
        value: function listen(event, callback) {
            this.on(this.eventFormatter.format(event), callback);
            return this;
        }
    }, {
        key: 'on',
        value: function on(event, callback) {
            var _this2 = this;

            var listener = function listener(channel, data) {
                if (_this2.name == channel) {
                    callback(data);
                }
            };
            this.socket.on(event, listener);
            this.bind(event, listener);
        }
    }, {
        key: 'configureReconnector',
        value: function configureReconnector() {
            var _this3 = this;

            var listener = function listener() {
                _this3.subscribe();
            };
            this.socket.on('reconnect', listener);
            this.bind('reconnect', listener);
        }
    }, {
        key: 'bind',
        value: function bind(event, callback) {
            this.events[event] = this.events[event] || [];
            this.events[event].push(callback);
        }
    }, {
        key: 'unbind',
        value: function unbind() {
            var _this4 = this;

            Object.keys(this.events).forEach(function (event) {
                _this4.events[event].forEach(function (callback) {
                    _this4.socket.removeListener(event, callback);
                });
                delete _this4.events[event];
            });
        }
    }]);
    return SocketIoChannel;
}(Channel);

var SocketIoPrivateChannel = function (_SocketIoChannel) {
    inherits(SocketIoPrivateChannel, _SocketIoChannel);

    function SocketIoPrivateChannel() {
        classCallCheck(this, SocketIoPrivateChannel);
        return possibleConstructorReturn(this, (SocketIoPrivateChannel.__proto__ || Object.getPrototypeOf(SocketIoPrivateChannel)).apply(this, arguments));
    }

    createClass(SocketIoPrivateChannel, [{
        key: 'whisper',
        value: function whisper(eventName, data) {
            this.socket.emit('client event', {
                channel: this.name,
                event: 'client-' + eventName,
                data: data
            });
            return this;
        }
    }]);
    return SocketIoPrivateChannel;
}(SocketIoChannel);

var SocketIoPresenceChannel = function (_SocketIoPrivateChann) {
    inherits(SocketIoPresenceChannel, _SocketIoPrivateChann);

    function SocketIoPresenceChannel() {
        classCallCheck(this, SocketIoPresenceChannel);
        return possibleConstructorReturn(this, (SocketIoPresenceChannel.__proto__ || Object.getPrototypeOf(SocketIoPresenceChannel)).apply(this, arguments));
    }

    createClass(SocketIoPresenceChannel, [{
        key: 'here',
        value: function here(callback) {
            this.on('presence:subscribed', function (members) {
                callback(members.map(function (m) {
                    return m.user_info;
                }));
            });
            return this;
        }
    }, {
        key: 'joining',
        value: function joining(callback) {
            this.on('presence:joining', function (member) {
                return callback(member.user_info);
            });
            return this;
        }
    }, {
        key: 'leaving',
        value: function leaving(callback) {
            this.on('presence:leaving', function (member) {
                return callback(member.user_info);
            });
            return this;
        }
    }]);
    return SocketIoPresenceChannel;
}(SocketIoPrivateChannel);

var PusherConnector = function (_Connector) {
    inherits(PusherConnector, _Connector);

    function PusherConnector() {
        var _ref;

        classCallCheck(this, PusherConnector);

        for (var _len = arguments.length, args = Array(_len), _key = 0; _key < _len; _key++) {
            args[_key] = arguments[_key];
        }

        var _this = possibleConstructorReturn(this, (_ref = PusherConnector.__proto__ || Object.getPrototypeOf(PusherConnector)).call.apply(_ref, [this].concat(args)));

        _this.channels = {};
        return _this;
    }

    createClass(PusherConnector, [{
        key: 'connect',
        value: function connect() {
            this.pusher = new Pusher(this.options.key, this.options);
        }
    }, {
        key: 'listen',
        value: function listen(name, event, callback) {
            return this.channel(name).listen(event, callback);
        }
    }, {
        key: 'channel',
        value: function channel(name) {
            if (!this.channels[name]) {
                this.channels[name] = new PusherChannel(this.pusher, name, this.options);
            }
            return this.channels[name];
        }
    }, {
        key: 'privateChannel',
        value: function privateChannel(name) {
            if (!this.channels['private-' + name]) {
                this.channels['private-' + name] = new PusherPrivateChannel(this.pusher, 'private-' + name, this.options);
            }
            return this.channels['private-' + name];
        }
    }, {
        key: 'presenceChannel',
        value: function presenceChannel(name) {
            if (!this.channels['presence-' + name]) {
                this.channels['presence-' + name] = new PusherPresenceChannel(this.pusher, 'presence-' + name, this.options);
            }
            return this.channels['presence-' + name];
        }
    }, {
        key: 'leave',
        value: function leave(name) {
            var _this2 = this;

            var channels = [name, 'private-' + name, 'presence-' + name];
            channels.forEach(function (name, index) {
                if (_this2.channels[name]) {
                    _this2.channels[name].unsubscribe();
                    delete _this2.channels[name];
                }
            });
        }
    }, {
        key: 'socketId',
        value: function socketId() {
            return this.pusher.connection.socket_id;
        }
    }]);
    return PusherConnector;
}(Connector);

var SocketIoConnector = function (_Connector) {
    inherits(SocketIoConnector, _Connector);

    function SocketIoConnector() {
        var _ref;

        classCallCheck(this, SocketIoConnector);

        for (var _len = arguments.length, args = Array(_len), _key = 0; _key < _len; _key++) {
            args[_key] = arguments[_key];
        }

        var _this = possibleConstructorReturn(this, (_ref = SocketIoConnector.__proto__ || Object.getPrototypeOf(SocketIoConnector)).call.apply(_ref, [this].concat(args)));

        _this.channels = {};
        return _this;
    }

    createClass(SocketIoConnector, [{
        key: 'connect',
        value: function connect() {
            this.socket = io(this.options.host, this.options);
            return this.socket;
        }
    }, {
        key: 'listen',
        value: function listen(name, event, callback) {
            return this.channel(name).listen(event, callback);
        }
    }, {
        key: 'channel',
        value: function channel(name) {
            if (!this.channels[name]) {
                this.channels[name] = new SocketIoChannel(this.socket, name, this.options);
            }
            return this.channels[name];
        }
    }, {
        key: 'privateChannel',
        value: function privateChannel(name) {
            if (!this.channels['private-' + name]) {
                this.channels['private-' + name] = new SocketIoPrivateChannel(this.socket, 'private-' + name, this.options);
            }
            return this.channels['private-' + name];
        }
    }, {
        key: 'presenceChannel',
        value: function presenceChannel(name) {
            if (!this.channels['presence-' + name]) {
                this.channels['presence-' + name] = new SocketIoPresenceChannel(this.socket, 'presence-' + name, this.options);
            }
            return this.channels['presence-' + name];
        }
    }, {
        key: 'leave',
        value: function leave(name) {
            var _this2 = this;

            var channels = [name, 'private-' + name, 'presence-' + name];
            channels.forEach(function (name) {
                if (_this2.channels[name]) {
                    _this2.channels[name].unsubscribe();
                    delete _this2.channels[name];
                }
            });
        }
    }, {
        key: 'socketId',
        value: function socketId() {
            return this.socket.id;
        }
    }]);
    return SocketIoConnector;
}(Connector);

var Echo = function () {
    function Echo(options) {
        classCallCheck(this, Echo);

        this.options = options;
        if (typeof Vue === 'function' && Vue.http) {
            this.registerVueRequestInterceptor();
        }
        if (typeof axios === 'function') {
            this.registerAxiosRequestInterceptor();
        }
        if (typeof jQuery === 'function') {
            this.registerjQueryAjaxSetup();
        }
        if (this.options.broadcaster == 'pusher') {
            if (!window['Pusher']) {
                window['Pusher'] = require('pusher-js');
            }
            this.connector = new PusherConnector(this.options);
        } else if (this.options.broadcaster == 'socket.io') {
            this.connector = new SocketIoConnector(this.options);
        }
    }

    createClass(Echo, [{
        key: 'registerVueRequestInterceptor',
        value: function registerVueRequestInterceptor() {
            var _this = this;

            Vue.http.interceptors.push(function (request, next) {
                if (_this.socketId()) {
                    request.headers.set('X-Socket-ID', _this.socketId());
                }
                next();
            });
        }
    }, {
        key: 'registerAxiosRequestInterceptor',
        value: function registerAxiosRequestInterceptor() {
            var _this2 = this;

            axios.interceptors.request.use(function (config) {
                if (_this2.socketId()) {
                    config.headers['X-Socket-Id'] = _this2.socketId();
                }
                return config;
            });
        }
    }, {
        key: 'registerjQueryAjaxSetup',
        value: function registerjQueryAjaxSetup() {
            var _this3 = this;

            if (typeof jQuery.ajax != 'undefined') {
                jQuery.ajaxSetup({
                    beforeSend: function beforeSend(xhr) {
                        if (_this3.socketId()) {
                            xhr.setRequestHeader('X-Socket-Id', _this3.socketId());
                        }
                    }
                });
            }
        }
    }, {
        key: 'listen',
        value: function listen(channel, event, callback) {
            return this.connector.listen(channel, event, callback);
        }
    }, {
        key: 'channel',
        value: function channel(_channel) {
            return this.connector.channel(_channel);
        }
    }, {
        key: 'private',
        value: function _private(channel) {
            return this.connector.privateChannel(channel);
        }
    }, {
        key: 'join',
        value: function join(channel) {
            return this.connector.presenceChannel(channel);
        }
    }, {
        key: 'leave',
        value: function leave(channel) {
            this.connector.leave(channel);
        }
    }, {
        key: 'socketId',
        value: function socketId() {
            return this.connector.socketId();
        }
    }]);
    return Echo;
}();

module.exports = Echo;
},{"pusher-js":83}],82:[function(require,module,exports){
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

},{}],83:[function(require,module,exports){
/*!
 * Pusher JavaScript Library v3.2.4
 * http://pusher.com/
 *
 * Copyright 2016, Pusher
 * Released under the MIT licence.
 */

(function webpackUniversalModuleDefinition(root, factory) {
	if(typeof exports === 'object' && typeof module === 'object')
		module.exports = factory();
	else if(typeof define === 'function' && define.amd)
		define([], factory);
	else if(typeof exports === 'object')
		exports["Pusher"] = factory();
	else
		root["Pusher"] = factory();
})(this, function() {
return /******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};

/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {

/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;

/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			exports: {},
/******/ 			id: moduleId,
/******/ 			loaded: false
/******/ 		};

/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);

/******/ 		// Flag the module as loaded
/******/ 		module.loaded = true;

/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}


/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;

/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;

/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";

/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ function(module, exports, __webpack_require__) {

	"use strict";
	var pusher_1 = __webpack_require__(1);
	module.exports = pusher_1["default"];


/***/ },
/* 1 */
/***/ function(module, exports, __webpack_require__) {

	"use strict";
	var runtime_1 = __webpack_require__(2);
	var Collections = __webpack_require__(9);
	var dispatcher_1 = __webpack_require__(23);
	var timeline_1 = __webpack_require__(38);
	var level_1 = __webpack_require__(39);
	var StrategyBuilder = __webpack_require__(40);
	var timers_1 = __webpack_require__(12);
	var defaults_1 = __webpack_require__(5);
	var DefaultConfig = __webpack_require__(62);
	var logger_1 = __webpack_require__(8);
	var factory_1 = __webpack_require__(42);
	var Pusher = (function () {
	    function Pusher(app_key, options) {
	        var _this = this;
	        checkAppKey(app_key);
	        options = options || {};
	        this.key = app_key;
	        this.config = Collections.extend(DefaultConfig.getGlobalConfig(), options.cluster ? DefaultConfig.getClusterConfig(options.cluster) : {}, options);
	        this.channels = factory_1["default"].createChannels();
	        this.global_emitter = new dispatcher_1["default"]();
	        this.sessionID = Math.floor(Math.random() * 1000000000);
	        this.timeline = new timeline_1["default"](this.key, this.sessionID, {
	            cluster: this.config.cluster,
	            features: Pusher.getClientFeatures(),
	            params: this.config.timelineParams || {},
	            limit: 50,
	            level: level_1["default"].INFO,
	            version: defaults_1["default"].VERSION
	        });
	        if (!this.config.disableStats) {
	            this.timelineSender = factory_1["default"].createTimelineSender(this.timeline, {
	                host: this.config.statsHost,
	                path: "/timeline/v2/" + runtime_1["default"].TimelineTransport.name
	            });
	        }
	        var getStrategy = function (options) {
	            var config = Collections.extend({}, _this.config, options);
	            return StrategyBuilder.build(runtime_1["default"].getDefaultStrategy(config), config);
	        };
	        this.connection = factory_1["default"].createConnectionManager(this.key, Collections.extend({ getStrategy: getStrategy,
	            timeline: this.timeline,
	            activityTimeout: this.config.activity_timeout,
	            pongTimeout: this.config.pong_timeout,
	            unavailableTimeout: this.config.unavailable_timeout
	        }, this.config, { encrypted: this.isEncrypted() }));
	        this.connection.bind('connected', function () {
	            _this.subscribeAll();
	            if (_this.timelineSender) {
	                _this.timelineSender.send(_this.connection.isEncrypted());
	            }
	        });
	        this.connection.bind('message', function (params) {
	            var internal = (params.event.indexOf('pusher_internal:') === 0);
	            if (params.channel) {
	                var channel = _this.channel(params.channel);
	                if (channel) {
	                    channel.handleEvent(params.event, params.data);
	                }
	            }
	            if (!internal) {
	                _this.global_emitter.emit(params.event, params.data);
	            }
	        });
	        this.connection.bind('connecting', function () {
	            _this.channels.disconnect();
	        });
	        this.connection.bind('disconnected', function () {
	            _this.channels.disconnect();
	        });
	        this.connection.bind('error', function (err) {
	            logger_1["default"].warn('Error', err);
	        });
	        Pusher.instances.push(this);
	        this.timeline.info({ instances: Pusher.instances.length });
	        if (Pusher.isReady) {
	            this.connect();
	        }
	    }
	    Pusher.ready = function () {
	        Pusher.isReady = true;
	        for (var i = 0, l = Pusher.instances.length; i < l; i++) {
	            Pusher.instances[i].connect();
	        }
	    };
	    Pusher.log = function (message) {
	        if (Pusher.logToConsole && (window).console && (window).console.log) {
	            (window).console.log(message);
	        }
	    };
	    Pusher.getClientFeatures = function () {
	        return Collections.keys(Collections.filterObject({ "ws": runtime_1["default"].Transports.ws }, function (t) { return t.isSupported({}); }));
	    };
	    Pusher.prototype.channel = function (name) {
	        return this.channels.find(name);
	    };
	    Pusher.prototype.allChannels = function () {
	        return this.channels.all();
	    };
	    Pusher.prototype.connect = function () {
	        this.connection.connect();
	        if (this.timelineSender) {
	            if (!this.timelineSenderTimer) {
	                var encrypted = this.connection.isEncrypted();
	                var timelineSender = this.timelineSender;
	                this.timelineSenderTimer = new timers_1.PeriodicTimer(60000, function () {
	                    timelineSender.send(encrypted);
	                });
	            }
	        }
	    };
	    Pusher.prototype.disconnect = function () {
	        this.connection.disconnect();
	        if (this.timelineSenderTimer) {
	            this.timelineSenderTimer.ensureAborted();
	            this.timelineSenderTimer = null;
	        }
	    };
	    Pusher.prototype.bind = function (event_name, callback) {
	        this.global_emitter.bind(event_name, callback);
	        return this;
	    };
	    Pusher.prototype.unbind = function (event_name, callback) {
	        this.global_emitter.unbind(event_name, callback);
	        return this;
	    };
	    Pusher.prototype.bind_all = function (callback) {
	        this.global_emitter.bind_all(callback);
	        return this;
	    };
	    Pusher.prototype.subscribeAll = function () {
	        var channelName;
	        for (channelName in this.channels.channels) {
	            if (this.channels.channels.hasOwnProperty(channelName)) {
	                this.subscribe(channelName);
	            }
	        }
	    };
	    Pusher.prototype.subscribe = function (channel_name) {
	        var channel = this.channels.add(channel_name, this);
	        if (channel.subscriptionPending && channel.subscriptionCancelled) {
	            channel.reinstateSubscription();
	        }
	        else if (!channel.subscriptionPending && this.connection.state === "connected") {
	            channel.subscribe();
	        }
	        return channel;
	    };
	    Pusher.prototype.unsubscribe = function (channel_name) {
	        var channel = this.channels.find(channel_name);
	        if (channel && channel.subscriptionPending) {
	            channel.cancelSubscription();
	        }
	        else {
	            channel = this.channels.remove(channel_name);
	            if (channel && this.connection.state === "connected") {
	                channel.unsubscribe();
	            }
	        }
	    };
	    Pusher.prototype.send_event = function (event_name, data, channel) {
	        return this.connection.send_event(event_name, data, channel);
	    };
	    Pusher.prototype.isEncrypted = function () {
	        if (runtime_1["default"].getProtocol() === "https:") {
	            return true;
	        }
	        else {
	            return Boolean(this.config.encrypted);
	        }
	    };
	    Pusher.instances = [];
	    Pusher.isReady = false;
	    Pusher.logToConsole = false;
	    Pusher.Runtime = runtime_1["default"];
	    Pusher.ScriptReceivers = runtime_1["default"].ScriptReceivers;
	    Pusher.DependenciesReceivers = runtime_1["default"].DependenciesReceivers;
	    Pusher.auth_callbacks = runtime_1["default"].auth_callbacks;
	    return Pusher;
	}());
	exports.__esModule = true;
	exports["default"] = Pusher;
	function checkAppKey(key) {
	    if (key === null || key === undefined) {
	        throw "You must pass your app key when you instantiate Pusher.";
	    }
	}
	runtime_1["default"].setup(Pusher);


/***/ },
/* 2 */
/***/ function(module, exports, __webpack_require__) {

	"use strict";
	var dependencies_1 = __webpack_require__(3);
	var xhr_auth_1 = __webpack_require__(7);
	var jsonp_auth_1 = __webpack_require__(14);
	var script_request_1 = __webpack_require__(15);
	var jsonp_request_1 = __webpack_require__(16);
	var script_receiver_factory_1 = __webpack_require__(4);
	var jsonp_timeline_1 = __webpack_require__(17);
	var transports_1 = __webpack_require__(18);
	var net_info_1 = __webpack_require__(25);
	var default_strategy_1 = __webpack_require__(26);
	var transport_connection_initializer_1 = __webpack_require__(27);
	var http_1 = __webpack_require__(28);
	var Runtime = {
	    nextAuthCallbackID: 1,
	    auth_callbacks: {},
	    ScriptReceivers: script_receiver_factory_1.ScriptReceivers,
	    DependenciesReceivers: dependencies_1.DependenciesReceivers,
	    getDefaultStrategy: default_strategy_1["default"],
	    Transports: transports_1["default"],
	    transportConnectionInitializer: transport_connection_initializer_1["default"],
	    HTTPFactory: http_1["default"],
	    TimelineTransport: jsonp_timeline_1["default"],
	    getXHRAPI: function () {
	        return window.XMLHttpRequest;
	    },
	    getWebSocketAPI: function () {
	        return window.WebSocket || window.MozWebSocket;
	    },
	    setup: function (PusherClass) {
	        var _this = this;
	        window.Pusher = PusherClass;
	        var initializeOnDocumentBody = function () {
	            _this.onDocumentBody(PusherClass.ready);
	        };
	        if (!window.JSON) {
	            dependencies_1.Dependencies.load("json2", {}, initializeOnDocumentBody);
	        }
	        else {
	            initializeOnDocumentBody();
	        }
	    },
	    getDocument: function () {
	        return document;
	    },
	    getProtocol: function () {
	        return this.getDocument().location.protocol;
	    },
	    getAuthorizers: function () {
	        return { ajax: xhr_auth_1["default"], jsonp: jsonp_auth_1["default"] };
	    },
	    onDocumentBody: function (callback) {
	        var _this = this;
	        if (document.body) {
	            callback();
	        }
	        else {
	            setTimeout(function () {
	                _this.onDocumentBody(callback);
	            }, 0);
	        }
	    },
	    createJSONPRequest: function (url, data) {
	        return new jsonp_request_1["default"](url, data);
	    },
	    createScriptRequest: function (src) {
	        return new script_request_1["default"](src);
	    },
	    getLocalStorage: function () {
	        try {
	            return window.localStorage;
	        }
	        catch (e) {
	            return undefined;
	        }
	    },
	    createXHR: function () {
	        if (this.getXHRAPI()) {
	            return this.createXMLHttpRequest();
	        }
	        else {
	            return this.createMicrosoftXHR();
	        }
	    },
	    createXMLHttpRequest: function () {
	        var Constructor = this.getXHRAPI();
	        return new Constructor();
	    },
	    createMicrosoftXHR: function () {
	        return new ActiveXObject("Microsoft.XMLHTTP");
	    },
	    getNetwork: function () {
	        return net_info_1.Network;
	    },
	    createWebSocket: function (url) {
	        var Constructor = this.getWebSocketAPI();
	        return new Constructor(url);
	    },
	    createSocketRequest: function (method, url) {
	        if (this.isXHRSupported()) {
	            return this.HTTPFactory.createXHR(method, url);
	        }
	        else if (this.isXDRSupported(url.indexOf("https:") === 0)) {
	            return this.HTTPFactory.createXDR(method, url);
	        }
	        else {
	            throw "Cross-origin HTTP requests are not supported";
	        }
	    },
	    isXHRSupported: function () {
	        var Constructor = this.getXHRAPI();
	        return Boolean(Constructor) && (new Constructor()).withCredentials !== undefined;
	    },
	    isXDRSupported: function (encrypted) {
	        var protocol = encrypted ? "https:" : "http:";
	        var documentProtocol = this.getProtocol();
	        return Boolean((window['XDomainRequest'])) && documentProtocol === protocol;
	    },
	    addUnloadListener: function (listener) {
	        if (window.addEventListener !== undefined) {
	            window.addEventListener("unload", listener, false);
	        }
	        else if (window.attachEvent !== undefined) {
	            window.attachEvent("onunload", listener);
	        }
	    },
	    removeUnloadListener: function (listener) {
	        if (window.addEventListener !== undefined) {
	            window.removeEventListener("unload", listener, false);
	        }
	        else if (window.detachEvent !== undefined) {
	            window.detachEvent("onunload", listener);
	        }
	    }
	};
	exports.__esModule = true;
	exports["default"] = Runtime;


/***/ },
/* 3 */
/***/ function(module, exports, __webpack_require__) {

	"use strict";
	var script_receiver_factory_1 = __webpack_require__(4);
	var defaults_1 = __webpack_require__(5);
	var dependency_loader_1 = __webpack_require__(6);
	exports.DependenciesReceivers = new script_receiver_factory_1.ScriptReceiverFactory("_pusher_dependencies", "Pusher.DependenciesReceivers");
	exports.Dependencies = new dependency_loader_1["default"]({
	    cdn_http: defaults_1["default"].cdn_http,
	    cdn_https: defaults_1["default"].cdn_https,
	    version: defaults_1["default"].VERSION,
	    suffix: defaults_1["default"].dependency_suffix,
	    receivers: exports.DependenciesReceivers
	});


/***/ },
/* 4 */
/***/ function(module, exports) {

	"use strict";
	var ScriptReceiverFactory = (function () {
	    function ScriptReceiverFactory(prefix, name) {
	        this.lastId = 0;
	        this.prefix = prefix;
	        this.name = name;
	    }
	    ScriptReceiverFactory.prototype.create = function (callback) {
	        this.lastId++;
	        var number = this.lastId;
	        var id = this.prefix + number;
	        var name = this.name + "[" + number + "]";
	        var called = false;
	        var callbackWrapper = function () {
	            if (!called) {
	                callback.apply(null, arguments);
	                called = true;
	            }
	        };
	        this[number] = callbackWrapper;
	        return { number: number, id: id, name: name, callback: callbackWrapper };
	    };
	    ScriptReceiverFactory.prototype.remove = function (receiver) {
	        delete this[receiver.number];
	    };
	    return ScriptReceiverFactory;
	}());
	exports.ScriptReceiverFactory = ScriptReceiverFactory;
	exports.ScriptReceivers = new ScriptReceiverFactory("_pusher_script_", "Pusher.ScriptReceivers");


/***/ },
/* 5 */
/***/ function(module, exports) {

	"use strict";
	var Defaults = {
	    VERSION: "3.2.4",
	    PROTOCOL: 7,
	    host: 'ws.pusherapp.com',
	    ws_port: 80,
	    wss_port: 443,
	    sockjs_host: 'sockjs.pusher.com',
	    sockjs_http_port: 80,
	    sockjs_https_port: 443,
	    sockjs_path: "/pusher",
	    stats_host: 'stats.pusher.com',
	    channel_auth_endpoint: '/pusher/auth',
	    channel_auth_transport: 'ajax',
	    activity_timeout: 120000,
	    pong_timeout: 30000,
	    unavailable_timeout: 10000,
	    cdn_http: 'http://js.pusher.com',
	    cdn_https: 'https://js.pusher.com',
	    dependency_suffix: ''
	};
	exports.__esModule = true;
	exports["default"] = Defaults;


/***/ },
/* 6 */
/***/ function(module, exports, __webpack_require__) {

	"use strict";
	var script_receiver_factory_1 = __webpack_require__(4);
	var runtime_1 = __webpack_require__(2);
	var DependencyLoader = (function () {
	    function DependencyLoader(options) {
	        this.options = options;
	        this.receivers = options.receivers || script_receiver_factory_1.ScriptReceivers;
	        this.loading = {};
	    }
	    DependencyLoader.prototype.load = function (name, options, callback) {
	        var self = this;
	        if (self.loading[name] && self.loading[name].length > 0) {
	            self.loading[name].push(callback);
	        }
	        else {
	            self.loading[name] = [callback];
	            var request = runtime_1["default"].createScriptRequest(self.getPath(name, options));
	            var receiver = self.receivers.create(function (error) {
	                self.receivers.remove(receiver);
	                if (self.loading[name]) {
	                    var callbacks = self.loading[name];
	                    delete self.loading[name];
	                    var successCallback = function (wasSuccessful) {
	                        if (!wasSuccessful) {
	                            request.cleanup();
	                        }
	                    };
	                    for (var i = 0; i < callbacks.length; i++) {
	                        callbacks[i](error, successCallback);
	                    }
	                }
	            });
	            request.send(receiver);
	        }
	    };
	    DependencyLoader.prototype.getRoot = function (options) {
	        var cdn;
	        var protocol = runtime_1["default"].getDocument().location.protocol;
	        if ((options && options.encrypted) || protocol === "https:") {
	            cdn = this.options.cdn_https;
	        }
	        else {
	            cdn = this.options.cdn_http;
	        }
	        return cdn.replace(/\/*$/, "") + "/" + this.options.version;
	    };
	    DependencyLoader.prototype.getPath = function (name, options) {
	        return this.getRoot(options) + '/' + name + this.options.suffix + '.js';
	    };
	    ;
	    return DependencyLoader;
	}());
	exports.__esModule = true;
	exports["default"] = DependencyLoader;


/***/ },
/* 7 */
/***/ function(module, exports, __webpack_require__) {

	"use strict";
	var logger_1 = __webpack_require__(8);
	var runtime_1 = __webpack_require__(2);
	var ajax = function (context, socketId, callback) {
	    var self = this, xhr;
	    xhr = runtime_1["default"].createXHR();
	    xhr.open("POST", self.options.authEndpoint, true);
	    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	    for (var headerName in this.authOptions.headers) {
	        xhr.setRequestHeader(headerName, this.authOptions.headers[headerName]);
	    }
	    xhr.onreadystatechange = function () {
	        if (xhr.readyState === 4) {
	            if (xhr.status === 200) {
	                var data, parsed = false;
	                try {
	                    data = JSON.parse(xhr.responseText);
	                    parsed = true;
	                }
	                catch (e) {
	                    callback(true, 'JSON returned from webapp was invalid, yet status code was 200. Data was: ' + xhr.responseText);
	                }
	                if (parsed) {
	                    callback(false, data);
	                }
	            }
	            else {
	                logger_1["default"].warn("Couldn't get auth info from your webapp", xhr.status);
	                callback(true, xhr.status);
	            }
	        }
	    };
	    xhr.send(this.composeQuery(socketId));
	    return xhr;
	};
	exports.__esModule = true;
	exports["default"] = ajax;


/***/ },
/* 8 */
/***/ function(module, exports, __webpack_require__) {

	"use strict";
	var collections_1 = __webpack_require__(9);
	var pusher_1 = __webpack_require__(1);
	var Logger = {
	    debug: function () {
	        var args = [];
	        for (var _i = 0; _i < arguments.length; _i++) {
	            args[_i - 0] = arguments[_i];
	        }
	        if (!pusher_1["default"].log) {
	            return;
	        }
	        pusher_1["default"].log(collections_1.stringify.apply(this, arguments));
	    },
	    warn: function () {
	        var args = [];
	        for (var _i = 0; _i < arguments.length; _i++) {
	            args[_i - 0] = arguments[_i];
	        }
	        var message = collections_1.stringify.apply(this, arguments);
	        if ((window).console) {
	            if ((window).console.warn) {
	                (window).console.warn(message);
	            }
	            else if ((window).console.log) {
	                (window).console.log(message);
	            }
	        }
	        if (pusher_1["default"].log) {
	            pusher_1["default"].log(message);
	        }
	    }
	};
	exports.__esModule = true;
	exports["default"] = Logger;


/***/ },
/* 9 */
/***/ function(module, exports, __webpack_require__) {

	"use strict";
	var base64_1 = __webpack_require__(10);
	var util_1 = __webpack_require__(11);
	function extend(target) {
	    var sources = [];
	    for (var _i = 1; _i < arguments.length; _i++) {
	        sources[_i - 1] = arguments[_i];
	    }
	    for (var i = 0; i < sources.length; i++) {
	        var extensions = sources[i];
	        for (var property in extensions) {
	            if (extensions[property] && extensions[property].constructor &&
	                extensions[property].constructor === Object) {
	                target[property] = extend(target[property] || {}, extensions[property]);
	            }
	            else {
	                target[property] = extensions[property];
	            }
	        }
	    }
	    return target;
	}
	exports.extend = extend;
	function stringify() {
	    var m = ["Pusher"];
	    for (var i = 0; i < arguments.length; i++) {
	        if (typeof arguments[i] === "string") {
	            m.push(arguments[i]);
	        }
	        else {
	            m.push(safeJSONStringify(arguments[i]));
	        }
	    }
	    return m.join(" : ");
	}
	exports.stringify = stringify;
	function arrayIndexOf(array, item) {
	    var nativeIndexOf = Array.prototype.indexOf;
	    if (array === null) {
	        return -1;
	    }
	    if (nativeIndexOf && array.indexOf === nativeIndexOf) {
	        return array.indexOf(item);
	    }
	    for (var i = 0, l = array.length; i < l; i++) {
	        if (array[i] === item) {
	            return i;
	        }
	    }
	    return -1;
	}
	exports.arrayIndexOf = arrayIndexOf;
	function objectApply(object, f) {
	    for (var key in object) {
	        if (Object.prototype.hasOwnProperty.call(object, key)) {
	            f(object[key], key, object);
	        }
	    }
	}
	exports.objectApply = objectApply;
	function keys(object) {
	    var keys = [];
	    objectApply(object, function (_, key) {
	        keys.push(key);
	    });
	    return keys;
	}
	exports.keys = keys;
	function values(object) {
	    var values = [];
	    objectApply(object, function (value) {
	        values.push(value);
	    });
	    return values;
	}
	exports.values = values;
	function apply(array, f, context) {
	    for (var i = 0; i < array.length; i++) {
	        f.call(context || (window), array[i], i, array);
	    }
	}
	exports.apply = apply;
	function map(array, f) {
	    var result = [];
	    for (var i = 0; i < array.length; i++) {
	        result.push(f(array[i], i, array, result));
	    }
	    return result;
	}
	exports.map = map;
	function mapObject(object, f) {
	    var result = {};
	    objectApply(object, function (value, key) {
	        result[key] = f(value);
	    });
	    return result;
	}
	exports.mapObject = mapObject;
	function filter(array, test) {
	    test = test || function (value) { return !!value; };
	    var result = [];
	    for (var i = 0; i < array.length; i++) {
	        if (test(array[i], i, array, result)) {
	            result.push(array[i]);
	        }
	    }
	    return result;
	}
	exports.filter = filter;
	function filterObject(object, test) {
	    var result = {};
	    objectApply(object, function (value, key) {
	        if ((test && test(value, key, object, result)) || Boolean(value)) {
	            result[key] = value;
	        }
	    });
	    return result;
	}
	exports.filterObject = filterObject;
	function flatten(object) {
	    var result = [];
	    objectApply(object, function (value, key) {
	        result.push([key, value]);
	    });
	    return result;
	}
	exports.flatten = flatten;
	function any(array, test) {
	    for (var i = 0; i < array.length; i++) {
	        if (test(array[i], i, array)) {
	            return true;
	        }
	    }
	    return false;
	}
	exports.any = any;
	function all(array, test) {
	    for (var i = 0; i < array.length; i++) {
	        if (!test(array[i], i, array)) {
	            return false;
	        }
	    }
	    return true;
	}
	exports.all = all;
	function encodeParamsObject(data) {
	    return mapObject(data, function (value) {
	        if (typeof value === "object") {
	            value = safeJSONStringify(value);
	        }
	        return encodeURIComponent(base64_1["default"](value.toString()));
	    });
	}
	exports.encodeParamsObject = encodeParamsObject;
	function buildQueryString(data) {
	    var params = filterObject(data, function (value) {
	        return value !== undefined;
	    });
	    var query = map(flatten(encodeParamsObject(params)), util_1["default"].method("join", "=")).join("&");
	    return query;
	}
	exports.buildQueryString = buildQueryString;
	function decycleObject(object) {
	    var objects = [], paths = [];
	    return (function derez(value, path) {
	        var i, name, nu;
	        switch (typeof value) {
	            case 'object':
	                if (!value) {
	                    return null;
	                }
	                for (i = 0; i < objects.length; i += 1) {
	                    if (objects[i] === value) {
	                        return { $ref: paths[i] };
	                    }
	                }
	                objects.push(value);
	                paths.push(path);
	                if (Object.prototype.toString.apply(value) === '[object Array]') {
	                    nu = [];
	                    for (i = 0; i < value.length; i += 1) {
	                        nu[i] = derez(value[i], path + '[' + i + ']');
	                    }
	                }
	                else {
	                    nu = {};
	                    for (name in value) {
	                        if (Object.prototype.hasOwnProperty.call(value, name)) {
	                            nu[name] = derez(value[name], path + '[' + JSON.stringify(name) + ']');
	                        }
	                    }
	                }
	                return nu;
	            case 'number':
	            case 'string':
	            case 'boolean':
	                return value;
	        }
	    }(object, '$'));
	}
	exports.decycleObject = decycleObject;
	function safeJSONStringify(source) {
	    try {
	        return JSON.stringify(source);
	    }
	    catch (e) {
	        return JSON.stringify(decycleObject(source));
	    }
	}
	exports.safeJSONStringify = safeJSONStringify;


/***/ },
/* 10 */
/***/ function(module, exports, __webpack_require__) {

	"use strict";
	function encode(s) {
	    return btoa(utob(s));
	}
	exports.__esModule = true;
	exports["default"] = encode;
	var fromCharCode = String.fromCharCode;
	var b64chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';
	var b64tab = {};
	for (var i = 0, l = b64chars.length; i < l; i++) {
	    b64tab[b64chars.charAt(i)] = i;
	}
	var cb_utob = function (c) {
	    var cc = c.charCodeAt(0);
	    return cc < 0x80 ? c
	        : cc < 0x800 ? fromCharCode(0xc0 | (cc >>> 6)) +
	            fromCharCode(0x80 | (cc & 0x3f))
	            : fromCharCode(0xe0 | ((cc >>> 12) & 0x0f)) +
	                fromCharCode(0x80 | ((cc >>> 6) & 0x3f)) +
	                fromCharCode(0x80 | (cc & 0x3f));
	};
	var utob = function (u) {
	    return u.replace(/[^\x00-\x7F]/g, cb_utob);
	};
	var cb_encode = function (ccc) {
	    var padlen = [0, 2, 1][ccc.length % 3];
	    var ord = ccc.charCodeAt(0) << 16
	        | ((ccc.length > 1 ? ccc.charCodeAt(1) : 0) << 8)
	        | ((ccc.length > 2 ? ccc.charCodeAt(2) : 0));
	    var chars = [
	        b64chars.charAt(ord >>> 18),
	        b64chars.charAt((ord >>> 12) & 63),
	        padlen >= 2 ? '=' : b64chars.charAt((ord >>> 6) & 63),
	        padlen >= 1 ? '=' : b64chars.charAt(ord & 63)
	    ];
	    return chars.join('');
	};
	var btoa = (window).btoa || function (b) {
	    return b.replace(/[\s\S]{1,3}/g, cb_encode);
	};


/***/ },
/* 11 */
/***/ function(module, exports, __webpack_require__) {

	"use strict";
	var timers_1 = __webpack_require__(12);
	var Util = {
	    now: function () {
	        if (Date.now) {
	            return Date.now();
	        }
	        else {
	            return new Date().valueOf();
	        }
	    },
	    defer: function (callback) {
	        return new timers_1.OneOffTimer(0, callback);
	    },
	    method: function (name) {
	        var args = [];
	        for (var _i = 1; _i < arguments.length; _i++) {
	            args[_i - 1] = arguments[_i];
	        }
	        var boundArguments = Array.prototype.slice.call(arguments, 1);
	        return function (object) {
	            return object[name].apply(object, boundArguments.concat(arguments));
	        };
	    }
	};
	exports.__esModule = true;
	exports["default"] = Util;


/***/ },
/* 12 */
/***/ function(module, exports, __webpack_require__) {

	"use strict";
	var __extends = (this && this.__extends) || function (d, b) {
	    for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p];
	    function __() { this.constructor = d; }
	    d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
	};
	var abstract_timer_1 = __webpack_require__(13);
	function clearTimeout(timer) {
	    (window).clearTimeout(timer);
	}
	function clearInterval(timer) {
	    (window).clearInterval(timer);
	}
	var OneOffTimer = (function (_super) {
	    __extends(OneOffTimer, _super);
	    function OneOffTimer(delay, callback) {
	        _super.call(this, setTimeout, clearTimeout, delay, function (timer) {
	            callback();
	            return null;
	        });
	    }
	    return OneOffTimer;
	}(abstract_timer_1["default"]));
	exports.OneOffTimer = OneOffTimer;
	var PeriodicTimer = (function (_super) {
	    __extends(PeriodicTimer, _super);
	    function PeriodicTimer(delay, callback) {
	        _super.call(this, setInterval, clearInterval, delay, function (timer) {
	            callback();
	            return timer;
	        });
	    }
	    return PeriodicTimer;
	}(abstract_timer_1["default"]));
	exports.PeriodicTimer = PeriodicTimer;


/***/ },
/* 13 */
/***/ function(module, exports) {

	"use strict";
	var Timer = (function () {
	    function Timer(set, clear, delay, callback) {
	        var _this = this;
	        this.clear = clear;
	        this.timer = set(function () {
	            if (_this.timer) {
	                _this.timer = callback(_this.timer);
	            }
	        }, delay);
	    }
	    Timer.prototype.isRunning = function () {
	        return this.timer !== null;
	    };
	    Timer.prototype.ensureAborted = function () {
	        if (this.timer) {
	            this.clear(this.timer);
	            this.timer = null;
	        }
	    };
	    return Timer;
	}());
	exports.__esModule = true;
	exports["default"] = Timer;


/***/ },
/* 14 */
/***/ function(module, exports, __webpack_require__) {

	"use strict";
	var logger_1 = __webpack_require__(8);
	var jsonp = function (context, socketId, callback) {
	    if (this.authOptions.headers !== undefined) {
	        logger_1["default"].warn("Warn", "To send headers with the auth request, you must use AJAX, rather than JSONP.");
	    }
	    var callbackName = context.nextAuthCallbackID.toString();
	    context.nextAuthCallbackID++;
	    var document = context.getDocument();
	    var script = document.createElement("script");
	    context.auth_callbacks[callbackName] = function (data) {
	        callback(false, data);
	    };
	    var callback_name = "Pusher.auth_callbacks['" + callbackName + "']";
	    script.src = this.options.authEndpoint +
	        '?callback=' +
	        encodeURIComponent(callback_name) +
	        '&' +
	        this.composeQuery(socketId);
	    var head = document.getElementsByTagName("head")[0] || document.documentElement;
	    head.insertBefore(script, head.firstChild);
	};
	exports.__esModule = true;
	exports["default"] = jsonp;


/***/ },
/* 15 */
/***/ function(module, exports) {

	"use strict";
	var ScriptRequest = (function () {
	    function ScriptRequest(src) {
	        this.src = src;
	    }
	    ScriptRequest.prototype.send = function (receiver) {
	        var self = this;
	        var errorString = "Error loading " + self.src;
	        self.script = document.createElement("script");
	        self.script.id = receiver.id;
	        self.script.src = self.src;
	        self.script.type = "text/javascript";
	        self.script.charset = "UTF-8";
	        if (self.script.addEventListener) {
	            self.script.onerror = function () {
	                receiver.callback(errorString);
	            };
	            self.script.onload = function () {
	                receiver.callback(null);
	            };
	        }
	        else {
	            self.script.onreadystatechange = function () {
	                if (self.script.readyState === 'loaded' ||
	                    self.script.readyState === 'complete') {
	                    receiver.callback(null);
	                }
	            };
	        }
	        if (self.script.async === undefined && document.attachEvent &&
	            /opera/i.test(navigator.userAgent)) {
	            self.errorScript = document.createElement("script");
	            self.errorScript.id = receiver.id + "_error";
	            self.errorScript.text = receiver.name + "('" + errorString + "');";
	            self.script.async = self.errorScript.async = false;
	        }
	        else {
	            self.script.async = true;
	        }
	        var head = document.getElementsByTagName('head')[0];
	        head.insertBefore(self.script, head.firstChild);
	        if (self.errorScript) {
	            head.insertBefore(self.errorScript, self.script.nextSibling);
	        }
	    };
	    ScriptRequest.prototype.cleanup = function () {
	        if (this.script) {
	            this.script.onload = this.script.onerror = null;
	            this.script.onreadystatechange = null;
	        }
	        if (this.script && this.script.parentNode) {
	            this.script.parentNode.removeChild(this.script);
	        }
	        if (this.errorScript && this.errorScript.parentNode) {
	            this.errorScript.parentNode.removeChild(this.errorScript);
	        }
	        this.script = null;
	        this.errorScript = null;
	    };
	    return ScriptRequest;
	}());
	exports.__esModule = true;
	exports["default"] = ScriptRequest;


/***/ },
/* 16 */
/***/ function(module, exports, __webpack_require__) {

	"use strict";
	var Collections = __webpack_require__(9);
	var runtime_1 = __webpack_require__(2);
	var JSONPRequest = (function () {
	    function JSONPRequest(url, data) {
	        this.url = url;
	        this.data = data;
	    }
	    JSONPRequest.prototype.send = function (receiver) {
	        if (this.request) {
	            return;
	        }
	        var query = Collections.buildQueryString(this.data);
	        var url = this.url + "/" + receiver.number + "?" + query;
	        this.request = runtime_1["default"].createScriptRequest(url);
	        this.request.send(receiver);
	    };
	    JSONPRequest.prototype.cleanup = function () {
	        if (this.request) {
	            this.request.cleanup();
	        }
	    };
	    return JSONPRequest;
	}());
	exports.__esModule = true;
	exports["default"] = JSONPRequest;


/***/ },
/* 17 */
/***/ function(module, exports, __webpack_require__) {

	"use strict";
	var runtime_1 = __webpack_require__(2);
	var script_receiver_factory_1 = __webpack_require__(4);
	var getAgent = function (sender, encrypted) {
	    return function (data, callback) {
	        var scheme = "http" + (encrypted ? "s" : "") + "://";
	        var url = scheme + (sender.host || sender.options.host) + sender.options.path;
	        var request = runtime_1["default"].createJSONPRequest(url, data);
	        var receiver = runtime_1["default"].ScriptReceivers.create(function (error, result) {
	            script_receiver_factory_1.ScriptReceivers.remove(receiver);
	            request.cleanup();
	            if (result && result.host) {
	                sender.host = result.host;
	            }
	            if (callback) {
	                callback(error, result);
	            }
	        });
	        request.send(receiver);
	    };
	};
	var jsonp = {
	    name: 'jsonp',
	    getAgent: getAgent
	};
	exports.__esModule = true;
	exports["default"] = jsonp;


/***/ },
/* 18 */
/***/ function(module, exports, __webpack_require__) {

	"use strict";
	var transports_1 = __webpack_require__(19);
	var transport_1 = __webpack_require__(21);
	var URLSchemes = __webpack_require__(20);
	var runtime_1 = __webpack_require__(2);
	var dependencies_1 = __webpack_require__(3);
	var Collections = __webpack_require__(9);
	var SockJSTransport = new transport_1["default"]({
	    file: "sockjs",
	    urls: URLSchemes.sockjs,
	    handlesActivityChecks: true,
	    supportsPing: false,
	    isSupported: function () {
	        return true;
	    },
	    isInitialized: function () {
	        return window.SockJS !== undefined;
	    },
	    getSocket: function (url, options) {
	        return new window.SockJS(url, null, {
	            js_path: dependencies_1.Dependencies.getPath("sockjs", {
	                encrypted: options.encrypted
	            }),
	            ignore_null_origin: options.ignoreNullOrigin
	        });
	    },
	    beforeOpen: function (socket, path) {
	        socket.send(JSON.stringify({
	            path: path
	        }));
	    }
	});
	var xdrConfiguration = {
	    isSupported: function (environment) {
	        var yes = runtime_1["default"].isXDRSupported(environment.encrypted);
	        return yes;
	    }
	};
	var XDRStreamingTransport = new transport_1["default"](Collections.extend({}, transports_1.streamingConfiguration, xdrConfiguration));
	var XDRPollingTransport = new transport_1["default"](Collections.extend({}, transports_1.pollingConfiguration, xdrConfiguration));
	transports_1["default"].xdr_streaming = XDRStreamingTransport;
	transports_1["default"].xdr_polling = XDRPollingTransport;
	transports_1["default"].sockjs = SockJSTransport;
	exports.__esModule = true;
	exports["default"] = transports_1["default"];


/***/ },
/* 19 */
/***/ function(module, exports, __webpack_require__) {

	"use strict";
	var URLSchemes = __webpack_require__(20);
	var transport_1 = __webpack_require__(21);
	var Collections = __webpack_require__(9);
	var runtime_1 = __webpack_require__(2);
	var WSTransport = new transport_1["default"]({
	    urls: URLSchemes.ws,
	    handlesActivityChecks: false,
	    supportsPing: false,
	    isInitialized: function () {
	        return Boolean(runtime_1["default"].getWebSocketAPI());
	    },
	    isSupported: function () {
	        return Boolean(runtime_1["default"].getWebSocketAPI());
	    },
	    getSocket: function (url) {
	        return runtime_1["default"].createWebSocket(url);
	    }
	});
	var httpConfiguration = {
	    urls: URLSchemes.http,
	    handlesActivityChecks: false,
	    supportsPing: true,
	    isInitialized: function () {
	        return true;
	    }
	};
	exports.streamingConfiguration = Collections.extend({ getSocket: function (url) {
	        return runtime_1["default"].HTTPFactory.createStreamingSocket(url);
	    }
	}, httpConfiguration);
	exports.pollingConfiguration = Collections.extend({ getSocket: function (url) {
	        return runtime_1["default"].HTTPFactory.createPollingSocket(url);
	    }
	}, httpConfiguration);
	var xhrConfiguration = {
	    isSupported: function () {
	        return runtime_1["default"].isXHRSupported();
	    }
	};
	var XHRStreamingTransport = new transport_1["default"](Collections.extend({}, exports.streamingConfiguration, xhrConfiguration));
	var XHRPollingTransport = new transport_1["default"](Collections.extend({}, exports.pollingConfiguration, xhrConfiguration));
	var Transports = {
	    ws: WSTransport,
	    xhr_streaming: XHRStreamingTransport,
	    xhr_polling: XHRPollingTransport
	};
	exports.__esModule = true;
	exports["default"] = Transports;


/***/ },
/* 20 */
/***/ function(module, exports, __webpack_require__) {

	"use strict";
	var defaults_1 = __webpack_require__(5);
	function getGenericURL(baseScheme, params, path) {
	    var scheme = baseScheme + (params.encrypted ? "s" : "");
	    var host = params.encrypted ? params.hostEncrypted : params.hostUnencrypted;
	    return scheme + "://" + host + path;
	}
	function getGenericPath(key, queryString) {
	    var path = "/app/" + key;
	    var query = "?protocol=" + defaults_1["default"].PROTOCOL +
	        "&client=js" +
	        "&version=" + defaults_1["default"].VERSION +
	        (queryString ? ("&" + queryString) : "");
	    return path + query;
	}
	exports.ws = {
	    getInitial: function (key, params) {
	        return getGenericURL("ws", params, getGenericPath(key, "flash=false"));
	    }
	};
	exports.http = {
	    getInitial: function (key, params) {
	        var path = (params.httpPath || "/pusher") + getGenericPath(key);
	        return getGenericURL("http", params, path);
	    }
	};
	exports.sockjs = {
	    getInitial: function (key, params) {
	        return getGenericURL("http", params, params.httpPath || "/pusher");
	    },
	    getPath: function (key, params) {
	        return getGenericPath(key);
	    }
	};


/***/ },
/* 21 */
/***/ function(module, exports, __webpack_require__) {

	"use strict";
	var transport_connection_1 = __webpack_require__(22);
	var Transport = (function () {
	    function Transport(hooks) {
	        this.hooks = hooks;
	    }
	    Transport.prototype.isSupported = function (environment) {
	        return this.hooks.isSupported(environment);
	    };
	    Transport.prototype.createConnection = function (name, priority, key, options) {
	        return new transport_connection_1["default"](this.hooks, name, priority, key, options);
	    };
	    return Transport;
	}());
	exports.__esModule = true;
	exports["default"] = Transport;


/***/ },
/* 22 */
/***/ function(module, exports, __webpack_require__) {

	"use strict";
	var __extends = (this && this.__extends) || function (d, b) {
	    for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p];
	    function __() { this.constructor = d; }
	    d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
	};
	var util_1 = __webpack_require__(11);
	var Collections = __webpack_require__(9);
	var dispatcher_1 = __webpack_require__(23);
	var logger_1 = __webpack_require__(8);
	var runtime_1 = __webpack_require__(2);
	var TransportConnection = (function (_super) {
	    __extends(TransportConnection, _super);
	    function TransportConnection(hooks, name, priority, key, options) {
	        _super.call(this);
	        this.initialize = runtime_1["default"].transportConnectionInitializer;
	        this.hooks = hooks;
	        this.name = name;
	        this.priority = priority;
	        this.key = key;
	        this.options = options;
	        this.state = "new";
	        this.timeline = options.timeline;
	        this.activityTimeout = options.activityTimeout;
	        this.id = this.timeline.generateUniqueID();
	    }
	    TransportConnection.prototype.handlesActivityChecks = function () {
	        return Boolean(this.hooks.handlesActivityChecks);
	    };
	    TransportConnection.prototype.supportsPing = function () {
	        return Boolean(this.hooks.supportsPing);
	    };
	    TransportConnection.prototype.connect = function () {
	        var _this = this;
	        if (this.socket || this.state !== "initialized") {
	            return false;
	        }
	        var url = this.hooks.urls.getInitial(this.key, this.options);
	        try {
	            this.socket = this.hooks.getSocket(url, this.options);
	        }
	        catch (e) {
	            util_1["default"].defer(function () {
	                _this.onError(e);
	                _this.changeState("closed");
	            });
	            return false;
	        }
	        this.bindListeners();
	        logger_1["default"].debug("Connecting", { transport: this.name, url: url });
	        this.changeState("connecting");
	        return true;
	    };
	    TransportConnection.prototype.close = function () {
	        if (this.socket) {
	            this.socket.close();
	            return true;
	        }
	        else {
	            return false;
	        }
	    };
	    TransportConnection.prototype.send = function (data) {
	        var _this = this;
	        if (this.state === "open") {
	            util_1["default"].defer(function () {
	                if (_this.socket) {
	                    _this.socket.send(data);
	                }
	            });
	            return true;
	        }
	        else {
	            return false;
	        }
	    };
	    TransportConnection.prototype.ping = function () {
	        if (this.state === "open" && this.supportsPing()) {
	            this.socket.ping();
	        }
	    };
	    TransportConnection.prototype.onOpen = function () {
	        if (this.hooks.beforeOpen) {
	            this.hooks.beforeOpen(this.socket, this.hooks.urls.getPath(this.key, this.options));
	        }
	        this.changeState("open");
	        this.socket.onopen = undefined;
	    };
	    TransportConnection.prototype.onError = function (error) {
	        this.emit("error", { type: 'WebSocketError', error: error });
	        this.timeline.error(this.buildTimelineMessage({ error: error.toString() }));
	    };
	    TransportConnection.prototype.onClose = function (closeEvent) {
	        if (closeEvent) {
	            this.changeState("closed", {
	                code: closeEvent.code,
	                reason: closeEvent.reason,
	                wasClean: closeEvent.wasClean
	            });
	        }
	        else {
	            this.changeState("closed");
	        }
	        this.unbindListeners();
	        this.socket = undefined;
	    };
	    TransportConnection.prototype.onMessage = function (message) {
	        this.emit("message", message);
	    };
	    TransportConnection.prototype.onActivity = function () {
	        this.emit("activity");
	    };
	    TransportConnection.prototype.bindListeners = function () {
	        var _this = this;
	        this.socket.onopen = function () {
	            _this.onOpen();
	        };
	        this.socket.onerror = function (error) {
	            _this.onError(error);
	        };
	        this.socket.onclose = function (closeEvent) {
	            _this.onClose(closeEvent);
	        };
	        this.socket.onmessage = function (message) {
	            _this.onMessage(message);
	        };
	        if (this.supportsPing()) {
	            this.socket.onactivity = function () { _this.onActivity(); };
	        }
	    };
	    TransportConnection.prototype.unbindListeners = function () {
	        if (this.socket) {
	            this.socket.onopen = undefined;
	            this.socket.onerror = undefined;
	            this.socket.onclose = undefined;
	            this.socket.onmessage = undefined;
	            if (this.supportsPing()) {
	                this.socket.onactivity = undefined;
	            }
	        }
	    };
	    TransportConnection.prototype.changeState = function (state, params) {
	        this.state = state;
	        this.timeline.info(this.buildTimelineMessage({
	            state: state,
	            params: params
	        }));
	        this.emit(state, params);
	    };
	    TransportConnection.prototype.buildTimelineMessage = function (message) {
	        return Collections.extend({ cid: this.id }, message);
	    };
	    return TransportConnection;
	}(dispatcher_1["default"]));
	exports.__esModule = true;
	exports["default"] = TransportConnection;


/***/ },
/* 23 */
/***/ function(module, exports, __webpack_require__) {

	"use strict";
	var callback_registry_1 = __webpack_require__(24);
	var Dispatcher = (function () {
	    function Dispatcher(failThrough) {
	        this.callbacks = new callback_registry_1["default"]();
	        this.global_callbacks = [];
	        this.failThrough = failThrough;
	    }
	    Dispatcher.prototype.bind = function (eventName, callback, context) {
	        this.callbacks.add(eventName, callback, context);
	        return this;
	    };
	    Dispatcher.prototype.bind_all = function (callback) {
	        this.global_callbacks.push(callback);
	        return this;
	    };
	    Dispatcher.prototype.unbind = function (eventName, callback, context) {
	        this.callbacks.remove(eventName, callback, context);
	        return this;
	    };
	    Dispatcher.prototype.unbind_all = function (eventName, callback) {
	        this.callbacks.remove(eventName, callback);
	        return this;
	    };
	    Dispatcher.prototype.emit = function (eventName, data) {
	        var i;
	        for (i = 0; i < this.global_callbacks.length; i++) {
	            this.global_callbacks[i](eventName, data);
	        }
	        var callbacks = this.callbacks.get(eventName);
	        if (callbacks && callbacks.length > 0) {
	            for (i = 0; i < callbacks.length; i++) {
	                callbacks[i].fn.call(callbacks[i].context || (window), data);
	            }
	        }
	        else if (this.failThrough) {
	            this.failThrough(eventName, data);
	        }
	        return this;
	    };
	    return Dispatcher;
	}());
	exports.__esModule = true;
	exports["default"] = Dispatcher;


/***/ },
/* 24 */
/***/ function(module, exports, __webpack_require__) {

	"use strict";
	var Collections = __webpack_require__(9);
	var CallbackRegistry = (function () {
	    function CallbackRegistry() {
	        this._callbacks = {};
	    }
	    CallbackRegistry.prototype.get = function (name) {
	        return this._callbacks[prefix(name)];
	    };
	    CallbackRegistry.prototype.add = function (name, callback, context) {
	        var prefixedEventName = prefix(name);
	        this._callbacks[prefixedEventName] = this._callbacks[prefixedEventName] || [];
	        this._callbacks[prefixedEventName].push({
	            fn: callback,
	            context: context
	        });
	    };
	    CallbackRegistry.prototype.remove = function (name, callback, context) {
	        if (!name && !callback && !context) {
	            this._callbacks = {};
	            return;
	        }
	        var names = name ? [prefix(name)] : Collections.keys(this._callbacks);
	        if (callback || context) {
	            this.removeCallback(names, callback, context);
	        }
	        else {
	            this.removeAllCallbacks(names);
	        }
	    };
	    CallbackRegistry.prototype.removeCallback = function (names, callback, context) {
	        Collections.apply(names, function (name) {
	            this._callbacks[name] = Collections.filter(this._callbacks[name] || [], function (binding) {
	                return (callback && callback !== binding.fn) ||
	                    (context && context !== binding.context);
	            });
	            if (this._callbacks[name].length === 0) {
	                delete this._callbacks[name];
	            }
	        }, this);
	    };
	    CallbackRegistry.prototype.removeAllCallbacks = function (names) {
	        Collections.apply(names, function (name) {
	            delete this._callbacks[name];
	        }, this);
	    };
	    return CallbackRegistry;
	}());
	exports.__esModule = true;
	exports["default"] = CallbackRegistry;
	function prefix(name) {
	    return "_" + name;
	}


/***/ },
/* 25 */
/***/ function(module, exports, __webpack_require__) {

	"use strict";
	var __extends = (this && this.__extends) || function (d, b) {
	    for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p];
	    function __() { this.constructor = d; }
	    d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
	};
	var dispatcher_1 = __webpack_require__(23);
	var NetInfo = (function (_super) {
	    __extends(NetInfo, _super);
	    function NetInfo() {
	        _super.call(this);
	        var self = this;
	        if (window.addEventListener !== undefined) {
	            window.addEventListener("online", function () {
	                self.emit('online');
	            }, false);
	            window.addEventListener("offline", function () {
	                self.emit('offline');
	            }, false);
	        }
	    }
	    NetInfo.prototype.isOnline = function () {
	        if (window.navigator.onLine === undefined) {
	            return true;
	        }
	        else {
	            return window.navigator.onLine;
	        }
	    };
	    return NetInfo;
	}(dispatcher_1["default"]));
	exports.NetInfo = NetInfo;
	exports.Network = new NetInfo();


/***/ },
/* 26 */
/***/ function(module, exports) {

	"use strict";
	var getDefaultStrategy = function (config) {
	    var wsStrategy;
	    if (config.encrypted) {
	        wsStrategy = [
	            ":best_connected_ever",
	            ":ws_loop",
	            [":delayed", 2000, [":http_fallback_loop"]]
	        ];
	    }
	    else {
	        wsStrategy = [
	            ":best_connected_ever",
	            ":ws_loop",
	            [":delayed", 2000, [":wss_loop"]],
	            [":delayed", 5000, [":http_fallback_loop"]]
	        ];
	    }
	    return [
	        [":def", "ws_options", {
	                hostUnencrypted: config.wsHost + ":" + config.wsPort,
	                hostEncrypted: config.wsHost + ":" + config.wssPort
	            }],
	        [":def", "wss_options", [":extend", ":ws_options", {
	                    encrypted: true
	                }]],
	        [":def", "sockjs_options", {
	                hostUnencrypted: config.httpHost + ":" + config.httpPort,
	                hostEncrypted: config.httpHost + ":" + config.httpsPort,
	                httpPath: config.httpPath
	            }],
	        [":def", "timeouts", {
	                loop: true,
	                timeout: 15000,
	                timeoutLimit: 60000
	            }],
	        [":def", "ws_manager", [":transport_manager", {
	                    lives: 2,
	                    minPingDelay: 10000,
	                    maxPingDelay: config.activity_timeout
	                }]],
	        [":def", "streaming_manager", [":transport_manager", {
	                    lives: 2,
	                    minPingDelay: 10000,
	                    maxPingDelay: config.activity_timeout
	                }]],
	        [":def_transport", "ws", "ws", 3, ":ws_options", ":ws_manager"],
	        [":def_transport", "wss", "ws", 3, ":wss_options", ":ws_manager"],
	        [":def_transport", "sockjs", "sockjs", 1, ":sockjs_options"],
	        [":def_transport", "xhr_streaming", "xhr_streaming", 1, ":sockjs_options", ":streaming_manager"],
	        [":def_transport", "xdr_streaming", "xdr_streaming", 1, ":sockjs_options", ":streaming_manager"],
	        [":def_transport", "xhr_polling", "xhr_polling", 1, ":sockjs_options"],
	        [":def_transport", "xdr_polling", "xdr_polling", 1, ":sockjs_options"],
	        [":def", "ws_loop", [":sequential", ":timeouts", ":ws"]],
	        [":def", "wss_loop", [":sequential", ":timeouts", ":wss"]],
	        [":def", "sockjs_loop", [":sequential", ":timeouts", ":sockjs"]],
	        [":def", "streaming_loop", [":sequential", ":timeouts",
	                [":if", [":is_supported", ":xhr_streaming"],
	                    ":xhr_streaming",
	                    ":xdr_streaming"
	                ]
	            ]],
	        [":def", "polling_loop", [":sequential", ":timeouts",
	                [":if", [":is_supported", ":xhr_polling"],
	                    ":xhr_polling",
	                    ":xdr_polling"
	                ]
	            ]],
	        [":def", "http_loop", [":if", [":is_supported", ":streaming_loop"], [
	                    ":best_connected_ever",
	                    ":streaming_loop",
	                    [":delayed", 4000, [":polling_loop"]]
	                ], [
	                    ":polling_loop"
	                ]]],
	        [":def", "http_fallback_loop",
	            [":if", [":is_supported", ":http_loop"], [
	                    ":http_loop"
	                ], [
	                    ":sockjs_loop"
	                ]]
	        ],
	        [":def", "strategy",
	            [":cached", 1800000,
	                [":first_connected",
	                    [":if", [":is_supported", ":ws"],
	                        wsStrategy,
	                        ":http_fallback_loop"
	                    ]
	                ]
	            ]
	        ]
	    ];
	};
	exports.__esModule = true;
	exports["default"] = getDefaultStrategy;


/***/ },
/* 27 */
/***/ function(module, exports, __webpack_require__) {

	"use strict";
	var dependencies_1 = __webpack_require__(3);
	function default_1() {
	    var self = this;
	    self.timeline.info(self.buildTimelineMessage({
	        transport: self.name + (self.options.encrypted ? "s" : "")
	    }));
	    if (self.hooks.isInitialized()) {
	        self.changeState("initialized");
	    }
	    else if (self.hooks.file) {
	        self.changeState("initializing");
	        dependencies_1.Dependencies.load(self.hooks.file, { encrypted: self.options.encrypted }, function (error, callback) {
	            if (self.hooks.isInitialized()) {
	                self.changeState("initialized");
	                callback(true);
	            }
	            else {
	                if (error) {
	                    self.onError(error);
	                }
	                self.onClose();
	                callback(false);
	            }
	        });
	    }
	    else {
	        self.onClose();
	    }
	}
	exports.__esModule = true;
	exports["default"] = default_1;


/***/ },
/* 28 */
/***/ function(module, exports, __webpack_require__) {

	"use strict";
	var http_xdomain_request_1 = __webpack_require__(29);
	var http_1 = __webpack_require__(31);
	http_1["default"].createXDR = function (method, url) {
	    return this.createRequest(http_xdomain_request_1["default"], method, url);
	};
	exports.__esModule = true;
	exports["default"] = http_1["default"];


/***/ },
/* 29 */
/***/ function(module, exports, __webpack_require__) {

	"use strict";
	var Errors = __webpack_require__(30);
	var hooks = {
	    getRequest: function (socket) {
	        var xdr = new window.XDomainRequest();
	        xdr.ontimeout = function () {
	            socket.emit("error", new Errors.RequestTimedOut());
	            socket.close();
	        };
	        xdr.onerror = function (e) {
	            socket.emit("error", e);
	            socket.close();
	        };
	        xdr.onprogress = function () {
	            if (xdr.responseText && xdr.responseText.length > 0) {
	                socket.onChunk(200, xdr.responseText);
	            }
	        };
	        xdr.onload = function () {
	            if (xdr.responseText && xdr.responseText.length > 0) {
	                socket.onChunk(200, xdr.responseText);
	            }
	            socket.emit("finished", 200);
	            socket.close();
	        };
	        return xdr;
	    },
	    abortRequest: function (xdr) {
	        xdr.ontimeout = xdr.onerror = xdr.onprogress = xdr.onload = null;
	        xdr.abort();
	    }
	};
	exports.__esModule = true;
	exports["default"] = hooks;


/***/ },
/* 30 */
/***/ function(module, exports) {

	"use strict";
	var __extends = (this && this.__extends) || function (d, b) {
	    for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p];
	    function __() { this.constructor = d; }
	    d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
	};
	var BadEventName = (function (_super) {
	    __extends(BadEventName, _super);
	    function BadEventName() {
	        _super.apply(this, arguments);
	    }
	    return BadEventName;
	}(Error));
	exports.BadEventName = BadEventName;
	var RequestTimedOut = (function (_super) {
	    __extends(RequestTimedOut, _super);
	    function RequestTimedOut() {
	        _super.apply(this, arguments);
	    }
	    return RequestTimedOut;
	}(Error));
	exports.RequestTimedOut = RequestTimedOut;
	var TransportPriorityTooLow = (function (_super) {
	    __extends(TransportPriorityTooLow, _super);
	    function TransportPriorityTooLow() {
	        _super.apply(this, arguments);
	    }
	    return TransportPriorityTooLow;
	}(Error));
	exports.TransportPriorityTooLow = TransportPriorityTooLow;
	var TransportClosed = (function (_super) {
	    __extends(TransportClosed, _super);
	    function TransportClosed() {
	        _super.apply(this, arguments);
	    }
	    return TransportClosed;
	}(Error));
	exports.TransportClosed = TransportClosed;
	var UnsupportedTransport = (function (_super) {
	    __extends(UnsupportedTransport, _super);
	    function UnsupportedTransport() {
	        _super.apply(this, arguments);
	    }
	    return UnsupportedTransport;
	}(Error));
	exports.UnsupportedTransport = UnsupportedTransport;
	var UnsupportedStrategy = (function (_super) {
	    __extends(UnsupportedStrategy, _super);
	    function UnsupportedStrategy() {
	        _super.apply(this, arguments);
	    }
	    return UnsupportedStrategy;
	}(Error));
	exports.UnsupportedStrategy = UnsupportedStrategy;


/***/ },
/* 31 */
/***/ function(module, exports, __webpack_require__) {

	"use strict";
	var http_request_1 = __webpack_require__(32);
	var http_socket_1 = __webpack_require__(33);
	var http_streaming_socket_1 = __webpack_require__(35);
	var http_polling_socket_1 = __webpack_require__(36);
	var http_xhr_request_1 = __webpack_require__(37);
	var HTTP = {
	    createStreamingSocket: function (url) {
	        return this.createSocket(http_streaming_socket_1["default"], url);
	    },
	    createPollingSocket: function (url) {
	        return this.createSocket(http_polling_socket_1["default"], url);
	    },
	    createSocket: function (hooks, url) {
	        return new http_socket_1["default"](hooks, url);
	    },
	    createXHR: function (method, url) {
	        return this.createRequest(http_xhr_request_1["default"], method, url);
	    },
	    createRequest: function (hooks, method, url) {
	        return new http_request_1["default"](hooks, method, url);
	    }
	};
	exports.__esModule = true;
	exports["default"] = HTTP;


/***/ },
/* 32 */
/***/ function(module, exports, __webpack_require__) {

	"use strict";
	var __extends = (this && this.__extends) || function (d, b) {
	    for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p];
	    function __() { this.constructor = d; }
	    d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
	};
	var runtime_1 = __webpack_require__(2);
	var dispatcher_1 = __webpack_require__(23);
	var MAX_BUFFER_LENGTH = 256 * 1024;
	var HTTPRequest = (function (_super) {
	    __extends(HTTPRequest, _super);
	    function HTTPRequest(hooks, method, url) {
	        _super.call(this);
	        this.hooks = hooks;
	        this.method = method;
	        this.url = url;
	    }
	    HTTPRequest.prototype.start = function (payload) {
	        var _this = this;
	        this.position = 0;
	        this.xhr = this.hooks.getRequest(this);
	        this.unloader = function () {
	            _this.close();
	        };
	        runtime_1["default"].addUnloadListener(this.unloader);
	        this.xhr.open(this.method, this.url, true);
	        if (this.xhr.setRequestHeader) {
	            this.xhr.setRequestHeader("Content-Type", "application/json");
	        }
	        this.xhr.send(payload);
	    };
	    HTTPRequest.prototype.close = function () {
	        if (this.unloader) {
	            runtime_1["default"].removeUnloadListener(this.unloader);
	            this.unloader = null;
	        }
	        if (this.xhr) {
	            this.hooks.abortRequest(this.xhr);
	            this.xhr = null;
	        }
	    };
	    HTTPRequest.prototype.onChunk = function (status, data) {
	        while (true) {
	            var chunk = this.advanceBuffer(data);
	            if (chunk) {
	                this.emit("chunk", { status: status, data: chunk });
	            }
	            else {
	                break;
	            }
	        }
	        if (this.isBufferTooLong(data)) {
	            this.emit("buffer_too_long");
	        }
	    };
	    HTTPRequest.prototype.advanceBuffer = function (buffer) {
	        var unreadData = buffer.slice(this.position);
	        var endOfLinePosition = unreadData.indexOf("\n");
	        if (endOfLinePosition !== -1) {
	            this.position += endOfLinePosition + 1;
	            return unreadData.slice(0, endOfLinePosition);
	        }
	        else {
	            return null;
	        }
	    };
	    HTTPRequest.prototype.isBufferTooLong = function (buffer) {
	        return this.position === buffer.length && buffer.length > MAX_BUFFER_LENGTH;
	    };
	    return HTTPRequest;
	}(dispatcher_1["default"]));
	exports.__esModule = true;
	exports["default"] = HTTPRequest;


/***/ },
/* 33 */
/***/ function(module, exports, __webpack_require__) {

	"use strict";
	var state_1 = __webpack_require__(34);
	var util_1 = __webpack_require__(11);
	var runtime_1 = __webpack_require__(2);
	var autoIncrement = 1;
	var HTTPSocket = (function () {
	    function HTTPSocket(hooks, url) {
	        this.hooks = hooks;
	        this.session = randomNumber(1000) + "/" + randomString(8);
	        this.location = getLocation(url);
	        this.readyState = state_1["default"].CONNECTING;
	        this.openStream();
	    }
	    HTTPSocket.prototype.send = function (payload) {
	        return this.sendRaw(JSON.stringify([payload]));
	    };
	    HTTPSocket.prototype.ping = function () {
	        this.hooks.sendHeartbeat(this);
	    };
	    HTTPSocket.prototype.close = function (code, reason) {
	        this.onClose(code, reason, true);
	    };
	    HTTPSocket.prototype.sendRaw = function (payload) {
	        if (this.readyState === state_1["default"].OPEN) {
	            try {
	                runtime_1["default"].createSocketRequest("POST", getUniqueURL(getSendURL(this.location, this.session))).start(payload);
	                return true;
	            }
	            catch (e) {
	                return false;
	            }
	        }
	        else {
	            return false;
	        }
	    };
	    HTTPSocket.prototype.reconnect = function () {
	        this.closeStream();
	        this.openStream();
	    };
	    ;
	    HTTPSocket.prototype.onClose = function (code, reason, wasClean) {
	        this.closeStream();
	        this.readyState = state_1["default"].CLOSED;
	        if (this.onclose) {
	            this.onclose({
	                code: code,
	                reason: reason,
	                wasClean: wasClean
	            });
	        }
	    };
	    HTTPSocket.prototype.onChunk = function (chunk) {
	        if (chunk.status !== 200) {
	            return;
	        }
	        if (this.readyState === state_1["default"].OPEN) {
	            this.onActivity();
	        }
	        var payload;
	        var type = chunk.data.slice(0, 1);
	        switch (type) {
	            case 'o':
	                payload = JSON.parse(chunk.data.slice(1) || '{}');
	                this.onOpen(payload);
	                break;
	            case 'a':
	                payload = JSON.parse(chunk.data.slice(1) || '[]');
	                for (var i = 0; i < payload.length; i++) {
	                    this.onEvent(payload[i]);
	                }
	                break;
	            case 'm':
	                payload = JSON.parse(chunk.data.slice(1) || 'null');
	                this.onEvent(payload);
	                break;
	            case 'h':
	                this.hooks.onHeartbeat(this);
	                break;
	            case 'c':
	                payload = JSON.parse(chunk.data.slice(1) || '[]');
	                this.onClose(payload[0], payload[1], true);
	                break;
	        }
	    };
	    HTTPSocket.prototype.onOpen = function (options) {
	        if (this.readyState === state_1["default"].CONNECTING) {
	            if (options && options.hostname) {
	                this.location.base = replaceHost(this.location.base, options.hostname);
	            }
	            this.readyState = state_1["default"].OPEN;
	            if (this.onopen) {
	                this.onopen();
	            }
	        }
	        else {
	            this.onClose(1006, "Server lost session", true);
	        }
	    };
	    HTTPSocket.prototype.onEvent = function (event) {
	        if (this.readyState === state_1["default"].OPEN && this.onmessage) {
	            this.onmessage({ data: event });
	        }
	    };
	    HTTPSocket.prototype.onActivity = function () {
	        if (this.onactivity) {
	            this.onactivity();
	        }
	    };
	    HTTPSocket.prototype.onError = function (error) {
	        if (this.onerror) {
	            this.onerror(error);
	        }
	    };
	    HTTPSocket.prototype.openStream = function () {
	        var _this = this;
	        this.stream = runtime_1["default"].createSocketRequest("POST", getUniqueURL(this.hooks.getReceiveURL(this.location, this.session)));
	        this.stream.bind("chunk", function (chunk) {
	            _this.onChunk(chunk);
	        });
	        this.stream.bind("finished", function (status) {
	            _this.hooks.onFinished(_this, status);
	        });
	        this.stream.bind("buffer_too_long", function () {
	            _this.reconnect();
	        });
	        try {
	            this.stream.start();
	        }
	        catch (error) {
	            util_1["default"].defer(function () {
	                _this.onError(error);
	                _this.onClose(1006, "Could not start streaming", false);
	            });
	        }
	    };
	    HTTPSocket.prototype.closeStream = function () {
	        if (this.stream) {
	            this.stream.unbind_all();
	            this.stream.close();
	            this.stream = null;
	        }
	    };
	    return HTTPSocket;
	}());
	function getLocation(url) {
	    var parts = /([^\?]*)\/*(\??.*)/.exec(url);
	    return {
	        base: parts[1],
	        queryString: parts[2]
	    };
	}
	function getSendURL(url, session) {
	    return url.base + "/" + session + "/xhr_send";
	}
	function getUniqueURL(url) {
	    var separator = (url.indexOf('?') === -1) ? "?" : "&";
	    return url + separator + "t=" + (+new Date()) + "&n=" + autoIncrement++;
	}
	function replaceHost(url, hostname) {
	    var urlParts = /(https?:\/\/)([^\/:]+)((\/|:)?.*)/.exec(url);
	    return urlParts[1] + hostname + urlParts[3];
	}
	function randomNumber(max) {
	    return Math.floor(Math.random() * max);
	}
	function randomString(length) {
	    var result = [];
	    for (var i = 0; i < length; i++) {
	        result.push(randomNumber(32).toString(32));
	    }
	    return result.join('');
	}
	exports.__esModule = true;
	exports["default"] = HTTPSocket;


/***/ },
/* 34 */
/***/ function(module, exports) {

	"use strict";
	var State;
	(function (State) {
	    State[State["CONNECTING"] = 0] = "CONNECTING";
	    State[State["OPEN"] = 1] = "OPEN";
	    State[State["CLOSED"] = 3] = "CLOSED";
	})(State || (State = {}));
	exports.__esModule = true;
	exports["default"] = State;


/***/ },
/* 35 */
/***/ function(module, exports) {

	"use strict";
	var hooks = {
	    getReceiveURL: function (url, session) {
	        return url.base + "/" + session + "/xhr_streaming" + url.queryString;
	    },
	    onHeartbeat: function (socket) {
	        socket.sendRaw("[]");
	    },
	    sendHeartbeat: function (socket) {
	        socket.sendRaw("[]");
	    },
	    onFinished: function (socket, status) {
	        socket.onClose(1006, "Connection interrupted (" + status + ")", false);
	    }
	};
	exports.__esModule = true;
	exports["default"] = hooks;


/***/ },
/* 36 */
/***/ function(module, exports) {

	"use strict";
	var hooks = {
	    getReceiveURL: function (url, session) {
	        return url.base + "/" + session + "/xhr" + url.queryString;
	    },
	    onHeartbeat: function () {
	    },
	    sendHeartbeat: function (socket) {
	        socket.sendRaw("[]");
	    },
	    onFinished: function (socket, status) {
	        if (status === 200) {
	            socket.reconnect();
	        }
	        else {
	            socket.onClose(1006, "Connection interrupted (" + status + ")", false);
	        }
	    }
	};
	exports.__esModule = true;
	exports["default"] = hooks;


/***/ },
/* 37 */
/***/ function(module, exports, __webpack_require__) {

	"use strict";
	var runtime_1 = __webpack_require__(2);
	var hooks = {
	    getRequest: function (socket) {
	        var Constructor = runtime_1["default"].getXHRAPI();
	        var xhr = new Constructor();
	        xhr.onreadystatechange = xhr.onprogress = function () {
	            switch (xhr.readyState) {
	                case 3:
	                    if (xhr.responseText && xhr.responseText.length > 0) {
	                        socket.onChunk(xhr.status, xhr.responseText);
	                    }
	                    break;
	                case 4:
	                    if (xhr.responseText && xhr.responseText.length > 0) {
	                        socket.onChunk(xhr.status, xhr.responseText);
	                    }
	                    socket.emit("finished", xhr.status);
	                    socket.close();
	                    break;
	            }
	        };
	        return xhr;
	    },
	    abortRequest: function (xhr) {
	        xhr.onreadystatechange = null;
	        xhr.abort();
	    }
	};
	exports.__esModule = true;
	exports["default"] = hooks;


/***/ },
/* 38 */
/***/ function(module, exports, __webpack_require__) {

	"use strict";
	var Collections = __webpack_require__(9);
	var util_1 = __webpack_require__(11);
	var level_1 = __webpack_require__(39);
	var Timeline = (function () {
	    function Timeline(key, session, options) {
	        this.key = key;
	        this.session = session;
	        this.events = [];
	        this.options = options || {};
	        this.sent = 0;
	        this.uniqueID = 0;
	    }
	    Timeline.prototype.log = function (level, event) {
	        if (level <= this.options.level) {
	            this.events.push(Collections.extend({}, event, { timestamp: util_1["default"].now() }));
	            if (this.options.limit && this.events.length > this.options.limit) {
	                this.events.shift();
	            }
	        }
	    };
	    Timeline.prototype.error = function (event) {
	        this.log(level_1["default"].ERROR, event);
	    };
	    Timeline.prototype.info = function (event) {
	        this.log(level_1["default"].INFO, event);
	    };
	    Timeline.prototype.debug = function (event) {
	        this.log(level_1["default"].DEBUG, event);
	    };
	    Timeline.prototype.isEmpty = function () {
	        return this.events.length === 0;
	    };
	    Timeline.prototype.send = function (sendfn, callback) {
	        var _this = this;
	        var data = Collections.extend({
	            session: this.session,
	            bundle: this.sent + 1,
	            key: this.key,
	            lib: "js",
	            version: this.options.version,
	            cluster: this.options.cluster,
	            features: this.options.features,
	            timeline: this.events
	        }, this.options.params);
	        this.events = [];
	        sendfn(data, function (error, result) {
	            if (!error) {
	                _this.sent++;
	            }
	            if (callback) {
	                callback(error, result);
	            }
	        });
	        return true;
	    };
	    Timeline.prototype.generateUniqueID = function () {
	        this.uniqueID++;
	        return this.uniqueID;
	    };
	    return Timeline;
	}());
	exports.__esModule = true;
	exports["default"] = Timeline;


/***/ },
/* 39 */
/***/ function(module, exports) {

	"use strict";
	var TimelineLevel;
	(function (TimelineLevel) {
	    TimelineLevel[TimelineLevel["ERROR"] = 3] = "ERROR";
	    TimelineLevel[TimelineLevel["INFO"] = 6] = "INFO";
	    TimelineLevel[TimelineLevel["DEBUG"] = 7] = "DEBUG";
	})(TimelineLevel || (TimelineLevel = {}));
	exports.__esModule = true;
	exports["default"] = TimelineLevel;


/***/ },
/* 40 */
/***/ function(module, exports, __webpack_require__) {

	"use strict";
	var Collections = __webpack_require__(9);
	var util_1 = __webpack_require__(11);
	var transport_manager_1 = __webpack_require__(41);
	var Errors = __webpack_require__(30);
	var transport_strategy_1 = __webpack_require__(55);
	var sequential_strategy_1 = __webpack_require__(56);
	var best_connected_ever_strategy_1 = __webpack_require__(57);
	var cached_strategy_1 = __webpack_require__(58);
	var delayed_strategy_1 = __webpack_require__(59);
	var if_strategy_1 = __webpack_require__(60);
	var first_connected_strategy_1 = __webpack_require__(61);
	var runtime_1 = __webpack_require__(2);
	var Transports = runtime_1["default"].Transports;
	exports.build = function (scheme, options) {
	    var context = Collections.extend({}, globalContext, options);
	    return evaluate(scheme, context)[1].strategy;
	};
	var UnsupportedStrategy = {
	    isSupported: function () {
	        return false;
	    },
	    connect: function (_, callback) {
	        var deferred = util_1["default"].defer(function () {
	            callback(new Errors.UnsupportedStrategy());
	        });
	        return {
	            abort: function () {
	                deferred.ensureAborted();
	            },
	            forceMinPriority: function () { }
	        };
	    }
	};
	function returnWithOriginalContext(f) {
	    return function (context) {
	        return [f.apply(this, arguments), context];
	    };
	}
	var globalContext = {
	    extend: function (context, first, second) {
	        return [Collections.extend({}, first, second), context];
	    },
	    def: function (context, name, value) {
	        if (context[name] !== undefined) {
	            throw "Redefining symbol " + name;
	        }
	        context[name] = value;
	        return [undefined, context];
	    },
	    def_transport: function (context, name, type, priority, options, manager) {
	        var transportClass = Transports[type];
	        if (!transportClass) {
	            throw new Errors.UnsupportedTransport(type);
	        }
	        var enabled = (!context.enabledTransports ||
	            Collections.arrayIndexOf(context.enabledTransports, name) !== -1) &&
	            (!context.disabledTransports ||
	                Collections.arrayIndexOf(context.disabledTransports, name) === -1);
	        var transport;
	        if (enabled) {
	            transport = new transport_strategy_1["default"](name, priority, manager ? manager.getAssistant(transportClass) : transportClass, Collections.extend({
	                key: context.key,
	                encrypted: context.encrypted,
	                timeline: context.timeline,
	                ignoreNullOrigin: context.ignoreNullOrigin
	            }, options));
	        }
	        else {
	            transport = UnsupportedStrategy;
	        }
	        var newContext = context.def(context, name, transport)[1];
	        newContext.Transports = context.Transports || {};
	        newContext.Transports[name] = transport;
	        return [undefined, newContext];
	    },
	    transport_manager: returnWithOriginalContext(function (_, options) {
	        return new transport_manager_1["default"](options);
	    }),
	    sequential: returnWithOriginalContext(function (_, options) {
	        var strategies = Array.prototype.slice.call(arguments, 2);
	        return new sequential_strategy_1["default"](strategies, options);
	    }),
	    cached: returnWithOriginalContext(function (context, ttl, strategy) {
	        return new cached_strategy_1["default"](strategy, context.Transports, {
	            ttl: ttl,
	            timeline: context.timeline,
	            encrypted: context.encrypted
	        });
	    }),
	    first_connected: returnWithOriginalContext(function (_, strategy) {
	        return new first_connected_strategy_1["default"](strategy);
	    }),
	    best_connected_ever: returnWithOriginalContext(function () {
	        var strategies = Array.prototype.slice.call(arguments, 1);
	        return new best_connected_ever_strategy_1["default"](strategies);
	    }),
	    delayed: returnWithOriginalContext(function (_, delay, strategy) {
	        return new delayed_strategy_1["default"](strategy, { delay: delay });
	    }),
	    "if": returnWithOriginalContext(function (_, test, trueBranch, falseBranch) {
	        return new if_strategy_1["default"](test, trueBranch, falseBranch);
	    }),
	    is_supported: returnWithOriginalContext(function (_, strategy) {
	        return function () {
	            return strategy.isSupported();
	        };
	    })
	};
	function isSymbol(expression) {
	    return (typeof expression === "string") && expression.charAt(0) === ":";
	}
	function getSymbolValue(expression, context) {
	    return context[expression.slice(1)];
	}
	function evaluateListOfExpressions(expressions, context) {
	    if (expressions.length === 0) {
	        return [[], context];
	    }
	    var head = evaluate(expressions[0], context);
	    var tail = evaluateListOfExpressions(expressions.slice(1), head[1]);
	    return [[head[0]].concat(tail[0]), tail[1]];
	}
	function evaluateString(expression, context) {
	    if (!isSymbol(expression)) {
	        return [expression, context];
	    }
	    var value = getSymbolValue(expression, context);
	    if (value === undefined) {
	        throw "Undefined symbol " + expression;
	    }
	    return [value, context];
	}
	function evaluateArray(expression, context) {
	    if (isSymbol(expression[0])) {
	        var f = getSymbolValue(expression[0], context);
	        if (expression.length > 1) {
	            if (typeof f !== "function") {
	                throw "Calling non-function " + expression[0];
	            }
	            var args = [Collections.extend({}, context)].concat(Collections.map(expression.slice(1), function (arg) {
	                return evaluate(arg, Collections.extend({}, context))[0];
	            }));
	            return f.apply(this, args);
	        }
	        else {
	            return [f, context];
	        }
	    }
	    else {
	        return evaluateListOfExpressions(expression, context);
	    }
	}
	function evaluate(expression, context) {
	    if (typeof expression === "string") {
	        return evaluateString(expression, context);
	    }
	    else if (typeof expression === "object") {
	        if (expression instanceof Array && expression.length > 0) {
	            return evaluateArray(expression, context);
	        }
	    }
	    return [expression, context];
	}


/***/ },
/* 41 */
/***/ function(module, exports, __webpack_require__) {

	"use strict";
	var factory_1 = __webpack_require__(42);
	var TransportManager = (function () {
	    function TransportManager(options) {
	        this.options = options || {};
	        this.livesLeft = this.options.lives || Infinity;
	    }
	    TransportManager.prototype.getAssistant = function (transport) {
	        return factory_1["default"].createAssistantToTheTransportManager(this, transport, {
	            minPingDelay: this.options.minPingDelay,
	            maxPingDelay: this.options.maxPingDelay
	        });
	    };
	    TransportManager.prototype.isAlive = function () {
	        return this.livesLeft > 0;
	    };
	    TransportManager.prototype.reportDeath = function () {
	        this.livesLeft -= 1;
	    };
	    return TransportManager;
	}());
	exports.__esModule = true;
	exports["default"] = TransportManager;


/***/ },
/* 42 */
/***/ function(module, exports, __webpack_require__) {

	"use strict";
	var assistant_to_the_transport_manager_1 = __webpack_require__(43);
	var handshake_1 = __webpack_require__(44);
	var pusher_authorizer_1 = __webpack_require__(47);
	var timeline_sender_1 = __webpack_require__(48);
	var presence_channel_1 = __webpack_require__(49);
	var private_channel_1 = __webpack_require__(50);
	var channel_1 = __webpack_require__(51);
	var connection_manager_1 = __webpack_require__(53);
	var channels_1 = __webpack_require__(54);
	var Factory = {
	    createChannels: function () {
	        return new channels_1["default"]();
	    },
	    createConnectionManager: function (key, options) {
	        return new connection_manager_1["default"](key, options);
	    },
	    createChannel: function (name, pusher) {
	        return new channel_1["default"](name, pusher);
	    },
	    createPrivateChannel: function (name, pusher) {
	        return new private_channel_1["default"](name, pusher);
	    },
	    createPresenceChannel: function (name, pusher) {
	        return new presence_channel_1["default"](name, pusher);
	    },
	    createTimelineSender: function (timeline, options) {
	        return new timeline_sender_1["default"](timeline, options);
	    },
	    createAuthorizer: function (channel, options) {
	        return new pusher_authorizer_1["default"](channel, options);
	    },
	    createHandshake: function (transport, callback) {
	        return new handshake_1["default"](transport, callback);
	    },
	    createAssistantToTheTransportManager: function (manager, transport, options) {
	        return new assistant_to_the_transport_manager_1["default"](manager, transport, options);
	    }
	};
	exports.__esModule = true;
	exports["default"] = Factory;


/***/ },
/* 43 */
/***/ function(module, exports, __webpack_require__) {

	"use strict";
	var util_1 = __webpack_require__(11);
	var Collections = __webpack_require__(9);
	var AssistantToTheTransportManager = (function () {
	    function AssistantToTheTransportManager(manager, transport, options) {
	        this.manager = manager;
	        this.transport = transport;
	        this.minPingDelay = options.minPingDelay;
	        this.maxPingDelay = options.maxPingDelay;
	        this.pingDelay = undefined;
	    }
	    AssistantToTheTransportManager.prototype.createConnection = function (name, priority, key, options) {
	        var _this = this;
	        options = Collections.extend({}, options, {
	            activityTimeout: this.pingDelay
	        });
	        var connection = this.transport.createConnection(name, priority, key, options);
	        var openTimestamp = null;
	        var onOpen = function () {
	            connection.unbind("open", onOpen);
	            connection.bind("closed", onClosed);
	            openTimestamp = util_1["default"].now();
	        };
	        var onClosed = function (closeEvent) {
	            connection.unbind("closed", onClosed);
	            if (closeEvent.code === 1002 || closeEvent.code === 1003) {
	                _this.manager.reportDeath();
	            }
	            else if (!closeEvent.wasClean && openTimestamp) {
	                var lifespan = util_1["default"].now() - openTimestamp;
	                if (lifespan < 2 * _this.maxPingDelay) {
	                    _this.manager.reportDeath();
	                    _this.pingDelay = Math.max(lifespan / 2, _this.minPingDelay);
	                }
	            }
	        };
	        connection.bind("open", onOpen);
	        return connection;
	    };
	    AssistantToTheTransportManager.prototype.isSupported = function (environment) {
	        return this.manager.isAlive() && this.transport.isSupported(environment);
	    };
	    return AssistantToTheTransportManager;
	}());
	exports.__esModule = true;
	exports["default"] = AssistantToTheTransportManager;


/***/ },
/* 44 */
/***/ function(module, exports, __webpack_require__) {

	"use strict";
	var Collections = __webpack_require__(9);
	var Protocol = __webpack_require__(45);
	var connection_1 = __webpack_require__(46);
	var Handshake = (function () {
	    function Handshake(transport, callback) {
	        this.transport = transport;
	        this.callback = callback;
	        this.bindListeners();
	    }
	    Handshake.prototype.close = function () {
	        this.unbindListeners();
	        this.transport.close();
	    };
	    Handshake.prototype.bindListeners = function () {
	        var _this = this;
	        this.onMessage = function (m) {
	            _this.unbindListeners();
	            var result;
	            try {
	                result = Protocol.processHandshake(m);
	            }
	            catch (e) {
	                _this.finish("error", { error: e });
	                _this.transport.close();
	                return;
	            }
	            if (result.action === "connected") {
	                _this.finish("connected", {
	                    connection: new connection_1["default"](result.id, _this.transport),
	                    activityTimeout: result.activityTimeout
	                });
	            }
	            else {
	                _this.finish(result.action, { error: result.error });
	                _this.transport.close();
	            }
	        };
	        this.onClosed = function (closeEvent) {
	            _this.unbindListeners();
	            var action = Protocol.getCloseAction(closeEvent) || "backoff";
	            var error = Protocol.getCloseError(closeEvent);
	            _this.finish(action, { error: error });
	        };
	        this.transport.bind("message", this.onMessage);
	        this.transport.bind("closed", this.onClosed);
	    };
	    Handshake.prototype.unbindListeners = function () {
	        this.transport.unbind("message", this.onMessage);
	        this.transport.unbind("closed", this.onClosed);
	    };
	    Handshake.prototype.finish = function (action, params) {
	        this.callback(Collections.extend({ transport: this.transport, action: action }, params));
	    };
	    return Handshake;
	}());
	exports.__esModule = true;
	exports["default"] = Handshake;


/***/ },
/* 45 */
/***/ function(module, exports) {

	"use strict";
	exports.decodeMessage = function (message) {
	    try {
	        var params = JSON.parse(message.data);
	        if (typeof params.data === 'string') {
	            try {
	                params.data = JSON.parse(params.data);
	            }
	            catch (e) {
	                if (!(e instanceof SyntaxError)) {
	                    throw e;
	                }
	            }
	        }
	        return params;
	    }
	    catch (e) {
	        throw { type: 'MessageParseError', error: e, data: message.data };
	    }
	};
	exports.encodeMessage = function (message) {
	    return JSON.stringify(message);
	};
	exports.processHandshake = function (message) {
	    message = exports.decodeMessage(message);
	    if (message.event === "pusher:connection_established") {
	        if (!message.data.activity_timeout) {
	            throw "No activity timeout specified in handshake";
	        }
	        return {
	            action: "connected",
	            id: message.data.socket_id,
	            activityTimeout: message.data.activity_timeout * 1000
	        };
	    }
	    else if (message.event === "pusher:error") {
	        return {
	            action: this.getCloseAction(message.data),
	            error: this.getCloseError(message.data)
	        };
	    }
	    else {
	        throw "Invalid handshake";
	    }
	};
	exports.getCloseAction = function (closeEvent) {
	    if (closeEvent.code < 4000) {
	        if (closeEvent.code >= 1002 && closeEvent.code <= 1004) {
	            return "backoff";
	        }
	        else {
	            return null;
	        }
	    }
	    else if (closeEvent.code === 4000) {
	        return "ssl_only";
	    }
	    else if (closeEvent.code < 4100) {
	        return "refused";
	    }
	    else if (closeEvent.code < 4200) {
	        return "backoff";
	    }
	    else if (closeEvent.code < 4300) {
	        return "retry";
	    }
	    else {
	        return "refused";
	    }
	};
	exports.getCloseError = function (closeEvent) {
	    if (closeEvent.code !== 1000 && closeEvent.code !== 1001) {
	        return {
	            type: 'PusherError',
	            data: {
	                code: closeEvent.code,
	                message: closeEvent.reason || closeEvent.message
	            }
	        };
	    }
	    else {
	        return null;
	    }
	};


/***/ },
/* 46 */
/***/ function(module, exports, __webpack_require__) {

	"use strict";
	var __extends = (this && this.__extends) || function (d, b) {
	    for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p];
	    function __() { this.constructor = d; }
	    d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
	};
	var Collections = __webpack_require__(9);
	var dispatcher_1 = __webpack_require__(23);
	var Protocol = __webpack_require__(45);
	var logger_1 = __webpack_require__(8);
	var Connection = (function (_super) {
	    __extends(Connection, _super);
	    function Connection(id, transport) {
	        _super.call(this);
	        this.id = id;
	        this.transport = transport;
	        this.activityTimeout = transport.activityTimeout;
	        this.bindListeners();
	    }
	    Connection.prototype.handlesActivityChecks = function () {
	        return this.transport.handlesActivityChecks();
	    };
	    Connection.prototype.send = function (data) {
	        return this.transport.send(data);
	    };
	    Connection.prototype.send_event = function (name, data, channel) {
	        var message = { event: name, data: data };
	        if (channel) {
	            message.channel = channel;
	        }
	        logger_1["default"].debug('Event sent', message);
	        return this.send(Protocol.encodeMessage(message));
	    };
	    Connection.prototype.ping = function () {
	        if (this.transport.supportsPing()) {
	            this.transport.ping();
	        }
	        else {
	            this.send_event('pusher:ping', {});
	        }
	    };
	    Connection.prototype.close = function () {
	        this.transport.close();
	    };
	    Connection.prototype.bindListeners = function () {
	        var _this = this;
	        var listeners = {
	            message: function (m) {
	                var message;
	                try {
	                    message = Protocol.decodeMessage(m);
	                }
	                catch (e) {
	                    _this.emit('error', {
	                        type: 'MessageParseError',
	                        error: e,
	                        data: m.data
	                    });
	                }
	                if (message !== undefined) {
	                    logger_1["default"].debug('Event recd', message);
	                    switch (message.event) {
	                        case 'pusher:error':
	                            _this.emit('error', { type: 'PusherError', data: message.data });
	                            break;
	                        case 'pusher:ping':
	                            _this.emit("ping");
	                            break;
	                        case 'pusher:pong':
	                            _this.emit("pong");
	                            break;
	                    }
	                    _this.emit('message', message);
	                }
	            },
	            activity: function () {
	                _this.emit("activity");
	            },
	            error: function (error) {
	                _this.emit("error", { type: "WebSocketError", error: error });
	            },
	            closed: function (closeEvent) {
	                unbindListeners();
	                if (closeEvent && closeEvent.code) {
	                    _this.handleCloseEvent(closeEvent);
	                }
	                _this.transport = null;
	                _this.emit("closed");
	            }
	        };
	        var unbindListeners = function () {
	            Collections.objectApply(listeners, function (listener, event) {
	                _this.transport.unbind(event, listener);
	            });
	        };
	        Collections.objectApply(listeners, function (listener, event) {
	            _this.transport.bind(event, listener);
	        });
	    };
	    Connection.prototype.handleCloseEvent = function (closeEvent) {
	        var action = Protocol.getCloseAction(closeEvent);
	        var error = Protocol.getCloseError(closeEvent);
	        if (error) {
	            this.emit('error', error);
	        }
	        if (action) {
	            this.emit(action);
	        }
	    };
	    return Connection;
	}(dispatcher_1["default"]));
	exports.__esModule = true;
	exports["default"] = Connection;


/***/ },
/* 47 */
/***/ function(module, exports, __webpack_require__) {

	"use strict";
	var runtime_1 = __webpack_require__(2);
	var Authorizer = (function () {
	    function Authorizer(channel, options) {
	        this.channel = channel;
	        var authTransport = options.authTransport;
	        if (typeof runtime_1["default"].getAuthorizers()[authTransport] === "undefined") {
	            throw "'" + authTransport + "' is not a recognized auth transport";
	        }
	        this.type = authTransport;
	        this.options = options;
	        this.authOptions = (options || {}).auth || {};
	    }
	    Authorizer.prototype.composeQuery = function (socketId) {
	        var query = 'socket_id=' + encodeURIComponent(socketId) +
	            '&channel_name=' + encodeURIComponent(this.channel.name);
	        for (var i in this.authOptions.params) {
	            query += "&" + encodeURIComponent(i) + "=" + encodeURIComponent(this.authOptions.params[i]);
	        }
	        return query;
	    };
	    Authorizer.prototype.authorize = function (socketId, callback) {
	        Authorizer.authorizers = Authorizer.authorizers || runtime_1["default"].getAuthorizers();
	        return Authorizer.authorizers[this.type].call(this, runtime_1["default"], socketId, callback);
	    };
	    return Authorizer;
	}());
	exports.__esModule = true;
	exports["default"] = Authorizer;


/***/ },
/* 48 */
/***/ function(module, exports, __webpack_require__) {

	"use strict";
	var runtime_1 = __webpack_require__(2);
	var TimelineSender = (function () {
	    function TimelineSender(timeline, options) {
	        this.timeline = timeline;
	        this.options = options || {};
	    }
	    TimelineSender.prototype.send = function (encrypted, callback) {
	        if (this.timeline.isEmpty()) {
	            return;
	        }
	        this.timeline.send(runtime_1["default"].TimelineTransport.getAgent(this, encrypted), callback);
	    };
	    return TimelineSender;
	}());
	exports.__esModule = true;
	exports["default"] = TimelineSender;


/***/ },
/* 49 */
/***/ function(module, exports, __webpack_require__) {

	"use strict";
	var __extends = (this && this.__extends) || function (d, b) {
	    for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p];
	    function __() { this.constructor = d; }
	    d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
	};
	var private_channel_1 = __webpack_require__(50);
	var logger_1 = __webpack_require__(8);
	var members_1 = __webpack_require__(52);
	var PresenceChannel = (function (_super) {
	    __extends(PresenceChannel, _super);
	    function PresenceChannel(name, pusher) {
	        _super.call(this, name, pusher);
	        this.members = new members_1["default"]();
	    }
	    PresenceChannel.prototype.authorize = function (socketId, callback) {
	        var _this = this;
	        _super.prototype.authorize.call(this, socketId, function (error, authData) {
	            if (!error) {
	                if (authData.channel_data === undefined) {
	                    logger_1["default"].warn("Invalid auth response for channel '" +
	                        _this.name +
	                        "', expected 'channel_data' field");
	                    callback("Invalid auth response");
	                    return;
	                }
	                var channelData = JSON.parse(authData.channel_data);
	                _this.members.setMyID(channelData.user_id);
	            }
	            callback(error, authData);
	        });
	    };
	    PresenceChannel.prototype.handleEvent = function (event, data) {
	        switch (event) {
	            case "pusher_internal:subscription_succeeded":
	                this.subscriptionPending = false;
	                this.subscribed = true;
	                if (this.subscriptionCancelled) {
	                    this.pusher.unsubscribe(this.name);
	                }
	                else {
	                    this.members.onSubscription(data);
	                    this.emit("pusher:subscription_succeeded", this.members);
	                }
	                break;
	            case "pusher_internal:member_added":
	                var addedMember = this.members.addMember(data);
	                this.emit('pusher:member_added', addedMember);
	                break;
	            case "pusher_internal:member_removed":
	                var removedMember = this.members.removeMember(data);
	                if (removedMember) {
	                    this.emit('pusher:member_removed', removedMember);
	                }
	                break;
	            default:
	                private_channel_1["default"].prototype.handleEvent.call(this, event, data);
	        }
	    };
	    PresenceChannel.prototype.disconnect = function () {
	        this.members.reset();
	        _super.prototype.disconnect.call(this);
	    };
	    return PresenceChannel;
	}(private_channel_1["default"]));
	exports.__esModule = true;
	exports["default"] = PresenceChannel;


/***/ },
/* 50 */
/***/ function(module, exports, __webpack_require__) {

	"use strict";
	var __extends = (this && this.__extends) || function (d, b) {
	    for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p];
	    function __() { this.constructor = d; }
	    d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
	};
	var factory_1 = __webpack_require__(42);
	var channel_1 = __webpack_require__(51);
	var PrivateChannel = (function (_super) {
	    __extends(PrivateChannel, _super);
	    function PrivateChannel() {
	        _super.apply(this, arguments);
	    }
	    PrivateChannel.prototype.authorize = function (socketId, callback) {
	        var authorizer = factory_1["default"].createAuthorizer(this, this.pusher.config);
	        return authorizer.authorize(socketId, callback);
	    };
	    return PrivateChannel;
	}(channel_1["default"]));
	exports.__esModule = true;
	exports["default"] = PrivateChannel;


/***/ },
/* 51 */
/***/ function(module, exports, __webpack_require__) {

	"use strict";
	var __extends = (this && this.__extends) || function (d, b) {
	    for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p];
	    function __() { this.constructor = d; }
	    d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
	};
	var dispatcher_1 = __webpack_require__(23);
	var Errors = __webpack_require__(30);
	var logger_1 = __webpack_require__(8);
	var Channel = (function (_super) {
	    __extends(Channel, _super);
	    function Channel(name, pusher) {
	        _super.call(this, function (event, data) {
	            logger_1["default"].debug('No callbacks on ' + name + ' for ' + event);
	        });
	        this.name = name;
	        this.pusher = pusher;
	        this.subscribed = false;
	        this.subscriptionPending = false;
	        this.subscriptionCancelled = false;
	    }
	    Channel.prototype.authorize = function (socketId, callback) {
	        return callback(false, {});
	    };
	    Channel.prototype.trigger = function (event, data) {
	        if (event.indexOf("client-") !== 0) {
	            throw new Errors.BadEventName("Event '" + event + "' does not start with 'client-'");
	        }
	        return this.pusher.send_event(event, data, this.name);
	    };
	    Channel.prototype.disconnect = function () {
	        this.subscribed = false;
	    };
	    Channel.prototype.handleEvent = function (event, data) {
	        if (event.indexOf("pusher_internal:") === 0) {
	            if (event === "pusher_internal:subscription_succeeded") {
	                this.subscriptionPending = false;
	                this.subscribed = true;
	                if (this.subscriptionCancelled) {
	                    this.pusher.unsubscribe(this.name);
	                }
	                else {
	                    this.emit("pusher:subscription_succeeded", data);
	                }
	            }
	        }
	        else {
	            this.emit(event, data);
	        }
	    };
	    Channel.prototype.subscribe = function () {
	        var _this = this;
	        if (this.subscribed) {
	            return;
	        }
	        this.subscriptionPending = true;
	        this.subscriptionCancelled = false;
	        this.authorize(this.pusher.connection.socket_id, function (error, data) {
	            if (error) {
	                _this.handleEvent('pusher:subscription_error', data);
	            }
	            else {
	                _this.pusher.send_event('pusher:subscribe', {
	                    auth: data.auth,
	                    channel_data: data.channel_data,
	                    channel: _this.name
	                });
	            }
	        });
	    };
	    Channel.prototype.unsubscribe = function () {
	        this.subscribed = false;
	        this.pusher.send_event('pusher:unsubscribe', {
	            channel: this.name
	        });
	    };
	    Channel.prototype.cancelSubscription = function () {
	        this.subscriptionCancelled = true;
	    };
	    Channel.prototype.reinstateSubscription = function () {
	        this.subscriptionCancelled = false;
	    };
	    return Channel;
	}(dispatcher_1["default"]));
	exports.__esModule = true;
	exports["default"] = Channel;


/***/ },
/* 52 */
/***/ function(module, exports, __webpack_require__) {

	"use strict";
	var Collections = __webpack_require__(9);
	var Members = (function () {
	    function Members() {
	        this.reset();
	    }
	    Members.prototype.get = function (id) {
	        if (Object.prototype.hasOwnProperty.call(this.members, id)) {
	            return {
	                id: id,
	                info: this.members[id]
	            };
	        }
	        else {
	            return null;
	        }
	    };
	    Members.prototype.each = function (callback) {
	        var _this = this;
	        Collections.objectApply(this.members, function (member, id) {
	            callback(_this.get(id));
	        });
	    };
	    Members.prototype.setMyID = function (id) {
	        this.myID = id;
	    };
	    Members.prototype.onSubscription = function (subscriptionData) {
	        this.members = subscriptionData.presence.hash;
	        this.count = subscriptionData.presence.count;
	        this.me = this.get(this.myID);
	    };
	    Members.prototype.addMember = function (memberData) {
	        if (this.get(memberData.user_id) === null) {
	            this.count++;
	        }
	        this.members[memberData.user_id] = memberData.user_info;
	        return this.get(memberData.user_id);
	    };
	    Members.prototype.removeMember = function (memberData) {
	        var member = this.get(memberData.user_id);
	        if (member) {
	            delete this.members[memberData.user_id];
	            this.count--;
	        }
	        return member;
	    };
	    Members.prototype.reset = function () {
	        this.members = {};
	        this.count = 0;
	        this.myID = null;
	        this.me = null;
	    };
	    return Members;
	}());
	exports.__esModule = true;
	exports["default"] = Members;


/***/ },
/* 53 */
/***/ function(module, exports, __webpack_require__) {

	"use strict";
	var __extends = (this && this.__extends) || function (d, b) {
	    for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p];
	    function __() { this.constructor = d; }
	    d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
	};
	var dispatcher_1 = __webpack_require__(23);
	var timers_1 = __webpack_require__(12);
	var logger_1 = __webpack_require__(8);
	var Collections = __webpack_require__(9);
	var runtime_1 = __webpack_require__(2);
	var ConnectionManager = (function (_super) {
	    __extends(ConnectionManager, _super);
	    function ConnectionManager(key, options) {
	        var _this = this;
	        _super.call(this);
	        this.key = key;
	        this.options = options || {};
	        this.state = "initialized";
	        this.connection = null;
	        this.encrypted = !!options.encrypted;
	        this.timeline = this.options.timeline;
	        this.connectionCallbacks = this.buildConnectionCallbacks();
	        this.errorCallbacks = this.buildErrorCallbacks();
	        this.handshakeCallbacks = this.buildHandshakeCallbacks(this.errorCallbacks);
	        var Network = runtime_1["default"].getNetwork();
	        Network.bind("online", function () {
	            _this.timeline.info({ netinfo: "online" });
	            if (_this.state === "connecting" || _this.state === "unavailable") {
	                _this.retryIn(0);
	            }
	        });
	        Network.bind("offline", function () {
	            _this.timeline.info({ netinfo: "offline" });
	            if (_this.connection) {
	                _this.sendActivityCheck();
	            }
	        });
	        this.updateStrategy();
	    }
	    ConnectionManager.prototype.connect = function () {
	        if (this.connection || this.runner) {
	            return;
	        }
	        if (!this.strategy.isSupported()) {
	            this.updateState("failed");
	            return;
	        }
	        this.updateState("connecting");
	        this.startConnecting();
	        this.setUnavailableTimer();
	    };
	    ;
	    ConnectionManager.prototype.send = function (data) {
	        if (this.connection) {
	            return this.connection.send(data);
	        }
	        else {
	            return false;
	        }
	    };
	    ;
	    ConnectionManager.prototype.send_event = function (name, data, channel) {
	        if (this.connection) {
	            return this.connection.send_event(name, data, channel);
	        }
	        else {
	            return false;
	        }
	    };
	    ;
	    ConnectionManager.prototype.disconnect = function () {
	        this.disconnectInternally();
	        this.updateState("disconnected");
	    };
	    ;
	    ConnectionManager.prototype.isEncrypted = function () {
	        return this.encrypted;
	    };
	    ;
	    ConnectionManager.prototype.startConnecting = function () {
	        var _this = this;
	        var callback = function (error, handshake) {
	            if (error) {
	                _this.runner = _this.strategy.connect(0, callback);
	            }
	            else {
	                if (handshake.action === "error") {
	                    _this.emit("error", { type: "HandshakeError", error: handshake.error });
	                    _this.timeline.error({ handshakeError: handshake.error });
	                }
	                else {
	                    _this.abortConnecting();
	                    _this.handshakeCallbacks[handshake.action](handshake);
	                }
	            }
	        };
	        this.runner = this.strategy.connect(0, callback);
	    };
	    ;
	    ConnectionManager.prototype.abortConnecting = function () {
	        if (this.runner) {
	            this.runner.abort();
	            this.runner = null;
	        }
	    };
	    ;
	    ConnectionManager.prototype.disconnectInternally = function () {
	        this.abortConnecting();
	        this.clearRetryTimer();
	        this.clearUnavailableTimer();
	        if (this.connection) {
	            var connection = this.abandonConnection();
	            connection.close();
	        }
	    };
	    ;
	    ConnectionManager.prototype.updateStrategy = function () {
	        this.strategy = this.options.getStrategy({
	            key: this.key,
	            timeline: this.timeline,
	            encrypted: this.encrypted
	        });
	    };
	    ;
	    ConnectionManager.prototype.retryIn = function (delay) {
	        var _this = this;
	        this.timeline.info({ action: "retry", delay: delay });
	        if (delay > 0) {
	            this.emit("connecting_in", Math.round(delay / 1000));
	        }
	        this.retryTimer = new timers_1.OneOffTimer(delay || 0, function () {
	            _this.disconnectInternally();
	            _this.connect();
	        });
	    };
	    ;
	    ConnectionManager.prototype.clearRetryTimer = function () {
	        if (this.retryTimer) {
	            this.retryTimer.ensureAborted();
	            this.retryTimer = null;
	        }
	    };
	    ;
	    ConnectionManager.prototype.setUnavailableTimer = function () {
	        var _this = this;
	        this.unavailableTimer = new timers_1.OneOffTimer(this.options.unavailableTimeout, function () {
	            _this.updateState("unavailable");
	        });
	    };
	    ;
	    ConnectionManager.prototype.clearUnavailableTimer = function () {
	        if (this.unavailableTimer) {
	            this.unavailableTimer.ensureAborted();
	        }
	    };
	    ;
	    ConnectionManager.prototype.sendActivityCheck = function () {
	        var _this = this;
	        this.stopActivityCheck();
	        this.connection.ping();
	        this.activityTimer = new timers_1.OneOffTimer(this.options.pongTimeout, function () {
	            _this.timeline.error({ pong_timed_out: _this.options.pongTimeout });
	            _this.retryIn(0);
	        });
	    };
	    ;
	    ConnectionManager.prototype.resetActivityCheck = function () {
	        var _this = this;
	        this.stopActivityCheck();
	        if (!this.connection.handlesActivityChecks()) {
	            this.activityTimer = new timers_1.OneOffTimer(this.activityTimeout, function () {
	                _this.sendActivityCheck();
	            });
	        }
	    };
	    ;
	    ConnectionManager.prototype.stopActivityCheck = function () {
	        if (this.activityTimer) {
	            this.activityTimer.ensureAborted();
	        }
	    };
	    ;
	    ConnectionManager.prototype.buildConnectionCallbacks = function () {
	        var _this = this;
	        return {
	            message: function (message) {
	                _this.resetActivityCheck();
	                _this.emit('message', message);
	            },
	            ping: function () {
	                _this.send_event('pusher:pong', {});
	            },
	            activity: function () {
	                _this.resetActivityCheck();
	            },
	            error: function (error) {
	                _this.emit("error", { type: "WebSocketError", error: error });
	            },
	            closed: function () {
	                _this.abandonConnection();
	                if (_this.shouldRetry()) {
	                    _this.retryIn(1000);
	                }
	            }
	        };
	    };
	    ;
	    ConnectionManager.prototype.buildHandshakeCallbacks = function (errorCallbacks) {
	        var _this = this;
	        return Collections.extend({}, errorCallbacks, {
	            connected: function (handshake) {
	                _this.activityTimeout = Math.min(_this.options.activityTimeout, handshake.activityTimeout, handshake.connection.activityTimeout || Infinity);
	                _this.clearUnavailableTimer();
	                _this.setConnection(handshake.connection);
	                _this.socket_id = _this.connection.id;
	                _this.updateState("connected", { socket_id: _this.socket_id });
	            }
	        });
	    };
	    ;
	    ConnectionManager.prototype.buildErrorCallbacks = function () {
	        var _this = this;
	        var withErrorEmitted = function (callback) {
	            return function (result) {
	                if (result.error) {
	                    _this.emit("error", { type: "WebSocketError", error: result.error });
	                }
	                callback(result);
	            };
	        };
	        return {
	            ssl_only: withErrorEmitted(function () {
	                _this.encrypted = true;
	                _this.updateStrategy();
	                _this.retryIn(0);
	            }),
	            refused: withErrorEmitted(function () {
	                _this.disconnect();
	            }),
	            backoff: withErrorEmitted(function () {
	                _this.retryIn(1000);
	            }),
	            retry: withErrorEmitted(function () {
	                _this.retryIn(0);
	            })
	        };
	    };
	    ;
	    ConnectionManager.prototype.setConnection = function (connection) {
	        this.connection = connection;
	        for (var event in this.connectionCallbacks) {
	            this.connection.bind(event, this.connectionCallbacks[event]);
	        }
	        this.resetActivityCheck();
	    };
	    ;
	    ConnectionManager.prototype.abandonConnection = function () {
	        if (!this.connection) {
	            return;
	        }
	        this.stopActivityCheck();
	        for (var event in this.connectionCallbacks) {
	            this.connection.unbind(event, this.connectionCallbacks[event]);
	        }
	        var connection = this.connection;
	        this.connection = null;
	        return connection;
	    };
	    ConnectionManager.prototype.updateState = function (newState, data) {
	        var previousState = this.state;
	        this.state = newState;
	        if (previousState !== newState) {
	            var newStateDescription = newState;
	            if (newStateDescription === "connected") {
	                newStateDescription += " with new socket ID " + data.socket_id;
	            }
	            logger_1["default"].debug('State changed', previousState + ' -> ' + newStateDescription);
	            this.timeline.info({ state: newState, params: data });
	            this.emit('state_change', { previous: previousState, current: newState });
	            this.emit(newState, data);
	        }
	    };
	    ConnectionManager.prototype.shouldRetry = function () {
	        return this.state === "connecting" || this.state === "connected";
	    };
	    return ConnectionManager;
	}(dispatcher_1["default"]));
	exports.__esModule = true;
	exports["default"] = ConnectionManager;


/***/ },
/* 54 */
/***/ function(module, exports, __webpack_require__) {

	"use strict";
	var Collections = __webpack_require__(9);
	var factory_1 = __webpack_require__(42);
	var Channels = (function () {
	    function Channels() {
	        this.channels = {};
	    }
	    Channels.prototype.add = function (name, pusher) {
	        if (!this.channels[name]) {
	            this.channels[name] = createChannel(name, pusher);
	        }
	        return this.channels[name];
	    };
	    Channels.prototype.all = function () {
	        return Collections.values(this.channels);
	    };
	    Channels.prototype.find = function (name) {
	        return this.channels[name];
	    };
	    Channels.prototype.remove = function (name) {
	        var channel = this.channels[name];
	        delete this.channels[name];
	        return channel;
	    };
	    Channels.prototype.disconnect = function () {
	        Collections.objectApply(this.channels, function (channel) {
	            channel.disconnect();
	        });
	    };
	    return Channels;
	}());
	exports.__esModule = true;
	exports["default"] = Channels;
	function createChannel(name, pusher) {
	    if (name.indexOf('private-') === 0) {
	        return factory_1["default"].createPrivateChannel(name, pusher);
	    }
	    else if (name.indexOf('presence-') === 0) {
	        return factory_1["default"].createPresenceChannel(name, pusher);
	    }
	    else {
	        return factory_1["default"].createChannel(name, pusher);
	    }
	}


/***/ },
/* 55 */
/***/ function(module, exports, __webpack_require__) {

	"use strict";
	var factory_1 = __webpack_require__(42);
	var util_1 = __webpack_require__(11);
	var Errors = __webpack_require__(30);
	var Collections = __webpack_require__(9);
	var TransportStrategy = (function () {
	    function TransportStrategy(name, priority, transport, options) {
	        this.name = name;
	        this.priority = priority;
	        this.transport = transport;
	        this.options = options || {};
	    }
	    TransportStrategy.prototype.isSupported = function () {
	        return this.transport.isSupported({
	            encrypted: this.options.encrypted
	        });
	    };
	    TransportStrategy.prototype.connect = function (minPriority, callback) {
	        var _this = this;
	        if (!this.isSupported()) {
	            return failAttempt(new Errors.UnsupportedStrategy(), callback);
	        }
	        else if (this.priority < minPriority) {
	            return failAttempt(new Errors.TransportPriorityTooLow(), callback);
	        }
	        var connected = false;
	        var transport = this.transport.createConnection(this.name, this.priority, this.options.key, this.options);
	        var handshake = null;
	        var onInitialized = function () {
	            transport.unbind("initialized", onInitialized);
	            transport.connect();
	        };
	        var onOpen = function () {
	            handshake = factory_1["default"].createHandshake(transport, function (result) {
	                connected = true;
	                unbindListeners();
	                callback(null, result);
	            });
	        };
	        var onError = function (error) {
	            unbindListeners();
	            callback(error);
	        };
	        var onClosed = function () {
	            unbindListeners();
	            var serializedTransport;
	            serializedTransport = Collections.safeJSONStringify(transport);
	            callback(new Errors.TransportClosed(serializedTransport));
	        };
	        var unbindListeners = function () {
	            transport.unbind("initialized", onInitialized);
	            transport.unbind("open", onOpen);
	            transport.unbind("error", onError);
	            transport.unbind("closed", onClosed);
	        };
	        transport.bind("initialized", onInitialized);
	        transport.bind("open", onOpen);
	        transport.bind("error", onError);
	        transport.bind("closed", onClosed);
	        transport.initialize();
	        return {
	            abort: function () {
	                if (connected) {
	                    return;
	                }
	                unbindListeners();
	                if (handshake) {
	                    handshake.close();
	                }
	                else {
	                    transport.close();
	                }
	            },
	            forceMinPriority: function (p) {
	                if (connected) {
	                    return;
	                }
	                if (_this.priority < p) {
	                    if (handshake) {
	                        handshake.close();
	                    }
	                    else {
	                        transport.close();
	                    }
	                }
	            }
	        };
	    };
	    return TransportStrategy;
	}());
	exports.__esModule = true;
	exports["default"] = TransportStrategy;
	function failAttempt(error, callback) {
	    util_1["default"].defer(function () {
	        callback(error);
	    });
	    return {
	        abort: function () { },
	        forceMinPriority: function () { }
	    };
	}


/***/ },
/* 56 */
/***/ function(module, exports, __webpack_require__) {

	"use strict";
	var Collections = __webpack_require__(9);
	var util_1 = __webpack_require__(11);
	var timers_1 = __webpack_require__(12);
	var SequentialStrategy = (function () {
	    function SequentialStrategy(strategies, options) {
	        this.strategies = strategies;
	        this.loop = Boolean(options.loop);
	        this.failFast = Boolean(options.failFast);
	        this.timeout = options.timeout;
	        this.timeoutLimit = options.timeoutLimit;
	    }
	    SequentialStrategy.prototype.isSupported = function () {
	        return Collections.any(this.strategies, util_1["default"].method("isSupported"));
	    };
	    SequentialStrategy.prototype.connect = function (minPriority, callback) {
	        var _this = this;
	        var strategies = this.strategies;
	        var current = 0;
	        var timeout = this.timeout;
	        var runner = null;
	        var tryNextStrategy = function (error, handshake) {
	            if (handshake) {
	                callback(null, handshake);
	            }
	            else {
	                current = current + 1;
	                if (_this.loop) {
	                    current = current % strategies.length;
	                }
	                if (current < strategies.length) {
	                    if (timeout) {
	                        timeout = timeout * 2;
	                        if (_this.timeoutLimit) {
	                            timeout = Math.min(timeout, _this.timeoutLimit);
	                        }
	                    }
	                    runner = _this.tryStrategy(strategies[current], minPriority, { timeout: timeout, failFast: _this.failFast }, tryNextStrategy);
	                }
	                else {
	                    callback(true);
	                }
	            }
	        };
	        runner = this.tryStrategy(strategies[current], minPriority, { timeout: timeout, failFast: this.failFast }, tryNextStrategy);
	        return {
	            abort: function () {
	                runner.abort();
	            },
	            forceMinPriority: function (p) {
	                minPriority = p;
	                if (runner) {
	                    runner.forceMinPriority(p);
	                }
	            }
	        };
	    };
	    SequentialStrategy.prototype.tryStrategy = function (strategy, minPriority, options, callback) {
	        var timer = null;
	        var runner = null;
	        if (options.timeout > 0) {
	            timer = new timers_1.OneOffTimer(options.timeout, function () {
	                runner.abort();
	                callback(true);
	            });
	        }
	        runner = strategy.connect(minPriority, function (error, handshake) {
	            if (error && timer && timer.isRunning() && !options.failFast) {
	                return;
	            }
	            if (timer) {
	                timer.ensureAborted();
	            }
	            callback(error, handshake);
	        });
	        return {
	            abort: function () {
	                if (timer) {
	                    timer.ensureAborted();
	                }
	                runner.abort();
	            },
	            forceMinPriority: function (p) {
	                runner.forceMinPriority(p);
	            }
	        };
	    };
	    return SequentialStrategy;
	}());
	exports.__esModule = true;
	exports["default"] = SequentialStrategy;


/***/ },
/* 57 */
/***/ function(module, exports, __webpack_require__) {

	"use strict";
	var Collections = __webpack_require__(9);
	var util_1 = __webpack_require__(11);
	var BestConnectedEverStrategy = (function () {
	    function BestConnectedEverStrategy(strategies) {
	        this.strategies = strategies;
	    }
	    BestConnectedEverStrategy.prototype.isSupported = function () {
	        return Collections.any(this.strategies, util_1["default"].method("isSupported"));
	    };
	    BestConnectedEverStrategy.prototype.connect = function (minPriority, callback) {
	        return connect(this.strategies, minPriority, function (i, runners) {
	            return function (error, handshake) {
	                runners[i].error = error;
	                if (error) {
	                    if (allRunnersFailed(runners)) {
	                        callback(true);
	                    }
	                    return;
	                }
	                Collections.apply(runners, function (runner) {
	                    runner.forceMinPriority(handshake.transport.priority);
	                });
	                callback(null, handshake);
	            };
	        });
	    };
	    return BestConnectedEverStrategy;
	}());
	exports.__esModule = true;
	exports["default"] = BestConnectedEverStrategy;
	function connect(strategies, minPriority, callbackBuilder) {
	    var runners = Collections.map(strategies, function (strategy, i, _, rs) {
	        return strategy.connect(minPriority, callbackBuilder(i, rs));
	    });
	    return {
	        abort: function () {
	            Collections.apply(runners, abortRunner);
	        },
	        forceMinPriority: function (p) {
	            Collections.apply(runners, function (runner) {
	                runner.forceMinPriority(p);
	            });
	        }
	    };
	}
	function allRunnersFailed(runners) {
	    return Collections.all(runners, function (runner) {
	        return Boolean(runner.error);
	    });
	}
	function abortRunner(runner) {
	    if (!runner.error && !runner.aborted) {
	        runner.abort();
	        runner.aborted = true;
	    }
	}


/***/ },
/* 58 */
/***/ function(module, exports, __webpack_require__) {

	"use strict";
	var util_1 = __webpack_require__(11);
	var runtime_1 = __webpack_require__(2);
	var sequential_strategy_1 = __webpack_require__(56);
	var Collections = __webpack_require__(9);
	var CachedStrategy = (function () {
	    function CachedStrategy(strategy, transports, options) {
	        this.strategy = strategy;
	        this.transports = transports;
	        this.ttl = options.ttl || 1800 * 1000;
	        this.encrypted = options.encrypted;
	        this.timeline = options.timeline;
	    }
	    CachedStrategy.prototype.isSupported = function () {
	        return this.strategy.isSupported();
	    };
	    CachedStrategy.prototype.connect = function (minPriority, callback) {
	        var encrypted = this.encrypted;
	        var info = fetchTransportCache(encrypted);
	        var strategies = [this.strategy];
	        if (info && info.timestamp + this.ttl >= util_1["default"].now()) {
	            var transport = this.transports[info.transport];
	            if (transport) {
	                this.timeline.info({
	                    cached: true,
	                    transport: info.transport,
	                    latency: info.latency
	                });
	                strategies.push(new sequential_strategy_1["default"]([transport], {
	                    timeout: info.latency * 2 + 1000,
	                    failFast: true
	                }));
	            }
	        }
	        var startTimestamp = util_1["default"].now();
	        var runner = strategies.pop().connect(minPriority, function cb(error, handshake) {
	            if (error) {
	                flushTransportCache(encrypted);
	                if (strategies.length > 0) {
	                    startTimestamp = util_1["default"].now();
	                    runner = strategies.pop().connect(minPriority, cb);
	                }
	                else {
	                    callback(error);
	                }
	            }
	            else {
	                storeTransportCache(encrypted, handshake.transport.name, util_1["default"].now() - startTimestamp);
	                callback(null, handshake);
	            }
	        });
	        return {
	            abort: function () {
	                runner.abort();
	            },
	            forceMinPriority: function (p) {
	                minPriority = p;
	                if (runner) {
	                    runner.forceMinPriority(p);
	                }
	            }
	        };
	    };
	    return CachedStrategy;
	}());
	exports.__esModule = true;
	exports["default"] = CachedStrategy;
	function getTransportCacheKey(encrypted) {
	    return "pusherTransport" + (encrypted ? "Encrypted" : "Unencrypted");
	}
	function fetchTransportCache(encrypted) {
	    var storage = runtime_1["default"].getLocalStorage();
	    if (storage) {
	        try {
	            var serializedCache = storage[getTransportCacheKey(encrypted)];
	            if (serializedCache) {
	                return JSON.parse(serializedCache);
	            }
	        }
	        catch (e) {
	            flushTransportCache(encrypted);
	        }
	    }
	    return null;
	}
	function storeTransportCache(encrypted, transport, latency) {
	    var storage = runtime_1["default"].getLocalStorage();
	    if (storage) {
	        try {
	            storage[getTransportCacheKey(encrypted)] = Collections.safeJSONStringify({
	                timestamp: util_1["default"].now(),
	                transport: transport,
	                latency: latency
	            });
	        }
	        catch (e) {
	        }
	    }
	}
	function flushTransportCache(encrypted) {
	    var storage = runtime_1["default"].getLocalStorage();
	    if (storage) {
	        try {
	            delete storage[getTransportCacheKey(encrypted)];
	        }
	        catch (e) {
	        }
	    }
	}


/***/ },
/* 59 */
/***/ function(module, exports, __webpack_require__) {

	"use strict";
	var timers_1 = __webpack_require__(12);
	var DelayedStrategy = (function () {
	    function DelayedStrategy(strategy, _a) {
	        var number = _a.delay;
	        this.strategy = strategy;
	        this.options = { delay: number };
	    }
	    DelayedStrategy.prototype.isSupported = function () {
	        return this.strategy.isSupported();
	    };
	    DelayedStrategy.prototype.connect = function (minPriority, callback) {
	        var strategy = this.strategy;
	        var runner;
	        var timer = new timers_1.OneOffTimer(this.options.delay, function () {
	            runner = strategy.connect(minPriority, callback);
	        });
	        return {
	            abort: function () {
	                timer.ensureAborted();
	                if (runner) {
	                    runner.abort();
	                }
	            },
	            forceMinPriority: function (p) {
	                minPriority = p;
	                if (runner) {
	                    runner.forceMinPriority(p);
	                }
	            }
	        };
	    };
	    return DelayedStrategy;
	}());
	exports.__esModule = true;
	exports["default"] = DelayedStrategy;


/***/ },
/* 60 */
/***/ function(module, exports) {

	"use strict";
	var IfStrategy = (function () {
	    function IfStrategy(test, trueBranch, falseBranch) {
	        this.test = test;
	        this.trueBranch = trueBranch;
	        this.falseBranch = falseBranch;
	    }
	    IfStrategy.prototype.isSupported = function () {
	        var branch = this.test() ? this.trueBranch : this.falseBranch;
	        return branch.isSupported();
	    };
	    IfStrategy.prototype.connect = function (minPriority, callback) {
	        var branch = this.test() ? this.trueBranch : this.falseBranch;
	        return branch.connect(minPriority, callback);
	    };
	    return IfStrategy;
	}());
	exports.__esModule = true;
	exports["default"] = IfStrategy;


/***/ },
/* 61 */
/***/ function(module, exports) {

	"use strict";
	var FirstConnectedStrategy = (function () {
	    function FirstConnectedStrategy(strategy) {
	        this.strategy = strategy;
	    }
	    FirstConnectedStrategy.prototype.isSupported = function () {
	        return this.strategy.isSupported();
	    };
	    FirstConnectedStrategy.prototype.connect = function (minPriority, callback) {
	        var runner = this.strategy.connect(minPriority, function (error, handshake) {
	            if (handshake) {
	                runner.abort();
	            }
	            callback(error, handshake);
	        });
	        return runner;
	    };
	    return FirstConnectedStrategy;
	}());
	exports.__esModule = true;
	exports["default"] = FirstConnectedStrategy;


/***/ },
/* 62 */
/***/ function(module, exports, __webpack_require__) {

	"use strict";
	var defaults_1 = __webpack_require__(5);
	exports.getGlobalConfig = function () {
	    return {
	        wsHost: defaults_1["default"].host,
	        wsPort: defaults_1["default"].ws_port,
	        wssPort: defaults_1["default"].wss_port,
	        httpHost: defaults_1["default"].sockjs_host,
	        httpPort: defaults_1["default"].sockjs_http_port,
	        httpsPort: defaults_1["default"].sockjs_https_port,
	        httpPath: defaults_1["default"].sockjs_path,
	        statsHost: defaults_1["default"].stats_host,
	        authEndpoint: defaults_1["default"].channel_auth_endpoint,
	        authTransport: defaults_1["default"].channel_auth_transport,
	        activity_timeout: defaults_1["default"].activity_timeout,
	        pong_timeout: defaults_1["default"].pong_timeout,
	        unavailable_timeout: defaults_1["default"].unavailable_timeout
	    };
	};
	exports.getClusterConfig = function (clusterName) {
	    return {
	        wsHost: "ws-" + clusterName + ".pusher.com",
	        httpHost: "sockjs-" + clusterName + ".pusher.com"
	    };
	};


/***/ }
/******/ ])
});
;
},{}],84:[function(require,module,exports){
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

},{}],85:[function(require,module,exports){
(function (process,global){
/*!
 * Vue.js v2.1.10
 * (c) 2014-2017 Evan You
 * Released under the MIT License.
 */
'use strict';

/*  */

/**
 * Convert a value to a string that is actually rendered.
 */
function _toString (val) {
  return val == null
    ? ''
    : typeof val === 'object'
      ? JSON.stringify(val, null, 2)
      : String(val)
}

/**
 * Convert a input value to a number for persistence.
 * If the conversion fails, return original string.
 */
function toNumber (val) {
  var n = parseFloat(val);
  return isNaN(n) ? val : n
}

/**
 * Make a map and return a function for checking if a key
 * is in that map.
 */
function makeMap (
  str,
  expectsLowerCase
) {
  var map = Object.create(null);
  var list = str.split(',');
  for (var i = 0; i < list.length; i++) {
    map[list[i]] = true;
  }
  return expectsLowerCase
    ? function (val) { return map[val.toLowerCase()]; }
    : function (val) { return map[val]; }
}

/**
 * Check if a tag is a built-in tag.
 */
var isBuiltInTag = makeMap('slot,component', true);

/**
 * Remove an item from an array
 */
function remove$1 (arr, item) {
  if (arr.length) {
    var index = arr.indexOf(item);
    if (index > -1) {
      return arr.splice(index, 1)
    }
  }
}

/**
 * Check whether the object has the property.
 */
var hasOwnProperty = Object.prototype.hasOwnProperty;
function hasOwn (obj, key) {
  return hasOwnProperty.call(obj, key)
}

/**
 * Check if value is primitive
 */
function isPrimitive (value) {
  return typeof value === 'string' || typeof value === 'number'
}

/**
 * Create a cached version of a pure function.
 */
function cached (fn) {
  var cache = Object.create(null);
  return (function cachedFn (str) {
    var hit = cache[str];
    return hit || (cache[str] = fn(str))
  })
}

/**
 * Camelize a hyphen-delimited string.
 */
var camelizeRE = /-(\w)/g;
var camelize = cached(function (str) {
  return str.replace(camelizeRE, function (_, c) { return c ? c.toUpperCase() : ''; })
});

/**
 * Capitalize a string.
 */
var capitalize = cached(function (str) {
  return str.charAt(0).toUpperCase() + str.slice(1)
});

/**
 * Hyphenate a camelCase string.
 */
var hyphenateRE = /([^-])([A-Z])/g;
var hyphenate = cached(function (str) {
  return str
    .replace(hyphenateRE, '$1-$2')
    .replace(hyphenateRE, '$1-$2')
    .toLowerCase()
});

/**
 * Simple bind, faster than native
 */
function bind$1 (fn, ctx) {
  function boundFn (a) {
    var l = arguments.length;
    return l
      ? l > 1
        ? fn.apply(ctx, arguments)
        : fn.call(ctx, a)
      : fn.call(ctx)
  }
  // record original fn length
  boundFn._length = fn.length;
  return boundFn
}

/**
 * Convert an Array-like object to a real Array.
 */
function toArray (list, start) {
  start = start || 0;
  var i = list.length - start;
  var ret = new Array(i);
  while (i--) {
    ret[i] = list[i + start];
  }
  return ret
}

/**
 * Mix properties into target object.
 */
function extend (to, _from) {
  for (var key in _from) {
    to[key] = _from[key];
  }
  return to
}

/**
 * Quick object check - this is primarily used to tell
 * Objects from primitive values when we know the value
 * is a JSON-compliant type.
 */
function isObject (obj) {
  return obj !== null && typeof obj === 'object'
}

/**
 * Strict object type check. Only returns true
 * for plain JavaScript objects.
 */
var toString = Object.prototype.toString;
var OBJECT_STRING = '[object Object]';
function isPlainObject (obj) {
  return toString.call(obj) === OBJECT_STRING
}

/**
 * Merge an Array of Objects into a single Object.
 */
function toObject (arr) {
  var res = {};
  for (var i = 0; i < arr.length; i++) {
    if (arr[i]) {
      extend(res, arr[i]);
    }
  }
  return res
}

/**
 * Perform no operation.
 */
function noop () {}

/**
 * Always return false.
 */
var no = function () { return false; };

/**
 * Return same value
 */
var identity = function (_) { return _; };

/**
 * Generate a static keys string from compiler modules.
 */
function genStaticKeys (modules) {
  return modules.reduce(function (keys, m) {
    return keys.concat(m.staticKeys || [])
  }, []).join(',')
}

/**
 * Check if two values are loosely equal - that is,
 * if they are plain objects, do they have the same shape?
 */
function looseEqual (a, b) {
  var isObjectA = isObject(a);
  var isObjectB = isObject(b);
  if (isObjectA && isObjectB) {
    return JSON.stringify(a) === JSON.stringify(b)
  } else if (!isObjectA && !isObjectB) {
    return String(a) === String(b)
  } else {
    return false
  }
}

function looseIndexOf (arr, val) {
  for (var i = 0; i < arr.length; i++) {
    if (looseEqual(arr[i], val)) { return i }
  }
  return -1
}

/*  */

var config = {
  /**
   * Option merge strategies (used in core/util/options)
   */
  optionMergeStrategies: Object.create(null),

  /**
   * Whether to suppress warnings.
   */
  silent: false,

  /**
   * Whether to enable devtools
   */
  devtools: process.env.NODE_ENV !== 'production',

  /**
   * Error handler for watcher errors
   */
  errorHandler: null,

  /**
   * Ignore certain custom elements
   */
  ignoredElements: [],

  /**
   * Custom user key aliases for v-on
   */
  keyCodes: Object.create(null),

  /**
   * Check if a tag is reserved so that it cannot be registered as a
   * component. This is platform-dependent and may be overwritten.
   */
  isReservedTag: no,

  /**
   * Check if a tag is an unknown element.
   * Platform-dependent.
   */
  isUnknownElement: no,

  /**
   * Get the namespace of an element
   */
  getTagNamespace: noop,

  /**
   * Parse the real tag name for the specific platform.
   */
  parsePlatformTagName: identity,

  /**
   * Check if an attribute must be bound using property, e.g. value
   * Platform-dependent.
   */
  mustUseProp: no,

  /**
   * List of asset types that a component can own.
   */
  _assetTypes: [
    'component',
    'directive',
    'filter'
  ],

  /**
   * List of lifecycle hooks.
   */
  _lifecycleHooks: [
    'beforeCreate',
    'created',
    'beforeMount',
    'mounted',
    'beforeUpdate',
    'updated',
    'beforeDestroy',
    'destroyed',
    'activated',
    'deactivated'
  ],

  /**
   * Max circular updates allowed in a scheduler flush cycle.
   */
  _maxUpdateCount: 100
};

/*  */

/**
 * Check if a string starts with $ or _
 */
function isReserved (str) {
  var c = (str + '').charCodeAt(0);
  return c === 0x24 || c === 0x5F
}

/**
 * Define a property.
 */
function def (obj, key, val, enumerable) {
  Object.defineProperty(obj, key, {
    value: val,
    enumerable: !!enumerable,
    writable: true,
    configurable: true
  });
}

/**
 * Parse simple path.
 */
var bailRE = /[^\w.$]/;
function parsePath (path) {
  if (bailRE.test(path)) {
    return
  } else {
    var segments = path.split('.');
    return function (obj) {
      for (var i = 0; i < segments.length; i++) {
        if (!obj) { return }
        obj = obj[segments[i]];
      }
      return obj
    }
  }
}

/*  */
/* globals MutationObserver */

// can we use __proto__?
var hasProto = '__proto__' in {};

// Browser environment sniffing
var inBrowser = typeof window !== 'undefined';
var UA = inBrowser && window.navigator.userAgent.toLowerCase();
var isIE = UA && /msie|trident/.test(UA);
var isIE9 = UA && UA.indexOf('msie 9.0') > 0;
var isEdge = UA && UA.indexOf('edge/') > 0;
var isAndroid = UA && UA.indexOf('android') > 0;
var isIOS = UA && /iphone|ipad|ipod|ios/.test(UA);

// this needs to be lazy-evaled because vue may be required before
// vue-server-renderer can set VUE_ENV
var _isServer;
var isServerRendering = function () {
  if (_isServer === undefined) {
    /* istanbul ignore if */
    if (!inBrowser && typeof global !== 'undefined') {
      // detect presence of vue-server-renderer and avoid
      // Webpack shimming the process
      _isServer = global['process'].env.VUE_ENV === 'server';
    } else {
      _isServer = false;
    }
  }
  return _isServer
};

// detect devtools
var devtools = inBrowser && window.__VUE_DEVTOOLS_GLOBAL_HOOK__;

/* istanbul ignore next */
function isNative (Ctor) {
  return /native code/.test(Ctor.toString())
}

/**
 * Defer a task to execute it asynchronously.
 */
var nextTick = (function () {
  var callbacks = [];
  var pending = false;
  var timerFunc;

  function nextTickHandler () {
    pending = false;
    var copies = callbacks.slice(0);
    callbacks.length = 0;
    for (var i = 0; i < copies.length; i++) {
      copies[i]();
    }
  }

  // the nextTick behavior leverages the microtask queue, which can be accessed
  // via either native Promise.then or MutationObserver.
  // MutationObserver has wider support, however it is seriously bugged in
  // UIWebView in iOS >= 9.3.3 when triggered in touch event handlers. It
  // completely stops working after triggering a few times... so, if native
  // Promise is available, we will use it:
  /* istanbul ignore if */
  if (typeof Promise !== 'undefined' && isNative(Promise)) {
    var p = Promise.resolve();
    var logError = function (err) { console.error(err); };
    timerFunc = function () {
      p.then(nextTickHandler).catch(logError);
      // in problematic UIWebViews, Promise.then doesn't completely break, but
      // it can get stuck in a weird state where callbacks are pushed into the
      // microtask queue but the queue isn't being flushed, until the browser
      // needs to do some other work, e.g. handle a timer. Therefore we can
      // "force" the microtask queue to be flushed by adding an empty timer.
      if (isIOS) { setTimeout(noop); }
    };
  } else if (typeof MutationObserver !== 'undefined' && (
    isNative(MutationObserver) ||
    // PhantomJS and iOS 7.x
    MutationObserver.toString() === '[object MutationObserverConstructor]'
  )) {
    // use MutationObserver where native Promise is not available,
    // e.g. PhantomJS IE11, iOS7, Android 4.4
    var counter = 1;
    var observer = new MutationObserver(nextTickHandler);
    var textNode = document.createTextNode(String(counter));
    observer.observe(textNode, {
      characterData: true
    });
    timerFunc = function () {
      counter = (counter + 1) % 2;
      textNode.data = String(counter);
    };
  } else {
    // fallback to setTimeout
    /* istanbul ignore next */
    timerFunc = function () {
      setTimeout(nextTickHandler, 0);
    };
  }

  return function queueNextTick (cb, ctx) {
    var _resolve;
    callbacks.push(function () {
      if (cb) { cb.call(ctx); }
      if (_resolve) { _resolve(ctx); }
    });
    if (!pending) {
      pending = true;
      timerFunc();
    }
    if (!cb && typeof Promise !== 'undefined') {
      return new Promise(function (resolve) {
        _resolve = resolve;
      })
    }
  }
})();

var _Set;
/* istanbul ignore if */
if (typeof Set !== 'undefined' && isNative(Set)) {
  // use native Set when available.
  _Set = Set;
} else {
  // a non-standard Set polyfill that only works with primitive keys.
  _Set = (function () {
    function Set () {
      this.set = Object.create(null);
    }
    Set.prototype.has = function has (key) {
      return this.set[key] === true
    };
    Set.prototype.add = function add (key) {
      this.set[key] = true;
    };
    Set.prototype.clear = function clear () {
      this.set = Object.create(null);
    };

    return Set;
  }());
}

var warn = noop;
var formatComponentName;

if (process.env.NODE_ENV !== 'production') {
  var hasConsole = typeof console !== 'undefined';

  warn = function (msg, vm) {
    if (hasConsole && (!config.silent)) {
      console.error("[Vue warn]: " + msg + " " + (
        vm ? formatLocation(formatComponentName(vm)) : ''
      ));
    }
  };

  formatComponentName = function (vm) {
    if (vm.$root === vm) {
      return 'root instance'
    }
    var name = vm._isVue
      ? vm.$options.name || vm.$options._componentTag
      : vm.name;
    return (
      (name ? ("component <" + name + ">") : "anonymous component") +
      (vm._isVue && vm.$options.__file ? (" at " + (vm.$options.__file)) : '')
    )
  };

  var formatLocation = function (str) {
    if (str === 'anonymous component') {
      str += " - use the \"name\" option for better debugging messages.";
    }
    return ("\n(found in " + str + ")")
  };
}

/*  */


var uid$1 = 0;

/**
 * A dep is an observable that can have multiple
 * directives subscribing to it.
 */
var Dep = function Dep () {
  this.id = uid$1++;
  this.subs = [];
};

Dep.prototype.addSub = function addSub (sub) {
  this.subs.push(sub);
};

Dep.prototype.removeSub = function removeSub (sub) {
  remove$1(this.subs, sub);
};

Dep.prototype.depend = function depend () {
  if (Dep.target) {
    Dep.target.addDep(this);
  }
};

Dep.prototype.notify = function notify () {
  // stablize the subscriber list first
  var subs = this.subs.slice();
  for (var i = 0, l = subs.length; i < l; i++) {
    subs[i].update();
  }
};

// the current target watcher being evaluated.
// this is globally unique because there could be only one
// watcher being evaluated at any time.
Dep.target = null;
var targetStack = [];

function pushTarget (_target) {
  if (Dep.target) { targetStack.push(Dep.target); }
  Dep.target = _target;
}

function popTarget () {
  Dep.target = targetStack.pop();
}

/*
 * not type checking this file because flow doesn't play well with
 * dynamically accessing methods on Array prototype
 */

var arrayProto = Array.prototype;
var arrayMethods = Object.create(arrayProto);[
  'push',
  'pop',
  'shift',
  'unshift',
  'splice',
  'sort',
  'reverse'
]
.forEach(function (method) {
  // cache original method
  var original = arrayProto[method];
  def(arrayMethods, method, function mutator () {
    var arguments$1 = arguments;

    // avoid leaking arguments:
    // http://jsperf.com/closure-with-arguments
    var i = arguments.length;
    var args = new Array(i);
    while (i--) {
      args[i] = arguments$1[i];
    }
    var result = original.apply(this, args);
    var ob = this.__ob__;
    var inserted;
    switch (method) {
      case 'push':
        inserted = args;
        break
      case 'unshift':
        inserted = args;
        break
      case 'splice':
        inserted = args.slice(2);
        break
    }
    if (inserted) { ob.observeArray(inserted); }
    // notify change
    ob.dep.notify();
    return result
  });
});

/*  */

var arrayKeys = Object.getOwnPropertyNames(arrayMethods);

/**
 * By default, when a reactive property is set, the new value is
 * also converted to become reactive. However when passing down props,
 * we don't want to force conversion because the value may be a nested value
 * under a frozen data structure. Converting it would defeat the optimization.
 */
var observerState = {
  shouldConvert: true,
  isSettingProps: false
};

/**
 * Observer class that are attached to each observed
 * object. Once attached, the observer converts target
 * object's property keys into getter/setters that
 * collect dependencies and dispatches updates.
 */
var Observer = function Observer (value) {
  this.value = value;
  this.dep = new Dep();
  this.vmCount = 0;
  def(value, '__ob__', this);
  if (Array.isArray(value)) {
    var augment = hasProto
      ? protoAugment
      : copyAugment;
    augment(value, arrayMethods, arrayKeys);
    this.observeArray(value);
  } else {
    this.walk(value);
  }
};

/**
 * Walk through each property and convert them into
 * getter/setters. This method should only be called when
 * value type is Object.
 */
Observer.prototype.walk = function walk (obj) {
  var keys = Object.keys(obj);
  for (var i = 0; i < keys.length; i++) {
    defineReactive$$1(obj, keys[i], obj[keys[i]]);
  }
};

/**
 * Observe a list of Array items.
 */
Observer.prototype.observeArray = function observeArray (items) {
  for (var i = 0, l = items.length; i < l; i++) {
    observe(items[i]);
  }
};

// helpers

/**
 * Augment an target Object or Array by intercepting
 * the prototype chain using __proto__
 */
function protoAugment (target, src) {
  /* eslint-disable no-proto */
  target.__proto__ = src;
  /* eslint-enable no-proto */
}

/**
 * Augment an target Object or Array by defining
 * hidden properties.
 */
/* istanbul ignore next */
function copyAugment (target, src, keys) {
  for (var i = 0, l = keys.length; i < l; i++) {
    var key = keys[i];
    def(target, key, src[key]);
  }
}

/**
 * Attempt to create an observer instance for a value,
 * returns the new observer if successfully observed,
 * or the existing observer if the value already has one.
 */
function observe (value, asRootData) {
  if (!isObject(value)) {
    return
  }
  var ob;
  if (hasOwn(value, '__ob__') && value.__ob__ instanceof Observer) {
    ob = value.__ob__;
  } else if (
    observerState.shouldConvert &&
    !isServerRendering() &&
    (Array.isArray(value) || isPlainObject(value)) &&
    Object.isExtensible(value) &&
    !value._isVue
  ) {
    ob = new Observer(value);
  }
  if (asRootData && ob) {
    ob.vmCount++;
  }
  return ob
}

/**
 * Define a reactive property on an Object.
 */
function defineReactive$$1 (
  obj,
  key,
  val,
  customSetter
) {
  var dep = new Dep();

  var property = Object.getOwnPropertyDescriptor(obj, key);
  if (property && property.configurable === false) {
    return
  }

  // cater for pre-defined getter/setters
  var getter = property && property.get;
  var setter = property && property.set;

  var childOb = observe(val);
  Object.defineProperty(obj, key, {
    enumerable: true,
    configurable: true,
    get: function reactiveGetter () {
      var value = getter ? getter.call(obj) : val;
      if (Dep.target) {
        dep.depend();
        if (childOb) {
          childOb.dep.depend();
        }
        if (Array.isArray(value)) {
          dependArray(value);
        }
      }
      return value
    },
    set: function reactiveSetter (newVal) {
      var value = getter ? getter.call(obj) : val;
      /* eslint-disable no-self-compare */
      if (newVal === value || (newVal !== newVal && value !== value)) {
        return
      }
      /* eslint-enable no-self-compare */
      if (process.env.NODE_ENV !== 'production' && customSetter) {
        customSetter();
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

/**
 * Set a property on an object. Adds the new property and
 * triggers change notification if the property doesn't
 * already exist.
 */
function set$1 (obj, key, val) {
  if (Array.isArray(obj)) {
    obj.length = Math.max(obj.length, key);
    obj.splice(key, 1, val);
    return val
  }
  if (hasOwn(obj, key)) {
    obj[key] = val;
    return
  }
  var ob = obj.__ob__;
  if (obj._isVue || (ob && ob.vmCount)) {
    process.env.NODE_ENV !== 'production' && warn(
      'Avoid adding reactive properties to a Vue instance or its root $data ' +
      'at runtime - declare it upfront in the data option.'
    );
    return
  }
  if (!ob) {
    obj[key] = val;
    return
  }
  defineReactive$$1(ob.value, key, val);
  ob.dep.notify();
  return val
}

/**
 * Delete a property and trigger change if necessary.
 */
function del (obj, key) {
  var ob = obj.__ob__;
  if (obj._isVue || (ob && ob.vmCount)) {
    process.env.NODE_ENV !== 'production' && warn(
      'Avoid deleting properties on a Vue instance or its root $data ' +
      '- just set it to null.'
    );
    return
  }
  if (!hasOwn(obj, key)) {
    return
  }
  delete obj[key];
  if (!ob) {
    return
  }
  ob.dep.notify();
}

/**
 * Collect dependencies on array elements when the array is touched, since
 * we cannot intercept array element access like property getters.
 */
function dependArray (value) {
  for (var e = (void 0), i = 0, l = value.length; i < l; i++) {
    e = value[i];
    e && e.__ob__ && e.__ob__.dep.depend();
    if (Array.isArray(e)) {
      dependArray(e);
    }
  }
}

/*  */

/**
 * Option overwriting strategies are functions that handle
 * how to merge a parent option value and a child option
 * value into the final value.
 */
var strats = config.optionMergeStrategies;

/**
 * Options with restrictions
 */
if (process.env.NODE_ENV !== 'production') {
  strats.el = strats.propsData = function (parent, child, vm, key) {
    if (!vm) {
      warn(
        "option \"" + key + "\" can only be used during instance " +
        'creation with the `new` keyword.'
      );
    }
    return defaultStrat(parent, child)
  };
}

/**
 * Helper that recursively merges two data objects together.
 */
function mergeData (to, from) {
  if (!from) { return to }
  var key, toVal, fromVal;
  var keys = Object.keys(from);
  for (var i = 0; i < keys.length; i++) {
    key = keys[i];
    toVal = to[key];
    fromVal = from[key];
    if (!hasOwn(to, key)) {
      set$1(to, key, fromVal);
    } else if (isPlainObject(toVal) && isPlainObject(fromVal)) {
      mergeData(toVal, fromVal);
    }
  }
  return to
}

/**
 * Data
 */
strats.data = function (
  parentVal,
  childVal,
  vm
) {
  if (!vm) {
    // in a Vue.extend merge, both should be functions
    if (!childVal) {
      return parentVal
    }
    if (typeof childVal !== 'function') {
      process.env.NODE_ENV !== 'production' && warn(
        'The "data" option should be a function ' +
        'that returns a per-instance value in component ' +
        'definitions.',
        vm
      );
      return parentVal
    }
    if (!parentVal) {
      return childVal
    }
    // when parentVal & childVal are both present,
    // we need to return a function that returns the
    // merged result of both functions... no need to
    // check if parentVal is a function here because
    // it has to be a function to pass previous merges.
    return function mergedDataFn () {
      return mergeData(
        childVal.call(this),
        parentVal.call(this)
      )
    }
  } else if (parentVal || childVal) {
    return function mergedInstanceDataFn () {
      // instance merge
      var instanceData = typeof childVal === 'function'
        ? childVal.call(vm)
        : childVal;
      var defaultData = typeof parentVal === 'function'
        ? parentVal.call(vm)
        : undefined;
      if (instanceData) {
        return mergeData(instanceData, defaultData)
      } else {
        return defaultData
      }
    }
  }
};

/**
 * Hooks and param attributes are merged as arrays.
 */
function mergeHook (
  parentVal,
  childVal
) {
  return childVal
    ? parentVal
      ? parentVal.concat(childVal)
      : Array.isArray(childVal)
        ? childVal
        : [childVal]
    : parentVal
}

config._lifecycleHooks.forEach(function (hook) {
  strats[hook] = mergeHook;
});

/**
 * Assets
 *
 * When a vm is present (instance creation), we need to do
 * a three-way merge between constructor options, instance
 * options and parent options.
 */
function mergeAssets (parentVal, childVal) {
  var res = Object.create(parentVal || null);
  return childVal
    ? extend(res, childVal)
    : res
}

config._assetTypes.forEach(function (type) {
  strats[type + 's'] = mergeAssets;
});

/**
 * Watchers.
 *
 * Watchers hashes should not overwrite one
 * another, so we merge them as arrays.
 */
strats.watch = function (parentVal, childVal) {
  /* istanbul ignore if */
  if (!childVal) { return parentVal }
  if (!parentVal) { return childVal }
  var ret = {};
  extend(ret, parentVal);
  for (var key in childVal) {
    var parent = ret[key];
    var child = childVal[key];
    if (parent && !Array.isArray(parent)) {
      parent = [parent];
    }
    ret[key] = parent
      ? parent.concat(child)
      : [child];
  }
  return ret
};

/**
 * Other object hashes.
 */
strats.props =
strats.methods =
strats.computed = function (parentVal, childVal) {
  if (!childVal) { return parentVal }
  if (!parentVal) { return childVal }
  var ret = Object.create(null);
  extend(ret, parentVal);
  extend(ret, childVal);
  return ret
};

/**
 * Default strategy.
 */
var defaultStrat = function (parentVal, childVal) {
  return childVal === undefined
    ? parentVal
    : childVal
};

/**
 * Validate component names
 */
function checkComponents (options) {
  for (var key in options.components) {
    var lower = key.toLowerCase();
    if (isBuiltInTag(lower) || config.isReservedTag(lower)) {
      warn(
        'Do not use built-in or reserved HTML elements as component ' +
        'id: ' + key
      );
    }
  }
}

/**
 * Ensure all props option syntax are normalized into the
 * Object-based format.
 */
function normalizeProps (options) {
  var props = options.props;
  if (!props) { return }
  var res = {};
  var i, val, name;
  if (Array.isArray(props)) {
    i = props.length;
    while (i--) {
      val = props[i];
      if (typeof val === 'string') {
        name = camelize(val);
        res[name] = { type: null };
      } else if (process.env.NODE_ENV !== 'production') {
        warn('props must be strings when using array syntax.');
      }
    }
  } else if (isPlainObject(props)) {
    for (var key in props) {
      val = props[key];
      name = camelize(key);
      res[name] = isPlainObject(val)
        ? val
        : { type: val };
    }
  }
  options.props = res;
}

/**
 * Normalize raw function directives into object format.
 */
function normalizeDirectives (options) {
  var dirs = options.directives;
  if (dirs) {
    for (var key in dirs) {
      var def = dirs[key];
      if (typeof def === 'function') {
        dirs[key] = { bind: def, update: def };
      }
    }
  }
}

/**
 * Merge two option objects into a new one.
 * Core utility used in both instantiation and inheritance.
 */
function mergeOptions (
  parent,
  child,
  vm
) {
  if (process.env.NODE_ENV !== 'production') {
    checkComponents(child);
  }
  normalizeProps(child);
  normalizeDirectives(child);
  var extendsFrom = child.extends;
  if (extendsFrom) {
    parent = typeof extendsFrom === 'function'
      ? mergeOptions(parent, extendsFrom.options, vm)
      : mergeOptions(parent, extendsFrom, vm);
  }
  if (child.mixins) {
    for (var i = 0, l = child.mixins.length; i < l; i++) {
      var mixin = child.mixins[i];
      if (mixin.prototype instanceof Vue$2) {
        mixin = mixin.options;
      }
      parent = mergeOptions(parent, mixin, vm);
    }
  }
  var options = {};
  var key;
  for (key in parent) {
    mergeField(key);
  }
  for (key in child) {
    if (!hasOwn(parent, key)) {
      mergeField(key);
    }
  }
  function mergeField (key) {
    var strat = strats[key] || defaultStrat;
    options[key] = strat(parent[key], child[key], vm, key);
  }
  return options
}

/**
 * Resolve an asset.
 * This function is used because child instances need access
 * to assets defined in its ancestor chain.
 */
function resolveAsset (
  options,
  type,
  id,
  warnMissing
) {
  /* istanbul ignore if */
  if (typeof id !== 'string') {
    return
  }
  var assets = options[type];
  // check local registration variations first
  if (hasOwn(assets, id)) { return assets[id] }
  var camelizedId = camelize(id);
  if (hasOwn(assets, camelizedId)) { return assets[camelizedId] }
  var PascalCaseId = capitalize(camelizedId);
  if (hasOwn(assets, PascalCaseId)) { return assets[PascalCaseId] }
  // fallback to prototype chain
  var res = assets[id] || assets[camelizedId] || assets[PascalCaseId];
  if (process.env.NODE_ENV !== 'production' && warnMissing && !res) {
    warn(
      'Failed to resolve ' + type.slice(0, -1) + ': ' + id,
      options
    );
  }
  return res
}

/*  */

function validateProp (
  key,
  propOptions,
  propsData,
  vm
) {
  var prop = propOptions[key];
  var absent = !hasOwn(propsData, key);
  var value = propsData[key];
  // handle boolean props
  if (isType(Boolean, prop.type)) {
    if (absent && !hasOwn(prop, 'default')) {
      value = false;
    } else if (!isType(String, prop.type) && (value === '' || value === hyphenate(key))) {
      value = true;
    }
  }
  // check default value
  if (value === undefined) {
    value = getPropDefaultValue(vm, prop, key);
    // since the default value is a fresh copy,
    // make sure to observe it.
    var prevShouldConvert = observerState.shouldConvert;
    observerState.shouldConvert = true;
    observe(value);
    observerState.shouldConvert = prevShouldConvert;
  }
  if (process.env.NODE_ENV !== 'production') {
    assertProp(prop, key, value, vm, absent);
  }
  return value
}

/**
 * Get the default value of a prop.
 */
function getPropDefaultValue (vm, prop, key) {
  // no default, return undefined
  if (!hasOwn(prop, 'default')) {
    return undefined
  }
  var def = prop.default;
  // warn against non-factory defaults for Object & Array
  if (isObject(def)) {
    process.env.NODE_ENV !== 'production' && warn(
      'Invalid default value for prop "' + key + '": ' +
      'Props with type Object/Array must use a factory function ' +
      'to return the default value.',
      vm
    );
  }
  // the raw prop value was also undefined from previous render,
  // return previous default value to avoid unnecessary watcher trigger
  if (vm && vm.$options.propsData &&
    vm.$options.propsData[key] === undefined &&
    vm[key] !== undefined) {
    return vm[key]
  }
  // call factory function for non-Function types
  return typeof def === 'function' && prop.type !== Function
    ? def.call(vm)
    : def
}

/**
 * Assert whether a prop is valid.
 */
function assertProp (
  prop,
  name,
  value,
  vm,
  absent
) {
  if (prop.required && absent) {
    warn(
      'Missing required prop: "' + name + '"',
      vm
    );
    return
  }
  if (value == null && !prop.required) {
    return
  }
  var type = prop.type;
  var valid = !type || type === true;
  var expectedTypes = [];
  if (type) {
    if (!Array.isArray(type)) {
      type = [type];
    }
    for (var i = 0; i < type.length && !valid; i++) {
      var assertedType = assertType(value, type[i]);
      expectedTypes.push(assertedType.expectedType || '');
      valid = assertedType.valid;
    }
  }
  if (!valid) {
    warn(
      'Invalid prop: type check failed for prop "' + name + '".' +
      ' Expected ' + expectedTypes.map(capitalize).join(', ') +
      ', got ' + Object.prototype.toString.call(value).slice(8, -1) + '.',
      vm
    );
    return
  }
  var validator = prop.validator;
  if (validator) {
    if (!validator(value)) {
      warn(
        'Invalid prop: custom validator check failed for prop "' + name + '".',
        vm
      );
    }
  }
}

/**
 * Assert the type of a value
 */
function assertType (value, type) {
  var valid;
  var expectedType = getType(type);
  if (expectedType === 'String') {
    valid = typeof value === (expectedType = 'string');
  } else if (expectedType === 'Number') {
    valid = typeof value === (expectedType = 'number');
  } else if (expectedType === 'Boolean') {
    valid = typeof value === (expectedType = 'boolean');
  } else if (expectedType === 'Function') {
    valid = typeof value === (expectedType = 'function');
  } else if (expectedType === 'Object') {
    valid = isPlainObject(value);
  } else if (expectedType === 'Array') {
    valid = Array.isArray(value);
  } else {
    valid = value instanceof type;
  }
  return {
    valid: valid,
    expectedType: expectedType
  }
}

/**
 * Use function string name to check built-in types,
 * because a simple equality check will fail when running
 * across different vms / iframes.
 */
function getType (fn) {
  var match = fn && fn.toString().match(/^\s*function (\w+)/);
  return match && match[1]
}

function isType (type, fn) {
  if (!Array.isArray(fn)) {
    return getType(fn) === getType(type)
  }
  for (var i = 0, len = fn.length; i < len; i++) {
    if (getType(fn[i]) === getType(type)) {
      return true
    }
  }
  /* istanbul ignore next */
  return false
}



var util = Object.freeze({
	defineReactive: defineReactive$$1,
	_toString: _toString,
	toNumber: toNumber,
	makeMap: makeMap,
	isBuiltInTag: isBuiltInTag,
	remove: remove$1,
	hasOwn: hasOwn,
	isPrimitive: isPrimitive,
	cached: cached,
	camelize: camelize,
	capitalize: capitalize,
	hyphenate: hyphenate,
	bind: bind$1,
	toArray: toArray,
	extend: extend,
	isObject: isObject,
	isPlainObject: isPlainObject,
	toObject: toObject,
	noop: noop,
	no: no,
	identity: identity,
	genStaticKeys: genStaticKeys,
	looseEqual: looseEqual,
	looseIndexOf: looseIndexOf,
	isReserved: isReserved,
	def: def,
	parsePath: parsePath,
	hasProto: hasProto,
	inBrowser: inBrowser,
	UA: UA,
	isIE: isIE,
	isIE9: isIE9,
	isEdge: isEdge,
	isAndroid: isAndroid,
	isIOS: isIOS,
	isServerRendering: isServerRendering,
	devtools: devtools,
	nextTick: nextTick,
	get _Set () { return _Set; },
	mergeOptions: mergeOptions,
	resolveAsset: resolveAsset,
	get warn () { return warn; },
	get formatComponentName () { return formatComponentName; },
	validateProp: validateProp
});

/* not type checking this file because flow doesn't play well with Proxy */

var initProxy;

if (process.env.NODE_ENV !== 'production') {
  var allowedGlobals = makeMap(
    'Infinity,undefined,NaN,isFinite,isNaN,' +
    'parseFloat,parseInt,decodeURI,decodeURIComponent,encodeURI,encodeURIComponent,' +
    'Math,Number,Date,Array,Object,Boolean,String,RegExp,Map,Set,JSON,Intl,' +
    'require' // for Webpack/Browserify
  );

  var warnNonPresent = function (target, key) {
    warn(
      "Property or method \"" + key + "\" is not defined on the instance but " +
      "referenced during render. Make sure to declare reactive data " +
      "properties in the data option.",
      target
    );
  };

  var hasProxy =
    typeof Proxy !== 'undefined' &&
    Proxy.toString().match(/native code/);

  if (hasProxy) {
    var isBuiltInModifier = makeMap('stop,prevent,self,ctrl,shift,alt,meta');
    config.keyCodes = new Proxy(config.keyCodes, {
      set: function set (target, key, value) {
        if (isBuiltInModifier(key)) {
          warn(("Avoid overwriting built-in modifier in config.keyCodes: ." + key));
          return false
        } else {
          target[key] = value;
          return true
        }
      }
    });
  }

  var hasHandler = {
    has: function has (target, key) {
      var has = key in target;
      var isAllowed = allowedGlobals(key) || key.charAt(0) === '_';
      if (!has && !isAllowed) {
        warnNonPresent(target, key);
      }
      return has || !isAllowed
    }
  };

  var getHandler = {
    get: function get (target, key) {
      if (typeof key === 'string' && !(key in target)) {
        warnNonPresent(target, key);
      }
      return target[key]
    }
  };

  initProxy = function initProxy (vm) {
    if (hasProxy) {
      // determine which proxy handler to use
      var options = vm.$options;
      var handlers = options.render && options.render._withStripped
        ? getHandler
        : hasHandler;
      vm._renderProxy = new Proxy(vm, handlers);
    } else {
      vm._renderProxy = vm;
    }
  };
}

/*  */

var VNode = function VNode (
  tag,
  data,
  children,
  text,
  elm,
  context,
  componentOptions
) {
  this.tag = tag;
  this.data = data;
  this.children = children;
  this.text = text;
  this.elm = elm;
  this.ns = undefined;
  this.context = context;
  this.functionalContext = undefined;
  this.key = data && data.key;
  this.componentOptions = componentOptions;
  this.componentInstance = undefined;
  this.parent = undefined;
  this.raw = false;
  this.isStatic = false;
  this.isRootInsert = true;
  this.isComment = false;
  this.isCloned = false;
  this.isOnce = false;
};

var prototypeAccessors = { child: {} };

// DEPRECATED: alias for componentInstance for backwards compat.
/* istanbul ignore next */
prototypeAccessors.child.get = function () {
  return this.componentInstance
};

Object.defineProperties( VNode.prototype, prototypeAccessors );

var createEmptyVNode = function () {
  var node = new VNode();
  node.text = '';
  node.isComment = true;
  return node
};

function createTextVNode (val) {
  return new VNode(undefined, undefined, undefined, String(val))
}

// optimized shallow clone
// used for static nodes and slot nodes because they may be reused across
// multiple renders, cloning them avoids errors when DOM manipulations rely
// on their elm reference.
function cloneVNode (vnode) {
  var cloned = new VNode(
    vnode.tag,
    vnode.data,
    vnode.children,
    vnode.text,
    vnode.elm,
    vnode.context,
    vnode.componentOptions
  );
  cloned.ns = vnode.ns;
  cloned.isStatic = vnode.isStatic;
  cloned.key = vnode.key;
  cloned.isCloned = true;
  return cloned
}

function cloneVNodes (vnodes) {
  var res = new Array(vnodes.length);
  for (var i = 0; i < vnodes.length; i++) {
    res[i] = cloneVNode(vnodes[i]);
  }
  return res
}

/*  */

var hooks = { init: init, prepatch: prepatch, insert: insert, destroy: destroy$1 };
var hooksToMerge = Object.keys(hooks);

function createComponent (
  Ctor,
  data,
  context,
  children,
  tag
) {
  if (!Ctor) {
    return
  }

  var baseCtor = context.$options._base;
  if (isObject(Ctor)) {
    Ctor = baseCtor.extend(Ctor);
  }

  if (typeof Ctor !== 'function') {
    if (process.env.NODE_ENV !== 'production') {
      warn(("Invalid Component definition: " + (String(Ctor))), context);
    }
    return
  }

  // async component
  if (!Ctor.cid) {
    if (Ctor.resolved) {
      Ctor = Ctor.resolved;
    } else {
      Ctor = resolveAsyncComponent(Ctor, baseCtor, function () {
        // it's ok to queue this on every render because
        // $forceUpdate is buffered by the scheduler.
        context.$forceUpdate();
      });
      if (!Ctor) {
        // return nothing if this is indeed an async component
        // wait for the callback to trigger parent update.
        return
      }
    }
  }

  // resolve constructor options in case global mixins are applied after
  // component constructor creation
  resolveConstructorOptions(Ctor);

  data = data || {};

  // extract props
  var propsData = extractProps(data, Ctor);

  // functional component
  if (Ctor.options.functional) {
    return createFunctionalComponent(Ctor, propsData, data, context, children)
  }

  // extract listeners, since these needs to be treated as
  // child component listeners instead of DOM listeners
  var listeners = data.on;
  // replace with listeners with .native modifier
  data.on = data.nativeOn;

  if (Ctor.options.abstract) {
    // abstract components do not keep anything
    // other than props & listeners
    data = {};
  }

  // merge component management hooks onto the placeholder node
  mergeHooks(data);

  // return a placeholder vnode
  var name = Ctor.options.name || tag;
  var vnode = new VNode(
    ("vue-component-" + (Ctor.cid) + (name ? ("-" + name) : '')),
    data, undefined, undefined, undefined, context,
    { Ctor: Ctor, propsData: propsData, listeners: listeners, tag: tag, children: children }
  );
  return vnode
}

function createFunctionalComponent (
  Ctor,
  propsData,
  data,
  context,
  children
) {
  var props = {};
  var propOptions = Ctor.options.props;
  if (propOptions) {
    for (var key in propOptions) {
      props[key] = validateProp(key, propOptions, propsData);
    }
  }
  // ensure the createElement function in functional components
  // gets a unique context - this is necessary for correct named slot check
  var _context = Object.create(context);
  var h = function (a, b, c, d) { return createElement(_context, a, b, c, d, true); };
  var vnode = Ctor.options.render.call(null, h, {
    props: props,
    data: data,
    parent: context,
    children: children,
    slots: function () { return resolveSlots(children, context); }
  });
  if (vnode instanceof VNode) {
    vnode.functionalContext = context;
    if (data.slot) {
      (vnode.data || (vnode.data = {})).slot = data.slot;
    }
  }
  return vnode
}

function createComponentInstanceForVnode (
  vnode, // we know it's MountedComponentVNode but flow doesn't
  parent, // activeInstance in lifecycle state
  parentElm,
  refElm
) {
  var vnodeComponentOptions = vnode.componentOptions;
  var options = {
    _isComponent: true,
    parent: parent,
    propsData: vnodeComponentOptions.propsData,
    _componentTag: vnodeComponentOptions.tag,
    _parentVnode: vnode,
    _parentListeners: vnodeComponentOptions.listeners,
    _renderChildren: vnodeComponentOptions.children,
    _parentElm: parentElm || null,
    _refElm: refElm || null
  };
  // check inline-template render functions
  var inlineTemplate = vnode.data.inlineTemplate;
  if (inlineTemplate) {
    options.render = inlineTemplate.render;
    options.staticRenderFns = inlineTemplate.staticRenderFns;
  }
  return new vnodeComponentOptions.Ctor(options)
}

function init (
  vnode,
  hydrating,
  parentElm,
  refElm
) {
  if (!vnode.componentInstance || vnode.componentInstance._isDestroyed) {
    var child = vnode.componentInstance = createComponentInstanceForVnode(
      vnode,
      activeInstance,
      parentElm,
      refElm
    );
    child.$mount(hydrating ? vnode.elm : undefined, hydrating);
  } else if (vnode.data.keepAlive) {
    // kept-alive components, treat as a patch
    var mountedNode = vnode; // work around flow
    prepatch(mountedNode, mountedNode);
  }
}

function prepatch (
  oldVnode,
  vnode
) {
  var options = vnode.componentOptions;
  var child = vnode.componentInstance = oldVnode.componentInstance;
  child._updateFromParent(
    options.propsData, // updated props
    options.listeners, // updated listeners
    vnode, // new parent vnode
    options.children // new children
  );
}

function insert (vnode) {
  if (!vnode.componentInstance._isMounted) {
    vnode.componentInstance._isMounted = true;
    callHook(vnode.componentInstance, 'mounted');
  }
  if (vnode.data.keepAlive) {
    vnode.componentInstance._inactive = false;
    callHook(vnode.componentInstance, 'activated');
  }
}

function destroy$1 (vnode) {
  if (!vnode.componentInstance._isDestroyed) {
    if (!vnode.data.keepAlive) {
      vnode.componentInstance.$destroy();
    } else {
      vnode.componentInstance._inactive = true;
      callHook(vnode.componentInstance, 'deactivated');
    }
  }
}

function resolveAsyncComponent (
  factory,
  baseCtor,
  cb
) {
  if (factory.requested) {
    // pool callbacks
    factory.pendingCallbacks.push(cb);
  } else {
    factory.requested = true;
    var cbs = factory.pendingCallbacks = [cb];
    var sync = true;

    var resolve = function (res) {
      if (isObject(res)) {
        res = baseCtor.extend(res);
      }
      // cache resolved
      factory.resolved = res;
      // invoke callbacks only if this is not a synchronous resolve
      // (async resolves are shimmed as synchronous during SSR)
      if (!sync) {
        for (var i = 0, l = cbs.length; i < l; i++) {
          cbs[i](res);
        }
      }
    };

    var reject = function (reason) {
      process.env.NODE_ENV !== 'production' && warn(
        "Failed to resolve async component: " + (String(factory)) +
        (reason ? ("\nReason: " + reason) : '')
      );
    };

    var res = factory(resolve, reject);

    // handle promise
    if (res && typeof res.then === 'function' && !factory.resolved) {
      res.then(resolve, reject);
    }

    sync = false;
    // return in case resolved synchronously
    return factory.resolved
  }
}

function extractProps (data, Ctor) {
  // we are only extracting raw values here.
  // validation and default values are handled in the child
  // component itself.
  var propOptions = Ctor.options.props;
  if (!propOptions) {
    return
  }
  var res = {};
  var attrs = data.attrs;
  var props = data.props;
  var domProps = data.domProps;
  if (attrs || props || domProps) {
    for (var key in propOptions) {
      var altKey = hyphenate(key);
      checkProp(res, props, key, altKey, true) ||
      checkProp(res, attrs, key, altKey) ||
      checkProp(res, domProps, key, altKey);
    }
  }
  return res
}

function checkProp (
  res,
  hash,
  key,
  altKey,
  preserve
) {
  if (hash) {
    if (hasOwn(hash, key)) {
      res[key] = hash[key];
      if (!preserve) {
        delete hash[key];
      }
      return true
    } else if (hasOwn(hash, altKey)) {
      res[key] = hash[altKey];
      if (!preserve) {
        delete hash[altKey];
      }
      return true
    }
  }
  return false
}

function mergeHooks (data) {
  if (!data.hook) {
    data.hook = {};
  }
  for (var i = 0; i < hooksToMerge.length; i++) {
    var key = hooksToMerge[i];
    var fromParent = data.hook[key];
    var ours = hooks[key];
    data.hook[key] = fromParent ? mergeHook$1(ours, fromParent) : ours;
  }
}

function mergeHook$1 (one, two) {
  return function (a, b, c, d) {
    one(a, b, c, d);
    two(a, b, c, d);
  }
}

/*  */

function mergeVNodeHook (def, hookKey, hook, key) {
  key = key + hookKey;
  var injectedHash = def.__injected || (def.__injected = {});
  if (!injectedHash[key]) {
    injectedHash[key] = true;
    var oldHook = def[hookKey];
    if (oldHook) {
      def[hookKey] = function () {
        oldHook.apply(this, arguments);
        hook.apply(this, arguments);
      };
    } else {
      def[hookKey] = hook;
    }
  }
}

/*  */

var normalizeEvent = cached(function (name) {
  var once = name.charAt(0) === '~'; // Prefixed last, checked first
  name = once ? name.slice(1) : name;
  var capture = name.charAt(0) === '!';
  name = capture ? name.slice(1) : name;
  return {
    name: name,
    once: once,
    capture: capture
  }
});

function createEventHandle (fn) {
  var handle = {
    fn: fn,
    invoker: function () {
      var arguments$1 = arguments;

      var fn = handle.fn;
      if (Array.isArray(fn)) {
        for (var i = 0; i < fn.length; i++) {
          fn[i].apply(null, arguments$1);
        }
      } else {
        fn.apply(null, arguments);
      }
    }
  };
  return handle
}

function updateListeners (
  on,
  oldOn,
  add,
  remove$$1,
  vm
) {
  var name, cur, old, event;
  for (name in on) {
    cur = on[name];
    old = oldOn[name];
    event = normalizeEvent(name);
    if (!cur) {
      process.env.NODE_ENV !== 'production' && warn(
        "Invalid handler for event \"" + (event.name) + "\": got " + String(cur),
        vm
      );
    } else if (!old) {
      if (!cur.invoker) {
        cur = on[name] = createEventHandle(cur);
      }
      add(event.name, cur.invoker, event.once, event.capture);
    } else if (cur !== old) {
      old.fn = cur;
      on[name] = old;
    }
  }
  for (name in oldOn) {
    if (!on[name]) {
      event = normalizeEvent(name);
      remove$$1(event.name, oldOn[name].invoker, event.capture);
    }
  }
}

/*  */

// The template compiler attempts to minimize the need for normalization by
// statically analyzing the template at compile time.
//
// For plain HTML markup, normalization can be completely skipped because the
// generated render function is guaranteed to return Array<VNode>. There are
// two cases where extra normalization is needed:

// 1. When the children contains components - because a functional component
// may return an Array instead of a single root. In this case, just a simple
// nomralization is needed - if any child is an Array, we flatten the whole
// thing with Array.prototype.concat. It is guaranteed to be only 1-level deep
// because functional components already normalize their own children.
function simpleNormalizeChildren (children) {
  for (var i = 0; i < children.length; i++) {
    if (Array.isArray(children[i])) {
      return Array.prototype.concat.apply([], children)
    }
  }
  return children
}

// 2. When the children contains constrcuts that always generated nested Arrays,
// e.g. <template>, <slot>, v-for, or when the children is provided by user
// with hand-written render functions / JSX. In such cases a full normalization
// is needed to cater to all possible types of children values.
function normalizeChildren (children) {
  return isPrimitive(children)
    ? [createTextVNode(children)]
    : Array.isArray(children)
      ? normalizeArrayChildren(children)
      : undefined
}

function normalizeArrayChildren (children, nestedIndex) {
  var res = [];
  var i, c, last;
  for (i = 0; i < children.length; i++) {
    c = children[i];
    if (c == null || typeof c === 'boolean') { continue }
    last = res[res.length - 1];
    //  nested
    if (Array.isArray(c)) {
      res.push.apply(res, normalizeArrayChildren(c, ((nestedIndex || '') + "_" + i)));
    } else if (isPrimitive(c)) {
      if (last && last.text) {
        last.text += String(c);
      } else if (c !== '') {
        // convert primitive to vnode
        res.push(createTextVNode(c));
      }
    } else {
      if (c.text && last && last.text) {
        res[res.length - 1] = createTextVNode(last.text + c.text);
      } else {
        // default key for nested array children (likely generated by v-for)
        if (c.tag && c.key == null && nestedIndex != null) {
          c.key = "__vlist" + nestedIndex + "_" + i + "__";
        }
        res.push(c);
      }
    }
  }
  return res
}

/*  */

function getFirstComponentChild (children) {
  return children && children.filter(function (c) { return c && c.componentOptions; })[0]
}

/*  */

var SIMPLE_NORMALIZE = 1;
var ALWAYS_NORMALIZE = 2;

// wrapper function for providing a more flexible interface
// without getting yelled at by flow
function createElement (
  context,
  tag,
  data,
  children,
  normalizationType,
  alwaysNormalize
) {
  if (Array.isArray(data) || isPrimitive(data)) {
    normalizationType = children;
    children = data;
    data = undefined;
  }
  if (alwaysNormalize) { normalizationType = ALWAYS_NORMALIZE; }
  return _createElement(context, tag, data, children, normalizationType)
}

function _createElement (
  context,
  tag,
  data,
  children,
  normalizationType
) {
  if (data && data.__ob__) {
    process.env.NODE_ENV !== 'production' && warn(
      "Avoid using observed data object as vnode data: " + (JSON.stringify(data)) + "\n" +
      'Always create fresh vnode data objects in each render!',
      context
    );
    return createEmptyVNode()
  }
  if (!tag) {
    // in case of component :is set to falsy value
    return createEmptyVNode()
  }
  // support single function children as default scoped slot
  if (Array.isArray(children) &&
      typeof children[0] === 'function') {
    data = data || {};
    data.scopedSlots = { default: children[0] };
    children.length = 0;
  }
  if (normalizationType === ALWAYS_NORMALIZE) {
    children = normalizeChildren(children);
  } else if (normalizationType === SIMPLE_NORMALIZE) {
    children = simpleNormalizeChildren(children);
  }
  var vnode, ns;
  if (typeof tag === 'string') {
    var Ctor;
    ns = config.getTagNamespace(tag);
    if (config.isReservedTag(tag)) {
      // platform built-in elements
      vnode = new VNode(
        config.parsePlatformTagName(tag), data, children,
        undefined, undefined, context
      );
    } else if ((Ctor = resolveAsset(context.$options, 'components', tag))) {
      // component
      vnode = createComponent(Ctor, data, context, children, tag);
    } else {
      // unknown or unlisted namespaced elements
      // check at runtime because it may get assigned a namespace when its
      // parent normalizes children
      vnode = new VNode(
        tag, data, children,
        undefined, undefined, context
      );
    }
  } else {
    // direct component options / constructor
    vnode = createComponent(tag, data, context, children);
  }
  if (vnode) {
    if (ns) { applyNS(vnode, ns); }
    return vnode
  } else {
    return createEmptyVNode()
  }
}

function applyNS (vnode, ns) {
  vnode.ns = ns;
  if (vnode.tag === 'foreignObject') {
    // use default namespace inside foreignObject
    return
  }
  if (vnode.children) {
    for (var i = 0, l = vnode.children.length; i < l; i++) {
      var child = vnode.children[i];
      if (child.tag && !child.ns) {
        applyNS(child, ns);
      }
    }
  }
}

/*  */

function initRender (vm) {
  vm.$vnode = null; // the placeholder node in parent tree
  vm._vnode = null; // the root of the child tree
  vm._staticTrees = null;
  var parentVnode = vm.$options._parentVnode;
  var renderContext = parentVnode && parentVnode.context;
  vm.$slots = resolveSlots(vm.$options._renderChildren, renderContext);
  vm.$scopedSlots = {};
  // bind the createElement fn to this instance
  // so that we get proper render context inside it.
  // args order: tag, data, children, normalizationType, alwaysNormalize
  // internal version is used by render functions compiled from templates
  vm._c = function (a, b, c, d) { return createElement(vm, a, b, c, d, false); };
  // normalization is always applied for the public version, used in
  // user-written render functions.
  vm.$createElement = function (a, b, c, d) { return createElement(vm, a, b, c, d, true); };
}

function renderMixin (Vue) {
  Vue.prototype.$nextTick = function (fn) {
    return nextTick(fn, this)
  };

  Vue.prototype._render = function () {
    var vm = this;
    var ref = vm.$options;
    var render = ref.render;
    var staticRenderFns = ref.staticRenderFns;
    var _parentVnode = ref._parentVnode;

    if (vm._isMounted) {
      // clone slot nodes on re-renders
      for (var key in vm.$slots) {
        vm.$slots[key] = cloneVNodes(vm.$slots[key]);
      }
    }

    if (_parentVnode && _parentVnode.data.scopedSlots) {
      vm.$scopedSlots = _parentVnode.data.scopedSlots;
    }

    if (staticRenderFns && !vm._staticTrees) {
      vm._staticTrees = [];
    }
    // set parent vnode. this allows render functions to have access
    // to the data on the placeholder node.
    vm.$vnode = _parentVnode;
    // render self
    var vnode;
    try {
      vnode = render.call(vm._renderProxy, vm.$createElement);
    } catch (e) {
      /* istanbul ignore else */
      if (config.errorHandler) {
        config.errorHandler.call(null, e, vm);
      } else {
        if (process.env.NODE_ENV !== 'production') {
          warn(("Error when rendering " + (formatComponentName(vm)) + ":"));
        }
        throw e
      }
      // return previous vnode to prevent render error causing blank component
      vnode = vm._vnode;
    }
    // return empty vnode in case the render function errored out
    if (!(vnode instanceof VNode)) {
      if (process.env.NODE_ENV !== 'production' && Array.isArray(vnode)) {
        warn(
          'Multiple root nodes returned from render function. Render function ' +
          'should return a single root node.',
          vm
        );
      }
      vnode = createEmptyVNode();
    }
    // set parent
    vnode.parent = _parentVnode;
    return vnode
  };

  // toString for mustaches
  Vue.prototype._s = _toString;
  // convert text to vnode
  Vue.prototype._v = createTextVNode;
  // number conversion
  Vue.prototype._n = toNumber;
  // empty vnode
  Vue.prototype._e = createEmptyVNode;
  // loose equal
  Vue.prototype._q = looseEqual;
  // loose indexOf
  Vue.prototype._i = looseIndexOf;

  // render static tree by index
  Vue.prototype._m = function renderStatic (
    index,
    isInFor
  ) {
    var tree = this._staticTrees[index];
    // if has already-rendered static tree and not inside v-for,
    // we can reuse the same tree by doing a shallow clone.
    if (tree && !isInFor) {
      return Array.isArray(tree)
        ? cloneVNodes(tree)
        : cloneVNode(tree)
    }
    // otherwise, render a fresh tree.
    tree = this._staticTrees[index] = this.$options.staticRenderFns[index].call(this._renderProxy);
    markStatic(tree, ("__static__" + index), false);
    return tree
  };

  // mark node as static (v-once)
  Vue.prototype._o = function markOnce (
    tree,
    index,
    key
  ) {
    markStatic(tree, ("__once__" + index + (key ? ("_" + key) : "")), true);
    return tree
  };

  function markStatic (tree, key, isOnce) {
    if (Array.isArray(tree)) {
      for (var i = 0; i < tree.length; i++) {
        if (tree[i] && typeof tree[i] !== 'string') {
          markStaticNode(tree[i], (key + "_" + i), isOnce);
        }
      }
    } else {
      markStaticNode(tree, key, isOnce);
    }
  }

  function markStaticNode (node, key, isOnce) {
    node.isStatic = true;
    node.key = key;
    node.isOnce = isOnce;
  }

  // filter resolution helper
  Vue.prototype._f = function resolveFilter (id) {
    return resolveAsset(this.$options, 'filters', id, true) || identity
  };

  // render v-for
  Vue.prototype._l = function renderList (
    val,
    render
  ) {
    var ret, i, l, keys, key;
    if (Array.isArray(val) || typeof val === 'string') {
      ret = new Array(val.length);
      for (i = 0, l = val.length; i < l; i++) {
        ret[i] = render(val[i], i);
      }
    } else if (typeof val === 'number') {
      ret = new Array(val);
      for (i = 0; i < val; i++) {
        ret[i] = render(i + 1, i);
      }
    } else if (isObject(val)) {
      keys = Object.keys(val);
      ret = new Array(keys.length);
      for (i = 0, l = keys.length; i < l; i++) {
        key = keys[i];
        ret[i] = render(val[key], key, i);
      }
    }
    return ret
  };

  // renderSlot
  Vue.prototype._t = function (
    name,
    fallback,
    props,
    bindObject
  ) {
    var scopedSlotFn = this.$scopedSlots[name];
    if (scopedSlotFn) { // scoped slot
      props = props || {};
      if (bindObject) {
        extend(props, bindObject);
      }
      return scopedSlotFn(props) || fallback
    } else {
      var slotNodes = this.$slots[name];
      // warn duplicate slot usage
      if (slotNodes && process.env.NODE_ENV !== 'production') {
        slotNodes._rendered && warn(
          "Duplicate presence of slot \"" + name + "\" found in the same render tree " +
          "- this will likely cause render errors.",
          this
        );
        slotNodes._rendered = true;
      }
      return slotNodes || fallback
    }
  };

  // apply v-bind object
  Vue.prototype._b = function bindProps (
    data,
    tag,
    value,
    asProp
  ) {
    if (value) {
      if (!isObject(value)) {
        process.env.NODE_ENV !== 'production' && warn(
          'v-bind without argument expects an Object or Array value',
          this
        );
      } else {
        if (Array.isArray(value)) {
          value = toObject(value);
        }
        for (var key in value) {
          if (key === 'class' || key === 'style') {
            data[key] = value[key];
          } else {
            var type = data.attrs && data.attrs.type;
            var hash = asProp || config.mustUseProp(tag, type, key)
              ? data.domProps || (data.domProps = {})
              : data.attrs || (data.attrs = {});
            hash[key] = value[key];
          }
        }
      }
    }
    return data
  };

  // check v-on keyCodes
  Vue.prototype._k = function checkKeyCodes (
    eventKeyCode,
    key,
    builtInAlias
  ) {
    var keyCodes = config.keyCodes[key] || builtInAlias;
    if (Array.isArray(keyCodes)) {
      return keyCodes.indexOf(eventKeyCode) === -1
    } else {
      return keyCodes !== eventKeyCode
    }
  };
}

function resolveSlots (
  children,
  context
) {
  var slots = {};
  if (!children) {
    return slots
  }
  var defaultSlot = [];
  var name, child;
  for (var i = 0, l = children.length; i < l; i++) {
    child = children[i];
    // named slots should only be respected if the vnode was rendered in the
    // same context.
    if ((child.context === context || child.functionalContext === context) &&
        child.data && (name = child.data.slot)) {
      var slot = (slots[name] || (slots[name] = []));
      if (child.tag === 'template') {
        slot.push.apply(slot, child.children);
      } else {
        slot.push(child);
      }
    } else {
      defaultSlot.push(child);
    }
  }
  // ignore single whitespace
  if (defaultSlot.length && !(
    defaultSlot.length === 1 &&
    (defaultSlot[0].text === ' ' || defaultSlot[0].isComment)
  )) {
    slots.default = defaultSlot;
  }
  return slots
}

/*  */

function initEvents (vm) {
  vm._events = Object.create(null);
  vm._hasHookEvent = false;
  // init parent attached events
  var listeners = vm.$options._parentListeners;
  if (listeners) {
    updateComponentListeners(vm, listeners);
  }
}

var target;

function add$1 (event, fn, once) {
  if (once) {
    target.$once(event, fn);
  } else {
    target.$on(event, fn);
  }
}

function remove$2 (event, fn) {
  target.$off(event, fn);
}

function updateComponentListeners (
  vm,
  listeners,
  oldListeners
) {
  target = vm;
  updateListeners(listeners, oldListeners || {}, add$1, remove$2, vm);
}

function eventsMixin (Vue) {
  var hookRE = /^hook:/;
  Vue.prototype.$on = function (event, fn) {
    var vm = this;(vm._events[event] || (vm._events[event] = [])).push(fn);
    // optimize hook:event cost by using a boolean flag marked at registration
    // instead of a hash lookup
    if (hookRE.test(event)) {
      vm._hasHookEvent = true;
    }
    return vm
  };

  Vue.prototype.$once = function (event, fn) {
    var vm = this;
    function on () {
      vm.$off(event, on);
      fn.apply(vm, arguments);
    }
    on.fn = fn;
    vm.$on(event, on);
    return vm
  };

  Vue.prototype.$off = function (event, fn) {
    var vm = this;
    // all
    if (!arguments.length) {
      vm._events = Object.create(null);
      return vm
    }
    // specific event
    var cbs = vm._events[event];
    if (!cbs) {
      return vm
    }
    if (arguments.length === 1) {
      vm._events[event] = null;
      return vm
    }
    // specific handler
    var cb;
    var i = cbs.length;
    while (i--) {
      cb = cbs[i];
      if (cb === fn || cb.fn === fn) {
        cbs.splice(i, 1);
        break
      }
    }
    return vm
  };

  Vue.prototype.$emit = function (event) {
    var vm = this;
    var cbs = vm._events[event];
    if (cbs) {
      cbs = cbs.length > 1 ? toArray(cbs) : cbs;
      var args = toArray(arguments, 1);
      for (var i = 0, l = cbs.length; i < l; i++) {
        cbs[i].apply(vm, args);
      }
    }
    return vm
  };
}

/*  */

var activeInstance = null;

function initLifecycle (vm) {
  var options = vm.$options;

  // locate first non-abstract parent
  var parent = options.parent;
  if (parent && !options.abstract) {
    while (parent.$options.abstract && parent.$parent) {
      parent = parent.$parent;
    }
    parent.$children.push(vm);
  }

  vm.$parent = parent;
  vm.$root = parent ? parent.$root : vm;

  vm.$children = [];
  vm.$refs = {};

  vm._watcher = null;
  vm._inactive = false;
  vm._isMounted = false;
  vm._isDestroyed = false;
  vm._isBeingDestroyed = false;
}

function lifecycleMixin (Vue) {
  Vue.prototype._mount = function (
    el,
    hydrating
  ) {
    var vm = this;
    vm.$el = el;
    if (!vm.$options.render) {
      vm.$options.render = createEmptyVNode;
      if (process.env.NODE_ENV !== 'production') {
        /* istanbul ignore if */
        if (vm.$options.template && vm.$options.template.charAt(0) !== '#') {
          warn(
            'You are using the runtime-only build of Vue where the template ' +
            'option is not available. Either pre-compile the templates into ' +
            'render functions, or use the compiler-included build.',
            vm
          );
        } else {
          warn(
            'Failed to mount component: template or render function not defined.',
            vm
          );
        }
      }
    }
    callHook(vm, 'beforeMount');
    vm._watcher = new Watcher(vm, function updateComponent () {
      vm._update(vm._render(), hydrating);
    }, noop);
    hydrating = false;
    // manually mounted instance, call mounted on self
    // mounted is called for render-created child components in its inserted hook
    if (vm.$vnode == null) {
      vm._isMounted = true;
      callHook(vm, 'mounted');
    }
    return vm
  };

  Vue.prototype._update = function (vnode, hydrating) {
    var vm = this;
    if (vm._isMounted) {
      callHook(vm, 'beforeUpdate');
    }
    var prevEl = vm.$el;
    var prevVnode = vm._vnode;
    var prevActiveInstance = activeInstance;
    activeInstance = vm;
    vm._vnode = vnode;
    // Vue.prototype.__patch__ is injected in entry points
    // based on the rendering backend used.
    if (!prevVnode) {
      // initial render
      vm.$el = vm.__patch__(
        vm.$el, vnode, hydrating, false /* removeOnly */,
        vm.$options._parentElm,
        vm.$options._refElm
      );
    } else {
      // updates
      vm.$el = vm.__patch__(prevVnode, vnode);
    }
    activeInstance = prevActiveInstance;
    // update __vue__ reference
    if (prevEl) {
      prevEl.__vue__ = null;
    }
    if (vm.$el) {
      vm.$el.__vue__ = vm;
    }
    // if parent is an HOC, update its $el as well
    if (vm.$vnode && vm.$parent && vm.$vnode === vm.$parent._vnode) {
      vm.$parent.$el = vm.$el;
    }
    // updated hook is called by the scheduler to ensure that children are
    // updated in a parent's updated hook.
  };

  Vue.prototype._updateFromParent = function (
    propsData,
    listeners,
    parentVnode,
    renderChildren
  ) {
    var vm = this;
    var hasChildren = !!(vm.$options._renderChildren || renderChildren);
    vm.$options._parentVnode = parentVnode;
    vm.$vnode = parentVnode; // update vm's placeholder node without re-render
    if (vm._vnode) { // update child tree's parent
      vm._vnode.parent = parentVnode;
    }
    vm.$options._renderChildren = renderChildren;
    // update props
    if (propsData && vm.$options.props) {
      observerState.shouldConvert = false;
      if (process.env.NODE_ENV !== 'production') {
        observerState.isSettingProps = true;
      }
      var propKeys = vm.$options._propKeys || [];
      for (var i = 0; i < propKeys.length; i++) {
        var key = propKeys[i];
        vm[key] = validateProp(key, vm.$options.props, propsData, vm);
      }
      observerState.shouldConvert = true;
      if (process.env.NODE_ENV !== 'production') {
        observerState.isSettingProps = false;
      }
      vm.$options.propsData = propsData;
    }
    // update listeners
    if (listeners) {
      var oldListeners = vm.$options._parentListeners;
      vm.$options._parentListeners = listeners;
      updateComponentListeners(vm, listeners, oldListeners);
    }
    // resolve slots + force update if has children
    if (hasChildren) {
      vm.$slots = resolveSlots(renderChildren, parentVnode.context);
      vm.$forceUpdate();
    }
  };

  Vue.prototype.$forceUpdate = function () {
    var vm = this;
    if (vm._watcher) {
      vm._watcher.update();
    }
  };

  Vue.prototype.$destroy = function () {
    var vm = this;
    if (vm._isBeingDestroyed) {
      return
    }
    callHook(vm, 'beforeDestroy');
    vm._isBeingDestroyed = true;
    // remove self from parent
    var parent = vm.$parent;
    if (parent && !parent._isBeingDestroyed && !vm.$options.abstract) {
      remove$1(parent.$children, vm);
    }
    // teardown watchers
    if (vm._watcher) {
      vm._watcher.teardown();
    }
    var i = vm._watchers.length;
    while (i--) {
      vm._watchers[i].teardown();
    }
    // remove reference from data ob
    // frozen object may not have observer.
    if (vm._data.__ob__) {
      vm._data.__ob__.vmCount--;
    }
    // call the last hook...
    vm._isDestroyed = true;
    callHook(vm, 'destroyed');
    // turn off all instance listeners.
    vm.$off();
    // remove __vue__ reference
    if (vm.$el) {
      vm.$el.__vue__ = null;
    }
    // invoke destroy hooks on current rendered tree
    vm.__patch__(vm._vnode, null);
  };
}

function callHook (vm, hook) {
  var handlers = vm.$options[hook];
  if (handlers) {
    for (var i = 0, j = handlers.length; i < j; i++) {
      handlers[i].call(vm);
    }
  }
  if (vm._hasHookEvent) {
    vm.$emit('hook:' + hook);
  }
}

/*  */


var queue = [];
var has$1 = {};
var circular = {};
var waiting = false;
var flushing = false;
var index = 0;

/**
 * Reset the scheduler's state.
 */
function resetSchedulerState () {
  queue.length = 0;
  has$1 = {};
  if (process.env.NODE_ENV !== 'production') {
    circular = {};
  }
  waiting = flushing = false;
}

/**
 * Flush both queues and run the watchers.
 */
function flushSchedulerQueue () {
  flushing = true;
  var watcher, id, vm;

  // Sort queue before flush.
  // This ensures that:
  // 1. Components are updated from parent to child. (because parent is always
  //    created before the child)
  // 2. A component's user watchers are run before its render watcher (because
  //    user watchers are created before the render watcher)
  // 3. If a component is destroyed during a parent component's watcher run,
  //    its watchers can be skipped.
  queue.sort(function (a, b) { return a.id - b.id; });

  // do not cache length because more watchers might be pushed
  // as we run existing watchers
  for (index = 0; index < queue.length; index++) {
    watcher = queue[index];
    id = watcher.id;
    has$1[id] = null;
    watcher.run();
    // in dev build, check and stop circular updates.
    if (process.env.NODE_ENV !== 'production' && has$1[id] != null) {
      circular[id] = (circular[id] || 0) + 1;
      if (circular[id] > config._maxUpdateCount) {
        warn(
          'You may have an infinite update loop ' + (
            watcher.user
              ? ("in watcher with expression \"" + (watcher.expression) + "\"")
              : "in a component render function."
          ),
          watcher.vm
        );
        break
      }
    }
  }

  // call updated hooks
  index = queue.length;
  while (index--) {
    watcher = queue[index];
    vm = watcher.vm;
    if (vm._watcher === watcher && vm._isMounted) {
      callHook(vm, 'updated');
    }
  }

  // devtool hook
  /* istanbul ignore if */
  if (devtools && config.devtools) {
    devtools.emit('flush');
  }

  resetSchedulerState();
}

/**
 * Push a watcher into the watcher queue.
 * Jobs with duplicate IDs will be skipped unless it's
 * pushed when the queue is being flushed.
 */
function queueWatcher (watcher) {
  var id = watcher.id;
  if (has$1[id] == null) {
    has$1[id] = true;
    if (!flushing) {
      queue.push(watcher);
    } else {
      // if already flushing, splice the watcher based on its id
      // if already past its id, it will be run next immediately.
      var i = queue.length - 1;
      while (i >= 0 && queue[i].id > watcher.id) {
        i--;
      }
      queue.splice(Math.max(i, index) + 1, 0, watcher);
    }
    // queue the flush
    if (!waiting) {
      waiting = true;
      nextTick(flushSchedulerQueue);
    }
  }
}

/*  */

var uid$2 = 0;

/**
 * A watcher parses an expression, collects dependencies,
 * and fires callback when the expression value changes.
 * This is used for both the $watch() api and directives.
 */
var Watcher = function Watcher (
  vm,
  expOrFn,
  cb,
  options
) {
  this.vm = vm;
  vm._watchers.push(this);
  // options
  if (options) {
    this.deep = !!options.deep;
    this.user = !!options.user;
    this.lazy = !!options.lazy;
    this.sync = !!options.sync;
  } else {
    this.deep = this.user = this.lazy = this.sync = false;
  }
  this.cb = cb;
  this.id = ++uid$2; // uid for batching
  this.active = true;
  this.dirty = this.lazy; // for lazy watchers
  this.deps = [];
  this.newDeps = [];
  this.depIds = new _Set();
  this.newDepIds = new _Set();
  this.expression = process.env.NODE_ENV !== 'production'
    ? expOrFn.toString()
    : '';
  // parse expression for getter
  if (typeof expOrFn === 'function') {
    this.getter = expOrFn;
  } else {
    this.getter = parsePath(expOrFn);
    if (!this.getter) {
      this.getter = function () {};
      process.env.NODE_ENV !== 'production' && warn(
        "Failed watching path: \"" + expOrFn + "\" " +
        'Watcher only accepts simple dot-delimited paths. ' +
        'For full control, use a function instead.',
        vm
      );
    }
  }
  this.value = this.lazy
    ? undefined
    : this.get();
};

/**
 * Evaluate the getter, and re-collect dependencies.
 */
Watcher.prototype.get = function get () {
  pushTarget(this);
  var value = this.getter.call(this.vm, this.vm);
  // "touch" every property so they are all tracked as
  // dependencies for deep watching
  if (this.deep) {
    traverse(value);
  }
  popTarget();
  this.cleanupDeps();
  return value
};

/**
 * Add a dependency to this directive.
 */
Watcher.prototype.addDep = function addDep (dep) {
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
Watcher.prototype.cleanupDeps = function cleanupDeps () {
    var this$1 = this;

  var i = this.deps.length;
  while (i--) {
    var dep = this$1.deps[i];
    if (!this$1.newDepIds.has(dep.id)) {
      dep.removeSub(this$1);
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
 */
Watcher.prototype.update = function update () {
  /* istanbul ignore else */
  if (this.lazy) {
    this.dirty = true;
  } else if (this.sync) {
    this.run();
  } else {
    queueWatcher(this);
  }
};

/**
 * Scheduler job interface.
 * Will be called by the scheduler.
 */
Watcher.prototype.run = function run () {
  if (this.active) {
    var value = this.get();
    if (
      value !== this.value ||
      // Deep watchers and watchers on Object/Arrays should fire even
      // when the value is the same, because the value may
      // have mutated.
      isObject(value) ||
      this.deep
    ) {
      // set new value
      var oldValue = this.value;
      this.value = value;
      if (this.user) {
        try {
          this.cb.call(this.vm, value, oldValue);
        } catch (e) {
          /* istanbul ignore else */
          if (config.errorHandler) {
            config.errorHandler.call(null, e, this.vm);
          } else {
            process.env.NODE_ENV !== 'production' && warn(
              ("Error in watcher \"" + (this.expression) + "\""),
              this.vm
            );
            throw e
          }
        }
      } else {
        this.cb.call(this.vm, value, oldValue);
      }
    }
  }
};

/**
 * Evaluate the value of the watcher.
 * This only gets called for lazy watchers.
 */
Watcher.prototype.evaluate = function evaluate () {
  this.value = this.get();
  this.dirty = false;
};

/**
 * Depend on all deps collected by this watcher.
 */
Watcher.prototype.depend = function depend () {
    var this$1 = this;

  var i = this.deps.length;
  while (i--) {
    this$1.deps[i].depend();
  }
};

/**
 * Remove self from all dependencies' subscriber list.
 */
Watcher.prototype.teardown = function teardown () {
    var this$1 = this;

  if (this.active) {
    // remove self from vm's watcher list
    // this is a somewhat expensive operation so we skip it
    // if the vm is being destroyed.
    if (!this.vm._isBeingDestroyed) {
      remove$1(this.vm._watchers, this);
    }
    var i = this.deps.length;
    while (i--) {
      this$1.deps[i].removeSub(this$1);
    }
    this.active = false;
  }
};

/**
 * Recursively traverse an object to evoke all converted
 * getters, so that every nested property inside the object
 * is collected as a "deep" dependency.
 */
var seenObjects = new _Set();
function traverse (val) {
  seenObjects.clear();
  _traverse(val, seenObjects);
}

function _traverse (val, seen) {
  var i, keys;
  var isA = Array.isArray(val);
  if ((!isA && !isObject(val)) || !Object.isExtensible(val)) {
    return
  }
  if (val.__ob__) {
    var depId = val.__ob__.dep.id;
    if (seen.has(depId)) {
      return
    }
    seen.add(depId);
  }
  if (isA) {
    i = val.length;
    while (i--) { _traverse(val[i], seen); }
  } else {
    keys = Object.keys(val);
    i = keys.length;
    while (i--) { _traverse(val[keys[i]], seen); }
  }
}

/*  */

function initState (vm) {
  vm._watchers = [];
  var opts = vm.$options;
  if (opts.props) { initProps(vm, opts.props); }
  if (opts.methods) { initMethods(vm, opts.methods); }
  if (opts.data) {
    initData(vm);
  } else {
    observe(vm._data = {}, true /* asRootData */);
  }
  if (opts.computed) { initComputed(vm, opts.computed); }
  if (opts.watch) { initWatch(vm, opts.watch); }
}

var isReservedProp = { key: 1, ref: 1, slot: 1 };

function initProps (vm, props) {
  var propsData = vm.$options.propsData || {};
  var keys = vm.$options._propKeys = Object.keys(props);
  var isRoot = !vm.$parent;
  // root instance props should be converted
  observerState.shouldConvert = isRoot;
  var loop = function ( i ) {
    var key = keys[i];
    /* istanbul ignore else */
    if (process.env.NODE_ENV !== 'production') {
      if (isReservedProp[key]) {
        warn(
          ("\"" + key + "\" is a reserved attribute and cannot be used as component prop."),
          vm
        );
      }
      defineReactive$$1(vm, key, validateProp(key, props, propsData, vm), function () {
        if (vm.$parent && !observerState.isSettingProps) {
          warn(
            "Avoid mutating a prop directly since the value will be " +
            "overwritten whenever the parent component re-renders. " +
            "Instead, use a data or computed property based on the prop's " +
            "value. Prop being mutated: \"" + key + "\"",
            vm
          );
        }
      });
    } else {
      defineReactive$$1(vm, key, validateProp(key, props, propsData, vm));
    }
  };

  for (var i = 0; i < keys.length; i++) loop( i );
  observerState.shouldConvert = true;
}

function initData (vm) {
  var data = vm.$options.data;
  data = vm._data = typeof data === 'function'
    ? data.call(vm)
    : data || {};
  if (!isPlainObject(data)) {
    data = {};
    process.env.NODE_ENV !== 'production' && warn(
      'data functions should return an object:\n' +
      'https://vuejs.org/v2/guide/components.html#data-Must-Be-a-Function',
      vm
    );
  }
  // proxy data on instance
  var keys = Object.keys(data);
  var props = vm.$options.props;
  var i = keys.length;
  while (i--) {
    if (props && hasOwn(props, keys[i])) {
      process.env.NODE_ENV !== 'production' && warn(
        "The data property \"" + (keys[i]) + "\" is already declared as a prop. " +
        "Use prop default value instead.",
        vm
      );
    } else {
      proxy(vm, keys[i]);
    }
  }
  // observe data
  observe(data, true /* asRootData */);
}

var computedSharedDefinition = {
  enumerable: true,
  configurable: true,
  get: noop,
  set: noop
};

function initComputed (vm, computed) {
  for (var key in computed) {
    /* istanbul ignore if */
    if (process.env.NODE_ENV !== 'production' && key in vm) {
      warn(
        "existing instance property \"" + key + "\" will be " +
        "overwritten by a computed property with the same name.",
        vm
      );
    }
    var userDef = computed[key];
    if (typeof userDef === 'function') {
      computedSharedDefinition.get = makeComputedGetter(userDef, vm);
      computedSharedDefinition.set = noop;
    } else {
      computedSharedDefinition.get = userDef.get
        ? userDef.cache !== false
          ? makeComputedGetter(userDef.get, vm)
          : bind$1(userDef.get, vm)
        : noop;
      computedSharedDefinition.set = userDef.set
        ? bind$1(userDef.set, vm)
        : noop;
    }
    Object.defineProperty(vm, key, computedSharedDefinition);
  }
}

function makeComputedGetter (getter, owner) {
  var watcher = new Watcher(owner, getter, noop, {
    lazy: true
  });
  return function computedGetter () {
    if (watcher.dirty) {
      watcher.evaluate();
    }
    if (Dep.target) {
      watcher.depend();
    }
    return watcher.value
  }
}

function initMethods (vm, methods) {
  for (var key in methods) {
    vm[key] = methods[key] == null ? noop : bind$1(methods[key], vm);
    if (process.env.NODE_ENV !== 'production' && methods[key] == null) {
      warn(
        "method \"" + key + "\" has an undefined value in the component definition. " +
        "Did you reference the function correctly?",
        vm
      );
    }
  }
}

function initWatch (vm, watch) {
  for (var key in watch) {
    var handler = watch[key];
    if (Array.isArray(handler)) {
      for (var i = 0; i < handler.length; i++) {
        createWatcher(vm, key, handler[i]);
      }
    } else {
      createWatcher(vm, key, handler);
    }
  }
}

function createWatcher (vm, key, handler) {
  var options;
  if (isPlainObject(handler)) {
    options = handler;
    handler = handler.handler;
  }
  if (typeof handler === 'string') {
    handler = vm[handler];
  }
  vm.$watch(key, handler, options);
}

function stateMixin (Vue) {
  // flow somehow has problems with directly declared definition object
  // when using Object.defineProperty, so we have to procedurally build up
  // the object here.
  var dataDef = {};
  dataDef.get = function () {
    return this._data
  };
  if (process.env.NODE_ENV !== 'production') {
    dataDef.set = function (newData) {
      warn(
        'Avoid replacing instance root $data. ' +
        'Use nested data properties instead.',
        this
      );
    };
  }
  Object.defineProperty(Vue.prototype, '$data', dataDef);

  Vue.prototype.$set = set$1;
  Vue.prototype.$delete = del;

  Vue.prototype.$watch = function (
    expOrFn,
    cb,
    options
  ) {
    var vm = this;
    options = options || {};
    options.user = true;
    var watcher = new Watcher(vm, expOrFn, cb, options);
    if (options.immediate) {
      cb.call(vm, watcher.value);
    }
    return function unwatchFn () {
      watcher.teardown();
    }
  };
}

function proxy (vm, key) {
  if (!isReserved(key)) {
    Object.defineProperty(vm, key, {
      configurable: true,
      enumerable: true,
      get: function proxyGetter () {
        return vm._data[key]
      },
      set: function proxySetter (val) {
        vm._data[key] = val;
      }
    });
  }
}

/*  */

var uid = 0;

function initMixin (Vue) {
  Vue.prototype._init = function (options) {
    var vm = this;
    // a uid
    vm._uid = uid++;
    // a flag to avoid this being observed
    vm._isVue = true;
    // merge options
    if (options && options._isComponent) {
      // optimize internal component instantiation
      // since dynamic options merging is pretty slow, and none of the
      // internal component options needs special treatment.
      initInternalComponent(vm, options);
    } else {
      vm.$options = mergeOptions(
        resolveConstructorOptions(vm.constructor),
        options || {},
        vm
      );
    }
    /* istanbul ignore else */
    if (process.env.NODE_ENV !== 'production') {
      initProxy(vm);
    } else {
      vm._renderProxy = vm;
    }
    // expose real self
    vm._self = vm;
    initLifecycle(vm);
    initEvents(vm);
    initRender(vm);
    callHook(vm, 'beforeCreate');
    initState(vm);
    callHook(vm, 'created');
    if (vm.$options.el) {
      vm.$mount(vm.$options.el);
    }
  };
}

function initInternalComponent (vm, options) {
  var opts = vm.$options = Object.create(vm.constructor.options);
  // doing this because it's faster than dynamic enumeration.
  opts.parent = options.parent;
  opts.propsData = options.propsData;
  opts._parentVnode = options._parentVnode;
  opts._parentListeners = options._parentListeners;
  opts._renderChildren = options._renderChildren;
  opts._componentTag = options._componentTag;
  opts._parentElm = options._parentElm;
  opts._refElm = options._refElm;
  if (options.render) {
    opts.render = options.render;
    opts.staticRenderFns = options.staticRenderFns;
  }
}

function resolveConstructorOptions (Ctor) {
  var options = Ctor.options;
  if (Ctor.super) {
    var superOptions = Ctor.super.options;
    var cachedSuperOptions = Ctor.superOptions;
    var extendOptions = Ctor.extendOptions;
    if (superOptions !== cachedSuperOptions) {
      // super option changed
      Ctor.superOptions = superOptions;
      extendOptions.render = options.render;
      extendOptions.staticRenderFns = options.staticRenderFns;
      extendOptions._scopeId = options._scopeId;
      options = Ctor.options = mergeOptions(superOptions, extendOptions);
      if (options.name) {
        options.components[options.name] = Ctor;
      }
    }
  }
  return options
}

function Vue$2 (options) {
  if (process.env.NODE_ENV !== 'production' &&
    !(this instanceof Vue$2)) {
    warn('Vue is a constructor and should be called with the `new` keyword');
  }
  this._init(options);
}

initMixin(Vue$2);
stateMixin(Vue$2);
eventsMixin(Vue$2);
lifecycleMixin(Vue$2);
renderMixin(Vue$2);

/*  */

function initUse (Vue) {
  Vue.use = function (plugin) {
    /* istanbul ignore if */
    if (plugin.installed) {
      return
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
    return this
  };
}

/*  */

function initMixin$1 (Vue) {
  Vue.mixin = function (mixin) {
    this.options = mergeOptions(this.options, mixin);
  };
}

/*  */

function initExtend (Vue) {
  /**
   * Each instance constructor, including Vue, has a unique
   * cid. This enables us to create wrapped "child
   * constructors" for prototypal inheritance and cache them.
   */
  Vue.cid = 0;
  var cid = 1;

  /**
   * Class inheritance
   */
  Vue.extend = function (extendOptions) {
    extendOptions = extendOptions || {};
    var Super = this;
    var SuperId = Super.cid;
    var cachedCtors = extendOptions._Ctor || (extendOptions._Ctor = {});
    if (cachedCtors[SuperId]) {
      return cachedCtors[SuperId]
    }
    var name = extendOptions.name || Super.options.name;
    if (process.env.NODE_ENV !== 'production') {
      if (!/^[a-zA-Z][\w-]*$/.test(name)) {
        warn(
          'Invalid component name: "' + name + '". Component names ' +
          'can only contain alphanumeric characters and the hyphen, ' +
          'and must start with a letter.'
        );
      }
    }
    var Sub = function VueComponent (options) {
      this._init(options);
    };
    Sub.prototype = Object.create(Super.prototype);
    Sub.prototype.constructor = Sub;
    Sub.cid = cid++;
    Sub.options = mergeOptions(
      Super.options,
      extendOptions
    );
    Sub['super'] = Super;
    // allow further extension/mixin/plugin usage
    Sub.extend = Super.extend;
    Sub.mixin = Super.mixin;
    Sub.use = Super.use;
    // create asset registers, so extended classes
    // can have their private assets too.
    config._assetTypes.forEach(function (type) {
      Sub[type] = Super[type];
    });
    // enable recursive self-lookup
    if (name) {
      Sub.options.components[name] = Sub;
    }
    // keep a reference to the super options at extension time.
    // later at instantiation we can check if Super's options have
    // been updated.
    Sub.superOptions = Super.options;
    Sub.extendOptions = extendOptions;
    // cache constructor
    cachedCtors[SuperId] = Sub;
    return Sub
  };
}

/*  */

function initAssetRegisters (Vue) {
  /**
   * Create asset registration methods.
   */
  config._assetTypes.forEach(function (type) {
    Vue[type] = function (
      id,
      definition
    ) {
      if (!definition) {
        return this.options[type + 's'][id]
      } else {
        /* istanbul ignore if */
        if (process.env.NODE_ENV !== 'production') {
          if (type === 'component' && config.isReservedTag(id)) {
            warn(
              'Do not use built-in or reserved HTML elements as component ' +
              'id: ' + id
            );
          }
        }
        if (type === 'component' && isPlainObject(definition)) {
          definition.name = definition.name || id;
          definition = this.options._base.extend(definition);
        }
        if (type === 'directive' && typeof definition === 'function') {
          definition = { bind: definition, update: definition };
        }
        this.options[type + 's'][id] = definition;
        return definition
      }
    };
  });
}

/*  */

var patternTypes = [String, RegExp];

function getComponentName (opts) {
  return opts && (opts.Ctor.options.name || opts.tag)
}

function matches (pattern, name) {
  if (typeof pattern === 'string') {
    return pattern.split(',').indexOf(name) > -1
  } else {
    return pattern.test(name)
  }
}

function pruneCache (cache, filter) {
  for (var key in cache) {
    var cachedNode = cache[key];
    if (cachedNode) {
      var name = getComponentName(cachedNode.componentOptions);
      if (name && !filter(name)) {
        pruneCacheEntry(cachedNode);
        cache[key] = null;
      }
    }
  }
}

function pruneCacheEntry (vnode) {
  if (vnode) {
    if (!vnode.componentInstance._inactive) {
      callHook(vnode.componentInstance, 'deactivated');
    }
    vnode.componentInstance.$destroy();
  }
}

var KeepAlive = {
  name: 'keep-alive',
  abstract: true,

  props: {
    include: patternTypes,
    exclude: patternTypes
  },

  created: function created () {
    this.cache = Object.create(null);
  },

  destroyed: function destroyed () {
    var this$1 = this;

    for (var key in this.cache) {
      pruneCacheEntry(this$1.cache[key]);
    }
  },

  watch: {
    include: function include (val) {
      pruneCache(this.cache, function (name) { return matches(val, name); });
    },
    exclude: function exclude (val) {
      pruneCache(this.cache, function (name) { return !matches(val, name); });
    }
  },

  render: function render () {
    var vnode = getFirstComponentChild(this.$slots.default);
    var componentOptions = vnode && vnode.componentOptions;
    if (componentOptions) {
      // check pattern
      var name = getComponentName(componentOptions);
      if (name && (
        (this.include && !matches(this.include, name)) ||
        (this.exclude && matches(this.exclude, name))
      )) {
        return vnode
      }
      var key = vnode.key == null
        // same constructor may get registered as different local components
        // so cid alone is not enough (#3269)
        ? componentOptions.Ctor.cid + (componentOptions.tag ? ("::" + (componentOptions.tag)) : '')
        : vnode.key;
      if (this.cache[key]) {
        vnode.componentInstance = this.cache[key].componentInstance;
      } else {
        this.cache[key] = vnode;
      }
      vnode.data.keepAlive = true;
    }
    return vnode
  }
};

var builtInComponents = {
  KeepAlive: KeepAlive
};

/*  */

function initGlobalAPI (Vue) {
  // config
  var configDef = {};
  configDef.get = function () { return config; };
  if (process.env.NODE_ENV !== 'production') {
    configDef.set = function () {
      warn(
        'Do not replace the Vue.config object, set individual fields instead.'
      );
    };
  }
  Object.defineProperty(Vue, 'config', configDef);
  Vue.util = util;
  Vue.set = set$1;
  Vue.delete = del;
  Vue.nextTick = nextTick;

  Vue.options = Object.create(null);
  config._assetTypes.forEach(function (type) {
    Vue.options[type + 's'] = Object.create(null);
  });

  // this is used to identify the "base" constructor to extend all plain-object
  // components with in Weex's multi-instance scenarios.
  Vue.options._base = Vue;

  extend(Vue.options.components, builtInComponents);

  initUse(Vue);
  initMixin$1(Vue);
  initExtend(Vue);
  initAssetRegisters(Vue);
}

initGlobalAPI(Vue$2);

Object.defineProperty(Vue$2.prototype, '$isServer', {
  get: isServerRendering
});

Vue$2.version = '2.1.10';

/*  */

// attributes that should be using props for binding
var acceptValue = makeMap('input,textarea,option,select');
var mustUseProp = function (tag, type, attr) {
  return (
    (attr === 'value' && acceptValue(tag)) && type !== 'button' ||
    (attr === 'selected' && tag === 'option') ||
    (attr === 'checked' && tag === 'input') ||
    (attr === 'muted' && tag === 'video')
  )
};

var isEnumeratedAttr = makeMap('contenteditable,draggable,spellcheck');

var isBooleanAttr = makeMap(
  'allowfullscreen,async,autofocus,autoplay,checked,compact,controls,declare,' +
  'default,defaultchecked,defaultmuted,defaultselected,defer,disabled,' +
  'enabled,formnovalidate,hidden,indeterminate,inert,ismap,itemscope,loop,multiple,' +
  'muted,nohref,noresize,noshade,novalidate,nowrap,open,pauseonexit,readonly,' +
  'required,reversed,scoped,seamless,selected,sortable,translate,' +
  'truespeed,typemustmatch,visible'
);

var xlinkNS = 'http://www.w3.org/1999/xlink';

var isXlink = function (name) {
  return name.charAt(5) === ':' && name.slice(0, 5) === 'xlink'
};

var getXlinkProp = function (name) {
  return isXlink(name) ? name.slice(6, name.length) : ''
};

var isFalsyAttrValue = function (val) {
  return val == null || val === false
};

/*  */

function genClassForVnode (vnode) {
  var data = vnode.data;
  var parentNode = vnode;
  var childNode = vnode;
  while (childNode.componentInstance) {
    childNode = childNode.componentInstance._vnode;
    if (childNode.data) {
      data = mergeClassData(childNode.data, data);
    }
  }
  while ((parentNode = parentNode.parent)) {
    if (parentNode.data) {
      data = mergeClassData(data, parentNode.data);
    }
  }
  return genClassFromData(data)
}

function mergeClassData (child, parent) {
  return {
    staticClass: concat(child.staticClass, parent.staticClass),
    class: child.class
      ? [child.class, parent.class]
      : parent.class
  }
}

function genClassFromData (data) {
  var dynamicClass = data.class;
  var staticClass = data.staticClass;
  if (staticClass || dynamicClass) {
    return concat(staticClass, stringifyClass(dynamicClass))
  }
  /* istanbul ignore next */
  return ''
}

function concat (a, b) {
  return a ? b ? (a + ' ' + b) : a : (b || '')
}

function stringifyClass (value) {
  var res = '';
  if (!value) {
    return res
  }
  if (typeof value === 'string') {
    return value
  }
  if (Array.isArray(value)) {
    var stringified;
    for (var i = 0, l = value.length; i < l; i++) {
      if (value[i]) {
        if ((stringified = stringifyClass(value[i]))) {
          res += stringified + ' ';
        }
      }
    }
    return res.slice(0, -1)
  }
  if (isObject(value)) {
    for (var key in value) {
      if (value[key]) { res += key + ' '; }
    }
    return res.slice(0, -1)
  }
  /* istanbul ignore next */
  return res
}

/*  */

var namespaceMap = {
  svg: 'http://www.w3.org/2000/svg',
  math: 'http://www.w3.org/1998/Math/MathML'
};

var isHTMLTag = makeMap(
  'html,body,base,head,link,meta,style,title,' +
  'address,article,aside,footer,header,h1,h2,h3,h4,h5,h6,hgroup,nav,section,' +
  'div,dd,dl,dt,figcaption,figure,hr,img,li,main,ol,p,pre,ul,' +
  'a,b,abbr,bdi,bdo,br,cite,code,data,dfn,em,i,kbd,mark,q,rp,rt,rtc,ruby,' +
  's,samp,small,span,strong,sub,sup,time,u,var,wbr,area,audio,map,track,video,' +
  'embed,object,param,source,canvas,script,noscript,del,ins,' +
  'caption,col,colgroup,table,thead,tbody,td,th,tr,' +
  'button,datalist,fieldset,form,input,label,legend,meter,optgroup,option,' +
  'output,progress,select,textarea,' +
  'details,dialog,menu,menuitem,summary,' +
  'content,element,shadow,template'
);

// this map is intentionally selective, only covering SVG elements that may
// contain child elements.
var isSVG = makeMap(
  'svg,animate,circle,clippath,cursor,defs,desc,ellipse,filter,' +
  'font-face,g,glyph,image,line,marker,mask,missing-glyph,path,pattern,' +
  'polygon,polyline,rect,switch,symbol,text,textpath,tspan,use,view',
  true
);



var isReservedTag = function (tag) {
  return isHTMLTag(tag) || isSVG(tag)
};

function getTagNamespace (tag) {
  if (isSVG(tag)) {
    return 'svg'
  }
  // basic support for MathML
  // note it doesn't support other MathML elements being component roots
  if (tag === 'math') {
    return 'math'
  }
}

var unknownElementCache = Object.create(null);
function isUnknownElement (tag) {
  /* istanbul ignore if */
  if (!inBrowser) {
    return true
  }
  if (isReservedTag(tag)) {
    return false
  }
  tag = tag.toLowerCase();
  /* istanbul ignore if */
  if (unknownElementCache[tag] != null) {
    return unknownElementCache[tag]
  }
  var el = document.createElement(tag);
  if (tag.indexOf('-') > -1) {
    // http://stackoverflow.com/a/28210364/1070244
    return (unknownElementCache[tag] = (
      el.constructor === window.HTMLUnknownElement ||
      el.constructor === window.HTMLElement
    ))
  } else {
    return (unknownElementCache[tag] = /HTMLUnknownElement/.test(el.toString()))
  }
}

/*  */

/**
 * Query an element selector if it's not an element already.
 */
function query (el) {
  if (typeof el === 'string') {
    var selector = el;
    el = document.querySelector(el);
    if (!el) {
      process.env.NODE_ENV !== 'production' && warn(
        'Cannot find element: ' + selector
      );
      return document.createElement('div')
    }
  }
  return el
}

/*  */

function createElement$1 (tagName, vnode) {
  var elm = document.createElement(tagName);
  if (tagName !== 'select') {
    return elm
  }
  if (vnode.data && vnode.data.attrs && 'multiple' in vnode.data.attrs) {
    elm.setAttribute('multiple', 'multiple');
  }
  return elm
}

function createElementNS (namespace, tagName) {
  return document.createElementNS(namespaceMap[namespace], tagName)
}

function createTextNode (text) {
  return document.createTextNode(text)
}

function createComment (text) {
  return document.createComment(text)
}

function insertBefore (parentNode, newNode, referenceNode) {
  parentNode.insertBefore(newNode, referenceNode);
}

function removeChild (node, child) {
  node.removeChild(child);
}

function appendChild (node, child) {
  node.appendChild(child);
}

function parentNode (node) {
  return node.parentNode
}

function nextSibling (node) {
  return node.nextSibling
}

function tagName (node) {
  return node.tagName
}

function setTextContent (node, text) {
  node.textContent = text;
}

function setAttribute (node, key, val) {
  node.setAttribute(key, val);
}


var nodeOps = Object.freeze({
	createElement: createElement$1,
	createElementNS: createElementNS,
	createTextNode: createTextNode,
	createComment: createComment,
	insertBefore: insertBefore,
	removeChild: removeChild,
	appendChild: appendChild,
	parentNode: parentNode,
	nextSibling: nextSibling,
	tagName: tagName,
	setTextContent: setTextContent,
	setAttribute: setAttribute
});

/*  */

var ref = {
  create: function create (_, vnode) {
    registerRef(vnode);
  },
  update: function update (oldVnode, vnode) {
    if (oldVnode.data.ref !== vnode.data.ref) {
      registerRef(oldVnode, true);
      registerRef(vnode);
    }
  },
  destroy: function destroy (vnode) {
    registerRef(vnode, true);
  }
};

function registerRef (vnode, isRemoval) {
  var key = vnode.data.ref;
  if (!key) { return }

  var vm = vnode.context;
  var ref = vnode.componentInstance || vnode.elm;
  var refs = vm.$refs;
  if (isRemoval) {
    if (Array.isArray(refs[key])) {
      remove$1(refs[key], ref);
    } else if (refs[key] === ref) {
      refs[key] = undefined;
    }
  } else {
    if (vnode.data.refInFor) {
      if (Array.isArray(refs[key]) && refs[key].indexOf(ref) < 0) {
        refs[key].push(ref);
      } else {
        refs[key] = [ref];
      }
    } else {
      refs[key] = ref;
    }
  }
}

/**
 * Virtual DOM patching algorithm based on Snabbdom by
 * Simon Friis Vindum (@paldepind)
 * Licensed under the MIT License
 * https://github.com/paldepind/snabbdom/blob/master/LICENSE
 *
 * modified by Evan You (@yyx990803)
 *

/*
 * Not type-checking this because this file is perf-critical and the cost
 * of making flow understand it is not worth it.
 */

var emptyNode = new VNode('', {}, []);

var hooks$1 = ['create', 'activate', 'update', 'remove', 'destroy'];

function isUndef (s) {
  return s == null
}

function isDef (s) {
  return s != null
}

function sameVnode (vnode1, vnode2) {
  return (
    vnode1.key === vnode2.key &&
    vnode1.tag === vnode2.tag &&
    vnode1.isComment === vnode2.isComment &&
    !vnode1.data === !vnode2.data
  )
}

function createKeyToOldIdx (children, beginIdx, endIdx) {
  var i, key;
  var map = {};
  for (i = beginIdx; i <= endIdx; ++i) {
    key = children[i].key;
    if (isDef(key)) { map[key] = i; }
  }
  return map
}

function createPatchFunction (backend) {
  var i, j;
  var cbs = {};

  var modules = backend.modules;
  var nodeOps = backend.nodeOps;

  for (i = 0; i < hooks$1.length; ++i) {
    cbs[hooks$1[i]] = [];
    for (j = 0; j < modules.length; ++j) {
      if (modules[j][hooks$1[i]] !== undefined) { cbs[hooks$1[i]].push(modules[j][hooks$1[i]]); }
    }
  }

  function emptyNodeAt (elm) {
    return new VNode(nodeOps.tagName(elm).toLowerCase(), {}, [], undefined, elm)
  }

  function createRmCb (childElm, listeners) {
    function remove$$1 () {
      if (--remove$$1.listeners === 0) {
        removeNode(childElm);
      }
    }
    remove$$1.listeners = listeners;
    return remove$$1
  }

  function removeNode (el) {
    var parent = nodeOps.parentNode(el);
    // element may have already been removed due to v-html / v-text
    if (parent) {
      nodeOps.removeChild(parent, el);
    }
  }

  var inPre = 0;
  function createElm (vnode, insertedVnodeQueue, parentElm, refElm, nested) {
    vnode.isRootInsert = !nested; // for transition enter check
    if (createComponent(vnode, insertedVnodeQueue, parentElm, refElm)) {
      return
    }

    var data = vnode.data;
    var children = vnode.children;
    var tag = vnode.tag;
    if (isDef(tag)) {
      if (process.env.NODE_ENV !== 'production') {
        if (data && data.pre) {
          inPre++;
        }
        if (
          !inPre &&
          !vnode.ns &&
          !(config.ignoredElements.length && config.ignoredElements.indexOf(tag) > -1) &&
          config.isUnknownElement(tag)
        ) {
          warn(
            'Unknown custom element: <' + tag + '> - did you ' +
            'register the component correctly? For recursive components, ' +
            'make sure to provide the "name" option.',
            vnode.context
          );
        }
      }
      vnode.elm = vnode.ns
        ? nodeOps.createElementNS(vnode.ns, tag)
        : nodeOps.createElement(tag, vnode);
      setScope(vnode);

      /* istanbul ignore if */
      {
        createChildren(vnode, children, insertedVnodeQueue);
        if (isDef(data)) {
          invokeCreateHooks(vnode, insertedVnodeQueue);
        }
        insert(parentElm, vnode.elm, refElm);
      }

      if (process.env.NODE_ENV !== 'production' && data && data.pre) {
        inPre--;
      }
    } else if (vnode.isComment) {
      vnode.elm = nodeOps.createComment(vnode.text);
      insert(parentElm, vnode.elm, refElm);
    } else {
      vnode.elm = nodeOps.createTextNode(vnode.text);
      insert(parentElm, vnode.elm, refElm);
    }
  }

  function createComponent (vnode, insertedVnodeQueue, parentElm, refElm) {
    var i = vnode.data;
    if (isDef(i)) {
      var isReactivated = isDef(vnode.componentInstance) && i.keepAlive;
      if (isDef(i = i.hook) && isDef(i = i.init)) {
        i(vnode, false /* hydrating */, parentElm, refElm);
      }
      // after calling the init hook, if the vnode is a child component
      // it should've created a child instance and mounted it. the child
      // component also has set the placeholder vnode's elm.
      // in that case we can just return the element and be done.
      if (isDef(vnode.componentInstance)) {
        initComponent(vnode, insertedVnodeQueue);
        if (isReactivated) {
          reactivateComponent(vnode, insertedVnodeQueue, parentElm, refElm);
        }
        return true
      }
    }
  }

  function initComponent (vnode, insertedVnodeQueue) {
    if (vnode.data.pendingInsert) {
      insertedVnodeQueue.push.apply(insertedVnodeQueue, vnode.data.pendingInsert);
    }
    vnode.elm = vnode.componentInstance.$el;
    if (isPatchable(vnode)) {
      invokeCreateHooks(vnode, insertedVnodeQueue);
      setScope(vnode);
    } else {
      // empty component root.
      // skip all element-related modules except for ref (#3455)
      registerRef(vnode);
      // make sure to invoke the insert hook
      insertedVnodeQueue.push(vnode);
    }
  }

  function reactivateComponent (vnode, insertedVnodeQueue, parentElm, refElm) {
    var i;
    // hack for #4339: a reactivated component with inner transition
    // does not trigger because the inner node's created hooks are not called
    // again. It's not ideal to involve module-specific logic in here but
    // there doesn't seem to be a better way to do it.
    var innerNode = vnode;
    while (innerNode.componentInstance) {
      innerNode = innerNode.componentInstance._vnode;
      if (isDef(i = innerNode.data) && isDef(i = i.transition)) {
        for (i = 0; i < cbs.activate.length; ++i) {
          cbs.activate[i](emptyNode, innerNode);
        }
        insertedVnodeQueue.push(innerNode);
        break
      }
    }
    // unlike a newly created component,
    // a reactivated keep-alive component doesn't insert itself
    insert(parentElm, vnode.elm, refElm);
  }

  function insert (parent, elm, ref) {
    if (parent) {
      if (ref) {
        nodeOps.insertBefore(parent, elm, ref);
      } else {
        nodeOps.appendChild(parent, elm);
      }
    }
  }

  function createChildren (vnode, children, insertedVnodeQueue) {
    if (Array.isArray(children)) {
      for (var i = 0; i < children.length; ++i) {
        createElm(children[i], insertedVnodeQueue, vnode.elm, null, true);
      }
    } else if (isPrimitive(vnode.text)) {
      nodeOps.appendChild(vnode.elm, nodeOps.createTextNode(vnode.text));
    }
  }

  function isPatchable (vnode) {
    while (vnode.componentInstance) {
      vnode = vnode.componentInstance._vnode;
    }
    return isDef(vnode.tag)
  }

  function invokeCreateHooks (vnode, insertedVnodeQueue) {
    for (var i$1 = 0; i$1 < cbs.create.length; ++i$1) {
      cbs.create[i$1](emptyNode, vnode);
    }
    i = vnode.data.hook; // Reuse variable
    if (isDef(i)) {
      if (i.create) { i.create(emptyNode, vnode); }
      if (i.insert) { insertedVnodeQueue.push(vnode); }
    }
  }

  // set scope id attribute for scoped CSS.
  // this is implemented as a special case to avoid the overhead
  // of going through the normal attribute patching process.
  function setScope (vnode) {
    var i;
    if (isDef(i = vnode.context) && isDef(i = i.$options._scopeId)) {
      nodeOps.setAttribute(vnode.elm, i, '');
    }
    if (isDef(i = activeInstance) &&
        i !== vnode.context &&
        isDef(i = i.$options._scopeId)) {
      nodeOps.setAttribute(vnode.elm, i, '');
    }
  }

  function addVnodes (parentElm, refElm, vnodes, startIdx, endIdx, insertedVnodeQueue) {
    for (; startIdx <= endIdx; ++startIdx) {
      createElm(vnodes[startIdx], insertedVnodeQueue, parentElm, refElm);
    }
  }

  function invokeDestroyHook (vnode) {
    var i, j;
    var data = vnode.data;
    if (isDef(data)) {
      if (isDef(i = data.hook) && isDef(i = i.destroy)) { i(vnode); }
      for (i = 0; i < cbs.destroy.length; ++i) { cbs.destroy[i](vnode); }
    }
    if (isDef(i = vnode.children)) {
      for (j = 0; j < vnode.children.length; ++j) {
        invokeDestroyHook(vnode.children[j]);
      }
    }
  }

  function removeVnodes (parentElm, vnodes, startIdx, endIdx) {
    for (; startIdx <= endIdx; ++startIdx) {
      var ch = vnodes[startIdx];
      if (isDef(ch)) {
        if (isDef(ch.tag)) {
          removeAndInvokeRemoveHook(ch);
          invokeDestroyHook(ch);
        } else { // Text node
          removeNode(ch.elm);
        }
      }
    }
  }

  function removeAndInvokeRemoveHook (vnode, rm) {
    if (rm || isDef(vnode.data)) {
      var listeners = cbs.remove.length + 1;
      if (!rm) {
        // directly removing
        rm = createRmCb(vnode.elm, listeners);
      } else {
        // we have a recursively passed down rm callback
        // increase the listeners count
        rm.listeners += listeners;
      }
      // recursively invoke hooks on child component root node
      if (isDef(i = vnode.componentInstance) && isDef(i = i._vnode) && isDef(i.data)) {
        removeAndInvokeRemoveHook(i, rm);
      }
      for (i = 0; i < cbs.remove.length; ++i) {
        cbs.remove[i](vnode, rm);
      }
      if (isDef(i = vnode.data.hook) && isDef(i = i.remove)) {
        i(vnode, rm);
      } else {
        rm();
      }
    } else {
      removeNode(vnode.elm);
    }
  }

  function updateChildren (parentElm, oldCh, newCh, insertedVnodeQueue, removeOnly) {
    var oldStartIdx = 0;
    var newStartIdx = 0;
    var oldEndIdx = oldCh.length - 1;
    var oldStartVnode = oldCh[0];
    var oldEndVnode = oldCh[oldEndIdx];
    var newEndIdx = newCh.length - 1;
    var newStartVnode = newCh[0];
    var newEndVnode = newCh[newEndIdx];
    var oldKeyToIdx, idxInOld, elmToMove, refElm;

    // removeOnly is a special flag used only by <transition-group>
    // to ensure removed elements stay in correct relative positions
    // during leaving transitions
    var canMove = !removeOnly;

    while (oldStartIdx <= oldEndIdx && newStartIdx <= newEndIdx) {
      if (isUndef(oldStartVnode)) {
        oldStartVnode = oldCh[++oldStartIdx]; // Vnode has been moved left
      } else if (isUndef(oldEndVnode)) {
        oldEndVnode = oldCh[--oldEndIdx];
      } else if (sameVnode(oldStartVnode, newStartVnode)) {
        patchVnode(oldStartVnode, newStartVnode, insertedVnodeQueue);
        oldStartVnode = oldCh[++oldStartIdx];
        newStartVnode = newCh[++newStartIdx];
      } else if (sameVnode(oldEndVnode, newEndVnode)) {
        patchVnode(oldEndVnode, newEndVnode, insertedVnodeQueue);
        oldEndVnode = oldCh[--oldEndIdx];
        newEndVnode = newCh[--newEndIdx];
      } else if (sameVnode(oldStartVnode, newEndVnode)) { // Vnode moved right
        patchVnode(oldStartVnode, newEndVnode, insertedVnodeQueue);
        canMove && nodeOps.insertBefore(parentElm, oldStartVnode.elm, nodeOps.nextSibling(oldEndVnode.elm));
        oldStartVnode = oldCh[++oldStartIdx];
        newEndVnode = newCh[--newEndIdx];
      } else if (sameVnode(oldEndVnode, newStartVnode)) { // Vnode moved left
        patchVnode(oldEndVnode, newStartVnode, insertedVnodeQueue);
        canMove && nodeOps.insertBefore(parentElm, oldEndVnode.elm, oldStartVnode.elm);
        oldEndVnode = oldCh[--oldEndIdx];
        newStartVnode = newCh[++newStartIdx];
      } else {
        if (isUndef(oldKeyToIdx)) { oldKeyToIdx = createKeyToOldIdx(oldCh, oldStartIdx, oldEndIdx); }
        idxInOld = isDef(newStartVnode.key) ? oldKeyToIdx[newStartVnode.key] : null;
        if (isUndef(idxInOld)) { // New element
          createElm(newStartVnode, insertedVnodeQueue, parentElm, oldStartVnode.elm);
          newStartVnode = newCh[++newStartIdx];
        } else {
          elmToMove = oldCh[idxInOld];
          /* istanbul ignore if */
          if (process.env.NODE_ENV !== 'production' && !elmToMove) {
            warn(
              'It seems there are duplicate keys that is causing an update error. ' +
              'Make sure each v-for item has a unique key.'
            );
          }
          if (sameVnode(elmToMove, newStartVnode)) {
            patchVnode(elmToMove, newStartVnode, insertedVnodeQueue);
            oldCh[idxInOld] = undefined;
            canMove && nodeOps.insertBefore(parentElm, newStartVnode.elm, oldStartVnode.elm);
            newStartVnode = newCh[++newStartIdx];
          } else {
            // same key but different element. treat as new element
            createElm(newStartVnode, insertedVnodeQueue, parentElm, oldStartVnode.elm);
            newStartVnode = newCh[++newStartIdx];
          }
        }
      }
    }
    if (oldStartIdx > oldEndIdx) {
      refElm = isUndef(newCh[newEndIdx + 1]) ? null : newCh[newEndIdx + 1].elm;
      addVnodes(parentElm, refElm, newCh, newStartIdx, newEndIdx, insertedVnodeQueue);
    } else if (newStartIdx > newEndIdx) {
      removeVnodes(parentElm, oldCh, oldStartIdx, oldEndIdx);
    }
  }

  function patchVnode (oldVnode, vnode, insertedVnodeQueue, removeOnly) {
    if (oldVnode === vnode) {
      return
    }
    // reuse element for static trees.
    // note we only do this if the vnode is cloned -
    // if the new node is not cloned it means the render functions have been
    // reset by the hot-reload-api and we need to do a proper re-render.
    if (vnode.isStatic &&
        oldVnode.isStatic &&
        vnode.key === oldVnode.key &&
        (vnode.isCloned || vnode.isOnce)) {
      vnode.elm = oldVnode.elm;
      vnode.componentInstance = oldVnode.componentInstance;
      return
    }
    var i;
    var data = vnode.data;
    var hasData = isDef(data);
    if (hasData && isDef(i = data.hook) && isDef(i = i.prepatch)) {
      i(oldVnode, vnode);
    }
    var elm = vnode.elm = oldVnode.elm;
    var oldCh = oldVnode.children;
    var ch = vnode.children;
    if (hasData && isPatchable(vnode)) {
      for (i = 0; i < cbs.update.length; ++i) { cbs.update[i](oldVnode, vnode); }
      if (isDef(i = data.hook) && isDef(i = i.update)) { i(oldVnode, vnode); }
    }
    if (isUndef(vnode.text)) {
      if (isDef(oldCh) && isDef(ch)) {
        if (oldCh !== ch) { updateChildren(elm, oldCh, ch, insertedVnodeQueue, removeOnly); }
      } else if (isDef(ch)) {
        if (isDef(oldVnode.text)) { nodeOps.setTextContent(elm, ''); }
        addVnodes(elm, null, ch, 0, ch.length - 1, insertedVnodeQueue);
      } else if (isDef(oldCh)) {
        removeVnodes(elm, oldCh, 0, oldCh.length - 1);
      } else if (isDef(oldVnode.text)) {
        nodeOps.setTextContent(elm, '');
      }
    } else if (oldVnode.text !== vnode.text) {
      nodeOps.setTextContent(elm, vnode.text);
    }
    if (hasData) {
      if (isDef(i = data.hook) && isDef(i = i.postpatch)) { i(oldVnode, vnode); }
    }
  }

  function invokeInsertHook (vnode, queue, initial) {
    // delay insert hooks for component root nodes, invoke them after the
    // element is really inserted
    if (initial && vnode.parent) {
      vnode.parent.data.pendingInsert = queue;
    } else {
      for (var i = 0; i < queue.length; ++i) {
        queue[i].data.hook.insert(queue[i]);
      }
    }
  }

  var bailed = false;
  // list of modules that can skip create hook during hydration because they
  // are already rendered on the client or has no need for initialization
  var isRenderedModule = makeMap('attrs,style,class,staticClass,staticStyle,key');

  // Note: this is a browser-only function so we can assume elms are DOM nodes.
  function hydrate (elm, vnode, insertedVnodeQueue) {
    if (process.env.NODE_ENV !== 'production') {
      if (!assertNodeMatch(elm, vnode)) {
        return false
      }
    }
    vnode.elm = elm;
    var tag = vnode.tag;
    var data = vnode.data;
    var children = vnode.children;
    if (isDef(data)) {
      if (isDef(i = data.hook) && isDef(i = i.init)) { i(vnode, true /* hydrating */); }
      if (isDef(i = vnode.componentInstance)) {
        // child component. it should have hydrated its own tree.
        initComponent(vnode, insertedVnodeQueue);
        return true
      }
    }
    if (isDef(tag)) {
      if (isDef(children)) {
        // empty element, allow client to pick up and populate children
        if (!elm.hasChildNodes()) {
          createChildren(vnode, children, insertedVnodeQueue);
        } else {
          var childrenMatch = true;
          var childNode = elm.firstChild;
          for (var i$1 = 0; i$1 < children.length; i$1++) {
            if (!childNode || !hydrate(childNode, children[i$1], insertedVnodeQueue)) {
              childrenMatch = false;
              break
            }
            childNode = childNode.nextSibling;
          }
          // if childNode is not null, it means the actual childNodes list is
          // longer than the virtual children list.
          if (!childrenMatch || childNode) {
            if (process.env.NODE_ENV !== 'production' &&
                typeof console !== 'undefined' &&
                !bailed) {
              bailed = true;
              console.warn('Parent: ', elm);
              console.warn('Mismatching childNodes vs. VNodes: ', elm.childNodes, children);
            }
            return false
          }
        }
      }
      if (isDef(data)) {
        for (var key in data) {
          if (!isRenderedModule(key)) {
            invokeCreateHooks(vnode, insertedVnodeQueue);
            break
          }
        }
      }
    } else if (elm.data !== vnode.text) {
      elm.data = vnode.text;
    }
    return true
  }

  function assertNodeMatch (node, vnode) {
    if (vnode.tag) {
      return (
        vnode.tag.indexOf('vue-component') === 0 ||
        vnode.tag.toLowerCase() === (node.tagName && node.tagName.toLowerCase())
      )
    } else {
      return node.nodeType === (vnode.isComment ? 8 : 3)
    }
  }

  return function patch (oldVnode, vnode, hydrating, removeOnly, parentElm, refElm) {
    if (!vnode) {
      if (oldVnode) { invokeDestroyHook(oldVnode); }
      return
    }

    var isInitialPatch = false;
    var insertedVnodeQueue = [];

    if (!oldVnode) {
      // empty mount (likely as component), create new root element
      isInitialPatch = true;
      createElm(vnode, insertedVnodeQueue, parentElm, refElm);
    } else {
      var isRealElement = isDef(oldVnode.nodeType);
      if (!isRealElement && sameVnode(oldVnode, vnode)) {
        // patch existing root node
        patchVnode(oldVnode, vnode, insertedVnodeQueue, removeOnly);
      } else {
        if (isRealElement) {
          // mounting to a real element
          // check if this is server-rendered content and if we can perform
          // a successful hydration.
          if (oldVnode.nodeType === 1 && oldVnode.hasAttribute('server-rendered')) {
            oldVnode.removeAttribute('server-rendered');
            hydrating = true;
          }
          if (hydrating) {
            if (hydrate(oldVnode, vnode, insertedVnodeQueue)) {
              invokeInsertHook(vnode, insertedVnodeQueue, true);
              return oldVnode
            } else if (process.env.NODE_ENV !== 'production') {
              warn(
                'The client-side rendered virtual DOM tree is not matching ' +
                'server-rendered content. This is likely caused by incorrect ' +
                'HTML markup, for example nesting block-level elements inside ' +
                '<p>, or missing <tbody>. Bailing hydration and performing ' +
                'full client-side render.'
              );
            }
          }
          // either not server-rendered, or hydration failed.
          // create an empty node and replace it
          oldVnode = emptyNodeAt(oldVnode);
        }
        // replacing existing element
        var oldElm = oldVnode.elm;
        var parentElm$1 = nodeOps.parentNode(oldElm);
        createElm(
          vnode,
          insertedVnodeQueue,
          // extremely rare edge case: do not insert if old element is in a
          // leaving transition. Only happens when combining transition +
          // keep-alive + HOCs. (#4590)
          oldElm._leaveCb ? null : parentElm$1,
          nodeOps.nextSibling(oldElm)
        );

        if (vnode.parent) {
          // component root element replaced.
          // update parent placeholder node element, recursively
          var ancestor = vnode.parent;
          while (ancestor) {
            ancestor.elm = vnode.elm;
            ancestor = ancestor.parent;
          }
          if (isPatchable(vnode)) {
            for (var i = 0; i < cbs.create.length; ++i) {
              cbs.create[i](emptyNode, vnode.parent);
            }
          }
        }

        if (parentElm$1 !== null) {
          removeVnodes(parentElm$1, [oldVnode], 0, 0);
        } else if (isDef(oldVnode.tag)) {
          invokeDestroyHook(oldVnode);
        }
      }
    }

    invokeInsertHook(vnode, insertedVnodeQueue, isInitialPatch);
    return vnode.elm
  }
}

/*  */

var directives = {
  create: updateDirectives,
  update: updateDirectives,
  destroy: function unbindDirectives (vnode) {
    updateDirectives(vnode, emptyNode);
  }
};

function updateDirectives (oldVnode, vnode) {
  if (oldVnode.data.directives || vnode.data.directives) {
    _update(oldVnode, vnode);
  }
}

function _update (oldVnode, vnode) {
  var isCreate = oldVnode === emptyNode;
  var isDestroy = vnode === emptyNode;
  var oldDirs = normalizeDirectives$1(oldVnode.data.directives, oldVnode.context);
  var newDirs = normalizeDirectives$1(vnode.data.directives, vnode.context);

  var dirsWithInsert = [];
  var dirsWithPostpatch = [];

  var key, oldDir, dir;
  for (key in newDirs) {
    oldDir = oldDirs[key];
    dir = newDirs[key];
    if (!oldDir) {
      // new directive, bind
      callHook$1(dir, 'bind', vnode, oldVnode);
      if (dir.def && dir.def.inserted) {
        dirsWithInsert.push(dir);
      }
    } else {
      // existing directive, update
      dir.oldValue = oldDir.value;
      callHook$1(dir, 'update', vnode, oldVnode);
      if (dir.def && dir.def.componentUpdated) {
        dirsWithPostpatch.push(dir);
      }
    }
  }

  if (dirsWithInsert.length) {
    var callInsert = function () {
      for (var i = 0; i < dirsWithInsert.length; i++) {
        callHook$1(dirsWithInsert[i], 'inserted', vnode, oldVnode);
      }
    };
    if (isCreate) {
      mergeVNodeHook(vnode.data.hook || (vnode.data.hook = {}), 'insert', callInsert, 'dir-insert');
    } else {
      callInsert();
    }
  }

  if (dirsWithPostpatch.length) {
    mergeVNodeHook(vnode.data.hook || (vnode.data.hook = {}), 'postpatch', function () {
      for (var i = 0; i < dirsWithPostpatch.length; i++) {
        callHook$1(dirsWithPostpatch[i], 'componentUpdated', vnode, oldVnode);
      }
    }, 'dir-postpatch');
  }

  if (!isCreate) {
    for (key in oldDirs) {
      if (!newDirs[key]) {
        // no longer present, unbind
        callHook$1(oldDirs[key], 'unbind', oldVnode, oldVnode, isDestroy);
      }
    }
  }
}

var emptyModifiers = Object.create(null);

function normalizeDirectives$1 (
  dirs,
  vm
) {
  var res = Object.create(null);
  if (!dirs) {
    return res
  }
  var i, dir;
  for (i = 0; i < dirs.length; i++) {
    dir = dirs[i];
    if (!dir.modifiers) {
      dir.modifiers = emptyModifiers;
    }
    res[getRawDirName(dir)] = dir;
    dir.def = resolveAsset(vm.$options, 'directives', dir.name, true);
  }
  return res
}

function getRawDirName (dir) {
  return dir.rawName || ((dir.name) + "." + (Object.keys(dir.modifiers || {}).join('.')))
}

function callHook$1 (dir, hook, vnode, oldVnode, isDestroy) {
  var fn = dir.def && dir.def[hook];
  if (fn) {
    fn(vnode.elm, dir, vnode, oldVnode, isDestroy);
  }
}

var baseModules = [
  ref,
  directives
];

/*  */

function updateAttrs (oldVnode, vnode) {
  if (!oldVnode.data.attrs && !vnode.data.attrs) {
    return
  }
  var key, cur, old;
  var elm = vnode.elm;
  var oldAttrs = oldVnode.data.attrs || {};
  var attrs = vnode.data.attrs || {};
  // clone observed objects, as the user probably wants to mutate it
  if (attrs.__ob__) {
    attrs = vnode.data.attrs = extend({}, attrs);
  }

  for (key in attrs) {
    cur = attrs[key];
    old = oldAttrs[key];
    if (old !== cur) {
      setAttr(elm, key, cur);
    }
  }
  // #4391: in IE9, setting type can reset value for input[type=radio]
  /* istanbul ignore if */
  if (isIE9 && attrs.value !== oldAttrs.value) {
    setAttr(elm, 'value', attrs.value);
  }
  for (key in oldAttrs) {
    if (attrs[key] == null) {
      if (isXlink(key)) {
        elm.removeAttributeNS(xlinkNS, getXlinkProp(key));
      } else if (!isEnumeratedAttr(key)) {
        elm.removeAttribute(key);
      }
    }
  }
}

function setAttr (el, key, value) {
  if (isBooleanAttr(key)) {
    // set attribute for blank value
    // e.g. <option disabled>Select one</option>
    if (isFalsyAttrValue(value)) {
      el.removeAttribute(key);
    } else {
      el.setAttribute(key, key);
    }
  } else if (isEnumeratedAttr(key)) {
    el.setAttribute(key, isFalsyAttrValue(value) || value === 'false' ? 'false' : 'true');
  } else if (isXlink(key)) {
    if (isFalsyAttrValue(value)) {
      el.removeAttributeNS(xlinkNS, getXlinkProp(key));
    } else {
      el.setAttributeNS(xlinkNS, key, value);
    }
  } else {
    if (isFalsyAttrValue(value)) {
      el.removeAttribute(key);
    } else {
      el.setAttribute(key, value);
    }
  }
}

var attrs = {
  create: updateAttrs,
  update: updateAttrs
};

/*  */

function updateClass (oldVnode, vnode) {
  var el = vnode.elm;
  var data = vnode.data;
  var oldData = oldVnode.data;
  if (!data.staticClass && !data.class &&
      (!oldData || (!oldData.staticClass && !oldData.class))) {
    return
  }

  var cls = genClassForVnode(vnode);

  // handle transition classes
  var transitionClass = el._transitionClasses;
  if (transitionClass) {
    cls = concat(cls, stringifyClass(transitionClass));
  }

  // set the class
  if (cls !== el._prevClass) {
    el.setAttribute('class', cls);
    el._prevClass = cls;
  }
}

var klass = {
  create: updateClass,
  update: updateClass
};

/*  */

var target$1;

function add$2 (
  event,
  handler,
  once,
  capture
) {
  if (once) {
    var oldHandler = handler;
    var _target = target$1; // save current target element in closure
    handler = function (ev) {
      remove$3(event, handler, capture, _target);
      arguments.length === 1
        ? oldHandler(ev)
        : oldHandler.apply(null, arguments);
    };
  }
  target$1.addEventListener(event, handler, capture);
}

function remove$3 (
  event,
  handler,
  capture,
  _target
) {
  (_target || target$1).removeEventListener(event, handler, capture);
}

function updateDOMListeners (oldVnode, vnode) {
  if (!oldVnode.data.on && !vnode.data.on) {
    return
  }
  var on = vnode.data.on || {};
  var oldOn = oldVnode.data.on || {};
  target$1 = vnode.elm;
  updateListeners(on, oldOn, add$2, remove$3, vnode.context);
}

var events = {
  create: updateDOMListeners,
  update: updateDOMListeners
};

/*  */

function updateDOMProps (oldVnode, vnode) {
  if (!oldVnode.data.domProps && !vnode.data.domProps) {
    return
  }
  var key, cur;
  var elm = vnode.elm;
  var oldProps = oldVnode.data.domProps || {};
  var props = vnode.data.domProps || {};
  // clone observed objects, as the user probably wants to mutate it
  if (props.__ob__) {
    props = vnode.data.domProps = extend({}, props);
  }

  for (key in oldProps) {
    if (props[key] == null) {
      elm[key] = '';
    }
  }
  for (key in props) {
    cur = props[key];
    // ignore children if the node has textContent or innerHTML,
    // as these will throw away existing DOM nodes and cause removal errors
    // on subsequent patches (#3360)
    if (key === 'textContent' || key === 'innerHTML') {
      if (vnode.children) { vnode.children.length = 0; }
      if (cur === oldProps[key]) { continue }
    }

    if (key === 'value') {
      // store value as _value as well since
      // non-string values will be stringified
      elm._value = cur;
      // avoid resetting cursor position when value is the same
      var strCur = cur == null ? '' : String(cur);
      if (shouldUpdateValue(elm, vnode, strCur)) {
        elm.value = strCur;
      }
    } else {
      elm[key] = cur;
    }
  }
}

// check platforms/web/util/attrs.js acceptValue


function shouldUpdateValue (
  elm,
  vnode,
  checkVal
) {
  return (!elm.composing && (
    vnode.tag === 'option' ||
    isDirty(elm, checkVal) ||
    isInputChanged(vnode, checkVal)
  ))
}

function isDirty (elm, checkVal) {
  // return true when textbox (.number and .trim) loses focus and its value is not equal to the updated value
  return document.activeElement !== elm && elm.value !== checkVal
}

function isInputChanged (vnode, newVal) {
  var value = vnode.elm.value;
  var modifiers = vnode.elm._vModifiers; // injected by v-model runtime
  if ((modifiers && modifiers.number) || vnode.elm.type === 'number') {
    return toNumber(value) !== toNumber(newVal)
  }
  if (modifiers && modifiers.trim) {
    return value.trim() !== newVal.trim()
  }
  return value !== newVal
}

var domProps = {
  create: updateDOMProps,
  update: updateDOMProps
};

/*  */

var parseStyleText = cached(function (cssText) {
  var res = {};
  var listDelimiter = /;(?![^(]*\))/g;
  var propertyDelimiter = /:(.+)/;
  cssText.split(listDelimiter).forEach(function (item) {
    if (item) {
      var tmp = item.split(propertyDelimiter);
      tmp.length > 1 && (res[tmp[0].trim()] = tmp[1].trim());
    }
  });
  return res
});

// merge static and dynamic style data on the same vnode
function normalizeStyleData (data) {
  var style = normalizeStyleBinding(data.style);
  // static style is pre-processed into an object during compilation
  // and is always a fresh object, so it's safe to merge into it
  return data.staticStyle
    ? extend(data.staticStyle, style)
    : style
}

// normalize possible array / string values into Object
function normalizeStyleBinding (bindingStyle) {
  if (Array.isArray(bindingStyle)) {
    return toObject(bindingStyle)
  }
  if (typeof bindingStyle === 'string') {
    return parseStyleText(bindingStyle)
  }
  return bindingStyle
}

/**
 * parent component style should be after child's
 * so that parent component's style could override it
 */
function getStyle (vnode, checkChild) {
  var res = {};
  var styleData;

  if (checkChild) {
    var childNode = vnode;
    while (childNode.componentInstance) {
      childNode = childNode.componentInstance._vnode;
      if (childNode.data && (styleData = normalizeStyleData(childNode.data))) {
        extend(res, styleData);
      }
    }
  }

  if ((styleData = normalizeStyleData(vnode.data))) {
    extend(res, styleData);
  }

  var parentNode = vnode;
  while ((parentNode = parentNode.parent)) {
    if (parentNode.data && (styleData = normalizeStyleData(parentNode.data))) {
      extend(res, styleData);
    }
  }
  return res
}

/*  */

var cssVarRE = /^--/;
var importantRE = /\s*!important$/;
var setProp = function (el, name, val) {
  /* istanbul ignore if */
  if (cssVarRE.test(name)) {
    el.style.setProperty(name, val);
  } else if (importantRE.test(val)) {
    el.style.setProperty(name, val.replace(importantRE, ''), 'important');
  } else {
    el.style[normalize(name)] = val;
  }
};

var prefixes = ['Webkit', 'Moz', 'ms'];

var testEl;
var normalize = cached(function (prop) {
  testEl = testEl || document.createElement('div');
  prop = camelize(prop);
  if (prop !== 'filter' && (prop in testEl.style)) {
    return prop
  }
  var upper = prop.charAt(0).toUpperCase() + prop.slice(1);
  for (var i = 0; i < prefixes.length; i++) {
    var prefixed = prefixes[i] + upper;
    if (prefixed in testEl.style) {
      return prefixed
    }
  }
});

function updateStyle (oldVnode, vnode) {
  var data = vnode.data;
  var oldData = oldVnode.data;

  if (!data.staticStyle && !data.style &&
      !oldData.staticStyle && !oldData.style) {
    return
  }

  var cur, name;
  var el = vnode.elm;
  var oldStaticStyle = oldVnode.data.staticStyle;
  var oldStyleBinding = oldVnode.data.style || {};

  // if static style exists, stylebinding already merged into it when doing normalizeStyleData
  var oldStyle = oldStaticStyle || oldStyleBinding;

  var style = normalizeStyleBinding(vnode.data.style) || {};

  vnode.data.style = style.__ob__ ? extend({}, style) : style;

  var newStyle = getStyle(vnode, true);

  for (name in oldStyle) {
    if (newStyle[name] == null) {
      setProp(el, name, '');
    }
  }
  for (name in newStyle) {
    cur = newStyle[name];
    if (cur !== oldStyle[name]) {
      // ie9 setting to null has no effect, must use empty string
      setProp(el, name, cur == null ? '' : cur);
    }
  }
}

var style = {
  create: updateStyle,
  update: updateStyle
};

/*  */

/**
 * Add class with compatibility for SVG since classList is not supported on
 * SVG elements in IE
 */
function addClass (el, cls) {
  /* istanbul ignore if */
  if (!cls || !cls.trim()) {
    return
  }

  /* istanbul ignore else */
  if (el.classList) {
    if (cls.indexOf(' ') > -1) {
      cls.split(/\s+/).forEach(function (c) { return el.classList.add(c); });
    } else {
      el.classList.add(cls);
    }
  } else {
    var cur = ' ' + el.getAttribute('class') + ' ';
    if (cur.indexOf(' ' + cls + ' ') < 0) {
      el.setAttribute('class', (cur + cls).trim());
    }
  }
}

/**
 * Remove class with compatibility for SVG since classList is not supported on
 * SVG elements in IE
 */
function removeClass (el, cls) {
  /* istanbul ignore if */
  if (!cls || !cls.trim()) {
    return
  }

  /* istanbul ignore else */
  if (el.classList) {
    if (cls.indexOf(' ') > -1) {
      cls.split(/\s+/).forEach(function (c) { return el.classList.remove(c); });
    } else {
      el.classList.remove(cls);
    }
  } else {
    var cur = ' ' + el.getAttribute('class') + ' ';
    var tar = ' ' + cls + ' ';
    while (cur.indexOf(tar) >= 0) {
      cur = cur.replace(tar, ' ');
    }
    el.setAttribute('class', cur.trim());
  }
}

/*  */

var hasTransition = inBrowser && !isIE9;
var TRANSITION = 'transition';
var ANIMATION = 'animation';

// Transition property/event sniffing
var transitionProp = 'transition';
var transitionEndEvent = 'transitionend';
var animationProp = 'animation';
var animationEndEvent = 'animationend';
if (hasTransition) {
  /* istanbul ignore if */
  if (window.ontransitionend === undefined &&
    window.onwebkittransitionend !== undefined) {
    transitionProp = 'WebkitTransition';
    transitionEndEvent = 'webkitTransitionEnd';
  }
  if (window.onanimationend === undefined &&
    window.onwebkitanimationend !== undefined) {
    animationProp = 'WebkitAnimation';
    animationEndEvent = 'webkitAnimationEnd';
  }
}

// binding to window is necessary to make hot reload work in IE in strict mode
var raf = inBrowser && window.requestAnimationFrame
  ? window.requestAnimationFrame.bind(window)
  : setTimeout;

function nextFrame (fn) {
  raf(function () {
    raf(fn);
  });
}

function addTransitionClass (el, cls) {
  (el._transitionClasses || (el._transitionClasses = [])).push(cls);
  addClass(el, cls);
}

function removeTransitionClass (el, cls) {
  if (el._transitionClasses) {
    remove$1(el._transitionClasses, cls);
  }
  removeClass(el, cls);
}

function whenTransitionEnds (
  el,
  expectedType,
  cb
) {
  var ref = getTransitionInfo(el, expectedType);
  var type = ref.type;
  var timeout = ref.timeout;
  var propCount = ref.propCount;
  if (!type) { return cb() }
  var event = type === TRANSITION ? transitionEndEvent : animationEndEvent;
  var ended = 0;
  var end = function () {
    el.removeEventListener(event, onEnd);
    cb();
  };
  var onEnd = function (e) {
    if (e.target === el) {
      if (++ended >= propCount) {
        end();
      }
    }
  };
  setTimeout(function () {
    if (ended < propCount) {
      end();
    }
  }, timeout + 1);
  el.addEventListener(event, onEnd);
}

var transformRE = /\b(transform|all)(,|$)/;

function getTransitionInfo (el, expectedType) {
  var styles = window.getComputedStyle(el);
  var transitioneDelays = styles[transitionProp + 'Delay'].split(', ');
  var transitionDurations = styles[transitionProp + 'Duration'].split(', ');
  var transitionTimeout = getTimeout(transitioneDelays, transitionDurations);
  var animationDelays = styles[animationProp + 'Delay'].split(', ');
  var animationDurations = styles[animationProp + 'Duration'].split(', ');
  var animationTimeout = getTimeout(animationDelays, animationDurations);

  var type;
  var timeout = 0;
  var propCount = 0;
  /* istanbul ignore if */
  if (expectedType === TRANSITION) {
    if (transitionTimeout > 0) {
      type = TRANSITION;
      timeout = transitionTimeout;
      propCount = transitionDurations.length;
    }
  } else if (expectedType === ANIMATION) {
    if (animationTimeout > 0) {
      type = ANIMATION;
      timeout = animationTimeout;
      propCount = animationDurations.length;
    }
  } else {
    timeout = Math.max(transitionTimeout, animationTimeout);
    type = timeout > 0
      ? transitionTimeout > animationTimeout
        ? TRANSITION
        : ANIMATION
      : null;
    propCount = type
      ? type === TRANSITION
        ? transitionDurations.length
        : animationDurations.length
      : 0;
  }
  var hasTransform =
    type === TRANSITION &&
    transformRE.test(styles[transitionProp + 'Property']);
  return {
    type: type,
    timeout: timeout,
    propCount: propCount,
    hasTransform: hasTransform
  }
}

function getTimeout (delays, durations) {
  /* istanbul ignore next */
  while (delays.length < durations.length) {
    delays = delays.concat(delays);
  }

  return Math.max.apply(null, durations.map(function (d, i) {
    return toMs(d) + toMs(delays[i])
  }))
}

function toMs (s) {
  return Number(s.slice(0, -1)) * 1000
}

/*  */

function enter (vnode, toggleDisplay) {
  var el = vnode.elm;

  // call leave callback now
  if (el._leaveCb) {
    el._leaveCb.cancelled = true;
    el._leaveCb();
  }

  var data = resolveTransition(vnode.data.transition);
  if (!data) {
    return
  }

  /* istanbul ignore if */
  if (el._enterCb || el.nodeType !== 1) {
    return
  }

  var css = data.css;
  var type = data.type;
  var enterClass = data.enterClass;
  var enterToClass = data.enterToClass;
  var enterActiveClass = data.enterActiveClass;
  var appearClass = data.appearClass;
  var appearToClass = data.appearToClass;
  var appearActiveClass = data.appearActiveClass;
  var beforeEnter = data.beforeEnter;
  var enter = data.enter;
  var afterEnter = data.afterEnter;
  var enterCancelled = data.enterCancelled;
  var beforeAppear = data.beforeAppear;
  var appear = data.appear;
  var afterAppear = data.afterAppear;
  var appearCancelled = data.appearCancelled;

  // activeInstance will always be the <transition> component managing this
  // transition. One edge case to check is when the <transition> is placed
  // as the root node of a child component. In that case we need to check
  // <transition>'s parent for appear check.
  var context = activeInstance;
  var transitionNode = activeInstance.$vnode;
  while (transitionNode && transitionNode.parent) {
    transitionNode = transitionNode.parent;
    context = transitionNode.context;
  }

  var isAppear = !context._isMounted || !vnode.isRootInsert;

  if (isAppear && !appear && appear !== '') {
    return
  }

  var startClass = isAppear ? appearClass : enterClass;
  var activeClass = isAppear ? appearActiveClass : enterActiveClass;
  var toClass = isAppear ? appearToClass : enterToClass;
  var beforeEnterHook = isAppear ? (beforeAppear || beforeEnter) : beforeEnter;
  var enterHook = isAppear ? (typeof appear === 'function' ? appear : enter) : enter;
  var afterEnterHook = isAppear ? (afterAppear || afterEnter) : afterEnter;
  var enterCancelledHook = isAppear ? (appearCancelled || enterCancelled) : enterCancelled;

  var expectsCSS = css !== false && !isIE9;
  var userWantsControl =
    enterHook &&
    // enterHook may be a bound method which exposes
    // the length of original fn as _length
    (enterHook._length || enterHook.length) > 1;

  var cb = el._enterCb = once(function () {
    if (expectsCSS) {
      removeTransitionClass(el, toClass);
      removeTransitionClass(el, activeClass);
    }
    if (cb.cancelled) {
      if (expectsCSS) {
        removeTransitionClass(el, startClass);
      }
      enterCancelledHook && enterCancelledHook(el);
    } else {
      afterEnterHook && afterEnterHook(el);
    }
    el._enterCb = null;
  });

  if (!vnode.data.show) {
    // remove pending leave element on enter by injecting an insert hook
    mergeVNodeHook(vnode.data.hook || (vnode.data.hook = {}), 'insert', function () {
      var parent = el.parentNode;
      var pendingNode = parent && parent._pending && parent._pending[vnode.key];
      if (pendingNode &&
          pendingNode.tag === vnode.tag &&
          pendingNode.elm._leaveCb) {
        pendingNode.elm._leaveCb();
      }
      enterHook && enterHook(el, cb);
    }, 'transition-insert');
  }

  // start enter transition
  beforeEnterHook && beforeEnterHook(el);
  if (expectsCSS) {
    addTransitionClass(el, startClass);
    addTransitionClass(el, activeClass);
    nextFrame(function () {
      addTransitionClass(el, toClass);
      removeTransitionClass(el, startClass);
      if (!cb.cancelled && !userWantsControl) {
        whenTransitionEnds(el, type, cb);
      }
    });
  }

  if (vnode.data.show) {
    toggleDisplay && toggleDisplay();
    enterHook && enterHook(el, cb);
  }

  if (!expectsCSS && !userWantsControl) {
    cb();
  }
}

function leave (vnode, rm) {
  var el = vnode.elm;

  // call enter callback now
  if (el._enterCb) {
    el._enterCb.cancelled = true;
    el._enterCb();
  }

  var data = resolveTransition(vnode.data.transition);
  if (!data) {
    return rm()
  }

  /* istanbul ignore if */
  if (el._leaveCb || el.nodeType !== 1) {
    return
  }

  var css = data.css;
  var type = data.type;
  var leaveClass = data.leaveClass;
  var leaveToClass = data.leaveToClass;
  var leaveActiveClass = data.leaveActiveClass;
  var beforeLeave = data.beforeLeave;
  var leave = data.leave;
  var afterLeave = data.afterLeave;
  var leaveCancelled = data.leaveCancelled;
  var delayLeave = data.delayLeave;

  var expectsCSS = css !== false && !isIE9;
  var userWantsControl =
    leave &&
    // leave hook may be a bound method which exposes
    // the length of original fn as _length
    (leave._length || leave.length) > 1;

  var cb = el._leaveCb = once(function () {
    if (el.parentNode && el.parentNode._pending) {
      el.parentNode._pending[vnode.key] = null;
    }
    if (expectsCSS) {
      removeTransitionClass(el, leaveToClass);
      removeTransitionClass(el, leaveActiveClass);
    }
    if (cb.cancelled) {
      if (expectsCSS) {
        removeTransitionClass(el, leaveClass);
      }
      leaveCancelled && leaveCancelled(el);
    } else {
      rm();
      afterLeave && afterLeave(el);
    }
    el._leaveCb = null;
  });

  if (delayLeave) {
    delayLeave(performLeave);
  } else {
    performLeave();
  }

  function performLeave () {
    // the delayed leave may have already been cancelled
    if (cb.cancelled) {
      return
    }
    // record leaving element
    if (!vnode.data.show) {
      (el.parentNode._pending || (el.parentNode._pending = {}))[vnode.key] = vnode;
    }
    beforeLeave && beforeLeave(el);
    if (expectsCSS) {
      addTransitionClass(el, leaveClass);
      addTransitionClass(el, leaveActiveClass);
      nextFrame(function () {
        addTransitionClass(el, leaveToClass);
        removeTransitionClass(el, leaveClass);
        if (!cb.cancelled && !userWantsControl) {
          whenTransitionEnds(el, type, cb);
        }
      });
    }
    leave && leave(el, cb);
    if (!expectsCSS && !userWantsControl) {
      cb();
    }
  }
}

function resolveTransition (def$$1) {
  if (!def$$1) {
    return
  }
  /* istanbul ignore else */
  if (typeof def$$1 === 'object') {
    var res = {};
    if (def$$1.css !== false) {
      extend(res, autoCssTransition(def$$1.name || 'v'));
    }
    extend(res, def$$1);
    return res
  } else if (typeof def$$1 === 'string') {
    return autoCssTransition(def$$1)
  }
}

var autoCssTransition = cached(function (name) {
  return {
    enterClass: (name + "-enter"),
    leaveClass: (name + "-leave"),
    appearClass: (name + "-enter"),
    enterToClass: (name + "-enter-to"),
    leaveToClass: (name + "-leave-to"),
    appearToClass: (name + "-enter-to"),
    enterActiveClass: (name + "-enter-active"),
    leaveActiveClass: (name + "-leave-active"),
    appearActiveClass: (name + "-enter-active")
  }
});

function once (fn) {
  var called = false;
  return function () {
    if (!called) {
      called = true;
      fn();
    }
  }
}

function _enter (_, vnode) {
  if (!vnode.data.show) {
    enter(vnode);
  }
}

var transition = inBrowser ? {
  create: _enter,
  activate: _enter,
  remove: function remove (vnode, rm) {
    /* istanbul ignore else */
    if (!vnode.data.show) {
      leave(vnode, rm);
    } else {
      rm();
    }
  }
} : {};

var platformModules = [
  attrs,
  klass,
  events,
  domProps,
  style,
  transition
];

/*  */

// the directive module should be applied last, after all
// built-in modules have been applied.
var modules = platformModules.concat(baseModules);

var patch$1 = createPatchFunction({ nodeOps: nodeOps, modules: modules });

/**
 * Not type checking this file because flow doesn't like attaching
 * properties to Elements.
 */

var modelableTagRE = /^input|select|textarea|vue-component-[0-9]+(-[0-9a-zA-Z_-]*)?$/;

/* istanbul ignore if */
if (isIE9) {
  // http://www.matts411.com/post/internet-explorer-9-oninput/
  document.addEventListener('selectionchange', function () {
    var el = document.activeElement;
    if (el && el.vmodel) {
      trigger(el, 'input');
    }
  });
}

var model = {
  inserted: function inserted (el, binding, vnode) {
    if (process.env.NODE_ENV !== 'production') {
      if (!modelableTagRE.test(vnode.tag)) {
        warn(
          "v-model is not supported on element type: <" + (vnode.tag) + ">. " +
          'If you are working with contenteditable, it\'s recommended to ' +
          'wrap a library dedicated for that purpose inside a custom component.',
          vnode.context
        );
      }
    }
    if (vnode.tag === 'select') {
      var cb = function () {
        setSelected(el, binding, vnode.context);
      };
      cb();
      /* istanbul ignore if */
      if (isIE || isEdge) {
        setTimeout(cb, 0);
      }
    } else if (vnode.tag === 'textarea' || el.type === 'text') {
      el._vModifiers = binding.modifiers;
      if (!binding.modifiers.lazy) {
        if (!isAndroid) {
          el.addEventListener('compositionstart', onCompositionStart);
          el.addEventListener('compositionend', onCompositionEnd);
        }
        /* istanbul ignore if */
        if (isIE9) {
          el.vmodel = true;
        }
      }
    }
  },
  componentUpdated: function componentUpdated (el, binding, vnode) {
    if (vnode.tag === 'select') {
      setSelected(el, binding, vnode.context);
      // in case the options rendered by v-for have changed,
      // it's possible that the value is out-of-sync with the rendered options.
      // detect such cases and filter out values that no longer has a matching
      // option in the DOM.
      var needReset = el.multiple
        ? binding.value.some(function (v) { return hasNoMatchingOption(v, el.options); })
        : binding.value !== binding.oldValue && hasNoMatchingOption(binding.value, el.options);
      if (needReset) {
        trigger(el, 'change');
      }
    }
  }
};

function setSelected (el, binding, vm) {
  var value = binding.value;
  var isMultiple = el.multiple;
  if (isMultiple && !Array.isArray(value)) {
    process.env.NODE_ENV !== 'production' && warn(
      "<select multiple v-model=\"" + (binding.expression) + "\"> " +
      "expects an Array value for its binding, but got " + (Object.prototype.toString.call(value).slice(8, -1)),
      vm
    );
    return
  }
  var selected, option;
  for (var i = 0, l = el.options.length; i < l; i++) {
    option = el.options[i];
    if (isMultiple) {
      selected = looseIndexOf(value, getValue(option)) > -1;
      if (option.selected !== selected) {
        option.selected = selected;
      }
    } else {
      if (looseEqual(getValue(option), value)) {
        if (el.selectedIndex !== i) {
          el.selectedIndex = i;
        }
        return
      }
    }
  }
  if (!isMultiple) {
    el.selectedIndex = -1;
  }
}

function hasNoMatchingOption (value, options) {
  for (var i = 0, l = options.length; i < l; i++) {
    if (looseEqual(getValue(options[i]), value)) {
      return false
    }
  }
  return true
}

function getValue (option) {
  return '_value' in option
    ? option._value
    : option.value
}

function onCompositionStart (e) {
  e.target.composing = true;
}

function onCompositionEnd (e) {
  e.target.composing = false;
  trigger(e.target, 'input');
}

function trigger (el, type) {
  var e = document.createEvent('HTMLEvents');
  e.initEvent(type, true, true);
  el.dispatchEvent(e);
}

/*  */

// recursively search for possible transition defined inside the component root
function locateNode (vnode) {
  return vnode.componentInstance && (!vnode.data || !vnode.data.transition)
    ? locateNode(vnode.componentInstance._vnode)
    : vnode
}

var show = {
  bind: function bind (el, ref, vnode) {
    var value = ref.value;

    vnode = locateNode(vnode);
    var transition = vnode.data && vnode.data.transition;
    var originalDisplay = el.__vOriginalDisplay =
      el.style.display === 'none' ? '' : el.style.display;
    if (value && transition && !isIE9) {
      vnode.data.show = true;
      enter(vnode, function () {
        el.style.display = originalDisplay;
      });
    } else {
      el.style.display = value ? originalDisplay : 'none';
    }
  },

  update: function update (el, ref, vnode) {
    var value = ref.value;
    var oldValue = ref.oldValue;

    /* istanbul ignore if */
    if (value === oldValue) { return }
    vnode = locateNode(vnode);
    var transition = vnode.data && vnode.data.transition;
    if (transition && !isIE9) {
      vnode.data.show = true;
      if (value) {
        enter(vnode, function () {
          el.style.display = el.__vOriginalDisplay;
        });
      } else {
        leave(vnode, function () {
          el.style.display = 'none';
        });
      }
    } else {
      el.style.display = value ? el.__vOriginalDisplay : 'none';
    }
  },

  unbind: function unbind (
    el,
    binding,
    vnode,
    oldVnode,
    isDestroy
  ) {
    if (!isDestroy) {
      el.style.display = el.__vOriginalDisplay;
    }
  }
};

var platformDirectives = {
  model: model,
  show: show
};

/*  */

// Provides transition support for a single element/component.
// supports transition mode (out-in / in-out)

var transitionProps = {
  name: String,
  appear: Boolean,
  css: Boolean,
  mode: String,
  type: String,
  enterClass: String,
  leaveClass: String,
  enterToClass: String,
  leaveToClass: String,
  enterActiveClass: String,
  leaveActiveClass: String,
  appearClass: String,
  appearActiveClass: String,
  appearToClass: String
};

// in case the child is also an abstract component, e.g. <keep-alive>
// we want to recursively retrieve the real component to be rendered
function getRealChild (vnode) {
  var compOptions = vnode && vnode.componentOptions;
  if (compOptions && compOptions.Ctor.options.abstract) {
    return getRealChild(getFirstComponentChild(compOptions.children))
  } else {
    return vnode
  }
}

function extractTransitionData (comp) {
  var data = {};
  var options = comp.$options;
  // props
  for (var key in options.propsData) {
    data[key] = comp[key];
  }
  // events.
  // extract listeners and pass them directly to the transition methods
  var listeners = options._parentListeners;
  for (var key$1 in listeners) {
    data[camelize(key$1)] = listeners[key$1].fn;
  }
  return data
}

function placeholder (h, rawChild) {
  return /\d-keep-alive$/.test(rawChild.tag)
    ? h('keep-alive')
    : null
}

function hasParentTransition (vnode) {
  while ((vnode = vnode.parent)) {
    if (vnode.data.transition) {
      return true
    }
  }
}

function isSameChild (child, oldChild) {
  return oldChild.key === child.key && oldChild.tag === child.tag
}

var Transition = {
  name: 'transition',
  props: transitionProps,
  abstract: true,

  render: function render (h) {
    var this$1 = this;

    var children = this.$slots.default;
    if (!children) {
      return
    }

    // filter out text nodes (possible whitespaces)
    children = children.filter(function (c) { return c.tag; });
    /* istanbul ignore if */
    if (!children.length) {
      return
    }

    // warn multiple elements
    if (process.env.NODE_ENV !== 'production' && children.length > 1) {
      warn(
        '<transition> can only be used on a single element. Use ' +
        '<transition-group> for lists.',
        this.$parent
      );
    }

    var mode = this.mode;

    // warn invalid mode
    if (process.env.NODE_ENV !== 'production' &&
        mode && mode !== 'in-out' && mode !== 'out-in') {
      warn(
        'invalid <transition> mode: ' + mode,
        this.$parent
      );
    }

    var rawChild = children[0];

    // if this is a component root node and the component's
    // parent container node also has transition, skip.
    if (hasParentTransition(this.$vnode)) {
      return rawChild
    }

    // apply transition data to child
    // use getRealChild() to ignore abstract components e.g. keep-alive
    var child = getRealChild(rawChild);
    /* istanbul ignore if */
    if (!child) {
      return rawChild
    }

    if (this._leaving) {
      return placeholder(h, rawChild)
    }

    // ensure a key that is unique to the vnode type and to this transition
    // component instance. This key will be used to remove pending leaving nodes
    // during entering.
    var id = "__transition-" + (this._uid) + "-";
    var key = child.key = child.key == null
      ? id + child.tag
      : isPrimitive(child.key)
        ? (String(child.key).indexOf(id) === 0 ? child.key : id + child.key)
        : child.key;
    var data = (child.data || (child.data = {})).transition = extractTransitionData(this);
    var oldRawChild = this._vnode;
    var oldChild = getRealChild(oldRawChild);

    // mark v-show
    // so that the transition module can hand over the control to the directive
    if (child.data.directives && child.data.directives.some(function (d) { return d.name === 'show'; })) {
      child.data.show = true;
    }

    if (oldChild && oldChild.data && !isSameChild(child, oldChild)) {
      // replace old child transition data with fresh one
      // important for dynamic transitions!
      var oldData = oldChild && (oldChild.data.transition = extend({}, data));
      // handle transition mode
      if (mode === 'out-in') {
        // return placeholder node and queue update when leave finishes
        this._leaving = true;
        mergeVNodeHook(oldData, 'afterLeave', function () {
          this$1._leaving = false;
          this$1.$forceUpdate();
        }, key);
        return placeholder(h, rawChild)
      } else if (mode === 'in-out') {
        var delayedLeave;
        var performLeave = function () { delayedLeave(); };
        mergeVNodeHook(data, 'afterEnter', performLeave, key);
        mergeVNodeHook(data, 'enterCancelled', performLeave, key);
        mergeVNodeHook(oldData, 'delayLeave', function (leave) {
          delayedLeave = leave;
        }, key);
      }
    }

    return rawChild
  }
};

/*  */

// Provides transition support for list items.
// supports move transitions using the FLIP technique.

// Because the vdom's children update algorithm is "unstable" - i.e.
// it doesn't guarantee the relative positioning of removed elements,
// we force transition-group to update its children into two passes:
// in the first pass, we remove all nodes that need to be removed,
// triggering their leaving transition; in the second pass, we insert/move
// into the final disired state. This way in the second pass removed
// nodes will remain where they should be.

var props = extend({
  tag: String,
  moveClass: String
}, transitionProps);

delete props.mode;

var TransitionGroup = {
  props: props,

  render: function render (h) {
    var tag = this.tag || this.$vnode.data.tag || 'span';
    var map = Object.create(null);
    var prevChildren = this.prevChildren = this.children;
    var rawChildren = this.$slots.default || [];
    var children = this.children = [];
    var transitionData = extractTransitionData(this);

    for (var i = 0; i < rawChildren.length; i++) {
      var c = rawChildren[i];
      if (c.tag) {
        if (c.key != null && String(c.key).indexOf('__vlist') !== 0) {
          children.push(c);
          map[c.key] = c
          ;(c.data || (c.data = {})).transition = transitionData;
        } else if (process.env.NODE_ENV !== 'production') {
          var opts = c.componentOptions;
          var name = opts
            ? (opts.Ctor.options.name || opts.tag)
            : c.tag;
          warn(("<transition-group> children must be keyed: <" + name + ">"));
        }
      }
    }

    if (prevChildren) {
      var kept = [];
      var removed = [];
      for (var i$1 = 0; i$1 < prevChildren.length; i$1++) {
        var c$1 = prevChildren[i$1];
        c$1.data.transition = transitionData;
        c$1.data.pos = c$1.elm.getBoundingClientRect();
        if (map[c$1.key]) {
          kept.push(c$1);
        } else {
          removed.push(c$1);
        }
      }
      this.kept = h(tag, null, kept);
      this.removed = removed;
    }

    return h(tag, null, children)
  },

  beforeUpdate: function beforeUpdate () {
    // force removing pass
    this.__patch__(
      this._vnode,
      this.kept,
      false, // hydrating
      true // removeOnly (!important, avoids unnecessary moves)
    );
    this._vnode = this.kept;
  },

  updated: function updated () {
    var children = this.prevChildren;
    var moveClass = this.moveClass || ((this.name || 'v') + '-move');
    if (!children.length || !this.hasMove(children[0].elm, moveClass)) {
      return
    }

    // we divide the work into three loops to avoid mixing DOM reads and writes
    // in each iteration - which helps prevent layout thrashing.
    children.forEach(callPendingCbs);
    children.forEach(recordPosition);
    children.forEach(applyTranslation);

    // force reflow to put everything in position
    var f = document.body.offsetHeight; // eslint-disable-line

    children.forEach(function (c) {
      if (c.data.moved) {
        var el = c.elm;
        var s = el.style;
        addTransitionClass(el, moveClass);
        s.transform = s.WebkitTransform = s.transitionDuration = '';
        el.addEventListener(transitionEndEvent, el._moveCb = function cb (e) {
          if (!e || /transform$/.test(e.propertyName)) {
            el.removeEventListener(transitionEndEvent, cb);
            el._moveCb = null;
            removeTransitionClass(el, moveClass);
          }
        });
      }
    });
  },

  methods: {
    hasMove: function hasMove (el, moveClass) {
      /* istanbul ignore if */
      if (!hasTransition) {
        return false
      }
      if (this._hasMove != null) {
        return this._hasMove
      }
      addTransitionClass(el, moveClass);
      var info = getTransitionInfo(el);
      removeTransitionClass(el, moveClass);
      return (this._hasMove = info.hasTransform)
    }
  }
};

function callPendingCbs (c) {
  /* istanbul ignore if */
  if (c.elm._moveCb) {
    c.elm._moveCb();
  }
  /* istanbul ignore if */
  if (c.elm._enterCb) {
    c.elm._enterCb();
  }
}

function recordPosition (c) {
  c.data.newPos = c.elm.getBoundingClientRect();
}

function applyTranslation (c) {
  var oldPos = c.data.pos;
  var newPos = c.data.newPos;
  var dx = oldPos.left - newPos.left;
  var dy = oldPos.top - newPos.top;
  if (dx || dy) {
    c.data.moved = true;
    var s = c.elm.style;
    s.transform = s.WebkitTransform = "translate(" + dx + "px," + dy + "px)";
    s.transitionDuration = '0s';
  }
}

var platformComponents = {
  Transition: Transition,
  TransitionGroup: TransitionGroup
};

/*  */

// install platform specific utils
Vue$2.config.isUnknownElement = isUnknownElement;
Vue$2.config.isReservedTag = isReservedTag;
Vue$2.config.getTagNamespace = getTagNamespace;
Vue$2.config.mustUseProp = mustUseProp;

// install platform runtime directives & components
extend(Vue$2.options.directives, platformDirectives);
extend(Vue$2.options.components, platformComponents);

// install platform patch function
Vue$2.prototype.__patch__ = inBrowser ? patch$1 : noop;

// wrap mount
Vue$2.prototype.$mount = function (
  el,
  hydrating
) {
  el = el && inBrowser ? query(el) : undefined;
  return this._mount(el, hydrating)
};

if (process.env.NODE_ENV !== 'production' &&
    inBrowser && typeof console !== 'undefined') {
  console[console.info ? 'info' : 'log'](
    "You are running Vue in development mode.\n" +
    "Make sure to turn on production mode when deploying for production.\n" +
    "See more tips at https://vuejs.org/guide/deployment.html"
  );
}

// devtools global hook
/* istanbul ignore next */
setTimeout(function () {
  if (config.devtools) {
    if (devtools) {
      devtools.emit('init', Vue$2);
    } else if (
      process.env.NODE_ENV !== 'production' &&
      inBrowser && !isEdge && /Chrome\/\d+/.test(window.navigator.userAgent)
    ) {
      console[console.info ? 'info' : 'log'](
        'Download the Vue Devtools extension for a better development experience:\n' +
        'https://github.com/vuejs/vue-devtools'
      );
    }
  }
}, 0);

module.exports = Vue$2;

}).call(this,require('_process'),typeof global !== "undefined" ? global : typeof self !== "undefined" ? self : typeof window !== "undefined" ? window : {})
},{"_process":82}],86:[function(require,module,exports){
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

},{}],87:[function(require,module,exports){
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

},{}],88:[function(require,module,exports){
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

},{}],89:[function(require,module,exports){
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

},{}],90:[function(require,module,exports){
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

},{}],91:[function(require,module,exports){
'use strict';

var _laravelEcho = require('laravel-echo');

var _laravelEcho2 = _interopRequireDefault(_laravelEcho);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

window.Echo = new _laravelEcho2.default({
    broadcaster: 'pusher',
    key: 'adaa734ec4ce7b21a7ae',
    encrypted: true
});

},{"laravel-echo":81}],92:[function(require,module,exports){
var __vueify_insert__ = require("vueify/lib/insert-css")
var __vueify_style__ = __vueify_insert__.insert("\n/*added by lem93*/\n.disable-table[_v-0c3612d6]{\n    pointer-events:none;\n    background-color: white;\n    filter:alpha(opacity=50); /* IE */\n    opacity: 0.5; /* Safari, Opera */\n    -moz-opacity:0.50; /* FireFox */\n    z-index: 20;\n    height: 100%;\n    width: 100%;\n    background-repeat:no-repeat;\n    background-position:center;\n    position:absolute;\n    top: 0px;\n    left: 0px;\n}\n\n.bootstrap-table .table[_v-0c3612d6] {\n    margin-bottom: 0 !important;\n    border-bottom: 1px solid #dddddd;\n    border-collapse: collapse !important;\n    border-radius: 1px;\n}\n\n.bootstrap-table .table[_v-0c3612d6]:not(.table-condensed),\n.bootstrap-table .table:not(.table-condensed) > tbody > tr > th[_v-0c3612d6],\n.bootstrap-table .table:not(.table-condensed) > tfoot > tr > th[_v-0c3612d6],\n.bootstrap-table .table:not(.table-condensed) > thead > tr > td[_v-0c3612d6],\n.bootstrap-table .table:not(.table-condensed) > tbody > tr > td[_v-0c3612d6],\n.bootstrap-table .table:not(.table-condensed) > tfoot > tr > td[_v-0c3612d6] {\n    padding: 8px;\n}\n\n.bootstrap-table .table.table-no-bordered > thead > tr > th[_v-0c3612d6],\n.bootstrap-table .table.table-no-bordered > tbody > tr > td[_v-0c3612d6] {\n    border-right: 2px solid transparent;\n}\n\n.bootstrap-table .table.table-no-bordered > tbody > tr > td[_v-0c3612d6]:last-child {\n    border-right: none;\n}\n\n.fixed-table-container[_v-0c3612d6] {\n    position: relative;\n    clear: both;\n    border: 1px solid #dddddd;\n    border-radius: 4px;\n    -webkit-border-radius: 4px;\n    -moz-border-radius: 4px;\n}\n\n.fixed-table-container.table-no-bordered[_v-0c3612d6] {\n    border: 1px solid transparent;\n}\n\n.fixed-table-footer[_v-0c3612d6],\n.fixed-table-header[_v-0c3612d6] {\n    overflow: hidden;\n}\n\n.fixed-table-footer[_v-0c3612d6] {\n    border-top: 1px solid #dddddd;\n}\n\n.fixed-table-body[_v-0c3612d6] {\n    overflow-x: auto;\n    overflow-y: auto;\n    height: 100%;\n}\n\n.fixed-table-container table[_v-0c3612d6] {\n    width: 100%;\n}\n\n.fixed-table-container thead th[_v-0c3612d6] {\n    height: 0;\n    padding: 0;\n    margin: 0;\n    border-left: 1px solid #dddddd;\n}\n\n.fixed-table-container thead th[_v-0c3612d6]:focus {\n    outline: 0 solid transparent;\n}\n\n.fixed-table-container thead th[_v-0c3612d6]:first-child {\n    border-left: none;\n    border-top-left-radius: 4px;\n    -webkit-border-top-left-radius: 4px;\n    -moz-border-radius-topleft: 4px;\n}\n\n.fixed-table-container thead th .th-inner[_v-0c3612d6],\n.fixed-table-container tbody td .th-inner[_v-0c3612d6] {\n    padding: 8px;\n    line-height: 24px;\n    vertical-align: top;\n    overflow: hidden;\n    text-overflow: ellipsis;\n    white-space: nowrap;\n}\n\n.fixed-table-container thead th .sortable[_v-0c3612d6] {\n    cursor: pointer;\n    background-position: right;\n    background-repeat: no-repeat;\n    padding-right: 30px;\n}\n\n.fixed-table-container thead th .sortable.both[_v-0c3612d6] {\n    background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABMAAAATCAQAAADYWf5HAAAAkElEQVQoz7X QMQ5AQBCF4dWQSJxC5wwax1Cq1e7BAdxD5SL+Tq/QCM1oNiJidwox0355mXnG/DrEtIQ6azioNZQxI0ykPhTQIwhCR+BmBYtlK7kLJYwWCcJA9M4qdrZrd8pPjZWPtOqdRQy320YSV17OatFC4euts6z39GYMKRPCTKY9UnPQ6P+GtMRfGtPnBCiqhAeJPmkqAAAAAElFTkSuQmCC');\n}\n\n.fixed-table-container thead th .sortable.asc[_v-0c3612d6] {\n    background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABMAAAATCAYAAAByUDbMAAAAZ0lEQVQ4y2NgGLKgquEuFxBPAGI2ahhWCsS/gDibUoO0gPgxEP8H4ttArEyuQYxAPBdqEAxPBImTY5gjEL9DM+wTENuQahAvEO9DMwiGdwAxOymGJQLxTyD+jgWDxCMZRsEoGAVoAADeemwtPcZI2wAAAABJRU5ErkJggg==');\n}\n\n.fixed-table-container thead th .sortable.desc[_v-0c3612d6] {\n    background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABMAAAATCAYAAAByUDbMAAAAZUlEQVQ4y2NgGAWjYBSggaqGu5FA/BOIv2PBIPFEUgxjB+IdQPwfC94HxLykus4GiD+hGfQOiB3J8SojEE9EM2wuSJzcsFMG4ttQgx4DsRalkZENxL+AuJQaMcsGxBOAmGvopk8AVz1sLZgg0bsAAAAASUVORK5CYII= ');\n}\n\n.fixed-table-container th.detail[_v-0c3612d6] {\n    width: 30px;\n}\n\n.fixed-table-container tbody td[_v-0c3612d6] {\n    border-left: 1px solid #dddddd;\n}\n\n.fixed-table-container tbody tr:first-child td[_v-0c3612d6] {\n    border-top: none;\n}\n\n.fixed-table-container tbody td[_v-0c3612d6]:first-child {\n    border-left: none;\n}\n\n/* the same color with .active */\n.fixed-table-container tbody .selected td[_v-0c3612d6] {\n    background-color: #f5f5f5;\n}\n\n.fixed-table-container .bs-checkbox[_v-0c3612d6] {\n    text-align: center;\n}\n\n.fixed-table-container .bs-checkbox .th-inner[_v-0c3612d6] {\n    padding: 8px 0;\n}\n\n.fixed-table-container input[type=\"radio\"][_v-0c3612d6],\n.fixed-table-container input[type=\"checkbox\"][_v-0c3612d6] {\n    margin: 0 auto !important;\n}\n\n.fixed-table-container .no-records-found[_v-0c3612d6] {\n    text-align: center;\n}\n\n.fixed-table-pagination div.pagination[_v-0c3612d6],\n.fixed-table-pagination .pagination-detail[_v-0c3612d6] {\n    margin-top: 10px;\n    margin-bottom: 10px;\n}\n\n.fixed-table-pagination div.pagination .pagination[_v-0c3612d6] {\n    margin: 0;\n}\n\n.fixed-table-pagination .pagination a[_v-0c3612d6] {\n    padding: 6px 12px;\n    line-height: 1.428571429;\n}\n\n.fixed-table-pagination .pagination-info[_v-0c3612d6] {\n    line-height: 34px;\n    margin-right: 5px;\n}\n\n.fixed-table-pagination .btn-group[_v-0c3612d6] {\n    position: relative;\n    display: inline-block;\n    vertical-align: middle;\n}\n\n.fixed-table-pagination .dropup .dropdown-menu[_v-0c3612d6] {\n    margin-bottom: 0;\n}\n\n.fixed-table-pagination .page-list[_v-0c3612d6] {\n    display: inline-block;\n}\n\n.fixed-table-toolbar .columns-left[_v-0c3612d6] {\n    margin-right: 5px;\n}\n\n.fixed-table-toolbar .columns-right[_v-0c3612d6] {\n    margin-left: 5px;\n}\n\n.fixed-table-toolbar .columns label[_v-0c3612d6] {\n    display: block;\n    padding: 3px 20px;\n    clear: both;\n    font-weight: normal;\n    line-height: 1.428571429;\n}\n\n.fixed-table-toolbar .bs-bars[_v-0c3612d6],\n.fixed-table-toolbar .search[_v-0c3612d6],\n.fixed-table-toolbar .columns[_v-0c3612d6] {\n    position: relative;\n    margin-top: 10px;\n    margin-bottom: 10px;\n    line-height: 34px;\n}\n\n.fixed-table-pagination li.disabled a[_v-0c3612d6] {\n    pointer-events: none;\n    cursor: default;\n}\n\n.fixed-table-loading[_v-0c3612d6] {\n    position: absolute;\n    right: 0;\n    top: 0;\n    bottom: 0;\n    left: 0;\n    z-index: 99;\n}\n\n.fixed-table-loading-bg[_v-0c3612d6] {\n    position: absolute;\n    width: 100%;\n    height: 100%;\n    opacity: 0.9;\n    background-color: #fff;\n}\n\n.fixed-table-loading-text[_v-0c3612d6]:before {\n    content: '';\n    display: inline-block;\n    height: 100%;\n    vertical-align: middle;\n}\n\n.fixed-table-loading-text[_v-0c3612d6] {\n    position: absolute;\n    width: 100%;\n    height: 100%;\n    display: inline-block;\n    text-align: center;\n    vertical-align: middle;\n}\n\n.fixed-table-body .card-view .title[_v-0c3612d6] {\n    font-weight: bold;\n    display: inline-block;\n    min-width: 30%;\n    text-align: left !important;\n}\n\n/* support bootstrap 2 */\n.fixed-table-body thead th .th-inner[_v-0c3612d6] {\n    box-sizing: border-box;\n}\n\n.table th[_v-0c3612d6], .table td[_v-0c3612d6] {\n    vertical-align: middle;\n    box-sizing: border-box;\n}\n\n.fixed-table-toolbar .dropdown-menu[_v-0c3612d6] {\n    text-align: left;\n    max-height: 300px;\n    overflow: auto;\n}\n\n.fixed-table-toolbar .btn-group > .btn-group[_v-0c3612d6] {\n    display: inline-block;\n    margin-left: -1px !important;\n}\n\n.fixed-table-toolbar .btn-group > .btn-group > .btn[_v-0c3612d6] {\n    border-radius: 0;\n}\n\n.fixed-table-toolbar .btn-group > .btn-group:first-child > .btn[_v-0c3612d6] {\n    border-top-left-radius: 4px;\n    border-bottom-left-radius: 4px;\n}\n\n.fixed-table-toolbar .btn-group > .btn-group:last-child > .btn[_v-0c3612d6] {\n    border-top-right-radius: 4px;\n    border-bottom-right-radius: 4px;\n}\n\n.bootstrap-table .table > thead > tr > th[_v-0c3612d6] {\n    vertical-align: bottom;\n    border-bottom: 1px solid #ddd;\n}\n\n/* support bootstrap 3 */\n.bootstrap-table .table thead > tr > th[_v-0c3612d6] {\n    padding: 0;\n    margin: 0;\n}\n\n.bootstrap-table .fixed-table-footer tbody > tr > td[_v-0c3612d6] {\n    padding: 0 !important;\n}\n\n.bootstrap-table .fixed-table-footer .table[_v-0c3612d6] {\n    border-bottom: none;\n    border-radius: 0;\n    padding: 0 !important;\n}\n\n.pull-right .dropdown-menu[_v-0c3612d6] {\n    right: 0;\n    left: auto;\n}\n\n/* calculate scrollbar width */\np.fixed-table-scroll-inner[_v-0c3612d6] {\n    width: 100%;\n    height: 200px;\n}\n\ndiv.fixed-table-scroll-outer[_v-0c3612d6] {\n    top: 0;\n    left: 0;\n    visibility: hidden;\n    width: 200px;\n    height: 150px;\n    overflow: hidden;\n}\n")
'use strict';

var _stringify = require('babel-runtime/core-js/json/stringify');

var _stringify2 = _interopRequireDefault(_stringify);

var _getIterator2 = require('babel-runtime/core-js/get-iterator');

var _getIterator3 = _interopRequireDefault(_getIterator2);

var _keys = require('babel-runtime/core-js/object/keys');

var _keys2 = _interopRequireDefault(_keys);

var _typeof2 = require('babel-runtime/helpers/typeof');

var _typeof3 = _interopRequireDefault(_typeof2);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

// it only does '%s', and return '' when arguments are undefined
var sprintf = function sprintf(str) {
    var args = arguments,
        flag = true,
        i = 1;

    str = str.replace(/%s/g, function () {
        var arg = args[i++];

        if (typeof arg === 'undefined') {
            flag = false;
            return '';
        }
        return arg;
    });
    return flag ? str : '';
};

// http://jsfiddle.net/wenyi/47nz7ez9/3/
var setFieldIndex = function setFieldIndex(columns) {
    var i,
        j,
        k,
        totalCol = 0,
        flag = [];

    for (i = 0; i < columns[0].length; i++) {
        totalCol += columns[0][i].colspan || 1;
    }

    for (i = 0; i < columns.length; i++) {
        flag[i] = [];
        for (j = 0; j < totalCol; j++) {
            flag[i][j] = false;
        }
    }

    for (i = 0; i < columns.length; i++) {
        for (j = 0; j < columns[i].length; j++) {
            var r = columns[i][j],
                rowspan = r.rowspan || 1,
                colspan = r.colspan || 1,
                index = $.inArray(false, flag[i]);

            if (colspan === 1) {
                r.fieldIndex = index;
                // when field is undefined, use index instead
                if (typeof r.field === 'undefined') {
                    r.field = index;
                }
            }

            for (k = 0; k < rowspan; k++) {
                flag[i + k][index] = true;
            }
            for (k = 0; k < colspan; k++) {
                flag[i][index + k] = true;
            }
        }
    }
};

var getFieldIndex = function getFieldIndex(columns, field) {
    var index = -1;

    $.each(columns, function (i, column) {
        if (column.field === field) {
            index = i;
            return false;
        }
        return true;
    });
    return index;
};

var calculateObjectValue = function calculateObjectValue(self, name, args, defaultValue) {
    var func = name;

    if (typeof name === 'string') {
        // support obj.func1.func2
        var names = name.split('.');

        if (names.length > 1) {
            func = window;
            $.each(names, function (i, f) {
                func = func[f];
            });
        } else {
            func = window[name];
        }
    }
    if ((typeof func === 'undefined' ? 'undefined' : (0, _typeof3.default)(func)) === 'object') {
        return func;
    }
    if (typeof func === 'function') {
        return func.apply(self, args);
    }
    if (!func && typeof name === 'string' && sprintf.apply(this, [name].concat(args))) {
        return sprintf.apply(this, [name].concat(args));
    }
    return defaultValue;
};

var escapeHTML = function escapeHTML(text) {
    if (typeof text === 'string') {
        return text.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;').replace(/`/g, '&#x60;');
    }
    return text;
};

var getItemField = function getItemField(item, field, escape, undefinedText) {
    var value = item;

    if (typeof field !== 'string' || item.hasOwnProperty(field)) {
        return escape ? escapeHTML(item[field]) : item[field];
    }
    var props = field.split('.');
    for (var p in props) {
        value = value && value[props[p]];
    }
    return (escape ? escapeHTML(value) : value) || undefinedText;
};

var checkAllIndexOf = function checkAllIndexOf(type, items, data, from, to) {
    if (type === 'radio') {
        return false;
    }
    for (var i = from; i < to; i++) {
        if (items.indexOf(data[i]) === -1) {
            return false;
        }
    }
    return true;
};

var DEFAULTS = {
    classes: 'table table-hover',
    height: undefined,
    undefinedText: '-',
    escape: false,
    showHeader: true,
    showFooter: false,
    cardView: false,
    locale: undefined,

    method: 'get',
    url: undefined,
    contentType: 'application/json',
    dataType: 'json',
    cache: true,
    ajax: undefined,
    ajaxOptions: {},
    queryParams: function queryParams(params) {
        return params;
    },
    queryParamsType: 'limit', // undefined
    responseHandler: function responseHandler(res) {
        return res;
    },
    responseTotalField: 'total',
    responseRowsField: 'rows',

    sortable: true,
    sortName: '',
    sortOrder: 'asc',
    sortStable: false,

    pagination: false,
    sidePagination: 'client', // client or server
    onlyInfoPagination: false,
    totalRows: 0, // no need to set, can be use in getOptions
    pageNumber: 1,
    pageSize: 10,
    pageList: [10, 25, 50, 100],
    paginationPreText: '&lsaquo;',
    paginationNextText: '&rsaquo;',
    paginationHAlign: 'right', //right, left
    paginationVAlign: 'bottom', //bottom, top, both
    paginationDetailHAlign: 'left', //right, left

    search: false,
    searchText: '',
    strictSearch: false,
    searchOnEnterKey: false,
    trimOnSearch: true,
    searchTimeOut: 500,
    searchAlign: 'right',

    showPaginationSwitch: false,
    showToggle: false,
    showRefresh: false,
    showColumns: false,
    minimumCountColumns: 1,
    buttonsAlign: 'right',
    toolbarAlign: 'left',

    idField: undefined,
    clickToSelect: false,
    singleSelect: false,
    selectItemName: 'btSelectItem',
    uniqueId: undefined,
    checkboxHeader: true,
    maintainSelected: false,

    detailView: false,
    detailFormatter: function detailFormatter(index, row) {
        return '';
    },

    iconSize: '',
    buttonsClass: 'default',
    iconsPrefix: 'glyphicon', // glyphicon of fa (font awesome)
    icons: {
        paginationSwitchDown: 'glyphicon-collapse-down icon-chevron-down',
        paginationSwitchUp: 'glyphicon-collapse-up icon-chevron-up',
        refresh: 'glyphicon-refresh icon-refresh',
        toggle: 'glyphicon-list-alt icon-list-alt',
        columns: 'glyphicon-th icon-th',
        detailOpen: 'glyphicon-plus icon-plus',
        detailClose: 'glyphicon-minus icon-minus'
    },

    rowStyle: function rowStyle(row, index) {
        return {};
    },
    footerStyle: function footerStyle(row, index) {
        return {};
    }
};

var COLUMN_DEFAULTS = {
    field: undefined,
    title: undefined,
    titleTooltip: undefined,
    width: undefined,
    'class': undefined,
    align: undefined, // left, right, center
    halign: undefined, // left, right, center
    falign: undefined, // left, right, center
    valign: undefined, // top, middle, bottom
    radio: false,
    checkbox: false,
    clickToSelect: true,
    visible: true,
    switchable: true,
    searchable: true,
    searchFormatted: true,
    cardVisible: true,
    formatter: undefined,
    footerFormatter: undefined,
    events: undefined,
    sortable: false,
    order: 'asc', // asc, desc
    sorter: undefined,
    sortName: undefined,
    cellStyle: undefined
};

var LOCALES = {};
LOCALES['en-US'] = LOCALES.en = {
    formatLoadingMessage: function formatLoadingMessage() {
        return 'Loading, please wait...';
    },
    formatRecordsPerPage: function formatRecordsPerPage(pageNumber) {
        return sprintf('%s rows per page', pageNumber);
    },
    formatShowingRows: function formatShowingRows(pageFrom, pageTo, totalRows) {
        return sprintf('Showing %s to %s of %s rows', pageFrom, pageTo, totalRows);
    },
    formatDetailPagination: function formatDetailPagination(totalRows) {
        return sprintf('Showing %s rows', totalRows);
    },
    formatSearch: function formatSearch() {
        return 'Search';
    },
    formatNoMatches: function formatNoMatches() {
        return 'No matching records found';
    },
    formatPaginationSwitch: function formatPaginationSwitch() {
        return 'Hide/Show pagination';
    },
    formatRefresh: function formatRefresh() {
        return 'Refresh';
    },
    formatToggle: function formatToggle() {
        return 'Toggle';
    },
    formatColumns: function formatColumns() {
        return 'Columns';
    },
    formatAllRows: function formatAllRows() {
        return 'All';
    }
};

$.extend(DEFAULTS, LOCALES['en-US']);

var BootstrapTable = {
    props: {
        columns: {
            type: Array,
            required: true,
            default: function _default() {
                return [];
            }
        },
        data: {
            type: Array,
            default: function _default() {
                return [];
            }
        },
        options: {
            type: Object,
            default: function _default() {
                return DEFAULTS;
            }
        }
    },
    data: function data() {
        return {
            fieldColumns: {},
            header: {},
            disabledTable: false,
            pageFrom: 1,
            pageTo: 1,
            totalPages: 0,
            searchText: '',
            loading: false,
            selected: {
                type: '',
                all: false,
                items: []
            },
            view: {
                headerHeight: 0
            }
        };
    },
    created: function created() {
        this.initLocale();
        this.initTable();
        this.initHeader();
        this.initPagination();
        this.initBody();
        this.initServer();
    },
    // lem93
    events: {
        refreshTable: function refreshTable() {
            var currentTable = this;
            setTimeout(function () {
                currentTable.updatePagination();
                currentTable.disabledTable = false;
            }, 10);
        },
        disableTable: function disableTable() {
            this.disabledTable = true;
        },
        enableTable: function enableTable() {
            this.disabledTable = false;
        }
    },
    computed: {
        paginationSwitchIcon: function paginationSwitchIcon() {
            return this.options.icons[this.options.pagination ? 'paginationSwitchDown' : 'paginationSwitchUp'];
        },
        toggleColumnsCount: function toggleColumnsCount() {
            var count = 0;
            for (var i in this.fieldColumns) {
                if (!(this.fieldColumns[i].radio || this.fieldColumns[i].checkbox || this.options.cardView && !this.fieldColumns[i].cardVisible) && this.fieldColumns[i].visible) {
                    count++;
                }
            }
            return count;
        },
        renderData: function renderData() {
            var that = this,
                data = this.data.slice(this.pageFrom - 1, this.pageTo);

            data.forEach(function (item, i) {
                var key,
                    style = {},
                    csses = [];

                style = calculateObjectValue(that.options, that.options.rowStyle, [item, i], style);

                if (style && style.css) {
                    for (key in style.css) {
                        csses.push(key + ': ' + style.css[key]);
                    }
                }
                item.style = style;
                item.csses = csses;
            });

            if (!this.options.maintainSelected) {
                this.selected.all = false;
                this.selected.items = [];
            } else {
                this.selected.all = checkAllIndexOf(this.selected.type, this.selected.items, this.data, this.pageFrom - 1, this.pageTo);
            }

            if (this.options.sidePagination !== 'server') {
                var s = this.searchText && (this.options.escape ? escapeHTML(this.searchText) : this.searchText).toLowerCase();

                data = s ? $.grep(data, function (item, i) {
                    for (var key in item) {
                        key = $.isNumeric(key) ? parseInt(key, 10) : key;
                        var value = item[key],
                            column = that.fieldColumns[getFieldIndex(that.fieldColumns, key)],
                            j = $.inArray(key, that.header.fields);

                        // Fix #142: search use formatted data
                        if (column && column.searchFormatted) {
                            value = calculateObjectValue(column, that.header.formatters[j], [value, item, i], value);
                        }

                        var index = $.inArray(key, that.header.fields);
                        if (index !== -1 && that.header.searchables[index] && (typeof value === 'string' || typeof value === 'number')) {
                            if (that.options.strictSearch) {
                                if ((value + '').toLowerCase() === s) {
                                    return true;
                                }
                            } else {
                                if ((value + '').toLowerCase().indexOf(s) !== -1) {
                                    return true;
                                }
                            }
                        }
                    }
                    return false;
                }) : data;
            }

            this._renderData = data;
            this.$nextTick(this.resetView);
            return data;
        },
        pageInfo: function pageInfo() {
            var i,
                from,
                to,
                info = {};

            if (this.totalPages < 5) {
                from = 1;
                to = this.totalPages;
            } else {
                from = this.options.pageNumber - 2;
                to = from + 4;
                if (from < 1) {
                    from = 1;
                    to = 5;
                }
                if (to > this.totalPages) {
                    to = this.totalPages;
                    from = to - 4;
                }
            }

            if (this.totalPages >= 6) {
                if (this.options.pageNumber >= 3) {
                    info.first = true;
                    from++;
                }

                if (this.options.pageNumber >= 4) {
                    if (this.options.pageNumber == 4 || this.totalPages == 6 || this.totalPages == 7) {
                        from--;
                    } else {
                        info.firstSeparator = true;
                    }

                    to--;
                }
            }

            if (this.totalPages >= 7 && this.options.pageNumber >= this.totalPages - 2) {
                from--;
            }

            if (this.totalPages === 6 && this.options.pageNumber >= this.totalPages - 2) {
                to++;
            } else if (this.totalPages >= 7 && (this.totalPages === 7 || this.options.pageNumber >= this.totalPages - 3)) {
                to++;
            }

            info.list = [];
            for (i = from; i <= to; i++) {
                info.list.push(i);
            }

            if (this.totalPages >= 8 && this.options.pageNumber <= this.totalPages - 4) {
                info.lastSeparator = true;
            }

            if (this.totalPages >= 6 && this.options.pageNumber <= this.totalPages - 3) {
                info.last = true;
            }
            return info;
        },
        columnsLength: function columnsLength() {
            return (0, _keys2.default)(this.fieldColumns).length;
        }
    },
    methods: {
        // lem93 methods
        colorTable: function colorTable(e) {
            this.clearRowClasses(e.path[3].rows);
            e.path[1].classList.add('table_active');
        },
        selectId: function selectId(id) {
            this.objectId = id;
            this.$dispatch('rowClicked', id);
        },
        clearRowClasses: function clearRowClasses(rows) {
            var _iteratorNormalCompletion = true;
            var _didIteratorError = false;
            var _iteratorError = undefined;

            try {
                for (var _iterator = (0, _getIterator3.default)(rows), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
                    var row = _step.value;

                    row.classList.remove('table_active');
                }
            } catch (err) {
                _didIteratorError = true;
                _iteratorError = err;
            } finally {
                try {
                    if (!_iteratorNormalCompletion && _iterator.return) {
                        _iterator.return();
                    }
                } finally {
                    if (_didIteratorError) {
                        throw _iteratorError;
                    }
                }
            }
        },

        // end
        initLocale: function initLocale() {
            if (!this.options.locale) {
                return;
            }
            var parts = this.options.locale.split(/-|_/);
            parts[0].toLowerCase();
            if (parts[1]) parts[1].toUpperCase();
            if (BootstrapTable.locales[this.options.locale]) {
                // locale as requested
                $.extend(this.options, BootstrapTable.locales[this.options.locale]);
            } else if (BootstrapTable.locales[parts.join('-')]) {
                // locale with sep set to - (in case original was specified with _)
                $.extend(this.options, BootstrapTable.locales[parts.join('-')]);
            } else if (BootstrapTable.locales[parts[0]]) {
                // short locale language code (i.e. 'en')
                $.extend(this.options, BootstrapTable.locales[parts[0]]);
            }
        },
        initTable: function initTable() {
            var that = this,
                columns = {};

            this.options = $.extend({}, DEFAULTS, this.options);
            if (!Array.isArray(this.columns[0])) {
                this.columns = [this.columns];
            }
            setFieldIndex(this.columns);
            this.columns.forEach(function (_columns, i) {
                _columns.forEach(function (column, j) {
                    column = $.extend({}, COLUMN_DEFAULTS, column);

                    if (typeof column.fieldIndex !== 'undefined') {
                        columns[column.fieldIndex] = column;
                    }

                    that.columns[i][j] = column;
                });
            });
            this.fieldColumns = columns;
            this.searchText = this.options.searchText;
            this.timeoutId = 0;
        },
        initHeader: function initHeader() {
            var that = this,
                visibleColumns = {};

            this.header = {
                fields: [],
                styles: [],
                classes: [],
                formatters: [],
                events: [],
                sorters: [],
                sortNames: [],
                cellStyles: [],
                searchables: []
            };
            this.columns.forEach(function (columns, i) {
                columns.forEach(function (column, j) {
                    var halign = '',
                        // header align style
                    align = '',
                        // body align style
                    style = '',
                        class_ = sprintf(' class="%s"', column['class']),
                        unitWidth = 'px',
                        width = column.width;

                    if (column.width !== undefined && !that.options.cardView) {
                        if (typeof column.width === 'string') {
                            if (column.width.indexOf('%') !== -1) {
                                unitWidth = '%';
                            }
                        }
                    }
                    if (column.width && typeof column.width === 'string') {
                        width = column.width.replace('%', '').replace('px', '');
                    }

                    halign = sprintf('text-align: %s; ', column.halign ? column.halign : column.align);
                    align = sprintf('text-align: %s; ', column.align);
                    style = sprintf('vertical-align: %s; ', column.valign);
                    style += sprintf('width: %s; ', (column.checkbox || column.radio) && !width ? '36px' : width ? width + unitWidth : undefined);

                    column.style = halign + style;

                    if (typeof column.fieldIndex !== 'undefined') {
                        that.header.fields[column.fieldIndex] = column.field;
                        that.header.styles[column.fieldIndex] = align + style;
                        that.header.classes[column.fieldIndex] = class_;
                        that.header.formatters[column.fieldIndex] = column.formatter;
                        that.header.events[column.fieldIndex] = column.events;
                        that.header.sorters[column.fieldIndex] = column.sorter;
                        that.header.sortNames[column.fieldIndex] = column.sortName;
                        that.header.cellStyles[column.fieldIndex] = column.cellStyle;
                        that.header.searchables[column.fieldIndex] = column.searchable;

                        if (!column.visible) {
                            return;
                        }

                        if (that.options.cardView && !column.cardVisible) {
                            return;
                        }

                        visibleColumns[column.field] = column;
                    }

                    if (column.checkbox || column.radio) {
                        that.selected.type = column.checkbox ? 'checkbox' : 'radio';
                        that.header.stateField = column.field;
                    }
                });
            });
        },
        onSort: function onSort(column) {
            if (!this.options.sortable || !column.sortable) {
                return;
            }
            if (this.options.sortName === column.field) {
                this.options.sortOrder = this.options.sortOrder === 'asc' ? 'desc' : 'asc';
            } else {
                this.options.sortName = column.field;
                this.options.sortOrder = column.order === 'asc' ? 'desc' : 'asc';
            }
            this.trigger('sort', this.options.sortName, this.options.sortOrder);

            if (this.options.sidePagination === 'server') {
                this.initServer();
                return;
            }

            this.initSort();
            this.initBody();
        },
        initSort: function initSort() {
            var that = this,
                name = this.options.sortName,
                order = this.options.sortOrder === 'desc' ? -1 : 1,
                index = this.header.fields.indexOf(this.options.sortName);

            if (index !== -1) {
                if (this.options.sortStable) {
                    this.data.forEach(function (row, i) {
                        if (!row.hasOwnProperty('_position')) row._position = i;
                    });
                }

                this.data.sort(function (a, b) {
                    if (that.header.sortNames[index]) {
                        name = that.header.sortNames[index];
                    }
                    var aa = getItemField(a, name, that.options.escape),
                        bb = getItemField(b, name, that.options.escape),
                        value = calculateObjectValue(that.header, that.header.sorters[index], [aa, bb]);

                    if (value !== undefined) {
                        return order * value;
                    }

                    // Fix #161: undefined or null string sort bug.
                    if (aa === undefined || aa === null) {
                        aa = '';
                    }
                    if (bb === undefined || bb === null) {
                        bb = '';
                    }

                    if (that.options.sortStable && aa === bb) {
                        aa = a._position;
                        bb = b._position;
                    }

                    // IF both values are numeric, do a numeric comparison
                    if ($.isNumeric(aa) && $.isNumeric(bb)) {
                        // Convert numerical values form string to float.
                        aa = parseFloat(aa);
                        bb = parseFloat(bb);
                        if (aa < bb) {
                            return order * -1;
                        }
                        return order;
                    }

                    if (aa === bb) {
                        return 0;
                    }

                    // If value is not a string, convert to string
                    if (typeof aa !== 'string') {
                        aa = aa.toString();
                    }

                    if (aa.localeCompare(bb) === -1) {
                        return order * -1;
                    }

                    return order;
                });
            }
        },
        search: function search(event) {
            var that = this;
            if (this.options.searchOnEnterKey && event.keyCode !== 13) {
                return;
            }

            if ([37, 38, 39, 40].indexOf(event.keyCode) > -1) {
                return;
            }

            clearTimeout(this.timeoutId); // doesn't matter if it's 0
            this.timeoutId = setTimeout(function () {
                that.onSearch(event);
            }, this.options.searchTimeOut);
        },
        onSearch: function onSearch(event) {
            if (this.options.trimOnSearch) {
                this.searchText = this.searchText.trim();
            }

            if (this.options.searchText === this.searchText) {
                return;
            }
            this.options.searchText = this.searchText;

            this.options.pageNumber = 1;
            this.updatePagination();
            this.trigger('search', this.searchText);
        },
        togglePagination: function togglePagination() {
            this.options.pagination = !this.options.pagination;
            this.updatePagination();
        },
        refresh: function refresh(params) {
            if (params && params.url) {
                this.options.pageNumber = 1;
            }
            this.initServer(params && params.silent, params && params.query, params && params.url);

            this.trigger('refresh', params);
        },
        toggleView: function toggleView() {
            this.options.cardView = !this.options.cardView;
            this.initBody();
            this.trigger('toggle', this.options.cardView);
        },
        initPagination: function initPagination() {
            if (this.options.sidePagination !== 'server') {
                this.options.totalRows = this.data.length;
            }

            this.totalPages = 0;
            if (this.options.totalRows) {
                if (this.options.pageSize === this.options.formatAllRows()) {
                    this.options.pageSize = this.options.totalRows;
                }

                this.totalPages = ~~((this.options.totalRows - 1) / this.options.pageSize) + 1;

                this.options.totalPages = this.totalPages;
            }
            if (this.totalPages > 0 && this.options.pageNumber > this.totalPages) {
                this.options.pageNumber = this.totalPages;
            }

            this.pageFrom = (this.options.pageNumber - 1) * this.options.pageSize + 1;
            this.pageTo = this.options.pageNumber * this.options.pageSize;
            if (this.pageTo > this.options.totalRows) {
                this.pageTo = this.options.totalRows;
            }
        },
        updatePagination: function updatePagination() {
            this.initPagination();
            if (this.options.sidePagination === 'server') {
                this.initServer();
            } else {
                this.initBody();
            }
        },
        onPageListChange: function onPageListChange(event) {
            var $this = $(event.currentTarget);

            this.options.pageSize = $this.text().toUpperCase() === this.options.formatAllRows().toUpperCase() ? this.options.formatAllRows() : +$this.text();

            this.updatePagination();
        },
        onPagePre: function onPagePre() {
            if (this.options.pageNumber - 1 === 0) {
                this.options.pageNumber = this.options.totalPages;
            } else {
                this.options.pageNumber--;
            }
            this.updatePagination();
        },
        onPageFirst: function onPageFirst() {
            this.options.pageNumber = 1;
            this.updatePagination();
        },
        onPageNumber: function onPageNumber(event) {
            var number = +$(event.currentTarget).text();
            if (this.options.pageNumber === number) {
                return;
            }
            this.options.pageNumber = number;
            this.updatePagination();
        },
        onPageLast: function onPageLast() {
            this.options.pageNumber = this.totalPages;
            this.updatePagination();
        },
        onPageNext: function onPageNext() {
            if (this.options.pageNumber + 1 > this.options.totalPages) {
                this.options.pageNumber = 1;
            } else {
                this.options.pageNumber++;
            }
            this.updatePagination();
        },
        initBody: function initBody(fixedScroll) {
            if (!this.options.pagination || this.options.sidePagination === 'server') {
                this.pageFrom = 1;
                this.pageTo = this.data.length;
            }
        },
        onCheckAllChange: function onCheckAllChange() {
            var items = [];
            if (this.selected.all) {
                for (var i = this.pageFrom - 1; i < this.pageTo; i++) {
                    items.push(this.data[i]);
                }
            }
            this.selected.items = items;
            this.trigger(this.selected.all ? 'check-all' : 'uncheck-all');
        },
        onCheckItemChange: function onCheckItemChange(item) {
            this.selected.all = checkAllIndexOf(this.selected.type, this.selected.items, this.data, this.pageFrom - 1, this.pageTo);

            if (this.selected.type === 'radio') {
                this.trigger('check', item);
            } else {
                var selected = this.selected.items.indexOf(item) > -1;
                if (this.options.singleSelect) {
                    this.selected.items = selected ? [item] : [];
                }
                this.trigger(selected ? 'check' : 'uncheck', item);
            }
        },
        onTdClick: function onTdClick(item, field, e) {
            var column = this.fieldColumns[getFieldIndex(this.fieldColumns, field)],
                value = getItemField(item, field, this.options.escape);

            // this.trigger(e.type === 'click' ? 'click-cell' : 'dbl-click-cell', field, value, item);
            // this.trigger(e.type === 'click' ? 'click-row' : 'dbl-click-row', item, field);
            this.colorTable(e); // lem93
            this.selectId(item.id); // lem93

            // if click to select - then trigger the checkbox/radio click
            if (e.type === 'click' && this.options.clickToSelect && column.clickToSelect) {
                if (this.selected.type === 'radio') {
                    this.selected.items = item;
                } else {
                    var index = this.selected.items.indexOf(item);
                    if (index > -1) {
                        this.selected.items.splice(index, 1);
                    } else {
                        this.selected.items.push(item);
                    }
                }
                this.onCheckItemChange(item);
            }
        },
        initServer: function initServer(silent, query, url) {
            var that = this,
                data = {},
                params = {
                searchText: this.searchText,
                sortName: this.options.sortName,
                sortOrder: this.options.sortOrder
            },
                request;

            if (this.options.pagination) {
                params.pageSize = this.options.pageSize === this.options.formatAllRows() ? this.options.totalRows : this.options.pageSize;
                params.pageNumber = this.options.pageNumber;
            }

            if (!(url || this.options.url) && !this.options.ajax) {
                return;
            }

            if (this.options.queryParamsType === 'limit') {
                params = {
                    search: params.searchText,
                    sort: params.sortName,
                    order: params.sortOrder
                };

                if (this.options.pagination) {
                    params.offset = this.options.pageSize === this.options.formatAllRows() ? 0 : this.options.pageSize * (this.options.pageNumber - 1);
                    params.limit = this.options.pageSize === this.options.formatAllRows() ? this.options.totalRows : this.options.pageSize;
                }
            }

            if (!$.isEmptyObject(this.filterColumnsPartial)) {
                params.filter = (0, _stringify2.default)(this.filterColumnsPartial, null);
            }

            data = calculateObjectValue(this.options, this.options.queryParams, [params], data);

            $.extend(data, query || {});

            // false to stop request
            if (data === false) {
                return;
            }

            if (!silent) {
                this.loading = true;
            }
            request = $.extend({}, calculateObjectValue(null, this.options.ajaxOptions), {
                type: this.options.method,
                url: url || this.options.url,
                data: this.options.contentType === 'application/json' && this.options.method === 'post' ? (0, _stringify2.default)(data) : data,
                cache: this.options.cache,
                contentType: this.options.contentType,
                dataType: this.dataType,
                success: function success(res) {
                    res = calculateObjectValue(that.options, that.options.responseHandler, [res], res);

                    that.load(res);
                    if (!silent) that.loading = false;
                    that.trigger('load-success', res);
                },
                error: function error(res) {
                    if (!silent) that.loading = false;
                    that.trigger('load-error', res.status, res);
                }
            });

            if (this.options.ajax) {
                calculateObjectValue(this, this.options.ajax, [request], null);
            } else {
                if (this._xhr && this._xhr.readyState !== 4) {
                    this._xhr.abort();
                }
                this._xhr = $.ajax(request);
            }
        },
        load: function load(data) {
            var fixedScroll = false;

            if (this.options.sidePagination === 'server') {
                this.options.totalRows = data[this.options.responseTotalField];
                fixedScroll = data.fixedScroll;
                data = data[this.options.responseRowsField];
            } else if (!$.isArray(data)) {
                // support fixedScroll
                fixedScroll = data.fixedScroll;
                data = data.data;
            }
            this.data = data;

            this.initSort();
            this.initPagination();
            this.initBody(fixedScroll);
        },
        getVisibleFields: function getVisibleFields() {
            var that = this,
                visibleFields = [];

            this.header.fields.forEach(function (field) {
                var column = that.fieldColumns[getFieldIndex(that.fieldColumns, field)];

                if (!column.visible) {
                    return;
                }
                visibleFields.push(field);
            });
            return visibleFields;
        },
        resetView: function resetView() {
            var that = this,
                $el = $(this.$el);

            this.view.headerHeight = $el.find('thead:visible').height();

            this.header.events.forEach(function (events, i) {
                if (!events) {
                    return;
                }
                // if events is defined with namespace
                if (typeof events === 'string') {
                    events = calculateObjectValue(null, events);
                }

                var field = that.header.fields[i],
                    fieldIndex = that.getVisibleFields().indexOf(field);

                if (that.options.detailView && !that.options.cardView) {
                    fieldIndex += 1;
                }

                for (var key in events) {
                    $el.find('tbody >tr:not(.no-records-found)').each(function () {
                        var $tr = $(this),
                            $td = $tr.find(that.options.cardView ? '.card-view' : 'td').eq(fieldIndex),
                            index = key.indexOf(' '),
                            name = key.substring(0, index),
                            el = key.substring(index + 1),
                            func = events[key];

                        $td.find(el).off(name).on(name, function (e) {
                            var index = $tr.data('index'),
                                row = that._renderData[index],
                                value = row[field];

                            func.apply(this, [e, value, row, index]);
                        });
                    });
                }
            });
        },
        trigger: function trigger(name) {
            var args = Array.prototype.slice.call(arguments, 1);

            name += '.bs.table';
            console.log(name, args);
        }
    },
    filters: {
        fieldValue: function fieldValue(item, field, i, j) {
            var value = getItemField(item, field, this.options.escape),
                column = this.fieldColumns[j];

            return calculateObjectValue(column, this.header.formatters[j], [value, item, i], value);
        }
    }
};

BootstrapTable.defaults = DEFAULTS;
BootstrapTable.column_defaults = COLUMN_DEFAULTS;
BootstrapTable.locales = LOCALES;

module.exports = BootstrapTable;
if (module.exports.__esModule) module.exports = module.exports.default
;(typeof module.exports === "function"? module.exports.options: module.exports).template = "\n<span id=\"tableOverlay\" :class=\"(disabledTable) ? 'disable-table' : ''\" _v-0c3612d6=\"\">\n    <div class=\"bootstrap-table\" _v-0c3612d6=\"\">\n        <div class=\"fixed-table-toolbar\" _v-0c3612d6=\"\">\n            <div class=\"pull-{{options.toolbarAlign}}\" _v-0c3612d6=\"\">\n                <slot _v-0c3612d6=\"\">\n                </slot>\n            </div>\n            <div class=\"columns columns-{{options.buttonsAlign}} btn-group pull-{{options.buttonsAlign}}\" _v-0c3612d6=\"\">\n                <button v-if=\"options.showPaginationSwitch\" class=\"btn btn-{{options.buttonsClass}} btn-{{options.iconSize}}\" type=\"button\" name=\"paginationSwitch\" title=\"{{options.formatPaginationSwitch()}}\" v-on:click=\"togglePagination\" _v-0c3612d6=\"\">\n                    <i class=\"{{options.iconsPrefix}} {{paginationSwitchIcon}}\" _v-0c3612d6=\"\"></i>\n                </button>\n                <button v-if=\"options.showRefresh\" class=\"btn btn-{{options.buttonsClass}} btn-{{options.iconSize}}\" type=\"button\" name=\"refresh\" title=\"{{options.formatRefresh()}}\" v-on:click=\"refresh\" _v-0c3612d6=\"\">\n                    <i class=\"{{options.iconsPrefix}} {{options.icons.refresh}}\" _v-0c3612d6=\"\"></i>\n                </button>\n                <button v-if=\"options.showToggle\" class=\"btn btn-{{options.buttonsClass}} btn-{{options.iconSize}}\" type=\"button\" name=\"toggle\" title=\"{{options.formatToggle()}}\" v-on:click=\"toggleView\" _v-0c3612d6=\"\">\n                    <i class=\"{{options.iconsPrefix}} {{options.icons.toggle}}\" _v-0c3612d6=\"\"></i>\n                </button>\n                <div v-if=\"options.showColumns\" class=\"keep-open btn-group\" title=\"{{this.options.formatColumns()}}\" _v-0c3612d6=\"\">\n                    <button type=\"button\" data-toggle=\"dropdown\" class=\"btn btn-{{options.buttonsClass}} btn-{{options.iconSize}} dropdown-toggle\" _v-0c3612d6=\"\">\n                        <i class=\"{{options.iconsPrefix}} {{options.icons.columns}}\" _v-0c3612d6=\"\"></i> <span class=\"caret\" _v-0c3612d6=\"\"></span>\n                    </button>\n                    <ul class=\"dropdown-menu\" role=\"menu\" _v-0c3612d6=\"\">\n                        <li v-for=\"(i, column) in fieldColumns\" v-on:click.stop=\"\" _v-0c3612d6=\"\">\n                            <label v-if=\"!(column.radio || column.checkbox || options.cardView &amp;&amp; !column.cardVisible)\" _v-0c3612d6=\"\">\n                                <input type=\"checkbox\" data-field=\"{{column.filed}}\" :disabled=\"toggleColumnsCount <= options.minimumCountColumns &amp;&amp; column.visible\" v-model=\"column.visible\" _v-0c3612d6=\"\"> {{column.title}}\n                            </label>\n                        </li>\n                    </ul>\n                </div>\n            </div>\n            <div v-if=\"options.search\" class=\"pull-{{options.searchAlign}} search\" _v-0c3612d6=\"\">\n                <input class=\"form-control input-{{options.iconSize}}\" type=\"text\" placeholder=\"{{options.formatSearch()}}\" v-model=\"searchText\" v-on:keyup=\"search($event)\" _v-0c3612d6=\"\">\n            </div>\n        </div>\n        <div class=\"fixed-table-container\" v-bind:style=\"{'padding-bottom': (options.height ? view.headerHeight : 0) + 'px', height: options.height + 'px'}\" _v-0c3612d6=\"\">\n            <div class=\"fixed-table-header\" v-if=\"options.showHeader &amp;&amp; !options.cardView &amp;&amp; options.height\" _v-0c3612d6=\"\">\n                <table class=\"{{options.classes}}\" _v-0c3612d6=\"\">\n                    <thead _v-0c3612d6=\"\">\n                        <tr v-for=\"_columns in columns\" _v-0c3612d6=\"\">\n                            <th v-if=\"!options.cardView &amp;&amp; options.detailView\" class=\"detail\" rowspan=\"columns.length\" _v-0c3612d6=\"\">\n                                <div class=\"fht-cell\" _v-0c3612d6=\"\"></div>\n                            </th>\n                            <template v-for=\"column in _columns\">\n                            <th v-if=\"!(!column.visible || options.cardView &amp;&amp; !column.cardVisible)\" title=\"{{{column.titleTooltip}}}\" v-bind:class=\"[{'bs-checkbox': column.checkbox || column.radio}, column.class]\" v-bind:style=\"column.style\" rowspan=\"{{column.rowspan}}\" colspan=\"{{column.colspan}}\" data-field=\"{{column.field}}\" tabindex=\"0\" _v-0c3612d6=\"\">\n                                <div class=\"th-inner\" v-bind:class=\"[{sortable: options.sortable &amp;&amp; column.sortable}, options.sortName == column.field ? options.sortOrder : 'both']\" v-on:click=\"onSort(column)\" v-on:keypress.enter=\"onSort(column)\" _v-0c3612d6=\"\">\n\n                                    <input v-if=\"column.checkbox &amp;&amp; !options.singleSelect &amp;&amp; options.checkboxHeader\" name=\"btSelectAll\" type=\"checkbox\" v-model=\"selected.all\" v-on:change=\"onCheckAllChange\" _v-0c3612d6=\"\">\n\n                                    <template v-if=\"!column.checkbox &amp;&amp; !column.radio\">\n                                    {{column.title}}\n                                    </template>\n                                </div>\n                                <div class=\"fht-cell\" _v-0c3612d6=\"\"></div>\n                            </th>\n                            </template>\n                        </tr>\n                    </thead>\n                </table>\n            </div>\n            <div class=\"fixed-table-body\" _v-0c3612d6=\"\">\n                <div v-if=\"loading\" class=\"fixed-table-loading\" v-bind:style=\"{top: view.headerHeight + 1 + 'px'}\" _v-0c3612d6=\"\">\n                    <div class=\"fixed-table-loading-bg\" _v-0c3612d6=\"\"></div>\n                    <div class=\"fixed-table-loading-text\" _v-0c3612d6=\"\">\n                        {{options.formatLoadingMessage()}}\n                    </div>\n                </div>\n                <table class=\"{{options.classes}}\" _v-0c3612d6=\"\">\n                    <thead v-if=\"options.showHeader &amp;&amp; !options.cardView &amp;&amp; !options.height\" _v-0c3612d6=\"\">\n                        <tr v-for=\"_columns in columns\" _v-0c3612d6=\"\">\n                            <th v-if=\"!options.cardView &amp;&amp; options.detailView\" class=\"detail\" rowspan=\"columns.length\" _v-0c3612d6=\"\">\n                                <div class=\"fht-cell\" _v-0c3612d6=\"\"></div>\n                            </th>\n                            <template v-for=\"column in _columns\">\n                            <th v-if=\"!(!column.visible || options.cardView &amp;&amp; !column.cardVisible)\" title=\"{{column.titleTooltip}}\" v-bind:class=\"[{'bs-checkbox': column.checkbox || column.radio}, column.class]\" v-bind:style=\"column.style\" rowspan=\"{{column.rowspan}}\" colspan=\"{{column.colspan}}\" data-field=\"{{column.field}}\" tabindex=\"0\" _v-0c3612d6=\"\">\n                                <div class=\"th-inner\" v-bind:class=\"[{sortable: options.sortable &amp;&amp; column.sortable}, options.sortName == column.field ? options.sortOrder : 'both']\" v-on:click=\"onSort(column)\" v-on:keypress.enter=\"onSort(column)\" _v-0c3612d6=\"\">\n\n                                    <input v-if=\"column.checkbox &amp;&amp; !options.singleSelect &amp;&amp; options.checkboxHeader\" name=\"btSelectAll\" type=\"checkbox\" v-model=\"selected.all\" v-on:change=\"onCheckAllChange\" _v-0c3612d6=\"\">\n\n                                    <template v-if=\"!column.checkbox &amp;&amp; !column.radio\">\n                                    {{column.title}}\n                                    </template>\n                                </div>\n                                <div class=\"fht-cell\" _v-0c3612d6=\"\"></div>\n                            </th>\n                            </template>\n                        </tr>\n                    </thead>\n                    <tbody _v-0c3612d6=\"\">\n                        <tr v-for=\"(i, item) in renderData\" v-bind:class=\"class\" data-index=\"{{i}}\" data-uniqueid=\"{{item[options.uniqueId]}}\" _v-0c3612d6=\"\">\n\n                            <template v-if=\"!options.cardView &amp;&amp; options.detailView\">\n                            <td _v-0c3612d6=\"\">\n                                <a class=\"detail-icon\" href=\"javascript:\" _v-0c3612d6=\"\">\n                                    <i v-bind:class=\"[options.iconsPrefix, icons.detailOpen]\" _v-0c3612d6=\"\"></i>\n                                </a>\n                            </td>\n                            </template>\n\n                            <template v-if=\"options.cardView\">\n                            <td colspan=\"{{header.fields.length}}\" _v-0c3612d6=\"\">\n                                <div class=\"card-views\" _v-0c3612d6=\"\">\n                                    <div v-for=\"(j, field) in header.fields\" class=\"card-view\" v-bind:class=\"fieldColumns[j].class\" _v-0c3612d6=\"\">\n                                        <template v-if=\"!(!fieldColumns[j].visible || options.cardView &amp;&amp; !fieldColumns[j].cardVisible)\">\n                                            <input v-if=\"fieldColumns[j].checkbox || fieldColumns[j].radio\" name=\"{{options.selectItemName}}\" v-bind:value=\"item\" v-model=\"selected.items\" v-on:change=\"onCheckItemChange(item)\" v-bind:type=\"fieldColumns[j].checkbox ? 'checkbox' : 'radio'\" _v-0c3612d6=\"\">\n                                            <div v-else=\"\" class=\"card-view\" _v-0c3612d6=\"\">\n                                                <span v-if=\"options.showHeader\" class=\"title\" _v-0c3612d6=\"\">\n                                                    {{fieldColumns[j].title}}\n                                                </span>\n                                                <span class=\"value\" _v-0c3612d6=\"\">\n                                                    {{{item | fieldValue field i j}}}\n                                                </span>\n                                            </div>\n                                        </template>\n                                    </div>\n                                </div>\n                            </td>\n                            </template>\n\n                            <template v-else=\"\">\n                                <template v-for=\"(j, field) in header.fields\">\n                                    <template v-if=\"!(!fieldColumns[j].visible || options.cardView &amp;&amp; !fieldColumns[j].cardVisible)\">\n                                        <td v-if=\"fieldColumns[j].checkbox || fieldColumns[j].radio\" class=\"bs-checkbox\" v-bind:class=\"fieldColumns[j].class\" _v-0c3612d6=\"\">\n                                            <input name=\"{{options.selectItemName}}\" v-bind:value=\"item\" v-model=\"selected.items\" v-on:change=\"onCheckItemChange(item)\" v-bind:type=\"fieldColumns[j].checkbox ? 'checkbox' : 'radio'\" _v-0c3612d6=\"\">\n                                        </td>\n                                        <td v-else=\"\" v-on:click=\"onTdClick(item, fieldColumns[j].field, $event)\" v-on:dblclick=\"onTdClick(item, fieldColumns[j].field, $event)\" _v-0c3612d6=\"\">\n                                            {{{item | fieldValue field i j}}}\n                                        </td>\n                                    </template>\n                                </template>\n                            </template>\n                        </tr>\n                        <tr v-if=\"!renderData.length\" class=\"no-records-found\" _v-0c3612d6=\"\">\n                            <td colspan=\"{{columnsLength + 1}}\" _v-0c3612d6=\"\">\n                                {{options.formatNoMatches()}}\n                            </td>\n                        </tr>\n                    </tbody>\n                </table>\n            </div>\n            <div v-if=\"options.pagination\" class=\"fixed-table-pagination\" _v-0c3612d6=\"\">\n                <div class=\"pull-{{options.paginationDetailHAlign}} pagination-detail\" _v-0c3612d6=\"\">\n                    <span class=\"pagination-info\" _v-0c3612d6=\"\">\n                        <template v-if=\"options.onlyInfoPagination\">\n                        {{options.formatDetailPagination(options.totalRows)}}\n                        </template>\n                        <template v-else=\"\">\n                        {{options.formatShowingRows(pageFrom, pageTo, options.totalRows)}}\n                        </template>\n                    </span>\n                    <span v-if=\"!options.onlyInfoPagination\" class=\"page-list\" _v-0c3612d6=\"\">\n                        {{options.formatRecordsPerPage('pageNumber').split('pageNumber')[0]}}\n                        <span class=\"btn-group {{options.paginationVAlign == 'top' || options.paginationVAlign == 'both' ? 'dropdown' : 'dropup'}}\" _v-0c3612d6=\"\">\n                            <button type=\"button\" class=\"btn btn-{{options.buttonsClass}} btn-{{options.iconSize}} dropdown-toggle\" data-toggle=\"dropdown\" _v-0c3612d6=\"\">\n                                <span class=\"page-size\" _v-0c3612d6=\"\">\n                                    {{options.pageSize === options.totalRows ? options.formatAllRows() : options.pageSize}}\n                                </span> <span class=\"caret\" _v-0c3612d6=\"\"></span>\n                            </button>\n                            <ul class=\"dropdown-menu\" role=\"menu\" _v-0c3612d6=\"\">\n                                <li v-bind:class=\"{active: page == options.formatAllRows() || page == options.pageSize}\" v-for=\"page in options.pageList\" v-on:click=\"onPageListChange\" _v-0c3612d6=\"\">\n                                    <a href=\"javascript:\" _v-0c3612d6=\"\">{{page}}</a>\n                                </li>\n                            </ul>\n                        </span> {{options.formatRecordsPerPage('pageNumber').split('pageNumber')[1]}}\n                    </span>\n                </div>\n                <div v-if=\"totalPages > 1\" class=\"pull-{{options.paginationHAlign}} pagination\" _v-0c3612d6=\"\">\n                    <ul class=\"pagination pagination-{{options.iconSize}}\" _v-0c3612d6=\"\">\n                        <li class=\"page-pre\" v-on:click=\"onPagePre\" _v-0c3612d6=\"\">\n                            <a href=\"javascript:\" _v-0c3612d6=\"\">{{{options.paginationPreText}}}</a>\n                        </li>\n                        <li v-if=\"pageInfo.first\" class=\"page-first\" v-bind:class=\"{active: 1 == options.pageNumber}\" v-on:click=\"onPageFirst\" _v-0c3612d6=\"\">\n                            <a href=\"javascript:\" _v-0c3612d6=\"\">1</a>\n                        </li>\n                        <li v-if=\"pageInfo.firstSeparator\" class=\"page-first-separator disabled\" _v-0c3612d6=\"\">\n                            <a href=\"javascript:\" _v-0c3612d6=\"\">...</a>\n                        </li>\n                        <li class=\"page-number\" v-bind:class=\"{active: i == this.options.pageNumber}\" v-for=\"i in pageInfo.list\" v-on:click=\"onPageNumber\" _v-0c3612d6=\"\">\n                            <a href=\"javascript:\" _v-0c3612d6=\"\">{{i}}</a>\n                        </li>\n                        <li v-if=\"pageInfo.lastSeparator\" class=\"page-last-separator disabled\" _v-0c3612d6=\"\">\n                            <a href=\"javascript:\" _v-0c3612d6=\"\">...</a>\n                        </li>\n                        <li v-if=\"pageInfo.last\" class=\"page-last\" v-bind:class=\"{active: totalPages == options.pageNumber}\" v-on:click=\"onPageLast\" _v-0c3612d6=\"\">\n                            <a href=\"javascript:\" _v-0c3612d6=\"\">{{totalPages}}</a>\n                        </li>\n                        <li class=\"page-next\" v-on:click=\"onPageNext\" _v-0c3612d6=\"\">\n                            <a href=\"javascript:\" _v-0c3612d6=\"\">{{{options.paginationNextText}}}</a>\n                        </li>\n                    </ul>\n                </div>\n            </div>\n        </div>\n        <div class=\"clearfix\" _v-0c3612d6=\"\"></div>\n    </div>\n</span>\n"
if (module.hot) {(function () {  module.hot.accept()
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), true)
  if (!hotAPI.compatible) return
  module.hot.dispose(function () {
    __vueify_insert__.cache["\n/*added by lem93*/\n.disable-table[_v-0c3612d6]{\n    pointer-events:none;\n    background-color: white;\n    filter:alpha(opacity=50); /* IE */\n    opacity: 0.5; /* Safari, Opera */\n    -moz-opacity:0.50; /* FireFox */\n    z-index: 20;\n    height: 100%;\n    width: 100%;\n    background-repeat:no-repeat;\n    background-position:center;\n    position:absolute;\n    top: 0px;\n    left: 0px;\n}\n\n.bootstrap-table .table[_v-0c3612d6] {\n    margin-bottom: 0 !important;\n    border-bottom: 1px solid #dddddd;\n    border-collapse: collapse !important;\n    border-radius: 1px;\n}\n\n.bootstrap-table .table[_v-0c3612d6]:not(.table-condensed),\n.bootstrap-table .table:not(.table-condensed) > tbody > tr > th[_v-0c3612d6],\n.bootstrap-table .table:not(.table-condensed) > tfoot > tr > th[_v-0c3612d6],\n.bootstrap-table .table:not(.table-condensed) > thead > tr > td[_v-0c3612d6],\n.bootstrap-table .table:not(.table-condensed) > tbody > tr > td[_v-0c3612d6],\n.bootstrap-table .table:not(.table-condensed) > tfoot > tr > td[_v-0c3612d6] {\n    padding: 8px;\n}\n\n.bootstrap-table .table.table-no-bordered > thead > tr > th[_v-0c3612d6],\n.bootstrap-table .table.table-no-bordered > tbody > tr > td[_v-0c3612d6] {\n    border-right: 2px solid transparent;\n}\n\n.bootstrap-table .table.table-no-bordered > tbody > tr > td[_v-0c3612d6]:last-child {\n    border-right: none;\n}\n\n.fixed-table-container[_v-0c3612d6] {\n    position: relative;\n    clear: both;\n    border: 1px solid #dddddd;\n    border-radius: 4px;\n    -webkit-border-radius: 4px;\n    -moz-border-radius: 4px;\n}\n\n.fixed-table-container.table-no-bordered[_v-0c3612d6] {\n    border: 1px solid transparent;\n}\n\n.fixed-table-footer[_v-0c3612d6],\n.fixed-table-header[_v-0c3612d6] {\n    overflow: hidden;\n}\n\n.fixed-table-footer[_v-0c3612d6] {\n    border-top: 1px solid #dddddd;\n}\n\n.fixed-table-body[_v-0c3612d6] {\n    overflow-x: auto;\n    overflow-y: auto;\n    height: 100%;\n}\n\n.fixed-table-container table[_v-0c3612d6] {\n    width: 100%;\n}\n\n.fixed-table-container thead th[_v-0c3612d6] {\n    height: 0;\n    padding: 0;\n    margin: 0;\n    border-left: 1px solid #dddddd;\n}\n\n.fixed-table-container thead th[_v-0c3612d6]:focus {\n    outline: 0 solid transparent;\n}\n\n.fixed-table-container thead th[_v-0c3612d6]:first-child {\n    border-left: none;\n    border-top-left-radius: 4px;\n    -webkit-border-top-left-radius: 4px;\n    -moz-border-radius-topleft: 4px;\n}\n\n.fixed-table-container thead th .th-inner[_v-0c3612d6],\n.fixed-table-container tbody td .th-inner[_v-0c3612d6] {\n    padding: 8px;\n    line-height: 24px;\n    vertical-align: top;\n    overflow: hidden;\n    text-overflow: ellipsis;\n    white-space: nowrap;\n}\n\n.fixed-table-container thead th .sortable[_v-0c3612d6] {\n    cursor: pointer;\n    background-position: right;\n    background-repeat: no-repeat;\n    padding-right: 30px;\n}\n\n.fixed-table-container thead th .sortable.both[_v-0c3612d6] {\n    background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABMAAAATCAQAAADYWf5HAAAAkElEQVQoz7X QMQ5AQBCF4dWQSJxC5wwax1Cq1e7BAdxD5SL+Tq/QCM1oNiJidwox0355mXnG/DrEtIQ6azioNZQxI0ykPhTQIwhCR+BmBYtlK7kLJYwWCcJA9M4qdrZrd8pPjZWPtOqdRQy320YSV17OatFC4euts6z39GYMKRPCTKY9UnPQ6P+GtMRfGtPnBCiqhAeJPmkqAAAAAElFTkSuQmCC');\n}\n\n.fixed-table-container thead th .sortable.asc[_v-0c3612d6] {\n    background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABMAAAATCAYAAAByUDbMAAAAZ0lEQVQ4y2NgGLKgquEuFxBPAGI2ahhWCsS/gDibUoO0gPgxEP8H4ttArEyuQYxAPBdqEAxPBImTY5gjEL9DM+wTENuQahAvEO9DMwiGdwAxOymGJQLxTyD+jgWDxCMZRsEoGAVoAADeemwtPcZI2wAAAABJRU5ErkJggg==');\n}\n\n.fixed-table-container thead th .sortable.desc[_v-0c3612d6] {\n    background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABMAAAATCAYAAAByUDbMAAAAZUlEQVQ4y2NgGAWjYBSggaqGu5FA/BOIv2PBIPFEUgxjB+IdQPwfC94HxLykus4GiD+hGfQOiB3J8SojEE9EM2wuSJzcsFMG4ttQgx4DsRalkZENxL+AuJQaMcsGxBOAmGvopk8AVz1sLZgg0bsAAAAASUVORK5CYII= ');\n}\n\n.fixed-table-container th.detail[_v-0c3612d6] {\n    width: 30px;\n}\n\n.fixed-table-container tbody td[_v-0c3612d6] {\n    border-left: 1px solid #dddddd;\n}\n\n.fixed-table-container tbody tr:first-child td[_v-0c3612d6] {\n    border-top: none;\n}\n\n.fixed-table-container tbody td[_v-0c3612d6]:first-child {\n    border-left: none;\n}\n\n/* the same color with .active */\n.fixed-table-container tbody .selected td[_v-0c3612d6] {\n    background-color: #f5f5f5;\n}\n\n.fixed-table-container .bs-checkbox[_v-0c3612d6] {\n    text-align: center;\n}\n\n.fixed-table-container .bs-checkbox .th-inner[_v-0c3612d6] {\n    padding: 8px 0;\n}\n\n.fixed-table-container input[type=\"radio\"][_v-0c3612d6],\n.fixed-table-container input[type=\"checkbox\"][_v-0c3612d6] {\n    margin: 0 auto !important;\n}\n\n.fixed-table-container .no-records-found[_v-0c3612d6] {\n    text-align: center;\n}\n\n.fixed-table-pagination div.pagination[_v-0c3612d6],\n.fixed-table-pagination .pagination-detail[_v-0c3612d6] {\n    margin-top: 10px;\n    margin-bottom: 10px;\n}\n\n.fixed-table-pagination div.pagination .pagination[_v-0c3612d6] {\n    margin: 0;\n}\n\n.fixed-table-pagination .pagination a[_v-0c3612d6] {\n    padding: 6px 12px;\n    line-height: 1.428571429;\n}\n\n.fixed-table-pagination .pagination-info[_v-0c3612d6] {\n    line-height: 34px;\n    margin-right: 5px;\n}\n\n.fixed-table-pagination .btn-group[_v-0c3612d6] {\n    position: relative;\n    display: inline-block;\n    vertical-align: middle;\n}\n\n.fixed-table-pagination .dropup .dropdown-menu[_v-0c3612d6] {\n    margin-bottom: 0;\n}\n\n.fixed-table-pagination .page-list[_v-0c3612d6] {\n    display: inline-block;\n}\n\n.fixed-table-toolbar .columns-left[_v-0c3612d6] {\n    margin-right: 5px;\n}\n\n.fixed-table-toolbar .columns-right[_v-0c3612d6] {\n    margin-left: 5px;\n}\n\n.fixed-table-toolbar .columns label[_v-0c3612d6] {\n    display: block;\n    padding: 3px 20px;\n    clear: both;\n    font-weight: normal;\n    line-height: 1.428571429;\n}\n\n.fixed-table-toolbar .bs-bars[_v-0c3612d6],\n.fixed-table-toolbar .search[_v-0c3612d6],\n.fixed-table-toolbar .columns[_v-0c3612d6] {\n    position: relative;\n    margin-top: 10px;\n    margin-bottom: 10px;\n    line-height: 34px;\n}\n\n.fixed-table-pagination li.disabled a[_v-0c3612d6] {\n    pointer-events: none;\n    cursor: default;\n}\n\n.fixed-table-loading[_v-0c3612d6] {\n    position: absolute;\n    right: 0;\n    top: 0;\n    bottom: 0;\n    left: 0;\n    z-index: 99;\n}\n\n.fixed-table-loading-bg[_v-0c3612d6] {\n    position: absolute;\n    width: 100%;\n    height: 100%;\n    opacity: 0.9;\n    background-color: #fff;\n}\n\n.fixed-table-loading-text[_v-0c3612d6]:before {\n    content: '';\n    display: inline-block;\n    height: 100%;\n    vertical-align: middle;\n}\n\n.fixed-table-loading-text[_v-0c3612d6] {\n    position: absolute;\n    width: 100%;\n    height: 100%;\n    display: inline-block;\n    text-align: center;\n    vertical-align: middle;\n}\n\n.fixed-table-body .card-view .title[_v-0c3612d6] {\n    font-weight: bold;\n    display: inline-block;\n    min-width: 30%;\n    text-align: left !important;\n}\n\n/* support bootstrap 2 */\n.fixed-table-body thead th .th-inner[_v-0c3612d6] {\n    box-sizing: border-box;\n}\n\n.table th[_v-0c3612d6], .table td[_v-0c3612d6] {\n    vertical-align: middle;\n    box-sizing: border-box;\n}\n\n.fixed-table-toolbar .dropdown-menu[_v-0c3612d6] {\n    text-align: left;\n    max-height: 300px;\n    overflow: auto;\n}\n\n.fixed-table-toolbar .btn-group > .btn-group[_v-0c3612d6] {\n    display: inline-block;\n    margin-left: -1px !important;\n}\n\n.fixed-table-toolbar .btn-group > .btn-group > .btn[_v-0c3612d6] {\n    border-radius: 0;\n}\n\n.fixed-table-toolbar .btn-group > .btn-group:first-child > .btn[_v-0c3612d6] {\n    border-top-left-radius: 4px;\n    border-bottom-left-radius: 4px;\n}\n\n.fixed-table-toolbar .btn-group > .btn-group:last-child > .btn[_v-0c3612d6] {\n    border-top-right-radius: 4px;\n    border-bottom-right-radius: 4px;\n}\n\n.bootstrap-table .table > thead > tr > th[_v-0c3612d6] {\n    vertical-align: bottom;\n    border-bottom: 1px solid #ddd;\n}\n\n/* support bootstrap 3 */\n.bootstrap-table .table thead > tr > th[_v-0c3612d6] {\n    padding: 0;\n    margin: 0;\n}\n\n.bootstrap-table .fixed-table-footer tbody > tr > td[_v-0c3612d6] {\n    padding: 0 !important;\n}\n\n.bootstrap-table .fixed-table-footer .table[_v-0c3612d6] {\n    border-bottom: none;\n    border-radius: 0;\n    padding: 0 !important;\n}\n\n.pull-right .dropdown-menu[_v-0c3612d6] {\n    right: 0;\n    left: auto;\n}\n\n/* calculate scrollbar width */\np.fixed-table-scroll-inner[_v-0c3612d6] {\n    width: 100%;\n    height: 200px;\n}\n\ndiv.fixed-table-scroll-outer[_v-0c3612d6] {\n    top: 0;\n    left: 0;\n    visibility: hidden;\n    width: 200px;\n    height: 150px;\n    overflow: hidden;\n}\n"] = false
    document.head.removeChild(__vueify_style__)
  })
  if (!module.hot.data) {
    hotAPI.createRecord("_v-0c3612d6", module.exports)
  } else {
    hotAPI.update("_v-0c3612d6", module.exports, (typeof module.exports === "function" ? module.exports.options : module.exports).template)
  }
})()}
},{"babel-runtime/core-js/get-iterator":1,"babel-runtime/core-js/json/stringify":2,"babel-runtime/core-js/object/keys":3,"babel-runtime/helpers/typeof":6,"vue":85,"vue-hot-reload-api":84,"vueify/lib/insert-css":86}],93:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
    value: true
});
exports.default = {
    props: ['type', 'message', 'active'],
    data: function data() {
        return {};
    },

    methods: {
        close: function close() {
            this.active = false;
        }
    }
};
if (module.exports.__esModule) module.exports = module.exports.default
;(typeof module.exports === "function"? module.exports.options: module.exports).template = "\n<div v-if=\"active\" class=\"alert alert-{{ type }} alert-fill alert-close fade in\" role=\"alert\">\n\t<button type=\"button\" @click=\"close\" class=\"close\" aria-label=\"Close\">\n\t\t<span aria-hidden=\"true\">×</span>\n\t</button>\n\t<span>{{ message }}</span>\n</div>\n"
if (module.hot) {(function () {  module.hot.accept()
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), true)
  if (!hotAPI.compatible) return
  if (!module.hot.data) {
    hotAPI.createRecord("_v-266d0912", module.exports)
  } else {
    hotAPI.update("_v-266d0912", module.exports, (typeof module.exports === "function" ? module.exports.options : module.exports).template)
  }
})()}
},{"vue":85,"vue-hot-reload-api":84}],94:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
	value: true
});

var _alert = require('./alert.vue');

var _alert2 = _interopRequireDefault(_alert);

var _BootstrapTable = require('./BootstrapTable.vue');

var _BootstrapTable2 = _interopRequireDefault(_BootstrapTable);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
	props: ['columns', 'button', 'toolbarSwitch', 'clickUrl', 'tableUrl'],
	components: {
		alert: _alert2.default,
		BootstrapTable: _BootstrapTable2.default
	},
	data: function data() {
		return {
			// alert
			alertMessage: '',
			alertActive: false,

			data: [],
			tableOptions: {
				iconsPrefix: 'font-icon',
				toggle: 'table',
				sidePagination: 'client',
				pagination: 'true',
				classes: 'table',
				icons: {
					paginationSwitchDown: 'font-icon-arrow-square-down',
					paginationSwitchUp: 'font-icon-arrow-square-down up',
					refresh: 'font-icon-refresh',
					toggle: 'font-icon-list-square',
					columns: 'font-icon-list-rotate',
					export: 'font-icon-download'
				},
				paginationPreText: '<i class="font-icon font-icon-arrow-left"></i>',
				paginationNextText: '<i class="font-icon font-icon-arrow-right"></i>',
				pageSize: 10,
				pageList: [5, 10, 20],
				search: true,
				showExport: true,
				exportTypes: ['excel', 'pdf'],
				minimumCountColumns: 2,
				showFooter: false,

				uniqueId: 'id',
				idField: 'id'
			}
		};
	},

	events: {
		rowClicked: function rowClicked(id) {
			window.location = Laravel.url + this.clickUrl + id;
		}
	},
	methods: {
		getList: function getList(finished) {
			var _this = this;

			var listUrl = Laravel.url + this.tableUrl;
			if (this.toolbarSwitch) {
				listUrl = Laravel.url + this.tableUrl + (finished ? 1 : 0);
			}
			this.$broadcast('disableTable');
			this.$http.get(listUrl).then(function (response) {
				_this.data = response.data;
				_this.validationErrors = {};
				_this.$broadcast('refreshTable');
			}, function (response) {
				_this.alertMessage = "The information could not be retrieved, please try again.";
				_this.alertActive = true;
				_this.$broadcast('enableTable');
			});
		},
		goToCreate: function goToCreate() {
			window.location = Laravel.url + this.clickUrl + 'create';
		}
	},
	ready: function ready() {
		if (this.toolbarSwitch) {
			this.getList(this.toolbarSwitch.checked);
			this.getList(this.toolbarSwitch.checked);
		} else {
			this.getList();
			this.getList();
		}
	}
};
if (module.exports.__esModule) module.exports = module.exports.default
;(typeof module.exports === "function"? module.exports.options: module.exports).template = "\n\n\t<bootstrap-table :columns=\"columns\" :data=\"data\" :options=\"tableOptions\">\n\t    <alert type=\"danger\" :message=\"alertMessage\" :active=\"alertActive\"></alert>\n\n        <button v-if=\"button\" type=\"button\" class=\"btn btn-primary\" @click=\"goToCreate\">\n\t\t\t<i :class=\"button.icon\"></i>&nbsp;&nbsp;&nbsp;{{ button.name }}\n\t\t</button>\n\n        <div v-if=\"toolbarSwitch\" class=\"checkbox-toggle\" style=\"display:inline;left:30px;\">\n\t\t\t<input type=\"checkbox\" id=\"toolbarSwitch\" v-model=\"toolbarSwitch.checked\" @click=\"getList(!toolbarSwitch.checked)\">\n\t\t\t<label for=\"toolbarSwitch\">{{ toolbarSwitch.name }}</label>\n\t\t</div>\n    </bootstrap-table>\n\n"
if (module.hot) {(function () {  module.hot.accept()
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), true)
  if (!hotAPI.compatible) return
  if (!module.hot.data) {
    hotAPI.createRecord("_v-1ef8c711", module.exports)
  } else {
    hotAPI.update("_v-1ef8c711", module.exports, (typeof module.exports === "function" ? module.exports.options : module.exports).template)
  }
})()}
},{"./BootstrapTable.vue":92,"./alert.vue":93,"vue":85,"vue-hot-reload-api":84}],95:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
    value: true
});

var _indexTable = require('./indexTable.vue');

var _indexTable2 = _interopRequireDefault(_indexTable);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
    components: {
        indexTable: _indexTable2.default
    },
    data: function data() {
        return {
            columns: [{
                field: 'id',
                title: '#',
                sortable: true
            }, {
                field: 'name',
                title: 'Name',
                sortable: true
            }, {
                field: 'address',
                title: 'Address',
                sortable: true
            }, {
                field: 'serviceDays',
                title: 'Service Days',
                sortable: true
            }, {
                field: 'chemicals',
                title: 'Chemicals',
                sortable: true
            }, {
                field: 'price',
                title: 'Price',
                sortable: true,
                visible: true
            }]
        };
    }
};
if (module.exports.__esModule) module.exports = module.exports.default
;(typeof module.exports === "function"? module.exports.options: module.exports).template = "\n\n\t<index-table :columns=\"columns\" :button=\"{ icon: 'font-icon font-icon-home', name: 'New Service' }\" :toolbar-switch=\"{ checked: true, name: 'Active Contract' }\" click-url=\"services/\" table-url=\"datatables/services?status=\">\n    </index-table>\n\n"
if (module.hot) {(function () {  module.hot.accept()
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), true)
  if (!hotAPI.compatible) return
  if (!module.hot.data) {
    hotAPI.createRecord("_v-6a76754e", module.exports)
  } else {
    hotAPI.update("_v-6a76754e", module.exports, (typeof module.exports === "function" ? module.exports.options : module.exports).template)
  }
})()}
},{"./indexTable.vue":94,"vue":85,"vue-hot-reload-api":84}],96:[function(require,module,exports){
'use strict';

var _vue = require('vue');

var _vue2 = _interopRequireDefault(_vue);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var dateFormat = require('dateformat');

// Vue imports


// var Spinner         = require("spin");
// var Gmaps           = require("gmaps.core");
// require("gmaps.markers");
// var Dropzone 		= require("dropzone");
// var swal 			= require("sweetalert");
// var bootstrapToggle = require("bootstrap-toggle");
// var locationPicker  = require("jquery-locationpicker");
// Vue.use(require('vue-resource'));

$(document).ready(function () {
	// var dateFormat = require('dateformat');

	// set th CSRF_TOKEN for ajax requests
	// $.ajaxSetup({
	//     headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
	// });
	// Vue.http.headers.common['X-CSRF-TOKEN'] = $('meta[name="csrf-token"]').attr('content');


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
    VueJs code
    ========================================================================== */

	// let Permissions 	 = require('./components/Permissions.vue');
	// let PhotoList 	     = require('./components/photoList.vue');
	// let FormToAjax   	= require('./directives/FormToAjax.vue');
	// let countries       = require('./components/countries.vue');
	// let dropdown       = require('./components/dropdown.vue');
	// let alert       = require('./components/alert.vue');
	// let billing       = require('./components/billing.vue');
	// let contract       = require('./components/contract.vue');
	// let chemical       = require('./components/chemical.vue');
	// let equipment       = require('./components/equipment.vue');
	// let works       = require('./components/works.vue');
	// let payments       = require('./components/payments.vue');
	// let routeTable     = require('./components/routeTable.vue');
	// let notificationsWidget     = require('./components/notificationsWidget.vue');
	// let AllNotificationsAsReadButton = require('./components/AllNotificationsAsReadButton.vue');
	// let workOrderPhotosShow = require('./components/workOrderPhotosShow.vue');
	// let workOrderPhotosEdit = require('./components/workOrderPhotosEdit.vue');
	// let finishWorkOrderButton = require('./components/finishWorkOrderButton.vue');
	// let deleteButton = require('./components/deleteButton.vue');
	// let addressFields = require('./components/addressFields.vue');
	// let missingServices = require('./components/missingServices.vue');
	// let settings = require('./components/settings.vue');
	// let profile = require('./components/profile.vue');
	// let workOrderTable = require('./components/workOrderTable.vue');
	var serviceTable = require('./components/serviceTable.vue');
	// let clientTable = require('./components/clientTable.vue');
	// let supervisorTable = require('./components/supervisorTable.vue');
	// let technicianTable = require('./components/technicianTable.vue');
	// let invoiceTable = require('./components/invoiceTable.vue');
	// let photo = require('./components/photo.vue');
	// let editReportPhotos = require('./components/editReportPhotos.vue');
	// let timezoneDropdown = require('./components/timezoneDropdown.vue');
	// let emailVerificationNotice = require('./components/emailVerificationNotice.vue');


	var mainVue = new _vue2.default({
		el: 'body',
		components: {
			// // header
			// notificationsWidget,
			// // generic
			// alert,
			// dropdown,
			// PhotoList,
			// photo,
			// deleteButton,
			// timezoneDropdown,
			// emailVerificationNotice,
			// // notifications
			// AllNotificationsAsReadButton,
			// // settings
			// Permissions,
			// billing,
			// settings,
			// profile,
			// // work orders
			// workOrderTable,
			// workOrderPhotosShow,
			// workOrderPhotosEdit,
			// finishWorkOrderButton,
			// works,
			// // report
			// missingServices,
			// editReportPhotos,
			// // service
			serviceTable: serviceTable
		}
	});

	/* ==========================================================================
 Tables
 ========================================================================== */

	var generic_table = $('.generic_table');

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

	$('.generic_table').on('click-row.bs.table', function (e, row, $element) {
		if ($element.hasClass('table_active')) {
			$element.removeClass('table_active');
		} else {
			generic_table.find('tr.table_active').removeClass('table_active');
			$element.addClass('table_active');
		}
		window.location.href = back.click_url + row.id;
	});

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
			mainVue.$broadcast('datePickerClicked', date_selected);
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

},{"./components/serviceTable.vue":95,"dateformat":80,"vue":85}]},{},[90,88,87,89,91,96]);

//# sourceMappingURL=bundle.js.map
