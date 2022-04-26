<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col">
            <div class="-my-2 -mx-4 sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle">
                    <div class="shadow-sm ring-1 ring-black ring-opacity-5">
                        <table class="min-w-full border-separate" style="border-spacing: 0">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="sticky top-16 z-10 border-b border-gray-300 bg-gray-50
                                bg-opacity-75 py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900
                                backdrop-blur backdrop-filter sm:pl-6 lg:pl-8">Name</th>
                                <th scope="col" class="sticky top-16  z-10 hidden border-b border-gray-300 bg-gray-50
                                bg-opacity-75 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur
                                backdrop-filter sm:table-cell">Email</th>
                                <th scope="col" class="sticky top-16  z-10 hidden border-b border-gray-300 bg-gray-50
                                bg-opacity-75 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur
                                backdrop-filter lg:table-cell">Role</th>
                                <th scope="col" class="sticky top-16  z-10 border-b border-gray-300 bg-gray-50
                                bg-opacity-75 py-3.5 pr-4 pl-3 text-sm font-semibold text-gray-900
                                backdrop-blur backdrop-filter sm:pr-6 lg:pr-8 text-right">
                                    Action
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white">
                            @foreach($associations as $association)
                                <tr>
                                    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm
                                    font-medium text-gray-900 sm:pl-6 lg:pl-8">
                                        {{ $association->user->name }}
                                        @if($association->user->is_admin)
                                            <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800"> Super Admin </span>
                                        @endif

                                    </td>
                                    <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm
                                    text-gray-500 hidden sm:table-cell">{{ $association->user->email}}</td>
                                    <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm
                                    text-gray-500 hidden lg:table-cell">{{ $association->user->roles->pluck('name')->implode(', ') }}</td>

                                    <td class=" gap-x-5 relative whitespace-nowrap border-b border-gray-200 py-4 pr-4 pl-3
                                    text-right text-sm font-medium sm:pr-6 lg:pr-8 flex justify-end">
                                        {{--                                        {!! Form::post([]) !!}--}}

                                        {!! Form::open(['route' => ['organizations.users.approve-association', auth()->user()->organization, $association->user]], ['class' => 'inline-flex'])  !!}
                                        <span class="flex justify-end gap-x-5">
                                        {!! Form::hidden('decision','0') !!}
                                        <button type="submit" value="attach" class="inline-flex items-center px-3 py-2 border
                                                    border-transparent shadow-sm text-sm leading-4 font-medium rounded-md text-white
                                                     bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2
                                                     focus:ring-offset-2 focus:ring-red-500">
                                            <!-- Heroicon name: solid/mail -->


                                            <svg xmlns="http://www.w3.org/2000/svg"  class="-ml-0.5 mr-2 h-6 w-6"  fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Reject
                                        </button>
                                            </span>
                                        {!! Form::close() !!}


                                        {!! Form::open(['route' => ['organizations.users.approve-association', auth()->user()->organization, $association->user]], ['class' => 'inline-flex'])  !!}
                                        <span class="flex justify-end gap-x-5">
                                        {!! Form::hidden('decision','1') !!}
                                        <button type="submit" value="attach" class="inline-flex items-center px-3 py-2 border
                                                    border-transparent shadow-sm text-sm leading-4 font-medium rounded-md text-white
                                                     bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2
                                                     focus:ring-offset-2 focus:ring-emerald-500">
                                            <!-- Heroicon name: solid/mail -->


                                            <svg xmlns="http://www.w3.org/2000/svg" class="-ml-0.5 mr-2 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                  <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                                </svg>
                                            Approve
                                        </button>
                                            </span>
                                        {!! Form::close() !!}




                                    </td>

                                </tr>
                            @endforeach

                            <!-- More people... -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
