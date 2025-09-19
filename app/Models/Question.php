<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    protected $fillable = [
        'question_set_id', 'question_type_id', 'question_number',
        'digits', 'operators', 'answer', 'time_limit'
    ];
    
    protected $casts = [
        'digits' => 'array',
        'operators' => 'array',
    ];
    
    public function questionSet(): BelongsTo
    {
        return $this->belongsTo(QuestionSet::class);
    }
    
    public function questionType(): BelongsTo
    {
        return $this->belongsTo(QuestionType::class);
    }

    public function examAnswers(): HasMany
    {
        return $this->hasMany(ExamAnswer::class);
    }
}