<?php

/**
* Widget for a Credit Card Date widget
*/
class sfWidgetFormCCExpirationDate extends sfWidgetFormI18nDate
{
  protected $_options = array('can_be_empty' => false,
                               'culture'=>'en',
                               'month_format'=>'name',
                               'format'=> '%month% %year%');
       
  public function __construct($options = array(), $attributes = array())
  {
    $years = range(date('Y'), date('Y') + 5);
    $options['years'] = isset($options['years']) ? $options['years'] : array_combine($years, $years);
    return parent::__construct(array_merge($this->_options, $options), $attributes);
  }     
}
