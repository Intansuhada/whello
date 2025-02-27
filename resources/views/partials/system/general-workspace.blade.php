<section class="content-detail active" id="general-workspace">
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
</section>