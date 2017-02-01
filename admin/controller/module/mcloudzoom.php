<?php

class ControllerModulemcloudzoom extends Controller {

    private $error = array();

    public function index() {
        $this->load->language('module/mcloudzoom');
        $this->document->setTitle($this->language->get('heading_title1'));
        $theme_popups = array('pp_default', 'light_rounded', 'dark_rounded', 'light_square', 'dark_square', 'facebook');
        $animation_speeds = array('fast', 'slow', 'normal');
        $show_titles = array('true', 'false');
        $autoplay_slideshows = array('true', 'false');
        $allow_resizes = array('true', 'false');
        $show_title_cloud_zooms = array('true', 'false');
        $show_social_buttons = array('true', 'false');
        $show_popup_buttons = array('true', 'false');
        $show_carousels = array('true', 'false');
        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

            $this->request->post['theme'] = in_array($this->request->post['theme'], $theme_popups) ? $this->request->post['theme'] : 'pp_default';
            $this->request->post['animation_speed'] = in_array($this->request->post['animation_speed'], $animation_speeds) ? $this->request->post['animation_speed'] : 'normal';
            $this->request->post['show_border_cloud_zoom'] = (int) $this->request->post['show_border_cloud_zoom'];
            $this->request->post['color_border_cloud_zoom'] = isset($this->request->post['color_border_cloud_zoom']) ? $this->request->post['color_border_cloud_zoom'] : '#ffffff';
            $this->request->post['opacity'] = ($this->request->post['opacity'] >= 0 && $this->request->post['opacity'] <= 1) ? $this->request->post['opacity'] : '0.8';
            $this->request->post['slideshow'] = (int) $this->request->post['slideshow'];
            $this->request->post['resize_cloud_zoom'] = (int) $this->request->post['resize_cloud_zoom'];

            $this->model_setting_setting->editSetting('mcloudzoom', $this->request->post);


            $this->session->data['success'] = $this->language->get('text_success');

            $this->redirect($this->url->link('module/mcloudzoom', 'token=' . $this->session->data['token'], 'SSL'));
        }

        $this->data['heading_title'] = $this->language->get('heading_title1');
        //WWw.MMOsolution.com config data -- DO NOT REMOVE--- 
        $this->data['MMOS_version'] = '4.2';
        $this->data['MMOS_code_id'] = 'MMOSOC112';

        $this->data['text_ThemePopup'] = $this->language->get('text_ThemePopup');
        $this->data['text_animation_speed'] = $this->language->get('text_animation_speed');
        $this->data['text_autoplay_slideshow'] = $this->language->get('text_autoplay_slideshow');
        $this->data['text_opacity'] = $this->language->get('text_opacity');
        $this->data['text_show_title'] = $this->language->get('text_show_title');
        $this->data['text_allow_resize'] = $this->language->get('text_allow_resize');
        $this->data['text_slideshow'] = $this->language->get('text_slideshow');
        $this->data['text_show_title_cloud_zoom'] = $this->language->get('text_show_title_cloud_zoom');
        $this->data['text_border_cloud_zoom'] = $this->language->get('text_border_cloud_zoom');
        $this->data['color_border_cloud_zoom'] = $this->language->get('color_border_cloud_zoom');
        $this->data['text_resize_cloud_zoom'] = $this->language->get('text_resize_cloud_zoom');
        $this->data['text_show_social_button'] = $this->language->get('text_show_social_button');
        $this->data['text_show_popup_button'] = $this->language->get('text_show_popup_button');
        $this->data['text_show_carousel'] = $this->language->get('text_show_carousel');
        $this->data['tab_setting'] = $this->language->get('tab_setting');
        $this->data['tab_support'] = $this->language->get('tab_support');

        $this->data['button_save'] = $this->language->get('button_save');
        $this->data['button_cancel'] = $this->language->get('button_cancel');

        $this->data['mcloudzooms'] = $this->model_setting_setting->getSetting('mcloudzoom');
        $this->data['themes'] = $theme_popups;
        $this->data['animation_speeds'] = $animation_speeds;
        $this->data['show_titles'] = $show_titles;
        $this->data['autoplay_slideshows'] = $autoplay_slideshows;
        $this->data['allow_resizes'] = $allow_resizes;
        $this->data['show_title_cloud_zooms'] = $show_title_cloud_zooms;
        $this->data['show_social_buttons'] = $show_social_buttons;
        $this->data['show_popup_buttons'] = $show_popup_buttons;
        $this->data['show_carousels'] = $show_carousels;


        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }

        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_module'),
            'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title1'),
            'href' => $this->url->link('module/mcloudzoom', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $this->data['action'] = $this->url->link('module/mcloudzoom', 'token=' . $this->session->data['token'], 'SSL');

        $this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

        $this->data['token'] = $this->session->data['token'];


        $this->load->model('design/layout');

        $this->data['layouts'] = $this->model_design_layout->getLayouts();



        $this->template = 'module/mcloudzoom.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }

    private function validate() {
        if (!$this->user->hasPermission('modify', 'module/mcloudzoom')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

    public function uninstall() {
        if ($this->user->hasPermission('modify', 'extension/module')) {
            $this->load->model('setting/setting');
            $this->model_setting_setting->editSetting('mcloudzoom', array('mcloudzoom_status' => 0));
            $this->db->query("DELETE FROM " . DB_PREFIX . "setting WHERE `group` = 'mcloudzoom'");
            $this->vqmod_protect();
        }
    }

    public function install() {
        if ($this->user->hasPermission('modify', 'extension/module')) {
            $this->load->model('setting/setting');
            $this->model_setting_setting->editSetting('mcloudzoom', array('mcloudzoom_status' => 1, 'show_title' => 'true', 'show_title_cloud_zoom' => 'false', 'autoplay_slideshow' => 'true', 'animation_speed' => 'normal', 'slideshow' => '5000', 'theme' => 'pp_default', 'allow_resize' => 'true', 'opacity' => '0.8', 'show_border_cloud_zoom' => '1', 'color_border_cloud_zoom' => '#ffffff', 'resize_cloud_zoom' => 300, 'show_social_button' => 'true', 'show_popup_button' => 'true', 'show_carousel' => 'true'));
            $this->vqmod_protect(1);

            $this->redirect($this->url->link('module/mcloudzoom', 'token=' . $this->session->data['token'], 'SSL'));
        }
    }

    protected function vqmod_protect($action = 0) {
        // action 1 =  install; 0: uninstall
        $vqmod_file = 'MMOSolution_cloud_zoom_pretty_photos.xml';
        if ($this->user->hasPermission('modify', 'extension/module')) {
            $MMOS_ROOT_DIR = substr(DIR_APPLICATION, 0, strrpos(DIR_APPLICATION, '/', -2)) . '/vqmod/xml/';
            if ($action == 1) {
                if (is_file($MMOS_ROOT_DIR . $vqmod_file . '_mmosolution')) {
                    @rename($MMOS_ROOT_DIR . $vqmod_file . '_mmosolution', $MMOS_ROOT_DIR . $vqmod_file);
                }
            } else {
                if (is_file($MMOS_ROOT_DIR . $vqmod_file)) {
                    @rename($MMOS_ROOT_DIR . $vqmod_file, $MMOS_ROOT_DIR . $vqmod_file . '_mmosolution');
                }
            }
        }
    }

}

?>