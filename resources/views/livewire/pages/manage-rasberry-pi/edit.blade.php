<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('messages.manage_rasberry_pi') }}
      </h2>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 text-gray-900">
                  
                <form class="" method="post" action="{{ route('rasberry-pi.save') }}">
                  @csrf
                  <div class="mb-4">
                    <label for="pi_name" class="block mb-2 text-sm font-medium text-gray-900">{{ __("messages.name") }}</label>
                    <input type="text" name="pi_name" class="border border-gray-400 text-sm rounded-md block w-full px-2 py-4" placeholder="Enter rasberry pi name" value="{{ isset($rasberryPi) ? $rasberryPi->pi_name : "" }}" />
                    @error('pi_name')
                        <div class="text-red-600 text-xs">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="mb-4">
                    <label for="model" class="block mb-2 text-sm font-medium text-gray-900">{{ __("messages.model") }}</label>
                    <select id="model" name="rasberry_pi_model_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-2 py-4">
                      <option>{{ __("messages.select_model") }}</option>
                      @foreach($models as $model)
                        @php
                          $selected = isset($rasberryPi) && $model->id === $rasberryPi->rasberry_pi_model_id ? "selected" : "";
                        @endphp
                        <option {{ $selected }} value="{{ $model->id }}">{{ $model->model_name }}</option>
                      @endforeach
                    </select>
                    @error('rasberry_pi_model_id')
                        <div class="text-red-600 text-xs">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="flex justify-end gap-4 mt-8">
                    @isset($rasberryPi)
                      <input type="hidden" name="id" value="{{ $rasberryPi->id }}" />
                    @endisset
                    <a href="{{ route('rasberry-pi.view') }}" class="py-2 px-6 bg-red-500 text-white rounded-md">
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
