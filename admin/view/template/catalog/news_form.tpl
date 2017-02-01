<?php echo $header; ?>
    <div id="content">
        <div class="breadcrumb">
            <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <?php echo $breadcrumb['separator']; ?>
                <a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
            <?php } ?>
        </div>
        <?php if ($error_warning) { ?>
            <div class="warning"><?php echo $error_warning; ?></div>
        <?php } ?>
        <div class="box">
            <div class="heading">
                <h1>
                    <img src="view/image/news.png" alt=""/> <?php echo $heading_title; ?>
                </h1>
                <div class="buttons">
                    <a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a>
                </div>
            </div>
            <div class="content">
                <div id="tabs" class="htabs">
                    <a href="#tab-general"><?php echo $tab_general; ?></a>
                    <a href="#tab-data"><?php echo $tab_data; ?></a>
                    <a href="#tab-design"><?php echo $tab_design; ?></a>
                </div>
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
                    <div id="tab-general">
                        <div id="languages" class="htabs">
                            <?php foreach ($languages as $language) { ?>
                                <a href="#language<?php echo $language['language_id']; ?>">
                                    <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/>
                                    <?php echo $language['name']; ?>
                                </a>
                            <?php } ?>
                        </div>
                        <?php foreach ($languages as $language) { ?>
                            <div id="language<?php echo $language['language_id']; ?>">
                                <table class="form">
                                    <tr>
                                        <td><?php echo $entry_meta_keywords; ?></td>
                                        <td>
                                            <input type="text" name="news_description[<?php echo $language['language_id']; ?>][meta_keywords]" size="100" value="<?php echo isset($news_description[$language['language_id']]) ? $news_description[$language['language_id']]['meta_keywords'] : ''; ?>"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?php echo $entry_meta_description; ?></td>
                                        <td>
                                            <input type="text" name="news_description[<?php echo $language['language_id']; ?>][meta_description]" size="100" value="<?php echo isset($news_description[$language['language_id']]) ? $news_description[$language['language_id']]['meta_description'] : ''; ?>"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?php echo $entry_title; ?></td>
                                        <td>
                                            <input type="text" name="news_description[<?php echo $language['language_id']; ?>][title]" size="100" value="<?php echo isset($news_description[$language['language_id']]) ? $news_description[$language['language_id']]['title'] : ''; ?>"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?php echo $entry_h1; ?></td>
                                        <td>
                                            <input type="text" name="news_description[<?php echo $language['language_id']; ?>][h1]" size="100" value="<?php echo isset($news_description[$language['language_id']]) ? $news_description[$language['language_id']]['h1'] : ''; ?>"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="required">*</span> <?php echo $entry_caption; ?>
                                        </td>
                                        <td>
                                            <input type="text" name="news_description[<?php echo $language['language_id']; ?>][caption]" size="100" value="<?php echo isset($news_description[$language['language_id']]) ? $news_description[$language['language_id']]['caption'] : ''; ?>"/>
                                            <?php if (isset($error_caption[$language['language_id']])) { ?>
                                                <span class="error"><?php echo $error_caption[$language['language_id']]; ?></span>
                                            <?php } ?></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="required">*</span> <?php echo $entry_description; ?>
                                        </td>
                                        <td>
                    <textarea name="news_description[<?php echo $language['language_id']; ?>][description]" id="description<?php echo $language['language_id']; ?>">
                        <?php echo isset($news_description[$language['language_id']]) ? $news_description[$language['language_id']]['description'] : ''; ?>
                    </textarea>
                                            <?php if (isset($error_description[$language['language_id']])) { ?>
                                                <span class="error"><?php echo $error_description[$language['language_id']]; ?></span>
                                            <?php } ?></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="required">*</span> <?php echo $entry_content; ?>
                                        </td>
                                        <td>
                    <textarea name="news_description[<?php echo $language['language_id']; ?>][content]" id="content<?php echo $language['language_id']; ?>">
                        <?php echo isset($news_description[$language['language_id']]) ? $news_description[$language['language_id']]['content'] : ''; ?>
                    </textarea>
                                            <?php if (isset($error_content[$language['language_id']])) { ?>
                                                <span class="error"><?php echo $error_content[$language['language_id']]; ?></span>
                                            <?php } ?></td>
                                    </tr>
                                </table>
                            </div>
                        <?php } ?>
                    </div>
                    <div id="tab-data">
                        <table class="form">
                            <tr>
                                <td><?php echo $entry_store; ?></td>
                                <td>
                                    <div class="scrollbox">
                                        <?php $class = 'even'; ?>
                                        <div class="<?php echo $class; ?>">
                                            <?php if (in_array(0, $news_store)) { ?>
                                                <input type="checkbox" name="news_store[]" value="0" checked="checked"/>
                                                <?php echo $text_default; ?>
                                            <?php } else { ?>
                                                <input type="checkbox" name="news_store[]" value="0"/>
                                                <?php echo $text_default; ?>
                                            <?php } ?>
                                        </div>
                                        <?php foreach ($stores as $store) { ?>
                                            <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                                            <div class="<?php echo $class; ?>">
                                                <?php if (in_array($store['store_id'], $news_store)) { ?>
                                                    <input type="checkbox" name="news_store[]" value="<?php echo $store['store_id']; ?>" checked="checked"/>
                                                    <?php echo $store['name']; ?>
                                                <?php } else { ?>
                                                    <input type="checkbox" name="news_store[]" value="<?php echo $store['store_id']; ?>"/>
                                                    <?php echo $store['name']; ?>
                                                <?php } ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $entry_fancybox; ?></td>
                                <input type="hidden" name="fancybox" value="0">
                                <td>
                                    <input type="checkbox" value="1" name="fancybox"<?php if ($fancybox > 0) echo ' checked'; ?> >
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $entry_image; ?></td>
                                <td>
                                    <input type="hidden" name="image" value="<?php echo $image; ?>" id="image"/>
                                    <img src="<?php echo $preview; ?>" alt="" id="thumb" class="image" onclick="image_upload('image', 'thumb');"/>
                                    <br/>
                                    <a onclick="image_upload('image', 'thumb');"><?php echo $text_browse; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a id="image_remove"><?php echo $button_remove; ?></a>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $entry_keyword; ?></td>
                                <td>
                                    <input type="text" name="keyword" value="<?php echo $keyword; ?>"/>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $entry_date_start; ?></td>
                                <td>
                                    <input class="date_start" type="text" name="date_start" value="<?php echo $date_start; ?>"/>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $entry_date_end; ?></td>
                                <td>
                                    <input class="date_end" type="text" name="date_end" value="<?php echo $date_end; ?>"/>
                                    <input id="date_never" name="date_never" type="checkbox" <?php if ($date_end == 0) echo 'checked'; ?> /> <?php echo $text_date_never; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $entry_status; ?></td>
                                <td><select name="status">
                                        <?php if ($status) { ?>
                                            <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                            <option value="0"><?php echo $text_disabled; ?></option>
                                        <?php } else { ?>
                                            <option value="1"><?php echo $text_enabled; ?></option>
                                            <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                        <?php } ?>
                                    </select></td>
                            </tr>
                        </table>
                    </div>
                    <div id="tab-design">
                        <table class="list">
                            <thead>
                            <tr>
                                <td class="left"><?php echo $entry_store; ?></td>
                                <td class="left"><?php echo $entry_layout; ?></td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="left"><?php echo $text_default; ?></td>
                                <td class="left">
                                    <select name="news_layout[0][layout_id]">
                                        <option value=""></option>
                                        <?php foreach ($layouts as $layout) { ?>
                                            <?php if (isset($news_layout[0]) && $news_layout[0] == $layout['layout_id']) { ?>
                                                <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                                            <?php } else { ?>
                                                <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select></td>
                            </tr>
                            </tbody>
                            <?php foreach ($stores as $store) { ?>
                                <tbody>
                                <tr>
                                    <td class="left"><?php echo $store['name']; ?></td>
                                    <td class="left">
                                        <select name="news_layout[<?php echo $store['store_id']; ?>][layout_id]">
                                            <option value=""></option>
                                            <?php foreach ($layouts as $layout) { ?>
                                                <?php if (isset($news_layout[$store['store_id']]) && $news_layout[$store['store_id']] == $layout['layout_id']) { ?>
                                                    <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                                                <?php } else { ?>
                                                    <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                                                <?php } ?>
                                            <?php } ?>
                                        </select></td>
                                </tr>
                                </tbody>
                            <?php } ?>
                        </table>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script>
    <script type="text/javascript"><!--
        function image_upload(field, thumb) {
            $('#dialog').remove();

            $('#content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="index.php?route=common/filemanager&token=<?php echo $token; ?>&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');

            $('#dialog').dialog({
                title: '<?php echo $text_image_manager; ?>',
                close: function (event, ui) {
                    if ($('#' + field).attr('value')) {
                        $.ajax({
                            url: 'index.php?route=common/filemanager/image&token=<?php echo $token; ?>&image=' + encodeURIComponent($('#' + field).val()),
                            dataType: 'text',
                            success: function (data) {
                                $('#' + thumb).replaceWith('<img src="' + data + '" class="image" alt="" id="' + thumb + '" onclick="image_upload(\'image\', \'thumb\');" />');
                            }
                        });
                    }
                },
                bgiframe: false,
                width: 800,
                height: 400,
                resizable: false,
                modal: false
            });
        }

        $('#image_remove').click(function () {
            $("input[name='image']").val('');
            $('#thumb').attr('src', '<?php echo $no_image; ?>');
            return false;
        });

        //--></script>
    <script type="text/javascript"><!--
        <?php foreach ($languages as $language) { ?>
        CKEDITOR.replace('description<?php echo $language['language_id']; ?>', {
            filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
            filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
            filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
            filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
            filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
            filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
        });
        CKEDITOR.replace('content<?php echo $language['language_id']; ?>', {
            filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
            filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
            filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
            filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
            filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
            filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
        });
        <?php } ?>
        //--></script>
    <script type="text/javascript" src="view/javascript/jquery/ui/jquery-ui-timepicker-addon.js"></script>
    <script type="text/javascript"><!--

        old_date_end = 0;

        $('.date_start').datetimepicker({
            dateFormat: 'dd-mm-yy',
            timeFormat: 'h:m'
        });

        $('.date_end').datetimepicker({
            dateFormat: 'dd-mm-yy',
            timeFormat: 'h:m'
        });

        <?php
        if ($date_end == 0) {
            echo "$('.date_end').datepicker('disable');";
        }
        ?>


        $('#date_never').click(function () {
            if ($('#date_never').is(':checked')) {
                $('.date_end').datepicker('disable');
                old_date_end = $('.date_end').val();
                $('.date_end').val("0");
                $('.date_end').attr("readOnly", true);
            } else {
                $('.date_end').val(old_date_end);
                $('.date_end').attr("readOnly", false);
                $('.date_end').datepicker('enable');
            }
        });
        //--></script>
    <script type="text/javascript"><!--
        $('#tabs a').tabs();
        $('#languages a').tabs();
        //--></script>
<?php echo $footer; ?>