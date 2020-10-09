<?php

namespace Blog\Controller\Backend;

use Blog\Models\Category;
use Blog\Models\Post;
use Blog\Services\PostService;
use Blog\Services\CategoryService;
use Doctrine\ORM\ORMException;
use Oforge\Engine\Modules\Core\Abstracts\AbstractModel;
use Oforge\Engine\Modules\Core\Exceptions\NotFoundException;
use Oforge\Engine\Modules\Core\Exceptions\ServiceNotFoundException;
use Oforge\Engine\Modules\CRUD\Controller\Backend\BaseCrudController;
use Doctrine\ORM\Mapping as ORM;
use Oforge\Engine\Modules\Core\Annotation\Endpoint\EndpointAction;
use Oforge\Engine\Modules\Core\Annotation\Endpoint\EndpointClass;
use Oforge\Engine\Modules\CRUD\Enum\CrudDataTypes;
use Oforge\Engine\Modules\CRUD\Enum\CrudFilterType;
use Oforge\Engine\Modules\CRUD\Enum\CrudGroupByOrder;
use Oforge\Engine\Modules\I18n\Helper\I18N;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class BackendBlogController
 * @package Blog\Controller\Backend\Blog
 * @EndpointClass(path="/backend/blog/posts", name="backend_blog_posts", assetScope="Backend")
 */
class BackendBlogController extends BaseCrudController {

    /** @var string $model */
    protected $model = Post::class;

    /** @var array $modelProperties */
    protected $modelProperties = [
           [
               'name'  => 'id',
               'type'  => CrudDataTypes::INT,
               'label' => ['key' => 'plugin_blog_property_id', 'default' => 'Id'],
               'crud'  => [
                   'index'  => 'readonly',
                   'view'   => 'readonly',
                   'create' => 'off',
                   'update' => 'editable',
                   'delete' => 'editable',
               ],
           ], #id
            [
            'name'=> 'created',
            'type' => CrudDataTypes::DATETIME,
            'label' => [
                'key' => 'plugin_blog_property_post_created',
                'default' => 'Created'
            ],
            'crud' => [
              'index' => 'readonly',
              'update' => 'readonly',
              'create' => 'off',
              'delete' => 'readonly',
              'view' => 'readonly'
            ],
        ],# created
        [
            'name' => 'updated',
            'type' => CrudDataTypes::DATETIME,
            'label' => [
                'key' => 'plugin_blog_property_post_updated',
                'default' => 'Updated'
            ],
            'crud' => [
                'index' => 'readonly',
                'update' => 'readonly',
                'create' => 'off',
                'delete' => 'readonly',
                'view' => 'readonly'
            ],# updated
        ],
        [
            'name' => 'category',
            'type' => CrudDataTypes::SELECT,
            'label' => [
                'key' => 'plugin_blog_property_category',
                'default' => 'Category'
            ],
            'crud' => [
                'index' => 'readonly',
                'update' => 'editable',
                'create' => 'editable',
                'delete' => 'readonly',
                'view' => 'readonly',
            ],
            'list' => 'getCategory',
            'multiple' => true,
        ],# category
        [
            'name' => 'title',
            'type' => CrudDataTypes::STRING,
            'label' => [
                'key' => 'plugin_blog_property_title',
                'default' => 'Title'
            ],
            'crud' => [
                'index' => 'off',
                'update' => 'editable',
                'create' => 'editable',
                'delete' => 'readonly',
                'view' => 'readonly',
            ],

        ],# title
        [
            'name' => 'content',
            'type' => CrudDataTypes::HTML,
            'label' => [
                'key' => 'plugin_blog_property_content',
                'default' => 'Content'
            ],
            'crud' => [
                'index' => 'off',
                'update' => 'editable',
                'create' => 'editable',
                'delete' => 'readonly',
                'view' => 'readonly'
            ]
        ],# content
        [
            'name' => 'author',
            'type' => CrudDataTypes::STRING,
            'label' => [
                'key' => 'plugin_blog_property_author',
                'default' => 'author',
            ],
            'crud' => [
                'index' => 'off',
                'update' => 'editable',
                'create' => 'editable',
                'delete' => 'readonly',
                'view' => 'readonly'
            ],
        ], # author

    ];
    /**
     * @var array $crudActions Keys of 'add|edit|delete'
     */
    protected $crudActions = [
        'index'  => true,
        'create' => true,
        'view'   => true,
        'update' => true,
        'delete' => true,
    ];





    /**
     * @return array
     * @throws ORMException
     * @throws ServiceNotFoundException
     */
    protected function getCategory() {
        /** @var CategoryService $categories */
        $categories = Oforge()->Services()->get('blog.category');
        $category = $categories->getAllCategories();
        Oforge()->View()->assign(['category' => $category]);

        return $category;
    }

    public function __construct() {
        parent::__construct();
    }


    protected function prepareItemDataArray(?AbstractModel $entity, string $crudAction) : array {
        $itemData = parent::prepareItemDataArray($entity, $crudAction);
        if (isset($itemData['category']['id'])) {
            $itemData['category'] = $itemData['category']['id'];
        }
        if (isset($itemData['post']['id'])) {
            $itemData['post'] = $itemData['post']['id'];
        }


        return $itemData;
    }

    /**
     * @param array $data
     * @param string $crudAction
     *
     * @return array
     * @throws NotFoundException
     */
    public function convertData(array $data, string $crudAction) : array {
        $entityManager = Oforge()->DB()->getForgeEntityManager();

        $categoryId = $data['category'];


        $category = $entityManager->getRepository(Category::class)->findOneBy(['id' => $categoryId]);
        if (!isset($category)) {
            throw new NotFoundException(sprintf(#
                I18N::translate('plugin_blog_category_not_found', [
                    'en' => 'category with ID "%s" not found.',
                ]),#
                $categoryId)#
            );
        }

        $data['category']      = $category;


        return parent::convertData($data, $crudAction);
    }




 }
