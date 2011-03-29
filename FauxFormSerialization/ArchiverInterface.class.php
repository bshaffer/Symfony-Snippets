<?php

/**
 *  Interface to archive an object from an array into a string and back again
 *
 *  @author  Brent Shaffer <bshafs at gmail dot com>
 */
interface ArchiverInterface
{
    public function sleep($value);
    public function wake($value);
    public function isAsleep($value);
}