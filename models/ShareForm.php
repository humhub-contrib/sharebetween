<?php

namespace humhub\modules\sharebetween\models;

// use Yii;
// use yii\base\Model;


use humhub\modules\space\models\Space;

/**
 * @author Luke
 * @package humhub.modules_core.space.forms
 * @since 0.5
 */
class ShareForm extends Space
{

    /**
     * Field for Invite GUIDs
     *
     * @var GUID
     */
    public $Spaces_GUIDs;

    /**
     * Number of maxSelection
     *
     * @var int
     */
    public $maxSelection;

    public function rules()
    {
        return array(
            array(['Spaces_GUIDs'], 'safe'),
                //array('inviteExternal', 'checkInviteExternal'),
        );
    }
 
     /**
     *
     * @return ActiveQuery
     */
    public function getSpaceContentContainer()
    {
        $spaces = [];
        if ($this->maxSelection > 1) {
            foreach (explode(',', $this->Spaces_GUIDs) as $guid) {
                $contentContainer = $this->findOne(['guid' => trim($guid)]);
                if ($contentContainer !== null) {
                    $spaces[] = $contentContainer;
                }
            }
        } else {
            $contentContainer = $this->findOne(['guid' => trim($this->Spaces_GUIDs[0])]);
            if ($contentContainer !== null) {
                $spaces[] = $contentContainer;
            }
        }
        return $spaces;
    }


}
