<div>
    <div wire:init='load' class="table-responsive">
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Type</th>
                    <th>Cron Exp</th>
                    <th>Timezone</th>
                    <th>Ping URL</th>
                    <th>Last Start</th>
                    <th>Last Finish</th>
                    <th>Last Failed</th>
                    <th>Last Skipped</th>
                    <th>Last Ping</th>
                    <th>Menu</th>
                </tr>
            </thead>
            <tbody>
                @forelse($datas as $log)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $log->name }}</td>
                    <td>{{ $log->type }}</td>
                    <td>{{ $log->cron_expression }}</td>
                    <td>{{ $log->timezone }}</td>
                    <td>{{ $log->ping_url }}</td>
                    <td>{{ $log->last_started_at }}</td>
                    <td>{{ $log->last_finished_at }}</td>
                    <td>{{ $log->last_failed_at }}</td>
                    <td>{{ $log->last_skipped_at }}</td>
                    <td>{{ $log->last_pinged_at }}</td>
                    <td><button type="button" class="btn btn-sm btn-primary">Run</button></td>
                </tr>
                @empty
                <tr>
                    <td colspan="11" class="text-center">Tidak ada data</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        @if(!empty($datas))
        <div class="d-flex flex-row">
            <div class="mx-auto">
                {{ $datas->links() }}
            </div>
        </div>
        @endif
    </div>
</div>
