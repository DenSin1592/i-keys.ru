let backdropElement;

function appendBackdrop() {
    backdropElement = document.createElement('div');
    
    $(backdropElement).addClass('backdrop');
    document.body.appendChild(backdropElement);
}

function removeBackdrop() {
    document.body.removeChild(backdropElement);
}