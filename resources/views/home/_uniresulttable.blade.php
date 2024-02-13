
@switch($key)

    @case( $key == 'Emigrants in Swedish church records')
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm

                                                                                font-medium  sm:pl-6 lg:pl-8">
        <a class="block" href="/scerc/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&birth_parish={{ $keywords['parish'] }}&array_dob%5Byear%5D={{ $keywords['year'] }}&action=search">
            {{ __( $key ) }}
        </a>
    </td>
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm
                                                                                font-medium sm:pl-6 lg:pl-8">
        <a class="block" href="/scerc/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&birth_parish={{ $keywords['parish'] }}&array_dob%5Byear%5D={{ $keywords['year'] }}&action=search">
            {{ $value }}
        </a>
    </td>
    @break

    @case( $key == 'Immigrants in Swedish church records')
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm

                                                                                font-medium  sm:pl-6 lg:pl-8">
        <a class="block" href="/scirc/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&birth_parish={{ $keywords['parish'] }}&array_birth_date%5Byear%5D={{ $keywords['year'] }}&action=search">
            {{ __($key) }}
        </a>
    </td>
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm
                                                                                font-medium sm:pl-6 lg:pl-8">
        <a class="block" href="/scirc/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&birth_parish={{ $keywords['parish'] }}&array_birth_date%5Byear%5D={{ $keywords['year'] }}&action=search">
            {{ $value }}
        </a>
    </td>
    @break

    @case( $key == 'SCB Immigranter' || $key == 'SCB immigrants')
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm

                                                                                font-medium  sm:pl-6 lg:pl-8">
        <a class="block" href="/sisrc/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&action=search">
            {{ __($key) }}
        </a>
    </td>
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm
                                                                                font-medium sm:pl-6 lg:pl-8">
        <a class="block" href="/sisrc/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&action=search">
            {{ $value }}
        </a>
    </td>
    @break

    @case( $key == 'SCB Emigranter' || $key == 'SCB emigrants')
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm

                                                                                font-medium  sm:pl-6 lg:pl-8">
        <a class="block" href="/sesrc/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&from_parish={{ $keywords['parish'] }}&birth_year={{ $keywords['year'] }}&action=search">
            {{ __($key) }}
        </a>
    </td>
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm
                                                                                font-medium sm:pl-6 lg:pl-8">
        <a class="block" href="/sesrc/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&from_parish={{ $keywords['parish'] }}&birth_year={{ $keywords['year'] }}&action=search">
            {{ $value }}
        </a>
    </td>
    @break

    @case( $key == 'Emigrants in Norwegian church records')
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm

                                                                                font-medium  sm:pl-6 lg:pl-8">
        <a class="block" href="/nerc/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&array_birth_date%5Byear%5D={{ $keywords['year'] }}&action=search">
            {{ __($key) }}
        </a>
    </td>
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm
                                                                                font-medium sm:pl-6 lg:pl-8">
        <a class="block" href="/nerc/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&array_birth_date%5Byear%5D={{ $keywords['year'] }}&action=search">
            {{ $value }}
        </a>
    </td>
    @break



    @case( $key == 'The Åland emigrant database')
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm

                                                                                font-medium  sm:pl-6 lg:pl-8">
        <a class="block" href="/ierc/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&array_date_of_birth%5Byear%5D={{ $keywords['year'] }}&action=search">
            {{ __($key) }}
        </a>
    </td>
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm
                                                                                font-medium sm:pl-6 lg:pl-8">
        <a class="block" href="/ierc/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&array_date_of_birth%5Byear%5D={{ $keywords['year'] }}&action=search">
            {{ $value }}
        </a>
    </td>
    @break

    @case( $key == 'Immigrants in Norwegian church records')
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm

                                                                                font-medium  sm:pl-6 lg:pl-8">
        <a class="block" href="/ncirc/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&action=search">
            {{ __($key) }}
        </a>
    </td>
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm
                                                                                font-medium sm:pl-6 lg:pl-8">
        <a class="block" href="/ncirc/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&action=search">
            {{ $value }}
        </a>
    </td>
    @break
        @case( $key == 'The Danish emigrant database')
        <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm

                                                                                font-medium  sm:pl-6 lg:pl-8">
        <a class="block" href="/danishemigration/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&action=search">
            {{ __($key) }}
        </a>
        </td>
        <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm
                                                                                font-medium sm:pl-6 lg:pl-8">
        <a class="block" href="/danishemigration/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&action=search">
            {{ $value }}
        </a>
        </td>
    @break

    @case( $key == 'New Yorks Passenger lists')
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm

                                                                                font-medium  sm:pl-6 lg:pl-8">
        <a class="block" href="/nypr/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&array_birth_year%5Byear%5D={{ $keywords['year'] }}&action=search">
            {{ __($key) }}
        </a>
    </td>
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm
                                                                                font-medium sm:pl-6 lg:pl-8">
        <a class="block" href="/nypr/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&array_birth_year%5Byear%5D={{ $keywords['year'] }}&action=search">
            {{ $value }}
        </a>
    </td>
    @break

    @case( $key == 'Passenger lists for Swedish ports')
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm

                                                                                font-medium  sm:pl-6 lg:pl-8">
        <a class="block" href="/spplr/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&action=search">
            {{ __($key) }}
        </a>
    </td>
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm
                                                                                font-medium sm:pl-6 lg:pl-8">
        <a class="block" href="/spplr/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&action=search">
            {{ $value }}
        </a>
    </td>
    @break


    @case( $key == 'Swedes over Kristiania')
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm

                                                                                font-medium  sm:pl-6 lg:pl-8">
        <a class="block" href="/sevkrc/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&action=search">
            {{ __($key) }}
        </a>
    </td>
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm
                                                                                font-medium sm:pl-6 lg:pl-8">
        <a class="block" href="/sevkrc/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&action=search">
            {{ $value }}
        </a>
    </td>
    @break

    @case( $key == 'The Larsson Brothers archive')
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm

                                                                                font-medium  sm:pl-6 lg:pl-8">
        <a class="block" href="/blarc/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&home_parish={{ $keywords['parish'] }}&action=search">
            {{ __($key) }}
        </a>
    </td>
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm
                                                                                font-medium sm:pl-6 lg:pl-8">
        <a class="block" href="/blarc/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&home_parish={{ $keywords['parish'] }}&action=search">
            {{ $value }}
        </a>
    </td>
    @break

    @case( $key == 'Mormon passenger list, Scandinavia')
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm

                                                                                font-medium  sm:pl-6 lg:pl-8">
        <a class="block" href="/msprc/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&action=search">
            {{ __($key) }}
        </a>
    </td>
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm
                                                                                font-medium sm:pl-6 lg:pl-8">
        <a class="block" href="/msprc/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&action=search">
            {{ $value }}
        </a>
    </td>
    @break

    @case( $key == 'Swedish American Church Archive (SAKA)')
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm

                                                                                font-medium  sm:pl-6 lg:pl-8">
        <a class="block" href="/sacar/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&birth_parish={{ $keywords['parish'] }}&array_birth_date%5Byear%5D={{ $keywords['year'] }}&action=search">
            {{ __($key) }}
        </a>
    </td>
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm
                                                                                font-medium sm:pl-6 lg:pl-8">
        <a class="block" href="/sacar/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&birth_parish={{ $keywords['parish'] }}&array_birth_date%5Byear%5D={{ $keywords['year'] }}&action=search">
            {{ $value }}
        </a>
    </td>
    @break

    @case( $key == 'Swedish American association members')
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm

                                                                                font-medium  sm:pl-6 lg:pl-8">
        <a class="block" href="/samrc/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&birth_parish={{ $keywords['parish'] }}&array_birth_date%5Byear%5D={{ $keywords['year'] }}&action=search">
            {{ __($key) }}
        </a>
    </td>
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm
                                                                                font-medium sm:pl-6 lg:pl-8">
        <a class="block" href="/samrc/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&birth_parish={{ $keywords['parish'] }}&array_birth_date%5Byear%5D={{ $keywords['year'] }}&action=search">
            {{ $value }}
        </a>
    </td>
    @break


    @case( $key == 'Swedes in Alaska')
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm

                                                                                font-medium  sm:pl-6 lg:pl-8">
        <a class="block" href="/siarc/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&array_birth_date%5Byear%5D={{ $keywords['year'] }}&action=search">
            {{ __($key) }}
        </a>
    </td>
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm
                                                                                font-medium sm:pl-6 lg:pl-8">
        <a class="block" href="/siarc/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&array_birth_date%5Byear%5D={{ $keywords['year'] }}&action=search">
            {{ $value }}
        </a>
    </td>
    @break


    @case( $key == 'Dalslänningar born in America')
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm

                                                                                font-medium  sm:pl-6 lg:pl-8">
        <a class="block" href="/dbir/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&array_birth_date%5Byear%5D={{ $keywords['year'] }}&action=search">
            {{ __($key) }}
        </a>
    </td>
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm
                                                                                font-medium sm:pl-6 lg:pl-8">
        <a class="block" href="/dbir/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&array_birth_date%5Byear%5D={{ $keywords['year'] }}&action=search">
            {{ $value }}
        </a>
    </td>
    @break


    @case( $key == 'The Larsson Brothers American agent archive')
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm

                                                                                font-medium  sm:pl-6 lg:pl-8">
        <a class="block" href="/leprc/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&home_parish={{ $keywords['parish'] }}&action=search">
            {{ __($key) }}
        </a>
    </td>
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm
                                                                                font-medium sm:pl-6 lg:pl-8">
        <a class="block" href="/leprc/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&home_parish={{ $keywords['parish'] }}&action=search">
            {{ $value }}
        </a>
    </td>
    @break



    @case( $key == 'Newspaper notices from Värmland newspapers')
        <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm

                                                                                font-medium  sm:pl-6 lg:pl-8">
        <a class="block" href="/vnnrc/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&array_birth_year%5Byear%5D={{ $keywords['year'] }}&action=search">
            {{ __($key) }}
        </a>
        </td>
        <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm
                                                                                font-medium sm:pl-6 lg:pl-8">
        <a class="block" href="/vnnrc/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&array_birth_year%5Byear%5D={{ $keywords['year'] }}&action=search">
            {{ $value }}
        </a>
        </td>
    @break


    @case( $key == 'The John Ericsson Archive')
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm

                                                                                font-medium  sm:pl-6 lg:pl-8">
        <a class="block" href="/jear/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&action=search">
            {{ __($key) }}
        </a>
    </td>
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm
                                                                                font-medium sm:pl-6 lg:pl-8">
        <a class="block" href="/jear/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&action=search">
            {{ $value }}
        </a>
    </td>
    @break

    @case( $key == 'Life descriptions of the conscripts')
        <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm font-medium  sm:pl-6 lg:pl-8">
            <a class="block" href="/blbrc/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&array_birth_date%5Byear%5D={{ $keywords['year'] }}&date_of_birth={{ $keywords['parish'] }}&action=search">
                {{ __($key) }}
            </a>
        </td>
        <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm font-medium sm:pl-6 lg:pl-8">
            <a class="block" href="/blbrc/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&array_birth_date%5Byear%5D={{ $keywords['year'] }}&qry_place_of_birth[value]={{ $keywords['parish'] }}&qry_place_of_birth[method]={{ null }}action=search">
                {{ $value }}
            </a>
        </td>
        @break

    @case( $key == 'Obituaries from Swedish American newspapers')
        <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm

                                                                                font-medium  sm:pl-6 lg:pl-8">
            <a class="block" href="/osanr/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&array_birth_date%5Byear%5D={{ $keywords['year'] }}&from_parish={{ $keywords['parish'] }}&action=search">
                {{ __($key) }}
            </a>
        </td>
        <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm
                                                                                font-medium sm:pl-6 lg:pl-8">
            <a class="block" href="/osanr/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&array_birth_date%5Byear%5D={{ $keywords['year'] }}&date_of_birth={{ $keywords['parish'] }}&action=search">
                {{ $value }}
            </a>
        </td>
        @break


    @default

@endswitch


