<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\ProvinceController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::middleware(['auth', 'saleman'])->group(function () {
Route::get('/index.html', 'Saleman\DashboardController@index');

// Sale
Route::get('dashboard',  'SaleMan\DashboardController@index');

// Route::get('/planMonth', function () { return view('saleman.planMonth'); });
Route::get('/planMonth', 'PlanMonthController@index');
Route::get('approve_monthly_plan/{id}', 'PlanMonthController@approve');
Route::get('dailyWork', 'SaleMan\DailyWorkController@index');
Route::get('/palncalendar', function () { return view('saleplan.salePalnCalendar'); });
Route::get('/planDetail', function () { return view('saleplan.saleplanDetail'); });

// Assignments
Route::get('assignment', 'SaleMan\AssignmentController@index');
Route::get('assignment_result_get/{id}', 'SaleMan\AssignmentController@assignment_result_get');
Route::post('assignment_Result', 'SaleMan\AssignmentController@saleplan_result');
Route::post('search_month_assignment', 'SaleMan\AssignmentController@search_month_assignment');



// Visit Customer
Route::get('visit', 'Customer\CustomerVisitController@visit');
Route::get('searchShop', 'Customer\CustomerVisitController@searchShop');
Route::post('create_visit', 'Customer\CustomerVisitController@visitStore');
Route::get('edit_customerVisit/{id}', 'Customer\CustomerVisitController@edit_customerVisit');
Route::post('update_customerVisit', 'Customer\CustomerVisitController@update_customerVisit');
Route::get('delete_visit/{id}', 'Customer\CustomerVisitController@destroy');
Route::get('/fetch_customer_shops_visit/{id}','Customer\CustomerVisitController@fetch_customer_shops_visit');

Route::post('customer_visit_checkin', 'Customer\CustomerVisitController@customer_visit_checkin');
Route::get('customer_visit_result_get/{id}', 'Customer\CustomerVisitController@customer_visit_result_get');
Route::post('customer_visit_Result', 'Customer\CustomerVisitController@customer_visit_Result');



// Customer
Route::get('/lead','Customer\CustomerController@customerLead');
Route::post('create_customer', 'Customer\CustomerController@store');
Route::get('edit_customerLead/{id}', 'Customer\CustomerController@edit');
Route::post('update_customerLead', 'Customer\CustomerController@update');
Route::post('delete_customer', 'Customer\CustomerController@destroy');

Route::get('/customer/detail/{id}', 'Customer\CustomerController@show');
Route::get('/customer','Customer\CustomerController@index');
Route::get('/fetch_customer_shops','Customer\CustomerController@fetch_customer_shops');
Route::get('/customer-api','Customer\ApiCustomerController@index'); // OAT ทดสอบดึง Api

Route::post('/leadtocustomer','Customer\CustomerController@lead_to_customer');
Route::post('/customerdelete','Customer\CustomerController@customer_delete');

Route::post('customer_new_checkin', 'Customer\CustomerController@customer_new_checkin');
Route::get('customer_new_result_get/{id}', 'Customer\CustomerController@customer_new_result_get');
Route::post('customer_new_Result', 'Customer\CustomerController@customer_new_Result');


// Sale Plan
Route::get('saleplan', 'SaleMan\SalePlanController@index');
Route::get('searchShop_saleplan/{id}', 'SaleMan\SalePlanController@fetch_customer_shops_saleplan');
Route::post('create_saleplan', 'SaleMan\SalePlanController@store');
Route::get('edit_saleplan/{id}', 'SaleMan\SalePlanController@edit');
Route::post('/saleplanEdit_fetch', 'SaleMan\SalePlanController@edit_fetch'); // OAT ใช้ในหน้า planMonth เป็น Modal
Route::post('update_saleplan', 'SaleMan\SalePlanController@update');
Route::get('delete_saleplan/{id}', 'SaleMan\SalePlanController@destroy');
Route::post('saleplan_checkin', 'SaleMan\SalePlanController@saleplan_checkin');
Route::get('saleplan_result_get/{id}', 'SaleMan\SalePlanController@saleplan_result_get');
Route::post('saleplan_Result', 'SaleMan\SalePlanController@saleplan_Result');

// Request Approval
Route::get('approval', 'SaleMan\RequestApprovalController@index');
Route::post('create_approval', 'SaleMan\RequestApprovalController@store');
Route::get('edit_approval/{id}', 'SaleMan\RequestApprovalController@edit');
Route::post('update_approval', 'SaleMan\RequestApprovalController@update');
Route::get('delete_approval/{id}', 'SaleMan\RequestApprovalController@destroy');
Route::get('view_comment/{id}', 'SaleMan\RequestApprovalController@view_comment');

// NOTE
Route::get('note', 'NoteController@note_sale');
Route::get('status_pin_update/{id}', 'NoteController@status_pin_update');
Route::post('create_note', 'NoteController@store');
Route::get('edit_note/{id}', 'NoteController@edit');
Route::post('update_note', 'NoteController@update');
Route::get('delete_note/{id}', 'NoteController@destroy');

Route::get('news', 'NewsController@frontend_news');
Route::get('promotions', 'PromotionController@frontend_promotion');

Route::get('/reportSale/reportSaleplan', function () { return view('reports.report_saleplan'); });
Route::get('/reportSale/reportVisitCustomerGoal', function () { return view('reports.report_visitcustomer_goal'); });
Route::get('/reportSale/reportVisitCustomer', function () { return view('reports.report_visitcustomer'); });

// });


// ------------------------------------------------------------------Manager-----------------------------------------------------------------------------//


// Route::middleware(['auth', 'lead'])->group(function () {
// lead
Route::get('leadManage', function () { return view('leadManager.dashboard'); });
Route::get('lead/planMonth', function () { return view('leadManager.planMonth'); });
Route::get('lead/dailyWork', function () { return view('leadManager.dailyWork'); });
Route::get('lead/dashboard', function () { return view('leadManager.dashboard'); });
Route::get('lead/palncalendar', function () { return view('leadManager.salePalnCalendar'); });
Route::get('lead/saleWork', function () { return view('leadManager.sale_work'); });
Route::get('lead/viewSaleDetail', function () { return view('leadManager.view_saleplan'); });
Route::get('lead/viewVisitDetail', function () { return view('leadManager.view_vist_customer'); });
Route::get('lead/viewAssignmentDetail', function () { return view('leadManager.view_assignment'); });

Route::get('/approvalsaleplan', 'LeadManager\ApprovalSalePlanController@index');
Route::get('/approvalsaleplan_detail/{id}', 'LeadManager\ApprovalSalePlanController@approvalsaleplan_detail');
Route::get('comment_saleplan/{id}/{createID}', 'LeadManager\ApprovalSalePlanController@comment_saleplan');
// Route::post('lead/create_comment_saleplan', 'LeadManager\ApprovalSalePlanController@create_comment_saleplan');
Route::post('lead/create_comment_saleplan', 'LeadManager\ApprovalSalePlanController@create_comment_saleplan');
Route::post('lead/approval_saleplan_confirm', 'LeadManager\ApprovalSalePlanController@approval_saleplan_confirm');
Route::post('lead/approval_saleplan_confirm_all', 'LeadManager\ApprovalSalePlanController@approval_saleplan_confirm_all');
Route::get('lead/retrospective/{id}', 'LeadManager\ApprovalSalePlanController@retrospective');

Route::get('/approvalgeneral', 'LeadManager\ApprovalController@index');
Route::post('lead/approval_confirm_all', 'LeadManager\ApprovalController@approval_confirm_all');
Route::get('lead/approval_general_detail/{id}', 'LeadManager\ApprovalController@approval_general_detail');
Route::post('lead/approval_confirm_detail', 'LeadManager\ApprovalController@approval_confirm_detail');
Route::post('lead/approvalUpdate', 'LeadManager\ApprovalController@approvalUpdate');
Route::get('comment_approval/{id}/{createID}', 'LeadManager\ApprovalController@comment_approval');
Route::post('lead/create_comment_request_approval', 'LeadManager\ApprovalController@create_comment_request_approval');
Route::get('/approvalgeneral/history', 'LeadManager\ApprovalController@approval_history');
Route::get('lead/approval_general_history_detail/{id}', 'LeadManager\ApprovalController@approval_general_history_detail');

Route::get('comment_customer_new/{id}/{createID}', 'LeadManager\ApprovalSalePlanController@comment_customer_new');
Route::post('lead/create_comment_customer_new', 'LeadManager\ApprovalSalePlanController@create_comment_customer_new');

// Assignment
Route::get('add_assignment', 'AssignmentController@index');
// Route::get('lead/searchShop', 'SaleMan\SalePlanController@searchShop');
Route::post('lead/create_assignment', 'AssignmentController@store');
Route::get('lead/edit_assignment/{id}', 'AssignmentController@edit');
Route::post('lead/update_assignment', 'AssignmentController@update');
Route::get('lead/delete_assignment/{id}', 'AssignmentController@destroy');
Route::get('lead/assignment_result_get/{id}', 'AssignmentController@assignment_result_get');

// NOTE Lead Manage
Route::get('/leadManage/note', 'NoteController@note_lead');
Route::get('lead/status_pin_update/{id}', 'NoteController@status_pin_update');
Route::post('lead/create_note', 'NoteController@store');
Route::get('lead/edit_note/{id}', 'NoteController@edit');
Route::post('lead/update_note', 'NoteController@update');
Route::get('lead/delete_note/{id}', 'NoteController@destroy');

Route::get('lead/news', 'NewsController@lead_frontend_news');
Route::get('lead/promotions', 'PromotionController@lead_frontend_promotion');
// });


// Route::middleware(['auth', 'head'])->group(function () {
// head
Route::get('headManage', function () { return view('headManager.dashboard'); });
Route::get('head/planMonth', function () { return view('headManager.planMonth'); });
Route::get('head/dailyWork', function () { return view('headManager.dailyWork'); });
Route::get('head/palncalendar', function () { return view('headManager.salePalnCalendar'); });
Route::get('head/saleWork', function () { return view('headManager.sale_work'); });
Route::get('head/viewSaleDetail', function () { return view('headManager.view_saleplan'); });
Route::get('head/viewVisitDetail', function () { return view('headManager.view_vist_customer'); });
Route::get('head/viewAssignmentDetail', function () { return view('headManager.view_assignment'); });

Route::get('head/approvalsaleplan', function () { return view('headManager.approval_saleplan'); });
Route::get('head/approvalgeneral', function () { return view('headManager.approval_general'); });
Route::get('head/approvalgeneral/history', function () { return view('headManager.approval_general_history'); });
Route::get('head/approvalsaleplan/detail', function () { return view('headManager.approval_saleplan_detail'); });
Route::get('head/assignment/add', function () { return view('headManager.add_assignment'); });

// Note Head Manage
Route::get('head/note', 'NoteController@note_head');
Route::post('head/create_note', 'NoteController@store');
Route::get('head/edit_note/{id}', 'NoteController@edit');
Route::post('head/update_note', 'NoteController@update');
Route::get('head/delete_note/{id}', 'NoteController@destroy');

Route::get('head/news', 'NewsController@head_frontend_news');
Route::get('head/promotions', 'PromotionController@head_frontend_promotion');

// });


// Route::middleware(['auth', 'admin'])->group(function () {
// admin
Route::get('admin', function () { return view('admin.dashboard'); });
Route::get('admin/palncalendar', function () { return view('admin.salePalnCalendar'); });
Route::get('admin/saleWork', function () { return view('admin.sale_work'); });
Route::get('admin/viewSaleDetail', function () { return view('admin.view_saleplan'); });
Route::get('admin/viewVisitDetail', function () { return view('admin.view_vist_customer'); });
Route::get('admin/viewAssignmentDetail', function () { return view('admin.view_assignment'); });
Route::get('admin/approvalsaleplan', function () { return view('admin.approval_saleplan'); });
Route::get('admin/approvalgeneral', function () { return view('admin.approval_general'); });
Route::get('admin/approvalgeneral/history', function () { return view('admin.approval_general_history'); });
Route::get('admin/approvalsaleplan/detail', function () { return view('admin.approval_saleplan_detail'); });

// Note
Route::get('admin/note', 'NoteController@note_admin');
Route::post('admin/create_note', 'NoteController@store');
Route::get('admin/edit_note/{id}', 'NoteController@edit');
Route::post('admin/update_note', 'NoteController@update');
Route::get('admin/delete_note/{id}', 'NoteController@destroy');
// News
Route::get('admin/fontendNews', 'NewsController@admin_frontend_news');
Route::get('admin/news', 'NewsController@index');
Route::post('admin/create_news', 'NewsController@store');
Route::get('admin/edit_news/{id}', 'NewsController@edit');
Route::post('admin/update_news', 'NewsController@update');
Route::get('admin/delete_news/{id}', 'NewsController@destroy');
// News Banner
Route::get('admin/newsBanner', 'NewsController@index_banner');
Route::post('admin/create_newsBanner', 'NewsController@banner_store');
Route::get('admin/edit_banner/{id}', 'NewsController@banner_edit');
Route::post('admin/update_banner', 'NewsController@banner_update');
Route::get('admin/delete_banner/{id}', 'NewsController@banner_destroy');

Route::get('admin/fontendPromotions', 'PromotionController@admin_frontend_promotion');
Route::get('admin/pomotion', 'PromotionController@index');
Route::post('admin/create_promotion', 'PromotionController@store');
Route::get('admin/edit_promotion/{id}', 'PromotionController@edit');
Route::post('admin/update_promotion', 'PromotionController@update');
Route::get('admin/delete_promotion/{id}', 'PromotionController@destroy');


Route::get('/admin/userPermission', 'Admin\UserPermissionController@index');
Route::post('/admin/userPermissionCreate', 'Admin\UserPermissionController@store');
Route::get('/admin/userPermissionEdit/{id}', 'Admin\UserPermissionController@edit');
Route::post('/admin/userPermissionUpdate', 'Admin\UserPermissionController@update');


Route::get('admin/checkHistory', function () { return view('admin.check_history'); });

Route::get('/admin/reportcustomer', function () { return view('reports.report_customer_admin'); });
Route::get('/admin/reportStore', function () { return view('reports.report_store_admin'); });
Route::get('/admin/reportTeam', function () { return view('reports.report_team_admin'); });
Route::get('/admin/reportSaleplan', function () { return view('reports.report_saleplan_admin'); });
Route::get('/admin/report_visitcustomer_goal', function () { return view('reports.report_visitcustomer_goal_admin'); });
Route::get('/admin/visitCustomer', function () { return view('reports.report_visitcustomer_admin'); });
Route::get('/admin/reportYear', function () { return view('reports.report_year_admin'); });

// });

//report
Route::get('/leadManage/reportcustomer', function () { return view('reports.report_customer'); });
Route::get('/leadManage/reportStore', function () { return view('reports.report_store'); });
Route::get('/leadManage/reportTeam', function () { return view('reports.report_team'); });
Route::get('/leadManage/reportSaleplan', function () { return view('reports.report_saleplan_lead'); });
Route::get('/leadManage/reportYear', function () { return view('reports.report_year'); });

Route::get('/headManage/reportcustomer', function () { return view('reports.report_customer'); });
Route::get('/headManage/reportStore', function () { return view('reports.report_store_head'); });
Route::get('/headManage/reportTeam', function () { return view('reports.report_team_head'); });
Route::get('/headManage/reportSaleplan', function () { return view('reports.report_saleplan_head'); });
Route::get('/headManage/report_visitcustomer_goal_head', function () { return view('reports.report_visitcustomer_goal_head'); });
Route::get('/headManage/visitCustomer', function () { return view('reports.report_visitcustomer_head'); });
Route::get('/headManage/reportYear', function () { return view('reports.report_year_head'); });


//fullcalender

// Route::get('fullcalendar','FullCalendarController@index');
Route::get('calendar', 'FullCalendarController@index');
Route::post('calendar/create','FullCalendarController@create');
Route::post('calendar/update','FullCalendarController@update');
Route::post('calendar/delete','FullCalendarController@destroy');


Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    return "Cache is cleared";
});


// utility

Route::get('/fetch_amphur/{id}',[ProvinceController::class, 'amphur']);
Route::get('/fetch_district/{id}',[ProvinceController::class, 'district']);
Route::get('/fetch_postcode/{id}',[ProvinceController::class, 'postcode']);

Route::get('/customer/autocomplete',[CustomerController::class, 'fetch_autocomplete']);

Auth::routes();
// Route::get('/', function () { return view('saleman.dashboard'); });

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index')->name('home');
