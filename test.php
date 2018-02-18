<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Тест</title>
    <nav>
        <ul>
            <li><a href="admin.php">Загрузить новый тест</a></li>
            <li><a href="list.php">Выбрать тест</a></li>
        </ul>
    </nav>
    </head>
    <body>
        <?php
         if (!empty($_GET["test"])) 
             { echo " Вы проходите тест: ";} 
         else { 
             header($_SERVER['SERVER_PROTOCOL']. ' 404 Not Found');
             echo "Выберите тест по ссылке в меню."; 
             exit;
         }
         $name = $_GET["test"];
         $dir = __DIR__ . DIRECTORY_SEPARATOR. "test";
         chdir($dir);
         if (!file_exists($name)) {
             header($_SERVER['SERVER_PROTOCOL']. ' 404 Not Found');
             echo "Такого теста нет, выберите другой тест по ссылке в меню."; 
             exit;
         }
         $string = file_get_contents($name);
         $data = json_decode($string, TRUE);
         echo $data[0]['main'];
        ?>
        <form method="post" enctype="multipart/form-data">
            <?php
            $n = 1;
                    foreach ($data as $key) {
                        $i = 1;
                        $answers = $key['answers'];
                        echo  $key['question']. "<br>";
                        foreach ($answers as $value) {
                            echo "<input type='radio' name='Q". $n."' value='$i'>". $value. " ";
                            $i = $i + 1;
                        }
                        echo "<br>";
                        $n = $n + 1;
                    }?>
            <input type="submit" value="Отправить">
        </form>
        <?php
        $s = 1;
        $m = 0;
        if (!empty($_POST)){
            foreach ($data as $value){
               if ($value['correct_answer'] == $_POST['Q'.$s]){
                  echo 'Ответ на вопрос '. $s. ' правильный'. '<br>';
                   $m = $m + 1;
               }
               else {
                  echo 'Ответ на вопрос '. $s. ' не правильный'. '<br>'; 
               }
             $s = $s + 1;
             }
             echo 'Всего правильных ответов '. $m. '<br>';
             $long = count($data) - 1;
             if ($m >= $long){
                 echo 'Поздравляем! Вы успешно прошли тест.';
                 session_start();
                 $_SESSION['main'] = $data[0]['main'];
                 $_SESSION['point'] = $m;
                 $_SESSION['long'] = count($data);
                 ?>
        <form method="get" action="diplom.php" enctype="multipart/form-data">
            <strong>Введите ваше имя</strong>
            <input type="text" name="name">
            <input type="submit" value="Отправить">
        </form>
                <?php
             }
             else {
                 echo 'Попробуйте пройти тест еще раз.';
             }
        }
        ?>
    </body>
</html>
