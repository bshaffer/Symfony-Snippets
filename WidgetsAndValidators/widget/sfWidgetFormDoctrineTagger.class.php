<?php

/**
* 
*/
class sfWidgetFormDoctrineTagger extends sfWidgetFormDoctrineChoice
{
  public function configure($options = array(), $attributes = array())
  {
    parent::configure($options, $attributes);
    if (!isset($options['add_empty'])) 
    {
      $this->setOption('add_empty', true);
    }
  }
  
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    $dropdown = parent::render($name, null, array('class' => 'tag-select'), $errors);
    $hidden = new sfWidgetFormInputHidden();
    $content = '';
    $values = $this->getChoices();
    if ($value) 
    {
      foreach ($value as $i => $id)
      {
        if (isset($values[$id])) 
        {
          $content .=$this->renderContentTag('li', 
                                $values[$id].$hidden->render($name."[]", $id).'&nbsp;'.
                                $this->renderContentTag('a', 'x', array('class' => 'remove', 'href' => '#')), 
                              array('class' => 'taggable-tag-'.$id));
        }
      }
    }

    $content = $dropdown.$this->renderContentTag('ul', $content).$this->getJavascriptBlock($name);
    return $this->renderContentTag('div', $content, array('id' => $this->generateId($name).'_tagger', 'class' => 'taggable_container'));
  }
  
  public function getJavascriptBlock($name)
  {
    $hidden = new sfWidgetFormInputHidden();
    $id = $this->generateId($name).'_tagger';
    $javascripts = <<<EOF
      <script type='text/javascript'>
        $(document).ready(function(){
          $("#%s select.%s").change(function() {
            var newId = $(this).attr('value');
            if($('#%s .taggable-tag-'+newId).size() == 0) {
              var input = '%s'.replace('*id*', newId);
              $('#%s ul').append("<li class='taggable-tag-"+newId+"'>"+$(this).find(':selected').attr('text')+input+"&nbsp;<a href='#' class='remove' onclick='$(this).parent().remove();return false;'>x</a></li>")
            }
            else {
              alert('"'+$(this).find(':selected').attr('text')+'" is already added');
            }
            $(this).attr('value', '');
          });
          $("#%s .remove").click(function(){
            $(this).parent().remove();
            return false;
          })
        });
      </script>
EOF;
    return sprintf($javascripts, $id, 'tag-select', $id, $hidden->render($name.'[]', '*id*'), $id, $id);
  }
}
