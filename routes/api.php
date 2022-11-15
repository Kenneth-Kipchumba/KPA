<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
    // Permissions
    Route::apiResource('permissions', 'PermissionsApiController');

    // Roles
    Route::apiResource('roles', 'RolesApiController');

    // Users
    Route::post('users/media', 'UsersApiController@storeMedia')->name('users.storeMedia');
    Route::apiResource('users', 'UsersApiController');

    // Courses
    Route::post('courses/media', 'CoursesApiController@storeMedia')->name('courses.storeMedia');
    Route::apiResource('courses', 'CoursesApiController');

    // Lessons
    Route::post('lessons/media', 'LessonsApiController@storeMedia')->name('lessons.storeMedia');
    Route::apiResource('lessons', 'LessonsApiController');

    // Tests
    Route::post('tests/media', 'TestsApiController@storeMedia')->name('tests.storeMedia');
    Route::apiResource('tests', 'TestsApiController');

    // Questions
    Route::post('questions/media', 'QuestionsApiController@storeMedia')->name('questions.storeMedia');
    Route::apiResource('questions', 'QuestionsApiController');

    // Question Options
    Route::apiResource('question-options', 'QuestionOptionsApiController');

    // Test Results
    Route::apiResource('test-results', 'TestResultsApiController');

    // Test Answers
    Route::apiResource('test-answers', 'TestAnswersApiController');

    // Expense Category
    Route::apiResource('expense-categories', 'ExpenseCategoryApiController');

    // Income Category
    Route::apiResource('income-categories', 'IncomeCategoryApiController');

    // Expense
    Route::apiResource('expenses', 'ExpenseApiController');

    // Income
    Route::post('incomes/media', 'IncomeApiController@storeMedia')->name('incomes.storeMedia');
    Route::apiResource('incomes', 'IncomeApiController');

    // Email
    Route::post('emails/media', 'EmailApiController@storeMedia')->name('emails.storeMedia');
    Route::apiResource('emails', 'EmailApiController');

    // Sms
    Route::apiResource('sms', 'SmsApiController');

    // Crm Invoice
    Route::post('crm-invoices/media', 'CrmInvoiceApiController@storeMedia')->name('crm-invoices.storeMedia');
    Route::apiResource('crm-invoices', 'CrmInvoiceApiController');

    // Specialization
    Route::post('specializations/media', 'SpecializationApiController@storeMedia')->name('specializations.storeMedia');
    Route::apiResource('specializations', 'SpecializationApiController');

    // Locations
    Route::apiResource('locations', 'LocationsApiController');

    // Rates
    Route::post('rates/media', 'RatesApiController@storeMedia')->name('rates.storeMedia');
    Route::apiResource('rates', 'RatesApiController');

    // Events
    Route::post('events/media', 'EventsApiController@storeMedia')->name('events.storeMedia');
    Route::apiResource('events', 'EventsApiController');

    // Event Attendance
    Route::post('event-attendances/media', 'EventAttendanceApiController@storeMedia')->name('event-attendances.storeMedia');
    Route::apiResource('event-attendances', 'EventAttendanceApiController');

    // Webinars
    Route::post('webinars/media', 'WebinarsApiController@storeMedia')->name('webinars.storeMedia');
    Route::apiResource('webinars', 'WebinarsApiController');
});
