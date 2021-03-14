<?php
namespace frontend\controllers;

use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\data\ActiveDataProvider;
use common\models\User;
use common\models\Meetings;
use common\models\Attendees;
use yii\helpers\ArrayHelper;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup', 'index', 'events' ,'addmeeting'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout','index', 'events' ,'addmeeting'],
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
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
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
        $activeUsers = User::find()->where(['isloggedin' => 1])->andWhere(['!=','id', Yii::$app->user->identity->id])->all();

        return $this->render('index', [
            'activeUsers' => $activeUsers,
        ]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $user = User::findOne(Yii::$app->user->identity->id);
            $user->isloggedin = 1;
            $user->save();
            return $this->goBack();
        } else {
            $model->password = '';

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
        $user = User::findOne(Yii::$app->user->identity->id);
        $user->isloggedin = 0;
        $user->save();
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    // public function actionContact()
    // {
    //     $model = new ContactForm();
    //     if ($model->load(Yii::$app->request->post()) && $model->validate()) {
    //         if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
    //             Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
    //         } else {
    //             Yii::$app->session->setFlash('error', 'There was an error sending your message.');
    //         }

    //         return $this->refresh();
    //     } else {
    //         return $this->render('contact', [
    //             'model' => $model,
    //         ]);
    //     }
    // }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    // public function actionAbout()
    // {
    //     return $this->render('about');
    // }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    // public function actionRequestPasswordReset()
    // {
    //     $model = new PasswordResetRequestForm();
    //     if ($model->load(Yii::$app->request->post()) && $model->validate()) {
    //         if ($model->sendEmail()) {
    //             Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

    //             return $this->goHome();
    //         } else {
    //             Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
    //         }
    //     }

    //     return $this->render('requestPasswordResetToken', [
    //         'model' => $model,
    //     ]);
    // }

    // /**
    //  * Resets password.
    //  *
    //  * @param string $token
    //  * @return mixed
    //  * @throws BadRequestHttpException
    //  */
    // public function actionResetPassword($token)
    // {
    //     try {
    //         $model = new ResetPasswordForm($token);
    //     } catch (InvalidArgumentException $e) {
    //         throw new BadRequestHttpException($e->getMessage());
    //     }

    //     if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
    //         Yii::$app->session->setFlash('success', 'New password saved.');

    //         return $this->goHome();
    //     }

    //     return $this->render('resetPassword', [
    //         'model' => $model,
    //     ]);
    // }

    // *
    //  * Verify email address
    //  *
    //  * @param string $token
    //  * @throws BadRequestHttpException
    //  * @return yii\web\Response
     
    // public function actionVerifyEmail($token)
    // {
    //     try {
    //         $model = new VerifyEmailForm($token);
    //     } catch (InvalidArgumentException $e) {
    //         throw new BadRequestHttpException($e->getMessage());
    //     }
    //     if ($user = $model->verifyEmail()) {
    //         if (Yii::$app->user->login($user)) {
    //             Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
    //             return $this->goHome();
    //         }
    //     }

    //     Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
    //     return $this->goHome();
    // }

    // /**
    //  * Resend verification email
    //  *
    //  * @return mixed
    //  */
    // public function actionResendVerificationEmail()
    // {
    //     $model = new ResendVerificationEmailForm();
    //     if ($model->load(Yii::$app->request->post()) && $model->validate()) {
    //         if ($model->sendEmail()) {
    //             Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
    //             return $this->goHome();
    //         }
    //         Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
    //     }

    //     return $this->render('resendVerificationEmail', [
    //         'model' => $model
    //     ]);
    // }

    public function actionEvents($start, $end)
    {
        $events = [];
        $user_id = (Yii::$app->request->get('user_id'))?Yii::$app->request->get('user_id'):Yii::$app->user->identity->id;
        $meetings = Meetings::find()->select('meetings.*,meeting_attendees.attendee_id')->innerJoin('meeting_attendees', 'meetings.id = meeting_attendees.meeting_id')->WHERE(['meetings.created_by' => $user_id])->orWhere(['meeting_attendees.attendee_id' => $user_id])->all();
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        foreach($meetings as $key => $meeting) {
            $events[] = ['id' => $meeting->id,
                'title' => $meeting->title,
                'start' => date("Y-m-d H:i:s",$meeting->start_date),
                'end' => date("Y-m-d H:i:s",$meeting->end_date),
                'overlap' => true,
                // 'editable' => true,
            ];

        }
        return $events;
    }

    public function actionAddmeeting()
    {
        $model = new Meetings();
        $modelAttendees = new Attendees();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) { 
            $attendees = $_POST['Attendees']['attendee_id'];
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                $model->date = strtotime($model->date);
                $model->start_time = strtotime($model->start_time);
                
                $start_date = date("Y-m-d",$model->date)." ".date("H:i:s",$model->start_time);
                $model->start_date = strtotime($start_date);
                $model->end_date = strtotime(date("Y-m-d H:i:s",(strtotime($start_date) + ($model->duration*60))));
                
                $meetingCount = Attendees::find()->select('meeting_attendees.*,meetings.created_by')->innerJoin('meetings', 'meetings.id = meeting_attendees.meeting_id')->WHERE(['IN', 'meeting_attendees.attendee_id',$attendees])->andWhere(['or',['between', 'meetings.start_date', $model->start_date, $model->end_date],['between', 'meetings.end_date', $model->start_date, $model->end_date]])->count();

                if($meetingCount == 0) {
                    $model->created_by = Yii::$app->user->identity->id;
                    $model->created_at = time();
                    $flag = $model->save(false);
                } else {
                    $flag = NULL;
                }

                foreach($attendees as $key => $attendee) {
                    $modelAttendees = new Attendees();
                    $modelAttendees->meeting_id = $model->id;
                    $modelAttendees->attendee_id = $attendee;
                    $flag = $modelAttendees->save(false);
                }

            } catch (Exception $e) {
                    $transaction->rollBack();
            }
            
            if ($flag) {
                $transaction->commit();
                $event = [];
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                $event[] = ['id' => $model->id,
                        'title' => $model->title,
                        'start' => date("Y-m-d H:i:s",$model->start_date),
                        'end' => date("Y-m-d H:i:s",$model->end_date),
                        'overlap' => true,
                        // 'editable' => true,
                ];
                
                return $event;
            } else {
                return 0;
            }
        }

             return $this->renderAjax('add-meeting', [
                'model' => $model,
                'modelAttendees' => $modelAttendees
        ]);
    }
}
