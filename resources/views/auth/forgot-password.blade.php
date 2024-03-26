<x-guest-layout>
    <div class='padding_30_50'>
        <div class="mb-4 text-sm text-gray-600">
            {{ __('パスワードをお忘れですか?') }}
        </div>
        <div class="mb-4 text-sm text-gray-600 margin_top_-14px">
            {{ __('パスワード再設定用のメールを送信するので, メールアドレスを入力してください.') }}
        </div>
    
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />
    
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
    
            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('メールアドレス')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
    
            <div class="flex items-center justify-end mt-4">
                <x-primary-button>
                    {{ __('パスワード再設定用のメールを送信') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
