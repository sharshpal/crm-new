<?php

use App\Models\DatiContratto;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


//All users (guest and logged)
Route::middleware(['web'])->group(static function () {

    Route::get('/', function () {
        return redirect('/login');
    });

    Route::namespace('Brackets\AdminAuth\Http\Controllers\Auth')->group(static function () {
        Route::get('/admin/login', function () {
            return redirect('/login');
        })->name('brackets/admin-auth::admin/login');
    });

    Route::namespace('App\Http\Controllers')->group(static function () {
        Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
        Route::post('/login', 'Auth\LoginController@login')->name("trylogin");

        Route::any('/logout', 'Auth\LoginController@logout')->name('logout');

        Route::get('/password-reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('/password/showForgotForm');
        Route::post('/password-reset/send', 'Auth\ForgotPasswordController@sendResetLinkEmail');
        Route::get('/password-reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('/password/showResetForm');
        Route::post('/password-reset/reset', 'Auth\ResetPasswordController@reset');

        Route::get('/activation/{token}', 'Auth\ActivationController@activate')->name('/activation/activate');

        Route::get('/activation', 'Auth\ActivationEmailController@showLinkRequestForm')->name('/activation');
        Route::post('/activation/send', 'Auth\ActivationEmailController@sendActivationEmail');
    });

});



//All auth users
Route::middleware(['auth:' . config('admin-auth.defaults.guard'),'ipfilter'])->group(static function () {

    Route::get('/home', function () {
        return redirect('/dashboard');
    })->name('home');

    Route::get('/dashboard', 'App\Http\Controllers\Dashboard\DashboardController@index')->name('/dashboard');

    Route::prefix('profile')->namespace('App\Http\Controllers\Profile')->name('profile/')->group(static function () {
        Route::get('/edit', 'ProfileController@editProfile')->name('edit-profile');
        Route::post('/edit', 'ProfileController@updateProfile')->name('update-profile');
        Route::get('/password', 'ProfileController@editPassword')->name('edit-password');
        Route::post('/password', 'ProfileController@updatePassword')->name('update-password');
    });


    Route::prefix('dati-contratto')->namespace('App\Http\Controllers\DatiContratto')->name('dati-contratto/')->group(static function () {
        Route::get('/', 'DatiContrattoController@index')->name('index');
        Route::get('/statistiche-esiti', 'DatiContrattoController@statisticheEsiti')->name('statistiche-esiti');
        Route::get('/export-statistiche-esiti', 'DatiContrattoController@exportStatisticheEsiti')->name('export-statistiche-esiti');
        Route::get('/create', 'DatiContrattoController@create')->name('create');
        //Route::get('/apicreate', 'DatiContrattoController@apicreate')->name('apicreate');
        Route::post('/', 'DatiContrattoController@store')->name('store');
        Route::get('/{datiContratto}/edit', 'DatiContrattoController@edit')->name('edit');
        Route::get('/{datiContratto}/show', 'DatiContrattoController@show')->name('show');
        Route::post('/{datiContratto}', 'DatiContrattoController@update')->name('update');
        Route::delete('/{datiContratto}', 'DatiContrattoController@destroy')->name('destroy');
        Route::get('/export', 'DatiContrattoController@exportList')->name('export');
        Route::post('/{datiContratto}/recover', 'DatiContrattoController@recoverContratto')->name('recover-contratto');
        Route::post('/{datiContratto}/edit-esito', 'DatiContrattoController@editEsito')->name('edit-esito');
        Route::post('/{datiContratto}/edit-note', 'DatiContrattoController@editNoteContratto')->name('edit-note');
    });

    Route::post('/bulk-edit-esito-contratti', 'App\Http\Controllers\DatiContratto\DatiContrattoController@bulkEditEsito')->name('bulk-edit-esito-contratti');


    Route::post('/check-fatturazione', 'App\Http\Controllers\DatiContratto\DatiContrattoController@exportVerificaFatturazione')->name('check-fatturazione');

    Route::prefix('campagna')->namespace('App\Http\Controllers\Admin')->name('campagna/')->group(static function () {
        Route::get('/', 'CampagnaController@index')->name('index');
    });

    Route::prefix('partner')->namespace('App\Http\Controllers\Admin')->name('partner/')->group(static function () {
        Route::get('/', 'PartnerController@index')->name('index');
    });

    Route::prefix('recording-log')->namespace('App\Http\Controllers\Admin')->name('recording-log/')->group(static function () {
        Route::get('/', 'RecordingLogController@index')->name('index');
    });

    Route::prefix('agent-log')->namespace('App\Http\Controllers\Admin')->name('agent-log/')->group(static function () {
        Route::get('/', 'VicidialAgentLogController@agentLog')->name('agent-log');
    });

    Route::get('/export-time-stats', 'App\Http\Controllers\Admin\VicidialAgentLogController@exportTimeStats')->name('export-time-stats');

    Route::get('/export-status-stats', 'App\Http\Controllers\Admin\VicidialAgentLogController@exportStatusStats')->name('export-status-stats');

    Route::get('/export-users-performance', 'App\Http\Controllers\Admin\UserTimelogController@exportUsersPerformance')->name('export-users-performance');

    Route::prefix('agent-stat-log')->namespace('App\Http\Controllers\Admin')->name('agent-stat-log/')->group(static function () {
        Route::get('/', 'VicidialAgentLogController@agentStatLog')->name('agent-stat-log');
    });

    Route::prefix('user-performance')->namespace('App\Http\Controllers\Admin')->name('user-performance/')->group(static function () {
        Route::get('/', 'UserTimelogController@userPerformance')->name('user-performance');
    });

    Route::prefix('user-timelog')->namespace('App\Http\Controllers\Admin')->name('user-timelog/')->group(static function () {
        Route::get('/', 'UserTimelogController@index')->name('index');
        Route::get('/create', 'UserTimelogController@create')->name('create');
        Route::post('/', 'UserTimelogController@store')->name('store');
        Route::get('/{userTimelog}/edit', 'UserTimelogController@edit')->name('edit');
        Route::post('/{userTimelog}', 'UserTimelogController@update')->name('update');
        Route::delete('/{userTimelog}', 'UserTimelogController@destroy')->name('destroy');
    });

    Route::post('/user/search', 'App\Http\Controllers\Admin\AdminUsersController@searchUser')->name('search-user');

    Route::post('attach-file', 'App\Http\Controllers\Upload\MyFileUploadController@upload')->name('attach-file');

    Route::post('dtc-attach-file', 'App\Http\Controllers\Upload\MyFileUploadController@upload')->name('dtc-attach-file');

    Route::post('dte-attach-file', 'App\Http\Controllers\Upload\MyFileUploadController@upload')->name('dte-attach-file');

    Route::get('storage/{id}/{name}', 'App\Http\Controllers\Upload\MyFileViewController@view')->name('media-view');

    Route::get('get-locked-ts', 'App\Http\Controllers\DatiContratto\DatiContrattoController@getLockedTs')->name('getLockedTs');


    /*
    Route::get('mail', function () {

        $today = Carbon::now();

        $request = new Request();

        $rows = DatiContratto::partnersInsert($request)->get()->all();

        $title = "Inserimenti Partner del {$today->isoFormat("DD/MM/YYYY")}";

        return (new App\Notifications\InserimentiPartnerNotification($title,$rows,null))
            ->toMail([]);
    });
    */


});


//All admin users
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'ipfilter', 'admin'])->group(static function () {

    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function () {

        Route::get('/', function () {
            return redirect('/dashboard');
        })->name('admin/dashboard');

        Route::prefix('users')->name('admin-users/')->group(static function () {
            Route::get('/', 'AdminUsersController@index')->name('index');
            Route::get('/create', 'AdminUsersController@create')->name('create');
            Route::post('/', 'AdminUsersController@store')->name('store');
            Route::get('/{adminUser}/impersonal-login', 'AdminUsersController@impersonalLogin')->name('impersonal-login');
            Route::get('/{adminUser}/edit', 'AdminUsersController@edit')->name('edit');
            Route::post('/{adminUser}', 'AdminUsersController@update')->name('update');
            Route::delete('/{adminUser}', 'AdminUsersController@destroy')->name('destroy');
            Route::get('/{adminUser}/resend-activation', 'AdminUsersController@resendActivationEmail')->name('resendActivationEmail');
        });

        Route::prefix('partners')->name('partners/')->group(static function () {
            Route::get('/', 'PartnerController@index')->name('index');
            Route::get('/create', 'PartnerController@create')->name('create');
            Route::post('/', 'PartnerController@store')->name('store');
            Route::get('/{partner}/edit', 'PartnerController@edit')->name('edit');
            Route::post('/{partner}', 'PartnerController@update')->name('update');
            Route::delete('/{partner}', 'PartnerController@destroy')->name('destroy');
        });

        Route::post('/bulk-assign-partner-campagna', 'PartnerController@bulkAssignCampagna')->name('bulk-assign-partner-campagna');
        Route::post('/bulk-assign-user-campagna', 'AdminUsersController@bulkAssignCampagna')->name('bulk-assign-user-campagna');

        Route::prefix('campaign')->name('campaign/')->group(static function () {
            Route::get('/', 'CampagnaController@index')->name('index');
            Route::get('/create', 'CampagnaController@create')->name('create');
            Route::post('/', 'CampagnaController@store')->name('store');
            Route::get('/{campagna}/edit', 'CampagnaController@edit')->name('edit');
            Route::post('/{campagna}', 'CampagnaController@update')->name('update');
            Route::delete('/{campagna}', 'CampagnaController@destroy')->name('destroy');
        });

        Route::prefix('esito')->name('esito/')->group(static function () {
            Route::get('/', 'EsitoController@index')->name('index');
            Route::get('/create', 'EsitoController@create')->name('create');
            Route::post('/', 'EsitoController@store')->name('store');
            Route::get('/{esito}/edit', 'EsitoController@edit')->name('edit');
            Route::post('/{esito}', 'EsitoController@update')->name('update');
            Route::delete('/{esito}', 'EsitoController@destroy')->name('destroy');
        });


        Route::prefix('rec-server')->name('rec-server/')->group(static function () {
            Route::get('/', 'RecServerController@index')->name('index');
            Route::get('/create', 'RecServerController@create')->name('create');
            Route::post('/', 'RecServerController@store')->name('store');
            Route::get('/{recServer}/edit', 'RecServerController@edit')->name('edit');
            Route::post('/{recServer}', 'RecServerController@update')->name('update');
            Route::delete('/{recServer}', 'RecServerController@destroy')->name('destroy');
        });

        Route::prefix('sys-settings')->name('sys-settings/')->group(static function() {
            Route::get('/',                                             'SysSettingsController@index')->name('index');
            Route::get('/create',                                       'SysSettingsController@create')->name('create');
            Route::post('/',                                            'SysSettingsController@store')->name('store');
            Route::get('/{sysSetting}/edit',                            'SysSettingsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'SysSettingsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{sysSetting}',                                'SysSettingsController@update')->name('update');
            Route::delete('/{sysSetting}',                              'SysSettingsController@destroy')->name('destroy');
        });

    });
});

