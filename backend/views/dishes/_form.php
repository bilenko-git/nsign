<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model backend\models\Dishes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dishes-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'dish')->textInput(['maxlength' => true]) ?>

    <!-- <?= $form->field($model, 'dish_active')->dropDownList([ 1 => '1', 0 => '0', ], ['prompt' => '']) ?> -->

	<?= 
		//print_r(ArrayHelper::map(Ingredients::find()->orderBy('ingredient')->all(), 'id', 'ingredient')); die('');
		Select2::widget([
	    'name' => 'ingredients',
	    'value' => $ingredientsData['selectedIngredients'],
	    'data' => $ingredientsData['ingredients'],
	    'options' => ['multiple' => true, 'placeholder' => 'Select ingredients ...']
	]); ?>

	<br>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
