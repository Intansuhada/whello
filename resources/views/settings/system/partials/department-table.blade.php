<div class="table-wrapper">
    <p>Department</p>

    <div class="top-table">
        <div class="table-add">
            <button type="button" class="table-add"><p>Add Department</p></button>
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
                    <td style="width: 467px;">Description</td>
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
                            <span>Development Team</span>
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
                            <span>Design Team</span>
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
    // Department checkbox logic
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
@endpush
