$(document).ready () ->

    $('input[name="q"]').autoComplete {
        minChars: 2
        source: (term,response) ->
            url = $('#search-url').val()
            $.ajax
                url: url+'?q='+term,
                headers: {
                    'X-FROM-AJAX': 'from-ajax'
                },
                type: 'GET'
                dataType: 'json'
                success: (res) ->
                    response res

        renderItem: (item, search) ->
            imageUrl = if item.app_image then item.app_image else item.image_url
            '<div class="autocomplete-suggestion" data-langname="' + item.title + '" data-lang="' + item.title + '" data-langurl="' + item.detail_url + '" data-val="' + item.title + '"><img src="'+imageUrl+'" alt="'+item.title+'"  width="30px"> ' + item.title + '</div>'
        onSelect: (e, term, item) ->
            window.location.href = item.data('langurl')
        
    }