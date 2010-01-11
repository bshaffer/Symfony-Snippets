[?php

/**
 * <?php echo $this->getModuleName() ?> module configuration.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage <?php echo $this->getModuleName()."\n" ?>
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: helper.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class Base<?php echo ucfirst($this->getModuleName()) ?>GeneratorHelper extends sfModelGeneratorHelper
{
  protected $_filters = array();
  
  public function getUrlForAction($action)
  {
    return 'list' == $action ? '<?php echo $this->params['route_prefix'] ?>' : '<?php echo $this->params['route_prefix'] ?>_'.$action;
  }
  
  public function getRouteForAction($action)
  {
    return '@'.$this->getUrlForAction($action);
  }
  
  public function exportColumnHeaders($headers)
  {
    if(isset($headers[0]) && strpos($headers[0], 'ID') === 0) $headers[0] = ' '.$headers[0];
    return implode("\t", $headers);
  }
  
  public function exportObjectRow($object, $fields)
  {
    $row = array();
    foreach ($fields as $field) 
    {
      $row[] = $object[$field];
    }
    return implode("\t", $row);
  }
  
  public function setFilters($filters)
  {
    $this->_filters = $filters;
  }
  
  public function getFilters()
  {
    return $this->_filters;
  }
  
  public function activeFilters()
  {
    return (bool) $this->_filters;
  }
}
