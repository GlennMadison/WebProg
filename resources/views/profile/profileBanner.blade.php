


<div class="d-flex align-items-center">
    <img src="https://avatars.githubusercontent.com/u/134983026?v=4" 
        class="rounded-circle " width="50" height="50">
    <div class="d-flex flex-column ms-4 ">
        <div class="font-weight-bold h5">
            {{ $object->user->name }}
            @if($object->user->role == 'doctor')
            <span class="badge bg-primary font-weight-normal">Doctor</span>
            @endif
        </div>
        <div class="text-muted">
            {{ $object->created_at->diffForHumans() }}
        </div>
    </div>
</div>