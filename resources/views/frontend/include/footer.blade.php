<footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
                <!-- À propos -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">À propos</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Qui sommes-nous ?</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Comment ça marche ?</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Nos services</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Blog</a></li>
                    </ul>
                </div>

                <!-- Aide -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Aide & Contact</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Centre d'aide</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Nous contacter</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">FAQ</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Support</a></li>
                    </ul>
                </div>

                <!-- Légales -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Informations légales</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Conditions générales</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Politique de confidentialité</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Mentions légales</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Cookies</a></li>
                    </ul>
                </div>

                <!-- Newsletter -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Newsletter</h3>
                    <p class="text-gray-300 mb-4">Inscrivez-vous pour recevoir nos offres exclusives</p>
                    <form class="space-y-3">
                        <div>
                            <input type="email" placeholder="Votre adresse email" class="w-full px-4 py-2 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-orange-500">
                        </div>
                        <button type="submit" class="bg-orange-500 text-white px-6 py-2 rounded-lg hover:bg-orange-600 transition-colors w-full">
                            S'abonner
                        </button>
                    </form>
                    <div class="mt-4">
                        <p class="text-gray-300 mb-2">Suivez-nous</p>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-300 hover:text-white transition-colors">
                                <i class="fab fa-facebook-f text-xl"></i>
                            </a>
                            <a href="#" class="text-gray-300 hover:text-white transition-colors">
                                <i class="fab fa-twitter text-xl"></i>
                            </a>
                            <a href="#" class="text-gray-300 hover:text-white transition-colors">
                                <i class="fab fa-instagram text-xl"></i>
                            </a>
                            <a href="#" class="text-gray-300 hover:text-white transition-colors">
                                <i class="fab fa-youtube text-xl"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Copyright -->
            <div class="border-t border-gray-700 pt-6">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-gray-400 text-sm">&copy; {{ date('Y') }} Cashback Market. Tous droits réservés.</p>
                    <div class="flex space-x-6 mt-4 md:mt-0">
                        <img src="{{ asset('images/payment-methods/visa.png') }}" alt="Visa" class="h-8">
                        <img src="{{ asset('images/payment-methods/mastercard.png') }}" alt="Mastercard" class="h-8">
                        <img src="{{ asset('images/payment-methods/paypal.png') }}" alt="PayPal" class="h-8">
                        <img src="{{ asset('images/payment-methods/cb.png') }}" alt="CB" class="h-8">
                    </div>
                </div>
            </div>
        </div>
    </footer>
