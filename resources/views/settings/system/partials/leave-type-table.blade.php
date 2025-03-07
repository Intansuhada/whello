<div class="table-wrapper">
    <p>Leave Type</p>
    <div class="top-table">
        <div class="table-add">
            <button class="table-add"><p>Add Leave</p></button>
        </div>
        <!-- ...existing table controls... -->
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
                <!-- Table rows content -->
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
    // Leave Type checkbox logic
    const selectAll_leaveType = document.getElementById('selectAll-leaveType');
    const allCheckbox_leaveType = document.querySelectorAll('.tbody-leaveType input[type=checkbox]');
    // ...existing checkbox script...
</script>
@endpush
