<?php
class Feedback{
    public function createFeedback($conn, $title, $content, $author){
        $query = $conn->prepare("INSERT INTO `feedback`(author, title, content) VALUES(:author, :title, :content)");
        $query->execute([
            "author" => $author,
            "title" => $title,
            "content" => $content
        ]);
    }
    public function getAllFeedbacks($conn){
        $query = $conn->prepare("SELECT * FROM `feedback` ORDER BY `id` DESC");
        $query->execute();
        return $query->fetchAll();
    }
    public function removeFeedback($conn, $id){
        $query = $conn->prepare("DELETE FROM `feedback` WHERE `id`=:id");
        $query->execute([
            "id" => $id
        ]);
    }
}