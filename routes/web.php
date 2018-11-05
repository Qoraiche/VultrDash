<?php

/*
|--------------------------------------------------------------------------
| Vultrdash Application Web Routes
|--------------------------------------------------------------------------
|
*/

Route::get( '/', 'Dash@home' )->name('home');
Route::get( 'activity', 'Dash@activity' )->name('activity');
Route::delete( 'activity/{id}', 'Dash@deleteActivity' )->middleware( ['role:super-admin'] );
Route::delete( 'activity', 'Dash@clearActivity' )->middleware( ['role:super-admin'] )->name('activity.clear');
Route::delete( 'useractivity', 'Dash@deleteActivityByUser' )->middleware( ['role:super-admin'] );

/**
 * 
 * Refresh - clear cache
 * 
 */

Route::get( 'refresh', function(){
	Cache::flush();
	return redirect( url()->previous() );
});

/**
 * 
 * Authentication
 * 
 */

Route::auth();
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

/**
 * 
 * Threads/messages
 * 
 */

Route::group(['prefix' => 'messages'], function () {
    Route::get('/', ['as' => 'messages', 'uses' => 'MessagesController@index']);
    Route::get('create', ['as' => 'messages.create', 'uses' => 'MessagesController@create']);
    Route::post('/', ['as' => 'messages.store', 'uses' => 'MessagesController@store']);
    Route::get('{id}', ['as' => 'messages.show', 'uses' => 'MessagesController@show']);
    Route::put('{id}', ['as' => 'messages.update', 'uses' => 'MessagesController@update']);
});


/**
 * 
 * Users
 */

Route::resource( 'users', 'ManageUsers' );

/**
 * 
 * Settings
 */


Route::group( [ 'prefix' => 'account', 'as' => 'account.', 'middleware' => 'auth'], function(){
	Route::get('/', 'MyAccount@index')->name('index');
	Route::get('thread/{id}', 'Myaccount@showThread')->name('thread.show');
	Route::post('thread', 'Myaccount@storeThread')->name('thread.store');
	Route::put('thread/{id}', 'Myaccount@updateThread')->name('thread.update');
	Route::delete('thread/{id}', 'Myaccount@deleteThread')->name('thread.delete');
	// Route::patch('/notif/markasread/{id}', 'Settings@markAsRead');
	// Route::patch('/notif/markallasread', 'Settings@markNotificationsAsRead');
	// Route::delete('/notif/deleteall', 'Settings@deleteNotifications');
	// Route::post('/update', 'Settings@updateSettings');
	
});

/**
 * 
 * Api
 */

Route::group( [ 'prefix' => 'api', 'middleware' => 'auth'], function(){
	Route::get('get/regions','api@getRegions');
	Route::get('get/plans','api@getPlans');
	Route::get('get/plans/region/{dcid}/type/{type?}/{listtype?}','api@getRegionPlans');

});

/**
 * 
 * Backups
 */
	
Route::get('backups', 'Backups@index')->name('backups.index');

/**
 * 
 * IPs
 * 
 */

Route::get('ips', 'Ips@index')->name('ips');

/**
 *
 * Servers
 *
 */

Route::get( '/servers', 'Dash@servers' )->name('servers.index');
Route::group( [ 'prefix' => 'servers', 'as' => 'servers.', 'middleware' => [ 'auth', 'permission:manage servers' ] ], function(){
	Route::get( '{serverid}/ddos', 'Servers@viewDDOS' )->name('view.ddos');
	Route::post( 'halt', 'Servers@halt' )->name('halt');
	Route::post( 'start', 'Servers@start' )->name('start');
	Route::post( 'reinstall', 'Servers@reinstall' )->name('reinstall');
	Route::post( 'destroy', 'Servers@destroy' )->name('destroy');
	Route::post( 'firewallgroupset', 'Servers@firewallGroupSet')->name('firewallgroupset');
	Route::post( 'isoattach', 'Servers@isoAttach')->name('isoattach');
	Route::post( 'isodetach', 'Servers@isoDetach')->name('isodetach');
	Route::post( 'labelset', 'Servers@labelSet')->name('labelset');
	Route::post( 'tagset', 'Servers@tagSet')->name('tagset');
	Route::post( 'upgradeplan', 'Servers@upgradePlan')->name('upgradeplan');
	Route::post( 'oschange', 'Servers@osChange')->name('oschange');
	Route::post( 'appchange', 'Servers@appChange')->name('appchange');
	Route::post( 'restoresnapshot', 'Servers@restoreSnapshot')->name('restoresnapshot');
	Route::post( 'backupenable', 'Servers@backupEnable')->name('backupenable');
	Route::post( 'backupsetschedule', 'Servers@backupSetSchedule')->name('backupsetschedule');
	Route::post( 'backupdisable', 'Servers@backupDisable')->name('backupdisable');
	Route::get( '{serverid}', 'Servers@show' )->name('view')->middleware('viewserver')->where('serverid', '[0-9]+');
	Route::get( '{serverid}/settings', 'Servers@viewSettings' )->name('view.settings')->middleware('viewserver')->where('serverid', '[0-9]+');
	Route::get( '{serverid}/snapshots', 'Servers@viewSnapshots' )->name('view.snapshots')->middleware('viewserver')->where('serverid', '[0-9]+');
	Route::get( '{serverid}/backups', 'Servers@viewBackups' )->name('view.backups')->middleware('viewserver')->where('serverid', '[0-9]+');
	Route::get( '{serverid}/activity', 'Servers@viewActivity' )->name('view.activity')->middleware('viewserver')->where('serverid', '[0-9]+');
	
});

Route::group( [ 'prefix' => 'servers', 'as' => 'servers.', 'middleware' => ['auth', 'permission:deploy servers'] ], function(){

	Route::get( 'add', 'Servers@deploy' )->name('deploy');
	Route::post( 'create', 'Servers@create' )->name('create');
	
});

/**
 *
 * 
 * Snapshots
 * 
 */

Route::get('/snapshots', 'Snapshots@index')->name('snapshots.index');
Route::group( ['prefix' => 'snapshots', 'as' => 'snapshots.', 'middleware' => [ 'auth', 'permission:manage snapshots' ] ], function(){
	Route::get('add', 'Snapshots@add')->name('add');
	Route::get('upload', 'Snapshots@upload')->name('upload');
	Route::post('create', 'Snapshots@create')->name('create');
	Route::post('createfromurl', 'Snapshots@createFromUrl')->name('createfromurl');
	Route::delete('destroy', 'Snapshots@destroy')->name('destroy');
});

/**
 * 
 * ISO
 * 
 */

Route::get('/iso', 'isos@index')->name('iso.index');
Route::group( ['prefix' => 'iso', 'as' => 'iso.', 'middleware' => [ 'auth', 'permission:manage iso' ] ], function(){
	Route::get('add', 'isos@add')->name('add');
	Route::post('create', 'isos@create')->name('create');
});

/**
 * 
 * Startup
 * 
 */

Route::get( '/startup', 'startups@index' )->name( 'startup.index' );
Route::group( ['prefix' => 'startup', 'as' => 'startup.', [ 'auth', 'permission:manage startupscripts' ] ], function(){
	Route::get('/', 'startups@index')->name('index');
	Route::get('add', 'startups@add')->name('add');
	Route::post('create', 'startups@create')->name('create');
	Route::delete('destroy', 'startups@destroy')->name('destroy');
	Route::get('{id}/edit', 'Sshkeys@add')->name('edit');
	Route::post('update', 'Sshkeys@add')->name('update');
});

/**
 * 
 * SSH keys
 * 
 */

Route::get('/sshkeys', 'Sshkeys@index')->name('sshkeys.index');
Route::group( ['prefix' => 'sshkeys', 'as' => 'sshkeys.', 'middleware' => [ 'auth', 'permission:manage sshkeys' ] ], function(){
	Route::get('add', 'Sshkeys@add')->name('add');
	Route::get('edit/{sshkeyid}', 'Sshkeys@edit')->name('edit');
	Route::post('create', 'Sshkeys@create')->name('create');
	Route::post('update', 'Sshkeys@update')->name('update');
	Route::delete('destroy', 'Sshkeys@destroy')->name('destroy');
});

/**
 *
 * DNS
 * 
 */

Route::get('/dns', 'Dnsdomains@index')->name('dns.index');
Route::group( ['prefix' => 'dns', 'as' => 'dns.', 'middleware' => [ 'auth', 'permission:manage dns' ] ], function(){
	Route::get('add', 'Dnsdomains@add')->name('add');
	Route::post('create', 'Dnsdomains@create')->name('create');
	Route::delete('delete', 'Dnsdomains@delete')->name('delete');
});

/**
 *
 * Blockstorage
 * 
 */

Route::get('/blockstorage', 'blockstorage@index')->name('blockstorage.index');
Route::group( ['prefix' => 'blockstorage', 'as' => 'blockstorage.', 'middleware' => [ 'auth', 'permission:manage blockstorage' ] ], function(){
	Route::get('add', 'blockstorage@add')->name('add');
	Route::post('create', 'blockstorage@create')->name('create');
	Route::delete('delete', 'blockstorage@delete')->name('delete');
});

/**
 *
 * Firewall
 * 
 */

Route::get('/firewall', 'firewall@index')->name('firewall.index');
Route::group( ['prefix' => 'firewall', 'as' => 'firewall.', 'middleware' => [ 'auth', 'permission:manage firewalls' ] ], function(){
	Route::delete('delete', 'firewall@delete_group')->name('delete_group');
});

/**
 *
 * Networks
 * 
 */

Route::get('/networks', 'Networks@index')->name('networks.index');
Route::group( ['prefix' => 'networks', 'as' => 'networks.', 'middleware' => [ 'auth', 'permission:manage networks' ] ], function(){
	Route::get('add', 'Networks@add')->name('add');
	Route::post('create', 'Networks@create')->name('create');
	Route::delete('delete', 'Networks@destroy')->name('destroy');
});