<?php

use App\Http\Controllers\Admin\Portfolio\AcademyController as AdminPortfolioAcademyController;
use App\Http\Controllers\Admin\Portfolio\ArtController as AdminPortfolioArtController;
use App\Http\Controllers\Admin\Portfolio\AudioController as AdminPortfolioAudioController;
use App\Http\Controllers\Admin\Portfolio\AwardController as AdminPortfolioAwardController;
use App\Http\Controllers\Admin\Portfolio\CertificateController as AdminPortfolioCertificateController;
use App\Http\Controllers\Admin\Portfolio\CertificationController as AdminPortfolioCertificationController;
use App\Http\Controllers\Admin\Portfolio\CourseController as AdminPortfolioCourseController;
use App\Http\Controllers\Admin\Portfolio\EducationController as AdminPortfolioEducationController;
use App\Http\Controllers\Admin\Portfolio\IndexController as AdminPortfolioIndexController;
use App\Http\Controllers\Admin\Portfolio\JobController as AdminPortfolioJobController;
use App\Http\Controllers\Admin\Portfolio\JobCoworkerController as AdminPortfolioJobCoworkerController;
use App\Http\Controllers\Admin\Portfolio\JobTaskController as AdminPortfolioJobTaskController;
use App\Http\Controllers\Admin\Portfolio\JobSkillController as AdminPortfolioJobSkillController;
use App\Http\Controllers\Admin\Portfolio\LinkController as AdminPortfolioLinkController;
use App\Http\Controllers\Admin\Portfolio\MusicController as AdminPortfolioMusicController;
use App\Http\Controllers\Admin\Portfolio\PhotographyController as AdminPortfolioPhotographyController;
use App\Http\Controllers\Admin\Portfolio\ProjectController as AdminPortfolioProjectController;
use App\Http\Controllers\Admin\Portfolio\PublicationController as AdminPortfolioPublicationController;
use App\Http\Controllers\Admin\Portfolio\SchoolController as AdminPortfolioSchoolController;
use App\Http\Controllers\Admin\Portfolio\SkillController as AdminPortfolioSkillController;
use App\Http\Controllers\Admin\Portfolio\VideoController as AdminPortfolioVideoController;

use App\Http\Controllers\Admin\Root\Portfolio\AcademyController as AdminRootPortfolioAcademyController;
use App\Http\Controllers\Admin\Root\Portfolio\ArtController as AdminRootPortfolioArtController;
use App\Http\Controllers\Admin\Root\Portfolio\AudioController as AdminRootPortfolioAudioController;
use App\Http\Controllers\Admin\Root\Portfolio\AwardController as AdminRootPortfolioAwardController;
use App\Http\Controllers\Admin\Root\Portfolio\CertificateController as AdminRootPortfolioCertificateController;
use App\Http\Controllers\Admin\Root\Portfolio\CertificationController as AdminRootPortfolioCertificationController;
use App\Http\Controllers\Admin\Root\Portfolio\CourseController as AdminRootPortfolioCourseController;
use App\Http\Controllers\Admin\Root\Portfolio\EducationController as AdminRootPortfolioEducationController;
use App\Http\Controllers\Admin\Root\Portfolio\IndexController as AdminRootPortfolioIndexController;
use App\Http\Controllers\Admin\Root\Portfolio\JobController as AdminRootPortfolioJobController;
use App\Http\Controllers\Admin\Root\Portfolio\JobCoworkerController as AdminRootPortfolioJobCoworkerController;
use App\Http\Controllers\Admin\Root\Portfolio\JobTaskController as AdminRootPortfolioJobTaskController;
use App\Http\Controllers\Admin\Root\Portfolio\JobSkillController as AdminRootPortfolioJobSkillController;
use App\Http\Controllers\Admin\Root\Portfolio\LinkController as AdminRootPortfolioLinkController;
use App\Http\Controllers\Admin\Root\Portfolio\MusicController as AdminRootPortfolioMusicController;
use App\Http\Controllers\Admin\Root\Portfolio\PhotographyController as AdminRootPortfolioPhotographyController;
use App\Http\Controllers\Admin\Root\Portfolio\ProjectController as AdminRootPortfolioProjectController;
use App\Http\Controllers\Admin\Root\Portfolio\PublicationController as AdminRootPortfolioPublicationController;
use App\Http\Controllers\Admin\Root\Portfolio\SchoolController as AdminRootPortfolioSchoolController;
use App\Http\Controllers\Admin\Root\Portfolio\SkillController as AdminRootPortfolioSkillController;
use App\Http\Controllers\Admin\Root\Portfolio\VideoController as AdminRootPortfolioVideoController;

use App\Http\Controllers\Guest\Portfolio\ArtController as GuestPortfolioArtController;
use App\Http\Controllers\Guest\Portfolio\AudioController as GuestPortfolioAudioController;
use App\Http\Controllers\Guest\Portfolio\AwardController as GuestPortfolioAwardController;
use App\Http\Controllers\Guest\Portfolio\CertificateController as GuestPortfolioCertificateController;
use App\Http\Controllers\Guest\Portfolio\CourseController as GuestPortfolioCourseController;
use App\Http\Controllers\Guest\Portfolio\EducationController as GuestPortfolioEducationController;
use App\Http\Controllers\Guest\Portfolio\LinkController as GuestPortfolioLinkController;
use App\Http\Controllers\Guest\Portfolio\MusicController as GuestPortfolioMusicController;
use App\Http\Controllers\Guest\Portfolio\IndexController as GuestPortfolioIndexController;
use App\Http\Controllers\Guest\Portfolio\PhotographyController as GuestPortfolioPhotographyController;
use App\Http\Controllers\Guest\Portfolio\ProjectController as GuestPortfolioProjectController;
use App\Http\Controllers\Guest\Portfolio\PublicationController as GuestPortfolioPublicationController;
use App\Http\Controllers\Guest\Portfolio\ResumeController as GuestPortfolioResumeController;
use App\Http\Controllers\Guest\Portfolio\SkillController as GuestPortfolioSkillController;
use App\Http\Controllers\Guest\Portfolio\VideoController as GuestPortfolioVideoController;

use Illuminate\Support\Facades\Route;

Route::prefix('admin/portfolio')->middleware('admin')->name('admin.portfolio.')->group(function () {

    Route::get('/', [AdminPortfolioIndexController::class, 'index'])->name('index');

    Route::resource('portfolio/academy', AdminPortfolioAcademyController::class);
    Route::resource('portfolio/certification', AdminPortfolioCertificationController::class);
    Route::resource('portfolio/school', AdminPortfolioSchoolController::class);

    Route::resource('art', AdminPortfolioArtController::class);
    Route::resource('audio', AdminPortfolioAudioController::class);
    Route::resource('award', AdminPortfolioAwardController::class);
    Route::resource('certificate', AdminPortfolioCertificateController::class);
    Route::resource('course', AdminPortfolioCourseController::class);
    Route::resource('education', AdminPortfolioEducationController::class);
    Route::resource('job', AdminPortfolioJobController::class);
    Route::resource('job-coworker', AdminPortfolioJobCoworkerController::class);
    Route::resource('job-skill', AdminPortfolioJobSkillController::class);
    Route::resource('job-task', AdminPortfolioJobTaskController::class);
    Route::resource('link', AdminPortfolioLinkController::class);
    Route::resource('music', AdminPortfolioMusicController::class);
    Route::resource('photography', AdminPortfolioPhotographyController::class);
    Route::resource('project', AdminPortfolioProjectController::class);
    Route::resource('publication', AdminPortfolioPublicationController::class);
    Route::resource('skill', AdminPortfolioSkillController::class);
    Route::resource('video', AdminPortfolioVideoController::class);
});

Route::prefix('admin/admin')->middleware('admin')->name('root.portfolio.')->group(function () {

    Route::get('portfolio', [AdminPortfolioIndexController::class, 'index'])->name('index');

    Route::resource('portfolio/academy', AdminRootPortfolioAcademyController::class);
    Route::resource('portfolio/certification', AdminRootPortfolioCertificationController::class);
    Route::resource('portfolio/school', AdminRootPortfolioSchoolController::class);

    Route::get('{admin:id}/portfolio/art/{art?}', [AdminRootPortfolioArtController::class, 'index'])->name('art.index');
    Route::resource('{admin:id}/portfolio/art', AdminRootPortfolioArtController::class)->except(['index']);
//    Route::get('{admin:id}/portfolio/art', [AdminRootPortfolioArtController::class, 'index'])->name('art.index');
//    Route::post('{admin:id}/portfolio/art', [AdminRootPortfolioArtController::class, 'store'])->name('art.store');
//    Route::get('{admin:id}/portfolio/art/create', [AdminRootPortfolioArtController::class, 'create'])->name('art.create');
//    Route::get('{admin:id}/portfolio/art/{art:id}', [AdminRootPortfolioArtController::class, 'show'])->name('art.show');
//    Route::put('{admin:id}/portfolio/art/{art:id}', [AdminRootPortfolioArtController::class, 'update'])->name('art.update');
//    Route::delete('{admin:id}/portfolio/art/{art:id}', [AdminRootPortfolioArtController::class, 'destroy'])->name('art.destroy');
//    Route::get('{admin:id}/portfolio/art/{art:id}/edit', [AdminRootPortfolioArtController::class, 'edit'])->name('art.edit');

    Route::resource('{admin:id}/portfolio/audio', AdminRootPortfolioAudioController::class);
//    Route::get('{admin:id}/portfolio/audio', [AdminRootPortfolioAudioController::class, 'index'])->name('audio.index');
//    Route::post('{admin:id}/portfolio/audio', [AdminRootPortfolioAudioController::class, 'store'])->name('audio.store');
//    Route::get('{admin:id}/portfolio/audio/create', [AdminRootPortfolioAudioController::class, 'create'])->name('audio.create');
//    Route::get('{admin:id}/portfolio/audio/{audio:id}', [AdminRootPortfolioAudioController::class, 'show'])->name('audio.show');
//    Route::put('{admin:id}/portfolio/audio/{audio:id}', [AdminRootPortfolioAudioController::class, 'update'])->name('audio.update');
//    Route::delete('{admin:id}/portfolio/audio/{audio:id}', [AdminRootPortfolioAudioController::class, 'destroy'])->name('audio.destroy');
//    Route::get('{admin:id}/portfolio/audio/{audio:id}/edit', [AdminRootPortfolioAudioController::class, 'edit'])->name('audio.edit');

    Route::resource('{admin:id}/portfolio/award', AdminRootPortfolioAwardController::class);
//    Route::get('{admin:id}/portfolio/award', [AdminRootPortfolioAwardController::class, 'index'])->name('award.index');
//    Route::post('{admin:id}/portfolio/award', [AdminRootPortfolioAwardController::class, 'store'])->name('award.store');
//    Route::get('{admin:id}/portfolio/award/create', [AdminRootPortfolioAwardController::class, 'create'])->name('award.create');
//    Route::get('{admin:id}/portfolio/award/{award:id}', [AdminRootPortfolioAwardController::class, 'show'])->name('award.show');
//    Route::put('{admin:id}/portfolio/award/{award:id}', [AdminRootPortfolioAwardController::class, 'update'])->name('award.update');
//    Route::delete('{admin:id}/portfolio/award/{award:id}', [AdminRootPortfolioAwardController::class, 'destroy'])->name('award.destroy');
//    Route::get('{admin:id}/portfolio/award/{award:id}/edit', [AdminRootPortfolioAwardController::class, 'edit'])->name('award.edit');

    Route::resource('{admin:id}/portfolio/certificate', AdminRootPortfolioCertificateController::class);
//    Route::get('{admin:id}/portfolio/certificate', [AdminRootPortfolioCertificateController::class, 'index'])->name('certificate.index');
//    Route::post('{admin:id}/portfolio/certificate', [AdminRootPortfolioCertificateController::class, 'store'])->name('certificate.store');
//    Route::get('{admin:id}/portfolio/certificate/create', [AdminRootPortfolioCertificateController::class, 'create'])->name('certificate.create');
//    Route::get('{admin:id}/portfolio/certificate/{certificate:id}', [AdminRootPortfolioCertificateController::class, 'show'])->name('certificate.show');
//    Route::put('{admin:id}/portfolio/certificate/{certificate:id}', [AdminRootPortfolioCertificateController::class, 'update'])->name('certificate.update');
//    Route::delete('{admin:id}/portfolio/certificate/{certificate:id}', [AdminRootPortfolioCertificateController::class, 'destroy'])->name('certificate.destroy');
//    Route::get('{admin:id}/portfolio/certificate/{certificate:id}/edit', [AdminRootPortfolioCertificateController::class, 'edit'])->name('certificate.edit');

    Route::resource('{admin:id}/portfolio/course', AdminRootPortfolioCourseController::class);
//    Route::get('{admin:id}/portfolio/course', [AdminRootPortfolioCourseController::class, 'index'])->name('course.index');
//    Route::post('{admin:id}/portfolio/course', [AdminRootPortfolioCourseController::class, 'store'])->name('course.store');
//    Route::get('{admin:id}/portfolio/course/create', [AdminRootPortfolioCourseController::class, 'create'])->name('course.create');
//    Route::get('{admin:id}/portfolio/course/{course:id}', [AdminRootPortfolioCourseController::class, 'show'])->name('course.show');
//    Route::put('{admin:id}/portfolio/course/{course:id}', [AdminRootPortfolioCourseController::class, 'update'])->name('course.update');
//    Route::delete('{admin:id}/portfolio/course/{course:id}', [AdminRootPortfolioCourseController::class, 'destroy'])->name('course.destroy');
//    Route::get('{admin:id}/portfolio/course/{course:id}/edit', [AdminRootPortfolioCourseController::class, 'edit'])->name('course.edit');

    Route::resource('{admin:id}/portfolio/education', AdminRootPortfolioEducationController::class);
//    Route::get('{admin:id}/portfolio/education', [AdminRootPortfolioEducationController::class, 'index'])->name('education.index');
//    Route::post('{admin:id}/portfolio/education', [AdminRootPortfolioEducationController::class, 'store'])->name('education.store');
//    Route::get('{admin:id}/portfolio/education/create', [AdminRootPortfolioEducationController::class, 'create'])->name('education.create');
//    Route::get('{admin:id}/portfolio/education/{education:id}', [AdminRootPortfolioEducationController::class, 'show'])->name('education.show');
//    Route::put('{admin:id}/portfolio/education/{education:id}', [AdminRootPortfolioEducationController::class, 'update'])->name('education.update');
//    Route::delete('{admin:id}/portfolio/education/{education:id}', [AdminRootPortfolioEducationController::class, 'destroy'])->name('education.destroy');
//    Route::get('{admin:id}/portfolio/education/{education:id}/edit', [AdminRootPortfolioEducationController::class, 'edit'])->name('education.edit');

    Route::resource('{admin:id}/portfolio/job', AdminRootPortfolioJobController::class);
//    Route::get('{admin:id}/portfolio/job', [AdminRootPortfolioJobController::class, 'index'])->name('job.index');
//    Route::post('{admin:id}/portfolio/job', [AdminRootPortfolioJobController::class, 'store'])->name('job.store');
//    Route::get('{admin:id}/portfolio/job/create', [AdminRootPortfolioJobController::class, 'create'])->name('job.create');
//    Route::get('{admin:id}/portfolio/job/{job:id}', [AdminRootPortfolioJobController::class, 'show'])->name('job.show');
//    Route::put('{admin:id}/portfolio/job/{job:id}', [AdminRootPortfolioJobController::class, 'update'])->name('job.update');
//    Route::delete('{admin:id}/portfolio/job/{job:id}', [AdminRootPortfolioJobController::class, 'destroy'])->name('job.destroy');
//    Route::get('{admin:id}/portfolio/job/{job:id}/edit', [AdminRootPortfolioJobController::class, 'edit'])->name('job.edit');

    Route::resource('{admin:id}/portfolio/job-coworker', AdminRootPortfolioJobCoworkerController::class);
//    Route::get('{admin:id}/portfolio/job-coworker', [AdminRootPortfolioJobCoworkerController::class, 'index'])->name('job-coworker.index');
//    Route::post('{admin:id}/portfolio/job-coworker', [AdminRootPortfolioJobCoworkerController::class, 'store'])->name('job-coworker.store');
//    Route::get('{admin:id}/portfolio/job-coworker/create', [AdminRootPortfolioJobCoworkerController::class, 'create'])->name('job-coworker.create');
//    Route::get('{admin:id}/portfolio/job-coworker/{job-coworker:id}', [AdminRootPortfolioJobCoworkerController::class, 'show'])->name('job-coworker.show');
//    Route::put('{admin:id}/portfolio/job-coworker/{job-coworker:id}', [AdminRootPortfolioJobCoworkerController::class, 'update'])->name('job-coworker.update');
//    Route::delete('{admin:id}/portfolio/job-coworker/{job-coworker:id}', [AdminRootPortfolioJobCoworkerController::class, 'destroy'])->name('job-coworker.destroy');
//    Route::get('{admin:id}/portfolio/job-coworker/{job-coworker:id}/edit', [AdminRootPortfolioJobCoworkerController::class, 'edit'])->name('job-coworker.edit');

    Route::resource('{admin:id}/portfolio/job-skill', AdminRootPortfolioJobSkillController::class);
//    Route::get('{admin:id}/portfolio/job-skill', [AdminRootPortfolioJobSkillController::class, 'index'])->name('job-skill.index');
//    Route::post('{admin:id}/portfolio/job-skill', [AdminRootPortfolioJobSkillController::class, 'store'])->name('job-skill.store');
//    Route::get('{admin:id}/portfolio/job-skill/create', [AdminRootPortfolioJobSkillController::class, 'create'])->name('job-skill.create');
//    Route::get('{admin:id}/portfolio/job-skill/{job-skill:id}', [AdminRootPortfolioJobSkillController::class, 'show'])->name('job-skill.show');
//    Route::put('{admin:id}/portfolio/job-skill/{job-skill:id}', [AdminRootPortfolioJobSkillController::class, 'update'])->name('job-skill.update');
//    Route::delete('{admin:id}/portfolio/job-skill/{job-skill:id}', [AdminRootPortfolioJobSkillController::class, 'destroy'])->name('job-skill.destroy');
//    Route::get('{admin:id}/portfolio/job-skill/{job-skill:id}/edit', [AdminRootPortfolioJobSkillController::class, 'edit'])->name('job-skill.edit');

    Route::resource('{admin:id}/portfolio/job-task', AdminRootPortfolioJobTaskController::class);
//    Route::get('{admin:id}/portfolio/job-task', [AdminRootPortfolioJobTaskController::class, 'index'])->name('job-task.index');
//    Route::post('{admin:id}/portfolio/job-task', [AdminRootPortfolioJobTaskController::class, 'store'])->name('job-task.store');
//    Route::get('{admin:id}/portfolio/job-task/create', [AdminRootPortfolioJobTaskController::class, 'create'])->name('job-task.create');
//    Route::get('{admin:id}/portfolio/job-task/{job-task:id}', [AdminRootPortfolioJobTaskController::class, 'show'])->name('job-task.show');
//    Route::put('{admin:id}/portfolio/job-task/{job-task:id}', [AdminRootPortfolioJobTaskController::class, 'update'])->name('job-task.update');
//    Route::delete('{admin:id}/portfolio/job-task/{job-task:id}', [AdminRootPortfolioJobTaskController::class, 'destroy'])->name('job-task.destroy');
//    Route::get('{admin:id}/portfolio/job-task/{job-task:id}/edit', [AdminRootPortfolioJobTaskController::class, 'edit'])->name('job-task.edit');

    Route::resource('{admin:id}/portfolio/link', AdminRootPortfolioLinkController::class);
//    Route::get('{admin:id}/portfolio/link', [AdminRootPortfolioLinkController::class, 'index'])->name('link.index');
//    Route::post('{admin:id}/portfolio/link', [AdminRootPortfolioLinkController::class, 'store'])->name('link.store');
//    Route::get('{admin:id}/portfolio/link/create', [AdminRootPortfolioLinkController::class, 'create'])->name('link.create');
//    Route::get('{admin:id}/portfolio/link/{link:id}', [AdminRootPortfolioLinkController::class, 'show'])->name('link.show');
//    Route::put('{admin:id}/portfolio/link/{link:id}', [AdminRootPortfolioLinkController::class, 'update'])->name('link.update');
//    Route::delete('{admin:id}/portfolio/link/{link:id}', [AdminRootPortfolioLinkController::class, 'destroy'])->name('link.destroy');
//    Route::get('{admin:id}/portfolio/link/{link:id}/edit', [AdminRootPortfolioLinkController::class, 'edit'])->name('link.edit');

    Route::resource('{admin:id}/portfolio/music', AdminRootPortfolioMusicController::class);
//    Route::get('{admin:id}/portfolio/music', [AdminRootPortfolioMusicController::class, 'index'])->name('music.index');
//    Route::post('{admin:id}/portfolio/music', [AdminRootPortfolioMusicController::class, 'store'])->name('music.store');
//    Route::get('{admin:id}/portfolio/music/create', [AdminRootPortfolioMusicController::class, 'create'])->name('music.create');
//    Route::get('{admin:id}/portfolio/music/{music:id}', [AdminRootPortfolioMusicController::class, 'show'])->name('music.show');
//    Route::put('{admin:id}/portfolio/music/{music:id}', [AdminRootPortfolioMusicController::class, 'update'])->name('music.update');
//    Route::delete('{admin:id}/portfolio/music/{music:id}', [AdminRootPortfolioMusicController::class, 'destroy'])->name('music.destroy');
//    Route::get('{admin:id}/portfolio/music/{music:id}/edit', [AdminRootPortfolioMusicController::class, 'edit'])->name('music.edit');

    Route::resource('{admin:id}/portfolio/photography', AdminRootPortfolioPhotographyController::class);
//    Route::get('{admin:id}/portfolio/photography', [AdminRootPortfolioPhotographyController::class, 'index'])->name('photography.index');
//    Route::post('{admin:id}/portfolio/photography', [AdminRootPortfolioPhotographyController::class, 'store'])->name('photography.store');
//    Route::get('{admin:id}/portfolio/photography/create', [AdminRootPortfolioPhotographyController::class, 'create'])->name('photography.create');
//    Route::get('{admin:id}/portfolio/photography/{photography:id}', [AdminRootPortfolioPhotographyController::class, 'show'])->name('photography.show');
//    Route::put('{admin:id}/portfolio/photography/{photography:id}', [AdminRootPortfolioPhotographyController::class, 'update'])->name('photography.update');
//    Route::delete('{admin:id}/portfolio/photography/{photography:id}', [AdminRootPortfolioPhotographyController::class, 'destroy'])->name('photography.destroy');
//    Route::get('{admin:id}/portfolio/photography/{photography:id}/edit', [AdminRootPortfolioPhotographyController::class, 'edit'])->name('photography.edit');

    Route::resource('{admin:id}/portfolio/project', AdminRootPortfolioProjectController::class);
//    Route::get('{admin:id}/portfolio/project', [AdminRootPortfolioProjectController::class, 'index'])->name('project.index');
//    Route::post('{admin:id}/portfolio/project', [AdminRootPortfolioProjectController::class, 'store'])->name('project.store');
//    Route::get('{admin:id}/portfolio/project/create', [AdminRootPortfolioProjectController::class, 'create'])->name('project.create');
//    Route::get('{admin:id}/portfolio/project/{project:id}', [AdminRootPortfolioProjectController::class, 'show'])->name('project.show');
//    Route::put('{admin:id}/portfolio/project/{project:id}', [AdminRootPortfolioProjectController::class, 'update'])->name('project.update');
//    Route::delete('{admin:id}/portfolio/project/{project:id}', [AdminRootPortfolioProjectController::class, 'destroy'])->name('project.destroy');
//    Route::get('{admin:id}/portfolio/project/{project:id}/edit', [AdminRootPortfolioProjectController::class, 'edit'])->name('project.edit');

    Route::resource('{admin:id}/portfolio/publication', AdminRootPortfolioPublicationController::class);
//    Route::get('{admin:id}/portfolio/publication', [AdminRootPortfolioPublicationController::class, 'index'])->name('publication.index');
//    Route::post('{admin:id}/portfolio/publication', [AdminRootPortfolioPublicationController::class, 'store'])->name('publication.store');
//    Route::get('{admin:id}/portfolio/publication/create', [AdminRootPortfolioPublicationController::class, 'create'])->name('publication.create');
//    Route::get('{admin:id}/portfolio/publication/{publication:id}', [AdminRootPortfolioPublicationController::class, 'show'])->name('publication.show');
//    Route::put('{admin:id}/portfolio/publication/{publication:id}', [AdminRootPortfolioPublicationController::class, 'update'])->name('publication.update');
//    Route::delete('{admin:id}/portfolio/publication/{publication:id}', [AdminRootPortfolioPublicationController::class, 'destroy'])->name('publication.destroy');
//    Route::get('{admin:id}/portfolio/publication/{publication:id}/edit', [AdminRootPortfolioPublicationController::class, 'edit'])->name('publication.edit');

    Route::resource('{admin:id}/portfolio/skill', AdminRootPortfolioSkillController::class);
//    Route::get('{admin:id}/portfolio/skill', [AdminRootPortfolioSkillController::class, 'index'])->name('skill.index');
//    Route::post('{admin:id}/portfolio/skill', [AdminPortfolioSkillController::class, 'store'])->name('skill.store');
//    Route::get('{admin:id}/portfolio/skill/create', [AdminRootPortfolioSkillController::class, 'create'])->name('skill.create');
//    Route::get('{admin:id}/portfolio/skill/{skill:id}', [AdminRootPortfolioSkillController::class, 'show'])->name('skill.show');
//    Route::put('{admin:id}/portfolio/skill/{skill:id}', [AdminRootPortfolioSkillController::class, 'update'])->name('skill.update');
//    Route::delete('{admin:id}/portfolio/skill/{skill:id}', [AdminRootPortfolioSkillController::class, 'destroy'])->name('skill.destroy');
//    Route::get('{admin:id}/portfolio/skill/{skill:id}/edit', [AdminRootPortfolioSkillController::class, 'edit'])->name('skill.edit');

    Route::resource('{admin:id}/portfolio/video', AdminRootPortfolioVideoController::class);
//    Route::get('{admin:id}/portfolio/video', [AdminRootPortfolioVideoController::class, 'index'])->name('video.index');
//    Route::post('{admin:id}/portfolio/video', [AdminRootPortfolioVideoController::class, 'store'])->name('video.store');
//    Route::get('{admin:id}/portfolio/video/create', [AdminRootPortfolioVideoController::class, 'create'])->name('video.create');
//    Route::get('{admin:id}/portfolio/video/{video:id}', [AdminRootPortfolioVideoController::class, 'show'])->name('video.show');
//    Route::put('{admin:id}/portfolio/video/{video:id}', [AdminRootPortfolioVideoController::class, 'update'])->name('video.update');
//    Route::delete('{admin:id}/portfolio/video/{video:id}', [AdminRootPortfolioVideoController::class, 'destroy'])->name('video.destroy');
//    Route::get('{admin:id}/portfolio/video/{video:id}/edit', [AdminRootPortfolioVideoController::class, 'edit'])->name('video.edit');
});


Route::name('guest.')->middleware('guest')->group(function () {
    Route::get('/{admin:label}/resume', [GuestPortfolioResumeController::class, 'index'])->name('resume');
    Route::get('/{admin:label}/portfolio', [GuestPortfolioIndexController::class, 'index'])->name('portfolio.index');
    Route::get('/{admin:label}/portfolio/art', [GuestPortfolioArtController::class, 'index'])->name('portfolio.art.index');
    Route::get('/{admin:label}/portfolio/art/{slug}', [GuestPortfolioArtController::class, 'show'])->name('portfolio.art.show');
    Route::get('/{admin:label}/portfolio/audio', [GuestPortfolioAudioController::class, 'index'])->name('portfolio.audio.index');
    Route::get('/{admin:label}/portfolio/audio/{slug}', [GuestPortfolioAudioController::class, 'show'])->name('portfolio.audio.show');
    Route::get('/{admin:label}/portfolio/award', [GuestPortfolioAwardController::class, 'index'])->name('portfolio.award.index');
    Route::get('/{admin:label}/portfolio/award/{slug}', [GuestPortfolioAwardController::class, 'show'])->name('portfolio.award.show');
    Route::get('/{admin:label}/portfolio/certificate', [GuestPortfolioCertificateController::class, 'index'])->name('portfolio.certificate.index');
    Route::get('/{admin:label}/portfolio/certificate/{slug}', [GuestPortfolioCertificateController::class, 'show'])->name('portfolio.certificate.show');
    Route::get('/{admin:label}/portfolio/course', [GuestPortfolioCourseController::class, 'index'])->name('portfolio.course.index');
    Route::get('/{admin:label}/portfolio/course/{slug}', [GuestPortfolioCourseController::class, 'show'])->name('portfolio.course.show');
    Route::get('/{admin:label}/portfolio/education', [GuestPortfolioEducationController::class, 'index'])->name('portfolio.education.index');
    Route::get('/{admin:label}/portfolio/education/{id}', [GuestPortfolioEducationController::class, 'show'])->name('portfolio.education.show');
    Route::get('/{admin:label}/portfolio/link', [GuestPortfolioLinkController::class, 'index'])->name('portfolio.link.index');
    Route::get('/{admin:label}/portfolio/link/{slug}', [GuestPortfolioLinkController::class, 'show'])->name('portfolio.link.show');
    Route::get('/{admin:label}/portfolio/music', [GuestPortfolioMusicController::class, 'index'])->name('portfolio.music.index');
    Route::get('/{admin:label}/portfolio/music/{slug}', [GuestPortfolioMusicController::class, 'show'])->name('portfolio.music.show');
    Route::get('/{admin:label}/portfolio/photography', [GuestPortfolioPhotographyController::class, 'index'])->name('portfolio.photography.index');
    Route::get('/{admin:label}/portfolio/photography/{slug}', [GuestPortfolioPhotographyController::class, 'show'])->name('portfolio.photography.show');
    Route::get('/{admin:label}/portfolio/project', [GuestPortfolioProjectController::class, 'index'])->name('portfolio.project.index');
    Route::get('/{admin:label}/portfolio/project/{slug}', [GuestPortfolioProjectController::class, 'show'])->name('portfolio.project.show');
    Route::get('/{admin:label}/portfolio/publication', [GuestPortfolioPublicationController::class, 'index'])->name('portfolio.publication.index');
    Route::get('/{admin:label}/portfolio/publication/{slug}', [GuestPortfolioPublicationController::class, 'show'])->name('portfolio.publication.show');
    Route::get('/{admin:label}/portfolio/skill', [GuestPortfolioSkillController::class, 'index'])->name('portfolio.skill.index');
    Route::get('/{admin:label}/portfolio/skill/{slug}', [GuestPortfolioSkillController::class, 'show'])->name('portfolio.skill.show');
    Route::get('/{admin:label}/portfolio/video', [GuestPortfolioVideoController::class, 'index'])->name('portfolio.video.index');
    Route::get('/{admin:label}/portfolio/video/{slug}', [GuestPortfolioVideoController::class, 'show'])->name('portfolio.video.show');
});
