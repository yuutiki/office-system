<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                SMTP設定編集
            </h2>
            <x-message :message="session('message')" />
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-white">
                    <div class="max-w-4xl mx-auto">
                        <div class="mb-6">
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">SMTP設定編集</h1>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">SMTP設定の編集を行います。必要な項目を入力してください。</p>
                        </div>

                        <form action="{{ route('smtp-settings.update', $smtpSetting) }}" method="POST" class="space-y-6">
                            @csrf
                            @method('PUT')
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                {{-- 左側カラム --}}
                                <div class="space-y-6">
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            設定名 <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" 
                                               id="name" 
                                               name="name" 
                                               value="{{ old('name', $smtpSetting->name) }}"
                                               required
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        @error('name')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            設定タイプ <span class="text-red-500">*</span>
                                        </label>
                                        <select id="type" 
                                                name="type" 
                                                required
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                            <option value="internal" {{ old('type', $smtpSetting->type) == 'internal' ? 'selected' : '' }}>
                                                社内向け
                                            </option>
                                            <option value="external" {{ old('type', $smtpSetting->type) == 'external' ? 'selected' : '' }}>
                                                社外向け
                                            </option>
                                        </select>
                                        @error('type')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="host" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            SMTPホスト <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" 
                                               id="host" 
                                               name="host" 
                                               value="{{ old('host', $smtpSetting->host) }}"
                                               required
                                               placeholder="smtp.example.com"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        @error('host')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="port" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            ポート番号 <span class="text-red-500">*</span>
                                        </label>
                                        <input type="number" 
                                               id="port" 
                                               name="port" 
                                               value="{{ old('port', $smtpSetting->port) }}"
                                               required
                                               min="1"
                                               max="65535"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        @error('port')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="encryption" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            暗号化
                                        </label>
                                        <select id="encryption" 
                                                name="encryption"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                            <option value="">なし</option>
                                            <option value="tls" {{ old('encryption', $smtpSetting->encryption) == 'tls' ? 'selected' : '' }}>
                                                TLS
                                            </option>
                                            <option value="ssl" {{ old('encryption', $smtpSetting->encryption) == 'ssl' ? 'selected' : '' }}>
                                                SSL
                                            </option>
                                        </select>
                                        @error('encryption')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                
                                {{-- 右側カラム --}}
                                <div class="space-y-6">
                                    <div>
                                        <label for="auth_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            認証タイプ <span class="text-red-500">*</span>
                                        </label>
                                        <select id="auth_type" 
                                                name="auth_type" 
                                                required
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                            <option value="password" {{ old('auth_type', $smtpSetting->auth_type) == 'password' ? 'selected' : '' }}>
                                                パスワード認証
                                            </option>
                                            <option value="oauth" {{ old('auth_type', $smtpSetting->auth_type) == 'oauth' ? 'selected' : '' }}>
                                                OAuth認証
                                            </option>
                                        </select>
                                        @error('auth_type')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            ユーザー名 <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" 
                                               id="username" 
                                               name="username" 
                                               value="{{ old('username', $smtpSetting->username) }}"
                                               required
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        @error('username')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div id="password-field" style="{{ $smtpSetting->auth_type === 'oauth' ? 'display: none;' : '' }}">
                                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            パスワード
                                        </label>
                                        <input type="password" 
                                               id="password" 
                                               name="password"
                                               placeholder="変更する場合のみ入力"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        <p class="mt-1 text-sm text-gray-500">変更しない場合は空欄のままにしてください</p>
                                        @error('password')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div id="oauth-fields" style="{{ $smtpSetting->auth_type === 'oauth' ? '' : 'display: none;' }}">
                                        <div class="space-y-6">
                                            <div>
                                                <label for="oauth_client_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                    OAuth Client ID
                                                </label>
                                                <input type="text" 
                                                       id="oauth_client_id" 
                                                       name="oauth_client_id" 
                                                       value="{{ old('oauth_client_id', $smtpSetting->oauth_client_id) }}"
                                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                                @error('oauth_client_id')
                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            
                                            <div>
                                                <label for="oauth_client_secret" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                    OAuth Client Secret
                                                </label>
                                                <input type="password" 
                                                       id="oauth_client_secret" 
                                                       name="oauth_client_secret"
                                                       placeholder="変更する場合のみ入力"
                                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                                <p class="mt-1 text-sm text-gray-500">変更しない場合は空欄のままにしてください</p>
                                                @error('oauth_client_secret')
                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            
                                            @if($smtpSetting->hasOAuthTokens())
                                                <div class="rounded-md bg-blue-50 p-4">
                                                    <div class="flex">
                                                        <div class="flex-shrink-0">
                                                            <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                            </svg>
                                                        </div>
                                                        <div class="ml-3 flex-1 md:flex md:justify-between">
                                                            <p class="text-sm text-blue-700">OAuth認証済み</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <label for="from_address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            送信元メールアドレス <span class="text-red-500">*</span>
                                        </label>
                                        <input type="email" 
                                               id="from_address" 
                                               name="from_address" 
                                               value="{{ old('from_address', $smtpSetting->from_address) }}"
                                               required
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        @error('from_address')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="from_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            送信元名 <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" 
                                               id="from_name" 
                                               name="from_name" 
                                               value="{{ old('from_name', $smtpSetting->from_name) }}"
                                               required
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        @error('from_name')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                                <a href="{{ route('smtp-settings.index') }}" 
                                   class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    キャンセル
                                </a>
                                <button type="submit" 
                                        class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    更新
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.getElementById('auth_type').addEventListener('change', function() {
        const isOAuth = this.value === 'oauth';
        document.getElementById('password-field').style.display = isOAuth ? 'none' : 'block';
        document.getElementById('oauth-fields').style.display = isOAuth ? 'block' : 'none';
    });

    // 初期表示の設定
    document.getElementById('auth_type').dispatchEvent(new Event('change'));
    </script>
</x-app-layout>