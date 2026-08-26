import { initAllImageUploads } from './Images.js';

// Delete Validation
const deleteForm = document.querySelectorAll('.delete-form');
const deleteBtn = document.querySelectorAll('.delete-btn');

deleteForm.forEach(deleteFormItem => {
    deleteFormItem?.addEventListener('submit', deleteValidation);
});

function deleteValidation(event) {
    const isConfirmed = confirm('Are you sure you want to delete this post?');

    if (!isConfirmed) {
        event.preventDefault();
    }
}

//Input Validation

const inputForm = document.querySelector('#input-form');
const inputName = document.querySelector('#input-name');
const inputFormSubmitBtn = document.querySelector('#input-form-submit-btn');

inputForm?.addEventListener('submit', inputValidation);

function inputValidation(event) {
    if (inputName.value === '') {
        event.preventDefault();
        alert('Please check your input, enter all least name of post');
    }
}

// Update Slug
const inputSlugUpdate = document.querySelector('#slug-update');
const inputSlugCheckbox = document.querySelector('#slug-update-checkbox');

inputSlugCheckbox?.addEventListener('change', function () {
    inputSlugUpdate.disabled = !inputSlugCheckbox.checked;
});

// On submit, enable the slug so its value is always sent
inputForm?.addEventListener('submit', function () {
    if (inputSlugUpdate) {
        inputSlugUpdate.disabled = false;
    }
});

// Forms validation
// Log in
const logInForm = document.querySelector('#log-in-form');


logInForm?.addEventListener('submit', logInValidation);


function logInValidation(event) {
    const email = document.querySelector('#user-email');
    const pass = document.querySelector('#user-pass');

    if (email.value.trim() === '' || pass.value.trim() === '') {
        event.preventDefault();
        alert('Please fill in both email and password.');
    }
}

// Register
const registerForm = document.querySelector('#register-form');

registerForm?.addEventListener('submit', registerValidation);


function registerValidation(event) {
    const email = document.querySelector('#user-email');
    const pass = document.querySelector('#user-pass');
    const verify = document.querySelector('#verify_pass');

    if (email.value.trim() === '' || pass.value.trim() === '' || verify.value.trim() === '') {
        event.preventDefault();
        alert('Please fill in all fields.');
    } else if (pass.value !== verify.value) {
        event.preventDefault();
        alert('Passwords do not match.');
    }
}

initAllImageUploads();