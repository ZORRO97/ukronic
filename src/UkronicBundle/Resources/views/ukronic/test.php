<?php  

Class BingTranslator
{
    public function translate($content, $from = 'fr', $to = 'en')
    {
        $data = array(
            'appId' => API_KEY_BING,
            'text'  => $content,
            'from'  => $from,
            'to'    => $to,
        );
 
        $urlTarget = 'http://api.microsofttranslator.com/V2/Http.svc/Translate?' . http_build_query($data);
        $translation = @file_get_contents($urlTarget);
 
        if ($translation === false)
        {
            return array(
                'error' => true,
                'msgError' => 'API Key Invalid or invalid languages',
            );
        }
 
        $result = array(
            'error' => false,
            'translation' => $translation,
        );
 
        return $result;
    }
}

$bing = new BingTranslator();
$result = $bing->translate("Mon texte à traduire", 'fr', 'en');
if ($result['error'])
    echo $result['msgError'];
else
    echo $result['translation'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Test de traduction</title>
</head>
<body>
    
</body>
</html>