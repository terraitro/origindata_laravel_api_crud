<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Employee extends Model
{
    use HasFactory;

    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class, 'company_has_employees');
    }

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'employee_has_projects');
    }
}
