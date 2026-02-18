    <!-- Footer -->
    <footer class="bg-slate-900 text-white pt-20 pb-10">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
                <div class="col-span-1 md:col-span-1">
                    <a href="#" class="flex items-center gap-2 mb-6">
                        <img src="{{ asset('assets/img/logo-1.png') }}" alt="MaticPost Logo" class="h-7 md:h-8 w-auto" loading="eager">
                        <span class="text-xl font-bold">MaticPost</span>
                    </a>
                    <p class="text-slate-400 text-sm leading-relaxed">
                        Membantu UMKM Indonesia mengelola media sosial lebih efisien, hemat, dan otomatis.
                    </p>
                </div>
                <div>
                    <h4 class="font-bold mb-6 text-slate-200">Produk</h4>
                    <ul class="space-y-4 text-slate-400 text-sm">
                        <li><a href="{{ url('/#features') }}" class="hover:text-brand-400 transition">Fitur</a></li>
                        <li><a href="{{ url('/#pricing') }}" class="hover:text-brand-400 transition">Harga</a></li>
                        <li><a href="{{ route('customer.login') }}" class="hover:text-brand-400 transition">Masuk ke Dashboard</a></li>
                        <li><a href="#" class="hover:text-brand-400 transition">Roadmap</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-6 text-slate-200">Legal</h4>
                    <ul class="space-y-4 text-slate-400 text-sm">
                        <li><a href="{{ url('/privacy') }}" class="hover:text-brand-400 transition">Kebijakan Privasi</a></li>
                        <li><a href="{{ url('/terms') }}" class="hover:text-brand-400 transition">Syarat & Ketentuan</a></li>
                        <li><a href="{{ url('/refund') }}" class="hover:text-brand-400 transition">Refund Policy</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-6 text-slate-200">Hubungi Kami</h4>
                    <ul class="space-y-4 text-slate-400 text-sm">
                        <li><a href="mailto:support@maticpost.com" class="hover:text-brand-400 transition"><i
                                    class="fas fa-envelope mr-2"></i> support@maticpost.com</a></li>
                        <li><a href="#" class="hover:text-brand-400 transition"><i class="fab fa-whatsapp mr-2"></i> +62
                                812-3456-7890</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-slate-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-slate-500 text-sm">© {{ date('Y') }} MaticPost Indonesia. All rights reserved.</p>
                <div class="flex gap-4">
                    <a href="#"
                        class="w-8 h-8 rounded bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-brand-600 hover:text-white transition"><i
                            class="fab fa-instagram"></i></a>
                    <a href="#"
                        class="w-8 h-8 rounded bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-brand-600 hover:text-white transition"><i
                            class="fab fa-facebook"></i></a>
                    <a href="#"
                        class="w-8 h-8 rounded bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-brand-600 hover:text-white transition"><i
                            class="fab fa-twitter"></i></a>
                </div>
            </div>
        </div>
    </footer>
