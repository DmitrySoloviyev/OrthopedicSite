<?php

/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 08.02.15
 * Time: 15:41
 */
class WebUser extends CWebUser
{
    private $_model = null;

    function getRole()
    {
        $user = $this->loadUser(Yii::app()->user->id);

        return $user->role;
    }

    function getLogin()
    {
        $user = $this->loadUser(Yii::app()->user->id);

        if ($user !== null)
            return $user->login;
        else
            return false;
    }

    function isAdmin()
    {
        $user = $this->loadUser(Yii::app()->user->id);
        if ($user !== null)
            return (intval($user->role) == User::ROLE_ADMIN);
        else
            return false;
    }

    function getName()
    {
        $user = $this->loadUser(Yii::app()->user->id);
        if ($user !== null)
            return $user->name;
        else
            return false;
    }

    function getFullName()
    {
        $user = $this->loadUser(Yii::app()->user->id);
        if ($user !== null)
            return $user->surname . ' ' . $user->name;
        else
            return false;
    }

    function getEmail()
    {
        $user = $this->loadUser(Yii::app()->user->id);
        if ($user !== null)
            return $user->email;
        else
            return false;
    }

    protected function loadUser($id = null)
    {
        if ($this->_model === null) {
            if ($id !== null)
                $this->_model = User::model()->findByPk($id);
        }

        return $this->_model;
    }

}
