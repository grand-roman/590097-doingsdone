<?php

if(file_exists('config.php')) {
    require_once 'config.php';
} else {
    require_once 'config.default.php';
}
?>