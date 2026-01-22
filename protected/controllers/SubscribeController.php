<?php

class SubscribeController extends Controller
{
    public function accessRules(): array
    {
        return [
            ['allow',
                'actions' => ['subscribe'],
                'users' => ['*'],
            ],
            ['deny',
                'users' => ['*'],
            ],
        ];
    }

    public function actionSubscribe(): void
    {
        [$success, $message, $data] = new SubscribeSubscribeAction()->execute();

        if (Yii::app()->request->isAjaxRequest) {
            header('Content-Type: application/json');
            echo json_encode($data);
            Yii::app()->end();
        } else {
            if ($success) {
                Yii::app()->user->setFlash('subscription', $message);
            }
            $this->redirect(['index']);
        }
    }
}

