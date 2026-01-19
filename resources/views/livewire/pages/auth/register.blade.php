<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function register()
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);
        return $this->redirectRoute('dashboard');
        // $this->redirect(route('dashboard', absolute: false), navigate: true);
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

    <!-- Right Register Form -->
    <div class="lg:w-1/2 py-8 px-6 flex flex-col justify-center">
        <div class="lg:max-w-[464px] mx-auto w-full">
            <div>
                {{-- <a href="/" class="mb-2.5 max-w-[290px]">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="">
                </a> --}}
                <h4 class="mb-3">Create an Account</h4>
                <p class="mb-8 text-secondary-light text-lg">Sign up for free and get started</p>
            </div>

            <!-- Livewire Register Form -->
            <form wire:submit.prevent="register">
                <!-- Name -->
                <div class="icon-field mb-4 relative">
                    <span class="absolute start-4 top-1/2 -translate-y-1/2 flex text-xl">
                        <iconify-icon icon="f7:person"></iconify-icon>
                    </span>
                    <input type="text" wire:model.defer="name"
                           class="form-control h-[56px] ps-11 border-neutral-300 bg-neutral-50 dark:bg-dark-2 rounded-xl"
                           placeholder="Name" required>
                    <x-input-error :messages="$errors->get('name')" class="text-red-500 mt-1 text-sm" />
                </div>

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

                <!-- Password -->
                <div class="icon-field mb-4 relative">
                    <span class="absolute start-4 top-1/2 -translate-y-1/2 flex text-xl">
                        <iconify-icon icon="solar:lock-password-outline"></iconify-icon>
                    </span>
                    <input type="password" wire:model.defer="password"
                           class="form-control h-[56px] ps-11 border-neutral-300 bg-neutral-50 dark:bg-dark-2 rounded-xl"
                           placeholder="Password" required autocomplete="new-password">
                    <x-input-error :messages="$errors->get('password')" class="text-red-500 mt-1 text-sm" />
                </div>

                <!-- Confirm Password -->
                <div class="icon-field mb-6 relative">
                    <span class="absolute start-4 top-1/2 -translate-y-1/2 flex text-xl">
                        <iconify-icon icon="solar:lock-password-outline"></iconify-icon>
                    </span>
                    <input type="password" wire:model.defer="password_confirmation"
                           class="form-control h-[56px] ps-11 border-neutral-300 bg-neutral-50 dark:bg-dark-2 rounded-xl"
                           placeholder="Confirm Password" required autocomplete="new-password">
                </div>

                <!-- Terms -->
                <div class="flex items-start gap-2 text-sm mb-6">
                    <input id="condition" type="checkbox" class="mt-1.5 border-neutral-300 rounded">
                    <label for="condition" class="text-gray-600 dark:text-gray-300">
                        By creating an account you agree to the 
                        <a href="#" class="text-primary-600 font-semibold">Terms & Conditions</a> and our 
                        <a href="#" class="text-primary-600 font-semibold">Privacy Policy</a>
                    </label>
                </div>

                <!-- Register Button -->
                <button type="submit" class="btn btn-primary justify-center w-full mt-2 py-4 rounded-xl">Sign Up</button>

                <!-- Footer -->
                <div class="mt-8 text-center text-sm">
                    <p>Already have an account? 
                        <a href="{{ route('login') }}" class="text-primary-600 font-semibold hover:underline" wire:navigate>Sign In</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</section>
