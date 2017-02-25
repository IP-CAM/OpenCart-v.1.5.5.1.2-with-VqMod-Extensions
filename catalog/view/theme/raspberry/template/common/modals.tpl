<link rel="stylesheet" type="text/css" href="catalog/view/theme/raspberry/stylesheet/main-style.css"/>

<div class="modal" id="modal" data-close='close-bl'>
    <div class="modal-content modal-content-message">
        <div class="close-btn close-btn-style-1"></div>
        <div class="mess">
            <h3>Внимание!</h3>
        </div>
        <p>Это тестовый сайт!<br>Ссылка на работающий магазин:
            <a href="http://cfe.by"><span class="mark">http://cfe.by</span></a>
        </p>
        <button type="button" class="btn-style-6">Продолжить</button>
    </div>
</div>

<script type="text/javascript">

    if (window.location.href === $("base").attr("href")) {
        $("#modal").show();
    } else {
        $("#modal").hide();
    }

    $('.close-btn').click(function () {
        $(this).closest("[data-close='close-bl']").hide();
    });

    $('#modal button').click(function () {
        $(this).closest("[data-close='close-bl']").hide();
    });
</script>