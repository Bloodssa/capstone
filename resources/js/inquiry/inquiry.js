import InquiryMessage from './inquiryMessage';
import messageTemplate from '../templates/messagesTemplates';

class InquiryChat {
    constructor(config) {
        // DOM
        this.message = document.getElementById("message-input");
        this.sbmtBtn = document.getElementById("send-btn");
        this.fileInput = document.getElementById("file-input");
        this.previewImage = document.getElementById("preview-container");
        this.chatContainer = document.getElementById("chat-box-container");

        this.inquiryId = config.inquiryId;
        this.userId = config.userId;
        this.files = [];
        this.pollingInterval = null; // init null value
        this.lastMessageCount = 0;
        this.lastMessageId = null; // init null value

        this.init();
    }

    init() {
        this.sbmtBtn.addEventListener("click", () => this.sendMessage());
        this.loadMessages(); // load msgs first

        this.startPolling(); // ask server every interval if there is new message
    }

    async sendMessage() {
        const msg = this.message.value.trim();
        if (!msg) return;

        const form = new FormData();

        // append client input
        form.append("message", msg);
        form.append("type", "message");
        form.append("warranty_inquiries_id", this.inquiryId);
        if (this.files.length > 0) this.files.forEach(file => form.append("attachments[]", file));

        try {
            this.sbmtBtn.disabled = true; // prevents double click
            await InquiryMessage.post(form); // send with axios to api post

            this.resetForm();
            await this.loadMessages();
            this.scrollToBottom(); // directly go to the btm of this messages container
        } catch (err) {
            console.log(err, "Failed to send");
        } finally {
            this.sbmtBtn.disabled = false;
        }
    }

    async loadMessages() {
        try {
            const res = await InquiryMessage.get(this.inquiryId);
            const messages = this.getMessages(res);
            this.renderMessages(messages); // render into container

            if (messages.length > 0) {
                this.lastMessageId = messages[messages.length - 1].id;
            }
        } catch (err) {
            console.error("Fetch Error:", err);
        }
    }

    // render messages
    renderMessages(messages) {
        this.chatContainer.innerHTML = '';
        messages.forEach(message => { this.messageTemplate(message); });
    }

    startPolling() {
        this.pollingInterval = setInterval(() => {
            this.pollMessages();
        }, 4000);
    }

    async pollMessages() {
        try {
            const res = await InquiryMessage.get(this.inquiryId);
        const messages = this.getMessages(res);

        if (!messages.length) return;

        const lastIndex = messages.findIndex(
            msg => msg.id === this.lastMessageId
        );

        const unseen =
            lastIndex === -1
                ? messages
                : messages.slice(lastIndex + 1);

        if (unseen.length > 0) {
            unseen.forEach(msg => this.messageTemplate(msg));

            this.lastMessageId =
                messages[messages.length - 1].id;

            this.scrollToBottom();
        }
        } catch (err) {
            console.log("Polling error", err);
        }
    }

    messageTemplate(message) {
        // use the template messages
        const html = messageTemplate.render(message, this.userId);
        // append to DOM
        this.chatContainer.insertAdjacentHTML('beforeend', html);
    }

    getMessages(response) {
        return response.data.data || response.data || [];
    }

    resetForm() {
        this.message.value = "";
        this.fileInput.value = "";
        this.files = [];
        if (this.previewImage) this.previewImage.innerHTML = "";
    }

    scrollToBottom() {
        if (this.chatContainer) this.chatContainer.scrollTop = this.chatContainer.scrollHeight;
    }
}

document.addEventListener("DOMContentLoaded", () => {
    new InquiryChat({
        inquiryId: window.INQUIRY_ID, // GET THIS FROM BLADED
        userId: window.authUserId
    });
});