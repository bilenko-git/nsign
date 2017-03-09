<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "dishes".
 *
 * @property integer $id
 * @property string $dish
 * @property string $dish_active
 */
class Dishes extends \yii\db\ActiveRecord
{
    public $ingredient;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dishes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dish'], 'required'],
            [['dish_active'], 'string'],
            [['dish'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dish' => 'Dish',
            'dish_active' => 'Dish Active',
        ];
    }
}
