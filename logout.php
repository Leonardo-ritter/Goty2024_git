<?php
session_start(); 
session_unset(); 
session_destroy(); 

//DIRECIONA PARA LOGIN
header("Location: login.html");
exit;
?>
