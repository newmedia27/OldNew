<?php

namespace app\modules\blog\components\services;


use app\modules\blog\components\repository\NewsCategoryRepository;

class NewsCategoryService
{
    public function getSubcategoriesByAliasPar($alias)
    {
        $repository = new NewsCategoryRepository();
        $cat = $repository->findCategoryByCatAlias($alias);
        $category = $repository->findCategoryByIdPar($cat->id);
        return $category;
    }
}