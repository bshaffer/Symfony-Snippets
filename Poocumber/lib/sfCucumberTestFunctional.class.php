<?php

/**
* Functional test for cucumber
*/
class sfCucumberTestFunctional extends sfTestFunctional
{
  protected $givens = array(),
            $whens  = array(),
            $thens  = array();

  public function given($statement, $function)
  {
    $this->givens[$statement] = $function;
  }
  
  public function whens($statement, $function)
  {
    $this->whens[$statement] = $function;
  }
  
  public function thens($statement, $function)
  {
    $this->thens[$statement] = $function;
  } 
  
  public function testFeature($name)
  {
    $features = sfYaml::load(sfConfig::get('sf_test_dir').'/data/features/'.$name.'_features.yml');
    include_once(sfConfig::get('sf_test_dir').'/data/features/steps/'.$name.'_steps.php');
    include_once(sfConfig::get('sf_test_dir').'/data/features/steps/steps.php');
    
    foreach ($features as $name => $feature) 
    {
      $this->info($name);
      foreach ((array) $this['Given'] as $statement) 
      {
        $matches = array();
        foreach ($this->givens as $given => $function) 
        {
          if(preg_match_all($statement, $given, $matches))
          {
            $function($this, $mathces);
          }
        }
      }
      
      foreach ((array) $this['When'] as $statement) 
      {
        $matches = array();
        foreach ($this->whens as $when => $function) 
        {
          if(preg_match_all($statement, $when, $matches))
          {
            $function($this, $mathces);
          }
        }
      }
            
      foreach ((array) $this['Then'] as $statement) 
      {
        $matches = array();
        foreach ($this->thens as $then => $function) 
        {
          if(preg_match_all($statement, $then, $matches))
          {
            $function($this, $mathces);
          }
        }
      }
    }
  } 
}