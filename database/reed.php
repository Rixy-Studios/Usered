<?php
class Reed{
    public function createReed($conn, $content, $authorid, $image_url, $video_url){
        $content = htmlspecialchars($content);
        $image_url = htmlspecialchars($image_url);
        $video_url = htmlspecialchars($video_url);
        $query = $conn->prepare("INSERT INTO reed(author, content, image_url, video_url) VALUES(:author, :content, :image_url, :video_url)");
        $query->execute([
            "author" => $authorid,
            "content" =>$content,
            "image_url" => $image_url,
            "video_url" => $video_url
        ]);
        $query = $conn->prepare("SELECT * FROM `reed` ORDER BY `id` DESC LIMIT 1");
        $query->execute();
        return $query->fetch();
    }
    public function getLatestReedsFromProfile($conn, $id){
        $query = $conn->prepare("SELECT * FROM reed WHERE `author`=:author ORDER BY `id` DESC");
        $query->execute([
            "author" => $id
        ]);
        return $query->fetchAll();
    }
    public function getReedFromID($conn, $id){
        $query = $conn->prepare("SELECT * FROM reed WHERE `id`=:id");
        $query->execute([
            "id" => $id
        ]);
        return $query->fetch();
    }
}