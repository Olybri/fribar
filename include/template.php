<?php

class Template
{
    private $name;
    private $values = array();
    
    public function __construct($name = "")
    {
        $this->set_name($name);
    }
    
    public function set_name($name)
    {
        $this->name = $name;
    }
    
    public function set($key, $value)
    {
        $this->values[$key] = $value;
    }
    
    public function html()
    {
        if(empty($this->name))
            die("<br><b>Error</b>: Template name not defined.");
        
        $filename = "template/$this->name.html";
        if(!file_exists($filename))
            die("<br><b>Error</b>: Template file not found <i>$filename</i>.");
        
        $html = file_get_contents($filename);
        
        foreach($this->values as $key => $value)
            $html = str_replace("{".$key."}", $value, $html);
        
        if(preg_match_all("<{(.+)}>", $html, $matches) != 0)
        {
            echo "<br><b>Error</b>: Value(s) not defined in template file <i>$filename</i>:<ul>";
            foreach(array_unique($matches[1]) as $match)
                echo "<li>$match<br></li>";
            die("</ul>");
        }
        
        return $html;
    }
}