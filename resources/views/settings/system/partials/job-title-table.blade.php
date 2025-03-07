<div class="table-wrapper">
    <p>Job Title</p>

    <div class="top-table">
        <div class="table-add">
            <button type="button" class="table-add"><p>Add Job</p></button>
        </div>
        <!-- ...existing table controls... -->
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
                <!-- ...existing table rows... -->
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
    // Job Title checkbox logic
    const selectAll_jobTitle = document.getElementById('selectAll-jobTitle');
    const allCheckbox_jobTitle = document.querySelectorAll('.tbody-jobTitle input[type=checkbox]:not(#selectAll-jobTitle)');
    // ...existing checkbox script...
</script>
@endpush
