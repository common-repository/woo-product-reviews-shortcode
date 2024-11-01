(function( $ ) {
    $(document.body).on('click', '.code-example-copy', function() {
        var control = $(this);
        var parent = control.parents('.code-example');
        var message = parent.find('.code-example-copied');
        var toCopy = parent.find('.code-example-value');

        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val(toCopy.text()).select();
        document.execCommand("copy");
        $temp.remove();

        toCopy.addClass('copied');
        control.hide();
        message.show();

        setTimeout(function() {
            toCopy.removeClass('copied');
            control.show();
            message.hide();
        }, 2000);
    });

    $(document.body).on('click', '.show-template, .hide-template', function() {
        var control = $(this);
        var template = control.data('template');
        var parent = control.parents('li');

        control.hide();

        if (control.hasClass('show-template')) {
            parent.find('.hide-template').show();
        } else {
            parent.find('.show-template').show();
        }

        $('#template_' + template).toggle();
    });

    $(document.body).on('click', '.copy-template', function() {
        var control = $(this);
        var template = control.data('template');

        var data = {
            action: 'wprshrtcd_copy_template',
            nonce:  wprshrtcd_ajax_object.nonce,
            template: template,
        };

        ajaxRequest(
            data,
            function() {},
            function() {}
        );
    });

    $(document.body).on('click', '.delete-template', function() {
        var control = $(this);
        var template = control.data('template');

        var data = {
            action: 'wprshrtcd_delete_template',
            nonce:  wprshrtcd_ajax_object.nonce,
            template: template
        };

        ajaxRequest(
            data,
            function() {},
            function() {}
        );
    });

    $(document.body).on('click', '#wprshrtcd_save_settings', function() {
        var form = $('#wprshrtcd_save_settings_form');
        var formData = form.serializeArray();

        var data = {
            action: 'wprshrtcd_save_settings',
            nonce:  wprshrtcd_ajax_object.nonce,
            formData: formData
        };

        ajaxRequest(
            data,
            function() {},
            function() {}
        );
    });

    $(document.body).on('click', '.wprshrtcd-duplicate', function() {
        var control = $(this);
        var duplicate = control.data('duplicate');

        var data = {
            action: 'wprshrtcd_duplicate_settings',
            nonce:  wprshrtcd_ajax_object.nonce,
            duplicate: duplicate
        };

        ajaxRequest(
            data,
            function() {},
            function() {}
        );
    });

    $(document.body).on('change', '#wprshrtcd_products_list input[type=checkbox]', function(){
        var checkboxes = $('#wprshrtcd_products_list input[type=checkbox]');
        var selected = [];

        checkboxes.each(function() {
            if ($(this).prop('checked')) {
                selected.push($(this).val());
            }
        });

        if (selected.length) {
            var selectedVal = selected.join(',');
        }

        $('#products_ids').val(selectedVal);

        update_query_link_params();
    });

    $(document.body).on('change', '#per_page_select', function(){
        var control = $(this);
        var value = control.val();
        var number = $('#per_page');

        if ('custom' == value) {
            number.attr('readonly', false);
        } else {
            number.attr('readonly', true);
        }
    });

    $(document.body).on('change', '#show_product_item_title, #show_pic, #show_product_item_link, #show_pic_type, #show_product_thumbnail_link', function(){
        var products = $('#review_link_type_settings');

        if (is_link_enabled()) {
            products.show();
        } else {
            products.hide();
        }
    });

    function is_link_enabled() {
        var show_product_item_title = $('#show_product_item_title').val();
        var show_pic = $('#show_pic').val();
        var show_pic_type = $('#show_pic_type').val();
        var show_product_item_link = $('#show_product_item_link').val();
        var show_product_thumbnail_link = $('#show_product_thumbnail_link').val();

        if ('no' === show_product_item_title && 'no' === show_pic) {
            return false;
        }

        if ('yes' === show_product_item_title && 'yes' === show_product_item_link) {
            return true;
        }

        if ('yes' === show_pic && 'thumbnail' === show_pic_type && 'yes' === show_product_thumbnail_link) {
            return true;
        }

        return false;
    }

    $(document.body).on('change', '#products_ids_select', function(){
        var control = $(this);
        var value = control.val();
        var products = $('#wprshrtcd_products_list');

        if ('custom' == value) {
            products.show();
        } else {
            products.hide();
        }
    });

    $(document.body).on('change', '#multicolumn_mode', function(){
        var control = $(this);
        var value = control.val();
        var products = $('#multicolumn_mode_settings_container');

        if ('yes' == value) {
            products.show();
        } else {
            products.hide();
        }
    });

    $(document.body).on('change', '#show_pic_type', function(){
        var control = $(this);
        var value = control.val();
        var products = $('#show_pic_size_settings');
        var link = $('#show_product_thumbnail_link_settings');

        if ('thumbnail' == value) {
            products.show();
            link.show();
        } else {
            products.hide();
            link.hide();
        }
    });

    $(document.body).on('change', '#show_pic', function(){
        var control = $(this);
        var value = control.val();
        var container = $('#show_pic_settings');

        if ('yes' == value) {
            container.show();
        } else {
            container.hide();
        }
    });

    $(document.body).on('change', '#show_unique_type', function(){
        var control = $(this);
        var value = control.val();
        var container = $('#show_unique_type_settings');

        if ('all' == value) {
            container.hide();
        } else {
            container.show();
        }
    });

    $(document.body).on('change', '#show_product_item_title', function(){
        var control = $(this);
        var value = control.val();
        var container = $('#show_product_item_title_settings');

        if ('no' == value) {
            container.hide();
        } else {
            container.show();
        }
    });

    $(document.body).on(
        'change',
        '#product_title, ' +
        '#per_page, ' +
        '#show_unique_amount, ' +
        '#products_ids_select, ' +
        '#show_schema, ' +
        '#per_page_select, ' +
        '#show_product_item_title, ' +
        '#show_product_item_link, ' +
        '#show_pic, ' +
        '#show_pic_type, ' +
        '#show_pic_size, ' +
        '#show_product_thumbnail_link, ' +
        '#show_nested, ' +
        '#review_link_type, ' +
        '#multicolumn_mode, ' +
        '#multicolumn_mode_desktop, ' +
        '#multicolumn_mode_desktop_thumb, ' +
        '#multicolumn_mode_tablet, ' +
        '#multicolumn_mode_tablet_thumb, ' +
        '#multicolumn_mode_mobile_thumb, ' +
        '#show_unique_type',
        function(){
            update_query_link_params();
        }
    );

    function update_query_link_params() {
        var form = $('#wprshrtcd_save_settings_form');

        if (form.length) {
            var params = form.serialize();
            var url = $('#request_url').val();

            $('#request_params').val(params);

            var preview_url = url + '&' + params;

            $('#preview_url').val(preview_url);

            $('#preview_link').attr('href', preview_url);
        }
    }

    $(document).ready(function () {
        update_query_link_params();

        $('.wptl-tip').tipr();
    });

    function ajaxRequest(data, cb, cbError) {
        $.ajax({
            type: 'post',
            url: ajaxurl,
            data: data,
            success: function (response) {
                var decoded;

                console.log(response);

                try {
                    decoded = $.parseJSON(response);
                } catch(err) {
                    console.log(err);
                    decoded = false;
                }

                if (decoded) {
                    if (decoded.success) {
                        if (decoded.message) {
                            alert(decoded.message);
                        }

                        if (decoded.url) {
                            window.location.replace(decoded.url);
                        } else if (decoded.reload) {
                            window.location.reload();
                        }

                        if (typeof cb === 'function') {
                            cb();
                        }
                    } else {
                        if (decoded.message) {
                            alert(decoded.message);
                        }

                        if (typeof cbError === 'function') {
                            cbError();
                        }
                    }
                } else {
                    alert('Something went wrong');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
            }
        });
    }
})( jQuery );
