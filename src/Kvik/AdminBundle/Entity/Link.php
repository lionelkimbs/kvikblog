<?php

namespace Kvik\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Link
 *
 * @ORM\Table(name="kb_link")
 * @ORM\Entity(repositoryClass="Kvik\AdminBundle\Repository\LinkRepository")
 */
class Link
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="linktype", type="string", length=255)
     */
    private $linktype;

    /**
     * @var int
     *
     * @ORM\Column(name="position", type="integer")
     */
    private $position;

    /**
     * One Link has Many Link as Child.
     * @ORM\OneToMany(targetEntity="Kvik\AdminBundle\Entity\Link", mappedBy="parent")
     */
    private $children;
    
    /**
     * Many Links can have One Link as a Parent.
     * @ORM\ManyToOne(targetEntity="Kvik\AdminBundle\Entity\Link", inversedBy="children")
     */
    private $parent;

    /**
     * Many Links have One Menu
     * @ORM\ManyToOne(targetEntity="Kvik\AdminBundle\Entity\Menu", inversedBy="links", cascade={"persist"})
     */
    private $menu;


    public function __construct() {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Link
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Link
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set position
     *
     * @param integer $position
     *
     * @return Link
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set linktype
     *
     * @param string $linktype
     *
     * @return Link
     */
    public function setLinktype($linktype)
    {
        $this->linktype = $linktype;

        return $this;
    }

    /**
     * Get linktype
     *
     * @return string
     */
    public function getLinktype()
    {
        return $this->linktype;
    }

    /**
     * Set menu
     *
     * @param \Kvik\AdminBundle\Entity\Menu $menu
     *
     * @return Link
     */
    public function setMenu(\Kvik\AdminBundle\Entity\Menu $menu = null)
    {
        $this->menu = $menu;

        return $this;
    }

    /**
     * Get menu
     *
     * @return \Kvik\AdminBundle\Entity\Menu
     */
    public function getMenu()
    {
        return $this->menu;
    }

    /**
     * Add child
     *
     * @param \Kvik\AdminBundle\Entity\Link $child
     *
     * @return Link
     */
    public function addChild(\Kvik\AdminBundle\Entity\Link $child)
    {
        $this->children[] = $child;

        return $this;
    }

    /**
     * Remove child
     *
     * @param \Kvik\AdminBundle\Entity\Link $child
     */
    public function removeChild(\Kvik\AdminBundle\Entity\Link $child)
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
     * @param \Kvik\AdminBundle\Entity\Link $parent
     *
     * @return Link
     */
    public function setParent(\Kvik\AdminBundle\Entity\Link $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Kvik\AdminBundle\Entity\Link
     */
    public function getParent()
    {
        return $this->parent;
    }
}
