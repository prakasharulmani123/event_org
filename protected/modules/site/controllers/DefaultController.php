<?php

/**
 * Site controller
 */
class DefaultController extends Controller {

    public $layout = '//layouts/column1';

    /**
     * @array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    public function actions() {
        return array(
            'download' => 'application.components.actions.download',
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('login', 'error', 'request-password-reset', 'screens', 'dailycron', 'testmail'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('logout', 'index', 'profile'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'actions' => array('invoice'),
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex() {
        $this->render('index');
    }

    public function actionInvoice() {
        $mail = new Sendmail;
        $trans_array = array(
            "{SITENAME}" => SITENAME,
            "{USERNAME}" => 'Prakash',
            "{EMAIL_ID}" => 'prakash.paramanandam@arkinfotec.com',
        );
        $message = $mail->getMessage('invoice', $trans_array);
        $Subject = $mail->translate('{SITENAME}: : Reminder');
        $mail->send('prakash.paramanandam@arkinfotec.com', $Subject, $message);
        $this->render('invoice');
    }

    public function actionLogin() {
        $this->layout = '//layouts/login';
        if (!Yii::app()->user->isGuest) {
            $this->goHome();
        }
        $model = new LoginForm();
        $forgot_model = new LoginForm('forgotpass');
        
        $this->performAjaxValidation(array($model, $forgot_model));

        if (isset($_POST['LoginForm']) && !isset($_POST['forgot'])) {
            $model->attributes = $_POST['LoginForm'];
            if ($model->validate() && $model->login()):
                if(UserIdentity::checkAdmin())
                    $this->goHome();
                else
                    $this->redirect(array('/site/event/index'));
            endif;
        }else if (isset($_POST['forgot'])) {
            $user = User::model()->findByAttributes(array('user_email' => $_POST['LoginForm']['email']));
            if (empty($user)) {
                Yii::app()->user->setFlash('danger', 'This Email Address Not Exists!!!');
                $this->refresh();
            } else {
                $reset_link = Myclass::getRandomString(25);
                $user->setAttribute('password_reset_token', $reset_link);
//                $user->setAttribute('modified_at', new CDbExpression('NOW()'));
                $user->save(false);

                ///////////////////////
                $time_valid = date('Y-m-d H:i:s');
                $resetlink = Yii::app()->createAbsoluteUrl('/site/default/reset?str=' . $user->password_reset_token . '&id=' . $user->user_id);
                if (!empty($user->user_email)):
                    //$loginlink = Yii::app()->createAbsoluteUrl('/site/default/login');
                    $mail = new Sendmail;
                    $trans_array = array(
                        "{SITENAME}" => SITENAME,
                        "{USERNAME}" => $user->username,
                        "{EMAIL_ID}" => $user->user_email,
                        "{NEXTSTEPURL}" => $resetlink,
                        "{TIMEVALID}" => $time_valid,
                    );
                    $message = $mail->getMessage('forgot_password', $trans_array);
                    $Subject = $mail->translate('{SITENAME}: Reset Password');
                    $mail->send($user->user_email, $Subject, $message);
                endif;

                Yii::app()->user->setFlash('success', "Your Password Reset Link sent to your email address.");
                $this->redirect(array('/site/default/login'));
            }
        }

        $this->render('login', array('model' => $model, 'forgot_model' => $forgot_model));
    }

    public function actionReset($str, $id) {
        $this->layout = '//layouts/login';
        if (!Yii::app()->user->isGuest)
            $this->redirect(array('/site/default/index'));

        $model = User::model()->findByPk($id);
        if (empty($model) || $model->password_reset_token != $str) {
            Yii::app()->user->setFlash('danger', "Not a valid Reset Link");
            $this->redirect(array('/site/default/login'));
        } else {
            $start = strtotime(date('Y-m-d H:i:s', strtotime($model->modified_at)));
            $end = strtotime(date('Y-m-d H:i:s'));
            $seconds = $end - $start;
            $days = floor($seconds / 86400);
            $hours = floor(($seconds - ($days * 86400)) / 3600);
            $minutes = floor(($seconds - ($days * 86400) - ($hours * 3600)) / 60);
            
            if ($minutes > 5) {
                Yii::app()->user->setFlash('danger', "This Reset Link Expired. Please Try again.");
                $this->redirect(array('/site/default/login'));
            }
        }

        $model->setScenario('reset');
        $this->performAjaxValidation($model);
        if (isset($_POST['reset'])) {
            $model->setAttribute('password_hash', Myclass::encrypt($_POST['User']['new_password']));
            $model->setAttribute('password_reset_token', '');
            $model->save(false);
            Yii::app()->user->setFlash('success', "Your Password Changed Successfully.");
            $this->redirect(array('/site/default/login'));
        }
        $this->render('reset', array('model' => $model));
    }
    
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(array('/site/default/login'));
    }

    public function actionRequestPasswordReset() {
        $model = new PasswordResetRequestForm();
        if (isset($_POST['PasswordResetRequestForm'])) {
            $model->attributes = $_POST['PasswordResetRequestForm'];
            if ($model->validate()):
                if ($model->sendEmail()) {
                    Yii::app()->user->setFlash('success', 'Check your email for further instructions.');
                    $this->goHome();
                } else {
                    Yii::app()->user->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
                }
            endif;
        }

        $this->render('requestPasswordResetToken', array(
            'model' => $model,
        ));
    }

    public function actionResetPassword($token) {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if (isset($_POST['ResetPasswordForm'])) {
            $model->attributes = $_POST['ResetPasswordForm'];
            if ($model->validate() && $model->resetPassword()):
                Yii::app()->user->setFlash('success', 'New password was saved.');
                $this->goHome();
            endif;
        }

        $this->render('resetPassword', array(
            'model' => $model,
        ));
    }

    public function actionProfile() {
        $id = Yii::app()->user->id;
        $model = User::model()->findByPk($id);
        $model->setScenario('update');
        $this->performAjaxValidation($model);

        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            if ($model->validate()):
                $model->save(false);
                Yii::app()->user->setFlash('success', 'Profile updated successfully');
                $this->refresh();
            endif;
        }
        $this->render('profile', compact('model'));
    }

    public function actionError() {
        $this->layout = 'error';
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest) {
                echo $error['message'];
                Yii::app()->end();
            } else {
                $name = Yii::app()->errorHandler->error['code'] . ' Error';
                $message = Yii::app()->errorHandler->error['message'];
                $this->render('error', compact('error', 'name', 'message'));
            }
        }
    }

    public function actionScreens($path) {
        if ($path) {
            $this->render('screens', compact('path'));
        }
    }

    public function actionDailycron() {
        
    }

    public function actionTestmail() {
        $mail = new Sendmail;
        $message = "test";
        $subject = "Tetss";

        try {
            mail("prakash.paramanandam@arkinfotec.com","My subject","Test");
        } catch (Exception $exc) {
            echo 'fail';
            echo $exc->getTraceAsString();
        }
        exit;


        var_dump($mail->send('prakash.paramanandam@arkinfotec.com', $subject, $message));
        exit;
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax'])) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
