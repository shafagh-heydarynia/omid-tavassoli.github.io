<?php 
$dblink = mysqli_connect('localhost','root','') or die(mysqli_connect_error());
function connect()
{ 
   global $dblink;
   return mysqli_select_db($dblink,'php2') or die(mysqli_connect_error()) ;
   return mysqli_query($dblink,"SET NAMES'UTF8'") ;
}
function disconnect()
{
    global $dblink;
    mysqli_close($dblink);
}
function redirect($pageurl , $x = "redirect" , $count = 0)
{
    $php = ".php";
    return header("Location:$pageurl.$php?$x=$count") ;
    return die;
}
function get($x)
{
    return $_GET[$x] ;
}
function post($x)
{
    return $_POST[$x] ;
}
function setget($x)
{
    return isset($_GET[$x]) ;
}
function setpost($x)
{
    return isset($_POST[$x]) ;
}
function registermail($email)
{
    global $dblink;
    $row = mysqli_fetch_assoc(mysqli_query($dblink,"SELECT id FROM users WHERE email = '$email' "));
    $id = $row['id'];
    $msg = "welcome to our website\nplease verify your identity by click the following link\n<a href=\"verification.php\">click</a>";
    return mail("$email","register configuration",$msg) ;
}
?>