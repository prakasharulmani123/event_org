<?php

/**
 * This is the model class for table "{{event}}".
 *
 * The followings are the available columns in table '{{event}}':
 * @property integer $event_id
 * @property string $event_name
 * @property string $event_date
 * @property string $event_users
 * @property string $status
 * @property string $created_at
 * @property string $created_by
 * @property integer $modified_at
 * @property integer $modified_by
 *
 * The followings are the available model relations:
 * @property EventLists[] $eventlists
 */
class Event extends RActiveRecord {

//    public $userlist;
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{event}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('event_name, event_date, event_users', 'required'),
            array('created_by, modified_by', 'numerical', 'integerOnly' => true),
            array('event_name', 'length', 'max' => 255),
            array('status', 'length', 'max' => 1),
            array('created_at, created_by', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('event_id, event_name, event_date, event_users, status, created_at, created_by, modified_at, modified_by', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'eventlists' => array(self::HAS_MANY, 'EventLists', 'event_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'event_id' => 'Event',
            'event_name' => 'Event Name',
            'event_date' => 'Event Date',
            'event_users' => 'Event Users',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'modified_at' => 'Modified At',
            'modified_by' => 'Modified By',
            'userlist' => 'Event Users',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Event the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function dataProvider() {
        $criteria = new CDbCriteria;

        $criteria->compare('event_id', $this->event_id);
        $criteria->compare('event_name', $this->event_name, true);
        $criteria->compare('event_date', $this->event_date, true);
        $criteria->compare('event_users', $this->event_users, true);
        $criteria->compare('status', $this->status, true);
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

    protected function beforeSave() {
        if(is_array($this->event_users))
            $this->event_users = CJSON::encode($this->event_users);
        $this->event_date = date('Y-m-d', strtotime($this->event_date));
        return parent::beforeSave();
    }
    
    public function getUserList() {
        $users = CJSON::decode($this->event_users);
        $user = '';
        if(!empty($users))
            foreach ($users as $userid)
                $user .= User::model()->findByPk($userid)->user_firstname.', ';
        $user = rtrim($user, ', ');
        return $user;
    }
}
