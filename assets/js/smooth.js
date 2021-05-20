document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('a[href^="#tricks"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();

            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });

    window.onscroll = function (e) {
        var $backButton = document.querySelector('.back-button')
        // called when the window is scrolled.
        if(document.body.scrollTop > 800 || document.documentElement.scrollTop > 800){
            $backButton.classList.add('block');
        } else{
            $backButton.classList.add('hidden');
        }
    }
});