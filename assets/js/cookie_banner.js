/**
 * Set variables that get element by id
 * in the DOM
 */
const cookie_policy = document.getElementById('cookie_policy');
const accept = document.getElementById('accept');

/**
 * Set up services variable that store the DOM where 
 * display the scripts.
 * The following variables are related to the services need cookies
 * like Google AdSense ec..
 */
const services = document.getElementById('services');
const service_adsense = ``; // This is just an example, at the moment I don't have any service needs to add

/**
 * Set Envets.
 * Fire and set the cookies
 */
accept.addEventListener('click', () => {
    cookie_policy.style.display = "none";
    document.cookie = "consent=true;";
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