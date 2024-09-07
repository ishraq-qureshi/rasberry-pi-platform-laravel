<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('messages.manage_rasberry_pi_model') }}
      </h2>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 text-gray-900">
                  
                <form class="" method="post" action="{{ route('rasberry-pi-modal.save') }}" enctype="multipart/form-data">
                  @csrf
                  <div class="mb-4">
                    <label for="model_name" class="block mb-2 text-sm font-medium text-gray-900">{{ __("messages.model_name") }}</label>
                    <input type="text" name="model_name" class="border border-gray-400 text-sm rounded-md block w-full px-2 py-4" placeholder="{{ __("messages.model_name_placeholder") }}" value="{{ isset($model) ? $model->model_name : "" }}" />
                    @error('model_name')
                        <div class="text-red-600 text-xs">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="mb-4">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="small_size">{{ __("messages.model_image") }}</label>
                    <input class="block w-full mb-5 text-xs text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" id="small_size" name="model_image" type="file">
                    @error('model_image')
                        <div class="text-red-600 text-xs">{{ $message }}</div>
                    @enderror
                    @if(isset($model))
                    <div class="flex">
                      <img src="{{ url('storage/model_images/' . $model->model_image) }}" alt="{{ $model->model_name }}" width="300" height="300" />
                    </div>
                    @endif
                  </div>
                  <div class="flex justify-end gap-4 mt-8">
                    @isset($model)
                      <input type="hidden" name="id" value="{{ $model->id }}" />
                    @endisset
                    <a href="{{ route('rasberry-pi-modal.view') }}" class="py-2 px-6 bg-red-500 text-white rounded-md">
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
