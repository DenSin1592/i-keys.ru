<?php namespace App\Models\Features;

/**
 * Class InitialKey
 * @package App\Models\Features
 */
trait InitialKey
{
    public static function bootInitialKey()
    {
        static::creating(
            function (self $self) {
                $keyName = $self->getKeyName();

                if (null === $self->getAttribute($keyName)) {
                    $initialKey = 301;

                    if (self::max($keyName) < $initialKey) {
                        $self->setAttribute($keyName, $initialKey);
                    }
                }
            }
        );
    }
}
