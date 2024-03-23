<?php 

$appid = "wx9468ddf934dcae3e"; // 小程序appid
$appkey = "6c3e6f74721b6a96dfe95fd2e6bffc6e"; // 小程序密钥

// 获取微信开放平台token
$token = file_get_contents('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$appkey);
$token = json_decode($token, true);
$token = $token["access_token"];

// 获取微信小程序schemeUrl
$url='https://api.weixin.qq.com/wxa/generatescheme?access_token='.$token;

$data = json_encode(array(
    "jump_wxa" => array(
        "path" => "/pages/index/index", // 页面地址
        "query" => "" // 需要传递的参数，可留空：a=****&b=*****······
        )
    )
);

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_ENCODING, "");
curl_setopt($ch, CURLOPT_AUTOREFERER, true);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Accept: application/json, text/plain, */*",
    "Accept-Language: zh-CN,zh;q=0.9,en;q=0.8",
    "Content-Type: application/json",
    "Origin: https://api.weixin.qq.com",
    "Content-Type: application/json"
));
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_ENCODING, "gzip");

$result = curl_exec($ch);

curl_close($ch);

//提取link
$link = json_decode($result, true)["openlink"];

$data = array(
    'code'=>200,
    'url'=>$link
    );

exit(json_encode($data));

?>
