<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $email = '';

    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        $status = Password::sendResetLink($this->only('email'));

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));
            return;
        }

        $this->reset('email');
        session()->flash('status', __($status));
    }
};
?>

<section class="bg-white dark:bg-neutral-700 flex flex-wrap min-h-[100vh]">  
    <!-- Left Image -->
    <div class="lg:w-1/2 lg:block hidden">
        <div class="flex items-center flex-col h-full justify-center">
            <img src="{{ asset('assets/images/auth/forgot-pass-img.png') }}" alt="Forgot Password">
        </div>
    </div>

    <!-- Right Form -->
    <div class="lg:w-1/2 py-8 px-6 flex flex-col justify-center">
        <div class="lg:max-w-[464px] mx-auto w-full">
            <div>
                <h4 class="mb-3">Forgot Password</h4>
                <p class="mb-8 text-secondary-light text-lg">
                    Enter the email address associated with your account and we will send you a link to reset your password.
                </p>
            </div>

            <form wire:submit.prevent="sendPasswordResetLink">
                @if (session('status'))
                    <div class="alert alert-success mb-3">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Email Field -->
                <div class="icon-field mb-6 relative">
                    <span class="absolute start-4 top-1/2 -translate-y-1/2 pointer-events-none flex text-xl">
                        <iconify-icon icon="mage:email"></iconify-icon>
                    </span>
                    <input type="email" wire:model.defer="email"
                           class="form-control h-[56px] ps-11 border-neutral-300 bg-neutral-50 dark:bg-neutral-600 rounded-xl"
                           placeholder="Enter your email" required>
                    <x-input-error :messages="$errors->get('email')" class="text-red-500 text-sm mt-1" />
                </div>

                <!-- Submit -->
                <button type="submit" class="btn btn-primary justify-center text-sm btn-sm px-3 py-4 w-full rounded-xl">
                    Send Reset Link
                </button>

                <div class="text-center">
                    <a href="{{ route('login') }}" wire:navigate class="text-primary-600 font-bold mt-6 hover:underline">
                        Back to Sign In
                    </a>
                </div>

                <div class="mt-10 md:mt-[60px] lg:mt-[100px] xl:mt-[120px] text-center text-sm">
                    <p class="mb-0">
                        Already have an account?
                        <a href="{{ route('login') }}" wire:navigate class="text-primary-600 font-semibold hover:underline">
                            Sign In
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</section>



