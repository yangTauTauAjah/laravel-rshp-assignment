@extends('layouts.app')

@section('title', 'Kontak - RSHP UNAIR')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-rshp-blue to-rshp-light-blue text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">Hubungi Kami</h1>
        <p class="text-xl text-blue-100 max-w-3xl mx-auto">
            Kami siap membantu dan melayani kebutuhan kesehatan hewan kesayangan Anda. Jangan ragu untuk menghubungi kami kapan saja.
        </p>
    </div>
</section>

<!-- Contact Information -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Contact Info -->
            <div>
                <h2 class="text-3xl font-bold text-rshp-dark-gray mb-8">Informasi Kontak</h2>
                
                <!-- Contact Cards -->
                <div class="space-y-6">
                    <!-- Address -->
                    <div class="bg-blue-50 p-6 rounded-lg shadow-sm">
                        <div class="flex items-start">
                            <div class="bg-rshp-blue p-3 rounded-lg mr-4">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-rshp-dark-gray mb-2">Alamat</h3>
                                <p class="text-gray-600">
                                    Kampus C Universitas Airlangga<br>
                                    Jl. Mulyorejo, Kec. Mulyorejo<br>
                                    Surabaya, Jawa Timur 60115<br>
                                    Indonesia
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Phone -->
                    <div class="bg-green-50 p-6 rounded-lg shadow-sm">
                        <div class="flex items-start">
                            <div class="bg-rshp-green p-3 rounded-lg mr-4">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-rshp-dark-gray mb-2">Telepon</h3>
                                <p class="text-gray-600 mb-1">
                                    <a href="tel:0858-0633-6433" class="hover:text-rshp-blue">
                                        0858-0633-6433 (WhatsApp)
                                    </a>
                                </p>
                                <p class="text-gray-600">
                                    <a href="tel:0822-2909-4131" class="hover:text-rshp-blue">
                                        0822-2909-4131 (WhatsApp)
                                    </a>
                                </p>
                                <p class="text-sm text-gray-500 mt-2">Layanan darurat 24 jam</p>
                            </div>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="bg-yellow-50 p-6 rounded-lg shadow-sm">
                        <div class="flex items-start">
                            <div class="bg-rshp-yellow p-3 rounded-lg mr-4">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-rshp-dark-gray mb-2">Email</h3>
                                <p class="text-gray-600">
                                    <a href="mailto:info@rshp.unair.ac.id" class="hover:text-rshp-blue">
                                        info@rshp.unair.ac.id
                                    </a>
                                </p>
                                <p class="text-sm text-gray-500 mt-2">Respon dalam 24 jam</p>
                            </div>
                        </div>
                    </div>

                    <!-- Operating Hours -->
                    <div class="bg-orange-50 p-6 rounded-lg shadow-sm">
                        <div class="flex items-start">
                            <div class="bg-rshp-orange p-3 rounded-lg mr-4">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-rshp-dark-gray mb-2">Jam Operasional</h3>
                                <div class="text-gray-600 space-y-1">
                                    <p><span class="font-medium">Senin - Jumat:</span> 08:00 - 17:00 WIB</p>
                                    <p><span class="font-medium">Sabtu:</span> 08:00 - 15:00 WIB</p>
                                    <p><span class="font-medium">Minggu:</span> 08:00 - 12:00 WIB</p>
                                    <p class="text-red-600 font-medium mt-2">Darurat: 24 jam</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Social Media -->
                <div class="mt-8">
                    <h3 class="text-xl font-semibold text-rshp-dark-gray mb-4">Ikuti Kami</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="bg-blue-600 text-white p-3 rounded-lg hover:bg-blue-700 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                            </svg>
                        </a>
                        <a href="#" class="bg-blue-800 text-white p-3 rounded-lg hover:bg-blue-900 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/>
                            </svg>
                        </a>
                        <a href="#" class="bg-pink-600 text-white p-3 rounded-lg hover:bg-pink-700 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.120.112.225.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.754-1.378l-.749 2.848c-.269 1.045-1.004 2.352-1.498 3.146 1.123.345 2.306.535 3.55.535 6.624 0 11.99-5.367 11.99-11.987C24.007 5.367 18.641.001 12.017.001z"/>
                            </svg>
                        </a>
                        <a href="#" class="bg-gradient-to-r from-pink-500 to-orange-500 text-white p-3 rounded-lg hover:from-pink-600 hover:to-orange-600 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div>
                <h2 class="text-3xl font-bold text-rshp-dark-gray mb-8">Kirim Pesan</h2>
                
                <div class="bg-gray-50 p-8 rounded-lg shadow-sm">
                    <form class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Depan *</label>
                                <input type="text" id="first_name" name="first_name" required
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rshp-blue focus:border-transparent">
                            </div>
                            <div>
                                <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Belakang *</label>
                                <input type="text" id="last_name" name="last_name" required
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rshp-blue focus:border-transparent">
                            </div>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                            <input type="email" id="email" name="email" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rshp-blue focus:border-transparent">
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                            <input type="tel" id="phone" name="phone"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rshp-blue focus:border-transparent">
                        </div>

                        <div>
                            <label for="pet_type" class="block text-sm font-medium text-gray-700 mb-2">Jenis Hewan</label>
                            <select id="pet_type" name="pet_type"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rshp-blue focus:border-transparent">
                                <option value="">Pilih jenis hewan</option>
                                <option value="dog">Anjing</option>
                                <option value="cat">Kucing</option>
                                <option value="bird">Burung</option>
                                <option value="rabbit">Kelinci</option>
                                <option value="hamster">Hamster</option>
                                <option value="fish">Ikan</option>
                                <option value="other">Lainnya</option>
                            </select>
                        </div>

                        <div>
                            <label for="service_type" class="block text-sm font-medium text-gray-700 mb-2">Jenis Layanan</label>
                            <select id="service_type" name="service_type"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rshp-blue focus:border-transparent">
                                <option value="">Pilih jenis layanan</option>
                                <option value="consultation">Konsultasi Umum</option>
                                <option value="vaccination">Vaksinasi</option>
                                <option value="surgery">Operasi/Bedah</option>
                                <option value="emergency">Darurat</option>
                                <option value="checkup">Pemeriksaan Rutin</option>
                                <option value="other">Lainnya</option>
                            </select>
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Pesan *</label>
                            <textarea id="message" name="message" rows="4" required
                                      placeholder="Jelaskan kondisi hewan atau pertanyaan Anda..."
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rshp-blue focus:border-transparent"></textarea>
                        </div>

                        <div class="flex items-start">
                            <input type="checkbox" id="terms" name="terms" required
                                   class="mt-1 h-4 w-4 text-rshp-blue border-gray-300 rounded focus:ring-rshp-blue">
                            <label for="terms" class="ml-3 text-sm text-gray-600">
                                Saya setuju dengan <a href="#" class="text-rshp-blue hover:underline">syarat dan ketentuan</a> 
                                serta <a href="#" class="text-rshp-blue hover:underline">kebijakan privasi</a> *
                            </label>
                        </div>

                        <button type="submit"
                                class="w-full bg-rshp-blue text-white py-3 px-6 rounded-lg font-semibold hover:bg-rshp-dark-blue transition-colors duration-200 transform hover:scale-105">
                            Kirim Pesan
                        </button>
                    </form>
                </div>

                <!-- Quick Contact -->
                <div class="mt-8 bg-rshp-yellow p-6 rounded-lg">
                    <h3 class="text-lg font-semibold text-rshp-dark-gray mb-3">Butuh Bantuan Segera?</h3>
                    <p class="text-gray-700 mb-4">Untuk kondisi darurat atau konsultasi cepat, hubungi langsung:</p>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="tel:0858-0633-6433" 
                           class="bg-green-600 text-white px-4 py-2 rounded-lg text-center font-medium hover:bg-green-700 transition-colors">
                            📞 Call: 0858-0633-6433
                        </a>
                        <a href="https://wa.me/6285806336433" 
                           class="bg-green-500 text-white px-4 py-2 rounded-lg text-center font-medium hover:bg-green-600 transition-colors">
                            💬 WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-rshp-dark-gray mb-4">Lokasi Kami</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Temukan kami di Kampus C Universitas Airlangga, Surabaya
            </p>
        </div>

        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="h-96">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7915.482022032093!2d112.788135!3d-7.270285!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7fbd40a9784f5%3A0xe756f6ae03eab99!2sAnimal%20Hospital%2C%20Universitas%20Airlangga!5e0!3m2!1sen!2sus!4v1755486601318!5m2!1sen!2sus"
                    style="border:0; width: 100%; height: 100%;" 
                    allowfullscreen="" 
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
            <div class="p-6 bg-gray-50">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-rshp-dark-gray mb-2">RSHP UNAIR</h3>
                        <p class="text-gray-600">Kampus C Universitas Airlangga, Mulyorejo, Surabaya, Jawa Timur 60115</p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <a href="https://www.google.com/maps/place/Animal+Hospital,+Universitas+Airlangga/@-7.270285,112.788135,16z/data=!4m6!3m5!1s0x2dd7fbd40a9784f5:0xe756f6ae03eab99!8m2!3d-7.2702854!4d112.7881346!16s%2Fg%2F1pzpjsyn8?hl=en-US&entry=ttu&g_ep=EgoyMDI1MDgxMy4wIKXMDSoASAFQAw%3D%3D" 
                           target="_blank"
                           class="bg-rshp-blue text-white px-6 py-2 rounded-lg font-medium hover:bg-rshp-dark-blue transition-colors inline-flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                            </svg>
                            Buka di Google Maps
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
