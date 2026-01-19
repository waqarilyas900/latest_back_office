<?php

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    #[Locked]
    public string $token = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function mount(string $token): void
    {
        $this->token = $token;
        $this->email = request()->string('email');
    }

    public function resetPassword(): void
    {
        $this->validate([
            'token' => ['required'],
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $status = Password::reset(
            $this->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) {
                $user->forceFill([
                    'password' => Hash::make($this->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status != Password::PASSWORD_RESET) {
            $this->addError('email', __($status));
            return;
        }

        Session::flash('status', __($status));

        $this->redirectRoute('login', navigate: true);
    }
};
?>

<section class="bg-white dark:bg-dark-2 flex flex-wrap min-h-[100vh]">  
    <!-- Left Illustration -->
    <div class="lg:w-1/2 lg:block hidden">
        <div class="flex items-center flex-col h-full justify-center">
            <img src="{{ asset('assets/images/auth/auth-img.png') }}" alt="">
        </div>
    </div>

    <!-- Right Reset Form -->
    <div class="lg:w-1/2 py-8 px-6 flex flex-col justify-center">
        <div class="lg:max-w-[464px] mx-auto w-full">
            <div>
                {{-- <a href="/" class="mb-2.5 max-w-[290px]">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="">
                </a> --}}
                <h4 class="mb-3">Reset Your Password</h4>
                <p class="mb-8 text-secondary-light text-lg">
                    Set a new password to regain access to your account.
                </p>
            </div>

            <form wire:submit.prevent="resetPassword">
                <!-- Email -->
                <div class="icon-field mb-4 relative">
                    <span class="absolute start-4 top-1/2 -translate-y-1/2 flex text-xl">
                        <iconify-icon icon="mage:email"></iconify-icon>
                    </span>
                    <input type="email" wire:model.defer="email"
                           class="form-control h-[56px] ps-11 border-neutral-300 bg-neutral-50 dark:bg-dark-2 rounded-xl"
                           placeholder="Email" required>
                    <x-input-error :messages="$errors->get('email')" class="text-red-500 mt-1 text-sm" />
                </div>

                <!-- New Password -->
                <div class="icon-field mb-4 relative">
                    <span class="absolute start-4 top-1/2 -translate-y-1/2 flex text-xl">
                        <iconify-icon icon="solar:lock-password-outline"></iconify-icon>
                    </span>
                    <input type="password" wire:model.defer="password"
                           class="form-control h-[56px] ps-11 border-neutral-300 bg-neutral-50 dark:bg-dark-2 rounded-xl"
                           placeholder="New Password" required autocomplete="new-password">
                    <x-input-error :messages="$errors->get('password')" class="text-red-500 mt-1 text-sm" />
                </div>

                <!-- Confirm Password -->
                <div class="icon-field mb-6 relative">
                    <span class="absolute start-4 top-1/2 -translate-y-1/2 flex text-xl">
                        <iconify-icon icon="solar:lock-password-outline"></iconify-icon>
                    </span>
                    <input type="password" wire:model.defer="password_confirmation"
                           class="form-control h-[56px] ps-11 border-neutral-300 bg-neutral-50 dark:bg-dark-2 rounded-xl"
                           placeholder="Confirm New Password" required autocomplete="new-password">
                    <x-input-error :messages="$errors->get('password_confirmation')" class="text-red-500 mt-1 text-sm" />
                </div>

                <!-- Submit -->
                <button type="submit" class="btn btn-primary w-full mt-2 py-4 rounded-xl">
                    Reset Password
                </button>

                <!-- Back to Login -->
                <div class="mt-8 text-center text-sm">
                    <p>Remembered your password? 
                        <a href="{{ route('login') }}" class="text-primary-600 font-semibold hover:underline" wire:navigate>
                            Back to Login
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</section>
