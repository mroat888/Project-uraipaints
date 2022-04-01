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

Route::middleware(['auth', 'saleman'])->group(function () {
Route::get('/index.html', 'Saleman\DashboardController@index');

// Sale
Route::get('dashboard',  'SaleMan\DashboardController@index');
Route::get('/planMonth', 'PlanMonthController@index');
Route::get('planMonth_history/{id}', 'PlanMonthController@history');
Route::post('search_month_planMonth', 'PlanMonthController@search_month_planMonth');
Route::get('approve_monthly_plan/{id}', 'PlanMonthController@approve');
Route::get('dailyWork', 'SaleMan\DailyWorkController@index');
Route::get('saleplan_view_comment/{id}', 'PlanMonthController@saleplan_view_comment');
Route::get('customernew_view_comment/{id}', 'PlanMonthController@customernew_view_comment');
Route::get('/palncalendar', function () { return view('saleplan.salePalnCalendar'); });

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
Route::post('delete_visit', 'Customer\CustomerVisitController@destroy');
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

// Customer shop saleplan customer_shops_saleplan
Route::get('/edit_shopsaleplan/{id}', 'Customer\CustomerShopSaleplanController@edit_shopsaleplan');
Route::post('/update_shopsaleplan', 'Customer\CustomerShopSaleplanController@update_shopsaleplan');

Route::get('/customer_lead/detail/{id}', 'Customer\CustomerController@show_lead');
Route::get('/customer/detail/{id}', 'Customer\CustomerController@show_customer');
Route::get('/customer','Customer\CustomerController@index');
Route::get('/fetch_customer_shops','Customer\CustomerController@fetch_customer_shops');
Route::get('/customer-api','Customer\ApiCustomerController@index');
Route::get('/customer-api/detail/{id}','Customer\ApiCustomerController@show');

Route::post('/leadtocustomer','Customer\CustomerController@lead_to_customer');
Route::post('/customerdelete','Customer\CustomerController@customer_delete');
Route::post('/customer_shops_saleplan_delete','Customer\CustomerController@customer_shops_saleplan_delete');

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
// Route::get('delete_saleplan/{id}', 'SaleMan\SalePlanController@destroy');
Route::post('delete_saleplan','SaleMan\SalePlanController@destroy');
Route::post('saleplan_checkin', 'SaleMan\SalePlanController@saleplan_checkin');
Route::get('saleplan_result_get/{id}', 'SaleMan\SalePlanController@saleplan_result_get');
Route::post('saleplan_Result', 'SaleMan\SalePlanController@saleplan_Result');

// Request Approval
Route::get('approval', 'SaleMan\RequestApprovalController@index');
Route::post('create_approval', 'SaleMan\RequestApprovalController@store');
Route::get('edit_approval/{id}', 'SaleMan\RequestApprovalController@edit');
Route::post('update_approval', 'SaleMan\RequestApprovalController@update');
Route::post('delete_approval', 'SaleMan\RequestApprovalController@destroy');
Route::get('view_comment/{id}', 'SaleMan\RequestApprovalController@view_comment');
Route::post('search_month_requestApprove', 'SaleMan\RequestApprovalController@search_month_requestApprove');

// TEST REQUEST
Route::get('approval', 'SaleMan\RequestApprovalController@index');
Route::get('approval2', 'SaleMan\RequestApprovalController@index2');

// NOTE
Route::get('note', 'NoteController@note_sale');
Route::get('status_pin_update/{id}', 'NoteController@status_pin_update');
Route::post('create_note', 'NoteController@store');
Route::get('edit_note/{id}', 'NoteController@edit');
Route::post('update_note', 'NoteController@update');
Route::get('delete_note/{id}', 'NoteController@destroy');
Route::post('search_month_note', 'NoteController@search_month_note');


Route::get('news', 'NewsController@frontend_news');
Route::get('news_detail/{id}', 'NewsController@news_detail');
Route::get('promotions', 'PromotionController@frontend_promotion');
Route::get('promotion_detail/{id}', 'PromotionController@promotion_detail');
Route::get('product_new', 'ProductNewController@frontend_product_new');

// Report
Route::get('/reportSale/reportMonthlyPlans', 'Report\ReportMonthlyPlansController@index');
Route::post('/reportSale/reportMonthlyPlans/search', 'Report\ReportMonthlyPlansController@search');
Route::get('/reportSale/reportSaleplan', 'Report\ReportSalePlanController@index');
Route::post('/reportSale/reportSaleplan/search', 'Report\ReportSalePlanController@search');
Route::get('/reportSale/reportVisitCustomerGoal', 'Report\ReportVisitCustomerGoalController@index');
Route::post('/reportSale/reportVisitCustomerGoal/search', 'Report\ReportVisitCustomerGoalController@search');
Route::get('/reportSale/reportVisitCustomer', 'Report\ReportVisitCustomerController@index');
Route::post('/reportSale/reportVisitCustomer/search', 'Report\ReportVisitCustomerController@search');

Route::get('edit-profile', 'ProfileController@index');
Route::post('userProfileUpdate', 'ProfileController@update');

// ข้อมูลที่ใช้ร่วมกัน
Route::get('data_name_store', 'ShareData\CheckStoreController@index');
Route::post('data_name_store/search', 'ShareData\CheckStoreController@search');
Route::get('data_name_store/detail/{id}', 'ShareData\CheckStoreController@show');
Route::get('data_search_product', 'ShareData\SearchroductController@index');
Route::post('data_search_product/search', 'ShareData\SearchroductController@search');
Route::get('data_report_product-new', 'ShareData\ProductNewController@index');
Route::get('data_report_full-year', 'ShareData\ReportFullYearController@index');
Route::post('data_report_full-year/search', 'ShareData\ReportFullYearController@search');
Route::get('data_report_historical-year', 'ShareData\ReportHistoricalYearController@index');
Route::post('data_report_historical-year/search', 'ShareData\ReportHistoricalYearController@search');
Route::get('data_report_historical-quarter', 'ShareData\ReportHistoricalQuarterController@index');
Route::post('data_report_historical-quarter/search', 'ShareData\ReportHistoricalQuarterController@search');
Route::get('data_report_historical-month', 'ShareData\ReportHistoricalMonthController@index');
Route::post('data_report_historical-month/search', 'ShareData\ReportHistoricalMonthController@search');
Route::get('data_report_sale_compare-year','ShareData\ReportSaleCompareYearController@index');
});




// ------------------------------------------------------------------Manager-----------------------------------------------------------------------------//


Route::middleware(['auth', 'lead'])->group(function () {
// lead
// Route::get('leadManager', 'LeadManager\DashboardController@index');
Route::get('lead/dashboard', 'LeadManager\DashboardController@index');
Route::get('lead/planMonth', function () { return view('leadManager.planMonth'); });
Route::get('lead/dailyWork', function () { return view('leadManager.dailyWork'); });
Route::get('lead/palncalendar', function () { return view('leadManager.salePalnCalendar'); });
Route::get('lead/saleWork', function () { return view('leadManager.sale_work'); });
Route::get('lead/viewSaleDetail', function () { return view('leadManager.view_saleplan'); });
Route::get('lead/viewVisitDetail', function () { return view('leadManager.view_vist_customer'); });
Route::get('lead/viewAssignmentDetail', function () { return view('leadManager.view_assignment'); });

Route::get('/approvalsaleplan', 'LeadManager\ApprovalSalePlanController@index');
Route::post('/approvalsaleplan/search', 'LeadManager\ApprovalSalePlanController@search');
Route::post('lead/approvalsaleplan-history/search', 'LeadManager\ApprovalSalePlanController@history_search');
Route::get('lead/approvalsaleplan-history', 'LeadManager\ApprovalSalePlanController@saleplan_history');
Route::get('lead/approvalsaleplan-history-detail/{id}', 'LeadManager\ApprovalSalePlanController@saleplan_history_detail');
Route::get('/approvalsaleplan_detail/{id}', 'LeadManager\ApprovalSalePlanController@approvalsaleplan_detail');
Route::get('comment_saleplan/{id}/{createID}', 'LeadManager\ApprovalSalePlanController@comment_saleplan');
Route::post('lead/create_comment_saleplan', 'LeadManager\ApprovalSalePlanController@create_comment_saleplan');
Route::post('lead/approval_saleplan_confirm', 'LeadManager\ApprovalSalePlanController@approval_saleplan_confirm');
Route::post('lead/approval_saleplan_confirm_all', 'LeadManager\ApprovalSalePlanController@approval_saleplan_confirm_all');
Route::post('lead/retrospective', 'LeadManager\ApprovalSalePlanController@retrospective');

Route::get('/approvalgeneral', 'LeadManager\ApprovalController@index');
Route::post('lead/approval_confirm_all', 'LeadManager\ApprovalController@approval_confirm_all');
Route::get('lead/approval_general_detail/{id}', 'LeadManager\ApprovalController@approval_general_detail');
Route::post('lead/approval_confirm_detail', 'LeadManager\ApprovalController@approval_confirm_detail');
Route::post('lead/approvalUpdate', 'LeadManager\ApprovalController@approvalUpdate');
Route::get('comment_approval/{id}/{createID}', 'LeadManager\ApprovalController@comment_approval');
Route::post('lead/create_comment_request_approval', 'LeadManager\ApprovalController@create_comment_request_approval');
Route::get('/approvalgeneral/history', 'LeadManager\ApprovalController@approval_history');
Route::get('lead/approval_general_history_detail/{id}', 'LeadManager\ApprovalController@approval_general_history_detail');
Route::get('lead/view_approval/{id}', 'LeadManager\ApprovalController@view_approval');

Route::get('show_comment_request_approval_history/{id}/{createID}', 'LeadManager\ApprovalController@comment_approval_history');
Route::post('lead/approvalGeneral_detail/search', 'LeadManager\ApprovalController@search_detail');
Route::post('lead/approvalGeneral-history/search', 'LeadManager\ApprovalController@search_history');
Route::post('lead/approvalGeneral/search', 'LeadManager\ApprovalController@search');

// อนุมัติลูกค้าใหม่นอกแผน
Route::get('approval-customer-except', 'LeadManager\ApprovalCustomerExceptController@index');
Route::post('lead/approval_customer_confirm_all', 'LeadManager\ApprovalCustomerExceptController@approval_customer_confirm_all');
Route::get('lead/approval_customer_except_detail/{id}', 'LeadManager\ApprovalCustomerExceptController@approval_customer_except_detail');
Route::get('lead/comment_customer_except/{id}/{custsaleplanID}/{createID}', 'LeadManager\ApprovalCustomerExceptController@comment_customer_except');
Route::post('lead/create_comment_customer_except', 'LeadManager\ApprovalCustomerExceptController@create_comment_customer_except');
Route::get('lead/approval-customer-except-history', 'LeadManager\ApprovalCustomerExceptController@customer_history');
Route::get('lead/approval_customer_except_history_detail/{id}', 'LeadManager\ApprovalCustomerExceptController@approval_customer_except_history_detail');
Route::get('lead/show_comment_customer_except/{id}/{custsaleplanID}/{createID}', 'LeadManager\ApprovalCustomerExceptController@show_comment_customer_except');
Route::post('lead/approval-customer-except/search', 'LeadManager\ApprovalCustomerExceptController@search');
Route::post('lead/approval-customer-except-history/search', 'LeadManager\ApprovalCustomerExceptController@search_history');

Route::get('comment_customer_new/{id}/{custsaleplanID}/{createID}', 'LeadManager\ApprovalSalePlanController@comment_customer_new');
Route::post('lead/create_comment_customer_new', 'LeadManager\ApprovalSalePlanController@create_comment_customer_new');

// Assignment
Route::get('add_assignment', 'AssignmentController@index');
Route::post('lead/create_assignment', 'AssignmentController@store');
Route::get('lead/edit_assignment/{id}', 'AssignmentController@edit');
Route::post('lead/update_assignment', 'AssignmentController@update');
Route::get('lead/delete_assignment/{id}', 'AssignmentController@destroy');
Route::get('lead/assignment_result_get/{id}', 'AssignmentController@assignment_result_get');
Route::post('lead/search_month_add-assignment', 'AssignmentController@lead_search_month_add_assignment');

// NOTE Lead Manage
Route::get('/leadManage/note', 'NoteController@note_lead');
Route::get('lead/status_pin_update/{id}', 'NoteController@status_pin_update');
Route::post('lead/create_note', 'NoteController@store');
Route::get('lead/edit_note/{id}', 'NoteController@edit');
Route::post('lead/update_note', 'NoteController@update');
Route::get('lead/delete_note/{id}', 'NoteController@destroy');
Route::post('lead/search_month_note', 'NoteController@lead_search_month_note');

Route::get('lead/news', 'NewsController@lead_frontend_news');
Route::get('lead/promotions', 'PromotionController@lead_frontend_promotion');
Route::get('lead/product_new', 'ProductNewController@lead_frontend_product_new');
Route::get('lead/news_detail/{id}', 'NewsController@lead_news_detail');
Route::get('lead/promotion_detail/{id}', 'PromotionController@lead_promotion_detail');

//report
Route::get('/leadManage/reportcustomer', function () { return view('reports.report_customer'); });
Route::get('/leadManage/reportStore','LeadManager\ApiCustomerController@index');
Route::get('/leadManage/reportStore/detail/{id}','LeadManager\ApiCustomerController@show');
// Route::get('/leadManage/reportTeam', 'LeadManager\ReportTeamController@index'); // -- ลูกค้าให้เปลี่ยนใช้ api อันล่าง
Route::get('/leadManage/reportTeam', 'LeadManager\ReportTeamController@reportTeamApi'); // เปลี่ยนมาอันนี้ <----|
// Route::get('/leadManage/reportSaleplan', 'LeadManager\ReportSalePlanController@index'); //-- เปลี่ยนรูปแบบรายงานใหม่ ใช้อันล่าง
// Route::post('/leadManage/reportSaleplan/search', 'LeadManager\ReportSalePlanController@search'); //-- เปลี่ยนรูปแบบรายงานใหม่ ใช้อันล่าง
Route::get('/leadManage/reportSaleplan', 'LeadManager\ReportSalePlanController@reportsalepaln');
Route::post('/leadManage/reportSaleplan/search', 'LeadManager\ReportSalePlanController@reportsalepaln_search');
Route::get('/leadManage/reportYear', 'LeadManager\ReportYearController@index');
Route::post('/leadManage/reportYear/search', 'LeadManager\ReportYearController@search');


// ข้อมูลที่ใช้ร่วมกัน
Route::get('leadManage/data_name_store', 'ShareData_LeadManager\CheckStoreController@index');
Route::post('leadManage/data_name_store/search', 'ShareData_LeadManager\CheckStoreController@search');
Route::get('leadManage/data_name_store/detail/{id}', 'ShareData_LeadManager\CheckStoreController@show');
Route::get('leadManage/data_search_product', 'ShareData_LeadManager\SearchroductController@index');
Route::post('leadManage/data_search_product/search', 'ShareData_LeadManager\SearchroductController@search');
Route::get('leadManage/data_report_product-new', 'ShareData_LeadManager\ProductNewController@index');
Route::get('leadManage/data_report_full-year', 'ShareData_LeadManager\ReportFullYearController@index');
Route::post('leadManage/data_report_full-year/search', 'ShareData_LeadManager\ReportFullYearController@search');
Route::get('leadManage/data_report_historical-year', 'ShareData_LeadManager\ReportHistoricalYearController@index');
Route::post('leadManage/data_report_historical-year/search', 'ShareData_LeadManager\ReportHistoricalYearController@search');
Route::get('leadManage/data_report_historical-quarter', 'ShareData_LeadManager\ReportHistoricalQuarterController@index');
Route::post('leadManage/data_report_historical-quarter/search', 'ShareData_LeadManager\ReportHistoricalQuarterController@search');
Route::get('leadManage/data_report_historical-month', 'ShareData_LeadManager\ReportHistoricalMonthController@index');
Route::post('leadManage/data_report_historical-month/search', 'ShareData_LeadManager\ReportHistoricalMonthController@search');
Route::get('leadManage/data_report_sale_compare-year','ShareData_LeadManager\ReportSaleCompareYearController@index');

Route::get('lead/edit-profile', 'ProfileController@lead_index');
Route::post('lead/userProfileUpdate', 'ProfileController@update');

});


// ==================================================================== Head ====================================================================//

Route::middleware(['auth', 'head'])->group(function () {
// head
Route::get('headManage', 'HeadManager\DashboardController@index');
// Route::get('head/planMonth', function () { return view('headManager.planMonth'); });
// Route::get('head/dailyWork', function () { return view('headManager.dailyWork'); });
Route::get('head/palncalendar', function () { return view('headManager.salePalnCalendar'); });
Route::get('head/saleWork', function () { return view('headManager.sale_work'); });
Route::get('head/viewSaleDetail', function () { return view('headManager.view_saleplan'); });
Route::get('head/viewVisitDetail', function () { return view('headManager.view_vist_customer'); });
Route::get('head/viewAssignmentDetail', function () { return view('headManager.view_assignment'); });

Route::get('head/approvalsaleplan', 'HeadManager\ApprovalSalePlanController@index');
Route::get('head/approvalsaleplan_detail/{id}', 'HeadManager\ApprovalSalePlanController@approvalsaleplan_detail');
Route::get('head/comment_saleplan/{id}/{createID}', 'HeadManager\ApprovalSalePlanController@comment_saleplan');
Route::post('head/create_comment_saleplan', 'HeadManager\ApprovalSalePlanController@create_comment_saleplan');
Route::get('head/comment_customer_new/{id}/{custsaleplanID}/{createID}', 'HeadManager\ApprovalSalePlanController@comment_customer_new');
Route::post('head/create_comment_customer_new', 'HeadManager\ApprovalSalePlanController@create_comment_customer_new');
Route::post('head/approvalsaleplan/search', 'HeadManager\ApprovalSalePlanController@search');

Route::get('head/approvalgeneral', 'HeadManager\ApprovalController@index');
Route::get('head/approvalgeneral/history', function () { return view('headManager.approval_general_history'); });
Route::get('head/approval_general_detail/{id}', 'HeadManager\ApprovalController@approval_general_detail');
Route::get('head/comment_approval/{id}/{createID}', 'HeadManager\ApprovalController@comment_approval');
Route::post('head/create_comment_request_approval', 'HeadManager\ApprovalController@create_comment_request_approval');
Route::post('head/approvalgeneral/search', 'HeadManager\ApprovalController@search');
Route::get('head/view_approval/{id}', 'HeadManager\ApprovalController@view_approval');

// Assignment
Route::get('head/assignment/add', 'AssignmentController@assignIndex');
Route::post('head/create_assignment', 'AssignmentController@store_head');
Route::get('head/edit_assignment/{id}', 'AssignmentController@edit');
Route::post('head/update_assignment', 'AssignmentController@update');
Route::get('head/delete_assignment/{id}', 'AssignmentController@destroy');
Route::post('head/search_month_add-assignment', 'AssignmentController@head_search_month_add_assignment');


// อนุมัติลูกค้าใหม่นอกแผน
Route::get('head/approval-customer-except', 'HeadManager\ApprovalCustomerExceptController@index');
Route::post('head/approval_customer_confirm_all', 'HeadManager\ApprovalCustomerExceptController@approval_customer_confirm_all');
Route::get('head/approval_customer_except_detail/{id}', 'HeadManager\ApprovalCustomerExceptController@approval_customer_except_detail');
Route::get('head/comment_customer_except/{id}/{custsaleplanID}/{createID}', 'HeadManager\ApprovalCustomerExceptController@comment_customer_except');
Route::post('head/create_comment_customer_except', 'HeadManager\ApprovalCustomerExceptController@create_comment_customer_except');
Route::post('head/approvalcustomer-except/search', 'HeadManager\ApprovalCustomerExceptController@search');

// Note Head Manage
Route::get('head/note', 'NoteController@note_head');
Route::post('head/create_note', 'NoteController@store');
Route::get('head/edit_note/{id}', 'NoteController@edit');
Route::post('head/update_note', 'NoteController@update');
Route::get('head/delete_note/{id}', 'NoteController@destroy');
Route::post('head/search_month_note', 'NoteController@head_search_month_note');
Route::get('head/status_pin_update/{id}', 'NoteController@status_pin_update');

Route::get('head/news', 'NewsController@head_frontend_news');
Route::get('head/promotions', 'PromotionController@head_frontend_promotion');
Route::get('head/product_new', 'ProductNewController@head_frontend_product_new');
Route::get('head/news_detail/{id}', 'NewsController@head_news_detail');
Route::get('head/promotion_detail/{id}', 'PromotionController@head_promotion_detail');

//report
Route::get('/headManage/reportcustomer', function () { return view('reports.report_customer'); });
Route::get('/headManage/reportStore','HeadManager\ApiCustomerController@index');
Route::get('/headManage/reportStore/detail/{id}','HeadManager\ApiCustomerController@show');
// Route::get('/headManage/reportTeam', 'HeadManager\ReportTeamController@index'); //-- ลูกค้าเปลี่ยนให้ดึง API ใช้อันล่าง
Route::get('/headManage/reportTeam', 'HeadManager\ReportTeamController@reportTeamApi');
// Route::get('/headManage/reportSaleplan', 'HeadManager\ReportSalePlanController@index');
// Route::post('/headManage/reportSaleplan/search', 'HeadManager\ReportSalePlanController@search');
Route::get('/headManage/reportSaleplan', 'HeadManager\ReportSalePlanController@reportsalepaln');
Route::post('/headManage/reportSaleplan/search', 'HeadManager\ReportSalePlanController@reportsalepaln_search');

Route::get('/headManage/report_visitcustomer_goal_head', 'HeadManager\ReportVisitCustomerGoalController@index');
Route::post('/headManage/report_visitcustomer_goal_head/search', 'HeadManager\ReportVisitCustomerGoalController@search');
Route::get('/headManage/reportVisitCustomer', 'HeadManager\ReportVisitCustomerController@index');
Route::post('/headManage/reportVisitCustomer/search', 'HeadManager\ReportVisitCustomerController@search');
Route::get('/headManage/reportYear', 'HeadManager\ReportYearController@index');
Route::post('/headManage/reportYear/search', 'HeadManager\ReportYearController@search');

Route::get('head/edit-profile', 'ProfileController@head_index');
Route::post('head/userProfileUpdate', 'ProfileController@update');


// ข้อมูลที่ใช้ร่วมกัน
Route::get('headManage/data_name_store', 'ShareData_HeadManager\CheckStoreController@index');
Route::post('headManage/data_name_store/search', 'ShareData_HeadManager\CheckStoreController@search');
Route::get('headManage/data_name_store/detail/{id}', 'ShareData_HeadManager\CheckStoreController@show');
Route::get('headManage/data_search_product', 'ShareData_HeadManager\SearchroductController@index');
Route::post('headManage/data_search_product/search', 'ShareData_HeadManager\SearchroductController@search');
Route::get('headManage/data_report_product-new', 'ShareData_HeadManager\ProductNewController@index');
Route::get('headManage/data_report_full-year', 'ShareData_HeadManager\ReportFullYearController@index');
Route::post('headManage/data_report_full-year/search', 'ShareData_HeadManager\ReportFullYearController@search');
Route::get('headManage/data_report_historical-year', 'ShareData_HeadManager\ReportHistoricalYearController@index');
Route::post('headManage/data_report_historical-year/search', 'ShareData_HeadManager\ReportHistoricalYearController@search');
Route::get('headManage/data_report_historical-quarter', 'ShareData_HeadManager\ReportHistoricalQuarterController@index');
Route::post('headManage/data_report_historical-quarter/search', 'ShareData_HeadManager\ReportHistoricalQuarterController@search');
Route::get('headManage/data_report_historical-month', 'ShareData_HeadManager\ReportHistoricalMonthController@index');
Route::post('headManage/data_report_historical-month/search', 'ShareData_HeadManager\ReportHistoricalMonthController@search');
Route::get('headManage/data_report_sale_compare-year','ShareData_HeadManager\ReportSaleCompareYearController@index');
});


// ------------------------------------------------------------ ADMIN --------------------------------------------------------------------- //

Route::middleware(['auth', 'admin'])->group(function () {
// admin

Route::get('admin', 'Admin\DashboardController@index');
Route::get('admin/palncalendar', function () { return view('admin.salePalnCalendar'); });
Route::get('admin/saleWork', function () { return view('admin.sale_work'); });
Route::get('admin/viewSaleDetail', function () { return view('admin.view_saleplan'); });
Route::get('admin/viewVisitDetail', function () { return view('admin.view_vist_customer'); });
Route::get('admin/viewAssignmentDetail', function () { return view('admin.view_assignment'); });

Route::get('admin/approvalsaleplan', 'Admin\ApprovalSalePlanController@index');
Route::get('admin/approvalsaleplan_detail/{id}', 'Admin\ApprovalSalePlanController@approvalsaleplan_detail');
Route::get('admin/comment_saleplan/{id}/{createID}', 'Admin\ApprovalSalePlanController@comment_saleplan');
Route::post('admin/create_comment_saleplan', 'Admin\ApprovalSalePlanController@create_comment_saleplan');
Route::get('admin/comment_customer_new/{id}/{custsaleplanID}/{createID}', 'Admin\ApprovalSalePlanController@comment_customer_new');
Route::post('admin/create_comment_customer_new', 'Admin\ApprovalSalePlanController@create_comment_customer_new');
// Route::get('admin/retrospective/{id}', 'Admin\ApprovalSalePlanController@retrospective');
Route::post('admin/retrospective', 'Admin\ApprovalSalePlanController@retrospective');
Route::post('admin/approvalsaleplan/search', 'Admin\ApprovalSalePlanController@search');

Route::get('admin/approvalgeneral', 'Admin\ApprovalController@index');
Route::get('admin/approval_general_detail/{id}', 'Admin\ApprovalController@approval_general_detail');
Route::get('admin/comment_approval/{id}/{createID}', 'Admin\ApprovalController@comment_approval');
Route::post('admin/create_comment_request_approval', 'Admin\ApprovalController@create_comment_request_approval');
Route::get('admin/approvalgeneral/history', function () { return view('admin.approval_general_history'); });
Route::post('admin/approvalgeneral/search', 'Admin\ApprovalController@search');
Route::get('admin/view_approval/{id}', 'Admin\ApprovalController@view_approval');

Route::get('admin/assignment-add', 'Admin\AssignmentController@index');
Route::get('admin/fetch_user/{id}', 'Admin\AssignmentController@fetch_user');
Route::post('admin/create_assignment', 'Admin\AssignmentController@store');
Route::get('admin/edit_assignment/{id}', 'Admin\AssignmentController@edit');
Route::post('admin/update_assignment', 'Admin\AssignmentController@update');
Route::get('admin/delete_assignment/{id}', 'Admin\AssignmentController@destroy');
Route::post('admin/search_month_add-assignment', 'Admin\AssignmentController@search');


// Note
Route::get('admin/note', 'NoteController@note_admin');
Route::post('admin/create_note', 'NoteController@store');
Route::get('admin/edit_note/{id}', 'NoteController@edit');
Route::post('admin/update_note', 'NoteController@update');
Route::get('admin/delete_note/{id}', 'NoteController@destroy');
Route::post('admin/search_month_note', 'NoteController@admin_search_month_note');
Route::get('admin/status_pin_update/{id}', 'NoteController@status_pin_update');

// News
Route::get('admin/fontendNews', 'NewsController@admin_frontend_news');
Route::get('admin/news', 'NewsController@index');
Route::post('admin/create_news', 'NewsController@store');
Route::get('admin/edit_news/{id}', 'NewsController@edit');
Route::post('admin/update_news', 'NewsController@update');
Route::post('admin/delete_news', 'NewsController@destroy');
Route::get('admin/news_detail/{id}', 'NewsController@admin_news_detail');
Route::post('admin/search-news-status-usage', 'NewsController@search_news_status_usage');
Route::get('admin/update-news-status-use/{id}', 'NewsController@update_status_use');

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
Route::get('admin/promotion_detail/{id}', 'PromotionController@admin_promotion_detail');
Route::post('admin/search-promotion-status-usage', 'PromotionController@search_promotion_status_promotion');
// Route::get('admin/update-promotion-status-use/{id}', 'PromotionController@update_status_use');


// Product New
Route::get('admin/fontendProductNew', 'ProductNewController@admin_frontend_product_new');
Route::get('admin/product_new', 'ProductNewController@index');
Route::post('admin/create_product_new', 'ProductNewController@store');
Route::get('admin/edit_product_new/{id}', 'ProductNewController@edit');
Route::post('admin/update_product_new', 'ProductNewController@update');
Route::get('admin/delete_product_new/{id}', 'ProductNewController@destroy');
Route::post('admin/search-productNew-status-usage', 'ProductNewController@search_news_status_usage');
Route::get('admin/update-productNew-status-use/{id}', 'ProductNewController@update_status_use');


// Product Property
Route::get('admin/product_property', 'Admin\ProductPropertyController@index');
Route::post('admin/create_product_property', 'Admin\ProductPropertyController@store');
Route::get('admin/edit_product_property/{id}', 'Admin\ProductPropertyController@edit');
Route::post('admin/update_product_property', 'Admin\ProductPropertyController@update');
Route::get('admin/delete_product_property/{id}', 'Admin\ProductPropertyController@destroy');


Route::get('/admin/userPermission', 'Admin\UserPermissionController@index');
Route::post('/admin/userPermissionCreate', 'Admin\UserPermissionController@store');
Route::get('/admin/userPermissionEdit/{id}', 'Admin\UserPermissionController@edit');
Route::post('/admin/userPermissionUpdate', 'Admin\UserPermissionController@update');
Route::get('admin/update-status-use/{id}', 'Admin\UserPermissionController@update_status_use');


Route::get('admin/checkHistory', 'Admin\UsageHistoryController@index');
Route::post('admin/checkHistory/search', 'Admin\UsageHistoryController@search');

Route::get('/admin/reportcustomer', function () { return view('reports.report_customer_admin'); });
Route::get('/admin/reportStore','Admin\ApiCustomerController@index');
Route::get('/admin/reportStore/detail/{id}','Admin\ApiCustomerController@show');
Route::get('/admin/reportTeam', 'Admin\ReportTeamController@index');
// Route::get('/admin/reportSaleplan', 'Admin\ReportSalePlanController@index'); //-- เปลี่ยนใช้อันล่าง
// Route::post('/admin/reportSaleplan/search', 'Admin\ReportSalePlanController@search');
Route::get('/admin/reportSaleplan', 'Admin\ReportSalePlanController@reportsalepaln');
Route::post('/admin/reportSaleplan/search', 'Admin\ReportSalePlanController@reportsalepaln_search');
Route::get('/admin/report_visitcustomer_goal', 'Admin\ReportVisitCustomerGoalController@index');
Route::post('/admin/report_visitcustomer_goal/search', 'Admin\ReportVisitCustomerGoalController@search');
Route::get('/admin/reportVisitCustomer', 'Admin\ReportVisitCustomerController@index');
Route::post('/admin/reportVisitCustomer/search', 'Admin\ReportVisitCustomerController@search');
Route::get('/admin/reportYear', 'Admin\ReportYearController@index');
Route::post('/admin/reportYear/search', 'Admin\ReportYearController@search');


Route::get('admin/teamSales', 'Admin\TeamSaleController@index');
Route::get('admin/teamSales_detail/{id}', 'Admin\TeamSaleController@teamSales_detail');

// Master
Route::get('admin/master_present_saleplan', 'Admin\MasterPresentSaleplanController@index');
Route::post('admin/create_master_present_saleplan', 'Admin\MasterPresentSaleplanController@store');
Route::get('/admin/edit_master_present_saleplan/{id}', 'Admin\MasterPresentSaleplanController@edit');
Route::post('/admin/update_master_present_saleplan', 'Admin\MasterPresentSaleplanController@update');
Route::get('admin/delete_master_present_saleplan/{id}', 'Admin\MasterPresentSaleplanController@destroy');

Route::get('admin/master_assignment', 'Admin\MasterAssignmentController@index');
Route::post('admin/create_master_assignment', 'Admin\MasterAssignmentController@store');
Route::get('/admin/edit_master_assignment/{id}', 'Admin\MasterAssignmentController@edit');
Route::post('/admin/update_master_assignment', 'Admin\MasterAssignmentController@update');
Route::get('admin/delete_master_assignment/{id}', 'Admin\MasterAssignmentController@destroy');

Route::get('admin/master_objective_saleplan', 'Admin\MasterObjectiveSaleplanController@index');
Route::post('admin/create_master_objective_saleplan', 'Admin\MasterObjectiveSaleplanController@store');
Route::get('/admin/edit_master_objective_saleplan/{id}', 'Admin\MasterObjectiveSaleplanController@edit');
Route::post('/admin/update_master_objective_saleplan', 'Admin\MasterObjectiveSaleplanController@update');
Route::get('admin/delete_master_objective_saleplan/{id}', 'Admin\MasterObjectiveSaleplanController@destroy');

Route::get('admin/master_tag', 'Admin\MasterNoteTagController@index');
Route::post('admin/create_master_tag', 'Admin\MasterNoteTagController@store');
Route::get('/admin/edit_master_tag/{id}', 'Admin\MasterNoteTagController@edit');
Route::post('/admin/update_master_tag', 'Admin\MasterNoteTagController@update');
Route::get('admin/delete_master_tag/{id}', 'Admin\MasterNoteTagController@destroy');

Route::get('admin/master_objective_visit', 'Admin\MastrObjectiveVisitController@index');
Route::post('admin/create_master_objective_visit', 'Admin\MastrObjectiveVisitController@store');
Route::get('/admin/edit_master_objective_visit/{id}', 'Admin\MastrObjectiveVisitController@edit');
Route::post('/admin/update_master_objective_visit', 'Admin\MastrObjectiveVisitController@update');
Route::get('admin/delete_master_objective_visit/{id}', 'Admin\MastrObjectiveVisitController@destroy');

Route::get('admin/master_customer_new', 'Admin\MastrCustomerNewController@index');
Route::post('admin/create_master_customer_new', 'Admin\MastrCustomerNewController@store');
Route::get('/admin/edit_master_customer_new/{id}', 'Admin\MastrCustomerNewController@edit');
Route::post('/admin/update_master_customer_new', 'Admin\MastrCustomerNewController@update');
Route::get('admin/delete_master_customer_new/{id}', 'Admin\MastrCustomerNewController@destroy');

Route::get('admin/master_teamSales', 'Admin\TeamSaleController@add_index');
Route::post('admin/teamsalesCreate', 'Admin\TeamSaleController@store');
Route::get('admin/teamsalesEdit/{id}', 'Admin\TeamSaleController@edit');
Route::post('admin/teamsalesUpdate', 'Admin\TeamSaleController@update');

Route::get('admin/master_setting', 'Admin\MasterSettingController@index');
Route::post('admin/master_setting/update', 'Admin\MasterSettingController@update');

Route::get('admin/edit-profile', 'ProfileController@admin_index');
Route::post('admin/userProfileUpdate', 'ProfileController@update');


// ข้อมูลที่ใช้ร่วมกัน
Route::get('admin/data_name_store', 'ShareData_Admin\CheckStoreController@index');
Route::post('admin/data_name_store/search', 'ShareData_Admin\CheckStoreController@search');
Route::get('admin/data_name_store/detail/{id}', 'ShareData_Admin\CheckStoreController@show');
Route::get('admin/data_search_product', 'ShareData_Admin\SearchroductController@index');
Route::post('admin/data_search_product/search', 'ShareData_Admin\SearchroductController@search');
Route::get('admin/data_report_product-new', 'ShareData_Admin\ProductNewController@index');
Route::post('admin/data_report_product-new/search', 'ShareData_Admin\ProductNewController@search');
Route::get('admin/data_report_product-new/show/{id}', 'ShareData_Admin\ProductNewController@show');
Route::get('admin/data_report_full-year', 'ShareData_Admin\ReportFullYearController@index');
Route::post('admin/data_report_full-year/search', 'ShareData_Admin\ReportFullYearController@search');
Route::get('admin/data_report_historical-year', 'ShareData_Admin\ReportHistoricalYearController@index');
Route::post('admin/data_report_historical-year/search', 'ShareData_Admin\ReportHistoricalYearController@search');
Route::get('admin/data_report_historical-quarter', 'ShareData_Admin\ReportHistoricalQuarterController@index');
Route::post('admin/data_report_historical-quarter/search', 'ShareData_Admin\ReportHistoricalQuarterController@search');
Route::get('admin/data_report_historical-month', 'ShareData_Admin\ReportHistoricalMonthController@index');
Route::post('admin/data_report_historical-month/search', 'ShareData_Admin\ReportHistoricalMonthController@search');
Route::get('admin/data_report_sale_compare-year','ShareData_Admin\ReportSaleCompareYearController@index');

});


// MustBeReport
// Route::middleware(['auth', 'report'])->group(function () {
//     Route::get('test2', function () { return "Report"; });
// });


//fullcalender

// Route::get('fullcalendar','FullCalendarController@index');
Route::get('calendar', 'FullCalendarController@index');
Route::post('calendar/create','FullCalendarController@create');
Route::post('calendar/update','FullCalendarController@update');
Route::post('calendar/delete','FullCalendarController@destroy');
Route::get('calendar/show/{id}','FullCalendarController@show');


// Route::get('/clear-cache', function() {
Route::get('/clc', function() {
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


Route::get('fetch_subgroups/{id}', 'Api\ApiController@fetch_subgroups');
Route::get('fetch_pdglists/{id}', 'Api\ApiController@fetch_pdglists');
Route::get('fetch_products/{id}', 'Api\ApiController@fetch_products');
Route::get('fetch_amphur_api/{position}/{id}', 'Api\ApiController@fetch_amphur_api');


//-- Salller
Route::get('fetch_provinces_products/{id}', 'Api\ApiController@fetch_provinces_products');
Route::get('fetch_amphur_products/{pdgid}/{id}', 'Api\ApiController@fetch_amphur_products');
Route::get('fetch_datatable_customer_sellers/{pdgid}/{pvid}/{ampid}', 'Api\ApiController@fetch_datatable_customer_sellers');
Route::get('fetch_datatable_customer_sellers_pdglist_pvid/{pdgid}/{pvid}', 'Api\ApiController@fetch_datatable_customer_sellers_pdglist_pvid');
Route::get('fetch_datatable_customer_sellers_pdglist/{pdgid}', 'Api\ApiController@fetch_datatable_customer_sellers_pdglist');

// Leader
Route::get('fetch_provinces_products_leaders/{id}', 'Api\ApiController@fetch_provinces_products_leaders');
Route::get('fetch_amphur_products_leaders/{pdgid}/{id}', 'Api\ApiController@fetch_amphur_products_leaders');
Route::get('fetch_datatable_customer_leaders/{pdgid}/{pvid}/{ampid}', 'Api\ApiController@fetch_datatable_customer_leaders');
Route::get('fetch_datatable_customer_leaders_pdglist_pvid/{pdgid}/{pvid}', 'Api\ApiController@fetch_datatable_customer_leaders_pdglist_pvid');
Route::get('fetch_datatable_customer_leaders_pdglist/{pdgid}', 'Api\ApiController@fetch_datatable_customer_leaders_pdglist');

// header
Route::get('fetch_provinces_products_headers/{id}', 'Api\ApiController@fetch_provinces_products_headers');
Route::get('fetch_amphur_products_headers/{pdgid}/{id}', 'Api\ApiController@fetch_amphur_products_headers');
Route::get('fetch_datatable_customer_headers/{pdgid}/{pvid}/{ampid}', 'Api\ApiController@fetch_datatable_customer_headers');
Route::get('fetch_datatable_customer_headers_pdglist_pvid/{pdgid}/{pvid}', 'Api\ApiController@fetch_datatable_customer_headers_pdglist_pvid');
Route::get('fetch_datatable_customer_headers_pdglist/{pdgid}', 'Api\ApiController@fetch_datatable_customer_headers_pdglist');

// admin
Route::get('fetch_provinces_products_admin/{id}', 'Api\ApiController@fetch_provinces_products_admin');
Route::get('fetch_amphur_products_admin/{id}', 'Api\ApiController@fetch_amphur_products_admin');
Route::get('fetch_datatable_customer_admin/{ampid}', 'Api\ApiController@fetch_datatable_customer_admin');
Route::get('fetch_datatable_customer_admin_pdglist_pvid/{pvid}', 'Api\ApiController@fetch_datatable_customer_admin_pdglist_pvid');
Route::get('fetch_datatable_customer_admin_pdglist/{pdgid}', 'Api\ApiController@fetch_datatable_customer_admin_pdglist');

Auth::routes();
// Route::get('/', function () { return view('saleman.dashboard'); });

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index')->name('home');
