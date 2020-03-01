@if(session()->has('messageAboutPostStatus'))
    <div class="container">
        <div class="alert alert-{{session('typeMessage')}}">
            {{session('messageAboutPostStatus')}}
        </div>
    </div>
@endif