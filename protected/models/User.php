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
 * @property string $user_company
 * @property string $user_address
 * @property string $user_avatar
 * @property string $status
 * @property string $created_at
 * @property string $created_by
 * @property integer $modified_at
 * @property integer $modified_by
 *
 * The followings are the available model relations:
 * @property EventVendors[] $eventVendors
 * @property Role $role
 */
class User extends RActiveRecord {

    public $new_password;
    public $confirm_password;

    const FILE_SIZE = 5;

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
            array('username, user_firstname', 'required'),
            array('role_id, user_email, user_phone', 'required', 'on' => 'user_create, user_update'),
            array('username, user_email', 'unique'),
            array('user_email', 'email'),
            array('role_id, created_by, modified_by, user_phone', 'numerical', 'integerOnly' => true),
            array('username, user_firstname, user_lastname, user_phone', 'length', 'max' => 50),
            array('password_hash, password_reset_token', 'length', 'max' => 255),
            array('user_email, user_company', 'length', 'max' => 100),
            array('status', 'length', 'max' => 1),
            array('new_password, confirm_password', 'length', 'min' => 6),
            array('confirm_password', 'compare', 'compareAttribute' => 'new_password', 'on' => 'reset,update,user_update'),
            array('new_password, confirm_password', 'required', 'on' => 'reset'),
            array('user_avatar', 'length', 'max' => 1000),
            array('user_avatar', 'file', 'allowEmpty' => true, 'maxSize' => 1024 * 1024 * self::FILE_SIZE, 'tooLarge' => 'File should be smaller than ' . self::FILE_SIZE . 'MB'),
            array('user_address, created_at, created_by, confirm_password, new_password,user_avatar', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('user_id, username, password_hash, password_reset_token, user_firstname, user_lastname, role_id, user_email, user_phone,user_company, user_address, status, created_at, created_by, modified_at, modified_by,user_avatar', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'eventVendors' => array(self::HAS_MANY, 'EventVendors', 'evt_user_id'),
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
            'user_firstname' => 'First Name',
            'user_lastname' => 'Lastname',
            'role_id' => 'Category',
            'user_email' => 'Email',
            'user_phone' => 'Phone',
            'user_company' => 'Company Name',
            'user_address' => 'Address',
            'user_avatar' => 'Avatar',
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
        $criteria->compare('user_company', $this->user_company, true);
        $criteria->compare('user_address', $this->user_address, true);
        $criteria->compare('user_avatar', $this->user_avatar, true);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('created_by', $this->created_by, true);
        $criteria->compare('modified_at', $this->modified_at);
        $criteria->compare('modified_by', $this->modified_by);

        $criteria->addNotInCondition('role_id', array(1));

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => PAGE_SIZE,
            )
        ));
    }

    public function behaviors() {
        return array(
            'NUploadFile' => array(
                'class' => 'ext.nuploadfile.NUploadFile',
                'fileField' => 'user_avatar',
            )
        );
    }

    protected function afterValidate() {
        if ($this->scenario == 'user_update' && !empty($this->confirm_password)) {
            $this->password_hash = Myclass::encrypt($this->confirm_password);
        }

        $this->setUploadDirectory(UPLOAD_DIR);
        $this->uploadFile();

        return parent::afterValidate();
    }

    public function getFullname() {
        return ucwords($this->user_firstname . ' ' . $this->user_lastname);
    }

}
