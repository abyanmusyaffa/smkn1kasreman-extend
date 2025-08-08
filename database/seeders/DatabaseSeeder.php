<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Alumni;
use App\Models\LessonSession;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Major;
use App\Models\Weblink;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            SchoolSeeder::class,
            MajorSeeder::class,
            PartnerSeeder::class,
            AchievementSeeder::class,
            GroupSeeder::class,
            AlumniSeeder::class,
            TestimonialSeeder::class,
            ArticleSeeder::class,
            FacilitySeeder::class,
            StaffSeeder::class,
            ExtracurricularSeeder::class,
            WeblinkSeeder::class,
            JobfairSeeder::class,
            OrganizationalStructureSeeder::class,
            ScoreSeeder::class,
            PassingCertificateSeeder::class,
            ShieldSeeder::class,
            LessonSessionSeeder::class,
        ]);
    }
}