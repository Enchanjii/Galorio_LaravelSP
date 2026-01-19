<?php

namespace App\Models;

class Course
{
    /**
     * Get all available Philippine course programs
     */
    public static function all()
    {
        return [
            'BS Information Technology' => 'Bachelor of Science in Information Technology',
            'BS Computer Science' => 'Bachelor of Science in Computer Science',
            'BS Electronics Engineering' => 'Bachelor of Science in Electronics Engineering',
            'BS Electrical Engineering' => 'Bachelor of Science in Electrical Engineering',
            'BS Civil Engineering' => 'Bachelor of Science in Civil Engineering',
            'BS Mechanical Engineering' => 'Bachelor of Science in Mechanical Engineering',
            'BS Mining Engineering' => 'Bachelor of Science in Mining Engineering',
            'BS Chemical Engineering' => 'Bachelor of Science in Chemical Engineering',
            'BS Nursing' => 'Bachelor of Science in Nursing',
            'BS Medical Laboratories' => 'Bachelor of Science in Medical Laboratory Science',
            'BS Pharmacy' => 'Bachelor of Science in Pharmacy',
            'BS Dental Medicine' => 'Bachelor of Science in Dental Medicine',
            'BS Education' => 'Bachelor of Secondary Education',
            'BS Commerce' => 'Bachelor of Science in Commerce',
            'BS Accounting' => 'Bachelor of Science in Accountancy',
            'BS Business Administration' => 'Bachelor of Science in Business Administration',
            'BS Economics' => 'Bachelor of Science in Economics',
            'BA Psychology' => 'Bachelor of Arts in Psychology',
            'BA English' => 'Bachelor of Arts in English',
            'BA Philosophy' => 'Bachelor of Arts in Philosophy',
            'BS Marine Biology' => 'Bachelor of Science in Marine Biology',
            'BS Maritime' => 'Bachelor of Science in Maritime',
            'BS Maritime Engineering' => 'Bachelor of Science in Maritime Engineering',
            'BS Agriculture' => 'Bachelor of Science in Agriculture',
            'BS Hotel and Restaurant Management' => 'Bachelor of Science in Hotel and Restaurant Management',
            'BS Tourism Management' => 'Bachelor of Science in Tourism Management',
            'BS Culinary Arts' => 'Bachelor of Science in Culinary Arts',
            'BS Fine Arts' => 'Bachelor of Science in Fine Arts',
            'BS Music' => 'Bachelor of Science in Music',
            'BS Physical Education' => 'Bachelor of Science in Physical Education',
        ];
    }

    /**
     * Get list of course values
     */
    public static function getList()
    {
        return array_keys(self::all());
    }

    /**
     * Get full course name by short code
     */
    public static function getFullName($shortCode)
    {
        return self::all()[$shortCode] ?? $shortCode;
    }
}
