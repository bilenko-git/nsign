<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "dishes_and_ingredients".
 *
 * @property integer $dish_id
 * @property integer $ingredient_id
 */
class Dishes_and_ingredients extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dishes_and_ingredients';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dish_id', 'ingredient_id'], 'required'],
            [['dish_id', 'ingredient_id'], 'integer'],
            [['dish_id', 'ingredient_id'], 'unique', 'targetAttribute' => ['dish_id', 'ingredient_id'], 'message' => 'The combination of Dish ID and Ingredient ID has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'dish_id' => 'Dish ID',
            'ingredient_id' => 'Ingredient ID',
        ];
    }
}
