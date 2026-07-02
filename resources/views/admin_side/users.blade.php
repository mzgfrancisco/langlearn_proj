@extends('layouts.admin')

@section('main-content')
<div class="flex min-h-screen bg-slate-50">
    @include('include.sidebar')

    <div class="flex-1 p-8 ml-60">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <h1 class="text-2xl font-bold text-slate-800 flex items-center gap-2">
                <i class="fa fa-users text-blue-500"></i>
                Manage Users
            </h1>

            <div class="relative mt-3 md:mt-0 w-full md:w-1/4">
                <input
                    id="searchInput"
                    type="search"
                    placeholder="Search users..."
                    class="w-full pl-10 pr-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none text-slate-700 shadow-sm"
                >
                <i class="fa fa-search absolute left-3 top-2.5 text-slate-400"></i>
            </div>
        </div>

        <!-- Card -->
        <div class="bg-white/90 rounded-2xl shadow-xl border border-slate-200 backdrop-blur-lg transition-all">
            <div class="bg-gradient-to-r from-indigo-500 to-purple-500 text-white font-semibold rounded-t-2xl px-6 py-3 flex items-center gap-2">
                <i class="fa fa-users"></i>
                User List
            </div>

            <div class="p-6 overflow-x-auto">
                <table class="w-full text-center border-collapse rounded-xl shadow-sm">
                    <thead class="bg-slate-100 text-slate-700 text-sm font-semibold">
                        <tr>
                            <th class="p-3">No.</th>
                            <th class="p-3"><i class="fa fa-user mr-1"></i>Name</th>
                            <th class="p-3"><i class="fa fa-envelope mr-1"></i>Email</th>
                            <th class="p-3"><i class="fa fa-cog mr-1"></i>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="userTable" class="text-slate-700 text-sm">
                        <tr><td colspan="4" class="py-4 text-slate-400">Loading users...</td></tr>
                    </tbody>
                </table>

                <div id="userPagination" class="flex justify-center mt-6 space-x-2">
                    <button class="px-3 py-1 rounded-lg text-blue-600 font-semibold bg-slate-100 shadow-sm hover:bg-blue-500 hover:text-white transition disabled:opacity-40 disabled:cursor-not-allowed">
                        <i class="fa fa-chevron-left"></i>
                    </button>
                    <button class="px-3 py-1 rounded-lg text-blue-600 font-semibold bg-slate-100 shadow-sm hover:bg-blue-500 hover:text-white transition disabled:opacity-40 disabled:cursor-not-allowed">
                        <i class="fa fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div id="editUserModal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl w-11/12 md:w-1/2 shadow-lg p-6">
        <div class="flex justify-between items-center border-b pb-3">
            <h2 class="text-xl font-semibold text-slate-700">
                <i class="fa fa-edit text-blue-500 mr-2"></i>Edit User
            </h2>
            <button data-modal-close class="text-slate-500 hover:text-slate-700">
                <i class="fa fa-times"></i>
            </button>
        </div>

        <form id="editUserForm" class="mt-4 space-y-4">
            <input type="hidden" id="editUserId">

            <div>
                <label class="block text-sm font-medium text-slate-600 mb-1">Name</label>
                <input
                    type="text" id="editUserName"
                    class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400"
                    required
                >
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-600 mb-1">Email</label>
                <input
                    type="email" id="editUserEmail"
                    class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400"
                    required
                >
            </div>

            <div class="flex justify-end pt-4 border-t">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    <i class="fa fa-save mr-2"></i>Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')

<script>

$(document).ready(function() {
    // Load users
    function loadUsers() {
        $.ajax({
            url: '{{ route("admin.users.get") }}',
            method: 'GET',
            dataType: 'json',
            success: function(res) {
                let tbody = $('#userTable');
                tbody.empty();

                if (res.success && res.data.length > 0) {
                    res.data.forEach(function(user, index) {
                        let statusBtn = user.status === 'enabled'
                            ? `<button class="bg-yellow-200 text-yellow-800 font-semibold px-3 py-1 rounded toggle-status" data-id="${user.id}" data-status="disable">Disable</button>`
                            : `<button class="bg-green-200 text-green-800 font-semibold px-3 py-1 rounded toggle-status" data-id="${user.id}" data-status="enable">Enable</button>`;

                        tbody.append(`
                            <tr class="hover:bg-slate-50 transition">
                                <td class="p-3">${index + 1}</td>
                                <td class="p-3">${user.name}</td>
                                <td class="p-3">${user.email}</td>
                                <td class="p-3 flex justify-center gap-2">
                                    <button class="bg-indigo-500 text-white px-3 py-1 rounded edit-user"
                                        data-id="${user.id}"
                                        data-name="${user.name}"
                                        data-email="${user.email}">
                                        Edit
                                    </button>
                                    ${statusBtn}
                                </td>
                            </tr>
                        `);
                    });
                } else {
                    tbody.html('<tr><td colspan="4" class="py-4 text-slate-400 text-center">No users found</td></tr>');
                }
            }
        });
    }
    loadUsers();

    // Edit modal open
    $(document).on('click', '.edit-user', function() {
        $('#editUserId').val($(this).data('id'));
        $('#editUserName').val($(this).data('name'));
        $('#editUserEmail').val($(this).data('email'));
        $('#editUserModal').removeClass('hidden');
    });

    // Close modal
    $(document).on('click', '[data-modal-close]', function() {
        $(this).closest('.fixed').addClass('hidden');
    });

    // Save edits
    $('#editUserForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: '{{ route("admin.users.update") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                user_id: $('#editUserId').val(),
                username: $('#editUserName').val(),
                email: $('#editUserEmail').val()
            },
            success: function(res) {
                if (res.success) {
                    $('#editUserModal').addClass('hidden');
                    loadUsers();
                    Swal.fire('Success', 'User updated successfully', 'success');
                } else {
                    Swal.fire('Error', res.message, 'error');
                }
            }
        });
    });

    // Toggle status
    $(document).on('click', '.toggle-status', function() {
        let id = $(this).data('id');
        let action = $(this).data('status');
        $.ajax({
            url: '{{ route("admin.users.toggle") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                user_id: id,
                action: action
            },
            success: function(res) {
                if (res.success) {
                    loadUsers();
                } else {
                    Swal.fire('Error', res.message, 'error');
                }
            }
        });
    });
});
</script>
@endpush
