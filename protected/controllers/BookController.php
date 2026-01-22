<?php
class BookController extends Controller
{
    public function accessRules(): array
    {
        return [
            ['allow',
                'actions' => ['index', 'view', 'topAuthors'],
                'users' => ['*'],
            ],
            ['allow',
                'actions' => ['create', 'update', 'admin', 'delete'],
                'users' => ['@'],
            ],
            ['deny',
                'users' => ['*'],
            ],
        ];
    }

    public function actionIndex(): void
    {
        $data = new IndexBookAction()->execute();
        $this->render('index', $data);
    }

    public function actionView($id)
    {
        $data = new ViewBookAction()->execute($id);
        $this->render('view', $data);
    }

    public function actionCreate()
    {
        [$newId, $data] = new CreateBookAction()->execute();
        if ($newId) {
            $this->redirect(['view', 'id' => $newId]);
        }
        $this->render('create', $data);
    }

    public function actionUpdate($id)
    {
        [$isRedirect, $data] = new UpdateBookAction()->execute($id);
        if ($isRedirect) {
            $this->redirect(['view', 'id' => $id]);
        }
        $this->render('update', $data);
    }

    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest) {
            new DeleteBookAction()->execute($id);
            if (!isset($_GET['ajax'])) {
                $this->redirect(['index']);
            }
        } else {
            throw new CHttpException(400, 'Invalid request.');
        }
    }

    public function actionTopAuthors(): void
    {
        $data = new TopAuthorsBookAction()->execute();
        $this->render('topAuthors', $data);
    }
}

