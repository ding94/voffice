<?php
namespace common\models\user;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\data\ActiveDataProvider;
use common\models\User\UserDetails;
use common\models\User\UserCompany;
use common\models\Parcel\Parcel;
/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_UNVERIFIED = 1;
    const STATUS_ACTIVE = 10;
    public $loginname;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE,self::STATUS_UNVERIFIED, self::STATUS_DELETED]],
            ['email' , 'unique'],
            [['username' ,'userdetails.fullname'] ,'safe'],
        ];
    }
	
	public function attributeLabels()
    {
        return [
            'username' => 'Username',
            
        ];
    }

    // public function login($data)
    // {
    //     $this->scenario = "login";
    //     if ($this->load($data) && $this->validate())
    //     {
    //         $session = Yii::$app->session;
    //         $session['loginname'] = $this->loginname;
    //         $session['isLogin'] = 1;
    //         return (bool)$session['isLogin'];
    //     }
    //     return false;
    // }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::find()->where('id = :id',[':id' => $id])->andWhere(['between', 'status', self::STATUS_UNVERIFIED, self::STATUS_ACTIVE])->one();
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::find()->where('username = :username',[':username' => $username])->andWhere(['between', 'status', self::STATUS_UNVERIFIED, self::STATUS_ACTIVE])->one();
      }
  
      /**

    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        if ($this->password == null) {
            return false;
        }else{
            return Yii::$app->security->validatePassword($password, $this->password_hash);
        }
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function getPassword()
    {
        return '';
    }

    public function getUserdetail()
    {
        //用来获得 UserDetails 的 uid 用 user id
         return $this->hasOne(UserDetails::className(), ['uid' => 'id']); // hasone 获得object, hasmany 获得 array
    }

    public function getUsercompany()
    {
        return $this->hasOne(UserCompany::className(),['uid' => 'id']);
    }

     public function getParcel()
    {
        return $this->hasOne(Parcel::className(),['uid' => 'id']);
    }
}
