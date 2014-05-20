<?php
require 'libs/Bootstrap.php';
require 'libs/Controller.php';
require 'libs/View.php';
require 'libs/Model.php';
require 'libs/Database.php';
require 'libs/Session.php';
require 'libs/User.php';

//include all the libs
require 'libs/view_functions.php';
require 'libs/ImageHelper.php';

require 'config/paths.php';

Session::init();

$bootstrap = new Bootstrap();
