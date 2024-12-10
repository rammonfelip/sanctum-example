<x-guest-layout>
    <div id="messageArea" class="mb-4 hidden">
        <div id="successMessage" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative hidden"></div>
        <div id="errorMessage" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative hidden"></div>
    </div>

    <form id="form" method="POST" action="/api/login">
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
            <a href="{{ route('register') }}">
                <x-secondary-button class="me-3">
                    {{ __('Registrar') }}
                </x-secondary-button>
            </a>

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
        axios.defaults.withCredentials = true;
        axios.defaults.withXSRFToken = true;
        axios.post('/api/login', formData, {
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            withCredentials: true,
        })
            .then(response => {
                if (response.data.token) {
                    showMessage('success', response.data.message);
                    localStorage.setItem('token', response.data.token);

                    // Redireciona após 1.5 segundos
                    setTimeout(() => {
                        window.location.href = '/dashboard';
                    }, 1500);
                }
            })
            .catch(error => {
                if (error.response && error.response.data && error.response.data.errors) {
                    const errorMessages = document.querySelectorAll('.text-red-500');
                    errorMessages.forEach(msg => msg.remove());

                    const errors = error.response.data.errors;

                    Object.keys(errors).forEach(field => {
                        const fieldElement = document.querySelector(`[name="${field}"]`);
                        if (fieldElement) {
                            const errorMessage = document.createElement('span');
                            errorMessage.classList.add('text-red-500', 'text-sm');
                            errorMessage.textContent = errors[field][0];
                            fieldElement.parentNode.appendChild(errorMessage);
                        }
                    });
                } else if (error.status === 401) {
                    showMessage('error', error.response.data.message)
                } else {
                    showMessage('error', 'Erro inesperado, tente novamente.')
                }
            });

    });

    function showMessage(type, message) {
        messageArea.classList.remove('hidden');

        if (type === 'success') {
            successMessage.textContent = message;
            successMessage.classList.remove('hidden');
            errorMessage.classList.add('hidden');
        } else {
            errorMessage.textContent = message;
            errorMessage.classList.remove('hidden');
            successMessage.classList.add('hidden');
        }
    }
</script>

