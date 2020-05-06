<?php
include_once "config.php";
include_once "ini_functions.php";

if (isset($_SERVER['X-Shoppy-Signature'])) {
    if (hash_equals(hash_hmac('sha512', $_SERVER['X-Shoppy-Signature'], $webhook_secret), $_SERVER['X-Shoppy-Signature'])) {
        $ini = parse_ini("stock.ini");
        $json_str = file_get_contents('php://input');
        $json_obj = json_decode($json_str);
        $data_id = $json_obj->data->product->id;
        $data_stock = $json_obj->data->product->stock;
        $ini[$data_id] = $data_stock;
        put_ini_file("stock.ini", $ini);
    }
}