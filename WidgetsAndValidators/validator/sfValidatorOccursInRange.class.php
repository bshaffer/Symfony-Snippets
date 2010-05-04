<?php

class sfValidatorOccursInRange extends sfValidatorBase
{
  public function configure($options = array(), $messages = array())
  {
    $this->addOption('date_format_error', 'F jS, Y');
    $this->addOption('does_occur', true);

    $this->setMessage('invalid', 'Date range %range% and range %item% %does_occur% overlap');
        
    parent::configure($options, $messages);
  }  

  /**
   * @see sfValidatorBase
   */
  protected function doClean($values)
  {
    // Convert to Timestamps
    foreach ($values as &$value) 
    {
      if (!is_numeric($value))
      {
        $value     = strtotime($value);
      }
    }
    
    // Exclusive Or == Awesome
    if ($this->getOption('does_occur') ^ cfitScheduler::overlapsRange($values['range_start'], $values['range_end'], $values['item_start'], $values['item_end']))
    {
      throw new sfValidatorError($this, 'invalid', array(
        'range'   => $this->formatDateRange($values['range_start'], $values['range_end']),
        'item'   => $this->formatDateRange($values['item_start'], $values['item_end']),
        'does_occur'    => $this->getOption('does_occur') ? 'must' : 'cannot',
      ));
    }
    
    return $values;
  }
  
  protected function formatDateRange($start, $end)
  {
    $startDate = date($this->getOption('date_format_error'), $start);
    $endDate = date($this->getOption('date_format_error'), $end);
    if ($start) 
    {
      if ($end) 
      {
        return sprintf('%s to %s', $startDate, $endDate );
      }
      return sprintf('starting %s', $startDate );
    }
    if ($end) 
    {
      return sprintf('ending %s', $endDate );
    }
    return 'N/A';
  }
}