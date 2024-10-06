<?php

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $surname = '';
    public string $telephone = '';
    public string $billing_address = '';
    public string $postal_address = '';
    public string $company_name = '';
    public string $vat = '';
    public string $street = '';
    public string $city = '';
    public string $country = '';
    public string $postal_code = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
        $this->surname = Auth::user()->surname;
        $this->telephone = Auth::user()->telephone;
        $this->company_name = Auth::user()->company_name ? Auth::user()->company_name : "";
        $this->vat = Auth::user()->vat ? Auth::user()->vat : "";
        $this->street = Auth::user()->street ? Auth::user()->street : "";
        $this->city = Auth::user()->city ? Auth::user()->city : "";
        $this->country = Auth::user()->country ? Auth::user()->country : "";
        $this->postal_code = Auth::user()->postal_code ? Auth::user()->postal_code : "";
        
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'surname' => ['required', 'string', 'max:255'],
            'telephone' => ['required', 'string', 'max:255'],     
            'billing_address' => ['string', 'max:255'],    
            'postal_address' => ['string', 'max:255'],    
            'company_name' => ['string', 'max:255'],
            'vat' => ['string', 'max:255'],
            'street' => ['string', 'max:255'],
            'city' => ['string', 'max:255'],
            'country' => ['string', 'max:255'],
            'postal_code' => ['string', 'max:255'],   
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: RouteServiceProvider::HOME);

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('messages.profile_information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("messages.profile_information_desc") }}
        </p>
    </header>

    <form wire:submit="updateProfileInformation" class="mt-6 space-y-6">
        <div>
            <x-input-label for="name" :value="__('messages.name')" />
            <x-text-input wire:model="name" id="name" name="name" type="text" class="mt-1 block w-full" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="surname" :value="__('messages.surname')" />
            <x-text-input wire:model="surname" id="surname" name="surname" type="text" class="mt-1 block w-full" required autofocus autocomplete="surname" />
            <x-input-error class="mt-2" :messages="$errors->get('surname')" />
        </div>

        <div>
            <x-input-label for="telephone" :value="__('messages.telephone')" />
            <x-text-input wire:model="telephone" id="telephone" name="telephone" type="text" class="mt-1 block w-full" required autofocus autocomplete="telephone" />
            <x-input-error class="mt-2" :messages="$errors->get('telephone')" />
        </div>

        <div>
            <x-input-label for="company_name" :value="__('messages.company_name')" />
            <x-text-input wire:model="company_name" id="company_name" name="company_name" type="text" class="mt-1 block w-full" required autofocus autocomplete="company_name" />
            <x-input-error class="mt-2" :messages="$errors->get('company_name')" />
        </div>

        <div>
            <x-input-label for="vat" :value="__('messages.vat')" />
            <x-text-input wire:model="vat" id="vat" name="vat" type="text" class="mt-1 block w-full" required autofocus autocomplete="vat" />
            <x-input-error class="mt-2" :messages="$errors->get('vat')" />
        </div>

        <div>
            <x-input-label for="street" :value="__('messages.street')" />
            <x-text-input wire:model="street" id="street" name="street" type="text" class="mt-1 block w-full" required autofocus autocomplete="street" />
            <x-input-error class="mt-2" :messages="$errors->get('street')" />
        </div>

        <div>
            <x-input-label for="city" :value="__('messages.city')" />
            <x-text-input wire:model="city" id="city" name="city" type="text" class="mt-1 block w-full" required autofocus autocomplete="city" />
            <x-input-error class="mt-2" :messages="$errors->get('city')" />
        </div>

        <div>
            <x-input-label for="country" :value="__('messages.country')" />
            <x-text-input wire:model="country" id="country" name="country" type="text" class="mt-1 block w-full" required autofocus autocomplete="country" />
            <x-input-error class="mt-2" :messages="$errors->get('country')" />
        </div>

        <div>
            <x-input-label for="postal_code" :value="__('messages.postal_code')" />
            <x-text-input wire:model="postal_code" id="postal_code" name="postal_code" type="text" class="mt-1 block w-full" required autofocus autocomplete="postal_code" />
            <x-input-error class="mt-2" :messages="$errors->get('postal_code')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('messages.email')" />
            <x-text-input wire:model="email" id="email" name="email" type="email" class="mt-1 block w-full" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('messages.email_unverified') }}

                        <button wire:click.prevent="sendVerification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('messages_resent_confirmation') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('messages.verification_link') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('messages.save') }}</x-primary-button>

            <x-action-message class="me-3" on="profile-updated">
                {{ __('messages.saved') }}
            </x-action-message>
        </div>
    </form>
</section>
