<?php
namespace App\Http\Controllers;
use App\Models\{Member,MembershipTransaction,Payment,Course,User,Enrollment,LearningCenter}; use Illuminate\Support\Facades\Http;
class DashboardController extends Controller {
 public function index(){ $user=auth()->user(); $weather=null; $center=LearningCenter::where('is_active',true)->whereNotNull('latitude')->whereNotNull('longitude')->first(); $key=config('services.google_weather.key'); if($center && $key){try{$response=Http::timeout(8)->get('https://weather.googleapis.com/v1/currentConditions:lookup',['key'=>$key,'location.latitude'=>$center->latitude,'location.longitude'=>$center->longitude]);if($response->successful())$weather=$response->json();}catch(\Throwable $e){report($e);}}
 return view('dashboard.index',['user'=>$user,'memberCount'=>Member::count(),'activeMembers'=>Member::where('status','Active')->count(),'pendingTransactions'=>MembershipTransaction::where('status','Pending')->count(),'collectedPayments'=>Payment::sum('amount'),'courseCount'=>Course::where('status','published')->count(),'studentCount'=>User::where('role','student')->count(),'recentTransactions'=>MembershipTransaction::with('member')->latest()->take(6)->get(),'myEnrollments'=>$user->role==='student'?Enrollment::with('course.lessons')->where('student_id',$user->id)->latest()->take(4)->get():collect(),'center'=>$center,'weather'=>$weather]); }
}
