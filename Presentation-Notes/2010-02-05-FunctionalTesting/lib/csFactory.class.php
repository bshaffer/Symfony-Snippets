<?php

/**
* 
*/
class sfFactory
{
  protected static $lastRandom = null;
  
  public static function generate($prefix = '')
  {
    self::$lastRandom = $prefix.rand();
    return self::$lastRandom;
  }
  
  public static function last()
  {
    if (!self::$lastRandom) 
    {
      throw new sfException("No previously generated random available");
    }
    return self::$lastRandom;
  }
}
