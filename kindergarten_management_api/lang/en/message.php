<?php

use App\Helpers\ResponseCode;

return
[
    ResponseCode::ERROR_USER_NOT_TEACHER => 'Error user not teacher',
    ResponseCode::ERROR_USER_NOT_PUPIL => 'Error user not pupil',
    ResponseCode::ERROR_CLASS_NOT_FOUND => 'Error class not found',
    ResponseCode::ERROR_USER_NOT_PUPIL_OR_NOT_PUPIL_IN_CLASS => 'Error user not pupil or not pupil in class',
    ResponseCode::ERROR_USER_CHECK_IN_ALREADY => 'Error user check in already',
    ResponseCode::ERROR_THE_TEACHER_IS_IN_CHARGE_OF_ANOTHER_CLASS => 'Error the teacher is in charge of another class',
    ResponseCode::ERROR_USER_ALREADY_IN_CLASS => 'Error user already in class',
    ResponseCode::ERROR_CLASS_OR_USER_NOT_FOUND => 'Error class or user not found',
    ResponseCode::ERROR_USER_NOT_TEACHER_OR_PUPIL => 'Error user not teacher or pupil',
    ResponseCode::SUCCESS => 'Success',
    ResponseCode::ERROR_SEVER => 'Error sever',
    ResponseCode::UNAUTHORIZED => 'Unauthorized',
    ResponseCode::FORBIDDEN => 'Forbidden',
    ResponseCode::NOT_FOUND => 'Not found',
    ResponseCode::ERROR_DATA_RETRIEVAL => 'Error data retrieval',
    ResponseCode::ERROR_NO_ADMIN_PRIVILEGES => 'Error no admin privileges',
    ResponseCode::ERROR_ACCOUNT_NOT_FOUND => 'Error account not found',
    ResponseCode::ERROR_DATA_ADDITION => 'Error data addition',
    ResponseCode::ERROR_DATA_UPDATE => 'Error data update',
    ResponseCode::ERROR_INCORRECT_NAME_ID_OR_PASSWORD => 'Error incorrect ID or PASSWORD',
    ResponseCode::ERROR_NOT_FOUND_ID => 'Error not found ID',
    ResponseCode::ERROR_ACCOUNT_ID_EXISTS => 'Error account ID exists',
    ResponseCode::ERROR_DELETE_SELF_ACCOUNT => 'Error delete self account',
    ResponseCode::ERROR_CLASS_ALREADY_EXISTS => 'Error class ID already exists',
    ResponseCode::RECORD_ALREADY_EXISTS => 'Error already exists',
];