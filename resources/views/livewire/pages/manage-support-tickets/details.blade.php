<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ $supportTicket->title }}
      </h2>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white mb-4 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <div class="flex flex-col gap-4 items-start">
              <div class="flex flex-col gap-2 py-4">                
                <h3 class="text-sm font-bold text-gray-500">{{ $supportTicket->user->name }}</h3>
                <div class="bg-gray-100 p-4 rounded-md">
                  <p>{{ $supportTicket->message }}</p>
                </div>
              </div>
            </div>
              @foreach($replies as $reply)
              <div class="flex flex-col gap-4 {{ $reply->user_id === $supportTicket->user_id ? 'items-start' : 'items-end' }}">
                <div class="flex flex-col w-1/2 gap-2 py-4">                
                  <h3 class="text-sm font-bold text-gray-500">{{ $reply->user_id === $supportTicket->user_id ? $reply->user->name : "Support Admin" }}</h3>
                  <div class="bg-gray-100 p-4 rounded-md">
                    <p>{{ $reply->message }}</p>
                  </div>
                </div>
              </div>
              @endforeach
          </div>
        </div>        
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 text-gray-900">
                  
                <form class="" method="post" action="{{ route('user-tickets.reply', ['id' => $supportTicket->id]) }}">
                  @csrf
                  <div class="mb-4">
                    <label for="message" class="block mb-2 text-sm font-medium text-gray-900">{{ __("messages.message") }}</label>
                    <textarea name="message" class="border border-gray-400 text-sm rounded-md block w-full px-2 py-4 h-96 resize-none"></textarea>
                    @error('message')
                        <div class="text-red-600 text-xs">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="flex justify-end gap-4 mt-8">
                    @isset($supportTicket)
                      <input type="hidden" name="id" value="{{ $supportTicket->id }}" />
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
