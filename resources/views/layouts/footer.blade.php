<footer class="mt-5" style="background-color: #8C4421; color: #FFF5E4; padding-top: 12px; padding-bottom: 8px;">
    <div style="height:5px;background-color:#FFD580" class="mb-4">&nbsp;</div>
    <div class="container">
        <div class="row">
            <!-- Sección de redes sociales -->
            <div class="col-md-4 mb-3">
                <h5 style="color: #FFD580;">Redes Sociales</h5>
                <div class="d-flex justify-content-start">
                    <a href="#" style="background-color: #3b5998; color: white; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px; margin-right: 8px;">
                        <i class="fab fa-facebook-f" style="font-size: 20px;"></i>
                    </a>
                    <a href="#" style="background-color: #55acee; color: white; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px; margin-right: 8px;">
                        <i class="fab fa-twitter" style="font-size: 20px;"></i>
                    </a>
                    <a href="#" style="background-color: #25D366; color: white; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px; margin-right: 8px;">
                        <i class="fab fa-whatsapp" style="font-size: 20px;"></i>
                    </a>
                    <a href="#" style="background-color: #0088cc; color: white; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px; margin-right: 8px;">
                        <i class="fab fa-telegram-plane" style="font-size: 20px;"></i>
                    </a>
                    <a href="#" style="background-color: #FF0000; color: white; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px;">
                        <i class="fab fa-youtube" style="font-size: 20px;"></i>
                    </a>
                </div>
            </div>

            <!-- Sección de enlaces -->
            <div class="col-md-4 mb-3">
                <h5 style="color: #FFD580;">Enlaces</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('site.about') }}" style="color: #FFD580; text-decoration: none;">Acerca de</a></li>
                    <li><a href="{{ route('site.privacy-policy') }}" style="color: #FFD580; text-decoration: none;">Política de Privacidad</a></li>
                    <li><a href="{{ route('site.cookies-policy') }}" style="color: #FFD580; text-decoration: none;">Política de Cookies</a></li>
                    <li><a href="{{ route('site.contact') }}" style="color: #FFD580; text-decoration: none;">Contacto</a></li>
                </ul>
            </div>

            <!-- Sección de disclaimer -->
            <div class="col-md-4 mb-3">
                <h5 style="color: #FFD580;">Disclaimer</h5>
                <p style="color: #FFF5E4;">Biblicomentarios.com es un esfuerzo particular y no es un sitio oficial de La Iglesia de Jesucristo de los Santos de los Últimos Días, si bien se ha hecho todo esfuerzo para obrar en conformidad con la doctrina y prácticas de la Iglesia.</p>
            </div>
        </div>
    </div>
    <div style="height:5px;background-color:#FFD580" class="mt-4 mb-2">&nbsp;</div>

    @include('components.footer_scripts')
</footer>