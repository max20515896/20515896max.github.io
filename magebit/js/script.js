//form validate

let inp = document.querySelector('.email input[type="text'),
    checkbox = document.querySelector('.form input[type="checkbox"]'),
    form = document.querySelector('form'),
    errorBox = document.querySelector('.error'),
    modal_success = document.querySelector('.subscription_success');

form.addEventListener('submit', function(e){
    e.preventDefault();
    if(inp.value == ''){
        errorMessage(errorBox, 'Email address is required');
    }
    else if(!validateEmail(inp.value)){
        errorMessage(errorBox, 'Please provide a valid e-mail address');
    }
    else if(inp.value.substr(-3,3) == '.co'){
        errorMessage(errorBox, 'We are not accepting subscriptions from Colombia emails');
    }
    else if(!checkbox.checked){
        errorMessage(errorBox, 'You must accept the terms and conditions');
    }
    else{
        form.parentNode.parentNode.style.display = 'none';
        modal_success.style.display = 'block';
        setTimeout(() => {
            form.submit();
        }, 3000);
    }
});

function validateEmail(email){    
    let regExp = /\S+@\S+\.\S+/;
    return regExp.test(email);
}

function errorMessage(block, text){
    block.innerHTML = text;
}

