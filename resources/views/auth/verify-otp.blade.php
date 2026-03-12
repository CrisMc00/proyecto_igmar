<x-guest-layout>
    <form method="POST" action="{{ route('otp.post') }}">
        @csrf
        <input type="text" name="code" placeholder="Código de 6 dígitos" required>
        <button type="submit">Verificar</button>
    </form>
</x-guest-layout>