<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - StretchXL Dashboard</title>
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="./assets/css/tailwind.output.css" />
    <link rel="stylesheet" href="./assets/css/variable.css" />
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
    <script
      src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"
      defer
    ></script>
    <script src="./assets/js/init-alpine.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
      .border-red-500 {
          border-color: #f56565 !important;
      }
      .border-green-500 {
          border-color: #48bb78 !important;
      }
      .error-message {
          color: #f56565;
          font-size: 0.75rem;
          margin-top: 0.25rem;
      }
    </style>
  </head>
  <body>
    <div class="flex items-center min-h-screen p-6 bg-gray-50 dark:bg-gray-900">
      <div class="flex-1 h-full max-w-4xl mx-auto overflow-hidden bg-white rounded-lg shadow-xl dark:bg-gray-800">
        <div class="flex flex-col overflow-y-auto md:flex-row">
          <div class="h-32 md:h-auto md:w-1/2">
            <img
              aria-hidden="true"
              class="object-cover w-full h-full dark:hidden"
              src="./assets/img/login-office.jpeg"
              alt="Office"
            />
            <img
              aria-hidden="true"
              class="hidden object-cover w-full h-full dark:block"
              src="./assets/img/login-office-dark.jpeg"
              alt="Office"
            />
          </div>
          <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
            <div class="w-full">
              <h1 class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200">
                Login
              </h1>
              <form id="login-form" method="post" class="space-y-6">
                <div>
                  <label class="block text-sm">
                    <span class="text-gray-700 dark:text-gray-400">Email</span>
                    <input
                      type="email"
                      id="email"
                      name="email"
                      class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-[#2563eb] focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                      placeholder="jane.doe@example.com"
                      oninput="validateField('email', this.value)"
                    />
                    <span id="email_error" class="text-xs text-red-600 dark:text-red-400 mt-1 hidden error-message"></span>
                  </label>
                </div>

                <div class="mt-4">
                  <label class="block text-sm">
                    <span class="text-gray-700 dark:text-gray-400">Password</span>
                    <input
                      type="password"
                      id="password"
                      name="password"
                      class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-[#2563eb] focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                      placeholder="***************"
                      oninput="validateField('password', this.value)"
                    />
                    <span id="password_error" class="text-xs text-red-600 dark:text-red-400 mt-1 hidden error-message"></span>
                  </label>
                </div>

                <button
                  type="submit"
                  class="block w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-primary-color border border-primary-color rounded-lg active:bg-primary-color hover:bg-primary-color focus:outline-none focus:shadow-outline-purple"
                >
                  Log in
                </button>
              </form>

              <hr class="my-8" />

              <p class="mt-4">
                <a
                  class="text-sm font-medium text-[#2563eb] dark:text-purple-400 hover:underline"
                  href="./forgot-password.php"
                >
                  Forgot your password?
                </a>
              </p>
              <p class="mt-1">
                <a
                  class="text-sm font-medium text-primary-color dark:text-purple-400 hover:underline"
                  href="./create-account.php"
                >
                  Create account
                </a>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script>
      // Validation patterns
      const patterns = {
          email: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
          password: /^.{6,}$/ // Minimum 6 characters
      };

      // Error messages
      const errorMessages = {
          email: {
              required: 'Email is required',
              invalid: 'Please enter a valid email address'
          },
          password: {
              required: 'Password is required',
              invalid: 'Password must be at least 6 characters'
          }
      };

      // Validate field
      function validateField(field, value) {
          const input = document.getElementById(field);
          const errorElement = document.getElementById(`${field}_error`);
          let isValid = true;
          let message = '';

          input.classList.remove('border-red-500', 'border-green-500');
          errorElement.classList.add('hidden');

          if (value === '') {
              return true; // Skip empty validation until submit
          }

          switch(field) {
              case 'email':
                  isValid = patterns.email.test(value);
                  message = isValid ? '' : errorMessages.email.invalid;
                  break;
              case 'password':
                  isValid = patterns.password.test(value);
                  message = isValid ? '' : errorMessages.password.invalid;
                  break;
          }

          if (!isValid && value) {
              input.classList.add('border-red-500');
              errorElement.textContent = message;
              errorElement.classList.remove('hidden');
          } else if (isValid && value) {
              input.classList.add('border-green-500');
          }

          return isValid;
      }

      // Validate form
      function validateForm() {
          let isValid = true;
          const email = document.getElementById('email').value.trim();
          const password = document.getElementById('password').value;

          // Reset all errors
          document.querySelectorAll('.error-message').forEach(el => {
              el.classList.add('hidden');
          });
          document.querySelectorAll('input').forEach(input => {
              input.classList.remove('border-red-500', 'border-green-500');
          });

          // Validate email
          if (!email) {
              showError('email', errorMessages.email.required);
              isValid = false;
          } else if (!patterns.email.test(email)) {
              showError('email', errorMessages.email.invalid);
              isValid = false;
          }

          // Validate password
          if (!password) {
              showError('password', errorMessages.password.required);
              isValid = false;
          } else if (!patterns.password.test(password)) {
              showError('password', errorMessages.password.invalid);
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

      // Login function
      async function loginUser(data) {
          try {
              Swal.fire({
                  title: 'Please wait...',
                  text: 'Signing in...',
                  allowOutsideClick: false,
                  didOpen: () => {
                      Swal.showLoading();
                  }
              });

              const formData = new FormData();
              formData.append('email', data.email);
              formData.append('password', data.password);
              formData.append('method', 'shipperLogin');

              const response = await fetch('helper/login.php', {
                  method: 'POST',
                  body: formData,
              });

              const result = await response.json();
              console.log('Login response:', result);

              if (result.status === "error") {
                  throw new Error(result.message || 'Login failed');
              }

              await Swal.fire({
                  title: 'Success!',
                  text: 'Logged in successfully!',
                  icon: 'success',
                  confirmButtonColor: '#D74559',
                  confirmButtonText: 'Continue'
              });

              localStorage.setItem('user', JSON.stringify(result.data));

              // Redirect to dashboard or home page
              window.location.href = 'index.php';
             

          } catch (error) {
              console.error('Login error:', error);
              Swal.fire({
                  title: 'Error!',
                  text: error.message || 'Failed to login. Please try again.',
                  icon: 'error',
                  confirmButtonColor: '#D74559',
                  confirmButtonText: 'OK'
              });
          }
      }

      // Form submission
      document.getElementById('login-form').addEventListener('submit', function(e) {
          e.preventDefault();
          
          if (validateForm()) {
              const data = {
                  email: document.getElementById('email').value.trim(),
                  password: document.getElementById('password').value
              };
              
              loginUser(data);
          }
      });

      // Add blur event listeners for validation
      document.addEventListener('DOMContentLoaded', function() {
          const fields = ['email', 'password'];
          fields.forEach(field => {
              document.getElementById(field).addEventListener('blur', function() {
                  validateField(field, this.value);
              });
          });
      });
    </script>
  </body>
</html>