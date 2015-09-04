<?php

class EventController extends Controller {
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
                //'postOnly + delete', // we only allow deletion via POST request
        );
    }

    public function actions() {
        return array(
            'pdf' => 'application.components.actions.pdf',
            'download' => 'application.components.actions.download',
            'addTabularInputsAsTable' => array(
                'class' => 'application.extensions.actions.XTabularInputAction',
                'modelName' => 'EventLists',
                'viewName' => '_tabularInputAsTable',
            ),
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array(),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('index', 'view', 'create', 'update', 'admin', 'delete', 'pdf', 'download', 'addTabularInputsAsTable'),
                'expression' => 'UserIdentity::checkAccess()',
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array(''),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $model = $this->loadModel($id);
        $criteria = new CDbCriteria;
        $criteria->compare('event_id', $model->event_id);
        $list_dataprovider =  new CActiveDataProvider(EventLists::model(), array(
            'criteria' => $criteria,
            'pagination' => false
        ));

        $export = isset($_REQUEST['export']) && $_REQUEST['export'] == 'PDF';
        $compact = compact('model', 'export', 'list_dataprovider');
        if ($export) {
            $mPDF1 = Yii::app()->ePdf->mpdf();
            $stylesheet = $this->pdfStyles();
            $mPDF1->WriteHTML($stylesheet, 1);
            $mPDF1->WriteHTML($this->renderPartial('view', $compact, true));
            $mPDF1->Output("Event_view_{$id}.pdf", EYiiPdf::OUTPUT_TO_DOWNLOAD);
        } else {
            $this->render('view', $compact);
        }
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Event;
        $lists[0] = new EventLists;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation(array($model, $lists[0]));
//        $this->MyperformAjaxValidation($model, $lists[0]);

        if (isset($_POST['Event'])) {
            $model->attributes = $_POST['Event'];
            if ($model->save()) {
                foreach ($_POST['EventLists'] as $key => $list_vals) {
                    $list = new EventLists;
                    $list->event_id = $model->event_id;
                    $list->attributes = $list_vals;
                    $list->save();
                }
                Yii::app()->user->setFlash('success', 'Event Created Successfully!!!');
                $this->redirect(array('/site/event/index'));
            }
        }

        $this->render('create', compact('model', 'lists'));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $lists = $model->eventlists;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation(array($model));

        if (isset($_POST['Event'])) {
            $model->attributes = $_POST['Event'];
            if ($model->save()) {
                EventLists::model()->deleteAllByAttributes(array('event_id' => $model->event_id));
                foreach ($_POST['EventLists'] as $key => $list_vals) {
                    $list = new EventLists;
                    $list->event_id = $model->event_id;
                    $list->attributes = $list_vals;
                    $list->save();
                }
                Yii::app()->user->setFlash('success', 'Event Updated Successfully!!!');
                $this->redirect(array('/site/event/index'));
            }
        }

        $this->render('update', compact('model', 'lists'));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        try {
            $model = $this->loadModel($id);
            $model->delete();
        } catch (CDbException $e) {
            if ($e->errorInfo[1] == 1451) {
                throw new CHttpException(400, Yii::t('err', 'Relation Restriction Error.'));
            } else {
                throw $e;
            }
        }

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            Yii::app()->user->setFlash('success', 'Event Deleted Successfully!!!');
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('/site/event/index'));
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new Event();
        $model->unsetAttributes();
        if (isset($_GET['Event'])) {
            $model->attributes = $_GET['Event'];
        }
        $this->render('index', compact('model'));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Event('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Event']))
            $model->attributes = $_GET['Event'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Event the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Event::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Event $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'event-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    protected function MyperformAjaxValidation($model, $tabularModal) {
        if (isset($_POST['ajax']) /*&& $_POST['ajax'] === 'event-form'*/) {
            $model = CJSON::decode(CActiveForm::validate($model));
            $cupons = CJSON::decode(CActiveForm::validateTabular($tabularModal));
            echo CJSON::encode(CMap::mergeArray($model, $cupons));
            Yii::App()->end();

//            $tabort = array("{", "}");
//            $tmp_model = str_replace($tabort, "", CActiveForm::validate($model));
//            $tmp_cupons = str_replace($tabort, "", CActiveForm::validateTabular($tabularModal));
//
//            echo "{" . $tmp_model . ", " . $tmp_cupons . "}";
//            Yii::app()->end();
        }
    }

}
