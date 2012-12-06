<?php
/* U need to change below fields */
include 'dbinfo.php';
 
/* Leave the script below as it is */
mysql_connect($db_hostname, $db_username, $db_password);
mysql_select_db($db_sitename);
$comment_on=$_POST[comment_on];
$comment_by=$_POST[comment_by];
$comment=$_POST[comment];
$query=mysql_query("INSERT INTO 
comments (comment_by,comment_on,comment)
VALUES ('$comment_by','$comment_on','$comment')");
if($query) {
$ref=$_SERVER['HTTP_REFERER'];
/* echo "Comment Inserted"; */
header("location: $ref");
}
else {
echo "Error while inserting comment, Contact the <a href=\"http://shrikrishna.tk\">programmer</a> for any help.";
}
mysql_close();
?>