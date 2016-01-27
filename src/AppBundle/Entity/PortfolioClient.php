<?php
namespace AppBundle\Entity;

use AppBundle\Entity\PortfolioItem;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="portfolio_clients")
 * @ORM\HasLifecycleCallbacks()
 */
class PortfolioClient
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=64, nullable=true)
     * @Assert\Length(
     *  min=2,
     *  minMessage="Portfolio category name should be at least 2 characters long",
     *  max=128,
     *  maxMessage="Portfolio category name should be at less 64 characters long"
     * )
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(type="string", length=64, nullable=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\PortfolioItem", mappedBy="client", fetch="EXTRA_LAZY")
     */
    private $portfolioItems;

    /**
     * @var \DateTime $createdAt
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime $updatedAt
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    public function __construct()
    {
        $this->portfolioItems = new ArrayCollection();
        $this->setCreatedAt(new \DateTime());
        if ($this->getUpdatedAt() == null) {
            $this->setUpdatedAt(new \DateTime());
        }
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return PortfolioItem
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return PortfolioItem
     */
    public function setName($name)
    {
        $this->name = trim($name);
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return PortfolioClient
     */
    public function setEmail($email)
    {
        $this->email = trim($email);
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getPortfolioItems()
    {
        return $this->portfolioItems;
    }

    /**
     * @param ArrayCollection $portfolioItems
     * @return PortfolioClient
     */
    public function setPortfolioItems($portfolioItems)
    {
        $this->portfolioItems = new ArrayCollection();
        foreach ($portfolioItems as $portfolioItem) {
            $this->addPortfolioItem($portfolioItem);
        }
        return $this;
    }

    /**
     * @param PortfolioItem $portfolioItem
     * @return PortfolioClient
     */
    public function addPortfolioItem($portfolioItem)
    {
        $this->portfolioItems->add($portfolioItem);
        return $this;
    }

    /**
     * @param PortfolioItem $portfolioItem
     * @return PortfolioClient
     */
    public function removePortfolioItem($portfolioItem)
    {
        $this->portfolioItems->removeElement($portfolioItem);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     * @return PortfolioClient
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }


    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     * @return PortfolioCategory
     * @ORM\PreUpdate
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function __toString()
    {
        if($this->getName()) {
            return $this->getName();
        }
        return "New Client";
    }

}