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
                    <td style="width: 39px;"><input type="checkbox" id="selectAll-companyHolidays"></td>
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
    </div>
</div>

@push('scripts')
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
@endpush
