<?php
session_start();
session_unset();
session_destroy();
session_destroy();
header("Location:login.php");  // adjust path
exit();
