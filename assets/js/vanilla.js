function toggleMenu(){
    const body = document.querySelector('body');
    const el = document.querySelector('.mobile__menu_trigger');
    const menu = document.querySelector('.header__mobile_navigation');

    el.onclick = (event) => { 
        el.classList.toggle('active');
        menu.classList.toggle('active');
        body.classList.toggle('popup_active');
        event.preventDefault();
    }
}

window.onload = function(){ 
    toggleMenu();
};



