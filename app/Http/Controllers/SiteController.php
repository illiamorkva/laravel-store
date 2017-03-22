<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function actionIndex()
    {
        return "Hello";
    }

    public function actionContact()
    {
        return "actionContact";
    }

    public function actionAbout()
    {
        return "actionAbout";
    }
}
