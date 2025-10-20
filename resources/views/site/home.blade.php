@extends('layouts.app')

@section('content')


  <!-- Hero Section -->
  @include('components.header')

  <!-- News Section -->
  <section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Header -->
      <div class="text-center mb-12">
        <h2 class="text-4xl font-black text-rshp-blue stylized-font mb-2">BERITA TERKINI</h2>
        <p class="text-rshp-dark-gray text-lg">RSHP Latest News</p>
      </div>

      <!-- News Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- Article 1 -->
        <article class="bg-white rounded-lg shadow-lg overflow-hidden">
          <div class="bg-gray-200 h-48 flex items-center justify-center">
            <img class="w-full h-full object-cover"
              src="https://rshp.unair.ac.id/wp-content/uploads/2023/10/20231018_130309-1-150x150.jpg" />
          </div>
          <div class="p-6">
            <h3 class="text-xl font-semibold text-rshp-dark-gray mb-2">
              Kunjungan SMA Islam Terpadu Nurul Fikri Boarding School Bogor
            </h3>
            <p class="text-sm text-gray-500 mb-3">24 October 2023</p>
            <p class="text-rshp-dark-gray mb-4">
              Pada Rabu, 18 Oktober 2023 telah dilaksanakan kunjungan SMA Islam Terpadu Nurul Fikri
              Boarding School Bogor ke RSHP UNAIR. Sebanyak ...
            </p>
            <a href="#" class="text-rshp-blue hover:text-rshp-orange transition-colors font-medium">
              Read more...
            </a>
          </div>
        </article>

        <!-- Article 2 -->
        <article class="bg-white rounded-lg shadow-lg overflow-hidden">
          <div class="bg-gray-200 h-48 flex items-center justify-center">
            <img class="w-full h-full object-cover"
              src="https://rshp.unair.ac.id/wp-content/uploads/2023/10/1696837376228-scaled-e1696838457533-150x150.jpg" />
          </div>
          <div class="p-6">
            <h3 class="text-xl font-semibold text-rshp-dark-gray mb-2">
              Kunjungan WOAH ke RSHP Unair
            </h3>
            <p class="text-sm text-gray-500 mb-3">9 October 2023</p>
            <p class="text-rshp-dark-gray mb-4">
              Pada tanggal 5 Oktober 2023, Rumah Sakit Hewan Pendidikan Universitas Airlangga mendapat
              informasi mendadak permohonan ...
            </p>
            <a href="#" class="text-rshp-blue hover:text-rshp-orange transition-colors font-medium">
              Read more...
            </a>
          </div>
        </article>

        <!-- Article 3 -->
        <article class="bg-white rounded-lg shadow-lg overflow-hidden">
          <div class="bg-gray-200 h-48 flex items-center justify-center">
            <img class="w-full h-full object-cover"
              src="https://rshp.unair.ac.id/wp-content/uploads/2023/10/20231004_180319-150x150.jpg" />
          </div>
          <div class="p-6">
            <h3 class="text-xl font-semibold text-rshp-dark-gray mb-2">
              Vaksin Rabies dan Pameran Hewan
            </h3>
            <p class="text-sm text-gray-500 mb-3">4 October 2023</p>
            <p class="text-rshp-dark-gray mb-4">
              Pada Minggu, 1 Oktober 2023 telah dilaksanakan kegiatan Sehat With Us "Dare to Care. Dare to
              Health" Vaksin Rabies dan Pameran Hewan di ...
            </p>
            <a href="#" class="text-rshp-blue hover:text-rshp-orange transition-colors font-medium">
              Read more...
            </a>
          </div>
        </article>
      </div>
    </div>
  </section>

  <!-- Information Section -->
  <section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        <!-- Left Section -->
        <div
          class="flex flex-col space-y-4 border-2 border-dashed border-black bg-white p-4 rounded-lg h-full relative group cursor-pointer">
          <div class="flex flex-col gap-2 h-full bg-white rounded-lg p-2 shadow-sm">
            <div class="bg-gray-200 rounded flex items-center justify-center">
              <div class="h-full w-full">
                <img src="/praktikum3/img/501529045_1338951710510912_7983829085045102228_n.jpeg"
                  alt="instagram-rshp-unair" class="w-full h-full object-cover" />
              </div>
            </div>
            <div class="flex items-center space-x-1">
              <span class="text-xs text-gray-600">✨PROMO VAKSIN RSHP UNAIR✨<br>
                <span class="font-semibold text-rshp-blue">Promo Vaksin Anjing</span>
                <br>
                <span>Promo DISKON 50% untuk vaksin anjing di RSHP UNAIR!</span>
                <br>
                <span>✅Berlaku untuk Vaksin Eurican 6</span>
                <br>
                <span>✅Periode Promo 25-31 Mei 2025</span>
                <br>
                <span>✅Wajib reservasi by WhatsApp (0858-0633-6433 atau 0822-2909-4131)</span>
                <br>
                <span>✅Kuota terbatas!!!</span>
                <br>
                <span>#RSHPUNAIR</span>
                <br>
                <span>#SMARTSERVICES</span>
                <br>
                <span>#VivaVeteriner</span>
                <br>
                <span>#UNAIRHEBAT</span>
                <br>
                <span>#UNAIR</span>
                <br>
                <span>#ExcellenceWithMorality</span>
                <br>
                <span>#WorldClassUniversity</span>
                <br>
                <span>#SmartUniversity</span>
            </div>
            <div class="mt-2 flex items-center justify-between">
              <div class="flex items-center space-x-1">
                <svg class="w-3 h-3 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                  <path
                    d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                </svg>
                <span class="text-xs text-gray-600">28</span>
              </div>
              <div class="flex items-center space-x-1">
                <svg class="w-3 h-3 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M21.99 4c0-1.1-.89-2-2-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h14l4 4-.01-18z" />
                </svg>
                <span class="text-xs text-gray-600">6</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Right Section - Google Maps -->
        <div class="flex flex-col space-y-4 border-2 border-dashed border-black bg-white p-4 rounded-lg">

          <!-- Information Panel -->
          <div class="bg-white rounded-lg">
            <h3 class="text-lg font-semibold text-rshp-dark-gray mb-2">
              Animal Hospital, Universitas A...
            </h3>
            <p class="text-sm text-gray-600 mb-3">
              Kampus C Universitas Airlangga, Mulyorejo, Kec. Mulyorejo, Surabaya, Jawa Timur 60115
            </p>
            <div class="flex items-center mb-3">
              <div class="flex text-rshp-orange">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                  <path
                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                  </path>
                </svg>
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                  <path
                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                  </path>
                </svg>
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                  <path
                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                  </path>
                </svg>
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                  <path
                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                  </path>
                </svg>
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                  <path
                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                  </path>
                </svg>
              </div>
              <span class="ml-2 text-sm font-semibold">4.4</span>
              <span class="ml-2 text-sm text-gray-600">(1.207 reviews)</span>
            </div>
          </div>

          <!-- Map Display -->
          <div class="flex-1 rounded-lg overflow-hidden">
            <iframe
              src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7915.482022032093!2d112.788135!3d-7.270285!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7fbd40a9784f5%3A0xe756f6ae03eab99!2sAnimal%20Hospital%2C%20Universitas%20Airlangga!5e0!3m2!1sen!2sus!4v1755486601318!5m2!1sen!2sus"
              style="border:0; width: 100%; height: 100%;" allowfullscreen="" loading="lazy"
              referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>

          <!-- Directions Button -->
          <a href="https://www.google.com/maps/place/Animal+Hospital,+Universitas+Airlangga/@-7.270285,112.788135,16z/data=!4m6!3m5!1s0x2dd7fbd40a9784f5:0xe756f6ae03eab99!8m2!3d-7.2702854!4d112.7881346!16s%2Fg%2F1pzpjsyn8?hl=en-US&entry=ttu&g_ep=EgoyMDI1MDgxMy4wIKXMDSoASAFQAw%3D%3D"
            target="_blank"
            class="w-full bg-rshp-blue text-white py-3 px-4 rounded-lg font-semibold hover:bg-blue-700 transition-colors flex items-center justify-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd"
                d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                clip-rule="evenodd"></path>
            </svg>
            Open in Google Maps
          </a>

        </div>
      </div>

      <!-- Bottom Section -->
      <div class="flex justify-center space-x-16 mt-12">
        <a class="cursor-pointer text-2xl font-black text-rshp-blue stylized-font">AGENDA</a>
        <a class="cursor-pointer text-2xl font-black text-rshp-blue stylized-font">EDUKASI</a>
        <a class="cursor-pointer text-2xl font-black text-rshp-blue stylized-font">RISET</a>
        <a class="cursor-pointer text-2xl font-black text-rshp-blue stylized-font">CASE REPORT</a>
      </div>
    </div>
  </section>

  <script>
    // Add any interactive functionality here
    document.addEventListener('DOMContentLoaded', function () {
      // Smooth scrolling for navigation links
      document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
          e.preventDefault();
          const target = document.querySelector(this.getAttribute('href'));
          if (target) {
            target.scrollIntoView({
              behavior: 'smooth'
            });
          }
        });
      });
    });
  </script>

@endsection