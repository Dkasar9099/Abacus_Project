<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\QuestionSet;
use App\Models\Level;
use Illuminate\Http\Request;

class QuestionSetController extends Controller
{
    public function index(Level $level)
    {
        $questionSets = $level->questionSets()
            ->with(['week', 'questions.questionType'])
            ->orderBy('week_id')
            ->orderBy('set_number')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $questionSets
        ]);
    }

    public function show(QuestionSet $questionSet)
    {
        return response()->json([
            'success' => true,
            'data' => $questionSet->load(['questions.questionType', 'week', 'level'])
        ]);
    }
}