
/**
 * Inquiry Updates and Response Client
 */
class Inquiry {
    constructor() {
        // DOM
        this.select = document.querySelector('select[name="status"]');
        this.form = this.select?.closest('form'); // find parent form

        this.status = ['closed', 'resolved', 'replaced'];
        this.modal = null;

        this.init();
    }

    init() {
        if (!this.select) return;

        this.select.addEventListener('change', (e) => this.handleChange(e));
    }

    handleChange(event) {
        const value = event.target.value;

        // if this click event includes the event render the modal
        this.status.includes(value) ? this.openModal() : this.form.submit();
    }

    modalTemplate() {
        const element = document.createElement('div');

        element.innerHTML = `
        <div class="fixed inset-0 flex items-center justify-center p-5 overflow-y-auto z-9999" id="solutionModal">
            <div class="fixed inset-0 h-full w-full bg-gray-400/50 backdrop-blur-sm" id="overlay"></div>
            <div class="no-scrollbar relative flex w-full max-w-3xl max-h-[90vh] flex-col overflow-y-auto rounded-xl bg-white p-6 lg:p-11 shadow-2xl">
                <button id="closeModal"
                    class="transition-all absolute right-5 top-5 z-10 flex h-11 w-11 items-center justify-center rounded-full bg-gray-100 text-gray-400 hover:bg-gray-200">
                    <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24">
                        <path d="M6.04289 16.5418C5.65237 16.9323 5.65237 17.5655 6.04289 17.956C6.43342 18.3465 7.06658 18.3465 7.45711 17.956L11.9987 13.4144L16.5408 17.9565C16.9313 18.347 17.5645 18.347 17.955 17.9565C18.3455 17.566 18.3455 16.9328 17.955 16.5423L13.4129 12.0002L17.955 7.45808C18.3455 7.06756 18.3455 6.43439 17.955 6.04387C17.5645 5.65335 16.9313 5.65335 16.5408 6.04387L11.9987 10.586L7.45711 6.04439C7.06658 5.65386 6.43342 5.65386 6.04289 6.04439C5.65237 6.43491 5.65237 7.06808 6.04289 7.4586L10.5845 12.0002L6.04289 16.5418Z"/>
                    </svg>
                </button>

                <div class="space-y-4">

                    <h2 class="text-lg font-bold text-neutral-900">
                        Provide Resolution Details
                    </h2>

                    <textarea id="solutionMessage"
                        rows="6"
                        class="w-full border border-gray-300 rounded-md p-3 text-sm focus:ring-2 focus:ring-neutral-900"
                        placeholder="Enter resolved/closed/replacement message..."></textarea>

                    <div class="flex justify-end gap-2 pt-4">
                        <button type="button" id="cancelModal"
                            class="px-4 py-2 text-sm hover:bg-gray-100 rounded-md">
                            Cancel
                        </button>

                        <button type="button" id="confirmModal"
                            class="px-4 py-2 bg-neutral-900 text-white font-semibold rounded-md text-sm">
                            Confirm
                        </button>
                    </div>

                </div>

            </div>
        </div>`;

        document.body.appendChild(element);

        this.modal = element.querySelector('#solutionModal');

        const overlay = this.modal.querySelector('#overlay');
        const closeBtn = this.modal.querySelector('#closeModal');
        const cancelBtn = this.modal.querySelector('#cancelModal');
        const confirmBtn = this.modal.querySelector('#confirmModal');
        const container = this.modal.querySelector('.no-scrollbar');

        // close modal events
        overlay.addEventListener('click', () => this.closeModal());
        closeBtn.addEventListener('click', () => this.closeModal());
        cancelBtn.addEventListener('click', () => this.closeModal());
        confirmBtn.addEventListener('click', () => this.submitSolution());
        //close if click outside this element
        this.modal.addEventListener('click', (e) => {
            if (!container.contains(e.target)) {
                this.closeModal();
            }
        });
    }

    openModal() {
        // if modal is null then create the template in the nodel
        !this.modal ? this.modalTemplate() : this.modal.classList.remove('hidden');
    }

    closeModal() {
        // clear modal
        this.modal.remove();
        this.modal = null;

        // reset select
        this.select.value = this.select.getAttribute('data-current');
    }

    submitSolution() {
        const textarea = this.modal.querySelector('#solutionMessage');
        const message = textarea.value.trim();

        if (!message) {
            textarea.classList.add('border-red-500');
            textarea.focus();
            return;
        }

        // add hidden input
        let input = this.form.querySelector('input[name="resolved_message"]');

        if (!input) {
            input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'resolved_message';
            this.form.appendChild(input);
        }

        input.value = message;

        // submit form
        this.form.submit();
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new Inquiry();
});
