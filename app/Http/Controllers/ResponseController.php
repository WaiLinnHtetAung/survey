<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use Illuminate\Http\Request;

class ResponseController extends Controller
{
    public function store(Request $request)
    {
        //storing methods here

        Survey::findOrfail($request->survey_id)->increment('response', 1);

        return redirect()->route('survey.index');
    }
}