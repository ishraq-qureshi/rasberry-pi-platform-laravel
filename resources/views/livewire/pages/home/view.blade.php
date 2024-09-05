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
              <div>
                <a href="{{ route("home") }}">
                  <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                </a>
              </div>
              <nav>
                <ul class="flex gap-8 items-center">
                  <li>
                    <a class="text-gray-800 hover:text-gray-400 font-medium" href="">How to Connect</a>
                  </li>
                  <li>
                    <a class="text-gray-800 hover:text-gray-400 font-medium" href="">Features</a>
                  </li>
                  <li>
                    <a class="text-gray-800 hover:text-gray-400 font-medium" href="">Pricing</a>
                  </li>
                  <li>
                    <a class="text-gray-800 hover:text-gray-400 font-medium" href="">Contact</a>
                  </li>
                  <li class="flex gap-2">
                    <a class="bg-secondary hover:bg-gray-700 text-white block px-6 py-2 rounded-full font-medium" href="{{ route("register") }}">Register</a>
                    <a class="bg-primary hover:bg-primaryDark text-white block px-6 py-2 rounded-full font-medium" href="{{ route("login") }}">Login</a>
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
            <div class="flex flex-col max-w-[40%] gap-8">
              <h1 class="text-7xl font-bold text-secondary font-['Nerko One']">Managing your IoT solution is easy as PI</h1>
              <h3 class="text-xl text-secondary leading-relaxed">With DashPi, it's never been easier to manage, view, and update your Raspberry Pi computers. Our comprehensive platform puts the power of IoT in your hands, so you can keep doing what you do—but better!</h3>
            </div>
          </div>
        </section>
        {{-- HERO SECTION --}}

        {{-- HOW TO CONNECT --}}
        <section class="px-4 py-16 bg-primary">
          <div class="max-w-[1280px] m-auto">
            <div class="flex flex-col gap-20">
              <div class="flex flex-col gap-2">
                <h2 class="text-5xl font-bold text-center text-white font-['Nerko One']">How To Connect?</h2>
                <p class="text-xl text-white text-opacity-80 text-center leading-relaxed">Wondering how DashPI works? Check out the details below.</p>
              </div>
              <div class="flex gap-6">
                
                <div class="flex flex-col flex-1 items-center gap-4">
                  <div class="w-16 h-16 flex justify-center items-center rounded-full shadow-lg bg-white">
                    <h3 class="text-3xl font-bold text-secondary">1</h3>
                  </div>
                  <h3 class="text-2xl text-center font-bold text-white">Create An Account</h3>
                  <p class="text-white text-center text-opacity-80">Register your account on the platform by filling the required fields</p>
                </div>

                <div class="flex flex-col flex-1 items-center gap-4">
                  <div class="w-16 h-16 flex justify-center items-center rounded-full bg-white shadow-lg">
                    <h3 class="text-3xl font-bold text-secondary">2</h3>
                  </div>
                  <h3 class="text-2xl text-center font-bold text-white">Choose Subscription Plan</h3>
                  <p class="text-white text-center text-opacity-80">Choose your subscription plan according to your requirements or select a 14 days trial plan to explore the platform.</p>
                </div>

                <div class="flex flex-col flex-1 items-center gap-4">
                  <div class="w-16 h-16 flex justify-center items-center rounded-full bg-white shadow-lg">
                    <h3 class="text-3xl font-bold text-secondary">3</h3>
                  </div>
                  <h3 class="text-2xl text-center font-bold text-white">Connect Your PI</h3>
                  <p class="text-white text-center text-opacity-80">Register your device to your account and connet your pi with automate or manual process, It will be listed on your dashboard.</p>
                </div>


              </div>
            </div>
          </div>
        </section>
        {{-- HOW TO CONNECT --}}

        {{-- FEATURES --}}
        <section class="px-4 py-20">
          <div class="max-w-[1280px] m-auto">
            <div class="flex flex-col gap-16">
              <div class="flex flex-1 flex-col gap-6">
                <h2 class="text-6xl text-center font-bold text-secondary leading-tight font-['Nerko One']">What Features You Will Be Using</h2>
                <p class="text-xl text-center max-w-[70%] m-auto text-secondary text-opacity-80 leading-relaxed">DashPI integrates device management, notifications, and analytics into a single, slick, and comprehensive package allowing you to manage your Raspberry Pi computers with unparalleled efficiency. Learn more about our features now!</p>
              </div>
              <div class="flex flex-1 flex-col gap-4">
                
                
                <div class="flex gap-8 items-center">
                  <div class="flex-1 justify-center max-w-[47%]">
                    <img src="storage/images/monitoring-icon.png" alt="montior-icon" width="500"/>
                  </div>
                  <div class="flex flex-col gap-4 flex-1 max-w-[47%]">
                    <h2 class="text-4xl text-secondary font-['Nerko One'] font-bold">Simplified Device Uptime Monitoring</h2>
                    <p class="text-xl leading-normal text-secondary text-opacity-70">Our streamlined user interface lets you quickly see which Raspberry Pi computers are online and offline, and keep an eye on their alerts all in a single, high-level view.</p>
                  </div>
                </div>


                <div class="flex gap-8 items-center flex-row-reverse">
                  <div class="flex-1 justify-center max-w-[47%]">
                    <img src="storage/images/smart-notification-icon.png" alt="montior-icon" class="max-h-[400px] object-contain" height="400" width="500"/>
                  </div>
                  <div class="flex flex-col gap-4 flex-1 max-w-[47%]">
                    <h2 class="text-4xl text-secondary font-['Nerko One'] font-bold">Smart Notifications</h2>
                    <p class="text-xl leading-normal text-secondary text-opacity-70">DashPI will keep you informed of important events happening on your Pi device. You'll be informed of storage, cpu, temperature events and more! Coming soon, you'll be able to send your own notifications without using an API!</p>
                  </div>
                </div>


                <div class="flex gap-8 items-center">
                  <div class="flex-1 justify-center max-w-[47%]">
                    <img src="storage/images/device-status-icon.png" alt="montior-icon" class="max-h-[400px] object-contain" height="400" width="500"/>
                  </div>
                  <div class="flex flex-col gap-4 flex-1 max-w-[47%]">
                    <h2 class="text-4xl text-secondary font-['Nerko One'] font-bold">At-A-Glance Device Status Overviews</h2>
                    <p class="text-xl leading-normal text-secondary text-opacity-70">It's never been easier to check in on the vitals of your Raspberry Pi computers. Get a quick look at important information like uptime, network connectivity, and more!</p>
                  </div>
                </div>


                <div class="flex gap-8 items-center flex-row-reverse">
                  <div class="flex-1 justify-center max-w-[47%]">
                    <img src="storage/images/advance-hardware-icon.png" alt="montior-icon" class="max-h-[400px] object-contain rounded-lg overflow-hidden" height="400" width="500"/>
                  </div>
                  <div class="flex flex-col gap-4 flex-1 max-w-[47%]">
                    <h2 class="text-4xl text-secondary font-['Nerko One'] font-bold">Advanced Hardware Monitoring</h2>
                    <p class="text-xl leading-normal text-secondary text-opacity-70">You can monitor the hardware status of each Pi device individually, with information such as available RAM, current CPU usage, storage, and other detail about connected devices.</p>
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
                <h2 class="text-6xl text-white text-center font-bold leading-tight font-['Nerko One']">Pricing Plans</h2>
                <p class="text-xl text-white text-center max-w-[70%] m-auto text-opacity-80 leading-relaxed">Simple, straightforward pricing</p>
              </div>
              <div class="flex gap-6 items-stretch">
                @foreach ($subscriptionPlans as $plan)
                <div class="flex flex-1 flex-col relative bg-white gap-6 p-8 rounded-md shadow-md" data-id="{{ $plan->id }}" data-price="{{ $plan->isDiscount ? $plan->discount_price : $plan->price }}">
                  @if($plan->is_trial)
                    <span class="bg-secondary absolute text-white px-4 py-1 text-sm rounded-full font-medium top-[-14px] left-0 right-0 m-auto max-w-[100px] text-center">Trial Plan</span>                  
                  @endif
                  <h3 class="text-3xl text-center text-secondary">{{ $plan->plan_name }}</h3>
                  <div class="flex flex-col items-center">
                    @if($plan->isDiscount && !$plan->is_trial)
                      <h3 class="text-2xl text-gray-400 line-through">€{{ number_format($plan->price, 2) }} </span>
                    @endif
                    @if($plan->is_trial)
                      <h3 class="text-6xl font-bold  text-secondary font-['Nerko One']">Free <span class="text-xl text-opacity-40 font-normal">/14 days</span></h3>
                    @else
                      <h3 class="text-6xl font-bold  text-secondary font-['Nerko One']"><sup>€</sup>{{ number_format($plan->isDiscount ? $plan->discount_price : $plan->price, 2) }}<span class="text-xl text-opacity-40 font-normal">/month</span></h3>
                    @endif                        
                  </div>      
                  <div class="flex gap-2 my-4 items-stretch">
                    <div class="flex items-center flex-col gap-2 flex-1">
                      <img src="storage/images/raspberry-pi-icon.png" alt="RaspberryPi Icon" width="40" />
                      <div>
                        <p class="text-sm text-secondary text-opacity-70 text-center">Allowed Devices</p>
                        <p class="text-2xl text-secondary font-bold text-center">{{ $plan->allowed_rasberry }}</p>
                      </div>
                    </div>
                    @if($plan->allowed_users > 0)
                    <span class="w-[1px] h-full bg-gray-200"></span>
                    <div class="flex flex-col items-center gap-2 flex-1">
                      <img src="storage/images/user-icon.png" alt="RaspberryPi Icon" width="40" />
                      <div>
                        <p class="text-sm text-secondary text-opacity-70 text-center">Allowed Users</p>
                        <p class="text-2xl text-secondary font-bold text-center">{{ $plan->allowed_users }}</p>
                      </div>
                    </div>
                    @endif
                  </div>       
                  <div class="flex flex-col gap-4 flex-1">
                    <h4 class="text-2xl text-secondary font-medium">What You Will Get:</h4>
                    <ul class="flex flex-col gap-4">
                      @foreach(unserialize($plan->features) as $feature)
                      <li class="flex gap-2 text-opacity-80 text-secondary">
                        <svg class="flex-shrink-0 w-5 h-5 text-green" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                        {{ $feature }}
                      </li>
                      @endforeach
                    </ul>
                  </div>
                  <a href="{{route("register", ["pricing_plan_id" => $plan->id])}}" class="text-center bg-secondary rounded-md hover:bg-opacity-90 text-white px-4 py-4 text-xl font-bold">Get Started</a>
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
                <h2 class="text-6xl text-center font-bold text-secondary leading-tight font-['Nerko One']">Contact Us</h2>
                <p class="text-xl text-center max-w-[70%] m-auto text-secondary text-opacity-80 leading-relaxed">Have Questions? We're Just a Message Away!<p>
              </div>
              <div class="flex flex-col gap-8">
                <div class="flex gap-8">
                  <div class="flex flex-col gap-2 flex-1">
                    <label class="text-sm text-secondary text-opacity-50">Full Name</label>
                    <input name="full_name" type="text" class="border border-black border-opacity-20 px-4 py-3 text-lg rounded-md" placeholder="Enter your full name" />
                  </div>
                  <div class="flex flex-col gap-2 flex-1">
                    <label class="text-sm text-secondary text-opacity-50">Email</label>
                    <input name="email" type="email" class="border border-black border-opacity-20 px-4 py-3 text-lg rounded-md" placeholder="Enter your email address" />
                  </div>
                </div>
                <div class="flex gap-8">
                  <div class="flex flex-col gap-2 flex-1">
                    <label class="text-sm text-secondary text-opacity-50">Phone Number</label>
                    <input name="phone_number" type="text" class="border border-black border-opacity-20 px-4 py-3 text-lg rounded-md" placeholder="Enter your phone number" />
                  </div>
                  <div class="flex flex-col gap-2 flex-1">
                    <label class="text-sm text-secondary text-opacity-50">Company</label>
                    <input name="company" type="text" class="border border-black border-opacity-20 px-4 py-3 text-lg rounded-md" placeholder="Enter your company" />
                  </div>
                </div>
                <div class="flex gap-8">
                  <div class="flex flex-col gap-2 flex-1">
                    <label class="text-sm text-secondary text-opacity-50">Message</label>
                    <textarea class="w-full h-[200px] resize-none border border-black border-opacity-20 px-4 py-3 text-lg rounded-md"></textarea>                    
                  </div>
                </div>
                <div class="flex gap-8 justify-end">
                  <button type="submit" class="bg-secondary text-white px-16 py-3 hover:bg-opacity-90 font-bold text-xl rounded-md">Submit</button>
                </div>
              </div>
            </div>
          </div>
        </section>
        {{-- CONTACT --}}

        {{-- FOOTER --}}
        <footer>
          <div class="max-w-[1280px] m-auto">
            <p class="px-4 py-4 border-t-2 text-center text-gray-500">Copyright &copy; <a href="{{route("home")}}">DashPi</a> 2024. All Rights Reserved</p>
          </div>
        </footer>
        {{-- FOOTER --}}
    </body>
</html>
