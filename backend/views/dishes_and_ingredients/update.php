<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Dishes_and_ingredients */

$this->title = 'Update Dishes And Ingredients: ' . $model->dish_id;
$this->params['breadcrumbs'][] = ['label' => 'Dishes And Ingredients', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->dish_id, 'url' => ['view', 'dish_id' => $model->dish_id, 'ingredient_id' => $model->ingredient_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dishes-and-ingredients-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
