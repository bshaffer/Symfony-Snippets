<?php

require_once $_SERVER['SYMFONY'].'/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
    // To load your plugin sfMyAwesomePlugin
    $this->setPlugins(array(
      'sfMyAwesomePlugin',
    ));
    
    $this->setPluginPath('sfMyAwesomePlugin', $_SERVER['SYMFONY_PLUGINS_DIR'] . '/sfMyAwesomePlugin');
  }
}
