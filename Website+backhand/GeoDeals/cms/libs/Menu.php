<?php
class Menu {

    var $_buttons = null;
    
    function __construct() {
        $this->AddButton(URL, "Home");
    }
    
    public function AddButton($url, $text)
    {
        $this->_buttons[] = "<a href=\"" . $url . "\">
                    <div class=\"button green\">
                        $text
                    </div>
                </a>";
    }
    
    public function ShowButtons()
    {
        $html = "";
        foreach($this->_buttons as $button)
        {
           $html .= $button;
        }
        return $html;
    }
    
    public function HandleButtons($location)
    {
        $location = explode("/", $location);
        if(count($location) > 1){
            $location = $location[0] ."/". $location[1];
        }
        else
        {
            $location = $location[0];
        }
        
        switch ($location)
        {
            case "category/show":
                 if(Session::get("isLoggedIn"))
                    $this->AddButton(URL . "topic/new", "Topic Toevoegen");
                break;
                case "":
                    if(Session::get("isLoggedIn"))
                        if(Session::get("User")->GetId() == "1")
                            $this->AddButton(URL . "category/new", "Categorie Toevoegen");
                    break;
            default:
                
                break;
        }
    }
}