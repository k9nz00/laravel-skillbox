@if(session()->has('messageAboutPostStatus'))
    <div class="container">
        <div class="row">
            <div class="alert alert-{{session('typeMessage')}}">
                {{session('messageAboutPostStatus')}}
            </div>
        </div>
    </div>
@endif
