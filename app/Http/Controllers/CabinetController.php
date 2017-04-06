<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CabinetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Action for the page "User Cabinet"
     */
    public function actionIndex(Request $request)
    {
        //Get current user
        $user = $request->user();

        return view('cabinet.index', [
            'user' => $user
        ]);
    }

    /**
     * Action for the page "The edit user data"
     */
    public function actionEdit(Request $request)
    {
        //Get current user
        $user = $request->user();

        $name = $user->name;

        $result = false;

        if ($request->isMethod('post')) {

            $this->validate($request, [
                'name' => 'required|min:2',
            ]);

            $user->name = $request->input('name');

            $result = $user->save();
        }

        return view('cabinet.edit', [
            'name' => $name, 'result' => $result
        ]);
    }
}
