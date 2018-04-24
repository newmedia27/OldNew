<?php

namespace app\modules\blog\models;
use app\modules\blog\components\repository\NewsCategoryRepository;
use app\modules\blog\components\repository\TagRepository;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * NewsSearch represents the model behind the search form about `app\modules\news\models\News`.
 */
class NewsSearch extends News
{
    /**
     * @var NewsCategoryRepository
     */
    private $categoryRepository;

    /**
     * @var TagRepository
     */
    private $tagRepository;

    public function __construct ($config = [], NewsCategoryRepository $categoryRepository, TagRepository $tagRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->tagRepository = $tagRepository;
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules ()
    {
        return [
            [['prior', 'visible'], 'integer'],
            [['created', 'updated', 'news_date_start'], 'safe'],
            [['description_ru', 'description_en', 'description_ua', 'description_long_ru', 'description_long_ua', 'description_long_en', 'seo_description_ru', 'seo_description_ua', 'seo_description_en', 'author_links'], 'string'],
            [['name_ru', 'name_ua', 'name_en', 'seo_title_ru', 'seo_title_ua', 'seo_title_en', 'seo_keywords_en', 'seo_keywords_ua', 'seo_keywords_ru', 'img_path', 'img_path_thumb', 'author_name'], 'string', 'max' => 255],
            [['alias'], 'string', 'max' => 155],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios ()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @param array $postParams
     *
     * @return ActiveDataProvider
     */
    public function search ($params, $postParams)
    {
        $query = News::find();

        if ($params['category']) {
            $query->joinWith('newsJoinCats')
                ->andFilterWhere(['news_join_cat.category_id' => $this->categoryRepository->findCategoryByCatAlias($params['category'])->id]);
        }

        if (!empty($params['tag'])) {
            $query->joinWith('tagsJoinObj')->andFilterWhere(['tags_join_obj.id_tag' => $this->tagRepository->findTagByAlias($params['tag'],'news')]);
        }

        if (!empty($params['date'])) {
            $query->andFilterWhere(['like', 'news_date_start', "{$params['date']} %", false]);
        }

        $query->orderBy(['news_date_start' => SORT_ASC]);

        if ($params['sort']) {
            $query->orderBy(['news_date_start' => intval($params['sort'])]);
        }else
            $query->orderBy(['news_date_start' => SORT_DESC]);
//        if ($params['sort'] == 5) {
//            $query->joinWith('raitingTotal')->orderBy(['raiting_total.total' => SORT_DESC]);
//        }

        $query->distinct();
        $countQuery = clone $query;
        $totalCountWithoutFiltering = $countQuery->count();

        $count = $params['count'] ? intval($params['count']) : 12;
        $pageFrom = $postParams['pageFrom'] ? intval($postParams['pageFrom']) : 1;

        if ($params['page']) {
            $offset = ($pageFrom - 1) * $count;
            $query->offset($offset);
            $query->limit((intval($params['page']) - $pageFrom + 1) * $count);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $count,
                'totalCount' => $totalCountWithoutFiltering,
                'forcePageParam' => false,
                'pageSizeParam' => false,
            ],
        ]);

        /**
         * Нужен для получения количества всех записей, если выключена пагинация
         */
        $dataProvider->totalCount = $totalCountWithoutFiltering;

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        return $dataProvider;
    }
}