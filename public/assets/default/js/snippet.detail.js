(function($){
    $(function(){
        var clipboardTrigger = $('#btnCopyCode');
        var clipboard = new Clipboard('#btnCopyCode');

        clipboard.on('success', function(e) {
            clipboardTrigger.html('Copied');
        });

        clipboard.on('error', function(e) {
            clipboardTrigger.html('Fail to copy');
        });

        var snippetCode = $('#raw-code').text();
        clipboardTrigger.attr('data-clipboard-text', snippetCode);

        $('.show-raw').click(function(){
            $('.code-container').toggleClass('hide');
            $('.raw-code-container').toggleClass('hide');
        });
    });
})(jQuery);
