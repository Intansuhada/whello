<section class="content-detail" id="account-security">
    <div class="account-security">
        <div class="account-security-info">
            <div class="form-account-security">
                <p><strong>Phone Number</strong></p>
                <p>his is phone number</p>
                <input type="text" name="phone" placeholder="" value="+6282288126962">
            </div>
            <div class="form-account-security">
                <p><strong>Username</strong></p>
                <p>Username can be used for login.</p>
                <form action="{{ route('settings.profile.change-username') }}" id="form-change-username" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="text" name="username" placeholder="" value="{{ $user->username }}">
                </form>
                <span><a href="#" id="change-username">Change Username</a></span>
            </div>
            <div class="form-account-security">
                <p><strong>Email</strong></p>
                <p>You can still log in with your current email address or your new one.</p>
                <form action="{{ route('settings.profile.verify-new-email') }}" id="form-change-email" method="post">
                    @csrf
                    <input type="email" name="email" placeholder="" value="{{ $user->email }}">
                </form>
                <span><a href="#" id="change-email">Change Email</a></span>
            </div>
            <div class="form-account-security">
                <p><strong>Password</strong></p>
                <p>You can change your password here.</p>
                <div class="input-box">
                    <form action="{{ route('settings.profile.change-password') }}" id="form-change-password" method="POST">
                        @method('PUT')
                        @csrf
                        <input type="password" name="password" id="password" placeholder="Password">
                        <input type="password" name="password_confirmation" placeholder="Confirm Password">
                    </form>
                    <img src="{{ asset('images/eye-slash.svg') }}" id="eyeicon">
                    <div class="change">
                        <span><a href="#" id="change-password">Change Password</a></span>
                    </div>
                </div>
            </div>
            <div class="form-account-security">
                <p><strong>Two Factor Authentication</strong></p>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
            </div>
            
            <div class="toggle">
                <input class="input-toggle" type="checkbox" id="account-security">
                <label for="account-security" class="button-toggle"></label>
                <p>Activate Two Factor Authentication</p>
            </div>
    
            <div class="leave">
                <div class="button-leave">
                    <button>
                        <a href="">
                            <img src="{{ asset('images/export.svg') }}" alt="" class="icon">
                            <span>Leave From Workspace</span>
                        </a>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>