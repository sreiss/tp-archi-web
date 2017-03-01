<?php

include 'base.controller.php';
include BASEPATH . '/models/breadcrumb.model.php';

class ErrorController extends BaseController {

    function index() {
        http_response_code(404);
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            echo json_encode([
                'error' =>  'Not found'
            ]);
        } else {
            $this->render('error.php', [
                'page_title' => 'Error'
            ]);
        }
    }

}