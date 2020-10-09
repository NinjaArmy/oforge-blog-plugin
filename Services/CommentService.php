<?php

namespace Blog\Services;

use Doctrine\ORM\ORMException;
use Oforge\Engine\Modules\Core\Abstracts\AbstractDatabaseAccess;
use Blog\Models\Comment;


/**
 * Class CommentService
 *
 * @package Blog\Services
 */
class CommentService extends AbstractDatabaseAccess {

    /** @inheritDoc */
    public function __construct() {
        parent::__construct(Comment::class);
    }

    /**
     * Get Comment by ID.
     *
     * @param int $commentID
     * @return Comment | null
     * @throws ORMException
     */
    public function getCommentByID(int $commentID) :?Comment {
        /** @var Comment | null $comment */

        $comment = $this->repository()->find($commentID);

        return $comment;
    }

}
