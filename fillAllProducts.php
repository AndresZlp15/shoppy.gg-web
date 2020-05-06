<?php
include_once "config.php";

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://shoppy.gg/api/v1/products/",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_USERAGENT => 'Shoppy.gg website #1 by Zeno',
    CURLOPT_POSTFIELDS => "",
    CURLOPT_HTTPHEADER => array(
        "authorization: " . $shoppygg_api
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
        if (isset($data->image->url)) {
            $data_image = $data->image->url;
        } else {
            $data_image = null;
        }
        $data_title = $data->title;
        $data_description = $data->description;
        $o_id = ($data_id) ? json_encode($data_id) : "\"\"";
        $o_title = ($data_title) ? json_encode($data_title) : "\"\"";
        $o_image = str_replace("\\/", "/", ($data_image) ? json_encode($data_image) : "\"\"");
        $o_description = ($data_description) ? json_encode($data_description) : "\"\"";
        echo "\t[${o_image}, ${o_title}, ${o_description}, ${o_id}],<br>";
        $ini['stock'][$data_id] = $data_stock;
    }
    put_ini_file("stock.ini", $ini);
}