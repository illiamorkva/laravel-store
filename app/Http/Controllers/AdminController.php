<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','role:admin']);
    }

    /**
     * Action for the start page "Admin Panel"
     */
    public function actionIndex()
    {
        return view('admin.index');
    }
}
