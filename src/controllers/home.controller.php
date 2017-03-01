<?php

include 'base.controller.php';
include BASEPATH . '/models/breadcrumb.model.php';

class HomeController extends BaseController {

    public function index() {
        $this->render('home.php', [
            'page_title' => 'Home',
            'breadcrumbs' => [
                new Breadcrumb('Home', HOST, true)
            ]
        ]);
    }

}