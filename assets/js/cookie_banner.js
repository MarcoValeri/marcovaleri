// Set variables
// const cookie_banner = document.getElementsByClassName('cookie-banner');
// console.log(cookie_banner);
const cookie_policy = document.getElementById('cookie_policy');
const accept = document.getElementById('accept');
const reject = document.getElementById('reject');

// EventsListener
accept.addEventListener('click', () => {
    cookie_policy.style.display = "none";
    document.cookie = "consent=true;";
})


// Save cookies into a variable
let allCookies = document.cookie.split(";");

// Loops through the cookies
allCookies.forEach(cookie => {
    if (cookie == "consent=true") {
        cookie_policy.style.display = "none";
    }
});