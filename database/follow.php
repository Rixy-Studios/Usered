<?php
class Follow{
    public function createFollow($conn, $source, $target){
        $query = $conn->prepare("INSERT INTO `follow`(source, target) VALUES(:source, :target)");
        $query->execute([
            "source" => $source,
            "target" => $target
        ]);
    }
    public function removeFollow($conn, $source, $target){
        $query = $conn->prepare("DELETE FROM `follow` WHERE `source`=:source AND `target`=:target");
        $query->execute([
            "source" => $source,
            "target" => $target
        ]);
    }
    public function checkFollowsAsSource($conn, $source){
        $query = $conn->prepare("SELECT COUNT(*) FROM `follow` WHERE `source`=:source");
        $query->execute([
            "source" => $source
        ]);
        $result = $query->fetch();
        return $result[0];
    }
    public function checkFollowsAsTarget($conn, $target){
        $query = $conn->prepare("SELECT COUNT(*) FROM `follow` WHERE `target`=:target");
        $query->execute([
            "target" => $target
        ]);
        $result = $query->fetch();
        return $result[0];
    }
    public function checkIfFollowing($conn, $source, $target){
        $query = $conn->prepare("SELECT * FROM `follow` WHERE `source`=:source AND `target`=:target");
        $query->execute([
            "source" => $source,
            "target" => $target
        ]);
        $result = $query->fetch();
        if(!$result){
            return false;
        }else{
            return true;
        }
    }
    public function getAllFollowsFromUser($conn, $user_id){
        $query = $conn->prepare("SELECT * FROM `follow` WHERE `source`=:user_id");
        $query->execute([
            "user_id" => $user_id
        ]);
        return $query->fetchAll();
    }
}