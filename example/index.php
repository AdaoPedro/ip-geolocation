<?php
    use AdaoPedro\IPGeolocation\IPGeolocation;

    require_once dirname(__DIR__) . "/vendor/autoload.php";

    $IPGeolocation = new IPGeolocation;
    $data = $IPGeolocation->Get("105.168.221.218");

    dump($data);


    

