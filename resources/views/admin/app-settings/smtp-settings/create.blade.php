<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                SMTP設定作成
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
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">SMTP設定作成</h1>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">新しいSMTP設定を作成します。必要な項目を入力してください。</p>
                        </div>

                        <form action="{{ route('smtp-settings.store') }}" method="POST" class="space-y-6">
                            @csrf
                            
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
                                               value="{{ old('name') }}"
                                               required
                                               placeholder="例: Gmail社内用"
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
                                            <option value="">選択してください</option>
                                            <option value="internal" {{ old('type') == 'internal' ? 'selected' : '' }}>
                                                社内向け
                                            </option>
                                            <option value="external" {{ old('type') == 'external' ? 'selected' : '' }}>
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
                                               value="{{ old('host') }}"
                                               required
                                               placeholder="smtp.gmail.com"
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
                                               value="{{ old('port', 587) }}"
                                               required
                                               min="1"
                                               max="65535"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        <p class="mt-1 text-sm text-gray-500">通常: 587 (TLS), 465 (SSL), 25 (暗号化なし)</p>
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
                                            <option value="tls" {{ old('encryption') == 'tls' ? 'selected' : '' }}>
                                                TLS
                                            </option>
                                            <option value="ssl" {{ old('encryption') == 'ssl' ? 'selected' : '' }}>
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
                                            <option value="password" {{ old('auth_type', 'password') == 'password' ? 'selected' : '' }}>
                                                パスワード認証
                                            </option>
                                            <option value="oauth" {{ old('auth_type') == 'oauth' ? 'selected' : '' }}>
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
                                               value="{{ old('username') }}"
                                               required
                                               placeholder="user@example.com"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        @error('username')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div id="password-field">
                                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            パスワード <span class="text-red-500">*</span>
                                        </label>
                                        <input type="password" 
                                               id="password" 
                                               name="password"
                                               required
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        @error('password')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div id="oauth-fields" style="display: none;">
                                        <div class="space-y-6">
                                            <div>
                                                <label for="oauth_client_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                    OAuth Client ID <span class="text-red-500">*</span>
                                                </label>
                                                <input type="text" 
                                                       id="oauth_client_id" 
                                                       name="oauth_client_id" 
                                                       value="{{ old('oauth_client_id') }}"
                                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                                @error('oauth_client_id')
                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            
                                            <div>
                                                <label for="oauth_client_secret" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                    OAuth Client Secret <span class="text-red-500">*</span>
                                                </label>
                                                <input type="password" 
                                                       id="oauth_client_secret" 
                                                       name="oauth_client_secret"
                                                       value="{{ old('oauth_client_secret') }}"
                                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                                @error('oauth_client_secret')
                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <label for="from_address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            送信元メールアドレス <span class="text-red-500">*</span>
                                        </label>
                                        <input type="email" 
                                               id="from_address" 
                                               name="from_address" 
                                               value="{{ old('from_address') }}"
                                               required
                                               placeholder="noreply@example.com"
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
                                               value="{{ old('from_name') }}"
                                               required
                                               placeholder="株式会社Example"
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
                                    作成
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
        
        // パスワードフィールドの必須属性を切り替え
        const passwordField = document.getElementById('password');
        const clientIdField = document.getElementById('oauth_client_id');
        const clientSecretField = document.getElementById('oauth_client_secret');
        
        if (isOAuth) {
            passwordField.removeAttribute('required');
            clientIdField.setAttribute('required', 'required');
            clientSecretField.setAttribute('required', 'required');
        } else {
            passwordField.setAttribute('required', 'required');
            clientIdField.removeAttribute('required');
            clientSecretField.removeAttribute('required');
        }
    });
 
    // 初期表示の設定
    document.getElementById('auth_type').dispatchEvent(new Event('change'));
    </script>
 </x-app-layout>