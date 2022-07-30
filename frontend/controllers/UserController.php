<?php

namespace frontend\controllers;

use common\models\User;
use frontend\models\user\SigninForm;
use frontend\models\user\SignupForm;
use frontend\models\user\UserUpdateForm;
use frontend\models\user\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\UploadedFile;

class UserController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionSignin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new SigninForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('signin', [
            'model' => $model,
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionSignout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionSignup()
    {
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post())) {
            $model->imageFile = UploadedFile::getInstanceByName('SignupForm[imageFile]');
            if ($model->signup()) {
                Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
                return $this->goHome();
            }
        }

        $formName = 'signup';
        return $this->render('signup', [
            'model' => $model,
            'name' => $formName,
        ]);
    }

    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if (($user = $model->verifyEmail()) && Yii::$app->user->login($user)) {
            Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
            return $this->goHome();
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    public function actionUpdate($id)
    {
        $model = User::find()->where('id = :id', [':id' => $id])->one();

        if ($model['id'] !== Yii::$app->user->id) {
            Yii::$app->session->setFlash('error', 'You cannot edit this account.');
            return $this->goHome();
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->imageFile = UploadedFile::getInstanceByName('User[imageFile]');
            if ($model->updateAccount($id)) {
                Yii::$app->session->setFlash('success', 'Account was succesfully updated.');
                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Something was wrong.');
            }
        }


        $mainTitle = 'Update form';
        $formName = 'user';
        $this->view->title = 'Update account';
        return $this->render('form', [
            'model' => $model,
            'title' => $mainTitle,
            'name' => $formName,
        ]);
    }
}
