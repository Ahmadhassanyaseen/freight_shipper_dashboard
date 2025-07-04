<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Forgot password - Windmill Dashboard</title>
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
          <form method="POST" id="forgot-password-form" class="flex  flex-col  p-6 sm:p-12 md:w-1/2">
            <div class="w-full">
              <h1
                class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200"
              >
                Forgot password
              </h1>
              <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">Email</span>
                <input
                  class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder="Enter your email"
                  name="email"
                  id="email"
                  required
                />
              </label>

              <!-- You should use a button here, as the anchor is only used for the example  -->
              <button
                class="block w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-primary-color border border-transparent rounded-lg active:bg-primary-color hover:bg-primary-color focus:outline-none focus:shadow-outline-primary-color"
                type="submit"
              >
                Recover password
              </button>
            </div>
           
<div class="flex mt-6 text-sm justify-between">
<p class="">
  <a
    class="text-sm font-medium text-[#2563eb] dark:text-purple-400 hover:underline"
    href="./login.php"
  >
    Already have an account?
  </a>
</p>
<p class="">
  <a
    class="text-sm font-medium text-primary-color dark:text-purple-400 hover:underline"
    href="./create-account.php"
  >
    Create account
  </a>
</p>
</div>
          </form>
          
        </div>
      </div>
    </div>
    <script>
      document.querySelector('#forgot-password-form').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        try {
            // Show loading state
            Swal.fire({
                title: 'Please wait...',
                text: 'Processing your request...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            const formData = new FormData(e.target);
            formData.append('method', 'forgetPassword');
           

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
                Swal.fire({
                    title: 'Success!',
                    text: 'Password reset link has been sent to your email.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
                window.location.href = 'login.php';
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: result.message || 'Failed to send reset link. Please try again.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        } catch (error) {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error!',
                text: 'An error occurred while processing your request. Please try again later.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    });
    </script>
  </body>
</html>
