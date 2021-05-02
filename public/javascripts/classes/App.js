import {EventPlacer} from "./EventPlacer.js";

export class App {

    constructor() {
        this.hideBurgerMenu();
        this.eventPlacer = new EventPlacer();
    }

    revealContent() {
        ScrollReveal().reveal('.reveal');
    }

    hideBurgerMenu() {
        const menu = document.getElementsByClassName('burger');
        const navigation = document.getElementById("items");
        $(menu).click( function () {
            menu[0].classList.toggle('is-active');
            navigation.classList.toggle('is-active');
        });
    }

    placeEvents() {
        this.eventPlacer.placePasswordRevealEvent();
        this.eventPlacer.placeModifyServiceEvent();
        this.eventPlacer.placeDeleteServiceEvent();
        this.eventPlacer.placeCloseModalEvents();
    }
}
