<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    protected $connection = 'default_db';

    protected $table = 'admins';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'name',
        'phone',
        'email',
        'image',
        'thumbnail',
        'password',
        'token',
        'root',
        'sequence',
        'public',
        'readonly',
        'root',
        'disabled',
    ];

    /**
     * Get the career applications for the admin.
     */
    public function applications(): HasMany
    {
        return $this->hasMany(\App\Models\Career\Application::class);
    }

    /**
     * Get the career communications for the admin.
     */
    public function communications(): HasMany
    {
        return $this->hasMany(\App\Models\Career\Communication::class);
    }

    /**
     * Get the career companies for the admin.
     */
    public function companies(): HasMany
    {
        return $this->hasMany(\App\Models\Career\Company::class);
    }

    /**
     * Get the career contacts for the admin.
     */
    public function contacts(): HasMany
    {
        return $this->hasMany(\App\Models\Career\Contact::class);
    }

    /**
     * Get the career cover letters for the admin.
     */
    public function coverLetters(): HasMany
    {
        return $this->hasMany(\App\Models\Career\CoverLetter::class);
    }

    /**
     * Get the career jobs for the admin.
     */
    public function jobs(): HasMany
    {
        return $this->hasMany(\App\Models\Career\Job::class);
    }

    /**
     * Get the career notes for the admin.
     */
    public function notes(): HasMany
    {
        return $this->hasMany(\App\Models\Career\Note::class);
    }

    /**
     * Get the career references for the admin.
     */
    public function references(): HasMany
    {
        return $this->hasMany(\App\Models\Career\Reference::class);
    }

    /**
     * Get the career resumes for the admin.
     */
    public function resumes(): HasMany
    {
        return $this->hasMany(\App\Models\Career\Resume::class);
    }

    /**
     * Get the career skills for the admin.
     */
    public function skills(): HasMany
    {
        return $this->hasMany(\App\Models\Career\Skill::class);
    }

    /**
     * Get the portfolio art for the admin.
     */
    public function art(): HasMany
    {
        return $this->hasMany(\App\Models\Portfolio\Art::class);
    }

    /**
     * Get the portfolio certifications for the admin.
     */
    public function certifications(): HasMany
    {
        return $this->hasMany(\App\Models\Portfolio\Certification::class);
    }

    /**
     * Get the portfolio courses for the admin.
     */
    public function courses(): HasMany
    {
        return $this->hasMany(\App\Models\Portfolio\Course::class);
    }

    /**
     * Get the portfolio links for the admin.
     */
    public function links(): HasMany
    {
        return $this->hasMany(\App\Models\Portfolio\Link::class);
    }

    /**
     * Get the portfolio music for the admin.
     */
    public function music(): HasMany
    {
        return $this->hasMany(\App\Models\Portfolio\Music::class);
    }

    /**
     * Get the portfolio projects for the admin.
     */
    public function projects(): HasMany
    {
        return $this->hasMany(\App\Models\Portfolio\Project::class);
    }

    /**
     * Get the portfolio readings for the admin.
     */
    public function readings(): HasMany
    {
        return $this->hasMany(\App\Models\Portfolio\Reading::class);
    }

    /**
     * Get the portfolio recipes for the admin.
     */
    public function recipes(): HasMany
    {
        return $this->hasMany(\App\Models\Portfolio\Recipe::class);
    }

    /**
     * Get the portfolio videos for the admin.
     */
    public function videos(): HasMany
    {
        return $this->hasMany(\App\Models\Portfolio\Video::class);
    }
}
