<?php
?>

<!-- Detect.js is a JavaScript library to detect platforms, versions, manufacturers and types based on the navigator.userAgent string -->
<script src="/catalog/view/javascript/detect.js"></script>

<!--
HLS	application/x-mpegurl	HTTP	html5
HLS	application/x-mpegurl	HTTP	flash
WebM	video/webm	HTTP	html5
MP4	video/mp4	HTTP	html5
MP4	video/flash	RTMP	flash
OGG	video/ogg	HTTP	html5
FLV	video/flash	RTMP	flash
MP4	video/mp4	HTTP	flash
FLV	video/flash	HTTP	flash
-->

<!-- player skin -->
<link rel="stylesheet" href="/system/flowplayer/skin/functional.css">
<!-- include flowplayer -->
<script src="/system/flowplayer/flowplayer.min.js"></script>

<style type="text/css">
    /* custom player skin */
    .flowplayer {
        /*width : 50%;*/
        /*max-width : 800px;*/
    }

    .flowplayer .fp-controls {
        background-color : rgba(17, 17, 17, 1)
    }

    .flowplayer .fp-timeline {
        background-color : rgba(204, 204, 204, 1)
    }

    .flowplayer .fp-progress {
        background-color : rgba(0, 167, 200, 1)
    }

    .flowplayer .fp-buffer {
        background-color : rgba(249, 249, 249, 1)
    }
</style>

<script type="text/javascript">
    $(function () {

        var ua      = detect.parse(navigator.userAgent);
        var browser = ua.browser.family;

        var playerPath = "/system/flowplayer/",
            swf        = playerPath + "flowplayer.swf",
            swfHls     = playerPath + "flowplayerhls.swf";

        <!-- fix for IE(stop download video) -->
        if (browser.toUpperCase() == 'IE') {
            $("iframe.default").addClass('player');
        }

        var iFrames = $("iframe.player");

        $.each(iFrames, function (index) {

            var iFrame     = $(this);
            var src        = iFrame.attr("src"),
                styles     = {
                    width: iFrame.css("width"),
                    height: iFrame.css("height")
                };
            var flowPlayer =
                    '<div class="flowplayer functional fixed-controls no-toggle" data-splash="false" data-index = "' + index + '"  data-swf="' + swf + '" data-swfHls="' + swfHls + '">'
                    + '     <video flashstopped="true">'
                    + '         <source src="' + src + '" type="video/mp4">'
                    + '         <source src="' + src + '" type="video/flv">'
                    + '         <source src="' + src + '" type="video/m4v">'
                    + '     </video>'
                    + '</div>';

            iFrame.after(flowPlayer);

            var player = $(".flowplayer[data-index='" + index + "']");
            player.css(styles).flowplayer();

            iFrame.remove();

            /*
             var conf = {
             adaptiveRatio: true,
             autoplay: false,
             splash: false,
             //            ratio: 0.4167,
             swf: swf,
             swfHls: swfHls,
             clip: {
             sources: [
             {type: "video/mp4", src: src}
             ]
             }
             };
             $("#player").flowplayer(conf).css(styles);
             */
        });
    })
    ;
</script>