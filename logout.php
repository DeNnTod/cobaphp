<?php
session_start();
session_unset();
session_destroy();

// Menghapus cookie
setcookie('username', '', time() - 3600, "/");
setcookie('password', '', time() - 3600, "/");

header("Location: login.php");
exit;
?>
