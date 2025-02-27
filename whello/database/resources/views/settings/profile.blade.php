@extends('app')

@section('content')
    @include('partials.sidebar')
    <div class="wrapper-profile-content">

        <div class="breadcrumb">
            <span>Basic Profile</span>
            <div class="link-breadcrumb">
                <ul>
                    <li><a href="/">Whello</a></li>
                    <li>my profile setting</li>
                </ul>
            </div>
        </div>

        <div class="setting-profile-wrapper">
            <div class="profile-menu-wrapper">
                <ul class="profile-menu">
                    <li class="profile-items">
                        <a href="" class="profile-link">
                            <img src="{{ asset('images/profile-circle.svg') }}" alt="" class="icon">
                            <span>Basic Profile</span>
                        </a>
                    </li>
                    <li class="profile-items">
                        <a href="" class="profile-link">
                            <img src="{{ asset('images/shield-slash.svg') }}" alt="" class="icon">
                            <span>Account & Security</span>
                        </a>
                    </li>
                    <li class="profile-items">
                        <a href="" class="profile-link">
                            <img src="{{ asset('images/notification-bing.svg') }}" alt="" class="icon">
                            <span>Notifications</span>
                        </a>
                    </li>
                    <li class="profile-divider"></li> <!-- Separator -->
                </ul>
            </div>

            <div class="profile-info-wrapper">
                <div class="myprofile">
                    <div class="profile-info">
                        <div class="photo-profile">
                            <p><strong>Photo Profile</strong></p>
                            <p>Lorem Ipsum is simply dummy text.</p>
                            <div class="profile-photo-placeholder">
                                <img src="{{ asset('images/change-photo.svg') }}" alt="Change Photo">
                                <div class="overlay">Change Photo</div>
                                <input type="file" id="photo-input" style="display: none;">
                                <button class="close-photo">x</button>
                            </div>
                        </div>

                        <div class="form-profile">
                            <p><strong>Nickname</strong></p>
                            <p>Lorem Ipsum is simply dummy text.</p>
                            <input type="text" placeholder="" value="-">
                        </div>

                        <div class="form-profile">
                            <p><strong>Full Name</strong></p>
                            <p>Lorem Ipsum is simply dummy text.</p>
                            <input type="text" placeholder="" value="{{ Auth::user()->name }}">
                        </div>

                        <div class="form-profile">
                            <p><strong>About Me</strong></p>
                            <p>Lorem Ipsum is simply dummy text.</p>
                            <textarea placeholder="">-</textarea>
                        </div>

                        <div class="form-profile">
                            <p><strong>Job Title</strong></p>
                            <p>Lorem Ipsum is simply dummy text.</p>
                            <input type="text" placeholder="" value="-">
                        </div>

                        <div class="form-profile">
                            <p><strong>Department</strong></p>
                            <p>Lorem Ipsum is simply dummy text.</p>
                            <input type="text" placeholder="" value="-">
                        </div>

                        <div class="form-profile">
                            <p><strong>Default Working Days & Hours</strong></p>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has
                                been the industry's standard dummy text ever since the 1500s, when an unknown printer took a
                                galley of type and scrambled it to make a type specimen book.</p>
                        </div>
                        <div class="oclock-and-day">
                            <div class="toggle-day">
                                <div class="toggle">
                                    <input class="input-toggle" type="checkbox" id="sunday">
                                    <label for="sunday" class="button-toggle"></label>
                                    <p>Sunday</p>
                                </div>
                                <div class="toggle">
                                    <input class="input-toggle" type="checkbox" id="monday">
                                    <label for="monday" class="button-toggle"></label>
                                    <p>Monday</p>
                                </div>
                                <div class="toggle">
                                    <input class="input-toggle" type="checkbox" id="tuesday">
                                    <label for="tuesday" class="button-toggle"></label>
                                    <p>Tuesday</p>
                                </div>
                                <div class="toggle">
                                    <input class="input-toggle" type="checkbox" id="wednesday">
                                    <label for="wednesday" class="button-toggle"></label>
                                    <p>Wednesday</p>
                                </div>
                                <div class="toggle">
                                    <input class="input-toggle" type="checkbox" id="thursday">
                                    <label for="thursday" class="button-toggle"></label>
                                    <p>Thursday</p>
                                </div>
                                <div class="toggle">
                                    <input class="input-toggle" type="checkbox" id="friday">
                                    <label for="friday" class="button-toggle"></label>
                                    <p>Friday</p>
                                </div>
                                <div class="toggle">
                                    <input class="input-toggle" type="checkbox" id="saturday">
                                    <label for="saturday" class="button-toggle"></label>
                                    <p>Saturday</p>
                                </div>
                            </div>
                            <div class="set-waktu">
                                <div class="form-set-waktu">
                                    <input type="text" class="set-oclock" value="08.00 AM">
                                    <span>to</span>
                                    <input type="text" class="set-oclock" value="12.00 AM">
                                    <span>&</span>
                                    <input type="text" class="set-oclock" value="13.00 PM">
                                    <span>to</span>
                                    <input type="text" class="set-oclock" value="05.00 PM">
                                </div>
                                <div class="form-set-waktu">
                                    <input type="text" class="set-oclock" value="08.00 AM">
                                    <span>to</span>
                                    <input type="text" class="set-oclock" value="12.00 AM">
                                    <span>&</span>
                                    <input type="text" class="set-oclock" value="13.00 PM">
                                    <span>to</span>
                                    <input type="text" class="set-oclock" value="05.00 PM">
                                </div>
                                <div class="form-set-waktu">
                                    <input type="text" class="set-oclock" value="08.00 AM">
                                    <span>to</span>
                                    <input type="text" class="set-oclock" value="12.00 AM">
                                    <span>&</span>
                                    <input type="text" class="set-oclock" value="13.00 PM">
                                    <span>to</span>
                                    <input type="text" class="set-oclock" value="05.00 PM">
                                </div>
                                <div class="form-set-waktu">
                                    <input type="text" class="set-oclock" value="08.00 AM">
                                    <span>to</span>
                                    <input type="text" class="set-oclock" value="12.00 AM">
                                    <span>&</span>
                                    <input type="text" class="set-oclock" value="13.00 PM">
                                    <span>to</span>
                                    <input type="text" class="set-oclock" value="05.00 PM">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="account-security">
                    <div class="account-security-info">
                        <div class="form-account-security">
                            <p><strong>Phone Number</strong></p>
                            <p>Lorem Ipsum is simply dummy text.</p>
                            <input type="text" placeholder="" value="+62 8228 8126 962">
                        </div>
                        <div class="form-account-security">
                            <p><strong>Email</strong></p>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                            <input type="text" placeholder="" value="sigit@whello.id">
                            <span><a href="#">Change Email</a></span>
                        </div>
                        <div class="form-account-security">
                            <p><strong>Username</strong></p>
                            <p>Lorem Ipsum is simply dummy text of the printing.</p>
                            <input type="text" placeholder="" value="@sigitwhello">
                            <span><a href="#">Change Username</a></span>
                        </div>
                        <div class="form-account-security">
                            <p><strong>Password</strong></p>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                            <div class="input-box">
                                <input type="password" id="password" placeholder="Password">
                                <img src="{{ asset('images/eye-slash.svg') }}" id="eyeicon">
                                <div class="change">
                                    <span><a href="#">Change Password</a></span>
                                </div>
                            </div>

                            <script>
                                let eyeicon = document.getElementById("eyeicon");
                                let password = document.getElementById("password");

                                eyeicon.onclick = function() {
                                    if (password.type == "password") {
                                        password.type = "text";
                                        eyeicon.src = "{{ asset('images/eye.svg') }}"

                                    } else {
                                        password.type = "password";
                                        eyeicon.src = "{{ asset('images/eye-slash.svg') }}"
                                    }
                                }
                            </script>

                        </div>
                        <div class="form-account-security">
                            <p><strong>Two Factor Authentication</strong></p>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                        </div>

                        {{-- //toggle --}}

                        <div class="toggle">
                            <input class="input-toggle" type="checkbox" id="account-security">
                            <label for="account-security" class="button-toggle"></label>
                            <p>Lorem ipsum dolor sit amet consectetur.</p>
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
                <div class="notifications-wrapper">
                    <div class="notifications-info">
                        <div class="form-profile">
                            <p><strong>Notifications</strong></p>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has
                                been the industry's standard dummy text ever since the 1500s, when an unknown printer took a
                                galley of type and scrambled it to make a type specimen book.</p>
                        </div>
                    </div>
                    <div class="table-profile">
                        <table>
                            <thead>
                                <tr>
                                    <th style="width: 55%;" class="column-table">Activity in the Clients</th>
                                    <th style="width: 10%;">
                                        <div class="column-icon">
                                            <img src="{{ asset('images/notification-bing.svg') }}" alt=""
                                                class="icon">
                                            <span>Browser</span>
                                        </div>
                                    </th>
                                    <th style="width: 10%;">
                                        <div class="column-icon">
                                            <img src="{{ asset('images/sms-notification.svg') }}" alt=""
                                                class="icon">
                                            <span>Email</span>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <p>All activity in the client</p>
                                        <p>Lorem lpsum is simply dummy text of the printing and typesetting industry.</p>
                                    </td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-1">
                                                <label for="toggle-1" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-2">
                                                <label for="toggle-2" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Only when someone adds a new client</td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-3">
                                                <label for="toggle-3" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-4">
                                                <label for="toggle-4" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Only when someone blacklist client</td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-5">
                                                <label for="toggle-5" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-6">
                                                <label for="toggle-6" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Only when someone removed client</td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-7">
                                                <label for="toggle-7" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-8">
                                                <label for="toggle-8" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="table-profile">
                        <table>
                            <thead>
                                <thead>
                                    <tr>
                                        <th style="width: 55%;" class="column-table">Activity in the Projects</th>
                                        <th style="width: 10%;">
                                            <div class="column-icon">
                                                <img src="{{ asset('images/notification-bing.svg') }}" alt=""
                                                    class="icon">
                                                <span>Browser</span>
                                            </div>
                                        </th>
                                        <th style="width: 10%;">
                                            <div class="column-icon">
                                                <img src="{{ asset('images/sms-notification.svg') }}" alt=""
                                                    class="icon">
                                                <span>Email</span>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                            <tbody>
                                <tr>
                                    <td>All activity in the project board</td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-9">
                                                <label for="toggle-9" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-10">
                                                <label for="toggle-10" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Only when Someone adds a new project</td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-11">
                                                <label for="toggle-11" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-12">
                                                <label for="toggle-12" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Only when you are added or removed as a project manager</td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-13">
                                                <label for="toggle-13" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-14">
                                                <label for="toggle-14" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Only when you are added or removed as a collaborator</td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-15">
                                                <label for="toggle-15" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-16">
                                                <label for="toggle-16" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Only if there is a change in the priority level</td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-17">
                                                <label for="toggle-17" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-18">
                                                <label for="toggle-18" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Only if there is a change in the project status</td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-19">
                                                <label for="toggle-19" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-20">
                                                <label for="toggle-20" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Only if there is a change in the due dates</td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-21">
                                                <label for="toggle-21" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-22">
                                                <label for="toggle-22" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Only when the project has reached <input type="text" value="80%"> of the
                                        budget</td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-23">
                                                <label for="toggle-23" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-24">
                                                <label for="toggle-24" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Only when the project is complete</td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-25">
                                                <label for="toggle-25" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-26">
                                                <label for="toggle-26" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Only when someone removed the project</td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-27">
                                                <label for="toggle-27" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-28">
                                                <label for="toggle-28" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Only is there are new comments</td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-29">
                                                <label for="toggle-29" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-30">
                                                <label for="toggle-30" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Only if there is a thread for your comemnts</td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-31">
                                                <label for="toggle-31" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-32">
                                                <label for="toggle-32" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Only when you are mentioned</td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-33">
                                                <label for="toggle-33" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-34">
                                                <label for="toggle-34" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                            </thead>
                        </table>
                    </div>
                    <div class="table-profile">
                        <table>
                            <thead>
                                <thead>
                                    <tr>
                                        <th style="width: 55%;" class="column-table">Activity in the Tasks</th>
                                        <th style="width: 10%;">
                                            <div class="column-icon">
                                                <img src="{{ asset('images/notification-bing.svg') }}" alt=""
                                                    class="icon">
                                                <span>Browser</span>
                                            </div>
                                        </th>
                                        <th style="width: 10%;">
                                            <div class="column-icon">
                                                <img src="{{ asset('images/sms-notification.svg') }}" alt=""
                                                    class="icon">
                                                <span>Email</span>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                            <tbody>
                                <tr>
                                    <td>All activity in the task</td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-35">
                                                <label for="toggle-35" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-36">
                                                <label for="toggle-36" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Only when Someone adds a new task</td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-37">
                                                <label for="toggle-37" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-38">
                                                <label for="toggle-48" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Only when you are added or unassigned to the task</td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-39">
                                                <label for="toggle-39" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-40">
                                                <label for="toggle-40" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Only when you are added or removed as a supervisor</td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-41">
                                                <label for="toggle-41" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-42">
                                                <label for="toggle-42" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Only when you are added or removed as a quality control</td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-43">
                                                <label for="toggle-43" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-44">
                                                <label for="toggle-44" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Only if there is a change in the priority level</td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-45">
                                                <label for="toggle-45" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-46">
                                                <label for="toggle-46" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Only if there is a change in the task status</td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-47">
                                                <label for="toggle-47" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-48">
                                                <label for="toggle-48" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Only if there is a change in the due dates</td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-49">
                                                <label for="toggle-49" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-50">
                                                <label for="toggle-50" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Only when the task is complete</td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-51">
                                                <label for="toggle-51" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-52">
                                                <label for="toggle-52" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Only when someone removed the task</td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-53">
                                                <label for="toggle-53" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-54">
                                                <label for="toggle-54" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Only is there are new comments</td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-55">
                                                <label for="toggle-55" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-56">
                                                <label for="toggle-56" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Only if there is a thread for your comemnts</td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-57">
                                                <label for="toggle-57" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-58">
                                                <label for="toggle-58" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Only when you are mentioned</td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-59">
                                                <label for="toggle-59" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-70">
                                                <label for="toggle-70" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                            </thead>
                        </table>
                    </div>
                    <div class="table-profile">
                        <table>
                            <thead>
                                <thead>
                                    <tr>
                                        <th style="width: 55%;" class="column-table">Activity in the Users</th>
                                        <th style="width: 10%;">
                                            <div class="column-icon">
                                                <img src="{{ asset('images/notification-bing.svg') }}" alt=""
                                                    class="icon">
                                                <span>Browser</span>
                                            </div>
                                        </th>
                                        <th style="width: 10%;">
                                            <div class="column-icon">
                                                <img src="{{ asset('images/sms-notification.svg') }}" alt=""
                                                    class="icon">
                                                <span>Email</span>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                            <tbody>
                                <tr>
                                    <td>All activity in the user</td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-71">
                                                <label for="toggle-71" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-72">
                                                <label for="toggle-72" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Only when Someone adds a new user</td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-73">
                                                <label for="toggle-73" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-74">
                                                <label for="toggle-74" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Only when someone changes user role permissions</td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-75">
                                                <label for="toggle-75" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-76">
                                                <label for="toggle-76" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Only when someone changes user department</td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-77">
                                                <label for="toggle-77" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-78">
                                                <label for="toggle-78" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Only when someone changes user daily capacity</td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-79">
                                                <label for="toggle-79" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-80">
                                                <label for="toggle-80" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Only when someone changes user hourly rate</td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-81">
                                                <label for="toggle-81" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-82">
                                                <label for="toggle-82" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>OOnly when someone changes user hourly rate</td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-83">
                                                <label for="toggle-83" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-84">
                                                <label for="toggle-84" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Only when someone removed the user</td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-85">
                                                <label for="toggle-85" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-86">
                                                <label for="toggle-86" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                            </thead>
                        </table>
                    </div>
                    <div class="table-profile">
                        <table>
                            <thead>
                                <thead>
                                    <tr>
                                        <th style="width: 55%;" class="column-table">Activity in the Websites</th>
                                        <th style="width: 10%;">
                                            <div class="column-icon">
                                                <img src="{{ asset('images/notification-bing.svg') }}" alt=""
                                                    class="icon">
                                                <span>Browser</span>
                                            </div>
                                        </th>
                                        <th style="width: 10%;">
                                            <div class="column-icon">
                                                <img src="{{ asset('images/sms-notification.svg') }}" alt=""
                                                    class="icon">
                                                <span>Email</span>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                            <tbody>
                                <tr>
                                    <td>All activity in the website</td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-87">
                                                <label for="toggle-87" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-88">
                                                <label for="toggle-88" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Only when Someone adds a new website</td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-89">
                                                <label for="toggle-89" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-90">
                                                <label for="toggle-90" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Only when someone removed the website</td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-91">
                                                <label for="toggle-91" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="toggle-table">
                                            <div class="toggle-click">
                                                <input class="input-toggle" type="checkbox" id="toggle-92">
                                                <label for="toggle-92" class="button-toggle"></label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
