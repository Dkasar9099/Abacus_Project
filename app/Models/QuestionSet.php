<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuestionSet extends Model
{
    protected $fillable = [
        'level_id', 'week_id', 'name', 'set_number', 
        'total_questions', 'time_limit', 'is_active'
    ];
    
    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }
    
    public function week(): BelongsTo
    {
        return $this->belongsTo(Week::class);
    }
    
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function exams(): HasMany
    {
        return $this->hasMany(Exam::class);
    }
}