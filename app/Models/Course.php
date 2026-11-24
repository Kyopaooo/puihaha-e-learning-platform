<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Course extends Model {protected $fillable=['title','slug','description','thumbnail','instructor_id','course_category_id','required_membership_level_id','status']; public function instructor(){return $this->belongsTo(User::class,'instructor_id');} public function category(){return $this->belongsTo(CourseCategory::class,'course_category_id');} public function lessons(){return $this->hasMany(Lesson::class)->orderBy('sort_order');} public function enrollments(){return $this->hasMany(Enrollment::class);} }
