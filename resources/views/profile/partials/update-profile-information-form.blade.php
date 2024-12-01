<section class="mb-4">
    <header>
        <h2 class="h4 text-dark">
            {{ __('Profile Information') }}
        </h2>

        <p class="text-muted mt-2">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <!-- Verification Form -->
    <form id="send-verification" method="post" action="{{ route('verification.send') }}" class="d-none">
        @csrf
    </form>

    <!-- Profile Update Form -->
    <form method="post" action="{{ route('profile.update') }}" class="mt-4">
        @csrf
        @method('patch')

        <div class="mb-3">
            <label for="name" class="form-label">{{ __('Name') }}</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}"
                required autofocus autocomplete="name" />
            @if ($errors->has('name'))
            <div class="text-danger small mt-1">
                {{ $errors->first('name') }}
            </div>
            @endif
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}"
                required autocomplete="username" />
            @if ($errors->has('email'))
            <div class="text-danger small mt-1">
                {{ $errors->first('email') }}
            </div>
            @endif

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
            <div class="mt-3">
                <p class="text-muted small">
                    {{ __('Your email address is unverified.') }}

                    <button form="send-verification" class="btn btn-link p-0 text-decoration-none">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                <p class="text-success small mt-2">
                    {{ __('A new verification link has been sent to your email address.') }}
                </p>
                @endif
            </div>
            @endif
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary">
                {{ __('Save') }}
            </button>

            @if (session('status') === 'profile-updated')
            <p class="text-success small mb-0">
                {{ __('Saved.') }}
            </p>
            @endif
        </div>
    </form>
</section>