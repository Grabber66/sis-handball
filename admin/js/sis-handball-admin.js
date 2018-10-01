(function ($) {
    'use strict';

    var allow_marked = 0;
    var allow_sorting = 0;
    var allow_limit = 0;
    var allow_teamname = 0;
    var allow_hide_cols = 0;

    $(document).ready(function () {
        resetAutomaticMarkedTeams();
        updateFieldView();
        updateShortcode();
        updateConcatenationFieldView();
        updateLinkChecker('https://www.sis-handball.de/');

        /* Shortcode generator */
        $('.shortcode-generator #sis_handball_shortcode_generator_type').change(function () {
            resetHiddenCols();
            updateFieldView();
            updateShortcode();
        });

        $('.shortcode-generator #sis_handball_shortcode_generator_sorting').change(function () {
            updateShortcode();
        });

        $('.shortcode-generator #sis_handball_shortcode_generator_league_id').on('keyup', function () {
            updateShortcode();
            updateFieldView();
        });

        $('.shortcode-generator #sis_handball_shortcode_generator_marked_manual').on('keyup', function () {
            updateShortcode();
        });

        $('.shortcode-generator #sis_handball_shortcode_generator_marked').on('change', function () {
            updateShortcode();
        });

        $('.shortcode-generator #sis_handball_shortcode_generator_limit').on('keyup', function () {
            updateShortcode();
        });

        $('.shortcode-generator #sis_handball_shortcode_generator_limit').bind('keyup mouseup', function () {
            updateShortcode();
        });

        $('.shortcode-generator #sis_handball_shortcode_generator_teamname').on('keyup', function () {
            updateShortcode();
        });

        $('.shortcode-generator.hide-cols input').on('change', function () {
            updateShortcode();
        });

        /* Autoselect value in input field */
        $('.select_value').click(function () {
            $(this).select();
        });

        /* Switch between automatic and manual input for marked team */
        $('.sis_handball_shortcode_generator_marked_toggle_manual').click(function (evt) {
            evt.preventDefault();
            $(this).find('span.hide').toggle();
            $(this).find('span.show').toggle();
            $('.shortcode-generator.marked-manual').toggle();
            resetAutomaticMarkedTeams();
        });
    });

    function updateFieldView() {
        $('.shortcode-generator.marked').hide();
        $('.shortcode-generator.marked-manual').hide();
        $('.shortcode-generator.sorting').hide();
        $('.shortcode-generator.limit').hide();
        $('.shortcode-generator.teamname').hide();

        var select_field = $('.shortcode-generator #sis_handball_shortcode_generator_type');
        var league_id = $('#sis_handball_shortcode_generator_league_id').val();

        /* Update sis link examples and link checker */
        if (select_field.val() === 'standings' || select_field.val() === 'chart' || select_field.val() === 'stats') {
            $('#sis_handball_shortcode_generator_league_id_description_link').html('https://sis-handball.de/default.aspx?view=Tabelle&Liga=<code>001517000000000000000000000000000001000</code>');
            updateLinkChecker('https://sis-handball.de/default.aspx?view=Tabelle&Liga=', league_id);
        }

        if (select_field.val() === 'team' || select_field.val() === 'next') {
            $('#sis_handball_shortcode_generator_league_id_description_link').html('https://sis-handball.de/default.aspx?view=Mannschaft&Liga=<code>001517000000000000000000000000000001015</code>');
            updateLinkChecker('https://sis-handball.de/default.aspx?view=Mannschaft&Liga=', league_id);
        }

        if (select_field.val() === 'games') {
            $('#sis_handball_shortcode_generator_league_id_description_link').html('https://sis-handball.de/default.aspx?view=AlleSpiele&Liga=<code>001517000000000000000000000000000001000</code>');
            updateLinkChecker('https://sis-handball.de/default.aspx?view=AlleSpiele&Liga=', league_id);
        }

        if (select_field.val() === 'club') {
            $('#sis_handball_shortcode_generator_league_id_description_link').html('https://www.sis-handball.de/default.aspx?view=Gesamtspielplan&Verein=<code>1710101106</code>');
            updateLinkChecker('https://www.sis-handball.de/default.aspx?view=Gesamtspielplan&Verein=', league_id);
        }

        /* Update visible fields */
        if (select_field.val() === 'standings' || select_field.val() === 'team' || select_field.val() === 'games' || select_field.val() === 'stats' || select_field.val() === 'next') {
            allow_marked = 1;
            $('.shortcode-generator.marked').show();
        } else {
            allow_marked = 0;
            $('.shortcode-generator.marked').hide();
        }

        if (select_field.val() === 'team' || select_field.val() === 'games') {
            allow_sorting = 1;
            $('.shortcode-generator.sorting').show();
        } else {
            allow_sorting = 0;
            $('.shortcode-generator.sorting').hide();
        }

        if (select_field.val() === 'team' || select_field.val() === 'next' || select_field.val() === 'standings' || select_field.val() === 'games' || select_field.val() === 'club') {
            allow_limit = 1;
            $('.shortcode-generator.limit').show();
        } else {
            allow_limit = 0;
            $('.shortcode-generator.limit').hide();
        }

        if (select_field.val() === 'chart') {
            allow_teamname = 1;
            $('.shortcode-generator.teamname').show();
        } else {
            allow_teamname = 0;
            $('.shortcode-generator.teamname').hide();
        }

        /* Update field view for hidden columns */
        if (select_field.val() === 'standings' || select_field.val() === 'team' || select_field.val() === 'games' || select_field.val() === 'stats' || select_field.val() === 'next' || select_field.val() === 'club') {
            allow_hide_cols = 1;
            $('.shortcode-generator .hide-cols-fieldset').hide();
            $('.shortcode-generator .hide-cols-' + select_field.val()).show();
            $('.shortcode-generator.hide-cols').show();
        } else {
            allow_hide_cols = 0;
            $('.shortcode-generator.hide-cols').hide();
        }
    }

    function updateLinkChecker(url, league_id) {
        if (league_id) {
            $('#sis_handball_shortcode_generator_link_checker').attr('href', url + league_id);
        } else {
            $('#sis_handball_shortcode_generator_link_checker').attr('href', url);
        }
    }

    function resetAutomaticMarkedTeams() {
        var marked_select = $('#sis_handball_shortcode_generator_marked');
        var default_value = marked_select.attr('data-default-option');
        marked_select.html('');
        marked_select.append('<option value="">' + default_value + '</option>');
    }

    function updateShortcode() {
        var build_shortcode = '[sishandball ';

        var type = $('.shortcode-generator #sis_handball_shortcode_generator_type').val();
        var league = $('.shortcode-generator #sis_handball_shortcode_generator_league_id').val();
        var marked = $('.shortcode-generator #sis_handball_shortcode_generator_marked').val();
        var marked_manual = $('.shortcode-generator #sis_handball_shortcode_generator_marked_manual').val();
        var sorting = $('.shortcode-generator #sis_handball_shortcode_generator_sorting').val();
        var limit = $('.shortcode-generator #sis_handball_shortcode_generator_limit').val();
        var teamname = $('.shortcode-generator #sis_handball_shortcode_generator_teamname').val();
        var hide_cols = getHiddenCols();

        if (allow_marked === 1 && marked.length >= 1) {
            build_shortcode = build_shortcode + 'marked="' + marked + '" ';
        } else if (allow_marked === 1 && marked_manual.length) {
            build_shortcode = build_shortcode + 'marked="' + marked_manual + '" ';
        }
        if (allow_sorting === 1 && sorting.length >= 1) {
            build_shortcode = build_shortcode + 'sorting="' + sorting + '" ';
        }
        if (allow_limit === 1 && limit.length >= 1) {
            build_shortcode = build_shortcode + 'limit="' + limit + '" ';
        }
        if (allow_teamname === 1 && teamname.length >= 1) {
            build_shortcode = build_shortcode + 'team="' + teamname + '" ';
        }
        if (allow_hide_cols === 1 && hide_cols.length >= 1) {
            build_shortcode = build_shortcode + 'hide_cols="' + hide_cols + '" ';
        }
        build_shortcode = build_shortcode + 'type="' + type + '" ';
        build_shortcode = build_shortcode + 'league="' + league + '"]';
        $('.shortcode-generator #sis_handball_shortcode_generator_generated_code').val(build_shortcode);
    }

    function updateConcatenationFieldView() {
        $('#sis_handball_concatenation_league_id_description_link').html('https://sis-handball.de/default.aspx?view=Mannschaft&Liga=<code>001517000000000000000000000000000001015</code>');
    }

    function getHiddenCols() {
        var hidden_cols = '';
        $('.sis_handball_shortcode_generator_hide_cols_input').each(function () {
            if ($(this).is(':checked')) {
                hidden_cols = hidden_cols + $(this).val() + ',';
            }
        });
        hidden_cols = hidden_cols.slice(0, -1);
        return hidden_cols;
    }

    function resetHiddenCols() {
        $('.sis_handball_shortcode_generator_hide_cols_input').prop('checked', false);
    }

    /*
     * Shortcode generator ajax
     * - Get teams by direct request for easier use
     */
    $('body').on('click', '#sis_handball_shortcode_generator_fetch_teams', function () {
        var league_id = $('#sis_handball_shortcode_generator_league_id').val();
        var marked_select_field = $('#sis_handball_shortcode_generator_marked');
        $.ajax({
            method: 'POST',
            url: "/wp-admin/admin-ajax.php",
            data: {action: 'team_fetch', type: 'standings', league_id: league_id},
            beforeSend: function () {
                marked_select_field.prop('disabled', true);
            },
            success(result) {
                if (result) {
                    marked_select_field.prop('disabled', false);
                    marked_select_field.html('');
                    var marked_teams_obj = result;
                    var marked_teams_array = $.map(marked_teams_obj, function (value, index) {
                        return [value];
                    });
                    for (var i = 0; i < marked_teams_array.length; i++) {
                        marked_select_field.append('<option value="' + marked_teams_array[i] + '">' + marked_teams_array[i] + '</option>');
                    }
                    updateShortcode();
                } else {
                    $('.sis_handball_shortcode_generator_marked_toggle_manual span.hide').toggle();
                    $('.sis_handball_shortcode_generator_marked_toggle_manual span.show').toggle();
                    $('.shortcode-generator.marked-manual').toggle();
                    resetAutomaticMarkedTeams();
                }
            }
        });
    });

    /**
     * Remove team name replacements via ajax
     * 
     * @since 1.0.34
     */
    $('body').on('click', '.sis-handball-team-name-replace-delete', function () {
        var team_name_replace_id = $(this).data('replace-id');
        var trigger = $(this);
        $.ajax({
            method: 'POST',
            url: "/wp-admin/admin-ajax.php",
            data: {action: 'delete_team_name_replace', id: team_name_replace_id},
            success(result) {
                console.log(result);
                if (result == 'team_name_replace_deleted') {
                    trigger.parents('tr').fadeOut();
                }
            }
        });
    });


})(jQuery);