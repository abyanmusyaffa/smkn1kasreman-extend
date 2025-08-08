<?php

use App\Filament\Resources\LessonTimetableResource\Pages\LessonTimetableByGroup;
use App\Models\Score;
use App\Livewire\Home;
use App\Livewire\News;
use App\Livewire\About;
use App\Livewire\Major;
use App\Livewire\Staff;
use App\Livewire\Alumni;
use App\Livewire\Gallery;
use App\Livewire\Jobfair;
use App\Livewire\Partner;
use App\Livewire\Download;
use App\Livewire\Facility;
use App\Livewire\Training;
use App\Livewire\Enrollment;
use App\Livewire\Internship;
use App\Livewire\Achievement;
use App\Livewire\MajorDetail;
use App\Models\ScoreCategory;
use App\Livewire\Announcement;
use App\Livewire\BusinessUnit;
use App\Livewire\ArticleDetail;
use App\Livewire\StudentEvents;
use App\Livewire\StudentCouncil;
use App\Livewire\Extracurricular;
use App\Livewire\TeachingFactory;
use App\Models\PassingCertificate;
use App\Livewire\BusinessUnitDetail;
use Illuminate\Support\Facades\Route;
use App\Models\SendPassingCertificate;
use App\Livewire\ExtracurricularDetail;
use App\Livewire\LessonTimetable;
use App\Livewire\TeachingFactoryDetail;
use App\Livewire\SchoolDepartmentDetail;
use App\Livewire\OrganizationalStructure;

// Route::get('/ls', function () {
//     Artisan::call('storage:link');
// });

Route::get('/', Home::class);

Route::get('/about', About::class);
Route::get('/oraganizational-structure', OrganizationalStructure::class);
Route::get('/staff', Staff::class);
Route::get('/facility', Facility::class);
Route::get('/achievement', Achievement::class);
Route::get('/gallery', Gallery::class);

Route::get('/major', Major::class);

Route::get('/extracurricular', Extracurricular::class);
Route::get('/student-event', StudentEvents::class);

Route::get('/internship', Internship::class);
Route::get('/partner', Partner::class);
Route::get('/jobfair', Jobfair::class);
Route::get('/alumni', Alumni::class);

Route::get('/lesson-timetable', LessonTimetable::class);

Route::get('/teaching-factory', TeachingFactory::class);
Route::get('/business-unit', BusinessUnit::class);
Route::get('/training', Training::class);

Route::get('/news', News::class);
Route::get('/announcement', Announcement::class);
Route::get('/enrollment', Enrollment::class);

Route::get('/download', Download::class);

Route::get('/achievement/{slug}', ArticleDetail::class);
Route::get('/news/{slug}', ArticleDetail::class);
Route::get('/announcement/{slug}', ArticleDetail::class);
Route::get('/enrollment/{slug}', ArticleDetail::class);
Route::get('/jobfair/{slug}', ArticleDetail::class);

Route::get('/e/{slug}', ExtracurricularDetail::class);

Route::get('/m/{alias}', MajorDetail::class);

Route::get('/t/{slug}', TeachingFactoryDetail::class);

Route::get('/b/{slug}', BusinessUnitDetail::class);

Route::get('/d/{slug}', SchoolDepartmentDetail::class);