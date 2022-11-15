<div id="sidebar" class="c-sidebar c-sidebar-fixed c-sidebar-lg-show">

    <div class="c-sidebar-brand d-md-down-none">
        <a class="c-sidebar-brand-full h4" href="#">
           
            <img class="m-3" width="180" src="{{ asset('img/kpa_logo_w.png') }}" />
        </a>
    </div>


    <ul class="c-sidebar-nav">
        <li class="c-sidebar-nav-item">
            <a href="{{ route("admin.home") }}" class="c-sidebar-nav-link">
                <i class="c-sidebar-nav-icon fas fa-fw fa-tachometer-alt">

                </i>
                {{ trans('global.dashboard') }}
            </a>
        </li>
        @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
            @can('profile_password_edit')
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'c-active' : '' }}" href="{{ route('profile.password.edit') }}">
                        <i class="fa-fw fas fa-user c-sidebar-nav-icon">
                        </i>
                        {{ trans('global.my_profile') }}
                    </a>
                </li>
            @endcan
        @endif
        @can('user_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/users*") ? "c-show" : "" }} {{ request()->is("admin/specializations*") ? "c-show" : "" }} {{ request()->is("admin/locations*") ? "c-show" : "" }} {{ request()->is("admin/roles*") ? "c-show" : "" }} {{ request()->is("admin/permissions*") ? "c-show" : "" }} {{ request()->is("admin/audit-logs*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-users c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.userManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('user_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.users.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/users") || request()->is("admin/users/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.user.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('specialization_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.specializations.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/specializations") || request()->is("admin/specializations/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user-md c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.specialization.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('location_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.locations.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/locations") || request()->is("admin/locations/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-map-marker-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.location.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('role_access')
                        <li class=" c-sidebar-nav-item"> 
                            <a href="{{ route("admin.roles.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/roles") || request()->is("admin/roles/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-briefcase c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.role.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('permission_access')
                        <li class="d-none c-sidebar-nav-item">
                            <a href="{{ route("admin.permissions.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/permissions") || request()->is("admin/permissions/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-unlock-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.permission.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('audit_log_access')
                        <li class="d-none c-sidebar-nav-item">
                            <a href="{{ route("admin.audit-logs.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/audit-logs") || request()->is("admin/audit-logs/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-file-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.auditLog.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('messaging_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/emails*") ? "c-show" : "" }} {{ request()->is("admin/sms*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-envelope c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.messaging.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('email_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.emails.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/emails") || request()->is("admin/emails/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-at c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.email.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('sms_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.sms.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/sms") || request()->is("admin/sms/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-mobile-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.sms.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @if( auth()->user()->status  == 2)
        @can('webinar_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.webinars.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/webinars") || request()->is("admin/webinars/*") ? "c-active" : "" }}">
                    <i class="fa-fw fab fa-youtube c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.webinar.title') }}
                </a>
            </li>
        @endcan
        @endif
        @can('course_access')
            <li class=" d-none c-sidebar-nav-item">
                <a href="{{ route("admin.courses.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/courses") || request()->is("admin/courses/*") ? "c-active" : "" }}">
                    <i class="fa-fw fab fa-readme c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.elearning.title') }}
                </a>
            </li>
        @endcan
        @can('elearning_access')
            <li class="d-none c-sidebar-nav-dropdown {{ request()->is("admin/courses*") ? "c-show" : "" }} {{ request()->is("admin/lessons*") ? "c-show" : "" }} {{ request()->is("admin/tests*") ? "c-show" : "" }} {{ request()->is("admin/questions*") ? "c-show" : "" }} {{ request()->is("admin/question-options*") ? "c-show" : "" }} {{ request()->is("admin/test-answers*") ? "c-show" : "" }} {{ request()->is("admin/test-results*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-university c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.elearning.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('course_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.courses.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/courses") || request()->is("admin/courses/*") ? "c-active" : "" }}">
                                <i class="fa-fw fab fa-readme c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.course.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('lesson_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.lessons.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/lessons") || request()->is("admin/lessons/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-book c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.lesson.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('test_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.tests.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/tests") || request()->is("admin/tests/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-copy c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.test.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('question_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.questions.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/questions") || request()->is("admin/questions/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-question-circle c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.question.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('question_option_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.question-options.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/question-options") || request()->is("admin/question-options/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-list-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.questionOption.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('test_answer_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.test-answers.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/test-answers") || request()->is("admin/test-answers/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-clipboard-check c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.testAnswer.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('test_result_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.test-results.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/test-results") || request()->is("admin/test-results/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-file-code c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.testResult.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('events_list_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/events*") ? "c-show" : "" }} {{ request()->is("admin/event-attendances*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-calendar-alt c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.eventsList.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('event_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.events.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/events") || request()->is("admin/events/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-align-justify c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.event.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('event_attendance_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.event-attendances.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/event-attendances") || request()->is("admin/event-attendances/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-users c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.eventAttendance.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('expense_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/rates*") ? "c-show" : "" }} {{ request()->is("admin/crm-invoices*") ? "c-show" : "" }} {{ request()->is("admin/incomes*") ? "c-show" : "" }} {{ request()->is("admin/expenses*") ? "c-show" : "" }} {{ request()->is("admin/expense-reports*") ? "c-show" : "" }} {{ request()->is("admin/members-reports*") ? "c-show" : "" }} {{ request()->is("admin/invoices-reports*") ? "c-show" : "" }} {{ request()->is("admin/receipts-reports*") ? "c-show" : "" }} {{ request()->is("admin/income-categories*") ? "c-show" : "" }} {{ request()->is("admin/expense-categories*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-money-bill c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.expenseManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('rate_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.rates.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/rates") || request()->is("admin/rates/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-calculator c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.rate.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('crm_invoice_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.crm-invoices.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/crm-invoices") || request()->is("admin/crm-invoices/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-file-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.crmInvoice.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('income_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.incomes.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/incomes") || request()->is("admin/incomes/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-receipt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.income.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('expense_access')
                        <li class="d-none c-sidebar-nav-item">
                            <a href="{{ route("admin.expenses.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/expenses") || request()->is("admin/expenses/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-coins c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.expense.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('expense_report_access')
                        <li class="d-none c-sidebar-nav-item">
                            <a href="{{ route("admin.expense-reports.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/expense-reports") || request()->is("admin/expense-reports/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-chart-line c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.expenseReport.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('members_report_access')
                        <li class="d-none c-sidebar-nav-item">
                            <a href="{{ route("admin.members-reports.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/members-reports") || request()->is("admin/members-reports/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-users c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.membersReport.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('invoices_report_access')
                        <li class="d-none c-sidebar-nav-item">
                            <a href="{{ route("admin.invoices-reports.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/invoices-reports") || request()->is("admin/invoices-reports/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-file-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.invoicesReport.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('receipts_report_access')
                        <li class="d-none c-sidebar-nav-item">
                            <a href="{{ route("admin.receipts-reports.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/receipts-reports") || request()->is("admin/receipts-reports/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-receipt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.receiptsReport.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('income_category_access')
                        <li class="d-none c-sidebar-nav-item">
                            <a href="{{ route("admin.income-categories.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/income-categories") || request()->is("admin/income-categories/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-sitemap c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.incomeCategory.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('expense_category_access')
                        <li class="d-none c-sidebar-nav-item">
                            <a href="{{ route("admin.expense-categories.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/expense-categories") || request()->is("admin/expense-categories/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-sitemap c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.expenseCategory.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        <li class="c-sidebar-nav-item">
            <a href="{{ route("admin.systemCalendar") }}" class="c-sidebar-nav-link {{ request()->is("admin/system-calendar") || request()->is("admin/system-calendar/*") ? "c-active" : "" }}">
                <i class="c-sidebar-nav-icon fa-fw fas fa-calendar-alt">

                </i>
                {{ trans('global.systemCalendar') }}
            </a>
        </li>
        @php($unread = \App\Models\QaTopic::unreadCount())
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.messenger.index") }}" class="{{ request()->is("admin/messenger") || request()->is("admin/messenger/*") ? "c-active" : "" }} c-sidebar-nav-link">
                    <i class="c-sidebar-nav-icon fa-fw fa fa-comments">

                    </i>
                    <span>{{ trans('global.messages') }}</span>
                    @if($unread > 0)
                        <strong>( {{ $unread }} )</strong>
                    @endif

                </a>
            </li>

            <li class="c-sidebar-nav-item">
                <a href="#" class="c-sidebar-nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                    <i class="c-sidebar-nav-icon fas fa-fw fa-sign-out-alt">

                    </i>
                    {{ trans('global.logout') }}
                </a>
            </li>
    </ul>

</div>