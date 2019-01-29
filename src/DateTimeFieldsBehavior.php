<?php
namespace mamatveev\yii2UsefulBehaviours;

use yii\base\Behavior;
use yii\db\BaseActiveRecord;

/**
 * Поля БД типа datetime или timestamp будут инстансом \DateTime
 */
class DateTimeFieldsBehavior extends Behavior
{
    /**
     * @var string[]
     */
    public $attributes = [];

    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            BaseActiveRecord::EVENT_BEFORE_INSERT => 'encode',
            BaseActiveRecord::EVENT_BEFORE_UPDATE => 'encode',
            BaseActiveRecord::EVENT_AFTER_FIND => 'decode',
            BaseActiveRecord::EVENT_AFTER_UPDATE => 'decode',
            BaseActiveRecord::EVENT_AFTER_INSERT => 'decode'
        ];
    }

    public function decode($event)
    {
        foreach ($this->attributes as $fieldName) {
            if (isset($this->owner->$fieldName) && !empty($this->owner->$fieldName)) {
                $this->owner->$fieldName = new \DateTime($this->owner->$fieldName);
            }
        }
    }

    public function encode($event)
    {
        foreach ($this->attributes as $fieldName) {
            if (isset($this->owner->$fieldName) && !empty($this->owner->$fieldName))
            {
                if ($this->owner->$fieldName instanceof \DateTime) {
                    $this->owner->$fieldName = $this->owner->$fieldName->format('Y-m-d H:i:s');
                }
            }
        }
    }
}

