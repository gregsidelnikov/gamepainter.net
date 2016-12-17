<?php /* Defines the generic HTML page data type */
class HTML
    {
    public $m_pageTitle;

    public $m_metaDescription;

    public $m_metaKeywords;

    // ~Constructor
    function __construct($title)
    {
        $this->m_pageTitle = $title;
    }

    public function PrintTitle()
    {
        print $this->m_pageTitle;
    }

    public function PrintDescription()
    {
        print $this->m_metaDescription;
    }

    public function PrintKeywords()
    {
        print $this->m_metaKeywords;
    }
}

?>