<?php
require(__DIR__ . '/inc.php');

$command = "sudo $shell_file del $id 2>&1";

echo `$command`;
