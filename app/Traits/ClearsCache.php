<?php

namespace App\Traits;

trait ClearsCache
{
  protected static function bootClearsCache()
  {
    $clearCache = function () {
      cache()->flush();
    };

    static::created($clearCache);
    static::updated($clearCache);
    static::deleted($clearCache);
  }
}
