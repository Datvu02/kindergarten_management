<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Services\LogService;
use App\Services\UserService;
use App\Http\Requests\DeleteUserRequest;
use App\Http\Requests\ShowTeacherRequest;
use App\Http\Requests\GetListPupilRequest;
use App\Http\Requests\AddUserPupilRequest;
use App\Http\Requests\GetListTeacherRequest;
use App\Http\Requests\AddUserTeacherRequest;
use App\Http\Requests\MonthlyCheckInRequest;
use App\Http\Requests\UpdateUserPupilRequest;
use App\Http\Requests\UpdateUserTeacherRequest;

class UserController extends Controller
{
    protected $userService;
    protected $logService;

    public function __construct(
        UserService $userService, 
        LogService $logService
    ){
        $this->userService = $userService;
        $this->logService = $logService;
    }

    public function showTeacher(ShowTeacherRequest $request): JsonResponse
    {
        $this->logService->info("Teacher detail start: ", $request->all());

        try {
            $result = $this->userService->showTeacher($request->id);

            if (isset($result['message'])){
                $this->logService->warning('Teacher detail', $result);

                return $this->errorResponse($result['message']);
            }

            $this->logService->info('Teacher detail finish successful', $result);
            return $this->successResponse($result);
        } catch (\Exception $e) {
            $this->logService->error('UserController->showTeacher '. $e->getMessage());
            
            return $this->internalErrorResponse();
        }
    }

    public function addUserTeacher(AddUserTeacherRequest $request): JsonResponse
    {
        $this->logService->info("Add teacher start: ", $request->all());

        try {
            $result = $this->userService->addUserTeacher($request);

            if (isset($result['message'])){
                $this->logService->warning('Add teacher', $result);

                return $this->errorResponse($result['message']);
            } 

            $this->logService->info('Add teacher finish successful', $result);
            return $this->successResponse($result);
        } catch (\Exception $e) {
            $this->logService->error('UserController->addUserTeacher'. $e->getMessage());
            
            return $this->internalErrorResponse();
        }
    }

    public function updateUserTeacher(UpdateUserTeacherRequest $request): JsonResponse
    {
        $this->logService->info("Update teacher start: ", $request->all());

        try {
            $result = $this->userService->updateUserTeacher($request);

            if (isset($result['message'])){
                $this->logService->warning('Update teacher', $result);

                return $this->errorResponse($result['message']);
            } 

            $this->logService->info('Update teacher finish successful', $result);
            return $this->successResponse($result);
        } catch (\Exception $e) {
            $this->logService->error('UserController->updateUserTeacher'. $e->getMessage());
            
            return $this->internalErrorResponse();
        }
    }

    public function deleteUserTeacher(DeleteUserRequest $request): JsonResponse
    {
        $this->logService->info("Delete teacher start: ", $request->all());

        try {
            $result = $this->userService->deleteUserTeacher($request->id);

            if (isset($result['message'])){
                $this->logService->warning('Delete teacher', $result);

                return $this->errorResponse($result['message']);
            } 

            $this->logService->info('Delte teacher finish successful', $result);
            return $this->successResponse($result);
        } catch (\Exception $e) {
            dd($e);
            $this->logService->error('UserController->deleteUserTeacher'. $e->getMessage());
            
            return $this->internalErrorResponse();
        }
    }

    public function addUserPupil(AddUserPupilRequest $request): JsonResponse
    {
        $this->logService->info("Add pupil start: ", $request->all());

        try {
            $result = $this->userService->addUserPupil($request);

            if (isset($result['message'])){
                $this->logService->warning('Add pupil', $result);

                return $this->errorResponse($result['message']);
            } 

            $this->logService->info('Add pupil finish successful', $result);
            return $this->successResponse($result);
        } catch (\Exception $e) {
            $this->logService->error('UserController->addUserpupil'. $e->getMessage());
            
            return $this->internalErrorResponse();
        }
    }

    public function updateUserPupil(UpdateUserPupilRequest $request): JsonResponse
    {
        $this->logService->info("Update pupil start: ", $request->all());

        try {
            $result = $this->userService->updateUserPupil($request);

            if (isset($result['message'])){
                $this->logService->warning('pupil teacher', $result);

                return $this->errorResponse($result['message']);
            } 

            $this->logService->info('Update pupil finish successful', $result);
            return $this->successResponse($result);
        } catch (\Exception $e) {
            $this->logService->error('UserController->updateUserPupil'. $e->getMessage());
            
            return $this->internalErrorResponse();
        }
    }

    public function deleteUserPupil(DeleteUserRequest $request): JsonResponse
    {
        $this->logService->info("Delete pupil start: ", $request->all());

        try {
            $result = $this->userService->deleteUserPupil( $request->id);

            if (isset($result['message'])){
                $this->logService->warning('Delete pupil', $result);

                return $this->errorResponse($result['message']);
            } 

            $this->logService->info('Delete pupil finish successful', $result);
            return $this->successResponse($result);
        } catch (\Exception $e) {
            $this->logService->error('UserController->deleteUserPupil'. $e->getMessage());
            
            return $this->internalErrorResponse();
        }
    }

    public function getListTeacher(GetListTeacherRequest $request): JsonResponse
    {
        $this->logService->info("Get list of class teacher start: ", $request->all());

        try {
            $result = $this->userService->getListTeacher($request);

            if (isset($result['message'])){
                $this->logService->warning('Get list of class teacher', $result);

                return $this->errorResponse($result['message']);
            } 

            $this->logService->info('Get list teacher finish successful', $result);
            return $this->successResponse($result);
        } catch (\Exception $e) {
            $this->logService->error('UserController->getListTeachers'. $e->getMessage());
            
            return $this->internalErrorResponse();
        }
    }

    public function getListPupil(GetListPupilRequest $request): JsonResponse
    {
        $this->logService->info("Get list pupil start: ", $request->all());

        try {
            $result = $this->userService->getListPupil($request);

            if (isset($result['message'])){
                $this->logService->warning('Get list pupil', $result);

                return $this->errorResponse($result['message']);
            } 

            $this->logService->info('Get list pupil finish successful', $result);
            return $this->successResponse($result);
        } catch (\Exception $e) {
            $this->logService->error('UserController->getListPupils'. $e->getMessage());
            
            return $this->internalErrorResponse();
        }
    }

    public function checkInUser()
    {
        $this->logService->info("checkInUser start: ");

        try {
            $result = $this->userService->checkInUser();

            if (isset($result['message'])){
                $this->logService->warning('checkInUser : ', $result);

                return $this->errorResponse($result['message']);
            } 

            $this->logService->info('checkInUser finish successful', $result);
            return $this->successResponse($result);
        } catch (\Exception $e) {
            $this->logService->error('UserController->checkInUser'. $e->getMessage());
            
            return $this->internalErrorResponse();
        }
    }

    public function monthlyCheckIn(MonthlyCheckInRequest $request)
    {
        $this->logService->info("monthlyCheckIn start: ", $request->all());

        try {
            $result = $this->userService->monthlyCheckIn($request);

            if (isset($result['message'])){
                $this->logService->warning('monthlyCheckIn : ', $result);

                return $this->errorResponse($result['message']);
            } 

            $this->logService->info('monthlyCheckIn finish successful', $result);
            return $this->successResponse($result);
        } catch (\Exception $e) {
            $this->logService->error('UserController->monthlyCheckIn'. $e->getMessage());
            
            return $this->internalErrorResponse();
        }
    }
}
