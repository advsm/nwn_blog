<?php
include 'conf.php';
begin();

if($_POST['submit'] and stristr($_SERVER['HTTP_REFERER'], "just.nwn.name")) {
  if(strlen($_POST['comment'])>400 and !root()) die("Много букв...");
  #if($_SESSION['captcha_keystring']!=$_POST['capcha']) die("Извините, но код с картинки не верен...");
  if(strlen($_POST['name'])>12) die();
  $ip=$_SERVER["REMOTE_ADDR"];
  $idcom=strtr($_POST['id'], $byfilter);
  $name=strtr($_POST['name'], $byfilter);
  $q="select id, ip, nixtime, name from comblog where idcom=$idcom and flood=0";
  #$q=mysql_query($q) or die(me(mysql_error()));
  while($r=mysql_fetch_assoc($q)) {
    $plus=mktime(date("G")+9, date("i")-5);
    if(($r['ip']==$ip or $r['name']==$name) and $r['nixtime']>$plus) redirect("./comment.php?id={$_POST['id']}", "Вы не можете отправлять сообщения так часто!");
    else {
      $q1="update comblog set flood=1 where id={$r['id']}";
      $q1=mysql_query($q1) or die(me(mysql_error()));
      @mysql_free_result($q1);
    }
  }
  #$q=mysql_query("select nn from user where nn='$name'") or die(me(mysql_error()));
  $r=mysql_fetch_assoc($q);
  if(mysql_num_rows($q)>0 && $r['nn'] != login()) redirect("./comment.php?id={$_POST['id']}", "Вы не можете использовать это имя (1=0).");
  $comment=filter($_POST['comment']);

  $time=mktime(date("G")+9);
  if(root()) $color="admin";
  elseif(login()) $color="user";
  else $color="guest";
  @mysql_free_result($q);
  $insert="insert into comblog (idcom, nixtime, ip, name, comment, color) values('$idcom', '$time', '$ip', '$name', '$comment', '$color')";
  #mysql_query($insert) or die(me(mysql_error()));
  @mysql_free_result($q);
  redirect("./comment.php?id=$idcom", "Комментарий добавлен.");
}

if(isset($_GET['show'])) {
  $show=$_GET['show'];
  settype($show, "integer");
} else $show=15;

if($_GET['id']) {
  $id=$_GET['id'];
  settype($id, "integer");
  $q="select * from blog where id=$id";
  $q=mysql_query($q) or die(me(mysql_error()));
  while($result=mysql_fetch_assoc($q)) addtext($result['id'], $result['nixtime'], $result['appby'], $result['groups'], $result['title'], $result['text'], $result['comment']);
} else die();

if(!isset($_GET['page']) or $_GET['page']<=0) $page=0;
else {
  $page=$_GET['page'];
  settype($page, "integer");
  $page=($page*$show)-$show;
}

$pages="<hr><center><br /> ";

if(($t=$_GET['page']-1)>0) $pages.="[ <a href='?id=$id&page=$t&show=$show'>previous</a> ] ";

$q="select id from comblog where idcom=$id order by id";
$q=mysql_query($q) or die(me(mysql_error()));
$num=mysql_num_rows($q);
$num=ceil($num/$show);
settype($num, "integer");
for($i=1; $i<=$num; $i++) {
  $pages.="[ <a href='?id=$id&page=$i&show=$show'>";
  if($_GET['page']==$i) $pages.="<span style='font-size: larger; font-weight: bold;'>$i</span>";
  else $pages.=$i;
  $pages.="</a> ] ";
}

if(($t=$_GET['page']+1)<=$num and $num!=1) $pages.="[ <a href='?id=$id&page=$t&show=$show'>next</a> ]";
$pages.="</center>";
echo $pages;

$selectcom="select * from comblog where idcom=$id order by id limit $page, $show";
$querycom=mysql_query($selectcom) or die(mysql_error());
while($result=mysql_fetch_assoc($querycom)) addcomment($result['id'], $result['idcom'], $result['nixtime'], $result['ip'], $result['name'], $result['comment'], $result['color']);
echo $pages. "
<br />
<hr />
<center>
<br />
<form action=\"comment.php\" method=\"post\">
";
$name=login();
if(root()) echo "<span style='font-weight: bold;' class='admin'>$name</span>
<input type='hidden' name='name' value='$name' size=\"12\" maxlength=\"12\" />";
elseif($name) echo "<span style='font-weight: bold;' class='user'>$name</span>
<input type='hidden' name='name' value='$name' size=\"12\" maxlength=\"12\" />";
else echo "<input type=text name=\"name\" value='Имя' size=\"12\" maxlength=\"12\" />";
echo "<!--<br /><br />
Код с картинки:<br /><br />
<input type='text' name='capcha' value='' /><br /><br />
<img border='0' src='./kcaptcha/' />-->
<br />
<br />
<textarea name=\"comment\" wrap=\"physical\" cols=\"50%\" rows=\"5\">Комментарий</textarea><br><br>
<input type=\"hidden\" name=\"id\" value=\"$id\">
<input type=\"submit\" name=\"submit\" value=\"Комментировать\">
</form>
</center>";


fin();
?>