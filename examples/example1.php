<?php

require_once '../class/Egzamel.php';

$file = './data/example1.xml';
$query = array(
    'student' => TRUE
);

Egzamel::parse($file, $query);
Egzamel::toXml();