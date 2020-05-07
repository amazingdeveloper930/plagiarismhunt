<?php

namespace App\Services;
use Storage;
use Exception;

class FileUtil
{
	public static function read_doc($filename)
	{
		$filename = "../storage/app/1.doc";
		$fileHandle = fopen("../storage/app/1.doc", "r");

	    $line = @fread($fileHandle, filesize($filename));   

	    $lines = explode(chr(0x0D),$line);
	    $outtext = "";
	    foreach($lines as $thisline)
	      {
	        $pos = strpos($thisline, chr(0x00));
	        if (($pos !== FALSE)||(strlen($thisline)==0))
	          {
	          } else {
	            $outtext .= $thisline." ";
	          }
	      }
	     $outtext = preg_replace("/[^a-zA-Z0-9\s\,\.\-\n\r\t@\/\_\(\)]/","",$outtext);
	    return $outtext;
	}

	public static function read_docx($filename){
		// $filename = "../storage/app/" . $filename;
        $filename = Storage::disk('local')->path($filename);
        $striped_content = '';
        $content = '';

        $zip = \zip_open($filename);

        if (!$zip || is_numeric($zip)) return false;
        
        while ($zip_entry = zip_read($zip)) {

            if (zip_entry_open($zip, $zip_entry) == FALSE) continue;

            if (zip_entry_name($zip_entry) != "word/document.xml") continue;

            $content .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));

            zip_entry_close($zip_entry);
        }// end while

        zip_close($zip);

        $content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $content);
        $content = str_replace('</w:r></w:p>', "\r\n", $content);
        $striped_content = strip_tags($content);

        return $striped_content;
    }


    public static function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
    }

    public static function sendRequest($url, $postfields)
    {        
        //initialize and setup the curl handler
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, count($postfields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postfields));
 
        //execute the request
        $result = curl_exec($ch);

        //json_decode the result
        $result = json_decode($result, true);
       
        //check if we're able to json_decode the result correctly
        if( $result == false || isset($result['success']) == false ) {
            throw new Exception('Request was not correct');
        }
         
        //if there was an error in the request, throw an exception
        if( $result['success'] == false ) {
            throw new Exception($result['errormsg']);
        }
         
        //if everything went great, return the data
        return $result['data'];
    }
}