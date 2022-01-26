<?php

namespace App\Providers;

use App\Models\User;
use App\Policies\UserPolicy;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        User::class => UserPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            $url = $this->updateUrl($url);

            return (new MailMessage)
                ->subject(Lang::get('Verify Email Address'))
                ->line(Lang::get('Please click the button below to verify your email address.'))
                ->action(Lang::get('Verify Email Address'), $url)
                ->line(Lang::get('If you did not create an account, no further action is required.'));
        });

        ResetPassword::toMailUsing(
            function ($notifiable, $url) {
                $url = url(route('password.reset', [
                    'token' => $url,
                    'email' => $notifiable->getEmailForPasswordReset(),
                ], false));
                $url = $this->updateUrl($url);

                return (new MailMessage)
                    ->subject(Lang::get('Reset Password Notification'))
                    ->line(Lang::get('You are receiving this email because we received a password reset request for your account.'))
                    ->action(Lang::get('Reset Password'), $url)
                    ->line(Lang::get('This password reset link will expire in :count minutes.', ['count' => config('auth.passwords.' . config('auth.defaults.passwords') . '.expire')]))
                    ->line(Lang::get('If you did not request a password reset, no further action is required.'));
            }
        );
    }

    private function updateUrl(string $url)
    {
        if (env('EXTERNAL_APP_URL')) {
            if (str_contains($url, 'api')) {
                if (str_contains($url, '127.0.0.1')) {
                    $url = str_replace('http://127.0.0.1/api', env('EXTERNAL_APP_URL'), $url);
                } else {
                    $url = str_replace(env('APP_URL') . '/api', env('EXTERNAL_APP_URL'), $url);
                }
            }
        }
        return $url;
    }
}
