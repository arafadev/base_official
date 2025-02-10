<div class="modal fade modal-notif modal-slide" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="defaultModalLabel">Notifications</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if ($notifications->count() > 0)
                    <div class="list-group list-group-flush my-n3">
                        @foreach ($notifications as $notification)
                            <div class="list-group-item bg-transparent">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <span class="fe fe-bell fe-24"></span>
                                    </div>
                                    <div class="col">
                                        <small><strong>{{ $notification->data['title_' . lang()] ?? 'Notification Title Here'}}</strong></small>
                                        <div class="my-0 text-muted small">
                                            {{ $notification->data['body_' . lang()] ?? 'Notification Body Here'  }}
                                        </div>
                                        <small class="badge badge-pill badge-light text-muted">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>      
                @else
                    <p class="text-center text-muted">No new notifications</p>
                @endif
            </div>
            <div class="modal-footer">
                @if ($notifications->count() > 0)
                    <form action="#" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-secondary btn-block">Clear All</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
