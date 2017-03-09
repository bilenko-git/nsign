<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use backend\models\Ingredients;
use backend\models\Dishes;
use backend\controllers\DishesController; //test
use yii\helpers\ArrayHelper;
use backend\models\Dishes_and_ingredients;
/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
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
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
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

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index', [
            'ingredients' => ArrayHelper::map(Ingredients::find()->orderBy('ingredient')->all(), 'id', 'ingredient'),
            'getIngredients' => [],
            'dishes' => ''
        ]);
    }

    public function getDishes( $ingredients ) 
    {
        $id_dishes = dishes_and_ingredients::find()
                        ->select(['dish_id', 'ingredient_id'])
                        ->asArray()
                        ->groupBy('dish_id')
                        ->where(['ingredient_id' => $ingredients])
                        ->all(); 

        $all_dish_id = array();
        foreach ( $id_dishes as $key => $value ) {
            array_push( $all_dish_id, $value['dish_id'] );  
        }

        $dishes = dishes_and_ingredients::find()
                        ->select(['dish', 'ingredient', 'dish_id', 'ingredient_id', 'ingredient_active'])
                        ->leftJoin('dishes', 'dishes.id = dishes_and_ingredients.dish_id')
                        ->leftJoin('ingredients', 'ingredients.id = dishes_and_ingredients.ingredient_id')
                        ->where(['dish_id' => $all_dish_id])
                        ->asArray()
                        ->all(); 

        return $dishes;
    }

    public function dishes_with_ingredients_arr( $dishes ) 
    {

        $count_dishes = count($dishes);

        for ( $i=0; $i < $count_dishes; $i++ ) {
            $ii = $i;

            if(!empty($dishes[$i]) && !empty($dishes[$i]['dish_id'])) {
                $dishes[$i]['ingredient_id'] = array($dishes[$i]['ingredient_id']);

                if( empty($dishes[$i]['ingredient_active']) ) {
                    $dishes[$i]['ingredient_active'] = 0;
                }

                if(!empty($dishes[$i]['ingredients'])) {
                    $dishes[$i]['ingredients'] = $dishes[$i]['ingredients'] + $dishes[$i]['ingredient'];
                } else {
                    $dishes[$i]['ingredients'] = $dishes[$i]['ingredient'];
                }

                for ( $j = $i+1; $j < $count_dishes; $j++ ) {
                    if( $dishes[$i]['dish_id'] == $dishes[$j]['dish_id'] ) {
                        
                        if( empty($dishes[$j]['ingredient_active']) ) {
                            $dishes[$ii]['ingredient_active'] = 0;
                        }

                        array_push($dishes[$ii]['ingredient_id'], $dishes[$j]['ingredient_id']);
                        $dishes[$ii]['ingredients'] .= ', '.$dishes[$j]['ingredient'];
                        unset($dishes[$j]);
                    }
                }  
            }
        }

        return $dishes;
    }

    public function actionDishes()
    {
        $GET = Yii::$app->request->get();
        $data = 'Выберите больше ингредиентов.'; 

        if( !empty($GET['ingredients']) && count($GET['ingredients']) >= 2 ) {
            $coincidedAllVal = [];
            $coincidedPartially = [];
            $other = [];
            $dishes = $this->getDishes($GET['ingredients']);
            $dishes_with_ingredients_arr = $this->dishes_with_ingredients_arr( $dishes );

            foreach ( $dishes_with_ingredients_arr as $key => $value ) {
                if( $dishes_with_ingredients_arr[$key]['ingredient_active'] ) {
                    
                    $diffArr = array_diff( $dishes_with_ingredients_arr[$key]['ingredient_id'], $GET['ingredients'] );
                    $count_ingredients = count(array_intersect( $dishes_with_ingredients_arr[$key]['ingredient_id'], $GET['ingredients'] ));

                    if(!$diffArr) {
                       array_push($coincidedAllVal, $dishes_with_ingredients_arr[$key]);
                    } else if ( $count_ingredients >= 2 ) {
                        $dishes_with_ingredients_arr[$key]['q'] = $count_ingredients;
                        array_push($coincidedPartially, $dishes_with_ingredients_arr[$key]); 
                    } else if ( $count_ingredients < 2 ) {
                        array_push($other, $dishes_with_ingredients_arr[$key]); 
                    }
                }
            }


            if( !empty($coincidedAllVal) ) {
                $data = $coincidedAllVal;
            } else if( !empty($coincidedPartially) ) {
                usort($coincidedPartially, function($a, $b) {
                    if ($a['q'] == $b['q']) {
                        return 0;
                    }
                    return ($a['q'] > $b['q']) ? -1 : 1;   
                });

                $data = $coincidedPartially;
            } else if ( !empty($other) || empty($coincidedAllVal) || empty($coincidedPartially) ) {
                $data = 'Ничего не найдено';
            }
        } 
    
        return $this->render('index', [
            'ingredients' => ArrayHelper::map(Ingredients::find()->orderBy('ingredient')->all(), 'id', 'ingredient'),
            'getIngredients' => !empty($GET['ingredients']) ? $GET['ingredients'] : '',
            'dishes' => !empty($data) ? $data : '', 
        ]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
