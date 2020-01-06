<?php
session_start();
unset($_SESSION['userID']);
unset($_SESSION['profileID']);
session_destroy();
session_write_close();
echo "<script>location.href='index.php';</script>";
exit();
?>