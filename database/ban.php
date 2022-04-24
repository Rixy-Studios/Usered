<?php
class Ban{
    public function checkBan($conn, $user_id){
        $query = $conn->prepare("SELECT * FROM `bans` WHERE `target`=:target");
        $query->execute([
            "target" => $user_id
        ]);
        $result = $query->fetch();
        if($result){
            return true;
        }else{
            return false;
        }
    }
    public function getBan($conn, $user_id){
        $query = $conn->prepare("SELECT * FROM `bans` WHERE `target`=:target");
        $query->execute([
            "target" => $user_id
        ]);
        return $query->fetch();
    }
    public function createBan($conn, $user_id, $reason){
        $query = $conn->prepare("INSERT INTO `bans`(target, reason) VALUES(:target, :reason)");
        $query->execute([
            "target" => $user_id,
            "reason" => $reason
        ]);
    }
    public function deleteBan($conn, $id){
        $query = $conn->prepare("DELETE FROM `bans` WHERE `target`=:id");
        $query->execute([
            "id" => $id
        ]);
    }
}