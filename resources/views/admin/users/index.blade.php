@extends('layouts.admin')

@section('title', 'User Management - POS Kasir')

@section('content')
<div class="space-y-6 overflow-hidden">
    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">User Management</h1>
            <p class="text-gray-600 mt-1">Manage system users, roles, and permissions</p>
        </div>
        <button onclick="openAddModal()" class="bg-cyan-500 text-white px-6 py-3 rounded-xl hover:bg-cyan-600 shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            <span>Add New User</span>
        </button>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-2xl shadow-lg border-l-4 border-purple-500 transform hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm mb-1 font-medium">Total Users</p>
                    <h3 class="text-3xl font-bold text-gray-800">{{ $totalUsers }}</h3>
                </div>
                <div class="w-14 h-14 bg-purple-500 rounded-full flex items-center justify-center">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-lg border-l-4 border-red-500 transform hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm mb-1 font-medium">Admins</p>
                    <h3 class="text-3xl font-bold text-gray-800">{{ $totalAdmins }}</h3>
                </div>
                <div class="w-14 h-14 bg-red-500 rounded-full flex items-center justify-center">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-lg border-l-4 border-green-500 transform hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm mb-1 font-medium">Kasirs</p>
                    <h3 class="text-3xl font-bold text-gray-800">{{ $totalKasirs }}</h3>
                </div>
                <div class="w-14 h-14 bg-green-500 rounded-full flex items-center justify-center">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-lg border-l-4 border-blue-500 transform hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm mb-1 font-medium">Users</p>
                    <h3 class="text-3xl font-bold text-gray-800">{{ $totalUser }}</h3>
                </div>
                <div class="w-14 h-14 bg-blue-500 rounded-full flex items-center justify-center">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search Section -->
    <div class="bg-white p-6 rounded-2xl shadow-lg">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0 md:space-x-4">
            <!-- Search Bar -->
            <div class="flex-1">
                <div class="relative">
                    <input 
                        type="text" 
                        id="searchInput"
                        placeholder="Search by name or email..." 
                        value="{{ $search }}"
                        class="w-full px-4 py-3 pl-12 border border-gray-300 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all"
                    >
                    <svg class="w-5 h-5 text-gray-400 absolute left-4 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>

            <!-- Role Filter -->
            <div class="flex items-center space-x-3">
                <label class="text-gray-700 font-medium">Filter:</label>
                <select id="roleFilter" class="px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all">
                    <option value="">All Roles</option>
                    <option value="admin" {{ $role == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="kasir" {{ $role == 'kasir' ? 'selected' : '' }}>Kasir</option>
                    <option value="user" {{ $role == 'user' ? 'selected' : '' }}>User</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-cyan-500 text-white">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold">User</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Email</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Role</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Created At</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($users as $user)
                    <tr class="hover:bg-gray-50 transition-colors" data-user-id="{{ $user->id }}">
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-full bg-cyan-500 flex items-center justify-center text-white font-bold">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $user->name }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-700">{{ $user->email }}</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                @if($user->role == 'admin') bg-red-100 text-red-700
                                @elseif($user->role == 'kasir') bg-green-100 text-green-700
                                @else bg-blue-100 text-blue-700
                                @endif">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-600 text-sm">{{ $user->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center space-x-2">
                                <button onclick="editUser({{ $user->id }})" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit User">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                                <button onclick="resetPassword({{ $user->id }})" class="p-2 text-orange-600 hover:bg-orange-50 rounded-lg transition-colors" title="Reset Password">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                                    </svg>
                                </button>
                                @if($user->id != Auth::id())
                                <button onclick="deleteUser({{ $user->id }}, '{{ $user->name }}')" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Delete User">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-400">
                                <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                </svg>
                                <p class="text-lg font-semibold">No users found</p>
                                <p class="text-sm">Try adjusting your search or filter criteria</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($users->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Add/Edit User Modal -->
<div id="userModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full transform transition-all" onclick="event.stopPropagation()">
        <div class="bg-cyan-500 p-6 rounded-t-2xl">
            <h3 id="modalTitle" class="text-2xl font-bold text-white">Add New User</h3>
        </div>
        <form id="userForm" class="p-6 space-y-4">
            @csrf
            <input type="hidden" id="userId" name="user_id">
            <input type="hidden" id="formMethod" name="_method" value="POST">
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
                <input type="text" id="userName" name="name" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all"
                    placeholder="Enter full name">
                <p class="text-red-500 text-sm mt-1 hidden" id="nameError"></p>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                <input type="email" id="userEmail" name="email" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all"
                    placeholder="Enter email address">
                <p class="text-red-500 text-sm mt-1 hidden" id="emailError"></p>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Role</label>
                <select id="userRole" name="role" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all">
                    <option value="">Select Role</option>
                    <option value="admin">Admin</option>
                    <option value="kasir">Kasir</option>
                    <option value="user">User</option>
                </select>
                <p class="text-red-500 text-sm mt-1 hidden" id="roleError"></p>
            </div>

            <div id="passwordSection">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <span id="passwordLabel">Password</span>
                    <span class="text-gray-500 text-xs ml-1">(min. 6 characters)</span>
                </label>
                <input type="password" id="userPassword" name="password"
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all"
                    placeholder="Enter password">
                <p class="text-red-500 text-sm mt-1 hidden" id="passwordError"></p>
            </div>

            <div class="flex space-x-3 pt-4">
                <button type="button" onclick="closeModal()" 
                    class="flex-1 px-6 py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-colors font-semibold">
                    Cancel
                </button>
                <button type="submit" 
                    class="flex-1 px-6 py-3 bg-cyan-500 hover:bg-cyan-600 text-white rounded-xl shadow-lg transition-all font-semibold">
                    <span id="submitBtnText">Create User</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Reset Password Modal -->
<div id="resetPasswordModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full transform transition-all" onclick="event.stopPropagation()">
        <div class="bg-orange-500 p-6 rounded-t-2xl">
            <h3 class="text-2xl font-bold text-white">Reset Password</h3>
        </div>
        <form id="resetPasswordForm" class="p-6 space-y-4">
            @csrf
            <input type="hidden" id="resetUserId" name="user_id">
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">New Password</label>
                <input type="password" id="newPassword" name="password" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all"
                    placeholder="Enter new password">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Confirm Password</label>
                <input type="password" id="confirmPassword" name="password_confirmation" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all"
                    placeholder="Confirm new password">
                <p class="text-red-500 text-sm mt-1 hidden" id="resetPasswordError"></p>
            </div>

            <div class="flex space-x-3 pt-4">
                <button type="button" onclick="closeResetModal()" 
                    class="flex-1 px-6 py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-colors font-semibold">
                    Cancel
                </button>
                <button type="submit" 
                    class="flex-1 px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white rounded-xl shadow-lg transition-all font-semibold">
                    Reset Password
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
// CSRF Token
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

// Search functionality with debounce
let searchTimeout;
document.getElementById('searchInput').addEventListener('input', function(e) {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        performSearch();
    }, 500);
});

// Role filter
document.getElementById('roleFilter').addEventListener('change', function() {
    performSearch();
});

function performSearch() {
    const search = document.getElementById('searchInput').value;
    const role = document.getElementById('roleFilter').value;
    
    let url = '/admin/users?';
    if (search) url += `search=${encodeURIComponent(search)}&`;
    if (role) url += `role=${role}&`;
    
    window.location.href = url;
}

// Open Add User Modal
function openAddModal() {
    document.getElementById('modalTitle').textContent = 'Add New User';
    document.getElementById('submitBtnText').textContent = 'Create User';
    document.getElementById('passwordLabel').textContent = 'Password';
    document.getElementById('userForm').reset();
    document.getElementById('userId').value = '';
    document.getElementById('formMethod').value = 'POST';
    document.getElementById('userPassword').required = true;
    clearErrors();
    document.getElementById('userModal').classList.remove('hidden');
}

// Edit User
async function editUser(userId) {
    try {
        const response = await fetch(`/admin/users/${userId}`, {
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            document.getElementById('modalTitle').textContent = 'Edit User';
            document.getElementById('submitBtnText').textContent = 'Update User';
            document.getElementById('passwordLabel').textContent = 'New Password (leave blank to keep current)';
            document.getElementById('userId').value = data.user.id;
            document.getElementById('userName').value = data.user.name;
            document.getElementById('userEmail').value = data.user.email;
            document.getElementById('userRole').value = data.user.role;
            document.getElementById('userPassword').value = '';
            document.getElementById('userPassword').required = false;
            document.getElementById('formMethod').value = 'PUT';
            clearErrors();
            document.getElementById('userModal').classList.remove('hidden');
        }
    } catch (error) {
        showNotification('Error loading user data', 'error');
    }
}

// Close Modal
function closeModal() {
    document.getElementById('userModal').classList.add('hidden');
    document.getElementById('userForm').reset();
    clearErrors();
}

// Close modal when clicking outside
document.getElementById('userModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});

// Submit User Form
document.getElementById('userForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    clearErrors();
    
    const userId = document.getElementById('userId').value;
    const method = document.getElementById('formMethod').value;
    const url = userId ? `/admin/users/${userId}` : '/admin/users';
    
    const formData = {
        name: document.getElementById('userName').value,
        email: document.getElementById('userEmail').value,
        role: document.getElementById('userRole').value,
        password: document.getElementById('userPassword').value,
        _method: method === 'PUT' ? 'PUT' : 'POST'
    };
    
    try {
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(formData)
        });
        
        const data = await response.json();
        
        if (response.ok && data.success) {
            showNotification(data.message, 'success');
            closeModal();
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        } else {
            if (data.errors) {
                displayErrors(data.errors);
            } else {
                showNotification(data.message || 'An error occurred', 'error');
            }
        }
    } catch (error) {
        console.error('Error:', error);
        showNotification('An error occurred', 'error');
    }
});

// Reset Password
function resetPassword(userId) {
    document.getElementById('resetUserId').value = userId;
    document.getElementById('resetPasswordForm').reset();
    document.getElementById('resetPasswordError').classList.add('hidden');
    document.getElementById('resetPasswordModal').classList.remove('hidden');
}

function closeResetModal() {
    document.getElementById('resetPasswordModal').classList.add('hidden');
    document.getElementById('resetPasswordForm').reset();
}

document.getElementById('resetPasswordModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeResetModal();
    }
});

// Submit Reset Password Form
document.getElementById('resetPasswordForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const userId = document.getElementById('resetUserId').value;
    const password = document.getElementById('newPassword').value;
    const passwordConfirmation = document.getElementById('confirmPassword').value;
    
    try {
        const response = await fetch(`/admin/users/${userId}/reset-password`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                password: password,
                password_confirmation: passwordConfirmation
            })
        });
        
        const data = await response.json();
        
        if (response.ok && data.success) {
            showNotification(data.message, 'success');
            closeResetModal();
        } else {
            document.getElementById('resetPasswordError').textContent = data.errors?.password?.[0] || data.message || 'Passwords do not match';
            document.getElementById('resetPasswordError').classList.remove('hidden');
        }
    } catch (error) {
        console.error('Error:', error);
        showNotification('An error occurred', 'error');
    }
});

// Delete User
async function deleteUser(userId, userName) {
    // Show SweetAlert2 confirmation
    const result = await Swal.fire({
        title: 'Delete User?',
        html: `Are you sure you want to delete <strong>"${userName}"</strong>?<br><small class="text-gray-500">This action cannot be undone.</small>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel',
        reverseButtons: true,
        customClass: {
            popup: 'rounded-2xl',
            confirmButton: 'px-6 py-3 rounded-xl font-semibold',
            cancelButton: 'px-6 py-3 rounded-xl font-semibold'
        }
    });
    
    // If user confirms
    if (result.isConfirmed) {
        try {
            // Show loading
            Swal.fire({
                title: 'Deleting...',
                text: 'Please wait',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            const response = await fetch(`/admin/users/${userId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    _method: 'DELETE'
                })
            });
            
            const data = await response.json();
            
            if (data.success) {
                // Show success message
                await Swal.fire({
                    title: 'Deleted!',
                    text: data.message,
                    icon: 'success',
                    confirmButtonColor: '#10b981',
                    confirmButtonText: 'OK',
                    customClass: {
                        popup: 'rounded-2xl',
                        confirmButton: 'px-6 py-3 rounded-xl font-semibold'
                    }
                });
                
                // Reload page
                window.location.reload();
            } else {
                // Show error message
                Swal.fire({
                    title: 'Error!',
                    text: data.message,
                    icon: 'error',
                    confirmButtonColor: '#ef4444',
                    confirmButtonText: 'OK',
                    customClass: {
                        popup: 'rounded-2xl',
                        confirmButton: 'px-6 py-3 rounded-xl font-semibold'
                    }
                });
            }
        } catch (error) {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error!',
                text: 'An error occurred while deleting user',
                icon: 'error',
                confirmButtonColor: '#ef4444',
                confirmButtonText: 'OK',
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'px-6 py-3 rounded-xl font-semibold'
                }
            });
        }
    }
}

// Display form errors
function displayErrors(errors) {
    if (errors.name) {
        document.getElementById('nameError').textContent = errors.name[0];
        document.getElementById('nameError').classList.remove('hidden');
    }
    if (errors.email) {
        document.getElementById('emailError').textContent = errors.email[0];
        document.getElementById('emailError').classList.remove('hidden');
    }
    if (errors.role) {
        document.getElementById('roleError').textContent = errors.role[0];
        document.getElementById('roleError').classList.remove('hidden');
    }
    if (errors.password) {
        document.getElementById('passwordError').textContent = errors.password[0];
        document.getElementById('passwordError').classList.remove('hidden');
    }
}

// Clear errors
function clearErrors() {
    document.getElementById('nameError').classList.add('hidden');
    document.getElementById('emailError').classList.add('hidden');
    document.getElementById('roleError').classList.add('hidden');
    document.getElementById('passwordError').classList.add('hidden');
}

// Show notification using SweetAlert2 Toast
function showNotification(message, type = 'success') {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        customClass: {
            popup: 'rounded-xl shadow-lg'
        },
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });
    
    Toast.fire({
        icon: type === 'success' ? 'success' : 'error',
        title: message
    });
}
</script>
@endpush
