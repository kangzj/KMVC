<?php

/**
 * 
 * @author Kangzengji
 * @date 2012-02-22
 */
class KView {

    private $controller = '';
    private $view_name = '';

    //constructor
    public function __construct($controller) {
        $this->controller = $controller;
    }

    /**
     * display the view file
     */
    public function display($view_name = '') {
        $data = $this->controller->getData();
        //set the vars
        if (is_array($data)) {
            foreach ($data as $key => $val) {
                $$key = $val;
            }
        }
        //load the view file
        if ($view_name == '') {
            $view_name = $this->controller->getDispatcher()->getControllerName() . $this->controller->getDispatcher()->getActionName();
            $this->view_name = strtolower($view_name);
        }
        $lang = $this->controller->getRequest()->getGetParam('lang');
        if(!$lang){
            $lang = 'en';
        }
        require KMVC_APPDIR . 'language/' . $lang . '.php';
        $lang = &$_LANGUAGE [$lang];
        $view_file_name = KMVC_APPDIR . 'view' . DS . $this->view_name . '.php';
        //if the view file exists, load it. if not, do nothing.
        if (file_exists($view_file_name)) {
            require $view_file_name;
        }
    }

}