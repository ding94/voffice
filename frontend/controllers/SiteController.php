<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use common\models\Contact;
use common\models\User\User;
use common\models\Package;
use common\models\User\UserBalance;
use common\models\Banner;
use common\models\AuthFb;
use yii\helpers\Url;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public $successUrl ='Success';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'auth' => [
              'class' => 'yii\authclient\AuthAction',
              'successCallback' => [$this, 'oAuthSuccess'],
            ],
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Contact();
        $package = Package::find()->all();
        $banner = Banner::find()->where(['<=','startTime',date("Y-m-d H:i:s")])->andWhere(['>=','endTime',date("Y-m-d H:i:s")])->all();
        if (Yii::$app->request->isPost) {
			$post = Yii::$app->request->post();
            if ($model->add($post)) {
                self::actionSendTicket($model->username, $model->email);
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

           
        } 
            return $this->render('indextest', [
                'model' => $model,
                'package' => $package,
                'banner' => $banner,
            ]);
		
		
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        $this->layout = 'main2';
		
		if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
		
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        
    }
    public function actionTopup()
    {
           
       
        return $this->render("topup",['model' => $model]);
    }
    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
		 $this->layout = 'main2';
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                $email = \Yii::$app->mailer->compose(['html' => 'confirmLink-html','text' => 'confirmLink-text'],//html file, word file in email
                    ['id' => $user->id, 'auth_key' => $user->auth_key])//pass value)
                ->setTo($user->email)
                ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name])
                ->setSubject('Signup Confirmation')
                ->send();
                if($email){
                    if (Yii::$app->getUser()->login($user)) {
                        Yii::$app->getSession()->setFlash('success','Verification email sent! Kindly check email and validate your account.');
                        return $this->render('validation');
                    }
                }
                else{
                Yii::$app->getSession()->setFlash('warning','Failed, contact Admin!');
                }
                return $this->goHome();
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionResendconfirmlink()
    {
        $email = \Yii::$app->mailer->compose(['html' => 'confirmLink-html'],//html file, word file in email
                    ['id' => Yii::$app->user->identity->id, 'auth_key' => Yii::$app->user->identity->auth_key])//pass value)
                ->setTo(Yii::$app->user->identity->email)
                ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name])
                ->setSubject('Signup Confirmation')
                ->send();
                if($email){
                    Yii::$app->getSession()->setFlash('success','Verification email sent! Kindly check email and validate your account.');
                    return $this->render('validation');
                } else{
                    Yii::$app->getSession()->setFlash('warning','Failed, contact Admin!');
                }
                return $this->render('validation');
    }

    public function actionConfirm()
    {   
        $id = Yii::$app->request->get('id');
        $key = Yii::$app->request->get('auth_key');
        $user = User::find()->where([
        'id'=>$id,
        'auth_key'=>$key,
        'status'=>1,
        ])->one();

        $balance = new UserBalance();

        if(!empty($user)){
            $user->status=10;
            $user->save();

            $balance->uid = $id;
            $balance->balance = 0;
            $balance->negative = 0;
            $balance->positive = 0;
            $balance->save();
            Yii::$app->getSession()->setFlash('success','Success!');
            if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
            }
        } else{
            Yii::$app->getSession()->setFlash('warning','Failed!');
            return $this->goHome();
        }

    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionSendTicket($username,$email)
    {

        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'guestSubmitTicket-html', 'text' => 'guestSubmitTicket-text'],//html file, word file in email
                ['username' => $username]//pass value
            )
            ->setFrom([Yii::$app->params['supportEmail']])//from who
            ->setTo($email)//to who
            ->setSubject('Ticket Submitted to Virtual Office!')//subject
            ->send();
    }

    public function actionValidation()
    {
        return $this->render('validation');
    }

  public function oAuthSuccess($client)
    {
       $attributes = $client->getUserAttributes();

        /** @var Auth $auth */
        $auth = AuthFb::find()->where([
            'source' => $client->getId(),
            'source_id' => $attributes['id'],
        ])->one();

        if (Yii::$app->user->isGuest) {
            if ($auth) { // login
                $user = User::find()->where(['id' => $auth->user_id])->one();
                Yii::$app->user->login($user);
                $this->successUrl = Url::to(['index']);
            } else { // signup
                if (User::find()->where(['email' => $attributes['email']])->exists()) {
                    Yii::$app->getSession()->setFlash('error', [
                        Yii::t('app', "User with the same email as in {client} account already exists but isn't linked to it. Login using email first to link it.", ['client' => $client->getTitle()]),
                    ]);
                } else {
                    $user = new User([
                        'username' => $attributes['name'],
                        'email' => $attributes['email'],
                    ]);
                    $user->generateAuthKey();
                    $transaction = $user->getDb()->beginTransaction();
                    if ($user->save()) {
                        $auth = new AuthFb([
                            'user_id' => $user->id,
                            'source' => $client->getId(),
                            'source_id' => (string)$attributes['id'],
                        ]);
                        $balance = self::newBalance($user);
                        if ($auth->save() && $balance->save()) {
                            $transaction->commit();
                            Yii::$app->user->login($user);
                            $this->successUrl = Url::to(['index']);
                        } else {
                            print_r($auth->getErrors());
                        }
                    } else {
                        print_r($user->getErrors());
                    }
                }
            }
        } else { // user already logged in
            if (!$auth) { // add auth provider
                $auth = new AuthFb([
                    'user_id' => Yii::$app->user->id,
                    'source' => $client->getId(),
                    'source_id' => $attributes['id'],
                ]);
                $auth->save();
            }
        }
    }

  public static function newUser($attribute){
    $user = new User();
    $user->username = $attribute['name'];
    $user->email = $attribute['email'];
    $user->fb_status = 1;
    $user->status = 10;
    return $user;
  }

  public static function newBalance($user){
    $balance = new UserBalance();
    $balance->uid = $user->id;
    $balance->balance = 0;
    $balance->negative = 0;
    $balance->positive = 0;
    return $balance;
  }
    
}
