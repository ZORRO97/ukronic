<?php
namespace UkronicBundle\Twig\Extension;

class FileExtension extends \Twig_Extension
{
    /**
     * Return the functions registered as twig extensions
     *
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('remote_file_exists', [$this, 'remoteFileExists']),
        ];
    }

    /**
     * @param string $url
     *
     * @return bool
     */
    public function remoteFileExists($url)
    {
        if ($url == "N/A") return false;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        $result = curl_exec($ch);
        $ret = false;
        

        //if request did not fail
        if ($result !== false) {
            //if request was ok, check response code
            $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);  
            
            if ($statusCode == 200) {
                $ret = true;   
            }
        }
        
        curl_close($ch);
        
        return $ret;
    }

    public function getName()
    {
        return 'app_file';
    }
}
