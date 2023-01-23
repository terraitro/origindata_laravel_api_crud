<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Company extends Model
{
    use HasFactory;

    public function employees(): BelongsToMany
    {
        return $this->belongsToMany(Employee::class, 'company_has_employees');
    }

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'company_has_projects');
    }
}
