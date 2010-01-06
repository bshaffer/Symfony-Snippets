<?php

/**
* Functional test for testing forms
*/
class csTestFunctional extends sfTestFunctional
{
  public function clickAndCheck($link, $module, $action, $statusCode = 200)
  {
    return $this->click($link)->isModuleAction($module, $action, $statusCode);
  }

  public function isModuleAction($module, $action, $statusCode = 200)
  {
    $this->with('request')->begin()->
  	  isParameter('module', $module)->
  	  isParameter('action', $action)->
  	end()->  

    with('response')->begin()->
    	isStatusCode($statusCode)->
    end();

    return $this;
  }
  
  public function login()
  {
    return 
    $this
      ->get('/login')
    
      ->with('form')->begin()
        ->fill('login')
      ->end()
      
      ->click('sign in')
    ;
  }
}
