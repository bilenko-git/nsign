<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use backend\models\Ingredients;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Url;
$this->title = 'My Yii Application';
?>
<div class="site-index">
    <div class="body-content">

        <div class="row">
            <div class="col-lg-2">
                <?php $form = ActiveForm::begin(['action' => ['site/dishes'], 'method' => 'get']); ?>
                    
                    <?= Select2::widget([
                        'max' => 5,
                        'name' => 'ingredients',
                        'value' => $getIngredients,
                        'data' => $ingredients,
                        'options' => ['multiple' => true, 'placeholder' => 'Select ingredients ...']
                    ]); ?>

                    <div style="display: flex; justify-content: space-between; margin-top: 25px; ">
                        <?= Html::tag('a', 'Reset', [
                            'class' => [
                                'btn',
                                'theme' => 'btn-default',
                            ],
                            'href' => 'index.php?r=site%2Findex'
                        ]); ?>

                        <?php echo Html::submitButton('Find', ['class' => 'btn btn-primary']);  ?>
                    </div>
                <?php ActiveForm::end(); ?>
            </div>

             <div class="col-lg-10 dishes" style="display: flex;">
                <? 
                    if( $dishes && is_array($dishes) ) {
                        foreach ($dishes as $key => $value) {
                            echo '<div style="border: 1px solid #ccc;padding: 10px 25px 10px 25px;margin: 0px 20px 3px 0px;width: 200px;">
                                    <div style="margin-bottom: 20px; text-align: center;">'.$dishes[$key]['dish'].'</div>
                                    <div style="margin-bottom: 10px; font-size: 12px;">'.$dishes[$key]['ingredients'].'</div>
                            </div>';    
                        }
                    } else {
                        echo $dishes;
                    }
                ?>
            </div>
        </div>

    </div>
</div>
