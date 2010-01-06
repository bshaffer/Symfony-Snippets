<?php

/*
 * This file is part of the symfony package.
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfTesterForm implements tests for forms submitted by the user.
 *
 * @package    symfony
 * @subpackage test
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfTesterForm.class.php 24217 2009-11-22 06:47:54Z fabien $
 */
class csTesterForm extends sfTesterForm
{
  protected 
    $_formData = array();
  
  /**
 * Constructor.
 *
 * Load form data (if applicable)
 *
 * @param sfTestFunctionalBase $browser A browser
 * @param lime_test            $tester  A tester object
 */
  public function __construct(sfTestFunctionalBase $browser, $tester)
  {
    parent::__construct($browser, $tester);
    
    
    if (file_exists(sfConfig::get('sf_test_dir').'/data/forms.yml')) 
    {
      $this->setFormData(sfYaml::load(sfConfig::get('sf_test_dir').'/data/forms.yml'));
    }
  }
  
  public function setFormData($data)
  {
    $this->_formData = $data;
  }
  
  public function mergeFormData($data)
  {
    $this->_formData = Doctrine_Lib::arrayDeepMerge($this->_formData, $data);
  }
  
  public function getFormValues($name)
  {
    if (!isset($this->_formData[$name])) 
    {
      throw new LogicException('data not set for form "'.$name.'"');
    }
    return isset($this->_formData[$name]) ? $this->_formData[$name] : array();
  }
  
  // Called at every occurence of $browser->with('form')
  public function initialize()
  {
    // Load form into local variable
    parent::initialize();
    
  }
  
  // Called when a page is requested
  // (at every occurence of $browser->call())
  public function prepare()
  {
    
  }
  
  public function fill($name, $values = array())
  {
    $formValues = Doctrine_Lib::arrayDeepMerge($this->getFormValues($name), $values);

    foreach ($formValues as $key => $value) 
    {
      $this->setDefaultField($key, $value);
    }

    return $this->getObjectToReturn();
  }

  public function setDefaultField($key, $value, $base = '')
  {
    $field = $base ? $base.'['.$key.']':$key;
    if (is_array($value)) 
    {
      foreach ($value as $key2 => $value2) 
      {
        $this->setDefaultField($key2, $value2, $field);
      }
    }
    else
    {
      $this->setField($field, $value);
    }
  }
}