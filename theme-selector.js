$(function() {
    $('.block_theme_selector select').on('change', function(e) {
        var $select = $(e.target);
        var params = {
            'sesskey': $select.data('sesskey'),
            'device': $select.data('device'),
            'choose': $select.selected().val()
        };
        window.location = '/theme/index.php?' + $.param(params);
    });
});
