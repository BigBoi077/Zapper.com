export class App {

    constructor() {
        this.hideBurgerMenu();
    }

    revealContent() {
        ScrollReveal().reveal('.reveal');
    }

    hideBurgerMenu() {
        const menu = document.getElementsByClassName('burger');
        const navigation = document.getElementById("items");

        console.log(menu)
        console.log(navigation)

        $(menu).click( function () {
            menu[0].classList.toggle('is-active');
            navigation.classList.toggle('is-active');
        });
    }
}
