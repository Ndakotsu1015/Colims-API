<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\AwardLetterController;
use App\Http\Controllers\BankReferenceController;
use App\Http\Controllers\CaseRequestController;
use App\Http\Controllers\CourtCaseController;
use App\Http\Controllers\UserController;

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

    Route::get('/dashboard-settings-contract', [App\Http\Controllers\DashboardSettingController::class, 'contract'])->name('contracts');

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

    Route::apiResource('users', App\Http\Controllers\UserController::class);

    Route::get('/pending-award-letters', [AwardLetterController::class, 'pending'])->name('pending-award-letter');

    Route::get('/award-letters-with-bank-guarantee', [AwardLetterController::class, 'awardLetterWithBankGuarantee'])->name('award-letters-with-bank-guarantee');

    Route::get('/award-letters-check-ref-no/{ref_no}', [AwardLetterController::class, 'checkRefNo'])->name('check-ref-no');

    Route::get('/bank-reference-check-ref-no/{ref_no}', [BankReferenceController::class, 'checkRefNo'])->name('check-ref-no');

    Route::get('/email-check/{email}', [UserController::class, 'emailCheck'])->name('email-check');

    Route::get('/award-letter-renewals', [AwardLetterController::class, 'awardLetterRenewals'])->name('award-letter-renewals');

    Route::apiResource('case-status', App\Http\Controllers\CaseStatusController::class);

    Route::apiResource('case-outcome', App\Http\Controllers\CaseOutcomeController::class);

    Route::apiResource('legal-document-types', App\Http\Controllers\LegalDocumentTypeController::class);

    Route::apiResource('solicitors', App\Http\Controllers\SolicitorController::class);

    Route::apiResource('case-participants', App\Http\Controllers\CaseParticipantController::class);

    Route::apiResource('case-requests', App\Http\Controllers\CaseRequestController::class);

    Route::get('case-requests/{id}/is-case-created', [App\Http\Controllers\CaseRequestController::class, 'isCaseCreated']);

    Route::get('/case-request-awaiting-reviewer-assignment', [CaseRequestController::class, 'awaitingReviewerAssignment'])->name('case-request-awaiting-reviewer-assignment');

    Route::get('/case-request-awaiting-recommendation', [CaseRequestController::class, 'awaitingRecommendation'])->name('case-request-awaiting-recommendation');

    Route::get('/case-request-awaiting-approval', [CaseRequestController::class, 'awaitingApproval'])->name('case-request-awaiting-approval');

    Route::get('/active-case-request', [CaseRequestController::class, 'activeCaseRequests'])->name('active-case-request');

    Route::get('/inactive-case-request', [CaseRequestController::class, 'inactiveCaseRequests'])->name('inactive-case-request');

    Route::post('/assign-case-reviewer', [CaseRequestController::class, 'assignCaseReviewer'])->name('assign-case-reviewer');

    Route::post('/case-reviewer-recommendation/{id}', [CaseRequestController::class, 'caseReviewerRecommendation'])->name('case-reviewer-recommendation');

    Route::post('/case-request-approval', [CaseRequestController::class, 'caseRequestApproval'])->name('case-request-approval');

    Route::post('/case-request-discarded', [CaseRequestController::class, 'caseRequestDiscarded'])->name('case-request-discarded');

    Route::apiResource('case-request-movements', App\Http\Controllers\CaseRequestMovementController::class);

    Route::get('court-cases/{id}/calendar-events', [App\Http\Controllers\CourtCaseController::class, 'getCalendarEvents']);

    Route::get('court-cases/{id}/case-activities', [App\Http\Controllers\CourtCaseController::class, 'getCaseActivities']);

    Route::get('court-cases/{id}/suit-parties', [App\Http\Controllers\CourtCaseController::class, 'getSuitParties']);
});

Route::post('/upload', [FileUploadController::class, 'upload'])->name('file.upload');

Route::get('/file/get/{filename}/{visibility?}', [FileUploadController::class, 'getFile'])->name('file.get');

Route::get('legal-documents/{id}/court-case', [App\Http\Controllers\LegalDocumentController::class, 'getCourtCase']);
