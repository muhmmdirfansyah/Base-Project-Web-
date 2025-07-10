<?php
require_once '../config/database.php';

session_destroy();
redirect(APP_URL . '/index.php');
?>