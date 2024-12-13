<?php

use App\Enums\RoleEnum;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\UserController;
use App\Mail\AutoEmail;
use Illuminate\Support\Facades\Mail;

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/getListClass', [ClassroomController::class,'getListClass'])->name('getListClass');
Route::get('/getListTeacher', [UserController::class,'getListTeacher'])->name('getListTeacher');
Route::get('/getListPupil', [UserController::class,'getListPupil'])->name('getListPupil');
Route::get('/getListOfClassTeachers',[ClassroomController::class,'getListOfClassTeachers'])->name('getListOfClassTeachers');
Route::get('/getListOfClassPupils',[ClassroomController::class,'getListOfClassPupils'])->name('getListOfClassPupils');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('role: ' . RoleEnum::PRINCIPAL->value)->group(function () {
        Route::controller( ClassroomController::class)->group(function () {
            Route::get('/showClass', 'showClass');
            Route::post('/addClass', 'addClass');
            Route::put('/updateClass', 'updateClass');
            Route::delete('/deleteClass', 'deleteClass');
            Route::post('/addTeacherOrPupilToClass', 'addTeacherOrPupilToClass');
        });

        Route::controller( UserController::class)->group(function () {
            Route::get('/showTeacher', 'showTeacher');
            Route::post('/addUserTeacher', 'addUserTeacher');
            Route::put('/updateUserTeacher', 'updateUserTeacher');
            Route::delete('/deleteUserTeacher', 'deleteUserTeacher');
        });
    });

    Route::middleware(['role:' . RoleEnum::PRINCIPAL->value . ';' . RoleEnum::HOMEROOM_TEACHER->value])->group(function () {    
        Route::controller( UserController::class)->group(function () {
            Route::post('/addUserPupil', 'addUserPupil');
            Route::put('/updateUserPupil', 'updatePupil');
            Route::delete('/deleteUserPupil', 'deleteUserPupil');
        });
        Route::post('/addPupilToClass', [ClassroomController::class,'addPupilToClass']);
    });
    
    Route::middleware(['role:' . RoleEnum::HOMEROOM_TEACHER->value . ';' . RoleEnum::TEACHER->value . ';' . RoleEnum::PUPIL->value])->group(function () {
        Route::post('/checkInUser', [UserController::class, 'checkInUser']);
    });
        Route::get('/monthlyCheckIn', [UserController::class, 'monthlyCheckIn']);
});