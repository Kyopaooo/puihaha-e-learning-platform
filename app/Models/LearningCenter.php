<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class LearningCenter extends Model {protected $fillable=['name','address','latitude','longitude','is_active']; protected function casts():array{return ['latitude'=>'decimal:7','longitude'=>'decimal:7','is_active'=>'boolean'];}}
