<?php
/**
 * Created by PhpStorm.
 * User: ondra
 * Date: 27.12.17
 * Time: 16:16
 */

namespace App\Configs;


use App\Exceptions\LogicException;

abstract class AbstractConfig
{
    /**
     * @param string $key
     * @param array  $data
     *
     * @return mixed
     * @throws \App\Exceptions\LogicException
     */
    protected function getValue(string $key, array $data)
    {
        if (!isset($data[$key])) {
            throw new LogicException(sprintf('Need set argument: "%s" in config', $key));
        }
    
        return $data[$key];
        
    }
}
