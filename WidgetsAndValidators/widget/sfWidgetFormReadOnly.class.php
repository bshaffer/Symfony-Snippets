<?php

/*
 * This file is part of the symfony package.
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfWidgetFormInputHidden represents a hidden HTML input tag.
 *
 * @package    symfony
 * @subpackage widget
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfWidgetFormInputHidden.class.php 9046 2008-05-19 08:13:51Z FabianLange $
 */
class sfWidgetFormReadOnly extends sfWidgetFormInput
{
  /**
   * @param array $options     An array of options
   * @param array $attributes  An array of default HTML attributes
   *
   * @see sfWidgetFormInput
   */
  protected function configure($options = array(), $attributes = array())
  {
    $this->addOption('display_value', "<strong>%value%</strong>");
    $this->addOption('null_value', "<strong>N/A</strong>");
    $this->addOption('model');
    $this->addOption('input_hidden', true);
        
    parent::configure($options, $attributes);
    // $this->setOption('read_only', true);    
  }
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    $hidden_tag = $this->getOption('input_hidden') ? 
        $this->renderTag('input', array_merge(array('type' => 'hidden', 'name' => $name, 'value' => $value), $attributes)):'';

    // pull record from ID if option model exists
    if ($model = $this->getOption('model')) 
    {
      $value = Doctrine::getTable($this->getOption('model'))->find($value);
    }
    
    return strtr($this->getOption('display_value'), array('%value%' => $value ? $value : $this->getOption('null_value'))).$hidden_tag;
  }
}
