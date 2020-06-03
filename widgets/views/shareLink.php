<?php
/* @var $this humhub\components\View */

use yii\helpers\Url;
?>

<?php if (!Yii::$app->user->isGuest): ?>
    <span class="likeLinkContainer" id="likeLinkContainer_<?= $id ?>">
        <a href="<?=Url::to(['/sharebetween/share', 'id' => $id]); ?>" data-target="#globalModal">
            <?= Yii::t('SharebetweenModule.base', 'Share'); ?>
            <?php
            /*
            echo Yii::t('LikeModule.widgets_views_likeLink', 'Like');
            */
            ?>
        </a>
    </span>
<?php endif; ?>
