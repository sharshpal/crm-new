@extends('ui.layout.emails.master')

@section('title', $title)

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
                <th style="border: 1px solid">{{trans('admin.dati-contratto.columns.partner')}}</th>
                <th style="border: 1px solid">{{trans('admin.user-performance.columns.pezzi_tot')}}</th>
            </tr>
        </thead>
        <tbody>

        @if(!count($rows))
            <tr>
                <td colspan="2" style="font-weight: 700; text-align: center; padding-top: 20px; padding-bottom: 0px">Nessun dato disponibile</td>
            </tr>
        @else
            @foreach($rows as $row)
                <tr>
                    <td style="border: 1px solid; text-align: center">{{ $row->partner()->first() ? $row->partner()->first()->nome : '' }} </td>
                    <td style="border: 1px solid; text-align: center">{{ $row->tot}} </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
@endsection
