<div id="footer">
    <?php if ($informations) { ?>
        <div class="column">
            <h3><?php echo $text_information; ?></h3>
            <ul>
                <!--                <?php /*foreach ($informations as $information) { */ ?>
                    <li>
                        <a href="<?php /*echo $information['href']; */ ?>"><?php /*echo $information['title']; */ ?></a>
                    </li>
                --><?php /*} */ ?>
                <li><a href="/">Главная</a></li>
                <li><a href="/about_us">О нас</a></li>
                <li><a href="/delivery_information">Доставка и оплата</a></li>
                <li><a href="<?= $contact; ?>">Контакты</a></li>
                <li>
                    <a href="<?= $manufacturer; ?>"><?= $text_manufacturer; ?></a>
                </li>
            </ul>
        </div>
    <?php } ?>
    <!--    <div class="column">
        <h3><?php /*echo $text_service; */ ?></h3>
        <ul>
            <li><a href="<?php /*echo $contact; */ ?>"><?php /*echo $text_contact; */ ?></a></li>
            <li><a href="<?php /*echo $return; */ ?>"><?php /*echo $text_return; */ ?></a></li>
            <li><a href="<?php /*echo $sitemap; */ ?>"><?php /*echo $text_sitemap; */ ?></a></li>
        </ul>
    </div>-->
    <!--    <div class="column">
        <h3><?php /*echo $text_extra; */ ?></h3>
        <ul>
            <li>
                <a href="<?php /*echo $manufacturer; */ ?>"><?php /*echo $text_manufacturer; */ ?></a>
            </li>
            <li>
                <a href="<?php /*echo $voucher; */ ?>"><?php /*echo $text_voucher; */ ?></a>
            </li>
            <li>
                <a href="<?php /*echo $affiliate; */ ?>"><?php /*echo $text_affiliate; */ ?></a>
            </li>
            <li>
                <a href="<?php /*echo $special; */ ?>"><?php /*echo $text_special; */ ?></a>
            </li>
        </ul>
    </div>-->
    <div class="column">
        <h3><?php echo $text_account; ?></h3>
        <ul>
            <li>
                <a href="<?php echo $account; ?>"><?php echo $text_account; ?></a>
            </li>
            <li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a>
            </li>
            <li>
                <a href="<?php echo $wishlist; ?>"><?php echo $text_wishlist; ?></a>
            </li>
            <!--            <li><a href="--><?php //echo $newsletter; ?><!--">--><?php //echo $text_newsletter; ?><!--</a></li>-->
        </ul>
    </div>
    <div class="details">
        <h3>Реквизиты</h3>
        <ul>
            <li>
                ИП Леоненко Александр Александрович<br>
                УНП 291218069, Свидетельство о гос. регистрации ИП № 0390224 выдано Администрацией Московского р-на г. Бреста 22.05.2013г.
            </li>
            <li>
                <span class="icon-foot-phone"></span>
                <span class="f-w_b">Тел.:</span>
                +375 (29) <span class="d_n">−</span> 5-226-226 МТС,
                +375 (44) <span class="d_n">−</span> 7-822-522 Velcom
            </li>
            <li>
                <span class="icon-foot-email"></span>
                <span class="f-w_b">Email:</span> info@modeja.by
            </li>
            <li>
                <span class="icon-foot-skype"></span>
                <span class="f-w_b">Skype:</span> Modeja.by
            </li>
            <li>
                Интернет-магазин "МОдЁжа" - modeja.by - зарегистрирован в Торговом реестре Республики Беларусь 12.09.2013г.
            </li>

            <!--Load star rating-->
        </ul>
    </div>
    
    <div class="grid grid-15" style="margin-top: -30px;">
        <h3>Мы в соцсетях</h3>
        <a href="//vk.com" class="ico-soc-vk" target="_blank"></a>
        <a href="//www.instagram.com" class="ico-soc-f" target="_blank"></a>
        <a href="//ok.ru" class="ico-soc-ok" target="_blank"></a>
    </div>

</div>
<!--
OpenCart is open source software and you are free to remove the powered by OpenCart if you want, but its generally accepted practise to make a small donation.
Please donate via PayPal to donate@opencart.com
//-->
<div id="powered"><?php echo $powered; ?></div>
<!--
OpenCart is open source software and you are free to remove the powered by OpenCart if you want, but its generally accepted practise to make a small donation.
Please donate via PayPal to donate@opencart.com
//-->
</div>
</body></html>