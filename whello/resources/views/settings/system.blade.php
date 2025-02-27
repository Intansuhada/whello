@extends('app')


@section('content')

@include('partials.navbar')

<div class="content">

@include('partials.sidebar')

    <div class="wrapper-system-content">

        <div class="breadcrumb">
            <span>General Workspace</span>
            <div class="link-breadcrumb">
                <ul>
                    <li><a href="/">Whello</a></li>
                    <li>system settings</li>
                </ul>
            </div>
        </div>

        <div class="setting-profile-wrapper">
            <div class="profile-menu-wrapper">
                <ul class="profile-menu">
                    <li class="profile-items">
                        <a href="" class="profile-link">
                            <img src="{{ asset('images/briefcase.svg') }}" alt="" class="icon">
                            <span>General Workspace</span>
                        </a>
                    </li>
                    <li class="profile-items">
                        <a href="" class="profile-link">
                            <img src="{{ asset('images/timer-pause.svg') }}" alt="" class="icon">
                            <span>Working Day</span>
                        </a>
                    </li>
                    <li class="profile-items">
                        <a href="" class="profile-link">
                            <img src="{{ asset('images/timer-pause.svg') }}" alt="" class="icon">
                            <span>Project Utility</span>
                        </a>
                    </li>
                    <li class="profile-items">
                        <a href="" class="profile-link">
                            <img src="{{ asset('images/timer-pause.svg') }}" alt="" class="icon">
                            <span>Time & Expenses</span>
                        </a>
                    </li>
                    <li class="profile-divider"></li> <!-- Separator -->
                </ul>
            </div>

            <div class="system-info-wrapper">

                <div class="general-workspace">
                    <div class="general-workspace-info">
                        <div class="form-system-setting">
                            <p><strong>Workspace Name</strong></p>
                            <p>Lorem Ipsum is simply dummy text.</p>
                            <input type="text" placeholder="" value="Whello" class="input-general-workspace">
                        </div>
                        <div class="form-system-setting">
                            <p><strong>Photo Profile</strong></p>
                            <p>Lorem Ipsum is simply dummy text.</p>
                            <div class="company-logo-placeholder">
                                <img src="{{ asset('images/image-company-logo.svg') }}" alt="Change Photo">
                                <div class="overlay">Change Photo</div>
                                <button class="close-photo">X</button>
                            </div>
                        </div>
                        <div class="form-system-setting">
                            <p><strong>Description</strong></p>
                            <p>Lorem Ipsum is simply dummy text.</p>
                            <textarea name="" id="" cols="30" rows="3">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text</textarea>
                        </div>
                        <div class="form-system-setting">
                            <p><strong>URL / Slug</strong></p>
                            <p>Lorem Ipsum is simply dummy text.</p>
                            <input type="text" placeholder="" value="/ whello /" class="input-general-workspace">
                        </div>
                        <div class="form-system-setting">
                            <p><strong>Owner</strong></p>
                            <p>Lorem Ipsum is simply dummy text.</p>
                            <input type="text" placeholder="" value="sigit@whello.id" class="input-general-workspace">
                        </div>
                        <div class="form-system-setting">
                            <p><strong>Team Member</strong></p>
                            <p>Lorem Ipsum is simply dummy text.</p>
                            <input type="text" placeholder="" value="23" class="input-general-workspace">
                        </div>
                        <div class="form-system-setting">
                            <p><strong>Time Zone</strong></p>
                            <p>Lorem Ipsum is simply dummy text.</p>
                            <select name="" id="" class="select-general-workspace">
                                <option value="">Bangkok, Hanoi, Jakarta (UTC+07:00)</option>
                            </select>
                        </div>
                        <div class="form-system-setting">
                            <p><strong>Time Format</strong></p>
                            <p>Lorem Ipsum is simply dummy text.</p>
                            <select name="" id="" class="select-general-workspace">
                                <option value="">12 Hour Day</option>
                            </select>
                        </div>
                        <div class="form-system-setting">
                            <p><strong>Date Format</strong></p>
                            <p>Lorem Ipsum is simply dummy text.</p>
                            <input type="date" placeholder="" value="-" class="input-general-workspace">
                        </div>
                        <div class="form-system-setting">
                            <p><strong>Default Language</strong></p>
                            <p>Lorem Ipsum is simply dummy text.</p>
                            <select name="" id="" class="select-general-workspace">
                                <option value="">English</option>
                            </select>
                        </div>
                        <div class="form-system-setting">
                            <p><strong>Default Currency</strong></p>
                            <p>Lorem Ipsum is simply dummy text.</p>
                            <select name="" id="" class="select-general-workspace">
                                <option value="">Indonesiia - IDR / Rupiah</option>
                            </select>
                        </div>
                        <div class="form-system-setting">
                            <p><strong>Default Company Hourly Rate</strong></p>
                            <p>Lorem Ipsum is simply dummy text.</p>
                            <input type="text" placeholder="" value="Rp 500.000,-" class="input-general-workspace">
                        </div>

                        <div class="table-wrapper">
                            <p>Job Title</p>

                            <div class="top-table">
                                <div class="table-add">
                                    <button class="table-add"><p>Add Job</p></button>
                                </div>
                                <div class="bulk-action">
                                    <select name="" id="" class="select-bulk-action">
                                        <option value=""><p>Bulk Action</p></option>
                                    </select>
                                </div>
                                <div class="apply">
                                    <button><p>Apply</p></button>
                                </div>
                                <div class="filter-hide-export">
                                    <button>
                                        <a href="">
                                            <img src="{{ asset('images/filters.svg') }}" alt="">
                                            <span>Filter</span>
                                        </a>
                                    </button>
                                    <button>
                                        <a href="">
                                            <img src="{{ asset('images/eye-slash.svg') }}" alt="">
                                            <span>Hide</span>
                                        </a>
                                    </button>
                                    <button>
                                        <a href="">
                                            <img src="{{ asset('images/cloud-download.svg') }}" alt="">
                                            <span>Export</span>
                                        </a>
                                    </button>
                                </div>
                                <div class="three-dots">
                                    <button>
                                        <p>•••</p>
                                    </button>
                                </div>
                                <div class="search-wrapper">
                                    <div class="search-table">
                                        <input type="text" placeholder="Search..." class="table-search-input">
                                        <img src="{{ asset('images/search-table.svg') }}" alt="Search Icon" class="search-icon">
                                    </div>
                                </div>
                            </div>

                            <div class="table-holidays">
                                <table>

                                    <thead>
                                        <tr>
                                            <td style="width: 39px;"><input type="checkbox" id="selectAll-jobTitle"></td>
                                            <td style="width: 250px;">Date of Holidays</td>
                                            <td style="width: 467px;">Holidays Type</td>
                                            <td style="width: 45px;"></td>
                                        </tr>
                                    </thead>

                                    <tbody class="tbody-jobTitle">
                                        <tr>
                                            <td><input type="checkbox"></td>
                                            <td>Wenesday,29 September 2024</td>
                                            <td>
                                                <div class="round-span">
                                                    <div class="round-color"></div>
                                                    <span>Hari Raya Idul Adha 1444 Hijriyah</span>
                                                </div>
                                            </td>
                                            <td><a href="">•••</a></td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox"></td>
                                            <td>Wenesday,29 September 2024</td>
                                            <td>
                                                <div class="round-span">
                                                    <div class="round-color"></div>
                                                    <span>Hari Raya Idul Adha 1444 Hijriyah</span>
                                                </div>
                                            </td>
                                            <td><a href="">•••</a></td>
                                        </tr>
                                    </tbody>
                                </table>

                                <script>
                                    const selectAll_jobTitle = document.getElementById('selectAll-jobTitle');
                                    const allCheckbox_jobTitle = document.querySelectorAll('.tbody-jobTitle input[type=checkbox]:not(#selectAll-jobTitle)');
                                    let listBoolean_jobTitle = [];

                                    allCheckbox_jobTitle.forEach(item => {
                                        item.addEventListener('change', function () {
                                            allCheckbox_jobTitle.forEach(i => {
                                                listBoolean_jobTitle.push(i.checked);
                                            })
                                            if(listBoolean_jobTitle.includes(false)) {
                                                selectAll_jobTitle.checked = false;
                                            }else{
                                                selectAll_jobTitle.checked = true;
                                            }
                                            listBoolean_jobTitle = []
                                        })
                                    })

                                    selectAll_jobTitle.addEventListener('change', function () {
                                        if(this.checked) {
                                            allCheckbox_jobTitle.forEach(i => {
                                                i.checked = true;
                                            })
                                        }else{
                                            allCheckbox_jobTitle.forEach(i => {
                                                i.checked = false;
                                            })
                                        }
                                    })
                                </script>

                            </div>
                        </div>

                        <div class="table-wrapper">
                            <p>Department</p>

                            <div class="top-table">
                                <div class="table-add">
                                    <button class="table-add"><p>Add Department</p></button>
                                </div>
                                <div class="bulk-action">
                                    <select name="" id="" class="select-bulk-action">
                                        <option value=""><p>Bulk Action</p></option>
                                    </select>
                                </div>
                                <div class="apply">
                                    <button><p>Apply</p></button>
                                </div>
                                <div class="filter-hide-export">
                                    <button>
                                        <a href="">
                                            <img src="{{ asset('images/filters.svg') }}" alt="">
                                            <span>Filter</span>
                                        </a>
                                    </button>
                                    <button>
                                        <a href="">
                                            <img src="{{ asset('images/eye-slash.svg') }}" alt="">
                                            <span>Hide</span>
                                        </a>
                                    </button>
                                    <button>
                                        <a href="">
                                            <img src="{{ asset('images/cloud-download.svg') }}" alt="">
                                            <span>Export</span>
                                        </a>
                                    </button>
                                </div>
                                <div class="three-dots">
                                    <button>
                                        <p>•••</p>
                                    </button>
                                </div>
                                <div class="search-wrapper">
                                    <div class="search-table">
                                        <input type="text" placeholder="Search..." class="table-search-input">
                                        <img src="{{ asset('images/search-table.svg') }}" alt="Search Icon" class="search-icon">
                                    </div>
                                </div>
                            </div>

                            <div class="table-holidays">
                                <table>

                                    <thead>
                                        <tr>
                                            <td style="width: 39px;"><input type="checkbox" id="selectAll-department"></td>
                                            <td style="width: 250px;">Department Name</td>
                                            <td style="width: 467px;">Holidays Type</td>
                                            <td style="width: 45px;"></td>
                                        </tr>
                                    </thead>

                                    <tbody class="tbody-department">
                                        <tr>
                                            <td><input type="checkbox"></td>
                                            <td>Website Development</td>
                                            <td>
                                                <div class="round-span">
                                                    <div class="round-color"></div>
                                                    <span>Hari Raya Idul Adha 1444 Hijriyah</span>
                                                </div>
                                            </td>
                                            <td><a href="">•••</a></td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox"></td>
                                            <td>UI/UX Design</td>
                                            <td>
                                                <div class="round-span">
                                                    <div class="round-color"></div>
                                                    <span>Hari Raya Idul Adha 1444 Hijriyah</span>
                                                </div>
                                            </td>
                                            <td><a href="">•••</a></td>
                                        </tr>
                                    </tbody>
                                </table>

                                <script>
                                    const selectAll_department = document.getElementById('selectAll-department');
                                    const allCheckbox_department = document.querySelectorAll('.tbody-department input[type=checkbox]:not(#selectAll-department)');
                                    let listBoolean_department = [];

                                    allCheckbox_department.forEach(item => {
                                        item.addEventListener('change', function () {
                                            allCheckbox_department.forEach(i => {
                                                listBoolean_department.push(i.checked);
                                            })
                                            if(listBoolean_department.includes(false)) {
                                                selectAll_department.checked = false;
                                            }else{
                                                selectAll_department.checked = true;
                                            }
                                            listBoolean_department = []
                                        })
                                    })

                                    selectAll_department.addEventListener('change', function () {
                                        if(this.checked) {
                                            allCheckbox_department.forEach(i => {
                                                i.checked = true;
                                            })
                                        }else{
                                            allCheckbox_department.forEach(i => {
                                                i.checked = false;
                                            })
                                        }
                                    })
                                </script>

                            </div>
                        </div>

                    </div>
                </div>

                <div class="working-day">
                    <div class="working-day-info">
                        <div class="form-working-day">
                            <p><strong>Default Working Days & Hours </strong></p>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
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

                        <li class="profile-divider"></li> <!-- Separator -->

                        <div class="form-working-day-setting">
                            <p><strong>Time Zone</strong></p>
                            <p>Lorem Ipsum is simply dummy text.</p>
                            <select name="" id="">
                                <option value="">Sunday</option>
                                <option value="">Monday</option>
                                <option value="">Tuesday</option>
                                <option value="">Wednesday</option>
                                <option value="">Thursday</option>
                                <option value="">Friday</option>
                                <option value="">Saturday</option>
                            </select>
                        </div>

                        <li class="profile-divider"></li> <!-- Separator -->

                        <div class="table-wrapper">
                            <p>Leave Type</p>

                            <div class="top-table">
                                <div class="table-add">
                                    <button class="table-add"><p>Add Leave</p></button>
                                </div>
                                <div class="bulk-action">
                                    <select name="" id="" class="select-bulk-action">
                                        <option value=""><p>Bulk Action</p></option>
                                    </select>
                                </div>
                                <div class="apply">
                                    <button><p>Apply</p></button>
                                </div>
                                <div class="filter-hide-export">
                                    <button>
                                        <a href="">
                                            <img src="{{ asset('images/filters.svg') }}" alt="">
                                            <span>Filter</span>
                                        </a>
                                    </button>
                                    <button>
                                        <a href="">
                                            <img src="{{ asset('images/eye-slash.svg') }}" alt="">
                                            <span>Hide</span>
                                        </a>
                                    </button>
                                    <button>
                                        <a href="">
                                            <img src="{{ asset('images/cloud-download.svg') }}" alt="">
                                            <span>Export</span>
                                        </a>
                                    </button>
                                </div>
                                <div class="three-dots">
                                    <button>
                                        <p>•••</p>
                                    </button>
                                </div>
                                <div class="search-wrapper">
                                    <div class="search-table">
                                        <input type="text" placeholder="Search..." class="table-search-input">
                                        <img src="{{ asset('images/search-table.svg') }}" alt="Search Icon" class="search-icon">
                                    </div>
                                </div>
                            </div>

                            <div class="table-holidays">
                                <table>

                                    <thead>
                                        <tr>
                                            <td style="width: 40px;"><input type="checkbox" id="selectAll-leaveType"></td>
                                            <td style="width: 280px;">Holidays Names</td>
                                            <td style="width: 230px;">Date of Holidays Type</td>
                                            <td style="width: 125px;">Paid Type</td>
                                            <td style="width: 100px;">Color</td>
                                            <td style="width: 40px;"></td>
                                        </tr>
                                    </thead>


                                    <tbody class="tbody-leaveType">
                                        <tr>
                                            <td><input type="checkbox"></td>
                                            <td>Hari Raya Idul Adha 1444 Hijriyah</td>
                                            <td>Half Day in the Afternoon</td>
                                            <td>Paid Type</td>
                                            <td>
                                                <div class="box-color"></div>
                                            </td>
                                            <td><a href="">•••</a></td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox"></td>
                                            <td>Hari Raya Idul Adha 1444 Hijriyah</td>
                                            <td>Half Day in the Afternoon</td>
                                            <td>Paid Type</td>
                                            <td>
                                                <div class="box-color"></div>
                                            </td>
                                            <td><a href="">•••</a></td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox"></td>
                                            <td>Hari Raya Idul Adha 1444 Hijriyah</td>
                                            <td>Half Day in the Afternoon</td>
                                            <td>Paid Type</td>
                                            <td>
                                                <div class="box-color"></div>
                                            </td>
                                            <td><a href="">•••</a></td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox"></td>
                                            <td>Hari Raya Idul Adha 1444 Hijriyah</td>
                                            <td>Half Day in the Afternoon</td>
                                            <td>Paid Type</td>
                                            <td>
                                                <div class="box-color"></div>
                                            </td>
                                            <td><a href="">•••</a></td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox"></td>
                                            <td>Hari Raya Idul Adha 1444 Hijriyah</td>
                                            <td>Half Day in the Afternoon</td>
                                            <td>Paid Type</td>
                                            <td>
                                                <div class="box-color"></div>
                                            </td>
                                            <td><a href="">•••</a></td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox"></td>
                                            <td>Hari Raya Idul Adha 1444 Hijriyah</td>
                                            <td>Half Day in the Afternoon</td>
                                            <td>Paid Type</td>
                                            <td>
                                                <div class="box-color"></div>
                                            </td>
                                            <td><a href="">•••</a></td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox"></td>
                                            <td>Hari Raya Idul Adha 1444 Hijriyah</td>
                                            <td>Half Day in the Afternoon</td>
                                            <td>Paid Type</td>
                                            <td>
                                                <div class="box-color"></div>
                                            </td>
                                            <td><a href="">•••</a></td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox"></td>
                                            <td>Hari Raya Idul Adha 1444 Hijriyah</td>
                                            <td>Half Day in the Afternoon</td>
                                            <td>Paid Type</td>
                                            <td>
                                                <div class="box-color"></div>
                                            </td>
                                            <td><a href="">•••</a></td>
                                        </tr>
                                    </tbody>
                                </table>

                                <script>
                                    const selectAll_leaveType = document.getElementById('selectAll-leaveType');
                                    const allCheckbox_leaveType = document.querySelectorAll('.tbody-leaveType input[type=checkbox]:not(#selectAll-leaveType)');
                                    let listBoolean_leaveType = [];

                                    allCheckbox_leaveType.forEach(item => {
                                        item.addEventListener('change', function () {
                                            allCheckbox_leaveType.forEach(i => {
                                                listBoolean_leaveType.push(i.checked);
                                            })
                                            if(listBoolean_leaveType.includes(false)) {
                                                selectAll_leaveType.checked = false;
                                            }else{
                                                selectAll_leaveType.checked = true;
                                            }
                                            listBoolean_leaveType = []
                                        })
                                    })

                                    selectAll_leaveType.addEventListener('change', function () {
                                        if(this.checked) {
                                            allCheckbox_leaveType.forEach(i => {
                                                i.checked = true;
                                            })
                                        }else{
                                            allCheckbox_leaveType.forEach(i => {
                                                i.checked = false;
                                            })
                                        }
                                    })
                                </script>

                            </div>
                        </div>

                        <li class="profile-divider"></li> <!-- Separator -->

                        <div class="table-wrapper">
                            <p>Company Holidays</p>

                            <div class="top-table">
                                <div class="table-add">
                                    <button class="table-add"><p>Add Leave</p></button>
                                </div>
                                <div class="bulk-action">
                                    <select name="" id="" class="select-bulk-action">
                                        <option value=""><p>Bulk Action</p></option>
                                    </select>
                                </div>
                                <div class="apply">
                                    <button><p>Apply</p></button>
                                </div>
                                <div class="filter-hide-export">
                                    <button>
                                        <a href="">
                                            <img src="{{ asset('images/filters.svg') }}" alt="">
                                            <span>Filter</span>
                                        </a>
                                    </button>
                                    <button>
                                        <a href="">
                                            <img src="{{ asset('images/eye-slash.svg') }}" alt="">
                                            <span>Hide</span>
                                        </a>
                                    </button>
                                    <button>
                                        <a href="">
                                            <img src="{{ asset('images/cloud-download.svg') }}" alt="">
                                            <span>Export</span>
                                        </a>
                                    </button>
                                </div>
                                <div class="three-dots">
                                    <button>
                                        <p>•••</p>
                                    </button>
                                </div>
                                <div class="search-wrapper">
                                    <div class="search-table">
                                        <input type="text" placeholder="Search..." class="table-search-input">
                                        <img src="{{ asset('images/search-table.svg') }}" alt="Search Icon" class="search-icon">
                                    </div>
                                </div>
                            </div>

                            <div class="table-holidays">
                                <table>

                                    <thead>
                                        <tr>
                                            <td style="width: 39px;"><input type="checkbox" id='selectAll-companyHolidays'></td>
                                            <td style="width: 250px;">Date of Holidays</td>
                                            <td style="width: 467px;">Holidays Type</td>
                                            <td style="width: 45px;"></td>
                                        </tr>
                                    </thead>

                                    <tbody class="tbody-companyHolidays">
                                        <tr>
                                            <td><input type="checkbox"></td>
                                            <td>Wednesday, 29 September 2024</td>
                                            <td>
                                                <div class="round-span">
                                                    <div class="round-color"></div>
                                                    <span>Hari Raya Idul Adha 1444 Hijriyah</span>
                                                </div>
                                            </td>
                                            <td><a href="">•••</a></td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox"></td>
                                            <td>Wednesday, 29 September 2024</td>
                                            <td>
                                                <div class="round-span">
                                                    <div class="round-color"></div>
                                                    <span>Hari Raya Idul Adha 1444 Hijriyah</span>
                                                </div>
                                            </td>
                                            <td><a href="">•••</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <script>
                                    const selectAll_companyHolidays = document.getElementById('selectAll-companyHolidays');
                                    const allCheckbox_companyHolidays = document.querySelectorAll('.tbody-companyHolidays input[type=checkbox]:not(#selectAll-companyHolidays)');
                                    let listBoolean_companyHolidays = [];

                                    allCheckbox_companyHolidays.forEach(item => {
                                        item.addEventListener('change', function () {
                                            allCheckbox_companyHolidays.forEach(i => {
                                                listBoolean_companyHolidays.push(i.checked);
                                            })
                                            if(listBoolean_companyHolidays.includes(false)) {
                                                selectAll_companyHolidays.checked = false;
                                            }else{
                                                selectAll_companyHolidays.checked = true;
                                            }
                                            listBoolean_companyHolidays = []
                                        })
                                    })

                                    selectAll_companyHolidays.addEventListener('change', function () {
                                        if(this.checked) {
                                            allCheckbox_companyHolidays.forEach(i => {
                                                i.checked = true;
                                            })
                                        }else{
                                            allCheckbox_companyHolidays.forEach(i => {
                                                i.checked = false;
                                            })
                                        }
                                    })
                                </script>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="project-utility">
                    <div class="project-utility-info">
                        <div class="project-utility-content1">
                            <p>Project-Utility</p>
                        </div>
                        <li class="profile-divider"></li> <!-- Separator -->
                        <div class="project-utility-content2">
                            <p>Project-Utility</p>
                        </div>
                    </div>
                </div>

                <li class="profile-divider"></li> <!-- Separator -->

                <div class="time-and-expenses">
                    <div class="time-and-expenses-info">
                        <div class="time-and-expenses-content1">
                            <p>Time & Expenses</p>
                        </div>
                        <li class="profile-divider"></li> <!-- Separator -->
                        <div class="time-and-expenses-content2">
                            <p>Time & Expenses</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
