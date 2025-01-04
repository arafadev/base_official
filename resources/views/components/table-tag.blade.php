<!-- resources/views/components/table-tag.blade.php -->

@props(['headers', 'items', 'actions'])

<table class="table datatables" id="dataTable-1">
    <thead>
        <tr>
            <th><input type="checkbox" id="select-all"></th>
            <th>#</th>
            @foreach ($headers as $header)
                <th>{{ $header }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @forelse ($items as $index => $item)
            <tr>
                <td> <input type="checkbox" class="select-row" value="{{ $item['id'] }}"></td>
                <td>{{ $index + 1 }}</td>
                @foreach ($item as $key => $value)
                    @if (!in_array($key, ['id', 'actions']))
                        <td>{{ $value }}</td>
                    @endif
                @endforeach
                @if (isset($actions))
                    <td>
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
