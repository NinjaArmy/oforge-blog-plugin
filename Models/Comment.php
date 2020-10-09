<?php

namespace Blog\Models;

use Oforge\Engine\Modules\Core\Abstracts\AbstractModel;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Comment
 *
 * @package Blog\Models
 * @ORM\Entity
 * @ORM\Table(name="oforge_blog_comments")
 */
class Comment extends AbstractModel {
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
     * @var string $comment
     * @ORM\Column(name="comment", type="bigint", nullable=false)
     */
    private $comment;

    public function getComment() : string {
        return $this->comment;
    }




    public function __construct() {

    }

}
