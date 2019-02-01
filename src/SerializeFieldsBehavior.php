<?php


namespace mamatveev\yii2UsefulBehaviours;


use yii\base\Behavior;

class SerializeFieldsBehavior extends Behavior
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
            $this->owner->$fieldName = serialize($this->owner->$fieldName);
        }
    }

    /**
     */
    public function encode()
    {
        foreach ($this->attributes as $fieldName) {
            $this->owner->$fieldName = unserialize($this->owner->$fieldName);
        }
    }

}
