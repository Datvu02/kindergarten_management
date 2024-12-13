<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\User;
use App\Enums\RoleEnum;
use App\Models\Classroom;
use App\Models\UserCheckIn;
use Illuminate\Support\Str;
use App\Helpers\ResponseCode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserService 
{
    
    public function showTeacher($id)
    {
        try {
            $user = User::findOrFail($id)
                    ->select('id', 'name_id', 'user_name', 'address', 'phone', 'yob', 'authority')->first();

            if ($user->authority->value == 4 || $user->authority->value == 1) {
                return [
                    'message' => __('message')[ResponseCode::ERROR_USER_NOT_TEACHER]
                ];
            }
        
            $result = [
                "User_id" => $user->name_id,
                "User_name" => $user->user_name,
                "Address" => $user->address,
                "Phone" => $user->phone,
                "Yob" => $user->yob,
            ];
        
            if ($user->authority->value == 3) {
                $result['status'] = "Homeroom Teacher";
                $result['class_room'] = "Teacher has no class room." . null 
                                        ?? Classroom::where('homeroom_teacher_id', $user->id)
                                        ->select('class_name')->first();
            } else {
                $result['status'] = "Teacher";
            }
        
            return $result;
        }
        catch (\Exception $e) {
            return ['message' => __('message')[ResponseCode::ERROR_ACCOUNT_NOT_FOUND]];
        }
    }

    public function addUserTeacher($request)
    {
        $passwordRandom = $this->generateRandomPassword();
        $user = new User();
        $user->name_id = $request->name_id;
        $user->user_name = $request->user_name;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->yob = $request->yob;
        $user->password = Hash::make($passwordRandom);
        $user->authority = RoleEnum::TEACHER;
        $user->save();

        return [
            'id' => $user->id,
            'password' => $passwordRandom,
        ];
    }

    public function updateUserTeacher($request)
    {
        $user = User::find($request->id)
                ->select('id', 'name_id', 'user_name', 'phone', 'address', 'yob', 'year_old')->first();

        if (! $user) {
            return ['message' => __('message')[ResponseCode::ERROR_ACCOUNT_NOT_FOUND]];
        }

        $data = array_filter($request->only(['name_id', 'user_name', 'user_phone', 'user_address', 'yob', 'year_old']), function ($value) {
            return !is_null($value);
        });

        $user->fill($data)->save();
    
        return [
            'id' => $user->id,
            'name_id' => $user->name_id,
            'user_name' => $user->user_name,
            'phone' => $user->phone,
            'address' => $user->address,
            'yob' => $user->yob,
            'year_old' => $user->year_old,
        ];
    }

    public function deleteUserTeacher($id)
    {
        $user = User::find($id);

        if (! $user) {
            return ['message' => __('message')[ResponseCode::ERROR_ACCOUNT_NOT_FOUND]];
        }

        if ($user->authority->value == 2 ) {
            $user->delete();
        } elseif ($user->authority->value == 3) {
            $className = Classroom::where('homeroom_teacher_id', $user->id)->select('class_name')->first();
            return [
                'class name' => $className,
                'warning' => 'Error user is homeroom teacher.'
            ];
        } else {
            return ['message' => __('message')[ResponseCode::ERROR_USER_NOT_TEACHER]];
        }

        return [
            'status' => 'Success',
        ];
    }

    public function addUserPupil($request)
    {
        $passwordRandom = $this->generateRandomPassword();
        $user = new User();
        $user->name_id = $request->name_id;
        $user->user_name = $request->user_name;
        $user->phone = $request->phone;
        $user->address = $request->email;
        $user->emailParent = $request->emailParent;
        $user->yob = $request->yob;
        $user->password = Hash::make($passwordRandom);
        $user->authority = RoleEnum::PUPIL;
        $user->save();

        return [
            'id' => $user->id,
            'email' => $user->email,
            'password' => $passwordRandom,
        ];
    }

    public function updateUserPupil($request)
    {
        
        $user = User::find($request->id)
                ->select('id', 'name_id', 'user_name', 'phone_parent', 'user_address', 'year_old')->first();

        if (! $user) {
            return ['message' => __('message')[ResponseCode::ERROR_ACCOUNT_NOT_FOUND]];
        }

        $data = array_filter($request->only(['name_id', 'user_name', 'phone_parent', 'user_address', 'year_old']), function ($value) {
            return !is_null($value);  
        });

        $user->fill($data)->save();
    
        return [
            'id' => $user->id,
            'name_id' => $user->name_id,
            'user_name' => $user->user_name,
            'phone_parent' => $user->phone_parent,
            'address' => $user->address,
            'year_old' => $user->year_old,
        ];
    }

    public function deleteUserPupil($id)
    {
        
        $user = User::find($id);

        if (! $user) {
            return ['message' => __('message')[ResponseCode::ERROR_ACCOUNT_NOT_FOUND]];
        }

        $className = $user->userClass()->select('class_name')->first();

        if ($user->authority->value == 4  && ! $className) {
            $user->delete();
        } else {
            return ['message' => __('message')[ResponseCode::ERROR_USER_NOT_PUPIL_OR_NOT_PUPIL_IN_CLASS]];
        }

        return [
            'status' => 'Success',
        ];
    }

    public function getListPupil($request)
    {
        $pupils = User::join('user_class', 'users.id', '=', 'user_class.user_id')
                ->where('authority', RoleEnum::PUPIL->value)
                ->orderBy('user_class.class_name', 'asc')
                ->select('users.id', 'name_id', 'user_name', 'address', 'phone_parent', 'yob', 'year_old')->get();

        return [
            'count' => $pupils->count(),
            'pupils' => $pupils
        ];
    }

    public function getListTeacher($request)
    {
        $teachers = User::select('id', 'name_id', 'user_name', 'address', 'phone', 'yob', 'year_old')
                    ->where('authority', [RoleEnum::HOMEROOM_TEACHER, RoleEnum::TEACHER])->get()->groupBy('authority');

        return [
            'count homeroom teacher' => $teachers[2]->count(),
            'count teacher' => $teachers[3]->count(),
            'homeroom teachers' => $teachers[2],
            'teachers' => $teachers[3]
        ];
    }

    public function generateRandomPassword($length = 8)
    {
        do {
            $passwordRandom = Str::random($length);
        } while (! preg_match('/[A-Za-z]/', $passwordRandom) || ! preg_match('/\d/', $passwordRandom));

        return $passwordRandom;
    }

    public function checkInUser()
    {
        if (UserCheckIn::where('user_id', Auth::id())->whereDate('created_at', '=', Carbon::today())->exists()) {
            return ['message' => __('message')[ResponseCode::ERROR_USER_CHECK_IN_ALREADY]];
        }

        $userCheckIn = UserCheckIn::create([
            'user_id' => Auth::id(),
        ]);

        return [
            $userCheckIn
        ];
    }

    public function monthlyCheckIn($param)
    {
        $userCheckIns = UserCheckIn::whereMonth('created_at', $param->month)
                                ->whereYear('created_at', $param->year)
                                ->where('user_id', $param->user_id)
                                ->get();

        return [
            'count' => $userCheckIns->count(),
            'userCheckIns' => $userCheckIns
        ];
    }
}