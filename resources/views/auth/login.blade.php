<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form id="form" method="POST">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-between mt-4">
            <x-secondary-button class="me-3">
                {{ __('Registrar') }}
            </x-secondary-button>

            <div class="flex items-center">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Esqueceu sua senha?') }}
                </a>

                <x-primary-button id="send" class="ms-3">
                    {{ __('Entrar') }}
                </x-primary-button>
            </div>
        </div>
    </form>
</x-guest-layout>

<script>
    document.getElementById('send').addEventListener('click', function(e) {
        e.preventDefault();

        const form = document.getElementById('form');

        const formData = new FormData(form);

        axios.post('/api/login', formData, {
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            }
        })
            .then(response => {
                console.log(response.data); return false;
                // Redireciona ao dashboard ou outra rota após sucesso
                window.location.href = '/dashboard';
            })
            .catch(error => {
                if (error.response && error.response.data && error.response.data.errors) {
                    // Limpar mensagens de erro anteriores
                    const errorMessages = document.querySelectorAll('.text-red-500');
                    errorMessages.forEach(msg => msg.remove());

                    const errors = error.response.data.errors;

                    // Iterar pelos erros e exibir mensagens
                    Object.keys(errors).forEach(field => {
                        const fieldElement = document.querySelector(`[name="${field}"]`);
                        if (fieldElement) {
                            const errorMessage = document.createElement('span');
                            errorMessage.classList.add('text-red-500', 'text-sm');
                            errorMessage.textContent = errors[field][0];
                            fieldElement.parentNode.appendChild(errorMessage);
                        }
                    });
                } else {
                    console.error('Erro inesperado:', error.response || error);
                    alert('Erro no login. Tente novamente.');
                }
            });
    });
</script>

