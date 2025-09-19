<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Level;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    public function index()
    {
        $levels = Level::orderBy('order')->get();
        return response()->json([
            'success' => true,
            'data' => $levels
        ]);
    }

    public function show(Level $level)
    {
        return response()->json([
            'success' => true,
            'data' => $level->load('questionSets.week')
        ]);
    }
}