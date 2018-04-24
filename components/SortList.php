<?php

namespace app\components;

use yii\base\Object;
use app\models\SmapPages;
use Yii;
use yii\helpers\ArrayHelper;
use app\modules\shop\models\ShopCategory;

class SortList extends Object {

    private $data;

    public function __construct ($menu_array = [], $config = []) {
        $this->data = $this->getMenuList($menu_array);

        parent::__construct($config);
    }

    /**
     * Sort an array of menu items like [id_par => [children array]]
     *
     * @param $array
     * @param int $parent_id
     * @return array
     */
    private function getMenuList ($array, $parent_id = 0) {
        $temp_array = array();
        foreach ($array as $element) {
            if ($element['id_par'] == $parent_id) {
                if (!empty($this->getMenuList($array, $element['id']))) {
                    $element['subs'] = $this->getMenuList($array, $element['id']);
                }
                $temp_array[] = $element;
            }
        }
        return $temp_array;
    }

    /**
     * Sort an array of menu items like [id_par => [children array]]
     *
     * @param $array
     * @param int $parent_id
     * @return array
     */
    private function getCatList ($array, $parent_id = 1) {
        $temp_array = array();

        foreach ($array as $element) {
            $children = ShopCategory::find()->where(['visible' => 1,'id_par'=> $element['id']])->orderBy('prior ASC')->asArray()->all();
            if ($element['id_par'] == $parent_id) {
                if (!empty($this->getCatList($children, $element['id']))) {
                    $element['subs'] = $this->getCatList($children, $element['id']);
                }
                $temp_array[] = $element;
            }
        }
        return $temp_array;
    }

    /**
     * Get element path including parents
     * Used in StartupBehaviour for checking url
     *
     * Needs to cache
     *
     * @param $id_par
     * @param $element_alias
     * @return string
     */
    public function getPath ($id_par, $element_alias)
    {
        $parent = SmapPages::find()->where(['id' => $id_par])->one();
        if (!empty($parent)) {
            $element_alias = $parent->alias . '/' . $element_alias;
            if (!empty(SmapPages::find()->where(['id' => $parent->id_par])->one())) {
                $element_alias = $this->getPath($parent->id_par, $element_alias);
            }
        }
        return $element_alias;
    }

    public $first = false;
    public $second = false;

    private function printMenu ($menu_array, $alias = '/')
    {
        foreach ($menu_array as $menu) {
            if ($menu['alias'] == 'catalog') {
                $data = ShopCategory::find()->where(['visible' => 1,'id_par'=> 1])->orderBy('prior ASC')->asArray()->all();
                $menu['subs'] = $this->getCatList($data);
            }

            if (array_key_exists('subs', $menu)) {
                echo "<li class='submenu first-level-sub'>
                    <a onclick='openMenu({e:event});' href=".Yii::$app->urlManager->createUrl($alias . '/' . $menu['alias']).">{$menu['name_'.Yii::$app->language]}";
                echo "</a>";

                if (array_key_exists('subs', $menu) && count($menu['subs'])>0) {

                    echo "<div class='submenu-wrap'>
                               <ul class='second-level'>";

                    foreach ($menu['subs'] as $submenu) {

                        if (array_key_exists('subs', $submenu)) {
                            echo "<li class='submenu hover-submenu'>
                            <a href=" . Yii::$app->urlManager->createUrl($alias . '/' . $menu['alias']. '/' . $submenu['alias']) . ">{$submenu['name_'.Yii::$app->language]}";
                            echo "</a>";

                            if (array_key_exists('subs', $submenu)) {
                                echo "<div class='third-level'>";
                                foreach ($submenu['subs'] as $subsubmenu) {
                                    echo "<ul>";
                                    if (array_key_exists('subs', $subsubmenu)) {
                                        echo "<li class='tl-head arrow'><a href='" . Yii::$app->urlManager->createUrl($alias . '/' . $menu['alias']. '/' . $submenu['alias']. '/' . $subsubmenu['alias']) . "'>{$subsubmenu['name_'.Yii::$app->language]}</a></li>";
                                        echo "<li class='tl-body'>";
                                            echo "<ul>";
                                            foreach ($subsubmenu['subs'] as $subsubsubmenu) {
                                                echo "<li><a href='" . Yii::$app->urlManager->createUrl($alias . '/' . $menu['alias']. '/' . $submenu['alias']. '/' . $subsubmenu['alias']. '/' . $subsubsubmenu['alias']) . "'>{$subsubsubmenu['name_'.Yii::$app->language]}</a></li>";
                                            }
                                            echo "</ul>";
                                        echo "</li>";
                                    }else{
                                        echo "<li class='tl-head'><a href='" . Yii::$app->urlManager->createUrl($alias . '/' . $menu['alias']. '/' . $submenu['alias']. '/' . $subsubmenu['alias']) . "'>{$subsubmenu['name_'.Yii::$app->language]}</a></li>";
                                    }
                                    echo "</ul>";
                                }


                                echo "</div>";
                            }
                        }else{
                            echo "<li>
                            <a href=" . Yii::$app->urlManager->createUrl($alias . '/' . $menu['alias'] . '/' . $submenu['alias']) . ">{$submenu['name_'.Yii::$app->language]}";
                            echo "</a>";
                        }
                        echo "</li>";
                    }

                    echo "</ul>
                    </div>";
                }

                echo "</li>";
            } else {
                echo "<li><a href='" . Yii::$app->urlManager->createUrl($alias . '/' . $menu['alias']) . "'>{$menu['name_'.Yii::$app->language]}</a></li>";
            }
        }
    }

    private function printMobileMenu ($menu_array, $alias = '/')
    {
        foreach ($menu_array as $menu) {
            if ($menu['alias'] == 'catalog') {
                $data = ShopCategory::find()->where(['visible' => 1,'id_par'=> 1])->orderBy('prior ASC')->asArray()->all();
                $menu['subs'] = $this->getCatList($data);
            }
            if (array_key_exists('subs', $menu)) {
                echo "<li>
                    <a href=".Yii::$app->urlManager->createUrl($alias . '/' . $menu['alias']).">{$menu['name_'.Yii::$app->language]}";
                echo "</a><ul>";
                $this->printMobileMenu($menu['subs'], $alias . '/' . $menu['alias']);
                echo "</ul></li>";
            }else {
                echo "<li><a href='" . Yii::$app->urlManager->createUrl($alias . '/' . $menu['alias']) . "'>{$menu['name_'.Yii::$app->language]}</a></li>";
            }
        }
    }

    public function finalPrintMenu () {
        $this->printMenu($this->data);
    }
    public function finalPrintMobileMenu () {
        $this->printMobileMenu($this->data);
    }
}