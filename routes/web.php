<?php

use App\Models\Score;
use App\Livewire\Home;
use App\Livewire\News;
use App\Livewire\About;
use App\Livewire\Major;
use App\Livewire\Staff;
use App\Livewire\Alumni;
use App\Livewire\Jobfair;
use App\Livewire\Partner;
use App\Livewire\Download;
use App\Livewire\Enrollment;
use App\Livewire\Achievement;
use App\Livewire\Announcement;
use App\Livewire\ArticleDetail;
use App\Livewire\BusinessUnit;
use App\Livewire\Extracurricular;
use App\Livewire\ExtracurricularDetail;
use App\Livewire\Facility;
use App\Livewire\Internship;
use App\Livewire\StudentCouncil;
use App\Livewire\StudentEvents;
use App\Livewire\TeachingFactory;
use App\Livewire\Training;
use App\Models\PassingCertificate;
use App\Models\ScoreCategory;
use Illuminate\Support\Facades\Route;
use App\Models\SendPassingCertificate;

// Route::get('/preview-skl', function () {
//     $record = SendPassingCertificate::find(3);
//     $alumni = $record->alumnis;
//     $score_categories = ScoreCategory::all();
//     $scores = Score::with('subjects.score_categories')
//         ->where('alumni_id', $alumni->id)
//         ->get();

//     $scoreA = $scores->filter(fn($s) => $s->subjects->score_categories->name === $score_categories[0]->name );
//     $scoreB = $scores->filter(fn($s) => $s->subjects->score_categories->name === $score_categories[1]->name );
//     $scoreC = $scores->filter(fn($s) => $s->subjects->score_categories->name === $score_categories[2]->name );
//     $scoreD = $scores->filter(fn($s) => $s->subjects->score_categories->name === $score_categories[3]->name );
    
//     $passing_certificate = PassingCertificate::find(1);

//     $imagePathLogo = storage_path('app/public/' . $passing_certificate->logo);
//     $imagePathPhoto = storage_path('app/public/' . $alumni->photo);
//     $imagePathStamp = storage_path('app/public/' . $passing_certificate->stamp);
//     $imagePathQRCode = storage_path('app/public/' . $passing_certificate->qrcode);
//     $imagePathSign = storage_path('app/public/' . $passing_certificate->signature);

//     $imageDataLogo = base64_encode(file_get_contents($imagePathLogo));
//     $imageDataPhoto = base64_encode(file_get_contents($imagePathPhoto));
//     $imageDataStamp = base64_encode(file_get_contents($imagePathStamp));
//     $imageDataQRCode = base64_encode(file_get_contents($imagePathQRCode));
//     $imageDataSign = base64_encode(file_get_contents($imagePathSign));

//     $srcLogo = 'data:image/png;base64,'.$imageDataLogo;
//     $srcPhoto = 'data:image/png;base64,'.$imageDataPhoto;
//     $srcStamp = 'data:image/png;base64,'.$imageDataStamp;
//     $srcQRCode = 'data:image/png;base64,'.$imageDataQRCode;
//     $srcSign = 'data:image/png;base64,'.$imageDataSign;

//     return view('pdf.passing-certificate', 
//         [
//             'passing_certificate' => $passing_certificate,
//             'alumni' => $alumni,
//             'certificate' => $record,
//             'score_categories' => $score_categories,
//             'scoreA' => $scoreA,
//             'scoreB' => $scoreB,
//             'scoreC' => $scoreC,
//             'scoreD' => $scoreD,
//             'srcLogo' => $srcLogo,
//             'srcPhoto' => $srcPhoto,
//             'srcStamp' => $srcStamp,
//             'srcQRCode' => $srcQRCode,
//             'srcSign' => $srcSign,
//         ]
//     );
// });

// Route::get('/ls', function () {
//     Artisan::call('storage:link');
// });

Route::get('/', Home::class);

Route::get('/about', About::class);
Route::get('/staff', Staff::class);
Route::get('/facility', Facility::class);
Route::get('/achievement', Achievement::class);
Route::get('/major', Major::class);

Route::get('/extracurricular', Extracurricular::class);
Route::get('/student-events', StudentEvents::class);

Route::get('/internship', Internship::class);
Route::get('/partner', Partner::class);
Route::get('/jobfair', Jobfair::class);
Route::get('/alumni', Alumni::class);

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