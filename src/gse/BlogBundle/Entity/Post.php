<?php

namespace gse\BlogBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Post
 *
 * @ORM\Table(name="post")
 * @ORM\Entity(repositoryClass="gse\BlogBundle\Entity\PostRepository")
 */
class Post
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="titulo", type="string", length=45, nullable=false)
     */
    private $titulo;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="cuerpo", type="text", nullable=false)
     */
    private $cuerpo;

    /**
     * @var string
     *
     * @ORM\Column(name="url_img", type="string", length=45, nullable=false)
     */
    private $urlImg;


    /**
     * @var \Tag
     *
     * @ORM\ManyToOne(targetEntity="Tag")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tag_ids", referencedColumnName="id")
     * })
     */
    private $tag_ids;

    /**
     * @ORM\OneToMany(targetEntity="gse\BlogBundle\Entity\tag", mappedBy="postr", cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    protected $tags;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    public function __toString() {
        return $this->getTitulo();
    }

    /**
     * Set titulo
     *
     * @param string $titulo
     * @return Post
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get titulo
     *
     * @return string 
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set cuerpo
     *
     * @param string $cuerpo
     * @return Post
     */
    public function setCuerpo($cuerpo)
    {
        $this->cuerpo = $cuerpo;

        return $this;
    }

    /**
     * Get cuerpo
     *
     * @return string 
     */
    public function getCuerpo()
    {
        return $this->cuerpo;
    }

    /**
     * Set urlImg
     *
     * @param string $urlImg
     * @return Post
     */
    public function setUrlImg($urlImg)
    {
        $this->urlImg = $urlImg;

        return $this;
    }

    /**
     * Get urlImg
     *
     * @return string 
     */
    public function getUrlImg()
    {
        return $this->urlImg;
    }

    /**
     * Set tag_ids
     *
     * @param \gse\BlogBundle\Entity\Tag $tagIds
     * @return Post
     */
    public function setTagIds(\gse\BlogBundle\Entity\Tag $tagIds = null)
    {
        $this->tag_ids = $tagIds;

        return $this;
    }

    /**
     * Get tag_ids
     *
     * @return \gse\BlogBundle\Entity\Tag 
     */
    public function getTagIds()
    {
        return $this->tag_ids;
    }

    public function removeTag(Tag $tag)
    {
        $this->tags->removeElement($tag);
    }

        /**
     * Constructor
     */
    public function __construct()
    {
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
    }
 
    public function setTags(\Doctrine\Common\Collections\Collection $tags)
    {
        $this->tags = $tags;
        foreach ($tags as $tag) {
            $address->setUser($this);
        }
    }
}
