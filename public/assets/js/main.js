const $ = jQuery.noConflict();
const container = $('.newsletter-card-wrapper');

/**
 * Reset a previous cookie
 * @param cname - Cookie name
 *
 * @since 1.0.0
 */
function resetCookie(cname) {
    document.cookie = cname + "=; expires=Thu, 01 Jan 1970 00:00:00 GMT";
}

/**
 * Init the newsletter card hide in the bottom
 *
 * @since 1.0.0
 */
function init() {
    var height = container.outerHeight();
    container.animate({bottom: -(height) + 'px'});
}

/**
 * Open the card on scroll
 *
 * @since 1.0.0
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
 * Set a cookie
 * @param cname - Cookie name
 * @param cvalue - Cookie value
 * @param exdays - Expiration days
 *
 * @since 1.0.0
 */
function setCookie(cname, cvalue, exdays) {
    console.log('set coookie');
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

/**
 * Get expiration days with ajax
 *
 * @param cname - Cookie name (i.e. is_card_hidden)
 * @param cvalue - Cookie value (i.e. true)
 *
 * @since 1.0.0
 */
function getExdays(cname, cvalue) {
    var data = {
        'action': my_ajax_obj.action,
        '_ajax_nonce': my_ajax_obj.nonce,
        'title': this.title
    };
    $.post(
        my_ajax_obj.ajax_url,
        data,
        function (response) {
            setCookie(cname, cvalue, response);
        });
}

/**
 * Close the newsletter card on close button click and set cookie
 *
 * @since 1.0.0
 */
function closeCard() {
    //On click close card and set cookie to hide the card in next 7 days
    container.css('display', 'none');
    var key = 'is_card_hidden';
    var value = 'true';
    getExdays(key, value);
}

/**
 * Show more content after validating the email then submit the form
 * after the second click on the button
 *
 * @since 2.0.0
 */
function submitForm() {
    var i = 0;
    var form = $('.newsletter-card-wrapper #newsletter');
    var button = $('.newsletter-card-wrapper #newsletter button');
    var email = $('.newsletter-card-wrapper #newsletter #email');
    var hidden_fields = $('.newsletter-card-wrapper #newsletter .hidden-fields');
    var validator = form.validate({
        rules: {
            email: {
                required: true,
                email: true
            }
        }
    });
    button.click(function () {
        validator.element('#email');
        console.log('Button clicked');
        if (email.hasClass('valid')) {
            i++;
            hidden_fields.show('slow');
        }
        if (i > 1) {
            form.submit();
            var cname = 'is_card_hidden';
            var cvalue = true;
            var exdays = 30;

            alert('setting cookie');

            setCookie(cname, cvalue, exdays);
        }
    });
}

$(document).ready(function () {
    init();
    openCard();
    $(' .close-button').click(function () {
        closeCard();
    });
    submitForm();
});