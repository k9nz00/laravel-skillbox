<h3 class="comments-form-title mt-2">Написать комментарий</h3>
<form action="{{route($route, $slug)}}" method="post">
    @csrf
    <div class="form-group">
       <label for="inputBody" class="field-label">
       <span class="">
            <svg class="material-icon-size" viewBox="0 0 24 24">
                <path
                    d="M20,20H4A2,2 0 0,1 2,18V6A2,2 0 0,1 4,4H20A2,2 0 0,1 22,6V18A2,2 0 0,1 20,20M4,6V18H20V6H4M6,9H18V11H6V9M6,13H16V15H6V13Z"/>
             </svg>
            Текст комментария
        </span>
        </label>
        <textarea
            class="form-control"
            id="inputBody"
            name="body"
            rows="5"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Создать комментарий</button>
</form>
<br>
