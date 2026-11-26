<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title mb-0">{{ trans('lavero-admin-sessions::sessions.title') }}</h5>
        <span class="badge bg-light text-dark border font-monospace">driver: {{ $driver }}</span>
    </div>
    <div class="card-body">
        @if($driver !== 'database')
            <div class="alert alert-info mb-0">{{ trans('lavero-admin-sessions::sessions.db_driver_note') }}</div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User ID</th>
                            <th>IP</th>
                            <th>User-Agent</th>
                            <th>Last Activity</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sessions as $s)
                            <tr>
                                <td class="font-monospace small">{{ substr($s->id, 0, 12) }}... @if($s->id === $currentSessionId)<span class="badge bg-success ms-1">current</span>@endif</td>
                                <td>{{ $s->user_id ?? '—' }}</td>
                                <td><code>{{ $s->ip_address }}</code></td>
                                <td class="small text-muted" style="max-width: 280px; word-break: break-all;">{{ $s->user_agent }}</td>
                                <td class="small">{{ date('Y-m-d H:i:s', $s->last_activity) }}</td>
                                <td class="text-end">
                                    @if($s->id !== $currentSessionId)
                                        <form action="{{ route('sessions.revoke') }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $s->id }}">
                                            <button type="submit" class="btn btn-xs btn-outline-danger">{{ trans('lavero-admin-sessions::sessions.revoke') }}</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
