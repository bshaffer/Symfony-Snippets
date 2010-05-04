<?php

/**
* 
*/
class sfWidgetFormChoiceWeek extends sfWidgetForm
{
  public function configure($options = array(), $attributes = array())
  {
    $this->addOption('end_date', null);
    $this->addOption('start_date', date('Y-m-d'));
    $this->addOption('starts_on', 'Sunday');
    $this->addOption('ends_on', 'Saturday');
    $this->addOption('index_format', 'Y-m-d');
    $this->addOption('display_format', 'F jS');
    $this->addOption('display_end', false);
    $this->addOption('add_empty', true);
    
    parent::configure($options, $attributes);
  }
  
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    $choice = new sfWidgetFormChoice(array('choices' => $this->calculateWeeks()));
    return $choice->render($name, $this->getIndex(strtotime($value)), $attributes, $errors);
  }
  
  public function calculateWeeks()
  {
    $weeks = $this->getOption('add_empty') ? array(null =>($this->getOption('add_empty') === true? '': $this->getOption('add_empty'))) : array();
    $start = cfitScheduler::calculateNextWeekday($this->getOption('starts_on'), strtotime($this->getOption('start_date')));
    
    if ($this->getOption('display_end')) 
    {
      $diff = (7 + date('w', strtotime($this->getOption('ends_on'))) - date('w', strtotime($this->getOption('starts_on')))) % 7;
    }
    
    $ends = $this->getOption('end_date')  ? strtotime($this->getOption('end_date')) : strtotime('+52 weeks', $start);
    
    while($start < $ends) 
    {
      $index = $this->getIndex($start);

      // timestamp from ISO week date format  
      $weeks[$index] = date($this->getOption('display_format'), $start);
      
      if ($this->getOption('display_end')) 
      {
        $weeks[$index] .= ' - '.date($this->getOption('display_format'), strtotime("+$diff days", $start));
      }
      
      $start = strtotime("+1 weeks", $start);
    }  
    return $weeks;
  }
  
  protected function getIndex($timestamp)
  {
    return $timestamp && $this->getOption('index_format') ? date($this->getOption('index_format'), $timestamp) : $timestamp;
  }
}
