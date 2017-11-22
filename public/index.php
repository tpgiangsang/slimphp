<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

$app = new \Slim\App;

//routing management.
require_once('../api/novels.php');
require_once('../api/contacts.php');

$app->run();