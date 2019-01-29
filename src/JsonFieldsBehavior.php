<?php

namespace mamatveev\yii2UsefulBehaviours;

use yii\base\Behavior;
use yii\db\ActiveRecord;

/**
 * Class JsonFieldsBehavior
 * @package common\base
 */
class JsonFieldsBehavior extends Behavior
{
    /**
     * @var array
     */
    public $attributes = [];

    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'encode',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'encode',
            ActiveRecord::EVENT_AFTER_FIND => 'decode',
            ActiveRecord::EVENT_AFTER_UPDATE => 'decode',
            ActiveRecord::EVENT_AFTER_INSERT => 'decode',
        ];
    }


    /**
     */
    public function decode()
    {
        foreach ($this->attributes as $fieldName) {
            $this->owner->$fieldName = json_decode($this->owner->$fieldName, true);
        }
    }

    /**
     */
    public function encode()
    {
        foreach ($this->attributes as $fieldName) {
            $this->owner->$fieldName = json_encode($this->owner->$fieldName, true);
        }
    }

}