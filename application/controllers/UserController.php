<?php

namespace application\controllers;

class UserController extends controller
{
    public function signup()
    {
        // 배열로 넘어옴
        $json = getJson();
        $result = $this->model->signUp($json);
        if ($result) {
            $this->flash(_LOGINUSER, $result);
            return [_RESULT => $result];
        }
        return [_RESULT => $result];
    }
}
