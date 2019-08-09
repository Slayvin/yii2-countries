<?php

namespace slayvin\countries\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;
use yeesoft\multilingual\behaviors\MultilingualBehavior;
use slayvin\countries\models\CountryQuery;

/**
 * This is the model class for table "{{%countries}}".
 *
 * @property string $iso (3)
 * @property boolean $selectable
 * @property boolean $default
 * @property string $name (63)
 * @property string $demonym (63)
 *
 */
class Country extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%countries}}';
    }

    public function behaviors()
    {
        return [
            'multilingual' => [
                'class' => MultilingualBehavior::class,
                'languages' => Yii::$app->params['languages'] ?? ['en' => 'English'],
                'requireTranslations' => false,
                'attributes' => ['name', 'demonym'],
                'languageForeignKey' => 'country_iso',
            ],
        ];
    }

    public function rules()
    {
        return [
            // Name
            ['name', 'string', 'max' => 63],
            // Nationality
            ['demonym', 'string', 'max' => 63],
        ];
    }

    public function attributeLabels()
    {
        return [
            'iso' => 'ISO',
            'name' => Yii::t('label', 'Country'),
            'demonym' => Yii::t('label', 'Country'),
        ];
    }

    public static function find()
    {
        return new CountryQuery(get_called_class());
    }

    public static function getList()
    {
        $countries = static::find()
            ->select(['iso', 'name'])
            ->joinWith('translations', false)
            ->where(['language' => Yii::$app->language])
            ->orderBy('default DESC, name')
            ->asArray()
            ->all();

        return ArrayHelper::map($countries, 'iso', 'name');
    }
}
