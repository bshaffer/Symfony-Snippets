<?php

// test the process of viewing and saving editable areas
require_once dirname(__FILE__).'/../bootstrap/bootstrap.php';

$browser = new sfTestFunctional(new sfBrowser());

$browser->info('Testing my application homepage')
  ->get('/')

  ->with('response')->begin()
    ->isStatusCode(200)
  ->end()
;