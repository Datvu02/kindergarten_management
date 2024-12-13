<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Services\ClassroomService;
use App\Services\LogService;
use App\Http\Requests\AddClassRequest;
use App\Http\Requests\ShowClassRequest;
use App\Http\Requests\UpdateClassRequest;
use App\Http\Requests\DeleteClassRequest;
use App\Http\Requests\GetListOfClassRequest;
use App\Http\Requests\AddTeacherOrPupilToClassRequest;

class ClassroomController extends Controller
{
    protected $classroomService;
    protected $logService;

    public function __construct(
        ClassroomService $classroomService, 
        LogService $logService
    ){
        $this->classroomService = $classroomService;
        $this->logService = $logService;
    }

    public function getListOfClassTeachers(GetListOfClassRequest $request): JsonResponse
    {
        $this->logService->info("Get list of class teacher start: ", $request->all());

        try {
            $result = $this->classroomService->getListOfClassTeachers($request->id);
            if (isset($result['message'])){
                $this->logService->warning('Get list of class teacher', $result);

                return $this->errorResponse($result['message']);
            } 

            $this->logService->info('Get list of class teacher finish successful', $result);
            return $this->successResponse($result);
        } catch (\Exception $e) {
            $this->logService->error('UserController->getListOfClassTeachers'. $e->getMessage());
            
            return $this->internalErrorResponse();
        }
    }

    public function getListOfClassPupils(GetListOfClassRequest $request): JsonResponse
    {
        $this->logService->info("Get list of class pupil start: ", $request->all());

        try {
            $result = $this->classroomService->getListOfClassPupils($request->all());

            if (isset($result['message'])){
                $this->logService->warning('Get list of class pupil', $result);

                return $this->errorResponse($result['message']);
            } 

            $this->logService->info('Get list of class pupil finish successful', $result);
            return $this->successResponse($result);
        } catch (\Exception $e) {
            $this->logService->error('UserController->getListOfClassPupils'. $e->getMessage());
            
            return $this->internalErrorResponse();
        }
    }

    public function showClass(ShowClassRequest $request): JsonResponse
    {
        $this->logService->info("Class detail start: ", $request->all());

        try {
            $result = $this->classroomService->showClass($request->id);

            if (isset($result['message'])){
                $this->logService->warning('Class detail: ', $result);

                return $this->errorResponse($result['message']);
            } 

            $this->logService->info('Class detail finish successful: ', $result);
            return $this->successResponse($result);
        } catch (\Exception $e) {
            $this->logService->error('ShowClass: '. $e->getMessage());
            
            return $this->internalErrorResponse();
        }
    }

    public function addClass(AddClassRequest $request): JsonResponse
    {
        $this->logService->info("Add class start: ", $request->all());
        // dd($request->all());
        try {
            $result = $this->classroomService->addClass($request->all());
            
            if (isset($result['message'])){
            $this->logService->warning('Add class', $result);
                return $this->errorResponse($result['message']);
            } 
            // dd($result->array());
            $this->logService->info('Add class successful');
            return $this->successResponse($result);

        } catch (\Exception $e) {
            $this->logService->error('UserController->addClass'. $e->getMessage());

            return $this->internalErrorResponse();
        }
    }

    public function updateClass(UpdateClassRequest $request): JsonResponse
    {
        $this->logService->info("Update class start: ", $request->all());

        try {
            $result = $this->classroomService->updateClass($request);

            if (isset($result['message'])){
                $this->logService->warning('Update class', $result);

                return $this->errorResponse($result['message']);
            } 

            $this->logService->info('Update class finish successful', $result);
            return $this->successResponse($result);
        } catch (\Exception $e) {
            $this->logService->error('UserController->updateClass'. $e->getMessage());
            
            return $this->internalErrorResponse();
        }
    }

    public function deleteClass(DeleteClassRequest  $request): JsonResponse
    {
        $this->logService->info("Delete class start: ", $request->all());

        try {
            $result = $this->classroomService->deleteClass($request->id);

            if (isset($result['message'])){
                $this->logService->warning('Delete class', $result);

                return $this->errorResponse($result['message']);
            } 

            $this->logService->info('Delete class finish successful');
            return $this->successResponse();
        } catch (\Exception $e) {
            $this->logService->error('UserController->deleteClass'. $e->getMessage());
            
            return $this->internalErrorResponse();
        }
    }

    public function addTeacherOrPupilToClass(AddTeacherOrPupilToClassRequest $request): JsonResponse
    {
        $this->logService->info("Add teacher or pupil to class start: ", $request->all());

        try {
            $result = $this->classroomService->addTeacherOrPupilToClass($request);

            if (isset($result['message'])){
                $this->logService->warning('Add teacher or pupil to class', $result);

                return $this->errorResponse($result['message']);
            } 

            $this->logService->info('Add teacher or pupil to class finish successful', $result);
            return $this->successResponse($result);
        } catch (\Exception $e) {
            $this->logService->error('addTeacherOrPupilToClass'. $e->getMessage());
            
            return $this->internalErrorResponse();
        }
    }
    
    public function addPupilToClass(AddTeacherOrPupilToClassRequest $request): JsonResponse
    {
        $this->logService->info("Add pupil to class start: ", $request->all());

        try {
            $result = $this->classroomService->addPupilToClass($request);

            if (isset($result['message'])){
                $this->logService->warning('Add pupil to class', $result);

                return $this->errorResponse($result['message']);
            } 

            $this->logService->info('Add pupil to class finish successful', $result);
            return $this->successResponse($result);
        } catch (\Exception $e) {
            $this->logService->error('addPupilToClass'. $e->getMessage());
            
            return $this->internalErrorResponse();
        }
    }
}
