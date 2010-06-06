<?php

/**
 * sfValidatorSchemaRequired assures one or more fields from an array contains a value.
 *
 * @author     Brent Shaffer <bshafs@gmail.com>
 */
class sfValidatorSchemaRequired extends sfValidatorSchema
{
  /**
   * Constructor.
   *
   * Available options:
   *
   *  * num_required:         minimum amount of fields that must pass validation (default is 1)
   *  * field_labels:         field labels passed to the global_invalid message
   *
   * Available messages:
   *
   *  * global_invalid:       Global error thrown for the form
   *
   * @param string $fields      Array of fields to choose from.  These values are also passed to the global_invalid message
   * @param array  $options     An array of options
   * @param array  $messages    An array of error messages
   *
   * @see sfValidatorBase
   */
  public function __construct(array $fields, $options = array(), $messages = array())
  {
    $this->addOption('min_required', 1);
    $this->addOption('max_required', null);
    $this->addOption('fields', $fields);
    $this->addOption('labels', array());
    $this->addOption('throw_global_error', true);
    
    $this->addMessage('min_invalid', 'You must fill out at least %num_required% of these fields');
    $this->addMessage('max_invalid', 'You filled out too many fields. Only %num_required% allowed');
    $this->addMessage('global_invalid', 'You filled out %num_valid% of %num_required% required fields below');
    
    parent::__construct(null, $options, $messages);
  }

  /**
   * @see sfValidatorBase
   */
  protected function doClean($values)
  {
    $valid = 0;
    foreach ($this->getOption('fields') as $field) {      
      $valid += (isset($values[$field]) && $values[$field]) ? 1:0;
    }
    
    if ($valid < $this->getOption('min_required'))
    {
      $this->throwError($valid, 'min_required');
    }
    
    if ($valid > $this->getOption('max_required'))
    {
      $this->throwError($valid, 'max_required');
    }
    
    return $values;
  }
  
  protected function throwError($numValid, $error)
  {
    $errorSchema = new sfValidatorErrorSchema($this);
    
    if ($this->getOption('throw_global_error')) 
    {
      // Add global error
      $errorSchema->addError(new sfValidatorError($this, 'global_invalid', array(
          $error          => $this->getOption($error),
          'num_valid'     => $numValid,
          'fields'        => implode(', ', $this->getOption('fields')),
          'labels'        => implode(', ', $this->getOption('labels')),
      )));
    }
      
    $error = new sfValidatorError($this, 'invalid', array($error => $this->getOption($error)));
    
    // Add an error for each of the fields
    foreach ($this->getOption('fields') as $field) 
    {
      $errorSchema->addError($error, $field);
    }
    
    throw $errorSchema;
  }
}
