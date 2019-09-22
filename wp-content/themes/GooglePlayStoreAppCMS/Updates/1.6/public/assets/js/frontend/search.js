(function() {
  $(document).ready(function() {
    return $('input[name="q"]').autoComplete({
      minChars: 2,
      source: function(term, response) {
        var url;
        url = $('#search-url').val();
        return $.ajax({
          url: url + '?q=' + term,
          headers: {
            'X-FROM-AJAX': 'from-ajax'
          },
          type: 'GET',
          dataType: 'json',
          success: function(res) {
            return response(res);
          }
        });
      },
      renderItem: function(item, search) {
        var imageUrl;
        imageUrl = item.app_image ? item.app_image : item.image_url;
        return '<div class="autocomplete-suggestion" data-langname="' + item.title + '" data-lang="' + item.title + '" data-langurl="' + item.detail_url + '" data-val="' + item.title + '"><img src="' + imageUrl + '" alt="' + item.title + '"  width="30px"> ' + item.title + '</div>';
      },
      onSelect: function(e, term, item) {
        return window.location.href = item.data('langurl');
      }
    });
  });

}).call(this);

//# sourceMappingURL=search.js.map
