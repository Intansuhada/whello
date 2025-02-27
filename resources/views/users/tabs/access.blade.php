<div class="user-tab-content">
    <div class="tab-header">
        <h2>Access Management</h2>
    </div>
    <div class="tab-body">
        <div class="access-controls">
            <div class="form-group">
                <label>User Role</label>
                <select class="form-control" name="role">
                    <option value="user" {{ ($user->role ?? '') == 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ ($user->role ?? '') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="manager" {{ ($user->role ?? '') == 'manager' ? 'selected' : '' }}>Manager</option>
                </select>
            </div>
            <div class="permissions-list">
                <h3>Permissions</h3>
                <div class="permission-group">
                    <label class="checkbox-container">
                        <input type="checkbox" name="permissions[]" value="view_projects" 
                            {{ in_array('view_projects', $user->permissions ?? []) ? 'checked' : '' }}>
                        View Projects
                    </label>
                    <label class="checkbox-container">
                        <input type="checkbox" name="permissions[]" value="edit_projects"
                            {{ in_array('edit_projects', $user->permissions ?? []) ? 'checked' : '' }}>
                        Edit Projects
                    </label>
                    <label class="checkbox-container">
                        <input type="checkbox" name="permissions[]" value="delete_projects"
                            {{ in_array('delete_projects', $user->permissions ?? []) ? 'checked' : '' }}>
                        Delete Projects
                    </label>
                </div>
            </div>
        </div>
        <button class="save-access-btn">Save Changes</button>
    </div>
</div>
