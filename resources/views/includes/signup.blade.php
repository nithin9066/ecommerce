  <!-- Main modal -->
  <div id="signup-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full"
  aria-modal="true" role="dialog">
  <div class="relative p-4 w-full max-w-md h-full md:h-auto">
      <!-- Modal content -->
      <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
          <button type="button"
              class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
              data-modal-toggle="signup-modal">
              <svg onclick="clearmsg('#success')" aria-hidden="true" class="w-5 h-5" fill="currentColor"
                  viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd"
                      d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                      clip-rule="evenodd"></path>
              </svg>
              <span class="sr-only">Close modal</span>
          </button>
          <h4 id="success" class="bg-green-500 w-full p-4 text-white tracking-wider font-semibold hidden"></h4>
          <ul id='regerror' class="text-sm bg-red-500 w-full p-2 text-white tracking-wider hidden"></ul>
          <div class="py-6 px-6 lg:px-8">
              <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">Sign Up</h3>
              <form class="space-y-6" id="signup">
                  <div class="flex gap-1">
                    <div>
                        <label for="name"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Your
                            Name</label>
                        <input type="text" name="name" id="name"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                            placeholder="eg: Krishna" required="">
                            <span class="text-red-500"></span>
                    </div>
                     <div>
                        <label for="phone"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Your
                            Phone Number</label>
                        <input type="tel" name="phone" id="phone"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                            placeholder="eg: 1234567890" required="">
                            <span class="text-red-500"></span>
                    </div>
                  </div>
                  <div>
                      <label for="email"
                          class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Your
                          email</label>
                      <input type="email" name="email" id="email"
                          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                          placeholder="name@company.com" required="">
                          <span class="text-red-500"></span>
                  </div>
                 <div class="flex gap-1">
                    <div>
                        <label for="password"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Your
                            password</label>
                        <input type="password" name="password" id="password" placeholder="••••••••"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                            required="">
                            <span class="text-red-500"></span>
                    </div>
                    <div>
                        <label for="cpassword"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Confirm
                            password</label>
                            
                        <input type="password" name="password_confirmation" id="cpassword" placeholder="••••••••"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                            required="">
                            <span class="text-red-500"></span>
                    </div>
                 </div>
                  <button type="submit"
                      class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Signup</button>
                  <div class="text-sm font-medium text-gray-500 dark:text-gray-300">
                      Existing User? 
                    <button type="button" class="text-blue-700 hover:underline dark:text-blue-500">Login</button>
                  </div>
              </form>
          </div>
      </div>
  </div>
</div>