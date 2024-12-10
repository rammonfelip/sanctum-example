<x-guest-layout>

    <div id="messageArea" class="mb-4 hidden">
        <div id="successMessage" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative hidden"></div>
        <div id="errorMessage" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative hidden"></div>
    </div>

    <form id="form" method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="mt-4">
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>
        <div class="flex items-center my-6">
            <hr class="flex-grow border-gray-400">
            <span class="mx-2 text-gray-600">Dados de Endereço</span>
            <hr class="flex-grow border-gray-400">
        </div>
        <!-- CEP -->
        <div class="mt-4">
            <x-input-label for="cep" :value="__('CEP')" />
            <x-text-input id="cep" class="block mt-1 w-full" type="text" name="cep" required autocomplete="postal-code" />
            <x-input-error :messages="$errors->get('cep')" class="mt-2" />
        </div>

        <!-- Rua -->
        <div class="mt-4">
            <x-input-label for="rua" :value="__('Rua')" />
            <x-text-input id="rua" class="block mt-1 w-full" type="text" name="rua" required />
            <x-input-error :messages="$errors->get('rua')" class="mt-2" />
        </div>

        <!-- Numero -->
        <div class="mt-4">
            <x-input-label for="numero" :value="__('Numero')" />
            <x-text-input id="numero" class="block mt-1 w-full" type="text" name="numero" required />
            <x-input-error :messages="$errors->get('numero')" class="mt-2" />
        </div>

        <!-- Bairro -->
        <div class="mt-4">
            <x-input-label for="bairro" :value="__('Bairro')" />
            <x-text-input id="bairro" class="block mt-1 w-full" type="text" name="bairro" required />
            <x-input-error :messages="$errors->get('bairro')" class="mt-2" />
        </div>

        <!-- Cidade -->
        <div class="mt-4">
            <x-input-label for="cidade" :value="__('Cidade')" />
            <x-text-input id="cidade" class="block mt-1 w-full" type="text" name="cidade" required />
            <x-input-error :messages="$errors->get('cidade')" class="mt-2" />
        </div>

        <!-- Estado -->
        <div class="mt-4">
            <x-input-label for="estado" :value="__('Estado')" />
            <x-text-input id="estado" class="block mt-1 w-full" type="text" name="estado" required />
            <x-input-error :messages="$errors->get('estado')" class="mt-2" />
        </div>

        <!-- Botão de Enviar -->
        <div class="flex items-center justify-end mt-4">
            <x-primary-button id="send" class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>

<script>
    document.getElementById('cep').addEventListener('blur', function() {
        const cep = this.value.replace(/\D/g, ''); // Remove caracteres não numéricos

        if (cep.length === 8) { // Valida o CEP
            fetch(`/consultar-cep/${cep}`)
                .then(response => response.json())
                .then(data => {
                    if (data.erro) {
                        alert('CEP não encontrado.');
                    } else {
                        // Preenche os campos
                        document.getElementById('rua').value = data.logradouro || '';
                        document.getElementById('bairro').value = data.bairro || '';
                        document.getElementById('cidade').value = data.localidade || '';
                        document.getElementById('estado').value = data.uf || '';
                    }
                })
                .catch(error => {
                    console.error('Erro ao buscar CEP:', error);
                    alert('Erro ao buscar o CEP. Tente novamente.');
                });
        } else {
            alert('CEP inválido. Por favor, insira um CEP válido com 8 dígitos.');
        }
    });

    document.getElementById('send').addEventListener('click', function(e) {
        e.preventDefault();

        const form = document.getElementById('form');

        const formData = new FormData(form);

        axios.post('/api/register', formData, {
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            }
        })
            .then(response => {
                showMessage('success', response.data.message);

                // Redireciona após 1.5 segundos
                setTimeout(() => {
                    window.location.href = '/login';
                }, 1500);
            })
            .catch(error => {
                if (error.response && error.response.data && error.response.data.errors) {
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
                }
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
    });
</script>
