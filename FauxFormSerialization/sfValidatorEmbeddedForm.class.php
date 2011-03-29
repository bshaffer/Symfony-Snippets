<?php

/**
 * sfValidatorEmbeddedForm saves form results into a single array
 *
 * @author    Brent Shaffer <bshafs at gmail dot com>
 */
class sfValidatorEmbeddedForm extends sfValidatorBase
{
    /**
    * options:
    *    * form: Required sfForm instance to validate
    *    * archiver: provide an archiver to sanitize results into a specific format (XML, YAML, etc).  Default is array.
    *    * throw_form_errors: whether or not to include validation errors in output
    *
    * messages:
    *    * invalid: error message to throw if validation fails
    *
    * @param string $options 
    * @param string $messages 
    * @return null
    * @author Brent Shaffer
    */
    protected function configure($options = array(), $messages = array())
    {
        $this->addRequiredOption('form');
        $this->addOption('throw_form_errors', true);
        $this->addOption('archiver');
        $this->addMessage('invalid', 'Your form contains some errors');

        parent::configure($options, $messages);
    }

    protected function doClean($value)
    {
        $form = $this->getOption('form');

        $form->bind($value);

        if ($form->isValid()) {
            if($archiverClass = $this->getOption('archiver')) {
                $archiver = new $archiverClass();
                return $archiver->sleep($form->getValues());
            }
  
            return $form->getValues();
        }

        throw $this->getOption('throw_form_errors') ? $form->getErrorSchema() : new sfValidatorErrorSchema($this);
    }
}
