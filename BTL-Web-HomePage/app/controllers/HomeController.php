<?php
require_once '../app/models/ProductModel.php';
require_once '../app/models/NewsModel.php';

class HomeController {
    public function index() {
        $productModel = new ProductModel();
        $newsModel = new NewsModel();

        $technologies = $productModel->getCoreTechnologies();
        $stories = $newsModel->getSuccessStories();

        require_once '../app/views/home/index.php';
    }
}