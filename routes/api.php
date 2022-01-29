<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\AwardLetterController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'prefix' => 'auth'
], function () {
    // Route::post('/login/admin', [AuthController::class, 'loginAdmin'])->name('auth.admin-login');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');    
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
    Route::post('/update-password', [AuthController::class, 'updatePassword']);

    Route::group(['middleware' => 'auth:sanctum',], function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::post('/profile', [AuthController::class, 'profile'])->name('profile');
        Route::post('/refresh', [AuthController::class, 'refresh'])->name('token.refresh');

        // previleges
        // Route::apiResource('privilege', App\Http\Controllers\PrivilegeController::class);

        // Route::apiResource('privilege-class', App\Http\Controllers\PrivilegeClassController::class);

        // Route::apiResource('privilege-detail', App\Http\Controllers\PrivilegeDetailController::class);

        // Route::apiResource('menu', App\Http\Controllers\MenuController::class);

        // Route::apiResource('menu-authorization', App\Http\Controllers\MenuAuthorizationController::class);
    });
});

Route::group(['middleware' => 'auth:sanctum',], function () {   
    // previleges
    Route::apiResource('privileges', App\Http\Controllers\PrivilegeController::class);
    
    Route::apiResource('privilege-classes', App\Http\Controllers\PrivilegeClassController::class);
    
    Route::apiResource('privilege-details', App\Http\Controllers\PrivilegeDetailController::class);
    
    Route::apiResource('menus', App\Http\Controllers\MenuController::class);
    
    Route::apiResource('menu-authorizations', App\Http\Controllers\MenuAuthorizationController::class);

    Route::apiResource('award-letters', App\Http\Controllers\AwardLetterController::class);

    Route::apiResource('banks', App\Http\Controllers\BankController::class);

    Route::apiResource('bank-references', App\Http\Controllers\BankReferenceController::class);

    Route::apiResource('charts', App\Http\Controllers\ChartController::class);

    Route::apiResource('chart-categories', App\Http\Controllers\ChartCategoryController::class);

    Route::apiResource('chart-providers', App\Http\Controllers\ChartProviderController::class);

    Route::apiResource('chart-types', App\Http\Controllers\ChartTypeController::class);

    Route::apiResource('contractors', App\Http\Controllers\ContractorController::class);

    Route::apiResource('contractor-affliates', App\Http\Controllers\ContractorAffliateController::class);

    Route::apiResource('dashboard-settings', App\Http\Controllers\DashboardSettingController::class);

    Route::apiResource('modules', App\Http\Controllers\ModuleController::class);

    Route::apiResource('projects', App\Http\Controllers\ProjectController::class);

    Route::apiResource('property-types', App\Http\Controllers\PropertyTypeController::class);

    Route::apiResource('states', App\Http\Controllers\StateController::class);

    Route::apiResource('submodules', App\Http\Controllers\SubmoduleController::class);

    Route::apiResource('court-cases', App\Http\Controllers\CourtCaseController::class);

    Route::apiResource('suit-parties', App\Http\Controllers\SuitPartyController::class);

    Route::apiResource('legal-documents', App\Http\Controllers\LegalDocumentController::class);

    Route::apiResource('case-activities', App\Http\Controllers\CaseActivityController::class);

    Route::apiResource('calendar-events', App\Http\Controllers\CalendarEventController::class);

    Route::apiResource('contract-categories', App\Http\Controllers\ContractCategoryController::class);

    Route::apiResource('contract-types', App\Http\Controllers\ContractTypeController::class);

    Route::apiResource('durations', App\Http\Controllers\DurationController::class);

    Route::apiResource('employees', App\Http\Controllers\EmployeeController::class);

    Route::get('/pending-award-letters', [AwardLetterController::class, 'pending'])->name('pending-award-letter');
});

Route::post('/upload', [FileUploadController::class, 'upload'])->name('file.upload');

Route::get('/get/{filename}/{visibility?}', [FileUploadController::class, 'getFile'])->name('file.get');