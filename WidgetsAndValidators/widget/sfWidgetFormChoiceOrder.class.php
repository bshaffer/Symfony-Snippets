<?php

/**
* 
*/
class sfWidgetFormSelectOrder extends sfWidgetFormSelectRadio
{
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    $combinations = $this->getAllCombinations($this->getOption('choices')); // copy the array
    $this->setOption('choices', $this->getHTMLFromCombinations($combinations));
    return parent::render($name, $value, $attributes, $errors);
  }
  
  public function getHTMLFromCombinations($combinations)
  {
    $combination_html = array();
    foreach ($combinations as $i => $combination) 
    {
      $html = '';
      foreach ($combination as $key => $value) 
      {
        $html .= "<li>$value</li>";
      }
      $combination_html[$i] = "<ol>$html</ol>";
    }
    return $combination_html;
  }
  
  // recursive script to find all combinations with an array of choices
  public function getAllCombinations(array $choices)
  {
    if (count($choices) <= 1) {
      return $choices;
    }
    $combinations = array();
    foreach ($choices as $i => $choice) {
      $tmp = $choices;
      unset($tmp[$i]);
      foreach ($this->getAllCombinations($tmp) as $key => $value) {
        if (is_array($value)) {
          array_unshift($value, $choice);
        } else {
          $value = array($choice, $value);
        }
        $combinations[$i.'-'.$key] = $value;
      }
    }
    return $combinations;
  }
  
  // Overriding "Label" tag
  protected function formatChoices($name, $value, $choices, $attributes)
  {
    $inputs = array();
    foreach ($choices as $key => $option)
    {
      $baseAttributes = array(
        'name'  => substr($name, 0, -2),
        'type'  => 'radio',
        'value' => self::escapeOnce($key),
        'id'    => $id = $this->generateId($name, self::escapeOnce($key)),
      );

      if (strval($key) == strval($value === false ? 0 : $value))
      {
        $baseAttributes['checked'] = 'checked';
      }

      $inputs[$id] = array(
        'input' => $this->renderTag('input', array_merge($baseAttributes, $attributes)),
        'label' => $this->renderContentTag('div', $option, array('for' => $id)),
      );
    }

    return call_user_func($this->getOption('formatter'), $this, $inputs);
  }
}
