<?php

require_once '../class/Egzamel.php';

$file = './data/example1.xml';
$query = array(
    'student' => array( "age" => "22")

);

Egzamel::parse($file, $query);
Egzamel::toXml();