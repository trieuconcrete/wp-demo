jQuery(function($) {
    var body = $('body');
    $('.st_add_booking_tour', body).each(function () {
        var parent = $(this),
        date_wrapper = $('#tour_time', parent),
        check_in_input = $('.check-in-input', parent),
        check_out_input = $('.check-out-input', parent),
        check_in_out_input = $('.check-in-out-input', parent),
        check_in_render = $('.check-in-render', parent),
        check_out_render = $('.check-out-render', parent),
        sts_checkout_label = $('.sts-tour-checkout-label', parent);
        st_security_check = $('.st_security_check', parent);
        var options = {
            singleDatePicker: true,
            showCalendar: false,
            sameDate: true,
            autoApply: true,
            disabledPast: true,
            dateFormat: 'DD/MM/YYYY',
            enableLoading: true,
            showEventTooltip: true,
            classNotAvailable: ['disabled', 'off'],
            disableHightLight: true,
            fetchEvents: function (start, end, el, callback) {
                var events = [];
                if (el.flag_get_events) {
                    return false;
                }
                el.flag_get_events = true;
                el.container.find('.loader-wrapper').show();
                var data = {
                    action: 'st_get_availability_tour_frontend',
                    start: start.format('YYYY-MM-DD'),
                    end: end.format('YYYY-MM-DD'),
                    tour_id: $('input#tour_id').val(),
                    security: $('input#st_frontend_security').val(),
                };
                $.post(st_params.ajax_url, data, function (respon) {
                    if (typeof respon === 'object') {
                        if (typeof respon.events === 'object') {
                            events = respon.events;
                        }
                    } else {
                        console.log('Can not get data');
                    }
                    callback(events, el);
                    el.flag_get_events = false;
                    el.container.find('.loader-wrapper').hide();
                }, 'json');
            }
        };
        if (typeof locale_daterangepicker == 'object') {
            options.locale = locale_daterangepicker;
        }

        check_in_out_input.daterangepicker(options,
            function (start, end, label, elmDate) {
                check_in_input.val(start.format(parent.data('format')));
                check_out_input.val(end.format(parent.data('format')));
                check_in_render.html(start.format(parent.data('format')));
                check_out_render.html(end.format(parent.data('format')));
                if (start.format(parent.data('format')).toString() == end.format(parent.data('format')).toString()) {
                    sts_checkout_label.hide();
                } else {
                    sts_checkout_label.show();
                }
                date = $.fullCalendar.moment(start.format(parent.data('format'))).format(st_params.date_format.toUpperCase());
                date_end = $.fullCalendar.moment(end.format(parent.data('format'))).format(st_params.date_format.toUpperCase());
                $('input#check_in_tour').val(date);
                $('input#check_out_tour').val(date_end);
                if(date != date_end){
                    $('input#check_out_tour').parents('.form-group').show();
                }
                if (typeof elmDate !== 'undefined' && elmDate !== false) {
                    if ($('.st-single-tour').length > 0) {
                        if (elmDate.target.classList.contains('has_starttime')) {
                            ajaxSelectStartTime(check_in_out_input.data('tour-id'), start.format(parent.data('format')), end.format(parent.data('format')), '', check_in_out_input.data('posttype'));
                        } else {
                            $('#starttime_tour option').remove();
                            $('#starttime_box').parent().hide();
                        }
                    }
                }
            });
        date_wrapper.click(function (e) {
            check_in_out_input.trigger('click');
        });
    });

    $('.st_add_booking_activity', body).each(function () {
        var parent = $(this),
        date_wrapper = $('#activity_time', parent),
        check_in_input = $('.check-in-input', parent),
        check_out_input = $('.check-out-input', parent),
        check_in_out_input = $('.check-in-out-input', parent),
        check_in_render = $('.check-in-render', parent),
        check_out_render = $('.check-out-render', parent),
        sts_checkout_label = $('.sts-tour-checkout-label', parent);
        st_security_check = $('.st_security_check', parent);
        var options = {
            singleDatePicker: true,
            showCalendar: false,
            sameDate: true,
            autoApply: true,
            disabledPast: true,
            dateFormat: 'DD/MM/YYYY',
            enableLoading: true,
            showEventTooltip: true,
            classNotAvailable: ['disabled', 'off'],
            disableHightLight: true,
            fetchEvents: function (start, end, el, callback) {
                var events = [];
                if (el.flag_get_events) {
                    return false;
                }
                el.flag_get_events = true;
                el.container.find('.loader-wrapper').show();
                var data = {
                    action: 'st_get_availability_activity_frontend',
                    start: start.format('YYYY-MM-DD'),
                    end: end.format('YYYY-MM-DD'),
                    activity_id: $('input#activity_id').val(),
                    security: $('input#st_frontend_security').val(),
                };
                $.post(st_params.ajax_url, data, function (respon) {
                    if (typeof respon === 'object') {
                        callback(respon, el);
                    } else {
                        console.log('Can not get data');
                    }
                    el.flag_get_events = false;
                    el.container.find('.loader-wrapper').hide();
                }, 'json');
            }
        };
        if (typeof locale_daterangepicker == 'object') {
            options.locale = locale_daterangepicker;
        }

        check_in_out_input.daterangepicker(options,
            function (start, end, label, elmDate) {
                check_in_input.val(start.format(parent.data('format')));
                check_out_input.val(end.format(parent.data('format')));
                check_in_render.html(start.format(parent.data('format')));
                check_out_render.html(end.format(parent.data('format')));
                if (start.format(parent.data('format')).toString() == end.format(parent.data('format')).toString()) {
                    sts_checkout_label.hide();
                } else {
                    sts_checkout_label.show();
                }
                date = $.fullCalendar.moment(start.format(parent.data('format'))).format(st_params.date_format.toUpperCase());
                date_end = $.fullCalendar.moment(end.format(parent.data('format'))).format(st_params.date_format.toUpperCase());
                $('input#check_in_activity').val(date);
                $('input#check_out_activity').val(date_end);
                if(date != date_end){
                    $('input#check_out_tour').parents('.form-group').show();
                }
                if (typeof elmDate !== 'undefined' && elmDate !== false) {
                    if ($('.st-single-activity').length > 0) {
                        if (elmDate.target.classList.contains('has_starttime')) {
                            ajaxSelectStartTime(check_in_out_input.data('tour-id'), start.format(parent.data('format')), end.format(parent.data('format')), '', check_in_out_input.data('posttype'));
                        } else {
                            $('#starttime_activity option').remove();
                            $('#starttime_box').parent().hide();
                        }
                    }
                }
            });
        date_wrapper.click(function (e) {
            check_in_out_input.trigger('click');
        });
    });
});
