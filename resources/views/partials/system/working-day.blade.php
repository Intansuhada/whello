<section class="content-detail" id="working-day">
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
</section>