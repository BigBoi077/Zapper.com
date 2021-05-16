export class EventPlacer {

    placeCloseModalEvents() {
        this.placeButtonCloseEvent();
        this.placeEscapeKeyEvent();
        this.placeAddServiceModalEvent()
    }

    placePasswordRevealEvent() {
        const buttons = document.querySelectorAll("[data-password-reveal]");
        const input = document.querySelectorAll('[data-password-box]');
        buttons.forEach(button =>
            button.addEventListener("click", function() {
                const target  = button.dataset.passwordReveal;
                input.forEach(input => {
                        if (input.dataset.passwordBox === target) {
                            if (input.type === "password") {
                                input.type = "text";
                            } else {
                                input.type = "password";
                            }
                        }
                    }
                )
            })
        );
    }

    placeModifyServiceEvent() {
        const buttons = document.querySelectorAll("[data-modify-modal-target]");
        const modals = document.querySelectorAll('[data-modify-modal]');
        buttons.forEach(button =>
            button.addEventListener("click", function() {
                const target  = button.dataset.modifyModalTarget
                modals.forEach(modal => {
                        if (modal.dataset.modifyModal === target) {
                            modal.classList.toggle("is-active");
                        }
                    }
                )
            })
        );
    }

    placeDeleteServiceEvent() {
        const buttons = document.querySelectorAll("[data-delete-modal-target]");
        const modals = document.querySelectorAll('[data-delete-modal]');
        buttons.forEach(button =>
            button.addEventListener("click", function() {
                const target  = button.dataset.deleteModalTarget;
                modals.forEach(modal => {
                        if (modal.dataset.deleteModal === target) {
                            modal.classList.toggle("is-active");
                        }
                    }
                )
            })
        );
    }

    placeButtonCloseEvent() {
        const buttons = document.querySelectorAll("[data-close-modal]")
        buttons.forEach(button =>
            button.addEventListener("click", function () {
                button.parentElement.parentElement.parentElement.classList.remove("is-active");
            })
        )
    }

    placeEscapeKeyEvent() {
        const modals = document.querySelectorAll("[data-modal]");
        $(document).keyup(function(e) {
            if (e.key === "Escape") {
                modals.forEach(modal => {
                    if (modal.classList.contains("is-active")) {
                        modal.classList.remove("is-active")
                    }
                })
            }
        });
    }

    placeAddServiceModalEvent() {
        const section = document.getElementById("addService")
        section.addEventListener("click", function () {
            const modal = document.querySelector("[data-add-modal]")
            modal.classList.toggle("is-active")
        });
    }
}
