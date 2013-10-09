<?php
header ("Content-type: image/png");
include 'conf.php';
conmysql();
$im = imagecreatetruecolor(230, 80);
$str="";
$count=rand(5, 6);
for($i=1; $i<=$count; $i++) {
  $color1=rand(80, 255);
  $color2=rand(80, 255);
  $color3=rand(80, 255);
  $col=imagecolorallocate($im, $color1, $color2, $color3);
  $font=rand(1, 5);
  $s='ABCDEFGHIJKLMPQRSTUVWXYZ';
  if($font!=2) $s.="123456789";
  $font="/home/egorgos/public_html/just/fonts/$font.ttf";
  $rnd=rand(0, strlen($s));
  $simb=$s{$rnd};
  $str.=$simb;
  $size=rand(15, 30);
  $naklon=rand(-5, 5);
  $y=rand(30, 70);
  $xx=rand(-2, 2);
  $x=30*$i+$xx;
  imagettftext($im, $size, $naklon, $x, $y, $col, $font, $simb);
}
if(isset($_GET['id']) and stristr($_SERVER['HTTP_REFERER'], "just.nwn.name/register.php")) {
  $id=$_GET['id'];
  settype($id, "integer");
  $q=mysql_query("update capcha set value='$str' where id=$id");
}
imagepng($im);
imagedestroy($im);

?>