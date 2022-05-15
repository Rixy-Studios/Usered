<?php
class Dm{
    public function getDmAsSource($conn, $source, $conversation){
        $query = $conn->prepare("SELECT * FROM `dm` WHERE `source`=:source AND `conversation`=:conv ORDER BY id DESC");
        $query->execute([
            "source" => $source,
            "conv" => $conversation
        ]);
        return $query->fetchAll();
    }
    public function getDmAsTarget($conn, $target, $conversation){
        $query = $conn->prepare("SELECT * FROM `dm` WHERE `target`=:target AND `conversation`=:conv ORDER BY id DESC");
        $query->execute([
            "target" => $target,
            "conv" => $conversation
        ]);
        return $query->fetchAll();
    }
    public function getDmNotRead($conn, $target){
        $query = $conn->prepare("SELECT COUNT(*) FROM `dm` WHERE `target`=:target AND `new`=1");
        $query->execute([
            "target" => $target
        ]);
        $result = $query->fetch();
        return $result[0];
    }
    public function removeNotRead($conn, $id){
        $query = $conn->prepare("UPDATE `dm` SET `new`=0 WHERE `id`=:id");
        $query->execute([
            "id" => $id
        ]);
    }
    private function getNextCIDNumber($conn){
        $query = $conn->prepare("SELECT * FROM `conversation` ORDER BY id DESC LIMIT 1");
        $query->execute();
        $result = $query->fetch();
        if(!$result){
            return 1;
        }
        return $result['cid']+1;
    }
    public function createConversation($conn, $source, $target){
        $cid = $this->getNextCIDNumber($conn);
        $query = $conn->prepare("INSERT INTO `conversation`(source, target, cid) VALUES(:source, :target, :cid)");
        $query->execute([
            "source" => $source,
            "target" => $target,
            "cid" => $cid
        ]);
        $query = $conn->prepare("INSERT INTO `conversation`(source, target, cid) VALUES(:source, :target, :cid)");
        $query->execute([
            "source" => $target,
            "target" => $source,
            "cid" => $cid
        ]);
    }
    public function getConversationFromSourceAndTarget($conn, $source, $target){
        $query = $conn->prepare("SELECT * FROM `conversation` WHERE `source`=:source AND `target`=:target");
        $query->execute([
            "source" => $source,
            "target" => $target
        ]);
        return $query->fetch();
    }
    public function getConversationFromIDAndSource($conn, $id, $source){
        $query = $conn->prepare("SELECT * FROM `conversation` WHERE `source`=:source AND `cid`=:id");
        $query->execute([
            "source" => intval($source),
            "id" => intval($id)
        ]);
        return $query->fetch();
    }
    public function getAllConversationsFromSource($conn, $source){
        $query = $conn->prepare("SELECT * FROM `conversation` WHERE `source`=:source ORDER BY id DESC");
        $query->execute([
            "source" => intval($source),
        ]);
        return $query->fetchAll();
    }
    public function getLatestMessageFromConversation($conn, $conversation){
        $query = $conn->prepare("SELECT * FROM `dm` WHERE `conversation`=:conv ORDER BY `id` DESC LIMIT 1");
        $query->execute([
            "conv" => $conversation
        ]);
        return $query->fetch();
    }
    public function createDm($conn, $source, $target, $content, $conversation){
        $query = $conn->prepare("INSERT INTO `dm`(source, target, content, conversation) VALUES (:source, :target, :content, :conversation)");
        $query->execute([
            "source" => $source,
            "target" => $target,
            "content" => $content,
            "conversation" => $conversation
        ]);
    }
}