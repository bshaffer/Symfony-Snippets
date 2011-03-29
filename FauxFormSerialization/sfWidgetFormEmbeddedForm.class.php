<?php

/**
 * sfWidgetFormEmbeddedForm represents an embedded form
 *
 * @author    Brent Shaffer <bshafs at gmail dot com>
 */
class sfWidgetFormEmbeddedForm extends sfWidgetForm
{
    /**
    * options:
    *    * form: Required sfForm instance rendered by this widget
    *    * archiver: provide an archiver to sanitize results into a specific format (XML, YAML, etc).  Default is array.
    *
    * @param string $options 
    * @param string $attributes 
    * @return null
    * @author Brent Shaffer
    */
    public function configure($options = array(), $attributes = array())
    {
        $this->addRequiredOption('form');

        $this->addOption('archiver');

        return parent::configure($options, $attributes);
    }

    public function render($name, $value = null, $attributes = array(), $errors = array())
    {
        $form = $this->getOption('form');
        $form->getWidgetSchema()->setNameFormat($name.'[%s]');

        if($archiverClass = $this->getOption('archiver'))
        {
            $archiver = new $archiverClass();

            $value = $archiver->isAsleep($value) ? $archiver->wake($value) : $value;
        }

        $form->setDefaults($value);

        return $form->render($attributes);
    }
}