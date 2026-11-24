<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class MembershipLevel extends Model {protected $fillable=['name','fee','validity_months','benefits','description','is_active']; protected function casts():array{return ['fee'=>'decimal:2','is_active'=>'boolean'];} public function members(){return $this->hasMany(Member::class);}}
