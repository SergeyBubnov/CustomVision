
<?php
$filepath = htmlspecialchars($_POST['filepath']);
$tag = htmlspecialchars($_POST['tag']);

$key = htmlspecialchars($_POST['key']);
$trainurl = htmlspecialchars($_POST['trainurl']);

$finalurl = $trainurl."?tagIds=".$tag;

$ch = curl_init($finalurl);//url метода Train 1.0
curl_setopt($ch, CURLOPT_POST,TRUE);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Training-key: '.$key,
        'Content-Type: multipart/form-data'
    ));//указываем в заколовках http нашу подписку
    $image = file_get_contents($filepath);
    curl_setopt($ch, CURLOPT_POSTFIELDS,$image);//записываем биты изображения
    $result=curl_exec($ch);
    echo "<pre>";
    print_r(json_decode($result));
    echo "</pre>";
curl_close($ch);
?>

Что-то пошло не так. Вышла новая версия метода Train для Custom Vision и старый url не поддерживается. Полная документация здесь: <a href="https://docs.microsoft.com/en-us/azure/cognitive-services/custom-vision-service/">Custom Vision documentation</href>
