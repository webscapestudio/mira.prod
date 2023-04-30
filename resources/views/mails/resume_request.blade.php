

@if(isset($comment))
<div>
    <p><b>Name:</b>&nbsp; {{ $name }}</p>
    <p><b>Phone:</b>&nbsp; {{ $phone }}</p>
    <p><b>Email:</b>&nbsp; {{ $email }}</p>
    <p><b>Department:</b>&nbsp; {{ $department }}</p>
     <p><b>Comment:</b>&nbsp; {{ $comment }}</p>
</div>
@else
<div>
    <p><b>Name:</b>&nbsp; {{ $name }}</p>
    <p><b>Phone:</b>&nbsp; {{ $phone }}</p>
    <p><b>Email:</b>&nbsp; {{ $email }}</p>
    <p><b>Department:</b>&nbsp; {{ $department }}</p>
</div>
@endif