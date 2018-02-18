<?php
$image = imagecreatetruecolor(376, 520);
$back_color = imagecolorallocate($image, 255, 255, 255);
$text_color = imagecolorallocate($image, 233, 14, 91);
$boxFile = __DIR__. '/diplom.png';
if (!file_exists($boxFile)){
    echo 'Файл с картинкой не найден.';
    exit;
}
session_start();
$text = $_SESSION['code'];
$imgBox = imagecreatefrompng($boxFile);
imagefill($image, 0, 0, $back_color);
imagecopy($image, $imgBox, 10, 10, 0, 0, 356, 500);
$font_file = __DIR__. '/ubuntu.ttf';
if (!file_exists($font_file)){
    echo 'Файл со шрифтом не найден.';
    exit;
}
$rating = 'Оценка: '. $_SESSION['score'];
$title = 'Тест "'. $_SESSION['main']. '"';
imagettftext($image, 10, 0, 100, 170, $text_color, $font_file, $title);
imagettftext($image, 20, 0, 100, 370, $text_color, $font_file, $rating);
imagettftext($image, 20, 0, 150, 250, $text_color, $font_file, $text);
header('Content-Type: image/png');
imagepng($image);
imagedestroy($image);