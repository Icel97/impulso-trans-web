    
                @if (session('success') || isset($success))
                <x-adminlte-alert theme="success" title="Info" id="success-alert">
                    @if (session('success'))
                        {{ session('success') }}
                    @else
                        {{ $success }}
                    @endif
                </x-adminlte-alert>             
            @elseif (session('error') || isset($error))
                <x-adminlte-alert theme="danger" title="Hubo un error" id="error-alert">
                    @if (session('error'))
                        {{ session('error') }}
                    @else
                        {{ $error }}
                    @endif
                </x-adminlte-alert>
            @elseif (session('info') || isset($info))
                <x-adminlte-alert theme="info" title="Alerta" id="info-alert">
                    @if (session('info'))
                        {{ session('info') }}
                    @else
                        {{ $info }}
                    @endif
                </x-adminlte-alert>
            @endif