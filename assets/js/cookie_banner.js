/**
 * Set variables that get element by id
 * in the DOM
 */
const cookie_policy = document.getElementById('cookie_policy');
const accept = document.getElementById('accept');
const cookie_info = document.getElementById('cookie-info');

/**
 * Set up a variable that store the cookie policy content
 * and another that get the DOM where display the cookie policy content
 */
const cookie_banner_policy = document.getElementById('cookie-banner-policy');
const cookie_banner_policy_content = `Cookie Policy di ViaggIn
                                        Questo documento contiene informazioni in merito alle tecnologie che consentono a questa Applicazione di raggiungere gli scopi descritti di seguito. Tali tecnologie permettono al Titolare di raccogliere e salvare informazioni (per esempio tramite l’utilizzo di Cookie) o di utilizzare risorse (per esempio eseguendo uno script) sul dispositivo dell’Utente quando quest’ultimo interagisce con questa Applicazione.

                                        Per semplicità, in questo documento tali tecnologie sono sinteticamente definite “Strumenti di Tracciamento”, salvo vi sia ragione di differenziare.
                                        Per esempio, sebbene i Cookie possano essere usati in browser sia web sia mobili, sarebbe fuori luogo parlare di Cookie nel contesto di applicazioni per dispositivi mobili, dal momento che si tratta di Strumenti di Tracciamento che richiedono la presenza di un browser. Per questo motivo, all’interno di questo documento il temine Cookie è utilizzato solo per indicare in modo specifico quel particolare tipo di Strumento di Tracciamento.

                                        Alcune delle finalità per le quali vengono impiegati Strumenti di Tracciamento potrebbero, inoltre richiedere il consenso dell’Utente. Se viene prestato il consenso, esso può essere revocato liberamente in qualsiasi momento seguendo le istruzioni contenute in questo documento.

                                        Questa Applicazione utilizza Strumenti di Tracciamento gestiti direttamente dal Titolare (comunemente detti Strumenti di Tracciamento “di prima parte”) e Strumenti di Tracciamento che abilitano servizi forniti da terzi (comunemente detti Strumenti di Tracciamento “di terza parte”). Se non diversamente specificato all’interno di questo documento, tali terzi hanno accesso ai rispettivi Strumenti di Tracciamento.
                                        Durata e scadenza dei Cookie e degli altri Strumenti di Tracciamento simili possono variare a seconda di quanto impostato dal Titolare o da ciascun fornitore terzo. Alcuni di essi scadono al termine della sessione di navigazione dell’Utente.
                                        In aggiunta a quanto specificato nella descrizione di ciascuna delle categorie di seguito riportate, gli Utenti possono ottenere informazioni più dettagliate ed aggiornate sulla durata, così come qualsiasi altra informazione rilevante - quale la presenza di altri Strumenti di Tracciamento - nelle privacy policy dei rispettivi fornitori terzi (tramite i link messi a disposizione) o contattando il Titolare.

                                        Attività strettamente necessarie a garantire il funzionamento di questa Applicazione e la fornitura del Servizio
                                        Questa Applicazione utilizza Cookie comunemente detti “tecnici” o altri Strumenti di Tracciamento analoghi per svolgere attività strettamente necessarie a garantire il funzionamento o la fornitura del Servizio.

                                        Altre attività che prevedono l’utilizzo di Strumenti di Tracciamento
                                        Miglioramento dell’esperienza
                                        Questa Applicazione utilizza Strumenti di Tracciamento per fornire una user experience personalizzata, consentendo una migliore gestione delle impostazioni personali e l'interazione con network e piattaforme esterne.
                                        `;

/**
 * Set up services variable that store the DOM where 
 * display the scripts.
 * The following variables are related to the services need cookies
 * like Google AdSense ec..
 */
const services = document.getElementById('services');
const service_adsense = `<script>console.log('Hello Marco');</script>`;

/**
 * Set two Envets.
 * One fire the cookies and one show more information
 * if the user click on 'more information'
 */
accept.addEventListener('click', () => {
    cookie_policy.style.display = "none";
    document.cookie = "consent=true;";
})


cookie_info.addEventListener('click', () => {
    cookie_banner_policy.innerHTML = cookie_banner_policy_content;
})

/**
 * Save cookies into a variable
 * Loops through the variables to understand 
 * if it is possible to run some services or no
 */
let allCookies = document.cookie.split(";");

allCookies.forEach(cookie => {

    if (cookie == "consent=true") {
        console.log(`I set up the cookies`);
        services.innerHTML = service_adsense;
        cookie_policy.style.display = "none";
    }

});