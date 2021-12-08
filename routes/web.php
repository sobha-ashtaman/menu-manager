<?php

use Illuminate\Support\Facades\Route;
use DevSobSud\MenuManager\Http\Controllers\MenuController;

Route::get('menus', [MenuController::class, 'index'])->name('menu-manager.menus.index');
Route::get('menus/create', [MenuController::class, 'create'])->name('menu-manager.menus.create');
Route::get('menus/edit/{id}', [MenuController::class, 'edit'])->name('menu-manager.menus.edit');
Route::get('menus/destroy/{id}', [MenuController::class, 'destroy'])->name('menu-manager.menus.destroy');
Route::get('menus/change-status/{id}', [MenuController::class, 'changeStatus'])->name('menu-manager.menus.change-status');
Route::post('menus/store', [MenuController::class, 'store'])->name('menu-manager.menus.store');
Route::post('menus/update', [MenuController::class, 'update'])->name('menu-manager.menus.update');