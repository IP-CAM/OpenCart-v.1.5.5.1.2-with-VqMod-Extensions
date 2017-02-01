/**
 * resize-image-manager, JavaScript Resize Image Manager
 * change size of Image Manager
 * @version 1.1
 * @author  Mi3girb
 * @created 2017-01-30
 */


;RIM = {
    name: 'ResizeImageManager',
    options: {
        heightBox: 550,                     // default 400
        widthBox: "97%",                    // default 800
        leftBox: "1.5%",
        differenceHeightColumn: 80,        // height column default 320
        widthLeftColumn: "12%",            // default 20%
        widthRightColumn: "87%"            // default 78%
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
            padding: 0,
            // height: "80px",
            // wight:"80px"
        });

    }

};