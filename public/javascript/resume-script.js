(function ($) {
    "use strict";

    $(document).ready(function() {

        /* =============== Skill Bar value =============== */
        $('.skill-progress').each(function() {
            $(this).find('.skill-determinate').css({
                width: jQuery(this).attr('data-percent')
            }, 7000);
        });

    });

})(jQuery);
