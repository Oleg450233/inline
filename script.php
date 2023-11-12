<?php
$post_count = 0;
$comment_count = 0;


$user='nachalnikovk';
$password='nachalnikovk';
$db='db';
$host='localhost';
$port='3306';

$dsn='mysql:host='.$host.';dbname='.$db.';port='.$port;
$pdo=new PDO($dsn,$user,$password);

$jsonStringPosts = file_get_contents('https://jsonplaceholder.typicode.com/posts');
$jsonArrayPosts = json_decode($jsonStringPosts, true);

$jsonStringComments = file_get_contents('https://jsonplaceholder.typicode.com/comments');
$jsonArrayComments = json_decode($jsonStringComments, true);

foreach ($jsonArrayPosts as $el)
{
    $sql="INSERT INTO `post` (id,userId,title, body) VALUES (?, ?, ?, ?)";
    $query=$pdo->prepare($sql);
    $query-> execute([$el['id'], $el['userId'], $el['title'], $el['body']]);
    $post_count +=1;
}
foreach ($jsonArrayComments as $el)
{
    $sql="INSERT INTO comment ( id,postId, name, email, body) VALUES (?, ?, ?, ?, ?)";
    $query = $pdo -> prepare($sql);
    $query -> execute([$el['id'],$el['postId'], $el['name'], $el['email'], $el['body']]);
    $comment_count +=1;
}


echo "Загружено".$post_count." записей и ".$comment_count." комментариев";

