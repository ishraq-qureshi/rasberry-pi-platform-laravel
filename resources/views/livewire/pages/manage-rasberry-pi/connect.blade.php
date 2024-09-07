<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Connect Your Rasberry Pi') }}
      </h2>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div>
          <ul class="text-sm font-medium text-center text-gray-500 rounded-lg shadow sm:flex">
            <li class="w-full focus-within:z-10">
                <a href="#automateTab" class="tab-item inline-block w-full p-4 text-gray-900 bg-gray-100 border-r border-gray-200 rounded-s-lg focus:ring-4 focus:ring-blue-300 active focus:outline-none" aria-current="page">{{ __('messages.automate') }}</a>
            </li>
            <li class="w-full focus-within:z-10">
                <a href="#manualTab" class="tab-item inline-block w-full p-4 bg-white border-r border-gray-200 hover:text-gray-700 hover:bg-gray-50 focus:ring-4 focus:ring-blue-300 focus:outline-none">{{ __("messages.manual") }}</a>
            </li>
          </ul>
        </div>
        <div class="flex flex-col gap-4 tab-content" id="automateTab">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">              
            <div class="block w-full p-6 bg-white border border-gray-200 rounded-lg shadow">
              <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">{{ __("messages.execute_curl_request") }}</h5>
              <p class="font-normal text-gray-700 dark:text-gray-400">{{ __("messages.execute_curl_request_desc") }}</p>
              <div class="px-3 py-2">
                <pre class="language-python"><code class="text-sm">curl -fsSL {{ env("APP_URL") }}/setup-rasberry-pi/{{ $rasberryPi->token->token }} | bash</code></pre>
              </div>
            </div>
          </div>
        </div>
        <div class="flex flex-col gap-4 hidden tab-content" id="manualTab">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">              
              <div class="block w-full p-6 bg-white border border-gray-200 rounded-lg shadow">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">{{ __("messages.create_python_file") }}</h5>
                <p class="font-normal text-gray-700 dark:text-gray-400">{{ __("messages.create_python_file_desc_1") }} <span class="font-bold text-black underline">(connection.py)</span> is in the desired location. For example, let's assume it's located in <span class="font-bold text-black underline">/home/pi/scripts/connection.py</span>.</p>
                <div class="px-3 py-2">
                  <pre class="language-python"><code class="text-sm">import requests
import json
import psutil
import subprocess
import shutil
import time
import os
from datetime import datetime

# Fonction pour envoyer les informations au serveur WordPress
def send_data():
    url = '{{ env('APP_URL') }}/post-rasberry-data/{{ $rasberryPi->id }}'

    # Obtention des informations système
    cpu_usage = psutil.cpu_percent()
    ram = psutil.virtual_memory()
    ram_usage = ram.percent

    # Température (lecture depuis le fichier système)
    with open('/sys/class/thermal/thermal_zone0/temp', 'r') as f:
        temperature = int(f.read()) / 1000  # Convertir en Celsius

    # Espace de stockage disponible
    disk_usage = shutil.disk_usage('/')

    # Calcul de l'utilisation de l'espace de stockage en pourcentage
    storage_usage_percent = (disk_usage.used / disk_usage.total) * 100

    # Numéro de série du Raspberry Pi
    serial_number = get_serial_number()

    # Modèle du Raspberry Pi
    model = subprocess.check_output(['cat', '/proc/device-tree/model']).decode('utf-8').strip()

    # Adresse IP LAN
    ip_address_lan = subprocess.check_output(['hostname', '-I']).decode('utf-8').split()[0]

    # Adresse IP WLAN
    ip_address_wlan = None
    try:
        # Vérifier si une connexion Internet est possible via l'interface WLAN
        response = subprocess.run(['ping', '-c', '1', '-W', '1', '8.8.8.8'], stdout=subprocess.PIPE)
        if response.returncode == 0:
            # Si la connexion est possible, obtenir l'adresse IP WLAN
            ip_address_wlan = subprocess.check_output(['hostname', '-I']).decode('utf-8').split()[0]
    except Exception as e:
        print(f"Failed to get WLAN IP address: {str(e)}")

    # Date et heure de la dernière mise à jour
    last_update = datetime.now().strftime("%Y-%m-%d %H:%M:%S")

    # Construction du payload
    payload = {
        'serial_number': serial_number,
        'cpu_usage': f'{cpu_usage}%',
        'ram_usage': f'{ram_usage}%',
        'temperature': f'{temperature}°C',
        'model': model,
        'ip_address_lan': ip_address_lan,
        'ip_address_wlan': ip_address_wlan,
        'storage_usage': f'{storage_usage_percent:.2f}%',
        'last_update': last_update,
        'disk_usage_total': disk_usage.total,
        'disk_usage_used': disk_usage.used,
    }

    # Envoi de la requête POST
    try:
        response = requests.post(url, json=payload)
        if response.status_code == 200:
            print("Data sent successfully.")
        else:
            print(f"Failed to send data. Error code: {response.status_code}")
    except Exception as e:
        print(f"An error occurred: {str(e)}")

# Fonction pour récupérer le numéro de série du Raspberry Pi
def get_serial_number():
    serial_number = None
    try:
        with open('/proc/cpuinfo', 'r') as f:
            for line in f:
                if line.startswith('Serial'):
                    serial_number = line.split(':')[1].strip()
                    break
    except Exception as e:
        print(f"Failed to get serial number: {str(e)}")
    return serial_number

if __name__ == "__main__":
  send_data()</code></pre>
                </div>
              </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">              
              <div class="block w-full p-6 bg-white border border-gray-200 rounded-lg shadow">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">{{ __("messages.create_shell_script") }}</h5>
                <p class="font-normal text-gray-700 dark:text-gray-400">{{ __("messages.create_shell_script_desc") }}</p>
                <p class="font-normal text-gray-700 dark:text-gray-400">{{ __("messages.create_shell_script") }}, <span class="font-bold text-black underline">run_connection.sh</span>, {{ __("messages.create_shell_script_2") }}</p>
                <div class="px-3 py-2">
                  <pre class="language-python"><code class="text-sm">#!/bin/bash
while true
do
  python3 /home/pi/scripts/connection.py
  sleep 5
done</code></pre>
                </div>
                <p class="font-normal text-gray-700 dark:text-gray-400">{{ __("messages.create_shell_script_desc_2") }}</p>
                <p class="font-normal text-gray-700 dark:text-gray-400">{{ __("messages.create_shell_script_desc_3") }}</p>
              </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">              
              <div class="block w-full p-6 bg-white border border-gray-200 rounded-lg shadow">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">{{ __("messages.shell_script_executable") }}</h5>
                <p class="font-normal text-gray-700 dark:text-gray-400">{{ __("messages.shell_script_executable_desc") }}</p>
                <div class="px-3 py-2">
                  <pre class="language-python"><code class="text-sm">chmod +x /home/pi/scripts/run_connection.sh</code></pre>
                </div>
              </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">              
              <div class="block w-full p-6 bg-white border border-gray-200 rounded-lg shadow">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">{{ __("messages.create_cron_job") }}</h5>
                <p class="font-normal text-gray-700 dark:text-gray-400">{{ __("messages.create_cron_job_desc") }}</p>
                <div class="px-3 py-2">
                  <pre class="language-python"><code class="text-sm">crontab -e</code></pre>
                </div>
                <p class="font-normal text-gray-700 dark:text-gray-400">{{ __("messages.create_cron_job_desc_2") }}</p>
                <div class="px-3 py-2">
                  <pre class="language-python"><code class="text-sm">@reboot /home/pi/scripts/run_connection.sh</code></pre>
                </div>
                <p class="font-normal text-gray-700 dark:text-gray-400">{{ __("messages.create_cron_job_desc_3") }} <span class="font-bold text-black underline">run_connection.sh</span> {{ __("messages.create_cron_job_desc_4") }} <span class="font-bold text-black underline">connection.py</span> {{ __("messages.create_cron_job_desc_5") }}</p>
              </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">              
              <div class="block w-full p-6 bg-white border border-gray-200 rounded-lg shadow">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">{{ __("messages.reboot_rasberry_pi") }}</h5>
                <p class="font-normal text-gray-700 dark:text-gray-400">{{ __("messages.reboot_rasberry_pi_desc") }}</p>
                <div class="px-3 py-2">
                  <pre class="language-python"><code class="text-sm">sudo reboot</code></pre>
                </div>
              </div>
            </div>
          </div>
      </div>
  </div>

  <script>
    jQuery(function(){
      jQuery(".tab-item").click(function(e){
        e.preventDefault();
        const tabID = jQuery(this).attr('href');
        jQuery('.tab-content').hide();
        jQuery(tabID).show();
      })
    })
  </script>
</x-app-layout>
