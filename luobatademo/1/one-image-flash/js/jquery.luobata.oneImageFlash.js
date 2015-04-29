;(function($){
    $.checkIn = function(el,options){
        var $el = $(el),
            $mask_1 = $el.find('.mask-1'),
            $mask_2 = $el.find('.mask-2'),
            $content = $el.find('.content');
        $el.bind('mouseenter', function(e){
            // $mask_1.removeClass('mask_1_out');
            // $mask_1.addClass('mask_1_in');
            $mask_1.css({
                'transform' : 'rotate(55.1deg) translateX(0px)',
                'transition' : '2s'
            });
        });
        $el.bind('mouseleave', function(e){
            // $mask_1.removeClass('mask_1_in');
            // $mask_1.addClass('mask_1_out');
            $mask_1.css({
                'transform' : 'rotate(55.1deg) translateX(-180px)',
                'transition' : '2s'
            });
        });

        console.log(1);
    };

    $.fn.checkIn = function(option){
        var defaults = {
            'width' : 300
        };
        var options = $.extend(defaults, option);
        var self = $(this);

        self.each(function(index,el){
            $.checkIn(el,options);
        });
    }
})(jQuery);