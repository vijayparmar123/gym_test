<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'HomeController@index');
//Route::get('/editAudit/{id}', 'HomeController@editAudit');
//Route::patch('/editAudit/updateAudit/{id}', 'HomeController@updateAudit');

Route::auth();

//Manage Profile content
Route::get('/profile/{id}','HomeController@edit');
Route::patch('/profile/update/{id}','HomeController@update');
Route::get('/setting/{id}','HomeController@setting');
Route::get('/langagesetting','HomeController@language');
Route::post('/Savelanguage','HomeController@savelanguage');
Route::patch('/setting/updateSetting/{id}','HomeController@updateSetting');

//Manage User Content

Route::get('/newuser', 'usercontroller@index');
Route::get('/user_registration', 'usercontroller@user');
Route::post('/add_user', 'usercontroller@store');
Route::get('/newuser/edit/{id}','usercontroller@edit');
Route::patch('/newuser/edit/update/{id}','usercontroller@update');
Route::get('/updatestatus/{id}', 'usercontroller@updatestatus');


//location content
 
Route::get('/location', 'locationcontroller@index');
Route::post('/add_location','locationcontroller@store');
Route::get('/location/destroy/{id}','locationcontroller@destroy');
Route::get('/location/edit/{id}','locationcontroller@edit');
Route::patch('/location/edit/update/{id}','locationcontroller@update');

//Manage Category content

Route::get('/category', 'categorycontroller@index');
Route::post('/add_category','categorycontroller@store');
Route::get('/category/destroy/{id}','categorycontroller@destroy');
Route::get('/category/edit/{id}','categorycontroller@edit');
Route::patch('/category/edit/update/{id}','categorycontroller@update');


//Manage Template content

Route::get('/template', 'templatecontroller@index');
Route::get('/client_company', 'templatecontroller@client_company');
Route::post('/add_template','templatecontroller@store');
Route::post('/add_client_company','templatecontroller@storeClient');
Route::get('/template/destroy/{id}','templatecontroller@destroy');
Route::get('/client_company/destroyClient/{id}','templatecontroller@destroyClient');
Route::get('/template/edit/{id}','templatecontroller@edit');
Route::get('/client_company/editClient/{id}','templatecontroller@editClient');
Route::patch('/template/edit/update/{id}','templatecontroller@update');
Route::patch('/client_company/editClient/updateClient/{id}','templatecontroller@updateClient');


//Manage Audit Content

Route::get('/ManageAudit', 'managae_auditcontroller@viewAudit');
Route::get('/updatearchive/{id}', 'managae_auditcontroller@updatearchive');
Route::get('/ManageAudit/edit/{id}', 'managae_auditcontroller@edit');
Route::patch('/ManageAudit/edit/update/{id}', 'managae_auditcontroller@update');
Route::get('/ManageAudit/updateandcontinue/{id}', 'managae_auditcontroller@update_continue');
Route::patch('/ManageAudit/updateandcontinue/update/{id}', 'managae_auditcontroller@update_continue_save');
Route::get('/ManageAudit/viewAuditPdf/{id}', 'managae_auditcontroller@viewAuditPdf');
Route::get('/ManageAudit/viewAuditData/{id}', 'managae_auditcontroller@viewAuditData');
Route::get('/storeaudi', 'managae_auditcontroller@update_audit_continue');
Route::post('/storeData', 'managae_auditcontroller@storeData');
//Route::get('/getauditdatas', 'managae_auditcontroller@getauditdatas');
//Route::get('/ManageAudit/view/{id}/pdfview','managae_auditcontroller@pdfview');


//Manage Archive

Route::get('/Archive', 'archivecontroller@index');
Route::get('/Archive/destroy/{id}', 'archivecontroller@destroy');

//Manage Questionnaire content

Route::get('/ManageQuestionnaire', 'manage_questionnairecontroller@index');
Route::post('/add_questionnaire', 'manage_questionnairecontroller@store');
Route::get('/ManageQuestionnaire/delete/{id}','manage_questionnairecontroller@destroy');
Route::get('/ManageQuestionnaire/sectionview/{id}','manage_questionnairecontroller@show');
Route::get('/ManageQuestionnaire/sectionview/{sectionid}/{id}','manage_questionnairecontroller@show_tbl_question');
Route::get('/ManageQuestionnaire/sectionview/{sectionid}/{id}/edit/{question_id}','manage_questionnairecontroller@edit_question');
Route::patch('/ManageQuestionnaire/sectionview/{mainid}/{sectionid}/edit/update/{question_id}','manage_questionnairecontroller@update_question');
Route::get('/ManageQuestionnaire/sectionview/{mainid}/{sectionid}/delete/{question_id}','manage_questionnairecontroller@delete_question');
Route::get('/ManageQuestionnaire/sectionview/delete/{mainid}/{sectionid}','manage_questionnairecontroller@delete_sections');
Route::post('/store_question','manage_questionnairecontroller@store_qustion');
Route::post('/store_section','manage_questionnairecontroller@store_section');
Route::get('/store_category','manage_questionnairecontroller@store_category');


//CreateAudit Questionnaire content

Route::get('/CreateAudit', 'auditcontroller@index');
Route::post('/Questions', 'auditcontroller@store');
Route::get('/getrecord', 'auditcontroller@getrecord');
Route::get('/storeanswer', 'auditcontroller@storeanswer');
Route::post('/storeanswers', 'auditcontroller@storeanswers');
Route::get('/storeimage', 'auditcontroller@storeimage');
Route::get('/storeproblem', 'auditcontroller@storeproblem');
Route::post('/add_questions/{id}', 'auditcontroller@storeQuestion');
Route::get('/getauditdata', 'auditcontroller@getauditdata');

//Manage Access Rights content

Route::get('/AccessRights', 'access_rightscontroller@index');
Route::get('/storeaccess', 'access_rightscontroller@store');


// reports
Route::get('/Report', 'Reportcontroller@index');
Route::post('/recordsave', 'Reportcontroller@record');
// Data Backup
Route::get('/DataBackup', 'Databackupcontroller@index');
Route::post('/add_backup','Databackupcontroller@backup_tables');


//Manage Pricin Plan Content
Route::get('/PricingPlan', 'PricingPlancontroller@index');
Route::post('/freePlan', 'PricingPlancontroller@store');
