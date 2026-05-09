<?php
class AdminCommentController extends BaseController {

    public function index() {
        if ($_SESSION['role'] !== 'admin') { header('Location: /login'); exit; }
        $model = new CommentModel();
        $page  = max(1, (int)($_GET['page'] ?? 1));
        $this->view('admin/comments/index', [
            'comments'   => $model->getAllAdmin($page, 10),
            'totalPages' => ceil($model->countAll() / 10),
            'page'       => $page,
        ]);
    }

    public function updateStatus() {
        if ($_SESSION['role'] !== 'admin') exit;
        $id     = (int)($_POST['id'] ?? 0);
        $status = $_POST['status'] ?? '';
        if (in_array($status, ['approved','pending','spam'])) {
            (new CommentModel())->updateStatus($id, $status);
        }
        header('Location: /admin/comments'); exit;
    }

    public function delete() {
        if ($_SESSION['role'] !== 'admin') exit;
        $id = (int)($_POST['id'] ?? 0);
        (new CommentModel())->delete($id);
        header('Location: /admin/comments'); exit;
    }
}