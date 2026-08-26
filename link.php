<?php
// link.php — run once: php link.php

$target = __DIR__ . '/storage/public';   // real folder
$link   = __DIR__ . '/public/storage';   // shortcut inside web root

if (file_exists($link)) {
	echo "Link already exists.\n";
	exit;
}

if (symlink($target, $link)) {
	echo "Symlink created: public/storage → storage/public\n";
} else {
	echo "Failed to create symlink. On Windows, run terminal as Administrator.\n";
}

// check in details. edit .htacces