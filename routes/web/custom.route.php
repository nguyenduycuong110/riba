<?php  
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Backend\V2\Scholar\PolicyControllerController;
use App\Http\Controllers\Backend\V2\Scholar\PolicyController;



Route::middleware(['admin', 'locale', 'backend_default_locale'])->group(function () {
    
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
});

