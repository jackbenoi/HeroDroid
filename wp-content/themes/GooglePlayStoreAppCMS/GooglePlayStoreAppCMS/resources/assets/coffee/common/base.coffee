###*
# Act as our Helpers for all our projects.
#
# @class Helpers
# @package Base Helper Class
# @author Anthony Pillos <dev.anthonypillos@gmail.com>
###
class Helpers

    isDebug: true

    obj: {}

    constructor: () ->
        @obj.startSymbol    = '{{'
        @obj.endSymbol      = '}}'

    log: (msg)->
        console.log msg if @isDebug

    isUndefined: ( obj ) -> obj?
    
    ###*
    # Format File Size into Human Readable Content
    #
    # @param {integer} bytes
    # @param {integer} si
    # @return string
    ###
    formatBytes: (bytes, si) ->
        si = 1024
        thresh = if si then 1000 else 1024
        if bytes < thresh
            return bytes + ' B'
        units = if si then [
            'KB'
            'MB'
            'GB'
            'TB'
            'PB'
            'EB'
            'ZB'
            'YB'
        ]
        else [
            'KiB'
            'MiB'
            'GiB'
            'TiB'
            'PiB'
            'EiB'
            'ZiB'
            'YiB'
        ]

        u = -1
        loop
            bytes /= thresh
            ++u
            unless bytes >= thresh
                break
        bytes.toFixed(1)+' '+units[u]


    ###*
    # Initialize angular module
    #
    # @param {string} moduleName
    # @param {array} config
    # @return angular instance
    ###
    angularInit: (moduleName, config) ->
        x = @
        angular.module(moduleName, config)


    ###*
    # Set LocaStorage Item using key value pair
    #
    # @param {string} key
    # @param {array,object,string} val
    # @return void
    ###
    set: (key, val) ->
        localStorage.setItem key, JSON.stringify val

    ###*
    # Get the save item from localStorage by its key id
    #
    # @param {string} key
    # @return mixed
    ###
    get: (key) ->
        try
            JSON.parse localStorage.getItem key
        catch e
            return false

            
    ###*
    # Remove LocaStorage Item using key value pair
    #
    # @param {string} key
    # @return void
    ###
    remove: (key) ->
        localStorage.removeItem key
        return


    ###*
    # Delete all data from LocaStorage
    # Set key_pair that you want to delete
    #
    # @param {string} key
    # @return void
    ###
    clear: (key_pair) ->
        for key, value of localStorage

            if key_pair is undefined or key_pair is true
                @remove key

            else if key.indexOf(key_pair) >= 0
                @remove key

        return

    isEmptyObj: (obj) ->
        # null and undefined are "empty"
        if obj is null
            return true

        for key of obj
            if hasOwnProperty.call(obj, key)
                return false

        if typeof obj is 'undefined'
            return true

        if obj.length > 0
            return false

        if obj.length == 0
            return true

        return true


    ###*
    # Generate Random Number
    #
    # @param {string} key
    # @return void
    ###
    randomKey: (str_count) ->

        str_count  = 6 if not str_count
        result     = ''
        randomChar = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789"

        for i in [ 0...str_count ] by 1
            result += randomChar.charAt Math.floor Math.random() * randomChar.length

        return result

                
    ###*
    # Get File Extension Name of the current string
    #
    # @params (string)  name    File Name
    # @return string
    ###
    getFileExtension: (name) ->
        return name.split('.').pop().toLowerCase()

    ###*
    # Validate if Extension is Allowed or Not from the given data
    #
    # @params (string)  fileName    File Name with Extension
    # @params (array)   exts        Extension Lists, that you allow
    # @return string
    ###
    isAllowedExtension: (fileName,exts) ->
        return (new RegExp('(' + exts.join('|').replace(/\./g, '\\.') + ')$')).test(fileName)

    sprintf: () ->
        regex = /%%|%(\d+\$)?([-+\'#0 ]*)(\*\d+\$|\*|\d+)?(\.(\*\d+\$|\*|\d+))?([scboxXuideEfFgG])/g
        a = arguments
        i = 0
        format = a[i++]
        pad = (str, len, chr, leftJustify) ->
            if !chr
                chr = ' '
            padding = if str.length >= len then '' else new Array(1 + len - (str.length) >>> 0).join(chr)
            if leftJustify then str + padding else padding + str

        justify = (value, prefix, leftJustify, minWidth, zeroPad, customPadChar) ->
            diff = minWidth - (value.length)
            if diff > 0
                if leftJustify or !zeroPad
                    value = pad(value, minWidth, customPadChar, leftJustify)
                else
                    value = value.slice(0, prefix.length) + pad('', diff, '0', true) + value.slice(prefix.length)
            value

        formatString = (value, leftJustify, minWidth, precision, zeroPad, customPadChar) ->
            if precision != null
                value = value.slice(0, precision)
            justify value, '', leftJustify, minWidth, zeroPad, customPadChar

        formatBaseX = (value, base, prefix, leftJustify, minWidth, precision, zeroPad) ->
            # Note: casts negative numbers to positive ones
            number = value >>> 0
            prefix = prefix and number and {
              '2': '0b'
              '8': '0'
              '16': '0x'
            }[base] or ''
            value = prefix + pad(number.toString(base), precision or 0, '0', false)
            justify value, prefix, leftJustify, minWidth, zeroPad

        doFormat = (substring, valueIndex, flags, minWidth, _, precision, type) ->
            number = undefined
            prefix = undefined
            method = undefined
            textTransform = undefined
            value = undefined

            if substring == '%%'
              return '%'
            # parse flags
            leftJustify = false
            positivePrefix = ''
            zeroPad = false
            prefixBaseX = false
            customPadChar = ' '
            flagsl = flags.length
            j = 0

            while flags and j < flagsl
              switch flags.charAt(j)
                when ' '
                  positivePrefix = ' '
                when '+'
                  positivePrefix = '+'
                when '-'
                  leftJustify = true
                when '\''
                  customPadChar = flags.charAt(j + 1)
                when '0'
                  zeroPad = true
                  customPadChar = '0'
                when '#'
                  prefixBaseX = true
              j++


            if !minWidth
              minWidth = 0
            else if minWidth == '*'
              minWidth = +a[i++]
            else if minWidth.charAt(0) == '*'
              minWidth = +a[minWidth.slice(1, -1)]
            else
              minWidth = +minWidth
            # Note: undocumented perl feature:
            if minWidth < 0
              minWidth = -minWidth
              leftJustify = true
            if !isFinite(minWidth)
              throw new Error('sprintf: (minimum-)width must be finite')
            if !precision
              precision = if 'fFeE'.indexOf(type) > -1 then 6 else if type == 'd' then 0 else undefined
            else if precision == '*'
              precision = +a[i++]
            else if precision.charAt(0) == '*'
              precision = +a[precision.slice(1, -1)]
            else
              precision = +precision

            value = if valueIndex then a[valueIndex.slice(0, -1)] else a[i++]
            switch type
              when 's'
                return formatString(String(value), leftJustify, minWidth, precision, zeroPad, customPadChar)
              when 'c'
                return formatString(String.fromCharCode(+value), leftJustify, minWidth, precision, zeroPad)
              when 'b'
                return formatBaseX(value, 2, prefixBaseX, leftJustify, minWidth, precision, zeroPad)
              when 'o'
                return formatBaseX(value, 8, prefixBaseX, leftJustify, minWidth, precision, zeroPad)
              when 'x'
                return formatBaseX(value, 16, prefixBaseX, leftJustify, minWidth, precision, zeroPad)
              when 'X'
                return formatBaseX(value, 16, prefixBaseX, leftJustify, minWidth, precision, zeroPad).toUpperCase()
              when 'u'
                return formatBaseX(value, 10, prefixBaseX, leftJustify, minWidth, precision, zeroPad)
              when 'i', 'd'
                number = +value or 0
                number = Math.round(number - (number % 1))
                # Plain Math.round doesn't just truncate
                prefix = if number < 0 then '-' else positivePrefix
                value = prefix + pad(String(Math.abs(number)), precision, '0', false)
                return justify(value, prefix, leftJustify, minWidth, zeroPad)
              # Should handle locales (as per setlocale)
              when 'e', 'E', 'f', 'F', 'g', 'G'
                number = +value
                prefix = if number < 0 then '-' else positivePrefix
                method = [
                  'toExponential'
                  'toFixed'
                  'toPrecision'
                ]['efg'.indexOf(type.toLowerCase())]
                textTransform = [
                  'toString'
                  'toUpperCase'
                ]['eEfFgG'.indexOf(type) % 2]
                value = prefix + Math.abs(number)[method](precision)
                return justify(value, prefix, leftJustify, minWidth, zeroPad)[textTransform]()
              else
                return substring
            return
        format.replace regex, doFormat

window._h = new Helpers()