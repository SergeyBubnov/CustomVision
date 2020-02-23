<!DOCTYPE HTML>
<html>
<head>
 <meta charset="utf-8">
 <title>Классификация</title>
</head>
<body>

<?php
$filepath = htmlspecialchars($_POST['filepath']);
$Server = $_SERVER['SERVER_NAME'];
$fullpath = 'https://'.$Server.'/'.$filepath;

$key = htmlspecialchars($_POST['key']);
$url = htmlspecialchars($_POST['url']);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST,TRUE);
    
echo "распознаем изображение...<br>";

curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Prediction-Key: '.$key,
    'Content-Type: application/json'
));

curl_setopt($ch, CURLOPT_POSTFIELDS,"{'url' : '".$fullpath."'}" );
    
curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);

$res = curl_exec($ch);
    
echo '<pre>';
$array =json_decode($res,TRUE);
print_r($array);
echo '</pre>';
    
    $found = FALSE;
    foreach($array['predictions'] as $choice)
    {
        if($choice['probability'] > 0.5)
        {
            if(!$found) echo "Найдены соответствия:<br>";
            $found = TRUE;
            echo "это ".$choice['tagName']." с вероятностью ".$choice['probability']." <br>";
        }
    }
    if(!$found) echo "Соответствий не найдено.";
    

    
    $trainurl = "https://southcentralus.api.cognitive.microsoft.com/customvision/v1.0/Training/projects/".$array['project']."/images/image";

curl_close($ch);
?>
<img src="<?php echo $filepath?>" width="200" height="200"><br>
<form action="train.php" method="post">
    <input type="text" name ="filepath" value="<?php echo $filepath?>"><br>
    <input type="text" name ="key" value="<?php echo $$key?>"><br>
    <input type="text" name ="trainurl" value="<?php echo $trainurl?>"><br>
    <input type="text" name="tag" required placeholder="добавить тег и дообучить модель"><br>
    <button type="submit">Отправить для дообучения модели</button>
</form>
Более полна информация о том как выглядят запросы к службе дообучения модели здесь: <a href="https://southcentralus.dev.cognitive.microsoft.com/docs/services/d9a10a4a5f8549599f1ecafc435119fa/operations/58d5835bc8cb231380095be3">API documentation</href>

</body>
</html>
