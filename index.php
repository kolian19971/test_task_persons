<?php

// class loader
spl_autoload_register(function ($class_name) {
    include $_SERVER['DOCUMENT_ROOT'].'/Classes/'.$class_name . '.php';
});

// get single instance of the class
$mankind = Mankind::getInstance();

// Load people from the file
try {
    $mankind->load('test.csv');
} catch (Exception $e) {
    print_r($e->getMessage());
    exit();
}

// Get the Person based on ID
var_dump($mankind->getPersonById(3457));

// Get the percentage of Men in Mankind
var_dump($mankind->getManPercent());

// the instance as array
foreach ($mankind as $key => $item){
    echo $item->getId()."\n";
}
