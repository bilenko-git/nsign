<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "ingredients".
 *
 * @property integer $id
 * @property string $ingredient
 * @property string $ingredient_active
 */
class Ingredients extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ingredients';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ingredient'], 'required'],
            [['ingredient_active'], 'string'],
            [['ingredient'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ingredient' => 'Ingredient',
            'ingredient_active' => 'Ingredient Active',
        ];
    }
}
