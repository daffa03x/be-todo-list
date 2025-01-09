<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChecklistController;
use App\Http\Controllers\ChecklistItemController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::middleware(['auth'])->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::get('/checklist', [ChecklistController::class, 'index']); 
    Route::post('/checklist', [ChecklistController::class, 'store']);
    Route::delete('/checklist/{id}', [ChecklistController::class, 'destroy']);
    Route::get('/checklist/{checklistId}/item', [ChecklistItemController::class, 'index']); 
    Route::post('/checklist/{checklistId}/item', [ChecklistItemController::class, 'store']);    
    Route::get('/checklist/{checklistId}/item/{itemId}', [ChecklistItemController::class, 'show']); 
    Route::put('/checklist/{checklistId}/item/{itemId}', [ChecklistItemController::class, 'updateStatus']); 
    Route::delete('/checklist/{checklistId}/item/{itemId}', [ChecklistItemController::class, 'destroy']); 
    Route::put('/checklist/{checklistId}/item/rename/{itemId}', [ChecklistItemController::class, 'rename']); 
});
