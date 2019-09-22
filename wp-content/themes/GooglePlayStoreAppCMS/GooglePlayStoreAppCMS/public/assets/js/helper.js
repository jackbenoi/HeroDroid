
/**
 * Act as our Helpers for all our projects.
 *
 * @class Helpers
 * @package Base Helper Class
 * @author Anthony Pillos <dev.anthonypillos@gmail.com>
 */

(function() {
  var Helpers;

  Helpers = (function() {
    Helpers.prototype.isDebug = true;

    Helpers.prototype.obj = {};

    function Helpers() {
      this.obj.startSymbol = '{{';
      this.obj.endSymbol = '}}';
    }

    Helpers.prototype.log = function(msg) {
      if (this.isDebug) {
        return console.log(msg);
      }
    };

    Helpers.prototype.isUndefined = function(obj) {
      return obj != null;
    };


    /**
     * Format File Size into Human Readable Content
     *
     * @param {integer} bytes
     * @param {integer} si
     * @return string
     */

    Helpers.prototype.formatBytes = function(bytes, si) {
      var thresh, u, units;
      si = 1024;
      thresh = si ? 1000 : 1024;
      if (bytes < thresh) {
        return bytes + ' B';
      }
      units = si ? ['KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'] : ['KiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB', 'ZiB', 'YiB'];
      u = -1;
      while (true) {
        bytes /= thresh;
        ++u;
        if (!(bytes >= thresh)) {
          break;
        }
      }
      return bytes.toFixed(1) + ' ' + units[u];
    };


    /**
     * Initialize angular module
     *
     * @param {string} moduleName
     * @param {array} config
     * @return angular instance
     */

    Helpers.prototype.angularInit = function(moduleName, config) {
      var x;
      x = this;
      return angular.module(moduleName, config);
    };


    /**
     * Set LocaStorage Item using key value pair
     *
     * @param {string} key
     * @param {array,object,string} val
     * @return void
     */

    Helpers.prototype.set = function(key, val) {
      return localStorage.setItem(key, JSON.stringify(val));
    };


    /**
     * Get the save item from localStorage by its key id
     *
     * @param {string} key
     * @return mixed
     */

    Helpers.prototype.get = function(key) {
      var e;
      try {
        return JSON.parse(localStorage.getItem(key));
      } catch (error) {
        e = error;
        return false;
      }
    };


    /**
     * Remove LocaStorage Item using key value pair
     *
     * @param {string} key
     * @return void
     */

    Helpers.prototype.remove = function(key) {
      localStorage.removeItem(key);
    };


    /**
     * Delete all data from LocaStorage
     * Set key_pair that you want to delete
     *
     * @param {string} key
     * @return void
     */

    Helpers.prototype.clear = function(key_pair) {
      var key, value;
      for (key in localStorage) {
        value = localStorage[key];
        if (key_pair === void 0 || key_pair === true) {
          this.remove(key);
        } else if (key.indexOf(key_pair) >= 0) {
          this.remove(key);
        }
      }
    };

    Helpers.prototype.isEmptyObj = function(obj) {
      var key;
      if (obj === null) {
        return true;
      }
      for (key in obj) {
        if (hasOwnProperty.call(obj, key)) {
          return false;
        }
      }
      if (typeof obj === 'undefined') {
        return true;
      }
      if (obj.length > 0) {
        return false;
      }
      if (obj.length === 0) {
        return true;
      }
      return true;
    };


    /**
     * Generate Random Number
     *
     * @param {string} key
     * @return void
     */

    Helpers.prototype.randomKey = function(str_count) {
      var i, k, randomChar, ref, result;
      if (!str_count) {
        str_count = 6;
      }
      result = '';
      randomChar = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
      for (i = k = 0, ref = str_count; k < ref; i = k += 1) {
        result += randomChar.charAt(Math.floor(Math.random() * randomChar.length));
      }
      return result;
    };


    /**
     * Get File Extension Name of the current string
     *
     * @params (string)  name    File Name
     * @return string
     */

    Helpers.prototype.getFileExtension = function(name) {
      return name.split('.').pop().toLowerCase();
    };


    /**
     * Validate if Extension is Allowed or Not from the given data
     *
     * @params (string)  fileName    File Name with Extension
     * @params (array)   exts        Extension Lists, that you allow
     * @return string
     */

    Helpers.prototype.isAllowedExtension = function(fileName, exts) {
      return (new RegExp('(' + exts.join('|').replace(/\./g, '\\.') + ')$')).test(fileName);
    };

    Helpers.prototype.sprintf = function() {
      var a, doFormat, format, formatBaseX, formatString, i, justify, pad, regex;
      regex = /%%|%(\d+\$)?([-+\'#0 ]*)(\*\d+\$|\*|\d+)?(\.(\*\d+\$|\*|\d+))?([scboxXuideEfFgG])/g;
      a = arguments;
      i = 0;
      format = a[i++];
      pad = function(str, len, chr, leftJustify) {
        var padding;
        if (!chr) {
          chr = ' ';
        }
        padding = str.length >= len ? '' : new Array(1 + len - str.length >>> 0).join(chr);
        if (leftJustify) {
          return str + padding;
        } else {
          return padding + str;
        }
      };
      justify = function(value, prefix, leftJustify, minWidth, zeroPad, customPadChar) {
        var diff;
        diff = minWidth - value.length;
        if (diff > 0) {
          if (leftJustify || !zeroPad) {
            value = pad(value, minWidth, customPadChar, leftJustify);
          } else {
            value = value.slice(0, prefix.length) + pad('', diff, '0', true) + value.slice(prefix.length);
          }
        }
        return value;
      };
      formatString = function(value, leftJustify, minWidth, precision, zeroPad, customPadChar) {
        if (precision !== null) {
          value = value.slice(0, precision);
        }
        return justify(value, '', leftJustify, minWidth, zeroPad, customPadChar);
      };
      formatBaseX = function(value, base, prefix, leftJustify, minWidth, precision, zeroPad) {
        var number;
        number = value >>> 0;
        prefix = prefix && number && {
          '2': '0b',
          '8': '0',
          '16': '0x'
        }[base] || '';
        value = prefix + pad(number.toString(base), precision || 0, '0', false);
        return justify(value, prefix, leftJustify, minWidth, zeroPad);
      };
      doFormat = function(substring, valueIndex, flags, minWidth, _, precision, type) {
        var customPadChar, flagsl, j, leftJustify, method, number, positivePrefix, prefix, prefixBaseX, textTransform, value, zeroPad;
        number = void 0;
        prefix = void 0;
        method = void 0;
        textTransform = void 0;
        value = void 0;
        if (substring === '%%') {
          return '%';
        }
        leftJustify = false;
        positivePrefix = '';
        zeroPad = false;
        prefixBaseX = false;
        customPadChar = ' ';
        flagsl = flags.length;
        j = 0;
        while (flags && j < flagsl) {
          switch (flags.charAt(j)) {
            case ' ':
              positivePrefix = ' ';
              break;
            case '+':
              positivePrefix = '+';
              break;
            case '-':
              leftJustify = true;
              break;
            case '\'':
              customPadChar = flags.charAt(j + 1);
              break;
            case '0':
              zeroPad = true;
              customPadChar = '0';
              break;
            case '#':
              prefixBaseX = true;
          }
          j++;
        }
        if (!minWidth) {
          minWidth = 0;
        } else if (minWidth === '*') {
          minWidth = +a[i++];
        } else if (minWidth.charAt(0) === '*') {
          minWidth = +a[minWidth.slice(1, -1)];
        } else {
          minWidth = +minWidth;
        }
        if (minWidth < 0) {
          minWidth = -minWidth;
          leftJustify = true;
        }
        if (!isFinite(minWidth)) {
          throw new Error('sprintf: (minimum-)width must be finite');
        }
        if (!precision) {
          precision = 'fFeE'.indexOf(type) > -1 ? 6 : type === 'd' ? 0 : void 0;
        } else if (precision === '*') {
          precision = +a[i++];
        } else if (precision.charAt(0) === '*') {
          precision = +a[precision.slice(1, -1)];
        } else {
          precision = +precision;
        }
        value = valueIndex ? a[valueIndex.slice(0, -1)] : a[i++];
        switch (type) {
          case 's':
            return formatString(String(value), leftJustify, minWidth, precision, zeroPad, customPadChar);
          case 'c':
            return formatString(String.fromCharCode(+value), leftJustify, minWidth, precision, zeroPad);
          case 'b':
            return formatBaseX(value, 2, prefixBaseX, leftJustify, minWidth, precision, zeroPad);
          case 'o':
            return formatBaseX(value, 8, prefixBaseX, leftJustify, minWidth, precision, zeroPad);
          case 'x':
            return formatBaseX(value, 16, prefixBaseX, leftJustify, minWidth, precision, zeroPad);
          case 'X':
            return formatBaseX(value, 16, prefixBaseX, leftJustify, minWidth, precision, zeroPad).toUpperCase();
          case 'u':
            return formatBaseX(value, 10, prefixBaseX, leftJustify, minWidth, precision, zeroPad);
          case 'i':
          case 'd':
            number = +value || 0;
            number = Math.round(number - (number % 1));
            prefix = number < 0 ? '-' : positivePrefix;
            value = prefix + pad(String(Math.abs(number)), precision, '0', false);
            return justify(value, prefix, leftJustify, minWidth, zeroPad);
          case 'e':
          case 'E':
          case 'f':
          case 'F':
          case 'g':
          case 'G':
            number = +value;
            prefix = number < 0 ? '-' : positivePrefix;
            method = ['toExponential', 'toFixed', 'toPrecision']['efg'.indexOf(type.toLowerCase())];
            textTransform = ['toString', 'toUpperCase']['eEfFgG'.indexOf(type) % 2];
            value = prefix + Math.abs(number)[method](precision);
            return justify(value, prefix, leftJustify, minWidth, zeroPad)[textTransform]();
          default:
            return substring;
        }
      };
      return format.replace(regex, doFormat);
    };

    return Helpers;

  })();

  window._h = new Helpers();

}).call(this);

//# sourceMappingURL=helper.js.map
