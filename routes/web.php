<?php

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

// Active Members
Route::get('admin/active_members', 'Admin\UsersController@active_members');

Route::get('/donepayment', ['as' => 'paymentsuccess', 'uses'=>'Admin\HomeController@paymentsuccess']);
Route::get('/paymentsuccess', 'Admin\HomeController@paymentsuccess');
Route::get('/paymentconfirmation', 'Admin\HomeController@paymentconfirmation');

Auth::routes();

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');




    Route::get('users/send/{id}', 'UsersController@send')->name('users.send');

    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users

    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::post('users/media', 'UsersController@storeMedia')->name('users.storeMedia');
    Route::post('users/ckmedia', 'UsersController@storeCKEditorImages')->name('users.storeCKEditorImages');
    Route::post('users/parse-csv-import', 'UsersController@parseCsvImport')->name('users.parseCsvImport');
    Route::post('users/process-csv-import', 'UsersController@processCsvImport')->name('users.processCsvImport');
    Route::resource('users', 'UsersController');
    


    // Courses
    Route::delete('courses/destroy', 'CoursesController@massDestroy')->name('courses.massDestroy');
    Route::post('courses/media', 'CoursesController@storeMedia')->name('courses.storeMedia');
    Route::post('courses/ckmedia', 'CoursesController@storeCKEditorImages')->name('courses.storeCKEditorImages');
    Route::post('courses/parse-csv-import', 'CoursesController@parseCsvImport')->name('courses.parseCsvImport');
    Route::post('courses/process-csv-import', 'CoursesController@processCsvImport')->name('courses.processCsvImport');
    Route::resource('courses', 'CoursesController');

    // Lessons
    Route::delete('lessons/destroy', 'LessonsController@massDestroy')->name('lessons.massDestroy');
    Route::post('lessons/media', 'LessonsController@storeMedia')->name('lessons.storeMedia');
    Route::post('lessons/ckmedia', 'LessonsController@storeCKEditorImages')->name('lessons.storeCKEditorImages');
    Route::post('lessons/parse-csv-import', 'LessonsController@parseCsvImport')->name('lessons.parseCsvImport');
    Route::post('lessons/process-csv-import', 'LessonsController@processCsvImport')->name('lessons.processCsvImport');
    Route::resource('lessons', 'LessonsController');

    // Tests
    Route::delete('tests/destroy', 'TestsController@massDestroy')->name('tests.massDestroy');
    Route::post('tests/media', 'TestsController@storeMedia')->name('tests.storeMedia');
    Route::post('tests/ckmedia', 'TestsController@storeCKEditorImages')->name('tests.storeCKEditorImages');
    Route::post('tests/parse-csv-import', 'TestsController@parseCsvImport')->name('tests.parseCsvImport');
    Route::post('tests/process-csv-import', 'TestsController@processCsvImport')->name('tests.processCsvImport');
    Route::resource('tests', 'TestsController');

    // Questions
    Route::delete('questions/destroy', 'QuestionsController@massDestroy')->name('questions.massDestroy');
    Route::post('questions/media', 'QuestionsController@storeMedia')->name('questions.storeMedia');
    Route::post('questions/ckmedia', 'QuestionsController@storeCKEditorImages')->name('questions.storeCKEditorImages');
    Route::post('questions/parse-csv-import', 'QuestionsController@parseCsvImport')->name('questions.parseCsvImport');
    Route::post('questions/process-csv-import', 'QuestionsController@processCsvImport')->name('questions.processCsvImport');
    Route::resource('questions', 'QuestionsController');

    // Question Options
    Route::delete('question-options/destroy', 'QuestionOptionsController@massDestroy')->name('question-options.massDestroy');
    Route::post('question-options/parse-csv-import', 'QuestionOptionsController@parseCsvImport')->name('question-options.parseCsvImport');
    Route::post('question-options/process-csv-import', 'QuestionOptionsController@processCsvImport')->name('question-options.processCsvImport');
    Route::resource('question-options', 'QuestionOptionsController');

    // Test Results
    Route::delete('test-results/destroy', 'TestResultsController@massDestroy')->name('test-results.massDestroy');
    Route::post('test-results/parse-csv-import', 'TestResultsController@parseCsvImport')->name('test-results.parseCsvImport');
    Route::post('test-results/process-csv-import', 'TestResultsController@processCsvImport')->name('test-results.processCsvImport');
    Route::resource('test-results', 'TestResultsController');

    // Test Answers
    Route::delete('test-answers/destroy', 'TestAnswersController@massDestroy')->name('test-answers.massDestroy');
    Route::post('test-answers/parse-csv-import', 'TestAnswersController@parseCsvImport')->name('test-answers.parseCsvImport');
    Route::post('test-answers/process-csv-import', 'TestAnswersController@processCsvImport')->name('test-answers.processCsvImport');
    Route::resource('test-answers', 'TestAnswersController');

    // Expense Category
    Route::delete('expense-categories/destroy', 'ExpenseCategoryController@massDestroy')->name('expense-categories.massDestroy');
    Route::resource('expense-categories', 'ExpenseCategoryController');

    // Income Category
    Route::delete('income-categories/destroy', 'IncomeCategoryController@massDestroy')->name('income-categories.massDestroy');
    Route::resource('income-categories', 'IncomeCategoryController');

    // Expense
    Route::delete('expenses/destroy', 'ExpenseController@massDestroy')->name('expenses.massDestroy');
    Route::resource('expenses', 'ExpenseController');

    // Income
    Route::delete('incomes/destroy', 'IncomeController@massDestroy')->name('incomes.massDestroy');
    Route::post('incomes/media', 'IncomeController@storeMedia')->name('incomes.storeMedia');
    Route::post('incomes/ckmedia', 'IncomeController@storeCKEditorImages')->name('incomes.storeCKEditorImages');
    Route::post('incomes/parse-csv-import', 'IncomeController@parseCsvImport')->name('incomes.parseCsvImport');
    Route::post('incomes/process-csv-import', 'IncomeController@processCsvImport')->name('incomes.processCsvImport');
    Route::resource('incomes', 'IncomeController');

    // Expense Report
    Route::delete('expense-reports/destroy', 'ExpenseReportController@massDestroy')->name('expense-reports.massDestroy');
    Route::resource('expense-reports', 'ExpenseReportController');

    // Email
    Route::delete('emails/destroy', 'EmailController@massDestroy')->name('emails.massDestroy');
    Route::post('emails/media', 'EmailController@storeMedia')->name('emails.storeMedia');
    Route::post('emails/ckmedia', 'EmailController@storeCKEditorImages')->name('emails.storeCKEditorImages');
    Route::post('emails/parse-csv-import', 'EmailController@parseCsvImport')->name('emails.parseCsvImport');
    Route::post('emails/process-csv-import', 'EmailController@processCsvImport')->name('emails.processCsvImport');
    Route::resource('emails', 'EmailController');

    // Sms
    Route::delete('sms/destroy', 'SmsController@massDestroy')->name('sms.massDestroy');
    Route::post('sms/parse-csv-import', 'SmsController@parseCsvImport')->name('sms.parseCsvImport');
    Route::post('sms/process-csv-import', 'SmsController@processCsvImport')->name('sms.processCsvImport');
    Route::resource('sms', 'SmsController');

    // Crm Invoice
    Route::delete('crm-invoices/destroy', 'CrmInvoiceController@massDestroy')->name('crm-invoices.massDestroy');
    Route::post('crm-invoices/media', 'CrmInvoiceController@storeMedia')->name('crm-invoices.storeMedia');
    Route::post('crm-invoices/ckmedia', 'CrmInvoiceController@storeCKEditorImages')->name('crm-invoices.storeCKEditorImages');
    Route::post('crm-invoices/parse-csv-import', 'CrmInvoiceController@parseCsvImport')->name('crm-invoices.parseCsvImport');
    Route::post('crm-invoices/process-csv-import', 'CrmInvoiceController@processCsvImport')->name('crm-invoices.processCsvImport');
    Route::resource('crm-invoices', 'CrmInvoiceController');
    Route::post('crm-invoices/invoice', 'CrmInvoiceController@invoice')->name('crm-invoices.invoice');
    Route::post('crm-invoices/email', 'CrmInvoiceController@email')->name('crm-invoices.email');


    // Specialization
    Route::delete('specializations/destroy', 'SpecializationController@massDestroy')->name('specializations.massDestroy');
    Route::post('specializations/media', 'SpecializationController@storeMedia')->name('specializations.storeMedia');
    Route::post('specializations/ckmedia', 'SpecializationController@storeCKEditorImages')->name('specializations.storeCKEditorImages');
    Route::post('specializations/parse-csv-import', 'SpecializationController@parseCsvImport')->name('specializations.parseCsvImport');
    Route::post('specializations/process-csv-import', 'SpecializationController@processCsvImport')->name('specializations.processCsvImport');
    Route::resource('specializations', 'SpecializationController');

    // Invoices Report
    Route::resource('invoices-reports', 'InvoicesReportController', ['except' => ['create', 'store', 'edit', 'update', 'show', 'destroy']]);

    // Receipts Report
    Route::resource('receipts-reports', 'ReceiptsReportController', ['except' => ['create', 'store', 'edit', 'update', 'show', 'destroy']]);

    // Members Report
    Route::resource('members-reports', 'MembersReportController', ['except' => ['create', 'store', 'edit', 'update', 'show', 'destroy']]);

    // Locations
    Route::delete('locations/destroy', 'LocationsController@massDestroy')->name('locations.massDestroy');
    Route::post('locations/parse-csv-import', 'LocationsController@parseCsvImport')->name('locations.parseCsvImport');
    Route::post('locations/process-csv-import', 'LocationsController@processCsvImport')->name('locations.processCsvImport');
    Route::resource('locations', 'LocationsController');

    // Rates
    Route::delete('rates/destroy', 'RatesController@massDestroy')->name('rates.massDestroy');
    Route::post('rates/media', 'RatesController@storeMedia')->name('rates.storeMedia');
    Route::post('rates/ckmedia', 'RatesController@storeCKEditorImages')->name('rates.storeCKEditorImages');
    Route::post('rates/parse-csv-import', 'RatesController@parseCsvImport')->name('rates.parseCsvImport');
    Route::post('rates/process-csv-import', 'RatesController@processCsvImport')->name('rates.processCsvImport');
    Route::resource('rates', 'RatesController');

    // Events
    Route::delete('events/destroy', 'EventsController@massDestroy')->name('events.massDestroy');
    Route::post('events/media', 'EventsController@storeMedia')->name('events.storeMedia');
    Route::post('events/ckmedia', 'EventsController@storeCKEditorImages')->name('events.storeCKEditorImages');
    Route::post('events/parse-csv-import', 'EventsController@parseCsvImport')->name('events.parseCsvImport');
    Route::post('events/process-csv-import', 'EventsController@processCsvImport')->name('events.processCsvImport');
    Route::resource('events', 'EventsController');

    // Event Attendance
    Route::delete('event-attendances/destroy', 'EventAttendanceController@massDestroy')->name('event-attendances.massDestroy');
    Route::post('event-attendances/media', 'EventAttendanceController@storeMedia')->name('event-attendances.storeMedia');
    Route::post('event-attendances/ckmedia', 'EventAttendanceController@storeCKEditorImages')->name('event-attendances.storeCKEditorImages');
    Route::post('event-attendances/parse-csv-import', 'EventAttendanceController@parseCsvImport')->name('event-attendances.parseCsvImport');
    Route::post('event-attendances/process-csv-import', 'EventAttendanceController@processCsvImport')->name('event-attendances.processCsvImport');
    Route::resource('event-attendances', 'EventAttendanceController');

    // Audit Logs
    Route::resource('audit-logs', 'AuditLogsController', ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);

    // Webinars
    Route::delete('webinars/destroy', 'WebinarsController@massDestroy')->name('webinars.massDestroy');
    Route::post('webinars/media', 'WebinarsController@storeMedia')->name('webinars.storeMedia');
    Route::post('webinars/ckmedia', 'WebinarsController@storeCKEditorImages')->name('webinars.storeCKEditorImages');
    Route::post('webinars/parse-csv-import', 'WebinarsController@parseCsvImport')->name('webinars.parseCsvImport');
    Route::post('webinars/process-csv-import', 'WebinarsController@processCsvImport')->name('webinars.processCsvImport');
    Route::resource('webinars', 'WebinarsController');

    // Events Report
    Route::delete('events-reports/destroy', 'EventsReportController@massDestroy')->name('events-reports.massDestroy');
    Route::resource('events-reports', 'EventsReportController');

    Route::get('system-calendar', 'SystemCalendarController@index')->name('systemCalendar');
    Route::get('global-search', 'GlobalSearchController@search')->name('globalSearch');
    Route::get('messenger', 'MessengerController@index')->name('messenger.index');
    Route::get('messenger/create', 'MessengerController@createTopic')->name('messenger.createTopic');
    Route::post('messenger', 'MessengerController@storeTopic')->name('messenger.storeTopic');
    Route::get('messenger/inbox', 'MessengerController@showInbox')->name('messenger.showInbox');
    Route::get('messenger/outbox', 'MessengerController@showOutbox')->name('messenger.showOutbox');
    Route::get('messenger/{topic}', 'MessengerController@showMessages')->name('messenger.showMessages');
    Route::delete('messenger/{topic}', 'MessengerController@destroyTopic')->name('messenger.destroyTopic');
    Route::post('messenger/{topic}/reply', 'MessengerController@replyToTopic')->name('messenger.reply');
    Route::get('messenger/{topic}/reply', 'MessengerController@showReply')->name('messenger.showReply');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});
