<?php

namespace common\widgets;

use common\models\Category;
use yii\base\Widget;

class Navigation extends Widget
{
    public $data;
    public $tree;
    public $navHtml;

    public function run()
    {
        $nav = \Yii::$app->cache->get('navigation');
        if (!$nav) {
            $this->data = Category::find()->indexBy('id')->asArray()->all();
            $this->tree = $this->getTree();
            $this->navHtml = $this->getNavHtml($this->tree);
            \Yii::$app->cache->set('navigation', $this->navHtml, 3600);
            return $this->navHtml;
        } else {
            return $nav;
        }
    }

    protected function getTree()
    {
        $tree = [];
        foreach ($this->data as $id => &$node) {
            if ($node['parent_id'] === 0)
                $tree[$id] = &$node;
            else
                $this->data[$node['parent_id']]['children'][$node['id']] = &$node;
        }
        return $tree;
    }

    protected function getNavHtml($tree)
    {
        $str = '';
        foreach ($tree as $nav) {
            $str .= $this->navToTemplate($nav);
        }
        return $str;
    }

    protected function navToTemplate($nav)
    {
        ob_start();
        include __DIR__ . '/layouts/navigation/index.php';
        return ob_get_clean();
    }
}

?>