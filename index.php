
<form action="" method="GET">
        <input type="text" name="name">
		<input type="submit" name="submit" value="Найти">
</form>
<?php


$user='nachalnikovk';
$password='nachalnikovk';
$db='db';
$host='localhost';
$port='3306';

$dsn='mysql:host='.$host.';dbname='.$db.';port='.$port;
$pdo=new PDO($dsn,$user,$password);
$sql="SELECT * FROM `post` ";
$query = $pdo->query($sql);
$it=$query->fetchAll(PDO::FETCH_ASSOC);
if (count($it)) {
    $name = $_GET['name'];

    if (strlen($name) >= 3) {
        $sql = "SELECT post.title,comment.body FROM `post` INNER JOIN `comment` ON post.id=comment.postid WHERE comment.body LIKE ?";
        $query = $pdo->prepare($sql);
        $name = "%" . $name . "%";


        $query->execute([$name]);
        $item = $query->fetchAll(PDO::FETCH_ASSOC);

    } else {

        echo "Минимальная длина запроса 3 символа";
    }

    if (isset($item)) {

        if (count($item) > 0) {

            echo "<h2>Результаты Поиска</h2>";
            echo "<table><tr><th>Запись</th><th>Комментарий</th></tr>";
            foreach ($item as $el) {
                echo "<tr><td>" . $el['title'] . "</td><td>" . $el['body'] . "</td></tr>";
            }
        } else {
            echo " Результаты не найдены";


        }

        echo "</table>";
    }
}
else{
    include "script.php";
}

