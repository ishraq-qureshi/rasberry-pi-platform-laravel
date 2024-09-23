<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('messages.manage_users') }}
      </h2>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 text-gray-900">
                  
                <form class="" method="post" action="{{ route('users.save') }}">
                  @csrf
                  <div class="mb-4">
                    <label for="user_name" class="block mb-2 text-sm font-medium text-gray-900">{{ __("messages.full_name") }}</label>
                    <input type="text" name="user_name" class="border border-gray-400 text-sm rounded-md block w-full px-2 py-4" placeholder="{{ __("messages.full_name_placeholder") }}" value="{{ isset($user) ? $user->name : "" }}" />
                    @error('user_name')
                        <div class="text-red-600 text-xs">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="mb-4">                    
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900">{{ __("messages.email") }}</label>
                    <input type="email" {{ isset($user) ? "disabled" : "" }} name="email" class="border {{ isset($user) ? "bg-gray-200 cursor-not-allowed" : "" }} border-gray-400 text-sm rounded-md block w-full px-2 py-4" placeholder="{{ __("messages.email_placeholder") }}" value="{{ isset($user) ? $user->email : "" }}"/>
                    @error('email')
                        <div class="text-red-600 text-xs">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="mb-4">
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900">{{ __("messages.password") }}</label>
                    <input type="password" name="password" class="border border-gray-400 text-sm rounded-md block w-full px-2 py-4" placeholder="{{ __("messages.password_placeholder") }}"/>
                    @error('password')
                        <div class="text-red-600 text-xs">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="mb-4">
                    <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900">{{ __("messages.confirm_password") }}</label>
                    <input type="password_confirmation" name="password_confirmation" class="border border-gray-400 text-sm rounded-md block w-full px-2 py-4" placeholder="{{ __("messages.confirm_password_placeholder") }}" />
                    @error('password_confirmation')
                        <div class="text-red-600 text-xs">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="mb-4">
                    <label for="surname" class="block mb-2 text-sm font-medium text-gray-900">{{ __("messages.surname") }}</label>
                    <input type="text" name="surname" class="border border-gray-400 text-sm rounded-md block w-full px-2 py-4" placeholder="{{ __("messages.surname_placeholder") }}" value="{{ isset($user) ? $user->surname : "" }}"/>
                    @error('surname')
                        <div class="text-red-600 text-xs">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="mb-4">
                    <label for="telephone" class="block mb-2 text-sm font-medium text-gray-900">{{ __("messages.telephone") }}</label>
                    <input type="text" name="telephone" class="border border-gray-400 text-sm rounded-md block w-full px-2 py-4" placeholder="{{ __("messages.telephone_placeholder") }}" value="{{ isset($user) ? $user->telephone : "" }}"/>
                    @error('telephone')
                        <div class="text-red-600 text-xs">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="mb-4">
                    <label for="billing_address" class="block mb-2 text-sm font-medium text-gray-900">{{ __("messages.billing_address") }}</label>
                    <input type="text" name="billing_address" class="border border-gray-400 text-sm rounded-md block w-full px-2 py-4" placeholder="{{ __("messages.billing_address_placeholder") }}" value="{{ isset($user) ? $user->billing_address : "" }}"/>
                    @error('billing_address')
                        <div class="text-red-600 text-xs">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="mb-4">
                    <label for="postal_address" class="block mb-2 text-sm font-medium text-gray-900">{{ __("messages.postal_address") }}</label>
                    <input type="text" name="postal_address" class="border border-gray-400 text-sm rounded-md block w-full px-2 py-4" placeholder="{{ __("messages.postal_address_placeholder") }}" value="{{ isset($user) ? $user->postal_address : "" }}"/>
                    @error('postal_address')
                        <div class="text-red-600 text-xs">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="mb-4">
                    <label for="company_name" class="block mb-2 text-sm font-medium text-gray-900">{{ __("messages.company_name") }}</label>
                    <input type="text" name="company_name" class="border border-gray-400 text-sm rounded-md block w-full px-2 py-4" placeholder="{{ __("messages.company_name_placeholder") }}" value="{{ isset($user) ? $user->company_name : "" }}"/>
                    @error('company_name')
                        <div class="text-red-600 text-xs">{{ $message }}</div>
                    @enderror
                  </div>
                  @role('superadmin')
                  <div class="mb-4">
                    <label for="subscription_plan" class="block mb-2 text-sm font-medium text-gray-900">{{ __("messages.subscription_plan") }}</label>
                    <select id="subscription_plan" name="subscription_plan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-2 py-4">
                      @foreach($plans as $plan)
                        @php
                          $selected = isset($user) && count($user->subscriptions) > 0 && $plan->id === $user->subscriptions[0]->id ? "selected" : "";
                        @endphp
                        <option {{ $selected }} value="{{ $plan->id }}">{{ $plan->plan_name }}</option>
                      @endforeach
                    </select>
                    @error('subscription_plan')
                        <div class="text-red-600 text-xs">{{ $message }}</div>
                    @enderror
                  </div>
                  @endrole
                  <div class="flex justify-end gap-4 mt-8">
                    @isset($user)
                      <input type="hidden" name="id" value="{{ $user->id }}" />
                    @endisset
                    <a href="{{ route('users.view') }}" class="py-2 px-6 bg-red-500 text-white rounded-md">
                      {{ __("messages.back") }}
                    </a>
                    <button type="submit" class='class="py-2 px-6 bg-black text-white rounded-md'>
                      {{ __("messages.save") }}
                    </button>
                  
                  </div>                  
                </form>

              </div>
          </div>
      </div>
  </div>
  <script>
    jQuery(function(){
      jQuery('input[name=isDiscount]').change(function(){
        jQuery('#discountPrice').toggle();
      })

      // Function to update the visibility of add/remove buttons
      function updateFeatureButtons() {
          const featureRows = $('.featureRow');
          const totalRows = featureRows.length;

          featureRows.each(function (index) {
              const addFeatureBtn = $(this).find('.addFeature');
              const removeFeatureBtn = $(this).find('.removeFeature');

              if (totalRows === 1) {
                  addFeatureBtn.show();
                  removeFeatureBtn.hide();
              } else if (index === totalRows - 1) {
                  addFeatureBtn.show();
                  removeFeatureBtn.show();
              } else {
                  addFeatureBtn.hide();
                  removeFeatureBtn.show();
              }
          });
      }

      // Function to clone a feature row
      function cloneFeatureRow() {
          const newFeatureRow = $('.featureRow').first().clone();
          newFeatureRow.find('input').val(''); // Clear the input value
          newFeatureRow.appendTo('.featureWrapper'); // Append the cloned row
          updateFeatureButtons(); // Update button visibility
      }

      // Function to remove a feature row
      function removeFeatureRow(button) {
          button.closest('.featureRow').remove();
          updateFeatureButtons(); // Update button visibility
      }

      // Event listener for adding a feature
      $(document).on('click', '.addFeature', function () {
          cloneFeatureRow();
      });

      // Event listener for removing a feature
      $(document).on('click', '.removeFeature', function () {
          removeFeatureRow($(this));
      });

      // Initialize button visibility on page load
      updateFeatureButtons();
    })
  </script>
</x-app-layout>
