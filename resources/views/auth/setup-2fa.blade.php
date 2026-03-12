<x-guest-layout>
    <div class="text-center">
        <h2>Escanea este código con tu App</h2>
        <div class="flex justify-center my-4">
            {!! QrCode::size(200)->generate($qr_url) !!}
        </div>
        <a href="{{ route('otp.verify') }}" class="btn btn-primary">Continuar</a>
    </div>
</x-guest-layout>