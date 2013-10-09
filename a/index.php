<?php
include '../conf.php';
begin();
conmysql(); 

if($_GET['act']=="cedit") {
  $id=$_GET['id'];
  settype($id, "integer");
  if($_POST['edit']) {
    $name=strtr($_POST['name'], $byfilter);
    $comment=strtr($_POST['comment'], $byfilter);
    $q=mysql_query("update comblog set name='$name', comment='$comment' where id='$id'") or die(me(mysql_error()));
    echo "<h4>Комментарий отредактирован</h4>";
    sleep(3);
    redirect("../comment.php?id={$_GET['cid']}");
  }
  if($_POST['delete']) {
    $q=mysql_query("delete from comblog where id='$id'") or die(me(mysql_error()));
    echo "<h4>Комментарий удален</h4>";
    sleep(3);
    redirect("../comment.php?id={$_GET['cid']}");
  }
  $q=mysql_query("select name, comment from comblog where id='$id'") or die(me(mysql_error()));
  $r=mysql_fetch_assoc($q);
  die("<table cellpadding=\"5\" cellspacing=\"5\" border=\"0\" width=\"100%\">
  <tr>
  <td align=\"center\">
  <form action=\"\" method=\"post\">
  <input type=\"text\" name=\"name\" value=\"{$r['name']}\" size=\"25\" maxlength=\"25\" />
  </td>
  </tr>
  <tr>
  <td align=\"center\">
  <br />
  <textarea name=\"comment\" cols=\"50%\" rows=\"3\">{$r['comment']}</textarea>
  <br />
  </td>
  </tr>
  <tr>
  <td align=\"center\">
  <table cellpadding=\"5\" cellspacing=\"5\" width=\"100%\" align=\"center\">
  <tr>
  <td>
  <input type=\"submit\" name=\"edit\" value=\"Редактировать\">
  </form>
  </td>
  <td align=\"right\">
  <form action=\"\" method=\"post\">
  <input type=\"submit\" name=\"delete\" value=\"Удалить\">
  </form>
  </td>
  </tr>
  </table>
  </td>
  </tr>
  </table>");
}

if($_GET['act']=="edit") {
  $id=$_GET['id'];
  settype($id, "integer");
  if($_POST['edit']) {
    $title=$_POST['title'];
    $text=$_POST['text'];
    $comment=$_POST['comment'];
    $q="update blog set title='$title', text='$text', comment='$comment' where id=$id";
    $q=mysql_query($q) or die(me(mysql_error()));
    echo "<h4>Запись отредактирована</h4>";
    sleep(3);
    redirect("../comment.php?id=$id");
  }
  if($_POST['delete']) {
    $q=mysql_query("delete from blog where id='$id'") or die(me(mysql_error()));
    $q1=mysql_query("delete from comblog where idcom='$id'") or die(me(mysql_error()));
    echo "<h4>Запись удалена</h4>";
    sleep(3);
    redirect("../");
  }
  $q=mysql_query("select title, text, comment from blog where id='$id'") or die(me(mysql_error()));
  $r=mysql_fetch_assoc($q);
  die("<form action=\"\" method=post>
  <table width=\"100%\" align=\"center\" cellpadding=\"5\" cellspacing=\"5\" border=\"0\">
  <tr>
  <td align=center>
  <textarea name=\"title\" cols=\"33%\" rows=\"6\" wrap=\"physical\">{$r['title']}</textarea>
  </td>
  <td align=center>
  <textarea name=\"text\" cols=\"33%\" rows=\"6\" wrap=\"physical\">{$r['text']}</textarea>
  </td>
  <td align=center>
  <textarea name=\"comment\" cols=\"33%\" rows=\"6\" wrap=\"physical\">{$r['comment']}</textarea>
  </td>
  </tr>
  <tr>
  <td>
  </td>
  <td>
  <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">
  <tr>
  <td>
  <input type=\"submit\" name=\"edit\" value=\"Редактировать\">
  </form>
  </td>
  <td align=\"right\">
  <form action=\"\" method=\"post\">
  <input type=\"submit\" name=\"delete\" value=\"Удалить\">
  </form>
  </td>
  </tr>
  </table>
  </td>
  </tr>
  </table>");
}

if($_POST['login'] and stristr($_SERVER['HTTP_REFERER'], "just.nwn.name")) {
  $u=filter($_POST['username']);
  $p=$_POST['userpass'];
  $q=mysql_query("select pp, root from user where nn='$u'") or die(me(mysql_error()));
  $r=mysql_fetch_assoc($q);
  $md5=md5(md5($p).md5($u));
  if($r['pp']==$md5) {
    $_SESSION['login']=$u;
    $_SESSION['pass']=$md5;
    if($r['root']==1) $_SESSION['root']=1;
    redirect("./", 'Вход выполнен!');
  }
}


if($_POST['submit']) {
  if(login()) $user=login();
  else die("<h4>Требуется залогинется!</h4>");

  if($_POST["addgroup"]) {
    $group=strtr($_POST["addgroup"], $byfilter);
    $q=mysql_query("insert into groups (groups) values ('$group')") or die(me(mysql_error()));
    $group=mysql_insert_id();
  } else $group= strtr($_POST["group"], $byfilter);
  
  $title=$_POST['title'];
  $text=$_POST['text'];
  $comment=$_POST['comment'];

  $time=mktime(date("G")+9);

  $insert="insert into blog (groups, nixtime, title, text, comment, appby) values('$group', '$time', '$title', '$text', '$comment', '$user')";
  mysql_query($insert) or die(mysql_error());
  redirect("./");
}

$query=mysql_query("select id, groups from groups order by id") or die(me(mysql_error()));
echo "<table width=\"100%\" cellpadding=\"0\" cellspasing=\"0\" border=\"0\">
<tr>
<td align=\"center\" valign=\"center\" width=\"50%\">
<form action=\"\" method=\"post\">
Выбрать группу:
<br />
<select name=\"group\" style=\"width: 50%;\">
";
while($result=mysql_fetch_assoc($query)) echo "<option value=\"{$result['id']}\">{$result['groups']}";
echo "
</select>
<br />
<br />
Или добавить новую группу:
<br />
<input type=\"text\" name=\"addgroup\" style=\"width: 50%\" />
<br />
<br />
<input type=text name=\"title\" value=\"Название.\" style=\"width: 50%\" />
<br />
<br />
<textarea name=\"text\" WRAP=\"physical\" COLS=\"50%\" ROWS=\"3\">
Запись.</textarea>
<br />
<br />
<textarea name=\"comment\" WRAP=\"physical\" COLS=\"50%\" ROWS=\"3\">
Свой коммент.</textarea>
<br />
<br />
<input type=\"submit\" name=\"submit\" value=\"Запостить\">
</form>
</td>
<td align=\"right\" valign=\"top\">
<table>
<tr>
<td>
<form action=\"\" method=post>
Ваше имя:
</td>
<td>
<input type=\"text\" name=\"username\" />
</td>
</tr>
<tr>
<td>
Пароль:
</td>
<td>
<input type=\"password\" name=\"userpass\" />
</td>
</tr>
<tr>
<td>
</td>
<td>
<input type=\"submit\" name=\"login\" value=\"Залогиниться\" />
</td>
</tr>
</table>
</form>
</td>
</tr>
</table>
";

fin();
?>