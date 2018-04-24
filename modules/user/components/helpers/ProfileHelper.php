<?php

namespace app\modules\user\components\helpers;

class ProfileHelper
{
    /**
     * @return string
     */
    public static function getEditButtons ()
    {
        return '<a class="profile_edit_link" id="profile_edit_ok" href="javascript:void(0)"><img
                                src="/frontend/web/img/ok.png" alt=""></a>
                        <a class="profile_edit_link" id="profile_edit_cancel" href="javascript:void(0)"><img
                                src="/frontend/web/img/cancel.png" alt=""></a>';
    }

    public static function getEditIcon ()
    {
        return '<a class="pull-right profile_data_update" href="javascript:void(0)">
                        <i class="fa fa-pencil"></i>
                    </a>';
    }
}