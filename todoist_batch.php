<?php

require_once 'Todoist.php';

try {
    $todoist = new Todoist();
    $todoist->createProject(date('Ymd'));
} catch (Exception $e) {
    echo $e;
}
