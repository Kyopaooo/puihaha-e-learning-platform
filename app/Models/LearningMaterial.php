<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class LearningMaterial extends Model {protected $fillable=['lesson_id','title','file_path','original_name']; public function lesson(){return $this->belongsTo(Lesson::class);} }
