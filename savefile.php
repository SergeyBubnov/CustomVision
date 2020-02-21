<?php

$Uploaded_file_location = FALSE;

try {
    
     if (
        !isset($_FILES['test']['error']) ||
        is_array($_FILES['test']['error'])
    ) {
        throw new RuntimeException('Invalid parameters.');
    }

    switch ($_FILES['test']['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_NO_FILE:
        	throw new RuntimeException('');
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            throw new RuntimeException('Exceeded filesize limit.');
        default:
            throw new RuntimeException('Unknown errors.');
    }

    // You should also check filesize here. 
    if ($_FILES['test']['size'] > 10000000) {
        throw new RuntimeException('Exceeded filesize limit.');
    }
  
    // DO NOT TRUST $_FILES['upfile']['mime'] VALUE !!
    // Check MIME Type by yourself.
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    if (false === $ext = array_search(
        $finfo->file($_FILES['test']['tmp_name']),
        array(
            'jpg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
        ),
        true
    )) {
        throw new RuntimeException('Invalid file format.');
    }

  	$Uploaded_file_location = sprintf('upload/%s.%s', sha1_file($_FILES['test']['tmp_name']),$ext);
  
    if (!move_uploaded_file($_FILES['test']['tmp_name'],'./'.$Uploaded_file_location))
    {
        throw new RuntimeException('Failed to move uploaded file.');
    }

} catch (RuntimeException $e) {

    echo $e->getMessage();

}
?>

<!DOCTYPE HTML>
<html>
<body>
    <form action="sendfile.php" method="post">
        <input type="hidden" name ="filepath" value="<?php echo $Uploaded_file_location?>">
        
        <input type="text" name="url" required placeholder="вставьте url службы CustomVision" size="100"><br>
<input type="text" name="key" required placeholder="вставьте Prediction-Key службы Custom Vision" size="100"><br>
        <button type="submit">Отправить на тест Custom Vision</button>
    </form>
    <img src="<?php echo $Uploaded_file_location?>" width="200" height="200">
</body>
</html>
