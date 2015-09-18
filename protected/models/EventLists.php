<?php

/**
 * This is the model class for table "{{event_lists}}".
 *
 * The followings are the available columns in table '{{event_lists}}':
 * @property integer $timing_id
 * @property integer $event_id
 * @property string $list_title
 * @property integer $list_role
 * @property string $timing_start
 * @property string $timing_end
 * @property string $timing_notes
 * @property string $event_type
 * @property string $event_adjusted
 * @property string $created_at
 * @property string $created_by
 * @property integer $modified_at
 * @property integer $modified_by
 *
 * The followings are the available model relations:
 * @property Event $event
 */
class EventLists extends RActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{event_lists}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('list_title, list_role, timing_start, timing_end', 'required'),
            array('event_id', 'required', 'on' => 'update'),
            array('event_id, list_role, created_by, modified_by', 'numerical', 'integerOnly' => true),
            array('list_title', 'length', 'max' => 255),
            array('timing_notes, created_at, created_by, event_type, event_adjusted', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('timing_id, event_id, list_title, list_role, timing_start, timing_end, timing_notes, created_at, created_by, modified_at, modified_by', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'eventHistories' => array(self::HAS_MANY, 'EventHistory', 'event_list_id'),
            'event' => array(self::BELONGS_TO, 'Event', 'event_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'timing_id' => 'Timing',
            'event_id' => 'Event',
            'list_title' => 'Event Name',
            'list_role' => 'Category',
            'timing_start' => 'Timing Start',
            'timing_end' => 'Timing End',
            'timing_notes' => 'Timing Notes',
            'event_type' => 'Event Type',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'modified_at' => 'Modified At',
            'modified_by' => 'Modified By',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return EventLists the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function dataProvider() {
        $criteria = new CDbCriteria;

        $criteria->compare('timing_id', $this->timing_id);
        $criteria->compare('event_id', $this->event_id);
        $criteria->compare('list_title', $this->list_title, true);
        $criteria->compare('list_role',$this->list_role);
        $criteria->compare('timing_start', $this->timing_start, true);
        $criteria->compare('timing_end', $this->timing_end, true);
        $criteria->compare('timing_notes', $this->timing_notes, true);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('created_by', $this->created_by, true);
        $criteria->compare('modified_at', $this->modified_at);
        $criteria->compare('modified_by', $this->modified_by);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => PAGE_SIZE,
            )
        ));
    }

    public function eventtypes($key = null) {
        $lists = array(
            'FX' => 'Fixed',
            'FL' => 'Flexible',
        );
        if($key != null)
            return $lists[$key];
        return $lists;
    }

    protected function beforeSave() {
        if($this->isNewRecord){
            $this->timing_start = date('h:i:s', strtotime($this->timing_start));
            $this->timing_end = date('h:i:s', strtotime($this->timing_end));
        }
        return parent::beforeSave();
    }
}
