<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'course_create',
            ],
            [
                'id'    => 18,
                'title' => 'course_edit',
            ],
            [
                'id'    => 19,
                'title' => 'course_show',
            ],
            [
                'id'    => 20,
                'title' => 'course_delete',
            ],
            [
                'id'    => 21,
                'title' => 'course_access',
            ],
            [
                'id'    => 22,
                'title' => 'lesson_create',
            ],
            [
                'id'    => 23,
                'title' => 'lesson_edit',
            ],
            [
                'id'    => 24,
                'title' => 'lesson_show',
            ],
            [
                'id'    => 25,
                'title' => 'lesson_delete',
            ],
            [
                'id'    => 26,
                'title' => 'lesson_access',
            ],
            [
                'id'    => 27,
                'title' => 'test_create',
            ],
            [
                'id'    => 28,
                'title' => 'test_edit',
            ],
            [
                'id'    => 29,
                'title' => 'test_show',
            ],
            [
                'id'    => 30,
                'title' => 'test_delete',
            ],
            [
                'id'    => 31,
                'title' => 'test_access',
            ],
            [
                'id'    => 32,
                'title' => 'question_create',
            ],
            [
                'id'    => 33,
                'title' => 'question_edit',
            ],
            [
                'id'    => 34,
                'title' => 'question_show',
            ],
            [
                'id'    => 35,
                'title' => 'question_delete',
            ],
            [
                'id'    => 36,
                'title' => 'question_access',
            ],
            [
                'id'    => 37,
                'title' => 'question_option_create',
            ],
            [
                'id'    => 38,
                'title' => 'question_option_edit',
            ],
            [
                'id'    => 39,
                'title' => 'question_option_show',
            ],
            [
                'id'    => 40,
                'title' => 'question_option_delete',
            ],
            [
                'id'    => 41,
                'title' => 'question_option_access',
            ],
            [
                'id'    => 42,
                'title' => 'test_result_create',
            ],
            [
                'id'    => 43,
                'title' => 'test_result_edit',
            ],
            [
                'id'    => 44,
                'title' => 'test_result_show',
            ],
            [
                'id'    => 45,
                'title' => 'test_result_delete',
            ],
            [
                'id'    => 46,
                'title' => 'test_result_access',
            ],
            [
                'id'    => 47,
                'title' => 'test_answer_create',
            ],
            [
                'id'    => 48,
                'title' => 'test_answer_edit',
            ],
            [
                'id'    => 49,
                'title' => 'test_answer_show',
            ],
            [
                'id'    => 50,
                'title' => 'test_answer_delete',
            ],
            [
                'id'    => 51,
                'title' => 'test_answer_access',
            ],
            [
                'id'    => 52,
                'title' => 'expense_management_access',
            ],
            [
                'id'    => 53,
                'title' => 'expense_category_create',
            ],
            [
                'id'    => 54,
                'title' => 'expense_category_edit',
            ],
            [
                'id'    => 55,
                'title' => 'expense_category_show',
            ],
            [
                'id'    => 56,
                'title' => 'expense_category_delete',
            ],
            [
                'id'    => 57,
                'title' => 'expense_category_access',
            ],
            [
                'id'    => 58,
                'title' => 'income_category_create',
            ],
            [
                'id'    => 59,
                'title' => 'income_category_edit',
            ],
            [
                'id'    => 60,
                'title' => 'income_category_show',
            ],
            [
                'id'    => 61,
                'title' => 'income_category_delete',
            ],
            [
                'id'    => 62,
                'title' => 'income_category_access',
            ],
            [
                'id'    => 63,
                'title' => 'expense_create',
            ],
            [
                'id'    => 64,
                'title' => 'expense_edit',
            ],
            [
                'id'    => 65,
                'title' => 'expense_show',
            ],
            [
                'id'    => 66,
                'title' => 'expense_delete',
            ],
            [
                'id'    => 67,
                'title' => 'expense_access',
            ],
            [
                'id'    => 68,
                'title' => 'income_create',
            ],
            [
                'id'    => 69,
                'title' => 'income_edit',
            ],
            [
                'id'    => 70,
                'title' => 'income_show',
            ],
            [
                'id'    => 71,
                'title' => 'income_delete',
            ],
            [
                'id'    => 72,
                'title' => 'income_access',
            ],
            [
                'id'    => 73,
                'title' => 'expense_report_create',
            ],
            [
                'id'    => 74,
                'title' => 'expense_report_edit',
            ],
            [
                'id'    => 75,
                'title' => 'expense_report_show',
            ],
            [
                'id'    => 76,
                'title' => 'expense_report_delete',
            ],
            [
                'id'    => 77,
                'title' => 'expense_report_access',
            ],
            [
                'id'    => 78,
                'title' => 'elearning_access',
            ],
            [
                'id'    => 79,
                'title' => 'messaging_access',
            ],
            [
                'id'    => 80,
                'title' => 'email_create',
            ],
            [
                'id'    => 81,
                'title' => 'email_edit',
            ],
            [
                'id'    => 82,
                'title' => 'email_show',
            ],
            [
                'id'    => 83,
                'title' => 'email_delete',
            ],
            [
                'id'    => 84,
                'title' => 'email_access',
            ],
            [
                'id'    => 85,
                'title' => 'sms_create',
            ],
            [
                'id'    => 86,
                'title' => 'sms_edit',
            ],
            [
                'id'    => 87,
                'title' => 'sms_show',
            ],
            [
                'id'    => 88,
                'title' => 'sms_delete',
            ],
            [
                'id'    => 89,
                'title' => 'sms_access',
            ],
            [
                'id'    => 90,
                'title' => 'crm_invoice_create',
            ],
            [
                'id'    => 91,
                'title' => 'crm_invoice_edit',
            ],
            [
                'id'    => 92,
                'title' => 'crm_invoice_show',
            ],
            [
                'id'    => 93,
                'title' => 'crm_invoice_delete',
            ],
            [
                'id'    => 94,
                'title' => 'crm_invoice_access',
            ],
            [
                'id'    => 95,
                'title' => 'specialization_create',
            ],
            [
                'id'    => 96,
                'title' => 'specialization_edit',
            ],
            [
                'id'    => 97,
                'title' => 'specialization_show',
            ],
            [
                'id'    => 98,
                'title' => 'specialization_delete',
            ],
            [
                'id'    => 99,
                'title' => 'specialization_access',
            ],
            [
                'id'    => 100,
                'title' => 'invoices_report_access',
            ],
            [
                'id'    => 101,
                'title' => 'receipts_report_access',
            ],
            [
                'id'    => 102,
                'title' => 'members_report_access',
            ],
            [
                'id'    => 103,
                'title' => 'location_create',
            ],
            [
                'id'    => 104,
                'title' => 'location_edit',
            ],
            [
                'id'    => 105,
                'title' => 'location_show',
            ],
            [
                'id'    => 106,
                'title' => 'location_delete',
            ],
            [
                'id'    => 107,
                'title' => 'location_access',
            ],
            [
                'id'    => 108,
                'title' => 'rate_create',
            ],
            [
                'id'    => 109,
                'title' => 'rate_edit',
            ],
            [
                'id'    => 110,
                'title' => 'rate_show',
            ],
            [
                'id'    => 111,
                'title' => 'rate_delete',
            ],
            [
                'id'    => 112,
                'title' => 'rate_access',
            ],
            [
                'id'    => 113,
                'title' => 'events_list_access',
            ],
            [
                'id'    => 114,
                'title' => 'event_create',
            ],
            [
                'id'    => 115,
                'title' => 'event_edit',
            ],
            [
                'id'    => 116,
                'title' => 'event_show',
            ],
            [
                'id'    => 117,
                'title' => 'event_delete',
            ],
            [
                'id'    => 118,
                'title' => 'event_access',
            ],
            [
                'id'    => 119,
                'title' => 'event_attendance_create',
            ],
            [
                'id'    => 120,
                'title' => 'event_attendance_edit',
            ],
            [
                'id'    => 121,
                'title' => 'event_attendance_show',
            ],
            [
                'id'    => 122,
                'title' => 'event_attendance_delete',
            ],
            [
                'id'    => 123,
                'title' => 'event_attendance_access',
            ],
            [
                'id'    => 124,
                'title' => 'audit_log_show',
            ],
            [
                'id'    => 125,
                'title' => 'audit_log_access',
            ],
            [
                'id'    => 126,
                'title' => 'webinar_create',
            ],
            [
                'id'    => 127,
                'title' => 'webinar_edit',
            ],
            [
                'id'    => 128,
                'title' => 'webinar_show',
            ],
            [
                'id'    => 129,
                'title' => 'webinar_delete',
            ],
            [
                'id'    => 130,
                'title' => 'webinar_access',
            ],
            [
                'id'    => 131,
                'title' => 'events_report_create',
            ],
            [
                'id'    => 132,
                'title' => 'events_report_edit',
            ],
            [
                'id'    => 133,
                'title' => 'events_report_show',
            ],
            [
                'id'    => 134,
                'title' => 'events_report_delete',
            ],
            [
                'id'    => 135,
                'title' => 'events_report_access',
            ],
            [
                'id'    => 136,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
