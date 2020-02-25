const $ = jQuery.noConflict();
const container = $('#newsletter-card-wrapper');
const cname = 'is_card_hidden';
const maxExDays = 1000;

/**
 * Hide the newsletter card calculating the container height
 * dynamically
 *
 * @since 1.0.0
 */
function hideCard() {
    var height = container.outerHeight();
    container.animate({bottom: -(height) + 'px'});
}

/**
 * Close the newsletter card on close button click and set cookie
 *
 * @since 1.0.0
 */
function closeCard() {
    //On click close card and set cookie to hide the card in next 7 days
    container.css('display', 'none');
    setExDays();
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
            var currentPosition = $(this).scrollTop();
            if (currentPosition > bound && !isVisible) {
                container.animate({bottom: "0"}, 300, 'linear');
                isVisible = true;
            }
        });
    }
}

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
 * Set a cookie
 * @param cname - Cookie name
 * @param cvalue - Cookie value
 * @param exdays - Expiration days
 *
 * @since 1.0.0
 */
function setCookie(cname, cvalue, exdays) {
    var d;
    var expires;

    d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

/**
 * Get expiration days with ajax
 *
 *
 * @since 1.0.0
 */
function setExDays() {
    var data = {
        'action': my_ajax_obj.action,
        '_ajax_nonce': my_ajax_obj.nonce,
        'title': this.title
    };

    $.post(
        my_ajax_obj.ajax_url,
        data,
        function (response) {
            setCookie(cname, true, response)
        }
    )
}

/**
 * Show more content after validating the email then submit the form
 * after the second click on the button
 *
 * @since 2.0.0
 */
function submitForm() {
    //TODO This is too specific for a general purpose plugin we should rethink or eliminate
    var i = 0;
    var form = $('#newsletter-card-wrapper .wpcf7-form');
    var button = $('#newsletter-card-wrapper #submit-form');
    var email = $('#newsletter-card-wrapper #email');
    var hidden_fields = $('#newsletter-card-wrapper .hidden-fields');

    var validator = form.validate({
        rules: {
            your_email: {
                required: true,
                email: true
            }
        }
    });
    button.click(function () {
        validator.element('#email');
        if (email.hasClass('valid')) {
            hidden_fields.show('slow');
            i++;

        }
        if (i > 1) {
            form.submit();
        }
    });
    document.addEventListener('wpcf7mailsent', function (event) {
        let width = container.outerWidth();

        setCookie(cname, true, maxExDays);
        container.animate({right: -(width) + 'px'});
    }, false);
}

$(document).ready(function () {
    hideCard();
    openCard();
    $(' .close-button').click(function () {
        closeCard();
    });
    submitForm();
});