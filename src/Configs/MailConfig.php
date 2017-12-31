<?php declare(strict_types=1);

namespace App\Configs;

/**
 * Class MailConfig
 * @package App\Configs
 * @author Ondra Votava <me@ondravotava.cz>
 */
final class MailConfig extends AbstractConfig
{
    
    /**
     * @var string
     */
    private $to;
    /**
     * @var string
     */
    private $from;
    /**
     * @var string
     */
    private $prefix;
    
    /**
     * MailConfig constructor.
     *
     * @param $args
     *
     * @throws \App\Exceptions\LogicException
     */
    public function __construct($args)
    {
        $this->to = (string)$this->getValue('to', $args);
        $this->from = (string)$this->getValue('from', $args);
        $this->prefix = (string)$this->getValue('subject_prefix', $args);

    }
    
    /**
     * @return string
     */
    public function getToMail(): string
    {
        return $this->to;
    }
    
    /**
     * @return string
     */
    public function getFromMail(): string
    {
        return $this->from;
    }
    
    /**
     * @return string
     */
    public function getSubjectPrefix(): string
    {
        return $this->prefix;
    }
}
