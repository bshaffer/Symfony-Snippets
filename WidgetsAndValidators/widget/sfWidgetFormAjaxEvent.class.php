<?php

/**
* sfWidgetFormAjaxEvent
*   A widget that will call an ajax URL and update a selector on change. 
*   This is fairly transparent. it can pull in messages, a preview, another form element, etc.
*
* options:
*   * widget:  The widget to trigger the ajax event
*   * update:  A JQuery selector for the DOM element to update with the response
*   * url:     A url or symfony route to call to update the element above.  The selected value of the widget is automatically appended to this url (ex: '@objects?object_id=' will end up calling '@objects?object_id=2' if "2" is the value selected in your widget)
*   * on_empty: Text to update the "update" DOM element with if the widget value is empty
*   * update_on_load: whether to call the AJAX function on page load
*/
class sfWidgetFormAjaxEvent extends sfWidgetForm
{
  public function configure($options = array(), $attributes = array())
  {
    $this->addRequiredOption('widget');
    $this->addRequiredOption('update');
    $this->addRequiredOption('url');
    
    $this->addOption('on_empty');
    $this->addOption('update_on_load', true);

    parent::configure($options, $attributes);
  }
  
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    $content = $this->getOption('widget')->render($name, $value, $attributes, $errors);
    $content .= $this->getJavascript($name);
    return $content;
  }
  
  public function getJavascript($name)
  {
    sfContext::getInstance()->getConfiguration()->loadHelpers('Tag', 'Url');
    $addEmpty = $this->getOption('on_empty') ? 
                  sprintf("if(selectedVal == '') { $('%s').html('%s').show();return;}", $this->getOption('update'), $this->getOption('on_empty')) : '';
    $javascripts = <<<EOF
    <script type="text/javascript">
// Default jQuery wrapper
$(document).ready(function() {

  // When the choice widget is changed
  $("#%s").change(function() {
    // Hide the target element
    var selectedVal = $(this).attr("value");
    
    %s

    $("%s").addClass('indicator').html(' ');
    
    // url of the JSON
    var url = "%s" + selectedVal;

    // Get the JSON for the selected item
    $("%s").load(url, function() {
      $(this).removeClass('indicator');
    });
  })%s
}); 
</script>
EOF;

    return sprintf($javascripts, $this->generateId($name), 
                                 $addEmpty,
                                 $this->getOption('update'),
                                 url_for($this->getOption('url')),
                                 $this->getOption('update'),
                                 $this->getOption('update_on_load') ? '.change();' : '');
  }
}