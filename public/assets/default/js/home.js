(function($){
  $(function(){
        var clipboard = new Clipboard('#btnCopySnippet');

        clipboard.on('success', function(e) {
            $('#btnCopySnippet').html('Copied');
        });

        clipboard.on('error', function(e) {
            $('#btnCopySnippet').html('Fail to copy');
        });

        var prepareParam = function(snippetValue, snippetTitle, csrfToken) {
            var param = {
                'snippet' : snippetValue,
                'snippetTitle' : snippetTitle
            };

            param[csrfToken.name] = csrfToken.value;
            return param;
        };

        var handleAddSnippet = function(snippetValue, snippetTitle, csrfToken) {
            var loader = $('#progressContainer');
            var formContainer = $('#formContainer');
            var statusContainer = $('#statusContainer');
            var resultContainer = $('#resultContainer');
            var errorContainer = $('#errorContainer');
            loader.removeClass('hidden');

            var param = prepareParam(snippetValue, snippetTitle, csrfToken);
            $.post('/create', param).done(function(response){
                  formContainer.addClass('hidden');
                  statusContainer.removeClass('hidden');
                  resultContainer.removeClass('hidden');
                  errorContainer.addClass('hidden');

                  var snippetUrlAnchor = $('#snippetUrl');
                  snippetUrlAnchor.attr('href', response.data.snippetUrl);
                  snippetUrlAnchor.html(response.data.snippetUrl);

                  var csrfTokenElem = $('#csrfToken');
                  csrfTokenElem.attr('name', response.csrfToken.name);
                  csrfTokenElem.attr('value', response.csrfToken.value);

                  var clipboardBtn = $('#btnCopySnippet');
                  clipboardBtn.removeClass('hidden');
                  clipboardBtn.html('Copy Snippet URL');
                  clipboardBtn.attr('data-clipboard-text', response.data.snippetUrl);

                  loader.addClass('hidden');
            }).fail(function(xhr, status, response){
                  formContainer.addClass('hidden');
                  statusContainer.removeClass('hidden');
                  resultContainer.addClass('hidden');
                  errorContainer.removeClass('hidden');
                  $('#btnCopySnippet').addClass('hidden');
                  $('#errorMsg').html(response);
                  loader.addClass('hidden');
            });
        };

        $('#btnCreateSnippet').click(function(){
            var snippetValue = $('#snippet').val();
            var snippetTitle = $('#snippetTitle').val();
            var csrfTokenElem = $('#csrfToken');
            var csrfToken = {
                name : csrfTokenElem.attr('name'),
                value : csrfTokenElem.val()
            };
            if (snippetValue.length) {
                handleAddSnippet(snippetValue, snippetTitle, csrfToken);
            } else {
                $('.resultContainer').addClass('hidden');
                $('.errorContainer').removeClass('hidden');
                $('#errorMsg').html('No URL to shorten.');
            }
        });

        $('#btnNewSnippet').click(function() {
            var formContainer = $('#formContainer');
            var statusContainer = $('#statusContainer');
            var snippetElement = $('#snippet');
            var snippetTitleElement = $('#snippetTitle');
            formContainer.removeClass('hidden');
            statusContainer.addClass('hidden');
            snippetElement.val('');
            snippetElement.trigger('autoresize');
            snippetTitleElement.val('');
        });


  }); // end of document ready
})(jQuery); // end of jQuery name space

