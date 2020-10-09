<?php

namespace Blog\Models;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Oforge\Engine\Modules\Auth\Models\User\BackendUser;
use Oforge\Engine\Modules\Core\Abstracts\AbstractModel;
use Doctrine\ORM\Mapping as ORM;
use Blog\Models\Category;


/**
 * Class Post
 *
 * @package Blog\Models
 * @ORM\Entity
 * @ORM\Table(name="oforge_blog_posts")
 * @ORM\HasLifecycleCallbacks
 */
class Post extends AbstractModel {
    /**
     * @var int $id
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string $title
     * @ORM\Column(name="title", type="text", nullable=false)
     */
    private $title;

    /**
     * @var BackendUser $author
     * @ORM\Column(name="author", type="text", nullable=false)
     */
    private $author;

    /**
     * @var Category $category
     * @ORM\ManyToOne(targetEntity="Blog\Models\Category", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;
    /**
     * @var string $comments
     * @ORM\Column(name="comments", type="text", nullable=false)
     */
    private $comments;
    /**
     * @var string $content
     * @ORM\Column(name="content", type="text", nullable=false, options={"default":""})
     */
    private $content;
    /**
     * @var DateTimeImmutable $created
     * @ORM\Column(name="created", type="datetime_immutable", nullable=false)
     */
    private $created;
    /**
     * @var DateTimeImmutable $updated
     * @ORM\Column(name="updated", type="datetime_immutable", nullable=false)
     */
    private $updated;



    public function __construct($inId=null, $inTitle=null, $inAuthor=null, $inCategory=null) {

        $this->id = $inId;
        $this->title = $inTitle;
        $this->author = $inAuthor;
        $this->category = $inCategory;

        $this->comments = new ArrayCollection();

    }

    /**
     *
     * @return int
     */
    public function getId() : int {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return Post
     */

    public function setId(int $id) : Post {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getComments() : string {
        return $this->comments;
    }


    /**
     * @param string $comments
     *
     * @return Post
     */
    public function setComments(string $comments) : Post {
        $this->comments = $comments;
        return $this;
    }

    /**
     * @return string
     */
    public function getAuthor() : string {
        return $this->author;
    }

    /**
     * @param string $author
     *
     *
     * @return Post
     */
    public function setAuthor(string $author) : Post {
        $this->author = $author;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle() : string {
        return $this->title;
    }


    /**
     * @param string $title
     *
     * @return Post
     */
    public function setTitle(string $title) : Post {
        $this->title = $title;
        return $this;
    }


    /**
     * @return string
     */
    public function getContent() : string {
        return $this->content;
    }

    /**
     * @param string $content
     *
     * @return Post
     */
    public function setContent(string $content) : Post {
        $this->content = $content;
        return $this;
    }

    /**
     * @return Category | null
     */
    public function getCategory() : ?Category {
        return $this->category;
    }

    /**
     * @param Category $category
     *
     * @return Post
     */
    public function setCategory(Category $category) : Post {
        $this->category = $category;
        return $this;
    }
    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updateTimestamps() {
        $now           = new DateTimeImmutable('now');
        $this->updated = $now;
        if (!isset($this->created)) {
            $this->created = $now;
        }
    }

    /**
     * @return DateTimeImmutable
     */
    public function getUpdated() : ?DateTimeImmutable {
        return $this->updated;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getCreated() : ?DateTimeImmutable {
        return $this->created;
    }

}
