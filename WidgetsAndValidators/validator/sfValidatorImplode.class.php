<?php

/**
* serializes an array of values
*/
class sfValidatorImplode extends sfValidatorChoice
{
  /**
   * options:
   *
   * @param string $options 
   * @param string $messages 
   * @return void
   * @author Brent Shaffer
   */
  protected function configure($options = array(), $messages = array())
  {
    $this->addOption('glue', ',');
    parent::configure($options, $messages);
  }
  
  protected function doClean($values)
  {
    $values = parent::doClean($values);
    
    return implode($this->getOption('glue'), $values);
  }
}
