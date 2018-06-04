var $ = jQuery.noConflict();
var container = $('.cf7nc-card-container');

/**
 * Set a cookie
 * @param cname - Cookie name
 * @param cvalue - Cookie value
 * @param exdays - Expiration days
 */
function setCookie(cname, cvalue, exdays) {
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
    var height = container.height();
    container.animate({bottom: -(height * 1.2) + 'px'});
}

/**
 * Close the newsletter card on close button click and set cookie
 */
function closeCard() {
    //On click close card and set cookie to hide the card in next 7 days
    $(' .close-button').click(function () {
        container.css('display', 'none');
        console.log('is_card_hidde added');
        setCookie('is_card_hidden', 'true', 2);
    });
}

/**
 * Open the card on scroll
 */
function openCard() {
    //Check if the cookie is set, if not show the newsletter card
    if (!document.cookie.split(';').filter(function (item) {
        return item.indexOf('is_card_hidden=true') >= 0
    }).length) {
        var scrollPos = 200;
        //On scroll show the card
        $(window).scroll(function () {
            var curScrollPos = jQuery(this).scrollTop();
            if (curScrollPos > scrollPos) {
                container.animate({bottom: "0"}, 300, 'linear');
                console.log('scrolling');
            } else {
                return
            }
            scrollPos = curScrollPos;
        });
    }
}

$(document).ready(function () {
    //resetCookie('is_card_hidden');
    console.log(document.cookie);
    init();
    openCard();
    closeCard();
});