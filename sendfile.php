
<?php 
$filepath = htmlspecialchars($_POST['filepath']);
$Server = $_SERVER['SERVER_NAME'];
$fullpath = 'https://'.$Server.'/'.$filepath;
    
$key = htmlspecialchars($_POST['key']);
$url = htmlspecialchars($_POST['url']);
    
$ch = curl_init($url); 
curl_setopt($ch, CURLOPT_POST,TRUE);

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
 
curl_close($ch);
?> 
