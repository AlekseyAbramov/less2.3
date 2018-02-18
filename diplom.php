<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Диплом</title>
        <nav>
        <ul>
            <li><a href="admin.php">Загрузить новый тест</a></li>
            <li><a href="list.php">Выбрать тест</a></li>
        </ul>
    </nav>
    </head>
    <body>
        <?php
        if (!empty($_GET['name'])) { 
            session_start();
            $_SESSION['code'] = $_GET['name'];
            echo " Поздравляем! Вы успешно прошли тест. ". $_SESSION['main'];
            if ($_SESSION['point'] == $_SESSION['long']){
                $score = "отлично";
                $_SESSION['score'] = $score;
            }
            else {
                $score = "хорошо";
                $_SESSION['score'] = $score;
            }

        }
        else {echo "Пожалуйста, пройдите тест.";}
        ?>
        <br>
        <img src="img.php">
    </body>
</html>
