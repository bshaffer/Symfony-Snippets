<?php

class sfWidgetFormPosition extends sfWidgetFormInput
{ 
  public function render($name, $value = null, $attributes = array(), $errors = array())
  { 
    sfProjectConfiguration::getActive()->loadHelpers(array('JavascriptBase', 'Asset', 'Tag', 'Url'));
    $attributes['class'] = 'position';

    return  "<div class='position-controls'>".
              parent::render($name, $value, $attributes, $errors).
              link_to_function(image_tag('up'), 'javascript:up(this)', array('class' => 'up')).
              link_to_function(image_tag('down'), 'javascript:down(this)', array('class' => 'down')).
            "</div>"
    ;
  }
  
  /**
  * Gets the JavaScript paths associated with the widget.
  *
  * @return array An array of JavaScript paths
  */
  public function getJavascripts()
  {
    return array('jquery/jquery-sortable.js');
  }
  
  public function getStylesheets()
  {
    return array('sortable.css' => 'all');
  }
}
