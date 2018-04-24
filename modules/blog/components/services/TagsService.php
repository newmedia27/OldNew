<?php

namespace app\modules\blog\components\services;
use app\modules\blog\components\repository\NewsCategoryRepository;
use app\modules\blog\components\repository\NewsRepository;



/**
 * Class TagsService
 * @package app\components\services
 */
class TagsService
{
    /**
     * @param $category
     * @param $url
     * @return array
     */
    public function getTagsForBlogCategory($category)
    {
        if ($category == null){
            $categories = $this->getIdsSubCategoriesByCategoryAlias('blog');
            $tags= $this->findTagsForCategories($categories);
        } else {
            $tags = $this->findTagsForCategory($category->id);
        }
        return $tags;
    }

    public function getIdsSubCategoriesByCategoryAlias($alias)
    {
        $repo = new NewsCategoryRepository();
        $category = $repo->findCategoryByCatAlias($alias);
        $subCategories = $repo->findCategoryByIdPar($category->id);
        $array = [];
        foreach ($subCategories as $sub){
            $array[] = $sub->id;
        }
        return $array;
    }

    /**
     * @param $model
     * @return array
     */
    private function findTagsForCategory($model)
    {
        $repo = new NewsRepository();
        $news = $repo->findNewsByCategory($model)->limit(100)->all();
        $tags = [];
        foreach ($news as $newsBlog){
            foreach ($newsBlog['tags'] as $tag) {
                if (self::inTags($tags, $tag)) {
                    $tags[] = $tag;
                }
            };
        }
        return $tags;
    }

    /**
     * @param $categories
     * @return array
     */
    private function findTagsForCategories($categories)
    {
        $repo = new NewsRepository();
        $news = $repo->findNewsInSubCats($categories)->limit(100)->all();
        $tags = [];
        foreach ($news as $newsBlog){
            foreach ($newsBlog['tags'] as $tag) {
                if (self::inTags($tags, $tag)) {
                    $tags[] = $tag;
                }
            };
        }
        return $tags;
    }

    /**
     * @param $tags
     * @param $tag
     * @return bool
     */
    private function inTags($tags, $tag)
    {
        foreach ($tags as $unit) {
            if ($unit==$tag) {
                return false;
            }
        };
        return true;
    }
}