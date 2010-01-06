<?php
$app = 'backend';
include(dirname(__FILE__) . '/../../bootstrap/functional.php');

$browser = new csTestFunctional(new sfBrowser(), null, array('form' => 'csTesterForm', 'doctrine' => 'sfTesterDoctrine'));

$browser->info('Create a new Unit');

$browser
  ->login()
  
  ->get('/company/new')
  
  ->with('form')->begin()
    ->fill('company', array('company[name]' => sfFactory::generate('Unit')))
  ->end()

  ->info('Create Unit "'.sfFactory::last().'"')
  
  ->click('Save and add')
  
  ->with('form')->begin()
    ->hasErrors(false)
  ->end()
  
  ->followRedirect()

  ->with('doctrine')->begin()
    ->check('Company', array('name' => sfFactory::last()))
  ->end()
;