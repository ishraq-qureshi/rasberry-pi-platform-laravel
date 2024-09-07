<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>DashPI - Platform Tagline</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Nerko+One&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased">
        
        {{-- HEADER --}}
        <header class="px-4 py-4 bg-white fixed top-0 w-full z-10">
          <div class="max-w-[1280px] m-auto">
            <div class="flex justify-between items-center">
              <div class="lg:w-auto w-full">
                <a href="{{ route("home") }}" class="block lg:text-left text-center">
                  <x-application-logo class="block h-9 w-auto fill-current text-gray-800 lg:m-0 m-auto" />
                </a>
              </div>
              <nav class="hidden lg:block">
                <ul class="flex gap-8 items-center">
                  <li>
                    <a class="text-gray-800 hover:text-gray-400 font-medium" href="">{{ __("messages.how_to_connect") }}</a>
                  </li>
                  <li>
                    <a class="text-gray-800 hover:text-gray-400 font-medium" href="">{{ __("messages.features") }}</a>
                  </li>
                  <li>
                    <a class="text-gray-800 hover:text-gray-400 font-medium" href="">{{ __("messages.pricing") }}</a>
                  </li>
                  <li>
                    <a class="text-gray-800 hover:text-gray-400 font-medium" href="">{{ __("messages.contact") }}</a>
                  </li>
                  <li class="flex gap-2">
                    <a class="bg-secondary hover:bg-gray-700 text-white block px-6 py-2 rounded-full font-medium" href="{{ route("register") }}">{{ __("messages.register") }}</a>
                    <a class="bg-primary hover:bg-primaryDark text-white block px-6 py-2 rounded-full font-medium" href="{{ route("login") }}">{{ __("messages.login") }}</a>
                  </li>
                  <li>
                    
                  </li>
                </ul>
              </nav>
            </div>
          </div>
        </header>
        {{-- HEADER --}}


        {{-- HERO SECTION --}}
        <section class="px-4 py-8 h-screen flex items-center bg-no-repeat bg-right-bottom" style="background: url('{{ url("storage/images/character-holding-raspberry-pi.png") }}') no-repeat 80% 100% / 40%">
          <div class="max-w-[1280px] m-auto w-full">
            <div class="flex flex-col lg:max-w-[40%] w-full gap-8">
              <h1 class="md:text-7xl text-6xl text-center lg:text-left font-bold text-secondary font-['Nerko One']">{{ __("messages.hero_title") }}</h1>
              <h3 class="text-xl text-center lg:text-left text-secondary leading-relaxed">{{ __("messages.hero_description") }}</h3>
            </div>
          </div>
        </section>
        {{-- HERO SECTION --}}

        {{-- HOW TO CONNECT --}}
        <section class="px-4 py-16 bg-primary">
          <div class="max-w-[1280px] m-auto">
            <div class="flex flex-col md:gap-20 gap-10">
              <div class="flex flex-col gap-2">
                <h2 class="md:text-5xl text-3xl font-bold text-center text-white font-['Nerko One']">{{ __("messages.how_to_connect") }}</h2>
                <p class="text-xl text-white text-opacity-80 text-center leading-relaxed">{{ __("messages.how_to_contect_description") }}</p>
              </div>
              <div class="flex gap-6 md:flex-row flex-col">
                
                <div class="flex flex-col flex-1 items-center gap-4">
                  <div class="w-16 h-16 flex justify-center items-center rounded-full shadow-lg bg-white">
                    <h3 class="text-3xl font-bold text-secondary">{{ __("messages.step_1") }}</h3>
                  </div>
                  <h3 class="text-2xl text-center font-bold text-white">{{ __("messages.create_account") }}</h3>
                  <p class="text-white text-center text-opacity-80">{{ __("messages.create_account_desc") }}</p>
                </div>

                <div class="flex flex-col flex-1 items-center gap-4">
                  <div class="w-16 h-16 flex justify-center items-center rounded-full bg-white shadow-lg">
                    <h3 class="text-3xl font-bold text-secondary">{{ __("messages.step_2") }}</h3>
                  </div>
                  <h3 class="text-2xl text-center font-bold text-white">{{ __("messages.choose_subscription") }}</h3>
                  <p class="text-white text-center text-opacity-80">{{ __("messages.choose_subscription_desc") }}</p>
                </div>

                <div class="flex flex-col flex-1 items-center gap-4">
                  <div class="w-16 h-16 flex justify-center items-center rounded-full bg-white shadow-lg">
                    <h3 class="text-3xl font-bold text-secondary">{{ __("messages.step_3") }}</h3>
                  </div>
                  <h3 class="text-2xl text-center font-bold text-white">{{ __("messages.connect_your_pi") }}</h3>
                  <p class="text-white text-center text-opacity-80">{{  __("messages.connect_your_pi_desc")}}</p>
                </div>


              </div>
            </div>
          </div>
        </section>
        {{-- HOW TO CONNECT --}}

        {{-- FEATURES --}}
        <section class="px-4 md:py-20 py-10">
          <div class="max-w-[1280px] m-auto">
            <div class="flex flex-col gap-16">
              <div class="flex flex-1 flex-col gap-6">
                <h2 class="md:text-6xl text-3xl text-center font-bold text-secondary leading-tight font-['Nerko One']">{{ __("messages.features_title") }}</h2>
                <p class="text-xl text-center md:max-w-[70%] m-auto text-secondary text-opacity-80 leading-relaxed">{{ __("messages.features_desc") }}</p>
              </div>
              <div class="flex flex-1 flex-col md:gap-4 gap-10">
                
                
                <div class="flex gap-8 md:flex-row flex-col items-center">
                  <div class="flex-1 justify-center w-full md:max-w-[47%]">
                    <img src="storage/images/monitoring-icon.png" class="m-auto md:m-0" alt="montior-icon" width="500"/>
                  </div>
                  <div class="flex flex-col gap-4 flex-1 md:max-w-[47%]">
                    <h2 class="md:text-4xl text-2xl text-secondary font-['Nerko One'] md:text-left text-center font-bold">{{ __("messages.feature1_title") }}</h2>
                    <p class="md:text-xl text-lg leading-normal text-secondary md:text-left text-center text-opacity-70">{{ __("messages.feature1_desc") }}</p>
                  </div>
                </div>


                <div class="flex gap-8 items-center flex-col md:flex-row-reverse">
                  <div class="flex-1 justify-center w-full md:max-w-[47%]">
                    <img src="storage/images/smart-notification-icon.png" alt="montior-icon" class="m-auto md:m-0 max-h-[400px] object-contain" height="400" width="500"/>
                  </div>
                  <div class="flex flex-col gap-4 flex-1 w-full md:max-w-[47%]">
                    <h2 class="md:text-4xl text-2xl text-secondary font-['Nerko One'] md:text-left text-center font-bold">{{ __("messages.feature2_title") }}</h2>
                    <p class="md:text-xl text-lg leading-normal text-secondary md:text-left text-center text-opacity-70">{{ __("messages.feature2_desc") }}</p>
                  </div>
                </div>


                <div class="flex gap-8 flex-col md:flex-row items-center">
                  <div class="flex-1 justify-center w-full md:max-w-[47%]]">
                    <img src="storage/images/device-status-icon.png" alt="montior-icon" class="m-auto md:m-0 max-h-[400px] object-contain" height="400" width="500"/>
                  </div>
                  <div class="flex flex-col gap-4 flex-1 w-full md:max-w-[47%]]">
                    <h2 class="md:text-4xl text-2xl text-secondary font-['Nerko One'] md:text-left text-center font-bold">{{ __("messages.feature3_title") }}</h2>
                    <p class="md:text-xl text-lg leading-normal text-secondary md:text-left text-center text-opacity-70">{{ __("messages.feature3_desc") }}</p>
                  </div>
                </div>


                <div class="flex gap-8 items-center flex-col md:flex-row-reverse">
                  <div class="flex-1 justify-center w-full md:max-w-[47%]]">
                    <img src="storage/images/advance-hardware-icon.png" alt="montior-icon" class="m-auto md:m-0 max-h-[400px] object-contain rounded-lg overflow-hidden" height="400" width="500"/>
                  </div>
                  <div class="flex flex-col gap-4 flex-1 w-full md:max-w-[47%]]">
                    <h2 class="md:text-4xl text-2xl text-secondary font-['Nerko One'] md:text-left text-center font-bold">{{ __("messages.feature4_title") }}</h2>
                    <p class="md:text-xl text-lg leading-normal text-secondary md:text-left text-center text-opacity-70">{{ __("messages.feature4_desc") }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        {{-- FEATURES --}}

        {{-- PRICING --}}
        <section class="px-4 py-16 bg-primary">
          <div class="max-w-[1280px] m-auto">
            <div class="flex flex-col gap-20">
              <div class="flex flex-1 flex-col gap-2">
                <h2 class="md:text-6xl text-3xl text-white text-center font-bold leading-tight font-['Nerko One']">{{ __("messages.pricing_plan_title") }}</h2>
                <p class="text-xl text-white text-center max-w-[70%] m-auto text-opacity-80 leading-relaxed">{{ __("messages.pricing_plan_desc") }}</p>
              </div>
              <div class="flex gap-6 items-stretch flex-wrap lg:flex-nowrap">
                @foreach ($subscriptionPlans as $plan)
                <div class="flex w-full lg:flex-1 lg:max-w-[410px] min-w-[calc(100%/3-20px)] flex-col relative bg-white md:gap-6 gap-4 p-8 rounded-md shadow-md" data-id="{{ $plan->id }}" data-price="{{ $plan->isDiscount ? $plan->discount_price : $plan->price }}">
                  @if($plan->is_trial)
                    <span class="bg-secondary absolute text-white px-4 py-1 text-sm rounded-full font-medium top-[-14px] left-0 right-0 m-auto max-w-[100px] text-center">{{ __("messages.trial_plan") }}</span>                  
                  @endif
                  <h3 class="md:text-3xl text-2xl  text-center text-secondary">{{ $plan->plan_name }}</h3>
                  <div class="flex flex-col items-center">
                    @if($plan->isDiscount && !$plan->is_trial)
                      <h3 class="text-2xl text-gray-400 line-through">€{{ number_format($plan->price, 2) }} </span>
                    @endif
                    @if($plan->is_trial)
                      <h3 class="md:text-6xl text-4xl font-bold  text-secondary font-['Nerko One']">{{ __("messages.free") }} <span class="text-xl text-opacity-40 font-normal">/{{ __("messages.14_days") }}</span></h3>
                    @else
                      <h3 class="md:text-6xl text-4xl font-bold  text-secondary font-['Nerko One']"><sup>€</sup>{{ number_format($plan->isDiscount ? $plan->discount_price : $plan->price, 2) }}<span class="text-xl text-opacity-40 font-normal">/month</span></h3>
                    @endif                        
                  </div>      
                  <div class="flex gap-2 my-4 items-stretch">
                    <div class="flex items-center flex-col gap-2 flex-1">
                      <img src="storage/images/raspberry-pi-icon.png" alt="RaspberryPi Icon" width="40" />
                      <div>
                        <p class="text-sm text-secondary text-opacity-70 text-center">{{ __("messages.allowed_devices") }}</p>
                        <p class="text-2xl text-secondary font-bold text-center">{{ $plan->allowed_rasberry }}</p>
                      </div>
                    </div>
                    @if($plan->allowed_users > 0)
                    <span class="w-[1px] h-full bg-gray-200"></span>
                    <div class="flex flex-col items-center gap-2 flex-1">
                      <img src="storage/images/user-icon.png" alt="RaspberryPi Icon" width="40" />
                      <div>
                        <p class="text-sm text-secondary text-opacity-70 text-center">{{ __("messages.allowed_user") }}</p>
                        <p class="text-2xl text-secondary font-bold text-center">{{ $plan->allowed_users }}</p>
                      </div>
                    </div>
                    @endif
                  </div>       
                  <div class="flex flex-col gap-4 flex-1">
                    <h4 class="text-2xl text-secondary font-medium">{{ __("messages.what_will_get") }}</h4>
                    <ul class="flex flex-col gap-4">
                      @foreach(unserialize($plan->features) as $feature)
                      <li class="flex gap-2 text-opacity-80 text-secondary">
                        <svg class="flex-shrink-0 w-5 h-5 text-green" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                        {{ $feature }}
                      </li>
                      @endforeach
                    </ul>
                  </div>
                  <a href="{{route("register", ["pricing_plan_id" => $plan->id])}}" class="text-center bg-secondary rounded-md hover:bg-opacity-90 text-white px-4 py-4 text-xl font-bold">{{ __("messages.get_started") }}</a>
                </div>
                @endforeach
              </div>
            </div>
          </div>
        </section>
        {{-- PRICING --}}

        {{-- CONTACT --}}
        <section class="px-4 py-16">
          <div class="max-w-[1280px] m-auto">
            <div class="flex flex-col gap-16">
              <div class="flex flex-1 flex-col gap-6">
                <h2 class="md:text-6xl text-3xl text-center font-bold text-secondary leading-tight font-['Nerko One']">{{ __("messages.contact_us_title") }}</h2>
                <p class="text-xl text-center max-w-[70%] m-auto text-secondary text-opacity-80 leading-relaxed">{{ __("messages.contact_us_desc") }}<p>
              </div>
              <div class="flex flex-col gap-8">
                <div class="flex gap-8 md:flex-row flex-col">
                  <div class="flex flex-col gap-2 flex-1">
                    <label class="text-sm text-secondary text-opacity-50">{{ __("messages.full_name") }}</label>
                    <input name="full_name" type="text" class="border border-black border-opacity-20 px-4 py-3 text-lg rounded-md" placeholder="{{ __("messages.full_name_placeholder") }}" />
                  </div>
                  <div class="flex flex-col gap-2 flex-1">
                    <label class="text-sm text-secondary text-opacity-50">{{ __("messages.email") }}</label>
                    <input name="email" type="email" class="border border-black border-opacity-20 px-4 py-3 text-lg rounded-md" placeholder="{{ __("messages.email_placeholder") }}" />
                  </div>
                </div>
                <div class="flex gap-8 md:flex-row flex-col">
                  <div class="flex flex-col gap-2 flex-1">
                    <label class="text-sm text-secondary text-opacity-50">{{ __("messages.phone") }}</label>
                    <input name="phone_number" type="text" class="border border-black border-opacity-20 px-4 py-3 text-lg rounded-md" placeholder="{{ __("messages.phone_placeholder") }}" />
                  </div>
                  <div class="flex flex-col gap-2 flex-1">
                    <label class="text-sm text-secondary text-opacity-50">{{ __("messages.comany_name") }}</label>
                    <input name="company" type="text" class="border border-black border-opacity-20 px-4 py-3 text-lg rounded-md" placeholder="{{ __("messages.company_name_placeholder") }}" />
                  </div>
                </div>
                <div class="flex gap-8 md:flex-row flex-col">
                  <div class="flex flex-col gap-2 flex-1">
                    <label class="text-sm text-secondary text-opacity-50">{{ __("messages.message") }}</label>
                    <textarea class="w-full h-[200px] resize-none border border-black border-opacity-20 px-4 py-3 text-lg rounded-md"></textarea>                    
                  </div>
                </div>
                <div class="flex gap-8 justify-end">
                  <button type="submit" class="bg-secondary text-white px-16 py-3 hover:bg-opacity-90 font-bold text-xl rounded-md">{{ __("submit") }}</button>
                </div>
              </div>
            </div>
          </div>
        </section>
        {{-- CONTACT --}}

        {{-- FOOTER --}}
        <footer>
          <div class="max-w-[1280px] m-auto">
            <p class="px-4 py-4 border-t-2 text-center text-gray-500">{{ __("messages.reserved") }} &copy; <a href="{{route("home")}}">DashPi</a> {{ __("messages.reserved") }}</p>
          </div>
        </footer>
        {{-- FOOTER --}}
    </body>
</html>
