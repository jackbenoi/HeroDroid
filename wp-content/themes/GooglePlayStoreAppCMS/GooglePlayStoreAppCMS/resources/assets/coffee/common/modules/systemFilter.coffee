###*
# systemFilter
#
# @package systemFilter
# @author       Anthony Pillos <dev.anthonypillos@gmail.com>
# @copyright    Copyright (c) 2016 Anthony Pillos. (http://anthonypillos.com,http://iapdesign.com,http://developers.ph)
# @version      v1
####


angular.module('SystemFilter', [])

	##
	# @params (string) 	items		Items Collections
	# @params (boolean) field		Field Name
	# @method groupBy()
	##
	.filter 'groupBy', ['$parse', ($parse) ->
		_.memoize (items, field) ->
			getter = $parse(field)
			_.groupBy items, (item) ->
				getter item
	]

	##
	# Ex. {[ '10000' | format_bytes ]}
	#
	# @params (string) 	value			Strign to be trim.
	# @params (boolean) wordwise		If set to 1, it will cut by words.
	# @params (string) 	max 			Max Length before truncating our string
	# @params (string) 	tail 			Separator after the end of string default is '...'
	# @method truncate()
	##
	.filter 'format_bytes', ->
		(bytes, si) ->
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

	##
	# Ex. {[ 'Lorem ipsum data string' | truncate:10]}
	#
	# @params (string) 	value			Strign to be trim.
	# @params (boolean) wordwise		If set to 1, it will cut by words.
	# @params (string) 	max 			Max Length before truncating our string
	# @params (string) 	tail 			Separator after the end of string default is '...'
	# @method truncate()
	##
	.filter 'truncateStr', ->

	  	(value, max, wordwise, tail) ->
		    if !value
		      return ''
		    max = parseInt(max, 10)
		    if !max
		      return value
		    if value.length <= max
		      return value
		    value = value.substr(0, max)
		    if wordwise
		      lastspace = value.lastIndexOf(' ')
		      if lastspace != -1
		        value = value.substr(0, lastspace)
		    value + (tail or '...')

	##
	# Ex. {[ 'Lorem ipsum data string' | truncateMiddle]}
	#
	# @params (string) 	str			Strign to be trim.
	# @params (boolean) length		Lenght of letters that will be trim off.
	# @params (string) 	separator 	Separator at the middle of string default is '...'
	# @method truncate()
	##
	.filter 'truncateMiddle', ->
		(str, length = 20, separator = '...') ->
			return '' if str is null
			return '' if str is undefined
			return str if str.length <= length

			pad = Math.round (length - separator.length) / 2
			start = str.substr(0, pad)
			end = str.substr(str.length - pad)

			[start, separator, end].join('')


	##
	# Ex. {[ "<strong>Render Bold Text</strong>" | trusted_html ]}
	#
	# @params (string) 	text string Render as html
	# @method mobile()
	##
	.filter 'trusted_html', ['$sce', ($sce) ->
		(text) ->
			$sce.trustAsHtml(text)
	]

	##
	# @params (string) 	items		Items Collections
	# @params (boolean) field		Field Name
	# @method removeSlash()
	##
	.filter 'remove_slash', ->
		(str) ->
			if str
				str.replace(/\\/g, '')

