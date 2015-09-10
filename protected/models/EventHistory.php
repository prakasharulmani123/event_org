<?php

/**
 * This is the model class for table "{{event_history}}".
 *
 * The followings are the available columns in table '{{event_history}}':
 * @property integer $event_hist_id
 * @property integer $event_list_id
 * @property string $event_hist_reason
 * @property string $event_hist_time_separator
 * @property string $event_hist_excess_time
 * @property string $event_hist_type
 * @property string $event_hist_new_from
 * @property string $event_hist_new_to
 * @property string $created_at
 * @property integer $created_by
 * @property string $modified_at
 * @property integer $modified_by
 *
 * The followings are the available model relations:
 * @property EventLists $eventList
 */
class EventHistory extends RActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{event_history}}';
    }

    public function scopes() {
        $alias = $this->getTableAlias(false, FALSE);
        $user_id = Yii::app()->user->id;
        return array(
            'mine' => array('condition' => "$alias.created_by = '$user_id'")
        );
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('event_list_id, event_hist_reason, event_hist_excess_time, event_hist_from, event_hist_to', 'required'),
            array('event_list_id, created_by, modified_by', 'numerical', 'integerOnly' => true),
            array('event_hist_time_separator', 'length', 'max' => 1),
            array('created_at, modified_at, event_hist_from, event_hist_to, event_hist_type, event_hist_new_from, event_hist_new_to', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('event_hist_id, event_list_id, event_hist_reason, event_hist_time_separator, event_hist_excess_time, created_at, created_by, modified_at, modified_by', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'eventList' => array(self::BELONGS_TO, 'EventLists', 'event_list_id'),
            'createdBy' => array(self::BELONGS_TO, 'User', 'created_by'),
            'modifiedBy' => array(self::BELONGS_TO, 'User', 'modified_by'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'event_hist_id' => 'Event Hist',
            'event_list_id' => 'List',
            'event_hist_reason' => 'Reason',
            'event_hist_time_separator' => 'Separator',
            'event_hist_excess_time' => 'Excessive Time',
            'event_hist_from' => 'Old From Time',
            'event_hist_to' => 'Old To Time',
            'event_hist_type' => 'Type',
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
     * @return EventHistory the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function dataProvider() {
        $criteria = new CDbCriteria;

        $criteria->compare('event_hist_id', $this->event_hist_id);
        $criteria->compare('event_list_id', $this->event_list_id);
        $criteria->compare('event_hist_reason', $this->event_hist_reason, true);
        $criteria->compare('event_hist_time_separator', $this->event_hist_time_separator, true);
        $criteria->compare('event_hist_excess_time', $this->event_hist_excess_time, true);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('modified_at', $this->modified_at, true);
        $criteria->compare('modified_by', $this->modified_by);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => PAGE_SIZE,
            )
        ));
    }

    protected function beforeSave() {
        $this->event_hist_new_from = $this->event_hist_from;
        if ($this->event_hist_time_separator == '+') {
            $this->event_hist_new_to = date("H:i:s", strtotime($this->event_hist_to) + strtotime($this->event_hist_excess_time) - strtotime("00:00:00"));
        } else if ($this->event_hist_time_separator == '-') {
            $this->event_hist_new_to = date("H:i:s", strtotime($this->event_hist_to) - strtotime($this->event_hist_excess_time) + strtotime("00:00:00"));
        }
        return parent::beforeSave();
    }

    protected function afterSave() {
        $event_list = EventLists::model()->findByPk($this->event_list_id);
        $lists = EventLists::model()->findAll('event_id = :event_id And timing_start >= :time And event_type = :type', array(':event_id' => $event_list->event_id, ':time' => $event_list->timing_start, ':type' => 'FL'));
        $i = 1;
        foreach ($lists as $list) {
            $old_start_time = date('h:i A', strtotime($list->timing_start));
            $old_end_time = date('h:i A', strtotime($list->timing_end));
            $type = '';
            
            if ($this->event_hist_time_separator == '+'){
                $list->timing_end = date("H:i:s", strtotime($list->timing_end) + strtotime($this->event_hist_excess_time) - strtotime("00:00:00"));
                $type = 'Push Time';
            }else if ($this->event_hist_time_separator == '-'){
                $list->timing_end = date("H:i:s", strtotime($list->timing_end) - strtotime($this->event_hist_excess_time) + strtotime("00:00:00"));
                $type = 'Make Time';
            }
            
            if ($i != 1) {
                if ($this->event_hist_time_separator == '+')
                    $list->timing_start = date("H:i:s", strtotime($list->timing_start) + (strtotime($this->event_hist_excess_time) - strtotime("00:00:00")));
                else
                    $list->timing_start = date("H:i:s", strtotime($list->timing_start) - (strtotime($this->event_hist_excess_time) - strtotime("00:00:00")));
            }else{
                $list->event_adjusted = 'Y';
                $notes = '';
                $new_end_time = date('h:i A', strtotime($list->timing_end));
                $notes .= "Modified by : ".Yii::app()->user->name." <br> {$old_end_time} changed as {$new_end_time}"."<br> {$type} Duration: {$this->event_hist_excess_time}<br><br>";
                $list->timing_notes = $list->timing_notes.$notes;
            }
            $list->save();
            $i++;
        }
        return parent::afterSave();
    }

    public function historytype($key = null) {
        $lists = array(
            'MT' => 'Make Time',
            'PT' => 'Push Time',
        );
        if ($key != null)
            return $lists[$key];
        return $lists;
    }

}
