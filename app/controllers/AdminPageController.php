<?php
// app/controllers/AdminPageController.php
require_once 'app/models/PageModel.php';

class AdminPageController {
    public function editAbout() {
        $model = new PageModel();
        $data = $model->getPageData('about');
        include 'app/views/admin/pages/about.php';
    }

    public function updateAbout() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $content = $_POST['content'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $imagePath = null;

            // Xử lý upload ảnh lên server 
            if (isset($_FILES['logo']) && $_FILES['logo']['error'] === 0) {
                $targetDir = "public/assets/uploads/";
                $fileName = time() . "_" . $_FILES["logo"]["name"];
                if (move_uploaded_file($_FILES["logo"]["tmp_name"], $targetDir . $fileName)) {
                    $imagePath = "/assets/uploads/" . $fileName;
                }
            }

            (new PageModel())->updatePage('about', $content, $phone, $address, $imagePath);
            header("Location: /admin/about?msg=success");
        }
    }
}