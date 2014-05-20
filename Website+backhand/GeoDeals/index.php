<?php
require 'libs/Bootstrap.php';
require 'libs/Controller.php';
require 'libs/View.php';
require 'libs/Model.php';
require 'libs/Database.php';
require 'libs/Session.php';
require 'libs/User.php';

require 'config/paths.php';
require 'config/vars.php';

Session::init();

$bootstrap = new Bootstrap();
