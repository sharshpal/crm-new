@extends('ui.layout.emails.master')

@section('title', "Rese Operatore")

@section('greetings')
    @if (! empty($greeting))
        {{ $greeting }}
    @endif
@endsection
@section('emailtitle')
    @foreach ($introLines as $line)
        <p style="font-size: 22px; line-height: 1.2; mso-line-height-alt: 26px; margin: 0;">
            <span style="font-size: 22px;">{{ $line }}</span>
        </p>
    @endforeach
@endsection
@section('emailmessage')
    <h2>{{$title}}</h2>
    <table style="width: 100%">
        <thead>
            <tr>
                <th style="border: 1px solid">{{trans('admin.user-performance.columns.id')}}</th>
                <th style="border: 1px solid">{{trans('admin.user-performance.columns.user_email')}}</th>
                <th style="border: 1px solid">{{trans('admin.user-performance.columns.user')}}</th>
                <th style="border: 1px solid">{{trans('admin.user-performance.columns.ore')}}</th>
                <th style="border: 1px solid">{{trans('admin.user-performance.columns.pezzi_singoli')}}</th>
                <th style="border: 1px solid">{{trans('admin.user-performance.columns.pezzi_dual')}}</th>
                <th style="border: 1px solid">{{trans('admin.user-performance.columns.pezzi_tot')}}</th>
                <th style="border: 1px solid">{{trans('admin.user-performance.columns.resa')}}</th>
            </tr>
        </thead>
        <tbody>

        @if(!count($rows))
            <tr>
                <td colspan="8" style="font-weight: 700; text-align: center; padding-top: 20px; padding-bottom: 0px">Nessun dato disponibile</td>
            </tr>
        @else
            @foreach($rows as $row)
                <tr>
                    <td style="border: 1px solid; text-align: center">{{ $row->id}} </td>
                    <td style="border: 1px solid; text-align: center">{{ $row->email}} </td>
                    <td style="border: 1px solid; text-align: center">{{ $row->full_name}} </td>
                    <td style="border: 1px solid; text-align: center">{{ $row->ore}} </td>
                    <td style="border: 1px solid; text-align: center">{{ $row->pezzi_singoli}}</td>
                    <td style="border: 1px solid; text-align: center">{{ $row->pezzi_dual}}</td>
                    <td style="border: 1px solid; text-align: center">{{ $row->pezzi_tot}}</td>
                    <td style="border: 1px solid; text-align: center">{{ $row->resa }}</td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
@endsection
