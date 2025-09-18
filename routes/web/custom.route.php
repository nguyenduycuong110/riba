<?php  
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Backend\V2\Scholar\ScholarCatalogueController;



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
});

