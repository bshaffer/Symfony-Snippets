<?php

/**
 * Converts Array to XML and XML to array
 *   ** warning: this has not been tested and is only to be used as an example **
 * @author    Brent Shaffer <bshafs at gmail dot com>
 */
class ArchiverXml implements ArchiverInterface
{
    public function sleep($value)
    {
        $xml = new SimpleXMLElement("<?xml version=\"1.0\"?><root></root>"); 
        
        $this->doSleep($value, $xml);
        
        return $xml->asXML(); 
    }
    
    protected function doSleep($value, $xml)
    {
        foreach($value as $key => $val) { 
            if(is_array($val)) { 
                $child = $xml->addChild($k); 
                
                $this->doSleep($val, $child); 
            } else { 
                $xml->addChild($key,$value); 
            } 
        }
        
        return $xml;
    }
    
    public function wake($value)
    {
        $xml = simplexml_load_string($value);

        $children = array(); 

        $children = $xml->children(); 
        if ($root){ // we're at root 
            $path .= '/'.$xml->getName(); 
        } 

        if ( count($children) == 0 ){ 
            $return[$path] = (string)$xml; 
            return; 
        } 
        $seen=array(); 
        foreach ($children as $child => $value) { 
            $childname = $child->getName();
            if ( !isset($seen[$childname])){ 
                $seen[$childname]=0; 
            } 
            $seen[$childname]++; 
            $this->wake($value, $return, $path.'/'.$child.'['.$seen[$childname].']'); 
        } 
    }
    
    public function isAsleep($value)
    {
        return $value && is_string($value);
    }
}
