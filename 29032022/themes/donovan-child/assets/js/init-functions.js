jQuery(document).ready(function(){
    let previousURL = document.referrer;
    jQuery('#previousPage').attr('href', previousURL);
    let url=window.location.href;
    let arr=url.split('/')[4];
    jQuery('#previousPage span').text(arr);
});