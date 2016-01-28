<?php
namespace AppBundle\Entity;

use AppBundle\AppBundle;
use AppBundle\Entity\Client;
use AppBundle\Entity\PortfolioImage;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="portfolio_items")
 * @ORM\HasLifecycleCallbacks()
 */
class PortfolioItem
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
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Length(
     *  min=2,
     *  minMessage="Name should be at least 2 characters long",
     *  max=128,
     *  maxMessage="Name should be at less 64 characters long"
     * )
     * @Assert\NotBlank()
     */
    private $name;


    /**
     * @var string
     * @ORM\Column(type="text")
     * @Assert\Length(
     *  min=2,
     *  minMessage="Description be at least 2 characters long"
     * )
     * @Assert\NotBlank()
     */
    private $description;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Url()
     * @Assert\NotBlank()
     */
    private $url;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\PortfolioImage", mappedBy="portfolioItem", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"position" = "ASC"})
     * @Assert\Count(min=1, minMessage="At least one image is required")
     */
    private $images;

    /**
     * @var PortfolioClient $client
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PortfolioClient", inversedBy="portfolioItems")
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id")
     */
    private $client;

    /**
     * @var Collection
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\PortfolioCategory", inversedBy="portfolioItems")
     * @ORM\JoinTable(name="portfolio_items_categories")
     */
    private $categories;

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
        $this->images = new ArrayCollection();
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
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return PortfolioItem
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return PortfolioItem
     */
    public function setDescription($description)
    {
        $this->description = trim($description);
        return $this;
    }

    /**
     * @return Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param Collection $categories
     * @return PortfolioItem
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
        return $this;
    }

    /**
     * @param PortfolioCategory $category
     * @return PortfolioItem
     */
    public function addCategories($category)
    {
        $this->categories->add($category);
    }

    /**
     * @return PortfolioClient
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param PortfolioClient $client
     */
    public function setClient($client)
    {
        $this->client = $client;
    }

    /**
     * @return Collection
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param Collection $images
     * @return PortfolioItem
     */
    public function setImages($images)
    {
        $this->images = new ArrayCollection();

        foreach ($images as $image) {
            $this->addImage($image);
        }

        return $this;
    }

    /**
     * @param PortfolioImage $image
     * @return PortfolioItem
     */
    public function addImage($image)
    {
        $this->images->add($image);
        return $this;
    }

    /**
     * @param PortfolioImage $image
     * @return PortfolioItem
     */
    public function removeImage($image)
    {
        $this->images->removeElement($image);
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
     * @return PortfolioItem
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
     * @return PortfolioItem
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function __toString()
    {
        if ($this->getName()) {
            return $this->getName();
        }
        return 'New Portfolio Item';
    }
}