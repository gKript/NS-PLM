<?php
/*
This file was autogenerated by ConfigurationLoader.class.php.
Please do not attempt to alter it's contents manually as any changes you make may be overwritten
*/
class gk
{
function __construct()
{
$this->info = new gk_info();
$this->param = new gk_param();

}
}
class gk_info
{
public $by;
public $author;
public $name;
public $debug;
public $version;
public $status;
public $subminor;
function __construct()
{
$this->by = (string) "gKript.org";
$this->author = (string) "asyntote";
$this->name = (string) "gK.php";
$this->debug = (int) 0;
$this->version = (string) "00.1";
$this->status = (string) "dev";
$this->subminor =  29;

}
}
class gk_param
{
public $session;
function __construct()
{
$this->authentication = new gk_param_authentication();
$this->session = (int) 1;

}
}
class gk_param_authentication
{
public $enable;
public $timeout;
public $cookie_allowed;
public $cookie_days;
function __construct()
{
$this->enable = (int) 1;
$this->timeout =  600;
$this->cookie_allowed = (int) 0;
$this->cookie_days = (int) 5;
$this->tables = new gk_param_authentication_tables();

}
}
class gk_param_authentication_tables
{
public $users;
public $online_users;
public $users_roles;
function __construct()
{
$this->users = (string) "users";
$this->online_users = (string) "online_users";
$this->users_roles = (string) "users_roles";

}
}
?>