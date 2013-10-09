<?php
include('conf.php');
begin();
if($_GET['act']=='exit') {
  session_unset();
  redirect('../', 'До свидания.');
}

if($_GET['act']=='login') {
  if($_POST['s'] and stristr($_SERVER['HTTP_REFERER'], "just.nwn.name")) {
    $name=filter($_POST['username']);
    $pass=md5(md5($_POST['userpass']));
    $q=mysql_query("select nn, pp from user where nn='$name' and pp='$pass'") or die(me(mysql_error()));
    if(mysql_num_rows($q) == 1) {
      $_SESSION['login']=$name;
      redirect('../', "Вы идентифицированы как $name.");
    } else redirect('../register.php?act=login', "<font color=red>Ошибка!</font><br />Неверный пароль!<br />");
  } else {
   echo "<table align='center' width='30%'>
   <tr>
    <td>
     <form action=\"../register.php?act=login\" method='post'>
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
    <td align='left'>
     <a target='_blank' href='http://lleo.aha.ru/na'>Забыл пароль</a>
    </td>
    <td align='left'>
     <input type=\"submit\" name=\"s\" value=\"Залогиниться\" />
    </td>
   </tr>
  </table>";
  }
} else {
if($_POST['s'] and stristr($_SERVER['HTTP_REFERER'], "just.nwn.name/register.php")) {
  $_SESSION['name']=filter($_POST['name']);
  $id=$_SESSION['capcha_id'];
  unset($_SESSION['capcha_id']);
  if(!(isset($_POST['name']) && $_POST['name'] != "" && isset($_POST['pass']) && $_POST['pass'] != "" && isset($_POST['pass1']) && $_POST['pass1'] != "")) redirect('../register.php', "<font color='red'>Ошибка!</font><br />Все поля должны быть заполнены!<br />");
  settype($_POST['id'], "integer");
  if($_SESSION['captcha_keystring']!=$_POST['capcha']) redirect('../register.php', "<font color='red'>Ошибка!</font><br />Неверное число на картинке!<br />");
  $name=$_POST['name'];
  if(!ereg("[а-яА-ЯA-Za-z0-9_]{3,12}", $name)) redirect('../register.php', "<font color='red'>Ошибка!</font><br />Неверный формат имени, имя может состоять из букв
  латинского и русского алфавитов, цифр и знака подчеркивания, также должно быть не короче 3,
  и не длиннее 12 символов!<br />");
  $q=mysql_query("select nn from user where nn='$name'") or die(me(mysql_error()));
  if(mysql_num_rows($q) == 1) redirect('../register.php', "<font color='red'>Ошибка!</font><br />Пользователь с таким именем уже существует, попробуйте ввести другое имя!<br />");
  if($_POST['pass'] != $_POST['pass1']) redirect('../register.php', "<font color='red'>Ошибка!</font><br />Введенные пароли не совпадают!<br />");
  $pass=md5(md5($_POST['pass']));
  $q="insert into user (nn, pp) values ('$name', '$pass')";
  $q=mysql_query($q) or die(me(mysql_error()));
  #$q=mysql_query("delete from capcha where id=$id") or die(me(mysql_error()));
  session_unset();
  die("Вы успешно зарегестрированы. Теперь можете <a href='../register.php?act=login' style='color: red;'>войти</a>.<br />
  Регистрационные данные:
  <br />
  Логин: {$_POST['name']}
  <br />
  Пароль: {$_POST['pass']}");
}
#$q=mysql_query("insert into capcha (value) values (1)") or die(me(mysql_error()));
#$id=mysql_insert_id();
#@mysql_free_result($q);
echo "
<table cellpadding='0' cellspacing='5' border='0' align='center' width='80%'>
 <tr>
  <td align='right' width='40%'>
   Введите ваше имя:
  </td>
  <td width='40%'>
   <form action='' method='post'>
   <input type='text' name='name' value='{$_SESSION['name']}' />
  </td>
 </tr>
 <tr>
  <td align='right' width='40%'>
   Введите пароль.
  </td>
  <td widyh='40%'>
   <input type='password' name='pass' value='' />
  </td>
 </tr>
 <tr>
 <tr>
  <td align='right' width='40%'>
   Повторите пароль.
  </td>
  <td widyh='40%'>
   <input type='password' name='pass1' value='' />
  </td>
 </tr>
  <td width='80%' align='center' colspan='2'>
   Введите символы, изображенные на картинке.
  </td>
 </tr>
 <tr>
  <td width='40%' align='right'>
   <input type='text' name='capcha' value='' />
  </td>
  <td width='40%'>";
  #$_SESSION['capcha_id']=$id;
  echo "
   <img src='./kcaptcha/' border='0' />
  </td>
 </tr>
 <tr>
  <td width='80%' colspan='2' align='center'>
  <a href=\"#\" onclick=\"javascript:alert('Стало быть обновите страницу.')\">Я робат и не вижу надпись</a>
  </td>
 </tr>
 <tr>
  <td width='60%' align='center' colspan='2'>
   <input type='submit' name='s' value='Зарегистрироваться'>
   </form>
  </td>
 </tr>
</table>";
}

fin();
?>