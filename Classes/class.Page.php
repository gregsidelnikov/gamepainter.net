<?php /* Defines the generic web page data type */
class Page extends HTML
    {
    public $title;

    public $body;

    public $id;

    // page data id
    public $location;

    // this is the Location in "http://localhost/my-website.com/Location", can be a username or an article title
    public $exists;

    // does this page data exist?
    public $data;

    // mysql data array
    public $scripts;

    // holds javascripts
    public $scripts_count;

    // script counter;
    public $css;

    // holds css string
    public $css_count;

    // css counter

    // ~Constructor

    function __construct($title)
    {
        $this->title = $title;
        $this->scripts = array();
        $this->scripts_count = 0;
        $this->css_count = 0;
    }

    function AddJavascript($url)
    {
        //if (substr($url, 0, 4) == "http")
            $this->scripts[$this->scripts_count++] = $url;
    }

    function AddjQueryFunctionality()
    {
        $this->AddJavascript("jquery-1.8.2.js");
    }

    function AddBloomButtonFunctionality()
    {
        $this->AddJavascript("bloom.js");
    }

    function PrintJavascript()
    {
        global $URL;
        for ($i = 0; $i < count( $this->scripts ); $i++)
            if (substr($this->scripts[$i], 0, 4) == "http")
                print "\r\n<script src = '" . $this->scripts[ $i ] . "' type = 'text/javascript'></script>";
            else
                print "\r\n<script src = '$URL/js/" . $this->scripts[ $i ] . "' type = 'text/javascript'></script>";
    }

    function AddCSS($url)
    {
        $this->css[$this->css_count++] = $url;
    }

    function PrintCSS()
    {
        global $URL;
        print "\r\n";
        for ($i = 0; $i < count( $this->css ); $i++)
        {
            if (substr($this->css[$i], 0, 4) == "http")
                print "<link rel = 'stylesheet' type = 'text/css' href = '" . $this->css[ $i ] . "' />\r\n";
            else
                print "<link rel = 'stylesheet' type = 'text/css' href = '$URL/css/" . $this->css[ $i ] . "' />\r\n";
        }
    }

    function DisplayTitle()
    {
        print $this->title;
    }
}
