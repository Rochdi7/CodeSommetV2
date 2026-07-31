(function () {
    if (typeof toastr === 'undefined') return;

    toastr.options = {
        closeButton: true,
        debug: false,
        newestOnTop: true,
        progressBar: true,
        positionClass: 'toast-top-right',
        preventDuplicates: true,
        showDuration: 300,
        hideDuration: 300,
        timeOut: 5000,
        extendedTimeOut: 2000,
        showEasing: 'swing',
        hideEasing: 'linear',
        showMethod: 'fadeIn',
        hideMethod: 'fadeOut'
    };
})();
