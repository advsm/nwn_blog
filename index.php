<?php
include 'conf.php';
begin();
conmysql();



if(isset($_GET['show']) and $_GET['show']>0 and strlen($_GET['show'])<3) {
  $show=$_GET['show'];
  settype($show, "integer");
} else $show=10;

if(!isset($_GET['page']) or $_GET['page']<=0 or strlen($_GET['page'])>2) $page=0;
else {
  $page=$_GET['page'];
  settype($page, "integer");
  $page=($page*$show)-$show;
}

if(isset($_GET["group"]) and strlen($_GET['group'])<=2) {
  $group=$_GET["group"];
  settype($group, "integer");
  $where="where groups=$group";
}

$pages="<hr><center><br />";

if(($t=$_GET['page']-1)>0) {
  $pages.="[ <a href='?";
  if(isset($group)) $pages.="group=$group&";
  $pages.="page=$t&show=$show'>previous</a> ] ";
}

$q="select id from blog $where order by 'id' desc";
$q=mysql_query($q) or die(me(mysql_error()));
$num=mysql_num_rows($q);
$num=ceil($num/$show);
@mysql_free_result($q);

settype($num, "integer");
for($i=1; $i<=$num; $i++) {
  $pages.="[ <a href='?";
  if(isset($group)) $pages.="group=$group&";
  $pages.="page=$i&show=$show'>";
  if($_GET['page']==$i) $pages.="<span style='font-size: larger; font-weight: bold;'>$i</span>";
  else $pages.=$i;
  $pages.="</a> ] ";
}

if(($t=$_GET['page']+1)<=$num and $num!=1) {
  if($_GET['page']==0) $t=2;
  $pages.="[ <a href='?";
  if(isset($group)) $pages.="group=$group&";
  $pages.="id=$id&page=$t&show=$show'>next</a> ]";
}
$pages.="</center>";

echo $pages;
$q="select id, nixtime, appby, groups, title, text, comment from blog $where order by 'id' desc limit $page, $show";
$q=mysql_query($q) or die(me(mysql_error()));
while($r=mysql_fetch_assoc($q)) addtext($r['id'], $r['nixtime'], $r['appby'], $r['groups'], $r['title'], $r['text'], $r['comment']);
echo $pages;
fin();
?>
