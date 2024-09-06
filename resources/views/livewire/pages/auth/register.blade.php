<?php

use App\Models\User;
use App\Providers\RouteServiceProvider;
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
    public string $pricing_plan_id = '';
    public string $billing_address = '';
    public string $postal_address = '';
    public string $company_name = '';
    public string $surname = '';
    public string $telephone = '';

    public function mount(string $pricing_plan_id = ''): void
    {
        $this->pricing_plan_id = $pricing_plan_id;
    }
    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'surname' => ['required', 'string', 'max:255'],
            'telephone' => ['required', 'string', 'max:255'],     
            'billing_address' => ['string', 'max:255'],    
            'postal_address' => ['string', 'max:255'],    
            'company_name' => ['string', 'max:255'],           
        ]);
        
        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        $user->assignRole('admin');

        Auth::login($user);

        if($this->pricing_plan_id) {
            $this->redirect(route("user-subscription.checkout", ["plan_id" => $this->pricing_plan_id]));
        } else {
            $this->redirect(RouteServiceProvider::HOME, navigate: true);
        }

    }
}; ?>

<div>    
    <form wire:submit="register">
        <div class="flex flex-col gap-4">
            <div class="flex gap-4">
                <div class="flex-1">
                    <x-input-label for="surname" :value="__('messages.surname')" />
                    <x-text-input wire:model="surname" id="surname" class="block mt-1 w-full" type="text" name="surname" required autofocus autocomplete="surname" />
                    <x-input-error :messages="$errors->get('surname')" class="mt-2" />
                </div>
                <div class="flex-1">
                    <x-input-label for="name" :value="__('messages.name')" />
                    <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" name="name" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
            </div>
    
            <div class="flex gap-4">
                <div class="flex-1">
                    <x-input-label for="email" :value="__('messages.email')" />
                    <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
        
                <div class="flex-1">
                    <x-input-label for="telephone" :value="__('messages.telephone')" />
                    <x-text-input wire:model="telephone" id="telephone" class="block mt-1 w-full" type="text" name="telephone" required autofocus autocomplete="telephone" />
                    <x-input-error :messages="$errors->get('telephone')" class="mt-2" />
                </div>
            </div>
            
            <div>
                <x-input-label for="company_name" :value="__('messages.company_name')" />
                <x-text-input wire:model="company_name" id="company_name" class="block mt-1 w-full" type="text" name="company_name" required autofocus autocomplete="company_name" />
                <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
            </div>
    
            <div class="flex gap-4">
                <div class="flex-1">
                    <x-input-label for="billing_address" :value="__('messages.billing_address')" />
                    <x-text-input wire:model="billing_address" id="billing_address" class="block mt-1 w-full" type="text" name="billing_address" required autofocus autocomplete="billing_address" />
                    <x-input-error :messages="$errors->get('billing_address')" class="mt-2" />
                </div>
        
                <div class="flex-1">
                    <x-input-label for="postal_address" :value="__('messages.postal_address')" />
                    <x-text-input wire:model="postal_address" id="postal_address" class="block mt-1 w-full" type="text" name="postal_address" required autofocus autocomplete="postal_address" />
                    <x-input-error :messages="$errors->get('postal_address')" class="mt-2" />
                </div>
            </div>
    
            
            <div class="flex gap-4">
                <div class="flex-1">
                    <x-input-label for="password" :value="__('messages.password')" />
        
                    <x-text-input wire:model="password" id="password" class="block mt-1 w-full"
                                    type="password"
                                    name="password"
                                    required autocomplete="new-password" />
        
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
                    
                <div class="flex-1">
                    <x-input-label for="password_confirmation" :value="__('messages.confirm_password')" />
        
                    <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full"
                                    type="password"
                                    name="password_confirmation" required autocomplete="new-password" />
        
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
            </div>                
    
            <div class="flex items-center justify-end mt-4">
                <input type="hidden" name="pricing_plan_id" value="{{ $pricing_plan_id }}"/>
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}" wire:navigate>
                    {{ __('messages.already_register') }}
                </a>
    
                <x-primary-button class="ms-4">
                    {{ __('messages.register') }}
                </x-primary-button>
            </div>
        </div>
    </form>
</div>
