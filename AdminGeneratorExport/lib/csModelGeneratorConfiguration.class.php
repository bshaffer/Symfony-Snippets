<?php


abstract class csModelGeneratorConfiguration extends sfModelGeneratorConfiguration
{
  abstract public function getExportDisplay();

  abstract public function getExportTitle();

  abstract public function getExportActions();

  protected function compile()
  {
    parent::compile();
    
    // ===================================
    // = Add for exporting configuration =
    // ===================================
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