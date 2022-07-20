<?php

namespace application\controllers;

class ApiController extends Controller
{
    public function categoryList()
    {
        return $this->model->getCategoryList();
    }

    public function productInsert()
    {
        $json = getJson();
        print_r($json);
        return [_RESULT => $this->model->productInsert($json)];
    }

    public function productList2()
    {
        $result = $this->model->productList();
        return $result === false ? [] : $result;
    }

    public function productDetail()
    {
        $urlPaths = getUrlPaths();
        if (!isset($urlPaths[2])) {
            exit();
        }
        $param = [
            'product_id' => intval($urlPaths[2])
        ];
        return $this->model->productDetail($param);
    }

    public function upload()
    {
        $urlPaths = getUrlPaths();
        if (!isset($urlPaths[2]) || !isset($urlPaths[3])) {
            exit();
        }
        $productId = intval($urlPaths[2]);
        $type = intval($urlPaths[3]);
        $json = getJson();
        $image_parts = explode(";base64,", $json["image"]);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $dirPath = _IMG_PATH . "/" . $productId . "/" . $type;
        $filePath = $dirPath . "/" . uniqid() . "." . $image_type;
        if (!is_dir($dirPath)) {
            mkdir($dirPath, 0777, true);
        }
        $result = file_put_contents($filePath, $image_base64);
        if ($result) {
            $param = [
                "product_id" => $productId,
                "type" => $type,
                "path" => uniqid() . "." . $image_type
            ];
            $this->model->productImageInsert($param);
        }
        return [_RESULT => $result ? 1 : 0];
    }

    public function productImageList()
    {
        $urlPaths = getUrlPaths();
        if (!isset($urlPaths[2])) {
            exit();
        }
        $productId = intval($urlPaths[2]);
        $param = [
            "product_id" => $productId,
        ];
        return $this->model->productImageList($param);
    }

    public function productImageDelete()
    {
        $urlPaths = getUrlPaths();
        if (!isset($urlPaths[2])) {
            exit();
        }
        $result = 0;
        switch (getMethod()) {
            case _DELETE:
                //delete image file



                $param = ["product_image_id" => intval($urlPaths[2])];
                $result = $this->model->productImageDelete($param);
                break;
        }

        return [_RESULT => $result];
    }
}
