<?php
/**
 * Created by PhpStorm.
 * User: ondra
 * Date: 30.12.17
 * Time: 5:32
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class ResumeDownload
 * @package App\Entity
 * @author Ondra Votava <me@ondravotava.cz>
 *
 * @ORM\Entity()
 * @ORM\Table(name="resume_downloads")
 */
class ResumeDownload
{
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var integer
     */
    private $id;
    
    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @var \DateTime
     */
    private $downloadAt;
    
    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    private $fromIp;
    
    /**
     * ResumeDownload constructor.
     *
     * @param string $ip
     */
    public function __construct(string $ip)
    {
        $this->fromIp = $ip;
        $this->downloadAt = new \DateTime();
    }
    
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
    
    /**
     * @return \DateTime
     */
    public function getDownloadAt(): \DateTime
    {
        return $this->downloadAt;
    }
    
    /**
     * @return string
     */
    public function getFromIp(): string
    {
        return $this->fromIp;
    }
    
}
