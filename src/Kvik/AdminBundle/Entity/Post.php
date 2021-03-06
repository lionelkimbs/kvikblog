<?php

namespace Kvik\AdminBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Post
 *
 * @ORM\Table(name="kb_post")
 * @ORM\Entity(repositoryClass="Kvik\AdminBundle\Repository\PostRepository")
 */
class Post
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="body", type="text", nullable=true)
     */
    private $body;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="excerpt", type="string", length=255, nullable=true)
     */
    private $excerpt;

    /**
     * @var int
     *
     * @ORM\Column(name="post_status", type="string", length=8)
     */
    private $postStatus;

    /**
     * @var bool
     *
     * @ORM\Column(name="privacy", type="boolean")
     */
    private $privacy;

    /**
     * @var string
     *
     * @ORM\Column(name="comment_status", type="boolean")
     */
    private $commentStatus;

    /**
     * @var string
     *
     * @ORM\Column(name="post_password", type="string", length=255, nullable=true)
     */
    private $postPassword;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_edit", type="datetime")
     */
    private $dateEdit;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_pub", type="datetime", nullable=true)
     */
    private $datePub;

    /**
     * @var int
     *
     * @ORM\Column(name="menu_order", type="integer", nullable=true)
     */
    private $menuOrder;

    /**
     * @var string
     *
     * @ORM\Column(name="post_type", type="string", length=20)
     */
    private $postType;

    /**
     * @var string
     *
     * @ORM\Column(name="metadescription", type="string", length=255, nullable=true)
     */
    private $metadescription;

    /**
     * One Parent has Many posts.
     * @ORM\OneToMany(targetEntity="Kvik\AdminBundle\Entity\Post", mappedBy="parent")
     */
    private $children;
    /**
     * Many Posts have One Parent.
     * @ORM\ManyToOne(targetEntity="Kvik\AdminBundle\Entity\Post", inversedBy="children")
     */
    private $parent;
    /**
     * Many Posts have Many Terms.
     * @ORM\ManyToMany(targetEntity="Kvik\AdminBundle\Entity\Term", inversedBy="posts")
     * @ORM\JoinTable(name="kb_posts_terms")
     */
    private $terms;
    /**
     * Many Posts have One Author.
     * @ORM\ManyToOne(targetEntity="Kvik\AdminBundle\Entity\User", inversedBy="posts")
     * @ORM\JoinTable(name="kb_users_groups")
     */
    private $author;
    /**
     * One Post has Many Editors.
     * @ORM\ManyToOne(targetEntity="Kvik\AdminBundle\Entity\User")
     */
    private $editor;
    /**
     * Post constructor.
     */
    public function __construct()
    {
        $this->setCommentStatus(0);
        $this->terms = new ArrayCollection();
        $this->dateEdit = new \DateTime();
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
    }


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
     * Set title
     *
     * @param string $title
     *
     * @return Post
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set body
     *
     * @param string $body
     *
     * @return Post
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Post
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set excerpt
     *
     * @param string $excerpt
     *
     * @return Post
     */
    public function setExcerpt($excerpt)
    {
        $this->excerpt = $excerpt;

        return $this;
    }

    /**
     * Get excerpt
     *
     * @return string
     */
    public function getExcerpt()
    {
        return $this->excerpt;
    }

    /**
     * Set postStatus
     *
     * @param string $postStatus
     *
     * @return Post
     */
    public function setPostStatus($postStatus)
    {
        $this->postStatus = $postStatus;

        return $this;
    }

    /**
     * Get postStatus
     *
     * @return string
     */
    public function getPostStatus()
    {
        return $this->postStatus;
    }

    /**
     * Set privacy
     *
     * @param boolean $privacy
     *
     * @return Post
     */
    public function setPrivacy($privacy)
    {
        $this->privacy = $privacy;

        return $this;
    }

    /**
     * Get privacy
     *
     * @return boolean
     */
    public function getPrivacy()
    {
        return $this->privacy;
    }

    /**
     * Set commentStatus
     *
     * @param boolean $commentStatus
     *
     * @return Post
     */
    public function setCommentStatus($commentStatus)
    {
        $this->commentStatus = $commentStatus;

        return $this;
    }

    /**
     * Get commentStatus
     *
     * @return boolean
     */
    public function getCommentStatus()
    {
        return $this->commentStatus;
    }

    /**
     * Set postPassword
     *
     * @param string $postPassword
     *
     * @return Post
     */
    public function setPostPassword($postPassword)
    {
        $this->postPassword = $postPassword;

        return $this;
    }

    /**
     * Get postPassword
     *
     * @return string
     */
    public function getPostPassword()
    {
        return $this->postPassword;
    }

    /**
     * Set dateEdit
     *
     * @param \DateTime $dateEdit
     *
     * @return Post
     */
    public function setDateEdit($dateEdit)
    {
        $this->dateEdit = $dateEdit;

        return $this;
    }

    /**
     * Get dateEdit
     *
     * @return \DateTime
     */
    public function getDateEdit()
    {
        return $this->dateEdit;
    }

    /**
     * Set datePub
     *
     * @param \DateTime $datePub
     *
     * @return Post
     */
    public function setDatePub($datePub)
    {
        $this->datePub = $datePub;

        return $this;
    }

    /**
     * Get datePub
     *
     * @return \DateTime
     */
    public function getDatePub()
    {
        return $this->datePub;
    }

    /**
     * Set menuOrder
     *
     * @param integer $menuOrder
     *
     * @return Post
     */
    public function setMenuOrder($menuOrder)
    {
        $this->menuOrder = $menuOrder;

        return $this;
    }

    /**
     * Get menuOrder
     *
     * @return integer
     */
    public function getMenuOrder()
    {
        return $this->menuOrder;
    }

    /**
     * Set postType
     *
     * @param string $postType
     *
     * @return Post
     */
    public function setPostType($postType)
    {
        $this->postType = $postType;

        return $this;
    }

    /**
     * Get postType
     *
     * @return string
     */
    public function getPostType()
    {
        return $this->postType;
    }

    /**
     * Set metadescription
     *
     * @param string $metadescription
     *
     * @return Post
     */
    public function setMetadescription($metadescription)
    {
        $this->metadescription = $metadescription;

        return $this;
    }

    /**
     * Get metadescription
     *
     * @return string
     */
    public function getMetadescription()
    {
        return $this->metadescription;
    }

    /**
     * Add child
     *
     * @param \Kvik\AdminBundle\Entity\Post $child
     *
     * @return Post
     */
    public function addChild(\Kvik\AdminBundle\Entity\Post $child)
    {
        $this->children[] = $child;

        return $this;
    }

    /**
     * Remove child
     *
     * @param \Kvik\AdminBundle\Entity\Post $child
     */
    public function removeChild(\Kvik\AdminBundle\Entity\Post $child)
    {
        $this->children->removeElement($child);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set parent
     *
     * @param \Kvik\AdminBundle\Entity\Post $parent
     *
     * @return Post
     */
    public function setParent(\Kvik\AdminBundle\Entity\Post $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Kvik\AdminBundle\Entity\Post
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add term
     *
     * @param \Kvik\AdminBundle\Entity\Term $term
     *
     * @return Post
     */
    public function addTerm(\Kvik\AdminBundle\Entity\Term $term)
    {
        $this->terms[] = $term;

        return $this;
    }

    /**
     * Remove term
     *
     * @param \Kvik\AdminBundle\Entity\Term $term
     */
    public function removeTerm(\Kvik\AdminBundle\Entity\Term $term)
    {
        $this->terms->removeElement($term);
    }

    /**
     * Get terms
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTerms()
    {
        return $this->terms;
    }

    /**
     * Set author
     *
     * @param \Kvik\AdminBundle\Entity\User $author
     *
     * @return Post
     */
    public function setAuthor(\Kvik\AdminBundle\Entity\User $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \Kvik\AdminBundle\Entity\User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set editor
     *
     * @param \Kvik\AdminBundle\Entity\User $editor
     *
     * @return Post
     */
    public function setEditor(\Kvik\AdminBundle\Entity\User $editor = null)
    {
        $this->editor = $editor;

        return $this;
    }

    /**
     * Get editor
     *
     * @return \Kvik\AdminBundle\Entity\User
     */
    public function getEditor()
    {
        return $this->editor;
    }
}
