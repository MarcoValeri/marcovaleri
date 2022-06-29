document.addEventListener('DOMContentLoaded', () => {
    
    // DOM variables
    const genderLegend = document.getElementById('gender-legend');
    const genderMale = document.getElementById('gender-male');
    const genderFemale = document.getElementById('gender-female');
    const genderNonBinary = document.getElementById('gender-non-binary');

    // Event Click
    genderMale.addEventListener('click', () => {
        genderLegend.innerHTML = 'Sentiti libero...';
    })

    genderFemale.addEventListener('click', () => {
        genderLegend.innerHTML = "Sentiti libera...";
    })

    genderNonBinary.addEventListener('click', () => {
        genderLegend.innerHTML = "Sentiti liberə...";
    })

})

