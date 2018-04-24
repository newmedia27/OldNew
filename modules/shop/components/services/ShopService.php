<?php
namespace app\modules\shop\components\services;

use app\components\repositories\CmsFilesRepository;
use app\modules\shop\components\repositories\ShopCategoryRepository;
use app\modules\shop\components\repositories\ShopProductsRepository;

class ShopService
{
    /**
     * @var ShopProductsRepository
     */
    private $shopProductsRepository;

    /**
     * @var ShopCategoryRepository
     */
    private $shopCategoryRepository;

    /**
     * CommentsService constructor.
     * @param ShopProductsRepository $commentsRepository
     * @param ShopCategoryRepository $shopCategoryRepository
     */
    public function __construct (ShopProductsRepository $shopProductsRepository,
                                ShopCategoryRepository $shopCategoryRepository)
    {
        $this->shopProductsRepository = $shopProductsRepository;
        $this->shopCategoryRepository = $shopCategoryRepository;
    }


}