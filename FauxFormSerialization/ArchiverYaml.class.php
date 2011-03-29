<?php

/**
 * Converts Array to YAML and YAML to array
 *   ** warning: this has not been tested and is only to be used as an example **
 * @author    Brent Shaffer <bshafs at gmail dot com>
 */
class ArchiverYaml implements ArchiverInterface
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
