[?php

/**
 * <?php echo $this->getModuleName() ?> module configuration.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage <?php echo $this->getModuleName()."\n" ?>
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: configuration.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class Base<?php echo ucfirst($this->getModuleName()) ?>GeneratorConfiguration extends sfModelGeneratorConfiguration
{
<?php include dirname(__FILE__).'/actionsConfiguration.php' ?>

<?php include dirname(__FILE__).'/fieldsConfiguration.php' ?>

  /**
   * Gets the form class name.
   *
   * @return string The form class name
   */
  public function getFormClass()
  {
    return '<?php echo isset($this->config['form']['class']) ? $this->config['form']['class'] : $this->getModelClass().'Form' ?>';
<?php unset($this->config['form']['class']) ?>
  }

  public function hasFilterForm()
  {
    return <?php echo !isset($this->config['filter']['class']) || false !== $this->config['filter']['class'] ? 'true' : 'false' ?>;
  }

  /**
   * Gets the filter form class name
   *
   * @return string The filter form class name associated with this generator
   */
  public function getFilterFormClass()
  {
    return '<?php echo isset($this->config['filter']['class']) && !in_array($this->config['filter']['class'], array(null, true, false), true) ? $this->config['filter']['class'] : $this->getModelClass().'FormFilter' ?>';
<?php unset($this->config['filter']['class']) ?>
  }

<?php include dirname(__FILE__).'/paginationConfiguration.php' ?>

<?php include dirname(__FILE__).'/sortingConfiguration.php' ?>

  public function getTableMethod()
  {
    return '<?php echo isset($this->config['list']['table_method']) ? $this->config['list']['table_method'] : null ?>';
<?php unset($this->config['list']['table_method']) ?>
  }

  public function getTableCountMethod()
  {
    return '<?php echo isset($this->config['list']['table_count_method']) ? $this->config['list']['table_count_method'] : null ?>';
<?php unset($this->config['list']['table_count_method']) ?>
  }
  
  protected function getConfig()
  {
    return array_merge(parent::getConfig(), array('export' => $this->getFieldsExport()));
  }
  
  public function getExportFilename()
  {
    return "<?php echo isset($this->config['export']['filename']) ? $this->config['export']['filename'] : ucfirst($this->getModuleName()).'_Export' ?>_".date("Y-m-d_Hi");
<?php unset($this->config['export']['filename']) ?>
  }
  
  protected function compile()
  {
    parent::compile();
    $this->configuration['credentials']['export'] = array();
    $this->configuration['export'] = array(
        'fields'  => array(),
        'title'   => $this->getExportTitle(),
        'actions' => $this->getExportActions() ? $this->getExportActions() : array('_list' => array('action' => 'index', 'label' => 'Back')));
  
    $config = $this->getConfig();
    foreach (array_keys($config['default']) as $field)
    {
      $formConfig = array_merge($config['default'][$field], isset($config['form'][$field]) ? $config['form'][$field] : array());

      $this->configuration['export']['fields'][$field]   = new sfModelGeneratorConfigurationField($field, array_merge(array('label' => sfInflector::humanize(sfInflector::underscore($field))), $config['default'][$field], isset($config['export'][$field]) ? $config['export'][$field] : array()));
    }

    foreach ($this->getExportDisplay() as $field)
    {
      list($field, $flag) = sfModelGeneratorConfigurationField::splitFieldWithFlag($field);

      $this->configuration['export']['fields'][$field] = new sfModelGeneratorConfigurationField($field, array_merge(
        array('type' => 'Text', 'label' => sfInflector::humanize(sfInflector::underscore($field))),
        isset($config['default'][$field]) ? $config['default'][$field] : array(),
        isset($config['export'][$field]) ? $config['export'][$field] : array(),
        array('flag' => $flag)
      ));
    }
    
    // export actions
    foreach ($this->configuration['export']['actions'] as $action => $parameters)
    {
      $this->configuration['export']['actions'][$action] = $this->fixActionParameters($action, $parameters);
    }

    
    $this->configuration['export']['display'] = array();
    foreach ($this->getExportDisplay() as $name)
    {
      list($name, $flag) = sfModelGeneratorConfigurationField::splitFieldWithFlag($name);
      if (!isset($this->configuration['export']['fields'][$name]))
      {
        throw new InvalidArgumentException(sprintf('The field "%s" does not exist.', $name));
      }
      $field = $this->configuration['export']['fields'][$name];
      $field->setFlag($flag);
      $this->configuration['export']['display'][$name] = $field;
    }
  }
  
  protected function fixActionParameters($action, $parameters)
  {
    $parameters = parent::fixActionParameters($action, $parameters);

    if ('_export' == $action && !isset($parameters['action']))
    {
      $parameters['action'] = 'export';
    }
    
    return $parameters;
  }
}
