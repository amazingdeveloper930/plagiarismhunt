<?php

namespace App\Http\Checkers;

class Prepostseo {


    protected $PREPOSTSEO_API_KEY = "463925b237b8d51c9a3381c7ca638967";
    protected $PREPOSTSEO_API_URL = "https://www.prepostseo.com/apis/checkPlag";
    protected $PREPOSTSEO_API_MAX_WORDCOUNT = 3000;



    function doAnalysis($exampletext)
    {

        // $variable = $this -> CHECKERPLAG_api_text($exampletext);
        // $pos = strpos($variable, "{");
        // if($pos != false)
        // {
        //     $variable = substr($variable, $pos);
        // }
        // return $variable;        
        $text_array = $this -> PREPOSTSEO_spitetext_bywordscount($exampletext, $this -> PREPOSTSEO_API_MAX_WORDCOUNT);
        
        $details = array();
        $sources = array();
        $plag_percent = 0;
        $total_queries = 0;
        $total_percent = 0;
        foreach ($text_array as $value) {
            # code...
            $variable = $this -> PREPOSTSEO_api_text($value);
            
            $variable = json_decode($variable);
            if(isset($variable -> details)){
                $details = array_merge($details, $variable -> details);
               
            }
                    
            if(isset($variable -> totalQueries))
                    $total_queries += $variable -> totalQueries;
            if(isset($variable -> plagPercent))
                    $total_percent += $variable -> plagPercent * $variable -> totalQueries;    
            if(isset($variable -> sources))
            $sources = array_merge($sources, $variable -> sources);
            // var_dump($variable);
        }
        // foreach ($details[0] as $detail) {
        //     # code...
        //     if(count($detail -> matched_urls) > 0)
        //         $total_percent ++;

        // }
        
       
        if($total_queries != 0)
        $total_percent = $total_percent / $total_queries;
        $total_percent = $total_percent + rand(-3, 3);
        if($total_percent < 0)
        $total_percent = 0;
        $result = array(
            "totalQueries" => $total_queries,
            "plagPercent" => $total_percent,
            "details" => $details,
            'sources' => $sources
        );
        
        return $result;
    }
    function PREPOSTSEO_spitetext_bywordscount($longtext, $maxLineLength)
    {
        $arrayWords = explode(' ', $longtext);
        $currentLength = 0;
        $index = 0;
        $arrayOutput = array();
        $arrayOutput[0] = '';

        foreach ($arrayWords as $word) {
            $currentLength ++;
           
            
            if($currentLength >= $maxLineLength)
            {
                $arrayOutput[$index] .= $word ;
                $index ++;
                $currentLength = 0;
                $arrayOutput[$index] = '';
            }
            else {
                $arrayOutput[$index] .= $word . " ";
            }
        }

        if($currentLength == 0)
        {
            array_pop($arrayOutput);
        }
        for($index = 0; $index < count($arrayOutput); $index ++)
        {
            if(isset($arrayOutput[$index]) && $arrayOutput[$index]  != "" && substr($arrayOutput[$index], -1) == ' ')
            $arrayOutput[$index] = substr($arrayOutput[$index], 0, -1);
        }
        return $arrayOutput;
    }
    function PREPOSTSEO_api_text($exampletext)
    {
        $url =$this -> PREPOSTSEO_API_URL;
	
		$curl=curl_init();
        
        $postdata = array();
        $postdata['key'] = $this -> PREPOSTSEO_API_KEY;
        $postdata['data'] = $exampletext;
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, isset($postdata));
		
		if (isset($postdata))
			curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
		
		$response=curl_exec($curl);
		curl_close($curl);
		
		if (strlen($response))
            // return $this -> copyscape_read_xml($response, $xmlspec);
            return $response;
		else
			return false;
    }


}
