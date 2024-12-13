<?php

namespace App\Services;

use App\Models\User;
use App\Models\Classroom;
use App\Helpers\ResponseCode;
use App\Enums\RoleEnum;

use function PHPUnit\Framework\isEmpty;

class ClassroomService 
{
    protected $logService;

    public function __construct(
        LogService $logService
    ){
        $this->logService = $logService;
    }
    

    public function getListOfClassTeachers($id)
    {
        $classroom = Classroom::find($id);

        if (! isset($classroom)) {
            return [
                'message' => __('message')[ResponseCode::ERROR_CLASS_NOT_FOUND],
            ];
        }

        $teachers = User::whereHas('userClass', function ($query) use ($id) {
            $query->where('user_class.class_name', $id);
        })->whereIn('authority', [RoleEnum::TEACHER, RoleEnum::HOMEROOM_TEACHER])
        ->select('id', 'name_id', 'user_name', 'address', 'phone', 'yob', 'year_old')->get();

        return [
            'teachers' => $teachers ?? [],
        ];
    }

    public function getListOfClassPupils($id)
    {
        
        $classroom = Classroom::find($id);

        if (! isset($classroom)) {
            return [
                'message' => __('message')[ResponseCode::ERROR_CLASS_NOT_FOUND],
            ];
        }

        $pupils = User::whereHas('userClass', function ($query) use ($id) {
            $query->where('user_class.class_name', $id);
        })->where('authority', RoleEnum::PUPIL)
        ->select('id', 'name_id', 'user_name', 'address', 'phone_parent', 'yob', 'year_old')->get();

        return [
            'pupils' => $pupils ?? [],
        ];
    }

    public function showClass($id)
    {
        $classroom = Classroom::find($id);

        if (! isset($classroom)) {
            return [
                'message' => __('message')[ResponseCode::ERROR_CLASS_NOT_FOUND],
            ];
        }

        $homeRoomTeacher = User::where('id', $classroom->homeroom_teacher_id)->select('user_name')->first();

        $users = User::whereHas('userClass', function ($query) use ($id) {
            $query->where('user_class.class_name', $id);
        })->where('authority', [RoleEnum::TEACHER, RoleEnum::PUPIL])->select('user_name')->get()->groupBy('authority');

        return [
            'class_name' => $classroom->class_name,
            'homeroom_teacher' => $homeRoomTeacher->user_name ?? 'Class has no homeroom teacher',
            'teacher_count' => $users[2]->count() ?? 0,
            'pupil_count' => $users[4]->count() ?? 0,
            'teacher' => $users[2] ?? 'Class has no teacher',
            'pupil' => $users[4] ?? 'Class has no pupil',
        ];
    }
    
    public function addClass($request)
    {
        $classroomCheck = Classroom::where('class_name', $request['class_name'])->first();
        $ClassroomCheckUserTeacher = Classroom::where('homeroom_teacher_id', $request['homeroom_teacher_id'])->first();
        $user = User::where('id', $request['homeroom_teacher_id'])->first();

        if (isset($classroomCheck)) {
            return ([
                'message' => __('message')[ResponseCode::ERROR_CLASS_ALREADY_EXISTS],
            ]);
        }

        if (isset($ClassroomCheckUserTeacher)) {
            return [
                'message' => __('message')[ResponseCode::ERROR_THE_TEACHER_IS_IN_CHARGE_OF_ANOTHER_CLASS],
            ];
        }

        if ($user->authority->value == 3) {
            $user->authority = 2;
            $user->save();
        } elseif ($user->authority->value == 1 || $user->authority->value == 4) {
            return [
                'message' => __('message')[ResponseCode::ERROR_USER_NOT_TEACHER],
            ];
        }

        $classroom = Classroom::create($request);
        return $classroom;

    }

    public function updateClass($request)
    {
        $classroom = Classroom::find($request->id);

        if (! isset($classroom)) {
            return [
                'message' => __('message')[ResponseCode::ERROR_CLASS_NOT_FOUND],
            ];
        }

        if ($request->class_name) {
            if(Classroom::where('class_name', $request->class_name)->first() && $classroom->class_name != $request->class_name) {
                return [
                    'message' => __('message')[ResponseCode::ERROR_CLASS_ALREADY_EXISTS],
                ];
            }else {
                $classroom->class_name = $request->class_name;
            }
        }

        if ($request->homeroom_teacher_id) {
            if(Classroom::where('homeroom_teacher_id', $request->homeroom_teacher_id)->first() && $classroom->homeroom_teacher_id != $request->homeroom_teacher_id) {
                return [
                    'message' => __('message')[ResponseCode::ERROR_THE_TEACHER_IS_IN_CHARGE_OF_ANOTHER_CLASS],
                ];
            }elseif ($request->homeroom_teacher_id != $classroom->homeroom_teacher_id) {
                User::where('id', $classroom->homeroom_teacher_id)->update(['authority' => 2]);
                $classroom->homeroom_teacher_id = $request->homeroom_teacher_id;
                User::where('id', $classroom->homeroom_teacher_id)->update(['authority' => 3]);
            }
        }

        $classroom->save(); 

        return [
            'id' => $classroom->id,
            'class_name' => $classroom->class_name, 
            'homeroom_teacher_id' => $classroom->homeroom_teacher_id
        ];
    }

    public function deleteClass($id)
    {
        $classroom = Classroom::find($id)->first();

        if (! isset($classroom)) {
            return [
                'message' => __('message')[ResponseCode::ERROR_CLASS_NOT_FOUND],
            ];
        }
        $classroom->delete();
    }

    public function addTeacherOrPupilToClass($request)
    {
        $classroom = Classroom::find($request->class_name);
        $user = User::find($request->user_id);

        if ( isset($classroom) && isset($user)) {
            $classes = $user->userClass;

            if ( $user->authority->value == 4 && $classes) {
                return [
                    'message'=> __('message')[ResponseCode::ERROR_USER_ALREADY_IN_CLASS],
                ];
            } elseif ( $user->authority->value == 3 || $user->authority->value == 2 && $classes->pluck('class_name')->first() == $classroom->class_name) {
                return [
                    'message' => __('message')[ResponseCode::ERROR_USER_ALREADY_IN_CLASS],
                ];
            } elseif ( $user->authority->value == 1) {
                return [
                    'message' => __('message')[ResponseCode::ERROR_USER_NOT_TEACHER_OR_PUPIL],
                ];
            }else {
                $user->userClass()->attach($classroom);
            }

        } else {
            return [
                'message' => __('message')[ResponseCode::ERROR_CLASS_OR_USER_NOT_FOUND],
            ];
        }

        return [
            'user' => $user->user_name,
            'class' => $classroom->class_name
        ];
    }
    
    public function addPupilToClass($request)
    {
        $classroom = Classroom::find($request->class_name);
        $user = User::find($request->user_id);

        if ( isset($classroom) && isset($user)) {
            $classes = $user->userClass;

            if ( $user->authority->value == 4 && $classes) {
                return [
                    'message'=> __('message')[ResponseCode::ERROR_USER_ALREADY_IN_CLASS],
                ];
            } elseif ( $user->authority->value !== 4) {
                return [
                    'message' => __('message')[ResponseCode::ERROR_USER_NOT_PUPIL],
                ];
            }else {
                $user->userClass()->attach($classroom);
            }

        } else {
            return [
                'message' => __('message')[ResponseCode::ERROR_CLASS_OR_USER_NOT_FOUND],
            ];
        }

        return [
            'user' => $user->user_name,
            'class' => $classroom->class_name
        ];
    }
}