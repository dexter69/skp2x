// Do obsługi okienka dialogowego konfirmacji/zatwierdzenia
class ConfirmServant {
    constructor(theButtonSelektor) {
        this.theButtonSelektor = theButtonSelektor;
        this.theButtonClicked = false; // przechowuje informację, czy to TEN przycisk został kliknięty
    }
    // Meteoda organizująca obsługę kliknięcia dla przycisku, który wywołuje okno confirm
    setHandlingForTheButton() {
        /**
         * Kliknięcie w ten button. Jeżeli zostanie kliknięty przycisk,
         * który ma wywołać okno confirm, to zapamietujemy ten fakt w property theButtonClicked.
         * Kod obsługujący submit formularza "wie" dzięki temu, czy submit był spowodowany
         * przez Ten przycisk, czy też inny. Zdarzenie "click" pojawia się przed "submit",
         * dzięki czemu ta property zawsze będzie ustawiona prawidłowo */
        $(this.theButtonSelektor).on("click", this, function (e) {
            /**
             * Przekazanie "this" jako argument. Celem jest dostęp do instancji klasy ConfirmServant,
             * gdyż przy wywołaniu jQuery "this" zmienia kontekst. Wynika to z dokumentacji metody "on",
             * jQuery - wtedy interesujące na "this" siedzi w e.data */
            e.data.theButtonClicked = true;
            console.log(e.data.theButtonClicked);
        });
        this._setFormSubmitHandling();
    }
    /**
         * Obsługa submit. Jeżeli submit był spowodowany przez nasz klawisz, to działamy
         * z oknem confirm. W przeciwnym wypadku wszystko odbywa się normalnie.
         * Metoda niby prywatna */
    // interesuje nas formularz, którego button jest częścią
    _setFormSubmitHandling() {
        $(this.theButtonSelektor).parents("form").on("submit", this, function (e) {
            event.preventDefault();
            if (e.data.theButtonClicked) { // Submit był spowodowany przez nasz button
                e.data.theButtonClicked = false; // clear                
                console.log("Zamknij clicked");
            }
            else {
                console.log("Inny clicked");
            }
        });
    }
}
