<form @auth id="addaddress" class="bg-white rounded-md" @endauth @guest action="/guest/payment" @endguest method="post">
    @csrf
    <label for="country" class="text-xs">Country/Region</label>
    <select required name="country" id="country" class="p-2 w-full my-2 rounded-md">
        <option selected value="IN">India</option>
    </select>
    <input required type="text" placeholder="Full Name" class="border p-2 w-full my-2 rounded-md" name="name" id="">
    <div class="flex w-full justify-between my-2">
        <input required type="tel" placeholder="Contact Number" class="border p-2 w-full mr-1 my-2 rounded-md"
            name="phone" id="">
        <input required type="email" placeholder="Email Address" class="border p-2 w-full my-2 rounded-md" name="email"
            id="">
    </div>
    <input type="text" placeholder="Address" class="border p-2 w-full my-2 rounded-md" name="address" id="">
    <input type="text" placeholder="Landmark" class="border p-2 w-full my-2 rounded-md" name="landmark" id="">
    <div class="grid lg:grid-cols-3 grid-cols-1 gap-4 mt-2">
        <input required type="text" placeholder="City" class="border p-2 rounded-md" name="city">
        <input required type="text" placeholder="State" class="border p-2 lg:mx-1 rounded-md" name="state">
        <input required type="number" placeholder="ZipCode" class="border p-2 rounded-md" name="zipcode">
    </div>
    <div class="text-end">
        <button class="w-full py-2 px-4 bg-indigo-600 text-white rounded-md my-4" id="addaddressbtn">@auth Save
            @endauth @guest Continue to Payment @endguest</button>
    </div>
</form>