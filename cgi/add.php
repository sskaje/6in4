<?php
require(__DIR__ . '/inc.php');

$command = "sudo $shell_file add $id $ip 2>&1";

echo `$command`;
