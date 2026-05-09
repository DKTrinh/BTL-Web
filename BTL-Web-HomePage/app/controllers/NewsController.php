<?php

require_once __DIR__ . '/../core/BaseController.php';
require_once __DIR__ . '/../models/NewsModel.php';

class NewsController extends BaseController {
    private $newsModel;

    public function __construct($db) {
        parent::__construct($db);
        $this->newsModel = new NewsModel($this->db);
    }

    
    public function index() {
        
        $keyword = isset($_GET['q']) ? trim($_GET['q']) : '';
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $limit = 6; 
        
        $totalNews = $this->newsModel->countNews($keyword);
        $totalPages = ceil($totalNews / $limit);
        
        
        $newsList = $this->newsModel->getPublished($keyword, $page, $limit);

        
        $data = [
            'newsList'   => $newsList,
            'keyword'    => $keyword,
            'page'       => $page,
            'totalPages' => $totalPages,
            'totalNews'  => $totalNews
        ];

        
        $this->render('pages/news', ['data' => $data]);
    }

    
    public function detail() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;

        if (!$id) {
            $this->redirect('public_entry.php?url=news');
        }

        $newsItem = $this->newsModel->getById($id);
        
        if (!$newsItem) {
            die("<h1 style='text-align:center; padding: 50px;'>Bài viết không tồn tại.</h1>");
        }

        
        $this->render('pages/news_detail', ['news' => $newsItem]); 
    }
}