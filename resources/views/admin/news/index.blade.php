<x-admin-layout>
    <div class="sm:flex sm:items-center   sm:-ml-4 sm:-mr-4" style="">
        <div class="sm:flex-auto">
            <h1 class="text-xl font-semibold text-gray-900">{{ __('News') }}</h1>
            <p class="mt-2 text-sm text-gray-700">{{ __('A list of all the news.') }}</p>
        </div>
    </div>

    <div class="sm:-ml-4 sm:-mr-4">



        <form method="GET" action="/admin/news" accept-charset="UTF-8">
            @csrf
            <div class="flex justify-between">

                <div class="flex items-center">
                    <div class="flex">
                        <div class="w-full py-4 max-w-xs mr-2 flex-shrink-0">
                            <label for="search" class="sr-only">{{ __('Search') }}</label>
                            <input type="text" name="search" id="search" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" value="{{ $query }}">
                        </div>

                        <button type="submit" class="inline-flex flex-shrink-0 self-center items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 text-sm">{{ __('Search News') }}</button>
                    </div>
                </div>
                <div>
                    <a href="{{ route('admin.news.create') }}" class="mt-3 inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 text-sm ">{{ __('Create') }}</a>
                </div>

            </div>
        </form>

    </div>
    <div class="px-4 sm:px-4 lg:px-4">
        <div class="mt-8 flex flex-col">
            <div class="-my-2 -mx-4 sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle">
                    <div class="shadow-sm ring-1 ring-black ring-opacity-5">
                        <table class="min-w-full border-separate" style="border-spacing: 0">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="w-24 sticky top-16 z-10 border-b border-gray-300 bg-gray-50 bg-opacity-75 py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 backdrop-blur backdrop-filter sm:pl-6 lg:pl-8">{{ __('Name') }}</th>
                                    <th scope="col" class="sticky top-16  z-10 hidden border-b border-gray-300 bg-gray-50 bg-opacity-75 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur backdrop-filter sm:table-cell">{{ __('Created at') }}</th>
                                    <th scope="col" class="sticky top-16  z-10 hidden border-b border-gray-300 bg-gray-50 bg-opacity-75 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur backdrop-filter sm:table-cell">{{ __('By') }}</th>

                                    <th scope="col" class="sticky top-16  z-10 border-b border-gray-300 bg-gray-50 bg-opacity-75 py-3.5 pr-4 pl-3 backdrop-blur backdrop-filter sm:pr-6 lg:pr-8">
                                        <span class="sr-only">{{ __('Update') }}</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                @foreach($news as $new)
                                <tr class="group hover:bg-indigo-600">
                                    <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm text-gray-500  group-hover:text-white hidden sm:table-cell">{{ $new->title}}</td>
                                    <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm text-gray-500  group-hover:text-white hidden sm:table-cell">{{ $new->create_time}}</td>
                                    <td class="relative whitespace-nowrap border-b border-gray-200 py-4 pr-4 pl-3 text-sm font-medium sm:pr-6 lg:pr-8  group-hover:text-white">
                                        {{ $new->user->name }}
                                    </td>
                                    <td class="relative whitespace-nowrap border-b border-gray-200 py-4 pr-4 pl-3 text-right text-sm font-medium sm:pr-6 lg:pr-8  group-hover:text-white">
                                        <a href="{{ route('admin.news.edit', $new->id) }}" class="text-indigo-600 hover:text-indigo-900 group-hover:text-white">{{ __('Edit') }}</a> |
                                        <a href="{{ route('admin.news.destroy', $new->id) }}" class="text-red-600 hover:text-indigo-900 group-hover:text-white delete-news">{{ __('Delete') }}</a>

                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    var deleteLinks = document.querySelectorAll('.delete-news');

                                    deleteLinks.forEach(function(link) {
                                        link.addEventListener('click', function(event) {
                                            event.preventDefault();

                                            var confirmation = confirm("{{ __('Are you sure you want to delete this news?') }}");

                                            if (confirmation) {
                                                window.location.href = link.getAttribute('href');
                                            }
                                        });
                                    });
                                });
                            </script>
                        </table>
                        {{ $news->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>