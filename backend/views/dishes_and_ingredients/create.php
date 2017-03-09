<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Dishes_and_ingredients */

$this->title = 'Create Dishes And Ingredients';
$this->params['breadcrumbs'][] = ['label' => 'Dishes And Ingredients', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dishes-and-ingredients-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
