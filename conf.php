<?php
function login() {
  if($_SESSION['login']) return $_SESSION['login'];
  else return false;
}

function root() {
  if($_SESSION['root']) return true;
  else return false;
}

function reg() {
  if(!login()) return "<div align='right' style='font-weight: bold; color: red;'>Вы идентифицированы как Гость.<br />
  <a href='../register.php?act=login'>Вход<a> | <a href='../register.php'>Регистрация</a></div>";
  else return "<div align=\"right\" style=\"font-weight: bold; color: red;\">Приветствую, ".login()."!<br />
  <a href='../register.php?act=exit'>Выход</a></div>";
}

function begin() {
  conmysql();
  unset($login);
  unset($root);
  session_start();
  echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">
  <html>
  <head>
  <meta charset='utf-8'>
  <link rel=\"stylesheet\" type=\"text/css\" href=\"../styles.css\">
  <title>just4fun</title>
  </head>
  <body>
  <table cellpadding='5' cellspacing='1' border='0' width='100%'>
   <tr>
    <td>
  <h2 align=center style=\"font-style: Arial; font-weight: bold;\">
  <a href='../'>JUST4FUN</a>
  </h2>";
  echo reg();
}

function fin() {
  $c=base64_decode('PCEtLSBIb3RMb2cgLS0+DQoNCjxzY3JpcHQgdHlwZT0idGV4dC9qYXZhc2NyaXB0IiBsYW5ndWFnZT0iamF2YXNjcmlwdCI+DQpob3Rsb2dfanM9IjEuMCI7DQpob3Rsb2dfcj0iIitNYXRoLnJhbmRvbSgpKyImcz0zNzg2NzEmaW09MTMyJnI9Iitlc2NhcGUoZG9jdW1lbnQucmVmZXJyZXIpKyImcGc9IisNCmVzY2FwZSh3aW5kb3cubG9jYXRpb24uaHJlZik7DQpkb2N1bWVudC5jb29raWU9ImhvdGxvZz0xOyBwYXRoPS8iOyBob3Rsb2dfcis9IiZjPSIrKGRvY3VtZW50LmNvb2tpZT8iWSI6Ik4iKTsNCjwvc2NyaXB0Pg0KPHNjcmlwdCB0eXBlPSJ0ZXh0L2phdmFzY3JpcHQiIGxhbmd1YWdlPSJqYXZhc2NyaXB0MS4xIj4NCmhvdGxvZ19qcz0iMS4xIjtob3Rsb2dfcis9IiZqPSIrKG5hdmlnYXRvci5qYXZhRW5hYmxlZCgpPyJZIjoiTiIpDQo8L3NjcmlwdD4NCjxzY3JpcHQgdHlwZT0idGV4dC9qYXZhc2NyaXB0IiBsYW5ndWFnZT0iamF2YXNjcmlwdDEuMiI+DQpob3Rsb2dfanM9IjEuMiI7DQpob3Rsb2dfcis9IiZ3aD0iK3NjcmVlbi53aWR0aCsneCcrc2NyZWVuLmhlaWdodCsiJnB4PSIrDQooKChuYXZpZ2F0b3IuYXBwTmFtZS5zdWJzdHJpbmcoMCwzKT09Ik1pYyIpKT8NCnNjcmVlbi5jb2xvckRlcHRoOnNjcmVlbi5waXhlbERlcHRoKTwvc2NyaXB0Pg0KPHNjcmlwdCB0eXBlPSJ0ZXh0L2phdmFzY3JpcHQiIGxhbmd1YWdlPSJqYXZhc2NyaXB0MS4zIj5ob3Rsb2dfanM9IjEuMyI8L3NjcmlwdD4NCjxzY3JpcHQgdHlwZT0idGV4dC9qYXZhc2NyaXB0IiBsYW5ndWFnZT0iamF2YXNjcmlwdCI+aG90bG9nX3IrPSImanM9Iitob3Rsb2dfanM7DQpkb2N1bWVudC53cml0ZSgiPGEgaHJlZj0naHR0cDovL2NsaWNrLmhvdGxvZy5ydS8/Mzc4NjcxJyB0YXJnZXQ9J190b3AnPjxpbWcgIisNCiIgc3JjPSdodHRwOi8vaGl0MTguaG90bG9nLnJ1L2NnaS1iaW4vaG90bG9nL2NvdW50PyIrDQpob3Rsb2dfcisiJicgYm9yZGVyPTAgd2lkdGg9ODggaGVpZ2h0PTMxIGFsdD1Ib3RMb2c+PFwvYT4iKQ0KPC9zY3JpcHQ+DQo8bm9zY3JpcHQ+DQo8YSBocmVmPSJodHRwOi8vY2xpY2suaG90bG9nLnJ1Lz8zNzg2NzEiIHRhcmdldD0iX3RvcCI+DQoNCjxpbWcgc3JjPSJodHRwOi8vaGl0MTguaG90bG9nLnJ1L2NnaS1iaW4vaG90bG9nL2NvdW50P3M9Mzc4NjcxJmFtcDtpbT0xMzIiIGJvcmRlcj0wIA0KIHdpZHRoPTg4IGhlaWdodD0zMSBhbHQ9IkhvdExvZyI+PC9hPg0KPC9ub3NjcmlwdD4NCg0KPCEtLSAvSG90TG9nIC0tPg==');
  mysql_close();
  echo "
  <br/>
  <hr>
  <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
  <tr>
  <td width=50%>
  ©oded by Anti
  </td>
  <td align=right>
  $c
  </td>
  </tr>
  </table>
 
 </td>
</tr>
</table>
  </body>
  </html>";
}

function conmysql() {
  $connect=mysql_connect('localhost','nwn_funky','PREVEd') or die(me(mysql_error()));
  mysql_select_db('nwn_funky') or die(me(mysql_error()));
  mysql_query('set names utf8');
}


function addtext($id, $time, $appby, $group, $title, $text, $comment) {
  $title=nl2br($title);
  $text=nl2br($text);
  $comment=nl2br($comment);
  $title=bb($title);
  $text=bb($text);
  $comment=bb($comment);

  $q=mysql_query("select groups from groups where id=$group");
  $r=mysql_fetch_assoc($q);

  $numcom=mysql_query("select id from comblog where idcom=$id");
  $rowcom=mysql_num_rows($numcom);
  echo "
  <br />
  <hr>
  <table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\">
  <tr>
  <td>
  ".ndate($time).", posted by <span style='font-weight: bold;' class='admin'>$appby</span>
  </td>
  <td align=\"right\">";
  if(root()) echo "<a style=\"color: red;\" href=\"./a/?id=$id&act=edit\">Редактировать</a>";
  echo "</td>
  </tr>
  <tr>
  <td colspan=\"2\" align=\"right\">
  <a href=\"./?group=$group\">Группа: {$r['groups']}</a>
  </td>
  </tr>
  </table>
  ";
  if($title != "") {
    echo "<span class=\"title\">
    $title
    </span>
    <br />
    ------------
    <br />
    <br />";
  }
  if($text != "") {
    echo "<span class=\"text\">
    $text
    </span>
    <br />
    ------------
    <br />
    <br />";
  }
  if($comment != "") {
    echo "<span class=\"comment\">
    $comment
    </span>
    <br />";
  }
  echo "
  <div align=\"right\">";
  if(stristr($_SERVER['REQUEST_URI'], "comment.php")) echo "<a href='../'><<< На главную</a>";
  else echo "<a href=\"./comment.php?id=$id\">Комментариев ($rowcom)</a>";
  echo "</div>
  ";
}

function addcomment($id, $idcom, $time, $ip, $name, $comment, $color) {
  $comment=nl2br($comment);
  $comment=bb($comment);
  echo "
  <br>
  <hr>
  <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\">
  <tr>
  <td>
  <span class=\"time\">".
  ndate($time)."
  </span>
  , commented by <span ";
  if($color != "guest") echo "style='font-weight: bold;' ";
  echo "class='$color'>$name</span> ";
  if($t=root()) echo "(IP: $ip)";
  echo "
  </td>
  <td align=\"right\">";
  if($t) echo "<a style='color: red;' href='./a/?act=cedit&id=$id&cid=$idcom'>Редактировать</a>";
  echo "
  </td>
  </tr>
  <tr>
  <td colspan=\"2\">
  <br />
  $comment
  </td>
  </tr>
  </table>";
}

function ndate($date) {
  return date("d.m.Y H:i:s", $date);
}


$byfilter = array("&" => "&amp;", "<" => "&lt;", ">" => "&gt;", '"' => "&quot;", "'" => "&#39;" );

function redirect($filename, $str = "") {
   echo "<h4 align='center'>$str<br />
   Подождите, сейчас вы будете перемещены.<br />
   Или нажмите <a href='$filename' style='color: red;'>сюда</a>, если не хотите ждать.
   </h4>";
   ob_flush();
   flush();
   sleep(3);
   if (!headers_sent())
       header('Location: '.$filename);
   else {
       die("<script type='text/javascript'>
       window.location.href='$filename';
       </script>
       <noscript>
       <meta http-equiv='refresh' content='0;url=$filename' />
       </noscript>");
   }
}

function bb($s) {
 $s=preg_replace("/\[b\](.*?)\[\/b\]/is","<b>$1</b>",$s);
 $s=preg_replace("/\[s\](.*?)\[\/s\]/is","<s>$1</s>",$s);
 $s=preg_replace("/\[i\](.*?)\[\/i\]/is","<i>$1</i>",$s);
 $s=preg_replace("/\[color=([a-z0-9#]+?)\](.*?)\[\/color\]/ies","'<font color=\''.str_replace('\'','&#039;','$1').'\'>'.str_replace('\'','&#039;','$2').'</font>'",$s);
 $s=preg_replace("/\[size=([+\-0-9]+?)\](.*?)\[\/size\]/ies","'<font size=\''.str_replace('\'','&#039;','$1').'\'>'.str_replace('\'','&#039;','$2').'</font>'",$s);
 $s=preg_replace("/(\[url\](.*?)(?=(\[url\]|\[url=([^\]]*?)\]|\[img\]|\[\/img\]|\[\/url\])))(\[\/url\])?/ies","('$5'=='[/url]'?'<a href=\''.str_replace('\'','&#039;','$2').'\'>'.'$2'.'</a>':'$0')",$s);
 $s=preg_replace("/(\[url=([^\]]*?)\](.*?)(?=(\[url\]|\[url=([^\]]*?)\]|\[img\]|\[\/img\]|\[\/url\])))(\[\/url\])?/ies","('$6'=='[/url]'?'<a href=\''.str_replace('\'','&#039;','$2').'\'>'.'$3'.'</a>':'$0')",$s);
 $s=preg_replace("/\[img\]((http:\/\/|\/).*?)\[\/img\]/ies","'<img src=\''.str_replace('\'','&#039;','$1').'\'>'",$s);
 return $s;
}

function me($e) {
  return "<h4>Warning!!! MySQL error: $e</h4>";
}

function filter($t) {
  $byfilter = array("&" => "&amp;", "<" => "&lt;", ">" => "&gt;", '"' => "&quot;", "'" => "&#39;" );
  $t=strtr($t, $byfilter);
  $t=trim($t);
  while(strstr($t, "\n\r\n\r\n\r")) $t=str_replace("\n\r\n\r\n\r", "\n\r\n\r", $t);
  return $t;
}
?>