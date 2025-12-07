<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-white tracking-tight">
            {{ __('Buat Kuis Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900 rounded-3xl border border-gray-800 shadow-2xl overflow-hidden relative">
                
                <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-indigo-600/10 rounded-full blur-3xl -mr-20 -mt-20 pointer-events-none"></div>
                <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-purple-600/10 rounded-full blur-3xl -ml-20 -mb-20 pointer-events-none"></div>

                <div class="p-8 relative z-10">
                    
                    @if(session('error'))
                        <div class="mb-6 p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 flex items-center gap-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('quizzes.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <div class="md:col-span-2 space-y-6">
                                <div>
                                    <label class="block text-xs font-bold text-gray-400 mb-2 uppercase tracking-wider">Judul Kuis</label>
                                    <input type="text" name="title" required 
                                        class="w-full bg-gray-800 border border-gray-700 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-white placeholder-gray-500 px-4 py-3 transition-all" 
                                        placeholder="Masukan judul kuis...">
                                </div>
                                
                                <div>
                                    <label class="block text-xs font-bold text-gray-400 mb-2 uppercase tracking-wider">Deskripsi</label>
                                    <textarea name="description" rows="3" 
                                        class="w-full bg-gray-800 border border-gray-700 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-white placeholder-gray-500 px-4 py-3 resize-none transition-all" 
                                        placeholder="Deskripsi singkat..."></textarea>
                                </div>
                            </div>

                            <div class="space-y-6">
                                <div>
                                    <label class="block text-xs font-bold text-gray-400 mb-2 uppercase tracking-wider">Durasi (Menit)</label>
                                    <input type="number" name="timer" value="30" min="1" required 
                                        class="w-full bg-gray-800 border border-gray-700 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-white px-4 py-3 text-center font-bold text-lg [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                </div>
                            </div>
                        </div>

                        <div class="rounded-2xl bg-white/5 border border-white/5 p-1 backdrop-blur-sm">
                            <div class="bg-gray-900/50 rounded-xl p-6 md:p-8 space-y-8">
                                
                                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-white/5 pb-6">
                                    <div class="flex items-center gap-4">
                                        <div class="p-3 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl shadow-lg shadow-indigo-500/20">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                                        </div>
                                        <div>
                                            <h3 class="text-xl font-bold text-white">AI Generator</h3>
                                            <p class="text-sm text-gray-400">Upload PDF materi atau tulis topik, AI akan membuatkan soal otomatis.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <div class="space-y-3">
                                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider">Sumber Materi (PDF)</label>
                                        <div class="relative group h-40">
                                            <input type="file" name="document" accept=".pdf" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20" />
                                            <div class="absolute inset-0 w-full h-full border-2 border-dashed border-gray-700 rounded-xl bg-gray-800/50 group-hover:bg-gray-800 group-hover:border-indigo-500/50 transition-all flex flex-col items-center justify-center z-10">
                                                <div class="p-3 bg-gray-800 rounded-full mb-3 group-hover:scale-110 transition-transform">
                                                    <svg class="h-6 w-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                                </div>
                                                <p class="text-sm font-medium text-gray-300">Klik untuk upload file PDF</p>
                                                <p class="text-xs text-gray-500 mt-1">Maksimal 10MB</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="space-y-3">
                                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider">Instruksi & Topik</label>
                                        <textarea name="ai_prompt" rows="4" 
                                            class="w-full h-40 bg-gray-800/50 border border-gray-700 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-white placeholder-gray-600 px-4 py-3 resize-none transition-all hover:bg-gray-800" 
                                            placeholder="Contoh: Buatkan soal tentang hukum Newton..."></textarea>
                                    </div>
                                </div>

                                <div x-data="quizDistribution()" x-init="init()" class="bg-gray-800/30 rounded-xl p-1 border border-white/5 mt-4">
                                    <div class="bg-gray-900/80 rounded-lg p-6">
                                        
                                        <div class="flex items-center justify-between mb-8">
                                            <div>
                                                <h4 class="text-white font-bold text-lg">Konfigurasi Soal</h4>
                                                <p class="text-gray-500 text-xs mt-1">Atur proporsi soal Pilihan Ganda & Essay</p>
                                            </div>
                                            
                                            <div class="flex items-center gap-3">
                                                <label class="text-xs font-bold text-gray-400 uppercase">Jumlah:</label>
                                                <div class="relative">
                                                    <select name="question_count" x-model.number="total" @change="updateTotal" 
                                                        class="appearance-none bg-gray-800 border border-gray-600 text-white text-sm font-bold rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-32 p-2.5 px-4 cursor-pointer hover:bg-gray-700 transition-colors pr-10">
                                                        <option value="5">5 Soal</option>
                                                        <option value="10">10 Soal</option>
                                                        <option value="15">15 Soal</option>
                                                        <option value="20">20 Soal</option>
                                                    </select>
                                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-6 mb-2">
                                            <div class="w-24 shrink-0">
                                                <label class="text-[10px] font-bold text-indigo-400 uppercase tracking-wider block mb-1">Pilgan</label>
                                                <input type="number" name="pg_count" x-model.number="pg" @input="updatePgInput" 
                                                    class="w-full bg-gray-800 border border-indigo-500/30 rounded-lg text-center text-white font-bold text-lg py-2 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none transition-all">
                                            </div>

                                            <div class="flex-1 relative h-6 w-full flex items-center group">
                                                
                                                <div class="absolute w-full h-3 bg-gray-700/50 rounded-full overflow-hidden">
                                                    <div class="h-full bg-gradient-to-r from-indigo-600 to-indigo-400" :style="'width: ' + (pg / total * 100) + '%'"></div>
                                                </div>
                                                
                                                <div class="absolute w-full h-3 rounded-full overflow-hidden pointer-events-none">
                                                    <div class="h-full bg-gradient-to-l from-purple-600 to-purple-400 ml-auto" :style="'width: ' + (essay / total * 100) + '%'"></div>
                                                </div>

                                                <div class="absolute h-6 w-6 bg-white rounded-full shadow-lg shadow-black/50 pointer-events-none z-20 border-2 border-gray-800 transition-all duration-75 flex items-center justify-center transform -translate-x-1/2"
                                                     :style="'left: ' + (pg / total * 100) + '%'">
                                                     <div class="w-1.5 h-1.5 bg-gray-400 rounded-full"></div>
                                                </div>

                                                <input type="range" x-model.number="pg" @input="updateSlider" min="0" :max="total" 
                                                    class="absolute w-full h-full opacity-0 cursor-pointer z-30 inset-0">
                                            </div>

                                            <div class="w-24 shrink-0">
                                                <label class="text-[10px] font-bold text-purple-400 uppercase tracking-wider block mb-1 text-right">Essay</label>
                                                <input type="number" name="essay_count" x-model.number="essay" @input="updateEssayInput" 
                                                    class="w-full bg-gray-800 border border-purple-500/30 rounded-lg text-center text-white font-bold text-lg py-2 focus:ring-1 focus:ring-purple-500 focus:border-purple-500 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none transition-all">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('quizzes.index') }}" class="px-6 py-3 rounded-xl text-gray-400 font-medium hover:text-white hover:bg-white/5 transition-colors">
                                Batal
                            </a>
                            <button type="submit" class="px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-bold rounded-xl shadow-lg shadow-indigo-600/20 hover:shadow-indigo-600/40 transform hover:-translate-y-0.5 transition-all duration-200">
                                Generate Kuis
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function quizDistribution() {
            return {
                total: 10,
                pg: 10,
                essay: 0,
                
                init() {
                    this.pg = this.total;
                    this.essay = 0;
                },

                updateTotal() {
                    this.total = parseInt(this.total);
                    this.pg = this.total;
                    this.essay = 0;
                },

                updateSlider() {
                    this.pg = parseInt(this.pg);
                    this.essay = this.total - this.pg;
                },

                updatePgInput() {
                    let val = parseInt(this.pg);
                    if (isNaN(val) || val < 0) val = 0;
                    if (val > this.total) val = this.total;
                    
                    this.pg = val;
                    this.essay = this.total - this.pg;
                },

                updateEssayInput() {
                    let val = parseInt(this.essay);
                    if (isNaN(val) || val < 0) val = 0;
                    if (val > this.total) val = this.total;

                    this.essay = val;
                    this.pg = this.total - this.essay;
                }
            }
        }
    </script>
</x-app-layout>