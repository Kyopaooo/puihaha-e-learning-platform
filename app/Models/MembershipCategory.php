<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class MembershipCategory extends Model {protected $fillable=['name','description','is_active']; protected function casts():array{return ['is_active'=>'boolean'];} public function members(){return $this->hasMany(Member::class);}}
