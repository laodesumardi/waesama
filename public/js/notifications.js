// Notification Management JavaScript

$(document).ready(function() {
    loadNotifications();
    loadUsers();
    
    // Auto refresh notifications every 30 seconds
    setInterval(loadNotifications, 30000);
    
    // Send notification form handler
    $('#sendNotificationForm').on('submit', function(e) {
        e.preventDefault();
        sendNotification();
    });
    
    // Filter change handler
    $('#priorityFilter, #statusFilter').on('change', function() {
        loadNotifications();
    });
    
    // Mark all as read button
    $('#markAllReadBtn').on('click', function() {
        markAllAsRead();
    });
});

// Load notifications with filters
function loadNotifications() {
    const priority = $('#priorityFilter').val();
    const status = $('#statusFilter').val();
    
    let url = '/notifications';
    const params = new URLSearchParams();
    
    if (priority) params.append('priority', priority);
    if (status) params.append('status', status);
    
    if (params.toString()) {
        url += '?' + params.toString();
    }
    
    $.get(url)
        .done(function(response) {
            displayNotifications(response.data);
            updateNotificationCount(response.unread_count);
        })
        .fail(function() {
            showToast('Gagal memuat notifikasi', 'error');
        });
}

// Display notifications in the list
function displayNotifications(notifications) {
    const container = $('#notificationsList');
    container.empty();
    
    if (notifications.length === 0) {
        container.html('<div class="text-center py-8 text-gray-500">Tidak ada notifikasi</div>');
        return;
    }
    
    notifications.forEach(function(notification) {
        const notificationHtml = createNotificationHtml(notification);
        container.append(notificationHtml);
    });
}

// Create HTML for a single notification
function createNotificationHtml(notification) {
    const isRead = notification.read_at !== null;
    const priorityClass = getPriorityClass(notification.priority);
    const priorityIcon = getPriorityIcon(notification.priority);
    const senderName = notification.sender ? notification.sender.name : 'System';
    const timeAgo = moment(notification.created_at).fromNow();
    
    return `
        <div class="notification-item border-l-4 ${priorityClass} bg-white p-4 mb-3 rounded-lg shadow-sm ${isRead ? 'opacity-75' : ''}" data-id="${notification.id}">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <div class="flex items-center mb-2">
                        <i class="${priorityIcon} mr-2 text-sm"></i>
                        <h4 class="font-semibold text-gray-900">${notification.title}</h4>
                        ${!isRead ? '<span class="ml-2 w-2 h-2 bg-blue-500 rounded-full"></span>' : ''}
                    </div>
                    <p class="text-gray-700 mb-2">${notification.message}</p>
                    <div class="flex items-center text-sm text-gray-500">
                        <span>Dari: ${senderName}</span>
                        <span class="mx-2">•</span>
                        <span>${timeAgo}</span>
                    </div>
                </div>
                <div class="flex items-center space-x-2 ml-4">
                    ${notification.action_url ? `<a href="${notification.action_url}" class="text-blue-600 hover:text-blue-800 text-sm">Lihat</a>` : ''}
                    ${!isRead ? `<button onclick="markAsRead(${notification.id})" class="text-green-600 hover:text-green-800 text-sm">Tandai Dibaca</button>` : ''}
                    <button onclick="deleteNotification(${notification.id})" class="text-red-600 hover:text-red-800 text-sm">Hapus</button>
                </div>
            </div>
        </div>
    `;
}

// Get priority CSS class
function getPriorityClass(priority) {
    switch(priority) {
        case 'high': return 'border-red-500';
        case 'medium': return 'border-yellow-500';
        case 'low': return 'border-green-500';
        default: return 'border-gray-300';
    }
}

// Get priority icon
function getPriorityIcon(priority) {
    switch(priority) {
        case 'high': return 'fas fa-exclamation-triangle text-red-500';
        case 'medium': return 'fas fa-info-circle text-yellow-500';
        case 'low': return 'fas fa-check-circle text-green-500';
        default: return 'fas fa-bell text-gray-500';
    }
}

// Load users for the send notification form
function loadUsers() {
    $.get('/api/users')
        .done(function(users) {
            const select = $('#recipientSelect');
            select.empty().append('<option value="">Pilih Penerima</option>');
            
            users.forEach(function(user) {
                select.append(`<option value="${user.id}">${user.name} (${user.email})</option>`);
            });
        })
        .fail(function() {
            showToast('Gagal memuat daftar pengguna', 'error');
        });
}

// Send notification
function sendNotification() {
    const formData = {
        recipient_id: $('#recipientSelect').val(),
        recipient_role: $('#roleSelect').val(),
        title: $('#notificationTitle').val(),
        message: $('#notificationMessage').val(),
        priority: $('#notificationPriority').val(),
        action_url: $('#actionUrl').val()
    };
    
    // Validate form
    if (!formData.title || !formData.message) {
        showToast('Judul dan pesan harus diisi', 'error');
        return;
    }
    
    if (!formData.recipient_id && !formData.recipient_role) {
        showToast('Pilih penerima atau role', 'error');
        return;
    }
    
    const url = formData.recipient_id ? '/notifications/send' : '/notifications/send-to-role';
    
    $.post(url, formData)
        .done(function(response) {
            showToast('Notifikasi berhasil dikirim', 'success');
            $('#sendNotificationModal').modal('hide');
            $('#sendNotificationForm')[0].reset();
            loadNotifications();
        })
        .fail(function(xhr) {
            const message = xhr.responseJSON?.message || 'Gagal mengirim notifikasi';
            showToast(message, 'error');
        });
}

// Mark notification as read
function markAsRead(notificationId) {
    $.post(`/notifications/${notificationId}/mark-as-read`)
        .done(function() {
            $(`.notification-item[data-id="${notificationId}"]`).addClass('opacity-75');
            $(`.notification-item[data-id="${notificationId}"] .w-2.h-2.bg-blue-500`).remove();
            $(`.notification-item[data-id="${notificationId}"] button[onclick="markAsRead(${notificationId})"]`).remove();
            loadNotifications();
        })
        .fail(function() {
            showToast('Gagal menandai notifikasi sebagai dibaca', 'error');
        });
}

// Mark all notifications as read
function markAllAsRead() {
    $.post('/notifications/mark-all-as-read')
        .done(function() {
            showToast('Semua notifikasi ditandai sebagai dibaca', 'success');
            loadNotifications();
        })
        .fail(function() {
            showToast('Gagal menandai semua notifikasi sebagai dibaca', 'error');
        });
}

// Delete notification
function deleteNotification(notificationId) {
    if (!confirm('Apakah Anda yakin ingin menghapus notifikasi ini?')) {
        return;
    }
    
    $.ajax({
        url: `/notifications/${notificationId}`,
        type: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })
    .done(function() {
        $(`.notification-item[data-id="${notificationId}"]`).fadeOut(300, function() {
            $(this).remove();
        });
        showToast('Notifikasi berhasil dihapus', 'success');
        loadNotifications();
    })
    .fail(function() {
        showToast('Gagal menghapus notifikasi', 'error');
    });
}

// Update notification count in header
function updateNotificationCount(count) {
    const badge = $('#notificationBadge');
    const sidebarBadge = $('#sidebarNotificationBadge');
    
    if (count > 0) {
        badge.text(count).removeClass('hidden');
        sidebarBadge.text(count).removeClass('hidden');
    } else {
        badge.addClass('hidden');
        sidebarBadge.addClass('hidden');
    }
}

// Show toast message
function showToast(message, type = 'info') {
    const toastClass = type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500';
    
    const toast = $(`
        <div class="fixed top-4 right-4 ${toastClass} text-white px-6 py-3 rounded-lg shadow-lg z-50 toast-message">
            ${message}
        </div>
    `);
    
    $('body').append(toast);
    
    setTimeout(function() {
        toast.fadeOut(300, function() {
            $(this).remove();
        });
    }, 3000);
}

// Toggle recipient selection
function toggleRecipientType() {
    const recipientType = $('input[name="recipient_type"]:checked').val();
    
    if (recipientType === 'user') {
        $('#recipientSelect').prop('disabled', false);
        $('#roleSelect').prop('disabled', true).val('');
    } else {
        $('#recipientSelect').prop('disabled', true).val('');
        $('#roleSelect').prop('disabled', false);
    }
}