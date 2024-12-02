<?php
session_start();
echo "Loging out. Please wait...";
session_destroy();
header("Location: /phpt/forum");
?>