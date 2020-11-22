<?php
include_once('../global.php');
unset($_SESSION['admin_identify']);
session_destroy();
header('Location:adminlogin.php');



?>