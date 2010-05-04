<?php

/*
 * This file is part of the symfony package.
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfValidatorUrl validates Decimal.
 *
 * @package    symfony
 * @subpackage validator
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id$
 */
class sfValidatorDecimal extends sfValidatorString
{
  public static $separator_default  = '.';
  public static $max_left_default   = '8';
  public static $max_right_default  = '2';
  /**
   * Configures the current validator.
   * 
   * Available options:
   *
   *  * separator: the character between the left and the right part 
   *  * max_left:  The maximum number of digits in the left part
   *  * max_right: The maximum number of digits in the right part
   *
   * @param array $options   An array of options
   * @param array $messages  An array of error messages
   *
   * @see sfValidatorString
   */
  protected function configure($options = array(), $messages = array())
  {            
    // configure
    parent::configure($options, $messages);

    $this->setMessage('invalid', 'the value %value% uses too many places right of the decimal. Only %max_right% allowed');

    // add the options and set the default values
    $this->addOption('separator', self::$separator_default);
    $this->addOption('max_left', self::$max_left_default);
    $this->addOption('max_right', self::$max_right_default);
    $this->addOption('min');
    $this->addOption('max');    
  }
  

  /**
   * @see sfValidatorString
   */
  protected function doClean($value)
  {
    // clean by the parent
    $clean    = parent::doClean($value);

    $numVal = new sfValidatorNumber(array('required' => false, 'min' => $this->getOption('min'), 'max' => $this->getOption('max')));
    
    $numVal->clean($value);
        
    // get the option
    $separator  = $this->getOption('separator');
    $max_left    = $this->getOption('max_left');
    $max_right  = $this->getOption('max_right');
    
    // build the regexp to test
    $pattern  = '/^\d{1,'.$max_left.'}';
    $pattern  .= '(\\'.$separator;
    $pattern  .= '\d{0,'.$max_right.'})?$/';
    
    // do the test
    if(!preg_match($pattern, $clean))
    {
      throw new sfValidatorError($this, 'invalid', array('max_right' => $this->getOption('max_right'), 'value' => $value));
    }
    
    // return the $clean value
    return $clean;
  }
}
