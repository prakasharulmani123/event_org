<?php

/**
 * This is the model class for table "{{user}}".
 *
 * The followings are the available columns in table '{{user}}':
 * @property integer $user_id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $user_firstname
 * @property string $user_lastname
 * @property integer $role_id
 * @property string $user_email
 * @property string $user_phone
 * @property string $user_address
 * @property string $status
 * @property string $created_at
 * @property string $created_by
 * @property integer $modified_at
 * @property integer $modified_by
 *
 * The followings are the available model relations:
 * @property Role $role
 */
class User extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{user}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('username, user_firstname, role_id, user_email', 'required'),
            array('username, user_email', 'unique'),
            array('role_id, modified_at, modified_by', 'numerical', 'integerOnly' => true),
            array('username, user_firstname, user_lastname, user_phone', 'length', 'max' => 50),
            array('password_hash, password_reset_token', 'length', 'max' => 255),
            array('user_email', 'length', 'max' => 100),
            array('status', 'length', 'max' => 1),
            array('user_address, created_at, created_by', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('user_id, username, password_hash, password_reset_token, user_firstname, user_lastname, role_id, user_email, user_phone, user_address, status, created_at, created_by, modified_at, modified_by', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'role' => array(self::BELONGS_TO, 'Role', 'role_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'user_id' => 'User',
            'username' => 'Username',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'user_firstname' => 'Firstname',
            'user_lastname' => 'Lastname',
            'role_id' => 'Role',
            'user_email' => 'Email',
            'user_phone' => 'Phone',
            'user_address' => 'Address',
            'status' => 'Status',
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
     * @return User the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function dataProvider() {
        $criteria = new CDbCriteria;

        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('username', $this->username, true);
        $criteria->compare('password_hash', $this->password_hash, true);
        $criteria->compare('password_reset_token', $this->password_reset_token, true);
        $criteria->compare('user_firstname', $this->user_firstname, true);
        $criteria->compare('user_lastname', $this->user_lastname, true);
        $criteria->compare('role_id', $this->role_id);
        $criteria->compare('user_email', $this->user_email, true);
        $criteria->compare('user_phone', $this->user_phone, true);
        $criteria->compare('user_address', $this->user_address, true);
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

}
