@extends('app')

@section('content')
    @include('partials.navbar')
    <div class="content">
        @include('partials.sidebar')
        <div class="user-wrapper">
            <div class="user-info">
                <div class="user-invite-overview">
                    <div class="user-invite">
                        <!-- Notifikasi Berhasil atau Gagal -->
                        @if (session('success'))
                            <div class="notify-popup">
                                <div class="notify-invite">
                                    <div class="notify-content">
                                        <p> {{ session('success') }} </p>
                                        <button type="button" class="oke-btn" id="oke-close">Oke</button>
                                    </div>
                                </div>
                            </div>
                        @elseif (session('error'))
                            <div class="notify-popup">
                                <div class="notify-invite">
                                    <div class="notify-content">
                                        <p class="error"> {{ session('error') }}</p>
                                        <button type="button" class="oke-btn" id="oke-close">Oke</button>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Tombol Invite -->
                        <div class="invite-people">
                            <button class="invite-btn" id="invite-btn">
                                <img src="{{ asset('images/user-invite.svg') }}" alt="Invite People">
                                Invite People
                            </button>
                            <div class="icons-container">
                                <img src="{{ asset('images/filter.svg') }}" alt="Filter">
                                <img src="{{ asset('images/sort.svg') }}" alt="Sort">
                                <img src="{{ asset('images/setting.svg') }}" alt="Setting">
                            </div>
                        </div>

                        <!-- Form Pencarian -->
                        <div class="search-container">
                            <input type="text" placeholder="Search Peoples" class="search-input">
                            <i class="fa fa-search search-icon"></i>
                        </div>

                        <!-- Daftar Pengguna Aktif -->
                        @foreach ($users as $user)
                            <div class="user-profile">
                                <img src="{{ asset('images/change-photo.svg') }}" alt="Avatar" class="profile-img">
                                <div class="profile-info">
                                    <p class="profile-name">{{ $user->email }}</p>
                                    <p class="profile-position">Aktif</p>
                                </div>
                            </div>
                        @endforeach

                        <!-- Daftar Pengguna yang Menunggu Aktivasi -->
                        @if (!$pendingUsers->isEmpty())
                            <hr>
                            @foreach ($pendingUsers as $pending)
                                <div class="user-profile pending-invite">
                                    <img src="{{ asset('images/account.svg') }}" alt="Avatar" class="profile-img">
                                    <div class="profile-info">
                                        <p class="profile-name">{{ $pending->email }}</p>
                                        <p class="profile-position">Pending...</p>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <!-- Popup Modal Undangan -->
                <div id="invite-popup" class="invite-popup">
                    <div class="popup-content">
                        <div class="header-popup-invite">
                            <h2>Invite People</h2>
                            <span class="close" id="popup-close-btn">&times;</span>
                        </div>

                        <form action="{{ route('users.invite') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="invite-email">Email</label>
                                <input type="email" id="invite-email" name="email" placeholder="Enter email" required>
                            </div>
                            <button type="submit" class="send-btn">Send</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
