<?php

namespace frontend\controllers;

use common\models\Article;
use common\models\Category;
use common\models\Commentary;
use Yii;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\UploadedFile;

class ArticleController extends Controller
{
    public function actionIndex()
    {
        $query = Article::find()
            ->select('article.id, title, description, image, created_at,
        article.category_id, category.id AS category_id, category.name AS category_name')
            ->innerJoin('category', 'article.category_id = category.id')
            ->asArray()->orderBy('article.id DESC');
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 20]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        $this->view->title = 'Main page';
        $mainTitle = 'Required title of main page';
        return $this->render('index', [
            'articles' => $models,
            'pages' => $pages,
            'title' => $mainTitle,
        ]);
    }

    public function actionCategory($id)
    {
        $category = Category::find()->select(['parent_id', 'name'])->where('id = :id', [':id' => $id])->one();
        if ($category['parent_id'] !== 0) {
            $query = Article::find()->select('article.id, title, description, image, created_at,
            article.category_id, category.id AS category_id, category.name AS category_name')
                ->innerJoin('category', 'article.category_id = category.id')->asArray()
                ->where('category_id = :id', [':id' => $id])->orderBy('id DESC');
        } else {
            $categoryChildren = Category::find()->select('id')->where('parent_id = :id', [':id' => $id])->all();
            $categoryAll = [];
            foreach ($categoryChildren as $child) {
                array_push($categoryAll, $child['id']);
            }
            array_push($categoryAll, intval($id, 10));
            $query = Article::find()->select('article.id, title, description, image, created_at,
            article.category_id, category.id AS category_id, category.name AS category_name')
                ->innerJoin('category', 'article.category_id = category.id')
                ->asArray()->where(['in', 'category_id', $categoryAll])->orderBy('id DESC');
        }
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 20]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        $this->view->title = $category['name'];
        if (count($models) > 0) {
            $mainTitle = 'All articles from ' . $category['name'];
            return $this->render('index', [
                'articles' => $models,
                'pages' => $pages,
                'title' => $mainTitle,
            ]);
        } else {
            $mainTitle = 'No results';
            return $this->render('noresult', [
                'title' => $mainTitle,
            ]);
        }
    }

    public function actionSearch()
    {
        $q = '%' . $_POST['q'] . '%';
        $query = Article::find()->select('article.id, title, description, image, created_at,
        article.category_id, category.id AS category_id, category.name AS category_name')
            ->innerJoin('category', 'article.category_id = category.id')
            ->asArray()->where(['like', 'title', $q, false])->orWhere(['like', 'description', $q, false])
            ->orderBy('article.id DESC');

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 20]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        $this->view->title = 'Search results';
        if (count($models) > 0) {
            $mainTitle = 'All articles according to this search query: ' . $_POST['q'];
            return $this->render('index', [
                'articles' => $models,
                'pages' => $pages,
                'title' => $mainTitle,
            ]);
        } else {
            $mainTitle = 'No results';
            return $this->render('noresult', [
                'title' => $mainTitle,
            ]);
        }
    }

    public function actionCreate()
    {
        $this->view->title = 'Create article';
        $model = new Article();

        if ($model->load(Yii::$app->request->post())) {
            $model->imageFile = UploadedFile::getInstanceByName('Article[imageFile]');
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Article was succesfully created.');
                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Something was wrong.');
            }
        }

        $name = 'article';
        $mainTitle = 'Create form';
        return $this->render('form', [
            'model' => $model,
            'title' => $mainTitle,
            'name' => $name,
        ]);
    }

    public function actionView($id)
    {
        $model = Article::find()->select('article.id, title, description, article.image AS image,
        article.created_at, article.updated_at, article.category_id, category.id AS category_id,
        category.name AS category_name, article.user_id, user.id AS user_id, user.username AS username,
        user.image AS user_image')
            ->innerJoin('category', 'article.category_id = category.id')
            ->innerJoin('user', 'article.user_id = user.id')->asArray()
        ->where('article.id = :id', [':id' => $id])->one();

        if ($model !== null) {
            $query = Commentary::find()->where('article_id = :id', [':id' => $id])
            ->select('commentary.id, sender_id, text, commentary.created_at, user.username,
            user.image')
            ->innerJoin('user', 'commentary.sender_id = user.id')
            ->asArray()->orderBy('commentary.created_at DESC');
            $countQuery = clone $query;
            $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 10]);
            $commentaries = $query->offset($pages->offset)
                ->limit($pages->limit)
                ->all();

            $this->view->title = $model['title'];

            $mainTitle = 'Commentaries';
            return $this->render('view', [
                'article' => $model,
                'pages' => $pages,
                'commentaries' => $commentaries,
            ]);
        } else {
            $this->view->title = 'Article';
            $mainTitle = 'Sorry this article doesn`t exists';
            return $this->render('noresult', [
                'title' => $mainTitle,
            ]);
        }
    }

    public function actionUpdate($id)
    {
        $model = Article::find()->where('id = :id', [':id' => $id])->one();

        if ($model['user_id'] !== Yii::$app->user->id) {
            Yii::$app->session->setFlash('error', 'You cannot edit this article.');
            return $this->goHome();
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->imageFile = UploadedFile::getInstanceByName('Article[imageFile]');
            if ($model->updateArticle($id)) {
                Yii::$app->session->setFlash('success', 'Article was succesfully updated.');
                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Something was wrong.');
            }
        }


        $mainTitle = 'Update form';
        $formName = 'article';
        return $this->render('form', [
            'model' => $model,
            'title' => $mainTitle,
            'name' => $formName,
        ]);
    }

    public function actionDelete($id)
    {
        $model = Article::find()->where('id = :id', [':id' => $id])->one();

        if ($model['user_id'] !== Yii::$app->user->id) {
            Yii::$app->session->setFlash('error', 'You cannot delete this article.');
            return $this->goHome();
        } else {
            $model->deleteArticle();
            Yii::$app->session->setFlash('succes', 'Article was succesfully deleted.');
            return $this->goHome();
        }
    }
}
