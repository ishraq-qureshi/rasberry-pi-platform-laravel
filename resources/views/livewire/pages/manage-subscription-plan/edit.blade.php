<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Manage Subscription Plans') }}
      </h2>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 text-gray-900">
                  
                <form class="" method="post" action="{{ route('subscription-plans.save') }}">
                  @csrf
                  <div class="mb-4">
                    <label for="plan_name" class="block mb-2 text-sm font-medium text-gray-900">Plan Name</label>
                    <input type="text" name="plan_name" class="border border-gray-400 text-sm rounded-md block w-full px-2 py-4" placeholder="Enter plan name" value="{{ isset($plan) ? $plan->plan_name : "" }}" />
                    @error('plan_name')
                        <div class="text-red-600 text-xs">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="mb-4">
                    <label for="price" class="block mb-2 text-sm font-medium text-gray-900">Price</label>
                    <input type="number" name="price" class="border border-gray-400 text-sm rounded-md block w-full px-2 py-4" placeholder="Enter plan price" value="{{ isset($plan) ? $plan->price : "" }}"/>
                    @error('price')
                        <div class="text-red-600 text-xs">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="mb-4">
                    <label for="allowed_rasberry" class="block mb-2 text-sm font-medium text-gray-900">Allowed Rasberry Pi</label>
                    <input type="number" name="allowed_rasberry" class="border border-gray-400 text-sm rounded-md block w-full px-2 py-4" placeholder="Enter plan allowed rasberry pi" value="{{ isset($plan) ? $plan->allowed_rasberry : "" }}"/>
                    @error('allowed_rasberry')
                        <div class="text-red-600 text-xs">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="mb-4">
                    <label for="allowed_users" class="block mb-2 text-sm font-medium text-gray-900">Allowed Sub Admins</label>
                    <input type="number" name="allowed_users" class="border border-gray-400 text-sm rounded-md block w-full px-2 py-4" placeholder="Enter plan allowed sub admins" value="{{ isset($plan) ? $plan->allowed_users : "" }}"/>
                    @error('allowed_users')
                        <div class="text-red-600 text-xs">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="mb-4 flex items-center gap-8">
                    <div>
                      <label for="isDiscount" class="inline-flex items-center">
                        <input name="isDiscount" value="1" id="isDiscount" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ isset($plan) && $plan->isDiscount ? "checked" : "" }}>
                        <span class="ms-2 text-sm text-gray-600">{{ __('Is Discount?') }}</span>
                      </label>
                      @error('isDiscount')
                          <div class="text-red-600 text-xs">{{ $message }}</div>
                      @enderror
                    </div>
                    <div>
                      <label for="is_trial" class="inline-flex items-center">
                        <input name="is_trial" value="1" id="is_trial" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ isset($plan) && $plan->is_trial ? "checked" : "" }}>
                        <span class="ms-2 text-sm text-gray-600">{{ __('Trial Plan?') }} <small>(Trial plan will be active for 14 days only and only one can be selected as trial at a time)</small></span>
                      </label>
                      @error('is_trial')
                          <div class="text-red-600 text-xs">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  <div class="mb-4 {{ isset($plan) && $plan->isDiscount ? "" : "hidden" }}" id="discountPrice">
                    <label for="discount_price" class="block mb-2 text-sm font-medium text-gray-900">Discount Price</label>
                    <input type="number" name="discount_price" class="border border-gray-400 text-sm rounded-md block w-full px-2 py-4" placeholder="Enter plan price" value="{{ isset($plan) ? $plan->discount_price : "" }}"/>
                    @error('discount_price')
                        <div class="text-red-600 text-xs">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="mb-4 ">
                    <label for="features" class="block mb-2 text-sm font-medium text-gray-900">Features</label>
                    <div class="flex flex-col gap-3 featureWrapper">
                      @if(isset($plan) && $plan->features)
                        @foreach(unserialize( $plan->features ) as $feature)
                          <div class="flex gap-4 featureRow">
                            <input type="text" name="features[]" class="border border-gray-400 text-sm rounded-md block w-full px-2 py-4" placeholder="Enter your feature" value="{{ $feature }}"/>
                            <div class="flex gap-2">
                              <button class="addFeature" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20" viewBox="0 0 128 128">
                                  <path d="M 64 6.0507812 C 49.15 6.0507812 34.3 11.7 23 23 C 0.4 45.6 0.4 82.4 23 105 C 34.3 116.3 49.2 122 64 122 C 78.8 122 93.7 116.3 105 105 C 127.6 82.4 127.6 45.6 105 23 C 93.7 11.7 78.85 6.0507812 64 6.0507812 z M 64 12 C 77.3 12 90.600781 17.099219 100.80078 27.199219 C 121.00078 47.499219 121.00078 80.500781 100.80078 100.80078 C 80.500781 121.10078 47.500781 121.10078 27.300781 100.80078 C 7.0007813 80.500781 6.9992188 47.499219 27.199219 27.199219 C 37.399219 17.099219 50.7 12 64 12 z M 64 42 C 62.3 42 61 43.3 61 45 L 61 61 L 45 61 C 43.3 61 42 62.3 42 64 C 42 65.7 43.3 67 45 67 L 61 67 L 61 83 C 61 84.7 62.3 86 64 86 C 65.7 86 67 84.7 67 83 L 67 67 L 83 67 C 84.7 67 86 65.7 86 64 C 86 62.3 84.7 61 83 61 L 67 61 L 67 45 C 67 43.3 65.7 42 64 42 z"></path>
                                </svg>
                              </button>
                              <button class="removeFeature hidden" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20" viewBox="0 0 24 24">
                                  <path d="M 10 2 L 9 3 L 3 3 L 3 5 L 4.109375 5 L 5.8925781 20.255859 L 5.8925781 20.263672 C 6.023602 21.250335 6.8803207 22 7.875 22 L 16.123047 22 C 17.117726 22 17.974445 21.250322 18.105469 20.263672 L 18.107422 20.255859 L 19.890625 5 L 21 5 L 21 3 L 15 3 L 14 2 L 10 2 z M 6.125 5 L 17.875 5 L 16.123047 20 L 7.875 20 L 6.125 5 z"></path>
                                </svg>
                              </button>
                            </div>
                          </div>
                        @endforeach
                      @else
                        <div class="flex gap-4 featureRow">
                          <input type="text" name="features[]" class="border border-gray-400 text-sm rounded-md block w-full px-2 py-4" placeholder="Enter your feature" />
                          <div class="flex gap-2">
                            <button class="addFeature" type="button">
                              <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20" viewBox="0 0 128 128">
                                <path d="M 64 6.0507812 C 49.15 6.0507812 34.3 11.7 23 23 C 0.4 45.6 0.4 82.4 23 105 C 34.3 116.3 49.2 122 64 122 C 78.8 122 93.7 116.3 105 105 C 127.6 82.4 127.6 45.6 105 23 C 93.7 11.7 78.85 6.0507812 64 6.0507812 z M 64 12 C 77.3 12 90.600781 17.099219 100.80078 27.199219 C 121.00078 47.499219 121.00078 80.500781 100.80078 100.80078 C 80.500781 121.10078 47.500781 121.10078 27.300781 100.80078 C 7.0007813 80.500781 6.9992188 47.499219 27.199219 27.199219 C 37.399219 17.099219 50.7 12 64 12 z M 64 42 C 62.3 42 61 43.3 61 45 L 61 61 L 45 61 C 43.3 61 42 62.3 42 64 C 42 65.7 43.3 67 45 67 L 61 67 L 61 83 C 61 84.7 62.3 86 64 86 C 65.7 86 67 84.7 67 83 L 67 67 L 83 67 C 84.7 67 86 65.7 86 64 C 86 62.3 84.7 61 83 61 L 67 61 L 67 45 C 67 43.3 65.7 42 64 42 z"></path>
                              </svg>
                            </button>
                            <button class="removeFeature hidden" type="button">
                              <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20" viewBox="0 0 24 24">
                                <path d="M 10 2 L 9 3 L 3 3 L 3 5 L 4.109375 5 L 5.8925781 20.255859 L 5.8925781 20.263672 C 6.023602 21.250335 6.8803207 22 7.875 22 L 16.123047 22 C 17.117726 22 17.974445 21.250322 18.105469 20.263672 L 18.107422 20.255859 L 19.890625 5 L 21 5 L 21 3 L 15 3 L 14 2 L 10 2 z M 6.125 5 L 17.875 5 L 16.123047 20 L 7.875 20 L 6.125 5 z"></path>
                              </svg>
                            </button>
                          </div>
                        </div>
                      @endif
                    </div>
                  </div>
                  <div class="flex justify-end gap-4 mt-8">
                    @isset($plan)
                      <input type="hidden" name="id" value="{{ $plan->id }}" />
                    @endisset
                    <a href="{{ route('subscription-plans.view') }}" class="py-2 px-6 bg-red-500 text-white rounded-md">
                      Back
                    </a>
                    <button type="submit" class='class="py-2 px-6 bg-black text-white rounded-md'>
                      Save
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
