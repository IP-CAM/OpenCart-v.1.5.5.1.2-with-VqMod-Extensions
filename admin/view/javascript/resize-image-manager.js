/**
 * resize-image-manager, JavaScript Resize Image Manager
 * change size of Image Manager
 * @version 1.3
 * @author  Mi3girb
 * @created 2017-01-30
 * @updated 2017-02-02
 */

;RIM = {
    name: 'ResizeImageManager',
    imageResize: false,                    // true - image resize, default false
    options: {
        heightBox: "550px",                // image manager height, default 400px
        widthBox: "97%",                   // image manager wight, default 800px
        differenceHeightColumn: "80px",    // height column default 320px
        widthLeftColumn: "12%",            // left column wight, default 20%
        widthRightColumn: "87%",           // right column wight, default 78%
        heightImage: "50px"                // image height, default 100x100px (ignore if imageResize is false)
    },
    _getMeasure: function (a) {
        return /[a-z%]+/i.exec(a)[0]
    },
    imageManagerSetMainBoxSize: function () {
        var measureWidthBox = this._getMeasure(this.options.widthBox);

        $('.ui-dialog.ui-widget.ui-widget-content.ui-corner-all.ui-draggable')
            .css({
                width: this.options.widthBox,
                height: this.options.heightBox,
                left: (100 - parseFloat(this.options.widthBox)) / 2 + measureWidthBox // horizontal alignment: (100% - 97%)/2
            });

        $("#dialog").css({height: this.options.heightBox});
    },
    imageManagerSetBoxColumnsSize: function () {
        var columnHeight = parseFloat(this.options.heightBox) - parseFloat(this.options.differenceHeightColumn) + this._getMeasure(this.options.heightBox);
        $('#column-left').css({
            width: this.options.widthLeftColumn,
            height: columnHeight
        });

        $('#column-right').css({
            width: this.options.widthRightColumn,
            height: columnHeight
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