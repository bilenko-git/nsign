<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Dishes_and_ingredients */

$this->title = $model->dish_id;
$this->params['breadcrumbs'][] = ['label' => 'Dishes And Ingredients', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dishes-and-ingredients-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'dish_id' => $model->dish_id, 'ingredient_id' => $model->ingredient_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'dish_id' => $model->dish_id, 'ingredient_id' => $model->ingredient_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'dish_id',
            'ingredient_id',
        ],
    ]) ?>

</div>
