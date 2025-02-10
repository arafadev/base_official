<!-- resources/views/components/table-tag.blade.php -->

<style>
    td.text-center .icon-link {
        display: inline-flex;
        align-items: center;
        margin: 0 5px;
    }

    td.text-center {
        white-space: nowrap;
    }

    .icon-link i {
        font-size: 18px;
        margin-right: 5px;
    }
</style>
@props(['headers', 'items', 'actions'])
<div class="table-container">
    <table class="table datatables" id="dataTable-1">
        <thead>
            <tr>
                <th class="text-center"><input type="checkbox" id="select-all"></th>
                <th class="text-center">#</th>
                @foreach ($headers as $header)
                    <th class="text-center" style="color: black; font-weight: 600;">{{ $header }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse ($items as $item)
                <tr>
                    <td class="text-center"> <input type="checkbox" class="select-row" value="{{ $item['id'] }}"></td>
                    <td class="text-center">{{ $item['id'] }}</td>
                    @foreach ($item as $key => $value)
                        @if (!in_array($key, ['id', 'actions']))
                            <td class="text-center">
                                @if (Str::contains($key, 'image'))
                                    <img src="{{ $value }}" alt="Image"
                                        style="width: 50px; height: 50px; object-fit: cover;">
                                @elseif ($key === 'phone')
                                    <a href="tel:{{ $value }}">{{ $value }}</a>
                                @else
                                    {!! $value !!}
                                @endif
                            </td>
                        @endif
                    @endforeach
                    @if (isset($actions))
                        <td class="text-center">
                            @if (isset($actions['show']))
                                <x-icon-link :href="route($actions['show'], $item['id'])" class="show" icon="fe fe-eye" />
                            @endif
                            @if (isset($actions['edit']))
                                <x-icon-link :href="route($actions['edit'], $item['id'])" class="edit" icon="fe fe-edit" />
                            @endif
                            @if (isset($actions['delete']))
                                <x-icon-link href="#" class="delete" icon="fe fe-trash" :data-id="$item['id']"
                                    :data-route="route($actions['delete'], $item['id'])" />
                            @endif
                        </td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($headers) + 3 }}" class="text-center">
                        {{ __('admin.no_items_found') }}
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>
