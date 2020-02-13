<?php

Route::get('/', function () {
    return redirect(route('adminroute'));
});

Route::group(['middleware' => 'admin'], function () {
				// @StatesController routes@ Added from component controller
				Route::get('states/add', 'StatesController@initContentCreate')->name('states.add');
				Route::post('states/add', 'StatesController@initProcessCreate');
				Route::get('states/edit/{id}', 'StatesController@initContentCreate')->name('states.edit');
				Route::post('states/edit/{id}', 'StatesController@initProcessCreate');
				Route::get('states', 'StatesController@initListing')->name('states.list');
				Route::get('states/delete/{id}', 'StatesController@initProcessDelete')->name('states.delete');

				Route::get('customer/add', 'CustomerController@initContentCreate')->name('customer.add');
				Route::post('customer/add', 'CustomerController@initProcessCreate');
				Route::get('customer/edit/{id}', 'CustomerController@initContentCreate')->name('customer.edit');
				Route::post('customer/edit/{id}', 'CustomerController@initProcessCreate');
				Route::get('customer', 'CustomerController@initListing')->name('customer.list');
				Route::get('customer/delete/{id}', 'CustomerController@initProcessDelete')->name('customer.delete');

    Route::get('privacy/policy/add', 'PrivacyPolicyController@initContentCreate')->name('privacy_policy.add');
    Route::post('privacy/policy/add', 'PrivacyPolicyController@initProcessCreate');
    Route::get('privacy/policy/edit/{id}', 'PrivacyPolicyController@initContentCreate')->name('privacy_policy.edit');
    Route::post('privacy/policy/edit/{id}', 'PrivacyPolicyController@initProcessCreate');
    Route::get('privacy/policy', 'PrivacyPolicyController@initListing')->name('privacy_policy.list');
    Route::get('privacy/policy/delete/{id}', 'PrivacyPolicyController@initProcessDelete')->name('privacy_policy.delete');

    Route::get('test/add', 'TestController@initContentCreate')->name('test.add');
    Route::post('test/add', 'TestController@initProcessCreate');
    Route::get('test/edit/{id}', 'TestController@initContentCreate')->name('test.edit');
    Route::post('test/edit/{id}', 'TestController@initProcessCreate');
    Route::get('test', 'TestController@initListing')->name('test.list');
    Route::get('test/delete/{id}', 'TestController@initProcessDelete')->name('test.delete');

    
    Route::get('dashboard', 'DashboardController@initContent')->name('admin.dashboard');
    Route::get('logout', 'EmployeeController@initProcessLogout')->name('employee.logout');


    Route::any('media/get/list', 'MediaController@initListingPartial');
    // @MediaController routes@ Added from component controller
    Route::post('media/add/embeded', 'MediaController@initProcessEmbed')->name('media.add.embeded');
    Route::get('media/add', 'MediaController@initContentCreate')->name('media.add');
    Route::post('media/add', 'MediaController@initProcessCreate');
    Route::get('media/edit/{id}', 'MediaController@initContentCreate')->name('media.edit');
    Route::post('media/edit/{id}', 'MediaController@initProcessCreate');
    Route::get('media', 'MediaController@initListing')->name('media.list');
    Route::get('media/delete/{id}', 'MediaController@initProcessDelete')->name('media.delete');

    Route::get('media/add', 'MediaController@initContentCreate')->name('media.add');
    Route::post('media/add', 'MediaController@initProcessCreate');
    Route::post('media/upload', 'MediaController@initProcessUpload')->name('media.upload');
    Route::get('media/edit/{id}', 'MediaController@initContentCreate')->name('media.edit');
    Route::post('media/edit/{id}', 'MediaController@initProcessCreate');
    Route::get('media', 'MediaController@initListing')->name('media.list');
    Route::get('media/delete/{id}', 'MediaController@initProcessDelete')->name('media.delete');

    // @PageController routes@ Added from component controller
    Route::get('page/add', 'PageController@initContentCreate')->name('page.add');
    Route::post('page/add', 'PageController@initProcessCreate');
    Route::get('page/edit/{id}', 'PageController@initContentCreate');
    Route::post('page/edit/{id}', 'PageController@initProcessCreate');
    Route::get('page', 'PageController@initListing')->name('page.list');
    Route::get('page/delete/{id}', 'PageController@initProcessDelete')->name('page.delete');

    Route::get('block/add', 'BlockController@initContentCreate')->name('block.add');
    Route::post('block/add', 'BlockController@initProcessCreate');
    Route::get('block/edit/{id}', 'BlockController@initContentCreate');
    Route::post('block/edit/{id}', 'BlockController@initProcessCreate');
    Route::get('block', 'BlockController@initListing')->name('block.list');
    Route::get('block/delete/{id}', 'BlockController@initProcessDelete')->name('block.delete');

    Route::get('admin/menu/headings/add', 'MenuHeadingController@initContentCreate')->name('menu_heading.add');
    Route::post('admin/menu/headings/add', 'MenuHeadingController@initProcessCreate');
    Route::get('admin/menu/headings/edit/{id}', 'MenuHeadingController@initContentCreate')->name('menu_heading.edit');
    Route::post('admin/menu/headings/edit/{id}', 'MenuHeadingController@initProcessCreate');
    Route::get('admin/menu/headings', 'MenuHeadingController@initListing')->name('menu_heading.list');
    Route::get('admin/menu/headings/delete/{id}', 'MenuHeadingController@initProcessDelete')->name('menu_heading.delete');

    Route::get('admin/menu/add', 'AdminMenuController@initContentCreate')->name('admin_menu.add');
    Route::post('admin/menu/add', 'AdminMenuController@initProcessCreate');
    Route::get('admin/menu/edit/{id}', 'AdminMenuController@initContentCreate')->name('admin_menu.edit');
    Route::post('admin/menu/edit/{id}', 'AdminMenuController@initProcessCreate');
    Route::get('admin/menu', 'AdminMenuController@initListing')->name('admin_menu.list');
    Route::get('admin/menu/delete/{id}', 'AdminMenuController@initProcessDelete')->name('admin_menu.delete');

    // @AdminMenuChildController routes@ Added from component controller
    Route::get('admin/menu/child/add', 'AdminMenuChildController@initContentCreate')->name('admin_menu_child.add');
    Route::post('admin/menu/child/add', 'AdminMenuChildController@initProcessCreate');
    Route::get('admin/menu/child/edit/{id}', 'AdminMenuChildController@initContentCreate')->name('admin_menu_child.edit');
    Route::post('admin/menu/child/edit/{id}', 'AdminMenuChildController@initProcessCreate');
    Route::get('admin/menu/child', 'AdminMenuChildController@initListing')->name('admin_menu_child.list');
    Route::get('admin/menu/child/delete/{id}', 'AdminMenuChildController@initProcessDelete')->name('admin_menu_child.delete');
    
    // @ComponentController routes@ Added from component controller
    Route::get('component/add', 'ComponentController@initContentCreate')->name('component.add');
    Route::post('component/add', 'ComponentController@initProcessCreate');
    Route::get('component/edit/{id}', 'ComponentController@initContentCreate')->name('component.edit');
    Route::post('component/edit/{id}', 'ComponentController@initProcessCreate');
    Route::get('component/list', 'ComponentController@initListing')->name('component.list');
    Route::post('component/relational', 'ComponentController@initProcessGetRealtionalComponentFields');

    Route::get('configuration', 'ConfigurationController@initContentCreate')->name('configuration');
    Route::post('configuration', 'ConfigurationController@initProcessCreate');
    Route::get('reset/assets', 'ConfigurationController@initProcessResetAssets')->name('reset.assets');

    // @EmailController routes@ Added from email controller
    Route::get('email/add', 'EmailController@initContentCreate')->name('email.add');
    Route::post('email/add', 'EmailController@initProcessCreate');
    Route::get('email/edit/{id}', 'EmailController@initContentCreate')->name('email.edit');
    Route::post('email/edit/{id}', 'EmailController@initProcessCreate');
    Route::get('email', 'EmailController@initListing')->name('email.list');
    Route::get('email/delete/{id}', 'EmailController@initProcessDelete')->name('email.delete');
    
});

Route::group(['prefix' => 'employee'], function () {
    Route::get('register', 'EmployeeController@initContentRegister')->name('employee.register');
    Route::post('register', 'EmployeeController@initProcessRegister');
    Route::get('edit/{id}', 'EmployeeController@initContentRegister')->name('employee.edit');
    Route::post('edit/{id}', 'EmployeeController@initProcessRegister');

    Route::get('delete/{id}', 'EmployeeController@initProcessDelete');
    Route::get('list', 'EmployeeController@initListing')->name('employee.list');
});

Route::group(['middleware' => 'admin_guest'], function () {
				// @StatesController routes@ Added from component controller
				Route::get('states/add', 'StatesController@initContentCreate')->name('states.add');
				Route::post('states/add', 'StatesController@initProcessCreate');
				Route::get('states/edit/{id}', 'StatesController@initContentCreate')->name('states.edit');
				Route::post('states/edit/{id}', 'StatesController@initProcessCreate');
				Route::get('states', 'StatesController@initListing')->name('states.list');
				Route::get('states/delete/{id}', 'StatesController@initProcessDelete')->name('states.delete');

    Route::post('secure/challenge', 'AdminAuthController@initProcessLogin');

    // Route::get('login', 'AuthenticationController@initContentLogin')->name('login');
    // Route::post('login', 'AuthenticationController@initProcessLogin');
    // Route::get('register', 'AuthenticationController@initContentRegister')->name('register');
    // Route::post('register', 'AuthenticationController@initProcessRegister');

    // Route::get('password/reset', 'ForgotPasswordController@initContentPasswordReset')->name('password.request');
    // Route::post('password/email', 'ForgotPasswordController@initProcessSendResetLink')->name('password.email');

    // Route::get('password/reset/{token}', 'ResetPasswordController@initContentSetNewPassword')->name('password.reset');
    // Route::post('password/reset', 'ResetPasswordController@initProcessResetPassword')->name('password.update');
    // Route::get('verify/account/{token}', 'AuthenticationController@initProcessVerificationAccount')->name('verify.account');
});

// Route::get('secure/challenge', 'AdminAuthController@initContent')->name('adminroute');
// Route::post('secure/challenge', 'AdminAuthController@initProcessLogin');
