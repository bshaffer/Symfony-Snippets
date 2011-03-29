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
    *    * global_attributes: if specified, attributes are passed as if to a widget.  Apply to ALL widgets
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
        $this->addOption('global_attributes', true);

        return parent::configure($options, $attributes);
    }

    public function render($name, $value = null, $attributes = array(), $errors = array())
    {
        $form = $this->getOption('form');
        $form->getWidgetSchema()->setNameFormat($name.'[%s]');

        if($archiverClass = $this->getOption('archiver')) {
            $archiver = new $archiverClass();
            $value = $archiver->isAsleep($value) ? $archiver->wake($value) : $value;
        }

        $form->setDefaults($value);
    
        if ($this->getOption('global_attributes')) {
            foreach ($form->getWidgetSchema()->getFields() as $name => $widget) {
                $widget->setAttributes($attributes);
            }
        }
    
        $html = $form->render($attributes);
    
        // Decorate the form
        if ($format = $form->getWidgetSchema()->getFormFormatter()->getDecoratorFormat()) {
          return strtr($format, array('%content%' => $html));
        }
    
        return $html;
    }
}