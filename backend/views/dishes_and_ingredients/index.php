<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\Dishes_and_ingredientsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dishes And Ingredients';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dishes-and-ingredients-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Dishes And Ingredients', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'dish_id',
            'ingredient_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
