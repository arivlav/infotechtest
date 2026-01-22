<?php

class AuthorController extends Controller
{
    public $layout = '//layouts/column1';

    public function accessRules(): array
    {
        return [
            ['allow', // allow authenticated users to perform CRUD
                'actions' => ['index', 'view', 'create', 'update', 'admin', 'delete'],
                'users' => ['@'],
            ],
            ['deny',  // deny all users
                'users' => ['*'],
            ],
        ];
    }

    public function actionIndex(): void
    {
        $data = new IndexAuthorAction()->execute();
        $this->render('index', $data);
    }

    public function actionView(int $id)
    {
        $data = new ViewAuthorAction()->execute($id);
        $this->render('view', $data);
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        [$newId, $data] = new CreateAuthorAction()->execute();
        if ($newId) {
            $this->redirect(['view', 'id' => $newId]);
        }
        $this->render('create', $data);
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        [$isRedirect, $data] = new UpdateAuthorAction()->execute($id);
        if ($isRedirect) {
            $this->redirect(['view', 'id' => $id]);
        }
        $this->render('update', $data);
    }

    public function actionDelete(int $id)
    {
        if (Yii::app()->request->isPostRequest) {
            new DeleteAuthorAction()->execute($id);
            if (!isset($_GET['ajax'])) {
                $this->redirect($_POST['returnUrl'] ?? ['index']);
            }
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

}

