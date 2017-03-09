<?php

namespace backend\controllers;

use Yii;
use backend\models\Dishes;
use backend\models\Ingredients; //test
use backend\models\Dishes_and_ingredients; //test
use backend\controllers\Dishes_and_ingredientsControllers;

use yii\helpers\ArrayHelper;

use backend\models\DishesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DishesController implements the CRUD actions for Dishes model.
 */
class DishesController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Dishes models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DishesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Dishes model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Dishes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Dishes();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
           
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            
            return $this->render('create', [
                'model' => $model,
                'ingredientsData' => [
                    'ingredients' => $this->getIngredients(),
                    'selectedIngredients' => []
                ],
            ]);
        }
    }

    public function getIngredients() {
        return ArrayHelper::map(Ingredients::find()->orderBy('ingredient')->all(), 'id', 'ingredient');
    }

    public function selectedIngredients($id = false) {
        $ingredients = Dishes_and_ingredients::find()
                        ->select(['ingredient_id'])
                        ->asArray()
                        ->where(['dish_id' => $id])->all();

        $selected = [];
        foreach ($ingredients as $key => $value) {
            array_push($selected, $value['ingredient_id']);
        }

        // print_r($ingredients); die('');
        return $selected;
    }

    /**
     * Updates an existing Dishes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            
            Yii::$app->db->createCommand()
                ->delete('dishes_and_ingredients', array('dish_id' => $id))
                ->execute();

            if(!empty(Yii::$app->request->post()['ingredients'])) {
                $data = [];

                foreach (Yii::$app->request->post()['ingredients'] as $key => $value) {
                    $data[] = [$id, $value];
                }

                Yii::$app->db->createCommand()
                    ->batchInsert('dishes_and_ingredients', ['dish_id', 'ingredient_id'], $data)
                    ->execute();
            }
       
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'ingredientsData' => [
                    'ingredients' => $this->getIngredients(),
                    'selectedIngredients' => $this->selectedIngredients($model->id)
                ],
            ]);
        }
    }

    /**
     * Deletes an existing Dishes model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Dishes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Dishes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Dishes::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
