<?php
class User{
    public function getUserFromUsername($conn, $username){
        $query = $conn->prepare("SELECT * FROM `user` WHERE `username`=:username");
        $query->execute([
            "username" => $username
        ]);
        return $query->fetch();
    }
    public function getUserFromEmail($conn, $email){
        $query = $conn->prepare("SELECT * FROM `user` WHERE `email`=:email");
        $query->execute([
            "email" => $email
        ]);
        return $query->fetch();
    }
    public function getUserFromID($conn, $id){
        $query = $conn->prepare("SELECT * FROM `user` WHERE `id`=:id");
        $query->execute([
            "id" => $id
        ]);
        return $query->fetch();
    }
    public function getUserFromToken($conn, $token){
        $query = $conn->prepare("SELECT * FROM `tokens` WHERE `token`=:token");
        $query->execute([
            "token" => $token
        ]);
        $result = $query->fetch();
        return $this->getUserFromID($conn, $result['user']);
    }
    public function update($conn, $field, $value, $id, $nohtml){
        //retarded but works
        if($nohtml){
            $value = htmlspecialchars($value);
        }
        $query = $conn->prepare("UPDATE `user` SET `".$field."`=:value WHERE `id`=:id");
        $query->execute([
            "value" => $value,
            "id" => $id
        ]);
    }
    public function createUser($conn, $username, $email, $password){
        $usernamechk = $this->getUserFromUsername($conn, $username);
        if($usernamechk){
            return "ALREADY_TAKEN_USERNAME";
        }
        $emailchk = $this->getUserFromEmail($conn, $email);
        if($emailchk){
            return "ALREADY_TAKEN_EMAIL";
        }
        $hashpass = password_hash($password, PASSWORD_BCRYPT);
        $query = $conn->prepare("INSERT INTO `user`(`username`, `password`, `email`) VALUES(:username, :password, :email)");
        $query->execute([
            "username" => $username,
            "password" => $hashpass,
            "email" => $email
        ]);
        return "OK";
    }
    public function login($conn, $utils, $username, $password){
        // check
        $check = $this->getUserFromUsername($conn, $username);
        if(!empty($check)){
            if(password_verify($password, $check['password'])){
                $token = $utils->tokenGen();
                $query = $conn->prepare("INSERT INTO `tokens`(`user`, `token`) VALUES(:userid, :token)");
                $query->execute([
                    "userid" => $check['id'],
                    "token" => $token
                ]);
                $_SESSION['token'] = $token;
                return "OK";
            }else{
                return "INVALID_PASSWORD";
            }
        }else{
            return "INVALID_USER";
        }
    }
}