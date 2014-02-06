<?php

namespace gse\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PostTag
 *
 * @ORM\Table(name="post_tag")
 * @ORM\Entity(repositoryClass="gse\BlogBundle\Entity\PostTagRepository")
 */
class PostTag
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
     * @var \Post
     *
     * @ORM\ManyToOne(targetEntity="Post", inversedBy="Post")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     * })
     */
    private $post;

    /**
     * @var \Tag
     *
     * @ORM\ManyToOne(targetEntity="Tag", inversedBy="Tag")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tag_id", referencedColumnName="id")
     * })
     */
    private $tag;




    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set post
     *
     * @param \gse\BlogBundle\Entity\Post $post
     * @return PostTag
     */
    public function setPost(\gse\BlogBundle\Entity\Post $post = null)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * Get post
     *
     * @return \gse\BlogBundle\Entity\Post 
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * Set tag
     *
     * @param \gse\BlogBundle\Entity\Tag $tag
     * @return PostTag
     */
    public function setTag(\gse\BlogBundle\Entity\Tag $tag = null)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * Get tag
     *
     * @return \gse\BlogBundle\Entity\Tag 
     */
    public function getTag()
    {
        return $this->tag;
    }
}
