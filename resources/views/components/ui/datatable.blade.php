@props(['headers', 'data'])

<div class="table-responsive">
    <table {{ $attributes->merge(['class' => 'table table-striped']) }}>
        <thead class="thead-dark">
            <tr>
                @foreach ($headers as $header)
                    <th>{{ $header }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            {{ $slot }}
        </tbody>
    </table>
</div>
