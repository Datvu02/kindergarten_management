<?php

use App\Helpers\ResponseCode;

return
[
    ResponseCode::ERROR_USER_NOT_TEACHER => 'Đây không phải là giáo viên',
    ResponseCode::ERROR_USER_NOT_PUPIL => 'Đây không phải là học sinh',
    ResponseCode::ERROR_CLASS_NOT_FOUND => 'Không tìm thấy lớp',
    ResponseCode::ERROR_USER_NOT_PUPIL_OR_NOT_PUPIL_IN_CLASS => 'Không phải học sinh học hoặc không phải học sinh trong lớp nây',
    ResponseCode::ERROR_USER_CHECK_IN_ALREADY => 'Bạn đã chấm công ngày hôm nay',
    ResponseCode::ERROR_THE_TEACHER_IS_IN_CHARGE_OF_ANOTHER_CLASS => 'Giáo viên này đang phụ trách lớp khác',
    ResponseCode::ERROR_USER_ALREADY_IN_CLASS => 'Tai khoản này đang trong lớp nây',
    ResponseCode::ERROR_CLASS_OR_USER_NOT_FOUND => 'Lớp hoặc tai khoản này không tìm thấy',
    ResponseCode::ERROR_USER_NOT_TEACHER_OR_PUPIL => 'Tai khoản này không phải giáo viên hoặc học sinh',
    ResponseCode::SUCCESS => 'Thành công',
    ResponseCode::ERROR_SEVER => 'Lỗi server',
    ResponseCode::UNAUTHORIZED => 'Không được phép truy cập',
    ResponseCode::FORBIDDEN => 'Cấm',
    ResponseCode::NOT_FOUND => 'Không tìm thấy',
    ResponseCode::ERROR_DATA_RETRIEVAL => 'Lỗi truy cập dữ liệu',
    ResponseCode::ERROR_NO_ADMIN_PRIVILEGES => 'Lỗi không phải là admin',
    ResponseCode::ERROR_ACCOUNT_NOT_FOUND => 'Không tìm thấy tài khoản',
    ResponseCode::ERROR_DATA_ADDITION => 'Lỗi thêm dữ liệu',
    ResponseCode::ERROR_DATA_UPDATE => 'Lỗi update dữ liệu',
    ResponseCode::ERROR_INCORRECT_NAME_ID_OR_PASSWORD => 'Sai tài khoản hoặc mật khâu',
    ResponseCode::ERROR_NOT_FOUND_ID => 'Không tìm thấy ID',
    ResponseCode::ERROR_ACCOUNT_ID_EXISTS => 'Không tim thấy tài khoản với ID này',
    ResponseCode::ERROR_DELETE_SELF_ACCOUNT => 'Không được xóa tài khoản này',
    ResponseCode::ERROR_CLASS_ALREADY_EXISTS => 'Lớp này đã tồn tại',
    ResponseCode::RECORD_ALREADY_EXISTS => 'Bản ghi này đã tồn tại',
];