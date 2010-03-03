<?php

/**
 * Report filter form.
 *
 * @package    cfit
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TaskFormFilter extends BaseTaskFormFilter
{
  public function configure()
  {
    $fields = $fields ? $fields : array('start_date', 'end_date');
    
    $this->setOption('occurs_in_range.filter_fields', $fields);
    
    $this->widgetSchema['occurs_in_range'] = new sfWidgetFormFilterDate(
      array('with_empty' => false,
            'from_date' => new sfWidgetFormDate(), 
            'to_date' => new sfWidgetFormDate()));
    
    $this->validatorSchema['occurs_in_range'] = new sfValidatorDateRange(
      array('required' => false, 
            'from_date' => new sfValidatorDate(array('required' => false)),
            'to_date' => new sfValidatorDate(array('required' => false))));
  }
}
