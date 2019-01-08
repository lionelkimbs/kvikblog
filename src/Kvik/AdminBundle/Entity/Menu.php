<?php

namespace Kvik\AdminBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Menu
 *
 * @ORM\Table(name="kb_menu")
 * @ORM\Entity(repositoryClass="Kvik\AdminBundle\Repository\MenuRepository")
 */
class Menu
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
     * @ORM\Column(name="title", type="string", length=255, unique=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="selected", type="boolean")
     */
    private $selected;


    /**
     * One Menu has Many Links
     * @ORM\OneToMany(targetEntity="Kvik\AdminBundle\Entity\Link", mappedBy="menu", cascade={"persist", "remove"}, fetch ="EAGER")
     * @ORM\OrderBy({"position" = "ASC"})
     */
    private $links;
    
    
    /**
     * Menu constructor.
     */
    public function __construct()
    {
        $this->selected = false;
        $this->links = new ArrayCollection();
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
     * @return Menu
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
     * Set selected
     *
     * @param boolean $selected
     *
     * @return Menu
     */
    public function setSelected($selected)
    {
        $this->selected = $selected;

        return $this;
    }

    /**
     * Get selected
     *
     * @return boolean
     */
    public function getSelected()
    {
        return $this->selected;
    }

    /**
     * Add link
     *
     * @param \Kvik\AdminBundle\Entity\Link $link
     *
     * @return Menu
     */
    public function addLink(\Kvik\AdminBundle\Entity\Link $link)
    {
        $this->links[] = $link;
        $link->setMenu($this);

        return $this;
    }

    /**
     * Remove link
     *
     * @param \Kvik\AdminBundle\Entity\Link $link
     */
    public function removeLink(\Kvik\AdminBundle\Entity\Link $link)
    {
        $this->links->removeElement($link);
    }

    /**
     * Get links
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLinks()
    {
        return $this->links;
    }
}
