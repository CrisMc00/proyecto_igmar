<x-guest-layout>
    <div class="text-center">
        <h2 class="mb-4">Configurar Google Authenticator</h2>
        <p>Escanea este código QR con tu aplicación:</p>
        
        <div class="flex justify-center my-4">
            {!! QrCode::size(200)->generate($qr_url) !!}
        </div>

        <p class="text-sm">Una vez escaneado, presiona continuar para verificar.</p>
        
        <a href="{{ route('otp.verify') }}" class="underline text-blue-600">Continuar</a>
    </div>
</x-guest-layout>