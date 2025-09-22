<?php  
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Backend\V2\Scholar\ScholarCatalogueController;
use App\Http\Controllers\Backend\V2\Scholar\ScholarController;
use App\Http\Controllers\Backend\V2\Scholar\PolicyController;
use App\Http\Controllers\Backend\V2\Scholar\TrainController;
use App\Http\Controllers\Backend\V2\Admission\AdmissionController;
use App\Http\Controllers\Backend\V2\Admission\AdmissionCatalogueController;
use App\Http\Controllers\Backend\V2\Major\MajorGroupController;
use App\Http\Controllers\Backend\V2\Major\MajorCatalogueController;
use App\Http\Controllers\Backend\V2\Major\MajorController;
use App\Http\Controllers\Backend\V2\School\SchoolCatalogueController;
use App\Http\Controllers\Backend\V2\School\SchoolController;
use App\Http\Controllers\Backend\V2\School\AreaController;
use App\Http\Controllers\Backend\V2\School\CityController;
use App\Http\Controllers\Backend\V2\School\ProjectController;

Route::middleware(['admin', 'locale', 'backend_default_locale'])->group(function () {

    /*Scholar*/

    Route::group(['prefix' => 'scholar'], function () {
        Route::get('index', [ScholarController::class, 'index'])->name('scholar.index')->middleware(['admin','locale']);
        Route::get('create', [ScholarController::class, 'create'])->name('scholar.create');
        Route::post('store', [ScholarController::class, 'store'])->name('scholar.store');
        Route::get('{id}/edit', [ScholarController::class, 'edit'])->where(['id' => '[0-9]+'])->name('scholar.edit');
        Route::post('{id}/update', [ScholarController::class, 'update'])->where(['id' => '[0-9]+'])->name('scholar.update');
        Route::get('{id}/delete', [ScholarController::class, 'delete'])->where(['id' => '[0-9]+'])->name('scholar.delete');
        Route::delete('{id}/destroy', [ScholarController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('scholar.destroy');
    });
    
    Route::group(['prefix' => 'scholar/catalogue'], function () {
        Route::get('index', [ScholarCatalogueController::class, 'index'])->name('scholar.catalogue.index')->middleware(['admin','locale']);
        Route::get('create', [ScholarCatalogueController::class, 'create'])->name('scholar.catalogue.create');
        Route::post('store', [ScholarCatalogueController::class, 'store'])->name('scholar.catalogue.store');
        Route::get('{id}/edit', [ScholarCatalogueController::class, 'edit'])->where(['id' => '[0-9]+'])->name('scholar.catalogue.edit');
        Route::post('{id}/update', [ScholarCatalogueController::class, 'update'])->where(['id' => '[0-9]+'])->name('scholar.catalogue.update');
        Route::get('{id}/delete', [ScholarCatalogueController::class, 'delete'])->where(['id' => '[0-9]+'])->name('scholar.catalogue.delete');
        Route::delete('{id}/destroy', [ScholarCatalogueController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('scholar.catalogue.destroy');
       
    });

    Route::group(['prefix' => 'scholar/policy'], function () {
        Route::get('index', [PolicyController::class, 'index'])->name('scholar.policy.index')->middleware(['admin','locale']);
        Route::get('create', [PolicyController::class, 'create'])->name('scholar.policy.create');
        Route::post('store', [PolicyController::class, 'store'])->name('scholar.policy.store');
        Route::get('{id}/edit', [PolicyController::class, 'edit'])->where(['id' => '[0-9]+'])->name('scholar.policy.edit');
        Route::post('{id}/update', [PolicyController::class, 'update'])->where(['id' => '[0-9]+'])->name('scholar.policy.update');
        Route::get('{id}/delete', [PolicyController::class, 'delete'])->where(['id' => '[0-9]+'])->name('scholar.policy.delete');
        Route::delete('{id}/destroy', [PolicyController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('scholar.policy.destroy');
       
    });

    Route::group(['prefix' => 'scholar/train'], function () {
        Route::get('index', [TrainController::class, 'index'])->name('scholar.train.index')->middleware(['admin','locale']);
        Route::get('create', [TrainController::class, 'create'])->name('scholar.train.create');
        Route::post('store', [TrainController::class, 'store'])->name('scholar.train.store');
        Route::get('{id}/edit', [TrainController::class, 'edit'])->where(['id' => '[0-9]+'])->name('scholar.train.edit');
        Route::post('{id}/update', [TrainController::class, 'update'])->where(['id' => '[0-9]+'])->name('scholar.train.update');
        Route::get('{id}/delete', [TrainController::class, 'delete'])->where(['id' => '[0-9]+'])->name('scholar.train.delete');
        Route::delete('{id}/destroy', [TrainController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('scholar.train.destroy');
    });

    /*Admission*/

    Route::group(['prefix' => 'admission'], function () {
        Route::get('index', [AdmissionController::class, 'index'])->name('admission.index')->middleware(['admin','locale']);
        Route::get('create', [AdmissionController::class, 'create'])->name('admission.create');
        Route::post('store', [AdmissionController::class, 'store'])->name('admission.store');
        Route::get('{id}/edit', [AdmissionController::class, 'edit'])->where(['id' => '[0-9]+'])->name('admission.edit');
        Route::post('{id}/update', [AdmissionController::class, 'update'])->where(['id' => '[0-9]+'])->name('admission.update');
        Route::get('{id}/delete', [AdmissionController::class, 'delete'])->where(['id' => '[0-9]+'])->name('admission.delete');
        Route::delete('{id}/destroy', [AdmissionController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('admission.destroy');
    });

    Route::group(['prefix' => 'admission/catalogue'], function () {
        Route::get('index', [AdmissionCatalogueController::class, 'index'])->name('admission.catalogue.index')->middleware(['admin','locale']);
        Route::get('create', [AdmissionCatalogueController::class, 'create'])->name('admission.catalogue.create');
        Route::post('store', [AdmissionCatalogueController::class, 'store'])->name('admission.catalogue.store');
        Route::get('{id}/edit', [AdmissionCatalogueController::class, 'edit'])->where(['id' => '[0-9]+'])->name('admission.catalogue.edit');
        Route::post('{id}/update', [AdmissionCatalogueController::class, 'update'])->where(['id' => '[0-9]+'])->name('admission.catalogue.update');
        Route::get('{id}/delete', [AdmissionCatalogueController::class, 'delete'])->where(['id' => '[0-9]+'])->name('admission.catalogue.delete');
        Route::delete('{id}/destroy', [AdmissionCatalogueController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('admission.catalogue.destroy');
       
    });

    /*Major*/

    Route::group(['prefix' => 'major_group'], function () {
        Route::get('index', [MajorGroupController::class, 'index'])->name('major_group.index')->middleware(['admin','locale']);
        Route::get('create', [MajorGroupController::class, 'create'])->name('major_group.create');
        Route::post('store', [MajorGroupController::class, 'store'])->name('major_group.store');
        Route::get('{id}/edit', [MajorGroupController::class, 'edit'])->where(['id' => '[0-9]+'])->name('major_group.edit');
        Route::post('{id}/update', [MajorGroupController::class, 'update'])->where(['id' => '[0-9]+'])->name('major_group.update');
        Route::get('{id}/delete', [MajorGroupController::class, 'delete'])->where(['id' => '[0-9]+'])->name('major_group.delete');
        Route::delete('{id}/destroy', [MajorGroupController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('major_group.destroy');
    });

    Route::group(['prefix' => 'major_catalogue'], function () {
        Route::get('index', [MajorCatalogueController::class, 'index'])->name('major_catalogue.index')->middleware(['admin','locale']);
        Route::get('create', [MajorCatalogueController::class, 'create'])->name('major_catalogue.create');
        Route::post('store', [MajorCatalogueController::class, 'store'])->name('major_catalogue.store');
        Route::get('{id}/edit', [MajorCatalogueController::class, 'edit'])->where(['id' => '[0-9]+'])->name('major_catalogue.edit');
        Route::post('{id}/update', [MajorCatalogueController::class, 'update'])->where(['id' => '[0-9]+'])->name('major_catalogue.update');
        Route::get('{id}/delete', [MajorCatalogueController::class, 'delete'])->where(['id' => '[0-9]+'])->name('major_catalogue.delete');
        Route::delete('{id}/destroy', [MajorCatalogueController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('major_catalogue.destroy');
       
    });

    Route::group(['prefix' => 'major'], function () {
        Route::get('index', [MajorController::class, 'index'])->name('major.index')->middleware(['admin','locale']);
        Route::get('create', [MajorController::class, 'create'])->name('major.create');
        Route::post('store', [MajorController::class, 'store'])->name('major.store');
        Route::get('{id}/edit', [MajorController::class, 'edit'])->where(['id' => '[0-9]+'])->name('major.edit');
        Route::post('{id}/update', [MajorController::class, 'update'])->where(['id' => '[0-9]+'])->name('major.update');
        Route::get('{id}/delete', [MajorController::class, 'delete'])->where(['id' => '[0-9]+'])->name('major.delete');
        Route::delete('{id}/destroy', [MajorController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('major.destroy');
       
    });

    /*School*/
    
    Route::group(['prefix' => 'school_catalogue'], function () {
        Route::get('index', [SchoolCatalogueController::class, 'index'])->name('school_catalogue.index')->middleware(['admin','locale']);
        Route::get('create', [SchoolCatalogueController::class, 'create'])->name('school_catalogue.create');
        Route::post('store', [SchoolCatalogueController::class, 'store'])->name('school_catalogue.store');
        Route::get('{id}/edit', [SchoolCatalogueController::class, 'edit'])->where(['id' => '[0-9]+'])->name('school_catalogue.edit');
        Route::post('{id}/update', [SchoolCatalogueController::class, 'update'])->where(['id' => '[0-9]+'])->name('school_catalogue.update');
        Route::get('{id}/delete', [SchoolCatalogueController::class, 'delete'])->where(['id' => '[0-9]+'])->name('school_catalogue.delete');
        Route::delete('{id}/destroy', [SchoolCatalogueController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('school_catalogue.destroy');
       
    });

    Route::group(['prefix' => 'school'], function () {
        Route::get('index', [SchoolController::class, 'index'])->name('school.index')->middleware(['admin','locale']);
        Route::get('create', [SchoolController::class, 'create'])->name('school.create');
        Route::post('store', [SchoolController::class, 'store'])->name('school.store');
        Route::get('{id}/edit', [SchoolController::class, 'edit'])->where(['id' => '[0-9]+'])->name('school.edit');
        Route::post('{id}/update', [SchoolController::class, 'update'])->where(['id' => '[0-9]+'])->name('school.update');
        Route::get('{id}/delete', [SchoolController::class, 'delete'])->where(['id' => '[0-9]+'])->name('school.delete');
        Route::delete('{id}/destroy', [SchoolController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('school.destroy');
       
    });

    Route::group(['prefix' => 'school/area'], function () {
        Route::get('index', [AreaController::class, 'index'])->name('school.area.index')->middleware(['admin','locale']);
        Route::get('create', [AreaController::class, 'create'])->name('school.area.create');
        Route::post('store', [AreaController::class, 'store'])->name('school.area.store');
        Route::get('{id}/edit', [AreaController::class, 'edit'])->where(['id' => '[0-9]+'])->name('school.area.edit');
        Route::post('{id}/update', [AreaController::class, 'update'])->where(['id' => '[0-9]+'])->name('school.area.update');
        Route::get('{id}/delete', [AreaController::class, 'delete'])->where(['id' => '[0-9]+'])->name('school.area.delete');
        Route::delete('{id}/destroy', [AreaController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('school.area.destroy');
       
    });

    Route::group(['prefix' => 'school/city'], function () {
        Route::get('index', [CityController::class, 'index'])->name('school.city.index')->middleware(['admin','locale']);
        Route::get('create', [CityController::class, 'create'])->name('school.city.create');
        Route::post('store', [CityController::class, 'store'])->name('school.city.store');
        Route::get('{id}/edit', [CityController::class, 'edit'])->where(['id' => '[0-9]+'])->name('school.city.edit');
        Route::post('{id}/update', [CityController::class, 'update'])->where(['id' => '[0-9]+'])->name('school.city.update');
        Route::get('{id}/delete', [CityController::class, 'delete'])->where(['id' => '[0-9]+'])->name('school.city.delete');
        Route::delete('{id}/destroy', [CityController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('school.city.destroy');
    });

    Route::group(['prefix' => 'school/project'], function () {
        Route::get('index', [ProjectController::class, 'index'])->name('school.project.index')->middleware(['admin','locale']);
        Route::get('create', [ProjectController::class, 'create'])->name('school.project.create');
        Route::post('store', [ProjectController::class, 'store'])->name('school.project.store');
        Route::get('{id}/edit', [ProjectController::class, 'edit'])->where(['id' => '[0-9]+'])->name('school.project.edit');
        Route::post('{id}/update', [ProjectController::class, 'update'])->where(['id' => '[0-9]+'])->name('school.project.update');
        Route::get('{id}/delete', [ProjectController::class, 'delete'])->where(['id' => '[0-9]+'])->name('school.project.delete');
        Route::delete('{id}/destroy', [ProjectController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('school.project.destroy');
    });

});

