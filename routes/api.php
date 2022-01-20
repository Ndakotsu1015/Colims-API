<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FileUploadController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
    });
});

// fileupload route group
Route::prefix('file')/*->middleware('auth:api')*/->group(function () {
    Route::post('/upload', [FileUploadController::class, 'upload'])->name('file.upload');

    Route::get('/get/{filename}/{visibility?}', [FileUploadController::class, 'getFile'])->name('file.get');

}); 

Route::group(['middleware' => 'auth:sanctum',], function () {      
    // previleges
    Route::apiResource('privilege', App\Http\Controllers\PrivilegeController::class);
    
    Route::apiResource('privilege-class', App\Http\Controllers\PrivilegeClassController::class);
    
    Route::apiResource('privilege-detail', App\Http\Controllers\PrivilegeDetailController::class);
    
    Route::apiResource('menu', App\Http\Controllers\MenuController::class);
    
    Route::apiResource('menu-authorization', App\Http\Controllers\MenuAuthorizationController::class);
        
    Route::apiResource('award-letter', App\Http\Controllers\AwardLetterController::class);

    Route::apiResource('bank', App\Http\Controllers\BankController::class);

    Route::apiResource('bank-reference', App\Http\Controllers\BankReferenceController::class);

    Route::apiResource('chart', App\Http\Controllers\ChartController::class);

    Route::apiResource('chart-category', App\Http\Controllers\ChartCategoryController::class);

    Route::apiResource('chart-provider', App\Http\Controllers\ChartProviderController::class);

    Route::apiResource('chart-type', App\Http\Controllers\ChartTypeController::class);

    Route::apiResource('contractor', App\Http\Controllers\ContractorController::class);

    Route::apiResource('contractor-affliate', App\Http\Controllers\ContractorAffliateController::class);

    Route::apiResource('dashboard-setting', App\Http\Controllers\DashboardSettingController::class);

    Route::apiResource('module', App\Http\Controllers\ModuleController::class);

    Route::apiResource('project', App\Http\Controllers\ProjectController::class);

    Route::apiResource('property-type', App\Http\Controllers\PropertyTypeController::class);

    Route::apiResource('state', App\Http\Controllers\StateController::class);

    Route::apiResource('submodule', App\Http\Controllers\SubmoduleController::class);
});


Route::apiResource('court-case', App\Http\Controllers\CourtCaseController::class);

Route::apiResource('suit-party', App\Http\Controllers\SuitPartyController::class);

Route::apiResource('legal-document', App\Http\Controllers\LegalDocumentController::class);

Route::apiResource('case-activity', App\Http\Controllers\CaseActivityController::class);

Route::apiResource('calendar-event', App\Http\Controllers\CalendarEventController::class);
