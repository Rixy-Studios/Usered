<?php
class App{
    public function createAppToken($conn, $utils, $userid){
        $token = $utils->tokenGen();
        $query = $conn->prepare("INSERT INTO `app_tokens`(user_id, token, usage_num) VALUES(:user_id, :token, 0)");
        $query->execute([
            "user_id" => $userid,
            "token" => $token
        ]);
        return $token;
    }
    public function getAppFromID($conn, $app_id){
        $query = $conn->prepare("SELECT * FROM `app_link` WHERE `appid`=:id");
        $query->execute([
            "id" => $app_id
        ]);
        return $query->fetch();
    }
    public function getAllApps($conn){
        $query = $conn->prepare("SELECT * FROM `app_link` ORDER BY `appid` DESC");
        $query->execute();
        return $query->fetchAll();
    }
    public function getTokenFromToken($conn, $token){
        $query = $conn->prepare("SELECT * FROM `app_tokens` WHERE `token`=:token");
        $query->execute([
            "token" => $token
        ]);
        return $query->fetch();
    }
    public function updateUsedCount($conn, $token){
        $result = $this->getTokenFromToken($conn, $token);
        $query = $conn->prepare("UPDATE `app_tokens` SET `usage_num`=:usagenum WHERE `token`=:token");
        $query->execute([
            "usagenum" => $result['usage_num'] + 1,
            "token" => $token
        ]);
        $result = $this->getTokenFromToken($conn, $token);
        if($result['usage_num']==3){
            $query = $conn->prepare("DELETE FROM `app_tokens` WHERE `token`=:token");
            $query->execute([
                "token" => $token
            ]);
        }
    }
}