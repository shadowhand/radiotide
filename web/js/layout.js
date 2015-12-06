jQuery(function ($) {
    $('form.import').on('submit', function () {
        var $btn = $(this).find('button[type="submit"]');
        $btn.prop('disabled', true);
        $btn.text('Working...');
        return true;
    });
    $('a#logout').on('click', function () {
        return confirm('Are you sure you want to log out?');
    });
});
