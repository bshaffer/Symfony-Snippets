<?php

/**
* 
*/
interface ArchiverInterface
{
  public function sleep($value);
  public function wake($value);
  public function isAsleep($value);
}