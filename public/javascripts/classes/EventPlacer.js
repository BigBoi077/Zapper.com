export class EventPlacer {
    placePasswordRevealEvent() {
        const buttons = document.querySelectorAll("[data-password-reveal]")
        console.log(buttons)
        buttons.forEach(button =>
            button.addEventListener("click", function() {
                const target  = button.dataset.passwordReveal
                const input = document.querySelectorAll('[data-password-box]')
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
}
