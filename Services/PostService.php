<?php

namespace Blog\Services;

use Blog\Models\Category;
use Blog\Models\Post;
use Doctrine\ORM\ORMException;
use Oforge\Engine\Modules\Core\Abstracts\AbstractDatabaseAccess;
use Oforge\Engine\Modules\Core\Exceptions\ConfigElementNotFoundException;
use Oforge\Engine\Modules\Core\Exceptions\ServiceNotFoundException;

/**
 * Class PostService
 *
 * @package Blog\Services
 */
class PostService extends AbstractDatabaseAccess {

    /** @inheritDoc */
    public function __construct() {
        parent::__construct([
            'default'=>Post::class,
            'category'=> Category::class
        ]);
    }

    /**
     * @param int $id
     *
     * @return Post|null
     * @throws ORMException
     */
    public function getPost(int $id) : ?Post {
        /** @var Post|null $post */
        $post = $this->repository()->find($id);

        return $post;
    }

    /**
     * @param int $id
     *
     * @return array|Post[]
     * @throws ORMException
     */
    public function getAllPosts()  {
        /** @var Post[] $posts
         */

      return $this->repository()->findAll();
    }

    /**
     * @param int $id
     * @return Post
     * @throws ORMException
     */
    public function updatePost(int $id, array $data) : Post{
        /** @var Post $updatePost */

        $updatePost = $this->repository()->find($id);
        $updatePost->setContent($data['content']);
        $updatePost->setCategory($data['category']);
        $updatePost->setTitle($data['title']);
        $this->entityManager()->update($updatePost);

        return $updatePost;

    }

    /**
     * @param int $id
     * @param string $title
     * @return Post
     * @throws ORMException
     */
    public function createPost(array $data) : Post {
        /** @var Post $createPost */


        $createPost = new Post();
        $createPost->setTitle($data['title']);
        $category = $this->repository('category')->findOneBy(['name'=>$data['category']]);
        $createPost->setCategory($category);
        $createPost->setContent($data['content']);
        $this->entityManager()->create($createPost);


        return $createPost;

    }

    /**
     * @param int $id
     * @throws ORMException
     */
    public function deletePost(int $id)  {
        /** @var Post $deletePost */

        $deletePost = $this->repository()->find($id);
        $this->entityManager()->remove($deletePost);

    }

}
