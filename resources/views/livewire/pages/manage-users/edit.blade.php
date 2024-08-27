<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Manage Users') }}
      </h2>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 text-gray-900">
                  
                <form class="" method="post" action="{{ route('users.save') }}">
                  @csrf
                  <div class="mb-4">
                    <label for="user_name" class="block mb-2 text-sm font-medium text-gray-900">Full Name</label>
                    <input type="text" name="user_name" class="border border-gray-400 text-sm rounded-md block w-full px-2 py-4" placeholder="Enter full name" value="{{ isset($user) ? $user->name : "" }}" />
                    @error('user_name')
                        <div class="text-red-600 text-xs">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="mb-4">
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                    <input type="email" disabled name="email" class="border bg-gray-200 cursor-not-allowed border-gray-400 text-sm rounded-md block w-full px-2 py-4" placeholder="Enter email" value="{{ isset($user) ? $user->email : "" }}"/>
                    @error('email')
                        <div class="text-red-600 text-xs">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="mb-4">
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password</label>
                    <input type="password" name="password" class="border border-gray-400 text-sm rounded-md block w-full px-2 py-4" placeholder="Enter password"/>
                    @error('password')
                        <div class="text-red-600 text-xs">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="mb-4">
                    <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900">Confirm Password</label>
                    <input type="password_confirmation" name="password_confirmation" class="border border-gray-400 text-sm rounded-md block w-full px-2 py-4" placeholder="Enter confirm password" />
                    @error('password_confirmation')
                        <div class="text-red-600 text-xs">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="flex justify-end gap-4 mt-8">
                    @isset($user)
                      <input type="hidden" name="id" value="{{ $user->id }}" />
                    @endisset
                    <a href="{{ route('users.view') }}" class="py-2 px-6 bg-red-500 text-white rounded-md">
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
