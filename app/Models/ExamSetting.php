<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamSetting extends Model
{
    protected $fillable = [
        'setting_key',
        'setting_value',
        'description'
    ];

    /**
     * Get setting value by key
     */
    public static function getValue($key, $default = null)
    {
        $setting = self::where('setting_key', $key)->first();
        return $setting ? $setting->setting_value : $default;
    }

    /**
     * Set setting value by key
     */
    public static function setValue($key, $value, $description = null)
    {
        return self::updateOrCreate(
            ['setting_key' => $key],
            [
                'setting_value' => $value,
                'description' => $description
            ]
        );
    }

    /**
     * Get exam duration in minutes
     */
    public static function getExamDuration()
    {
        return self::getValue('exam_duration', 60); // default 60 minutes
    }

    /**
     * Get number of questions per exam
     */
    public static function getQuestionsPerExam()
    {
        return self::getValue('questions_per_exam', 10); // default 10 questions
    }
}
