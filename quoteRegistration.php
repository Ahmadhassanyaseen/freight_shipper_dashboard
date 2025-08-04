<?php include 'config/config.php'; ?>
<?php
if(!isset($_GET['id'])){
    header("Location: login.php");
    exit();
}
$data['id'] = $_GET['id'];
$response = fetchShipperDataById($data);
?>
<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Set New Password - Windmill Dashboard</title>
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="./assets/css/tailwind.output.css" />
    <link rel="stylesheet" href="./assets/css/variable.css" />  
    <script
      src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"
      defer
    ></script>
    <script src="./assets/js/init-alpine.js"></script>
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
      .error {
        color: #e53e3e;
        font-size: 0.75rem;
        margin-top: 0.25rem;
        display: none;
      }
      .error.show {
        display: block;
      }
      .form-input.error-border {
        border-color: #e53e3e;
      }
      .form-input.success-border {
        border-color: #38a169;
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
              src="./assets/img/forget.jpg"
              alt="Office"
            />
            <img
              aria-hidden="true"
              class="hidden object-cover w-full h-full dark:block"
              src="./assets/img/forget.jpg"
              alt="Office"
            />
          </div>
          <form method="POST" id="new-password-form" class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
            <div class="w-full">
                <h1 class="mb-6 text-xl font-semibold text-gray-700 dark:text-white"><?php echo $response['name']; ?></h1>
              <h2 class="mb-6 text-xl font-semibold text-gray-700 dark:text-white">
                Please set a password for your account
              </h2>
              <div class="mb-4">
                <label class="block text-sm text-gray-700 dark:text-gray-400 mb-1" for="password">
                  New Password
                </label>
                <input
                  class="w-full px-3 py-2 text-sm border rounded-lg focus:border-primary-color focus:outline-none focus:ring-1 focus:ring-primary-color"
                  id="password"
                  name="password"
                  type="password"
                  placeholder="Enter new password"
                  required
                  minlength="8"
                />
                <div id="password-error" class="error">Password must be at least 8 characters long and include numbers and special characters</div>
              </div>
              <div class="mb-6">
                <label class="block text-sm text-gray-700 dark:text-gray-400 mb-1" for="confirm_password">
                  Confirm New Password
                </label>
                <input
                  class="w-full px-3 py-2 text-sm border rounded-lg focus:border-primary-color focus:outline-none focus:ring-1 focus:ring-primary-color"
                  id="confirm_password"
                  name="confirm_password"
                  type="password"
                  placeholder="Confirm new password"
                  required
                />
                <div id="confirm-password-error" class="error">Passwords do not match</div>
              </div>
              <button
                class="w-full px-4 py-2 text-sm font-medium text-white transition-colors duration-150 bg-primary-color border border-transparent rounded-lg hover:bg-primary-color-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-color"
                type="submit"
              >
                Set Password
              </button>
              <p class="mt-4 text-center">
                <a class="text-sm font-medium text-primary-color hover:underline" href="login.php">
                  Back to Login
                </a>
              </p>
            </div>
          </form>
        </div>
      </div>
    </div>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('new-password-form');
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('confirm_password');
        const passwordError = document.getElementById('password-error');
        const confirmPasswordError = document.getElementById('confirm-password-error');
        // Password validation pattern
        const passwordPattern = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,}$/;
        function validatePassword() {
          const isValid = passwordPattern.test(password.value);
          if (!isValid) {
            password.classList.add('error-border');
            password.classList.remove('success-border');
            passwordError.classList.add('show');
            return false;
          } else {
            password.classList.remove('error-border');
            password.classList.add('success-border');
            passwordError.classList.remove('show');
            return true;
          }
        }
        function validateConfirmPassword() {
          const passwordsMatch = password.value === confirmPassword.value;
          if (!passwordsMatch) {
            confirmPassword.classList.add('error-border');
            confirmPassword.classList.remove('success-border');
            confirmPasswordError.classList.add('show');
            return false;
          } else {
            confirmPassword.classList.remove('error-border');
            confirmPassword.classList.add('success-border');
            confirmPasswordError.classList.remove('show');
            return true;
          }
        }
        // Real-time validation
        password.addEventListener('input', validatePassword);
        confirmPassword.addEventListener('input', validateConfirmPassword);
        // Form submission
        form.addEventListener('submit', async function(e) {
          e.preventDefault();
          const isPasswordValid = validatePassword();
          const isConfirmPasswordValid = validateConfirmPassword();
          if (!isPasswordValid || !isConfirmPasswordValid) {
            return;
          }
          try {
            // Show loading state
            Swal.fire({
              title: 'Please wait...',
              text: 'Updating your password...',
              allowOutsideClick: false,
              didOpen: () => {
                Swal.showLoading();
              }
            });
            const formData = new FormData(form);
            formData.append('method', 'setPassword');
            formData.append('id', '<?php echo $response['id']; ?>');
            const response = await fetch('https://stretchxlfreight.com/logistx/index.php?entryPoint=VendorSystem', {
              method: 'POST',
              body: formData,
            });
            if (!response.ok) {
              throw new Error('Network response was not ok');
            }
            const result = await response.json();
            console.log('API Response:', result);
            if (result.status === 'success') {
              await Swal.fire({
                title: 'Success!',
                text: 'Your password has been reset successfully.',
                icon: 'success',
                confirmButtonText: 'OK'
              });
              window.location.href = 'login.php';
            } else {
              throw new Error(result.message || 'Failed to reset password');
            }
          } catch (error) {
            console.error('Error:', error);
            Swal.fire({
              title: 'Error!',
              text: error.message || 'An error occurred while resetting your password. Please try again later.',
              icon: 'error',
              confirmButtonText: 'OK'
            });
          }
        });
      });
    </script>
  </body>
</html>