<?php

namespace Blog\Controller\Frontend;
use Blog\Services\CategoryService;
use Blog\Services\CommentService;
use Blog\Services\PostService;
use Doctrine\ORM\Mapping as ORM;
use FrontendUserManagement\Abstracts\SecureFrontendController;
use Slim\Http\Request;
use Slim\Http\Response;
use Oforge\Engine\Modules\Core\Annotation\Endpoint\EndpointAction;
use Oforge\Engine\Modules\Core\Annotation\Endpoint\EndpointClass;

/**
 * Class BlogController
 *
 * @package Blog\Controller\Frontend\Blog
 * @EndpointClass(path="/blog", name="frontend_blog", assetScope="Frontend")
 */
class BlogController  {


    /** @var CategoryService $categoryService */
    private $categoryService;
    /** @var CommentService $commentService */
    private $commentService;
    /** @var PostService $postService */
    private $postService;

    public function __construct() {
        $this->categoryService = Oforge()->Services()->get('blog.category');
        $this->commentService = Oforge()->Services()->get('blog.comment');
        $this->postService = Oforge()->Services()->get('blog.post');
    }


    /**
     * @EndpointAction (path="[/[{id}]]")
     */
    public function indexAction(Request $request, Response $response, array $args) {


        if(isset($args['id']) && $request->isGet()){
            $post = $this->postService->getPost($args['id']);
            Oforge()->View()->assign([
               'post' => $post->toArray(),
            ]);
        }elseif ($request->isGet()){
            $posts = $this->postService->getAllPosts();
            $tmp = [];
            foreach ($posts as $post ){
                $tmp[]= $post->toArray();
            }
            $posts = $tmp;

            Oforge()->View()->assign([
                'posts' => $posts,

            ]);
            return $response;
        }elseif(isset($args['id']) && $request->isDelete()){
            $deletePost = $this->postService->deletePost($args ['id']);
            Oforge()->View()->assign([
               'deletePost' => $deletePost->toArray()
            ]);

        }elseif (isset($args['id'])&& $request->isPost()){
            $updatePost = $this->postService->updatePost($args['id']);
            Oforge()->View()->assign([
                'updatePost' => $updatePost->toArray()
            ]);
            return $response->withStatus(200);
        }
        elseif($request->isPost()) {
            $createPost = $this->postService->createPost();

            Oforge()->View()->assign([
                'createPost' => $createPost->toArray(),
            ]);
            return $response->withStatus(201);
        }
        return $response->withStatus(405);
    }


}
