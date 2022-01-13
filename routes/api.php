<?php

use App\Http\Controllers\AuthController;
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
        Route::post('/refresh', [AuthController::class, 'refresh'])->name('token.refresh');
    });
});


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
