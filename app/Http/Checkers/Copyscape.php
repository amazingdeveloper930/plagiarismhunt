<?php

namespace App\Http\Checkers;


class Copyscape {


    protected $COPYSCAPE_USERNAME = "erogatulix";
    protected $COPYSCAPE_API_KEY = "vewnpw8fyrgc8678";
    protected $COPYSCAPE_API_URL = "http://www.copyscape.com/api/";


    function copyscape_api_url_search_internet($url, $full=null)
	{
		return $this -> copyscape_api_url_search($url, $full, 'csearch');
	}
	
	function copyscape_api_text_search_internet($text, $encoding, $full=null)
	{
		return $this -> copyscape_api_text_search($text, $encoding, $full, 'csearch');
	}
	
	function copyscape_api_check_balance()
	{
		return $this -> copyscape_api_call('balance');
	}
	
/*
	C. Functions for you to use (only accounts with private index enabled)
*/
	
	function copyscape_api_url_search_private($url, $full=null)
	{
		return $this -> copyscape_api_url_search($url, $full, 'psearch');
	}
	
	function copyscape_api_url_search_internet_and_private($url, $full=null)
	{
		return $this -> copyscape_api_url_search($url, $full, 'cpsearch');
	}

	function copyscape_api_text_search_private($text, $encoding, $full=null)
	{
		return $this -> copyscape_api_text_search($text, $encoding, $full, 'psearch');
	}
	
	function copyscape_api_text_search_internet_and_private($text, $encoding, $full=null)
	{
		return $this -> copyscape_api_text_search($text, $encoding, $full, 'cpsearch');
	}
	
	function copyscape_api_url_add_to_private($url, $id=null)
	{
		$params['q']=$url;
		
		if (isset($id))
			$params['i']=$id;
			
		return $this -> copyscape_api_call('pindexadd', $params);
	}
	
	function copyscape_api_text_add_to_private($text, $encoding, $title=null, $id=null)
	{
		$params['e']=$encoding;
		
		if (isset($title))
			$params['a']=$title;

		if (isset($id))
			$params['i']=$id;
			
		return $this -> copyscape_api_call('pindexadd', $params, null, $text);
	}
	
	function copyscape_api_delete_from_private($handle)
	{
		$params['h']=$handle;
		
		return $this -> copyscape_api_call('pindexdel', $params);
	}
	
/*
	D. Some examples of use
*/

    function doAnalysis($exampletext)
    {

        $variable = $this -> copyscape_api_text_search_internet($exampletext, 'ISO-8859-1', 5);
        // $result = htmlspecialchars(print_r($variable, true));
		return $variable;        
    }
	
	function my_echo_title($title)
	{
		echo '<P><BIG><B>'.htmlspecialchars($title).':</B></BIG></P>';
		flush();
	}
	
	function my_print_r($variable)
	{
		echo '<PRE>'.htmlspecialchars(print_r($variable, true)).'</PRE><HR>';
		flush();
	}

/*
	E. Functions used internally
*/

	function copyscape_api_url_search($url, $full=null, $operation='csearch')
	{
		$params['q']=$url;

		if (isset($full))
			$params['c']=$full;
		
		return $this -> copyscape_api_call($operation, $params, array(2 => array('result' => 'array')));
	}
	
	function copyscape_api_text_search($text, $encoding, $full=null, $operation='csearch')
	{
		$params['e']=$encoding;

		if (isset($full))
			$params['c']=$full;

		return $this -> copyscape_api_call($operation, $params, array(2 => array ('result' => 'array')), $text);
	}

	function copyscape_api_call($operation, $params=array(), $xmlspec=null, $postdata=null)
	{
		$url=$this -> COPYSCAPE_API_URL.'?u='.urlencode($this -> COPYSCAPE_USERNAME).
			'&k='.urlencode($this -> COPYSCAPE_API_KEY).'&o='.urlencode($operation);
		
		foreach ($params as $name => $value)
			$url.='&'.urlencode($name).'='.urlencode($value);
		
		$curl=curl_init();
		
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
	
	function copyscape_read_xml($xml, $spec=null)
	{
		global $copyscape_xml_data, $copyscape_xml_depth, $copyscape_xml_ref, $copyscape_xml_spec;
        

		$copyscape_xml_data=array();
		$copyscape_xml_depth=0;
		$copyscape_xml_ref=array();
		$copyscape_xml_spec=$spec;
		
		$parser=xml_parser_create();
		
		xml_set_element_handler($parser, 'copyscape_xml_start', 'copyscape_xml_end');
		xml_set_character_data_handler($parser, 'copyscape_xml_data');
		
		if (!xml_parse($parser, $xml, true))
			return false;
			
		xml_parser_free($parser);
		
		return $copyscape_xml_data;
    }
    
    function copyscape_xml_start($parser, $name, $attribs)
	{
		global $copyscape_xml_data, $copyscape_xml_depth, $copyscape_xml_ref, $copyscape_xml_spec;
		
		$copyscape_xml_depth++;
		
		$name=strtolower($name);
		
		if ($copyscape_xml_depth==1)
			$copyscape_xml_ref[$copyscape_xml_depth]=&$copyscape_xml_data;
		
		else {
			if (!is_array($copyscape_xml_ref[$copyscape_xml_depth-1]))
				$copyscape_xml_ref[$copyscape_xml_depth-1]=array();
				
			if (@$copyscape_xml_spec[$copyscape_xml_depth][$name]=='array') {
				if (!is_array(@$copyscape_xml_ref[$copyscape_xml_depth-1][$name])) {
					$copyscape_xml_ref[$copyscape_xml_depth-1][$name]=array();
					$key=0;
				} else
					$key=1+max(array_keys($copyscape_xml_ref[$copyscape_xml_depth-1][$name]));
				
				$copyscape_xml_ref[$copyscape_xml_depth-1][$name][$key]='';
				$copyscape_xml_ref[$copyscape_xml_depth]=&$copyscape_xml_ref[$copyscape_xml_depth-1][$name][$key];

			} else {
				$copyscape_xml_ref[$copyscape_xml_depth-1][$name]='';
				$copyscape_xml_ref[$copyscape_xml_depth]=&$copyscape_xml_ref[$copyscape_xml_depth-1][$name];
			}
		}
	}

	function copyscape_xml_end($parser, $name)
	{
		global $copyscape_xml_depth, $copyscape_xml_ref;
		
		unset($copyscape_xml_ref[$copyscape_xml_depth]);

		$copyscape_xml_depth--;
	}
	
	function copyscape_xml_data($parser, $data)
	{
		global $copyscape_xml_depth, $copyscape_xml_ref;

		if (is_string($copyscape_xml_ref[$copyscape_xml_depth]))
			$copyscape_xml_ref[$copyscape_xml_depth].=$data;
	}

	
}


?>