@if(count($errors) > 0)
<div class="warningAfterNav">
  <ul style="list-style:none;">
    @foreach($errors->all() as $error)
     <li class="alert alert-danger">{{$error}}</li>
    @endforeach
  </ul>
</div>
@endif
@foreach(['success','danger','info','warning'] as $msg)
 @if(session()->has($msg))
  <div class="flash-message warningAfterNav">
    <p class="alert alert-{{$msg}}">{{ session()->get($msg) }}</p>
  </div>
 @endif
@endforeach
