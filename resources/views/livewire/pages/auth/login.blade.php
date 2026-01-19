<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    public function login()
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();
        return $this->redirectRoute('dashboard');
        

        // $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
};

?>

<section class="bg-white dark:bg-dark-2 flex flex-wrap min-h-[100vh]">  
    <div class="lg:w-1/2 lg:block hidden">
        <div class="flex items-center flex-col h-full justify-center">
            <img src="{{ asset('assets/images/auth/auth-img.png') }}" alt="">
        </div>
    </div>
    <div class="lg:w-1/2 py-8 px-6 flex flex-col justify-center">
        <div class="lg:max-w-[464px] mx-auto w-full">
            <div>
                {{-- <a href="/" class="mb-2.5 max-w-[290px]">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="">
                </a> --}}
                <h4 class="mb-3">Sign In to your Account</h4>
                <p class="mb-8 text-secondary-light text-lg">Welcome back! please enter your detail</p>
            </div>

            <!-- Livewire Login Form -->
            <form wire:submit.prevent="login">
                <div class="icon-field mb-4 relative">
                    <span class="absolute start-4 top-1/2 -translate-y-1/2 flex text-xl">
                        <iconify-icon icon="mage:email"></iconify-icon>
                    </span>
                    <input type="email" wire:model.defer="form.email"
                           class="form-control h-[56px] ps-11 border-neutral-300 bg-neutral-50 dark:bg-dark-2 rounded-xl"
                           placeholder="Email" required>
                    <x-input-error :messages="$errors->get('form.email')" class="text-red-500 mt-1 text-sm" />
                </div>

                <div class="relative mb-5">
                    <div class="icon-field">
                        <span class="absolute start-4 top-1/2 -translate-y-1/2 flex text-xl">
                            <iconify-icon icon="solar:lock-password-outline"></iconify-icon>
                        </span> 
                        <input type="password" wire:model.defer="form.password"
                               class="form-control h-[56px] ps-11 border-neutral-300 bg-neutral-50 dark:bg-dark-2 rounded-xl"
                               id="your-password" placeholder="Password" required>
                    </div>
                    <x-input-error :messages="$errors->get('form.password')" class="text-red-500 mt-1 text-sm" />
                </div>

                <div class="mt-7 flex justify-between items-center">
                    <label class="flex items-center">
                        <input type="checkbox" wire:model="form.remember" class="border border-neutral-300">
                        <span class="ps-2">Remember me</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-primary-600 font-medium hover:underline">Forgot Password?</a>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary justify-center w-full mt-8 py-4 rounded-xl">Sign In</button>
            </form>
        </div>
    </div>
</section>

