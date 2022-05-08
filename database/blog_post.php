<?php
class BlogPost{
    public function getBlogPostFromID($conn, $id){
        $query = $conn->prepare("SELECT * FROM `blogpost` WHERE `id`=:id");
        $query->execute([
            "id" => $id
        ]);
        return $query->fetch();
    }
    public function createBlogPost($conn, $title, $content, $banner_url,$author){
        $query = $conn->prepare("INSERT INTO `blogpost`(author, title, content, banner_url) VALUES(:author, :title, :content, :banner_url)");
        $query->execute([
            "author" => $author,
            "title" => $title,
            "banner_url" => $banner_url,
            "content" => $content
        ]);
        $query = $conn->prepare("SELECT * FROM `blogpost` ORDER BY `id` DESC LIMIT 1");
        $query->execute();
        return $query->fetch();
    }
}