"use strict";

const SCRIPT_NAME ='auth_menu.js';

document.addEventListener('DOMContentLoaded', () => {

    try {
        let authMenuContainer = document.querySelector('#auth-menu');

        authMenuContainer.addEventListener('mouseenter', (e) => {
            e.currentTarget.classList.remove('closed')
            e.currentTarget.classList.add('opened')
        });

        authMenuContainer.addEventListener('mouseleave', (e) => {
            e.currentTarget.classList.remove('opened')
            e.currentTarget.classList.add('closed')
        });
    } catch (ex) {
        console.warn(SCRIPT_NAME + ': ' +ex)
    }

});

