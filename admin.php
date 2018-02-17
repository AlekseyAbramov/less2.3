<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Загрузка файла с тестом</title>
    <nav>
        <ul>
            <li><a href="list.php">Выбрать тест</a></li>
            <li><a href="test.php">Пройти тест</a></li>
        </ul>
    </nav>
    </head>
    <body>
        <?php
        $uploads_dir = __DIR__ . DIRECTORY_SEPARATOR. "test". DIRECTORY_SEPARATOR ;

        if (isset($_FILES['myfile']['name']) && !empty($_FILES['myfile']['name'])){
            if ($_FILES['myfile']['error'] == UPLOAD_ERR_OK && $_FILES['myfile']['type'] == "application/json"){
                $tmp_name = $_FILES['myfile']['tmp_name'];
                $name = basename($_FILES['myfile']['name']);
                move_uploaded_file($tmp_name, $name);
                
                $string = file_get_contents($name);
                $data = json_decode($string);

                switch (json_last_error()) {
                  case JSON_ERROR_NONE:
                     $data_error = '';
                  break;
                  case JSON_ERROR_DEPTH:
                     $data_error = 'Достигнута максимальная глубина стека, загрузите другой файл';
                  break;
                  case JSON_ERROR_STATE_MISMATCH:
                       $data_error = 'Неверный или не корректный JSON, загрузите другой файл';
                  break;
                  case JSON_ERROR_CTRL_CHAR:
                    $data_error = 'Ошибка управляющего символа, возможно верная кодировка, загрузите другой файл';
                  break;
                  case JSON_ERROR_SYNTAX:
                   $data_error = 'Синтаксическая ошибка, загрузите другой файл';
                   break;
                  case JSON_ERROR_UTF8:
                    $data_error = 'Некорректные символы UTF-8, возможно неверная кодировка, загрузите другой файл';
                   break;	
                  default:
                      $data_error = 'Неизвестная ошибка, загрузите другой файл';
                   break;
                }

                  if($data_error !=''){
                      echo $data_error;
                      unlink($name);
                 }
                 else {
                     $new_test = $uploads_dir. $name;
                     rename($name, $new_test);
                     header('Location: list.php');
                     exit;
                       }
            }
            else {
                echo "<p>Ошибка: файл с тестами не загружен<p>";
            }
        }
        ?>
        
        <form method="post" enctype="multipart/form-data">
            Файл <input type="file" name="myfile">
            <input type="submit" value="Отправить">
        </form>
        <p><strong>Пример JSON файла:</strong></p>
        <code>
[{
     "main":"Столицы государств",
     "question": "Столица России?",
     "answers": 
        {
        "1": "1. Париж",
        "2": "2. Вашингтон",
        "3": "3. Питер",
        "4": "4. Москва"
        },
     "correct_answer": "4"
},
{
     "question": "Столица Франции?",
     "answers": 
        {
        "1": "1. Париж",
        "2": "2. Вашингтон",
        "3": "3. Питер",
        "4": "4. Москва"
        },
     "correct_answer": "1"
}]
        </code>
    </body>
</html>
