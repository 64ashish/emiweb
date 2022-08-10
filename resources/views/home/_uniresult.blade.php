@if($record->archive->id == 1)
    <tr  class="odd:bg-white even:bg-gray-100">
        <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm
                                                                    font-medium text-gray-900 sm:pl-6 lg:pl-8">
            {{ $record->first_name }} {{ $record->last_name }}
            <p class="text-indigo-700 text-xs">
                <a href="{{ route('records', $record->archive->id) }}">{{ $record->archive->name }}</a>
            </p></td>
        <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm
                                                                    text-gray-500 hidden sm:table-cell">{{ __('Birth place') }}:<br> {{ $record->birth_place}}</td>
        <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm
                                                                    text-gray-500 hidden lg:table-cell">{{ __('Last resident') }}:<br> {{ $record->last_resident }}</td>
        <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm
                                                                    text-gray-500">{{ __('Record date') }}:<br>{{ $record->traveled_on }}</td>
        <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm
                                                                    text-gray-500">
            {{ __('Destination') }}:<br> {{  $record->destination_city }}, {{ $record->destination_country }}
        </td>
        <td class="relative whitespace-nowrap border-b border-gray-200 py-4 pr-4 pl-3
                                                                     text-sm text-right font-medium sm:pr-6 lg:pr-8">
            <a href="{{ route('records.show', [$record->archive->id,$record]) }}" class="inline-flex text-indigo-700
                                               items-center px-3 py-1.5 text-indigo-700">View</a>

        </td>
    </tr>
@endif

@if($record->archive->id == 5)
    <tr  class="odd:bg-white even:bg-gray-100">
        <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm
                                                                    font-medium text-gray-900 sm:pl-6 lg:pl-8">
            {{ $record->first_name }} {{ $record->last_name }}
            <p class="text-indigo-700 text-xs">
                <a href="{{ route('records', $record->archive->id) }}">{{ $record->archive->name }}</a>
            </p></td>
        <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm
                                                                    text-gray-500 hidden sm:table-cell">{{ __('Birth place') }}:<br> {{ $record->birth_place}}</td>
        <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm
                                                                    text-gray-500 hidden lg:table-cell">{{ __('Last resident') }}:<br> {{ $record->last_resident }}</td>
        <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm
                                                                    text-gray-500">{{ __('Record date') }}:<br>{{ $record->record_date }}</td>
        <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm
                                                                    text-gray-500">
            {{ __('Destination country') }}:<br> {{ $record->destination_country }}
        </td>
        <td class="relative whitespace-nowrap border-b border-gray-200 py-4 pr-4 pl-3
                                                                     text-sm text-right font-medium sm:pr-6 lg:pr-8">
            <a href="{{ route('records.show', [$record->archive->id,$record]) }}" class="inline-flex text-indigo-700
                                               items-center px-3 py-1.5 text-indigo-700">View</a>

        </td>
    </tr>
@endif

@if($record->archive->id == 18)
    <tr  class="odd:bg-white even:bg-gray-100">
        <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm
                                                                    font-medium text-gray-900 sm:pl-6 lg:pl-8">
            {{ $record->first_name }} {{ $record->last_name }}
            <p class="text-indigo-700 text-xs">
                <a href="{{ route('records', $record->archive->id) }}">{{ $record->archive->name }}</a>
            </p></td>
        <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm
                                                                    text-gray-500 hidden sm:table-cell">{{ __('Birth place') }}:<br> {{ $record->birth_place}}</td>
        <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm
                                                                    text-gray-500 hidden lg:table-cell">{{ __('Birth date') }}:<br> {{ $record->birth_date }}</td>
        <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm
                                                                    text-gray-500">{{ __('Profession') }}:<br>{{ $record->profession }}</td>
        <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm
                                                                    text-gray-500">
            {{ __('Death place') }} :<br> {{ $record->death_place }}
        </td>
        <td class="relative whitespace-nowrap border-b border-gray-200 py-4 pr-4 pl-3
                                                                     text-sm text-right font-medium sm:pr-6 lg:pr-8">
            <a href="{{ route('records.show', [$record->archive->id,$record]) }}" class="inline-flex text-indigo-700
                                               items-center px-3 py-1.5 text-indigo-700">View</a>

        </td>
    </tr>
@endif

@if($record->archive->id == 9)
    <tr  class="odd:bg-white even:bg-gray-100">
        <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm
                                                                    font-medium text-gray-900 sm:pl-6 lg:pl-8">
            {{ $record->first_name }} {{ $record->last_name }}
            <p class="text-indigo-700 text-xs">
                <a href="{{ route('records', $record->archive->id) }}">{{ $record->archive->name }}</a>
            </p></td>
        <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm
                                                                    text-gray-500 hidden sm:table-cell">{{ __('From province') }}:<br> {{ $record->from_province}}</td>
        <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm
                                                                    text-gray-500 hidden lg:table-cell">{{ __('Birth date') }}:<br> {{ $record->birth_year }}</td>
        <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm
                                                                    text-gray-500">{{ __('Profession') }}:<br>{{ $record->profession }}</td>
        <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm
                                                                    text-gray-500">
            {{ __('Destination') }} :<br> {{ $record->destination }}
        </td>
        <td class="relative whitespace-nowrap border-b border-gray-200 py-4 pr-4 pl-3
                                                                     text-sm text-right font-medium sm:pr-6 lg:pr-8">
            <a href="{{ route('records.show', [$record->archive->id,$record]) }}" class="inline-flex text-indigo-700
                                               items-center px-3 py-1.5 text-indigo-700">View</a>

        </td>
    </tr>
@endif

@if($record->archive->id == 11)
    <tr  class="odd:bg-white even:bg-gray-100">
        <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm
                                                                    font-medium text-gray-900 sm:pl-6 lg:pl-8">
            {{ $record->first_name }} {{ $record->last_name }}
            <p class="text-indigo-700 text-xs">
                <a href="{{ route('records', $record->archive->id) }}">{{ $record->archive->name }}</a>
            </p></td>
        <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm
                                                                    text-gray-500 hidden sm:table-cell">{{ __('Home location') }}:<br> {{ $record->home_location }}</td>
        <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm
                                                                    text-gray-500 hidden lg:table-cell">{{ __('Birth date') }}:<br> {{ $record->birth_year }}</td>
        <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm
                                                                    text-gray-500">{{ __('Profession') }}:<br>{{ $record->profession }}</td>
        <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm
                                                                    text-gray-500">
            {{ __('Destination') }} :<br> {{ $record->destination }}
        </td>
        <td class="relative whitespace-nowrap border-b border-gray-200 py-4 pr-4 pl-3
                                                                     text-sm text-right font-medium sm:pr-6 lg:pr-8">
            <a href="{{ route('records.show', [$record->archive->id,$record]) }}" class="inline-flex text-indigo-700
                                               items-center px-3 py-1.5 text-indigo-700">View</a>

        </td>
    </tr>
@endif
<tr  class="odd:bg-white even:bg-gray-100">
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm
                                                                    font-medium text-gray-900 sm:pl-6 lg:pl-8">
        {{ $record->first_name }} {{ $record->last_name }}
        <p class="text-indigo-700 text-xs">
            <a href="{{ route('records', $record->archive->id) }}">{{ $record->archive->name }}</a>
        </p></td>
    <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm
                                                                    text-gray-500 hidden sm:table-cell">{{ __('Home location') }}:<br> {{ $record->home_location }}</td>
    <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm
                                                                    text-gray-500 hidden lg:table-cell">{{ __('Birth date') }}:<br> {{ $record->birth_year }}</td>
    <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm
                                                                    text-gray-500">{{ __('Profession') }}:<br>{{ $record->profession }}</td>
    <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm
                                                                    text-gray-500">
        {{ __('Destination') }} :<br> {{ $record->destination }}
    </td>
    <td class="relative whitespace-nowrap border-b border-gray-200 py-4 pr-4 pl-3
                                                                     text-sm text-right font-medium sm:pr-6 lg:pr-8">
        <a href="{{ route('records.show', [$record->archive->id,$record]) }}" class="inline-flex text-indigo-700
                                               items-center px-3 py-1.5 text-indigo-700">View</a>

    </td>
</tr>




