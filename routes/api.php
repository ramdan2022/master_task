<?php


use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AuthUser;
use App\Http\Controllers\AuthUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

#================ Tasks ==================
route::controller(TaskController::class)->prefix('tasks')->group(function () {

    route::get('/',  'index');
    route::post('/create', 'create');
    route::post('update/{id}', 'update');
    route::delete('destroy/{id}', 'destroy');
});

#=================== Projects ========================

route::controller(ProjectController::class)->prefix('project')->group(function () {

    route::get('/', 'index');
    route::post('/set', 'set');
    route::put('/update/{id}', 'update');
    route::delete('/delete/{id}', 'delete');
});

#==================== Users =======================

route::controller(AuthUserController::class)->prefix('user')->group(function () {

    route::post('/register', 'register');
    route::post('/login', 'login');
    route::post('/logout', 'logout')->middleware('auth:sanctum');
});
