<?php

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

?>