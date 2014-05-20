<?php
class Error extends Controller
{
    function __construct($args = array())
    {
        parent::__construct();
        $this->view->render(__CLASS__ . '/index');
    }
}
?>
