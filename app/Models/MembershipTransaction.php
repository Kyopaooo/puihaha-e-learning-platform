<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class MembershipTransaction extends Model {protected $fillable=['reference_number','member_id','membership_level_id','type','amount','amount_paid','status','transaction_date','approved_at']; protected function casts():array{return ['amount'=>'decimal:2','amount_paid'=>'decimal:2','transaction_date'=>'date','approved_at'=>'datetime'];} public function member(){return $this->belongsTo(Member::class);} public function level(){return $this->belongsTo(MembershipLevel::class,'membership_level_id');} public function payments(){return $this->hasMany(Payment::class);}}
