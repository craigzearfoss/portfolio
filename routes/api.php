<?php

use App\Http\Controllers\Api\V1\CandidateController as CandidateController;
use App\Http\Controllers\Api\V1\FavoriteController as FavoriteController;
use App\Http\Controllers\Api\V1\MenuController as MenuController;

use App\Http\Controllers\Api\V1\Career\IndustryController as CareerIndustryController;
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
use App\Http\Controllers\Api\V1\Portfolio\SchoolController as PortfolioSchoolController;
use App\Http\Controllers\Api\V1\Portfolio\SkillController as PortfolioSkillController;
use App\Http\Controllers\Api\V1\Portfolio\VideoController as PortfolioVideoController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->name('api.v1.')->group(function () {

    Route::get('candidate/{owner}', [CandidateController::class, 'show'])->name('candidate.show');
    Route::get('favorite/add/{resourceName}/{id}', [FavoriteController::class, 'add'])->name('favorite.add');
    Route::get('favorite/remove/{resourceName}/{id}', [FavoriteController::class, 'remove'])->name('favorite.remove');
    Route::get('menu/{owner}', [MenuController::class, 'show'])->name('menu.show');

    Route::get('career/industries', [CareerIndustryController::class, 'index'])->name('career.job-industry.index');
    Route::get('career/industries/{industry}', [CareerIndustryController::class, 'show'])->name('career.industry.show');
    Route::get('career/job-boards', [CareerJobBoardController::class, 'index'])->name('career.job-board.index');
    Route::get('career/job-boards/{jobBoard}', [CareerJobBoardController::class, 'show'])->name('career.job-board.show');
    Route::get('career/recruiters', [CareerRecruiterController::class, 'index'])->name('career.recruiter.index');
    Route::get('career/recruiters/{recruiter}', [CareerRecruiterController::class, 'show'])->name('career.recruiter.show');

    Route::get('portfolio/academies', [PortfolioAcademyController::class, 'index'])->name('portfolio.academy.index');
    Route::get('portfolio/academies/{academy}', [PortfolioAcademyController::class, 'show'])->name('portfolio.academy.show');
    Route::get('portfolio/certifications', [PortfolioCertificationController::class, 'index'])->name('portfolio.certification.index');
    Route::get('portfolio/certifications/{certification}', [PortfolioCertificationController::class, 'show'])->name('portfolio.certification.show');
    Route::get('portfolio/schools', [PortfolioSchoolController::class, 'index'])->name('portfolio.school.index');
    Route::get('portfolio/schools/{school}', [PortfolioSchoolController::class, 'show'])->name('portfolio.school.show');

    Route::get('personal/{owner}', [PersonalIndexController::class, 'show'])->name('personal.show');
    Route::get('personal/readings', [PersonalReadingController::class, 'index'])->name('personal.reading.index');
    Route::get('personal/readings/{reading}', [PersonalReadingController::class, 'show'])->name('personal.reading.show');
    Route::get('personal/recipes', [PersonalRecipeController::class, 'index'])->name('personal.recipe.index');
    Route::get('personal/recipes/{recipe}', [PersonalRecipeController::class, 'show'])->name('personal.recipe.show');

    Route::get('portfolio/{owner}', [PortfolioIndexController::class, 'show'])->name('portfolio.show');
    Route::get('portfolio/arts', [PortfolioArtController::class, 'index'])->name('portfolio.art.index');
    Route::get('portfolio/arts/{art}', [PortfolioArtController::class, 'show'])->name('portfolio.art.show');
    Route::get('portfolio/audios', [PortfolioAudioController::class, 'index'])->name('portfolio.audio.index');
    Route::get('portfolio/audios/{audio}', [PortfolioAudioController::class, 'show'])->name('portfolio.audio.show');
    Route::get('portfolio/awards', [PortfolioAwardController::class, 'index'])->name('portfolio.award.index');
    Route::get('portfolio/awards/{award}', [PortfolioAwardController::class, 'show'])->name('portfolio.award.show');
    Route::get('portfolio/certificates', [PortfolioCertificateController::class, 'index'])->name('portfolio.certificate.index');
    Route::get('portfolio/certificates/{certificate}', [PortfolioCertificateController::class, 'show'])->name('portfolio.certificate.show');
    Route::get('portfolio/courses', [PortfolioCourseController::class, 'index'])->name('portfolio.course.index');
    Route::get('portfolio/courses/{course}', [PortfolioCourseController::class, 'show'])->name('portfolio.course.show');
    Route::get('portfolio/educations', [PortfolioEducationController::class, 'index'])->name('portfolio.education.index');
    Route::get('portfolio/educations/{education}', [PortfolioEducationController::class, 'show'])->name('portfolio.education.show');
    Route::get('portfolio/jobs', [PortfolioJobController::class, 'index'])->name('portfolio.job.index');
    Route::get('portfolio/jobs/{job}', [PortfolioJobController::class, 'show'])->name('portfolio.job.show');
    Route::get('portfolio/links', [PortfolioLinkController::class, 'index'])->name('portfolio.link.index');
    Route::get('portfolio/links/{link}', [PortfolioLinkController::class, 'show'])->name('portfolio.link.show');
    Route::get('portfolio/musics', [PortfolioMusicController::class, 'index'])->name('portfolio.music.index');
    Route::get('portfolio/musics/{music}', [PortfolioMusicController::class, 'show'])->name('portfolio.music.show');
    Route::get('portfolio/photographies', [PortfolioPhotographyController::class, 'index'])->name('portfolio.photography.index');
    Route::get('portfolio/photographies/{photography}', [PortfolioPhotographyController::class, 'show'])->name('portfolio.photography.show');
    Route::get('portfolio/projects', [PortfolioProjectController::class, 'index'])->name('portfolio.project.index');
    Route::get('portfolio/projects/{project}', [PortfolioProjectController::class, 'show'])->name('portfolio.project.show');
    Route::get('portfolio/publications', [PortfolioPublicationController::class, 'index'])->name('portfolio.publication.index');
    Route::get('portfolio/publications/{publication}', [PortfolioPublicationController::class, 'show'])->name('portfolio.publication.show');
    Route::get('portfolio/skills', [PortfolioSkillController::class, 'index'])->name('portfolio.skill.index');
    Route::get('portfolio/skills/{skill}', [PortfolioSkillController::class, 'show'])->name('portfolio.skill.show');
    Route::get('portfolio/videos', [PortfolioVideoController::class, 'index'])->name('portfolio.video.index');
    Route::get('portfolio/videos/{video}', [PortfolioVideoController::class, 'show'])->name('portfolio.video.show');
});
