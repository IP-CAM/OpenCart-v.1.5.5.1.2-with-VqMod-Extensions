/**
 * video-on-page, JavaScript video on the page
 * Add video on the page and using FlowPlayer
 * @version 1.0
 * @author  Mi3girb
 * @created 2017-02-23
 * @updated 2017-02-23
 * class = ""         using link
 * class = "player"   using FlowPlayer
 * class = "default"  using browser default player and for IE
 */

$(function () {
    var ua         = detect.parse(navigator.userAgent),
        browser    = ua.browser.family,
        playerPath = "/system/flowplayer/",
        swf        = playerPath + "flowplayer.swf",
        swfHls     = playerPath + "flowplayerhls.swf";

    <!-- fix for IE(stop download video) -->
    if (browser.toUpperCase() === 'IE') {
        $("iframe.default").addClass('player');
    }

    var iFrames = $("iframe.player");

    $.each(iFrames, function (index) {
        var iFrame         = $(this),
            classes        = "flowplayer functional fixed-controls no-toggle",
            src            = iFrame.prop("src"),
            styles         = {
                width: iFrame.css("width"),
                height: iFrame.css("height")
            },
            conf           = {
                // player level
                embed: false,
                splash: false,
                swf: swf,
                swfHls: swfHls,
                autoplay: false,
                clip: {
                    // clip level
                    sources: [
                        // source level
                        {type: "video/webm", src: src},
                        {type: "video/mp4", src: src},
                        {type: "video/flash", src: src}
                    ]
                }
            },
            htmlFlowPlayer = '<div class="' + classes + '" data-index = "' + index + '" ></div>';
//          var   htmlFlowPlayer =
//                    '<div class="flowplayer functional fixed-controls no-toggle" data-embed="false" data-splash="false" data-index = "' + index + '"  data-swf="' + swf + '" data-swfHls="' + swfHls + '">'
//                    '<div class="flowplayer" data-index = "' + index + '" >'
//                    + '     <video>'
//                    + '         <source src="' + src + '" type="video/mp4">'
//                    + '         <source src="' + src + '" type="video/webm">'
//                    + '         <source src="' + src + '" type="video/flash">'
//                    + '     </video>'
//                    + '</div>',
//                conf       = {};

        if (src.replace(/^.*\//, '').lastIndexOf('.') > -1) { // has extension

            iFrame.after(htmlFlowPlayer);

            var player = $(".flowplayer[data-index='" + index + "']").css(styles);

            flowplayer(player, conf);

            iFrame.remove();
        }
    });
});