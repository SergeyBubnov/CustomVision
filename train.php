
<?php
$filepath = htmlspecialchars($_POST['filepath']);
$tag = htmlspecialchars($_POST['tag']);

$key = htmlspecialchars($_POST['key']);
$trainurl = htmlspecialchars($_POST['trainurl']);

$finalurl = $trainurl."?tagIds=".$tag;

$ch = curl_init($finalurl);
curl_setopt($ch, CURLOPT_POST,TRUE);
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Training-key: '.$key,
        'Content-Type: multipart/form-data'
    ));
    $image = file_get_contents($filepath);
    curl_setopt($ch, CURLOPT_POSTFIELDS,$image);
    $result=curl_exec($ch);
    echo "<pre>";
    print_r(json_decode($result));
    echo "</pre>";
curl_close($ch);
?> 
