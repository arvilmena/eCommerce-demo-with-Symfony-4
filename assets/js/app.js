var App = (function(window, $) {

    var init = function() {
        hello();
        initCartCheckout();
    };

    var hello = function() {
        console.log('Hello from app.js!');
    };

    var initCartCheckout = function() {
        var $modal = $('#checkoutModal');
        if ( !$modal.length ) return;

        /**
         * Local Functions.
         */
        var modalHasError = function() {
            return $modal.hasClass('has-error');
        };
        var showModal = function() {
            $modal.modal({show: true});
        }

        /**
         * Logic
         */
        if (modalHasError()) showModal();

    };

    return {
        run: init,
    }
})(window, $);

$(document).ready(function() {
    App.run();
});
