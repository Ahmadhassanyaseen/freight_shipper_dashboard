<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Create account - Windmill Dashboard</title>
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="./assets/css/tailwind.output.css" />
    <link rel="stylesheet" href="./assets/css/variable.css" />
    
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- Alpine JS -->
    <script
      src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"
      defer
    ></script>
    <script src="./assets/js/init-alpine.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  </head>
  <body>
    <div class="flex items-center min-h-screen p-6 bg-gray-50 dark:bg-gray-900">
      <div
        class="flex-1 h-full max-w-4xl mx-auto overflow-hidden bg-white rounded-lg shadow-xl dark:bg-gray-800"
      >
        <div class="flex flex-col overflow-y-auto md:flex-row">
          <div class="h-32 md:h-auto md:w-1/2">
            <img
              aria-hidden="true"
              class="object-cover w-full h-full dark:hidden"
              src="./assets/img/signup.jpg"
              alt="Office"
            />
            <img
              aria-hidden="true"
              class="hidden object-cover w-full h-full dark:block"
              src="./assets/img/signup.jpg"
              alt="Office"
            />
          </div>
          <form id="create-account-form" method="post" class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
            <div class="w-full">
              <h1
                class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200"
              >
                Create account
              </h1>
              <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">User Name</span>
                <input
                  type="text"
                  id="user_name"
                  name="user_name"
                  class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder="Jane Doe"
                  oninput="validateField('user_name', this.value)"
                />
                <span id="user_name_error" class="text-xs text-red-600 dark:text-red-400 mt-1 hidden"></span>
              </label>
              <label class="block mt-4  text-sm">
                <span class="text-gray-700 dark:text-gray-400">Email</span>
                <input
                  type="email"
                  id="email"
                  name="email"
                  class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder="jane.doe@example.com"
                  oninput="validateField('email', this.value)"
                />
                <span id="email_error" class="text-xs text-red-600 dark:text-red-400 mt-1 hidden"></span>
              </label>
              <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Password</span>
                <input
                  type="password"
                  id="password"
                  name="password"
                  class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-primary-color focus:outline-none focus:shadow-outline-primary-color dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder="Enter your password"
                  oninput="validateField('password', this.value)"
                />
                <span id="password_error" class="text-xs text-red-600 dark:text-red-400 mt-1 hidden"></span>
                <div class="text-xs text-gray-500 mt-1">Must be at least 8 characters with uppercase, lowercase, number & special character</div>
              </label>
              <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                  Confirm password
                </span>
                <input
                  type="password"
                  id="confirm_password"
                  name="confirm_password"
                  class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-primary-color focus:outline-none focus:shadow-outline-primary-color dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder="Confirm your password"
                  oninput="validateField('confirm_password', this.value, document.getElementById('password').value)"
                />
                <span id="confirm_password_error" class="text-xs text-red-600 dark:text-red-400 mt-1 hidden"></span>
              </label>

              <div class="flex mt-6 text-sm flex-col">
                <label class="flex items-center dark:text-gray-400">
                  <input
                    type="checkbox"
                    id="terms"
                    class="text-primary-color form-checkbox focus:border-primary-color focus:outline-none focus:shadow-outline-primary-color dark:focus:shadow-outline-gray"
                    onchange="validateField('terms', this.checked)"
                  />
                
                  <span class="ml-2">
                    I agree to the
                    <span class="underline">privacy policy</span>
                  </span>
                </label>
                <span id="terms_error" class="text-xs text-red-600 dark:text-red-400 mt-1 hidden"></span>
              </div>

              <!-- You should use a button here, as the anchor is only used for the example  -->
              <button
                class="block w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-primary-color border border-transparent rounded-lg active:bg-primary-color hover:bg-primary-color focus:outline-none focus:shadow-outline-primary-color"
                type="submit"
              >
                Create account
              </button>

              <hr class="my-8" />

             

              <p class="mt-4">
                <a
                  class="text-sm font-medium text-primary-color dark:text-primary-color hover:underline"
                  href="./login.php"
                >
                  Already have an account? Login
                </a>
              </p>
            </div>
          </form>
        </div>
      </div>
    </div>

    <script>
        // Move createShipper function to the top to ensure it's defined when called
        // async function createShipper(data) {
        //     try {
        //         Swal.fire({
        //             title: 'Please wait...',
        //             text: 'Creating account...',
        //             allowOutsideClick: false,
        //             didOpen: () => {
        //                 Swal.showLoading();
        //             }
        //         });
        //         const formData = new FormData();
        //         formData.append('user_name', document.getElementById('user_name').value);
        //         formData.append('email', document.getElementById('email').value);
        //         formData.append('password', document.getElementById('password').value);
        //         formData.append('confirm_password', document.getElementById('confirm_password').value);
        //         formData.append('method', 'createShipper');
                
                
        //         const response = await fetch('https://stretchxlfreight.com/logistx/index.php?entryPoint=VendorSystem', {
        //             method: 'POST',
        //             body: formData,
        //         });
                
        //         const result = await response.json();
        //         console.log(result);
        //         if(result.status == "error"){
        //           Swal.fire({
        //             title: 'Error!',
        //             text: result.message,
        //             icon: 'error',
        //             confirmButtonColor: '#D74559',
        //             confirmButtonText: 'Continue'
        //         });
        //         }
                
        //         Swal.fire({
        //             title: 'Success!',
        //             text: 'Account created successfully!',
        //             icon: 'success',
        //             confirmButtonColor: '#D74559',
        //             confirmButtonText: 'Continue'
        //         }).then((result) => {
        //             if (result.isConfirmed) {
                      
        //                 // Redirect after successful submission
        //                 window.location.href = 'login.php';
        //             }
        //         });
        //     } catch (error) {
        //         console.error('Error creating account:', error);
        //         Swal.fire({
        //             title: 'Error!',
        //             text: 'Failed to create account. Please try again.',
        //             icon: 'error',
        //             confirmButtonColor: '#D74559',
        //             confirmButtonText: 'Continue'
        //         });
        //     }  
        // }
        async function createShipper(data) {
    try {
        Swal.fire({
            title: 'Please wait...',
            text: 'Creating account...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        const formData = new FormData();
        formData.append('user_name', document.getElementById('user_name').value);
        formData.append('email', document.getElementById('email').value);
        formData.append('password', document.getElementById('password').value);
        formData.append('confirm_password', document.getElementById('confirm_password').value);
        formData.append('method', 'createShipper');
        
        const response = await fetch('https://stretchxlfreight.com/logistx/index.php?entryPoint=VendorSystem', {
            method: 'POST',
            body: formData,
        });
        
        const result = await response.json();
        console.log('Form data:', data);
        console.log('Server response:', result);
        
        if (result.status === "error") {
            Swal.fire({
                title: 'Error!',
                text: result.message,
                icon: 'error',
                confirmButtonColor: '#D74559',
                confirmButtonText: 'Continue'
            });
            return; // Stop execution if there's an error
        }
        
        // Only show success if there was no error
        await Swal.fire({
            title: 'Success!',
            text: 'Account created successfully!',
            icon: 'success',
            confirmButtonColor: '#D74559',
            confirmButtonText: 'Continue'
        });
        
        // Redirect after successful submission
        window.location.href = 'login.php';
            
    } catch (error) {
        console.error('Error creating account:', error);
        Swal.fire({
            title: 'Error!',
            text: 'Failed to create account. Please try again.',
            icon: 'error',
            confirmButtonColor: '#D74559',
            confirmButtonText: 'Continue'
        });
    }  
}
        // Validation patterns
        const patterns = {
            username: /^[a-zA-Z0-9_]{3,20}$/,
            email: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
            password: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/
        };

        // Error messages
        const errorMessages = {
            user_name: {
                required: 'Username is required',
                invalid: '3-20 characters, letters, numbers, and underscores only'
            },
            email: {
                required: 'Email is required',
                invalid: 'Please enter a valid email address'
            },
            password: {
                required: 'Password is required',
                invalid: 'Must include uppercase, lowercase, number & special character'
            },
            confirm_password: {
                required: 'Please confirm your password',
                invalid: 'Passwords do not match'
            },
            terms: {
                required: 'You must agree to the terms and conditions'
            }
        };

        // Validate field on input
        function validateField(field, value, compareValue = null) {
            const input = document.getElementById(field);
            const errorElement = document.getElementById(`${field}_error`);
            let isValid = true;
            let message = '';

            // Reset styles
            input.classList.remove('border-red-500', 'border-green-500');
            errorElement.classList.add('hidden');

            // Skip validation if field is empty (handled on blur or submit)
            if (value === '' || (typeof value === 'boolean' && !value)) {
                return true;
            }

            // Field-specific validation
            switch(field) {
                case 'user_name':
                    isValid = patterns.username.test(value);
                    message = isValid ? '' : errorMessages.user_name.invalid;
                    break;
                case 'email':
                    isValid = patterns.email.test(value);
                    message = isValid ? '' : errorMessages.email.invalid;
                    break;
                case 'password':
                    isValid = patterns.password.test(value);
                    message = isValid ? '' : errorMessages.password.invalid;
                    break;
                case 'confirm_password':
                    isValid = value === compareValue;
                    message = isValid ? '' : errorMessages.confirm_password.invalid;
                    break;
                case 'terms':
                    isValid = value === true;
                    message = isValid ? '' : errorMessages.terms.required;
                    break;
            }

            // Update UI
            if (!isValid && value) {
                input.classList.add('border-red-500');
                errorElement.textContent = message;
                errorElement.classList.remove('hidden');
            } else if (isValid && value) {
                input.classList.add('border-green-500');
            }

            return isValid;
        }

        // Validate field on blur
        function validateOnBlur(field) {
            const input = document.getElementById(field);
            const value = field === 'terms' ? input.checked : input.value.trim();
            
            if (field === 'confirm_password') {
                const password = document.getElementById('password').value;
                return validateField(field, value, password);
            }
            return validateField(field, value);
        }

        // Validate entire form
        function validateForm() {
            let isValid = true;
            const username = document.getElementById('user_name').value.trim();
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            const termsChecked = document.getElementById('terms').checked;

            // Validate all fields
            if (!username) {
                showError('user_name', errorMessages.user_name.required);
                isValid = false;
            } else if (!patterns.username.test(username)) {
                showError('user_name', errorMessages.user_name.invalid);
                isValid = false;
            }

            if (!email) {
                showError('email', errorMessages.email.required);
                isValid = false;
            } else if (!patterns.email.test(email)) {
                showError('email', errorMessages.email.invalid);
                isValid = false;
            }

            if (!password) {
                showError('password', errorMessages.password.required);
                isValid = false;
            } else if (!patterns.password.test(password)) {
                showError('password', errorMessages.password.invalid);
                isValid = false;
            }

            if (!confirmPassword) {
                showError('confirm_password', errorMessages.confirm_password.required);
                isValid = false;
            } else if (password !== confirmPassword) {
                showError('confirm_password', errorMessages.confirm_password.invalid);
                isValid = false;
            }

            if (!termsChecked) {
                showError('terms', errorMessages.terms.required);
                isValid = false;
            }

            return isValid;
        }

        // Show error message
        function showError(field, message) {
            const input = document.getElementById(field);
            const errorElement = document.getElementById(`${field}_error`);
            
            input.classList.add('border-red-500');
            errorElement.textContent = message;
            errorElement.classList.remove('hidden');
            
            // Scroll to the first error
            if (!document.querySelector('.border-red-500:first-of-type')) {
                input.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }

        // Form submission
        document.getElementById('create-account-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (validateForm()) {
                // Get form values
                const data = {
                    user_name: document.getElementById('user_name').value.trim(),
                    email: document.getElementById('email').value.trim(),
                    password: document.getElementById('password').value,
                    confirm_password: document.getElementById('confirm_password').value
                };
                
                console.log('Form data:', data);
                createShipper(data);
                
                
            }
        });

        // Add blur event listeners for validation
        document.addEventListener('DOMContentLoaded', function() {
            const fields = ['user_name', 'email', 'password','confirm_password'];
            fields.forEach(field => {
                document.getElementById(field).addEventListener('blur', () => validateOnBlur(field));
            });
        });
        
        // Moved to the top of the script
    </script>
  </body>
</html>
