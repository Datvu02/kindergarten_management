<?php

namespace App\Helpers;

use Error;

class ResponseCode
{
    public const ERROR_USER_NOT_TEACHER = '001';
    public const ERROR_USER_NOT_PUPIL = '002';
    public const ERROR_CLASS_NOT_FOUND = '003';
    public const ERROR_USER_NOT_PUPIL_OR_NOT_PUPIL_IN_CLASS = '004';
    public const ERROR_USER_CHECK_IN_ALREADY = '005';
    public const ERROR_THE_TEACHER_IS_IN_CHARGE_OF_ANOTHER_CLASS = '006';
    public const ERROR_USER_ALREADY_IN_CLASS = '007';    
    public const ERROR_CLASS_OR_USER_NOT_FOUND = '008';
    public const ERROR_USER_NOT_TEACHER_OR_PUPIL = '009';
    public const SUCCESS = '200';
    public const ERROR_SEVER = '500';
    public const UNAUTHORIZED = '401';
    public const FORBIDDEN = '403';
    public const NOT_FOUND = '404';
    public const ERROR_DATA_RETRIEVAL = '204';
    public const ERROR_NO_ADMIN_PRIVILEGES = '204';
    public const ERROR_ACCOUNT_NOT_FOUND = '204';
    public const ERROR_DATA_ADDITION = '204';
    public const ERROR_DATA_UPDATE = '204';
    public const ERROR_INCORRECT_NAME_ID_OR_PASSWORD = '204';
    public const ERROR_NOT_FOUND_ID = '204';
    public const ERROR_ACCOUNT_ID_EXISTS = '204';
    public const ERROR_DELETE_SELF_ACCOUNT = '204';
    public const ERROR_CLASS_ALREADY_EXISTS = '422';
    public const RECORD_ALREADY_EXISTS = '422';
}
