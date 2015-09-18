<?php

/**
 * This is the model class for table "{{event_vendors}}".
 *
 * The followings are the available columns in table '{{event_vendors}}':
 * @property integer $evt_vendor
 * @property integer $ev_event_id
 * @property string $evt_vendor_name
 * @property string $evt_vendor_email
 * @property string $evt_vendor_phone
 * @property integer $evt_vendor_role
 * @property string $is_status
 * @property string $created_at
 * @property integer $created_by
 */
class EventVendors extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{event_vendors}}';
    }

    public function scopes() {
        $alias = $this->getTableAlias(false, FALSE);
        return array(
            'active' => array('condition' => "$alias.is_status = '1'")
        );
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ev_event_id, evt_vendor_name, evt_vendor_email, evt_vendor_phone, evt_vendor_role, created_by', 'required'),
            array('evt_vendor_email', 'email'),
            array('ev_event_id, evt_vendor_role, created_by', 'numerical', 'integerOnly' => true),
            array('evt_vendor_name, evt_vendor_email, evt_vendor_phone', 'length', 'max' => 100),
            array('is_status', 'length', 'max' => 1),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('evt_vendor, ev_event_id, evt_vendor_name, evt_vendor_email, evt_vendor_phone, evt_vendor_role, is_status, created_at, created_by', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'evt_vendor' => 'Evt Vendor',
            'ev_event_id' => 'Ev Event',
            'evt_vendor_name' => 'Vendor Name',
            'evt_vendor_email' => 'Email Address',
            'evt_vendor_phone' => 'Phone Number',
            'evt_vendor_role' => 'Category',
            'is_status' => 'Is Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return EventVendors the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function dataProvider() {
        $criteria = new CDbCriteria;

        $criteria->compare('evt_vendor', $this->evt_vendor);
        $criteria->compare('ev_event_id', $this->ev_event_id);
        $criteria->compare('evt_vendor_name', $this->evt_vendor_name, true);
        $criteria->compare('evt_vendor_email', $this->evt_vendor_email, true);
        $criteria->compare('evt_vendor_phone', $this->evt_vendor_phone, true);
        $criteria->compare('evt_vendor_role', $this->evt_vendor_role);
        $criteria->compare('is_status', $this->is_status, true);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('created_by', $this->created_by);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => PAGE_SIZE,
            )
        ));
    }

    protected function beforeValidate() {
        if ($this->isNewRecord) {
            $this->created_by = Yii::app()->user->id;
        }
        return parent::beforeValidate();
    }

}
