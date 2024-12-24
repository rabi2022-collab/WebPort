document.addEventListener('DOMContentLoaded', (event) => {
    // Clear local storage when clicking on the Signup link
    const signupLink = document.getElementById('signup-link');
    if (signupLink) {
        signupLink.addEventListener('click', (e) => {
            // Clear the local storage for the registration form fields
            const fields = [
                "first-name",
                "middle-name",
                "last-name",
                "suffix",
                "bdate",
                "age",
                "sex",
                "occupation",
                "s_id",
                "zip-code",
                "address",
                "country",
                "province",
                "city",
                "barangay",
                "purok",
                "username",
                "email",
                "phone",
                "pass",
                "cpass"
            ];

            // Remove all form-related data from local storage
            fields.forEach((field) => {
                localStorage.removeItem(field);
            });

            console.log("Local storage cleared for registration form.");
        });
    }
});
