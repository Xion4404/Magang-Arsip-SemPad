<!-- Media & Informasi Section -->
<<<<<<< HEAD
<section class="py-24 bg-white overflow-hidden">
    <div class="container mx-auto px-6">
        <div class="flex justify-between items-end mb-12">
            <div>
                <h2 class="text-4xl font-bold text-gray-800 mb-2">Media & Informasi</h2>
                <div class="w-20 h-1.5 bg-red-600 rounded-full"></div>
            </div>
            <div class="hidden md:flex gap-2">
                <button id="slidePrev"
                    class="p-3 bg-gray-100 hover:bg-red-600 hover:text-white rounded-full transition shadow-sm">
=======
<section class="py-8 relative overflow-hidden bg-cover bg-center bg-fixed" style="background-image: url('{{ asset('images/hp 5.jpeg') }}');">
    <!-- Red Overlay with Blur -->
    <div class="absolute inset-0 bg-black/35 backdrop-blur-sm z-0"></div>

    <div class="container mx-auto px-6 relative z-10">
        <div class="flex justify-between items-end mb-8">
            <div>
                <h2 class="text-4xl font-bold text-white mb-2">Media & Informasi</h2>
                <div class="w-20 h-1.5 bg-white rounded-full"></div>
            </div>
            <div class="hidden md:flex gap-2">
                <button id="slidePrev"
                    class="p-3 bg-white/20 hover:bg-[#e92027] text-white rounded-full transition shadow-sm backdrop-blur-sm">
>>>>>>> 7d4f385849d706498d1a4faaf8f83b504a2a87f9
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button id="slideNext"
<<<<<<< HEAD
                    class="p-3 bg-gray-100 hover:bg-red-600 hover:text-white rounded-full transition shadow-sm">
=======
                    class="p-3 bg-white/20 hover:bg-[#e92027] text-white rounded-full transition shadow-sm backdrop-blur-sm">
>>>>>>> 7d4f385849d706498d1a4faaf8f83b504a2a87f9
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="relative group">
            <!-- Slider Container -->
            <div id="mediaSlider"
<<<<<<< HEAD
                class="flex gap-6 overflow-x-auto pb-12 snap-x snap-mandatory scrollbar-hide scroll-smooth"
=======
                class="flex gap-6 overflow-x-auto pb-8 snap-x snap-mandatory scrollbar-hide scroll-smooth"
>>>>>>> 7d4f385849d706498d1a4faaf8f83b504a2a87f9
                style="scrollbar-width: none; -ms-overflow-style: none;">
                @forelse($mediaInfo as $item)
                    <!-- Card Item -->
                    <div x-data="{ expanded: false }" @click="expanded = !expanded"
                        class="flex-shrink-0 w-[400px] snap-center bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden cursor-pointer hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2"
                        :class="expanded ? 'w-[600px]' : 'w-[400px]'">

                        <!-- Image Area -->
                        <div class="relative h-64 overflow-hidden">
                            <img src="{{ asset($item->gambar) }}" alt="{{ $item->judul }}"
                                class="w-full h-full object-cover transform hover:scale-110 transition duration-700">
                            <div
<<<<<<< HEAD
                                class="absolute top-4 left-4 bg-red-600 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-lg">
=======
                                class="absolute top-4 left-4 bg-[#e92027] text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-lg">
>>>>>>> 7d4f385849d706498d1a4faaf8f83b504a2a87f9
                                {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                            </div>
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-60"></div>
                        </div>

                        <!-- Content Area -->
                        <div class="p-8">
                            <h3
<<<<<<< HEAD
                                class="text-2xl font-bold text-gray-800 mb-3 leading-tight group-hover:text-red-700 transition-colors">
=======
                                class="text-2xl font-bold text-gray-800 mb-3 leading-tight group-hover:text-[#e92027] transition-colors">
>>>>>>> 7d4f385849d706498d1a4faaf8f83b504a2a87f9
                                {{ $item->judul }}
                            </h3>

                            <!-- Preview Text -->
                            <p x-show="!expanded" class="text-gray-500 line-clamp-2">
                                {{ Str::limit($item->deskripsi, 100) }}
                            </p>

                            <!-- Full Content (Expandable) -->
                            <div x-show="expanded" x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 max-h-0"
                                x-transition:enter-end="opacity-100 max-h-[1000px]"
                                class="mt-4 text-gray-600 space-y-4 border-t border-gray-100 pt-4">
                                <p class="leading-relaxed whitespace-pre-line">
                                    {{ $item->deskripsi }}
                                </p>
                            </div>

                            <div
<<<<<<< HEAD
                                class="mt-6 flex items-center text-red-600 font-semibold text-sm uppercase tracking-wide group-hover:underline">
=======
                                class="mt-6 flex items-center text-[#e92027] font-semibold text-sm uppercase tracking-wide group-hover:underline">
>>>>>>> 7d4f385849d706498d1a4faaf8f83b504a2a87f9
                                <span x-text="expanded ? 'Tutup Detail' : 'Baca Selengkapnya'"></span>
                                <svg class="w-4 h-4 ml-2 transform transition-transform duration-300"
                                    :class="expanded ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                    </div>
                @empty
                    <!-- Empty State -->
<<<<<<< HEAD
                    <div class="w-full text-center py-20 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor"
=======
                    <div class="w-full text-center py-20 bg-white/10 backdrop-blur-sm rounded-2xl border-2 border-dashed border-white/20">
                        <svg class="w-16 h-16 text-white/50 mx-auto mb-4" fill="none" stroke="currentColor"
>>>>>>> 7d4f385849d706498d1a4faaf8f83b504a2a87f9
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
<<<<<<< HEAD
                        <p class="text-gray-500 font-medium">Belum ada berita atau media yang diposting.</p>
=======
                        <p class="text-white/80 font-medium">Belum ada berita atau media yang diposting.</p>
>>>>>>> 7d4f385849d706498d1a4faaf8f83b504a2a87f9
                    </div>
                @endforelse
            </div>

            <!-- Fade Edges for Scroll Cue -->
            <div
<<<<<<< HEAD
                class="absolute top-0 right-0 h-full w-24 bg-gradient-to-l from-white to-transparent pointer-events-none md:hidden">
=======
                class="absolute top-0 right-0 h-full w-24 bg-gradient-to-l from-black/20 to-transparent pointer-events-none md:hidden">
>>>>>>> 7d4f385849d706498d1a4faaf8f83b504a2a87f9
            </div>
        </div>
    </div>
</section>

<!-- Script for Custom Navigation (Optional fallback for manual buttons) -->
<script>
    const slider = document.getElementById('mediaSlider');
    const prevBtn = document.getElementById('slidePrev');
    const nextBtn = document.getElementById('slideNext');

    if (slider && prevBtn && nextBtn) {
        nextBtn.addEventListener('click', () => {
            slider.scrollBy({ left: 420, behavior: 'smooth' });
        });
        prevBtn.addEventListener('click', () => {
            slider.scrollBy({ left: -420, behavior: 'smooth' });
        });
    }
<<<<<<< HEAD
</script>
=======
</script>
>>>>>>> 7d4f385849d706498d1a4faaf8f83b504a2a87f9
