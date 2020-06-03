<?php

use yii\bootstrap\ActiveForm;
use humhub\widgets\ModalDialog;
use humhub\modules\space\widgets\SpacePickerField;
use humhub\libs\Html;


?>
<div class="modal-dialog modal-dialog-small animated fadeIn">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">
                <?= Yii::t('SharebetweenModule.base', '<strong>Share</strong> content'); ?>
            </h4>
        </div>
        <div class="modal-body">

            <br/>
            <div class="text-center">
                <ul id="tabs" class="nav nav-tabs tabs-center" data-tabs="tabs">
                    <li class="active tab-internal">
                        <a href="#internal"  data-toggle="tab">
                            <?= Yii::t('SharebetweenModule.base', 'On space'); ?>
                        </a>
                    </li>
                    <li class="tab-external">
                        <a href="#share_profile" data-toggle="tab">
                            <?= Yii::t('SharebetweenModule.base', 'On your profile'); ?>
                        </a>
                    </li>
                </ul>
            </div>
            <br/>

            <div class="tab-content">
                <div class="tab-pane active" id="internal">
                    <?php $form = ActiveForm::begin([
                        'id' => 'post-share-modal-form',
                    ]); ?>

                    <?= Yii::t('SharebetweenModule.base', 'To share this content with other spaces, please type their names below to find and pick them.'); ?>

                    <br/><br/>

                    <!--  $form->field($model, 'space')->textInput(['id' => 'invite'])->label(false);   -->

                    <?= SpacePickerField::widget([
                        // 'id' => 'invite',
                        // 'form' => $form,
                        'model' => $model,
                        'attribute' => 'Spaces_GUIDs',
                        // 'name' => 'post-share-modal-form',
                        'focus' => true,
                        'maxSelection' => $model->maxSelection,
                    ]);
                    ?>


                    <?php $form->field($model, 'Spaces_GUIDs')->widget(SpacePickerField::class, ['id' => 'invite'])->label(false);  ?>


                        <script <?= Html::nonce() ?>>
                            // Shake modal after wrong validation
                            <?php if ($model->hasErrors()) : ?>
                                    $('.modal-dialog').removeClass('fadeIn');
                                    $('.modal-dialog').addClass('shake');

                                    // check if there is an error at the second tab
                                <?php if ($model->hasErrors('inviteExternal')) : ?>
                                        // show tab external tab
                                        $('#tabs a:last').tab('show');
                                <?php endif; ?>

                            <?php endif; ?>

                            $('.tab-internal a').on('shown.bs.tab', function (e) {
                                $('#invite').focus();
                            });

                            $('.tab-external a').on('shown.bs.tab', function (e) {
                                // $('#email_invite').focus();
                            });

                        </script>

                    <div class="modal-footer">

                        <?= \humhub\widgets\AjaxButton::widget([
                            'label' => Yii::t('SharebetweenModule.base', 'Share'),
                            'ajaxOptions' => [
                                'type' => 'POST',
                                'beforeSend' => new yii\web\JsExpression('function(){ setModalLoader(); }'),
                                'success' => new yii\web\JsExpression('function(html){ $("#globalModal").html(html); }'),
                                'url' => yii\helpers\Url::to(['/sharebetween/share/index', 'id' => $content->id, 'self' => 0]),
                            ],
                            'htmlOptions' => [
                                'class' => 'btn btn-primary'
                            ]
                        ]);
                        ?>
                        <button type="button" class="btn btn-primary"
                                data-dismiss="modal"><?= Yii::t('SharebetweenModule.base', 'Cancel'); ?></button>
                    </div>                    
                    <?php ActiveForm::end(); ?>

                </div>
               
                <div class="tab-pane" id="share_profile">
                    <?php $form = ActiveForm::begin(); ?>
                    <?= Yii::t('SharebetweenModule.base', 'Share this content directly on your profile.'); ?>
                    <br/><br/>

                    <div class="modal-footer">

                        <?= \humhub\widgets\AjaxButton::widget([
                            'label' => Yii::t('SharebetweenModule.base', 'Share'),
                            'ajaxOptions' => [
                                'type' => 'POST',
                                'beforeSend' => new yii\web\JsExpression('function(){ setModalLoader(); }'),
                                'success' => new yii\web\JsExpression('function(html){ $("#globalModal").html(html); }'),
                                'url' => yii\helpers\Url::to(['/sharebetween/share/index', 'id' => $content->id, 'self' => 1]),
                            ],
                            'htmlOptions' => [
                                'class' => 'btn btn-primary'
                            ]
                        ]);
                        ?>
                        <button type="button" class="btn btn-primary"
                                data-dismiss="modal"><?= Yii::t('SharebetweenModule.base', 'Close'); ?></button>

                        <?php ActiveForm::end(); ?>
                    </div>

                </div>
                <?= \humhub\widgets\LoaderWidget::widget(['id' => 'invite-loader', 'cssClass' => 'loader-modal hidden']); ?>

            </div>

        </div>

    </div>

</div>

