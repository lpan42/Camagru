<?php
require_once 'config/database.php';
require_once 'models/Db.php';

Db::connect($DB_DSN, $DB_USER, $DB_PASSWORD);
?>  