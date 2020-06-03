<?php

namespace humhub\modules\sharebetween\models;

use Yii;
use humhub\modules\content\components\ContentActiveRecord;
use humhub\modules\content\models\Content;
use humhub\modules\content\components\ContentContainerActiveRecord;
use humhub\modules\content\models\ContentContainer;
use humhub\modules\user\models\User;
use humhub\modules\space\models\Space;

class Share extends ContentActiveRecord
{

    public $wallEntryClass = 'humhub\modules\sharebetween\widgets\StreamEntry';
    public $autoAddToWall = true;

    public static function tableName()
    {
        return 'sharebetween_share';
    }

    public function rules()
    {
        return array(
            [['content_id'], 'required'],
        );
    }

    public function getSharedContent()
    {
        return $this->hasOne(Content::className(), ['id' => 'content_id']);
    }

    public static function createShareToUserProfile(Content $content, ContentContainerActiveRecord $container)
    {
        if (self::hasShare($content, $container)) {
            // throw new \yii\web\HttpException(400, 'Shared!');
            return false;
        } else {

            $share = new self;
            $share->content_id = $content->id;

            $share->content->setContainer($container);
 
            $share->save();

            return true;
        }
    }

    public static function createShareToSpace(Content $content, Space $container)
    {
        // if (self::hasShareSpace($content, $container)) {
        //     // throw new \yii\web\HttpException(400, 'Shared!');
        //     return false;
        // } else {

            $share = new self;
            $share->content_id = $content->id;

            Yii::error('space active recored begin to instantiate.'.$container->id);
            $share->content->setContainer($container);            

            $share->save();

            return true;
        // }
    }

    public static function hasShare(Content $content, ContentContainerActiveRecord $container)
    {
        $share = Share::find()->joinWith('content')->where(['sharebetween_share.content_id' => $content->id, 'content.contentcontainer_id' => $container->id])->one();
        if ($share !== null) {
            return true;
        }

        return false;
    }

    public static function deleteShare(Content $content, ContentContainerActiveRecord $container)
    {
        $shares = Share::find()->joinWith('content')->where(['sharebetween_share.content_id' => $content->id, 'content.contentcontainer_id' => $container->id])->all();
        foreach ($shares as $share) {
            $share->delete();
        }
    }



}
