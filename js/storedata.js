// Check if data exists in local storage and populate the form
function populateForm() {
    const fields = [
      "first-name", "middle-name", "last-name", "suffix", "bdate", "age", "sex", 
      "occupation", "s_id", "zip-code", "address", "country", "province", 
      "city", "barangay", "purok", "username", "email", "phone", "pass", "cpass"
    ];
  
    fields.forEach((field) => {
      const value = localStorage.getItem(field);
      if (value !== null) {
        document.getElementById(field).value = value;
      }
    });
  }
  
  // Save data to local storage on input change
  function saveData() {
    const fields = [
      "first-name", "middle-name", "last-name", "suffix", "bdate", "age", "sex", 
      "occupation", "s_id", "zip-code", "address", "country", "province", 
      "city", "barangay", "purok", "username", "email", "phone", "pass", "cpass"
    ];
  
    fields.forEach((field) => {
      const element = document.getElementById(field);
      if (element) {
        element.addEventListener("input", () => {
          localStorage.setItem(field, element.value);
        });
      }
    });
  }
  
  // Function to clear form and local storage upon successful submission
  function clearForm() {
    const fields = [
      "first-name", "middle-name", "last-name", "suffix", "bdate", "age", "sex", 
      "occupation", "s_id", "zip-code", "address", "country", "province", 
      "city", "barangay", "purok", "username", "email", "phone", "pass", "cpass"
    ];
  
    // Clear input fields and local storage
    fields.forEach((field) => {
      const element = document.getElementById(field);
      if (element) {
        element.value = ""; // Clear form fields
      }
      localStorage.removeItem(field); // Clear local storage
    });
  }
  
  // Function to handle form submission based on success or error
  function handleFormSubmission(success) {
    if (success) {
      // Clear form and local storage if registration is successful
      clearForm();
      console.log("Form submission successful. Form cleared.");
    } else {
      // Data remains in local storage if submission failed
      console.error("Form submission failed, data retained.");
    }
  }
  
  // Call the functions to populate and save the form data
  populateForm();
  saveData();
  