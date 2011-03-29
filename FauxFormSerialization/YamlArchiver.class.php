<?php

/**
 * Converts Array to YAML and YAML to array
 *
 * @author    Brent Shaffer <bshafs at gmail dot com>
 */
class YamlArchiver implements ArchiverInterface
{
  public function sleep($value)
  {
      return sfYaml::dump($value);
  }
  
  public function wake($value)
  {
     return sfYaml::load($value);
  }
  
  public function isAsleep($value)
  {
      return $value && is_string($value);
  }
}
