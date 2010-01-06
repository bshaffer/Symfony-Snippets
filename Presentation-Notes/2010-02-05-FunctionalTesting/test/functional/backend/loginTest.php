<?php
$app = 'backend';
include(dirname(__FILE__) . '/../../bootstrap/functional.php');

$browser = new csTestFunctional(new sfBrowser(), null, array('form' => 'csTesterForm', 'doctrine' => 'sfTesterDoctrine'));

$browser
  ->get('/company')
  
  ->isModuleAction('company', 'index', 401)
  
  ->with('form')->begin()
    ->fill('login_bad')
  ->end()
  
  ->click('sign in')
  
  ->isModuleAction('sfGuardAuth', 'signin')
  
  ->with('form')->begin()
    ->hasErrors()
    ->fill('login')
  ->end()

  ->click('sign in')
  
  ->followRedirect()
  
  ->isModuleAction('company', 'index')
;