<?php

namespace Blog;

use Blog\Controller\Backend\BackendBlogController;
use Blog\Controller\Backend\BackendCategoryController;
use Blog\Controller\Frontend\BlogController;
use Blog\Models\Post;
use Blog\Models\Comment;
use Blog\Services\CategoryService;
use Blog\Services\CommentService;
use Blog\Services\PostService;
use Oforge\Engine\Modules\AdminBackend\Core\Services\BackendNavigationService;
use Oforge\Engine\Modules\AdminBackend\Core\Services\DashboardWidgetsService;
use Oforge\Engine\Modules\Core\Abstracts\AbstractBootstrap;


class Bootstrap extends AbstractBootstrap {
    public function __construct() {
        $this->models = [
            Post::class,
            Comment::class,
            Post::class
        ];
        $this->endpoints = [
          BlogController::class,
          BackendBlogController::class,
          BackendCategoryController::class
        ];
        $this->services = [
          'blog.category' => CategoryService::class,
          'blog.post' => PostService::class,
          'blog.comment' => CommentService::class,
        ];
    }

    public function activate() {
        /** @var BackendNavigationService $backendNavigationService */
        $backendNavigationService = Oforge()->Services()->get('backend.navigation');
        $backendNavigationService->add(BackendNavigationService::CONFIG_CONTENT);
        $backendNavigationService->add([
            'name'     => 'backend_blog',
            'order'    => 1,
            'parent'   => BackendNavigationService::KEY_CONTENT,
            'icon'     => 'fa fa-newspaper-o',
            'path'     => 'backend_blog_posts',
            'position' => 'sidebar',
        ]);



    }

    public function deactivate() {
        /** @var BackendNavigationService $backendNavigationService */
        $backendNavigationService = Oforge()->Services()->get('backend.navigation');
        $backendNavigationService->delete([
            'name'     => 'backend_blog',
        ]);

    }


}
