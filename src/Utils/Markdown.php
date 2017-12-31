<?php
/**
 * Created by PhpStorm.
 * User: Ondra Votava
 * Date: 22.12.17
 * Time: 15:26
 */

namespace App\Utils;

use Parsedown;

/**
 * Class Markdown
 * @package App\Utils
 * @author Ondra Votava <ondrej.votava@mediafactory.cz>
 */

class Markdown
{
    
    /** @var Parsedown  */
    protected $parser;
    
    /**
     * Markdown constructor.
     */
    public function __construct(  )
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
