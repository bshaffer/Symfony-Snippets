<?php

/*
 * This file is part of the symfony package.
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfWidgetFormTextarea represents a textarea HTML tag.
 *
 * @package    symfony
 * @subpackage widget
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfWidgetFormTextarea.class.php 9046 2008-05-19 08:13:51Z FabianLange $
 */
class sfWidgetFormEmbeddedForm extends sfWidgetForm
{
  public function configure($options = array(), $attributes = array())
  {
    $this->addRequiredOption('form');
    
    $this->addOption('archiver', 'sfArchiverSerialize');
    
    return parent::configure($options, $attributes);
  }
  
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    $form = $this->getOption('form');
    $form->getWidgetSchema()->setNameFormat($name.'[%s]');
    
    $archiverClass = $this->getOption('archiver');
    $archiver = new $archiverClass();
    
    $value = $archiver->isAsleep($value) ? $archiver->wake($value) : $value;
    
    $form->setDefaults($value);

    return $form->render($attributes);
  }
}