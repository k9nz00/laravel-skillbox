<?php $newsItem = $newsItem ?? new \App\Models\News() ?>

<div class="form-group">
    <label for="inputSlug" class="field-label">
        <span class="">
            <svg class="material-icon-size" viewBox="0 0 24 24">
                        <path d="M12.89,3L14.85,3.4L11.11,21L9.15,20.6L12.89,3M19.59,12L16,8.41V5.58L22.42,12L16,18.41V15.58L19.59,12M1.58,12L8,5.58V8.41L4.41,12L8,15.58V18.41L1.58,12Z"/>
             </svg>
            Символьный код для новости
        </span>
    </label>
    <input type="text"
           name="slug"
           class="form-control"
           id="inputSlug"
           placeholder="Slug"
           value="{{old('slug', $newsItem->slug)}}"
           >
</div>
<div class="form-group">
    <label for="inputTitle" class="field-label">
        <span class="">
            <svg class="material-icon-size" viewBox="0 0 24 24">
                <path d="M5,4V7H10.5V19H13.5V7H19V4H5Z"/>
            </svg>
            Название новости
        </span>
    </label>
    <input type="text"
           name="title"
           class="form-control"
           id="inputTitle"
           placeholder="title"
           value="{{old('title', $newsItem->title)}}"
           >
</div>
<div class="form-group">
    <label for="inputShortDescription" class="field-label">
       <span class="">
            <svg class="material-icon-size" viewBox="0 0 24 24">
                <path d="M17,7H22V17H17V19A1,1 0 0,0 18,20H20V22H17.5C16.95,22 16,21.55 16,21C16,21.55 15.05,22 14.5,22H12V20H14A1,1 0 0,0 15,19V5A1,1 0 0,0 14,4H12V2H14.5C15.05,2 16,2.45 16,3C16,2.45 16.95,2 17.5,2H20V4H18A1,1 0 0,0 17,5V7M2,7H13V9H4V15H13V17H2V7M20,15V9H17V15H20M8.5,12A1.5,1.5 0 0,0 7,10.5A1.5,1.5 0 0,0 5.5,12A1.5,1.5 0 0,0 7,13.5A1.5,1.5 0 0,0 8.5,12M13,10.89C12.39,10.33 11.44,10.38 10.88,11C10.32,11.6 10.37,12.55 11,13.11C11.55,13.63 12.43,13.63 13,13.11V10.89Z"/>
             </svg>
            Краткое описание статьи
        </span>
    </label>
    <input type="text"
           name="shortDescription"
           class="form-control"
           id="inputShortDescription"
           placeholder="inputShortDescription"
           value="{{old('shortDescription', $newsItem->shortDescription)}}"
           >
</div>
<div class="form-group">
    <label for="inputBody" class="field-label">
       <span class="">
            <svg class="material-icon-size" viewBox="0 0 24 24">
                <path d="M20,20H4A2,2 0 0,1 2,18V6A2,2 0 0,1 4,4H20A2,2 0 0,1 22,6V18A2,2 0 0,1 20,20M4,6V18H20V6H4M6,9H18V11H6V9M6,13H16V15H6V13Z"/>
             </svg>
            Текст новости
        </span>
    </label>
    <textarea
            class="form-control"
            id="inputBody"
            name="body"
            rows="10">{{old('body', $newsItem->body)}}</textarea>
</div>

<div class="form-group">
    <label class="form-check-label field-label" for="inputTags">
        <span>
            <svg class="material-icon-size" viewBox="0 0 24 24">
                <path d="M5.5,9A1.5,1.5 0 0,0 7,7.5A1.5,1.5 0 0,0 5.5,6A1.5,1.5 0 0,0 4,7.5A1.5,1.5 0 0,0 5.5,9M17.41,11.58C17.77,11.94 18,12.44 18,13C18,13.55 17.78,14.05 17.41,14.41L12.41,19.41C12.05,19.77 11.55,20 11,20C10.45,20 9.95,19.78 9.58,19.41L2.59,12.42C2.22,12.05 2,11.55 2,11V6C2,4.89 2.89,4 4,4H9C9.55,4 10.05,4.22 10.41,4.58L17.41,11.58M13.54,5.71L14.54,4.71L21.41,11.58C21.78,11.94 22,12.45 22,13C22,13.55 21.78,14.05 21.42,14.41L16.04,19.79L15.04,18.79L20.75,13L13.54,5.71Z"/>
            </svg>
            Теги связанные со новостью
        </span>

    </label>
    <input type="text"
           name="tags"
           value="{{old('tags', $newsItem->tags->pluck('name')->implode(', '))}}"
           class="form-control"
           id="inputTags"
           placeholder="tags">
</div>
