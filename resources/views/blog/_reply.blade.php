<div class="card blog-body mb-2">
    <div class="card-body">
        <h5 class="card-title"><a href="#">{{ $reply->owner->name }}</a></h5>
        <h6 class="card-subtitle mb-2 text-muted">{{ $reply->created_at->diffForHumans() }}</h6>
        <p class="card-text">{{ $reply->body }}</p>
    </div>
</div>