const $ = jQuery.noConflict();
const container = $('.cf7-nc-card-container');

/**
 * Set a cookie
 * @param cname - Cookie name
 * @param cvalue - Cookie value
 * @param exdays - Expiration days
 */
function setCookie(cname, cvalue, exdays) { //TODO this doesn't working see dev.steliomlaori.it
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

/**
 * Reset a previous cookie
 * @param cname
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
    getExdays('is_card_hidden', 'true');
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
 */
function getExdays(cname, cvalue) {
    $.post(my_ajax_obj.ajax_url, {
        _ajax_nonce: my_ajax_obj.nonce,
        action: "cf7_nc_get_cookie_option",
        title: this.value
    }, function (data) {
        setCookie(cname, cvalue, data)
    });
}

$(document).ready(function () {
    init();
    openCard();
    $(' .close-button').click(function () {
        closeCard();
    });
});