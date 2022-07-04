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
Route::get('important-day-detail',  'SaleMan\ImportantDayController@index');
Route::get('/planMonth', 'PlanMonthController@index');
Route::get('planMonth_history/{id}', 'PlanMonthController@history');
Route::get('approvalsaleplan_close/{id}', 'PlanMonthController@approvalsaleplan_close');
Route::post('search_month_planMonth', 'PlanMonthController@search_month_planMonth');
Route::get('approve_monthly_plan/{id}', 'PlanMonthController@approve');
Route::get('dailyWork', 'SaleMan\DailyWorkController@index');
Route::get('saleplan_view_comment/{id}', 'PlanMonthController@saleplan_view_comment');
Route::get('customernew_view_comment/{id}', 'PlanMonthController@customernew_view_comment');
Route::get('/palncalendar', function () { return view('saleplan.salePalnCalendar'); });

// Assignments
Route::get('assignment', 'SaleMan\AssignmentController@index');
// Route::get('assignment_result_get/{id}', 'SaleMan\AssignmentController@assignment_result_get'); //-- ย้ายไป utility
// Route::post('assignment_Result', 'SaleMan\AssignmentController@saleplan_result'); //-- ย้ายไป utility
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
Route::post('/lead/search','Customer\CustomerController@customerLeadSearch');
Route::post('create_customer', 'Customer\CustomerController@store');
Route::get('edit_customerLead/{id}', 'Customer\CustomerController@edit');
Route::post('update_customerLead', 'Customer\CustomerController@update');
Route::post('delete_customer', 'Customer\CustomerController@destroy');


// Route::get('/lead','Customer\CustomerControllerCopy@customerLead');
// Route::post('/lead/search','Customer\CustomerControllerCopy@customerLeadSearch');


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


// Trip
Route::get('trip', 'UnionTripController@index');
Route::post('trip/search', 'UnionTripController@search');
Route::get('trip/detail/{id}', 'UnionTripController@trip_detail');
Route::get('trip/show_detail/{id}', 'UnionTripController@trip_detail');
Route::get('trip/approve_trip/detail/{id}', 'UnionTripApproveController@trip_showdetail');


// Request Approval
Route::get('approval', 'SaleMan\RequestApprovalController@index');
Route::post('create_approval', 'SaleMan\RequestApprovalController@store');
Route::get('edit_approval/{id}', 'SaleMan\RequestApprovalController@edit');
Route::post('update_approval', 'SaleMan\RequestApprovalController@update');
Route::post('delete_approval', 'SaleMan\RequestApprovalController@destroy');
Route::get('view_comment/{id}', 'SaleMan\RequestApprovalController@view_comment');
// Route::post('search_month_requestApprove', 'SaleMan\RequestApprovalController@search_month_requestApprove');
Route::get('search_month_requestApprove/{fromMonth}/{toMonth}', 'SaleMan\RequestApprovalController@search_month_requestApprove');

// TEST REQUEST
// Route::get('approval', 'SaleMan\RequestApprovalController@index');
Route::get('approval2', 'SaleMan\RequestApprovalController@index2');

// NOTE
Route::get('note', 'NoteController@note_sale');
Route::get('status_pin_update/{id}', 'NoteController@status_pin_update');
Route::post('create_note', 'NoteController@store');
Route::get('edit_note/{id}', 'NoteController@edit');
Route::post('update_note', 'NoteController@update');
Route::post('delete_note', 'NoteController@destroy');
Route::post('search_month_note', 'NoteController@search_month_note');


// Delivery
Route::get('delivery_status', 'DeliveryController@index');
Route::post('search_delivery_status', 'DeliveryController@search_delivery_status');


Route::get('news', 'NewsController@frontend_news');
Route::post('search_news', 'NewsController@search_news');
Route::get('news_detail/{id}', 'NewsController@news_detail');

Route::get('promotions', 'PromotionController@frontend_promotion');
Route::get('promotion_detail/{id}', 'PromotionController@promotion_detail');
Route::post('search_promotion', 'PromotionController@search_promotion');

Route::get('product_new', 'ProductNewController@frontend_product_new');
Route::get('product_new_detail/{id}', 'ProductNewController@product_new_detail');
Route::post('search_product_new', 'ProductNewController@search_product_new');

Route::get('catalog', 'CatalogController@index');
Route::get('view_product_catalog_detail/{id}', 'CatalogController@catalog_detail');
Route::post('search-productCatalog', 'CatalogController@search');

// Product Age
Route::get('product_age', 'ProductAgeController@index');
Route::post('search-product_age', 'ProductAgeController@search');
Route::get('view_product_age_detail/{id}', 'ProductAgeController@view_detail');

// Product MTO
Route::get('product_mto', 'ProductMtoController@index');
Route::post('search-product_mto', 'ProductMtoController@search');
Route::get('view_product_mto_detail/{id}', 'ProductMtoController@view_detail');

// Product Cancel
Route::get('product_cancel', 'ProductCancelController@index');
Route::post('search-product_cancel', 'ProductCancelController@search');
Route::get('view_product_cancel_detail/{id}', 'ProductCancelController@view_detail');

// Product Price
Route::get('product_price', 'ProductPriceController@index');
Route::post('search-product_price', 'ProductPriceController@search');
Route::get('view_product_price_detail/{id}', 'ProductPriceController@view_detail');


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
Route::post('data_report_product-new/search', 'ShareData\ProductNewController@search');

// Route::get('data_report_full-year', 'ShareData\ReportFullYearController@index'); //-- OAT เปลี่ยนเป็นอันล่าง ใช้งานร่วมกัน
// Route::post('data_report_full-year/search', 'ShareData\ReportFullYearController@search'); //-- OAT เปลี่ยนเป็นอันล่าง ใช้งานร่วมกัน
Route::get('data_report_full-year', 'ShareData_Union\ReportFullYearController@index');
Route::post('data_report_full-year/search', 'ShareData_Union\ReportFullYearController@search');

Route::get('data_report_full-year/detail/{pdgroup}/{year}/{id}', 'ShareData_Union\ReportFullYearController@show');
Route::get('data_report_full-year_compare_group', 'ShareData_Union\ReportFullYearCompareGroupController@index');
Route::post('data_report_full-year_compare_group/search', 'ShareData_Union\ReportFullYearCompareGroupController@search');


// Route::get('data_report_historical-year', 'ShareData\ReportHistoricalYearController@index'); //-- OAT เปลี่ยนอันล่าง ไปใช้ Controller เดียวกัน
// Route::post('data_report_historical-year/search', 'ShareData\ReportHistoricalYearController@search'); //-- OAT เปลี่ยนอันล่าง ไปใช้ Controller เดียวกัน
Route::get('data_report_historical-year', 'ShareData_Union\ReportHistoricalYearController@index');
Route::post('data_report_historical-year/search', 'ShareData_Union\ReportHistoricalYearController@search');
Route::get('data_report_historical-quarter', 'ShareData\ReportHistoricalQuarterController@index');
Route::post('data_report_historical-quarter/search', 'ShareData\ReportHistoricalQuarterController@search');
Route::get('data_report_historical-month', 'ShareData\ReportHistoricalMonthController@index');
Route::post('data_report_historical-month/search', 'ShareData\ReportHistoricalMonthController@search');
Route::get('data_report_sale_compare-year','ShareData\ReportSaleCompareYearController@index');
Route::post('data_report_sale_compare-year/search','ShareData\ReportSaleCompareYearController@search');

Route::get('data_report_customer_compare-year','ShareData_Union\ReportCustomerCompareYearController@index');
Route::post('data_report_customer_compare-year/search','ShareData_Union\ReportCustomerCompareYearController@search');
Route::get('data_report_product_return','ShareData_Union\ReportProductReturnController@index');
Route::post('data_report_product_return/search','ShareData_Union\ReportProductReturnController@search');

});


// ------------------------------------------------------------------Manager-----------------------------------------------------------------------------//


Route::middleware(['auth', 'lead'])->group(function () {
// lead
// Route::get('leadManager', 'LeadManager\DashboardController@index');
Route::get('lead/dashboard', 'LeadManager\DashboardController@index');
Route::get('lead/important-day-detail',  'LeadManager\ImportantDayController@index');
Route::get('lead/planMonth', function () { return view('leadManager.planMonth'); });
Route::get('lead/dailyWork', function () { return view('leadManager.dailyWork'); });
Route::get('lead/palncalendar', function () { return view('leadManager.salePalnCalendar'); });
Route::get('lead/saleWork', function () { return view('leadManager.sale_work'); });
Route::get('lead/viewSaleDetail', function () { return view('leadManager.view_saleplan'); });
Route::get('lead/viewVisitDetail', function () { return view('leadManager.view_vist_customer'); });
Route::get('lead/viewAssignmentDetail', function () { return view('leadManager.view_assignment'); });


// Trip
Route::get('lead/trip', 'UnionTripController@index');
Route::post('lead/trip/search', 'UnionTripController@search');
Route::get('lead/trip/detail/{id}', 'UnionTripController@trip_detail');

Route::get('lead/approve_trip', 'UnionTripApproveController@index');
Route::post('lead/approve_trip/search', 'UnionTripApproveController@search');
Route::post('lead/approval_trip_confirm_all', 'UnionTripApproveController@approval_trip_confirm_all');
Route::post('lead/trip_retrospective', 'UnionTripApproveController@trip_retrospective');

Route::get('lead/approve_trip/history', 'UnionTripApproveController@trip_history');
Route::post('lead/approve_trip/history/search', 'UnionTripApproveController@trip_history_search');

Route::get('lead/approve_trip/detail/{id}', 'UnionTripApproveController@trip_showdetail');
Route::get('lead/approve_trip/edit/{id}', 'UnionTripApproveController@trip_editdetail');
Route::post('lead/approve_trip/update', 'UnionTripApproveController@trip_updatedetail');




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
Route::post('lead/approval-customer-except-history/search', 'LeadManager\ApprovalCustomerExceptController@search_history');
Route::get('lead/approval_customer_except_history_detail/{id}', 'LeadManager\ApprovalCustomerExceptController@approval_customer_except_history_detail');
Route::get('lead/show_comment_customer_except/{id}/{custsaleplanID}/{createID}', 'LeadManager\ApprovalCustomerExceptController@show_comment_customer_except');
Route::post('lead/approval-customer-except/search', 'LeadManager\ApprovalCustomerExceptController@search');


Route::get('comment_customer_new/{id}/{saleplanID}', 'LeadManager\ApprovalSalePlanController@comment_customer_new');
Route::post('lead/create_comment_customer_new', 'LeadManager\ApprovalSalePlanController@create_comment_customer_new');

Route::get('comment_customer_except/{id}/{saleplanID}', 'LeadManager\ApprovalSalePlanController@comment_customer_except');
Route::post('lead/create_comment_customer_except', 'LeadManager\ApprovalSalePlanController@create_comment_customer_except');

// Assignment
Route::get('add_assignment', 'AssignmentController@index');
Route::post('lead/create_assignment', 'AssignmentController@store');
Route::get('lead/edit_assignment/{id}', 'AssignmentController@edit');
Route::post('lead/update_assignment', 'AssignmentController@update');
Route::post('lead/delete_assignment', 'AssignmentController@destroy');
Route::get('lead/assignment_result_get/{id}', 'AssignmentController@assignment_result_get');
Route::post('lead/search_month_add-assignment', 'AssignmentController@lead_search_month_add_assignment');
Route::post('lead/update_assignment_status_result', 'AssignmentController@update_status_result');
Route::get('lead/get_assignment', 'AssignmentController@get_assign');
Route::post('lead/search_month_get-assignment', 'AssignmentController@lead_search_month_get_assignment');
Route::get('lead/assignment_file/{id}', 'AssignmentController@assign_file');
Route::post('lead/create_assignment_gallery', 'AssignmentController@file_store');
Route::get('lead/edit_assignment_file/{id}', 'AssignmentController@file_edit');
Route::post('lead/update_assignment_file', 'AssignmentController@file_update');
Route::post('lead/delete_assignment_file', 'AssignmentController@file_destroy');

// NOTE Lead Manage
Route::get('/leadManage/note', 'NoteController@note_lead');
Route::get('lead/status_pin_update/{id}', 'NoteController@status_pin_update');
Route::post('lead/create_note', 'NoteController@store');
Route::get('lead/edit_note/{id}', 'NoteController@edit');
Route::post('lead/update_note', 'NoteController@update');
Route::post('lead/delete_note', 'NoteController@destroy');
Route::post('lead/search_month_note', 'NoteController@lead_search_month_note');

// Delivery
Route::get('lead/delivery_status', 'DeliveryController@index');
Route::post('lead/search_delivery_status', 'DeliveryController@search_delivery_status');

Route::get('lead/news', 'NewsController@lead_frontend_news');
Route::post('lead/search_news', 'NewsController@search_news');
Route::get('lead/promotions', 'PromotionController@lead_frontend_promotion');
Route::post('lead/search_promotion', 'PromotionController@search_promotion');
Route::get('lead/product_new', 'ProductNewController@lead_frontend_product_new');
Route::get('lead/product_new_detail/{id}', 'ProductNewController@product_new_detail');
Route::post('lead/search_product_new', 'ProductNewController@search_product_new');
Route::get('lead/news_detail/{id}', 'NewsController@lead_news_detail');
Route::get('lead/promotion_detail/{id}', 'PromotionController@lead_promotion_detail');

Route::get('lead/catalog', 'CatalogController@index');
Route::get('lead/view_product_catalog_detail/{id}', 'CatalogController@catalog_detail');
Route::post('lead/search-productCatalog', 'CatalogController@search');

// Product Age
Route::get('lead/product_age', 'ProductAgeController@index');
Route::post('lead/search-product_age', 'ProductAgeController@search');
Route::get('lead/view_product_age_detail/{id}', 'ProductAgeController@view_detail');

// Product MTO
Route::get('lead/product_mto', 'ProductMtoController@index');
Route::post('lead/search-product_mto', 'ProductMtoController@search');
Route::get('lead/view_product_mto_detail/{id}', 'ProductMtoController@view_detail');

// Product Cancel
Route::get('lead/product_cancel', 'ProductCancelController@index');
Route::post('lead/search-product_cancel', 'ProductCancelController@search');
Route::get('lead/view_product_cancel_detail/{id}', 'ProductCancelController@view_detail');

// Product Price
Route::get('lead/product_price', 'ProductPriceController@index');
Route::post('lead/search-product_price', 'ProductPriceController@search');
Route::get('lead/view_product_price_detail/{id}', 'ProductPriceController@view_detail');

//report
Route::get('/leadManage/reportcustomer', function () { return view('reports.report_customer'); });
Route::get('/leadManage/reportStore','LeadManager\ApiCustomerController@index');
Route::get('/leadManage/reportStore/detail/{id}','LeadManager\ApiCustomerController@show');
// Route::get('/leadManage/reportTeam', 'LeadManager\ReportTeamController@index'); // -- ลูกค้าให้เปลี่ยนใช้ api อันล่าง
Route::get('/leadManage/reportTeam', 'LeadManager\ReportTeamController@reportTeamApi'); // เปลี่ยนมาอันนี้ <---|
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
// Route::get('leadManage/data_report_product-new', 'ShareData_LeadManager\ProductNewController@index'); //-- OAT เปลี่ยนไปใช้อันล่าง
Route::get('leadManage/data_report_product-new', 'ShareData_Union\ProductNewController@index');

// Route::get('leadManage/data_report_full-year', 'ShareData_LeadManager\ReportFullYearController@index'); //-- OAT เปลี่ยนมาใช้อันล่าง
// Route::post('leadManage/data_report_full-year/search', 'ShareData_LeadManager\ReportFullYearController@search');

Route::get('leadManage/data_report_full-year', 'ShareData_Union\ReportFullYearController@index');
Route::post('leadManage/data_report_full-year/search', 'ShareData_Union\ReportFullYearController@search');
Route::get('leadManage/data_report_full-year/detail/{pdgroup}/{year}/{id}', 'ShareData_Union\ReportFullYearController@show');
Route::get('leadManage/data_report_full-year_compare_group', 'ShareData_Union\ReportFullYearCompareGroupController@index');
Route::post('leadManage/data_report_full-year_compare_group/search', 'ShareData_Union\ReportFullYearCompareGroupController@search');

// Route::get('leadManage/data_report_historical-year', 'ShareData_LeadManager\ReportHistoricalYearController@index'); //-- OAT เปลี่ยนไปใช้อันล่าง ใช้ร่วมกัน
// Route::post('leadManage/data_report_historical-year/search', 'ShareData_LeadManager\ReportHistoricalYearController@search'); //-- OAT เปลี่ยนไปใช้อันล่าง ใช้ร่วมกัน
Route::get('leadManage/data_report_historical-year', 'ShareData_Union\ReportHistoricalYearController@index');
Route::post('leadManage/data_report_historical-year/search', 'ShareData_Union\ReportHistoricalYearController@search');
Route::get('leadManage/data_report_historical-quarter', 'ShareData_LeadManager\ReportHistoricalQuarterController@index');
Route::post('leadManage/data_report_historical-quarter/search', 'ShareData_LeadManager\ReportHistoricalQuarterController@search');
Route::get('leadManage/data_report_historical-month', 'ShareData_LeadManager\ReportHistoricalMonthController@index');
Route::post('leadManage/data_report_historical-month/search', 'ShareData_LeadManager\ReportHistoricalMonthController@search');
Route::get('leadManage/data_report_sale_compare-year','ShareData_LeadManager\ReportSaleCompareYearController@index');
Route::post('leadManage/data_report_sale_compare-year/search','ShareData_LeadManager\ReportSaleCompareYearController@search');

Route::get('leadManage/data_report_customer_compare-year','ShareData_Union\ReportCustomerCompareYearController@index');
Route::post('leadManage/data_report_customer_compare-year/search','ShareData_Union\ReportCustomerCompareYearController@search');
Route::get('leadManage/data_report_product_return','ShareData_Union\ReportProductReturnController@index');
Route::post('leadManage/data_report_product_return/search','ShareData_Union\ReportProductReturnController@search');

Route::get('lead/edit-profile', 'ProfileController@lead_index');
Route::post('lead/userProfileUpdate', 'ProfileController@update');


});


// ==================================================================== Head ====================================================================//

Route::middleware(['auth', 'head'])->group(function () {
// head
Route::get('headManage', 'HeadManager\DashboardController@index');
Route::get('head/important-day-detail',  'HeadManager\ImportantDayController@index');
Route::get('head/palncalendar', function () { return view('headManager.salePalnCalendar'); });
Route::get('head/saleWork', function () { return view('headManager.sale_work'); });
Route::get('head/viewSaleDetail', function () { return view('headManager.view_saleplan'); });
Route::get('head/viewVisitDetail', function () { return view('headManager.view_vist_customer'); });
Route::get('head/viewAssignmentDetail', function () { return view('headManager.view_assignment'); });

Route::get('head/approvalsaleplan', 'HeadManager\ApprovalSalePlanController@index');
Route::get('head/approvalsaleplan_detail/{id}', 'HeadManager\ApprovalSalePlanController@approvalsaleplan_detail');
Route::get('head/approvalsaleplan_detail_close/{id}', 'HeadManager\ApprovalSalePlanController@approvalsaleplan_detail_close');
Route::get('head/comment_saleplan/{id}/{createID}', 'HeadManager\ApprovalSalePlanController@comment_saleplan');
Route::post('head/create_comment_saleplan', 'HeadManager\ApprovalSalePlanController@create_comment_saleplan');
Route::get('head/comment_customer_new/{id}/{custsaleplanID}/{createID}', 'HeadManager\ApprovalSalePlanController@comment_customer_new');
Route::post('head/create_comment_customer_new', 'HeadManager\ApprovalSalePlanController@create_comment_customer_new');
Route::post('head/approvalsaleplan/search', 'HeadManager\ApprovalSalePlanController@search');


// Trip
Route::get('head/trip', 'UnionTripController@index');
Route::post('head/trip/search', 'UnionTripController@search');
Route::get('head/trip/detail/{id}', 'UnionTripController@trip_detail');

Route::get('head/approve_trip', 'UnionTripApproveController@index');
Route::post('head/approve_trip/search', 'UnionTripApproveController@search');
Route::get('head/approve_trip/history', 'UnionTripApproveController@trip_history');
Route::post('head/approve_trip/history/search', 'UnionTripApproveController@trip_history_search');
Route::get('head/approve_trip/detail/{id}', 'UnionTripApproveController@trip_showdetail');


Route::get('head/approvalgeneral', 'HeadManager\ApprovalController@index');
Route::get('head/approvalgeneral/history', 'HeadManager\ApprovalController@approval_history');
Route::post('head/approvalgeneral/history/search', 'HeadManager\ApprovalController@approval_history_search');
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
// Route::get('head/delete_assignment/{id}', 'AssignmentController@destroy');
Route::post('head/delete_assignment', 'AssignmentController@destroy');
Route::post('head/search_month_add-assignment', 'AssignmentController@head_search_month_add_assignment');
Route::post('head/update_assignment_status_result', 'AssignmentController@update_status_result');
Route::get('head/get_assignment', 'AssignmentController@get_assign');
Route::post('head/search_month_get-assignment', 'AssignmentController@head_search_month_get_assignment');
Route::get('head/assignment_file/{id}', 'AssignmentController@assign_file');
Route::post('head/create_assignment_gallery', 'AssignmentController@file_store');
Route::get('head/edit_assignment_file/{id}', 'AssignmentController@file_edit');
Route::post('head/update_assignment_file', 'AssignmentController@file_update');
Route::post('head/delete_assignment_file', 'AssignmentController@file_destroy');


// อนุมัติลูกค้าใหม่นอกแผน
Route::get('head/approval-customer-except', 'HeadManager\ApprovalCustomerExceptController@index');
Route::post('head/approval_customer_confirm_all', 'HeadManager\ApprovalCustomerExceptController@approval_customer_confirm_all');
Route::get('head/approval_customer_except_detail/{id}', 'HeadManager\ApprovalCustomerExceptController@approval_customer_except_detail');
Route::get('head/comment_customer_except/{id}/{custsaleplanID}/{createID}', 'HeadManager\ApprovalCustomerExceptController@comment_customer_except');
Route::post('head/create_comment_customer_except', 'HeadManager\ApprovalCustomerExceptController@create_comment_customer_except');
Route::post('head/approvalcustomer-except/search', 'HeadManager\ApprovalCustomerExceptController@search');
Route::get('head/comment_customer_new_except/{shop_id}/{shops_saleplan_id}/{monthly_plans_id}', 'HeadManager\ApprovalCustomerExceptController@comment_customer_new_except'); //-- OAT
Route::post('head/comment_customer_new_except_update', 'HeadManager\ApprovalCustomerExceptController@comment_customer_new_except_update'); //-- OAT

// Note Head Manage
Route::get('head/note', 'NoteController@note_head');
Route::post('head/create_note', 'NoteController@store');
Route::get('head/edit_note/{id}', 'NoteController@edit');
Route::post('head/update_note', 'NoteController@update');
// Route::get('head/delete_note/{id}', 'NoteController@destroy');
Route::post('head/delete_note', 'NoteController@destroy');
Route::post('head/search_month_note', 'NoteController@head_search_month_note');
Route::get('head/status_pin_update/{id}', 'NoteController@status_pin_update');

// Delivery
Route::get('head/delivery_status', 'DeliveryController@index');
Route::post('head/search_delivery_status', 'DeliveryController@search_delivery_status');

Route::get('head/news', 'NewsController@head_frontend_news');
Route::post('head/search_news', 'NewsController@search_news');
Route::get('head/promotions', 'PromotionController@head_frontend_promotion');
Route::post('head/search_promotion', 'PromotionController@search_promotion');
Route::get('head/product_new', 'ProductNewController@head_frontend_product_new');
Route::get('head/product_new_detail/{id}', 'ProductNewController@product_new_detail');
Route::post('head/search_product_new', 'ProductNewController@search_product_new');
Route::get('head/news_detail/{id}', 'NewsController@head_news_detail');
Route::get('head/promotion_detail/{id}', 'PromotionController@head_promotion_detail');

Route::get('head/catalog', 'CatalogController@index');
Route::get('head/view_product_catalog_detail/{id}', 'CatalogController@catalog_detail');
Route::post('head/search-productCatalog', 'CatalogController@search');

// Product Age
Route::get('head/product_age', 'ProductAgeController@index');
Route::post('head/search-product_age', 'ProductAgeController@search');
Route::get('head/view_product_age_detail/{id}', 'ProductAgeController@view_detail');

// Product MTO
Route::get('head/product_mto', 'ProductMtoController@index');
Route::post('head/search-product_mto', 'ProductMtoController@search');
Route::get('head/view_product_mto_detail/{id}', 'ProductMtoController@view_detail');

// Product Cancel
Route::get('head/product_cancel', 'ProductCancelController@index');
Route::post('head/search-product_cancel', 'ProductCancelController@search');
Route::get('head/view_product_cancel_detail/{id}', 'ProductCancelController@view_detail');

// Product Price
Route::get('head/product_price', 'ProductPriceController@index');
Route::post('head/search-product_price', 'ProductPriceController@search');
Route::get('head/view_product_price_detail/{id}', 'ProductPriceController@view_detail');

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
// Route::get('headManage/data_report_product-new', 'ShareData_HeadManager\ProductNewController@index'); //-- OAT เปลี่ยนเป็นด้านล่าง
Route::get('headManage/data_report_product-new', 'ShareData_Union\ProductNewController@index');

// Route::get('headManage/data_report_full-year', 'ShareData_HeadManager\ReportFullYearController@index');
// Route::post('headManage/data_report_full-year/search', 'ShareData_HeadManager\ReportFullYearController@search');

Route::get('headManage/data_report_full-year', 'ShareData_Union\ReportFullYearController@index');
Route::post('headManage/data_report_full-year/search', 'ShareData_Union\ReportFullYearController@search');
Route::get('headManage/data_report_full-year/detail/{pdgroup}/{year}/{id}', 'ShareData_Union\ReportFullYearController@show');

Route::get('headManage/data_report_full-year_compare_group', 'ShareData_Union\ReportFullYearCompareGroupController@index');
Route::post('headManage/data_report_full-year_compare_group/search', 'ShareData_Union\ReportFullYearCompareGroupController@search');

// Route::get('headManage/data_report_historical-year', 'ShareData_HeadManager\ReportHistoricalYearController@index'); //-- OAT เปลี่ยนมาใช้อันล่าง ใช้ร่วมกัน
// Route::post('headManage/data_report_historical-year/search', 'ShareData_HeadManager\ReportHistoricalYearController@search'); //-- OAT เปลี่ยนมาใช้อันล่าง ใช้ร่วมกัน
Route::get('headManage/data_report_historical-year', 'ShareData_Union\ReportHistoricalYearController@index');
Route::post('headManage/data_report_historical-year/search', 'ShareData_Union\ReportHistoricalYearController@search');
Route::get('headManage/data_report_historical-quarter', 'ShareData_HeadManager\ReportHistoricalQuarterController@index');
Route::post('headManage/data_report_historical-quarter/search', 'ShareData_HeadManager\ReportHistoricalQuarterController@search');
Route::get('headManage/data_report_historical-month', 'ShareData_HeadManager\ReportHistoricalMonthController@index');
Route::post('headManage/data_report_historical-month/search', 'ShareData_HeadManager\ReportHistoricalMonthController@search');
Route::get('headManage/data_report_sale_compare-year','ShareData_HeadManager\ReportSaleCompareYearController@index');
Route::post('headManage/data_report_sale_compare-year/search','ShareData_HeadManager\ReportSaleCompareYearController@search');
Route::get('headManage/data_report_customer_compare-year','ShareData_Union\ReportCustomerCompareYearController@index');
Route::post('headManage/data_report_customer_compare-year/search','ShareData_Union\ReportCustomerCompareYearController@search');
Route::get('headManage/data_report_product_return','ShareData_Union\ReportProductReturnController@index');
Route::post('headManage/data_report_product_return/search','ShareData_Union\ReportProductReturnController@search');
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
Route::get('admin/approvalsaleplan_close/{id}', 'Admin\ApprovalSalePlanController@approvalsaleplan_close');
Route::post('admin/approvalsaleplan_close', 'Admin\ApprovalSalePlanController@approvalsaleplan_close_update');
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

// Route::get('admin/approvalgeneral/history', function () { return view('admin.approval_general_history'); });
Route::get('admin/approvalgeneral/history', 'Admin\ApprovalController@approval_history');
Route::post('admin/approvalgeneral/history/search', 'Admin\ApprovalController@approval_history_search');

Route::post('admin/approvalgeneral/search', 'Admin\ApprovalController@search');
Route::get('admin/view_approval/{id}', 'Admin\ApprovalController@view_approval');

Route::get('admin/assignment-add', 'Admin\AssignmentController@index');
// Route::get('admin/fetch_user/{id}', 'Admin\AssignmentController@fetch_user');
Route::get('admin/fetch_user', 'Admin\AssignmentController@fetch_user');
Route::post('admin/create_assignment', 'Admin\AssignmentController@store');
Route::get('admin/edit_assignment/{id}', 'Admin\AssignmentController@edit');
Route::post('admin/update_assignment', 'Admin\AssignmentController@update');
Route::post('admin/update_assignment_status_result', 'Admin\AssignmentController@update_status_result');
// Route::get('admin/delete_assignment/{id}', 'Admin\AssignmentController@destroy');
Route::post('admin/delete_assignment', 'Admin\AssignmentController@destroy');
Route::post('admin/search_month_add-assignment', 'Admin\AssignmentController@search');
Route::get('admin/assignment_file/{id}', 'AssignmentController@assign_file');
Route::post('admin/create_assignment_gallery', 'Admin\AssignmentController@file_store');
Route::get('admin/edit_assignment_file/{id}', 'Admin\AssignmentController@file_edit');
Route::post('admin/update_assignment_file', 'Admin\AssignmentController@file_update');
Route::post('admin/delete_assignment_file', 'Admin\AssignmentController@file_destroy');

// Customer Change Status
Route::get('admin/change_customer_status', 'Admin\ChangeCustomerController@index');
Route::get('admin/change_customer_status_edit/{id}', 'Admin\ChangeCustomerController@show');
Route::post('admin/change_customer_status_update', 'Admin\ChangeCustomerController@update_status');
Route::post('admin/change_customer_status/destroy','Admin\ChangeCustomerController@destroy');

Route::post('admin/change_customer_status/search','Admin\ChangeCustomerController@customerLeadSearch');
Route::get('admin/approval_customer_except_detail/{id}', 'Admin\ChangeCustomerController@approval_customer_except_detail');
// Route::post('create_customer', 'Customer\CustomerController@store');
Route::get('admin/edit_customerLead/{id}', 'Admin\ChangeCustomerController@edit');
Route::post('admin/update_customerLead', 'Admin\ChangeCustomerController@update');
// Route::post('delete_customer', 'Customer\CustomerController@destroy');


// Trip
Route::get('admin/approve_trip', 'Admin\UnionTripAdminController@index');
Route::post('admin/approve_trip/search', 'Admin\UnionTripAdminController@search');
Route::post('admin/approval_trip_confirm_all', 'Admin\UnionTripAdminController@approval_trip_confirm_all');
Route::get('admin/approve_trip/detail/{id}', 'UnionTripApproveController@trip_showdetail');


// Note
Route::get('admin/note', 'NoteController@note_admin');
Route::post('admin/create_note', 'NoteController@store');
Route::get('admin/edit_note/{id}', 'NoteController@edit');
Route::post('admin/update_note', 'NoteController@update');
// Route::get('admin/delete_note/{id}', 'NoteController@destroy');
Route::post('admin/delete_note', 'NoteController@destroy');
Route::post('admin/search_month_note', 'NoteController@admin_search_month_note');
Route::get('admin/status_pin_update/{id}', 'NoteController@status_pin_update');

// Delivery
Route::get('admin/delivery_status', 'DeliveryController@index');
Route::post('admin/search_delivery_status', 'DeliveryController@search_delivery_status');

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
// News Gallery
Route::get('admin/news-gallery/{id}', 'NewsController@gallery');
Route::get('admin/news-view-detail/{id}', 'NewsController@view_detail');
Route::post('admin/create_news_gallery', 'NewsController@gallery_store');
Route::get('admin/edit_news_gallery/{id}', 'NewsController@gallery_edit');
Route::post('admin/update_news_gallery', 'NewsController@gallery_update');
Route::post('admin/delete_news_gallery', 'NewsController@gallery_destroy');


Route::get('admin/fontendPromotions', 'PromotionController@admin_frontend_promotion');
Route::get('admin/pomotion', 'PromotionController@index');
Route::post('admin/create_promotion', 'PromotionController@store');
Route::get('admin/edit_promotion/{id}', 'PromotionController@edit');
Route::post('admin/update_promotion', 'PromotionController@update');
Route::get('admin/delete_promotion/{id}', 'PromotionController@destroy');
Route::get('admin/promotion_detail/{id}', 'PromotionController@admin_promotion_detail');
Route::post('admin/search-promotion-status-usage', 'PromotionController@search_promotion_status_promotion');
Route::get('admin/update-promotion-status-use/{id}', 'PromotionController@update_status_use');

Route::get('admin/promotion-gallery/{id}', 'PromotionController@gallery');
Route::get('admin/promotion-view-detail/{id}', 'PromotionController@view_detail');
Route::post('admin/create_promotion_gallery', 'PromotionController@gallery_store');
Route::get('admin/edit_promotion_gallery/{id}', 'PromotionController@gallery_edit');
Route::post('admin/update_promotion_gallery', 'PromotionController@gallery_update');
Route::post('admin/delete_promotion_gallery', 'PromotionController@gallery_destroy');

// News Banner
Route::get('admin/promotionBanner', 'PromotionController@index_banner');
Route::post('admin/create_promotionBanner', 'PromotionController@banner_store');
Route::get('admin/edit_promotionBanner/{id}', 'PromotionController@banner_edit');
Route::post('admin/update_promotionBanner', 'PromotionController@banner_update');
Route::post('admin/delete_promotionBanner', 'PromotionController@banner_destroy');


// Product New
Route::get('admin/fontendProductNew', 'ProductNewController@admin_frontend_product_new');
Route::get('admin/product_new', 'ProductNewController@index');
Route::post('admin/create_product_new', 'ProductNewController@store');
Route::get('admin/edit_product_new/{id}', 'ProductNewController@edit');
Route::post('admin/update_product_new', 'ProductNewController@update');
Route::get('admin/delete_product_new/{id}', 'ProductNewController@destroy');
Route::post('admin/search-productNew-status-usage', 'ProductNewController@search_news_status_usage');
Route::get('admin/update-productNew-status-use/{id}', 'ProductNewController@update_status_use');
Route::get('admin/product-new-gallery/{id}', 'ProductNewController@gallery');
Route::post('admin/create_product_new_gallery', 'ProductNewController@gallery_store');
Route::get('admin/edit_product_new_gallery/{id}', 'ProductNewController@gallery_edit');
Route::post('admin/update_product_new_gallery', 'ProductNewController@gallery_update');
Route::post('admin/delete_product_new_gallery', 'ProductNewController@gallery_destroy');
Route::get('admin/view_product_new_detail/{id}', 'ProductNewController@view_detail');



// Catalog
Route::get('admin/catalog', 'Admin\CatalogController@index');
Route::post('admin/create_product_catalog', 'Admin\CatalogController@store');
Route::get('admin/update-productCatalog-status-use/{id}', 'Admin\CatalogController@update_status_use');
Route::get('admin/edit_product_catalog/{id}', 'Admin\CatalogController@edit');
Route::post('admin/update_product_catalog', 'Admin\CatalogController@update');
Route::post('admin/search-productCatalog', 'Admin\CatalogController@search');
Route::get('admin/view_product_catalog_detail/{id}', 'Admin\CatalogController@view_detail');
Route::post('admin/delete_catalog', 'Admin\CatalogController@destroy');


// Product Age
Route::get('admin/product_age', 'Admin\ProductAgeController@index');
Route::post('admin/create_product_age', 'Admin\ProductAgeController@store');
Route::get('admin/update-productAge-status-use/{id}', 'Admin\ProductAgeController@update_status_use');
Route::get('admin/edit_product_age/{id}', 'Admin\ProductAgeController@edit');
Route::post('admin/update_product_age', 'Admin\ProductAgeController@update');
Route::post('admin/delete_age', 'Admin\ProductAgeController@destroy');
Route::post('admin/search-product_age', 'Admin\ProductAgeController@search');
Route::get('admin/view_product_age_detail/{id}', 'Admin\ProductAgeController@view_detail');


// Product MTO
Route::get('admin/product_mto', 'Admin\ProductMtoController@index');
Route::post('admin/create_product_mto', 'Admin\ProductMtoController@store');
Route::get('admin/update-productMto-status-use/{id}', 'Admin\ProductMtoController@update_status_use');
Route::get('admin/edit_product_mto/{id}', 'Admin\ProductMtoController@edit');
Route::post('admin/update_product_mto', 'Admin\ProductMtoController@update');
Route::post('admin/delete_mto', 'Admin\ProductMtoController@destroy');
Route::post('admin/search-product_mto', 'Admin\ProductMtoController@search');
Route::get('admin/view_product_mto_detail/{id}', 'Admin\ProductMtoController@view_detail');


// Product Cancel
Route::get('admin/product_cancel', 'Admin\ProductCancelController@index');
Route::post('admin/create_product_cancel', 'Admin\ProductCancelController@store');
Route::get('admin/update-productCancel-status-use/{id}', 'Admin\ProductCancelController@update_status_use');
Route::get('admin/edit_product_cancel/{id}', 'Admin\ProductCancelController@edit');
Route::post('admin/update_product_cancel', 'Admin\ProductCancelController@update');
Route::post('admin/delete_cancel', 'Admin\ProductCancelController@destroy');
Route::post('admin/search-product_cancel', 'Admin\ProductCancelController@search');
Route::get('admin/view_product_cancel_detail/{id}', 'Admin\ProductCancelController@view_detail');


// Product Price
Route::get('admin/product_price', 'Admin\ProductPriceController@index');
Route::post('admin/create_product_price', 'Admin\ProductPriceController@store');
Route::get('admin/update-productPrice-status-use/{id}', 'Admin\ProductPriceController@update_status_use');
Route::get('admin/edit_product_price/{id}', 'Admin\ProductPriceController@edit');
Route::post('admin/update_product_price', 'Admin\ProductPriceController@update');
Route::post('admin/delete_price', 'Admin\ProductPriceController@destroy');
Route::post('admin/search-product_price', 'Admin\ProductPriceController@search');
Route::get('admin/view_product_price_detail/{id}', 'Admin\ProductPriceController@view_detail');

Route::get('admin/productPrice-gallery/{id}', 'Admin\ProductPriceController@gallery');
Route::post('admin/create_product_price_gallery', 'Admin\ProductPriceController@gallery_store');
Route::get('admin/edit_product_price_gallery/{id}', 'Admin\ProductPriceController@gallery_edit');
Route::post('admin/update_product_price_gallery', 'Admin\ProductPriceController@gallery_update');
Route::post('admin/delete_product_price_gallery', 'Admin\ProductPriceController@gallery_destroy');


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
Route::post('admin/delete_user_permission', 'Admin\UserPermissionController@delete');


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

Route::get('admin/master_news_tag', 'Admin\MasterNewsTagController@index');
Route::post('admin/create_master_news_tag', 'Admin\MasterNewsTagController@store');
Route::get('/admin/edit_master_news_tag/{id}', 'Admin\MasterNewsTagController@edit');
Route::post('/admin/update_master_news_tag', 'Admin\MasterNewsTagController@update');
Route::get('admin/delete_master_news_tag/{id}', 'Admin\MasterNewsTagController@destroy');

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
// Route::get('admin/data_report_product-new', 'ShareData_Admin\ProductNewController@index'); //-- OAT เปลี่ยนมาใช้อันล่าง
Route::get('admin/data_report_product-new', 'ShareData_Union\ProductNewController@index');
Route::post('admin/data_report_product-new/search', 'ShareData_Admin\ProductNewController@search');
Route::get('admin/data_report_product-new/show/{id}', 'ShareData_Admin\ProductNewController@show');

// Route::get('admin/data_report_full-year', 'ShareData_Admin\ReportFullYearController@index');  //-- OAT เปลี่ยนมาใช้อันล่าง
// Route::post('admin/data_report_full-year/search', 'ShareData_Admin\ReportFullYearController@search');  //-- OAT เปลี่ยนมาใช้อันล่าง

Route::get('admin/data_report_full-year', 'ShareData_Union\ReportFullYearController@index');
Route::post('admin/data_report_full-year/search', 'ShareData_Union\ReportFullYearController@search');
Route::get('admin/data_report_full-year/detail/{pdgroup}/{year}/{id}', 'ShareData_Union\ReportFullYearController@show');

Route::get('admin/data_report_full-year_compare_group', 'ShareData_Union\ReportFullYearCompareGroupController@index');
Route::post('admin/data_report_full-year_compare_group/search', 'ShareData_Union\ReportFullYearCompareGroupController@search');

// Route::get('admin/data_report_historical-year', 'ShareData_Admin\ReportHistoricalYearController@index'); //-- OAT เปลี่ยนมาใช้อันล่าง ใช้งานร่วมกัน
// Route::post('admin/data_report_historical-year/search', 'ShareData_Admin\ReportHistoricalYearController@search'); //-- OAT เปลี่ยนมาใช้อันล่าง ใช้งานร่วมกัน
Route::get('admin/data_report_historical-year', 'ShareData_Union\ReportHistoricalYearController@index');
Route::post('admin/data_report_historical-year/search', 'ShareData_Union\ReportHistoricalYearController@search');
Route::get('admin/data_report_historical-quarter', 'ShareData_Admin\ReportHistoricalQuarterController@index');
Route::post('admin/data_report_historical-quarter/search', 'ShareData_Admin\ReportHistoricalQuarterController@search');
Route::get('admin/data_report_historical-month', 'ShareData_Admin\ReportHistoricalMonthController@index');
Route::post('admin/data_report_historical-month/search', 'ShareData_Admin\ReportHistoricalMonthController@search');
Route::get('admin/data_report_sale_compare-year','ShareData_Admin\ReportSaleCompareYearController@index');
Route::post('admin/data_report_sale_compare-year/search','ShareData_Admin\ReportSaleCompareYearController@search');

Route::get('admin/data_report_customer_compare-year','ShareData_Union\ReportCustomerCompareYearController@index');
Route::post('admin/data_report_customer_compare-year/search','ShareData_Union\ReportCustomerCompareYearController@search');
Route::get('admin/data_report_product_return','ShareData_Union\ReportProductReturnController@index');
Route::post('admin/data_report_product_return/search','ShareData_Union\ReportProductReturnController@search');

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


// utility ---ใช้งานร่วมกัน

Route::get('/fetch_amphur/{id}',[ProvinceController::class, 'amphur']);
Route::get('/fetch_district/{id}',[ProvinceController::class, 'district']);
Route::get('/fetch_postcode/{id}',[ProvinceController::class, 'postcode']);
Route::get('/customer/autocomplete',[CustomerController::class, 'fetch_autocomplete']);
Route::get('/fetch_customer_shops_byid/{id}','Customer\CustomerController@fetch_customer_shops_byid');
Route::get('checkstore_campaigns/{seller}/detail/{id}','CheckStoreCampaignsController@show');
Route::get('sellerdetail/{position}/{seller_level}/{id}', 'SellerDetailController@show');

Route::get('fetch_subgroups/{id}', 'Api\ApiController@fetch_subgroups');
Route::get('fetch_pdglists/{id}', 'Api\ApiController@fetch_pdglists');
Route::get('fetch_products/{id}', 'Api\ApiController@fetch_products');
Route::get('fetch_amphur_api/{position}/{id}', 'Api\ApiController@fetch_amphur_api');
Route::get('fetch_campaignpromotes/{year}', 'Api\ApiController@fetch_campaignpromotes');
Route::get('fetch_customer_province_api/{pid}', 'Api\ApiController@fetch_customer_province_api');

Route::get('assignments_commentshow/{id}', 'UnionAssignmentController@commentshow');
Route::get('assignment_result_get/{id}', 'UnionAssignmentController@assignment_result_get');
Route::post('assignment_Result', 'UnionAssignmentController@saleplan_result');

Route::post('manager/data_report_product-new/search', 'ShareData_Union\ProductNewController@search');



// trip ---ใช้งานร่วมกัน
Route::get('trip/create', 'UnionTripController@create');
Route::post('trip/insert', 'UnionTripController@store');
Route::get('trip/edit/{id}', 'UnionTripController@edit');
Route::post('trip/update', 'UnionTripController@update');
Route::post('trip/delete', 'UnionTripController@destroy');
Route::get('trip/request/{id}', 'UnionTripController@request_approve');
Route::get('manager/trip/request/{id}', 'UnionTripController@manager_request_approve');

Route::post('trip/detail/insert', 'UnionTripController@trip_detail_store');
Route::get('trip/detail/edit/{id}', 'UnionTripController@trip_detail_edit');
Route::post('trip/detail/update', 'UnionTripController@trip_detail_update');
Route::post('trip/detail/delete', 'UnionTripController@trip_detail_destroy');


Route::post('manager/trip/comment/create', 'UnionTripApproveController@trip_comment');

// จบ trip ---ใช้งานร่วมกัน



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


// Report PDF & Excel
// Route::post('trip_pdf', 'UnionTripReportPDFController@pdf');
Route::get('trip_user_pdf/{id}', 'UnionTripReportPDFController@userpdf');


Route::post('trip_excel', 'UnionTripReportExportContoller@excel');
Route::get('trip_user_excel/{id}', 'UnionTripReportExportContoller@userexcel');

Route::post('trip_mail', 'UnionTripReportPDFController@sandmail');
Route::post('trip_report', 'UnionTripReportPDFController@trip_report_month');

Auth::routes();
// Route::get('/', function () { return view('saleman.dashboard'); });

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index')->name('home');


// Route::get('/clear-cache', function() {
    Route::get('/clc', function() {
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        return "Cache is cleared";
    });


// Route ดึงข้อมูล APi ลงฐานข้อมูล
Route::get('/api_fetch_provinces', 'Api\ApiController@api_fetch_provinces');
Route::get('/api_fetch_amphures', 'Api\ApiController@api_fetch_amphures');
Route::get('/api_fetch_customers', 'Api\ApiController@api_fetch_customers');
Route::get('/api_fetch_pdglists', 'Api\ApiController@api_fetch_pdglists');
Route::get('/api_customer_to_pdglist', 'Api\ApiController@api_customer_to_pdglist');
