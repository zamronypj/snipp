(function($){
    $(function(){
        $('.button-collapse').sideNav();
        var profileElem = $('.userprofile');
        if (profileElem) {
            profileElem.dropdown({
                belowOrigin: true
            });
        }

    });
})(jQuery);
