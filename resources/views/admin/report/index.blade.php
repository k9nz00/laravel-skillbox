@extends('layouts.adminMasterLayout')

@section('navBar')
    @parent
@endsection

@section('content')
    <table class="table table-hover table-dark">
        <thead>
        <tr>
            <th style="width: 80px" scope="col">Наименование отчета</th>
            <th class="text-center" scope="col">Краткое описание отчета</th>
            <th class="text-center" scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td style="width: 80px">Итого</td>
            <td>Отчет о количестве сущностей на найте</td>
            <td>
                <a href="{{route('admin.reports.total')}}" class="btn btn-outline-primary">К отчету</a>
            </td>
        </tr>
        </tbody>
    </table>
@endsection
