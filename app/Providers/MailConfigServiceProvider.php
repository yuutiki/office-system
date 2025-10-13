<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\SmtpConfigService;
use App\Models\SmtpSetting;
use App\Mail\Transport\GoogleOAuthTransportFactory;
use App\Services\OAuthService;
use Illuminate\Support\Facades\Schema;

class MailConfigServiceProvider extends ServiceProvider
{
    // public function register()
    // {
    //     // SMTPの設定サービスをシングルトンとして登録
    //     $this->app->singleton('smtp.config.service', function ($app) {
    //         return new SmtpConfigService();
    //     });
        
    //     // OAuthサービスを登録
    //     $this->app->singleton('oauth.service', function ($app) {
    //         return new OAuthService();
    //     });
        
    //     // GoogleのOAuthトランスポートファクトリーを登録
    //     $this->app->singleton('gmail.oauth.transport.factory', function ($app) {
    //         return new GoogleOAuthTransportFactory($app->make('oauth.service'));
    //     });
    // }

    // // public function boot()
    // // {
    // //     try {
    // //         if (Schema::hasTable('smtp_settings')) {
    // //             $this->app->make('smtp.config.service')->refreshMailConfig();
    // //             $this->registerOAuthTransports();
    // //         }
    // //     } catch (\Exception $e) {
    // //         // マイグレーション時などDB未接続でも無視
    // //     }
    // // }

    
    // /**
    //  * OAuth認証に対応したトランスポートを登録
    //  */
    // protected function registerOAuthTransports()
    // {
    //     // 社内・社外で有効なOAuth設定を取得
    //     $oauthSettings = SmtpSetting::where('auth_type', 'oauth')
    //                                ->whereNotNull('oauth_refresh_token')
    //                                ->get();
        
    //     foreach ($oauthSettings as $setting) {
    //         // メーラーに登録
    //         $this->app['mail.manager']->extend("{$setting->type}_oauth", function () use ($setting) {
    //             // DSN作成
    //             $dsn = $this->app['smtp.config.service']->createDsn($setting);
                
    //             // トランスポートファクトリーからトランスポートを作成
    //             return $this->app['gmail.oauth.transport.factory']->create($dsn);
    //         });
    //     }
    // }
}