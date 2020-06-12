@extends('layouts.adminMasterLayout')

@section('navBar')
    @parent
@endsection

@section('content')
    <div class="col-md-9 blog-main">
        <p>
            В сформированнои отчете будет произведен подсчет количества элементов для выбранных пунктов select'a<br> <b>(Можно
                выбрать несколько)</b>
        </p>
        <form action="{{route('admin.reports.total.generate')}}" method="POST">
            <div class="form-group">
                @csrf
                <label for="reportsItems">Выберите пункты для формирования отчет</label>
                <select
                    multiple
                    size="{{count($instances)}}"
                    class="form-control"
                    name="instances[]"
                    id="reportsItems">
                    @foreach($instances as $instanceName => $instanceLabel)
                        <option
                            value="{{$instanceName}}">
                            {{ucfirst($instanceLabel)}}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Сгенерировать отчет</button>
        </form>
    </div>


@endsection
