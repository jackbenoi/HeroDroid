###*
# ListingService
# Handle Collections of Data from AJAX Request
#
# @package 		ListingService
# @author       Anthony Pillos <dev.anthonypillos@gmail.com>
# @copyright    Copyright (c) 2016 Anthony Pillos. (http://anthonypillos.com,http://iapdesign.com,http://developers.ph)
# @version      v1
###

angular.module('ListingService',[]).service "ListingService",
[
	'ApiFactory',
	(ApiFactory) ->

		options = {
			collections 		: []
			data 				: []

			range 	     		: []
			totalPages    		: 0
			currentPage   		: 1

			requestData : (requestURI, reqMethod, data, qDefer) ->
				if reqMethod?
					reqMethod = reqMethod
				else
					reqMethod = 'POST'

				data = if data? then data else {}

				ApiFactory.sendRequest data, requestURI, reqMethod, qDefer


			dataHandler : (response, status) ->

				@collections = response
				@totalPages  = response.last_page
				@currentPage = response.current_page
				@data 		 = if response.data? then response.data else []

				# paging
				pages 	= []
				ceil 	= Math.ceil((@currentPage+1)/10)*10
				floor 	= Math.floor((@currentPage+1)/10)*10

				if ceil > @totalPages
					floor = Math.floor((@currentPage-1)/10)*10
					max   = @totalPages
				else
					max = ceil


				if ceil is floor
					floor -= 10

				i = if floor > 0 then floor else 1

				while i <= max
					pages.push i
					i++

				@range = pages


			getCollections : () ->

		}

		return options
]