<?php

declare(strict_types=1);

namespace App\Configs;

use App\Exceptions\LogicException;

abstract class AbstractConfig
{
    /**
     * @param string $key
     * @param array<string,mixed>  $data
     *
     * @return mixed
     */
    protected function getValue(string $key, array $data)
    {
        if (!isset($data[$key])) {
            throw new LogicException(sprintf('Need set argument: "%s" in config', $key));
        }

        return $data[$key];
    }
}
