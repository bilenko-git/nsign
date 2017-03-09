<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Dishes_and_ingredients */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dishes-and-ingredients-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'dish_id')->textInput() ?>

    <?= $form->field($model, 'ingredient_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
