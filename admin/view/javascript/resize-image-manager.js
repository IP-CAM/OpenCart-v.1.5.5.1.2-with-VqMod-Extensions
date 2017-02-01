/**
 * resize-image-manager, JavaScript Resize Image Manager
 * change size of Image Manager
 * @version 1.2
 * @author  Mi3girb
 * @created 2017-01-30
 * @updated 2017-02-01
 */


;RIM = {
    name: 'ResizeImageManager',
    imageResize: false,                    // true - image resize, default false
    options: {
        heightBox: 550,                    // image manager height, default 400px
        widthBox: "97%",                   // image manager wight, default 800px
        leftBox: "1.5%",
        differenceHeightColumn: 80,        // height column default 320px
        widthLeftColumn: "12%",            // left column wight, default 20%
        widthRightColumn: "87%",           // right column wight, default 78%
        heightImage: 50                    // image height, default 100x100px
    },
    imageManagerSetMainBoxSize: function () {
        $('.ui-dialog.ui-widget.ui-widget-content.ui-corner-all.ui-draggable')
            .css({
                width: this.options.widthBox,
                height: this.options.heightBox,
                left: this.options.leftBox
            });

        $("#dialog").css({height: this.options.heightBox});
    },
    imageManagerSetBoxColumnsSize: function () {
        $('#column-left').css({
            width: this.options.widthLeftColumn,
            height: this.options.heightBox - this.options.differenceHeightColumn
        });

        $('#column-right').css({
            width: this.options.widthRightColumn,
            height: this.options.heightBox - this.options.differenceHeightColumn
        });

        $('#column-right a').css({
            padding: 0
        });
    },
    imageManagerSetImageSize: function () {
        if (this.imageResize) {
            $('#column-right img').css({
                height: this.options.heightImage
            });
        }
    }
};