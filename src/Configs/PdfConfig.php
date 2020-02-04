<?php

declare(strict_types=1);

namespace App\Configs;

/**
 * Class PdfConfig
 * @package App\Configs
 * @author  Ondra Votava <ondra@votava.dev>
 */
final class PdfConfig extends AbstractConfig
{
    /**
     * @var string
     */
    private $filename;
    /**
     * @var string
     */
    private $path;

    /**
     * PdfConfig constructor.
     *
     * @param array<string,mixed> $args
     */
    public function __construct(array $args)
    {
        $path = (string)$this->getValue('pdf_path', $args);
        $this->path = rtrim($path, '/') . '/';
        $this->filename = (string)$this->getValue('file_name', $args);
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * @return string
     */
    public function getOutput(): string
    {
        return $this->getPath() . $this->getFilename();
    }
}
