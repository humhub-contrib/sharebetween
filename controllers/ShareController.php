<?php

namespace humhub\modules\sharebetween\controllers;

use Yii;
use humhub\modules\content\models\Content;
use humhub\modules\sharebetween\models\ShareForm;
use humhub\modules\sharebetween\models\Share;

class ShareController extends \humhub\components\Controller
{

    public function actionIndex()
    {
        $model = new ShareForm();
        $content = Content::findOne(['id' => Yii::$app->request->get('id')]);

        if (!$content->canView()) {
            // throw new \yii\web\HttpException('400', 'Permission denied!');
            return $this->renderAjax('refused');
        }

        if (Yii::$app->request->isPost) {
            if (Yii::$app->request->get('self') == 1) {
                        // Yii::Error($content);
                        // Yii::Error(Yii::$app->user->getIdentity());
                if (Share::createShareToUserProfile($content, Yii::$app->user->getIdentity())) {
                    return $this->renderAjax('success');
                } else {
                    return $this->renderAjax('already');
                }
            } else {
                if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                    $counter = 0;
                    foreach ($model->getSpaceContentContainer() as $spaceContainer) {
                        // Yii::Error(var_dump($content));
                        // Yii::Error(var_dump($spaceContainer));

                        // Yii::Error('Begin try to share the post on Another Space.');
                        if (Share::createShareToSpace($content, $spaceContainer)) {
                            $counter += 1;
                        }
                    }
                    if ($counter>0) {
                        return $this->renderAjax('success');
                    } else {
                        return $this->renderAjax('already');
                    }
                }
            }
        }


        return $this->renderAjax('index', ['content' => $content, 'model' => $model]);
    }

}
