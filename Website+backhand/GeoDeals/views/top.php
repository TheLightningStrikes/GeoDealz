<?php
Session::init();

if(Session::get("isLoggedIn"))
{
    echo "<div id=\"top\">
                    <div class=\"user\">
                            <div class=\"image\">
                                    <img src=\"". URL . "images/default_user.png\" alt=\"User Image\" />
                            </div>
                            <div class=\"name\">" . Session::get("User")->GetUsername() . "</div>
                            <form id=\"form\" action=\"" . URL . "login\logout\">
                                    <input class=\"green\" type=\"submit\" value=\"Logout\" />
                            </form>
                    </div>
                </div>";
}
else
{
    echo "<div id=\"top\">	
                    <a href=\"" . URL . "login\">
                            <div class=\"user\">
                                    <div class=\"login\">
                                            Login
                                    </div>
                            </div>
                    </a>
                </div>";
}