jQuery(function ($) {
    $('form.import').on('submit', function () {
        var $btn = $(this).find('button[type="submit"]');
        $btn.prop('disabled', true);
        $btn.text('Working...');
        return true;
    });
});
