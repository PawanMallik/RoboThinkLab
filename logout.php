<?php
session_start();
session_destroy();
header("Location: admin.robothinklab.com/login.php");
exit();
