
jQuery(function($) {
    var img = new Image(), imgW, imgH, newW, newH, minH;
    //img.src = $('.hero').css('background-image').replace('url(', '').replace(/'/, '').replace(')', '').replace('"','').replace('"','');
    function doResize() {
        imgW = img.width;
        imgH = img.height;
        if(imgW > imgH) {
            newW = $('.hero').width();
            newH = imgH / imgW * newW;
        } else {
            newH = $('.hero').height();
            newW = imgW / imgH * newH;
        }
        $('.hero').css('height', (newH)+'px');
    }

    $(window).load(function(){
        doResize();
        $(window).on('resize', doResize);
    });
});
