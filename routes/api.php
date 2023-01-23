<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\ProjectController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function (){
    Route::prefix('companies')->name('companies.')
        ->group(function (){
            Route::get('/', [CompanyController::class, 'index'])->name('index');
            Route::post('/', [CompanyController::class, 'store'])->name('store')
                ->middleware('auth:sanctum');
            Route::get('/{company}', [CompanyController::class, 'show'])->name('show');
            Route::put('/{company}', [CompanyController::class, 'update'])->name('update')
                ->middleware('auth:sanctum');
            Route::delete('/{company}', [CompanyController::class, 'destroy'])->name('destroy')
                ->middleware('auth:sanctum');
            Route::post('/{company}/attachEmployee/{employee}', [CompanyController::class, 'attachEmployee'])
                ->name('attachEmployee')
                ->middleware('auth:sanctum');
            Route::post('/{company}/detachEmployee/{employee}', [CompanyController::class, 'detachEmployee'])
                ->name('detachEmployee')
                ->middleware('auth:sanctum');
        });

    Route::prefix('employees')->name('employees.')
        ->group(function (){
            Route::get('/', [EmployeeController::class, 'index'])->name('index');
            Route::post('/', [EmployeeController::class, 'store'])->name('store')->middleware('auth:sanctum');
            Route::get('/{employee}', [EmployeeController::class, 'show'])->name('show');
            Route::put('/{employee}', [EmployeeController::class, 'update'])->name('update')->middleware('auth:sanctum');
            Route::delete('/{employee}', [EmployeeController::class, 'destroy'])->name('destroy')->middleware('auth:sanctum');
            Route::post('/{employee}/attachProject/{project}', [EmployeeController::class, 'attachProject'])
                ->name('attachProject')
                ->middleware('auth:sanctum');
            Route::post('/{employee}/detachProject/{project}', [EmployeeController::class, 'detachProject'])
                ->name('detachProject')
                ->middleware('auth:sanctum');
        });

    Route::prefix('projects')->name('projects.')
        ->group(function (){
            Route::get('/', [ProjectController::class, 'index'])->name('index');
            Route::post('/', [ProjectController::class, 'store'])->name('store')->middleware('auth:sanctum');
            Route::get('/{project}', [ProjectController::class, 'show'])->name('show');
            Route::put('/{project}', [ProjectController::class, 'update'])->name('update')->middleware('auth:sanctum');
            Route::delete('/{project}', [ProjectController::class, 'destroy'])->name('destroy')->middleware('auth:sanctum');
            Route::post('/{project}/attachCompany/{company}', [ProjectController::class, 'attachCompany'])
                ->name('attachCompany')
                ->middleware('auth:sanctum');
            Route::post('/{project}/detachCompany/{company}', [ProjectController::class, 'detachCompany'])
                ->name('detachCompany')
                ->middleware('auth:sanctum');
        });
});
