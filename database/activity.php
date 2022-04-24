<?php
class Activity{
    public function getLatestActivities($conn){
        $query = $conn->prepare("SELECT * FROM `activity` ORDER BY `id` DESC LIMIT 5");
        $query->execute();
        return $query->fetchAll();
    }
    public function getLatestActivitiesFromUser($conn, $user_id){
        $query = $conn->prepare("SELECT * FROM `activity` WHERE `source`=:source ORDER BY `id` DESC LIMIT 5");
        $query->execute([
            "source" => $user_id
        ]);
        return $query->fetchAll();
    }
    public function getActivityFromID($conn, $actid){
        $query = $conn->prepare("SELECT * FROM `activity` WHERE `id`=:id");
        $query->execute([
            "id" => $actid
        ]);
        return $query->fetch();
    }
    public function getUserFromActivity($conn, $actid){
        $act = $this->getActivityFromID($conn, $actid);
        $query = $conn->prepare("SELECT * FROM `user` WHERE `id`=:id");
        $query->execute([
            "id" => $act['source']
        ]);
        return $query->fetch();
    }
    public function addActivity($conn, $type, $source, $target){
        $query = $conn->prepare("INSERT INTO activity(type, source, target) VALUES(:type, :source, :target)");
        $query->execute([
            "type" => $type,
            "source" => $source,
            "target" => $target
        ]);
    }
    public function addActivityWithExtra($conn, $type, $source, $target, $extra){
        $query = $conn->prepare("INSERT INTO activity(type, source, target, extra) VALUES(:type, :source, :target, :extra)");
        $query->execute([
            "type" => $type,
            "source" => $source,
            "target" => $target,
            "extra" => $extra
        ]);
    }
}