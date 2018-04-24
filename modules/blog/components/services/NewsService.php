<?php

namespace app\modules\blog\components\services;


use app\modules\blog\components\repository\TagRepository;
use app\modules\blog\components\repository\NewsCategoryRepository;
use app\modules\blog\components\repository\NewsRepository;

use yii\data\ActiveDataProvider;
use yii\web\HttpException;

class NewsService
{
    private $categoryRepository;
    private $newsRepository;
    private $tagRepository;


    public function __construct(NewsCategoryRepository $categoryRepository,
                                TagRepository $tagRepository,
                                NewsRepository $newsRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->tagRepository = $tagRepository;
        $this->newsRepository = $newsRepository;
    }

    public function checkIsCategory ($alias)
    {
        $category = $this->categoryRepository->findCategoryByAlias($alias);

        if (empty($category)) {
            throw new HttpException(404, 'The requested page is not found');
        }

        return $category;
    }

    public function checkIsTag ($alias)
    {
        $tag = $this->tagRepository->findTagByAlias($alias,'news');

        if (empty($tag)) {
            throw new HttpException(404, 'The requested page is not found');
        }

        return $tag;
    }

    public function checkIsBlogNews ($category, $alias)
    {
        $query = $this->newsRepository->findNewsByAliasWithCmsFiles($category->id, $alias);
        $blogNews = new ActiveDataProvider([
            'query' => $query
        ]);

        if (empty($blogNews)) {
            throw new HttpException(404, 'The requested page is not found');
        }
        return $blogNews;
    }
}