<?php

use App\Http\Controllers\Api\V1\Career\JobBoardController as CareerJobBoardController;
use App\Http\Controllers\Api\V1\Career\RecruiterController as CareerRecruiterController;
use App\Http\Controllers\Api\V1\Personal\IndexController as PersonalIndexController;
use App\Http\Controllers\Api\V1\Personal\ReadingController as PersonalReadingController;
use App\Http\Controllers\Api\V1\Personal\RecipeController as PersonalRecipeController;
use App\Http\Controllers\Api\V1\Portfolio\AcademyController as PortfolioAcademyController;
use App\Http\Controllers\Api\V1\Portfolio\ArtController as PortfolioArtController;
use App\Http\Controllers\Api\V1\Portfolio\AudioController as PortfolioAudioController;
use App\Http\Controllers\Api\V1\Portfolio\AwardController as PortfolioAwardController;
use App\Http\Controllers\Api\V1\Portfolio\CertificateController as PortfolioCertificateController;
use App\Http\Controllers\Api\V1\Portfolio\CertificationController as PortfolioCertificationController;
use App\Http\Controllers\Api\V1\Portfolio\CourseController as PortfolioCourseController;
use App\Http\Controllers\Api\V1\Portfolio\EducationController as PortfolioEducationController;
use App\Http\Controllers\Api\V1\Portfolio\IndexController as PortfolioIndexController;
use App\Http\Controllers\Api\V1\Portfolio\JobController as PortfolioJobController;
use App\Http\Controllers\Api\V1\Portfolio\LinkController as PortfolioLinkController;
use App\Http\Controllers\Api\V1\Portfolio\MusicController as PortfolioMusicController;
use App\Http\Controllers\Api\V1\Portfolio\PhotographyController as PortfolioPhotographyController;
use App\Http\Controllers\Api\V1\Portfolio\ProjectController as PortfolioProjectController;
use App\Http\Controllers\Api\V1\Portfolio\PublicationController as PortfolioPublicationController;
use App\Http\Controllers\Api\V1\Portfolio\SkillController as PortfolioSkillController;
use App\Http\Controllers\Api\V1\Portfolio\VideoController as PortfolioVideoController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->name('api.v1.')->group(function () {

    Route::get('career/job-boards', [CareerJobBoardController::class, 'index'])->name('career.job-board.index');
    Route::get('career/job-boards/{id}', [CareerJobBoardController::class, 'show'])->name('career.job-board.show');
    Route::get('career/recruiters', [CareerRecruiterController::class, 'index'])->name('career.recruiter.index');
    Route::get('career/recruiters/{id}', [CareerRecruiterController::class, 'show'])->name('career.recruiter.show');

    Route::get('portfolio/academies', [PortfolioAcademyController::class, 'index'])->name('portfolio.academy.index');
    Route::get('portfolio/academies/{id}', [PortfolioAcademyController::class, 'show'])->name('portfolio.academy.show');
    Route::get('portfolio/certifications', [PortfolioCertificationController::class, 'index'])->name('portfolio.certification.index');
    Route::get('portfolio/certifications/{id}', [PortfolioCertificationController::class, 'show'])->name('portfolio.certification.show');

    Route::get('personal/{owner_id}', [PersonalIndexController::class, 'show'])->name('personal.show');
    Route::get('personal/readings/{owner_id}', [PersonalReadingController::class, 'show'])->name('personal.reading.show');
    Route::get('personal/recipes/{owner_id}', [PersonalRecipeController::class, 'show'])->name('personal.recipe.show');

    Route::get('portfolio/{owner_id}', [PortfolioIndexController::class, 'show'])->name('portfolio.show');
    Route::get('portfolio/arts/{owner_id}', [PortfolioArtController::class, 'show'])->name('portfolio.art.show');
    Route::get('portfolio/audios/{owner_id}', [PortfolioAudioController::class, 'show'])->name('portfolio.audio.show');
    Route::get('portfolio/awards/{owner_id}', [PortfolioAwardController::class, 'show'])->name('portfolio.award.show');
    Route::get('portfolio/certificates/{owner_id}', [PortfolioCertificateController::class, 'show'])->name('portfolio.certificate.show');
    Route::get('portfolio/courses/{owner_id}', [PortfolioCourseController::class, 'show'])->name('portfolio.course.show');
    Route::get('portfolio/educations/{owner_id}', [PortfolioEducationController::class, 'show'])->name('portfolio.education.show');
    Route::get('portfolio/jobs/{owner_id}', [PortfolioJobController::class, 'show'])->name('portfolio.job.show');
    Route::get('portfolio/links/{owner_id}', [PortfolioLinkController::class, 'show'])->name('portfolio.link.show');
    Route::get('portfolio/musics/{owner_id}', [PortfolioMusicController::class, 'show'])->name('portfolio.music.show');
    Route::get('portfolio/photographies/{owner_id}', [PortfolioPhotographyController::class, 'show'])->name('portfolio.photography.show');
    Route::get('portfolio/projects/{owner_id}', [PortfolioProjectController::class, 'show'])->name('portfolio.project.show');
    Route::get('portfolio/publications/{owner_id}', [PortfolioPublicationController::class, 'show'])->name('portfolio.publication.show');
    Route::get('portfolio/skills/{owner_id}', [PortfolioSkillController::class, 'show'])->name('portfolio.skill.show');
    Route::get('portfolio/videos/{owner_id}', [PortfolioVideoController::class, 'show'])->name('portfolio.video.show');
});
