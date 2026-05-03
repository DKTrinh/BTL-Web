<?php

class UserModel {

    private $useMock = true; // đổi false khi có DB

    public function getUsers($limit, $offset) {
        if ($this->useMock) {
            return [
                ['id'=>1,'username'=>'admin','email'=>'admin@gmail.com','status'=>1],
                ['id'=>2,'username'=>'user1','email'=>'user1@gmail.com','status'=>0],
                ['id'=>3,'username'=>'user2','email'=>'user2@gmail.com','status'=>1],
            ];
        }
    }

    public function countUsers() {
        return 3;
    }

    public function getUserById($id) {
        return [
            'id'=>$id,
            'username'=>'admin',
            'email'=>'admin@gmail.com',
            'role'=>'admin'
        ];
    }

    public function updateUser($id, $username, $email, $role) {
        return true;
    }

    public function lockUser($id) {
        return true;
    }

    public function resetPassword($id, $pass) {
        return true;
    }
}