/*
* Custom jQuery file for fixing menus to top
*/

/* https://stackoverflow.com/questions/22541364/sticky-navbar-onscroll*/


jQuery(window).bind('scroll', function () {
    if (jQuery(window).scrollTop() > 50 && jQuery( window ).width() > 767) {
        jQuery('.responsive-blog-nav').addClass('navbarfixed');
        jQuery('.responsive_blog_top_menu').addClass('topmenufixed');
        jQuery('.top-widget').addClass('topwidgetfixed');
    } else {
        jQuery('.responsive-blog-nav').removeClass('navbarfixed');
        jQuery('.responsive_blog_top_menu').removeClass('topmenufixed');
        jQuery('.top-widget').removeClass('topwidgetfixed');
    }
    
    if (jQuery(window).scrollTop() > 100 && jQuery( window ).width() < 767) {
        jQuery('.navbar-toggle').addClass('navbartogglefixed');
    } else {
        jQuery('.navbar-toggle').removeClass('navbartogglefixed');
    }
});
