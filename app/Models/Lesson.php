<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Lesson extends Model {protected $fillable=['course_id','title','content','video_url','sort_order','is_published']; protected function casts():array{return ['is_published'=>'boolean'];} public function course(){return $this->belongsTo(Course::class);} public function materials(){return $this->hasMany(LearningMaterial::class);} }
