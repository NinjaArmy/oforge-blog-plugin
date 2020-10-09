<?php

namespace Blog\Models;

use Doctrine\ORM\ORMException;
use Oforge\Engine\Modules\Core\Abstracts\AbstractModel;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Category
 *
 * @package Blog\Models
 * @ORM\Entity
 * @ORM\Table(name="oforge_blog_categories")
 */
class Category extends AbstractModel {
    /**
     * @var int $id
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;


    /**
     * @return int
     */
    public function getId() : int {
        return $this->id;
    }



    /**
     * @var string $name
     * @ORM\Column(name="name", type="text", nullable=false)
     */
    private $name;


    /**
     * @return string
     */
    public function getName() : string {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Category
     */
    public function setName(string  $name) : Category{
        $this->name = $name;
        return $this;
    }


    public function __construct() {

    }

}
