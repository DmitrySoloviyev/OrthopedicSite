<?php

/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 11.01.15
 * Time: 17:37
 */
class SearchFormWidget extends CWidget
{
    public function init()
    {

    }

    public function run()
    {
        $model = new SearchForm();
        $this->render('search_form', ['model' => $model]);
    }

}
