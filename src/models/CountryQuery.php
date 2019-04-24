<?php

namespace slayvin\countries\models;

use yii\db\ActiveQuery;

class CountryQuery extends ActiveQuery
{

    use \yeesoft\multilingual\db\MultilingualTrait;

    public function selectable($value = true)
    {
        return $this->andOnCondition(['selectable' => $value])->orderBy('default DESC');
    }
}
