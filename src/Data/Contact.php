<?php

declare(strict_types=1);

namespace App\Data;

/**
 * Class Contact
 * @package App\Data
 * @author  Ondra Votava <ondra@votava.dev>
 */
class Contact
{
    /**
     * @var array<string,mixed> params
     */
    private $params;

    /**
     * Contact constructor.
     *
     * @param array<string,mixed> $params
     */
    public function __construct(array $params)
    {
        $this->params = $params;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->params['email'] ?? '';
    }

    /**
     * @return string
     */
    public function getHtmlEmail(): string
    {
        return str_replace('@', '&commat;', $this->getEmail());
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->params['phone'] ?? '';
    }

    /**
     * @return string
     */
    public function getPlace(): string
    {
        return $this->params['place'] ?? '';
    }


    /**
     * @return string
     */
    public function getWebsite(): string
    {
        return $this->params['website'] ?? '';
    }
}
