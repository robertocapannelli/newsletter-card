const $ = jQuery.noConflict();
const container = $('.cf7-nc-card-container');

/**
 * Set a cookie
 * @param cname - Cookie name
 * @param cvalue - Cookie value
 * @param exdays - Expiration days
 */
function setCookie(cname, cvalue, exdays) {

    console.log('set coookie');

    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

/**
 * Reset a previous cookie
 * @param cname - Cookie name
 */
function resetCookie(cname) {
    document.cookie = cname + "=; expires=Thu, 01 Jan 1970 00:00:00 GMT";
}

/**
 * Init the newsletter card hide in the bottom
 */
function init() {
    var height = container.outerHeight();
    container.animate({bottom: -(height) + 'px'});
}

/**
 * Close the newsletter card on close button click and set cookie
 */
function closeCard() {
    //On click close card and set cookie to hide the card in next 7 days
    container.css('display', 'none');
    var key = 'is_card_hidden';
    var value = 'true';

    getExdays(key, value);
}

/**
 * Open the card on scroll
 */
function openCard() {
    //Check if the cookie is set, if not show the newsletter card
    if (!document.cookie.split(';').filter(function (item) {
        return item.indexOf('is_card_hidden=true') >= 0
    }).length) {
        var bound = 200;
        var isVisible = false;
        //On scroll show the card
        $(window).scroll(function () {
            var currentPosition = jQuery(this).scrollTop();
            if (currentPosition > bound && !isVisible) {
                container.animate({bottom: "0"}, 300, 'linear');
                isVisible = true;
            }
        });
    }
}

/**
 * Get expiration days with ajax
 *
 * @param cname - Cookie name (i.e. is_hidden_card)
 * @param cvalue - Cookie value (i.e. true)
 */
function getExdays(cname, cvalue) {
    var data = {
        'action': my_ajax_obj.action,
        '_ajax_nonce': my_ajax_obj.nonce,
        'title' : this.title
    };
    $.post(
        my_ajax_obj.ajax_url,
        data,
        function (response) {
            setCookie(cname, cvalue, response);
        });
}

$(document).ready(function () {
    init();
    openCard();
    $(' .close-button').click(function () {
        closeCard();
    });

    /* var button = $('.cf7-nc-card-container #newsletter button');
     var email = $('#newsletter #email');
     var hidden_fields = $('.cf7-nc-card-container form .hidden-fields');

     var validator = $(".cf7-nc-card-container #newsletter").validate({
         rules: {
             email: {
                 required: true,
                 email: true
             }
         }
     });

     validator.element('#email');

     button.click(function () {
         console.log('Button clicked');
         if (email.hasClass('valid')) {
             hidden_fields.removeClass('hidden');
         }

     });*/

});