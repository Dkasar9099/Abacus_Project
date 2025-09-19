<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\LevelController;
use App\Http\Controllers\API\QuestionSetController;
use App\Http\Controllers\API\ExamController;



    Route::get('/levels', [LevelController::class, 'index']);
    Route::get('/levels/{level}', [LevelController::class, 'show']);
    
    // Question Sets
    Route::get('/levels/{level}/question-sets', [QuestionSetController::class, 'index']);
    Route::get('/question-sets/{questionSet}', [QuestionSetController::class, 'show']);
    
    // Exams
    Route::post('/exams/start', [ExamController::class, 'startExam']);
    Route::post('/exams/{exam}/submit-answer', [ExamController::class, 'submitAnswer']);
    Route::post('/exams/{exam}/complete', [ExamController::class, 'completeExam']);
    Route::get('/exams/{exam}/results', [ExamController::class, 'getResults']); 
    
