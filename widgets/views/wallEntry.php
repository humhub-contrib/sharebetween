<?php

// use yii\helpers\Html;
use humhub\libs\Html;
use humhub\modules\space\models\Space;
use humhub\modules\user\models\User;
use humhub\modules\content\components\ContentContainerController;
use humhub\modules\content\widgets\WallEntry;
use humhub\modules\content\widgets\WallEntryControls;

//$user = $object->content->user;
$container = $object->content->container;
$sharedContent = $object->sharedContent->getPolymorphicRelation();
?>

<div class="panel panel-default wall_<?php echo $object->getUniqueId(); ?>">
    <div class="panel-body">
        <div class="media">
            <!-- since v1.2 -->
            <div class="stream-entry-loader"></div>

            <!-- start: show wall entry options -->
            <?php if ($renderControls) : ?>
                <?= WallEntryControls::widget(['object' => $object, 'wallEntryWidget' => $wallEntryWidget]); ?>
            <?php endif; ?>
            <!-- end: show wall entry options -->

            <div class="media-body">
                <div class="media-heading">
                    <?= Yii::t('SharebetweenModule.base',
                        '{displayName} shared a {contentType}',
                        [
                            'displayName' => Html::a($user->displayName, $user->getUrl(), ['style' => 'color: #e5c150']),
                            'contentType' => Html::a($sharedContent->getContentName(), $sharedContent->content->getUrl())
                        ]
                    ); ?>
                    <?php if ($container): ?>
                        <span class="viaLink">
                            <i class="fa fa-caret-right" aria-hidden="true"></i>
                            <?= Html::containerLink($container); ?>
                        </span>
                    <?php endif; ?>

                </div>
            </div>

            <hr/>

            <div class="content" id="wall_content_<?php echo $object->getUniqueId(); ?>">
                <?php echo $content; ?>
            </div>

        </div>
    </div>

</div>
