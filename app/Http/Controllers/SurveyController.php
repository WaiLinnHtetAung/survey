<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\Question;
use Illuminate\Http\Request;
use DB;

class SurveyController extends Controller
{
    public function index()
    {
        $survey = Survey::with('questions')->get();

        return view('survey', compact('survey'));
    }

    public function create()
    {
        return view('survey_create');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $survey = "";

            if (!Survey::where('name', $request->name)->first()) {
                $survey = Survey::create($request->all());

            } else {
                $survey = Survey::where('name', $request->name)->first();
            }

            Question::create([
                'question_text' => $request->question_text,
                'question_type' => $request->question_type ?? 'text',
                'choices' => $request->question_type == 'multiple_choice' ? $request->choices : null,
                'survey_id' => $survey->id
            ]);

            DB::commit();
            return 'success';

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }

    }

    public function show(Survey $survey)
    {
        $survey = $survey->load('questions');

        return view('survey_page', compact('survey'));
    }
}