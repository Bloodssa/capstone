const messageTemplate = {
    /**
     * STATUS UPDATES
     */
    updates(message) {
        return `
            <div class="relative flex items-center justify-center my-8">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative bg-white px-4 flex flex-col items-center text-center">
                    <span class="text-sm font-semibold text-neutral-500">
                        ${message.message}
                    </span>
                    <span class="text-xs text-neutral-400 mt-0.5">
                        ${timeAgo(message.created_at)}
                    </span>
                </div>
            </div>
        `;
    },
    /**
     * SOLUTION
     */
    solution(message) {
        return `
            <div class="my-10 flex justify-center px-4">
                <div class="max-w-md w-full border border-gray-300 rounded-md p-6 bg-white">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="p-2 bg-neutral-900 rounded-md text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-neutral-900">Inquiry
                                ${message.status}</h3>
                            <p class="text-xs text-neutral-500">${formatDate(message.created_at)}</p>
                        </div>
                    </div>
                    <div class="text-sm text-neutral-900 font-medium">
                        ${message.message}"
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-300 flex justify-between items-center">
                        <span class="text-sm font-semibold text-neutral-500">${message?.user.name}</span>
                            ${message.status.charAt(0).toUpperCase() + message.status.slice(1)}
                    </div>
                </div>
            </div>
        `;
    },
    /**
     * Standard
     */
    message(message, currentUserId) {
        const senderId = message.user?.id;
        const isCustomer = Number(senderId) === Number(currentUserId);

        return `
        <div class="flex ${isCustomer ? 'justify-end' : 'justify-start'} mb-3">
            <div class="flex items-end gap-2
                ${isCustomer ? 'flex-row-reverse' : 'items-start'}">
                ${!isCustomer ? `
                    <div class="shrink-0">
                        ${renderAvatar(message.user?.name ?? 'System')}
                    </div>
                ` : ''}
                <div class="flex flex-col
                    ${isCustomer ? 'items-end' : 'items-start'}">
                    ${message.message ? `
                        <div class="p-2 rounded-md text-sm max-w-md wrap-break-word
                            ${isCustomer ? 'bg-neutral-900 text-white' : 'bg-gray-100 text-neutral-900'}">
                            ${escapeHtml(message.message)}
                        </div>
                    ` : ''}
                    ${renderAttachments(message.attachments, isCustomer)}
                    <span class="text-xs text-gray-500 mt-1">
                        ${timeAgo(message.created_at)}
                    </span>
                </div>
            </div>
        </div>
    `;
    },

    /**
     * functions to be called on what typr of the template to be displayed in the chat div
     */
    render(message, currentUserId) {
        switch (message.type) {
            case 'updates':
                return this.updates(message);
            case 'solution':
                return this.solution(message);
            default:
                return this.message(message, currentUserId);
        }
    }
};

function formatDate(dateString) {
    const date = new Date(dateString);

    return date.toLocaleString('en-PH', {
        month: 'short',
        day: 'numeric',
        year: 'numeric',
        hour: 'numeric',
        minute: '2-digit',
        hour12: true
    });
}

function renderAttachments(files = [], isCustomer = false) {
    if (!files || files.length === 0) return '';

    return `
        <div class="flex flex-wrap gap-2 mt-2 max-w-[320px]
            ${isCustomer ? 'justify-end' : 'justify-start'}">

            ${files.map(path => `
                <a href="/storage/${path}" target="_blank">
                    <img
                        src="/storage/${path}"
                        alt="Attachment"
                        class="h-24 w-24 object-cover rounded-md border border-gray-200 hover:opacity-80 transition"
                    >
                </a>
            `).join('')}

        </div>
    `;
}

function renderAvatar(name = 'Guest', size = 'md') {
    const sizes = {
        xs: 'w-6 h-6 text-xs',
        sm: 'w-8 h-8 text-sm',
        md: 'w-10 h-10 text-base',
        lg: 'w-12 h-12 text-lg',
    };

    const sizeClass = sizes[size] || sizes.md;
    const firstLetter = (name && typeof name === 'string' ? name.charAt(0).toUpperCase() : 'G');

    return `
        <div class="relative cursor-pointer inline-flex items-center justify-center
            overflow-hidden bg-neutral-900 rounded-full shrink-0 ${sizeClass}">
            <span class="font-semibold text-white leading-none">
                ${firstLetter}
            </span>
        </div>
    `;
}

function escapeHtml(text = '') {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function timeAgo(dateString) {
    const date = new Date(dateString);
    const now = new Date();

    const seconds = Math.floor((now - date) / 1000);

    const intervals = [
        { label: 'year', seconds: 31536000 },
        { label: 'month', seconds: 2592000 },
        { label: 'day', seconds: 86400 },
        { label: 'hour', seconds: 3600 },
        { label: 'minute', seconds: 60 },
        { label: 'second', seconds: 1 },
    ];

    for (const interval of intervals) {
        const count = Math.floor(seconds / interval.seconds);

        if (count >= 1) {
            return `${count} ${interval.label}${count > 1 ? 's' : ''} ago`;
        }
    }

    return 'Just now';
}

export default messageTemplate;