var $ = jQuery.noConflict();

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

$(document).ready(function () {

    var container = $('.cf7nc-card-container');
    var height = container.height();

    //TODO dynamic height container to avoid problem with form with more than one field

    //resetCookie('is_card_hidden');
    console.log(document.cookie);
    //Check if the cookie is set, if not show the newsletter card
    if (!document.cookie.split(';').filter(function (item) {
        return item.indexOf('is_card_hidden=true') >= 0
    }).length) {
        var scrollPos = 200;
        //On scroll show the card
        $(window).scroll(function () {
            var curScrollPos = jQuery(this).scrollTop();
            if (curScrollPos > scrollPos) {
                $('.cf7nc-card-container').addClass('visible');
                console.log('scrolling');
            } else {
                return
            }
            scrollPos = curScrollPos;
        });
    }
    //On click close card and set cookie to hide the card in next 7 days
    $(' .close-button').click(function () {
        container.removeClass('visible');
        setCookie('is_card_hidden', 'true', 7);
    });
});