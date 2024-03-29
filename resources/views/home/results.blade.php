<x-app-layout>
    <!-- Main 3 column grid -->
    <div class="grid grid-cols-1 gap-4 items-start lg:gap-8">
        <!-- Left column -->
        <section aria-labelledby="section-1-title">
            <h2 class="text-gray-900 ">
{{--                Your search for "<strong>{{ $keywords }}</strong>" returned {{ count($records) }} results.--}}
            </h2>
            <div class="mt-8 flex flex-col">

                <div class="-my-2 -mx-4 sm:-mx-6 lg:-mx-8">

                    <div class="inline-block min-w-full py-2 align-middle">

                        <div class="shadow-sm ring-1 ring-black ring-opacity-5">

                            @if(count($records) > 0)
                            <table class="min-w-full border-separate" style="border-spacing: 0">

                                <tbody class="bg-white">
                                @foreach($records as $key => $value)
                                    @if($value > 0)

                                        <tr class="odd:bg-white even:bg-gray-100 hover:bg-indigo-700 text-gray-900 hover:text-white ">
                                          @include('home._uniresulttable')
                                        </tr>
                                    @endif
                                @endforeach

                                <!-- More people... -->
                                </tbody>
                            </table>

                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </section>

    </div>
</x-app-layout>
