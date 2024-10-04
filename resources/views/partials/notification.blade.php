 @forelse ($notifications as $notification)
     <div class="d-flex px-3 py-3 {{ $notification->read_at ?? 'bg-info-subtle' }}"
         style="border-bottom: 2px solid lightgrey">
         <div class="flex-grow-1">
             <div class="font-size-12 d-flex justify-content-between gap-2">
                 <div>
                     <p class="mb-1 fs-6"> {{ $notification->data['message'] }}</p>
                     <small class="mb-0"><i class="mdi mdi-clock-outline"></i> <span
                             key="t-min-ago">{{ $notification->created_at->diffForHumans() }}
                         </span></small>
                 </div>
                 <div class="dropdown">
                     <button class="btn btn-light btn-sm" type="button" id="dropdownMenuButton3"
                         data-bs-toggle="dropdown" aria-expanded="false">
                         <i class="bx bx-dots-vertical-rounded"></i>
                     </button>
                     <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                         <li><a class="dropdown-item read-notification" data-id="{{ $notification->id }}">read</a></li>
                     </ul>
                 </div>
             </div>
         </div>
     </div>
 @empty
     No Notifaiction here
 @endforelse
