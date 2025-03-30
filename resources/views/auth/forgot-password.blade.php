<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <div class="flex md:w-1/2 justify-center py-10 items-center  bg-gradient-to-tr from-neutral-100 to-amber-50">
        <form method="POST" action="{{ route('password.email') }}">
            <h1 class="text-gray-800 font-bold text-4xl mb-1">Hello Again!</h1>
			<p class="text-xl font-normal text-gray-600 mb-7">Welcome Back</p>
            @csrf
    
            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
    
            <div class="flex items-center justify-end mt-4">
                <x-primary-button>
                    {{ __('Email Password Reset Link') }}
                </x-primary-button>
            </div>
        </form>
    </div>

</x-guest-layout>
