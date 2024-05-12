<?php 

$fileGambar = imagecreatefromjpeg('asset/image.jpeg');
$watermark = imagecreatefrompng('./asset/logo.png');


$watermark_width = imagesx($watermark);
$watermark_height = imagesy($watermark);

$gambar_width = imagesx($fileGambar);
$gambar_height = imagesy($fileGambar);

imagecopy(
    $fileGambar,$watermark,$watermark_width + 1700 ,100, 0, 0, $watermark_width,$watermark_height
);

header('Content-Type: image/png');
imagejpeg($fileGambar);
imagedestroy($fileGambar);  


?>