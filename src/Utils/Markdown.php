<?php

declare(strict_types=1);

namespace App\Utils;

use Parsedown;

/**
 * Class Markdown
 * @package App\Utils
 * @author  Ondra Votava <ondra@votava.dev>
 */
class Markdown
{

    /** @var Parsedown */
    protected $parser;

    /**
     * Markdown constructor.
     */
    public function __construct()
    {
        $this->parser = new Parsedown();
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public function convertMarkdownToHtml(string $string): string
    {
        return $this->parser->parse($string);
    }
}
