<?php

/**
* serializes an array of values
*/
class sfValidatorEmbeddedForm extends sfValidatorBase
{
  /**
   * options:
   *    * required_rows: if the value is an array, check that the row count must equal a certain number
   *
   * @param string $options 
   * @param string $messages 
   * @return void
   * @author Brent Shaffer
   */
  protected function configure($options = array(), $messages = array())
  {
    $this->addRequiredOption('form');
    
    $this->addOption('throw_form_errors', true);
    
    $this->addOption('archiver', 'sfArchiverSerialize');
    
    $this->addMessage('invalid', 'Your form contains some errors');
    
    parent::configure($options, $messages);
  }
  
  protected function doClean($value)
  {
    $form = $this->getOption('form');

    $form->bind($value);
    
    if ($form->isValid()) 
    {
      $archiverClass = $this->getOption('archiver');
      $archiver = new $archiverClass();
      return $archiver->sleep($form->getValues());
    }
    
    throw $this->getOption('throw_form_errors') ? $form->getErrorSchema() : new sfValidatorErrorSchema($this);
  }
}
