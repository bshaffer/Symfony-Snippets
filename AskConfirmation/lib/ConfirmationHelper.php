<?php

// Recursive call to write nested array as input parameters
function parameter_to_input_tag($key, $value)
{
  if (is_array($value)) 
  {
    $html = '';
    foreach ($value as $key2 => $value2) 
    {
      $html .= parameter_to_input_tag(sprintf('%s[%s]', $key, $key2), $value2);
    }
    return $html;
  }
  return '<input type="hidden" name="'. $key . '" value="'. $value. '" />';
}