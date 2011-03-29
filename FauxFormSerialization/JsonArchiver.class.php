<?php

/**
 * Converts Array to Json-encoded string and Json-encoded string to array
 *
 * @author    Brent Shaffer <bshafs at gmail dot com>
 */
class JsonArchiver implements ArchiverInterface
{
    public function sleep($value)
    {
        return json_encode($value);
    }

    public function wake($value)
    {
        return json_decode($value, true);
    }
  
    public function isAsleep($value)
    {
        // Bit of a give away this one
        if (!is_string($value)) {
            return false;
        }
        
        return true;
    }
}
