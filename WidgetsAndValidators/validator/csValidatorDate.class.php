<?php

class csValidatorDate extends sfValidatorDate
{
  protected function configure($options = array(), $messages = array())
  {
    $this->addOption('with_meridiem', false);
    parent::configure($options, $messages);
    
    // setting option "date_format_range_error" because the format in sfValidatorDate is unreadable.
    $this->setOption('date_format_range_error', 'F jS, Y');
  }
  
  
  protected function convertDateArrayToString($value)
  {
    if ($this->getOption('with_meridiem')) 
    {
      if (!isset($value['meridiem']) || !in_array(strtolower($value['meridiem']), array('am', 'pm'))) 
      {
        throw new sfValidatorError($this, 'invalid', array('value' => $value));
      }
      
      if (strtolower($value['meridiem']) == 'pm') 
      {
        $value['hour'] += 12;
      }
    }
    
    $ret = parent::convertDateArrayToString($value);
    
    $timestamp = strtotime($ret);
    
    sfContext::getInstance()->getLogger()->debug("Timestamp: ".$timestamp . ' for '.date('Y-m-d H:i:s', $timestamp) . ' ('.date('Y-m-d h:i:s A', $timestamp).')');
    
    return $ret;
  }
}