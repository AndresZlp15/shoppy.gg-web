<?php
include_once "config.php";
include_once "ini_functions.php";

function updateStock($shoppygg_api_fn = false) {
    if ($shoppygg_api_fn === false) {
        if (isset($shoppygg_api)) {
            $shoppygg_api_fn = $shoppygg_api;
        } else {
            throw new Error("No Shoppy.GG api key set");
        }
    }
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://shoppy.gg/api/v1/products/",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_POSTFIELDS => "",
        CURLOPT_USERAGENT => 'Shoppy.gg website #1 by Zeno',
        CURLOPT_HTTPHEADER => array(
            "authorization: " . $shoppygg_api_fn
        ),
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        $ini = parse_ini("stock.ini");
        $response_json = json_decode($response);
        foreach ($response_json as $index => $data) {
            $data_id = $data->id;
            $data_stock = $data->stock;
            $ini['stock'][$data_id] = $data_stock;
        }
        put_ini_file("stock.ini", $ini);
    }
}