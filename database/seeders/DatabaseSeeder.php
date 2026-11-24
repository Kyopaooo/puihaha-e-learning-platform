<?php

namespace Database\Seeders;

use App\Models\{
    User, Member, MembershipCategory, MembershipLevel, CourseCategory, LearningCenter
};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $demoAccounts = [
            ['email' => 'admin@puihaha.test', 'name' => 'Puihaha Administrator', 'role' => 'admin'],
            ['email' => 'instructor@puihaha.test', 'name' => 'Demo Instructor', 'role' => 'instructor'],
            ['email' => 'student@puihaha.test', 'name' => 'Demo Student', 'role' => 'student'],
        ];

        foreach ($demoAccounts as $account) {
            $user = User::firstOrCreate(
                ['email' => $account['email']],
                [
                    'name' => $account['name'],
                    'password' => Hash::make('ChangeMe123!'),
                    'role' => $account['role'],
                    'is_active' => true,
                ]
            );

            // Local demonstration accounts are pre-verified; newly registered users must verify by email.
            if (! $user->email_verified_at) {
                $user->forceFill(['email_verified_at' => now()])->save();
            }
        }

        foreach (['Student', 'Regular', 'Senior Citizen', 'Corporate'] as $name) {
            MembershipCategory::firstOrCreate(['name' => $name], ['is_active' => true]);
        }

        foreach ([
            ['Basic', 0, 12, 'Access to introductory learning resources'],
            ['Silver', 499, 12, 'Access to standard courses'],
            ['Gold', 999, 12, 'Access to premium courses and resources'],
            ['Platinum', 1499, 12, 'Full access to all learning resources'],
        ] as [$name, $fee, $months, $benefits]) {
            MembershipLevel::firstOrCreate(
                ['name' => $name],
                [
                    'fee' => $fee,
                    'validity_months' => $months,
                    'benefits' => $benefits,
                    'is_active' => true,
                ]
            );
        }

        foreach (['Technology', 'Business', 'Personal Development', 'Creative Skills'] as $name) {
            CourseCategory::firstOrCreate(['name' => $name]);
        }

        foreach (Member::whereNull('membership_category_id')->get() as $member) {
            $category = MembershipCategory::where('name', $member->category)->first();
            $level = MembershipLevel::where('name', $member->level)->first();

            $member->update([
                'membership_category_id' => $category?->id,
                'membership_level_id' => $level?->id,
            ]);
        }

        LearningCenter::firstOrCreate(
            ['name' => 'Puihaha Main Learning Center'],
            ['address' => 'Manila, Philippines', 'is_active' => true]
        );
    }
}
