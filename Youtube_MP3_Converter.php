<?php
ob_start();
if(file_exists("error_log")) {
    unlink("error_log");   
}
if(empty($_GET['id'])) {
    $_GET['id'] = "id";
}

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://www.y2mate.com/mates/analyzeV2/ajax');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Accept: */*',
    'Accept-Language: tr-TR,tr;q=0.9,en-US;q=0.8,en;q=0.7',
    'Connection: keep-alive',
    'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
    'Origin: https://www.y2mate.com',
    'Referer: https://www.y2mate.com/youtube/94O2a0xUdMI',
    'Sec-Fetch-Dest: empty',
    'Sec-Fetch-Mode: cors',
    'Sec-Fetch-Site: same-origin',
    'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36 OPR/101.0.0.0',
    'X-Requested-With: XMLHttpRequest',
    'sec-ch-ua: "Not/A)Brand";v="99", "Opera";v="101", "Chromium";v="115"',
    'sec-ch-ua-mobile: ?0',
    'sec-ch-ua-platform: "Windows"',
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, 'k_query=https://www.youtube.com/watch?v='.$_GET['id'].'&k_page=home&hl=en&q_auto=1');
$response = curl_exec($ch);
curl_close($ch);
$response=json_decode($response, true);
if($response['mess']!=""){
    echo "false";
    exit;
}
$k=$response['links']['mp3']['mp3128']['k'];
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://www.y2mate.com/mates/convertV2/index');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Accept: */*',
    'Accept-Language: tr-TR,tr;q=0.9,en-US;q=0.8,en;q=0.7',
    'Connection: keep-alive',
    'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
    'Origin: https://www.y2mate.com',
    'Referer: https://www.y2mate.com/tr/youtube-mp3/rjKwVMDm51E',
    'Sec-Fetch-Dest: empty',
    'Sec-Fetch-Mode: cors',
    'Sec-Fetch-Site: same-origin',
    'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36 OPR/101.0.0.0',
    'X-Requested-With: XMLHttpRequest',
    'sec-ch-ua: "Not/A)Brand";v="99", "Opera";v="101", "Chromium";v="115"',
    'sec-ch-ua-mobile: ?0',
    'sec-ch-ua-platform: "Windows"',
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, 'vid='.$_GET['id'].'&k='.$k);

$response = curl_exec($ch);
curl_close($ch);

$response=json_decode($response, true);
if(isset($response['dlink'])){
    $fileName = $response['title'].'.mp3';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $response['dlink']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $html = curl_exec($ch);
    header("Content-Type: audio/mpeg");
    header('Content-Disposition: attachment; filename="'.$fileName); 
    echo $html;
}else{
    echo "false";
    exit;
}

if(file_exists("error_log")) {
    unlink("error_log");   
}
ob_end_flush();
?>