

@if (session('success'))
    <div id="flashBox" class="rounded-md bg-green-50 p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <!-- Heroicon name: solid/check-circle -->
                <lord-icon
                        src="https://cdn.lordicon.com/aixyixpa.json"
                        trigger="loop"
                        colors="primary:#166534"
                        style="width:30px;height:30px">
                </lord-icon>
            </div>
            <div class="ml-3 flex items-center">

                <h3 class="text-sm font-medium text-green-800"> {{ Session::get('success')  }}</h3>

            </div>
        </div>
    </div>
@endif

@if (session('error'))
    <div class="rounded-md bg-red-50 p-4">
        <div class="flex">
            <div class="flex-shrink-0 ">
                <!-- Heroicon name: solid/x-circle -->
                <lord-icon
                        src="https://cdn.lordicon.com/rslnizbt.json"
                        trigger="loop"
                        colors="primary:#9f1239"
                        style="width:30px;height:30px">
                </lord-icon>
            </div>
            <div class="ml-3 flex items-center">
                <h3 class="text-sm font-medium text-red-800"> {{ Session::get('error')  }}</h3>

            </div>
        </div>
    </div>
@endif
