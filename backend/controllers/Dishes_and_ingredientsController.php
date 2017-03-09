<?php

namespace backend\controllers;

use Yii;
use backend\models\Dishes_and_ingredients;
use backend\models\Dishes_and_ingredientsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * Dishes_and_ingredientsController implements the CRUD actions for Dishes_and_ingredients model.
 */
class Dishes_and_ingredientsController extends Controller
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
     * Lists all Dishes_and_ingredients models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new Dishes_and_ingredientsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Dishes_and_ingredients model.
     * @param integer $dish_id
     * @param integer $ingredient_id
     * @return mixed
     */
    public function actionView($dish_id, $ingredient_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($dish_id, $ingredient_id),
        ]);
    }

    /**
     * Creates a new Dishes_and_ingredients model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Dishes_and_ingredients();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'dish_id' => $model->dish_id, 'ingredient_id' => $model->ingredient_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Dishes_and_ingredients model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $dish_id
     * @param integer $ingredient_id
     * @return mixed
     */
    public function actionUpdate($dish_id, $ingredient_id)
    {
        $model = $this->findModel($dish_id, $ingredient_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'dish_id' => $model->dish_id, 'ingredient_id' => $model->ingredient_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Dishes_and_ingredients model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $dish_id
     * @param integer $ingredient_id
     * @return mixed
     */
    public function actionDelete($dish_id, $ingredient_id)
    {
        $this->findModel($dish_id, $ingredient_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Dishes_and_ingredients model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $dish_id
     * @param integer $ingredient_id
     * @return Dishes_and_ingredients the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($dish_id, $ingredient_id)
    {
        if (($model = Dishes_and_ingredients::findOne(['dish_id' => $dish_id, 'ingredient_id' => $ingredient_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
